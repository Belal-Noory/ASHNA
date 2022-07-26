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

// Get all pending Transactions
$all_pending_documents = $document->getAllPendingDocuments($user_data->company_id);
$pending_documents = $all_pending_documents->fetchAll(PDO::FETCH_OBJ);

$all_active_documents = $document->getAllActiveDocuments($user_data->company_id);
$active_documents = $all_active_documents->fetchAll(PDO::FETCH_OBJ);
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
                            <a 
                            class="nav-link active waves-effect waves-dark" 
                            id="activeTab" 
                            data-toggle="tab" 
                            href="#activePanel" aria-controls="activePanel" aria-expanded="true">Approved</a>
                        </li>
                        <li class="nav-item">
                            <a 
                            class="nav-link waves-effect waves-dark" 
                            id="pendingTab" 
                            data-toggle="tab" 
                            href="#pendingPanel" aria-controls="pendingPanel" aria-expanded="true">Pending</a>
                        </li>
                    </ul>
                    <div class="tab-content px-1 pt-1">
                        <div role="tabpanel" class="tab-pane active" id="activePanel" aria-labelledby="activeTab" aria-expanded="true">
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
                                                        <th>LID</th>
                                                        <th>Date</th>
                                                        <th>Descrption</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $counter = 1;
                                                    foreach ($active_documents as $active) { ?>
                                                        <tr>
                                                            <td><?php echo $counter; ?></td>
                                                            <td><?php echo $active->leadger_id; ?></td>
                                                            <td><?php echo Date("m/d/Y", $active->reg_date); ?></td>
                                                            <td><?php echo $active->remarks ?></td>
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

                        <div role="tabpanel" class="tab-pane" id="pendingPanel" aria-labelledby="pendingTab" aria-expanded="true">
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
                                                        <th>LID</th>
                                                        <th>Date</th>
                                                        <th>Descrption</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php $counter = 1;
                                                    foreach ($pending_documents as $pending) { ?>
                                                        <tr>
                                                            <td><?php echo $counter; ?></td>
                                                            <td><?php echo $pending->leadger_id; ?></td>
                                                            <td><?php echo Date("m/d/Y", $pending->reg_date); ?></td>
                                                            <td><?php echo $pending->remarks ?></td>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include("./master/footer.php");
?>

<script>
    $(document).ready(function() {
        var t = $("#AccountsTable").DataTable();
    });
</script>