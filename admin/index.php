<?php
$base = $_SERVER['REQUEST_URI'];
$base = parse_url($base);
$parts = explode("/", $base['path']);
$path = $parts[1];

$res = helper::is_localhost();
if ($res == "local") {
    $home = "/" . $path;
} else {
    $home = "";
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
    <title>Admin Login</title>
    <link rel="apple-touch-icon" href="<?php echo $home ?>/business/app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $home ?>/business/app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CQuicksand:300,400,500,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo $home ?>/business/app-assets/vendors/css/vendors-rtl.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $home ?>/business/app-assets/vendors/css/forms/icheck/icheck.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $home ?>/business/app-assets/vendors/css/forms/icheck/custom.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo $home ?>/business/app-assets/css-rtl/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $home ?>/business/app-assets/css-rtl/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $home ?>/business/app-assets/css-rtl/colors.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $home ?>/business/app-assets/css-rtl/components.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $home ?>/business/app-assets/css-rtl/custom-rtl.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo $home ?>/business/app-assets/css-rtl/core/menu/menu-types/vertical-menu-modern.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $home ?>/business/app-assets/css-rtl/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $home ?>/business/app-assets/css-rtl/pages/login-register.css">
    <!-- END: Page CSS-->
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern 1-column  bg-full-screen-image blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column">
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <section class="row flexbox-container">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="col-lg-4 col-md-8 col-10 box-shadow-2 p-0">
                            <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
                                <div class="card-header border-0">
                                    <div class="card-title text-center">
                                        <img src="<?php echo $home ?>/business/app-assets/images/logo/ashna_trans.png" alt="branding logo" style="width: 120px;">
                                    </div>
                                </div>
                                <div class="card-content">
                                    <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1"><span>لطفآ معلومات خود را درج کنید</span></p>
                                    <div class="card-body">
                                        <form class="form-horizontal" action="../app/Controllers/SystemAdmin.php" method="POST">
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="email" class="form-control" id="email" name="email" placeholder="ایمیل ادرس" required>
                                                <div class="form-control-position">
                                                    <i class="la la-user"></i>
                                                </div>
                                            </fieldset>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="password" class="form-control" id="pass" name="pass" placeholder="رمز عبور" required>
                                                <div class="form-control-position">
                                                    <i class="la la-key"></i>
                                                </div>
                                            </fieldset>
                                            <input type="hidden" name="login">
                                            <button type="submit" class="btn btn-outline-info btn-block"><i class="ft-unlock"></i> ورود به سیستم </button>
                                        </form>

                                        <?php print_r($_SERVER['QUERY_STRING']); ?>
                                        <?php if (isset($_GET["notfound"]) || isset($_GET["loginFirst"])) { ?>
                                            <div class="alert bg-danger alert-icon-left alert-arrow-left alert-dismissible mt-2 mb-2" role="alert">
                                                <span class="alert-icon"><i class="la la-thumbs-o-down"></i></span>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                                <strong>لطفآ مشخصات درست را وارد کنید</strong>
                                            </div>
                                        <?php } ?>

                                        <?php if (isset($_GET["empty"])) { ?>
                                            <div class="alert bg-danger alert-icon-left alert-arrow-left alert-dismissible mt-2 mb-2" role="alert">
                                                <span class="alert-icon"><i class="la la-thumbs-o-down"></i></span>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                                <strong>لطفآ همه مشخصات را وارد کنید</strong>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
    <!-- END: Content-->


    <!-- BEGIN: Vendor JS-->
    <script src="<?php echo $home ?>/business/app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="<?php echo $home ?>/business/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"></script>
    <script src="<?php echo $home ?>/business/app-assets/vendors/js/forms/icheck/icheck.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="<?php echo $home ?>/business/app-assets/js/core/app-menu.js"></script>
    <script src="<?php echo $home ?>/business/app-assets/js/core/app.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="<?php echo $home ?>/business/app-assets/js/scripts/forms/form-login-register.js"></script>
    <!-- END: Page JS-->

</body>
<!-- END: Body-->

</html>