<?php
$Active_nav_name = array("parent" => "Accounting", "child" => "Documents List");
$page_title = "Documents";
include("./master/header.php");

$company = new Company();
$document = new Document();

$allcurrency_data = $company->GetCompanyCurrency($user_data->company_id);
$allcurrency = $allcurrency_data->fetchAll(PDO::FETCH_OBJ);

// All Account types
$All_Accounts_data = $document->getAccountTypes($user_data->company_id);
$All_Accounts = $All_Accounts_data->fetchAll(PDO::FETCH_OBJ);

// Get all Transactions
$all_transactions_data = $document->getAllDocuments($user_data->company_id);
$all_transactions = $all_transactions_data->fetchAll(PDO::FETCH_OBJ);
?>

<style>
    .showreceiptdetails {
        cursor: pointer;
    }
</style>

<section class="p-2">
    <div class="col-xl-12">
        <div class="card" style="">
            <div class="card-header">
                <h4 class="card-title">Document List</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <ul class="nav nav-tabs nav-underline no-hover-bg nav-justified">
                        <li class="nav-item">
                            <a class="nav-link active waves-effect waves-dark" id="active-tab32" data-toggle="tab" href="#active32" aria-controls="active32" aria-expanded="true">All</a>
                        </li>
                        <?php
                        foreach ($All_Accounts as $account) { ?>
                            <li class="nav-item">
                                <a class="nav-link waves-effect waves-dark" id="<?php echo str_replace(' ', '', $account->op_type) . "-tab"; ?>" data-toggle="tab" href="#<?php echo str_replace(' ', '', $account->op_type) . "-panel"; ?>" aria-controls="link32" aria-expanded="false"><?php echo $account->op_type; ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                    <div class="tab-content px-1 pt-1">
                        <div role="tabpanel" class="tab-pane active" id="active32" aria-labelledby="active-tab32" aria-expanded="true">
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
                                        <div class="card-body table-responsive">
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
                                                    foreach ($all_transactions as $transactions) { ?>
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
                        <?php
                        foreach ($All_Accounts as $account) { ?>
                            <div class="tab-pane" id="<?php echo str_replace(' ', '', $account->op_type) . "-panel"; ?>" role="tabpanel" aria-labelledby="<?php echo str_replace(' ', '', $account->op_type) . "-tab"; ?>" aria-expanded="false">
                                <?php
                                $all_data = $document->getDocumentBasedOnTransaction($user_data->company_id, $account->op_type);
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
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


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