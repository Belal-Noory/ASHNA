<?php
session_start();
require "../../init.php";
$loged_user = json_decode($_SESSION["bussiness_user"]);

$banks = new Banks();
$company = new Company();
$system = new SystemAdmin();
$receipt = new Receipt();
$bussiness = new Bussiness();
$transfer = new Transfer();

$company_FT_data = $company->getCompanyActiveFT($loged_user->company_id);
$company_ft = $company_FT_data->fetch(PDO::FETCH_OBJ);

$company_currencies = $company->GetCompanyCurrency($loged_user->company_id);
$company_curreny = $company_currencies->fetchAll(PDO::FETCH_OBJ);
$mainCurency = "";
foreach ($company_curreny as $currency) {
    if ($currency->mainCurrency == 1) {
        $mainCurency = $currency->currency;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Edit Recipt
    if (isset($_POST["receipt"])) {
        $catagory_id = $system->getCatagoryByName("revenue");
        $catagoey = $catagory_id->fetch(PDO::FETCH_OBJ);

        $date = $_POST["date"];
        $newdate = strtotime($date);

        $account_catagory = $catagoey->account_catagory_id;
        $recievable_id = helper::test_input($_POST["reciptItemID"]);
        $payable_id = helper::test_input($_POST["customer"]);
        $currency_id = helper::test_input($_POST["currency"]);
        $remarks = helper::test_input($_POST["details"]);
        $accountdetails = helper::test_input($_POST["accountdetails"]);

        $reg_date = $newdate;
        $currency_rate = $_POST["rate"];
        $approve = 0;
        $createby = $loged_user->customer_id;
        $company_id = $loged_user->company_id;
        $amount = $_POST["amount"];
        $reciptItemAmount = $_POST["reciptItemAmount"];
        $recipt_details = helper::test_input($_POST["reciptItemdetails"]);

        // Get Last Leadger ID of company
        $LastLID = $_POST["LID"];

        // Add single entery in leadger
        $banks->updatedLeadger([$recievable_id, $payable_id, $currency_id, $remarks, $reg_date, $currency_rate, $createby, $LastLID]);
        $tid = $banks->updateTransferMoney([$payable_id, $amount, $currency_id, $currency_rate, $LastLID, "Crediet"]);
        $banks->updateTransferMoney([$recievable_id, $reciptItemAmount, $currency_id, $currency_rate, $LastLID, "Debet"]);

        // get currency details
        $cdetails_data = $company->GetCurrencyDetails($currency_id);
        $cdetails = $cdetails_data->fetch(PDO::FETCH_OBJ);

        $res = array('date' => $date, 'lid' => $LastLID, 'tid' => $tid, $tid, 'currency' => $cdetails->currency, 'amount' => $amount, 'details' => $remarks, 'pby' => $loged_user->fname . ' ' . $loged_user->lname);
        echo json_encode($res);
    }

    // edite Revenues
    if (isset($_POST["revenue"])) {
        $catagory_id = $system->getCatagoryByName("revenue");
        $catagoey = $catagory_id->fetch(PDO::FETCH_OBJ);

        $date = $_POST["date"];
        $newdate = strtotime($date);

        $account_catagory = $catagoey->account_catagory_id;
        $recievable_id = helper::test_input($_POST["reciptItemID"]);
        $payable_id = helper::test_input($_POST["rev_ID"]);
        $currency_id = helper::test_input($_POST["currency"]);
        $remarks = helper::test_input($_POST["details"]);
        $accountdetails = helper::test_input($_POST["accountdetails"]);

        $reg_date = $newdate;
        $currency_rate = $_POST["rate"];
        $approve = 0;
        $createby = $loged_user->customer_id;
        $company_id = $loged_user->company_id;
        $amount = $_POST["amount"];
        $reciptItemAmount = $_POST["reciptItemAmount"];
        $recipt_details = helper::test_input($_POST["reciptItemdetails"]);

        // Get Last Leadger ID of company
        $LastLID = $_POST["LID"];

        // Add single entery in leadger
        $banks->updatedLeadger([$recievable_id, $payable_id, $currency_id, $remarks, $reg_date, $currency_rate, $createby, $LastLID]);
        $tid = $banks->updateTransferMoney([$payable_id, $amount, $currency_id, $currency_rate, $LastLID, "Crediet"]);
        $banks->updateTransferMoney([$recievable_id, $reciptItemAmount, $currency_id, $currency_rate, $LastLID, "Debet"]);

        // get currency details
        $cdetails_data = $company->GetCurrencyDetails($currency_id);
        $cdetails = $cdetails_data->fetch(PDO::FETCH_OBJ);

        $ret = array('date' => $date, 'lid' => $LastLID, 'tid' => $tid, $tid, 'currency' => $cdetails->currency, 'amount' => $amount, 'details' => $remarks, 'pby' => $loged_user->fname . ' ' . $loged_user->lname);
        echo json_encode($ret);
    }

    // edite Payment
    if (isset($_POST["payment"])) {
        $catagory_id = $system->getCatagoryByName("revenue");
        $catagoey = $catagory_id->fetch(PDO::FETCH_OBJ);

        $date = $_POST["date"];
        $newdate = strtotime($date);

        $account_catagory = $catagoey->account_catagory_id;
        $recievable_id = helper::test_input($_POST["reciptItemID"]);
        $payable_id = helper::test_input($_POST["customer"]);
        $currency_id = helper::test_input($_POST["currency"]);
        $remarks = helper::test_input($_POST["details"]);
        $accountdetails = helper::test_input($_POST["accountdetails"]);

        $reg_date = $newdate;
        $currency_rate = $_POST["rate"];
        $approve = 0;
        $createby = $loged_user->customer_id;
        $company_id = $loged_user->company_id;
        $amount = $_POST["amount"];
        $reciptItemAmount = $_POST["reciptItemAmount"];
        $recipt_details = helper::test_input($_POST["reciptItemdetails"]);

        // Get Last Leadger ID of company
        $LastLID = $_POST["LID"];
        $banks->updatedLeadger([$recievable_id, $payable_id, $currency_id, $remarks, $reg_date, $currency_rate, $createby, $LastLID]);
        $tid = $banks->updateTransferMoney([$payable_id, $amount, $currency_id, $currency_rate, $LastLID, "Debet"]);
        $banks->updateTransferMoney([$recievable_id, $reciptItemAmount, $currency_id, $currency_rate, $LastLID, "Crediet"]);

        // get currency details
        $cdetails_data = $company->GetCurrencyDetails($currency_id);
        $cdetails = $cdetails_data->fetch(PDO::FETCH_OBJ);

        $ret = array('date' => $date, 'lid' => $LastLID, 'tid' => $tid, $tid, 'currency' => $cdetails->currency, 'amount' => $amount, 'details' => $remarks, 'pby' => $loged_user->fname . ' ' . $loged_user->lname);
        echo json_encode($ret);
    }

    // edite Payment
    if (isset($_POST["expense"])) {
        $catagory_id = $system->getCatagoryByName("revenue");
        $catagoey = $catagory_id->fetch(PDO::FETCH_OBJ);

        $date = $_POST["date"];
        $newdate = strtotime($date);

        $account_catagory = $catagoey->account_catagory_id;
        $recievable_id = helper::test_input($_POST["reciptItemID"]);
        $payable_id = helper::test_input($_POST["rev_ID"]);
        $currency_id = helper::test_input($_POST["currency"]);
        $remarks = helper::test_input($_POST["details"]);

        $reg_date = $newdate;
        $currency_rate = $_POST["rate"];
        $approve = 0;
        $createby = $loged_user->customer_id;
        $company_id = $loged_user->company_id;
        $amount = $_POST["amount"];
        $reciptItemAmount = $_POST["reciptItemAmount"];
        $details = $_POST["reciptItemdetails"];

        // Get Last Leadger ID of company
        $LastLID = $_POST["LID"];

        // Add single entery in leadger
        $banks->updatedLeadger([$recievable_id, $payable_id, $currency_id, $remarks, $reg_date, $currency_rate, $createby, $LastLID]);
        $tid = $banks->updateTransferMoney([$payable_id, $amount, $currency_id, $currency_rate, $LastLID, "Debet"]);
        $banks->updateTransferMoney([$recievable_id, $reciptItemAmount, $currency_id, $currency_rate, $LastLID, "Crediet"]);

        // get currency details
        $cdetails_data = $company->GetCurrencyDetails($currency_id);
        $cdetails = $cdetails_data->fetch(PDO::FETCH_OBJ);

        $ret = array('date' => $date, 'lid' => $LastLID, 'tid' => $tid, $tid, 'currency' => $cdetails->currency, 'amount' => $amount, 'details' => $remarks, 'pby' => $loged_user->fname . ' ' . $loged_user->lname);
        echo json_encode($ret);
    }

    // Edite Out Transfer
    if (isset($_POST["ot"])) {
        $loged_user = json_decode($_SESSION["bussiness_user"]);
        $company_id = $loged_user->company_id;

        $details = helper::test_input($_POST["details"]);
        $date = helper::test_input($_POST["date"]);
        $newdate = strtotime($date);
        $transfercode = helper::test_input($_POST["transfercode"]);
        $vouchercode = helper::test_input($_POST["vouchercode"]);
        $rsaraf_ID = helper::test_input($_POST["rsaraf_ID"]);
        $currency = helper::test_input($_POST["currency"]);
        $amount = helper::test_input($_POST["amount"]);
        $mycommission = helper::test_input($_POST["mycommission"]);
        $sarafcommission = helper::test_input($_POST["sarafcommission"]);

        // Daily Customer sender 
        $sender_phone = helper::test_input($_POST["sender_phone"]);
        $sender_fname = helper::test_input($_POST["sender_fname"]);
        $sender_lname = helper::test_input($_POST["sender_lname"]);
        $sender_Fathername = helper::test_input($_POST["sender_Fathername"]);
        $sender_nid = helper::test_input($_POST["sender_nid"]);
        $sender_details = helper::test_input($_POST["sender_details"]);
        $Daily_sender_id = $bussiness->updateDailyCustomerByPhone([$sender_fname, $sender_lname, $sender_Fathername, $sender_nid, $sender_details, $sender_phone, "Daily Customer"]);


        // Daily Customer receiver 
        $receiver_phone = helper::test_input($_POST["receiver_phone"]);
        $receiver_fname = helper::test_input($_POST["receiver_fname"]);
        $receiver_lname = helper::test_input($_POST["receiver_lname"]);
        $receiver_Fathername = helper::test_input($_POST["receiver_Fathername"]);
        $receiver_nid = helper::test_input($_POST["receiver_nid"]);
        $receiver_details = helper::test_input($_POST["receiver_details"]);
        $Daily_receiver_id = $bussiness->updateDailyCustomerByPhone([$receiver_fname, $receiver_lname, $receiver_Fathername, $receiver_nid, $receiver_details, $receiver_phone, "Daily Customer"]);

        // just add one payment method
        $paymentID = $_POST["reciptItemID"];
        $payment_amount = $_POST["reciptItemAmount"];
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

        // Get Last Leadger ID of company
        $LastLID = $_POST["LID"];

        $banks->updatedLeadger([$paymentID, $rsaraf_ID, $currency, $details, $newdate, $rate, $loged_user->user_id, $LastLID]);
        // Credit the required amount in Saraf`s account
        $tid = $banks->updateTransferMoneyINOUT([$rsaraf_ID, $amount, $currency, $rate, $LastLID, "Crediet", $amount]);
        $banks->updateTransferMoneyINOUT([$rsaraf_ID, $sarafcommission, $currency, $rate, $LastLID, "Crediet", $sarafcommission]);

        // Debit the required amount from Company Account
        $banks->updateTransferMoneyINOUT([$paymentID, $payment_amount, $currency, $rate, $LastLID, "Debet", $payment_amount]);
        $banks->updateTransferMoneyINOUT([$paymentID, $mycommission, $currency, $rate, $LastLID, "Debet", $mycommission]);
        $banks->updateTransferMoneyINOUT([$paymentID, $sarafcommission, $currency, $rate, $LastLID, "Debet", $sarafcommission]);

        // Add the transfer profit to Income out transfer account in chartofaccount
        $incomeTransfer_data = $banks->getAccountByName($loged_user->company_id, "Income out Transfer");
        $incomeTransfer = $incomeTransfer_data->fetch(PDO::FETCH_OBJ);
        $banks->updateTransferMoneyINOUT([$incomeTransfer->chartofaccount_id, $mycommission, $currency, $rate, $LastLID, "Crediet", $mycommission]);

        $saraf_cus_id_data = $banks->getCustomerByBank($rsaraf_ID);
        $saraf_cus_id_details = $saraf_cus_id_data->fetch(PDO::FETCH_OBJ);

        $transfer_ID = $transfer->updateOutTransfer([$loged_user->customer_id, $mycommission, $saraf_cus_id_details->customer_id, $sarafcommission, $amount, $currency, $newdate, $transfercode, $vouchercode, $details, $LastLID]);

        // get currency details
        $cdetails_data = $company->GetCurrencyDetails($currency);
        $cdetails = $cdetails_data->fetch(PDO::FETCH_OBJ);

        $address = "";
        if (isset($saraf_cus_id_details->office_address) || isset($saraf_cus_id_details->official_phone) || $saraf_cus_id_details->personal_phone) {
            $address = $saraf_cus_id_details->office_address . "," . $saraf_cus_id_details->official_phone . "," . $saraf_cus_id_details->personal_phone;
        }
        $ret = array('date' => $date, 'lid' => $LastLID, 'tid' => $transfer_ID, 'currency' => $cdetails->currency, 'amount' => $amount, 'details' => $details, 'pby' => $loged_user->fname . ' ' . $loged_user->lname, 'tcode' => $transfercode, 'address' => $address, 'from' => $saraf_cus_id_details->alies_name);
        echo json_encode($ret);
    }

    // Edite Out Transfer
    if (isset($_POST["in"])) {
        $loged_user = json_decode($_SESSION["bussiness_user"]);
        $company_id = $loged_user->company_id;

        $details = helper::test_input($_POST["details"]);
        $date = helper::test_input($_POST["date"]);
        $newdate = strtotime($date);
        $transfercode = helper::test_input($_POST["transfercode"]);
        $vouchercode = helper::test_input($_POST["vouchercode"]);
        $rsaraf_ID = helper::test_input($_POST["rsaraf_ID"]);
        $currency = helper::test_input($_POST["currency"]);
        $amount = helper::test_input($_POST["amount"]);
        $sarafcommission = helper::test_input($_POST["sarafcommission"]);

        // Daily Customer sender 
        $sender_phone = helper::test_input($_POST["sender_phone"]);
        $sender_fname = helper::test_input($_POST["sender_fname"]);
        $sender_lname = helper::test_input($_POST["sender_lname"]);
        $sender_Fathername = helper::test_input($_POST["sender_Fathername"]);
        $sender_nid = helper::test_input($_POST["sender_nid"]);
        $sender_details = helper::test_input($_POST["sender_details"]);
        $Daily_sender_id = $bussiness->updateDailyCustomerByPhone([$sender_fname, $sender_lname, $sender_Fathername, $sender_nid, $sender_details, $sender_phone, "Daily Customer"]);


        // Daily Customer receiver 
        $receiver_phone = helper::test_input($_POST["receiver_phone"]);
        $receiver_fname = helper::test_input($_POST["receiver_fname"]);
        $receiver_lname = helper::test_input($_POST["receiver_lname"]);
        $receiver_Fathername = helper::test_input($_POST["receiver_Fathername"]);
        $receiver_nid = helper::test_input($_POST["receiver_nid"]);
        $receiver_details = helper::test_input($_POST["receiver_details"]);
        $Daily_receiver_id = $bussiness->updateDailyCustomerByPhone([$receiver_fname, $receiver_lname, $receiver_Fathername, $receiver_nid, $receiver_details, $receiver_phone, "Daily Customer"]);

        // just add one payment method
        $paymentID = $_POST["reciptItemID"];
        $payment_amount = $_POST["reciptItemAmount"];
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

        // Get Last Leadger ID of company
        $LastLID = $_POST["LID"];

        $banks->updatedLeadger([$paymentID, $rsaraf_ID, $currency, $details, $newdate, $rate, $loged_user->user_id, $LastLID]);
        // Credit the required amount in Saraf`s account
        $tid = $banks->updateTransferMoneyINOUT([$rsaraf_ID, $amount, $currency, $rate, $LastLID, "Crediet", $amount]);
        $banks->updateTransferMoneyINOUT([$rsaraf_ID, $sarafcommission, $currency, $rate, $LastLID, "Crediet", $sarafcommission]);

        // Debit the required amount from Company Account
        $banks->updateTransferMoneyINOUT([$paymentID, $payment_amount, $currency, $rate, $LastLID, "Crediet", $payment_amount]);
        $banks->updateTransferMoneyINOUT([$rsaraf_ID, $payment_amount, $currency, $rate, $LastLID, "Debet", $payment_amount]);
        $banks->updateTransferMoneyINOUT([$rsaraf_ID, $sarafcommission, $currency, $rate, $LastLID, "Debet", $sarafcommission]);

        // Add the transfer profit to Income out transfer account in chartofaccount
        $incomeTransfer_data = $banks->getAccountByName($loged_user->company_id, "Income out Transfer");
        $incomeTransfer = $incomeTransfer_data->fetch(PDO::FETCH_OBJ);
        $banks->updateTransferMoneyINOUT([$incomeTransfer->chartofaccount_id, $sarafcommission, $currency, $rate, $LastLID, "Crediet", $sarafcommission]);

        $saraf_cus_id_data = $banks->getCustomerByBank($rsaraf_ID);
        $saraf_cus_id_details = $saraf_cus_id_data->fetch(PDO::FETCH_OBJ);

        $transfer_ID = $transfer->updateOutTransfer([$loged_user->customer_id, 0, $saraf_cus_id_details->customer_id, $sarafcommission, $amount, $currency, $newdate, $transfercode, $vouchercode, $details, $LastLID]);

        // get currency details
        $cdetails_data = $company->GetCurrencyDetails($currency);
        $cdetails = $cdetails_data->fetch(PDO::FETCH_OBJ);

        $address = "";
        if (isset($saraf_cus_id_details->office_address) || isset($saraf_cus_id_details->official_phone) || $saraf_cus_id_details->personal_phone) {
            $address = $saraf_cus_id_details->office_address . "," . $saraf_cus_id_details->official_phone . "," . $saraf_cus_id_details->personal_phone;
        }
        $ret = array('date' => $date, 'lid' => $LastLID, 'tid' => $transfer_ID, 'currency' => $cdetails->currency, 'amount' => $amount, 'details' => $details, 'pby' => $loged_user->fname . ' ' . $loged_user->lname, 'tcode' => $transfercode, 'address' => $address, 'from' => $saraf_cus_id_details->alies_name);
        echo json_encode($ret);
    }

    if (isset($_POST["ex"])) {
        $details = $_POST["details"];
        $date = strtotime($_POST["date"]);
        $currencyfrom = helper::test_input($_POST["currencyfrom"]);
        $currencyto = helper::test_input($_POST["exchangecurrencyto"]);
        $amount = helper::test_input($_POST["eamount"]);
        $bankfrom = helper::test_input($_POST["bankfromfrom"]);
        $bankto = helper::test_input($_POST["banktoto"]);
        $rate = helper::test_input($_POST["rate"]);

        // Get Last Leadger ID of company
        $LastLID = $_POST["LID"];

        // $banks->addExchangeLeadger($LastLID, $bankto, $bankfrom, $currencyfrom, $details, $term, time(), $rate, 0, $loged_user->user_id, 0, "Bank Exchange", $loged_user->company_id, 0, $currencyto);
        // $banks->addTransferMoney([$bankfrom, $LastLID, $amount, "Credit", $loged_user->company_id, $details, 0, $currencyfrom, $rate]);
        // $banks->addTransferMoney([$bankto, $LastLID, ($amount * $rate), "Debet", $loged_user->company_id, $details, 0, $currencyto, $rate]);

        // update leadger
        $banks->updatedLeadger([$bankto, $bankfrom, $currencyfrom, $details, $date, $rate, $loged_user->user_id, $LastLID]);
        $tid = $banks->updateTransferMoney([$bankfrom, $amount, $currencyfrom, $rate, $LastLID, "Crediet"]);
        $banks->updateTransferMoney([$bankto, ($amount * $rate), $currencyto, $rate, $LastLID, "Debet"]);

        echo "done";
    }

    if (isset($_POST["bt"])) {
        $details = $_POST["details"];
        $date = strtotime($_POST["date"]);
        $currencyfrom = helper::test_input($_POST["currencyfrom"]);
        $currencyto = helper::test_input($_POST["exchangecurrencyto"]);
        $amount = helper::test_input($_POST["eamount"]);
        $bankfrom = helper::test_input($_POST["bankfromfrom"]);
        $bankto = helper::test_input($_POST["banktoto"]);
        $rate = helper::test_input($_POST["rate"]);

        // Get Last Leadger ID of company
        $LastLID = $_POST["LID"];

        // $banks->addExchangeLeadger($LastLID, $bankto, $bankfrom, $currencyfrom, $details, $term, time(), $rate, 0, $loged_user->user_id, 0, "Bank Exchange", $loged_user->company_id, 0, $currencyto);
        // $banks->addTransferMoney([$bankfrom, $LastLID, $amount, "Credit", $loged_user->company_id, $details, 0, $currencyfrom, $rate]);
        // $banks->addTransferMoney([$bankto, $LastLID, ($amount * $rate), "Debet", $loged_user->company_id, $details, 0, $currencyto, $rate]);

        // update leadger
        $banks->updatedLeadger([$bankto, $bankfrom, $currencyfrom, $details, $date, $rate, $loged_user->user_id, $LastLID]);
        $tid = $banks->updateTransferMoney([$bankfrom, $amount, $currencyfrom, $rate, $LastLID, "Crediet"]);
        $banks->updateTransferMoney([$bankto, $amount, $currencyto, $rate, $LastLID, "Debet"]);

        echo "done";
    }
}