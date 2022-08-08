<?php
$Active_nav_name = array("parent" => "Accounting", "child" => "Pending Transaction");
$page_title = "Pending Transactions";
include("./master/header.php");
$receipt = new Receipt();
$company = new Company();
$bank = new Banks();

$company_FT_data = $company->getCompanyActiveFT($user_data->company_id);
$company_ft = $company_FT_data->fetch(PDO::FETCH_OBJ);

$company_curreny_data = $company->GetCompanyCurrency($user_data->company_id);
$company_curreny = $company_curreny_data->fetchAll(PDO::FETCH_OBJ);
$mainCurrency = "";
foreach ($company_curreny as $currency) {
    if ($currency->mainCurrency) {
        $mainCurrency = $currency->currency;
    }
}

// get pending Transactions
$Ptransactions_data = $admin->getPendingTransactions($user_data->company_id, $term_id);
$Ptransactions = $Ptransactions_data->fetchAll(PDO::FETCH_OBJ);
?>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
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
                            <div class="table-responsive">
                                <table class="table" id="ptable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>TID</th>
                                            <th>Leadger</th>
                                            <th>Date</th>
                                            <th>Details</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $counter = 0;
                                        $prevLID = "";
                                        foreach ($Ptransactions as $PT) {
                                            if($PT->leadger_id !== $prevLID){?>
                                            <tr>
                                                <td><?php echo $counter?></td>
                                                <td><?php echo $PT->account_money_id; ?></td>
                                                <td><?php echo $PT->leadger_id ?></td>
                                                <td><?php echo $dat = date("m/d/Y", $PT->reg_date);?></td>
                                                <td><?php echo $PT->remarks ?></td>
                                                <td>
                                                    <button class="btn btn-sm btn-blue btnshowpendingtransactionmodel" data-href="<?php echo $PT->leadger_id ?>">
                                                        <i class="la la-eye"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        
                                       <?php 
                                        $counter++;}
                                        $prevLID = $PT->leadger_id;}?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>


<!-- Modal Single Pending Transaction -->
<div class="modal fade text-center" id="pendingTransctionsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-body p-4">
                <div class="table-responsive">
                    <table class="table" id="TablePending">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>TID</th>
                                <th>Leadger</th>
                                <th>Date</th>
                                <th>Details</th>
                                <th>Account</th>
                                <th>Amount</th>
                                <th>T-Type</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-blue" id="pendingapprove">Approve</button>
            </div>
        </div>
    </div>
</div>
<?php
include("./master/footer.php");
?>

<script>
        // show single transaction
        let parentTable = $("#ptable").DataTable();
        let pendingTable = $("#TablePending").DataTable();
        lastNoti = null;
        $(document).on("click", ".btnshowpendingtransactionmodel", function(e) {
            e.preventDefault();
            pendingTable.clear().draw();
            LID = $(this).attr("data-href");
            lastNoti = $(this).parent().parent();
            $("#pendingapprove").attr("data-href", LID);
            $.get("../app/Controllers/SystemAdmin.php", {
                pendingT: true,
                LID: LID
            }, function(data) {
                if (data) {
                    ndata = $.parseJSON(data);
                    counter = 1;
                    ndata.forEach(element => {
                        // date
                        date = new Date(element.reg_date * 1000);
                        newdate = date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate();
                        pendingTable.row.add([counter, element.account_money_id, element.leadger_id, newdate, element.detials, element.account_name ,element.amount, element.ammount_type]).draw(false);
                        counter++;
                    });
                    $("#pendingTransctionsModal").modal("show");
                }
            });
        });

        // approve transactions
        $("#pendingapprove").on("click", function(e) {
            e.preventDefault();
            LID = $(this).attr("data-href");
            ths = $(this);
            $.post("../app/Controllers/SystemAdmin.php", {
                apporveTransactions: true,
                LID: LID
            }, function(data) {
                pendingTable.clear().draw();
                $("#pendingTransctionsModal").modal("hide");
                $(lastNoti).parent().parent().fadeOut();
            });
        });
</script>