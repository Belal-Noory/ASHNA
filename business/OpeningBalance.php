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

$allContacts_data = $bussiness->getCompanyCustomersWithAccounts($user_data->company_id, $user_data->user_id);
$allContacts = $allContacts_data->fetchAll(PDO::FETCH_OBJ);
?>

<div class="container pt-2">
    <div class="card bg-light">
        <div class="card-content">
            <div class="card-body p-2">
                <form id="addbankBalanceForm">
                    <div class="row">
                        <div class="col-lg-1"><i class="la la-bank" style="font-size: 50px;color:dodgerblue"></i></div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <label for="bank">Bank</label>
                                <select class="form-control chosen required customer" name="bank" id="bank">
                                    <option value="" selected="">Select</option>
                                    <?php
                                    $banks_details = $bank->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($banks_details as $details) {
                                        echo "<option value='$details->chartofaccount_id'>$details->account_name - $details->account_type - $details->currency</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" name="amount" id="amount" class="form-control required receiptamount" placeholder="Amount">
                                <label class="d-none rate"></label>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="details">Details</label>
                                <input type="text" name="details" id="details" class="form-control" placeholder="details">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="currency">Currency</label>
                                <select type="text" id="currency" class="form-control" placeholder="Currency" name="currency">
                                    <?php
                                    foreach ($allcurrency as $currency) {
                                        echo "<option value='$currency->company_currency_id'>$currency->currency</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="addbankopeningbalance">
                        <button type="button" class="btn btn-dark ml-2" id="btnaddbankbalance"><span class="las la-save"></span> Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card bg-light">
        <div class="card-content">
            <div class="card-body p-2">
                <form id="addsaifBalanceForm">
                    <div class="row">
                        <div class="col-lg-1"><i class="la la-box" style="font-size: 50px;color:dodgerblue"></i></div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <label for="saif">Saif</label>
                                <select class="form-control chosen required customer" name="saif" id="saif">
                                    <option value="" selected="">Select</option>
                                    <?php
                                    $saif_details = $saifs->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($saif_details as $details) {
                                        echo "<option value='$details->chartofaccount_id'>$details->account_name - $details->account_type - $details->currency</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" name="amount" id="amount" class="form-control required receiptamount" placeholder="Amount">
                                <label class="d-none rate"></label>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="details">Details</label>
                                <input type="text" name="details" id="details" class="form-control" placeholder="details">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="currency">Currency</label>
                                <select type="text" id="currency" class="form-control" placeholder="Currency" name="currency">
                                    <?php
                                    foreach ($allcurrency as $currency) {
                                        echo "<option value='$currency->company_currency_id'>$currency->currency</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="addsaifopeningbalance">
                        <button type="button" class="btn btn-dark ml-2" id="btnaddsaifbalance"><span class="las la-save"></span> Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card bg-light">
        <div class="card-content">
            <div class="card-body p-2">
                <form id="addcusBalanceForm">
                    <div class="row">
                        <div class="col-lg-1"><i class="la la-users" style="font-size: 50px;color:dodgerblue"></i></div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <label for="customer">Customer</label>
                                <select class="form-control chosen required customer" name="customer" id="customer">
                                    <option value="" selected="">Select</option>
                                    <?php
                                    foreach ($allContacts as $contact) {
                                        echo "<option value='$contact->chartofaccount_id' >$contact->account_name - $contact->account_type - $contact->currency</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" name="amount" id="amount" class="form-control required receiptamount" placeholder="Amount">
                                <label class="d-none rate"></label>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="details">Details</label>
                                <input type="text" name="details" id="details" class="form-control" placeholder="details">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="currency">Currency</label>
                                <select type="text" id="currency" class="form-control" placeholder="Currency" name="currency">
                                    <?php
                                    foreach ($allcurrency as $currency) {
                                        echo "<option value='$currency->company_currency_id'>$currency->currency</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="addcusopeningbalance">
                        <button type="button" class="btn btn-dark ml-2" id="btnaddcusbalance"><span class="las la-save"></span> Register</button>
                    </div>
                </form>
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
        $('.chosen').chosen();
        $(".chosen-container").removeAttr("style");
        $(".chosen-container").addClass("form-control").addClass("p-0");
        $(".chosen-single").css({
            "height": "100%",
            "width": "100%",
            "border": "0px",
            "outline": "0px"
        });
        $(".chosen-single span").css({
            "height": "100%",
            "width": "100%",
            "padding-top": "5px",
            "padding-left": "5px",
        });

        // Add bank balance
        $("#btnaddbankbalance").on("click", function() {
            $("#show").modal("show");
            $.post("../app/Controllers/banks.php",$("#addbankBalanceForm").serialize(),function(data){
                $(".container-waiting").addClass("d-none");
                $(".container-done").removeClass("d-none");
                setTimeout(function() {
                    $("#show").modal("hide");
                }, 2000);
                $("#addbankBalanceForm")[0].reset();
            });
        });

        // Add Saif balance
        $("#btnaddsaifbalance").on("click", function() {
            $("#show").modal("show");
            $.post("../app/Controllers/banks.php",$("#addsaifBalanceForm").serialize(),function(data){
                $(".container-waiting").addClass("d-none");
                $(".container-done").removeClass("d-none");
                setTimeout(function() {
                    $("#show").modal("hide");
                }, 2000);
                $("#addsaifBalanceForm")[0].reset();
            });
        });

        // Add Customer balance
        $("#btnaddcusbalance").on("click", function() {
            $("#show").modal("show");
            $.post("../app/Controllers/banks.php",$("#addcusBalanceForm").serialize(),function(data){
                $(".container-waiting").addClass("d-none");
                $(".container-done").removeClass("d-none");
                setTimeout(function() {
                    $("#show").modal("hide");
                }, 2000);
                $("#addsaifBalanceForm")[0].reset();
            });
        });
    });
</script>