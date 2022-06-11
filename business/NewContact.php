<?php
$Active_nav_name = array("parent" => "Contact", "child" => "New Contact");
$page_title = "New Customer";
include("./master/header.php");

?>

<!-- END: Main Menu-->
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <?php helper::generateForm(
                "customers",
                ["customer_id", "added_date", "approve", "createby", "company_id"],
                [array("feild" => "person_type", "childs" => array("Saraf", "Customer", "Daily Customer", "Capital", "Share holders")), array("feild" => "gender", "childs" => array("Male", "Female"))],
                "step",
                [
                    array("table_name" => "customeraddress", "ignore" => array("person_address_id", "customer_id"), "hasAttachmen" => false, "addMulti" => true, "drompdowns" => [array("feild" => "address_type", "childs" => array("Current", "Permenant"))]),
                    array("table_name" => "customersbankdetails", "ignore" => array("person_bank_details_id", "customer_id"), "hasAttachmen" => false, "addMulti" => true, "drompdowns" => [array("feild" => "currency", "childs" => array("Select Currency"))])
                ]
            ) ?>
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
                    <h5>Customer Registered</h5>
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
    $(document).ready(() => {

        // Load all currency in dropdown
        $.get("../app/Controllers/banks.php", {
            "getCurrency": true
        }, (data) => {
            console.log(data);
            $newdata = $.parseJSON(data);
            $newdata.forEach(element => {
                $("#currency").append(`<option value='${element.currency}'>${element.currency}</option>`);
            });
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


        // Add Multi forms
        $form_count = Array();

        $(document).on("click", ".btnaddmulti", function(e) {
            e.preventDefault();
            newForm = $(this).parent().parent().children(".row:first()").clone();

            hidden_input_counter = $(this).parent().parent().children(".counter").val();
            hidden_input_counter++;
            $(this).parent().parent().children(".counter").val(hidden_input_counter);

            $parentName = $(this).parent().parent().attr("data");

            tempCount = 0;
            if ($form_count.length > 0) {
                $form_count.forEach(element => {
                    if (element.name == $parentName) {
                        tempCount = element.count;
                        tempCount++;
                        element.count = tempCount;
                    }
                });
            } else {
                $form_count.push({
                    "name": $parentName,
                    "count": 0
                });
            }

            $form_IDs = Array();

            // Find all inputs
            $(newForm).find("input").each(function(index) {
                $form_IDs.push({
                    "name": $(this).attr("id"),
                    "type": $(this).attr("type"),
                    "child": 0
                });
            });

            // Find all select
            $(newForm).find("select").each(function(index) {
                $childs = Array();
                $(this).children("option").each(function() {
                    $childs.push($(this).val());
                });
                $form_IDs.push({
                    "name": $(this).attr("id"),
                    "type": "select",
                    "child": $childs
                });
            });

            $form = "<div class='row'>";
            $($form_IDs).each((index, element) => {
                if (element.type == "text") {
                    $form += "<div class='col-md-6'><div class='form-group'><label for='" + (element.name + tempCount) + "' style='font-variant:small-caps'>" + element.name + ":<span class='danger'>*</span></label><input type='" + element.type + "' class='form-control' id='" + element.name + tempCount + "' name='" + element.name + tempCount + "' placeholder='" + element.name + "' /></div></div>";
                }

                if (element.type == "file") {
                    $form += "<div class='col-md-6'><div class='form-group'><label for='" + (element.name + tempCount) + "' style='font-variant:small-caps'>" + element.name + ":<span class='danger'>*</span></label><input type='" + element.type + "' class='form-control' id='" + element.name + tempCount + "' name='" + element.name + tempCount + "' placeholder='" + element.name + "' /></div></div>";
                }

                if (element.type == "select") {
                    $form += "<div class='col-md-6'><div class='form-group'><label for='" + (element.name + tempCount) + "' style='font-variant:small-caps'>" + element.name + ":<span class='danger'>*</span></label>";
                    $form += "<select id='" + element.name + tempCount + "' name='" + element.name + tempCount + "' class='form-control'>";
                    element.child.forEach(element => {
                        $form += "<option value='" + element + "'>" + element + "</option>";
                    });
                    $form += "</select></div></div>";
                }
            });
            $form += "<div class='col-md-6'><a href='#' class='btn btn-sm btn-danger btndeletemulti'><span class='la la-trash'></span></a></div></div>";
            $(this).parent().parent().append($form);
        });

        // Delete multi forms
        $(document).on("click", ".btndeletemulti", function(e) {
            e.preventDefault();
            $(this).parent().parent().fadeOut();
            parent = $(this).parent().parent().parent().attr("data");
            $form_count.forEach(element => {
                if (element.name == parent) {
                    tempCount = element.count;
                    tempCount--;
                    element.count = tempCount;
                }
            });
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