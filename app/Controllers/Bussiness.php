<?php
session_start();
require "../../init.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Company Model object
    $bussiness = new Bussiness();


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

        // Get Customer Bank details
        $customer_bank_details = array();
        array_push($customer_bank_details, $customerID);
        array_push($customer_bank_details, helper::test_input($_POST["bank_name"]));
        array_push($customer_bank_details, helper::test_input($_POST["account_type"]));
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
                    array_push($customer_bank_details_temp, helper::test_input($_POST[("account_type" . $i)]));
                    array_push($customer_bank_details_temp, helper::test_input($_POST[("account_number" . $i)]));
                    array_push($customer_bank_details_temp, helper::test_input($_POST[("currency" . $i)]));
                    array_push($customer_bank_details_temp, helper::test_input($_POST[("details" . $i)]));
                    $bussiness->addCustomerBankDetails($customer_bank_details_temp);
                }
            }
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
}
