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
                "Saif Info",
                ["chartofaccount_id", "cutomer_id", "reg_date", "approve", "createby", "company_id", "account_catagory", "account_kind", "account_type", "account_number", "initial_ammount","useradded"],
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
            $newdata = $.parseJSON(data);
            $newdata.forEach(element => {
                selected = element.mainCurrency == 1 ? "selected" : "";
                $("#currency").append(`<option value='${element.currency}' ${selected}>${element.currency}</option>`);
            });
        });

        $(".form").find("input").each(function(element) {
            if ($(this).attr("type") != "hidden") {
                $(this).addClass("required");
            }
        });

        // Add customer
        $(document).on("submit", ".form", function(e) {
            e.preventDefault();
            if ($(".form").valid()) {
                $.ajax({
                    url: "../app/Controllers/banks.php",
                    type: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $("#show").modal("show");
                    },
                    success: function(data) {
                        $(".container-waiting").addClass("d-none");
                        $(".container-done").removeClass("d-none");
                        $(".form")[0].reset();
                    },
                    error: function(e) {
                        $(".container-waiting").addClass("d-none");
                        $(".container-done").removeClass("d-none");
                        $(".container-done").html(e);
                    }
                });
            }
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