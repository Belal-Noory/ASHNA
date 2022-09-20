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
                                    <th>LID</th>
                                    <th>Date</th>
                                    <th>Details</th>
                                    <th>From</th>
                                    <th>Amount</th>
                                    <th>Rate</th>
                                    <th>To</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $counter = 0;
                                foreach ($all_echange as $newrec) {
                                    // account from
                                    $acc_from_data = $bank->getSystemAccount($newrec->payable_id);
                                    $acc_from = $acc_from_data->fetch(PDO::FETCH_OBJ);

                                    // get account from money
                                    $money_to_data = $bank->getMoney($newrec->payable_id,$newrec->leadger_id);
                                    $money_to = $money_to_data->fetch(PDO::FETCH_OBJ);

                                    // account to
                                    $acc_to_data = $bank->getSystemAccount($newrec->recievable_id);
                                    $acc_to = $acc_to_data->fetch(PDO::FETCH_OBJ);

                                    // get account from money
                                    $money_from_data = $bank->getMoney($newrec->recievable_id,$newrec->leadger_id);
                                    $money_from = $money_from_data->fetch(PDO::FETCH_OBJ);
                                ?>
                                    <tr>
                                        <td><?php echo $counter; ?></td>
                                        <td><?php echo $newrec->leadger_id; ?></td>
                                        <td><?php echo date("m/d/Y", $newrec->reg_date); ?></td>
                                        <td><?php echo $newrec->remarks; ?></td>
                                        <td><?php echo $acc_from->account_name; ?></td>
                                        <td><?php echo $money_to->amount; ?></td>
                                        <td><?php echo $newrec->currency_rate ?></td>
                                        <td><?php echo $acc_to->account_name;?></td>
                                        <td><?php echo $money_from->amount ?></td>
                                        <td><a href='Edite.php?edit=<?php echo $newrec->leadger_id; ?>&op=ex'><span class='las la-edit la-2x'></span></a></td>
                                    </tr>
                                <?php
                                    $counter++;
                                } ?>
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