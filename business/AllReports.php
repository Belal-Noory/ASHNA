<?php
$Active_nav_name = array("parent" => "Reports", "child" => "All Reports");
$page_title = "Reports";
include("./master/header.php");
// Logged in user info 
$report = new Reports();
$bank = new Banks();

$allCatagories_data = $report->getReportsCatagory($user_data->company_id);
$allCatagories = $allCatagories_data->fetchAll(PDO::FETCH_OBJ);

$company_curreny_data = $company->GetCompanyCurrency($user_data->company_id);
$company_curreny = $company_curreny_data->fetchAll(PDO::FETCH_OBJ);
$mainCurrency = "";
foreach ($company_curreny as $currency) {
    if ($currency->mainCurrency) {
        $mainCurrency = $currency->currency;
    }
}
// cards color
$colors = array("info", "danger", "success", "warning");
?>
<style>
    .media-link {
        color: gray;
    }

    #assetsBadge,
    #eqityBadge {
        display: flex;
        flex-direction: row;
        margin: 8px;
    }

    #assetsBadge i.title,
    #eqityBadge i.title {
        margin-right: auto;
    }
</style>
<div class="container mt-2" id="mainc" data-href="<?php echo $mainCurrency; ?>">
    <h2 class="text-muted mb-1">All Reports</h2>
    <div class="row" id="user" data-href="<?php $user_data->user_id; ?>">
        <!-- left -->
        <div class="col col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Financial</h4>
                </div>
                <div class="card-content">
                    <div class="card-body p-0">
                        <div class="media-list list-group">
                            <div class="list-group-item list-group-item-action media">
                                <a class="media-link" href="#" data-href="balance">
                                    <span class="media-left"><i class="la la-star-o"></i></span>
                                    <span class="media-body">Balance Sheet</span>
                                </a>
                            </div>
                            <div class="list-group-item list-group-item-action media">
                                <a class="media-link" href="#" data-href="profitlossStmnt">
                                    <span class="media-left"><i class="la la-star-o"></i></span>
                                    <span class="media-body">Profit/Loss Statement</span>
                                </a>
                            </div>
                            <div class="list-group-item list-group-item-action media">
                                <a class="media-link" href="#" data-href="capitalStmnt">
                                    <span class="media-left"><i class="la la-star-o"></i></span>
                                    <span class="media-body">Capital Statement</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Accounting</h4>
                </div>
                <div class="card-content">
                    <div class="card-body p-0">
                        <div class="media-list list-group">
                            <div class="list-group-item list-group-item-action media">
                                <a class="media-link" href="#" data-href="leadger">
                                    <span class="media-left"><i class="la la-star-o"></i></span>
                                    <span class="media-body">Leadger</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Contacts</h4>
                </div>
                <div class="card-content">
                    <div class="card-body p-0">
                        <div class="media-list list-group">
                            <div class="list-group-item list-group-item-action media">
                                <a class="media-link" href="#" data-href="debetor/creditor">
                                    <span class="media-left"><i class="la la-star-o"></i></span>
                                    <span class="media-body">Debtors/Creditors</span>
                                </a>
                            </div>
                            <div class="list-group-item list-group-item-action media">
                                <a class="media-link" href="#" data-href="contactCard" type="Legal Entity">
                                    <span class="media-left"><i class="la la-star-o"></i></span>
                                    <span class="media-body">KYC Legal Entity</span>
                                </a>
                            </div>
                            <div class="list-group-item list-group-item-action media">
                                <a class="media-link" href="#" data-href="contactCard" type="Individual">
                                    <span class="media-left"><i class="la la-star-o"></i></span>
                                    <span class="media-body">KYC Indivitual</span>
                                </a>
                            </div>
                            <div class="list-group-item list-group-item-action media">
                                <a class="media-link" href="#" data-href="contactCard" type="MSP">
                                    <span class="media-left"><i class="la la-star-o"></i></span>
                                    <span class="media-body">KYC MSP</span>
                                </a>
                            </div>
                            <div class="list-group-item list-group-item-action media">
                                <a class="media-link" href="#" data-href="contactCard" type="Share holders">
                                    <span class="media-left"><i class="la la-star-o"></i></span>
                                    <span class="media-body">KYC Shareholder</span>
                                </a>
                            </div>
                            <div class="list-group-item list-group-item-action media">
                                <a class="media-link" href="#" data-href="contactCard" type="Daily Customer">
                                    <span class="media-left"><i class="la la-star-o"></i></span>
                                    <span class="media-body">KYC Daily Customer</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right -->
        <div class="col col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Banking</h4>
                </div>
                <div class="card-content">
                    <div class="card-body p-0">
                        <div class="media-list list-group">
                            <div class="list-group-item list-group-item-action media">
                                <a class="media-link" href="#" data-href="bankT">
                                    <span class="media-left"><i class="la la-star-o"></i></span>
                                    <span class="media-body">Bank Transactions</span>
                                </a>
                            </div>
                            <div class="list-group-item list-group-item-action media">
                                <a class="media-link" href="#" data-href="cashRegisterT">
                                    <span class="media-left"><i class="la la-star-o"></i></span>
                                    <span class="media-body">Cash Register Transactions</span>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">In/Out Transfers</h4>
                </div>
                <div class="card-content">
                    <div class="card-body p-0">
                        <div class="media-list list-group">
                            <div class="list-group-item list-group-item-action media">
                                <a class="media-link" href="#" data-href="inTransfers">
                                    <span class="media-left"><i class="la la-star-o"></i></span>
                                    <span class="media-body">In Transfers Transactions</span>
                                </a>
                            </div>
                            <div class="list-group-item list-group-item-action media">
                                <a class="media-link" href="#" data-href="outTransfers">
                                    <span class="media-left"><i class="la la-star-o"></i></span>
                                    <span class="media-body">Out Transfers Transactions</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Money Exchange</h4>
                </div>
                <div class="card-content">
                    <div class="card-body p-0">
                        <div class="media-list list-group">
                            <div class="list-group-item list-group-item-action media">
                                <a class="media-link" href="#" data-href="exchangeT">
                                    <span class="media-left"><i class="la la-star-o"></i></span>
                                    <span class="media-body">Exchange Transactions</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">User Logs</h4>
                </div>
                <div class="card-content">
                    <div class="card-body p-0">
                        <div class="media-list list-group">
                            <div class="list-group-item list-group-item-action media">
                                <a class="media-link" href="#" data-href="loginlogs">
                                    <span class="media-left"><i class="la la-star-o"></i></span>
                                    <span class="media-body">Login Logs</span>
                                </a>
                            </div>
                            <div class="list-group-item list-group-item-action media">
                                <a class="media-link" href="#" data-href="activitylogs">
                                    <span class="media-left"><i class="la la-star-o"></i></span>
                                    <span class="media-body">Activity Logs</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true">
    <div class="modal-dialog modal-xl p-0" role="document">
        <div class="modal-content p-0">
            <div class="modal-body p-0">
                <div class="container container-waiting">
                    <div class="loader-wrapper">
                        <div class="loader-container">
                            <div class="ball-clip-rotate loader-primary">
                                <div></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-done d-none p-1">
                    <!-- Login Logs Report -->
                    <table class="table p-0 customeTable" id="loginTable">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Action</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <!-- Activity Logs Report -->
                    <table class="table p-0 customeTable" id="activityTable">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Model</th>
                                <th>Action</th>
                                <th>Details</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                    <!-- Transactions Report -->
                    <table class="table p-0 customeTable display compact" id="transactionsTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Bank/Cash Register</th>
                                <th>TID</th>
                                <th>Leadger</th>
                                <th>Date</th>
                                <th>Details</th>
                                <th>Debet</th>
                                <th>Credit</th>
                                <th>Balance</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                    <!-- In/Out Transference Report -->
                    <table class="table p-0 customeTable display compact" id="inoutTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>LID</th>
                                <th>Date</th>
                                <th>TID</th>
                                <th>Details</th>
                                <th>Saraf</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Currency</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                    <!-- Exchange Transaction Report -->
                    <table class="table p-0 customeTable display compact" id="exchangeTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>LID</th>
                                <th>EID</th>
                                <th>Date</th>
                                <th>Details</th>
                                <th>From</th>
                                <th>Currency</th>
                                <th>Amount</th>
                                <th>To</th>
                                <th>Currency</th>
                                <th>Amount</th>
                                <th>Rate</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
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
        var getUrl = window.location;
        var baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];

        $('.customeTable').DataTable({
            dom: 'Bfrtip',
            orderCellsTop: true,
            filter: true,
            "autoWidth": false,
            "columnDefs": [{
                "targets": '_all',
                "createdCell": function(td, cellData, rowData, row, col) {
                    $(td).css('padding', '0px')
                }
            }],
            buttons: [
                'excel', {
                    extend: 'pdf',
                    customize: function(doc) {
                        doc.content[1].table.widths =
                            Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                    },
                    footer: true
                }, {
                    extend: 'print',
                    customize: function(win) {
                        $(win.document.body)
                            .css("margin", "40pt 20pt 20pt 20pt")
                            .prepend(
                                `<div style='display:flex;flex-direction:column;justify-content:center;align-items:center'><img src="${baseUrl}/business/app-assets/images/logo/ashna_trans.png" style='width:60pt' /><span>ASHNA Company</span></div>`
                            );

                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    },
                    footer: true
                }, 'colvis'
            ],
            "processing": true
        });

        // Loged in user ID
        userID = $("#user").attr("data-href");

        tblLogin = $("#loginTable").DataTable();
        tblActivity = $("#activityTable").DataTable();
        tblTransaction = $('#transactionsTable').DataTable();
        tblInOutTransaction = $('#inoutTable').DataTable();
        exchangeTransaction = $('#exchangeTable').DataTable();

        $(document).on("click", ".media-body", function(e) {
            e.preventDefault();
            if ($(this).parent().attr("data-href") !== "balancesheet") {
                $('#activityTable_wrapper').addClass("d-none");
                $('#loginTable_wrapper').addClass("d-none");
                $('#transactionsTable_wrapper').addClass("d-none");
                $('#inoutTable_wrapper').addClass("d-none");
                $('#exchangeTable_wrapper').addClass("d-none");

                var type = $(this).parent().attr("data-href");

                // login logs
                if (type === "loginlogs") {
                    $("#show").modal("show");
                    tblLogin.clear();
                    $.get("../app/Controllers/Reports.php", {
                        loginlogs: true
                    }, function(data) {
                        $('#loginTable_wrapper').removeClass("d-none");
                        ndata = $.parseJSON(data);
                        ndata.forEach(element => {
                            date = new Date(element.action_date * 1000);
                            newdate = date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate();
                            tblLogin.row.add([element.fname + " " + element.lname, element.user_action, newdate]).draw(false);
                        });
                        $(".container-waiting").addClass("d-none");
                        $(".container-done").removeClass("d-none");
                    });
                }

                // Activity Logs
                if (type === "activitylogs") {
                    $("#show").modal("show");
                    tblActivity.clear();
                    $.get("../app/Controllers/Reports.php", {
                        activitylogs: true
                    }, function(data) {
                        console.log(data);
                        $('#activityTable_wrapper').removeClass("d-none");
                        ndata = $.parseJSON(data);
                        ndata.forEach(element => {
                            tblActivity.row.add([element.fname + " " + element.lname, element.tble, element.user_action, element.details, element.reg_date]).draw(false);
                        });
                        $(".container-waiting").addClass("d-none");
                        $(".container-done").removeClass("d-none");
                    });
                }

                // Bank Transaction Reports
                if (type === "bankT") {
                    $("#show").modal("show");
                    tblTransaction.clear();
                    $.get("../app/Controllers/Reports.php", {
                        bankReports: true
                    }, function(data) {
                        $('#transactionsTable_wrapper').removeClass("d-none");
                        ndata = $.parseJSON(data);
                        counter = 0;
                        balance = 0;
                        ndata.forEach(element => {
                            date = new Date(element.reg_date * 1000);
                            newdate = date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate();
                            debet = 0;
                            credit = 0;
                            if (element.ammount_type === "Debet") {
                                debet = parseFloat(element.amount);
                            } else {
                                credit = parseFloat(element.amount);
                            }
                            balance = parseFloat((balance + debet) - credit);
                            tblTransaction.row.add([counter, element.account_name, element.account_money_id, element.leadger_ID, newdate, element.detials, debet.toLocaleString(), credit.toLocaleString(), balance.toLocaleString()]).draw(false);
                            counter++;
                        });
                        // This function will be triggered every time any ajax request is requested and completed
                        $("#transactionsTable").children("thead").children("tr:nth-child(2)").children("th").each(function(i) {
                            var select = $('<select class="form-control"><option value="">Filter</option></select>')
                                .appendTo($(this).empty())
                                .on('change', function() {
                                    tblTransaction.column(i)
                                        .search($(this).val())
                                        .draw();
                                });
                            tblTransaction.column(i).data().unique().sort().each(function(d, j) {
                                select.append(`<option value='${d}'>${d}</option>`);
                            });
                        });
                        tblTransaction.columns.adjust().draw();
                        $(".container-waiting").addClass("d-none");
                        $(".container-done").removeClass("d-none");
                    });
                }

                // Cash Register Transaction Reports
                if (type === "cashRegisterT") {
                    $("#show").modal("show");
                    tblTransaction.clear();
                    $.get("../app/Controllers/Reports.php", {
                        cashReports: true
                    }, function(data) {
                        $('#transactionsTable_wrapper').removeClass("d-none");
                        ndata = $.parseJSON(data);
                        counter = 0;
                        balance = 0;
                        ndata.forEach(element => {
                            date = new Date(element.reg_date * 1000);
                            newdate = date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate();
                            debet = 0;
                            credit = 0;
                            if (element.ammount_type === "Debet") {
                                debet = parseFloat(element.amount);
                            } else {
                                credit = parseFloat(element.amount);
                            }
                            balance = parseFloat((balance + debet) - credit);
                            tblTransaction.row.add([counter, element.account_name, element.account_money_id, element.leadger_ID, newdate, element.detials, debet.toLocaleString(), credit.toLocaleString(), balance.toLocaleString()]).draw(false);
                            counter++;
                        });
                        // This function will be triggered every time any ajax request is requested and completed
                        $("#transactionsTable").children("tfoot").children("tr").children("th").each(function(i) {
                            var select = $('<select class="form-control"><option value="">Filter</option></select>')
                                .appendTo($(this).empty())
                                .on('change', function() {
                                    tblTransaction.column(i)
                                        .search($(this).val())
                                        .draw();
                                });
                            tblTransaction.column(i).data().unique().sort().each(function(d, j) {
                                select.append(`<option value='${d}'>${d}</option>`);
                            });
                        });
                        $(".container-waiting").addClass("d-none");
                        $(".container-done").removeClass("d-none");
                    });
                }

                // In Transfers Reports
                if (type === "inTransfers") {
                    $("#show").modal("show");
                    tblInOutTransaction.clear();
                    $.get("../app/Controllers/Reports.php", {
                        InTransfers: true
                    }, function(data) {
                        $('#inoutTable_wrapper').removeClass("d-none");
                        ndata = $.parseJSON(data);
                        counter = 0;
                        ndata.forEach(element => {
                            date = new Date(element.reg_date * 1000);
                            newdate = date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate();
                            saraf = "";
                            paid = "";
                            if (element.sender_id == userID) {
                                saraf = element.userreceiver_name;
                            } else {
                                saraf = element.usersender_name;
                            }
                            if (element.paid == "1") {
                                paid = "Yes";
                            } else {
                                paid = "No";
                            }
                            amount = element.amount.toLocaleString();
                            tblInOutTransaction.row.add([counter, element.leadger_id, newdate, element.TID, element.details, saraf, element.moneysender_name, element.moneyreceiver_name, element.currency, amount, paid]).draw(false);
                            counter++;
                        });
                        // This function will be triggered every time any ajax request is requested and completed
                        $("#inoutTable").children("thead").children("tr:nth-child(2)").children("th").each(function(i) {
                            var select = $('<select class="form-control"><option value="">Filter</option></select>')
                                .appendTo($(this).empty())
                                .on('change', function() {
                                    tblInOutTransaction.column(i)
                                        .search($(this).val())
                                        .draw();
                                });
                            tblInOutTransaction.column(i).data().unique().sort().each(function(d, j) {
                                select.append(`<option value='${d}'>${d}</option>`);
                            });
                        });
                        $(".container-waiting").addClass("d-none");
                        $(".container-done").removeClass("d-none");
                    });
                }

                // Out Transfers Reports
                if (type === "outTransfers") {
                    $("#show").modal("show");
                    tblInOutTransaction.clear();
                    $.get("../app/Controllers/Reports.php", {
                        OutTransfers: true
                    }, function(data) {
                        $('#inoutTable_wrapper').removeClass("d-none");
                        ndata = $.parseJSON(data);
                        console.log(ndata);
                        counter = 0;
                        ndata.forEach(element => {
                            date = new Date(element.reg_date * 1000);
                            newdate = date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate();
                            saraf = "";
                            paid = "";
                            if (element.sender_id == userID) {
                                saraf = element.userreceiver_name;
                            } else {
                                saraf = element.usersender_name;
                            }
                            if (element.paid == "1") {
                                paid = "Yes";
                            } else {
                                paid = "No";
                            }
                            amount = element.amount.toLocaleString();
                            tblInOutTransaction.row.add([counter, element.leadger_id, newdate, element.TID, element.details, saraf, element.moneysender_name, element.moneyreceiver_name, element.currency, amount, paid]).draw(false);
                            counter++;
                        });
                        // This function will be triggered every time any ajax request is requested and completed
                        $("#inoutTable").children("thead").children("tr:nth-child(2)").children("th").each(function(i) {
                            var select = $('<select class="form-control"><option value="">Filter</option></select>')
                                .appendTo($(this).empty())
                                .on('change', function() {
                                    tblInOutTransaction.column(i)
                                        .search($(this).val())
                                        .draw();
                                });
                            tblInOutTransaction.column(i).data().unique().sort().each(function(d, j) {
                                select.append(`<option value='${d}'>${d}</option>`);
                            });
                        });
                        $(".container-waiting").addClass("d-none");
                        $(".container-done").removeClass("d-none");
                    });
                }

                // Exchange Transaction Reports
                if (type === "exchangeT") {
                    $("#show").modal("show");
                    exchangeTransaction.clear();
                    $.get("../app/Controllers/Reports.php", {
                        exchangeTransaction: true
                    }, function(data) {
                        $('#exchangeTable_wrapper').removeClass("d-none");
                        ndata = $.parseJSON(data);
                        console.log(ndata);
                        counter = 0;
                        prevID = 0;
                        cf = "";
                        ct = "";
                        acfrom = "";
                        act = "";
                        eid = "";
                        amountf = 0;
                        amountt = 0;
                        next = false;
                        console.log(ndata);
                        ndata.forEach(element => {
                            if (element.leadger_id == prevID) {
                                next = true;
                            } else {
                                cf = element.from_currency;
                                ct = element.currency_to;
                                acfrom = element.acfrom;
                                act = element.act;
                                eid = element.EID;
                                amountf = element.amount;
                            }

                            prevID = element.leadger_id;
                            if (next) {
                                amountt = element.amount;
                                amountf = amountf.toLocaleString();
                                amountt = amountt.toLocaleString();
                                date = new Date(element.reg_date * 1000);
                                newdate = date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate();
                                exchangeTransaction.row.add([counter, element.leadger_id, eid, newdate, element.details, acfrom, cf, amountf, act, ct, amountt, element.rate]).draw(false);
                                counter++;
                                prevID = 0;
                                cf = "";
                                ct = "";
                                acfrom = "";
                                act = "";
                                eid = "";
                                amountf = 0;
                                amountt = 0;
                                next = false;
                            }
                        });
                        // This function will be triggered every time any ajax request is requested and completed
                        $("#exchangeTable").children("tfoot").children("tr").children("th").each(function(i) {
                            var select = $('<select class="form-control"><option value="">Filter</option></select>')
                                .appendTo($(this).empty())
                                .on('change', function() {
                                    exchangeTransaction.column(i)
                                        .search($(this).val())
                                        .draw();
                                });
                            exchangeTransaction.column(i).data().unique().sort().each(function(d, j) {
                                select.append(`<option value='${d}'>${d}</option>`);
                            });
                        });
                        $(".container-waiting").addClass("d-none");
                        $(".container-done").removeClass("d-none");
                    });
                }

                // balance sheet
                if (type === "balance") {
                    window.location = baseUrl + "/balancesheet.php";
                }

                // Profit/Loss sheet
                if (type === "profitlossStmnt") {
                    window.location = baseUrl + "/profitloss.php";
                }

                // debitos/creditos
                if(type === "debetor/creditor"){
                    window.location = baseUrl + "/debitorsCreditorsReport.php";
                }

                // KYC
                if(type === "contactCard")
                {
                    kind = $(this).parent().attr("type");
                    window.location = baseUrl + "/KYC.php?type="+kind;
                }
            }
        });

        $(document).on("click", ".media-left", function(e) {
            e.preventDefault();
            ths = $(this);
            if ($(ths).children("i").hasClass("la-star-o")) {
                $(ths).children("i").removeClass("la-star-o").addClass("la-star")
            } else {
                $(ths).children("i").removeClass("la-star").addClass("la-star-o")
            }
        });
    });

    const getAllParents = (arr, seletor) => {
        prevCat = "";
        arr.forEach(element => {
            if (element.parent) {
                $(seletor).append(`<a href='#' class='list-group-item list-group-item-action balancehover d-flex justify-content-evenly' style='background-color: transparent;color: rgba(0,0,0,.5);' aria-current='true'>
                                    <span style='margin-right:auto'>${element.parent.account_name}</span>
                                    <span class='total'>${element.parent.amount}</span>
                                </a>`);
            } else {
                $(seletor).append(`<a href='#' class='list-group-item list-group-item-action balancehover d-flex justify-content-evenly' style='background-color: transparent;color: rgba(0,0,0,.5);' aria-current='true'>
                                    <span style='margin-right:auto'>${element.account_name}</span>
                                    <span class='total'>${element.amount}</span>
                                </a>`);
            }

            if (element.child) {
                getAllParents(element.child, seletor);
            }
        });

        total = 0;
        $(seletor).children("a").children("span.total").each(function() {
            total += parseFloat($(this).text());
        });
        return total;
    };
</script>