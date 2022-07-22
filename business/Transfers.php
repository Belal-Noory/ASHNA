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
                                        <th>TID</th>
                                        <th>LID</th>
                                        <th>Date</th>
                                        <th>Detail</th>
                                        <th>Account</th>
                                        <th>Amount</th>
                                        <th>Transfered</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $counter = 1;
                                    foreach ($allTransfersLeadger as $allTransferLeadger) {
                                        $account_info_Array = explode("-",$allTransferLeadger->detials);
                                        $account = $account_info_Array[1];
                                        $account_details = json_decode($bank->getchartofaccountDetails($account));

                                    ?>
                                                <tr>
                                                    <td><?php echo $counter; ?></td>
                                                    <td><?php echo $allTransferLeadger->account_money_id; ?></td>
                                                    <td><?php echo $allTransferLeadger->leadger_ID; ?></td>
                                                    <td><?php echo date("m/d/Y", $allTransferLeadger->reg_date); ?></td>
                                                    <td><?php echo $allTransferLeadger->remarks; ?></td>
                                                    <td><?php
                                                        $bank_details_data = $bank->getBank_Saif($allTransferLeadger->payable_id);
                                                        $bank_details = $bank_details_data->fetch();
                                                        echo $bank_details["account_name"];
                                                        ?></td>
                                                    <td><?php echo $allTransferLeadger->amount; ?></td>
                                                    <td><?php echo $account_info_Array[0].' - '.$account_details->account_name; ?></td>
                                                </tr>
                                    <?php $counter++; }?>
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