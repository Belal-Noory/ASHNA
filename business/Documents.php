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
                            <a class="nav-link active waves-effect waves-dark" id="activeTab" data-toggle="tab" href="#activePanel" aria-controls="activePanel" aria-expanded="true">Approved</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link waves-effect waves-dark" id="pendingTab" data-toggle="tab" href="#pendingPanel" aria-controls="pendingPanel" aria-expanded="true">Pending</a>
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
                                            <table class="table material-table" id="approveTable">
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
                                                            <td><?php echo $active->amount ?></td>
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
                                            <table class="table material-table" id="pendingTable">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>LID</th>
                                                        <th>Date</th>
                                                        <th>Descrption</th>
                                                        <th>Amount</th>
                                                        <th>Approve</th>
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
                                                            <td><?php echo $pending->amount ?></td>
                                                            <td><span data-href="<?php echo $pending->leadger_id ?>" class="las la-thumbs-up text-primary btnapprovedocument" style="font-size:3rem;cursor:pointer"></span></td>
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

<!-- Add Reminder Modal -->
<div class="modal fade text-center" id="model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content p-5">
            <div class="card-body table-responsive">
                <table class="table material-table" id="detailsTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>LID</th>
                            <th>Account</th>
                            <th>Currency</th>
                            <th>Details</th>
                            <th>Financial Term</th>
                            <th>date</th>
                            <th>Created By</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <button class="btn btn-lg btn-primary" id="btnapprove">تایید</button>
            </div>
        </div>
    </div>
</div>

<?php
include("./master/footer.php");
?>

<script>
    $(document).ready(function() {
        var pendingTable = $("#pendingTable").DataTable();
        var approveTable = $("#approveTable").DataTable();
        var detailsTable = $("#detailsTable").DataTable();

        selected_data = [];
        selected_row = null;

        $(document).on("click", ".btnapprovedocument", function() {
            ths = $(this);
            selected_row = ths;
            LID = $(this).attr("data-href");
            date = $(this).parent().parent().children("td:nth-child(3)").text();
            remark = $(this).parent().parent().children("td:nth-child(4)").text();
            amount = $(this).parent().parent().children("td:nth-child(5)").text();

            selected_data["lid"] = LID;
            selected_data["date"] = date;
            selected_data["remark"] = remark;
            selected_data["amount"] = amount;

            // send request to the to get document details
            $.get("../app/Controllers/Document.php", {
                "DLID": LID
            }, function(data) {
                ndata = $.parseJSON(data);
                detailsTable.row.add([1,ndata.leadger_id,ndata.account_name,ndata.currency, selected_data["remark"],ndata.company_financial_term_id,selected_data["date"],ndata.fname+" "+ndata.lname]).draw(false);
            });

            $("#model").modal("show");
        });

        // final approval
        $("#btnapprove").on("click", function() {
            $.confirm({
                icon: 'fa fa-smile-o',
                theme: 'modern',
                closeIcon: true,
                animation: 'scale',
                type: 'blue',
                title: 'مطمین هستید؟',
                content: '',
                buttons: {
                    confirm: {
                        text: 'بلی',
                        action: function() {
                            counter = 0;
                            if (approveTable.rows().count() > 0) {
                                app_table_last = approveTable.row(":last").data();
                                counter = app_table_last[0];
                                counter++;
                            }
                            // send request to the server to approve now
                            $.post("../app/Controllers/Document.php", {
                                "ALID": LID
                            }, function(data) {
                                approveTable.row.add([counter, selected_data["lid"], selected_data["date"], selected_data["remark"], selected_data["amount"]]).draw(false);
                                $(selected_row).parent().parent().fadeOut();
                                $("#model").modal("hide");
                            });
                        }
                    },
                    cancel: {
                        text: 'نخیر',
                        action: function() {}
                    }
                }
            });


        });
    });
</script>