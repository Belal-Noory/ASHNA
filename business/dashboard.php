<?php
$Active_nav_name = array("parent" => "Dashboard", "child" => "");
$page_title = "Dashboard";
include("./master/header.php");

$banks = new Banks();
$bussiness = new Bussiness();

// get all currency Exchanges
$exchange_data = $banks->getCompanyExchangeConversion($user_data->company_id);
$exchange = $exchange_data->fetchAll(PDO::FETCH_OBJ);

// get top debetors
$debtors_data = $bussiness->getTopDebetos($user_data->company_id);
$debtors = $debtors_data->fetchAll(PDO::FETCH_OBJ);
?>

<!-- END: Main Menu-->
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
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
                                            <h3 class="mb-0 text-white">$1.2K</h3>
                                            <p class="text-white">per Ounce</p>
                                            <h4 class="text-white mt-1">Gold</h4>
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
                                            <h3 class="mb-0 text-white">$14.66</h3>
                                            <p class="text-white">per Ounce</p>
                                            <h4 class="text-white mt-1">Silver</h4>
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
                                            <h3 class="mb-0 text-white">$0.88</h3>
                                            <p class="text-white">per Unit</p>
                                            <h4 class="text-white mt-1">USD</h4>
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
                                            <h3 class="mb-0 text-white">$6.5K</h3>
                                            <p class="text-white">per unit</p>
                                            <h4 class="text-white mt-1">EURO</h4>
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
                    <div class="col-lg-6 col-md-12">
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
                                                foreach ($exchange as $ex) {
                                                    $dat = date("m/d/Y", $ex->reg_date);
                                                    echo "<tr>
                                                            <td>$ex->currency_from - $ex->currency_to</td>
                                                            <td class='text-truncate'>$ex->rate</td>
                                                            <td>$dat</td>
                                                        </tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="card recent-loan">
                                <div class="card-header">
                                    <h4 class="text-center">Top 20 Debtors</h4>
                                </div>
                                <div class="card-content">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="border-top-0">Name</th>
                                                    <th class="border-top-0">Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($debtors as $debts) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $debts->account_name; ?></td>
                                                        <td class="text-truncate"><?php echo $debts->debits - $debts->credits; ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12">
                        <div class="card recent-loan">
                            <div class="card-header">
                                <h4 class="text-center">Live Currency Exchange</h4>
                                <h6 class="text-center">Base Currency <span id="basec" style="font-weight: bold;"></span></h6>
                                <h6 class="text-center" id="basedate"></h6>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover" id="liveCurrency">
                                            <thead>
                                                <tr>
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
                    </div>
                </div>
            </section>
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
        getRates(mainCurrency);
        setInterval(() => {
            getRates(mainCurrency);
        }, 60000);

    });

    const getRates = (mainC) => {
        // get live exchange rates
        API = "Qh8dI7n50xvgHOCxWYCFP1Oi8aWZlbkf";
        $.ajax({
            url: "https://api.apilayer.com/exchangerates_data/latest?base=" + mainC,
            method: "GET",
            headers: {
                apikey: API
            },
            success: function(data) {
                liveCurrencyTable.clear();
                $("#basec").text(mainC);
                $("#basedate").text(data.date);
                rates = data.rates;
                for (const [key, value] of Object.entries(rates)) {
                    liveCurrencyTable.row.add([key, value]).draw(false);
                }
            }
        })
    }
</script>