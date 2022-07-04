<?php
$Active_nav_name = array("parent" => "Payment & Expanse", "child" => "In Transference");
$page_title = "New In Tranfer";
include("./master/header.php");

$company = new Company();
$bussiness = new Bussiness();

$allcurrency_data = $company->GetCompanyCurrency($user_data->company_id);
$allcurrency = $allcurrency_data->fetchAll(PDO::FETCH_OBJ);

$all_saraf_data = $bussiness->getAllSarafs();
$all_saraf = $all_saraf_data->fetchAll(PDO::FETCH_OBJ);

$all_daily_cus_data = $bussiness->GetAllDailyCustomers();
$allDailyCus = $all_daily_cus_data->fetchAll(PDO::FETCH_OBJ);

$company_curreny_data = $company->GetCompanyCurrency($user_data->company_id);
$company_curreny = $company_curreny_data->fetchAll(PDO::FETCH_OBJ);
$mainCurrency = "";
foreach ($company_curreny as $currency) {
    if ($currency->mainCurrency) {
        $mainCurrency = $currency->currency;
    }
}
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
        top: 20px;
        left: 17%;
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
        margin: 0;
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
                                    <div class="form-group">
                                        <label for="details">Description</label>
                                        <textarea id="details" class="form-control required" placeholder="Description" name="details"></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="date">Date</label>
                                                <input type="date" id="date" class="form-control required" placeholder="Date" name="date">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="date">Transfer Code</label>
                                                <input type="text" id="transfercode" class="form-control required" placeholder="Transfer Code" name="transfercode">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="date">Voucher Code</label>
                                                <input type="text" id="vouchercode" class="form-control" placeholder="Voucher Code" name="vouchercode">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="date">Receiver Saraf</label>
                                                <select class="form-control chosen required" name="rsaraf_ID" id="rsaraf_ID" data-placeholder="Choose a Saraf...">
                                                    <option value="" selected>Select</option>
                                                    <?php
                                                    foreach ($all_saraf as $saraf) {
                                                        if ($saraf->currency == $mainCurrency) {
                                                            echo "<option class='$saraf->currency' value='$saraf->chartofaccount_id' >$saraf->fname $saraf->lname</option>";
                                                        } else {
                                                            echo "<option class='d-none $saraf->currency' value='$saraf->chartofaccount_id' >$saraf->fname $saraf->lname</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="currency">Currency</label>
                                                <select type="text" id="currency" class="form-control" placeholder="Currency" name="currency">
                                                    <?php
                                                    foreach ($allcurrency as $currency) {
                                                        $selected = $currency->currency == $mainCurrency ? "selected" : "";
                                                        echo "<option value='$currency->company_currency_id' $selected>$currency->currency</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="currency">Amount</label>
                                                <input type="number" id="amount" class="form-control required" placeholder="Amount" name="amount">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="currency">My Commission</label>
                                                <input type="number" id="mycommission" class="form-control required" placeholder="Amount" name="mycommission">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="currency">Saraf Commission</label>
                                                <input type="number" id="sarafcommission" class="form-control required" placeholder="Amount" name="sarafcommission">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="card bg-light">
                                                <div class="card-header">
                                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                                </div>
                                                <div class="card-content collapse show">
                                                    <div class="card-header">
                                                        <h3 class="card-title text-center">Sender</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="currency">Phone Number</label>
                                                            <input type="text" class="form-control required" name="sender_phone" id="sender_phone" placeholder="Phone Number" list="dailyCustomers" />
                                                            <datalist id="dailyCustomers">
                                                                <?php
                                                                foreach ($allDailyCus as $dailyCus) {
                                                                    echo "<option value='$dailyCus->personal_phone'>$dailyCus->fname $dailyCus->lname</option>";
                                                                }
                                                                ?>
                                                            </datalist>
                                                            <span class="la la-spinner spinner blue mt-1 d-none" style="font-size: 25px;"></span>
                                                        </div>
                                                        <div class="form-group d-none">
                                                            <label for="currency">First Name</label>
                                                            <input type="text" class="form-control required" name="sender_fname" id="sender_fname" placeholder="First Name" />
                                                        </div>
                                                        <div class="form-group d-none">
                                                            <label for="currency">Last Name</label>
                                                            <input type="text" class="form-control" name="sender_lname" id="sender_lname" placeholder="Last Name" />
                                                        </div>
                                                        <div class="form-group d-none">
                                                            <label for="currency">Father Name</label>
                                                            <input type="text" class="form-control" name="sender_Fathername" id="sender_Fathername" placeholder="Father Name" />
                                                        </div>
                                                        <div class="form-group d-none">
                                                            <label for="currency">NID</label>
                                                            <input type="text" class="form-control" name="sender_nid" id="sender_nid" placeholder="NID" />
                                                        </div>
                                                        <div class="form-group d-none">
                                                            <label for="details">Description</label>
                                                            <textarea id="sender_details" class="form-control" placeholder="Description" name="sender_details"></textarea>
                                                        </div>
                                                        <input type="hidden" name="addsender" id="addsender" value="true">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="card bg-light">
                                                <div class="card-header">
                                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                                </div>
                                                <div class="card-content collapse show">
                                                    <div class="card-header">
                                                        <h3 class="card-title text-center">Receiver</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="currency">Phone Number</label>
                                                            <input type="text" list="dailyCustomers2" class="form-control required" name="receiver_phone" id="receiver_phone" placeholder="Phone Number" />
                                                            <datalist id="dailyCustomers2">
                                                                <?php
                                                                foreach ($allDailyCus as $dailyCus) {
                                                                    echo "<option value='$dailyCus->personal_phone'>$dailyCus->fname $dailyCus->lname</option>";
                                                                }
                                                                ?>
                                                            </datalist>
                                                            <span class="la la-spinner spinner blue mt-1 d-none" style="font-size: 25px;"></span>
                                                        </div>
                                                        <div class="form-group d-none">
                                                            <label for="currency">First Name</label>
                                                            <input type="text" class="form-control required" name="receiver_fname" id="receiver_fname" placeholder="First Name" />
                                                        </div>
                                                        <div class="form-group d-none">
                                                            <label for="currency">Last Name</label>
                                                            <input type="text" class="form-control" name="receiver_lname" id="receiver_lname" placeholder="Last Name" />
                                                        </div>
                                                        <div class="form-group d-none">
                                                            <label for="currency">Father Name</label>
                                                            <input type="text" class="form-control" name="receiver_Fathername" id="receiver_Fathername" placeholder="Father Name" />
                                                        </div>
                                                        <div class="form-group d-none">
                                                            <label for="currency">NID</label>
                                                            <input type="text" class="form-control" name="receiver_nid" id="receiver_nid" placeholder="NID" />
                                                        </div>
                                                        <div class="form-group d-none">
                                                            <label for="details">Description</label>
                                                            <textarea id="receiver_details" class="form-control" placeholder="Description" name="receiver_details"></textarea>
                                                        </div>
                                                        <input type="hidden" name="addreceiver" id="addreceiver" value="true">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 error d-none">
                                            <span class="alert alert-danger"></span>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 mb-2">
                                        <div class="pen-outer">
                                            <div class="pulldown">
                                                <h3 class="card-title mr-2">Payment Type</h3>
                                                <div class="pulldown-toggle pulldown-toggle-round">
                                                    <i class="la la-plus"></i>
                                                </div>
                                                <div class="pulldown-menu">
                                                    <ul>
                                                        <li class="addreciptItem" item="bank">
                                                            <i class="la la-bank" style="font-size:30px;color:white"></i>
                                                        </li>
                                                        <li class="addreciptItem" item="saif">
                                                            <i class="la la-box" style="font-size:30px;color:white"></i>
                                                        </li>
                                                        <li class="addreciptItem" item="customer">
                                                            <i class="la la-user" style="font-size:30px;color:white"></i>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 paymentContainer"></div>
                                </div>

                                <div class="form-actions">
                                    <button type="button" id="btnaddouttransfere" class="btn btn-info waves-effect waves-light">
                                        <i class="la la-check-square-o"></i> Save
                                    </button>
                                </div>
                                <input type="hidden" name="paymentIDcounter" id="paymentIDcounter" value="0">
                                <input type="hidden" name="addintransfer">
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
                    <h5>Transfere Added</h5>
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
        // Add More button codes
        // reference to last opened menu
        var $lastOpened = false;

        // simply close the last opened menu on document click
        $(document).click(function() {
            if ($lastOpened) {
                $lastOpened.removeClass('open');
            }
        });

        // simple event delegation
        $(document).on('click', '.pulldown-toggle', function(event) {

            // jquery wrap the el
            var el = $(event.currentTarget);

            // prevent this from propagating up
            event.preventDefault();
            event.stopPropagation();

            // check for open state
            if (el.hasClass('open')) {
                el.removeClass('open');
            } else {
                if ($lastOpened) {
                    $lastOpened.removeClass('open');
                }
                el.addClass('open');
                $lastOpened = el;
            }

        });

        // Load company Banks
        bankslist = Array();
        $.get("../app/Controllers/banks.php", {
            "getcompanyBanks": true
        }, function(data) {
            newdata = $.parseJSON(data);
            bankslist = newdata;
        });

        // Load company Saifs
        saiflist = Array();
        $.get("../app/Controllers/banks.php", {
            "getcompanySafis": true
        }, function(data) {
            newdata = $.parseJSON(data);
            saiflist = newdata;
        });

        // Load company Customers
        cuslist = Array();
        $.get("../app/Controllers/banks.php", {
            "getcompanyCustomers": true
        }, function(data) {
            newdata = $.parseJSON(data);
            cuslist = newdata;
        });

        // List accounts based on selected curreny
        $("#currency").on("change", function() {
            currency = $("#currency option:selected").text();
            // hide all options of customer
            $("#rsaraf_ID option").addClass("d-none");
            $(".customer option").addClass("d-none");

            $("#rsaraf_ID > option").each(function() {
                if ($(this).hasClass(currency)) {
                    $(this).removeClass("d-none");
                }
            });

            // hide all option of receipt items
            $(".customer > option").each(function() {
                if ($(this).hasClass(currency)) {
                    $(this).removeClass("d-none");
                }
            });
        });

        counter = 1;
        first = true;
        formReady = false;
        // load all banks when clicked on add banks
        $(".addreciptItem").on("click", function() {
            type = $(this).attr("item");

            item_name = "paymentID";
            item_amount = "payment_amount";
            details = "reciptItemdetails";
            // if its not first time that clicked this button
            if (first == false) {
                item_name += counter;
                item_amount += counter;
                details = "reciptItemdetails" + counter;
                $("#paymentIDcounter").val(counter);
                counter++;
            }

            form = `<div class='card bg-light'>
                        <div class="card-header">
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a class='deleteMore' href='#'><i class="ft-x"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-1">`;

            if (type == "bank") {
                form += `<i class="la la-bank" style="font-size: 50px;color:dodgerblue"></i></div>
                                                    <div class="col-lg-7">
                                                        <div class="form-group">
                                                            <label for="${item_name}">Bank</label>
                                                            <select class="form-control chosen required customer" name="${item_name}" id="${item_name}" data='bank'>
                                                                <option value="" selected>Select</option>`;
                bankslist.forEach(element => {
                    if (element.currency == $("#currency option:selected").text()) {
                        form += "<option class='" + element.currency + "' value='" + element.chartofaccount_id + "'>" + element.account_name + "</option>";
                    } else {
                        form += "<option class='d-none " + element.currency + "' value='" + element.chartofaccount_id + "'>" + element.account_name + "</option>";
                    }
                });
                form += `</select><label class="d-none balance"></label>
                            </div>
                        </div>`;
            }
            if (type == "saif") {
                form += `<i class="la la-box" style="font-size: 50px;color:dodgerblue"></i></div>
                                                    <div class="col-lg-7">
                                                        <div class="form-group">
                                                            <label for="${item_name}">Saif</label>
                                                            <select class="form-control chosen required customer" name="${item_name}" id="${item_name}" data='saif'>
                                                                <option value="" selected>Select</option>`;
                saiflist.forEach(element => {
                    if (element.currency == $("#currency option:selected").text()) {
                        form += "<option class='" + element.currency + "' value='" + element.chartofaccount_id + "'>" + element.account_name + "</option>";
                    } else {
                        form += "<option class='d-none '" + element.currency + "' value='" + element.chartofaccount_id + "'>" + element.account_name + "</option>";
                    }
                });
                form += `</select><label class="d-none balance"></label>
                            </div>
                        </div>`;
            }

            if (type == "customer") {
                form += `<i class="la la-user" style="font-size: 50px;color:dodgerblue"></i></div>
                                                    <div class="col-lg-7">
                                                        <div class="form-group">
                                                            <label for="${item_name}">Contact</label>
                                                            <select class="form-control chosen required customer" name="${item_name}" id="${item_name}" data='customer'>`;
                cuslist.forEach(element => {
                    if (element.currency == $("#currency option:selected").text()) {
                        form += "<option class='" + element.currency + "' value='" + element.chartofaccount_id + "'>" + element.account_name + "</option>";
                    } else {
                        form += "<option class='d-none '" + element.currency + "' value='" + element.chartofaccount_id + "'>" + element.account_name + "</option>";
                    }
                });
                form += '</select></label></div></div>';

            }

            details = $("#details").val();
            amount = $("#amount").val();
            form += ` <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="${item_amount}">Amount</label>
                                            <input type="number" name="${item_amount}" id="${item_amount}" class="form-control required receiptamount" value='${amount}' placeholder="Amount">
                                            <label class="d-none rate"></label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="${details}">Details</label>
                                            <input type="text" name="${details}" id="${details}" class="form-control details" placeholder="Details" value='${details}'>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;

            $(".paymentContainer").append(form);
            formReady = true;
            first = false;
        });

        $("#details").on("keyup", function() {
            $(".details").val($(this).val());
        });

        $("#amount").on("keyup", function() {
            $(".receiptamount").val($(this).val());
        });

        $(document).on("click", ".deleteMore", function(e) {
            e.preventDefault();
            $(this).parent().parent().parent().parent().parent().fadeOut();
        });

        // check sender daily customer based on phone number
        $("#sender_phone").on("blur", function() {
            phone = $(this).val();
            ths = $(this);
            $(ths).parent().children("span.la").removeClass("d-none");

            $.get("../app/Controllers/Bussiness.php", {
                "getDailyCus": true,
                "dailyCusID": phone
            }, function(data) {
                ndata = $.parseJSON(data);
                if (ndata.length > 0) {
                    $(ths).parent().parent().children(".form-group").children("input#sender_fname").val(ndata[0].fname);
                    $(ths).parent().parent().children(".form-group").children("#sender_lname").val(ndata[0].lname);
                    $(ths).parent().parent().children(".form-group").children("#sender_Fathername").val(ndata[0].alies_name);
                    $(ths).parent().parent().children(".form-group").children("#sender_nid").val(ndata[0].NID);
                    $(ths).parent().parent().children(".form-group").children("#sender_details").val(ndata[0].details);
                    $(ths).parent().parent().children("#addsender").val("false");
                } else {
                    $(ths).parent().parent().children(".form-group").each(function() {
                        $(this).find("input:not(#sender_phone)").val("");
                    });
                    $(ths).parent().parent().children("#addsender").val("true");
                }
            });
            $(ths).parent().parent().children(".form-group").removeClass("d-none");
            $(ths).parent().children("span.la").addClass("d-none");
        });

        // check receiver daily customer based on phone number
        $("#receiver_phone").on("blur", function() {
            phone = $(this).val();
            ths = $(this);
            $(ths).parent().children("span.la").removeClass("d-none");

            $.get("../app/Controllers/Bussiness.php", {
                "getDailyCus": true,
                "dailyCusID": phone
            }, function(data) {
                ndata = $.parseJSON(data);
                if (ndata.length > 0) {
                    $(ths).parent().parent().children(".form-group").children("#receiver_fname").val(ndata[0].fname);
                    $(ths).parent().parent().children(".form-group").children("#receiver_lname").val(ndata[0].lname);
                    $(ths).parent().parent().children(".form-group").children("#receiver_Fathername").val(ndata[0].alies_name);
                    $(ths).parent().parent().children(".form-group").children("#receiver_nid").val(ndata[0].NID);
                    $(ths).parent().parent().children(".form-group").children("#receiver_details").val(ndata[0].details);
                    $(ths).parent().parent().children("#addreceiver").val("false");
                } else {
                    $(ths).parent().parent().children(".form-group").each(function() {
                        $(this).find("input:not(#receiver_phone").val("");
                    });
                    $(ths).parent().parent().children("#addreceiver").val("true");
                }
            });
            $(ths).parent().parent().children(".form-group").removeClass("d-none");
            $(ths).parent().children("span.la").addClass("d-none");
        });

        // check for block nids
        receiver_nid_blocked = false;
        $("#receiver_nid").on("blur", function() {
            nid = $(this).val();
            $.get("../app/Controllers/Bussiness.php", {
                "checkNID": nid
            }, function(data) {
                ndata = $.parseJSON(data);
                if (ndata.length > 0) {
                    receiver_nid_blocked = true;
                    $(".error").removeClass("d-none").children("span").text("Receiver NID is blocked please check it again");
                }
            });
        });

        // check for block nids
        sender_nid_blocked = false;
        $("#sender_nid").on("blur", function() {
            nid = $(this).val();
            $.get("../app/Controllers/Bussiness.php", {
                "checkNID": nid
            }, function(data) {
                ndata = $.parseJSON(data);
                if (ndata.length > 0) {
                    sender_nid_blocked = true;
                    $(".error").removeClass("d-none").children("span").text("Sender NID is blocked please check it again");
                }
            });
        });

        // Add Out Transfere
        $("#btnaddouttransfere").on("click", function() {
            if ($(".form").valid()) {
                if (receiver_nid_blocked == false && sender_nid_blocked == false) {
                    $(".error").addClass("d-none");
                    $("#show").modal("show");
                    $.post("../app/Controllers/Transfer.php", $(".form").serialize(), function(data) {
                        $(".container-waiting").addClass("d-none");
                        $(".container-done").removeClass("d-none");
                        setTimeout(function() {
                            $("#show").modal("hide");
                        }, 2000);
                        $(".paymentContainer").html("");
                        $(".form")[0].reset();
                    });

                } else {
                    $(".error").removeClass("d-none").children("span").text("One of NID is blocked please check it again");
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