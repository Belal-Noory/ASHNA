<?php
$Active_nav_name = array("parent" => "Banking", "child" => "Exchange");
$page_title = "New Exchange";
include("./master/header.php");

$company = new Company();
$bussiness = new Bussiness();
$bank = new Banks();

$allcurrency_data = $company->GetCompanyCurrency($user_data->company_id);
$allcurrency = $allcurrency_data->fetchAll(PDO::FETCH_OBJ);
$mainCurrency = "";

$allContacts_data = $bussiness->getCompanyCustomersWithAccounts($user_data->company_id, $user_data->user_id);
$allContacts = $allContacts_data->fetchAll(PDO::FETCH_OBJ);

// get all banks
$all_banks_data = $bank->getBanks($user_data->company_id);
$all_banks = $all_banks->fetchAll(PDO::FETCH_OBJ);

// 
?>

<style>
    .pulldown {
        display: flex;
        flex-direction: row;
        align-items: center;
    }

    .pulldown .pulldown-toggle-round {
        box-shadow: 0 4px 5px 0 rgba(0, 0, 0, .14), 0 1px 10px 0 rgba(0, 0, 0, .12), 0 2px 4px -1px rgba(0, 0, 0, .2)
    }

    /* Styles for our pulldown menus */

    .pulldown {
        position: relative;
    }

    .pulldown .pulldown-toggle {
        cursor: pointer;
    }

    .pulldown .pulldown-toggle-round {
        height: 50px;
        width: 50px;
        border-radius: 60px;
        cursor: pointer;
        text-align: center;
        background: #ff1744;
        -webkit-transition: .35s ease-in-out;
        -moz-transition: .35s ease-in-out;
        -o-transition: .35s ease-in-out;
    }

    .pulldown .pulldown-toggle.open {
        transform: rotate(270deg);
        background: #78909c;
    }

    .pulldown-toggle.pulldown-toggle-round i {
        line-height: 50px;
        color: #FFF;
        font-size: 30px;
    }

    .pulldown .pulldown-menu {
        position: absolute;
        top: 40px;
        left: 20%;
        width: 180px;
        background-color: #fff;
        border-radius: 1px;
        display: none;
        z-index: 10;
        box-shadow: 0px 2px 12px rgba(0, 0, 0, .2);
    }

    .pulldown-right .pulldown-menu {
        left: auto;
        right: 0px;
    }

    .pulldown-toggle.open+.pulldown-menu {
        display: block;
        -webkit-animation-name: openPullDown;
        animation-name: openPullDown;
        -webkit-animation-duration: 500ms;
        animation-duration: 500ms;
        -webkit-animation-fill-mode: both;
        animation-fill-mode: both;
        -webkit-transform-origin: left top;
        transform-origin: left top;
    }

    .pulldown-right .pulldown-toggle.open+.pulldown-menu {
        -webkit-transform-origin: right top;
        transform-origin: right top;
    }

    .pulldown-menu ul {
        list-style: none;
        padding: 0;
        margin: 8px 0;
        background: transparent;
        position: absolute;
        display: flex;
        flex-direction: row;

    }

    .pulldown-menu ul li {
        background-color: dodgerblue;
        padding: 0;
        margin: 4px;
        height: fit-content;
        width: fit-content;
        border-radius: 50%;
        padding: 6px;
    }

    .pulldown-menu ul li:hover {
        cursor: pointer;
        transform: scale(1.09);
    }

    @media (max-width: 550px) {
        .pulldown-toggle.open+.pulldown-menu {
            -webkit-animation-name: openPullDownMobile;
            animation-name: openPullDownMobile;
            -webkit-animation-duration: 200ms;
            animation-duration: 200ms;
        }
    }


    /*
    |
    | Grow from origin
    |
    */

    @-webkit-keyframes openPullDown {
        0% {
            opacity: 0;
            -webkit-transform: scale(.7);
            transform: scale(.7);
        }

        100% {
            opacity: 1;
            -webkit-transform: scale(1);
            transform: scale(1);
        }
    }

    @keyframes openPullDown {
        0% {
            opacity: 0;
            -webkit-transform: scale(.7);
            -ms-transform: scale(.7);
            transform: scale(.7);
        }

        100% {
            opacity: 1;
            -webkit-transform: scale(1);
            -ms-transform: scale(1);
            transform: scale(1);
        }
    }


    /*
    |
    | Slide up from bottom
    |
    */

    @-webkit-keyframes openPullDownMobile {
        0% {
            -webkit-transform: translate(0%, 100%);
            transform: translate(0%, 100%);
        }

        100% {
            -webkit-transform: translate(0%, 0%);
            transform: translate(0%, 0%);
        }
    }

    @keyframes openPullDownMobile {
        0% {
            -webkit-transform: translate(0%, 100%);
            -ms-transform: translate(0%, 100%);
            transform: translate(0%, 100%);
        }

        100% {
            -webkit-transform: translate(0%, 0%);
            -ms-transform: translate(0%, 0%);
            transform: translate(0%, 0%);
        }
    }
