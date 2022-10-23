<?php
$Active_nav_name = array("parent" => "Dashboard", "child" => "");
$page_title = "Dashboard";
include("./master/header.php");

$banks = new Banks();
$bussiness = new Bussiness();
$transfer = new Transfer();
$saraf = new Saraf();

// get all currency Exchanges
$exchange_data = $banks->getCompanyExchangeConversion($user_data->company_id);
$exchange = $exchange_data->fetchAll(PDO::FETCH_OBJ);

// get top debetors
$debtors_data = $bussiness->getTopDebetos($user_data->company_id);
$debtors = $debtors_data->fetchAll(PDO::FETCH_OBJ);

$company_FT_data = $company->getCompanyActiveFT($user_data->company_id);
$company_ft = $company_FT_data->fetch(PDO::FETCH_OBJ);
$company_financial_term_id = 0;
if (isset($company_ft->term_id)) {
    $company_financial_term_id = $company_ft->term_id;
}

// get pending transfers
$pending_transfers = $transfer->getPendingInTransfer($user_data->company_id, $company_financial_term_id);
$pending_transfers_out = $transfer->getPendingOutTransfer($user_data->company_id, $company_financial_term_id);

// total sarafs
$total_sarafs = $saraf->getTotalSaraf($user_data->company_id);

// total customers
$total_customers = $bussiness->getTotalCompanyCustomers($user_data->company_id);
?>

<style>
    .newNav {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
    }

    .newNav i {
        border: 1px solid dodgerblue;
        border-radius: 0px 50% 50% 0px;
        padding: 6px;
        background: white;
        color: dodgerblue;
    }

    .newNav span {
       padding-right: 4px;
    }

    .hover:hover {
        transition: all .5s ease-in-out;
        rotate: 360deg;
    }

    .text-hover:hover {
        transform: scale(1.08);
    }

    .content-header{
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        row-gap: 5px;
        column-gap: 2px;
        align-items: center;
        justify-content: center;
    }
</style>

