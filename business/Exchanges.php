<?php
$Active_nav_name = array("parent" => "Banking", "child" => "Exchange List");
$page_title = "Exchanges List";
include("./master/header.php");

$banks = new Banks();
$all_echange_data = $banks->getAllExchangeMoney($user_data->company_id);
$all_echange = $all_echange_data->fetchAll(PDO::FETCH_OBJ);
?>

<div class="container pt-2">
    <div class="table-responsive">
        <table class="table material-table" id="SinglecustomerTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Debet</th>
                    <th>Credit</th>
                    <th>Rate</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $counter = 1;
                foreach ($all_echange as $ex) {
                    $date = $ex->reg_date;
                    $ndate = Date("m/d/Y", $ex->reg_date);
                    echo "<tr>
                                <td>$counter</td>
                                <td>$ndate</td>
                                <td>$ex->debt_amount</td>
                                <td>$ex->credit_amount</td>
                                <td>$ex->exchange_rate</td>
                                <td>$ex->details</td>
                        </tr>";
                    $counter++;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


<?php
include("./master/footer.php");
?>