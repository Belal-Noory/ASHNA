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

    // Add new bank
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
        
        $company_financial_term_id = 0;
        if(isset($company_ft->term_id)){$company_financial_term_id = $company_ft->term_id;}
        
        $reg_date = $newdate;
        $currency_rate = $loged_user->company_id;
        $currency_rate = 0;
        $approve = 1;
        $createby = $loged_user->customer_id;
        $op_type = "Receipt";
        $company_id = helper::test_input($_POST["details"]);
        $amount = $_POST["amount"];
        $reciptItemAmount = $_POST["reciptItemAmount"];

        // check if account payable currency is same as account receivable
        $bank_detail = $banks->getBankByID($recievable_id);
        $receible_bank_details = $bank_detail->fetch(PDO::FETCH_OBJ);

        // Payable currrency details
        $payable_currency_data = $company->GetCompanyCurrencyDetails($loged_user->company_id,$currency_id);
        $payable_currency_details = $payable_currency_data->fetch(PDO::FETCH_OBJ);

        // Get receivable currency details
        $receivable_currency_data = $company->GetCompanyCurrencyDetails($loged_user->company_id,$receible_bank_details->currency);
        $receivable_currency_details = $receivable_currency_data->fetch(PDO::FETCH_OBJ);

        if (isset($receivable_currency_details->company_currency_id)) {
            if ($currency_id != $receivable_currency_details->company_currency_id) {
                // conversion is needed: get currency rate
                $exchange_rate_data = $banks->getExchangeConversion($payable_currency_details->company_currency_id, $receivable_currency_details->company_currency_id, $loged_user->company_id);
                $exchange_rate_details = $exchange_rate_data->fetch(PDO::FETCH_OBJ);
                if (isset($exchange_rate_details->rate)){
                $currency_rate = $exchange_rate_details->rate;
                }
            }
        }

        // Add single entery in leadger
        $res = $receipt->addReceiptLeadger([$recievable_id,$payable_id,$currency_id,$remarks,$company_financial_term_id,$reg_date,$currency_rate,$approve,$createby,0,$op_type,$loged_user->company_id]);
        $banks->addTransferMoney([$payable_id, $res, $amount, "Crediet", $loged_user->company_id]);
        $namount = $reciptItemAmount;
        if($currency_rate != 0){$namount = $namount*$currency_rate;}
        $banks->addTransferMoney([$recievable_id, $res, $namount, "Debet", $loged_user->company_id]);

        if ($_POST["receptItemCounter"] >= 1) {
            for ($i = 1; $i <= $_POST["receptItemCounter"]; $i++) {

                // check if account payable currency is same as account receivable
                $bank_detail_temp = $banks->getBankByID($_POST[("reciptItemID" . $i)]);
                $receible_bank_details_temp = $bank_detail_temp->fetch(PDO::FETCH_OBJ);

                // Get receivable currency details
                $receivable_currency_data_temp = $company->GetCompanyCurrencyDetails($loged_user->company_id, $receible_bank_details_temp->currency);
                $receivable_currency_details_temp = $receivable_currency_data_temp->fetch(PDO::FETCH_OBJ);

                if (isset($receivable_currency_details_temp->company_currency_id)) {
                    if ($currency_id != $receivable_currency_details_temp->company_currency_id) {
                        // conversion is needed: get currency rate
                        $exchange_rate_data_temp = $banks->getExchangeConversion($payable_currency_details->company_currency_id, $receivable_currency_details_temp->company_currency_id, $loged_user->company_id);
                        $exchange_rate_details_temp = $exchange_rate_data_temp->fetch(PDO::FETCH_OBJ);
                        if (isset($exchange_rate_details_temp->rate)) {
                            $currency_rate = $exchange_rate_details_temp->rate;
                        }
                    }
                }

                $namount = $_POST[("reciptItemAmount".$i)];
                if ($currency_rate != 0) {
                    $namount = $namount * $currency_rate;
                }
                $banks->addTransferMoney([$_POST[("reciptItemID" . $i)], $res, $namount, "Debet", $loged_user->company_id]);
            }
        }
        echo $res;
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
