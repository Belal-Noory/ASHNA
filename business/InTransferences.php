<?php
$Active_nav_name = array("parent" => "Payment & Expense", "child" => "In Transference list");
$page_title = "In Transferences";
include("./master/header.php");

$transfer = new Transfer();
$bussiness = new Bussiness();

$pending_transfers_data = $transfer->getPendingInTransfer($user_data->company_id);
$pending_transfers = $pending_transfers_data->fetchAll(PDO::FETCH_OBJ);

$paid_transfers_data = $transfer->getPaidInTransfer($user_data->company_id);
$paid_transfers = $paid_transfers_data->fetchAll(PDO::FETCH_OBJ);

?>
<style>
    .mainrow:hover {
        cursor: pointer;
        background-color: lightgray;
    }

    .btncancelTransfer:hover>span,
    .btnapprove:hover>span {
        cursor: pointer;
        transform: scale(1.1);
    }
</style>

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
<div class="container pt-3">
    <section id="material-fixed-tabs" class="material-fixed-tabs">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Out Transferences</h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis font-medium-3"></i></a>
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
                    <p>All out transactions will be listed below based on its cataogries.</p>
                    <ul class="nav nav-justified nav-tabs nav-tabs-material" id="justifiedTab" role="tablist">
                        <li class="nav-item">
                            <a aria-controls="home" aria-selected="true" class="nav-link waves-effect waves-dark active" data-toggle="tab" href="#paidPanel" id="paid-tab" role="tab">Paid</a>
                        </li>
                        <li class="nav-item">
                            <a aria-controls="profile" aria-selected="false" class="nav-link waves-effect waves-dark" data-toggle="tab" href="#pendingPanel" id="pending-tab" role="tab">Pending</a>
                        </li>

                        <div class="nav-tabs-indicator" style="left: 0px; right: 1212.67px;"></div>
                    </ul>
                    <div class="tab-content" id="justifiedTabContent">
                        <div aria-labelledby="paid-tab" class="tab-pane fade active show" id="paidPanel" role="tabpanel">
                            <section id="material-datatables">
                                <div class="card">
                                    <div class="card-header">
                                        <a class="heading-elements-toggle">
                                            <i class="la la-ellipsis-v font-medium-3"></i>
                                        </a>
                                        <div class="heading-elements">
                                            <ul class="list-inline mb-0">
                                                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <table class="table material-table" id="paidTenasfereTable">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Description</th>
                                                        <th>From</th>
                                                        <th>Amount</th>
                                                        <th>Transfer Code</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($paid_transfers as $ptransfer) {
                                                        $from_data = $bussiness->getCustomerByID($ptransfer->company_user_sender);
                                                        $from = $from_data->fetch(PDO::FETCH_OBJ);

                                                        $dat = date("m/d/Y", $ptransfer->reg_date);
                                                        echo "<tr class='mainrow'>
                                                                            <td>$dat</td>
                                                                            <td class='tRow' data-href='$ptransfer->leadger_id'>$ptransfer->details</td>
                                                                            <td>$from->fname $from->lname</td>
                                                                            <td>$ptransfer->amount-$ptransfer->currency</td>
                                                                            <td>$ptransfer->transfer_code</td>
                                                                        </tr>";
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div aria-labelledby="pending-tab" class="tab-pane fade" id="pendingPanel" role="tabpanel">
                            <section id="material-datatables">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card mb-0">
                                            <div class="card-header">
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
                                                    <table class="table material-table">
                                                        <thead>
                                                            <tr>
                                                                <th>Date</th>
                                                                <th>Description</th>
                                                                <th>From</th>
                                                                <th>Amount</th>
                                                                <th>Transfer Code</th>
                                                                <th>Approve</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            foreach ($pending_transfers as $ptransfer) {
                                                                $from_data = $bussiness->getCustomerByID($ptransfer->company_user_sender);
                                                                $from = $from_data->fetch(PDO::FETCH_OBJ);
                                                                $dat = date("m/d/Y", $ptransfer->reg_date);
                                                                echo "<tr class='mainrow'>
                                                                            <td>$dat</td>
                                                                            <td class='tRow' data-href='$ptransfer->leadger_id'>$ptransfer->details</td>
                                                                            <td>$from->fname $from->lname</td>
                                                                            <td>$ptransfer->amount-$ptransfer->currency</td>
                                                                            <td>$ptransfer->transfer_code</td>
                                                                            <td><a href='#' class='btn btn-blue btnapprove' data-href='$ptransfer->company_money_transfer_id'><span class='las la-check'></span></a></td>
                                                                        </tr>";
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal -->
<div class="modal fade text-center" id="showpendingdetails" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-body p-2">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="col-lg-12">
                            <div class="card bg-gradient-directional-primary">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-white text-left">
                                                <h3 class="text-white" id="rcommision"></h3>
                                                <span>Saraf Commission</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="card bg-gradient-directional-primary">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-white text-left">
                                                <h3 class="text-white" id="scommision"></h3>
                                                <span>Your Commission</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="bs-callout-info callout-border-left mt-1 p-1">
                            <strong>Transfer Details</strong>
                            <p id="tdetails"></p>
                        </div>
                    </div>
                </div>

                <table class="table material-table" id="tblaccountmoney">
                    <thead>
                        <tr>
                            <th>Account</th>
                            <th>Leagder</th>
                            <th>Debet</th>
                            <th>Credit</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

                <div class="col-lg-12 mt-2">
                    <div class="card bg-light">
                        <div class="card-header">
                            <h3 class="card-title text-center">Daily Customers</h3>
                        </div>
                        <div class="card-body">
                            <table class="table material-table" id="tbldaily">
                                <thead>
                                    <tr>
                                        <th>Full Name</th>
                                        <th>Phone</th>
                                        <th>NID</th>
                                        <th>Note</th>
                                        <th>Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade text-center" id="showapprove" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body p-2">
                <div class="row">
                    <div class="col-lg-12">
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
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="receiptItemsContainer col-lg-12"></div>
            </div>
        </div>
    </div>
</div>

<?php
include("./master/footer.php");
?>

<script>
    $(document).ready(function() {

        var t1 = $("#tblaccountmoney").DataTable();
        var t2 = $("#tbldaily").DataTable();
        let t3 = $("#paidTenasfereTable").DataTable();

        $(document).on("click", ".tRow", function() {
            leadger_id = $(this).attr("data-href");
            t2.clear();
            $.get("../app/Controllers/Transfer.php", {
                "transferoutalldetails": true,
                "leadger_id": leadger_id
            }, function(data) {
                ndata = $.parseJSON(data);
                $("#tdetails").text(ndata[0].details);

                // Get Currency Details
                $.get("../app/Controllers/Transfer.php", {
                    "getCurrencyDetails": true,
                    "cur": ndata[0].currency
                }, function(data) {
                    cdata = $.parseJSON(data);
                    $("#rcommision").text(ndata[0].company_user_receiver_commission + "-" + cdata.currency);
                    $("#scommision").text(ndata[0].company_user_sender_commission + "-" + cdata.currency);
                });

                // Get Company Receiver Details
                $.get("../app/Controllers/Transfer.php", {
                    "DCMS": true,
                    "id": ndata[0].money_receiver
                }, function(data) {
                    cdata = $.parseJSON(data);
                    t2.row.add([cdata.fname + " " + cdata.lname, cdata.personal_phone, cdata.NID, cdata.note, "Receiver"]).draw(false);
                });

                // Get Company Sender Details
                $.get("../app/Controllers/Transfer.php", {
                    "DCMS": true,
                    "id": ndata[0].money_sender
                }, function(data) {
                    cdata = $.parseJSON(data);
                    t2.row.add([cdata.fname + " " + cdata.lname, cdata.personal_phone, cdata.NID, cdata.note, "Sender"]).draw(false);
                });

                ndata.forEach(element => {

                    // get Account details
                    $.get("../app/Controllers/Transfer.php", {
                        "account": true,
                        "id": element.account_id
                    }, function(data) {
                        cdata = $.parseJSON(data);
                        if (element.ammount_type == "Debet") {
                            t1.row.add([cdata.account_name, element.leadger_ID, element.amount, 0]).draw(false);

                        } else {
                            t1.row.add([cdata.account_name, element.leadger_ID, 0, element.amount]).draw(false);
                        }
                    });
                });

                $("#showpendingdetails").modal("show");
            });

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

        formReady = false;
        // load all banks when clicked on add banks
        $(".addreciptItem").on("click", function() {
            type = $(this).attr("item");
            item_name = "reciptItemID";
            details = "reciptItemdetails";

            form = `<div class='card bg-light mt-1'>
                        <div class="card-header">
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">`;

            if (type == "bank") {
                form += `<i class="la la-bank" style="font-size: 50px;color:dodgerblue"></i></div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="${item_name}">Bank</label>
                                                            <select class="form-control chosen required customer" name="${item_name}" id="${item_name}" data='bank'>
                                                                <option value="" selected>Select</option>`;
                bankslist.forEach(element => {
                    form += "<option value='" + element.chartofaccount_id + "'>" + element.account_name + " - " + element.account_type + " - " + element.currency + "</option>";
                });
                form += `</select><label class="d-none balance"></label>
                            </div>
                        </div>`;
            }
            if (type == "saif") {
                form += `<i class="la la-box" style="font-size: 50px;color:dodgerblue"></i></div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="${item_name}">Saif</label>
                                                            <select class="form-control chosen required customer" name="${item_name}" id="${item_name}" data='saif'>
                                                                <option value="" selected>Select</option>`;
                saiflist.forEach(element => {
                    form += "<option value='" + element.chartofaccount_id + "'>" + element.account_name + " - " + element.account_type + " - " + element.currency + "</option>";
                });
                form += `</select><label class="d-none balance"></label>
                            </div>
                        </div>`;
            }

            form += ` 
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="${details}">Details</label>
                                            <input type="text" name="${details}" id="${details}" class="form-control" placeholder="Details">
                                        </div>
                                    </div>
                                    <div class='col-lg-12'><button id='addapproval' type="button" class="btn btn-blue">Register</button></div>
                                </div>
                            </div>
                        </div>
                    </div>`;

            $(".receiptItemsContainer").html(form);
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
            formReady = true;
        });


        // approve the tranference
        let recent_row_selected = "";
        $(document).on("click", ".btnapprove", function(e) {
            e.preventDefault();
            ths = $(this);
            recent_row_selected = $(this).parent().parent();
            TID = $(this).attr("data-href");
            $("#showapprove").attr("data-href", TID);
            $("#showapprove").modal("show");
        });

        $(document).on("click", "#addapproval", function() {
            TID = $("#showapprove").attr("data-href");
            reciptItemID = $("#reciptItemID").val();
            reciptItemdetails = $("#reciptItemdetails").val();
            if (formReady == true) {
                $.post("../app/Controllers/Transfer.php", {
                    "sarafIntrasnfer": true,
                    "TID": TID,
                    "bankid": reciptItemID,
                    "details": reciptItemdetails
                }, function(data) {
                    date = $(recent_row_selected).children("td:nth-child(1)").text();
                    des = $(recent_row_selected).children("td:nth-child(2)").text();
                    from = $(recent_row_selected).children("td:nth-child(3)").text();
                    to = $(recent_row_selected).children("td:nth-child(4)").text();
                    amount = $(recent_row_selected).children("td:nth-child(5)").text();
                    tcode = $(recent_row_selected).children("td:nth-child(6)").text();
                    $(recent_row_selected).fadeOut();
                    t3.row.add([date, des, from, to, amount, tcode]).draw(false);
                    $("#showapprove").modal("hide");
                });
            } else {
                $(".receiptItemsContainer").html("<span class='alert alert-danger'>Please select Bank/Saif</span>");
            }
        });
    });
</script>