<?php
$Active_nav_name = array("parent" => "Banking", "child" => "Transfer List");
$page_title = "Transfers";
include("./master/header.php");

// Logged in user info
$user_data = json_decode($_SESSION["bussiness_user"]);

// Objects
$bank = new Banks();
$company = new Company();

$allTransfersLeadger_Data = $bank->getTransfersLeadger($user_data->company_id);
$allTransfersLeadger = $allTransfersLeadger_Data->fetchAll(PDO::FETCH_OBJ);
?>

<!-- BEGIN: Content-->
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
                            <table class="table material-table" id="customersTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Description</th>
                                        <th>From</th>
                                        <th>Amount</th>
                                        <th>To</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $counter = 1;
                                    foreach ($allTransfersLeadger as $allTransferLeadger) {
                                        $money_data = $bank->getTransfersMoney($user_data->company_id, $allTransferLeadger->leadger_id);
                                        $money_details = $money_data->fetchAll(PDO::FETCH_OBJ);
                                        $crediet_amount = 0;
                                        foreach ($money_details as $MD) {
                                            if ($MD->ammount_type == "Crediet") {
                                                $crediet_amount = $MD->amount;
                                            }
                                            if ($MD->ammount_type == "Debet") {
                                    ?>
                                                <tr>
                                                    <td><?php echo $counter; ?></td>
                                                    <td><?php echo date("m/d/Y", $allTransferLeadger->reg_date); ?></td>
                                                    <td><?php echo $allTransferLeadger->remarks; ?></td>
                                                    <td><?php
                                                        $bank_details_data = $bank->getBank_Saif($allTransferLeadger->payable_id);
                                                        $bank_details = $bank_details_data->fetch();
                                                        echo $bank_details["account_name"];
                                                        ?></td>
                                                    <td><?php echo $crediet_amount; ?></td>
                                                    <td><?php
                                                        $bank_details_data = $bank->getBank_Saif($allTransferLeadger->recievable_id);
                                                        $bank_details = $bank_details_data->fetch();
                                                        echo $bank_details["account_name"];
                                                        ?></td>
                                                    <td><?php echo $MD->amount; ?></td>
                                                </tr>
                                    <?php }
                                        }
                                        $counter++;
                                    }  ?>
                                </tbody>
                            </table>
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