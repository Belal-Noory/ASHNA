<?php
session_start();
if (isset($_SESSION["saraf_user"])) {
    header("location: send.php");
}
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
    <title>ASHNA | Login</title>
    <link rel="icon" href="../ashna.ico" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CQuicksand:300,400,500,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="../business/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="../business/app-assets/vendors/css/forms/icheck/icheck.css">
    <link rel="stylesheet" type="text/css" href="../business/app-assets/vendors/css/forms/icheck/custom.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="../business/app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../business/app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="../business/app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="../business/app-assets/css/components.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="../business/app-assets/css/core/menu/menu-types/horizontal-menu.css">
    <link rel="stylesheet" type="text/css" href="../business/app-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="../business/app-assets/css/pages/login-register.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="../business/assets/css/style.css">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="horizontal-layout horizontal-menu 1-column  bg-full-screen-image blank-page" data-open="hover" data-menu="horizontal-menu" data-col="1-column">
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="row flexbox-container">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="col-lg-4 col-md-8 col-10 box-shadow-2 p-0">
                            <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
                                <div class="card-header border-0">
                                    <div class="card-title text-center">
                                        <img src="../business/app-assets/images/logo/ashna_trans.png" style="width: 120px;" alt="branding logo">
                                    </div>
                                </div>
                                <div class="card-content">
                                    <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1"><span>Account
                                            Details</span></p>
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
                                            <input type="hidden" name="sarafLogin" value="true">
                                            <button type="button" class="btn btn-outline-info btn-block" id="btnloginsaraf">
                                                <i class="ft-unlock"></i> Login</button>
                                            <div class="text-center spiner d-none"><i class="la la-spinner spinner blue" style="font-size: 30px;"></i></div>
                                        </form>
                                        <div class="alert mt-2"></div>
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
    <script src="../business/app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="../business/app-assets/vendors/js/ui/jquery.sticky.js"></script>
    <script src="../business/app-assets/vendors/js/charts/jquery.sparkline.min.js"></script>
    <script src="../business/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"></script>
    <script src="../business/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
    <script src="../business/app-assets/vendors/js/forms/icheck/icheck.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="../business/app-assets/js/core/app-menu.js"></script>
    <script src="../business/app-assets/js/core/app.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="../business/app-assets/js/scripts/ui/breadcrumbs-with-stats.js"></script>
    <script src="../business/app-assets/js/scripts/forms/form-login-register.js"></script>
    <!-- END: Page JS-->

</body>
<!-- END: Body-->
<script>
    $(document).ready(function() {

        // Remove all alerts after 500 milli seconds
        setInterval(() => {
            $(".alert").addClass("d-none");
        }, 3000);

        $("#btnloginsaraf").on("click", function() {
            if ($("#businessLoginForm").valid()) {
                $(this).fadeOut();
                ths = $(this);
                $(".spiner").removeClass("d-none");
                $.post("../app/Controllers/Saraf.php", $("#businessLoginForm").serialize(), (data) => {
                    // User is not registered yet.
                    if (data == "Notregisterd") {
                        $(".alert").addClass("alert-danger");
                        $(".alert").text("Not registered yet, please create an account first");
                        $(".alert").removeClass("d-none");

                        $(ths).fadeIn();
                        $(".spiner").addClass("d-none");
                    }

                    // IF login is success
                    if (data == "logedin") {
                        window.location = "send.php";
                    }
                });
            } else {
                $(".alert").addClass("alert-danger");
                $(".alert").text("Please Enter valid values");
                $(".alert").removeClass("d-none");
            }
        });
    });

    // Initialize validation
    $("#businessLoginForm").validate({
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