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
}

?>