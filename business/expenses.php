<?php
$Active_nav_name = array("parent" => "Payment & Expense", "child" => "Expense List");
$page_title = "Revenues";
include("./master/header.php");
$expense = new Expense();
$all_receipt_data = $expense->getExpenseLeadger($user_data->company_id);
$all_receipt = $all_receipt_data->fetchAll(PDO::FETCH_OBJ);
?>

<style>
    .showreceiptdetails {
        cursor: pointer;
    }

    .showreceiptdetails:hover {
        background-color: lightgray;
    }
</style>
<!-- END: Main Menu-->
<!-- BEGIN: Content-->
<div class="container pt-5">
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
                    <table class="table material-table" id="customersTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Description</th>
                                <th>amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $counter = 1;
                            foreach ($all_receipt as $receipt) { ?>
                                <tr data-href="<?php echo $receipt->leadger_id; ?>" class="showreceiptdetails">
                                    <td><?php echo $counter; ?></td>
                                    <td><?php echo Date("m/d/Y", $receipt->reg_date); ?></td>
                                    <td><?php echo $receipt->remarks; ?></td>
                                    <td><?php echo $receipt->currency . " " . $receipt->amount; ?></td>
                                </tr>
                            <?php $counter++;
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!-- Material Data Tables -->
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
<!-- END: Content-->



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