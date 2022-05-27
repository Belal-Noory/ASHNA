<?php
session_start();
require "../../init.php";

$banks = new Banks();
$loged_user = json_decode($_SESSION["bussiness_user"]);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Add new bank
    if(isset($_POST["addchartofaccount"]))
    {
        $account_catagory = 3;
        $account_name = helper::test_input($_POST["account_name"]);
        $account_number = helper::test_input($_POST["account_number"]);
        $initial_ammount = helper::test_input($_POST["initial_ammount"]);
        $account_type = helper::test_input($_POST["account_type"]);
        $currency_id = helper::test_input($_POST["currency_id"]);
        $reg_date = time();
        $company_id = $loged_user->company_id;
        $createby = $loged_user->customer_id;
        $approve = 1;
        $note = helper::test_input($_POST["note"]);
        $account_kind = "Bank";

        // Call add function
        $res = $banks->addBank([$account_catagory,$account_name,$account_number,$initial_ammount,$account_type,$currency_id,$reg_date,$company_id,$createby,$approve,$note,$account_kind]);
        echo $res;
    }

    // Add New Saif
    if(isset($_POST["addnewsaif"]))
    {
        $account_catagory = 3;
        $account_name = helper::test_input($_POST["account_name"]);
        $currency_id = helper::test_input($_POST["currency_id"]);
        $reg_date = time();
        $company_id = $loged_user->company_id;
        $createby = $loged_user->customer_id;
        $approve = 1;
        $note = helper::test_input($_POST["note"]);
        $account_kind = "Saif";
        $res = $banks->addSaif([$account_catagory,$account_name,$currency_id,$reg_date,$company_id,$createby,$approve,$note,$account_kind]);
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