<?php
session_start();
require "../../init.php";

if (isset($_SESSION["bussiness_user"])) {
    $loged_user = json_decode($_SESSION["bussiness_user"]);
}

$banks = new Banks();
$company = new Company();

$company_FT_data = $company->getCompanyActiveFT($loged_user->company_id);
$company_ft = $company_FT_data->fetch(PDO::FETCH_OBJ);

$allcurrency_data = $company->GetCompanyCurrency($loged_user->company_id);
$allcurrency = $allcurrency_data->fetchAll(PDO::FETCH_OBJ);
$mainCurrencyID = "";
foreach ($allcurrency as $currency) {
    if ($currency->mainCurrency == 1) {
        $mainCurrencyID = $currency->company_currency_id;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // update echange entries
    if (isset($_GET["updateEchnageEntries"])) {
        $chartID = $_GET["chartID"];
        $rate = $_GET["rate"];
        $res = $banks->updatedExchangeEntries($chartID, $rate);

        // add loss/profit
        $diff = $_GET["diff"];
        $company_financial_term_id = 0;
        if (isset($company_ft->term_id)) {
            $company_financial_term_id = $company_ft->term_id;
        }

        // Get Last Leadger ID of company
        $LastLID = $company->getLeadgerID($loged_user->company_id);

        if ($diff > 0) {
            // loss
            $banks->addLoseProfitLeadger([$LastLID,115, $mainCurrencyID, "Loss from Exchnage Entries",$company_financial_term_id,time(),$loged_user->user_id,"Exchange Loss",$loged_user->company_id]);
            $banks->addTransferMoney([115,$LastLID,$diff,"loss",$loged_user->company_id,"Loss from Exchnage Entries",0,$mainCurrencyID,$rate]);
        } else {
            // profit
            $banks->addLoseProfitLeadger([$LastLID,77, $mainCurrencyID, "Income from Exchnage Entries",$company_financial_term_id,time(),$loged_user->user_id,"Exchange Income",$loged_user->company_id]);
            $banks->addTransferMoney([77,$LastLID,$diff,"income",$loged_user->company_id,"Income from Exchnage Entries",0,$mainCurrencyID,$rate]);
        }
        echo $res;
    }
}
