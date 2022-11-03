<?php
$Active_nav_name = array("parent" => "Receipt & Revenue", "child" => "Out Transference list");
$page_title = "Out Transferences";
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

$pending_transfers_data = $transfer->getPendingOutTransfer($user_data->company_id, $financial_term);
$pending_transfers = $pending_transfers_data->fetchAll(PDO::FETCH_OBJ);

$paid_transfers_data = $transfer->getPaidOutTransfer($user_data->company_id, $financial_term);
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
                                            <table class="table material-table" id="tblPaidTransfers">
                                                <thead>
                                                    <tr>
                                                        <th>Code No</th>
                                                        <th>Date</th>
                                                        <th>Description</th>
                                                        <th>MSP</th>
                                                        <th>Sender</th>
                                                        <th>Receiver</th>
                                                        <th>Amount</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($paid_transfers as $ptransfer) {
                                                        $sender_data = $bussiness->getCustomerByID($ptransfer->money_sender);
                                                        $sender = $sender_data->fetch(PDO::FETCH_OBJ);

                                                        $receiver_data = $bussiness->getCustomerByID($ptransfer->money_receiver);
                                                        $receiver = $receiver_data->fetch(PDO::FETCH_OBJ);

                                                        $to_data = $bussiness->getCustomerByID($ptransfer->company_user_receiver);
                                                        $to = $to_data->fetch(PDO::FETCH_OBJ);

                                                        $dat = date("m/d/Y", $ptransfer->reg_date);
                                                        $amount = number_format($ptransfer->amount,2,".",",");
                                                        $action = "<a class='btn btn-sm btn-blue text-white' href='Edite.php?edit=$ptransfer->leadger_id&op=ot'><span class='las la-edit la-2x'></span></a>";
                                                        echo "<tr class='mainrow'>
                                                                <td>$ptransfer->transfer_code</td>
                                                                <td>$dat</td>
                                                                <td class='' data-href='$ptransfer->leadger_id'>$ptransfer->details</td>
                                                                <td>$to->fname $to->lname</td>
                                                                <td>$sender->fname $sender->lname</td>
                                                                <td>$receiver->fname $receiver->lname</td>
                                                                <td>$amount $ptransfer->currency</td>
                                                                <td><span class='las la-smile text-primary la-2x'></span></td>
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
                                                    <table class="table material-table" id="tblpendingTransfers">
                                                        <thead>
                                                            <tr>
                                                                <th>Code No</th>
                                                                <th>Date</th>
                                                                <th>Description</th>
                                                                <th>MSP</th>
                                                                <th>Sender</th>
                                                                <th>Receiver</th>
                                                                <th>Amount</th>
                                                                <th>Cancel</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            foreach ($pending_transfers as $ptransfer) {
                                                                $sender_data = $bussiness->getCustomerByID($ptransfer->money_sender);
                                                                $sender = $sender_data->fetch(PDO::FETCH_OBJ);

                                                                $receiver_data = $bussiness->getCustomerByID($ptransfer->money_receiver);
                                                                $receiver = $receiver_data->fetch(PDO::FETCH_OBJ);

                                                                $to_data = $bussiness->getCustomerByID($ptransfer->company_user_receiver);
                                                                $to = $to_data->fetch(PDO::FETCH_OBJ);
                                                                $toname = "NA";
                                                                if (isset($to->fname)) {
                                                                    $toname = $to->fname . " " . $to->lname;
                                                                }
                                                                $dat = date("m/d/Y", $ptransfer->reg_date);
                                                                $amount = number_format($ptransfer->amount,2,".",",");
                                                                echo "<tr class='mainrow'>
                                                                            <td>$ptransfer->transfer_code</td>
                                                                            <td>$dat</td>
                                                                            <td class='' data-href='$ptransfer->leadger_id'>$ptransfer->details</td>
                                                                            <td>$toname</td>
                                                                            <td>$sender->fname $sender->lname</td>
                                                                            <td>$receiver->fname $receiver->lname</td>
                                                                            <td>$amount $ptransfer->currency</td>
                                                                            <td>
                                                                                <a href='#' class='btncancelTransfer' data-href='$ptransfer->leadger_id'><span class='las la-trash danger' style='font-size:25px'></span></a>
                                                                                <a href='Edite.php?edit=$ptransfer->leadger_id&op=ot'><span class='las la-edit' style='font-size:25px'></span></a>
                                                                            </td>
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
                                <th>#</th>
                                <th>TID</th>
                                <th>Date</th>
                                <th>Details</th>
                                <th>Account</th>
                                <th>Amount</th>
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

<?php
include("./master/footer.php");
?>

<script>
    $(document).ready(function() {

        var t1 = $("#tblaccountmoney").DataTable();
        var t2 = $("#tbldaily").DataTable();
        var t3 = $("#tbldaily2").DataTable();

        // get all daily customers list
        CompanyCustomers = [];
        $.get("../app/Controllers/Bussiness.php", {
            Customers: true
        }, function(data) {
            ndata = $.parseJSON(data);
            CompanyCustomers = ndata;
        });

        // pending transfers table
        tblPendingTransfers = $("#tblpendingTransfers").DataTable();

        // Paid transfers table
        tblpaidTransfers = $("#tblPaidTransfers").DataTable();

        $(document).on("click", ".tRow", function() {
            leadger_id = $(this).attr("data-href");
            $.get("../app/Controllers/Transfer.php", {
                "transferoutalldetails": true,
                "leadger_id": leadger_id
            }, function(data) {
                ndata = $.parseJSON(data);
                t3.clear();
                ndata.forEach((element, index) => {
                    // date
                    date = new Date(element.reg_date * 1000);
                    newdate = date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate();
                    amount = new Intl.NumberFormat("en-US",{maximumFractionDigits:2,minimumFractionDigits:2}).format(element.amount);
                    t3.row.add([
                        index,
                        element.account_money_id,
                        newdate,
                        element.details,
                        element.account_name,
                        (amount + " " + element.currency),
                        element.ammount_type
                    ]).draw(false);
                });
                $("#showpendingdetails").modal("show");
            });

        })

        $(document).on("click", ".btncancelTransfer", function(e) {
            e.preventDefault();
            ths = $(this);
            transfer_id = $(ths).attr("data-href");

            $.confirm({
                icon: 'fa fa-trash',
                theme: 'modern',
                closeIcon: true,
                animation: 'scale',
                type: 'blue',
                title: 'Are you sure?',
                content: 'if you delete this transaction, it will be deleted forever.',
                buttons: {
                    confirm: {
                        text: 'Yes',
                        action: function() {
                            $.post("../app/Controllers/Transfer.php", {
                                "cancel_transer_done": true,
                                "transferID": transfer_id
                            }, function(data) {
                                $(ths).parent().parent().fadeOut();
                            });
                        }
                    },
                    cancel: {
                        text: 'No',
                        action: function() {}
                    }
                }
            });
        });

        // get new Paid Out Tranfers
        setInterval(() => {
            $.post("../app/Controllers/Transfer.php", {
                newOutTranfersPaid: true
            }, function(data) {
                ndata = $.parseJSON(data);
                if (ndata.length > 0) {
                    tblpaidTransfers.clear();
                    ndata.forEach(element => {
                        // get to data
                        to_cus = CompanyCustomers.filter(cus => cus.customer_id == element.company_user_receiver);
                         // get receiver details
                         $.get("../app/Controllers/Transfer.php", {
                            DCMS: true,
                            id: element.money_receiver
                        }, function(data) {
                            receiver = $.parseJSON(data);
                            // sender
                            $.get("../app/Controllers/Transfer.php", {
                                DCMS: true,
                                id: element.money_sender
                            }, function(data) {
                                sender = $.parseJSON(data);
                                // get to data
                                to_cus = CompanyCustomers.filter(cus => cus.customer_id == element.company_user_receiver);

                                // date
                                date = new Date(element.reg_date * 1000);
                                newdate = date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate();
                                btn = `<a href='#' class='btncancelTransfer' data-href='${element.leadger_id}'><span class='las la-trash danger' style='font-size:25px'></span></a>
                                    <a href='Edite.php?edit=${element.leadger_id}&op=ot'><span class='las la-edit' style='font-size:25px'></span></a>`;
                                // date
                                date = new Date(element.reg_date * 1000);
                                newdate = date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate();
                                // btn = `<a class='btn btn-sm btn-blue text-white' href='Edite.php?edit=${element.leadger_id}&op=ot'><span class='las la-edit la-2x'></span></a>`;
                                btn = `<span class='las la-smile text-primary la-2x'></span>`;
                                amount = new Intl.NumberFormat("en-US",{maximumFractionDigits:2,minimumFractionDigits:2}).format(element.amount);
                                var rowNode = tblpaidTransfers.row.add([element.transfer_code,newdate, element.details, to_cus[0].fname + " " + to_cus[0].lname,sender.fname+" "+sender.lname,receiver.fname+" "+receiver.lname ,amount + " " + element.currency, btn]).draw().node();
                                $(rowNode).addClass('mainrow');
                                $(rowNode).find('td').eq(1).addClass('tRow').attr("data-href", element.leadger_id);
                            });
                        });
                    });
                }
            });
        }, 10000);

        // get new Pending Out Tranfers
        setInterval(() => {
            $.post("../app/Controllers/Transfer.php", {
                newOutTranfersPendings: true
            }, function(data) {
                ndata = $.parseJSON(data);
                if (ndata.length > 0) {
                    tblPendingTransfers.clear();
                    ndata.forEach(element => {
                        // get receiver details
                        $.get("../app/Controllers/Transfer.php", {
                            DCMS: true,
                            id: element.money_receiver
                        }, function(data) {
                            receiver = $.parseJSON(data);
                            // sender
                            $.get("../app/Controllers/Transfer.php", {
                                DCMS: true,
                                id: element.money_sender
                            }, function(data) {
                                sender = $.parseJSON(data);
                                // get to data
                                to_cus = CompanyCustomers.filter(cus => cus.customer_id == element.company_user_receiver);

                                // date
                                date = new Date(element.reg_date * 1000);
                                newdate = date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate();
                                btn = `<a href='#' class='btncancelTransfer' data-href='${element.leadger_id}'><span class='las la-trash danger' style='font-size:25px'></span></a>
                                    <a href='Edite.php?edit=${element.leadger_id}&op=ot'><span class='las la-edit' style='font-size:25px'></span></a>`;
                                amount = new Intl.NumberFormat("en-US",{maximumFractionDigits:2,minimumFractionDigits:2}).format(element.amount);
                                var rowNode = tblPendingTransfers.row.add([element.transfer_code, newdate, element.details, to_cus[0].fname + " " + to_cus[0].lname, sender.fname + " " + sender.lname, receiver.fname + " " + receiver.lname, amount + " " + element.currency, btn]).draw().node();
                                // $(rowNode).addClass('mainrow');
                                // $(rowNode).find('td').eq(1).addClass('tRow').attr("data-href", element.leadger_id);
                            });
                        });
                    });
                }
            });
        }, 10000);
    });
</script>