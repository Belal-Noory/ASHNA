<?php
$Active_nav_name = array("parent" => "Banking", "child" => "Transfer");
$page_title = "New Transfer";
include("./master/header.php");

// Objects
$bank = new Banks();
$company = new Company();

$allBanks_data = $bank->getBanks($user_data->company_id);
$allBanks = $allBanks_data->fetchAll(PDO::FETCH_OBJ);

// All Saifs
$allSaifs_data = $bank->getSaifs($user_data->company_id);
$allSaifs = $allSaifs_data->fetchAll(PDO::FETCH_OBJ);

// Company Currency
$currency_data = $company->GetCompanyCurrency($user_data->company_id);
$currency = $currency_data->fetchAll(PDO::FETCH_OBJ);
$mainCurrency = "";
?>
<!-- BEGIN: Content-->
<div class="container mt-2">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title" id="basic-layout-form">New Transfer</h4>
            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>

        <div class="card-content collapse show">
            <div class="card-body">
                <form class="form">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <input type="date" id="date" class="form-control required" placeholder="First Name" name="date">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="saifamount">Amount</label>
                                    <input type="number" class="form-control required" name="amount" id="amount" placeholder="Amount">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="rate">Reference Code</label>
                                    <input type="number" class="form-control" name="rcode" id="rcode" placeholder="Reference Code">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="details">Description</label>
                                    <textarea id="details" rows="1" class="form-control required" name="details" placeholder="Description" style="border:none;border-bottom:1px solid gray"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card-content">
                                    <div class="card-header">
                                        <span class="card-title" id="basic-layout-colored-form-control">From</span>
                                        <span class="badge badge-danger d-none" id="badgefrom"></span>
                                        <span class="badge badge-danger d-none" id="badgefromamount"></span>
                                    </div>
                                    <div class="card-body">
                                        <div class="card-body">
                                            <ul class="nav nav-tabs nav-underline nav-justified">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="bank-tab" data-toggle="tab" href="#bankPanel" aria-controls="activeIcon12" aria-expanded="true">
                                                        <i class="ft-cog"></i> Bank
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="saif-tab" data-toggle="tab" href="#saifPanel" aria-controls="linkIconOpt11">
                                                        <i class="ft-external-link"></i> Saif
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div role="tabpanel" class="tab-pane active" id="bankPanel" aria-labelledby="bank-tab" aria-expanded="true">
                                                    <div class="form-group">
                                                        <label for="bank">Bank</label>
                                                        <select id="bankfrom" name="bankfrom" class="form-control accounts">
                                                            <option value="NA" selected>Select Bank</option>
                                                            <?php
                                                            foreach ($allBanks as $bank) {
                                                                echo "<option data-href='$bank->currency' value='$bank->chartofaccount_id'>$bank->account_name</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="saifPanel" role="tabpanel" aria-labelledby="saif-tab" aria-expanded="false">
                                                    <div class="form-group">
                                                        <label for="saif">Saif</label>
                                                        <select id="saiffrom" name="saiffrom" class="form-control accounts">
                                                            <option value="NA" selected>Select Saif</option>
                                                            <?php
                                                            foreach ($allSaifs as $saif) {
                                                                echo "<option data-href='$saif->currency' value='$saif->chartofaccount_id'>$saif->account_name</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="card-content">
                                    <div class="card-header">
                                        <span class="card-title" id="basic-layout-colored-form-control">To</span>
                                        <span class="badge badge-danger d-none" id="badgeto"></span>
                                        <span class="badge badge-danger d-none" id="badgetoamount"></span>
                                    </div>
                                    <div class="card-body">
                                        <div class="card-body">
                                            <ul class="nav nav-tabs nav-underline nav-justified">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="bank-tab-to" data-toggle="tab" href="#bankPanelTo" aria-controls="activeIcon12" aria-expanded="true">
                                                        <i class="ft-cog"></i> Bank
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="saif-tab-to" data-toggle="tab" href="#saifPanelTo" aria-controls="linkIconOpt11">
                                                        <i class="ft-external-link"></i> Saif
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div role="tabpanel" class="tab-pane active" id="bankPanelTo" aria-labelledby="bank-tab-to" aria-expanded="true">
                                                    <div class="form-group">
                                                        <label for="bank">Bank</label>
                                                        <select id="bankto" name="bankto" class="form-control accounts">
                                                            <option value="NA" selected>Select Bank</option>
                                                            <?php
                                                            foreach ($allBanks as $bank) {
                                                                echo "<option data-href='$bank->currency' value='$bank->chartofaccount_id'>$bank->account_name</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="saifPanelTo" role="tabpanel" aria-labelledby="saif-tab-to" aria-expanded="false">
                                                    <div class="form-group">
                                                        <label for="saif">Saif</label>
                                                        <select id="saifto" name="saifto" class="form-control accounts">
                                                            <option value="NA" selected>Select Saif</option>
                                                            <?php
                                                            foreach ($allSaifs as $saif) {
                                                                echo "<option data-href='$saif->currency' value='$saif->chartofaccount_id'>$saif->account_name</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-primary" id="btnaddtransfer">
                            <i class="la la-check-square-o"></i> Save
                        </button>
                    </div>

                    <input type="hidden" name="addtransfer">
                    <input type="hidden" name="rate"  id="rate" value="0">
                    <input type="hidden" name="cfrom" id="cfrom">
                    <input type="hidden" name="cto" id="cto">
                    <input type="hidden" name="amountto" id="amountto" value="0">
                </form>
                <span class="alert alert-danger d-none"></span>
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
                    <h5>Transfered Successfully</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="snackbar snackbar-multi-line bg-danger" id="erroSnackbar">
    <div class="snackbar-body">
    </div>
    <button class="snackbar-btn text-white" type="button" onclick="$('#erroSnackbar').removeClass('show')"><span class="las la-window-close"></span></button>
</div>
<!-- END: Content-->
<?php
include("./master/footer.php");
?>
<script>
    $(document).ready(function() {

        setInterval(() => {
            // $(".alert").addClass("d-none");
            $("#show").modal("hide");
        }, 2000);

        $("#btnaddtransfer").on("click", function(e) {
            e.preventDefault();
            if ($(".form").valid()) {
                $("#show").modal("show");
                $.post("../app/Controllers/banks.php", $(".form").serialize(), (data) => {
                    console.log(data);
                    $(".container-waiting").addClass("d-none");
                    $(".container-done").removeClass("d-none");
                    // $(".form")[0].reset();
                });
            }
        });

        // check bank to
        $("#bankto").on("change", function() {
            $("#badgefrom").text("");
            $("#badgefromamount").text("");

            $("#badgeto").text("");
            $("#badgetoamount").text("");

            // set saifto to NA
            $("#saifto").prop("selectedIndex", 0);

            // bank to details
            bankto = $("#bankto option:selected");
            currency = $(bankto).attr("data-href");

            // bank to details
            bankfrom = $("#bankfrom option:selected");
            if ($(bankfrom).val() == "NA") {
                bankfrom = $("#saiffrom option:selected");
            }
            currency_bankfrom = (bankfrom).attr("data-href");

            amount = $("#amount").val();
            $("#cto").val(currency);
            $("#cfrom").val(currency_bankfrom);
            if ($(saiffrom).val() != "NA") {
                if (currency != currency_bankfrom) {
                    $.get("../app/Controllers/banks.php", {
                            "getExchange": true,
                            "from": currency,
                            "to": currency_bankfrom
                        },
                        function(data) {
                            if (data != "false") {
                                ndata = JSON.parse(data);
                                $("#rate").val(ndata.rate);
                                if (ndata.currency_to == currency) {
                                    $("#badgetoamount").text(parseFloat(ndata.rate) * parseFloat(amount));
                                    $("#badgeto").text(ndata.currency_to);
                                    $("#amountto").val(parseFloat(ndata.rate) * parseFloat(amount));
                                } else {
                                    $("#badgetoamount").text(parseFloat((1 / ndata.rate)) * parseFloat(amount));
                                    $("#badgeto").text(ndata.currency_from);
                                    $("#amountto").val(parseFloat((1 / ndata.rate)) * parseFloat(amount));
                                }
                                $("#badgeto").removeClass("d-none");
                                $("#badgetoamount").removeClass("d-none");

                                // update from
                                $("#badgefrom").removeClass("d-none");
                                $("#badgefrom").text(currency_bankfrom);
                                $("#badgefromamount").removeClass("d-none");
                                $("#badgefromamount").text(amount);
                            } else {
                                if (!$("#erroSnackbar").hasClass("show")) {
                                    $("#erroSnackbar").addClass("show");
                                    $("#erroSnackbar").children(".snackbar-body").html(`Please add exchange from ${currency} to ${mainCurrency}`);
                                }
                            }
                        });
                } else {
                    $("#erroSnackbar").removeClass("show");
                    $("#budgetoamount").addClass("d-none");
                    $("#budgeto").addClass("d-none");
                    $("#amountto").val(0);
                }
            }
        });

        // check saif to
        $("#saifto").on("change", function() {
            $("#badgefrom").text("");
            $("#badgefromamount").text("");

            $("#badgeto").text("");
            $("#badgetoamount").text("");

            // set bankto to NA
            $("#bankto").prop("selectedIndex", 0);

            // bank to details
            saifto = $("#saifto option:selected");
            currency = $(saifto).attr("data-href");

            // bank to details
            saiffrom = $("#saiffrom option:selected");
            if ($(saiffrom).val() == "NA") {
                saiffrom = $("#bankfrom option:selected");
            }
            currency_bankfrom = $(saiffrom).attr("data-href");
            amount = $("#amount").val();

             $("#cto").val(currency);
            $("#cfrom").val(currency_bankfrom);
            if ($(saiffrom).val() != "NA") {
                if (currency != currency_bankfrom) {
                    $.get("../app/Controllers/banks.php", {
                            "getExchange": true,
                            "from": currency,
                            "to": currency_bankfrom
                        },
                        function(data) {
                            if (data != "false") {
                                ndata = JSON.parse(data);
                                $("#rate").val(ndata.rate);
                                if (ndata.currency_to == currency) {
                                    $("#badgetoamount").text(parseFloat(ndata.rate) * parseFloat(amount));
                                    $("#badgeto").text(ndata.currency_to);
                                    $("#amountto").val(parseFloat(ndata.rate) * parseFloat(amount));
                                } else {
                                    $("#badgetoamount").text(parseFloat((1 / ndata.rate)) * parseFloat(amount));
                                    $("#badgeto").text(ndata.currency_from);
                                    $("#amountto").val(parseFloat((1 / ndata.rate)) * parseFloat(amount));
                                     
                                }
                                $("#badgeto").removeClass("d-none");
                                $("#badgetoamount").removeClass("d-none");

                                // update from
                                $("#badgefrom").removeClass("d-none");
                                $("#badgefrom").text(currency_bankfrom);
                                $("#badgefromamount").removeClass("d-none");
                                $("#badgefromamount").text(amount);
                            } else {
                                if (!$("#erroSnackbar").hasClass("show")) {
                                    $("#erroSnackbar").addClass("show");
                                    $("#erroSnackbar").children(".snackbar-body").html(`Please add exchange from ${currency} to ${mainCurrency}`);
                                }
                            }
                        });
                } else {
                    $("#erroSnackbar").removeClass("show");
                    $("#budgetoamount").addClass("d-none");
                    $("#budgeto").addClass("d-none");
                    $("#amountto").val(0);
                }
            }
        });

        // check saif from
        $("#saiffrom").on("change", function() {
            $("#badgefrom").text("");
            $("#badgefromamount").text("");

            $("#badgeto").text("");
            $("#badgetoamount").text("");

            // set bankto to NA
            $("#bankfrom").prop("selectedIndex", 0);

            // bank to details
            saifto = $("#saifto option:selected");
            if ($(saifto).val() == "NA") {
                saifto = $("#bankto option:selected");
            }
            currency = $(saifto).attr("data-href");

            // bank to details
            saiffrom = $("#saiffrom option:selected");
            currency_bankfrom = $(saiffrom).attr("data-href");
            amount = $("#amount").val();

             $("#cto").val(currency);
            $("#cfrom").val(currency_bankfrom);
            if ($(saifto).val() != "NA") {
                if (currency != currency_bankfrom) {
                    $.get("../app/Controllers/banks.php", {
                            "getExchange": true,
                            "from": currency,
                            "to": currency_bankfrom
                        },
                        function(data) {
                            if (data != "false") {
                                ndata = JSON.parse(data);
                                $("#rate").val(ndata.rate);
                                if (ndata.currency_to == currency) {
                                    $("#badgetoamount").text(parseFloat(ndata.rate) * parseFloat(amount));
                                    $("#badgeto").text(ndata.currency_to);
                                    $("#amountto").val(parseFloat(ndata.rate) * parseFloat(amount));
                                } else {
                                    $("#badgetoamount").text(parseFloat((1 / ndata.rate)) * parseFloat(amount));
                                    $("#badgeto").text(ndata.currency_from);
                                    $("#amountto").val(parseFloat((1 / ndata.rate)) * parseFloat(amount));
                                     
                                }
                                $("#badgeto").removeClass("d-none");
                                $("#badgetoamount").removeClass("d-none");

                                // update from
                                $("#badgefrom").removeClass("d-none");
                                $("#badgefrom").text(currency_bankfrom);
                                $("#badgefromamount").removeClass("d-none");
                                $("#badgefromamount").text(amount);
                            } else {
                                if (!$("#erroSnackbar").hasClass("show")) {
                                    $("#erroSnackbar").addClass("show");
                                    $("#erroSnackbar").children(".snackbar-body").html(`Please add exchange from ${currency} to ${mainCurrency}`);
                                }
                            }
                        });
                } else {
                    $("#erroSnackbar").removeClass("show");
                    $("#budgetoamount").addClass("d-none");
                    $("#budgeto").addClass("d-none");
                    $("#amountto").val(0);
                }
            }
        });

        // check bank from
        $("#bankfrom").on("change", function() {
            $("#badgefrom").text("");
            $("#badgefromamount").text("");

            $("#badgeto").text("");
            $("#badgetoamount").text("");

            // set bankto to NA
            $("#saiffrom").prop("selectedIndex", 0);

            // bank to details
            saifto = $("#saifto option:selected");
            if ($(saifto).val() == "NA") {
                saifto = $("#bankto option:selected");
            }
            currency = $(saifto).attr("data-href");

            // bank to details
            saiffrom = $("#bankfrom option:selected");
            currency_bankfrom = $(saiffrom).attr("data-href");
            amount = $("#amount").val();

             $("#cto").val(currency);
            $("#cfrom").val(currency_bankfrom);

            if ($(saifto).val() != "NA") {
                if (currency != currency_bankfrom) {
                    $.get("../app/Controllers/banks.php", {
                            "getExchange": true,
                            "from": currency,
                            "to": currency_bankfrom
                        },
                        function(data) {
                            if (data != "false") {
                                ndata = JSON.parse(data);
                                $("#rate").val(ndata.rate);
                                if (ndata.currency_to == currency) {
                                    $("#badgetoamount").text(parseFloat(ndata.rate) * parseFloat(amount));
                                    $("#badgeto").text(ndata.currency_to);
                                    $("#amountto").val(parseFloat(ndata.rate) * parseFloat(amount));
                                } else {
                                    $("#badgetoamount").text(parseFloat((1 / ndata.rate)) * parseFloat(amount));
                                    $("#badgeto").text(ndata.currency_from);
                                    $("#amountto").val(parseFloat((1 / ndata.rate)) * parseFloat(amount));
                                     
                                }
                                $("#badgeto").removeClass("d-none");
                                $("#badgetoamount").removeClass("d-none");

                                // update from
                                $("#badgefrom").removeClass("d-none");
                                $("#badgefrom").text(currency_bankfrom);
                                $("#badgefromamount").removeClass("d-none");
                                $("#badgefromamount").text(amount);
                            } else {
                                if (!$("#erroSnackbar").hasClass("show")) {
                                    $("#erroSnackbar").addClass("show");
                                    $("#erroSnackbar").children(".snackbar-body").html(`Please add exchange from ${currency} to ${mainCurrency}`);
                                }
                            }
                        });
                } else {
                    $("#erroSnackbar").removeClass("show");
                    $("#budgetoamount").addClass("d-none");
                    $("#budgeto").addClass("d-none");
                    $("#amountto").val(0);
                }
            }
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

    });
</script>