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
?>
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="col-lg-12">
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date">Date</label>
                                            <input type="date" id="date" class="form-control required" placeholder="First Name" name="date">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="saifamount">Amount</label>
                                            <input type="number" class="form-control required" name="amount" id="amount" placeholder="Amount">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Currency">Currency</label>
                                            <select id="Currency" name="Currency" class="form-control">
                                                <option value="NA" selected>Select Currency</option>
                                                <?php
                                                foreach ($currency as $cur) {
                                                    echo "<option value='$cur->company_currency_id'>$cur->currency</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rate">Currency Rate</label>
                                            <input type="number" class="form-control required" name="rate" id="rate" placeholder="Currency Rate" value="0">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="details">Description</label>
                                            <textarea id="details" rows="5" class="form-control required" name="details" placeholder="Description"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card-content">
                                            <div class="card-header">
                                                <h4 class="card-title" id="basic-layout-colored-form-control">From</h4>
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
                                                                <select id="bank" name="bankfrom" class="form-control">
                                                                    <option value="NA" selected>Select Bank</option>
                                                                    <?php
                                                                    foreach ($allBanks as $bank) {
                                                                        echo "<option value='$bank->chartofaccount_id'>$bank->account_name - $bank->account_type - $bank->currency</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane" id="saifPanel" role="tabpanel" aria-labelledby="saif-tab" aria-expanded="false">
                                                            <div class="form-group">
                                                                <label for="saif">Saif</label>
                                                                <select id="saif" name="saiffrom" class="form-control">
                                                                    <option value="NA" selected>Select Saif</option>
                                                                    <?php
                                                                    foreach ($allSaifs as $saif) {
                                                                        echo "<option value='$saif->chartofaccount_id'>$saif->account_name - $saif->account_type - $saif->currency</option>";
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
                                                <h4 class="card-title" id="basic-layout-colored-form-control">To</h4>
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
                                                                <select id="bank" name="bankto" class="form-control">
                                                                    <option value="NA" selected>Select Bank</option>
                                                                    <?php
                                                                    foreach ($allBanks as $bank) {
                                                                        echo "<option value='$bank->chartofaccount_id'>$bank->account_name - $bank->account_type - $bank->currency</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane" id="saifPanelTo" role="tabpanel" aria-labelledby="saif-tab-to" aria-expanded="false">
                                                            <div class="form-group">
                                                                <label for="saif">Saif</label>
                                                                <select id="saif" name="saifto" class="form-control">
                                                                    <option value="NA" selected>Select Saif</option>
                                                                    <?php
                                                                    foreach ($allSaifs as $saif) {
                                                                        echo "<option value='$saif->chartofaccount_id'>$saif->account_name - $saif->account_type - $saif->currency</option>";
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
                        </form>
                        <span class="alert alert-danger d-none"></span>
                    </div>
                </div>
            </div>
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
                    <h5>Transfered Successfully</h5>
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

        setInterval(() => {
            // $(".alert").addClass("d-none");
            $("#show").modal("hide");
        }, 2000);

        $("#btnaddtransfer").on("click", function(e) {
            e.preventDefault();
            if ($(".form").valid()) {
                $("#show").modal("show");
                $(".container-waiting").addClass("d-none");
                $(".container-done").removeClass("d-none");
                console.log($(".form").serialize());
                $.post("../app/Controllers/banks.php", $(".form").serialize(), (data) => {
                    $(".form")[0].reset();
                    if (data != "done") {
                        $(".alert").removeClass("d-none");
                        $(".alert").text(data);
                    }
                });
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