<?php
$Active_nav_name = array("parent" => "Banking", "child" => "New Saif");
$page_title = "New Saif";
include("./master/header.php");
?>
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="col-md-12 col-lg-6">
            <?php helper::generateForm(
                "chartofaccount",
                ["chartofaccount_id", "cutomer_id", "reg_date", "approve", "createby", "company_id", "account_catagory", "account_kind", "account_type", "account_number", "initial_ammount"],
                [array("feild" => "currency", "childs" => array("Currency"))],
                "step",
                []
            ) ?>
        </div>
    </div>
</div> <!-- Form wzard with step validation section start -->

<!-- Modal -->
<div class="modal fade text-center" id="show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body p-2">
                <div class="container container-waiting">
                    <div class="loader-wrapper">
                        <div class="loader-container">
                            <div class="ball-clip-rotate loader-primary">
                                <div></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container container-done d-none">
                    <i class="font-large-2 icon-line-height la la-check" style="color: seagreen;"></i>
                    <h5>Saif Registered</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- END: Content-->
<?php
include("./master/footer.php");
?>
<script>
    $(document).ready(function() {

        $("#addchartofaccount").attr("name", "addnewsaif");
        $.get("../app/Controllers/banks.php", {
            "getCurrency": true
        }, (data) => {
            console.log(data);
            $newdata = $.parseJSON(data);
            $newdata.forEach(element => {
                $("#currency").append(`<option value='${element.currency}'>${element.currency}</option>`);
            });
        });

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
                $(".container-waiting").addClass("d-none");
                $(".container-done").removeClass("d-none");
                $.post("../app/Controllers/banks.php", $(".steps-validation").serialize(), (data) => {
                    setTimeout(function() {
                        $("#show").modal("hide");
                    }, 2000);
                    $("#steps-validation")[0].reset();
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