<?php
$Active_nav_name = array("parent" => "Banking", "child" => "Bank List");
$page_title = "Banks";
include("./master/header.php");
// Logged in user info 
$bank = new Banks();
$banks = $bank->getBanks($user_data->company_id);
$banks_data = $banks->fetchAll(PDO::FETCH_OBJ);

// cards color
$colors = array("info", "danger", "success", "warning");
?>
<section id="stats-icon-subtitle-bg-1">
    <div class="container">
        <div class="row pt-2">

            <?php
            if (count($banks_data) > 0) {
                foreach ($banks_data as $b) {
                    $amount_data = $bank->getAccountMoneyByID($b->chartofaccount_id);
                    $amounts = $amount_data->fetch(PDO::FETCH_OBJ);

            ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card overflow-hidden">
                            <div class="card-content">
                                <div class="media align-items-stretch bg-gradient-x-<?php echo $colors[array_rand($colors)]; ?> text-white rounded">
                                    <div class="p-2 media-middle" style="display: flex; flex-direction:column">
                                        <i class="icon-home font-large-2 text-white"></i>
                                        <i class="las la-edit font-large-2 text-white"></i>
                                    </div>
                                    <div class="media-body p-2">
                                        <h4 class="text-white"><?php echo $b->account_name; ?></h4>
                                        <h5 class="text-white"><?php echo $b->account_number; ?></h5>
                                        <h3 class="text-white mt-1"><?php echo $amounts->Debet-$amounts->Credit.$b->currency; ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php }
            } ?>
        </div>
    </div>
</section>

<?php
include("./master/footer.php");
?>