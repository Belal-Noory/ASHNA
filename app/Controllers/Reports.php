<?php
session_start();
require "../../init.php";

if (isset($_SESSION["bussiness_user"])) {
    $loged_user = json_decode($_SESSION["bussiness_user"]);
}

$company = new Company();
$reports = new Reports();

$company_FT_data = $company->getCompanyActiveFT($loged_user->company_id);
$company_ft = $company_FT_data->fetch();

function recurSearch2($c, $parentID)
{
    $data = [];
    $conn = new Connection();
    $query = "SELECT * FROM account_catagory 
    LEFT JOIN chartofaccount ON chartofaccount.account_catagory = account_catagory.account_catagory_id 
    LEFT JOIN general_leadger ON general_leadger.recievable_id = chartofaccount.chartofaccount_id OR general_leadger.payable_id = chartofaccount.chartofaccount_id
    LEFT JOIN account_money ON account_money.leadger_ID = general_leadger.leadger_id 
    WHERE account_catagory.parentID = ? AND account_catagory.company_id = ?";
    $result = $conn->Query($query, [$parentID, $c]);
    $results = $result->fetchAll(PDO::FETCH_OBJ);
    foreach ($results as $item) {
        if (checkChilds($item->account_catagory_id, $c) > 0) {
            array_push($data, ["parent" => $item, "child" => recurSearch2($c, $item->account_catagory_id)]);
        } else {
            array_push($data, $item);
        }
    }
    return $data;
}

function checkChilds($patne, $company)
{
    $conn = new Connection();
    $query = "SELECT * FROM account_catagory WHERE parentID = ? AND company_id = ?";
    $result = $conn->Query($query, [$patne, $company]);
    $results = $result->rowCount();
    return $results;
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    // login Reports
    if (isset($_GET["loginlogs"])) {
        $logs_data = $reports->getLoginReports($loged_user->company_id);
        $logs = $logs_data->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($logs);
    }

    // Activity Reports
    if (isset($_GET["activitylogs"])) {
        $logs_data = $reports->getActivityReports($loged_user->company_id);
        $logs = $logs_data->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($logs);
    }

    // Bank Reports
    if (isset($_GET["bankReports"])) {
        $logs_data = $reports->getBanksReports($loged_user->company_id);
        $logs = $logs_data->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($logs);
    }

    // Cash Register Reports
    if (isset($_GET["cashReports"])) {
        $logs_data = $reports->getCashRegisterReports($loged_user->company_id);
        $logs = $logs_data->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($logs);
    }

    // In Transfers Reports
    if (isset($_GET["InTransfers"])) {
        $logs_data = $reports->getInTransfersReports($loged_user->company_id);
        $logs = $logs_data->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($logs);
    }

    // In Transfers Reports
    if (isset($_GET["OutTransfers"])) {
        $logs_data = $reports->getOutTransfersReports($loged_user->company_id);
        $logs = $logs_data->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($logs);
    }

    // In Transfers Reports
    if (isset($_GET["exchangeTransaction"])) {
        $logs_data = $reports->getExchangeTransactionReports($loged_user->company_id);
        $logs = $logs_data->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($logs);
    }

    // balance sheet
    if (isset($_GET["balancesheet"])) {
        $data = [];
        $conn = new Connection();
        $query = "SELECT * FROM account_catagory 
        LEFT JOIN chartofaccount ON chartofaccount.account_catagory = account_catagory.account_catagory_id 
        LEFT JOIN general_leadger ON general_leadger.recievable_id = chartofaccount.chartofaccount_id OR general_leadger.payable_id = chartofaccount.chartofaccount_id
        LEFT JOIN account_money ON account_money.leadger_ID = general_leadger.leadger_id 
        WHERE account_catagory.catagory IN (?,?,?) AND account_catagory.company_id = ?";
        $result = $conn->Query($query, ["Assets", "Liabilities", "Equity", $loged_user->company_id]);
        $results = $result->fetchAll(PDO::FETCH_OBJ);
        foreach ($results as $item) {
            if (checkChilds($item->account_catagory_id, $loged_user->company_id) > 0) {
                array_push($data, ["parent" => $item, "child" => recurSearch2($loged_user->company_id, $item->account_catagory_id)]);
            } else {
                array_push($data, $item);
            }
        }
        echo json_encode($data);
    }
}
