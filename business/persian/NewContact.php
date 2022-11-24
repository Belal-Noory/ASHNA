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
                "Basic Info",
                ["customer_id", "added_date", "approve", "createby", "company_id"],
                [array("feild" => "person_type", "childs" => array("Legal Entity","Individual", "MSP", "Share holders","user")), array("feild" => "gender", "childs" => array("Male", "Female"))],
                "step",
                [
                    array("table_name" => "customeraddress", "title" => "Customer Address", "ignore" => array("person_address_id", "customer_id"), "hasAttachmen" => false, "addMulti" => true, "drompdowns" => [array("feild" => "address_type", "childs" => array("Current", "Permenant"))]),
                    array("table_name" => "customersbankdetails", "title" => "Customer Bank Details", "ignore" => array("person_bank_details_id", "customer_id"), "hasAttachmen" => false, "addMulti" => true, "drompdowns" => []),
                    array("table_name" => "customersattacment", "title" => "Customer Attachments", "ignore" => array("person_attachment_id", "person_id", "attachment_name", "createby", "updatedby"), "hasAttachmen" => true, "addMulti" => true, "drompdowns" => [array("feild" => "attachment_type", "childs" => array("NID", "profile", "signature", "other"))])
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
                    <h5>مشتری ثبت شد</h5>
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


        $("#alies_name").attr("required",true);
        $("#alies_name").addClass("required");

        $(".form").children(".row").first().children("div:nth-child(22)").children(".form-group").children("textarea").attr("name","pdetails");
        $(".form").children(".row").first().children("div:nth-child(22)").children(".form-group").children("textarea").attr("id","pdetails");

        $(".form").children("div:nth-child(6)").children(".row").children("div:nth-child(2)").children(".form-group").children("input").attr("name","fdetails");
        $(".form").children("div:nth-child(6)").children(".row").children("div:nth-child(2)").children(".form-group").children("input").attr("id","fdetails");

        // Load all currency in dropdown
        $.get("../app/Controllers/banks.php", {
            "getCurrency": true
        }, (data) => {
            $newdata = $.parseJSON(data);
            $newdata.forEach(element => {
                $("#currency").append(`<option value='${element.currency}'>${element.currency}</option>`);
            });
        });

        // Add customer
        $(document).on("submit", ".form", function(e) {
            e.preventDefault();
            if ($(".form").valid()) {
                $.ajax({
                    url: "../app/Controllers/Bussiness.php",
                    type: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $("#show").modal("show");
                    },
                    success: function(data) {
                        console.log(data);
                        $(".container-waiting").addClass("d-none");
                        $(".container-done").removeClass("d-none");
                        // $(".form")[0].reset();
                    },
                    error: function(e) {
                        $(".container-waiting").addClass("d-none");
                        $(".container-done").removeClass("d-none");
                        $(".container-done").html(e);
                    }
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
            $(newForm).find("input,select").each(function(index) {
                console.log($(this));
                if ($(this).attr("type") == "input" || $(this).attr("type") == "file") {
                    $form_IDs.push({
                        "name": $(this).attr("id"),
                        "type": $(this).attr("type"),
                        "child": 0
                    });
                } else {
                    $childs = Array();
                    $(this).children("option").each(function() {
                        $childs.push($(this).val());
                    });
                    $form_IDs.push({
                        "name": $(this).attr("id"),
                        "type": "select",
                        "child": $childs
                    });
                }
            });

            $form = "<div class='row mt-2'>";
            $($form_IDs).each((index, element) => {
                if (element.type == "text") {
                    $form += "<div class='col-lg-3'><div class='form-group'><label for='" + (element.name + tempCount) + "' style='font-variant:small-caps'>" + element.name + ":<span class='danger'>*</span></label><input type='" + element.type + "' class='form-control' id='" + element.name + tempCount + "' name='" + element.name + tempCount + "' placeholder='" + element.name + "' /></div></div>";
                } else if (element.type == "file") {
                    $form += "<div class='col-lg-3'><div class='form-group attachement'><label for='" + (element.name + tempCount) + "'><span class='las la-file-upload blue'></span></label><i>filename</i><input type='" + element.type + "' class='form-control d-none' id='" + element.name + tempCount + "' name='" + element.name + tempCount + "' placeholder='" + element.name + "' /></div></div>";
                } else if (element.type == "select") {
                    $form += "<div class='col-lg-3'><div class='form-group'><label for='" + (element.name + tempCount) + "' style='font-variant:small-caps'>" + element.name + ":<span class='danger'>*</span></label>";
                    $form += "<select id='" + element.name + tempCount + "' name='" + element.name + tempCount + "' class='form-control'>";
                    element.child.forEach(element => {
                        $form += "<option value='" + element + "'>" + element + "</option>";
                    });
                    $form += "</select></div></div>";
                }
            });
            $form += "<div class='col-lg-3'><a href='#' class='btn btn-sm btn-danger btndeletemulti'><span class='la la-trash'></span></a></div></div>";
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
    $(".form").validate({
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