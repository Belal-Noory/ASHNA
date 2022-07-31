<?php
$Active_nav_name = array("parent" => "Banking", "child" => "Exchange List");
$page_title = "Exchanges List";
include("./master/header.php");

$bank = new Banks();
$all_echange_data = $bank->getAllExchangeMoney($user_data->company_id);
$all_echange = $all_echange_data->fetchAll(PDO::FETCH_OBJ);
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
                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table material-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>EID</th>
                                    <th>LID</th>
                                    <th>Date</th>
                                    <th>Details</th>
                                    <th>From</th>
                                    <th>Amount</th>
                                    <th>Rate</th>
                                    <th>To</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                    $counter = 0;
                                    $LID = 0;
                                    $next = false;

                                    $acfrom = "";
                                    $amountfrom = 0;
                                    $acto = "";
                                    $amountto = 0;
                                    foreach ($all_echange as $newrec) {
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

                                        $LID = $newrec->leadger_ID;

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
                                                     $details = $bank->getchartofaccountDetails($acto);
                                                     $res = json_decode($details);
                                                     echo $res->account_name; ?></td>
                                                    <td><?php echo $amountto; ?></td>
                                                    <td><?php echo $newrec->currency_rate ?></td>
                                                    <td><?php
                                                     $details = $bank->getchartofaccountDetails($acfrom);
                                                     $res = json_decode($details);
                                                     echo $res->account_name;
                                                     ?></td>
                                                    <td><?php echo $amountfrom; ?></td>
                                                </tr>
                                    <?php 
                                        $counter++; 
                                        $LID = 0; 
                                        $acfrom = "";
                                        $amountfrom = 0;
                                        $acto = "";
                                        $amountto = 0;
                                        $next=false;
                                    }
                                    }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Material Data Tables -->


    <?php
    include("./master/footer.php");
    ?>