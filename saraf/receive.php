<?php
$menue = array(
    array("name" => "ارسال ها", "url" => "send.php", "icon" => "la-send", "active" => ""),
    array("name" => "دریافت ها", "url" => "receive.php", "icon" => "la-arrow-left", "active" => "active"),
);
$page_title = "دریافت ها";
include("./master/header.php");

$company = new Company();
$saraf = new Saraf();

$pending_transfers_data = $saraf->getPendingInTransfer($loged_user->customer_id);
$pending_transfers = $pending_transfers_data->fetchAll(PDO::FETCH_OBJ);

$paid_transfers_data = $saraf->getPaidInTransfer($loged_user->customer_id);
$paid_transfers = $paid_transfers_data->fetchAll(PDO::FETCH_OBJ);
?>
<!-- END: Main Menu-->
<!-- BEGIN: Content-->
<div class="container pt-2">
    <!-- transfers list -->
    <section id="justified-bottom-border">
        <div class="row match-height">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-underline no-hover-bg nav-justified">
                                <li class="nav-item">
                                    <a class="nav-link active" id="active-tab32" data-toggle="tab" href="#active32" aria-controls="active32" aria-expanded="true">پرداخت شده</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="link-tab32" data-toggle="tab" href="#link32" aria-controls="link32" aria-expanded="false">پرداخت نشده</a>
                                </li>
                            </ul>
                            <div class="tab-content px-1 pt-1">
                                <div role="tabpanel" class="tab-pane active" id="active32" aria-labelledby="active-tab32" aria-expanded="true">
                                    <section id="configuration">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <div class="heading-elements">
                                                            <ul class="list-inline mb-0">
                                                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="card-content collapse show">
                                                        <div class="card-body card-dashboard">
                                                            <div class="table-responsive">
                                                                <table class="table table-striped table-bordered zero-configuration" id="tb1">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>تاریخ</th>
                                                                            <th>توضیحات</th>
                                                                            <th>صراف</th>
                                                                            <th>مقدار پول</th>
                                                                            <th>نمبر حواله</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        foreach ($paid_transfers as $ptransfer) {
                                                                            $to_data = $company->getCompanyByID($ptransfer->company_id);
                                                                            $to = $to_data->fetch(PDO::FETCH_OBJ);

                                                                            $dat = date("m/d/Y", $ptransfer->reg_date);
                                                                            echo "<tr class='mainrow'>
                                                                            <td>$dat</td>
                                                                            <td class='tRow' data-href='$ptransfer->leadger_id'>$ptransfer->details</td>
                                                                            <td>$to->company_name</td>
                                                                            <td>$ptransfer->amount-$ptransfer->currency</td>
                                                                            <td>$ptransfer->transfer_code</td>
                                                                        </tr>";
                                                                        }
                                                                        ?>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <div class="tab-pane" id="link32" role="tabpanel" aria-labelledby="link-tab32" aria-expanded="false">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <div class="heading-elements">
                                                        <ul class="list-inline mb-0">
                                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="card-content collapse show">
                                                    <div class="card-body card-dashboard">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-bordered zero-configuration">
                                                                <thead>
                                                                    <tr>
                                                                        <th>تاریخ</th>
                                                                        <th>توضیحات</th>
                                                                        <th>از طرف</th>
                                                                        <th>مقدار پول</th>
                                                                        <th>نمبر حواله</th>
                                                                        <th>تایید</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    foreach ($pending_transfers as $ptransfer) {
                                                                        $to_data = $company->getCompanyByID($ptransfer->company_id);
                                                                        $to = $to_data->fetch(PDO::FETCH_OBJ);
                                                                        $dat = date("m/d/Y", $ptransfer->reg_date);
                                                                        echo "<tr class='mainrow'>
                                                                            <td>$dat</td>
                                                                            <td class='tRow' data-href='$ptransfer->leadger_id'>$ptransfer->details</td>
                                                                            <td>$to->company_name</td>
                                                                            <td>$ptransfer->amount-$ptransfer->currency</td>
                                                                            <td>$ptransfer->transfer_code</td>
                                                                            <td><a class='btn btn-blue btnapprovebysaraf' data-href='$ptransfer->company_money_transfer_id' href='#'><span class='las la-thumbs-up'></span></a></td>
                                                                        </tr>";
                                                                    }
                                                                    ?>
                                                            </table>
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
            </div>
        </div>
    </section>
</div>
<!-- END: Content-->
<?php include("./master/footer.php") ?>

<script>
    $(document).ready(function() {
        t = $("#tb1").DataTable();

        // approve pending transaction
        $(document).on("click", ".btnapprovebysaraf", function(e) {
            e.preventDefault();
            TID = $(this).attr("data-href");
            ths = $(this);

            $.post("../app/Controllers/Saraf.php", {
                "approve": true,
                "TID": TID
            }, function(data) {
                $(ths).parent().parent().fadeOut();
                t.row.add([$(ths).parent().parent().children("td:nth-child(1)").text(), $(ths).parent().parent().children("td:nth-child(2)").text(), $(ths).parent().parent().children("td:nth-child(3)").text(), $(ths).parent().parent().children("td:nth-child(4)").text(), $(ths).parent().parent().children("td:nth-child(5)").text()]).draw(false);
            });
        });
    });
</script>