<!-- END: Main Menu-->
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header mb-1">
            <!-- navigation Section -->
            <div class="col-lg-2 col-sm-4 btn btn-sm btn-blue newNav p-0">
                <i class="las la-users fa-3x"></i>
                <a href="./ContactList.php" class="text-white text-hover">Contacts</a>
                <a href="./NewContact.php" class="text-white"><span class="las la-plus fa-2x hover"></span></a>
            </div>
            <div class="col-lg-2 col-sm-4 btn btn-sm btn-blue newNav p-0">
                <i class="las la-coins fa-3x"></i>
                <a href="./Receipts.php" class="text-white text-hover">Receipts</a>
                <a href="./NewReceipt.php" class="text-white"><span class="las la-plus fa-2x hover"></span></a>
            </div>
            <div class="col-lg-2 col-sm-4 btn btn-sm btn-blue newNav p-0">
                <i class="las la-wallet fa-3x"></i>
                <a href="./Payments.php" class="text-white text-hover">Payments</a>
                <a href="./NewPayment.php" class="text-white"><span class="las la-plus fa-2x hover"></span></a>
            </div>
            <div class="col-lg-2 col-sm-4 btn btn-sm btn-blue newNav p-0">
                <i class="las la-credit-card fa-3x"></i>
                <a href="./Revenues.php" class="text-white text-hover">Revenue</a>
                <a href="./NewRevenue.php" class="text-white"><span class="las la-plus fa-2x hover"></span></a>
            </div>
            <div class="col-lg-2 col-sm-4 btn btn-sm btn-blue newNav p-0">
                <i class="las la-credit-card fa-3x"></i>
                <a href="./expenses.php" class="text-white text-hover">Expens</a>
                <a href="./NewExpense.php" class="text-white"><span class="las la-plus fa-2x hover"></span></a>
            </div>
            <div class="col-lg-2 col-sm-4 btn btn-sm btn-blue newNav p-0">
                <i class="las la-arrow-right fa-3x"></i>
                <a href="./OutTransferences.php" class="text-white text-hover">OUT-T</a>
                <a href="./NewOutTransference.php" class="text-white"><span class="las la-plus fa-2x hover"></span></a>
            </div>
            <div class="col-lg-2 col-sm-4 btn btn-sm btn-blue newNav p-0">
                <i class="las la-arrow-left fa-3x"></i>
                <a href="./InTransferences.php" class="text-white text-hover">IN-T</a>
                <a href="./NewInTransference.php" class="text-white"><span class="las la-plus fa-2x hover"></span></a>
            </div>
            <div class="col-lg-2 col-sm-4 btn btn-sm btn-blue newNav p-0">
                <i class="las la-chart-pie fa-3x"></i>
                <a href="./AllReports.php" class="text-white text-hover">Reports</a>
                <a href="./AllReports.php" class="text-white text-hover"><span class="las la-eye fa-2x hover"></span></a>
            </div>
        </div>
        <div class="content-body">
            <!-- Bank Stats -->
            <section id="bank-cards" class="bank-cards">
                <div class="row match-height">
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                        <div class="card bank-card pull-up bg-primary">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-5 text-left">
                                            <h3 class="mb-0 text-white"><?php echo $pending_transfers->rowCount(); ?></h3>
                                            <p class="text-white">Pending</p>
                                            <h4 class="text-white mt-1">In Transfers</h4>
                                        </div>
                                        <div class="col-7">
                                            <div class="float-right">
                                                <canvas id="gold-chart" class="height-75"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                        <div class="card bank-card pull-up bg-danger">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-5 text-left">
                                            <h3 class="mb-0 text-white"><?php echo $pending_transfers_out->rowCount(); ?></h3>
                                            <p class="text-white">Pending</p>
                                            <h4 class="text-white mt-0">Out Transfers</h4>
                                        </div>
                                        <div class="col-7">
                                            <div class="float-right">
                                                <canvas id="silver-chart" class="height-75"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                        <div class="card bank-card pull-up bg-blue">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-5 text-left">
                                            <h3 class="mb-0 text-white"><?php echo $total_sarafs->rowCount(); ?></h3>
                                            <p class="text-white">Total</p>
                                            <h4 class="text-white mt-1">Sarafs</h4>
                                        </div>
                                        <div class="col-7">
                                            <div class="float-right">
                                                <canvas id="euro-chart" class="height-75"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                        <div class="card bank-card pull-up bg-info">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-5 text-left">
                                            <h3 class="mb-0 text-white"><?php echo $total_customers->rowCount(); ?></h3>
                                            <p class="text-white">Total</p>
                                            <h4 class="text-white mt-1">Customers</h4>
                                        </div>
                                        <div class="col-7">
                                            <div class="float-right">
                                                <canvas id="bitcoin-chart" class="height-75"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6" style="cursor: pointer;" id="btndailyTran">
                        <div class="card bank-card pull-up" style="background: #FB5607;">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-5 text-left">
                                            <P class="mb-0 text-white">ROZNAMCHA</P>
                                            <hr style="background-color: white;">
                                            <P class="mb-0 text-white">Daily Transaction</P>
                                        </div>
                                        <div class="col-7">
                                            <div class="float-right">
                                                <canvas id="bitcoin-chart" class="height-75"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-12">
                        <div>
                            <div class="card recent-loan">
                                <div class="card-header">
                                    <h4 class="text-center">Currency Exchange</h4>
                                </div>
                                <div class="card-content">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="border-top-0">Currencies</th>
                                                    <th class="border-top-0">Rate</th>
                                                    <th class="border-top-0">Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $prevC = array();
                                                foreach ($exchange as $ex) {
                                                    if (!in_array(($ex->currency_from . '-' . $ex->currency_to), $prevC)) {
                                                        $dat = date("m/d/Y", $ex->reg_date);
                                                        echo "<tr>
                                                                <td>$ex->currency_from - $ex->currency_to</td>
                                                                <td class='text-truncate'>$ex->rate</td>
                                                                <td>$dat</td>
                                                            </tr>";
                                                    }
                                                    array_push($prevC, $ex->currency_from . '-' . $ex->currency_to);
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="card recent-loan bg-blue bg-lighten-2">
                                <div class="card-header">
                                    <h4 class="text-center text-white">Top 20 Debtors</h4>
                                </div>
                                <div class="card-content">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr class="bg-blue bg-lighten-2">
                                                    <th class="border-top-0 text-white">Name</th>
                                                    <th class="border-top-0 text-white">Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // foreach ($debtors as $debts) {
                                                ?>
                                                    <tr class="bg-blue bg-lighten-5">
                                                        <td><?php //echo $debts->account_name; 
                                                            ?></td>
                                                        <td class="text-truncate"><?php //echo $debts->debits - $debts->credits; 
                                                                                    ?></td>
                                                    </tr>
                                                <?php //} 
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>

                <!-- <div class="col-lg-6 col-md-12">
                        <div class="card recent-loan bg-blue bg-lighten-2">
                            <div class="card-header">
                                <h4 class="text-center text-white">Live Currency Exchange</h4>
                                <h6 class="text-center text-white">Base Currency <span id="basec" style="font-weight: bold;"></span></h6>
                                <h6 class="text-center text-white" id="basedate"></h6>
                            </div>
                            <div class="card-content">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover" id="liveCurrency">
                                            <thead>
                                                <tr class="bg-blue bg-lighten-4">
                                                    <th class="border-top-0">Currency</th>
                                                    <th class="border-top-0">Rate</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
        </div>
        </section>
    </div>
</div>
</div>

<!-- Modal Daily Transaction -->
<div class="modal fade text-center" id="riznamcha" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-body p-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-center">Daily Transactions</h4>
                    </div>
                    <div class="card-content">
                        <div class="table-responsive p-1">
                            <table class="table table-hover material-table" id="tbdailyT">
                                <thead>
                                    <tr>
                                        <th class="border-top-0">Amount</th>
                                        <th class="border-top-0">Debit</th>
                                        <th class="border-top-0">Credit</th>
                                        <th class="border-top-0">Type</th>
                                        <th class="border-top-0">Acount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $today = date("m/d/Y", time());
                                    $allTrans = $banks->getAllTransactions($user_data->company_id, $term_id);
                                    foreach ($allTrans as $at) {
                                        $tdate = date("m/d/Y", $at->reg_date);
                                        $debit = 0;
                                        $credit = 0;
                                        if ($at->ammount_type === "Debet") {
                                            $debit = "<span class='las la-check text-blue fa-2x' style='font-weight: bold;'></span>";
                                            $credit = "<span class='las la-times text-danger fa-2x' style='font-weight: bold;'></span>";
                                        } else {
                                            $credit = "<span class='las la-check text-blue fa-2x' style='font-weight: bold;'></span>";
                                            $debit = "<span class='las la-times text-danger fa-2x' style='font-weight: bold;'></span>";
                                        }
                                        if ($tdate == $today) {
                                            echo "<tr data-href='$tdate'>
                                                            <td>$at->amount $at->currency</td>
                                                            <td>$debit</td>
                                                            <td>$credit</td>
                                                            <td>$at->op_type</td>
                                                            <td>$at->account_name</td>
                                                        </tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- END: Content-->
<?php
include("./master/footer.php");
?>

<script>
    $(document).ready(function() {
        // main currency
        mainCurrency = $("#mainC").attr("data-href");

        liveCurrencyTable = $("#liveCurrency").DataTable({
            dom: 'Bfrtip',
            filter: true,
            buttons: [
                'excel',
                {
                    extend: 'pdf',
                    customize: function(doc) {
                        doc.content[1].table.widths =
                            Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                    },
                    footer: true
                },
                {
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
                }
            ],
            processing: true
        });

        // get live exchange rates
        // setInterval(() => {
        //     getRates(mainCurrency);
        // }, 10000);

        $("#btndailyTran").on("click", function() {
            $("#riznamcha").modal("show");
        });
    });

    const getRates = (mainC) => {
        // get live exchange rates
        $.ajax({
            url: "https://api.apilayer.com/exchangerates_data/latest?base=" + mainC,
            method: "GET",
            headers: {
                apikey: "Qh8dI7n50xvgHOCxWYCFP1Oi8aWZlbkf"
            },
            success: function(data) {
                liveCurrencyTable.clear();
                $("#basec").text(mainC);
                $("#basedate").text(data.date);
                rates = data.rates;
                for (const [key, value] of Object.entries(rates)) {
                    var row = liveCurrencyTable.row.add([key, value]).draw().node();
                    $(row).addClass("bg-blue bg-lighten-4");
                }

            }
        })
    }
</script>