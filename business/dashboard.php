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

$saifs = $banks->getSaifs($user_data->company_id);
$saifs_data = $saifs->fetchAll(PDO::FETCH_OBJ);

$bank = $banks->getBanks($user_data->company_id);
$bank_data = $bank->fetchAll(PDO::FETCH_OBJ);

$staff = $bussiness->getCompanyStaff($user_data->company_id);
$staff_data = $staff->fetchAll(PDO::FETCH_OBJ);
?>

<style>
    .newNav {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        width: 11%;
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

    .newnavhover:hover {
        transition: all .5s ease-in-out;
        rotate: 360deg;
    }

    .text-hover:hover {
        transform: scale(1.08);
    }

    .content-header {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        row-gap: 5px;
        column-gap: 2px;
        align-items: center;
        justify-content: space-between;
    }
</style>

<!-- END: Main Menu-->
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header mb-1">
            <!-- navigation Section -->
            <div class="btn btn-sm btn-blue newNav p-0">
                <i class="las la-users fa-3x"></i>
                <a href="./ContactList.php" class="text-white text-hover">Contacts</a>
                <a href="./NewContact.php" class="text-white"><span class="las la-plus fa-2x newnavhover"></span></a>
            </div>
            <div class=" btn btn-sm btn-blue newNav p-0">
                <i class="las la-coins fa-3x"></i>
                <a href="./Receipts.php" class="text-white text-hover">Receipts</a>
                <a href="./NewReceipt.php" class="text-white"><span class="las la-plus fa-2x newnavhover"></span></a>
            </div>
            <div class=" btn btn-sm btn-blue newNav p-0">
                <i class="las la-wallet fa-3x"></i>
                <a href="./Payments.php" class="text-white text-hover">Payments</a>
                <a href="./NewPayment.php" class="text-white"><span class="las la-plus fa-2x newnavhover"></span></a>
            </div>
            <div class=" btn btn-sm btn-blue newNav p-0">
                <i class="las la-credit-card fa-3x"></i>
                <a href="./Revenues.php" class="text-white text-hover">Revenue</a>
                <a href="./NewRevenue.php" class="text-white"><span class="las la-plus fa-2x newnavhover"></span></a>
            </div>
            <div class=" btn btn-sm btn-blue newNav p-0">
                <i class="las la-credit-card fa-3x"></i>
                <a href="./expenses.php" class="text-white text-hover">Expens</a>
                <a href="./NewExpense.php" class="text-white"><span class="las la-plus fa-2x newnavhover"></span></a>
            </div>
            <div class=" btn btn-sm btn-blue newNav p-0">
                <i class="las la-arrow-right fa-3x"></i>
                <a href="./OutTransferences.php" class="text-white text-hover">OUT-T</a>
                <a href="./NewOutTransference.php" class="text-white"><span class="las la-plus fa-2x newnavhover"></span></a>
            </div>
            <div class=" btn btn-sm btn-blue newNav p-0">
                <i class="las la-arrow-left fa-3x"></i>
                <a href="./InTransferences.php" class="text-white text-hover">IN-T</a>
                <a href="./NewInTransference.php" class="text-white"><span class="las la-plus fa-2x newnavhover"></span></a>
            </div>
            <div class=" btn btn-sm btn-blue newNav p-0">
                <i class="las la-chart-pie fa-3x"></i>
                <a href="./AllReports.php" class="text-white text-hover">Reports</a>
                <a href="./AllReports.php" class="text-white text-hover"><span class="las la-eye fa-2x newnavhover"></span></a>
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

                    <!-- <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6" style="cursor: pointer;" id="btndailyTran">
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
                    </div> -->
                </div>
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                        <div class="card recent-loan">
                            <div class="card-header">
                                <h4 class="text-center">Trasury Status</h4>
                            </div>
                            <div class="card-content">
                                <?php
                                if (count($saifs_data) > 0) {
                                    $counter = 1;
                                    foreach ($saifs_data as $saif) {
                                        $amount_data = $banks->getAccountMoneyByID($saif->chartofaccount_id);
                                        $amounts = $amount_data->fetch(PDO::FETCH_OBJ);
                                ?>
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <span class="float-left"><?php echo $counter ?></span>
                                                <span class="ml-2"><?php echo $saif->account_name ?></span>
                                                <span class="float-right"><?php echo $amounts->Debet - $amounts->Credit . " " . $saif->currency ?></span>
                                            </li>
                                        </ul>
                                <?php $counter++;
                                    }
                                } else {
                                    echo "<h6 class='text-gray text-center'>No treasury added yet!</h6>";
                                } ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                        <div class="card recent-loan">
                            <div class="card-header">
                                <h4 class="text-center">Bank Status</h4>
                            </div>
                            <div class="card-content">
                                <?php
                                if (count($bank_data) > 0) {
                                    foreach ($bank_data as $b) {
                                        $amount_data = $banks->getAccountMoneyWithRate($b->chartofaccount_id);
                                        $amounts = $amount_data->fetchAll(PDO::FETCH_OBJ);
                                        $debit = 0;
                                        $credit = 0;
                                        foreach ($amounts as $amount) {
                                            if ($amount->ammount_type == "Debet") {
                                                $debit += $amount->amount;
                                            } else {
                                                $credit += $amount->amount;
                                            }
                                        }
                                ?>
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <span class="float-left"><?php echo $counter ?></span>
                                                <span class="ml-2"><?php echo $b->account_name ?></span>
                                                <span class="float-right"><?php echo $debit - $credit . " " . $b->currency ?></span>
                                            </li>
                                        </ul>
                                <?php $counter++;
                                    }
                                } else {
                                    echo "<h6 class='text-gray text-center'>No treasury added yet!</h6>";
                                } ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Organizational Structure of the company</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body p-0">
                                    <div class="media-list list-group">
                                        <div class="row">
                                            <?php
                                            if (count($staff_data) > 0) {
                                                foreach ($staff_data as $staff) {
                                                    $customer_image = $bussiness->getStaffProfileImage($staff->customer_id);
                                                    $profile = $customer_image->fetch(PDO::FETCH_OBJ);
                                            ?>
                                                    <div class="list-group-item list-group-item-action media col-lg-6" style="border: none;outline: none;">
                                                        <span class="media-left">
                                                            <?php
                                                            if (isset($profile->attachment_name) > 0) {
                                                                echo "<img class='media-object rounded-circle' src='uploadedfiles/customerattachment/$profile->attachment_name' width='48' height='48' alt='image'>";
                                                            } else {
                                                                echo "<img class='media-object rounded-circle' src='app-assets/images/avatar.jpg' width='48' height='48' alt='image'>";
                                                            }
                                                            ?>
                                                        </span>
                                                        <span class="media-body">
                                                            <span style="border-bottom: 2px solid gray;"><?php echo $staff->fname . " " . $staff->lname ?></span>
                                                            <br>
                                                            <span class="grey"><?php echo $staff->job ?></span>
                                                        </span>
                                                    </div>
                                            <?php }
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
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
                                        <th class="border-top-0">Code</th>
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
                                            $leadger = $at->leadger_ID;
                                            if ($at->op_type == "transferin" || $at->op_type == "transferout") {
                                                $transfer_details = $transfer->TransferByLeadgerID($at->leadger_ID, $user_data->company_id);
                                                $transfer_data = $transfer_details->fetch(PDO::FETCH_OBJ);
                                                if ($transfer_details->rowCount() > 0) {
                                                    $TID = explode("-", $transfer_data->transfer_code);
                                                    $leadger = $at->leadger_ID . " || " . $TID[1];
                                                }
                                            }

                                            echo "<tr data-href='$tdate'>
                                                        <td>$leadger</td>
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