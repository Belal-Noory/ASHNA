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
        $transaction = $sysAdmin->getPendingTransaction($LID);
        $json = $transaction->fetchALL(PDO::FETCH_OBJ);
        echo json_encode($json);
    }
}
