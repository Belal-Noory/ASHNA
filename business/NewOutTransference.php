<?php
$Active_nav_name = array("parent" => "Receipt & Revenue", "child" => "Out Transference");
$page_title = "New Out Transference";
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
<div class="container p-1">
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
                            <form class="outtransferform">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label for="details">Description</label>
                                        <textarea id="details" class="form-control required" rows="1" placeholder="Description" name="details" style="border:none; border-bottom:1px solid gray"></textarea>
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
                                                <label for="date">Receiver Saraf</label>
                                                <select class="form-control chosen required" name="rsaraf_ID" id="rsaraf_ID" data-placeholder="Choose a Saraf...">
                                                    <option value="" selected>Select</option>
                                                    <?php
                                                    foreach ($all_saraf as $saraf) {
                                                        echo "<option class='$saraf->currency' value='$saraf->chartofaccount_id' data-href='$saraf->cutomer_id' >$saraf->fname $saraf->lname</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="date">Transfer Code</label>
                                                <input type="text" id="transfercode" class="form-control" placeholder="Transfer Code" name="transfercode" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="date">Voucher Code</label>
                                                <input type="text" id="vouchercode" class="form-control" placeholder="Voucher Code" name="vouchercode" value="0">
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
                                                <input type="number" id="tamount" class="form-control required" placeholder="Amount" name="tamount" value="0">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="currency">My Commission</label>
                                                <input type="number" id="mycommission" class="form-control required" placeholder="Amount" name="mycommission" prev="0" value="0">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="currency">Saraf Commission</label>
                                                <input type="number" id="sarafcommission" class="form-control required" placeholder="Amount" name="sarafcommission" prev="0" value="0">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row pt-0 pb-0 pl-1 pr-1">
                                        <div class="col-lg-6 p-0 pr-1">
                                            <div class="card bg-light p-0">
                                                <h3 class="card-title text-center pt-1">Sender</h3>
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="currency">Phone Number</label>
                                                        <input type="text" class="form-control" name="sender_phone" id="sender_phone" placeholder="Phone Number" list="dailyCustomers" />
                                                        <datalist id="dailyCustomers">
                                                            <?php
                                                            foreach ($allDailyCus as $dailyCus) {
                                                                echo "<option value='$dailyCus->personal_phone'>$dailyCus->fname $dailyCus->lname</option>";
                                                            }
                                                            ?>
                                                        </datalist>
                                                        <span class="la la-spinner spinner blue mt-1 d-none" style="font-size: 25px;"></span>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group d-none col-md-6 col-xs-12">
                                                            <label for="currency">First Name</label>
                                                            <input type="text" class="form-control required" name="sender_fname" id="sender_fname" placeholder="First Name" />
                                                        </div>
                                                        <div class="form-group d-none col-md-6 col-xs-12">
                                                            <label for="currency">Last Name</label>
                                                            <input type="text" class="form-control" name="sender_lname" id="sender_lname" placeholder="Last Name" />
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="form-group d-none col-md-6 col-xs-12">
                                                            <label for="currency">Father Name</label>
                                                            <input type="text" class="form-control" name="sender_Fathername" id="sender_Fathername" placeholder="Father Name" />
                                                        </div>
                                                        <div class="form-group d-none col-md-6 col-xs-12">
                                                            <label for="currency">NID</label>
                                                            <input type="text" class="form-control" name="sender_nid" id="sender_nid" placeholder="NID" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group d-none">
                                                        <label for="details">Description</label>
                                                        <textarea id="sender_details" class="form-control" rows="1" style="border:none; border-bottom:1px solid gray" placeholder="Description" name="sender_details"></textarea>
                                                    </div>
                                                    <div class="attachContainer d-none">
                                                        <div class='form-group attachement'>
                                                            <div class="d-flex justify-content-between align-items-center senderAttach">
                                                                <div class="form-group">
                                                                    <label for='attachmentsender'>
                                                                        <span class='las la-file-upload blue'></span>
                                                                    </label>
                                                                    <i id='filename'>filename</i>
                                                                    <input type='file' class='form-control d-none attachInput' id='attachmentsender' name='attachmentsender' />
                                                                </div>
                                                                <div class="form-group">
                                                                    <select type="text" id="attachTypesender" class="form-control" placeholder="Type" name="attachTypesender">
                                                                        <option value="NID">NID</option>
                                                                        <option value="Passport">Passport</option>
                                                                        <option value="Driving license">Driving license</option>
                                                                        <option value="Company license">Company license</option>
                                                                        <option value="TIN">TIN</option>
                                                                        <option value="Other">Other</option>
                                                                    </select>
                                                                </div>
                                                                <span></span>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn btn-blue" id="btnaddsenderattach"><span class="las la-plus"></span></button>
                                                    </div>
                                                    <input type="hidden" name="attachCountsender" id="attachCountsender" value="0">
                                                    <input type="hidden" name="addsender" id="addsender" value="true">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 p-0">
                                            <div class="card bg-light p-0 pl-1">
                                                <h3 class="card-title text-center pt-1">Receiver</h3>
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="currency">Phone Number</label>
                                                        <input type="text" list="dailyCustomers2" class="form-control" name="receiver_phone" id="receiver_phone" placeholder="Phone Number" />
                                                        <datalist id="dailyCustomers2">
                                                            <?php
                                                            foreach ($allDailyCus as $dailyCus) {
                                                                echo "<option value='$dailyCus->personal_phone'>$dailyCus->fname $dailyCus->lname</option>";
                                                            }
                                                            ?>
                                                        </datalist>
                                                        <span class="la la-spinner spinner blue mt-1 d-none" style="font-size: 25px;"></span>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group d-none col-md-6 col-xs-12">
                                                            <label for="currency">First Name</label>
                                                            <input type="text" class="form-control required" name="receiver_fname" id="receiver_fname" placeholder="First Name" />
                                                        </div>
                                                        <div class="form-group d-none col-md-6 col-xs-12">
                                                            <label for="currency">Last Name</label>
                                                            <input type="text" class="form-control" name="receiver_lname" id="receiver_lname" placeholder="Last Name" />
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group d-none col-md-6 col-xs-12">
                                                            <label for="currency">Father Name</label>
                                                            <input type="text" class="form-control" name="receiver_Fathername" id="receiver_Fathername" placeholder="Father Name" />
                                                        </div>
                                                        <div class="form-group d-none col-md-6 col-xs-12">
                                                            <label for="currency">NID</label>
                                                            <input type="text" class="form-control" name="receiver_nid" id="receiver_nid" placeholder="NID" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group d-none">
                                                        <label for="details">Description</label>
                                                        <textarea id="receiver_details" class="form-control p-0" rows="1" style="border:none; border-bottom:1px solid gray" placeholder="Description" name="receiver_details"></textarea>
                                                    </div>
                                                    <div class="attachContainer d-none">
                                                        <div class='form-group attachement'>
                                                            <div class="d-flex justify-content-between align-items-center receiverAttach">
                                                                <div class="form-group">
                                                                    <label for='attachmentreceiver'>
                                                                        <span class='las la-file-upload blue'></span>
                                                                    </label>
                                                                    <i id='filename'>filename</i>
                                                                    <input type='file' class='form-control d-none attachInput' id='attachmentreceiver' name='attachmentreceiver' />
                                                                </div>
                                                                <div class="form-group">
                                                                    <select type="text" id="attachTypereceiver" class="form-control" placeholder="Type" name="attachTypereceiver">
                                                                        <option value="NID">NID</option>
                                                                        <option value="Passport">Passport</option>
                                                                        <option value="Driving license">Driving license</option>
                                                                        <option value="Company license">Company license</option>
                                                                        <option value="TIN">TIN</option>
                                                                        <option value="Other">Other</option>
                                                                    </select>
                                                                </div>
                                                                <span></span>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn btn-blue" id="btnaddreceiverattach"><span class="las la-plus"></span></button>
                                                    </div>
                                                    <input type="hidden" name="attachCountreceiver" id="attachCountreceiver" value="0">
                                                    <input type="hidden" name="addreceiver" id="addreceiver" value="true">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 error d-none">
                                            <span class="alert alert-danger"></span>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 mb-1 mt-0">
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
                                                <div class="clac ml-2" style="display: flex;flex-direction:column">
                                                    <span>Sum: <span id="sum" style="color: dodgerblue; font-weight: bold;"></span></span>
                                                    <span>Rest: <span id="rest" style="color: tomato; font-weight: bold;">0</span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 paymentContainer"></div>
                                </div>

                                <div class="form-actions">
                                    <button type="submit" id="btnaddouttransfere" class="btn btn-info waves-effect waves-light">
                                        <i class="la la-check-square-o"></i> Save
                                    </button>
                                </div>
                                <input type="hidden" name="paymentIDcounter" id="paymentIDcounter" value="0">
                                <input type="hidden" name="addouttransfer">
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
        senderCounter = 1;
        $("#btnaddsenderattach").on("click", function() {
            name = "attachmentsender" + senderCounter;
            type = "attachTypesender" + senderCounter;
            if (senderCounter < 6) {
                form = `<div class="d-flex justify-content-between align-items-center">
                            <div class="form-group">
                                <label for='${name}'>
                                    <span class='las la-file-upload blue'></span>
                                </label>
                                <i id='filename'>filename</i>
                                <input type='file' class='form-control d-none attachInput' id='${name}' name='${name}' />
                            </div>
                            <div class="form-group">
                                <select type="text" id="${type}" class="form-control" placeholder="Type" name="${type}">
                                    <option value="NID">NID</option>
                                    <option value="Passport">Passport</option>
                                    <option value="Driving license">Driving license</option>
                                    <option value="Company license">Company license</option>
                                    <option value="TIN">TIN</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <a href='#' class='deletedailyattachsender' style='font-size:25px'><span class='las la-trash danger'></span></a>
                    </div>
                `
                $(".senderAttach").parent().append(form);
                $("#attachCountsender").val(senderCounter);
                senderCounter++;
            } else {
                if ($(this).parent().children(".alert").length <= 0) {
                    error = `<span class='alert alert-danger mt-1'>Cannot add more then 3 attachments</span>`;
                    $(this).parent().append(error);
                }
            }
        });

        receiverCounter = 1;
        $("#btnaddreceiverattach").on("click", function() {
            name = "attachmentreceiver" + receiverCounter;
            type = "attachmentreceiver" + senderCounter;
            if (receiverCounter < 6) {
                form = `<div class="d-flex justify-content-between align-items-center">
                            <div class="form-group">
                                <label for='${name}'>
                                    <span class='las la-file-upload blue'></span>
                                </label>
                                <i id='filename'>filename</i>
                                <input type='file' class='form-control d-none attachInput' id='${name}' name='${name}' />
                            </div>
                            <div class="form-group">
                                <select type="text" id="${type}" class="form-control" placeholder="Type" name="${type}">
                                    <option value="NID">NID</option>
                                    <option value="Passport">Passport</option>
                                    <option value="Driving license">Driving license</option>
                                    <option value="Company license">Company license</option>
                                    <option value="TIN">TIN</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <a href='#' class='deletedailyattachsender' style='font-size:25px'><span class='las la-trash danger'></span></a>
                    </div>
                `
                $(".receiverAttach").parent().append(form);
                $("#attachCountreceiver").val(receiverCounter);
                receiverCounter++;
            } else {
                if ($(this).parent().children(".alert").length <= 0) {
                    error = `<span class='alert alert-danger mt-1'>Cannot add more then 3 attachments</span>`;
                    $(this).parent().append(error);
                }
            }
        });

        // Delete daily sender customer attachment
        $(document).on("click", ".deletedailyattachreceiver", function(e) {
            e.preventDefault();
            inputcounter = $("#attachCountreceiver").val();
            inputcounter--;
            $("#attachCountreceiver").val(inputcounter);
            receiverCounter--;
            $(this).parent().remove();
        });

        // Delete daily receiver customer attachment
        $(document).on("click", ".deletedailyattachsender", function(e) {
            e.preventDefault();
            inputcounter = $("#attachCountsender").val();
            inputcounter--;
            $("#attachCountsender").val(inputcounter);
            senderCounter--;
            $(this).parent().remove();
        });

        $(document).on("click", ".alert", function() {
            $(this).fadeOut();
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
                    $(ths).parent().parent().children("row").children(".form-group").children("input#sender_fname").val(ndata[0].fname);
                    $(ths).parent().parent().children("row").children(".form-group").children("#sender_lname").val(ndata[0].lname);
                    $(ths).parent().parent().children("row").children(".form-group").children("#sender_Fathername").val(ndata[0].alies_name);
                    $(ths).parent().parent().children("row").children(".form-group").children("#sender_nid").val(ndata[0].NID);
                    $(ths).parent().parent().children(".form-group").children("#sender_details").val(ndata[0].details);
                    $(ths).parent().parent().children("#addsender").val("false");
                    $(ths).parent().parent().children(".attachContainer").remove();
                } else {
                    $(ths).parent().parent().children("row").children(".form-group").each(function() {
                        $(this).find("input:not(#sender_phone)").val("");
                    });
                    $(ths).parent().parent().children("#addsender").val("true");
                }
            });
            $(ths).parent().parent().children(".attachContainer").removeClass("d-none");
            $(ths).parent().parent().children(".row").children(".form-group").removeClass("d-none");
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
                    $(ths).parent().parent().children("row").children(".form-group").children("#receiver_fname").val(ndata[0].fname);
                    $(ths).parent().parent().children("row").children(".form-group").children("#receiver_lname").val(ndata[0].lname);
                    $(ths).parent().parent().children("row").children(".form-group").children("#receiver_Fathername").val(ndata[0].alies_name);
                    $(ths).parent().parent().children("row").children(".form-group").children("#receiver_nid").val(ndata[0].NID);
                    $(ths).parent().parent().children(".form-group").children("#receiver_details").val(ndata[0].details);
                    $(ths).parent().parent().children("#addreceiver").val("false");
                    $(ths).parent().parent().children(".attachContainer").remove();
                } else {
                    $(ths).parent().parent().children("row").children(".form-group").each(function() {
                        $(this).find("input:not(#receiver_phone").val("");
                    });
                    $(ths).parent().parent().children("#addreceiver").val("true");
                }
            });
            $(ths).parent().parent().children(".attachContainer").removeClass("d-none");
            $(ths).parent().parent().children(".row").children(".form-group").removeClass("d-none");
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

        // generate transfer code
        $("#rsaraf_ID").on("change", function() {
            sarafID = $("#rsaraf_ID option:selected").attr("data-href");
            sarafAccountID = $(this).val();
            if (sarafAccountID !== "") {
                $.get("../app/Controllers/Bussiness.php", {
                    getTranasferCode: true,
                    SID: sarafID
                }, function(data) {
                    if (data === 0 || data === "0") {
                        // first time transfer, now generate a transfer code
                        $("#transfercode").val((sarafAccountID + "-1"));
                    } else {
                        $ID = parseInt(data);
                        $ID++;
                        $("#transfercode").val((sarafAccountID + "-" + $ID));
                    }
                });
            }
        });

        $("#tamount").on("keyup", function(e) {
            e.preventDefault();
            val = $(this).val().toString();
            if (val.length > 0) {
                val = parseFloat($(this).val());
                MC = parseFloat($("#mycommission").val());
                SC = parseFloat($("#sarafcommission").val())
                rest = parseFloat($("#rest").text());

                if (rest != 0 && find(".receiptamountr").length > 0) {
                    $(".receiptamount").each(function() {
                        rest - +parseFloat(val);
                    });
                    $("#rest").text(rest);
                } else {
                    $("#rest").text((val + MC + SC));
                }
                $("#sum").text((val + MC + SC));
            }
        });

        $("#tamount").on("blur", function(e) {
            e.preventDefault();
            amount = parseFloat($(this).val());
            currency = $("#currency option:selected").text();
            if (amount > 0) {
                if (currency != mainCurrency) {
                    $("#amountspinner").removeClass("d-none");
                    $.get("../app/Controllers/banks.php", {
                            "getExchange": true,
                            "from": currency,
                            "to": mainCurrency
                        },
                        function(data) {
                            $("#amountspinner").addClass("d-none");
                            if (data != "false") {
                                ndata = JSON.parse(data);
                                $("#currencyrate").removeClass("d-none");
                                $("#currencyrate").addClass("mt-1");
                                if (ndata.currency_from == currency) {
                                    $("#currencyrate").html(`<span class='badge badge-danger'>Rate: ${ndata.rate}</span> <span class='badge badge-blue'>New amount: ${parseFloat(ndata.rate)*parseFloat(amount)} - ${mainCurrency} </span>`);
                                    $("#rate").val(parseFloat(ndata.rate));
                                } else {
                                    $("#rate").val(parseFloat((1 / ndata.rate)));
                                    $("#currencyrate").text(`Rate: ${1/ndata.rate} New amount: ${parseFloat((1/ndata.rate))*parseFloat(amount)}`);
                                    $("#currencyrate").html(`<span class='badge badge-danger'>Rate: ${ndata.rate}</span> <span class='badge badge-blue'>New amount: ${parseFloat((1/ndata.rate))*parseFloat(amount)} - ${mainCurrency}</span>`);
                                }
                            } else {
                                if (!$("#erroSnackbar").hasClass("show")) {
                                    $("#erroSnackbar").addClass("show");
                                    $("#erroSnackbar").children(".snackbar-body").html(`Please add exchange from ${currency} to ${mainCurrency}`);
                                }
                            }
                        });
                } else {
                    $("#erroSnackbar").removeClass("show");
                    $("#amountspinner").addClass("d-none");
                    $("#currencyrate").addClass("d-none");
                    $("#rate").val('0');
                }
            } else {
                $("#erroSnackbar").removeClass("show");
                $("#amountspinner").addClass("d-none");
                $("#currencyrate").addClass("d-none");
                $("#rate").val('0');
            }
        });

        // sum the the amount with the amount input value and set it as sum beside payment method
        $("#mycommission, #sarafcommission").on("keyup", function(e) {
            val = parseFloat($(this).val());
            preValue = parseFloat($(this).attr("prev"));
            if (!isNaN(val)) {
                // get the prev value of this input
                preValue = parseFloat($(this).attr("prev"));
                // now get the total sum
                sumTotal = parseFloat($("#sum").text());
                sumTotal -= preValue;
                sumTotal += val;
                $("#sum").text(sumTotal);
                $("#rest").text(sumTotal);
                // now set the prev attribut for this input
                $(this).attr("prev", val);
            } else {
                if (preValue > 0) {
                    sumTotal = parseFloat($("#sum").text());
                    sumTotal -= preValue;
                    $("#sum").text(sumTotal);
                    $("#rest").text(sumTotal);
                }
                // now set the prev attribut for this input
                $(this).attr("prev", "0");
                $(this).val(0);
            }
        })

        // Add Out Transfere
        $(".outtransferform").on("submit", function(e) {
            e.preventDefault();
            if ($(".outtransferform").valid()) {
                if (receiver_nid_blocked == false && sender_nid_blocked == false) {
                    totalamount = $("#rest").text();
                    if (totalamount == 0) {
                        $.ajax({
                            url: "../app/Controllers/Transfer.php",
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
                                $(".outtransferform")[0].reset();
                            },
                            error: function(e) {
                                $(".container-waiting").addClass("d-none");
                                $(".container-done").removeClass("d-none");
                                $(".container-done").html(e);
                            }
                        });
                    }
                } else {
                    $(".error").removeClass("d-none").children("span").text("One of NID is blocked please check it again");
                }
            }
        });
    });

    // Initialize validation
    $(".outtransferform").validate({
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
        }
    });
</script>