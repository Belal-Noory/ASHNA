<?php
$Active_nav_name = array("parent" => "Payment & Expense", "child" => "New Payment");
$page_title = "New Payment";
include("./master/header.php");

$company = new Company();
$bussiness = new Bussiness();

$allcurrency_data = $company->GetCompanyCurrency($user_data->company_id);
$allcurrency = $allcurrency_data->fetchAll(PDO::FETCH_OBJ);

$allContacts_data = $bussiness->getCompanyCustomersWithAccounts($user_data->company_id, $user_data->user_id);
$allContacts = $allContacts_data->fetchAll(PDO::FETCH_OBJ);

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
                                    <div class="form-group">
                                        <label for="details">Description</label>
                                        <textarea id="details" class="form-control required" placeholder="Description" name="details"></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="date">Date</label>
                                                <input type="date" id="date" class="form-control required" placeholder="Date" name="date">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="currency">Currency</label>
                                                <select type="text" id="currency" class="form-control" placeholder="Currency" name="currency">
                                                    <?php
                                                    foreach ($allcurrency as $currency) {
                                                        $selected = "";
                                                        if($currency->currency == $mainCurrency){$selected = "selected";}
                                                        echo "<option value='$currency->company_currency_id'>$currency->currency</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card bg-light">
                                        <div class="card-header">
                                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                        </div>
                                        <div class="card-content">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-1">
                                                        <i class="la la-user" style="font-size: 50px;color:dodgerblue"></i>
                                                    </div>
                                                    <div class="col-lg-7">
                                                        <div class="form-group">
                                                            <label for="customer">Contact</label>
                                                            <select type="text" class="form-control chosen required" name="customer" id="customer" data-placeholder="Choose a Customer...">
                                                                <option value="" selected>Select</option>
                                                                <?php
                                                                foreach ($allContacts as $contact) {
                                                                    if($contact->currency == $mainCurrency)
                                                                    {
                                                                        echo "<option class='$contact->currency' value='$contact->chartofaccount_id' >$contact->account_name</option>";
                                                                    }else{
                                                                        echo "<option class='d-none $contact->currency' value='$contact->chartofaccount_id' >$contact->account_name</option>";
                                                                    }  
                                                                }
                                                                ?>
                                                            </select>
                                                            <label class="d-none" id="balance"></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="amount">Amount</label>
                                                            <input type="number" name="amount" id="amount" class="form-control required" placeholder="Amount">
                                                            <label class="d-none" id="currencyrate"></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="accountdetails">Details</label>
                                                            <input type="text" name="accountdetails" id="accountdetails" class="form-control" placeholder="Details">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 mb-2">
                                        <div class="pen-outer">
                                            <div class="pulldown">
                                                <h3 class="card-title mr-2">Add Payment Items</h3>
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

                                    <div class="col-lg-12 receiptItemsContainer"></div>
                                </div>

                                <div class="form-actions">
                                    <button type="button" id="btnaddreceipt" class="btn btn-info waves-effect waves-light">
                                        <i class="la la-check-square-o"></i> Save
                                    </button>
                                </div>
                                <input type="hidden" name="receptItemCounter" id="receptItemCounter" value="0">
                                <input type="hidden" name="rate" id="rate" value="0">
                                <input type="hidden" name="addreceipt" id="addreceipt">
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
                    <h5>Payment Added</h5>
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

        setInterval(function() {
            $(".alert").fadeOut();
        }, 3000);

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

        // List accounts based on selected curreny
        $("#currency").on("change",function(){
            currency = $("#currency option:selected").text();
            // hide all options of customer
            $("#customer option").addClass("d-none");
            $("#customer > option").each(function(){
                if($(this).hasClass(currency)){
                    $(this).removeClass("d-none");
                }
            });

            // hide all option of Revenue items
            $(".customer option").addClass("d-none");
            $(".customer > option").each(function(){
                if($(this).hasClass(currency)){
                    $(this).removeClass("d-none");
                }
            });

            $(".customer option").addClass("d-none");
            $(".chosen-results > li").each(function(){
                if($(this).hasClass(currency)){
                    $(this).removeClass("d-none");
                }
            });
        });

        Selected_Customer_Currency = "";
        // Load customer balance
        $("#customer").on("change", function() {
            text = $("#customer option:selected").text();
            currency = text.substring(text.lastIndexOf("-") + 1);
            Selected_Customer_Currency = currency;
            if ($(this).val() != "") {
                $.get("../app/Controllers/banks.php", {
                    "getCustomerBalance": true,
                    "cusID": $(this).val()
                }, function(data) {
                    res = $.parseJSON(data);
                    if (res.length <= 0) {
                        $("#balance").removeClass("d-none").text("Balance: 0");
                    } else {
                        debet = 0;
                        crediet = 0;

                        res.forEach(element => {
                            if (element.ammount_type == "Debet") {
                                debet += parseFloat(element.amount);
                            } else {
                                crediet += parseFloat(element.amount);
                            }
                        });
                        $("#balance").removeClass("d-none").text("Balance: " + (debet - crediet));
                    }
                });
            } else {
                $("#balance").addClass("d-none");
            }
        });

        // check if the selected recept currency is equal to the selected account currency
        $("#amount").on("blur", function() {
            console.log(Selected_Customer_Currency + "-" + $("#currency option:selected").text().trim());
            if (Selected_Customer_Currency.trim() != $("#currency option:selected").text().trim()) {
                $from_currency = $("#currency option:selected").text();
                $.get("../app/Controllers/banks.php", {
                    "getExchange": true,
                    "from": Selected_Customer_Currency.trim(),
                    "to": $from_currency
                }, function(data) {
                    ndata = $.parseJSON(data);
                    if (Object.keys(ndata).length > 0) {
                        if (Selected_Customer_Currency.trim() == ndata.currency_from.trim()) {
                            input_val = parseFloat($("#amount").val());
                            input_val *= parseFloat(ndata.rate);
                            // $("#amount").val(input_val);
                            $("#currencyrate").removeClass("d-none").text(Selected_Customer_Currency + " to " + $from_currency + " rate is : " + ndata.rate + " = " + input_val);
                            $("#rate").val(ndata.rate);
                        } else {
                            input_val = parseFloat($("#amount").val());
                            input_val /= parseFloat(ndata.rate);
                            // $("#amount").val(input_val);
                            $("#currencyrate").removeClass("d-none").text($from_currency + " to " + Selected_Customer_Currency + " rate is : " + (1 / parseFloat(ndata.rate)) + " = " + input_val);
                            $("#rate").val((1 / parseFloat(ndata.rate)));
                        }
                    } else {
                        $("#currencyrate").removeClass("d-none").text(Selected_Customer_Currency + " to " + $from_currency + " rate is not in the database, pleas add it first ");
                        $("#rate").val(0);
                    }
                });
            } else {
                $("#currencyrate").addClass("d-none").text("");
                $("#rate").val(0);
            }
        });

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

        counter = 1;
        first = true;
        // load all banks when clicked on add banks
        $(".addreciptItem").on("click", function() {
            type = $(this).attr("item");

            amoutn_name = "reciptItemAmount";
            item_name = "reciptItemID";
            details = "reciptItemdetails";

            // if its not first time that clicked this button
            if (first == false) {
                amoutn_name = "reciptItemAmount" + counter;
                item_name = "reciptItemID" + counter;
                details = "reciptItemdetails" + counter;
                $("#receptItemCounter").val(counter);
                counter++;
            }

            // check if selected payable currency is equal to 


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
                        form += "<option class='d-none " + element.currency + "' value='" + element.chartofaccount_id + "'>" + element.account_name + "</option>";
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
                form += $("#customer").html();
                form += '</select><label class="d-none balance"></label></div></div>';

            }

            form += ` <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="${amoutn_name}">Amount</label>
                                            <input type="number" name="${amoutn_name}" id="${amoutn_name}" class="form-control required receiptamount" placeholder="Amount">
                                            <label class="d-none rate"></label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="${details}">Details</label>
                                            <input type="text" name="${details}" id="${details}" class="form-control" placeholder="Details">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;

            $(".receiptItemsContainer").append(form);
            $('.chosen').chosen();
            $(".chosen-container").removeAttr("style");
            $(".chosen-container").addClass("form-control").addClass("p-0");
            $(".chosen-single").css({
                "height": "100%",
                "width": "100%"
            });
            $(".chosen-single span").css({
                "height": "100%",
                "width": "100%",
                "padding-top": "5px",
                "padding-left": "5px",
            });
            first = false;
            formReady = true;
        });

        $(document).on("click", ".deleteMore", function(e) {
            e.preventDefault();
            $(this).parent().parent().parent().parent().parent().fadeOut();
        });


        recipt_item_currency = "";
        // Load customer balance
        $(document).on("change", ".customer", function() {
            ths = $(this);
            text = $("#customer option:selected").text();
            currency = text.substring(text.lastIndexOf("-") + 1);
            if ($(ths).val() != "") {
                if ($(ths).attr("data") == "customer") {
                    $.get("../app/Controllers/banks.php", {
                        "getCustomerBalance": true,
                        "cusID": $(ths).val()
                    }, function(data) {
                        res = $.parseJSON(data);
                        if (res.length <= 0) {
                            $(ths).parent().children(".balance").removeClass("d-none").text("Balance: 0");
                            Selected_Customer_Currency = currency;
                        } else {
                            debet = 0;
                            crediet = 0;

                            res.forEach(element => {
                                if (element.ammount_type == "Debet") {
                                    debet += parseFloat(element.amount);
                                } else {
                                    crediet += parseFloat(element.amount);
                                }
                                recipt_item_currency = element.currency;
                            });
                            $(ths).parent().children(".balance").removeClass("d-none").text("Balance: " + (debet - crediet));
                        }
                    });
                }

                if ($(ths).attr("data") == "bank") {
                    $.get("../app/Controllers/banks.php", {
                        "getBalance": true,
                        "AID": $(ths).val()
                    }, function(data) {
                        res = $.parseJSON(data);
                        if (res.length <= 0) {
                            $(ths).parent().children(".balance").removeClass("d-none").text("Balance: 0");
                        } else {
                            debet = 0;
                            crediet = 0;

                            res.forEach(element => {
                                if (element.ammount_type == "Debet") {
                                    debet += parseFloat(element.amount);
                                } else {
                                    crediet += parseFloat(element.amount);
                                }
                                recipt_item_currency = element.currency;
                            });
                            $(ths).parent().children(".balance").removeClass("d-none").text("Balance: " + (debet - crediet));
                        }
                    });
                }

                if ($(ths).attr("data") == "saif") {
                    $.get("../app/Controllers/banks.php", {
                        "getBalance": true,
                        "AID": $(ths).val()
                    }, function(data) {
                        res = $.parseJSON(data);
                        if (res.length <= 0) {
                            $(ths).parent().children(".balance").removeClass("d-none").text("Balance: 0");
                        } else {
                            debet = 0;
                            crediet = 0;

                            res.forEach(element => {
                                if (element.ammount_type == "Debet") {
                                    debet += parseFloat(element.amount);
                                } else {
                                    crediet += parseFloat(element.amount);
                                }
                                recipt_item_currency = element.currency;
                            });
                            $(ths).parent().children(".balance").removeClass("d-none").text("Balance: " + (debet - crediet));
                        }
                    });
                }

            } else {
                $(ths).parent().children(".balance").addClass("d-none");
            }
        });


        $(document).on("blur", ".receiptamount", function() {
            ths = $(this);
            recipt_item_currency = $(this).parent().parent().parent().children(".col-lg-7").children(".form-group").children("select").children("option:selected").text().toString();
            recipt_item_currency = recipt_item_currency.substring(recipt_item_currency.lastIndexOf("- ") + 1);
            if (recipt_item_currency.trim() != $("#currency option:selected").text().trim()) {
                $from_currency = $("#currency option:selected").text();
                $.get("../app/Controllers/banks.php", {
                    "getExchange": true,
                    "from": $from_currency,
                    "to": recipt_item_currency
                }, function(data) {
                    ndata = $.parseJSON(data);
                    if (ndata) {
                        if ($from_currency == ndata.currency_from) {
                            alert("equal");
                            input_val = parseFloat($(ths).val());
                            input_val *= parseFloat(ndata.rate);
                            // $(ths).val(input_val);
                            $(ths).parent().children(".rate").removeClass("d-none").text($from_currency + " to " + recipt_item_currency + " rate is : " + ndata.rate + " = " + input_val);
                        } else {
                            input_val = parseFloat($(ths).val());
                            input_val /= parseFloat(ndata.rate);
                            // $(ths).val(input_val);
                            $(ths).parent().children(".rate").removeClass("d-none").text($from_currency + " to " + recipt_item_currency + " rate is : " + (1 / parseFloat(ndata.rate)) + " = " + input_val);
                        }
                    } else {
                        $(ths).parent().children(".rate").removeClass("d-none").text($from_currency + " to " + recipt_item_currency + " rate is not in the database, please add it before adding this receipt");
                    }
                });
            } else {
                $(ths).parent().children(".rate").addClass("d-none").text("");
            }
        });


        // Add recept
        $("#btnaddreceipt").on("click", function() {
            if ($(".form").valid()) {
                if (formReady) {
                    totalamount = 0;
                    var totalInputs = $(".receiptamount").each(function() {
                        totalamount += parseFloat($(this).val());
                    });

                    mianAmount = 0;

                    if ($("#currencyrate").text().length > 0) {
                        mianAmount = parseFloat($("#currencyrate").text().substring($("#currencyrate").text().lastIndexOf("=") + 1));
                    } else {
                        mianAmount = $("#amount").val();
                    }

                    if (mianAmount == totalamount) {
                        // form condition based on each payment items balances
                        let submit = false;
                        // check if a bank balance is zero
                        let balanses = $(".balance");
                        balanses.each(function() {
                            let balance = $(this).text();
                            balance = parseFloat(balance.substring(balance.lastIndexOf(": ") + 1));
                            let entered_balance = parseFloat($(this).parent().parent().parent().children("div:last").children(".form-group").children("input").val());
                            if (balance == 0 || balance < entered_balance) {
                                $(this).css("border-bottom", "1px solid red");
                                $(".receiptItemsContainer").append("<div class='alert alert-danger'>The Payment item balance is either 0 or smaller then the required amount</div>");
                                submit = false;
                            } else {
                                submit = true;
                            }
                        });

                        if (submit) {
                            $("#show").modal("show");
                            $.post("../app/Controllers/Payments.php", $(".form").serialize(), function(data) {
                                $(".container-waiting").addClass("d-none");
                                $(".container-done").removeClass("d-none");
                                setTimeout(function() {
                                    $("#show").modal("hide");
                                }, 2000);
                            });
                            $(".form")[0].reset();
                            $(".receiptItemsContainer").html("");
                        }

                    } else {
                        $(".receiptItemsContainer").append("<div class='alert alert-danger'>Payment Amount can not be greater or smaller then the paid amount</div>");
                    }

                } else {
                    $(".receiptItemsContainer").html("<div class='alert alert-danger'>Please select payment item</div>");
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