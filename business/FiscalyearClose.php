<?php
$Active_nav_name = array("parent" => "Accounting", "child" => "Fiscal Year CLose");
$page_title = "Fiscal Year";
include("./master/header.php");

$company = new Company();
$document = new Document();

$allcurrency_data = $company->GetCompanyCurrency($user_data->company_id);
$allcurrency = $allcurrency_data->fetchAll(PDO::FETCH_OBJ);

?>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <div class="container">
                <div class="bs-callout-primary mb-2">
                    <div class="media align-items-stretch">
                        <div class="media-left media-middle bg-pink d-flex align-items-center p-2">
                            <i class="la la-sun-o white font-medium-5"></i>
                        </div>
                        <div class="media-body p-1">
                            <strong>Attention Please!</strong>
                            <p>If you register new fiscal year your all transactions will be closed, and a new new financial term will be opened.</p>
                            <p>Before closing the fiscal year, check the balance sheet and balance of the accounts and make corrections if necessary.</p>
                        </div>
                    </div>
                </div>
                <?php helper::generateForm(
                    "company_financial_terms",
                    ["term_id", "current", "companyID","reg_date"],
                    [],
                    "step",
                    []
                ) ?>
            </div>
        </div>
    </div> <!-- Form wzard with step validation section start -->
</div>


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
                    <h5>Prevois Fiscal Year closed and new fiscal year added</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include("./master/footer.php");
?>

<script>
    $(document).ready(function() {
        $("#steps-validation").find("input").each(function(element){
            if($(this).attr("type") != "hidden")
            {
                $(this).addClass("required");
            }
        });

        let currencyIndex = 2;
        // Show form
        var form = $(".steps-validation").show();
        var validator;
        $(".steps-validation").steps({
            headerTag: "h6",
            bodyTag: "fieldset",
            transitionEffect: "slideLeft",
            titleTemplate: '<span class="step">#index#</span> #title#',
            enableAllSteps: true,
            enableContentCache: true,
            saveState: false,
            labels: {
                finish: 'Close & Open FY',
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
                $.post("../app/Controllers/Company.php", $("#steps-validation").serialize(), function(data) {
                    $(".container-waiting").addClass("d-none");
                    $(".container-done").removeClass("d-none");
                    $(".container-done").html(data);
                    // setTimeout(function() {
                    //     $("#show").modal("hide");
                    // }, 2000);
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