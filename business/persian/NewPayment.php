<?php
$Active_nav_name = array("parent" => "Payment & Expanse", "child" => "New Payment");
$page_title = "New Payment";
include("./master/header.php");

$company = new Company();
$bussiness = new Bussiness();

$allcurrency_data = $company->GetCompanyCurrency($user_data->company_id);
$allcurrency = $allcurrency_data->fetchAll(PDO::FETCH_OBJ);

$allContacts_data = $bussiness->getCompanyReceivableAccounts($user_data->company_id);
$allContacts = $allContacts_data->fetchAll(PDO::FETCH_OBJ);

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
                                        <label for="details">شرح</label>
                                        <textarea id="details" class="form-control required" placeholder="Description" name="details"></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="date">تاریخ</label>
                                                <input type="date" id="date" class="form-control required" placeholder="Date" name="date">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="currency">اسعار</label>
                                                <select type="text" id="currency" class="form-control" placeholder="Currency" name="currency">
                                                    <?php
                                                    foreach ($allcurrency as $currency) {
                                                        $selected = "";
                                                        if ($currency->currency == $mainCurrency) {
                                                            $selected = "selected";
                                                        }
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
                                                            <label for="customer">اشخاص</label>
                                                            <select type="text" class="form-control chosen required customer" name="customer" id="customer" data-placeholder="Choose a Customer...">
                                                                <option value="" selected>انتخاب</option>
                                                                <?php
                                                                foreach ($allContacts as $contact) {
                                                                    echo "<option class='$contact->currency' value='$contact->chartofaccount_id' data-href='$contact->customer_id'>$contact->account_name</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                            <label class="d-none" id="balance"></label>
                                                            <a href="#" class="cusKYC d-none"><span class="las la-user"></span><span></span></a>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="amount">مبلغ</label>
                                                            <input type="text" name="amount" id="amount" class="form-control required decimalNum" placeholder="Amount">
                                                            <label class="d-none" id="currencyrate"></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="accountdetails">شرح</label>
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
                                                <h3 class="card-title mr-2">افزدن پرداخت</h3>
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
                                                <div class="clac ml-2" style="display: flex;flex-direction:column">
                                                    <span>مجموعه: <span id="sum" style="color: dodgerblue; font-weight: bold;"></span></span>
                                                    <span>باقیمانده: <span id="rest" style="color: tomato; font-weight: bold;">0</span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 receiptItemsContainer"></div>
                                </div>

                                <div class="form-actions">
                                    <button type="button" id="btnaddreceipt" class="btn btn-info waves-effect waves-light">
                                        <i class="la la-check-square-o"></i> ثبت
                                    </button>
                                    <button type="button" id="btnprint" class="btn btn-info waves-effect waves-light">
                                        <i class="la la-print"></i> چاپ
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

        // Add recept
        printData = null;
        $("#btnaddreceipt").on("click", function() {
            var getUrl = window.location;
            var baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
            if ($(".form").valid()) {
                if (formReady) {
                    totalamount = parseInt($("#rest").text());
                    if (totalamount === 0) {
                        $("#show").modal("show");
                        $.post("../app/Controllers/Payments.php", $(".form").serialize(), function(data) {
                            console.log(data);
                            printData = $.parseJSON(data);
                            printData.from = $("#customer option:selected").text();
                            $(".container-waiting").addClass("d-none");
                            $(".container-done").removeClass("d-none");
                            setTimeout(function() {
                                $("#show").modal("hide");
                            }, 2000);
                            $(".form")[0].reset();
                            $(".receiptItemsContainer").html("");
                            print(printData,baseUrl);
                        });
                    } else {
                        $(".receiptItemsContainer").append("<div class='alert alert-danger'>Payment Amount can not be greater or smaller then the paid amount</div>");
                    }

                } else {
                    $(".receiptItemsContainer").html("<div class='alert alert-danger'>Please select payment item</div>");
                }
            }
        });

         // print 
         $("#btnprint").on("click", function(){
            var getUrl = window.location;
            var baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
            if(printData != null)
            {
                print(printData,baseUrl);
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