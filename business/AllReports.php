<?php
$Active_nav_name = array("parent" => "Reports", "child" => "All Reports");
$page_title = "Reports";
include("./master/header.php");
// Logged in user info 
$report = new Reports();
$allCatagories_data = $report->getReportsCatagory($user_data->company_id);
$allCatagories = $allCatagories_data->fetchAll(PDO::FETCH_OBJ);

?>
<style>
    .showreceiptdetails {
        cursor: pointer;
    }
</style>
<div class="col-lg-12 mt-2">
    <div class="card" style="">
        <div class="card-header">
            <h4 class="card-title">All Reports</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <p>Get Reports based on the main catagories and sub catagories.</p>
                <ul class="nav nav-tabs nav-underline no-hover-bg nav-tabs-material">
                    <?php 
                        $index = 0;
                        $Prev_account_kind = array();
                        foreach ($allCatagories as $account) { 
                            if(!in_array($account->account_kind,$Prev_account_kind)){ ?>
                            <li class="nav-item">
                                <a class="nav-link waves-effect waves-dark <?php if($index == 0){echo "active";} ?>" id="<?php echo str_replace(' ', '', $account->account_kind) . "-tab"; ?>" data-toggle="tab" href="#<?php echo str_replace(' ', '', $account->account_kind) . "-panel"; ?>" aria-controls="link32" aria-expanded="<?php if($index == 0){echo "true";}else{echo "false";} ?>"><?php echo $account->account_kind; ?></a>
                            </li>
                        <?php }
                            array_push($Prev_account_kind,$account->account_kind);
                            $index++;}  ?>
                </ul>
                <div class="tab-content px-1 pt-1">
                    <?php
                        $index = 0;
                        $Prev_account_kind = array();
                        foreach ($allCatagories as $account) { 
                            if(!in_array($account->account_kind,$Prev_account_kind)){?>
                            <div class="tab-pane <?php if($index == 0){echo "active";} ?>" id="<?php echo str_replace(' ', '', $account->account_kind) . "-panel"; ?>" role="tabpanel" aria-labelledby="<?php echo str_replace(' ', '', $account->account_kind) . "-tab"; ?>" aria-expanded="<?php if($index == 0){echo "true";}else{echo "false";} ?>">
                                <?php
                                $all_data = $report->getReportsBasedOnTransaction($user_data->company_id, $account->chartofaccount_id);
                                $all_details = $all_data->fetchAll(PDO::FETCH_OBJ);
                                ?>
                                <section id="material-datatables">
                                    <div class="card">
                                        <div class="card-header">
                                            <a class="heading-elements-toggle">
                                                <i class="la la-ellipsis-v font-medium-3"></i>
                                            </a>
                                            <div class="heading-elements">
                                                <ul class="list-inline mb-0">
                                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-content">
                                            <div class="card-body">
                                                <table class="table material-table" id="customersTable">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Date</th>
                                                            <th>Description</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $counter = 1;
                                                        foreach ($all_details as $transactions) { ?>
                                                            <tr>
                                                                <td><?php echo $counter; ?></td>
                                                                <td data-href="<?php echo $transactions->leadger_id; ?>" class="showreceiptdetails"><?php echo Date("m/d/Y", $transactions->reg_date); ?></td>
                                                                <td data-href="<?php echo $transactions->leadger_id; ?>" class="showreceiptdetails"><?php echo $transactions->remarks; ?></td>
                                                                <td data-href="<?php echo $transactions->leadger_id; ?>" class="showreceiptdetails"><?php echo $transactions->currency . " " . $transactions->amount; ?></td>
                                                            </tr>
                                                        <?php $counter++;
                                                        } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        <?php }
                            array_push($Prev_account_kind,$account->account_kind);$index++;} ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade text-center" id="show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true">
    <div class="modal-dialog" role="document">
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
                    <table class="table material-table" id="AccountsTable">
                        <thead>
                            <tr>
                                <th>Account</th>
                                <th>Debet</th>
                                <th>Credit</th>
                            </tr>
                        </thead>
                        <tbody id="modelTable">

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
        var t = $("#AccountsTable").DataTable();

        $(document).on("click", ".showreceiptdetails", function(e) {
            $("#show").modal("show");
            t.clear();
            var leadger_id = $(this).attr("data-href");
            $.get("../app/Controllers/banks.php", {
                "getLeadgerAccounts": true,
                "leadgerID": leadger_id
            }, function(data) {
                ndata = $.parseJSON(data);
                ndata.forEach(element => {
                    if (element.ammount_type == "Crediet") {
                        t.row.add([element.account_name, 0, element.amount]).draw(false);;

                    } else {
                        t.row.add([element.account_name, element.amount, 0]).draw(false);;
                    }
                });
            });
            $(".container-waiting").addClass("d-none");
            $(".container-done").removeClass("d-none");
        });

    });
</script>