<?php
session_start();
require "../../init.php";

if (isset($_SESSION["bussiness_user"])) {
    $loged_user = json_decode($_SESSION["bussiness_user"]);
}

$banks = new Banks();
$company = new Company();

$company_FT_data = $company->getCompanyActiveFT($loged_user->company_id);
$company_ft = $company_FT_data->fetch();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // add accounts for new customer
    $company_currencies = $company->GetCompanyCurrency($loged_user->company_id);
    $company_curreny = $company_currencies->fetchAll(PDO::FETCH_OBJ);
    $mainCurency = "";
    foreach ($company_curreny as $currency) {
        if ($currency->mainCurrency == 1) {
            $mainCurency = $currency->currency;
        }
    }

    // Add new bank
    if (isset($_POST["addchartofaccount"])) {
        $account_catagory = 3;
        $account_name = helper::test_input($_POST["account_name"]);
        $account_number = helper::test_input($_POST["account_number"]);
        $initial_ammount = helper::test_input($_POST["initial_ammount"]);
        $account_type = helper::test_input($_POST["account_type"]);
        $currency_id = helper::test_input($_POST["currency"]);
        $reg_date = time();
        $company_id = $loged_user->company_id;
        $createby = $loged_user->customer_id;
        $approve = 1;
        $note = helper::test_input($_POST["note"]);
        $account_kind = "Bank";

        // Call add function
        $res = $banks->addBank([$account_catagory, $account_name, $account_number, $initial_ammount, $account_type, $currency_id, $reg_date, $company_id, $createby, $approve, $note, $account_kind]);
        echo $res;
    }

    // Add New Saif
    if (isset($_POST["addnewsaif"])) {
        $account_catagory = 3;
        $account_name = helper::test_input($_POST["account_name"]);
        $currency_id = helper::test_input($_POST["currency"]);
        $reg_date = time();
        $company_id = $loged_user->company_id;
        $createby = $loged_user->customer_id;
        $approve = 1;
        $note = helper::test_input($_POST["note"]);
        $account_kind = "Saif";
        $res = $banks->addSaif([$account_catagory, $account_name, $currency_id, $reg_date, $company_id, $createby, $approve, $note, $account_kind]);
        echo $res;
    }

    // Add Transfer
    if (isset($_POST["addtransfer"])) {
        $date = $_POST["date"];
        $amount = helper::test_input($_POST["amount"]);
        $details = helper::test_input($_POST["details"]);
        $Currency = helper::test_input($_POST["Currency"]);
        $rate = helper::test_input($_POST["rate"]);

        // From Bank and Saif
        $bank_from = $_POST["bankfrom"];
        $saif_from = $_POST["saiffrom"];

        // To Bank and Saif
        $bank_to = $_POST["bankto"];
        $saif_to = $_POST["saifto"];

        if ($bank_from == "NA" && $saif_from == "NA") {
            echo "Please select a source from which the transfer should be made";
        } else if ($bank_to == "NA" && $saif_to == "NA") {
            echo "Please select a source to which the transfer should be made";
        } else if ($bank_to != "NA" && $bank_to == $bank_from) {
            echo "Please select a different source to transfer";
        } else if ($saif_to != "NA" && $saif_to == $saif_from) {
            echo "Please select a different source to transfer";
        } else if ($Currency == "NA") {
            echo "please select currency";
        } else {
            $financial_term = 0;
            $bankfrom_id = 0;
            $bankto_id = 0;

            if ($bank_from == "NA") {
                $bankfrom_id = $saif_from;
            } else {
                $bankfrom_id = $bank_from;
            }

            if ($bank_to == "NA") {
                $bankto_id = $saif_to;
            } else {
                $bankto_id = $bank_to;
            }

            if (isset($company_ft["term_id"])) {
                $financial_term = $company_ft["term_id"];
            }

            $res = $banks->addTransferLeadger([$bankto_id, $bankfrom_id, $Currency, $details, $financial_term, time(), $rate, 1, $loged_user->user_id, 0, 'Bank Transfer', $loged_user->company_id]);
            if ($res > 0) {
                $nammount = 0;
                if ($rate > 0) {
                    $nammount = $amount * $rate;
                } else {
                    $nammount = $amount;
                }

                $banks->addTransferMoney([$bankfrom_id, $res, $amount, "Crediet", $loged_user->company_id, $details]);
                $banks->addTransferMoney([$bankto_id, $res, $nammount, "Debet", $loged_user->company_id, $details]);
                echo "done";
            } else {
                echo "Error while adding money to accounts";
            }
        }
    }

    // Add Exchange converstion
    if (isset($_POST["addExchange"])) {
        $fromC = $_POST["fromC"];
        $toC = $_POST["toC"];
        $rate = helper::test_input($_POST["rate"]);
        $res = $banks->addExchangeConversion([$fromC, $toC, $rate, time(), 1, $loged_user->user_id, $loged_user->company_id]);
        echo $res;
    }

    // Add Exchange converstion
    if (isset($_POST["addexchangeMoney"])) {
        $details = $_POST["details"];
        $date = $_POST["date"];
        $currencyfrom = helper::test_input($_POST["currencyfrom"]);
        $currencyto = helper::test_input($_POST["currencyto"]);
        $amount = helper::test_input($_POST["amount"]);
        $customer = helper::test_input($_POST["customer"]);
        $rate = helper::test_input($_POST["rate"]);
        $reciptItemID = helper::test_input($_POST["reciptItemID"]);

        $res = $banks->addExchangeMoney([$currencyfrom, $currencyto, $reciptItemID, $customer, $loged_user->company_id, ($amount * $rate), $amount, $rate, $details, time(), $loged_user->user_id]);
        echo $res;
    }

    // Add Chart of account
    if (isset($_POST["addchartofaccounts"])) {
        $name = helper::test_input($_POST["name"]);
        $subAccount = $_POST["subaccount"];
        $mainAccount = $_POST["mainaccount"];

        $accountCatagory_ID = $banks->addCatagory($name, $mainAccount, $loged_user->company_id);
        $res = $banks->addCatagoryAccount([$accountCatagory_ID, $name, "NA", $mainCurency, time(), $loged_user->company_id, $loged_user->user_id, $name, 0]);
        echo $res;
    }

    // Add bank opening balance
    if (isset($_POST["addbankopeningbalance"])) {
        $bank = $_POST["bank"];
        $amoun = $_POST["amount"];
        $details = $_POST["details"];
        $currency = $_POST["currency"];
        $financial_term = 0;
        if (isset($company_ft["term_id"])) {
            $financial_term = $company_ft["term_id"];
        }

        $res = $banks->addOpeningBalanceLeadger([$bank, $currency, $details, $financial_term, time(), 1, $loged_user->user_id, 0, "Opening Balance", $loged_user->company_id]);
        $banks->addTransferMoney([$bank, $res, $amoun, "Debet", $loged_user->company_id, $details]);
        echo $res;
    }

    // Add saif opening balance
    if (isset($_POST["addsaifopeningbalance"])) {
        $bank = $_POST["saif"];
        $amoun = $_POST["amount"];
        $details = $_POST["details"];
        $currency = $_POST["currency"];
        $financial_term = 0;
        if (isset($company_ft["term_id"])) {
            $financial_term = $company_ft["term_id"];
        }

        $res = $banks->addOpeningBalanceLeadger([$bank, $currency, $details, $financial_term, time(), 1, $loged_user->user_id, 0, "Opening Balance", $loged_user->company_id]);
        $banks->addTransferMoney([$bank, $res, $amoun, "Debet", $loged_user->company_id, $details]);
        echo $res;
    }

    // Add saif opening balance
    if (isset($_POST["addcusopeningbalance"])) {
        $customer = $_POST["customer"];
        $amoun = $_POST["amount"];
        $details = $_POST["details"];
        $currency = $_POST["currency"];
        $financial_term = 0;
        if (isset($company_ft["term_id"])) {
            $financial_term = $company_ft["term_id"];
        }
        $res = $banks->addOpeningBalanceLeadger([$customer, $currency, $details, $financial_term, time(), 1, $loged_user->user_id, 0, "Opening Balance", $loged_user->company_id]);
        $banks->addTransferMoney([$customer, $res, $amoun, "Debet", $loged_user->company_id, $details]);
        echo $res;
    }

    // clear leadger
    if (isset($_POST["clearLeadger"])) {
        $LID = $_POST["LID"];
        $res = $banks->clearLeadger($LID);
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

    // get customer account balance
    if (isset($_GET["getCustomerBalance"])) {
        $cusID = $_GET["cusID"];
        $res = $banks->getCustomerBalance($cusID);
        echo json_encode($res->fetchAll(PDO::FETCH_ASSOC));
    }

    // get account balance
    if (isset($_GET["getBalance"])) {
        $cusID = $_GET["AID"];
        $res = $banks->getCustomerBalance($cusID);
        echo json_encode($res->fetchAll(PDO::FETCH_ASSOC));
    }

    // get company banks
    if (isset($_GET["getcompanyBanks"])) {
        $allbanks_data = $banks->getBanks($loged_user->company_id);
        $allbanks = $allbanks_data->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($allbanks);
    }

    // get company Saifs
    if (isset($_GET["getcompanySafis"])) {
        $allbanks_data = $banks->getSaifs($loged_user->company_id);
        $allbanks = $allbanks_data->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($allbanks);
    }

    // get company Customers
    if (isset($_GET["getcompanyCustomers"])) {
        $allbanks_data = $banks->getCustomers($loged_user->company_id);
        $allbanks = $allbanks_data->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($allbanks);
    }

    // get company Accounts based on type
    if (isset($_GET["getcompanyAccount"])) {
        $type = $_GET["type"];
        $allbanks_data = $banks->getAccount($loged_user->company_id, $type);
        $allbanks = $allbanks_data->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($allbanks);
    }

    // get company exchange
    if (isset($_GET["getExchange"])) {
        $from = $_GET["from"];
        $to = $_GET["to"];
        $data = $banks->getExchangeConversion($from, $to, $loged_user->company_id);
        $details = $data->fetch(PDO::FETCH_OBJ);
        echo json_encode($details);
    }

    // Get Receipt leadger account money
    if (isset($_GET["getLeadgerAccounts"])) {
        $leadger_id = $_GET["leadgerID"];
        $receipt = new Receipt();
        $all_data = $receipt->getReceiptAccount($leadger_id);
        $all_details = $all_data->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($all_details);
    }

    // get Leadger debets/credits
    if (isset($_GET["getLeadgerDebetsCredits"])) {
        $cusD = $_GET["cusid"];
        $banks = new Banks();
        $all_data = $banks->getLeadgerDebets_Credits($cusD);
        echo $all_data;
    }
}
