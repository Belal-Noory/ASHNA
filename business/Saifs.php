<?php
$Active_nav_name = array("parent" => "Banking", "child" => "Saif list");
$page_title = "Saif List";
include("./master/header.php");
// Logged in user info 
$bank = new Banks();
$banks = $bank->getSaifs($user_data->company_id);
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

            ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card overflow-hidden">
                            <div class="card-content">
                                <div class="media align-items-stretch bg-gradient-x-<?php echo $colors[array_rand($colors)]; ?> text-white rounded">
                                    <div class="p-2 media-middle">
                                        <i class="icon-home font-large-2 text-white"></i>
                                    </div>
                                    <div class="media-body p-2">
                                        <h4 class="text-white"><?php echo $b->account_name; ?></h4>
                                    </div>
                                    <div class="media-right p-2 media-middle">
                                        <h1 class="text-white"><?php echo $b->currency; ?></h1>
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