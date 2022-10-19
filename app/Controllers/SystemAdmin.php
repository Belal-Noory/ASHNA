<?php
session_start();
require "../../init.php";
if (isset($_SESSION["bussiness_user"])) {
    $loged_user = json_decode($_SESSION["bussiness_user"]);
}

$company = new Company();

$company_FT_data = $company->getCompanyActiveFT($loged_user->company_id);
$company_ft = $company_FT_data->fetch();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sysAdmin = new SystemAdmin();
    // Login
    if (isset($_POST["login"])) {
        $email = helper::test_input($_POST["email"]);
        $pass = helper::test_input($_POST["pass"]);
        if (!empty($email) && !empty($pass)) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header("location: ../../admin/index.php?invalidEmail=true");
            } else {
                //login here

                $res = $sysAdmin->login([$email, $pass]);
                if ($res->rowCount() > 0) {
                    $admin_data_array = $res->fetchAll(PDO::FETCH_OBJ);
                    $admin_data = array();
                    foreach ($admin_data_array as $info) {
                        $admin_data['id'] = $info->id;
                        $admin_data['email'] = $info->email;
                        $admin_data['pass'] = $info->pass;
                        $admin_data['fname'] = $info->fname;
                        $admin_data['lname'] = $info->lname;
                    }

                    $_SESSION["sys_admin"] = json_encode($admin_data);
                    header("location: ../../admin/dashboard.php");
                    exit();
                } else {
                    header("location: ../../admin/index.php?notfound=true");
                }
            }
        } else {
            header("location: ../../admin/index.php?empty=true");
        }
    }

    // Logout
    if (isset($_POST["logout"])) {
        session_destroy();
        exit();
    }

    // add website message
    if (isset($_POST["addwebsitemsg"])) {
        $title = helper::test_input($_POST["title"]);
        $details = helper::test_input($_POST["details"]);
        $date = time();
        $res = $sysAdmin->addWebsiteMsg([$title, $details, $date]);
        echo $res;
    }

    // add website FAQs
    if (isset($_POST["addwebsitefaq"])) {
        $title = helper::test_input($_POST["q"]);
        $details = helper::test_input($_POST["a"]);
        $date = time();
        $res = $sysAdmin->addWebsiteFAQ([$title, $details, $date]);
        echo $res;
    }

    // approve pending transactions
    if (isset($_POST["apporveTransactions"])) {
        $LID = $_POST["LID"];
        $res = $sysAdmin->approvePendingTransactions($LID);
        if(strpos($LID,"TOU") !== false)
        {
            $res = $sysAdmin->approvePendingTransfers($LID);
        }
        $sysAdmin->approvePendingTransactionMoney($LID);
        echo $res;
    }

    // Delete leadger
    if (isset($_POST["DL"])) {
        $LID = $_POST["LID"];
        $res = $sysAdmin->deleteLeadger($LID);
        echo $res;
    }

    // Resoter leadger
    if (isset($_POST["RL"])) {
        $LID = $_POST["LID"];
        $res = $sysAdmin->restoreLeadger($LID);
        echo $res;
    }

    // get new notification
    if(isset($_POST["newNotification"])){
        $financial_term = 0;
        if (isset($company_ft["term_id"])) {
            $financial_term = $company_ft["term_id"];
        }
        $newNotifi_data = $sysAdmin->getPendingTransactionsCount($loged_user->company_id, $financial_term);
        $newNotifi = $newNotifi_data->fetchAll(PDO::FETCH_OBJ);
        echo json_encode([$newNotifi_data->rowCount(),$newNotifi]);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $sysAdmin = new SystemAdmin();
    $banks = new Banks();

    // Get Models that are not assigned to a company
    if (isset($_GET["getcompanymodels"])) {
        $companyID = $_GET["companyID"];
        $models = $sysAdmin->getCompanyModel($companyID);
        $models_data = $models->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($models_data);
    }

    // getpendingTransactions
    if (isset($_GET["pendingT"])) {
        $LID = $_GET["LID"];
        $transaction = $sysAdmin->getPendingTransaction($loged_user->company_id,$LID);
        $json = $transaction->fetchALL(PDO::FETCH_OBJ);
        echo json_encode($json);
    }

    // Get All Pending Transactions
    if (isset($_GET["pendingTs"])) {
        $financial_term = 0;
        if (isset($company_ft["term_id"])) {
            $financial_term = $company_ft["term_id"];
        }
        $transaction = $sysAdmin->getPendingTransactions($loged_user->company_id,$financial_term);
        $json = $transaction->fetchALL(PDO::FETCH_OBJ);
        echo json_encode([$transaction->rowCount(),$json]);
    }

    // Get All Bank/Saifs amount
    if (isset($_GET["banksAmount"])) {
        $acc_money_data = [];

        // get company main currency
        $mainCurrency = "";
        $mainCurrencyID  = 0;
        $allcurrency_data = $company->GetCompanyCurrency($loged_user->company_id);
        $allcurrency = $allcurrency_data->fetchAll(PDO::FETCH_OBJ);
        foreach ($allcurrency as $crn) {
            if($crn->mainCurrency == 1)
            {
                $mainCurrency = $crn->currency;
                $mainCurrencyID = $crn->company_currency_id;
                break;
            }
        }

        $financial_term = 0;
        if (isset($company_ft["term_id"])) {
            $financial_term = $company_ft["term_id"];
        }

        // get banks amount
        $all_banks_data = $banks->getBanks($loged_user->company_id);
        $all_banks = $all_banks_data->fetchALL(PDO::FETCH_OBJ);
        foreach ($all_banks as $allbanks) {
            // get bank money
            $bank_money_data = $banks->getBankSaifMoney($loged_user->company_id, $allbanks->chartofaccount_id,$financial_term);
            $bank_money = $bank_money_data->fetchAll(PDO::FETCH_OBJ);
            $btotal = 0;
            $rate = 0;
            $debit = 0;
            $credit = 0;
            foreach ($bank_money as $money) {
                // get account currency details
                $acc_currency_data = $company->GetCurrencyDetails($money->currency);
                $acc_currency = $acc_currency_data->fetch(PDO::FETCH_OBJ);
                if ($money->currency != $mainCurrencyID) {
                    $currency_exchange_data = $banks->getExchangeConversion($mainCurrency, $acc_currency->currency, $loged_user->company_id);
                    $currency_exchange = $currency_exchange_data->fetch(PDO::FETCH_OBJ);
                    if ($currency_exchange->currency_from == $mainCurrency) {
                        $rate = 1 / $currency_exchange->rate;
                    } else {
                        $rate = $currency_exchange->rate;
                    }
                    if ($money->ammount_type == "Crediet") {
                        $credit += $money->amount * $rate;
                    } else {
                        $debit += $money->amount * $rate;
                    }
                } else {
                    $rate = 1;
                    if ($money->ammount_type == "Crediet") {
                        $credit += $money->amount * $rate;
                    } else {
                        $debit += $money->amount * $rate;
                    }
                }
            }
            $btotal += round($debit - $credit);
            array_push($acc_money_data,$btotal);
        }

        // Get saifs amount
        $all_banks_data = $banks->getSaifs($loged_user->company_id);
        $all_banks = $all_banks_data->fetchALL(PDO::FETCH_OBJ);
        foreach ($all_banks as $allbanks) {
            // get bank money
            $bank_money_data = $banks->getBankSaifMoney($loged_user->company_id, $allbanks->chartofaccount_id,$financial_term);
            $bank_money = $bank_money_data->fetchAll(PDO::FETCH_OBJ);
            $btotal = 0;
            $rate = 0;
            $debit = 0;
            $credit = 0;
            foreach ($bank_money as $money) {
                // get account currency details
                $acc_currency_data = $company->GetCurrencyDetails($money->currency);
                $acc_currency = $acc_currency_data->fetch(PDO::FETCH_OBJ);
                if ($money->currency != $mainCurrencyID) {
                    $currency_exchange_data = $banks->getExchangeConversion($mainCurrency, $acc_currency->currency, $loged_user->company_id);
                    $currency_exchange = $currency_exchange_data->fetch(PDO::FETCH_OBJ);
                    if ($currency_exchange->currency_from == $mainCurrency) {
                        $rate = 1 / $currency_exchange->rate;
                    } else {
                        $rate = $currency_exchange->rate;
                    }
                    if ($money->ammount_type == "Crediet") {
                        $credit += $money->amount * $rate;
                    } else {
                        $debit += $money->amount * $rate;
                    }
                } else {
                    $rate = 1;
                    if ($money->ammount_type == "Crediet") {
                        $credit += $money->amount * $rate;
                    } else {
                        $debit += $money->amount * $rate;
                    }
                }
            }
            $btotal += round($debit - $credit);
            array_push($acc_money_data,$btotal);
        }

        echo json_encode($acc_money_data);
    }
}
