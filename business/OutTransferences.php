<?php
$Active_nav_name = array("parent" => "Receipt & Revenue", "child" => "Out Transference list");
$page_title = "Out Transferences";
include("./master/header.php");

$transfer = new Transfer();
$bussiness = new Bussiness();

$pending_transfers_data = $transfer->getPendingOutTransfer($user_data->company_id);
$pending_transfers = $pending_transfers_data->fetchAll(PDO::FETCH_OBJ);

$paid_transfers_data = $transfer->getPaidOutTransfer($user_data->company_id);
$paid_transfers = $paid_transfers_data->fetchAll(PDO::FETCH_OBJ);
?>
<style>
    .mainrow:hover {
        cursor: pointer;
        background-color: lightgray;
    }

    .btncancelTransfer:hover>span {
        cursor: pointer;
        transform: scale(1.1);
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
                                            <table class="table material-table">
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

                                                        $dat = date("m/d/Y", $ptransfer->reg_date);
                                                        echo "<tr class='mainrow'>
                                                                            <td>$dat</td>
                                                                            <td class='tRow' data-href='$ptransfer->leadger_id'>$ptransfer->details</td>
                                                                            <td>$from->fname $from->lname</td>
                                                                            <td>$to->fname $to->lname</td>
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
                                                                <th>To</th>
                                                                <th>Amount</th>
                                                                <th>Transfer Code</th>
                                                                <th>Cancel</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            foreach ($pending_transfers as $ptransfer) {
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
                                                                            <td><a href='#' class='btncancelTransfer' data-href='$ptransfer->leadger_id'><span class='las la-trash danger' style='font-size:25px'></span></a></td>
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
                        <div class="col-md-6">
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

                        <div class="col-md-6">
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

<?php
include("./master/footer.php");
?>

<script>
    $(document).ready(function() {

        var t1 = $("#tblaccountmoney").DataTable();
        var t2 = $("#tbldaily").DataTable();

        $(document).on("click", ".tRow", function() {
            leadger_id = $(this).attr("data-href");

            $.get("../app/Controllers/Transfer.php", {
                "transferoutalldetails": true,
                "leadger_id": leadger_id
            }, function(data) {
                console.log(data);

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

                $("#showpendingdetails").modal("show");
            });

        })

        $(document).on("click", ".btncancelTransfer", function(e) {
            e.preventDefault();
            ths = $(this);
            transfer_id = $(ths).attr("data-href");

            $.post("../app/Controllers/Transfer.php", {
                "cancel_transer_done": true,
                "transferID": transfer_id
            }, function(data) {
                $(ths).parent().parent().fadeOut();
            });
        });
    });
</script>