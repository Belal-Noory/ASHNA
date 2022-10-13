<?php
$Active_nav_name = array("parent" => "Payment & Expense", "child" => "In Transference list");
$page_title = "In Transferences";
include("./master/header.php");

$transfer = new Transfer();
$bussiness = new Bussiness();
$company = new Company();

$company_FT_data = $company->getCompanyActiveFT($user_data->company_id);
$company_ft = $company_FT_data->fetch(PDO::FETCH_OBJ);
$financial_term = 0;
if (isset($company_ft->term_id)) {
    $financial_term = $company_ft->term_id;
}


$pending_transfers_data = $transfer->getPendingInTransfer($user_data->company_id, $financial_term);
$pending_transfers = $pending_transfers_data->fetchAll(PDO::FETCH_OBJ);

$paid_transfers_data = $transfer->getPaidInTransfer($user_data->company_id, $financial_term);
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
                                                        <th>To</th>
                                                        <th>Amount</th>
                                                        <th>Transfer Code</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($paid_transfers as $ptransfer) {
                                                        $from_data = $bussiness->getCustomerByID($ptransfer->company_user_sender);
                                                        $from = $from_data->fetch(PDO::FETCH_OBJ);

                                                        $to_data = $bussiness->getCustomerByID($ptransfer->company_user_receiver);
                                                        $to = $to_data->fetch(PDO::FETCH_OBJ);
                                                        $toname = "NA";
                                                        if (isset($to->fname)) {
                                                            $toname = $to->fname . " " . $to->lname;
                                                        }
                                                        $dat = date("m/d/Y", $ptransfer->reg_date);
                                                        echo "<tr class='mainrow'>
                                                                            <td>$dat</td>
                                                                            <td class='tRow' data-href='$ptransfer->leadger_id'>$ptransfer->details</td>
                                                                            <td>$from->fname $from->lname</td>
                                                                            <td>$toname</td>
                                                                            <td>$ptransfer->amount-$ptransfer->currency</td>
                                                                            <td>$ptransfer->transfer_code</td>
                                                                            <td><a class='btn btn-sm btn-blue text-white' href='Edite.php?edit=$ptransfer->leadger_id&op=in'><span class='las la-edit la-2x'></span></a></td>
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
                                                    <table class="table material-table" id="tblPendingTransactions">
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
                                                            foreach ($pending_transfers as $ptransfer) {
                                                                $from_data = $bussiness->getCustomerByID($ptransfer->company_user_sender);
                                                                $from = $from_data->fetch(PDO::FETCH_OBJ);
                                                                $dat = date("m/d/Y", $ptransfer->reg_date);
                                                                echo "<tr class='mainrow'>
                                                                            <td>$dat</td>
                                                                            <td class='tRow' data-href='$ptransfer->company_money_transfer_id'>$ptransfer->details</td>
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
                <div class="table-responsive">
                    <h5 class="text-muted">Transfer Details</h5>
                    <table class="table table-sm display compact" id="tbldaily2">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">TR-Code</th>
                                <th class="text-center">your Commission</th>
                                <th class="text-center">from</th>
                                <th class="text-center">sender</th>
                                <th class="text-center">receiver</th>
                                <th class="text-center">Amount</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Details</th>
                                <th class="text-center">Lock</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="paymentContainer container"></div>
            </div>
            <div class="modal-fotter d-flex justify-content-between p-2">
                <div class="pen-outer">
                    <div class="pulldown">
                        <div class="pulldown-toggle pulldown-toggle-round">
                            <i class="la la-plus"></i>
                        </div>
                        <div class="pulldown-menu">
                            <ul>
                                <li class="addreciptItem2" item="bank">
                                    <i class="la la-bank" style="font-size:30px;color:white"></i>
                                </li>
                                <li class="addreciptItem2" item="saif">
                                    <i class="la la-box" style="font-size:30px;color:white"></i>
                                </li>
                                <li class="addreciptItem2" item="customer">
                                    <i class="la la-user" style="font-size:30px;color:white"></i>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-dark btn-min-width waves-effect waves-light" id="btnapprove">
                    Approve
                    <i class="la la-check"></i>
                    <i class="la la-spinner spinner d-none"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Receiver -->
<div class="modal fade text-left" id="receiverModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary white">
                <h4 class="modal-title white" id="myModalLabel8">Money Receiver Details</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="receiverForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="currency">Phone Number</label>
                        <input type="text" class="form-control" name="receiver_phone" id="receiver_phone" placeholder="Phone Number" />
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-xs-12">
                            <label for="currency">First Name</label>
                            <input type="text" class="form-control required" name="receiver_fname" id="receiver_fname" placeholder="First Name" />
                        </div>
                        <div class="form-group col-md-6 col-xs-12">
                            <label for="currency">Last Name</label>
                            <input type="text" class="form-control" name="receiver_lname" id="receiver_lname" placeholder="Last Name" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6 col-xs-12">
                            <label for="currency">Father Name</label>
                            <input type="text" class="form-control" name="receiver_Fathername" id="receiver_Fathername" placeholder="Father Name" />
                        </div>
                        <div class="form-group col-md-6 col-xs-12">
                            <label for="currency">NID</label>
                            <input type="text" class="form-control" name="receiver_nid" id="receiver_nid" placeholder="NID" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="details">Description</label>
                        <textarea id="receiver_details" class="form-control p-0" rows="1" style="border:none; border-bottom:1px solid gray" placeholder="Description" name="receiver_details"></textarea>
                    </div>
                    <div class="attachContainer">
                        <h6 class="text-muted">Uploaded Attachments</h6>
                        <ul class="list-group uploaded">

                        </ul>
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
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary waves-effect waves-light" id="updatereceiver">
                        <i class="la la-check"></i>
                        <i class="la la-spinner spinner d-none"></i>
                        Save changes
                    </button>
                </div>
                <input type="hidden" name="attachCountreceiver" id="attachCountreceiver" value="0">
                <input type="hidden" name="receiverID" id="receiverID">
                <input type="hidden" name="updatereceiver" id="updatereceiver">
            </form>
        </div>
    </div>
</div>

<?php
include("./master/footer.php");
?>

<script>
    $(document).ready(function() {

        var t1 = $("#tblaccountmoney").DataTable();
        var t2 = $("#tbldaily2").DataTable();

        // get all daily customers list
        CompanyCustomers = [];
        $.get("../app/Controllers/Bussiness.php", {
            Customers: true
        }, function(data) {
            ndata = $.parseJSON(data);
            CompanyCustomers = ndata;
        });

        // pending transfers table
        tblPendingTransfers = $("#tblPendingTransactions").DataTable();

        // Paid transfers table
        tblpaidTransfers = $("#paidTenasfereTable").DataTable();

        selectedRow = null;
        $(document).on("click", ".tRow", function() {
            TID = $(this).attr("data-href");
            selectedRow = $(this);
            $.get("../app/Controllers/Transfer.php", {
                "transferByID": true,
                "TID": TID
            }, function(data) {
                t2.clear();
                ndata = $.parseJSON(data);
                // date
                date = new Date(ndata[0].reg_date * 1000);
                newdate = date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate();
                t2.row.add([
                    1,
                    ndata[0].company_money_transfer_id,
                    ndata[0].company_user_receiver_commission,
                    ndata[0].csender_fname + " " + ndata[0].csender_lname,
                    ndata[0].sender_fname + " " + ndata[0].sender_lname,
                    `<button type="button" data-href='${ndata[0].money_receiver}' class="btn btn-outline-info block btn-lg waves-effect waves-light showreceiverModel">
                      ${ndata[0].receiver_fname+" "+ndata[0].receiver_lname}
                    </button>`,
                    ndata[0].amount + "-" + ndata[0].currency,
                    newdate,
                    ndata[0].details,
                    `<button data-href='${ndata[0].company_money_transfer_id}' type="button" class="btn btn-icon btn-danger waves-effect waves-light btnlocktransfers">
                    <i class="la la-lock"></i></button>`
                ]).draw(false);
                $("#btnapprove").attr("data-href", ndata[0].company_money_transfer_id);
                $("#showpendingdetails").modal("show");
            });

        });

        // lock transaction
        locked = false;
        $(document).on("click", ".btnlocktransfers", function(e) {
            e.preventDefault();
            TID = $(this).attr("data-href");
            ths = $(this);
            $(ths).children("i").removeClass("la-lock");
            $(ths).children("i").addClass("la-spinner");
            $(ths).children("i").addClass("spinner");
            $.get("../app/Controllers/Transfer.php", {
                "lockTR": true,
                "ID": TID,
                lock: 1
            }, function(data) {
                console.log(data);
                $(ths).children("i").removeClass("la-spinner");
                $(ths).children("i").removeClass("spinner");
                $(ths).children("i").addClass("la-unlock");
                $(ths).removeClass("btnlocktransfers");
                $(ths).addClass("btnunlocktransfers");
                $(ths).removeClass("btn-danger");
                $(ths).addClass("btn-blue");
                locked = true;
            });
        });

        // unlcok
        $(document).on("click", ".btnunlocktransfers", function(e) {
            e.preventDefault();
            TID = $(this).attr("data-href");
            ths = $(this);
            $(ths).children("i").removeClass("la-unlock");
            $(ths).children("i").addClass("la-spinner");
            $(ths).children("i").addClass("spinner");
            $.get("../app/Controllers/Transfer.php", {
                "lockTR": true,
                "ID": TID,
                lock: 0
            }, function(data) {
                $(ths).children("i").removeClass("la-spinner");
                $(ths).children("i").removeClass("spinner");
                $(ths).children("i").addClass("la-lock");
                $(ths).removeClass("btnunlocktransfers");
                $(ths).addClass("btnlocktransfers");
                $(ths).removeClass("btn-blue");
                $(ths).addClass("btn-danger");
                locked = false;
            });
        });

        // show receiver model
        $(document).on("click", ".showreceiverModel", function(e) {
            e.preventDefault();
            $RID = $(this).attr("data-href");
            $("#receiverID").val($RID);
            $.get("../app/Controllers/Transfer.php", {
                DCMSAttach: true,
                id: $RID
            }, function(data) {
                ndata = $.parseJSON(data);
                $("#receiver_phone").val(ndata[0].personal_phone);
                $("#receiver_fname").val(ndata[0].fname);
                $("#receiver_lname").val(ndata[0].lname);
                $("#receiver_Fathername").val(ndata[0].alies_name);
                $("#receiver_nid").val(ndata[0].NID);
                $("#receiver_details").val(ndata[0].note);

                $(".uploaded").html("");
                ndata.forEach(element => {
                    $(".uploaded").append(`<li class="list-group-item">
                                <span class="float-right">
                                    <i class="la la-check"></i>
                                </span>
                                ${element.type}
                            </li>`);
                });
            });
            $("#receiverModel").modal("show");
        });

        receiverCounter = 1;
        $("#btnaddreceiverattach").on("click", function() {
            name = "attachmentreceiver" + receiverCounter;
            type = "attachTypereceiver" + receiverCounter;
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
                            <a href='#' class='deletedailyattachreceiver' style='font-size:25px'><span class='las la-trash danger'></span></a>
                    </div>
                `
                $(".receiverAttach").parent().append(form);
                $("#attachCountreceiver").val(receiverCounter);
                receiverCounter++;
            } else {
                if ($(this).parent().children(".alert").length <= 0) {
                    error = `<span class='alert alert-danger mt-1'>Cannot add more then 6 attachments</span>`;
                    $(this).parent().append(error);
                }
            }
        });

        // Delete daily receiver customer attachment
        $(document).on("click", ".deletedailyattachreceiver", function(e) {
            e.preventDefault();
            inputcounter = $("#attachCountreceiver").val();
            inputcounter--;
            $("#attachCountreceiver").val(inputcounter);
            receiverCounter--;
            $(this).parent().remove();
        });

        // update receiver details
        $(document).on("submit", ".receiverForm", function(e) {
            e.preventDefault();
            $.ajax({
                url: "../app/Controllers/Transfer.php",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $("#updatereceiver").children(".spinner").removeClass("d-none");
                    $("#updatereceiver").children(".la-check").addClass("d-none");
                    $("#updatereceiver").attr("disabled");
                },
                success: function(data) {
                    console.log(data);
                    $("#updatereceiver").children(".spinner").addClass("d-none");
                    $("#updatereceiver").children(".la-check").removeClass("d-none");
                    $("#updatereceiver").removeAttr("disabled");
                },
                error: function(e) {
                    console.log(e);
                }
            });
        });

        // load all banks when clicked on add banks
        $(".addreciptItem2").on("click", function() {
            type = $(this).attr("item");

            item_name = "reciptItemID";
            details_name = "reciptItemdetails";

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
                                    <div class="col-lg-4">`;

            if (type == "bank") {
                form += `<i class="la la-bank" style="font-size: 50px;color:dodgerblue"></i></div>
                                                    <div class="col-lg-8">
                                                        <div class="form-group">
                                                            <select class="form-control customer" name="${item_name}" id="${item_name}" data='bank'>
                                                                <option value="" selected>Select</option>`;
                bankslist.forEach(element => {
                    form += "<option class='" + element.currency + "' value='" + element.chartofaccount_id + "'>" + element.account_name + "</option>";

                });
                form += `</select><label class="d-none balance"></label>
                            </div>
                        </div>`;
            }
            if (type == "saif") {
                form += `<i class="la la-box" style="font-size: 50px;color:dodgerblue"></i></div>
                                                    <div class="col-lg-8">
                                                        <div class="form-group">
                                                            <select class="form-control customer" name="${item_name}" id="${item_name}" data='saif'>
                                                                <option value="" selected>Select</option>`;
                saiflist.forEach(element => {
                    form += "<option class='" + element.currency + "' value='" + element.chartofaccount_id + "'>" + element.account_name + "</option>";
                });
                form += `</select><label class="d-none balance"></label>
                            </div>
                        </div>`;
            }

            if (type == "customer") {
                form += `<i class="la la-user" style="font-size: 50px;color:dodgerblue"></i></div>
                                                    <div class="col-lg-8">
                                                        <div class="form-group">
                                                            <select class="form-control customer" name="${item_name}" id="${item_name}" data='customer'>`;
                customersList.forEach(element => {
                    form += "<option class='" + element.currency + "' value='" + element.chartofaccount_id + "'>" + element.account_name + "</option>";
                });
                form += '</select><label class="d-none balance"></label></div></div>';

            }

            form += ` <div class="col-lg-12">
                                        <div class="form-group">
                                            <input type="text" name="${details_name}" id="${details_name}" class="form-control details" placeholder="Details"">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;

            $(".receiptItemsContainer, .paymentContainer").html(form);
            formReady = true;
        });


        $("#btnapprove").on("click", function(e) {
            e.preventDefault();
            ths = $(this);
            transfer_id = $(ths).attr("data-href");
            $(this).attr("disabled");
            if (!locked) {
                if ($("#reciptItemID").length > 0 && $("#reciptItemID").val() != "") {
                    $(this).children("i:nth-child(1)").addClass("d-none");
                    $(this).children("i:nth-child(2)").removeClass("d-none");
                    $.post("../app/Controllers/Transfer.php", {
                        sarafIntrasnfer: true,
                        TID: transfer_id,
                        reciptItemID: $("#reciptItemID").val(),
                        reciptItemdetails: $("#reciptItemdetails").val()
                    }, function(data) {
                        console.log(data);
                        $(ths).children("i:nth-child(1)").removeClass("d-none");
                        $(ths).children("i:nth-child(2)").addClass("d-none");
                        $(ths).removeAttr("disabled");
                        $(selectedRow).parent().remove();
                        $("#showpendingdetails").modal("hide");
                    });
                } else {
                    $(".paymentContainer").html("<span class='badge badge-danger p-2'>Please select payment method</span>");
                }
            } else {
                $(".paymentContainer").html("<span class='badge badge-danger p-2'>Please unlock the transfer first</span>");
            }
        });

        // get new Paid Out Tranfers
        setInterval(() => {
            $.post("../app/Controllers/Transfer.php", {
                newInranfersPaid: true
            }, function(data) {
                ndata = $.parseJSON(data);
                if (ndata.length > 0) {
                    tblpaidTransfers.clear();
                    ndata.forEach(element => {
                        // get from data
                        from_cus = CompanyCustomers.filter(cus => cus.customer_id == element.company_user_sender);

                        // get to data
                        to_cus = CompanyCustomers.filter(cus => cus.customer_id == element.company_user_receiver);

                        // date
                        date = new Date(element.reg_date * 1000);
                        newdate = date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate();
                        btn = `<a class='btn btn-sm btn-blue text-white' href='Edite.php?edit=${element.leadger_id}&op=ot'><span class='las la-edit la-2x'></span></a>`;
                        var rowNode = tblpaidTransfers.row.add([newdate, element.details, from_cus[0].fname + " " + from_cus[0].lname, to_cus[0].fname + " " + to_cus[0].lname, element.amount + "-" + element.currency, element.transfer_code, btn]).draw().node();
                        $(rowNode).addClass('mainrow');
                        $(rowNode).find('td').eq(1).addClass('tRow').attr("data-href", element.leadger_id);
                    });
                }
            });
        }, 10000);

        // get new Pending In Tranfers
        setInterval(() => {
            $.post("../app/Controllers/Transfer.php", {
                newInTranfersPendings: true
            }, function(data) {
                ndata = $.parseJSON(data);
                if (ndata.length > 0) {
                    tblPendingTransfers.clear();
                    ndata.forEach(element => {
                        // get from data
                        from_cus = CompanyCustomers.filter(cus => cus.customer_id == element.company_user_sender);

                        // date
                        date = new Date(element.reg_date * 1000);
                        newdate = date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate();
                        var rowNode = tblPendingTransfers.row.add([newdate, element.details, from_cus[0].fname + " " + from_cus[0].lname, element.amount + "-" + element.currency, element.transfer_code]).draw().node();
                        $(rowNode).addClass('mainrow');
                        $(rowNode).find('td').eq(1).addClass('tRow').attr("data-href", element.company_money_transfer_id);
                    });
                }
            });
        }, 10000);
    });
</script>