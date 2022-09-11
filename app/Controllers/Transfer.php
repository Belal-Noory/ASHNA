<?php
session_start();
require "../../init.php";

// Company Model object
$company = new Company();
$bussiness = new Bussiness();
// Banks account
$bank = new Banks();
// Transfer 
$transfer = new Transfer();
$saraf = new Saraf();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $loged_user = json_decode($_SESSION["bussiness_user"]);

    $company_FT_data = $company->getCompanyActiveFT($loged_user->company_id);
    $company_ft = $company_FT_data->fetch(PDO::FETCH_OBJ);

    // add accounts for new customer
    $company_currencies = $company->GetCompanyCurrency($loged_user->company_id);
    $company_curreny = $company_currencies->fetchAll(PDO::FETCH_OBJ);
    $mainCurency = "";
    foreach ($company_curreny as $currency) {
        if ($currency->mainCurrency == 1) {
            $mainCurency = $currency->currency;
        }
    }

    // Add new out transfer
    if (isset($_POST["addouttransfer"])) {
        $loged_user = json_decode($_SESSION["bussiness_user"]);
        $company_id = $loged_user->company_id;

        $details = helper::test_input($_POST["details"]);
        $date = helper::test_input($_POST["date"]);
        $newdate = strtotime($date);
        $transfercode = helper::test_input($_POST["transfercode"]);
        $vouchercode = helper::test_input($_POST["vouchercode"]);
        $rsaraf_ID = helper::test_input($_POST["rsaraf_ID"]);
        $currency = helper::test_input($_POST["currency"]);
        $amount = helper::test_input($_POST["tamount"]);
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
            $fileNAmeTmp = time() . $_FILES["attachmentsender"]['name'];
            if (move_uploaded_file($_FILES['attachmentsender']['tmp_name'], "../../business/uploadedfiles/dailycustomer/" . $fileNAmeTmp)) {
                $type = $_POST["attachTypesender"];
                $bussiness->addDailyCustomerAttachment([$Daily_sender_id, $fileNAmeTmp, $type]);
            }
            $totalsenderAttachemnts = $_POST["attachCountsender"];
            if ($totalsenderAttachemnts > 0) {
                for ($i = 1; $i <= $totalsenderAttachemnts; $i++) {
                    $fileNameTmp = time() . $_FILES[('attachmentsender' . $i)]['name'];
                    if (move_uploaded_file($_FILES[('attachmentsender' . $i)]['tmp_name'], "../../business/uploadedfiles/dailycustomer/" . $fileNameTmp)) {
                        $type_tmp = $_POST[("attachTypesender" . $i)];
                        $bussiness->addDailyCustomerAttachment([$Daily_sender_id, $fileNameTmp, $type_tmp]);
                    }
                }
            }
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

            $fileNAmeTmp = time() . $_FILES["attachmentreceiver"]['name'];
            if (move_uploaded_file($_FILES['attachmentreceiver']['tmp_name'], "../../business/uploadedfiles/dailycustomer/" . $fileNAmeTmp)) {
                $type_r = $_POST["attachTypereceiver"];
                $bussiness->addDailyCustomerAttachment([$Daily_receiver_id, $fileNAmeTmp, $type_r]);
            }

            $totalreceiverAttachemnts = $_POST["attachCountreceiver"];
            if ($totalreceiverAttachemnts > 0) {
                for ($i = 1; $i <= $totalreceiverAttachemnts; $i++) {

                    $fileNameTmp = time() . $_FILES[('attachmentsender' . $i)]['name'];
                    if (move_uploaded_file($_FILES[('attachmentsender' . $i)]['tmp_name'], "../../business/uploadedfiles/dailycustomer/" . $fileNameTmp)) {
                        $type_r_tmp = $_POST[("attachTypereceiver" . $i)];
                        $bussiness->addDailyCustomerAttachment([$Daily_receiver_id, $fileNameTmp]);
                    }
                }
            }
        } else {
            $daily_receiver_data = $bussiness->GetDailyCustomer(helper::test_input($_POST["sender_phone"]));
            $daily_receiver_details = $daily_receiver_data->fetch(PDO::FETCH_OBJ);
            $Daily_receiver_id = $daily_receiver_details->customer_id;
        }

        // just add one payment method
        $paymentID = $_POST["reciptItemID"];
        $payment_amount = $_POST["reciptItemAmount"] - ($sarafcommission + $mycommission);
        $company_financial_term_id = 0;
        if (isset($company_ft->term_id)) {
            $company_financial_term_id = $company_ft->term_id;
        }
        $recipt_details = helper::test_input($_POST["reciptItemdetails"]);

        // get currency details
        $currency_data = $company->GetCompanyCurrencyDetails($loged_user->company_id, $currency);
        $currency_details = $currency_data->fetch(PDO::FETCH_OBJ);

        // get the rate of the currency
        $rate = 0;
        if ($currency_details->currency !== $mainCurency) {
            $currency_rate_details_data = $bank->getExchangeConversion($mainCurency, $currency_details->currency, $loged_user->company_id);
            $currency_rate_details = $currency_rate_details_data->fetch(PDO::FETCH_OBJ);
            if ($currency_rate_details->currency_from == $mainCurency) {
                $rate = 1 / $currency_rate_details->rate;
            } else {
                $rate = $currency_rate_details->rate;
            }
        }

        $leadger_id = $transfer->addTransferOutLeadger([$paymentID, $rsaraf_ID, $company_financial_term_id, $newdate, $details, 0, $loged_user->user_id, 0, "transferout", $loged_user->company_id, $currency]);
        // Credit the required amount in Saraf`s account
        $transfer->addTransferOutMoney([$rsaraf_ID, $leadger_id, $amount, "Crediet", $loged_user->company_id, $recipt_details, 1, $currency, $rate]);
        $transfer->addTransferOutMoney([$rsaraf_ID, $leadger_id, $sarafcommission, "Crediet", $loged_user->company_id, $recipt_details, 1, $currency, $rate]);

        // Debit the required amount from Company Account
        $transfer->addTransferOutMoney([$paymentID, $leadger_id, $payment_amount, "Debet", $loged_user->company_id, $details, 1, $currency, $rate]);
        $transfer->addTransferOutMoney([$paymentID, $leadger_id, $mycommission, "Debet", $loged_user->company_id, $details, 1, $currency, $rate]);
        $transfer->addTransferOutMoney([$paymentID, $leadger_id, $sarafcommission, "Debet", $loged_user->company_id, $details, 1, $currency, $rate]);

        // Add the transfer profit to Income out transfer account in chartofaccount
        $incomeTransfer_data = $bank->getAccountByName($loged_user->company_id, "Income out Transfer");
        $incomeTransfer = $incomeTransfer_data->fetch(PDO::FETCH_OBJ);
        $transfer->addTransferOutMoney([$incomeTransfer->chartofaccount_id, $leadger_id, $mycommission, "Crediet", $loged_user->company_id, $details, 1, $currency, $rate]);

        $saraf_cus_id_data = $bank->getCustomerByBank($rsaraf_ID);
        $saraf_cus_id_details = $saraf_cus_id_data->fetch(PDO::FETCH_OBJ);

        $transfer_ID = $transfer->addOutTransfer([$loged_user->customer_id, $mycommission, $saraf_cus_id_details->customer_id, $sarafcommission, $Daily_sender_id, $Daily_receiver_id, $amount, $currency, $newdate, 0, 0, $transfercode, $vouchercode, $details, 0, "out", $loged_user->company_id, $leadger_id]);

        // get currency details
        $cdetails_data = $company->GetCurrencyDetails($currency);
        $cdetails = $cdetails_data->fetch(PDO::FETCH_OBJ);

        $address = "";
        if(isset($saraf_cus_id_details->office_address) || isset($saraf_cus_id_details->official_phone) || $saraf_cus_id_details->personal_phone)
        {
            $address = $saraf_cus_id_details->office_address.",".$saraf_cus_id_details->official_phone.",".$saraf_cus_id_details->personal_phone;
        }
        $ret = array('date' => $date, 'lid' => $leadger_id, 'tid' => $transfer_ID, 'currency' => $cdetails->currency, 'amount' => $amount, 'details' => $details, 'pby' => $loged_user->fname . ' ' . $loged_user->lname,'tcode'=>$transfercode,'address'=>$address);
        echo json_encode($ret);
    }


    // Add new In transfer
    if (isset($_POST["addintransfer"])) {
        $loged_user = json_decode($_SESSION["bussiness_user"]);
        $company_id = $loged_user->company_id;

        $details = helper::test_input($_POST["details"]);
        $date = helper::test_input($_POST["date"]);
        $newdate = strtotime($date);
        $transfercode = helper::test_input($_POST["transfercode"]);
        $vouchercode = helper::test_input($_POST["vouchercode"]);
        $rsaraf_ID = helper::test_input($_POST["rsaraf_ID"]);
        $currency = helper::test_input($_POST["currency"]);
        $amount = helper::test_input($_POST["tamount"]);
        $mycommission = helper::test_input($_POST["mycommission"]);

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

            $fileNAmeTmp = time() . $_FILES["attachmentsender"]['name'];
            if (move_uploaded_file($_FILES['attachmentsender']['tmp_name'], "../../business/uploadedfiles/dailycustomer/" . $fileNAmeTmp)) {
                $type = $_POST["attachTypesender"];
                $bussiness->addDailyCustomerAttachment([$Daily_sender_id, $fileNAmeTmp, $type]);
            }
            $totalsenderAttachemnts = $_POST["attachCountsender"];
            if ($totalsenderAttachemnts > 0) {
                for ($i = 1; $i <= $totalsenderAttachemnts; $i++) {
                    $fileNameTmp = time() . $_FILES[('attachmentsender' . $i)]['name'];
                    if (move_uploaded_file($_FILES[('attachmentsender' . $i)]['tmp_name'], "../../business/uploadedfiles/dailycustomer/" . $fileNameTmp)) {
                        $type_tmp = $_POST[("attachTypesender" . $i)];
                        $bussiness->addDailyCustomerAttachment([$Daily_sender_id, $fileNameTmp, $type_tmp]);
                    }
                }
            }
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

            $fileNAmeTmp = time() . $_FILES["attachmentreceiver"]['name'];
            if (move_uploaded_file($_FILES['attachmentreceiver']['tmp_name'], "../../business/uploadedfiles/dailycustomer/" . $fileNAmeTmp)) {
                $type_r = $_POST["attachTypereceiver"];
                $bussiness->addDailyCustomerAttachment([$Daily_receiver_id, $fileNAmeTmp, $type_r]);
            }

            $totalreceiverAttachemnts = $_POST["attachCountreceiver"];
            if ($totalreceiverAttachemnts > 0) {
                for ($i = 1; $i <= $totalreceiverAttachemnts; $i++) {

                    $fileNameTmp = time() . $_FILES[('attachmentsender' . $i)]['name'];
                    if (move_uploaded_file($_FILES[('attachmentsender' . $i)]['tmp_name'], "../../business/uploadedfiles/dailycustomer/" . $fileNameTmp)) {
                        $type_r_tmp = $_POST[("attachTypereceiver" . $i)];
                        $bussiness->addDailyCustomerAttachment([$Daily_receiver_id, $fileNameTmp]);
                    }
                }
            }
        } else {
            $daily_receiver_data = $bussiness->GetDailyCustomer(helper::test_input($_POST["receiver_phone"]));
            $daily_receiver_details = $daily_receiver_data->fetch(PDO::FETCH_OBJ);
            $Daily_receiver_id = $daily_receiver_details->customer_id;
        }

        $saraf_cus_id_data = $bank->getCustomerByBank($rsaraf_ID);
        $saraf_cus_id_details = $saraf_cus_id_data->fetch(PDO::FETCH_OBJ);

        // get currency details
        $currency_data = $company->GetCompanyCurrencyDetails($loged_user->company_id, $currency);
        $currency_details = $currency_data->fetch(PDO::FETCH_OBJ);

        // get the rate of the currency
        $rate = 0;
        if ($account_currency->currency !== $mainCurency) {
            $currency_rate_details_data = $bank->getExchangeConversion($mainCurency, $currency_details->currency, $loged_user->company_id);
            $currency_rate_details = $currency_rate_details_data->fetch(PDO::FETCH_OBJ);
            if ($currency_rate_details->currency_from == $mainCurency) {
                $rate = 1 / $currency_rate_details->rate;
            } else {
                $rate = $currency_rate_details->rate;
            }
        }

        $transfer_ID = $transfer->addOutTransfer([$saraf_cus_id_details->customer_id, $rate, $loged_user->customer_id, $mycommission, $Daily_sender_id, $Daily_receiver_id, $amount, $currency, $newdate, 0, 0, $transfercode, $vouchercode, $details, 0, "in", $loged_user->company_id, $rsaraf_ID]);

        // get currency details
        $cdetails_data = $company->GetCurrencyDetails($currency);
        $cdetails = $cdetails_data->fetch(PDO::FETCH_OBJ);

        $address = "";
        if(isset($saraf_cus_id_details->office_address) || isset($saraf_cus_id_details->official_phone) || $saraf_cus_id_details->personal_phone)
        {
            $address = $saraf_cus_id_details->office_address.",".$saraf_cus_id_details->official_phone.",".$saraf_cus_id_details->personal_phone;
        }
        
        $ret = array('date' => $date, 'lid' => $leadger_id, 'tid' => $transfer_ID, 'currency' => $cdetails->currency, 'amount' => $amount, 'details' => $details, 'pby' => $loged_user->fname . ' ' . $loged_user->lname,'tcode'=>$transfercode,'address'=>$address);
        echo json_encode($ret);
    }

    // approve In transfer from saraf
    if (isset($_POST["sarafIntrasnfer"])) {
        $company_id = $loged_user->company_id;

        // Get money transfer id and select from database
        $transfer_id = $_POST["TID"];

        // get transfer details
        $transfer_details_data = $transfer->getTransferByID($transfer_id);
        $transfer_details = $transfer_details_data->fetch(PDO::FETCH_OBJ);

        // just add one payment method
        $paymentID = $_POST["reciptItemID"];
        $company_financial_term_id = 0;
        if (isset($company_ft->term_id)) {
            $company_financial_term_id = $company_ft->term_id;
        }
        $recipt_details = helper::test_input($_POST["reciptItemdetails"]);

        $leadger_id = $transfer->addTransferOutLeadger([$paymentID, $transfer_details->leadger_id, $company_financial_term_id, time(), $recipt_details, 0, $loged_user->user_id, 0, "transferin", $loged_user->company_id, $transfer_details->company_currency_id]);
        // Credit the required amount in Saraf`s account
        $transfer->addTransferOutMoney([$transfer_details->leadger_id, $leadger_id, $transfer_details->amount, "Debet", $loged_user->company_id, $recipt_details, 0, $transfer_details->company_currency_id, $transfer_details->company_user_sender_commission]);
        $transfer->addTransferOutMoney([$transfer_details->leadger_id, $leadger_id, $transfer_details->company_user_receiver_commission, "Debet", $loged_user->company_id, $recipt_details, 0, $transfer_details->company_currency_id, $transfer_details->company_user_sender_commission]);
        // Debit the required amount from Company Account
        $transfer->addTransferOutMoney([$paymentID, $leadger_id, $transfer_details->amount, "Crediet", $loged_user->company_id, $recipt_details, 0, $transfer_details->company_currency_id, $transfer_details->company_user_sender_commission]);

        // Add the transfer profit to Income out transfer account in chartofaccount
        $incomeTransfer_data = $bank->getAccountByName($loged_user->company_id, "Income in Transfer");
        $incomeTransfer = $incomeTransfer_data->fetch(PDO::FETCH_OBJ);
        $transfer->addTransferOutMoney([$incomeTransfer->chartofaccount_id, $leadger_id, $transfer_details->company_user_receiver_commission, "Crediet", $loged_user->company_id, $recipt_details, 0, $transfer_details->company_currency_id, $transfer_details->company_user_sender_commission]);

        // update in transferece
        $transfer->approveTransfer($transfer_id, $leadger_id);
        echo $leadger_id;
    }

    // Cancel Transfer
    if (isset($_POST["cancel_transer_done"])) {
        $transfer_id = $_POST["transferID"];
        $leadgers = explode(",", $transfer_id);

        $transfer->deleteTransferByLeadger($transfer_id);

        foreach ($leadgers as $l) {
            $transfer->deleteAccoumtMoneyByLeadger($l);
            $transfer->deleteTransferLeadger($l);
        }
        echo "done";
    }

    // // Approve Transfer
    // if (isset($_POST["approve_transer_done"])) {
    //     $transfer_id = $_POST["transferID"];
    //     $transfer->approveTransferMoneyByLeadger($transfer_id);
    //     $transfer->approveTransfer($transfer_id);
    //     echo "done";
    // }

    // update moeny receiver details
    if (isset($_POST["updatereceiver"])) {
        $RID = $_POST["receiverID"];
        $attachCounter = $_POST["attachCountreceiver"];

        $receiver_phone = helper::test_input($_POST["receiver_phone"]);
        $receiver_fname = helper::test_input($_POST["receiver_fname"]);
        $receiver_lname = helper::test_input($_POST["receiver_lname"]);
        $receiver_Fathername = helper::test_input($_POST["receiver_Fathername"]);
        $receiver_nid = helper::test_input($_POST["receiver_nid"]);
        $receiver_details = helper::test_input($_POST["receiver_details"]);

        $res = $bussiness->updateDailyCustomer([$receiver_fname, $receiver_lname, $receiver_Fathername, $receiver_phone, $receiver_nid, $receiver_details, $RID]);

        if (!empty($_FILES)) {
            $fileNAmeTmp = time() . $_FILES["attachmentreceiver"]['name'];
            if (move_uploaded_file($_FILES['attachmentreceiver']['tmp_name'], "../../business/uploadedfiles/dailycustomer/" . $fileNAmeTmp)) {
                $type_r = $_POST["attachTypereceiver"];
                $bussiness->addDailyCustomerAttachment([$RID, $fileNAmeTmp, $type_r]);
            }
        }

        if ($attachCounter > 0) {
            for ($i = 1; $i <= $attachCounter; $i++) {
                $fileNameTmp = time() . $_FILES[('attachmentreceiver' . $i)]['name'];
                if (move_uploaded_file($_FILES[('attachmentreceiver' . $i)]['tmp_name'], "../../business/uploadedfiles/dailycustomer/" . $fileNameTmp)) {
                    $type_r_tmp = $_POST[("attachTypereceiver" . $i)];
                    $bussiness->addDailyCustomerAttachment([$RID, $fileNameTmp, $type_r_tmp]);
                }
            }
        }

        echo $res;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $transfer = new Transfer();
    $loged_user = json_decode($_SESSION["bussiness_user"]);

    if (isset($_GET["transferoutalldetails"])) {
        $leadger = $_GET["leadger_id"];
        $details = $transfer->getTransferByLeadger($leadger);
        echo json_encode($details->fetchAll(PDO::FETCH_OBJ));
    }

    if (isset($_GET["transferByID"])) {
        $TID = $_GET["TID"];
        $details = $transfer->getTransferByID($TID);
        echo json_encode($details->fetchAll(PDO::FETCH_ASSOC));
    }

    // Get Currency Details
    if (isset($_GET["getCurrencyDetails"])) {
        $company = new Company();
        $debet_data = $company->GetCompanyCurrencyDetails($loged_user->company_id, $_GET["cur"]);
        $debet = $debet_data->fetch(PDO::FETCH_OBJ);

        echo json_encode($debet);
    }

    // Get Daily customer Money sender
    if (isset($_GET["DCMS"])) {
        $id = $_GET["id"];
        $detials = $transfer->getDailyCusDetails($id);
        echo json_encode($detials->fetch(PDO::FETCH_OBJ));
    }

    // Get Daily customer with attachment
    if (isset($_GET["DCMSAttach"])) {
        $id = $_GET["id"];
        $detials = $transfer->getDailyCusDetailsAttachment($id);
        echo json_encode($detials->fetchAll());
    }

    // Get Financial Accounts details
    if (isset($_GET["account"])) {
        $id = $_GET["id"];
        $detials = $bank->getBank_Saif($id);
        echo json_encode($detials->fetch(PDO::FETCH_OBJ));
    }

    // lock transfer
    if (isset($_GET["lockTR"])) {
        $ID = $_GET["ID"];
        $lock = $_GET["lock"];
        $res = $transfer->lockUnlockTransfer($ID, $lock);
        echo $res;
    }
}
