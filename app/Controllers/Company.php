<?php
session_start();
require "../../init.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Company Model object
    $company = new Company();

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
        $fiscal_year_start = helper::test_input($_POST["fiscal_year_start"]);
        $fiscal_year_end = helper::test_input($_POST["fiscal_year_end"]);
        $fiscal_year_title = helper::test_input($_POST["fiscal_year_title"]);

        $res = $company->addCompany([$cname, $clegalname, $ctype, $liscen, $cTIN, $creginum, $ccountry, $cprovince, $cdistrict, $cpostalcode, $cphone, $cfax, $caddress, $cwebsite, $cemail, $maincurrency, $fiscal_year_start, $fiscal_year_end, $fiscal_year_title, time()]);
        $companyID = $res;

        // Add Multi currency
        if ($_POST["currencyCount"] > 0) {
            for ($i = 1; $i <= $_POST["currencyCount"]; $i++) {
                $company->addCompanyCurrency([$companyID, $_POST[("ccurrency" . $i)]]);
            }
        }

        // Add Company Contract
        $contract_end_date = new DateTime($_POST["end_contract"]);
        $company->addCompanyContract([$companyID, time(), $contract_end_date->getTimestamp()]);

        echo $companyID;
    }

    // Add Company modules
    if (isset($_POST["addmodel"])) {
        $modelname = helper::test_input($_POST["modelname"]);
        $companyID = helper::test_input($_POST["userID"]);

        // Add company model
        $res = $company->addCompanyModel([$companyID, $modelname]);
        echo $res;
    }

    // Remove Company Model
    if (isset($_POST["removeCompanyModel"])) {
        $modelID = helper::test_input($_POST["modelID"]);
        $res = $company->deleteCompanyModel($modelID);
        echo $res;
    }

    // Add company users for loging in business panel
    if (isset($_POST["addnewuser"])) {
        $fname = helper::test_input($_POST["fname"]);
        $lname = helper::test_input($_POST["lname"]);
        $username = helper::test_input($_POST["email"]);
        $password = helper::test_input($_POST["pass"]);
        $companyID = helper::test_input($_POST["company"]);

        $res = $company->addCompanyUser([$companyID, $username, $password, $fname, $lname]);
        echo $res->rowCount();
    }

    // Business Related Login
    // ===========================================

    // Login users for bussiness panel
    if(isset($_POST["bussinessLogin"]))
    {
        $username = helper::test_input($_POST["username"]);
        $passowrd = helper::test_input($_POST["password"]);

        $login = $company->login($username,$passowrd);
        $loginData = $login->fetch(PDO::FETCH_ASSOC);

        if(count($loginData) > 0)
        {
            // If company contract is expired 
            if($loginData["disable"] == 1)
            {
                echo "renewContract";
            }
            else{
                // Add login logs
                $company->login_logs($loginData["id"],"login");
                // if login is success
                $_SESSION["bussiness_user"] = json_encode($loginData);
                echo "logedin";
            }

        }
        else{
            echo "Notregisterd";
        }
    }

    // logout users from business panel
    if(isset($_POST["bussinessLogout"]))
    {
        // Logged in user info
        $user_data = json_decode($_SESSION["bussiness_user"]);
        // Add login logs
        $company->login_logs($user_data->id,"logout");
        session_destroy();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    // Company Model object
    $company = new Company();

    // Get Company models : models that are not allowed to be used by company
    if (isset($_GET["getCompanyDenyModel"])) {
        $companyID = helper::test_input($_GET["companyID"]);
        $res = $company->getCompanyDenyModel($companyID);
        $models_data = $res->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($models_data);
    }
}
