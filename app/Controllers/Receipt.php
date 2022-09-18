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
        $approve = 0;
        $createby = $loged_user->customer_id;
        $op_type = "Receipt";
        $company_id = $loged_user->company_id;
        $amount = $_POST["amount"];
        $reciptItemAmount = $_POST["reciptItemAmount"];
        $recipt_details = helper::test_input($_POST["reciptItemdetails"]);

        // Get Last Leadger ID of company
        $LastLID = $company->getLeadgerID($loged_user->company_id,"Receipt");
        $LastLID = "CRN-".$LastLID;

        // Add single entery in leadger
        $receipt->addReceiptLeadger([$LastLID,$recievable_id, $payable_id, $currency_id, $remarks, $company_financial_term_id, $reg_date, $currency_rate, $approve, $createby, 0, $op_type, $loged_user->company_id]);
        $tid = $banks->addTransferMoney([$payable_id, $LastLID, $amount, "Crediet", $loged_user->company_id, $accountdetails,1,$currency_id,$currency_rate]);
        $banks->addTransferMoney([$recievable_id, $LastLID, $reciptItemAmount, "Debet", $loged_user->company_id, $recipt_details,1,$currency_id,$currency_rate]);

        if ($_POST["receptItemCounter"] >= 1) {
            for ($i = 1; $i <= $_POST["receptItemCounter"]; $i++) {
                $namount = $_POST[("reciptItemAmount" . $i)];
                $banks->addTransferMoney([$_POST[("reciptItemID" . $i)], $LastLID, $namount, "Debet", $loged_user->company_id, $_POST[("reciptItemdetails" . $i)],1]);
            }
        }
        
        // get currency details
        $cdetails_data = $company->GetCurrencyDetails($currency_id);
        $cdetails = $cdetails_data->fetch(PDO::FETCH_OBJ);

        $res = array('date' => $date,'lid'=>$LastLID,'tid'=>$tid,$tid,'currency'=>$cdetails->currency,'amount'=>$amount,'details'=>$remarks,'pby'=>$loged_user->fname.' '.$loged_user->lname);
        echo json_encode($res);
    }

    // Edit Recipt
    if(isset($_POST["editreceipt"]))
    {
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
        $approve = 0;
        $createby = $loged_user->customer_id;
        $op_type = "Receipt";
        $company_id = $loged_user->company_id;
        $amount = $_POST["amount"];
        $reciptItemAmount = $_POST["reciptItemAmount"];
        $recipt_details = helper::test_input($_POST["reciptItemdetails"]);

        // Get Last Leadger ID of company
        $LastLID = $_POST["LID"];

        // Add single entery in leadger
        $receipt->updatedReceiptLeadger([$recievable_id, $payable_id, $currency_id, $remarks, $reg_date, $currency_rate, $createby,$LastLID]);
        $tid = $banks->updateTransferMoney([$payable_id, $amount,$currency_id,$currency_rate, $LastLID,"Crediet"]);
        $banks->updateTransferMoney([$recievable_id, $reciptItemAmount,$currency_id,$currency_rate, $LastLID, "Debet"]);
        
        // get currency details
        $cdetails_data = $company->GetCurrencyDetails($currency_id);
        $cdetails = $cdetails_data->fetch(PDO::FETCH_OBJ);

        $res = array('date' => $date,'lid'=>$LastLID,'tid'=>$tid,$tid,'currency'=>$cdetails->currency,'amount'=>$amount,'details'=>$remarks,'pby'=>$loged_user->fname.' '.$loged_user->lname);
        echo json_encode($res);
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
