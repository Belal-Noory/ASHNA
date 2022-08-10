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
                                                        <th>To</th>
                                                        <th>Amount</th>
                                                        <th>Transfer Code</th>
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
                <button type="button" class="btn btn-dark btn-min-width waves-effect waves-light">Approve <i class="la la-check"></i></button>
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
        var t2 = $("#tbldaily2").DataTable();

        let t3 = $("#paidTenasfereTable").DataTable();

        $(document).on("click", ".tRow", function() {
            TID = $(this).attr("data-href");
            $.get("../app/Controllers/Transfer.php", {
                "transferByID": true,
                "TID": TID
            }, function(data) {
                t2.clear();
                ndata = $.parseJSON(data);
                console.log(ndata[0].csender_lname);
                // date
                date = new Date(ndata[0].reg_date * 1000);
                newdate = date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate();
                t2.row.add([
                    1,
                    ndata[0].company_money_transfer_id,
                    ndata[0].company_user_receiver_commission,
                    ndata[0].csender_fname+" "+ndata[0].csender_lname,
                    ndata[0].sender_fname + " " + ndata[0].sender_lname,
                    ndata[0].receiver_fname+" "+ndata[0].receiver_lname,
                    ndata[0].amount,
                    newdate,
                    ndata[0].details,
                    `<button type="button" class="btn btn-icon btn-danger waves-effect waves-light"><i class="la la-lock"></i></button>`
                ]).draw(false);

                $("#showpendingdetails").modal("show");
            });

        })

        $(document).on("click", ".btnapprove", function(e) {
            e.preventDefault();
            ths = $(this);
            transfer_id = $(ths).attr("data-href");
            $.post("../app/Controllers/Transfer.php", {
                "sarafIntrasnfer": true,
                "TID": transfer_id
            }, function(data) {
                $(ths).parent().parent().fadeOut();
            });

        });
    });
</script>