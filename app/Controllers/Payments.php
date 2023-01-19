<?php
session_start();
require "../../init.php";
$loged_user = json_decode($_SESSION["bussiness_user"]);

$banks = new Banks();
$company = new Company();
$system = new SystemAdmin();
$receipt = new Payments();

$company_FT_data = $company->getCompanyActiveFT($loged_user->company_id);
$company_ft = $company_FT_data->fetch(PDO::FETCH_OBJ);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Add new Receipt
    if (isset($_POST["addreceipt"])) {
        $catagory_id = $system->getCatagoryByName("revenue");
        $catagoey = $catagory_id->fetch(PDO::FETCH_OBJ);

        $date = $_POST["date"];
        $newdate = strtotime($date);

        $account_catagory = $catagoey->account_catagory_id;
        $recievable_id = helper::test_input($_POST["reciptItemID"]);
        $payable_id = helper::test_input($_POST["customer"]);
        $currency_id = helper::test_input($_POST["currency"]);
        $remarks = helper::test_input($_POST["details"]);
        $accountdetails = helper::test_input($_POST["accountdetails"]);

        $company_financial_term_id = 0;
        if (isset($company_ft->term_id)) {
            $company_financial_term_id = $company_ft->term_id;
        }

        $reg_date = $newdate;
        $currency_rate = $_POST["rate"];
        if($currency_rate == "" || $currency_rate == " "){$currency_rate = 0;}
        $approve = 0;
        $createby = $loged_user->customer_id;
        $op_type = "Payment";
        $company_id = $loged_user->company_id;
        $amount = $_POST["amount"];
        $amount = preg_replace('/\,/',"",$amount);
        $reciptItemAmount = $_POST["reciptItemAmount"];
        $reciptItemAmount = preg_replace('/\,/',"",$reciptItemAmount);
        $recipt_details = helper::test_input($_POST["reciptItemdetails"]);

        // Get Last Leadger ID of company
        $LastLID = $company->getLeadgerID($loged_user->company_id, "Payment");
        $LastLID = "DRN-" . $LastLID;

        // Add single entery in leadger
        $receipt->addPaymentLeadger([$LastLID, $recievable_id, $payable_id, $currency_id, $remarks, $company_financial_term_id, $reg_date, $currency_rate, $approve, $createby, 0, $op_type, $company_id]);
        $tid = $banks->addTransferMoney([$recievable_id, $LastLID, $amount, "Crediet", $company_id, $accountdetails, 1, $currency_id, $currency_rate]);
        $banks->addTransferMoney([$payable_id, $LastLID, $reciptItemAmount, "Debet", $company_id, $recipt_details, 1, $currency_id, $currency_rate]);

        // get currency details
        $cdetails_data = $company->GetCurrencyDetails($currency_id);
        $cdetails = $cdetails_data->fetch(PDO::FETCH_OBJ);

        $ret = array('date' => $date, 'lid' => $LastLID, 'tid' => $tid, $tid, 'currency' => $cdetails->currency, 'amount' => $amount, 'details' => $remarks, 'pby' => $loged_user->fname . ' ' . $loged_user->lname);
        echo json_encode($ret);
    }

    // get new receipts using ajax
    if (isset($_POST["newPayments"])) {
        $company_financial_term_id = 0;
        if (isset($company_ft->term_id)) {
            $company_financial_term_id = $company_ft->term_id;
        }

        $receipts_data = $receipt->getPaymentLeadger($loged_user->company_id, $company_financial_term_id);
        $receipts = $receipts_data->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($receipts);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Get Currency Details
    if (isset($_GET["getCurrency"])) {
        $company = new Company();
        $data = $company->GetCompanyCurrency($loged_user->company_id);
        $currency = $data->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($currency);
    }
}
