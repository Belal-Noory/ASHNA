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
                                        <th>From</th>
                                        <th>Amount</th>
                                        <th>To</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $allTransferLeadger =  $allTransfersLeadger_Data->fetchAll(PDO::FETCH_OBJ);
                                    $counter = 0;
                                    $LID = 0;
                                    $next = false;

                                    $acfrom = "";
                                    $amountfrom = 0;
                                    $acto = "";
                                    $amountto = 0;
                                    foreach ($allTransferLeadger as $newrec) {
                                        if($LID == 0)
                                        {
                                            $acto = $newrec->account_id;
                                            $amountto = $newrec->amount;
                                        }

                                        if($newrec->leadger_ID == $LID)
                                        {
                                            $acfrom = $newrec->account_id;
                                            $amountfrom = $newrec->amount;
                                            $next = true;
                                        }

                                        if($next)
                                        {
                                    ?>
                                                <tr>
                                                    <td><?php echo $counter; ?></td>
                                                    <td><?php echo $newrec->account_money_id; ?></td>
                                                    <td><?php echo $newrec->leadger_ID; ?></td>
                                                    <td><?php echo date("m/d/Y", $newrec->reg_date); ?></td>
                                                    <td><?php echo $newrec->remarks; ?></td>
                                                    <td><?php
                                                     $details = $bank->getchartofaccountDetails($acfrom);
                                                     $res = json_decode($details);
                                                     echo $res->account_name;
                                                     ?></td>
                                                    <td><?php echo $amountfrom; ?></td>
                                                    <td><?php 
                                                     $details = $bank->getchartofaccountDetails($acto);
                                                     $res = json_decode($details);
                                                     echo $res->account_name; ?></td>
                                                    <td><?php echo $amountto; ?></td>
                                                </tr>
                                    <?php 
                                    $counter++; $next = false; $LID = 0; }
                                    $LID = $newrec->leadger_ID;
                                    }?>
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