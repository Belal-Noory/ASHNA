<?php
session_start();
require "../../init.php";
$loged_user = json_decode($_SESSION["bussiness_user"]);

$document = new Document();
$company = new Company();

$company_FT_data = $company->getCompanyActiveFT($loged_user->company_id);
$company_ft = $company_FT_data->fetch();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Add new Document
    if (isset($_POST["adddocument"])) {
        $date = $_POST["date"];
        $newdate = strtotime($date);
        $details = helper::test_input($_POST["details"]);

        $company_financial_term_id = 0;
        if (isset($company_ft->term_id)) {
            $company_financial_term_id = $company_ft->term_id;
        }

        $account = helper::test_input($_POST["account"]);
        $subaccount = helper::test_input($_POST["subaccount"]);
        $accdetails = helper::test_input($_POST["accdetails"]);
        $currency = $_POST["doc_currency"];
        $debetamount = helper::test_input($_POST["debetamount"]);
        $creditamount = helper::test_input($_POST["creditamount"]);

        $account_temp = 0;
        if ($subaccount != 0) {
            $account_temp = $subaccount;
        } else {
            $account_temp = $account;
        }

        $amount = 0;
        $op_type = "";
        $acc_recevable = 0;
        $acc_payable = 0;
        if ($debetamount == 0) {
            $amount = $creditamount;
            $op_type = "Crediet";
            $acc_payable = $account_temp;
        } else {
            $amount = $debetamount;
            $op_type = "Debet";
            $acc_recevable = $account_temp;
        }

        // Add leadger here
        $LID = $document->addDocumentLeadger([$acc_recevable, $acc_payable, $details, $currency, $company_financial_term_id, $newdate, 0, $loged_user->user_id, 0, "Document", $loged_user->company_id]);
        // Add money 
        $document->addDocumentMoney([$account_temp, $LID, $amount, $op_type, $loged_user->company_id, $accdetails,1]);

        $rowCount = $_POST["rowCount"];
        if ($rowCount > 1) {
            for ($i = 1; $i < $rowCount; $i++) {
                $account_temp = helper::test_input($_POST[("account" . $i)]);
                $subaccount_temp = helper::test_input($_POST[("subaccount" . $i)]);
                $accdetails_temp = helper::test_input($_POST[("accdetails" . $i)]);
                $debetamount_temp = helper::test_input($_POST[("debetamount" . $i)]);
                $creditamount_temp = helper::test_input($_POST[("creditamount" . $i)]);
                $currency_temp = $_POST[("doc_currency" . $i)];

                $account_temp1 = 0;
                if ($subaccount_temp != 0) {
                    $account_temp1 = $subaccount_temp;
                } else {
                    $account_temp1 = $account_temp;
                }

                $amount_temp = 0;
                $op_type_temp = "";
                $acc_recevable_temp = 0;
                $acc_payable_temp = 0;
                if ($debetamount_temp == 0) {
                    $amount_temp = $creditamount_temp;
                    $op_type_temp = "Crediet";
                    $acc_payable_temp = $account_temp1;
                } else {
                    $amount_temp = $debetamount_temp;
                    $op_type_temp = "Debet";
                    $acc_recevable_temp = $account_temp1;
                }

                // Add leadger here
                $LID_temp = $document->addDocumentLeadger([$acc_recevable_temp, $acc_payable_temp, $details, $currency_temp, $company_financial_term_id, $newdate, 0, $loged_user->user_id, 0, "Document", $loged_user->company_id]);
                // Add money 
                $document->addDocumentMoney([$account_temp1, $LID_temp, $amount_temp, $op_type_temp, $loged_user->company_id, $accdetails_temp,1]);
            }
        }

        echo $LID;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
}
