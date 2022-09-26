<?php
$Active_nav_name = array("parent" => "Banking", "child" => "Bank List");
$page_title = "Banks";
include("./master/header.php");
// Logged in user info 
$bank = new Banks();
$company = new Company();

$banks = $bank->getBanks($user_data->company_id);
$banks_data = $banks->fetchAll(PDO::FETCH_OBJ);

$allcurrency_data = $company->GetCompanyCurrency($user_data->company_id);
$allcurrency = $allcurrency_data->fetchAll(PDO::FETCH_OBJ);

// cards color
$colors = array("info", "danger", "success", "warning");
?>

<style>
    .hover:hover {
        transform: scale(1.08);
        cursor: pointer;
    }
</style>

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
                                    <div class="p-2 media-middle" style="display: flex; flex-direction:column;justify-content: space-between;">
                                        <i class="icon-home font-large-2 text-white"></i>
                                        <i class="las la-edit hover text-white btneshowedite" data-href="<?php echo $b->chartofaccount_id; ?>"></i>
                                    </div>
                                    <div class="media-body p-2">
                                        <h4 class="text-white"><?php echo $b->account_name; ?></h4>
                                        <h5 class="text-white"><?php echo $b->account_number; ?></h5>
                                        <h3 class="text-white mt-1"><?php echo $amounts->Debet - $amounts->Credit . $b->currency; ?></h3>
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

<!-- Add Reminder Modal -->
<div class="modal fade text-center" id="showeditbankModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body p-2">
                <div class="card">
                    <div class="card-header">
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <form action="#" class="form">
                                <h4 class="form-section"><i class="ft-user"></i> Bank Info</h4>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="account_name" style="font-variant:small-caps">
                                                account name:
                                                <span class="danger">*</span>
                                            </label>
                                            <input type="text" class="form-control required" id="account_name" name="account_name" placeholder="ACCOUNT NAME">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="account_number" style="font-variant:small-caps">
                                                account number:
                                                <span class="danger">*</span>
                                            </label>
                                            <input type="text" class="form-control required" id="account_number" name="account_number" placeholder="ACCOUNT NUMBER">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="initial_ammount" style="font-variant:small-caps">
                                                initial ammount:
                                                <span class="danger">*</span>
                                            </label>
                                            <input type="text" class="form-control required" id="initial_ammount" name="initial_ammount" placeholder="INITIAL AMMOUNT">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="currency" style="font-variant:small-caps">
                                                currency:
                                                <span class="danger">*</span>
                                            </label>
                                            <select id="currency" name="currency" class="form-control">
                                                <?php
                                                foreach ($allcurrency as $currency) {
                                                    echo "<option value='$currency->company_currency_id'>$currency->currency</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="note" style="font-variant:small-caps">
                                                note:
                                                <span class="danger">*</span>
                                            </label>
                                            <textarea class="form-control" id="note" name="note" placeholder="NOTE"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button type="submite" class="btn btn-blue waves-effect waves-light">
                                        <i class="la la-check-square-o"></i> Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
include("./master/footer.php");
?>

<script>
    $(document).ready(function(){

        // load bank
        $(document).on("click",".btneshowedite",function(e){
            e.preventDefault();
            bID = $(this).attr("data-href");
            $.get("../app/Controllers/banks.php",{accountDetails:true,acc:bID},function(data){
                ndata = $.parseJSON(data);
                console.log(data);

                $("#account_name").val(ndata.account_name);
                $("#account_number").val(ndata.account_number);
                $("#initial_ammount").val(ndata.initial_ammount);
                $("#currency").val();
                $("#note").val(ndata.note);
            });
        });
    });
</script>