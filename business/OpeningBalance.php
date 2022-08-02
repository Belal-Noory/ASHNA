<?php
$Active_nav_name = array("parent" => "Accounting", "child" => "Opening Balance");
$page_title = "Opening Balance";
include("./master/header.php");

$company = new Company();
$bussiness = new Bussiness();
$banks = new Banks();

$bank = $banks->getBanks($user_data->company_id);
$saifs = $banks->getSaifs($user_data->company_id);

$allcurrency_data = $company->GetCompanyCurrency($user_data->company_id);
$allcurrency = $allcurrency_data->fetchAll(PDO::FETCH_OBJ);

$mainCurrency = "";
foreach ($allcurrency as $c) {
    $mainCurrency = $c->mainCurrency == 1 ? $c->currency : $mainCurrency;
}

$allContacts_data = $bussiness->getCompanyCustomersWithAccounts($user_data->company_id, $user_data->user_id);
$allContacts = $allContacts_data->fetchAll(PDO::FETCH_OBJ);
?>

<div class="container-fluid p-2">
    <div class="row">
        <div class="card col" style="background-color: rgba(26,179,148,.15);">
            <div class="card-content">
                <div class="card-body p-2">
                    <h5 class="card-title" style="color: #1ab394;">Assets</h5>
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action" style="background-color: transparent;color:rgba(0,0,0,.5);" aria-current="true">
                            The current link item
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column col">
            <div class="card" style="background-color: rgba(237,85,101,.15);">
                <div class="card-content">
                    <div class="card-body p-2">
                        <h5 class="card-title" style="color: #ed5565">Liabilities</h5>
                        <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action" style="background-color: transparent;color: rgba(0,0,0,.5);" aria-current="true">
                            The current link item
                        </a>
                    </div>
                    </div>
                </div>
            </div>

            <div class="card" style="background-color: rgba(28,132,198,.15);">
                <div class="card-content">
                    <div class="card-body p-2">
                        <h5 class="card-title" style="color: #1c84c6">Equity</h5>
                        <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action" style="background-color: transparent; color: rgba(0,0,0,.5);" aria-current="true">
                            The current link item
                        </a>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                    <h5>Registered Successfully</h5>
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

        // List accounts based on selected curreny
        // $(".bankcurrency").on("change", function() {
        //     currency = $(".bankcurrency option:selected").text();
        //     // hide all options of customer
        //     $("#bank option").addClass("d-none");

        //     $("#bank > option").each(function() {
        //         if ($(this).hasClass(currency)) {
        //             $(this).removeClass("d-none");
        //         }
        //     });
        // });

        // $(".saifCurrency").on("change", function() {
        //     currency = $(".saifCurrency option:selected").text();
        //     // hide all options of customer
        //     $("#saif option").addClass("d-none");

        //     $("#saif > option").each(function() {
        //         if ($(this).hasClass(currency)) {
        //             $(this).removeClass("d-none");
        //         }
        //     });
        // });

        // $(".cusCurrency").on("change", function() {
        //     currency = $(".cusCurrency option:selected").text();
        //     // hide all options of customer
        //     $("#customer option").addClass("d-none");

        //     $("#customer > option").each(function() {
        //         if ($(this).hasClass(currency)) {
        //             $(this).removeClass("d-none");
        //         }
        //     });
        // });

        // // Add bank balance
        // $("#btnaddbankbalance").on("click", function() {
        //     if ($("#addbankBalanceForm").valid()) {
        //         $("#show").modal("show");
        //         $.post("../app/Controllers/banks.php", $("#addbankBalanceForm").serialize(), function(data) {
        //             $(".container-waiting").addClass("d-none");
        //             $(".container-done").removeClass("d-none");
        //             setTimeout(function() {
        //                 $("#show").modal("hide");
        //             }, 2000);
        //             $("#addbankBalanceForm")[0].reset();
        //         });
        //     }
        // });

        // // Add Saif balance
        // $("#btnaddsaifbalance").on("click", function() {
        //     if ($("#addsaifBalanceForm").valid()) {
        //         $("#show").modal("show");
        //         $.post("../app/Controllers/banks.php", $("#addsaifBalanceForm").serialize(), function(data) {
        //             $(".container-waiting").addClass("d-none");
        //             $(".container-done").removeClass("d-none");
        //             setTimeout(function() {
        //                 $("#show").modal("hide");
        //             }, 2000);
        //             $("#addsaifBalanceForm")[0].reset();
        //         });
        //     }
        // });

        // // Add Customer balance
        // $("#btnaddcusbalance").on("click", function() {
        //     if ($("#addcusBalanceForm").valid()) {
        //         $("#show").modal("show");
        //         $.post("../app/Controllers/banks.php", $("#addcusBalanceForm").serialize(), function(data) {
        //             $(".container-waiting").addClass("d-none");
        //             $(".container-done").removeClass("d-none");
        //             setTimeout(function() {
        //                 $("#show").modal("hide");
        //             }, 2000);
        //             $("#addsaifBalanceForm")[0].reset();
        //         });
        //     }
        // });
    });

    // Initialize validation
    $("#addbankBalanceForm, #addcusBalanceForm, #addsaifBalanceForm").validate({
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