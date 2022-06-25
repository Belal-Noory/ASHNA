<?php
session_start();
require "../../init.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Company Model object
    $company = new Company();
    $bussiness = new Bussiness();

    // banks
    $bank = new Banks();

    if (isset($_SESSION["bussiness_user"])) {
        // Logged in user info
        $user_data = json_decode($_SESSION["bussiness_user"]);
    }

    // Add Company
    if (isset($_POST["addcompany"])) {
        $cname = helper::test_input($_POST["cname"]);
        $clegalname = helper::test_input($_POST["clegalname"]);
        $ctype = helper::test_input($_POST["ctype"]);
        $liscen = helper::test_input($_POST["clicense"]);
        $cTIN = helper::test_input($_POST["cTIN"]);
        $creginum = helper::test_input($_POST["creginum"]);
        $ccountry = helper::test_input($_POST["ccountry"]);
        $cprovince = helper::test_input($_POST["cprovince"]);
        $cdistrict = helper::test_input($_POST["cdistrict"]);
        $cemail = helper::test_input($_POST["cemail"]);
        $cpostalcode = helper::test_input($_POST["cpostalcode"]);
        $cphone = helper::test_input($_POST["cphone"]);
        $cfax = helper::test_input($_POST["cfax"]);
        $cwebsite = helper::test_input($_POST["cwebsite"]);
        $caddress = helper::test_input($_POST["caddress"]);

        $maincurrency = helper::test_input($_POST["maincurrency"]);

        $res = $company->addCompany([$cname, $clegalname, $ctype, $liscen, $cTIN, $creginum, $ccountry, $cprovince, $cdistrict, $cpostalcode, $cphone, $cfax, $caddress, $cwebsite, $cemail, time()]);
        $companyID = $res;

        // Add Company main currency
        $company->addCompanyCurrency([$companyID, $maincurrency, 1]);

        // Add Multi currency
        if ($_POST["currencyCount"] > 0) {
            for ($i = 1; $i <= $_POST["currencyCount"]; $i++) {
                $company->addCompanyCurrency([$companyID, $_POST[("ccurrency" . $i)], 0]);
            }
        }

        // Add Company Contract
        $contract_end_date = new DateTime($_POST["end_contract"]);
        $company->addCompanyContract([$companyID, time(), $contract_end_date->getTimestamp()]);

        // Add default Accounts for the company
        $accounts = array("assets", "expenses", "liablity", "revenue", "capital");
        foreach ($accounts as $account) {
            $catagory_details = $company->getCatagoryByName($account);
            $catagory_details_data = $catagory_details->fetch(PDO::FETCH_OBJ);
            $bank->addCatagoryAccount([$catagory_details_data->account_catagory_id, $account, "Payable", $maincurrency, time(), $companyID, 1, $account, 0]);
            $bank->addCatagoryAccount([$catagory_details_data->account_catagory_id, $account, "Receivable", $maincurrency, time(), $companyID, 1, $account, 0]);
        }

        echo $companyID;
    }

    // Delete Company
    if(isset($_POST["deleteCompany"]))
    {
        $companyID = $_POST["companyID"];
        $company->deleteCompany($companyID);
        $company->deleteCompanyCurrency($companyID);
        $company->deleteCompanyContract($companyID);
        $bank->deleteCatagoryAccount($companyID);
        echo "done";
    }

    // Add Company modules
    if (isset($_POST["addmodel"])) {
        $modelname = helper::test_input($_POST["modelname"]);
        $companyID = helper::test_input($_POST["userID"]);

        // Add company model
        $res = $company->addCompanyModel([$companyID, $modelname]);
        echo $res;
    }

    // Add Company User modules
    if (isset($_POST["addUserDenyModel"])) {
        $modelname = helper::test_input($_POST["modelname"]);
        $cusID = helper::test_input($_POST["cusID"]);

        $res1 = $company->getCompanyUserByCustomerID($cusID);
        $res_ID = $res1->fetch(PDO::FETCH_OBJ);

        // Add company model
        $res = $company->addCompanyUserModel([$res_ID->user_id, $modelname]);

        // Block every child of the model as well.
        $all_cheldren_data = $company->getCompanyModelAllChilds($modelname);
        $all_cheldren = $all_cheldren_data->fetchAll(PDO::FETCH_OBJ);
        foreach ($all_cheldren as $child) {
            // Add company model
            $company->addCompanyUserSubModel([$res_ID->user_id, $child->id]);
        }
        echo $res;
    }

    // Add Company User Sub modules
    if (isset($_POST["addUserSubDenyModel"])) {
        $modelname = helper::test_input($_POST["modelname"]);
        $cusID = helper::test_input($_POST["cusID"]);

        $res1 = $company->getCompanyUserByCustomerID($cusID);
        $res_ID = $res1->fetch(PDO::FETCH_OBJ);

        // Add company model
        $res = $company->addCompanyUserSubModel([$res_ID->user_id, $modelname]);
        echo $res;
    }

    // Remove Company Model
    if (isset($_POST["removeCompanyModel"])) {
        $modelID = helper::test_input($_POST["modelID"]);
        $res = $company->deleteCompanyModel($modelID);
        echo $res;
    }

    // Remove Company User Model
    if (isset($_POST["removeCompanyUserModel"])) {
        $modelID = helper::test_input($_POST["modelID"]);
        $userID = $_POST["cusID"];

        $res1 = $company->getCompanyUserByCustomerID($userID);
        $res_ID = $res1->fetch(PDO::FETCH_OBJ);

        // get Model details
        $details_data = $company->getCompanyUserModel($modelID);
        $details = $details_data->fetch(PDO::FETCH_OBJ);
        // Unblock every child of the model as well.
        $all_cheldren_data = $company->getCompanyModelAllChilds($details->company_model_id);
        $all_cheldren = $all_cheldren_data->fetchAll(PDO::FETCH_OBJ);
        foreach ($all_cheldren as $child) {
            // Remove company model
            $company->deleteCompanyUserSubModelByUser($child->id, $res_ID->user_id);
        }

        $res = $company->deleteCompanyUserModel($modelID, $res_ID->user_id);
        echo $modelID;
    }

    // Remove Company User Sub Model
    if (isset($_POST["removeCompanyUserSubModel"])) {
        $ID = $_POST["ID"];
        $res = $company->deleteCompanyUserSubModel($ID);
        echo $res;
    }

    // Add company users for loging in business panel
    if (isset($_POST["addnewuser"])) {
        $fname = helper::test_input($_POST["fname"]);
        $lname = helper::test_input($_POST["lname"]);
        $username = helper::test_input($_POST["email"]);
        $password = helper::test_input($_POST["pass"]);
        $companyID = helper::test_input($_POST["company"]);

        // Add company customer first
        $customerID = $company->addCompanyCustomer([$companyID, $fname, $lname, "admin", time()], "company_id,fname,lname,person_type,added_date", "?,?,?,?,?");

        $res = $company->addCompanyUser([$companyID, $customerID, $username, $password]);
        echo $res->rowCount();
    }

    // add company user for loging
    if (isset($_POST["addcompanyLoginUser"])) {
        $cusID = $_POST["cusID"];
        $username = helper::test_input($_POST["username"]);
        $password = helper::generateRandomPass(10);
        $companyID = $user_data->company_id;
        $res = $company->addCompanyUser([$companyID, $cusID, $username, $password]);
        if ($res->rowCount() > 0) {
            echo $password;
        } else {
            echo "error";
        }
    }

    // open new fiscal year
    if (isset($_POST["addcompany_financial_terms"])) {
        $fiscal_year_start = helper::test_input($_POST["fiscal_year_start"]);
        $fiscal_year_end = helper::test_input($_POST["fiscal_year_end"]);
        $fiscal_year_title = helper::test_input($_POST["fiscal_year_title"]);

        // check current fiscal year
        $current_FY_data = $company->checkFY($user_data->company_id);
        if ($current_FY_data->rowCount() > 0) {
            // get the ID of current FY
            $current_FY = $current_FY_data->fetch(PDO::FETCH_OBJ);
            $current_FY_ID = $current_FY->term_id;

            // close the current year and add new
            $company->closeFY($user_data->company_id);

            // add new one
            $res = $company->openFY([$user_data->company_id, $fiscal_year_start, $fiscal_year_end, $fiscal_year_title, time(), 1]);
            echo $res;
        } else {
            // add new fiscal year
            $res = $company->openFY([$user_data->company_id, $fiscal_year_start, $fiscal_year_end, $fiscal_year_title, time(), 1]);
            echo $res;
        }
    }

    // Business Related Login
    // ===========================================

    // Login users for bussiness panel
    if (isset($_POST["bussinessLogin"])) {
        $username = helper::test_input($_POST["username"]);
        $passowrd = helper::test_input($_POST["password"]);

        $login = $company->login($username, $passowrd);
        if ($login->rowCount() > 0) {
            $loginData = $login->fetch(PDO::FETCH_ASSOC);
            // If company contract is expired 
            if ($loginData["disable"] == 1) {
                echo "renewContract";
            } else {
                // Add login logs
                $company->login_logs($loginData["user_id"], "login");

                // Make user online
                $res = $company->makeOnline($loginData["user_id"], 1);

                // if login is success
                $_SESSION["bussiness_user"] = json_encode($loginData);
                echo "logedin";
            }
        } else {
            echo "Notregisterd";
        }
    }

    // logout users from business panel
    if (isset($_POST["bussinessLogout"])) {
        // Logged in user info
        $user_data = json_decode($_SESSION["bussiness_user"]);
        // Add login logs
        $company->login_logs($user_data->user_id, "logout");

        // Make user online
        $company->makeOnline($user_data->user_id, 0);
        session_destroy();
    }

    // Block login on a user
    if (isset($_POST["blockLogin"])) {
        $cusID = $_POST["cusID"];
        $res = $bussiness->blockCompanyLogin($cusID);
        echo $res->rowCount();
    }

    // Unblock login on a user
    if (isset($_POST["unblockLogin"])) {
        $cusID = $_POST["cusID"];
        $res = $bussiness->unBlockCompanyLogin($cusID);
        echo $res->rowCount();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    // Company Model object
    $company = new Company();

    // Logged in user info
    $user_data = json_decode($_SESSION["bussiness_user"]);

    // Get Company models : models that are not allowed to be used by company
    if (isset($_GET["getCompanyDenyModel"])) {
        $companyID = helper::test_input($_GET["companyID"]);
        $res = $company->getCompanyDenyModel($companyID);
        $models_data = $res->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($models_data);
    }

    // Get Company Models 
    if (isset($_GET["getcompanymodels"])) {
        $cusID = $_GET["cusID"];

        $res1 = $company->getCompanyUserByCustomerID($cusID);
        $res_ID = $res1->fetch(PDO::FETCH_OBJ);

        $res = $company->getCompanyModel($res_ID->user_id, $user_data->company_id);
        $models_data = $res->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($models_data);
    }

    // Get Company Sub Models 
    if (isset($_GET["getcompanySubmodels"])) {
        $cusID = $_GET["cusID"];

        $res1 = $company->getCompanyUserByCustomerID($cusID);
        $res_ID = $res1->fetch(PDO::FETCH_OBJ);

        $res = $company->getCompanySubModel($res_ID->user_id, $user_data->company_id);
        $models_data = $res->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($models_data);
    }

    // Get Company users models : models that are not allowed to be used by company users
    if (isset($_GET["getCompanyUserDenyModel"])) {
        $cusID = helper::test_input($_GET["cusID"]);

        $res1 = $company->getCompanyUserByCustomerID($cusID);
        $res_ID = $res1->fetch(PDO::FETCH_OBJ);

        $res = $company->getCompanyUserDenyModel($res_ID->user_id);
        $models_data = $res->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($models_data);
    }

    // Get Company users models : models that are not allowed to be performed CRUID by company users
    if (isset($_GET["getCompanyUserCRUIDModel"])) {
        $cusID = helper::test_input($_GET["cusID"]);

        $res1 = $company->getCompanyUserByCustomerID($cusID);
        $res_ID = $res1->fetch(PDO::FETCH_OBJ);

        $res = $company->getCompanyUserCRUIDModel($res_ID->user_id);
        $models_data = $res->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($models_data);
    }
}
