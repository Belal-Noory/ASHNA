<?php
session_start();
require "../../init.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Company Model object
    $saraf = new Saraf();
    $bussiness = new Bussiness();
    $transfer = new Transfer();

    // banks
    $bank = new Banks();

    if (isset($_SESSION["saraf_user"])) {
        // Logged in user info
        $user_data = json_decode($_SESSION["saraf_user"]);
    }

    // Login users for bussiness panel
    if (isset($_POST["sarafLogin"])) {
        $username = helper::test_input($_POST["username"]);
        $passowrd = helper::test_input($_POST["password"]);

        $login = $saraf->login($username, $passowrd);
        if ($login->rowCount() > 0) {
            $loginData = $login->fetch(PDO::FETCH_ASSOC);
            // Make user online
            $res = $saraf->makeOnline($loginData["customer_id"], 1);

            // if login is success
            $_SESSION["saraf_user"] = json_encode($loginData);
            echo "logedin";
        } else {
            echo "Notregisterd";
        }
    }

    // logout users from business panel
    if (isset($_POST["sarafLogout"])) {
        // Make user online
        $saraf->makeOnline($user_data->customer_id, 0);
        session_destroy();
    }

    // Add new out transfer
    if (isset($_POST["addouttransfer"])) {
        $details = helper::test_input($_POST["details"]);
        $date = helper::test_input($_POST["date"]);
        $newdate = strtotime($date);
        $transfercode = helper::test_input($_POST["transfercode"]);
        $rsaraf_ID = helper::test_input($_POST["rsaraf_ID"]);
        $currency = helper::test_input($_POST["currency"]);
        $amount = helper::test_input($_POST["amount"]);
        $mycommission = helper::test_input($_POST["mycommission"]);
        $sarafcommission = helper::test_input($_POST["sarafcommission"]);

        // Daily Customer sender 
        $Daily_sender_id = 0;
        if ($_POST["addsender"] == "true") {
            $sender_phone = helper::test_input($_POST["sender_phone"]);
            $sender_fname = helper::test_input($_POST["sender_fname"]);
            $sender_lname = helper::test_input($_POST["sender_lname"]);
            $sender_Fathername = helper::test_input($_POST["sender_Fathername"]);
            $sender_nid = helper::test_input($_POST["sender_nid"]);
            $sender_details = helper::test_input($_POST["sender_details"]);
            $Daily_sender_id = $bussiness->addDailyCustomer([$sender_fname, $sender_lname, $sender_Fathername, $sender_phone, $sender_nid, $sender_details, 'Daily Customer', time(), $loged_user->user_id, 1]);
        } else {
            $daily_sender_data = $bussiness->GetDailyCustomer(helper::test_input($_POST["sender_phone"]));
            $daily_sender_details = $daily_sender_data->fetch(PDO::FETCH_OBJ);
            $Daily_sender_id = $daily_sender_details->customer_id;
        }

        // Daily Customer receiver 
        $Daily_receiver_id = 0;
        if ($_POST["addreceiver"] == "true") {
            $receiver_phone = helper::test_input($_POST["receiver_phone"]);
            $receiver_fname = helper::test_input($_POST["receiver_fname"]);
            $receiver_lname = helper::test_input($_POST["receiver_lname"]);
            $receiver_Fathername = helper::test_input($_POST["receiver_Fathername"]);
            $receiver_nid = helper::test_input($_POST["receiver_nid"]);
            $receiver_details = helper::test_input($_POST["receiver_details"]);
            $Daily_receiver_id = $bussiness->addDailyCustomer([$receiver_fname, $receiver_lname, $receiver_Fathername, $receiver_phone, $receiver_nid, $receiver_details, 'Daily Customer', time(), $loged_user->user_id, 1]);
        } else {
            $daily_receiver_data = $bussiness->GetDailyCustomer(helper::test_input($_POST["sender_phone"]));
            $daily_receiver_details = $daily_receiver_data->fetch(PDO::FETCH_OBJ);
            $Daily_receiver_id = $daily_receiver_details->customer_id;
        }

        $transfer_ID = $transfer->addOutTransfer([$user_data->customer_id, $mycommission, 0, $sarafcommission, $Daily_sender_id, $Daily_receiver_id, $amount, $currency, $newdate, 0, 0, $transfercode, 0, $details, 0, "out", $rsaraf_ID, 0]);
        echo $transfer_ID;
    }

    // approve the transfer
    if (isset($_POST["approve"])) {
        $TID = $_POST["TID"];
        $saraf->approverTansaction($TID);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $company = new Company();

    // get currency details of a company
    if (isset($_GET["company_currency"])) {
        $currency_data = $company->GetCompanyCurrency($_GET["currency"]);
        $currency = $currency_data->fetchAll();
        echo json_encode($currency);
    }
}
