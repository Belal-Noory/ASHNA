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
</style>
<div class="container mt-2" id="mainc" data-href="<?php echo $mainCurrency; ?>">
    <h2 class="text-muted mb-1">All Reports</h2>
    <div class="row">
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
                                <a class="media-link" href="#" data-href="balancesheet">
                                    <span class="media-left"><i class="la la-star-o"></i></span>
                                    <span class="media-body">Balance Sheet</span>
                                </a>
                            </div>
                            <div class="list-group-item list-group-item-action media">
                                <a class="media-link" href="#" data-href="profit/lossStmnt">
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
                                <a class="media-link" href="#" data-href="contactCard">
                                    <span class="media-left"><i class="la la-star-o"></i></span>
                                    <span class="media-body">Contact Card</span>
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
                            <div class="list-group-item list-group-item-action media">
                                <a class="media-link" href="#" data-href="pcashT">
                                    <span class="media-left"><i class="la la-star-o"></i></span>
                                    <span class="media-body">Petty Cash Transactions</span>
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
    <div class="modal-dialog modal-xl" role="document">
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

                <div class="container-done d-none p-3">
                    <table class="table" id="loginTable">
                        <thead><th>User</th><th>Action</th><th>Date</th></thead>
                        <tbody></tbody>
                    </table>

                    <table class="table" id="activityTable">
                        <thead><th>User</th><th>Model</th><th>Action</th><th>Details</th><th>Date</th></thead>
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

        $('.Table').DataTable({
            dom: 'Bfrtip',
            select: true,
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

        tblLogin = $("#loginTable").DataTable();
        tblActivity = $("#activityTable").DataTable();

        $(document).on("click", ".media-body", function(e) {
            e.preventDefault();
            
            $('#activityTable_wrapper').addClass("d-none");
            $('#loginTable_wrapper').addClass("d-none");

            var type = $(this).parent().attr("data-href");
            $("#show").modal("show");
            
            // login logs
            if (type === "loginlogs") {
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
</script>