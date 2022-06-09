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
        $currency = $_POST["currency"];

        $company_financial_term_id = 0;
        if (isset($company_ft->term_id)) {
            $company_financial_term_id = $company_ft->term_id;
        }

        // Add leadger here
        $LID = $document->addDocumentLeadger([$details, $currency, $company_financial_term_id, $newdate, 1, $loged_user->user_id, 0, "Document", $loged_user->company_id]);

        $account = helper::test_input($_POST["account"]);
        $subaccount = helper::test_input($_POST["subaccount"]);
        $accdetails = helper::test_input($_POST["accdetails"]);
        $debetamount = helper::test_input($_POST["debetamount"]);
        $creditamount = helper::test_input($_POST["creditamount"]);

        $amount = 0;
        $op_type = "";
        if ($debetamount == 0) {
            $amount = $creditamount;
            $op_type = "Crediet";
        } else {
            $amount = $debetamount;
            $op_type = "Debet";
        }
        // Add money 
        $document->addDocumentMoney([$subaccount, $LID, $amount, $op_type, $loged_user->company_id, $accdetails]);

        $rowCount = $_POST["rowCount"];
        if ($rowCount > 1) {
            for ($i = 1; $i < $rowCount; $i++) {
                $account_temp = helper::test_input($_POST[("account" . $i)]);
                $subaccount_temp = helper::test_input($_POST[("subaccount" . $i)]);
                $accdetails_temp = helper::test_input($_POST[("accdetails" . $i)]);
                $debetamount_temp = helper::test_input($_POST[("debetamount" . $i)]);
                $creditamount_temp = helper::test_input($_POST[("creditamount" . $i)]);

                $amount_temp = 0;
                $op_type_temp = "";
                if ($debetamount_temp == 0) {
                    $amount_temp = $creditamount_temp;
                    $op_type_temp = "Crediet";
                } else {
                    $amount_temp = $debetamount_temp;
                    $op_type_temp = "Debet";
                }
                // Add money 
                $document->addDocumentMoney([$subaccount_temp, $LID, $amount_temp, $op_type_temp, $loged_user->company_id, $accdetails_temp]);
            }
        }

        echo $LID;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
}
