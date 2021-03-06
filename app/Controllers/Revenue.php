<?php
session_start();
require "../../init.php";
$loged_user = json_decode($_SESSION["bussiness_user"]);

$banks = new Banks();
$company = new Company();
$system = new SystemAdmin();
$receipt = new Receipt();

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
        $payable_id = helper::test_input($_POST["rev_ID"]);
        $currency_id = helper::test_input($_POST["currency"]);
        $remarks = helper::test_input($_POST["details"]);
        $accountdetails = helper::test_input($_POST["accountdetails"]);

        $company_financial_term_id = 0;
        if (isset($company_ft->term_id)) {
            $company_financial_term_id = $company_ft->term_id;
        }

        $reg_date = $newdate;
        $currency_rate = $_POST["rate"];
        $approve = 1;
        $createby = $loged_user->customer_id;
        $op_type = "Revenue";
        $company_id = $loged_user->company_id;
        $amount = $_POST["amount"];
        $reciptItemAmount = $_POST["reciptItemAmount"];
        $recipt_details = helper::test_input($_POST["reciptItemdetails"]);


        // Add single entery in leadger
        $res = $receipt->addReceiptLeadger([$payable_id,$recievable_id, $currency_id, $remarks, $company_financial_term_id, $reg_date, $currency_rate, $approve, $createby, 0, $op_type, $loged_user->company_id]);
        $banks->addTransferMoney([$recievable_id, $res, $reciptItemAmount, "Debet", $loged_user->company_id, $accountdetails]);
        
        $res1 = $receipt->addReceiptLeadger([$recievable_id, $payable_id, $currency_id, $remarks, $company_financial_term_id, $reg_date, $currency_rate, $approve, $createby, 0, $op_type, $loged_user->company_id]);
        $banks->addTransferMoney([$payable_id, $res1, $amount, "Crediet", $loged_user->company_id, $recipt_details]);

        if ($_POST["receptItemCounter"] >= 1) {
            for ($i = 1; $i <= $_POST["receptItemCounter"]; $i++) {
                $namount = $_POST[("reciptItemAmount" . $i)];
                $res_temp = $receipt->addReceiptLeadger([$payable_id,$recievable_id, $currency_id, $remarks, $company_financial_term_id, $reg_date, $currency_rate, $approve, $createby, 0, $op_type, $loged_user->company_id]);
                $banks->addTransferMoney([$_POST[("reciptItemID" . $i)], $res_temp, $namount, "Debet", $loged_user->company_id, $_POST[("reciptItemdetails" . $i)]]);
            }
        }
        echo $res;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
}
