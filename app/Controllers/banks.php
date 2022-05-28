<?php
session_start();
require "../../init.php";
$loged_user = json_decode($_SESSION["bussiness_user"]);

$banks = new Banks();
$company = new Company();

$company_FT_data = $company->getCompanyActiveFT($loged_user->company_id);
$company_ft = $company_FT_data->fetch();

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

    // Add Transfer
    if(isset($_POST["addtransfer"]))
    {
        $date = $_POST["date"];
        $amount = helper::test_input($_POST["amount"]);
        $details = helper::test_input($_POST["details"]);
        $Currency = helper::test_input($_POST["Currency"]);
        $rate = helper::test_input($_POST["rate"]);

        // From Bank and Saif
        $bank_from = $_POST["bankfrom"];
        $saif_from = $_POST["saiffrom"];

        // To Bank and Saif
        $bank_to = $_POST["bankto"];
        $saif_to = $_POST["saifto"];

        if($bank_from == "NA" && $saif_from == "NA")
        {
            echo "Please select a source from which the transfer should be made";
        }
        else if($bank_to == "NA" && $saif_to == "NA")
        {
            echo "Please select a source to which the transfer should be made";
        }
        else if($bank_to != "NA" && $bank_to == $bank_from)
        {
            echo "Please select a different source to transfer";
        }
        else if($saif_to != "NA" && $saif_to == $saif_from)
        {
            echo "Please select a different source to transfer";
        }
        else if($Currency == "NA")
        {
            echo "please select currency";
        }else{
            $financial_term = 0;
            $bankfrom_id = 0;
            $bankto_id = 0;

            if($bank_from == "NA")
            {
                $bankfrom_id = $saif_from;
            }
            else{
                $bankfrom_id = $bank_from;
            }

            if($bank_to == "NA")
            {
                $bankto_id = $saif_to;
            }
            else{
                $bankto_id = $bank_to;
            }

            if(count($company_ft) > 0)
            {
                $financial_term = $company_ft["term_id"];
            }

            $res = $banks->addTransferLeadger([$bankto_id,$bankfrom_id,$Currency,$details,$financial_term,time(),$rate,1,$loged_user->user_id,0,'Bank Transfer']);
            if($res > 0)
            {
                $nammount = 0;
                if($rate > 0)
                {
                    $nammount = $amount * $rate;
                }
                else{
                    $nammount = $amount;
                }

                $banks->addTransferMoney([$bankfrom_id,$res,$amount,"Crediet"]);
                $banks->addTransferMoney([$bankto_id,$res,$nammount,"Debet"]);
                echo "done";
            }
            else{
                echo "Error while adding money to accounts";
            }
            
        }
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