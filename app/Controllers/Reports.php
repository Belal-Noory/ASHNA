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

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    // login Reports
    if(isset($_GET["loginlogs"]))
    {
        $logs_data = $reports->getLoginReports($loged_user->company_id);
        $logs = $logs_data->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($logs);
    }

    // Activity Reports
    if(isset($_GET["activitylogs"]))
    {
        $logs_data = $reports->getActivityReports($loged_user->company_id);
        $logs = $logs_data->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($logs);
    }

    // Bank Reports
    if(isset($_GET["bankReports"]))
    {
        $logs_data = $reports->getBanksReports($loged_user->company_id);
        $logs = $logs_data->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($logs);
    }


    // Cash Register Reports
    if(isset($_GET["cashReports"]))
    {
        $logs_data = $reports->getCashRegisterReports($loged_user->company_id);
        $logs = $logs_data->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($logs);
    }

    // In Transfers Reports
    if(isset($_GET["InTransfers"]))
    {
        $logs_data = $reports->getInTransfersReports($loged_user->company_id);
        $logs = $logs_data->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($logs);
    }

    // In Transfers Reports
    if(isset($_GET["OutTransfers"]))
    {
        $logs_data = $reports->getOutTransfersReports($loged_user->company_id);
        $logs = $logs_data->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($logs);
    }
    
    // In Transfers Reports
    if(isset($_GET["exchangeTransaction"]))
    {
        $logs_data = $reports->getExchangeTransactionReports($loged_user->company_id);
        $logs = $logs_data->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($logs);
    }
}

?>