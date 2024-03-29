<?php
session_start();
require "../../init.php";

if (!isset($_SESSION["bussiness_user"])) {
    header("location: index.php");
} else {
    $ctime = strtotime("now");
    $_SESSION['sessionX'] = $ctime;
}

function sessionX()
{
    $logLength = 900; # time in seconds :: 1800 = 30 minutes 
    $ctime = strtotime("now"); # Create a time from a string 
    # If no session time is created, create one 
    if (!isset($_SESSION['sessionX'])) {
        # create session time 
        $_SESSION['sessionX'] = $ctime;
    } else {
        # Check if they have exceded the time limit of inactivity 
        if (((strtotime("now") - $_SESSION['sessionX']) > $logLength) && isset($_SESSION["bussiness_user"])) {
            $company = new Company();
            # If exceded the time, log the user out 
            // Logged in user info
            $loged_user = json_decode($_SESSION["bussiness_user"]);
            // Add login logs
            $company->login_logs($loged_user->user_id, "logout");

            // Make user online
            $company->makeOnline($loged_user->user_id, 0);
            session_destroy();
            # Redirect to login page to log back in 
            header("Location: index.php");
            exit;
        } else {
            # If they have not exceded the time limit of inactivity, keep them logged in 
            $_SESSION['sessionX'] = $ctime;
        }
    }
}
# Run Session logout check 
sessionX();
// Company Object
$company = new Company();
$admin = new SystemAdmin();

// Logged in user info
$user_data = json_decode($_SESSION["bussiness_user"]);

$url = $curPageName = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);
if ($url !== "profitloss.php" && $url !== "balancesheet.php") {
    // check if current page is blocked for the user
    $current_page_data = $company->getCompanyModelDetails($url);
    if ($current_page_data->rowCount() > 0) {
        $current_page = $current_page_data->fetch(PDO::FETCH_OBJ);
        $res = $company->checkIfSubModelBlocked($user_data->user_id, $current_page->id);
        $res2 = $company->checkIfModelBlocked($user_data->user_id, $current_page->id);
        if ($res > 0 || $res2 > 0) {
            header("location:./dashboard.php");
        }
    }
}


// check company contract
$contact_check_data = $company->checkContract($user_data->company_id);
$contact_check = $contact_check_data->fetch(PDO::FETCH_OBJ);
$remind = time() - $contact_check->contract_end;
$day = round($remind / 86400);
$h = round($remind / 3600);
if ($h > 24) {
    $h -= 24;
    $day += 1;
}

if ($day > 0) {
    session_destroy();
    header("location:index.php?demo=expired");
}
// Load company models
$company_models_data = $company->getCompanyMainAllowedModel($user_data->company_id);
$company_models = $company_models_data->fetchAll(PDO::FETCH_OBJ);

$allcurrency_data = $company->GetCompanyCurrency($user_data->company_id);
$allcurrency = $allcurrency_data->fetchAll(PDO::FETCH_OBJ);
$mainCurrency = "";
$mainCurrencyID = "";

foreach ($allcurrency as $currency) {
    if ($currency->mainCurrency == 1) {
        $mainCurrency = $currency->currency;
        $mainCurrencyID = $currency->company_currency_id;
    }
}

// get company current financial term
$company_FT_data = $company->getCompanyActiveFT($user_data->company_id);
$company_ft = $company_FT_data->fetch(PDO::FETCH_OBJ);

$term_id = 0;
if ($company_FT_data->rowCount() > 0) {
    $term_id = $company_ft->term_id;
}

// get pending Transactions
$notifications_data = $admin->getPendingTransactions($user_data->company_id, $term_id);
$notifications = $notifications_data->fetchAll(PDO::FETCH_OBJ);

