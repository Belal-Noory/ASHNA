<?php
session_start();
require "../../init.php";

// Company Model object
$bussiness = new Bussiness();

// Banks account
$bank = new Banks();

// Company
$company = new Company();

// Transfer
$transfer = new Transfer();

if (isset($_SESSION["bussiness_user"])) {
    $loged_user = json_decode($_SESSION["bussiness_user"]);
    $company_FT_data = $company->getCompanyActiveFT($loged_user->company_id);
    $company_ft = $company_FT_data->fetch();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION["bussiness_user"])) {
        $loged_user = json_decode($_SESSION["bussiness_user"]);
    }

    // Add new contact
    if (isset($_POST["addcustomers"])) {

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

        array_push($customer_data, helper::test_input($_POST["father"]));
        array_push($customer_data, helper::test_input($_POST["dob"]));
        array_push($customer_data, helper::test_input($_POST["job"]));
        array_push($customer_data, helper::test_input($_POST["incomesource"]));
        array_push($customer_data, helper::test_input($_POST["monthlyincom"]));
        array_push($customer_data, helper::test_input($_POST["financialCredit"]));
        array_push($customer_data, helper::test_input($_POST["pdetails"]));

        $customerID = $bussiness->addCustomer($customer_data);

        // if its saraf create a login user
        if ($_POST["person_type"] == "MSP") {
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

        // Save BAnk Details of customers
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
        $mainCurrency = "";
        foreach ($company_curreny as $currency) {
            if ($currency->mainCurrency == 1) {
                $mainCurrency = $currency->currency;
                break;
            }
        }

        // Create System Accounts for customers
        if ($_POST["person_type"] == "MSP" || $_POST["person_type"] == "Individual" || $_POST["person_type"] == "Legal Entity" || $_POST["person_type"] == "Share holders") {
            // get accounts receivable account details
            $receivable_account_data = $bank->getAccountCatByName("Accounts Receivable");
            $receivable_account = $receivable_account_data->fetch(PDO::FETCH_OBJ);
            // Create Receivable Account for customer
            $bank->addCatagoryAccount([$receivable_account->account_catagory_id, $_POST["alies_name"], "receivable", $mainCurrency, time(), $loged_user->company_id, $loged_user->user_id, helper::test_input($_POST["person_type"]), $customerID, 1]);
        
            // get accounts receivable account details
            $payable_account_data = $bank->getAccountCatByName("Accounts Payable");
            $payable_account = $payable_account_data->fetch(PDO::FETCH_OBJ);
            // Create payable Account for customer
            $bank->addCatagoryAccount([$payable_account->account_catagory_id, $_POST["alies_name"], "payable", $mainCurrency, time(), $loged_user->company_id, $loged_user->user_id, helper::test_input($_POST["person_type"]), $customerID, 1]);
        }


        // Get Customer Attachments
        $customer_attachment = array();
        array_push($customer_attachment, $customerID);
        array_push($customer_attachment, $_POST["attachment_type"]);
        $fileNAme = time() . $_FILES['attachment']['name'];
        array_push($customer_attachment, $fileNAme);
        array_push($customer_attachment, helper::test_input($_POST["fdetails"]));
        array_push($customer_attachment, $loged_user->user_id);
        array_push($customer_attachment, 0);
        if (move_uploaded_file($_FILES['attachment']['tmp_name'], "../../business/uploadedfiles/customerattachment/" . $fileNAme)) {
            $bussiness->addCustomerAttachments($customer_attachment);
        }
        // If more attachments are submitted
        if (isset($_POST["customersattacmentcount"])) {
            $totalAttachemnts = $_POST["customersattacmentcount"];
            for ($i = 0; $i <= $totalAttachemnts; $i++) {
                if (isset($_POST[("attachment_type" . $i)])) {
                    $customer_attachment_temp = array();
                    array_push($customer_attachment_temp, $customerID);
                    array_push($customer_attachment_temp, $_POST[("attachment_type" . $i)]);
                    $fileNAmeTmp = time() . $_FILES[('attachment' . $i)]['name'];
                    array_push($customer_attachment_temp, $fileNAmeTmp);
                    array_push($customer_attachment_temp, helper::test_input($_POST["fdetails"]));
                    array_push($customer_attachment_temp, $loged_user->user_id);
                    array_push($customer_attachment_temp, 0);
                    if (move_uploaded_file($_FILES[('attachment' . $i)]['tmp_name'], "../../business/uploadedfiles/customerattachment/" . $fileNAmeTmp)) {
                        $bussiness->addCustomerAttachments($customer_attachment_temp);
                    }
                }
            }
        }

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

    // Add customer Attachment
    if (isset($_POST["addAttach"])) {
        // Get Customer Attachments
        $customer_attachment = array();
        array_push($customer_attachment, $_POST["cus"]);
        array_push($customer_attachment, $_POST["attachment_type"]);
        $fileNAme = time() . $_FILES['attachment']['name'];
        array_push($customer_attachment, $fileNAme);
        array_push($customer_attachment, helper::test_input($_POST["details"]));
        array_push($customer_attachment, $loged_user->user_id);
        array_push($customer_attachment, 0);
        if (move_uploaded_file($_FILES['attachment']['tmp_name'], "../../business/uploadedfiles/customerattachment/" . $fileNAme)) {
            $res = $bussiness->addCustomerAttachments($customer_attachment);
        }
        echo $fileNAme;
    }

    // Delete Customer Attachment
    if (isset($_POST["deleteCustomerAttach"])) {
        $customerID = $_POST["cutomerID"];
        $res = $bussiness->deleteCustomerAttachments($customerID);
        if ($res > 0) {
            if (file_exists("../../business/uploadedfiles/customerattachment/" . $customerID)) {
                unlink("../../business/uploadedfiles/customerattachment/" . $customerID);
            }
        }
        echo $res;
    }

    // Change user credentials
    if(isset($_POST["changeCredential"])){
        $username = $_POST["user"];
        $pass = $_POST["pas"];
        $res = $bussiness->changeCredentials($loged_user->customer_id,$username,$pass);
        session_destroy();
        echo $res;
    }

    // add blocked nids
    if(isset($_POST["addblockednids"])){
        $retur = [];
        $nid = $_POST["nid"];
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $father = $_POST["father"];
        $dat = time();
        $res = $bussiness->AddBlockNID($nid,$fname,$lname,$father,$dat,$loged_user->user_id);
        if($res > 0)
        {
            array_push($retur,$nid);
            array_push($retur,$fname);
            array_push($retur,$lname);
            array_push($retur,$father);
            array_push($retur,$res);
            array_push($retur,date('m/d/Y',$dat));
        }
        else{
            array_push($retur,"error");
        }
        echo json_encode($retur);
    }

    // remove Blocked NID
    if(isset($_POST["removeNID"])){
        $nidID = $_POST["ID"];
        $res = $bussiness->RemoveBlockNID($nidID);
        echo $res;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $bussiness = new Bussiness();
    // Get Customer details
    if (isset($_GET["getCustomerByID"])) {
        $customerID = helper::test_input($_GET["customerID"]);
        $getAllTransactions = helper::test_input($_GET["getAllTransactions"]);

        $customer_info = array();

        $customer_data = $bussiness->getCustomerByID($customerID);
        $imgs = $bussiness->getCustomerAttachments($customerID);
        array_push($customer_info, ["personalData" => json_encode($customer_data->fetch())]);
        array_push($customer_info, ["imgs" => json_encode($imgs->fetchAll())]);

        if ($getAllTransactions) {
            // All Transactions
            $cus_receivable_data = $bussiness->getRecivableAccount($loged_user->company_id,$customerID);
            $cus_receivable = $cus_receivable_data->fetch(PDO::FETCH_OBJ);
            $transations_array = array();
            // get payable account transaction
            $receivable_transaction_data = $bank->getAccountMoneyByTerm($cus_receivable->chartofaccount_id,$company_ft["term_id"]);
            $receivable_transaction = $receivable_transaction_data->fetchAll(PDO::FETCH_OBJ);
            array_push($transations_array, $receivable_transaction);
            // foreach ($customer_all_accounts as $all_accounts) {
            //     $allTransactions = $bussiness->getCustomerAllTransaction($all_accounts->chartofaccount_id,$loged_user->company_id);
            //     if ($allTransactions->rowCount() > 0) {
            //         $allTransaction = $allTransactions->fetchAll(PDO::FETCH_ASSOC);
            //         array_push($transations_array, $allTransaction);
            //     }
            // }
            array_push($customer_info, ["transactions" => json_encode($transations_array)]);

            // All Exchange Transaction
            $allExchanges = $bussiness->getCustomerAllExchangeTransaction($customerID);
            $allExchange = $allExchanges->fetchAll(PDO::FETCH_ASSOC);
            array_push($customer_info, ["exchangeTransactions" => json_encode($allExchange)]);

            // All Accounts
            $allAccounts = $bussiness->getCustomerAccountsByID($customerID);
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

    // Get Customer Attachment
    if (isset($_GET["getCustomerAttach"])) {
        $customerId = helper::test_input($_GET["cutomerID"]);
        $attachs = $bussiness->getCustomerAttachments($customerId);
        $attach = $attachs->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($attach);
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
        $note = $notes->fetch(PDO::FETCH_ASSOC);
        echo json_encode($note);
    }

    // get the last transfer code of saraf
    if (isset($_GET["getTranasferCode"])) {
        $SID = $_GET["SID"];
        $company_FT_data = $company->getCompanyActiveFT($loged_user->company_id);
        $company_ft = $company_FT_data->fetch(PDO::FETCH_OBJ);
        $financial_term = 0;
        if (isset($company_ft->term_id)) {
            $financial_term = $company_ft->term_id;
        }
        $result = $transfer->getOutTransferBySaraf($SID, $loged_user->company_id,$financial_term);
        if ($result->rowCount() > 0) {
            $res = $result->fetch(PDO::FETCH_OBJ);
            $ID_array = explode("-", $res->transfer_code);
            echo $ID_array[1];
        } else {
            echo 0;
        }
    }

    // Get transaction Details
    if (isset($_GET["tDetails"])) {
        $LID = $_GET["LID"];
        $res = $bussiness->getTransactionByID($LID);
        $res_data = $res->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($res_data);
    }

    // get customer transactions by Account UD
    if(isset($_GET["TByAccount"]))
    {
        $accID = $_GET["accID"];
        $allTransactions = $bussiness->getCustomerAllTransaction($accID,$loged_user->company_id);
        $allTransactio = $allTransactions->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($allTransactio);
    }

     // get customer transactions by Currency
     if(isset($_GET["TByCurrency"]))
     {
         $accID = $_GET["accID"];
         $cur = $_GET["cur"];
         $allTransactions = $bank->getCustomerAllTransactionByCurrency($accID,$cur);
         $allTransactio = $allTransactions->fetchAll(PDO::FETCH_OBJ);
         echo json_encode($allTransactio);
     }

    //  Get Daily Customers List
    if(isset($_GET["Customers"]))
    {
        $DC_data = $bussiness->getCustomer($loged_user->company_id);
        $DC_list= $DC_data->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($DC_list);
    }

    // get customer KYC
    if(isset($_GET["KYC"]))
    {
        $cusID = $_GET["cusID"];
        $data = [];

        // profile details
        $profile_details = $bussiness->getCustomerDetails($cusID);
        $profile = $profile_details->fetch(PDO::FETCH_OBJ);
        // array_push($data,["profile"=>$profile]);
        $data["profile"] = $profile;

        // Customer Address
        $cus_address = $bussiness->getCustomerAddress($cusID);
        // array_push($data,["Address"=>$cus_address->fetchAll(PDO::FETCH_OBJ)]);
        $data["Address"]= $cus_address->fetchAll(PDO::FETCH_OBJ);

        // Customer Bank details
        $cus_banks = $bussiness->getCustomerBankDetails($cusID);
        // array_push($data,["bankDetails"=>$cus_banks->fetchAll(PDO::FETCH_OBJ)]);
        $data["bankDetails"]=$cus_banks->fetchAll(PDO::FETCH_OBJ);

        // Customer Attachement
        $cus_attach = $bussiness->getCustomerAttachments($cusID);
        // array_push($data,["attachment"=>$cus_attach->fetchAll(PDO::FETCH_OBJ)]);
        $data["attachment"]=$cus_attach->fetchAll(PDO::FETCH_OBJ);

        echo json_encode($data);
    }
}
