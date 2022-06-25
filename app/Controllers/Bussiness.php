<?php
session_start();
require "../../init.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Company Model object
    $bussiness = new Bussiness();

    // Banks account
    $bank = new Banks();

    // Company
    $company = new Company();

    // Add new contact
    if (isset($_POST["addcustomers"])) {
        $loged_user = json_decode($_SESSION["bussiness_user"]);

        $customer_data = array();
        // Get Customer personal Data
        array_push($customer_data, $loged_user->company_id);
        array_push($customer_data, helper::test_input($_POST["fname"]));
        array_push($customer_data, helper::test_input($_POST["lname"]));
        array_push($customer_data, helper::test_input($_POST["alies_name"]));
        array_push($customer_data, helper::test_input($_POST["gender"]));
        array_push($customer_data, helper::test_input($_POST["email"]));
        array_push($customer_data, helper::test_input($_POST["NID"]));
        array_push($customer_data, helper::test_input($_POST["TIN"]));
        array_push($customer_data, helper::test_input($_POST["office_address"]));
        array_push($customer_data, helper::test_input($_POST["office_details"]));
        array_push($customer_data, helper::test_input($_POST["official_phone"]));
        array_push($customer_data, helper::test_input($_POST["personal_phone"]));
        array_push($customer_data, helper::test_input($_POST["personal_phone_second"]));
        array_push($customer_data, helper::test_input($_POST["fax"]));
        array_push($customer_data, helper::test_input($_POST["website"]));
        array_push($customer_data, helper::test_input($_POST["note"]));
        array_push($customer_data, helper::test_input($_POST["person_type"]));
        array_push($customer_data, time());
        array_push($customer_data, $loged_user->user_id);
        if ($loged_user->person_type == "admin") {
            array_push($customer_data, 1);
        } else {
            array_push($customer_data, 0);
        }

        $customerID = $bussiness->addCustomer($customer_data);

        // if its saraf create a login user
        if ($_POST["person_type"] == "Saraf") {
            $saraf = new Saraf();
            $res = $saraf->addSarafLogin([$customerID, $_POST["fname"], $_POST["NID"], 0]);
        }

        // Get Customer Address
        $customer_address = array();
        array_push($customer_address, $customerID);
        array_push($customer_address, helper::test_input($_POST["address_type"]));
        array_push($customer_address, helper::test_input($_POST["detail_address"]));
        array_push($customer_address, helper::test_input($_POST["province"]));
        array_push($customer_address, helper::test_input($_POST["district"]));
        $bussiness->addCustomerAddress($customer_address);

        // if more accounts are submitted
        if (isset($_POST["customeraddresscount"])) {
            $totalAddress = $_POST["customeraddresscount"];
            for ($i = 0; $i <= $totalAddress; $i++) {
                if (isset($_POST[("address_type" . $i)])) {
                    $customer_address_temp = array();
                    array_push($customer_address_temp, $customerID);
                    array_push($customer_address_temp, helper::test_input($_POST[("address_type" . $i)]));
                    array_push($customer_address_temp, helper::test_input($_POST[("detail_address" . $i)]));
                    array_push($customer_address_temp, helper::test_input($_POST[("province" . $i)]));
                    array_push($customer_address_temp, helper::test_input($_POST[("district" . $i)]));
                    $bussiness->addCustomerAddress($customer_address_temp);
                }
            }
        }

        if ($_POST["person_type"] != "Daily Customer") {
            // Get Customer Bank details | Create an account in chart of accounts for the customer
            $customer_bank_details = array();
            array_push($customer_bank_details, $customerID);
            array_push($customer_bank_details, helper::test_input($_POST["bank_name"]));
            array_push($customer_bank_details, helper::test_input($_POST["account_number"]));
            array_push($customer_bank_details, helper::test_input($_POST["currency"]));
            array_push($customer_bank_details, helper::test_input($_POST["details"]));
            $bussiness->addCustomerBankDetails($customer_bank_details);

            // if more accounts are submitted
            if (isset($_POST["customersbankdetailscount"])) {
                $totalAccounts = $_POST["customersbankdetailscount"];
                for ($i = 0; $i <= $totalAccounts; $i++) {
                    if (isset($_POST[("bank_name" . $i)])) {
                        $customer_bank_details_temp = array();
                        array_push($customer_bank_details_temp, $customerID);
                        array_push($customer_bank_details_temp, helper::test_input($_POST[("bank_name" . $i)]));
                        array_push($customer_bank_details_temp, helper::test_input($_POST[("account_number" . $i)]));
                        array_push($customer_bank_details_temp, helper::test_input($_POST[("currency" . $i)]));
                        array_push($customer_bank_details_temp, helper::test_input($_POST[("details" . $i)]));
                        $bussiness->addCustomerBankDetails($customer_bank_details_temp);
                    }
                }
            }
        }

        // add accounts for new customer
        $company_currencies = $company->GetCompanyCurrency($loged_user->company_id);
        $company_curreny = $company_currencies->fetchAll(PDO::FETCH_OBJ);

        // get account catagory for payable accounts
        $catagoryies = $company->getCatagoryByName("liablity");
        $catagory_payable = $catagoryies->fetch(PDO::FETCH_OBJ);

        // get account catagory for receivable accounts
        $catagoryies = $company->getCatagoryByName("assets");
        $catagory_receiable = $catagoryies->fetch(PDO::FETCH_OBJ);

        foreach ($company_curreny as $currency) {
            $bank->addCatagoryAccount([$catagory_payable->account_catagory_id, $_POST["fname"] . " " . $_POST["lname"], "Payable", $currency->currency, time(), $loged_user->company_id, $loged_user->user_id, "Customer", $customerID]);
            $bank->addCatagoryAccount([$catagory_receiable->account_catagory_id, $_POST["fname"] . " " . $_POST["lname"], "Receivable", $currency->currency, time(), $loged_user->company_id, $loged_user->user_id, "Customer", $customerID]);
        }

        // Get Customer Attachments
        // $customer_attachment = array();
        // array_push($customer_attachment, $customerID);
        // array_push($customer_attachment, helper::test_input($_POST["attachment_type"]));
        // array_push($customer_attachment, $_FILES['attachment']['name']);
        // array_push($customer_attachment, helper::test_input($_POST["details"]));
        // array_push($customer_attachment, $loged_user->user_id);
        // print_r($customer_attachment);


        // move_uploaded_file($_FILES['attachment']['tmp_name'],"../../business/uploadedfiles/customerattachment/"+$_FILES['attachment']['name']);

        // // If more attachments are submitted
        // if(isset($_POST["customersattacmentcount"]))
        // {
        //     $totalAttachemnts = $_POST["customersattacmentcount"];
        //     for($i = 0; $i <= $totalAttachemnts; $i++)
        //     {
        //         if(isset($_POST[("attachment_type".$i)])){
        //             $customer_attachment_temp = array();
        //             array_push($customer_attachment_temp, $customerID);
        //             array_push($customer_attachment_temp, helper::test_input($_POST[("attachment_type".$i)]));
        //             array_push($customer_attachment_temp, $_FILES[('attachment'.$i)]['name']);
        //             array_push($customer_attachment_temp, helper::test_input($_POST["details"]));
        //             array_push($customer_attachment_temp, $loged_user->user_id);

        //             move_uploaded_file($_FILES[('attachment'.$i)]['tmp_name'],"../../business/uploadedfiles/customerattachment/"+$_FILES[('attachment'.$i)]['name']);
        //         }
        //     }
        // }

        echo $customerID;
    }

    // Add customer notes
    if (isset($_POST["addCustomerNote"])) {
        $title = helper::test_input($_POST["title"]);
        $details = helper::test_input($_POST["details"]);
        $noteID = $bussiness->addCustomerNote([$_POST["cutomerID"], $title, $details, time()]);
        echo $noteID;
    }

    // Delete Customer Notes
    if (isset($_POST["deleteCustomerNote"])) {
        $customerID = $_POST["cutomerID"];
        $res = $bussiness->deleteCustomerNote($customerID);
        echo $res->rowCount();
    }

    // Add customer Reminder
    if (isset($_POST["addCustomerReminder"])) {
        $title = helper::test_input($_POST["title"]);
        $details = helper::test_input($_POST["details"]);
        $date = helper::test_input($_POST["date"]);
        $reminderID = $bussiness->addCustomerReminder([$_POST["cutomerID"], $title, $details, $date, time()]);
        echo $reminderID;
    }

    // Delete Customer Reminder
    if (isset($_POST["deleteCustomerReminder"])) {
        $customerID = $_POST["cutomerID"];
        $res = $bussiness->deleteCustomerReminder($customerID);
        echo $res->rowCount();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $bussiness = new Bussiness();
    if (isset($_SESSION["bussiness_user"])) {
        $loged_user = json_decode($_SESSION["bussiness_user"]);
    }


    // Get Customer details
    if (isset($_GET["getCustomerByID"])) {
        $customerID = helper::test_input($_GET["customerID"]);
        $getAllTransactions = helper::test_input($_GET["getAllTransactions"]);

        $customer_info = array();

        $customer_data = $bussiness->getCustomerByID($customerID);
        array_push($customer_info, ["personalData" => json_encode($customer_data->fetch())]);
        if ($getAllTransactions) {
            // All Transactions
            $customer_all_accounts_data = $bussiness->getCustomerAccountsByID($customerID);
            $customer_all_accounts = $customer_all_accounts_data->fetchAll(PDO::FETCH_OBJ);
            $transations_array = array();
            foreach ($customer_all_accounts as $all_accounts) {
                $allTransactions = $bussiness->getCustomerAllTransaction($all_accounts->chartofaccount_id);
                if($allTransactions->rowCount() > 0)
                {
                    $allTransaction = $allTransactions->fetchAll(PDO::FETCH_ASSOC);
                    array_push($transations_array,json_encode($allTransaction));
                }
            }
            array_push($customer_info, ["transactions" => json_encode($transations_array)]);

            // All Exchange Transaction
            $allExchanges = $bussiness->getCustomerAllExchangeTransaction($customerID);
            $allExchange = $allExchanges->fetchAll(PDO::FETCH_ASSOC);
            array_push($customer_info, ["exchangeTransactions" => json_encode($allExchange)]);

            // All Accounts
            $allAccounts = $bussiness->getCustomerAllAccounts($customerID);
            $allAccount = $allAccounts->fetchAll(PDO::FETCH_ASSOC);
            array_push($customer_info, ["Accounts" => json_encode($allAccount)]);
        }

        echo json_encode($customer_info);
    }

    // Get Currency Details
    if (isset($_GET["getCurrencyDetails"])) {
        $company = new Company();
        $debet_data = $company->GetCompanyCurrencyDetails($loged_user->company_id, $_GET["DebetID"]);
        $debet = $debet_data->fetch();
        $credeit_datA = $company->GetCompanyCurrencyDetails($loged_user->company_id, $_GET["creditID"]);
        $credeit = $credeit_datA->fetch();

        $data = array("debet" => $debet, "credeit" => $credeit);
        echo json_encode($data);
    }

    // Get Customer Notes
    if (isset($_GET["getCustomerNote"])) {
        $customerId = helper::test_input($_GET["cutomerID"]);
        $notes = $bussiness->getCustomerNote($customerId);
        $note = $notes->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($note);
    }

    // Get Customer Reminder
    if (isset($_GET["getCustomerReminder"])) {
        $customerId = helper::test_input($_GET["cutomerID"]);
        $notes = $bussiness->getCustomerReminder($customerId);
        $note = $notes->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($note);
    }

    // Get Daily Customer
    if (isset($_GET["getDailyCus"])) {
        $phone = helper::test_input($_GET["dailyCusID"]);
        $notes = $bussiness->GetDailyCustomer($phone);
        $note = $notes->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($note);
    }

    // Check if daily nid is not blocked
    if (isset($_GET["checkNID"])) {
        $nid = helper::test_input($_GET["checkNID"]);
        $notes = $bussiness->GetBlockNID($nid);
        $note = $notes->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($note);
    }
}
