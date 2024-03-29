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
                    $amount_data = $bank->getAccountMoneyWithRate($b->chartofaccount_id);
                    $amounts = $amount_data->fetchAll(PDO::FETCH_OBJ);
                    $debit = 0;
                    $credit = 0;
                    foreach ($amounts as $amount) {
                        if($amount->ammount_type == "Debet")
                        {
                            $debit += $amount->amount;
                        }
                        else{
                            $credit += $amount->amount;
                        }
                    }

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
                                        <h3 class="text-white mt-1"><?php echo $debit-$credit . "-" . $b->currency; ?></h3>
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
<div class="modal fade" id="showeditbankModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body p-2">
                <form action="#" class="form">
                    <h4 class="form-section"><i class="ft-user"></i>شرح حساب بانکی</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="account_name" style="font-variant:small-caps">
                                    نام حساب:
                                    <span class="danger">*</span>
                                </label>
                                <input type="text" class="form-control required" id="account_name" name="account_name" placeholder="ACCOUNT NAME">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="account_number" style="font-variant:small-caps">
                                    شماره حساب:
                                    <span class="danger">*</span>
                                </label>
                                <input type="text" class="form-control required" id="account_number" name="account_number" placeholder="ACCOUNT NUMBER">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="currency" style="font-variant:small-caps">
                                    اسعار:
                                    <span class="danger">*</span>
                                </label>
                                <select id="currency" name="currency" class="form-control">
                                    <?php
                                    foreach ($allcurrency as $currency) {
                                        echo "<option value='$currency->currency'>$currency->currency</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="note" style="font-variant:small-caps">
                                    یاد داشت:
                                    <span class="danger">*</span>
                                </label>
                                <textarea class="form-control" id="note" name="note" placeholder="NOTE"></textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="bID" id="bID">
                    <input type="hidden" name="udpateBank" id="udpateBank">
                    <div class="form-actions">
                        <button type="button" class="btn btn-blue waves-effect waves-light" id="btnediteBank">
                            <i class="la la-check-square-o"></i>
                            <i class="las la-spinner spinner d-none"></i>
                            بروز رسانی
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php
include("./master/footer.php");
?>

<script>
    $(document).ready(function() {

        // recent selected bank for edite
        recentSelectedBank = null;
        // load bank
        $(document).on("click", ".btneshowedite", function(e) {
            e.preventDefault();
            bID = $(this).attr("data-href");
            ths = $(this);
            $.get("../app/Controllers/banks.php", {
                accountDetails: true,
                acc: bID
            }, function(data) {
                ndata = $.parseJSON(data);
                recentSelectedBank = $(ths);
                $("#account_name").val(ndata.account_name);
                $("#account_number").val(ndata.account_number);

                bankCurrency = $(ths).parent().parent().children("div").last().children("h3").text();
                BCurrencyAmount = parseFloat(bankCurrency.substr(0, bankCurrency.lastIndexOf("-")));
                BCurrency = bankCurrency.substr(bankCurrency.lastIndexOf("-")+1);
                console.log(BCurrencyAmount);
                if (BCurrencyAmount == 0) {
                    $("#currency option").filter(function() {
                        if($(this).hasClass("d-none"))
                        {
                            $(this).removeClass("d-none");
                        }
                        return $(this).text() == ndata.currency;
                    }).prop('selected', true);
                } else {
                    $("#currency option").filter(function() {
                        if($(this).text() == ndata.currency)
                        {
                            if($(this).hasClass("d-none"))
                            {
                                $(this).removeClass("d-none");
                            }
                        }
                        else{ 
                            $(this).addClass("d-none");
                        }
                    }).prop('selected', true);
                }
                $("#note").val(ndata.note);
                $("#bID").val(bID);
                $("#showeditbankModel").modal("show");
            });
        });

        // update bank
        $("#btnediteBank").on("click", function(e) {
            e.preventDefault();
            ths = $(this);
            if (!$(ths).attr("loading")) {
                $(ths).children("i").first().addClass("d-none");
                $(ths).children("i").last().removeClass("d-none");
                $(ths).attr("loading", true);

                $.post("../app/Controllers/banks.php", $(".form").serialize(), function(data) {
                    ndata = $.parseJSON(data);
                    // set Account Name
                    $(recentSelectedBank).parent().parent().children("div").last().children("h4").text(ndata[0]);
                    // set Account Number
                    $(recentSelectedBank).parent().parent().children("div").last().children("h5").text(ndata[1]);
                    // Set Account Currency
                    bankCurrency = $(recentSelectedBank).parent().parent().children("div").last().children("h3").text();
                    BCurrencyAmount = parseFloat(bankCurrency.substr(0, bankCurrency.lastIndexOf("-")));
                    $(recentSelectedBank).parent().parent().children("div").last().children("h3").text(BCurrencyAmount+"-"+ndata[2]);

                    $(ths).children("i").first().removeClass("d-none");
                    $(ths).children("i").last().addClass("d-none");
                    $(ths).removeAttr("loading");
                    $("#showeditbankModel").modal("hide");
                });
            }
        });
    });
</script>