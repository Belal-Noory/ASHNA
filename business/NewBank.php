<?php
$Active_nav_name = array("parent" => "Banking", "child" => "New Bank");
include("./master/header.php");
?>
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="col-md-8 col-lg-6">
            <?php helper::generateForm(
                "chartofaccount",
                ["chartofaccount_id", "reg_date", "approve", "createby", "company_id", "account_catagory"],
                [array("feild" => "account_type", "childs" => array("Payable", "Receivable")), array("feild" => "account_kind", "childs" => array("Bank", "Saif"))],
                "step",
                []
            ) ?>
        </div>
    </div>
</div> <!-- Form wzard with step validation section start -->
</div>
<!-- END: Content-->
<?php
include("./master/footer.php");
?>
<script>
    $(document).ready(function() {
        var form = $(".steps-validation").show();
        $(".steps-validation").steps({
            headerTag: "h6",
            bodyTag: "fieldset",
            transitionEffect: "slideLeft",
            titleTemplate: '<span class="step">#index#</span> #title#',
            enableAllSteps: true,
            enableContentCache: true,
            saveState: false,
            labels: {
                finish: 'Register',
                next: 'Next',
                previous: 'Prev',
            },
            onStepChanging: function(event, currentIndex, newIndex) {
                // Allways allow previous action even if the current form is not valid!
                if (currentIndex > newIndex) {
                    return true;
                }
                // Needed in some cases if the user went back (clean up)
                if (currentIndex < newIndex) {
                    // To remove error styles
                    form.find(".body:eq(" + newIndex + ") label.error").remove();
                    form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
                }
                form.validate().settings.ignore = ":disabled,:hidden";
                return form.valid();
            },
            onFinishing: function(event, currentIndex) {
                form.validate().settings.ignore = ":disabled";
                return form.valid();
            },
            onFinished: function(event, currentIndex) {
                $("#show").modal("show");
                $.post("../app/Controllers/Bussiness.php", $(".steps-validation").serialize(), (data) => {
                    $(".container-waiting").addClass("d-none");
                    $(".container-done").removeClass("d-none");

                    setTimeout(function() {
                        $("#show").modal("hide");
                        window.location.reload();
                    }, 2000);
                });
            }
        });
    });
    // Initialize validation
    $(".steps-validation").validate({
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