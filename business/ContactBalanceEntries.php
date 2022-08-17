<?php
$Active_nav_name = array("parent" => "Accounting", "child" => "Contact Balance Entries");
$page_title = "Contact Balance Entries";
include("./master/header.php");

$company = new Company();
$banks = new Banks();
$bussiness = new Bussiness();

$allcurrency_data = $company->GetCompanyCurrency($user_data->company_id);
$allcurrency = $allcurrency_data->fetchAll(PDO::FETCH_OBJ);

// Get all Customers of this company
$allCustomers_data = $bussiness->getCompanyUniqueCustomers($user_data->company_id, $user_data->user_id);
$allCustomers = $allCustomers_data->fetchAll(PDO::FETCH_OBJ);
?>

<div class="container pt-5">
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
                                <th>Name</th>
                                <th>Debet</th>
                                <th>Crediet</th>
                                <th>Transactions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $counter = 1;
                            foreach ($allCustomers as $customer) {
                                $res = $banks->getDebets_Credits($customer->chartofaccount_id);
                                $debets = 0;
                                $credits = 0;
                                $charAccID = 0;
                                $data = json_decode($res);
                                foreach ($data as $da) {
                                    if ($da->chartofaccount_id === $da->account_id) {
                                        $debets = $da->debits;
                                        $credits = $da->credits;
                                    }
                                } ?>
                                <tr>
                                    <td><?php echo $customer->fname . ' ' . $customer->lname; ?></td>
                                    <td><?php echo $debets ?></td>
                                    <td><?php echo $credits; ?></td>
                                    <td><a href='#' data-href='<?php echo $customer->chartofaccount_id; ?>' class='btn btn-blue showreceiptdetails'><span class='las la-table'></span></a></td>
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
                                <th>Leadger</th>
                                <th>Debet</th>
                                <th>Credit</th>
                                <th>Clear</th>
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
            var customerID = $(this).attr("data-href");
            $.get("../app/Controllers/banks.php", {
                "getLeadgerDebetsCredits": true,
                "cusid": customerID
            }, function(data) {
                $("#show").modal("show");
                t.clear();
                ndata = $.parseJSON(data);
                console.log(ndata);
                PLID = 0;
                ndata.forEach(element => {
                    if (element.chartofaccount_id === element.account_id && element.leadger_ID !== PLID) {
                        debit = 0;
                        credit = 0;
                        if (element.ammount_type === "Debet") {
                            debit = element.amount;
                        } else {
                            credit = element.amount;
                        }
                        t.row.add([element.leadger_ID, debit, credit, "<a class='btn btn-blue btnClearLeadger' data-href='" + element.leadger + "'><span class='las la-thumbs-up white'></span></a>"]).draw(false);;
                    }
                    PLID = element.leadger_ID;
                });
            });
            $(".container-waiting").addClass("d-none");
            $(".container-done").removeClass("d-none");
        });

        // clear leadger
        $(document).on("click", ".btnClearLeadger", function() {
            LID = $(this).attr("data-href");
            ths = $(this);
            $(ths).parent().parent().fadeOut();

            $.post("../app/Controllers/banks.php", {
                "clearLeadger": true,
                "LID": LID
            }, function(data) {
                $(ths).parent().parent().fadeOut();
            });
        });

    });
</script>