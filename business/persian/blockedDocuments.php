<?php
$Active_nav_name = array("parent" => "Settings", "child" => "Blocked Documents");
$page_title = "Blocked Documents";
include("./master/header.php");

$transfer = new Transfer();
$bussiness = new Bussiness();

$locked_data = $transfer->getBlockedTransactions($user_data->company_id);
$locked = $locked_data->fetchAll(PDO::FETCH_OBJ);

?>

<style>
    .hover:hover span {
        transform: scale(1.09);
    }
</style>

<div class="app-content content">
    <div class="content-header row">
    </div>
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <div class="card p-1">
                <div class="table-responsive">
                    <table class="material-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Amount</th>
                                <th>Money Sender</th>
                                <th>Money Receiver</th>
                                <th>Transfer Code</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($locked_data->rowCount() > 0) {
                                foreach ($locked as $ptransfer) {
                                    $from_data = $bussiness->getCustomerByID($ptransfer->company_user_sender);
                                    $from = $from_data->fetch(PDO::FETCH_OBJ);

                                    $to_data = $bussiness->getCustomerByID($ptransfer->company_user_receiver);
                                    $to = $to_data->fetch(PDO::FETCH_OBJ);

                                    // money sender
                                    $money_sender_data = $bussiness->getCustomerByID($ptransfer->money_sender);
                                    $money_sender = $money_sender_data->fetch(PDO::FETCH_OBJ);

                                    // money receiver
                                    $money_receiver_data = $bussiness->getCustomerByID($ptransfer->money_receiver);
                                    $money_receiver = $money_receiver_data->fetch(PDO::FETCH_OBJ);

                                    $dat = date("m/d/Y", $ptransfer->reg_date);
                                    echo "<tr class='mainrow'>
                                            <td>$dat</td>
                                            <td class='tRow' data-href='$ptransfer->leadger_id'>$ptransfer->details</td>
                                            <td>$from->fname $from->lname</td>
                                            <td>$to->fname $to->lname</td>
                                            <td>$ptransfer->amount-$ptransfer->currency</td>
                                            <td>$money_sender->fname $money_sender->lname</td>
                                            <td>$money_receiver->fname $money_receiver->lname</td>
                                            <td>$ptransfer->transfer_code</td>
                                            <td><a class='btnunlockT hover' href='#' data-href='$ptransfer->company_money_transfer_id'><span class='las la-unlock text-blue la-2x'></span><span class='las la-spinner spinner la-2x d-none'></span></a></td>
                                        </tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include("./master/footer.php");
?>

<script>
    $(document).ready(function() {
        tbl = $(".material-table").DataTable();
        // unlock transaction
        $(document).on("click", ".btnunlockT", function(e) {
            e.preventDefault();
            ID = $(this).attr("data-href");
            parent = $(this).parent().parent();
            ths = $(this);
            if(!$(ths).attr("loading"))
            {
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
                                $(ths).attr("loading",true);
                                $(ths).children("span").first().addClass("d-none");
                                $(ths).children("span").last().removeClass("d-none");
                                $.get("../app/Controllers/Transfer.php", {
                                    lockTR: true,
                                    ID: ID,
                                    lock: 0
                                }, function(data) {
                                    console.log(data);
                                    if(data > 0)
                                    {
                                        tbl.row(parent).remove().draw(false);
                                    }
                                });
                            }
                        },
                        cancel: {
                            text: 'نخیر',
                            action: function() {}
                        }
                    }
                });
            }
        });
    });
</script>