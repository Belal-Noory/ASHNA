<?php
session_start();
if (isset($_SESSION["bussiness_user"])) {
    header("location: dashboard.php");
}
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="ASHNA BABUR accounting software, expections in accounting">
    <meta name="keywords" content="ashna babur, ashna, ashna babur accounting system, accounting software, msp services, ashna msp">
    <meta name="author" content="Belal Noory">
    <title>ASHNA | Login</title>
    <link rel="icon" href="../ashna.ico" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CQuicksand:300,400,500,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/css/forms/icheck/icheck.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/css/forms/icheck/custom.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="../app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/components.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="../app-assets/css/core/menu/menu-types/horizontal-menu.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/pages/login-register.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <!-- END: Custom CSS-->
    <style>
        .continer-login{
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
    </style>
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="horizontal-layout horizontal-menu 1-column  bg-full-screen-image blank-page" data-open="hover" data-menu="horizontal-menu" data-col="1-column">
    <section class="continer-login">
        <div class="card border-grey border-lighten-3 px-1 py-1 m-0 col-lg-4 col-md-10">
            <div class="card-header border-0">
                <div class="card-title text-center">
                    <img src="../app-assets/images/logo/ashna_trans.png" style="width: 120px;" alt="branding logo">
                </div>
            </div>
            <div class="card-content">
                <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1"><span>مشخصات اکونت</span></p>
                <div class="card-body">
                    <form class="form-horizontal" id="businessLoginForm">
                        <fieldset class="form-group position-relative has-icon-left">
                            <input type="text" class="form-control required" id="username" name="username" placeholder="Your Username" required>
                            <div class="form-control-position">
                                <i class="la la-user"></i>
                            </div>
                        </fieldset>
                        <fieldset class="form-group position-relative has-icon-left">
                            <input type="password" class="form-control required" id="password" name="password" placeholder="Enter Password" required>
                            <div class="form-control-position">
                                <i class="la la-key"></i>
                            </div>
                        </fieldset>
                        <input type="hidden" name="bussinessLogin" value="true">
                        <button type="button" class="btn btn-outline-info btn-block" id="btnloginbusiness">
                            <i class="ft-unlock"></i> وارد شدن</button>
                        <div class="text-center spiner d-none"><i class="la la-spinner spinner blue" style="font-size: 30px;"></i></div>
                    </form>
                    <div class="alert mt-2"></div>

                    <?php if (isset($_GET["demo"])) { ?>
                        <div class="bs-callout-pink mt-1">
                            <div class="media align-items-stretch">
                                <div class="media-body p-1">
                                    <strong>Contract Ended</strong>
                                    <p>Your company contract has ended, please renew your company contract.</p>
                                    <p>Tank you for using our services ;).</p>
                                </div>
                                <div class="media-right media-middle bg-pink d-flex align-items-center p-2">
                                    <i class="la la-slack white font-medium-5"></i>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <!-- END: Content-->


    <!-- BEGIN: Vendor JS-->
    <script src="../app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="../app-assets/vendors/js/ui/jquery.sticky.js"></script>
    <script src="../app-assets/vendors/js/charts/jquery.sparkline.min.js"></script>
    <script src="../app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"></script>
    <script src="../app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
    <script src="../app-assets/vendors/js/forms/icheck/icheck.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="../app-assets/js/core/app-menu.js"></script>
    <script src="../app-assets/js/core/app.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="../app-assets/js/scripts/ui/breadcrumbs-with-stats.js"></script>
    <script src="../app-assets/js/scripts/forms/form-login-register.js"></script>
    <!-- END: Page JS-->

</body>
<!-- END: Body-->
<script>
    $(document).ready(function() {

        // Remove all alerts after 500 milli seconds
        setInterval(() => {
            $(".alert").removeClass("d-none");
        }, 3000);

        $("#btnloginbusiness").on("click", function() {

            if ($("#businessLoginForm").valid()) {
                $(this).fadeOut();
                ths = $(this);
                $(".spiner").removeClass("d-none");
                $.post("../../app/Controllers/Company.php", $("#businessLoginForm").serialize(), (data) => {
                    console.log(data);
                    // User is not registered yet.
                    if (data == "Notregisterd") {
                        $(".alert").addClass("alert-danger");
                        $(".alert").text("Not registered yet, please create an account first");
                        $(".alert").removeClass("d-none");

                        $(ths).fadeIn();
                        $(".spiner").addClass("d-none");
                    }

                    // If company contract is expired 
                    if (data == "renewContract") {
                        $(".alert").addClass("alert-danger");
                        $(".alert").text("Company contract is expired, please renew your company contact.");
                        $(".alert").removeClass("d-none");

                        $(ths).fadeIn();
                        $(".spiner").addClass("d-none");
                    }

                    // IF login is success
                    if (data == "logedin") {
                        window.location.replace("dashboard.php");
                    }
                });
            } else {
                $(".alert").addClass("alert-danger");
                $(".alert").text("Please Enter valid values");
                $(".alert").removeClass("d-none");
            }
        });

        $("#password").on("keyup", function(key) {
            if (key.keyCode == 13) {
                if ($("#businessLoginForm").valid()) {
                    $(this).fadeOut();
                    ths = $(this);
                    $(".spiner").removeClass("d-none");
                    $.post("../../app/Controllers/Company.php", $("#businessLoginForm").serialize(), (data) => {
                        console.log(data);
                        // User is not registered yet.
                        if (data == "Notregisterd") {
                            $(".alert").addClass("alert-danger");
                            $(".alert").text("Not registered yet, please create an account first");
                            $(".alert").removeClass("d-none");

                            $(ths).fadeIn();
                            $(".spiner").addClass("d-none");
                        }

                        // If company contract is expired 
                        if (data == "renewContract") {
                            $(".alert").addClass("alert-danger");
                            $(".alert").text("Company contract is expired, please renew your company contact.");
                            $(".alert").removeClass("d-none");

                            $(ths).fadeIn();
                            $(".spiner").addClass("d-none");
                        }

                        // IF login is success
                        if (data == "logedin") {
                            window.location.replace("dashboard.php");
                        }
                    });
                } else {
                    $(".alert").addClass("alert-danger");
                    $(".alert").text("Please Enter valid values");
                    $(".alert").removeClass("d-none");
                }
            }
        })
    });

    // Initialize validation
    $(".businessLoginForm").validate({
        ignore: 'input[type=hidden]', // ignore hidden fields
        errorClass: 'danger',
        successClass: 'success',
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        unhighlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        },
        rules: {
            email: {
                email: true
            }
        }
    });
</script>

</html>