$notifications_count_data = $admin->getPendingTransactionsCount($user_data->company_id, $term_id);
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="ASHNA BABUR accounting software, expections in accounting">
    <meta name="keywords" content="ashna babur, ashna, ashna babur accounting system, accounting software, msp services, ashna msp">
    <meta name="author" content="Belal Noory">
    <title><?php echo $page_title; ?></title>
    <link rel="icon" href="../ashna.ico" />
    <link rel="apple-touch-icon" href="../app-assets/images/logo/ashna.png">
    <link rel="shortcut icon" type="image/x-icon" href="../app-assets/images/logo/ashna.png">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CQuicksand:300,400,500,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/css/material-vendors.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="../app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.css" />

    <link rel="stylesheet" type="text/css" href="../app-assets/css/plugins/loaders/loaders.min.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/fonts/simple-line-icons/style.min.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/css/cryptocoins/cryptocoins.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/pages/card-statistics.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/pages/single-page.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css-rtl/core/colors/palette-callout.css">
    <!-- END: Theme CSS-->


    <!-- BEGIN: Material Design-->
    <link rel="stylesheet" type="text/css" href="../app-assets/css/material.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/material-extended.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/material-colors.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/css/tables/datatable/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/datetime/1.1.2/css/dataTables.dateTime.min.css">
    <!-- END: Material Design -->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="../app-assets/css/core/menu/menu-types/horizontal-menu.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/plugins/calendars/clndr.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/plugins/forms/wizard.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <!-- END: Page CSS-->

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/chosen/1.1.0/chosen.min.css">

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <!-- END: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="../assets/confirm/css/jquery-confirm.css">
    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css">
    <link rel="stylesheet" href="../assets/style.css">
    <style>@page { size: A5 }</style>
    <style>
        /*PRELOADING------------ */
        #overlayer {
            width: 100%;
            height: 100%;
            position: fixed;
            z-index: 7100;
            background: #fff;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .loader {
            z-index: 7700;
            position: fixed;
            top: 50%;
            left: 50%;
            -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }

        /* print */
        .pheader {
            display: flex;
            flex-direction: column;
            text-align: center;
            border-bottom: 1px solid gray;
        }

        .pheader #section_info {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        .pheader #section_info #pheader_address {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .pbody {
            display: flex;
            flex-direction: column;
        }

        .pbody #printtitle {
            text-align: center;
        }

        .pbody #details div {
            width: 50%;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        .pbody #details div span {
            margin: 0px 10px;
            padding: 2px;
        }

        .pbody #details #amountDiv {
            border: 1px solid black;
            padding: 6px;
            justify-content: space-between;
            width: 50%;
            margin-bottom: 20px;
            margin-top: 20px;
        }

        .pbody #details #amountDiv span:first-child {
            border-right: 1px solid black;
        }

        .pbody #details #amountDiv span:last-child {
            border-left: 1px solid black;
        }

        .subdetails {
            width: 100%;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            margin: 4px 0px;
        }

        #subdetailslast div {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        #subdetailslast {
            margin-top: 60px;
        }


        #subdetailsfirst {
            border-top: 1px solid gray;
            padding-top: 8px;
        }

        .transfer {
            display: none;
        }

        .card-box {
            padding: 20px;
            border-radius: 3px;
            margin-bottom: 30px;
            background-color: #fff;
        }

        .file-man-box {
            padding: 20px;
            border: 1px solid #e3eaef;
            border-radius: 5px;
            position: relative;
            margin-bottom: 20px
        }

        .file-man-box .file-close {
            color: #f1556c;
            position: absolute;
            line-height: 24px;
            font-size: 24px;
            right: 10px;
            top: 10px;
            visibility: hidden
        }

        .file-man-box .file-img-box {
            line-height: 120px;
            text-align: center
        }

        .file-man-box .file-img-box img {
            height: 64px
        }

        .file-man-box .file-download {
            font-size: 32px;
            color: #98a6ad;
            position: absolute;
            right: 10px
        }

        .file-man-box .file-download:hover {
            color: #313a46
        }

        .file-man-box .file-man-title {
            padding-right: 25px
        }

        .file-man-box:hover {
            -webkit-box-shadow: 0 0 24px 0 rgba(0, 0, 0, .06), 0 1px 0 0 rgba(0, 0, 0, .02);
            box-shadow: 0 0 24px 0 rgba(0, 0, 0, .06), 0 1px 0 0 rgba(0, 0, 0, .02)
        }

        .file-man-box:hover .file-close {
            visibility: visible
        }

        .text-overflow {
            text-overflow: ellipsis;
            white-space: nowrap;
            display: block;
            width: 100%;
            overflow: hidden;
        }

        h5 {
            font-size: 15px;
        }

        #overlayimg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, .6);
            z-index: 5000;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #overlayimg #imgoverlay {
            width: 60%;
        }

        .exchangeContainer {
            position: fixed;
            bottom: 0;
            left: 0;
            margin-left: 10px;
            margin-bottom: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            width: fit-content;
            height: fit-content;
            z-index: 50000;
        }

        .exchangeContainer a {
            padding: 10xp;
            border-radius: 50%;
            height: 40px;
            width: 40px;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .exchangeContainer:hover a {
            transform: scale(1.07);
        }



        .fab-wrapper {
            position: fixed;
            bottom: 3rem;
            right: 3rem;
            z-index: 50000;
        }

        .fab-checkbox {
            display: none;
        }

        .fab {
            position: absolute;
            bottom: -1rem;
            right: -1rem;
            width: 4rem;
            height: 4rem;
            background: blue;
            border-radius: 50%;
            background: #126ee2;
            box-shadow: 0px 5px 20px #81a4f1;
            transition: all 0.3s ease;
            border-bottom-right-radius: 6px;
            border: 1px solid #0c50a7;
            z-index: 500000;
        }

        .fab:before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .fab-checkbox:checked~.fab:before {
            width: 90%;
            height: 90%;
            left: 5%;
            top: 5%;
            background-color: rgba(255, 255, 255, 0.2);
        }

        .fab:hover {
            background: #2c87e8;
            box-shadow: 0px 5px 20px 5px #81a4f1;
            cursor: pointer;
        }

        .fab-dots {
            position: absolute;
            height: 8px;
            width: 8px;
            background-color: white;
            border-radius: 50%;
            top: 50%;
            transform: translateX(0%) translateY(-50%) rotate(0deg);
            opacity: 1;
            animation: blink 3s ease infinite;
            transition: all 0.3s ease;
        }

        .fab-dots-1 {
            left: 15px;
            animation-delay: 0s;
        }

        .fab-dots-2 {
            left: 50%;
            transform: translateX(-50%) translateY(-50%);
            animation-delay: 0.4s;
        }

        .fab-dots-3 {
            right: 15px;
            animation-delay: 0.8s;
        }

        .fab-checkbox:checked~.fab .fab-dots {
            height: 6px;
        }

        .fab .fab-dots-2 {
            transform: translateX(-50%) translateY(-50%) rotate(0deg);
        }

        .fab-checkbox:checked~.fab .fab-dots-1 {
            width: 32px;
            border-radius: 10px;
            left: 50%;
            transform: translateX(-50%) translateY(-50%) rotate(45deg);
        }

        .fab-checkbox:checked~.fab .fab-dots-3 {
            width: 32px;
            border-radius: 10px;
            right: 50%;
            transform: translateX(50%) translateY(-50%) rotate(-45deg);
        }

        @keyframes blink {
            50% {
                opacity: 0.25;
            }
        }

        .fab-checkbox:checked~.fab .fab-dots {
            animation: none;
        }

        .fab-wheel {
            position: absolute;
            bottom: 0;
            right: 0;
            border: none;
            width: 10rem;
            height: 10rem;
            transition: all 0.3s ease;
            transform-origin: bottom right;
            transform: scale(0);
        }

        .fab-checkbox:checked~.fab-wheel {
            transform: scale(1);
        }

        .fab-action {
            position: absolute;
            background: #0f1941;
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: White;
            box-shadow: 0 0.1rem 1rem rgba(24, 66, 154, 0.82);
            transition: all 1s ease;
            opacity: 0;
        }

        .fab-checkbox:checked~.fab-wheel .fab-action {
            opacity: 1;
        }

        .fab-action:hover {
            background-color: dodgerblue;
        }

        .fab-action:hover i {
            transition:.5s ease-in-out;
            rotate: 360deg;
        }

        .fab-wheel .fab-action-1 {
            right: -1rem;
            top: 0;
        }

        .fab-wheel .fab-action-2 {
            right: 3.4rem;
            top: 0.5rem;
        }

        .fab-wheel .fab-action-3 {
            left: 0.5rem;
            bottom: 3.4rem;
        }

        .fab-wheel .fab-action-4 {
            left: 0;
            bottom: -1rem;
        }
    </style>
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
<body class="horizontal-layout horizontal-menu 2-columns" data-open="hover" data-menu="horizontal-menu" data-col="2-columns" id="mainC" data-href="<?php echo $mainCurrency; ?>">
    <div id="overlayimg">
        <img src="" alt="" id="imgoverlay" />
    </div>
    <div class="bs-callout-pink callout-bordered mt-1 mainerror d-none" style="width:fit-content;position: fixed; top: 10vh; right: 10px;z-index: 1000;">
        <div class="media align-items-stretch">
            <div class="media-body p-1">
                <strong>خطا!!</strong>
                <p>فقد فایل های JPG و PDF را میتوانید اپلود کنید.</p>
            </div>
            <div class="media-right media-middle bg-pink d-flex align-items-center p-2">
                <i class="la la-exclamation white font-medium-5"></i>
            </div>
        </div>
    </div>
    <div id="overlayer"></div>
    <div class="loader">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">در حال بارگیری...</span>
        </div>
    </div>
    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow navbar-static-top navbar-light navbar-brand-center">
        <div class="navbar-wrapper">
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item mobile-menu d-md-none mr-auto">
                        <a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#">
                            <i class="ft-menu font-large-1"></i>
                        </a>
                    </li>
                    <li class="nav-item d-md-none">
                        <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile">
                            <i class="la la-ellipsis-v"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="navbar-container content">
                <div class="collapse navbar-collapse" id="navbar-mobile">
                    <ul class="nav navbar-nav mr-auto float-left">
                        <li class="nav-item d-none d-md-block">
                            <a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#">
                                <i class="ft-menu"></i>
                            </a>
                        </li>
                        <li class="nav-item d-none d-lg-block">
                            <a class="nav-link nav-link-expand" href="#">
                                <i class="ficon ft-maximize"></i>
                            </a>
                        </li>
                        <li class="dropdown nav-item mega-dropdown d-none d-lg-block">
                            <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
                                آشنا
                            </a>
                            <ul class="mega-dropdown-menu dropdown-menu row p-1">
                                <li class="col-md-4 bg-mega p-2">
                                    <h3 class="text-white mb-1 font-weight-bold">ASHNA Accounting Software</h3>
                                    <p class="text-white line-height-2">
                                        The most complete and accurate accounting software for financial and accounting management.
                                        please visit our youtube channel to learn more.
                                    </p>
                                    <button class="btn btn-outline-white">Learn More</button>
                                </li>
                                <li class="col-md-5 px-2">
                                    <h6 class="font-weight-bold font-medium-2 ml-1">Software Features</h6>
                                    <ul class="row mt-2">
                                        <li class="col-6 col-xl-4">
                                            <a class="text-center mb-2 mb-xl-3" href="#">
                                                <i class="la la-users font-large-1 mr-0"></i>
                                                <p class="font-medium-2 mt-25 mb-0">Customers Management</p>
                                            </a>
                                        </li>
                                        <li class="col-6 col-xl-4">
                                            <a class="text-center mb-2 mb-xl-3 mt-75 mt-xl-0" href="#">
                                                <i class="la la-stethoscope font-large-1 mr-0"></i>
                                                <p class="font-medium-2 mt-25 mb-0">Service Management</p>
                                            </a>
                                        </li>
                                        <li class="col-6 col-xl-4">
                                            <a class="text-center mb-2 mt-75 mt-xl-0" href="#">
                                                <i class="la la-bank font-large-1 mr-0"></i>
                                                <p class="font-medium-2 mt-25 mb-50">Banking</p>
                                            </a>
                                        </li>
                                        <li class="col-6 col-xl-4">
                                            <a class="text-center mb-2 mt-75 mt-xl-0" href="#">
                                                <i class="la la-tag font-large-1 mr-0"></i>
                                                <p class="font-medium-2 mt-25 mb-50">Sales & Revenue Management</p>
                                            </a>
                                        </li>
                                        <li class="col-6 col-xl-4">
                                            <a class="text-center mb-2 mt-75 mt-xl-0" href="#">
                                                <i class="la la-table font-large-1 mr-0"></i>
                                                <p class="font-medium-2 mt-25 mb-50">All Kinds of Reports</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item nav-search">
                            <a class="nav-link nav-link-search" href="#">
                                <i class="ficon ft-search"></i>
                            </a>
                            <div class="search-input">
                                <input class="input" type="text" placeholder="جستجو..." tabindex="0" data-search="template-list">
                                <div class="search-input-close"><i class="ft-x"></i></div>
                                <ul class="search-list"></ul>
                            </div>
                        </li>
                        <li class="nav-item d-lg-block">
                            <div class="mt-1 alert alert-icon-left alert-danger alert-dismissible mb-2 contract" role="alert">
                                <span class="alert-icon"><i class="la la-thumbs-o-up"></i></span>
                                ختم قرار داد بعد از <strong><?php echo str_replace("-", "", $day); ?></strong> <?php if ($day == 1 || $day == -1) {
                                                                                                                    echo "روز";
                                                                                                                } else {
                                                                                                                    echo "روز";
                                                                                                                } ?>.
                            </div>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav float-right">
                        <li class="dropdown dropdown-language nav-item">
                            <a class="dropdown-toggle nav-link" id="dropdown-flag" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="ficon ft-globe"></i>
                                <span class="selected-language"></span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdown-flag">
                                <a class="dropdown-item" href="dashboard.php" data-language="en">
                                    <!-- <i class="flag-icon flag-icon-us"></i>  -->
                                    انگلیسی
                                </a>
                                <a class="dropdown-item" href="persian/dashboard.php" data-language="fr">
                                    <!-- <i class="flag-icon flag-icon-af"></i>  -->
                                    فارسی
                                </a>
                                <a class="dropdown-item" href="pashto/dashboard.php" data-language="pt">
                                    <!-- <i class="flag-icon flag-icon-af"></i>  -->
                                    پشتو
                                </a>
                            </div>
                        </li>
                        <li class="dropdown dropdown-notification nav-item">
                            <a class="nav-link nav-link-label" href="#" data-toggle="dropdown">
                                <i class="ficon ft-bell"></i>
                                <span class="badge badge-pill badge-danger badge-up badge-glow" id="totalNotifi"><?php echo $notifications_count_data->rowCount(); ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right height-400 vertical-scroll" id="notifications">
                                <li class='dropdown-menu-header'>
                                    <h6 class='dropdown-header m-0'>
                                        <span class='grey darken-2'>معاملات معلق</span>
                                    </h6>
                                    <span class="notification-tag badge badge-danger float-right m-0">همه</span>
                                </li>
                                <?php
                                $prev = "";
                                if ($notifications_data->rowCount() > 0) {
                                    foreach ($notifications as $notify) {
                                        $time = helper::changeTimestape($notify->reg_date);
                                        if ($notify->leadger_id !== $prev) {
                                            echo "<li class='media-list w-100 notification'>
                                                            <a href='javascript:void(0)'>
                                                                <div class='media'>
                                                                    <div class='media-left align-self-center'>
                                                                        <i class='la la-eye icon-bg-circle bg-cyan mr-0 btnshowpendingtransactionmodel' data-href='$notify->leadger_id'></i>
                                                                    </div>
                                                                    <div class='media-body'>
                                                                        <h6 class='media-heading'>$notify->op_type: Leadger $notify->leadger_id</h6>
                                                                        <p class='notification-text font-small-3 text-muted'>$notify->remarks</p><small>
                                                                        <time class='media-meta text-muted' datetime='2015-06-11T18:29:20+08:00'>$time</time></small>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </li>";
                                        }
                                        $prev = $notify->leadger_id;
                                    }
                                } else {
                                    echo "<li class='media-list w-100' id='noNotification'>
                                                        <a href='javascript:void(0)'>
                                                            <div class='media'>
                                                                <div class='media-left align-self-center'>
                                                                    <i class='ft-times-square icon-bg-circle bg-cyan mr-0'></i>
                                                                </div>
                                                                <div class='media-body'>
                                                                    <h6 class='media-heading'>No New Notification</h6>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>";
                                }
                                ?>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-user nav-item">
                            <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                <span class="mr-1 user-name text-bold-700"><?php echo $user_data->fname . " " . $user_data->lname; ?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="profile.php"><i class="ft-user"></i> ویرایش پروفایل</a>
                                <!-- <a class="dropdown-item" href="#"><i class="ft-check-square"></i> Task</a> -->
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" id="btnbusinesslogout">
                                    <i class="ft-power"></i> خارج شدن
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- END: Header-->

    <!-- BEGIN: Main Menu-->
    <div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-dark navbar-without-dd-arrow navbar-shadow" role="navigation" data-menu="menu-wrapper" dir="rtl">
        <div class="navbar-container main-menu-content" data-menu="menu-container">
            <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="nav-item <?php echo $Active_nav_name["parent"] == "Dashboard" ? "active" : ""; ?>">
                    <a class="nav-link setMenuActive" href="dashboard.php">
                        <i class="la la-bank"></i>
                        <span>صفحه عمومی</span></a>
                </li>
                <?php
                foreach ($company_models as $model) {
                    $isBlocked = $company->checkIfModelBlocked($user_data->user_id, $model->id);
                    if ($isBlocked <= 0) {
                ?>
                        <li class="dropdown nav-item <?php echo $Active_nav_name["parent"] == $model->name_dari ? "active" : ""; ?>" data-menu="dropdown">
                            <a class="dropdown-toggle nav-link" href="<?php echo $model->url; ?>" data-toggle="dropdown">
                                <i class="la <?php echo $model->icon; ?>"></i><span data-i18n="Accounts"><?php echo $model->name_dari; ?></span>
                            </a>
                            <?php
                            $subModel_data = $company->getCompanySubAllowedModel($model->id);
                            if ($subModel_data->rowCount() > 0) {
                                $subModel = $subModel_data->fetchAll(PDO::FETCH_OBJ);
                            ?>
                                <ul class="dropdown-menu">
                                    <?php
                                    foreach ($subModel as $smodel) {
                                        $isSubBlocked = $company->checkIfSubModelBlocked($user_data->user_id, $smodel->id);
                                        if ($isSubBlocked <= 0) {
                                    ?>
                                            <li data-menu="" class="<?php echo $Active_nav_name["child"] == $smodel->name_dari ? "active" : ""; ?>">
                                                <a class="dropdown-item" href="<?php echo $smodel->url; ?>" data-toggle="">
                                                    <span data-i18n="Add New"><?php echo $smodel->name_dari; ?></span>
                                                </a>
                                            </li>

                                    <?php }
                                    } ?>
                                </ul>
                            <?php } ?>
                        </li>
                <?php }
                }
                ?>
            </ul>
        </div>
    </div>

    <!-- Action button -->
    <div class="fab-wrapper">
        <input id="fabCheckbox" type="checkbox" class="fab-checkbox" />
        <label class="fab" for="fabCheckbox">
            <span class="fab-dots fab-dots-1"></span>
            <span class="fab-dots fab-dots-2"></span>
            <span class="fab-dots fab-dots-3"></span>
        </label>
        <div class="fab-wheel">
            <a class="fab-action fab-action-1" id="generalExchange">
                <i class="la la-exchange" style="color: white;"></i>
            </a>
            <a class="fab-action fab-action-2" id="generalMoneyExchange">
                <i class="la la-money" style="color: white;"></i>
            </a>
            <!-- <a class="fab-action fab-action-3">
                <i class="fas fa-address-book"></i>
            </a>
            <a class="fab-action fab-action-4">
                <i class="fas fa-info"></i>
            </a> -->
        </div>
    </div>