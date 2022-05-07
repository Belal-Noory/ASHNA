<?php

use function PHPSTORM_META\type;

    session_start();
    if(!isset($_SESSION["sys_admin"]))
    {
        header("location: ../index.php?loginFirst=true");
        exit();
    }
    else{
        $admin_info = json_decode($_SESSION["sys_admin"]);
    }
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="rtl">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Modern admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities with bitcoin dashboard.">
    <meta name="keywords" content="admin template, modern admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
    <meta name="author" content="PIXINVENT">
    <title>Admin Dashboard</title>
    <link rel="apple-touch-icon" href="../app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="../app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CQuicksand:300,400,500,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/css/vendors-rtl.min.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/fonts/meteocons/style.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/pickers/daterange/daterangepicker.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="../app-assets/css-rtl/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css-rtl/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css-rtl/colors.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css-rtl/components.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css-rtl/custom-rtl.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="../app-assets/css-rtl/core/menu/menu-types/vertical-menu-modern.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css-rtl/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/fonts/simple-line-icons/style.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css-rtl/pages/dashboard-ecommerce.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css-rtl/plugins/forms/wizard.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css-rtl/plugins/pickers/daterange/daterange.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="../assets/css/style-rtl.css">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern 2-columns   fixed-navbar" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">

    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-dark navbar-shadow">
        <div class="navbar-wrapper">
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item mobile-menu d-lg-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
                    <li class="nav-item mr-auto">
                        <a class="navbar-brand" href="index.html">
                            <img class="brand-logo" alt="modern admin logo" src="../app-assets/images/logo/logo.png">
                            <h3 class="brand-text">ASHNA</h3>
                        </a></li>
                    <li class="nav-item d-none d-lg-block nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="toggle-icon ft-toggle-right font-medium-3 white" data-ticon="ft-toggle-right"></i></a></li>
                    <li class="nav-item d-lg-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a></li>
                </ul>
            </div>
            <div class="navbar-container content">
                <div class="collapse navbar-collapse" id="navbar-mobile">
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
                                    <i class="flag-icon flag-icon-fr"></i> French
                                </a>
                                <a class="dropdown-item" href="#" data-language="pt">
                                    <i class="flag-icon flag-icon-pt"></i> Portuguese
                                </a>
                        </li>
                        <li class="dropdown dropdown-user nav-item">
                            <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                <span class="mr-1 user-name text-bold-700"><?php echo $admin_info->fname." ".$admin_info->lname;?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" id="btnlogout">
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


    <!-- Menue Start-->
    <div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <?php 
                    foreach($menu as $m)
                    {
                ?>
                    <li class="<?php echo $m["status"]; ?>">
                        <a href="<?php echo $m["url"]; ?>">
                            <i class="las <?php echo $m["icon"]; ?>"></i>
                            <span class="menu-title" data-i18n="eCommerce Dashboard"><?php echo $m["name"]; ?></span>
                        </a>
                    </li>
                <?php 
            }?>
                
            </ul>
        </div>
    </div>
    <!-- Menue End-->

