<?php
session_start();
require "../../init.php";

if (isset($_SESSION["bussiness_user"])) {
    $loged_user = json_decode($_SESSION["bussiness_user"]);
}

$banks = new Banks();
$company = new Company();
$bussiness = new Bussiness();

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
        $account_catagory = 11;
        $account_name = helper::test_input($_POST["account_name"]);
        $account_number = helper::test_input($_POST["account_number"]);
        $initial_ammount = helper::test_input($_POST["initial_ammount"]);
        $currency_id = helper::test_input($_POST["currency"]);
        $reg_date = time();
        $company_id = $loged_user->company_id;
        $createby = $loged_user->customer_id;
        $approve = 1;
        $note = helper::test_input($_POST["note"]);
        $account_kind = "Bank";

        // Call add function
        $res = $banks->addBank([$account_catagory, $account_name, $account_number, $initial_ammount, $currency_id, $reg_date, $company_id, $createby, $approve, $note, $account_kind, 1]);
        echo $res;
    }

    // Add New Saif
    if (isset($_POST["addnewsaif"])) {
        $account_catagory = 10;
        $account_name = helper::test_input($_POST["account_name"]);
        $currency_id = helper::test_input($_POST["currency"]);
        $reg_date = time();
        $company_id = $loged_user->company_id;
        $createby = $loged_user->customer_id;
        $approve = 1;
        $note = helper::test_input($_POST["note"]);
        $account_kind = "Cash Register";
        $res = $banks->addSaif([$account_catagory, $account_name, $currency_id, $reg_date, $company_id, $createby, $approve, $note, $account_kind, 1]);
        echo $res;
    }

    // Add Transfer
    if (isset($_POST["addtransfer"])) {
        $date = $_POST["date"];
        $amount = helper::test_input($_POST["amount"]);
        $amountto = helper::test_input($_POST["amountto"]);
        $details = helper::test_input($_POST["details"]);
        $rcode = helper::test_input($_POST["rcode"]);
        $rate = helper::test_input($_POST["rate"]);
        $cfrom = helper::test_input($_POST["cfrom"]);
        $cto = helper::test_input($_POST["cto"]);

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

            $namount = 0;
            if ($amountto == 0) {
                $namount = $amount;
            } else {
                $namount = $amountto;
            }

            // get currency codes
            $cfrom_id = 0;
            $cto_id = 0;
            $c_data = $company->GetCompanyCurrency($loged_user->company_id);
            $c_detail = $c_data->fetchAll(PDO::FETCH_OBJ);
            foreach ($c_detail as $cd) {
                if ($cd->currency == $cfrom) {
                    $cfrom_id = $cd->company_currency_id;
                }

                if ($cd->currency == $cto) {
                    $cto_id = $cd->company_currency_id;
                }
            }

            $res = $banks->addTransferLeadger([$bankto_id, $bankfrom_id, $cfrom_id, $details, $financial_term, time(), $rate, 0, $loged_user->user_id, 0, 'Bank Transfer', $loged_user->company_id, $rcode]);
            $banks->addTransferMoney([$bankfrom_id, $res, $amount, "Crediet", $loged_user->company_id, "Transfere to -" . $bankto_id, 1]);
            $banks->addTransferMoney([$bankto_id, $res, $namount, "Debet", $loged_user->company_id, "Transfere from -" . $bankfrom_id, 1]);
            echo "done";
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

    // Add Exchange money
    if (isset($_POST["addexchangeMoney"])) {
        $details = $_POST["details"];
        $date = $_POST["date"];
        $currencyfrom = helper::test_input($_POST["currencyfrom"]);
        $currencyto = helper::test_input($_POST["exchangecurrencyto"]);
        $amount = helper::test_input($_POST["eamount"]);
        $bankfrom = helper::test_input($_POST["bankfromfrom"]);
        $bankto = helper::test_input($_POST["banktoto"]);
        $rate = helper::test_input($_POST["rate"]);
        $term = 0;
        if (isset($company_ft["term_id"])) {
            $term = $company_ft["term_id"];
        }
        $res = $banks->addExchangeLeadger($bankto, $bankfrom, $currencyfrom, $details, $term, time(), $rate, 0, $loged_user->user_id, 0, "Bank Exchange", $loged_user->company_id, 0, $currencyto);
        $banks->addTransferMoney([$bankfrom, $res, $amount, "Credit", $loged_user->company_id, $details, 0]);
        $banks->addTransferMoney([$bankto, $res, ($amount * $rate), "Debet", $loged_user->company_id, $details, 0]);
        echo $res;
    }

    // Add Chart of account
    if (isset($_POST["addchartofaccounts"])) {
        $name = helper::test_input($_POST["name"]);
        $subAccount = $_POST["subaccount"];

        $accountCatagory_ID = $banks->addCatagory($name, $subAccount, $loged_user->company_id);
        $res = $banks->addCatagoryAccount([$accountCatagory_ID, $name, "NA", $mainCurency, time(), $loged_user->company_id, $loged_user->user_id, $name, 0, 1]);
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

    // Add opening balance
    if (isset($_POST["addbalance"])) {
        $account = $_POST["account"];
        $amoun = $_POST["bamount"];
        $am_type = $_POST["amount_type"];
        $financial_term = 0;
        if (isset($company_ft["term_id"])) {
            $financial_term = $company_ft["term_id"];
        }

        // get account currency
        $account_currency_data = $banks->getchartofaccountDetails($account);
        $account_currency = json_decode($account_currency_data);

        $cure = 0;
        $rate = 0;
        if(isset($_POST["modelcurrency"])){
            $cure = $_POST["modelcurrency"];

            // Account Currency 
            $accCurrency_data = $company->GetCompanyCurrencyDetails($loged_user->company_id, $cure);
            $accCurrency = $accCurrency_data->fetch(PDO::FETCH_OBJ);

            // get the rate of the currency
            if ($account_currency->currency !== $accCurrency->currency) {
                $currency_rate_details_data = $banks->getExchangeConversion($accCurrency->currency, $account_currency->currency, $loged_user->company_id);
                $currency_rate_details = $currency_rate_details_data->fetch(PDO::FETCH_OBJ);
                if ($currency_rate_details->currency_from == $mainCurency) {
                    $rate = 1 / $currency_rate_details->rate;
                } else {
                    $rate = $currency_rate_details->rate;
                }
            }
        };

        // get currency details
        $currency_data = json_decode($company->GetCurrencyByName($account_currency->currency, $loged_user->company_id));
        
        if($account_currency->currency !== $mainCurency && $rate == 0){
            $currency_rate_details_data = $banks->getExchangeConversion($mainCurency, $account_currency->currency, $loged_user->company_id);
            $currency_rate_details = $currency_rate_details_data->fetch(PDO::FETCH_OBJ);
            if ($currency_rate_details->currency_from == $mainCurency) {
                $rate = 1 / $currency_rate_details->rate;
            } else {
                $rate = $currency_rate_details->rate;
            }
        }

        $LCurrency = $cure;
        if($LCurrency === 0 || $LCurrency === "0"){
            $LCurrency = $currency_data->company_currency_id;
        }
        $res = $banks->addOpeningBalanceLeadger([$account, $LCurrency, 'Opening Balance', $financial_term, time(), 1, $loged_user->user_id, 0, 'Opening Balance', $loged_user->company_id]);
        $banks->addTransferMoney([$account, 12, $amoun, $am_type, $loged_user->company_id, 'Opening Balance', 0, $LCurrency, $rate]);
        
        // if more data submitted
        $count = $_POST["rowCount"];
        if ($count > 1) {
            for ($i = 1; $i <= $count; $i++) {
                if (isset($_POST[("account" . $i)])) {
                    $account_temp = $_POST[("account" . $i)];
                    $amoun_temp = $_POST[("bamount" . $i)];

                    $account_currency_data_temp = $banks->getchartofaccountDetails($account_temp);
                    $account_currency_temp = json_decode($account_currency_data_temp);

                    $cure_tmp = 0;
                    $rate_tmp = 0;
                    if(isset($_POST[("modelcurrency".$i)])){
                        $cure_tmp = $_POST[("modelcurrency".$i)];

                        // Account Currency 
                        $accCurrency_data_tmp = $company->GetCompanyCurrencyDetails($loged_user->company_id, $cure_tmp);
                        $accCurrency_tmp = $accCurrency_data_tmp->fetch(PDO::FETCH_OBJ);

                        // get the rate of the currency
                        if ($account_currency_temp->currency !== $accCurrency_tmp->currency) {
                            $currency_rate_details_data_temp = $banks->getExchangeConversion($accCurrency_tmp->currency, $account_currency_temp->currency, $loged_user->company_id);
                            $currency_rate_details_tmp = $currency_rate_details_data_temp->fetch(PDO::FETCH_OBJ);
                            if ($currency_rate_details_tmp->currency_from == $mainCurency) {
                                $rate_tmp = 1 / $currency_rate_details_tmp->rate;
                            } else {
                                $rate_tmp = $currency_rate_details_tmp->rate;
                            }
                        }
                    };
                    
                    // get currency details
                    $currency_data_temp = json_decode($company->GetCurrencyByName($account_currency_temp->currency, $loged_user->company_id));
                    
                    if($account_currency_temp->currency !== $mainCurency && $rate_tmp == 0){
                        $currency_rate_details_data_temp = $banks->getExchangeConversion($mainCurency, $account_currency_temp->currency, $loged_user->company_id);
                        $currency_rate_details_tmp = $currency_rate_details_data_temp->fetch(PDO::FETCH_OBJ);
                        if ($currency_rate_details_tmp->currency_from == $mainCurency) {
                            $rate_tmp = 1 / $currency_rate_details_tmp->rate;
                        } else {
                            $rate_tmp = $currency_rate_details_tmp->rate;
                        }
                    }

                    $LCurrency_tmp = $cure_tmp;
                    if($LCurrency_tmp === 0 || $LCurrency_tmp === "0"){
                        $LCurrency_tmp = $currency_data_temp->company_currency_id;
                    }

                    $res = $banks->addOpeningBalanceLeadger([$account_temp, $LCurrency_tmp, "Opening Balance", $financial_term, time(), 1, $loged_user->user_id, 0, "Opening Balance", $loged_user->company_id]);
                    $banks->addTransferMoney([$account_temp, $res, $amoun_temp, $am_type, $loged_user->company_id, "Opening Balance", 0, $LCurrency_tmp, $rate_tmp]);
                }
            }
        }
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

    // Get customers with their accounts
    if (isset($_GET["getcompanycustomersAccounts"])) {
        $allContacts_data = $bussiness->getCompanyCustomersWithAccounts($loged_user->company_id, $loged_user->user_id);
        $allContacts = $allContacts_data->fetchAll();
        echo json_encode($allContacts);
    }

    // get account details
    if (isset($_GET["accountDetails"])) {
        $acc = $_GET["acc"];
        $banks = new Banks();
        $result = $banks->getSystemAccount($acc);
        echo json_encode($result->fetch(PDO::FETCH_OBJ));
    }

    // get Receivable Accounts
    if (isset($_GET["getPayableAccounts"])) {
        $type = $_GET["cat"];
        $allbanks_data = $banks->getAccount($loged_user->company_id, $type);
        $allbanks = $allbanks_data->fetchAll(PDO::FETCH_OBJ);

        $conn = new Connection();
        $amount = 0;
        foreach ($allbanks as $acc) {
            $query = "SELECT * FROM account_money WHERE account_id = ? AND detials = ? AND ammount_type = ?";
            $result = $conn->Query($query, [$acc->chartofaccount_id, "Opening Balance","Crediet"]);
            $res = $result->fetchAll(PDO::FETCH_OBJ);
            foreach ($res as $fres) {
                if($fres->rate !== 0)
                {
                    $amount += $fres->amount*$fres->rate;
                }
                else{
                    $amount += $fres->amount;
                }
            }
        }

        echo round($amount);
    }
}