</style>

<!-- END: Main Menu-->
<!-- BEGIN: Content-->
<div class="container pt-5">
    <section id="basic-form-layouts">
        <div class="row match-height">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
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
                                                <input type="date" id="date" class="form-control required" placeholder="Date" name="date">
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <label for="details">Description</label>
                                                <textarea id="details" class="form-control required border-0" placeholder="Description" rows="1" name="details"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="currencyfrom">Currency From</label>
                                                <select type="text" id="currencyfrom" class="form-control required" placeholder="Currency From" name="currencyfrom">
                                                    <option value="0">Select</option>
                                                    <?php
                                                    foreach ($allcurrency as $currency) {
                                                        $mainCurrency = $currency->mainCurrency == 1 ? $currency->currency : $mainCurrency;
                                                        $selected = $currency->mainCurrency == 1 ? "selected" : "";
                                                        echo "<option value='$currency->company_currency_id' $selected>$currency->currency</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="currencyto">Currency To</label>
                                                <select type="text" id="exchangecurrencyto" class="form-control required" placeholder="Currency To" name="exchangecurrencyto">
                                                    <option value="0">Select</option>
                                                    <?php
                                                    foreach ($allcurrency as $currency) {
                                                        $selected = $currency->currency == $mainCurrency ? "selected" : "";
                                                        echo "<option value='$currency->company_currency_id' $selected>$currency->currency</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="amount">Amount</label>
                                                <input type="number" id="amount" class="form-control required" placeholder="Amount" name="amount" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="customer">Contact</label>
                                                <select type="text" class="form-control chosen required" name="customer" id="customer" data-placeholder="Choose a Customer...">
                                                    <option value="" selected>Select</option>
                                                    <?php
                                                    foreach ($allContacts as $contact) {
                                                        if ($contact->currency == $mainCurrency) {
                                                            echo "<option class='$contact->currency' value='$contact->chartofaccount_id' >$contact->account_name</option>";
                                                        } else {
                                                            echo "<option class='d-none $contact->currency' value='$contact->chartofaccount_id' >$contact->account_name</option>";
                                                        }
                                                    }
                                                    ?>
                                                    <option value="0">NA</option>
                                                </select>
                                                <label class="d-none" id="balance"></label>
                                            </div>
                                            <div class="bs-callout-primary mb-2">
                                                <div class="media align-items-stretch">
                                                    <div class="media-left media-middle bg-pink d-flex align-items-center p-2">
                                                        <i class="la la-sun-o white font-medium-5"></i>
                                                    </div>
                                                    <div class="media-body p-1">
                                                        <strong>Attention Please!</strong>
                                                        <p>If customer is not registered in the system, please select NA</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="rate">Exchange Rate</label>
                                                <input type="number" id="rate" class="form-control required" placeholder="Exchange Rate" name="rate" />
                                            </div>
                                            <div class="bs-callout-primary mb-2">
                                                <div class="media align-items-stretch">
                                                    <div class="media-left media-middle bg-pink d-flex align-items-center p-2">
                                                        <i class="la la-sun-o white font-medium-5"></i>
                                                    </div>
                                                    <div class="media-body p-1">
                                                        <strong>Attention Please!</strong>
                                                        <p>If exchange rate was not in the database, please enter it manually</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="button" id="btnaddreceipt" class="btn btn-info waves-effect waves-light">
                                        <i class="la la-check-square-o"></i> Save
                                    </button>
                                </div>
                                <input type="hidden" name="addexchangeMoney" id="addexchangeMoney">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- END: Content-->

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
                    <h5>Successfully Added</h5>
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
        formReady = false;
        setInterval(function() {
            $(".alert").fadeOut();
        }, 3000);

        $("#exchangecurrencyto").on("change", function() {
            from = $("#currencyfrom option:selected").text();
            to = $("#currencyto option:selected").text();
            if (from != "Select" && to != "Select") {
                $.get("../app/Controllers/banks.php", {
                    "getExchange": true,
                    "from": from,
                    "to": to
                }, function(data) {
                    ndata = $.parseJSON(data);
                    $("#rate").val(ndata.rate);
                });
            }
        });


        // Add recept
        $("#btnaddreceipt").on("click", function() {
            if ($(".form").valid()) {
                if (formReady) {
                    $("#show").modal("show");
                    $.post("../app/Controllers/banks.php", $(".form").serialize(), function(data) {
                        $(".container-waiting").addClass("d-none");
                        $(".container-done").removeClass("d-none");
                        setTimeout(function() {
                            $("#show").modal("hide");
                        }, 2000);
                    });
                    $(".form")[0].reset();
                    $(".receiptItemsContainer").html("");

                } else {
                    $(".receiptItemsContainer").html("<div class='alert alert-danger'>Please select receipt item</div>");
                }
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