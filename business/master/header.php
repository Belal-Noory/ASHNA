<?php
session_start();
require "../init.php";

if (!isset($_SESSION["bussiness_user"])) {
    header("location: index.php");
}

// Company Object
$company = new Company();

// Logged in user info
$user_data = json_decode($_SESSION["bussiness_user"]);

// Load company models
$company_models_data = $company->getCompanyMainAllowedModel($user_data->company_id);
$company_models = $company_models_data->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Modern admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities with bitcoin dashboard.">
    <meta name="keywords" content="admin template, modern admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
    <meta name="author" content="PIXINVENT">
    <title><?php echo $page_title; ?></title>
    <link rel="apple-touch-icon" href="./app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="./app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CQuicksand:300,400,500,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="./app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="./app-assets/vendors/css/material-vendors.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="./app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="./app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.css" />

    <link rel="stylesheet" type="text/css" href="./app-assets/css/plugins/loaders/loaders.min.css">
    <link rel="stylesheet" type="text/css" href="./app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="./app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="./app-assets/fonts/simple-line-icons/style.min.css">
    <link rel="stylesheet" type="text/css" href="./app-assets/vendors/css/cryptocoins/cryptocoins.css">
    <link rel="stylesheet" type="text/css" href="./app-assets/css/pages/card-statistics.css">
    <link rel="stylesheet" type="text/css" href="./app-assets/css/pages/single-page.css">
    <!-- END: Theme CSS-->


    <!-- BEGIN: Material Design-->
    <link rel="stylesheet" type="text/css" href="./app-assets/css/material.css">
    <link rel="stylesheet" type="text/css" href="./app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="./app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="./app-assets/css/material-extended.css">
    <link rel="stylesheet" type="text/css" href="./app-assets/css/material-colors.css">
    <!-- END: Material Design -->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="./app-assets/css/core/menu/menu-types/horizontal-menu.css">
    <link rel="stylesheet" type="text/css" href="./app-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="./app-assets/css/plugins/calendars/clndr.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/plugins/forms/wizard.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <!-- END: Page CSS-->

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/chosen/1.1.0/chosen.min.css">

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="./assets/css/style.css">
    <!-- END: Custom CSS-->

    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="horizontal-layout horizontal-menu 2-columns  " data-open="hover" data-menu="horizontal-menu" data-col="2-columns">

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
                                ASHNA
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
                                        <li class="col-6 col-xl-4"><a class="text-center mb-2 mb-xl-3" href="#">
                                                <i class="la la-la-shopping-cart font-large-1 mr-0"></i>
                                                <p class="font-medium-2 mt-25 mb-0">Product Management</p>
                                            </a></li>
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
                                <input class="input" type="text" placeholder="Search..." tabindex="0" data-search="template-list">
                                <div class="search-input-close"><i class="ft-x"></i></div>
                                <ul class="search-list"></ul>
                            </div>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav float-right">
                        <li class="dropdown dropdown-language nav-item">
                            <a class="dropdown-toggle nav-link" id="dropdown-flag" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="flag-icon flag-icon-gb"></i>
                                <span class="selected-language"></span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdown-flag">
                                <a class="dropdown-item" href="#" data-language="en">
                                    <i class="flag-icon flag-icon-us"></i> English
                                </a>
                                <a class="dropdown-item" href="#" data-language="fr">
                                    <i class="flag-icon flag-icon-af"></i> Persian
                                </a>
                                <a class="dropdown-item" href="#" data-language="pt">
                                    <i class="flag-icon flag-icon-af"></i> Pashto
                                </a>
                            </div>
                        </li>
                        <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon ft-bell"></i><span class="badge badge-pill badge-danger badge-up badge-glow">5</span></a>
                            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                <li class="dropdown-menu-header">
                                    <h6 class="dropdown-header m-0">
                                        <span class="grey darken-2">Notifications</span>
                                    </h6>
                                    <span class="notification-tag badge badge-danger float-right m-0">5 New</span>
                                </li>
                                <li class="scrollable-container media-list w-100">
                                    <a href="javascript:void(0)">
                                        <div class="media">
                                            <div class="media-left align-self-center"><i class="ft-plus-square icon-bg-circle bg-cyan mr-0"></i></div>
                                            <div class="media-body">
                                                <h6 class="media-heading">You have new order!</h6>
                                                <p class="notification-text font-small-3 text-muted">Lorem ipsum dolor sit amet, consectetuer elit.</p><small>
                                                    <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">30 minutes ago</time></small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center" href="javascript:void(0)">Read all notifications</a></li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-notification nav-item">
                            <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon ft-mail"></i></a>
                            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                <li class="dropdown-menu-header">
                                    <h6 class="dropdown-header m-0"><span class="grey darken-2">Messages</span></h6><span class="notification-tag badge badge-warning float-right m-0">4 New</span>
                                </li>
                                <li class="scrollable-container media-list w-100"><a href="javascript:void(0)">
                                        <div class="media">
                                            <div class="media-left"><span class="avatar avatar-sm avatar-online rounded-circle"><img src="./app-assets/images/portrait/small/avatar-s-19.png" alt="avatar"><i></i></span></div>
                                            <div class="media-body">
                                                <h6 class="media-heading">Margaret Govan</h6>
                                                <p class="notification-text font-small-3 text-muted">I like your portfolio, let's start.</p><small>
                                                    <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Today</time></small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center" href="javascript:void(0)">Read all messages</a></li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-user nav-item">
                            <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                <span class="mr-1 user-name text-bold-700"><?php echo $user_data->fname . " " . $user_data->lname; ?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#"><i class="ft-user"></i> Edit Profile</a>
                                <a class="dropdown-item" href="#"><i class="ft-check-square"></i> Task</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" id="btnbusinesslogout">
                                    <i class="ft-power"></i> Logout
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

    <div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-dark navbar-without-dd-arrow navbar-shadow" role="navigation" data-menu="menu-wrapper">
        <div class="navbar-container main-menu-content" data-menu="menu-container">
            <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="nav-item <?php echo $Active_nav_name["parent"] == "Dashboard" ? "active" : ""; ?>">
                    <a class="nav-link setMenuActive" href="dashboard.php">
                        <i class="la la-bank"></i>
                        <span>Dashboard</span></a>
                </li>
                <?php
                foreach ($company_models as $model) {
                ?>
                    <li class="dropdown nav-item <?php echo $Active_nav_name["parent"] == $model->name_english ? "active" : ""; ?>" data-menu="dropdown">
                        <a class="dropdown-toggle nav-link" href="<?php echo $model->url; ?>" data-toggle="dropdown">
                            <i class="la <?php echo $model->icon; ?>"></i><span data-i18n="Accounts"><?php echo $model->name_english; ?></span>
                        </a>
                        <?php
                        $subModel_data = $company->getCompanySubAllowedModel($model->id);
                        if ($subModel_data->rowCount() > 0) {
                            $subModel = $subModel_data->fetchAll(PDO::FETCH_OBJ);
                        ?>
                            <ul class="dropdown-menu">
                                <?php
                                foreach ($subModel as $smodel) {
                                ?>
                                    <li data-menu="" class="<?php echo $Active_nav_name["child"] == $smodel->name_english ? "active" : ""; ?>">
                                        <a class="dropdown-item" href="<?php echo $smodel->url; ?>" data-toggle="">
                                            <span data-i18n="Add New"><?php echo $smodel->name_english; ?></span>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>