<?php
$Active_nav_name = array("parent" => "Dashboard", "child" => "");
$page_title = "Dashboard";
include("./master/header.php");
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
                        <div class="card">
                            <div class="card-content">
                                <div class="card card-shadow">
                                    <div class="card-header card-header-transparent">
                                        <h4 class="card-title">Transaction Reports</h4>
                                        <ul class="nav nav-pills nav-pills-rounded chart-action float-right btn-group" role="group">
                                            <li class="nav-item">
                                                <a class="active nav-link" data-toggle="tab" href="#scoreLineToDay">Day</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#scoreLineToWeek">Week</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#scoreLineToMonth">Month</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="widget-content tab-content bg-white p-20">
                                        <div class="ct-chart tab-pane active scoreLineShadow" id="scoreLineToDay"></div>
                                        <div class="ct-chart tab-pane scoreLineShadow" id="scoreLineToWeek"></div>
                                        <div class="ct-chart tab-pane scoreLineShadow" id="scoreLineToMonth"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12">
                        <div class="card recent-loan">
                            <div class="card-header">
                                <h4 class="text-center">Loan Applications</h4>
                            </div>
                            <div class="card-content">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="border-top-0">Customer</th>
                                                <th class="border-top-0">Amount</th>
                                                <th class="border-top-0">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    Ahmad
                                                </td>
                                                <td class="text-truncate">
                                                    <i class="ft-arrow-down-left success"></i> $20000
                                                    <div class="font-small-2 text-light"><i class="font-small-2 ft-map-pin"></i> S.G.road,UK</div>
                                                </td>
                                                <td class="text-truncate">4:59p.m</td>
                                            </tr>
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
<!-- END: Content-->
<?php
include("./master/footer.php");
?>