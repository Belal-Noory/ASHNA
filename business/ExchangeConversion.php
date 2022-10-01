<?php
$Active_nav_name = array("parent" => "Accounting", "child" => "Exchange Conversion");
$page_title = "Exchange Conversion";
include("./master/header.php");

$company = new Company();
$ccurrency_data = $company->GetCompanyCurrency($user_data->company_id);
$currency = $ccurrency_data->fetchAll(PDO::FETCH_OBJ);

$currency_conversion_data = $company->GetCompanyCurrencyConversion($user_data->company_id);
$currency_conversion = $currency_conversion_data->fetchAll(PDO::FETCH_OBJ);
?>

<!-- END: Main Menu-->
<!-- BEGIN: Content-->
<div class="container pt-4">
    <section id="currency-exchange">
        <div class="col-md-12 col-sm-12">
            <div class="card text-center">
                <div class="card-header mt-3">
                    <h1 class="text-bold-500 info">
                        Daily Exchange Conversion
                    </h1>
                </div>
                <div class="card-subtitle p-0 mx-2">
                    <h5 class="text-bold-500">Please enter you all currency exchange on daily bases or even on hour bases.</h5>
                </div>
                <div class="card-body mt-2">
                    <form class="exchange">
                        <div class="form-group form-inline d-flex justify-content-center">
                            <div class="input-group mr-1 mb-1">
                                <select name="cfrom" id="cfrom" class="form-control bg-info text-white required">
                                    <option value="">From</option>
                                    <?php
                                    foreach ($currency as $c) {
                                        $selected = $c->mainCurrency == 1 ? "selected" : "";
                                        echo "<option value='$c->currency' $selected>$c->currency</option>";
                                    }
                                    ?>
                                </select>
                                <select name="cto" id="cto" class="form-control bg-primary text-white required">
                                    <option value="">To</option>

                                    <?php
                                    foreach ($currency as $c) {
                                        echo "<option value='$c->currency'>$c->currency</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="input-group mb-1">
                                <input type="number" class="form-control required" placeholder="Rate" name="rate" id="rate">
                            </div>
                        </div>
                        <button type="button" class="btn btn-info exchange my-2" id="addexchange">
                            <i class="la la-exchange font-medium-1"></i>
                            <span class="font-medium-1"> Exchange </span>
                        </button>
                    </form>
                    <div class="col-lg-12"><span class="alert d-none"></span></div>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-sm-12 pb-5">
            <div class="card text-center">
                <div class="card-header mt-3">
                    <h1 class="text-bold-500 info">
                        Exchange Conversion List
                    </h1>
                </div>
                <div class="card-body mt-2">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">#</th>
                                <th scope="col" class="text-center">Date</th>
                                <th scope="col" class="text-center">From (Currency)</th>
                                <th scope="col" class="text-center">To (Currency)</th>
                                <th scope="col" class="text-center">Rate</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $counter = 0;
                                foreach ($currency_conversion as $cc) {?>
                                    <tr>
                                        <th scope="row" class="text-center"><?php echo $counter ?></th>
                                        <td class="text-center"><?php echo date("Y/m/d",$cc->reg_date)?></td>
                                        <td class="text-center"><?php echo $cc->currency_from?></td>
                                        <td class="text-center"><?php echo $cc->currency_to?></td>
                                        <td class="text-center"><?php echo $cc->rate?></td>
                                    </tr>
                               <?php $counter++; }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- END: Content-->
<?php
include("./master/footer.php");
?>

<script>
    $(document).ready(function() {
        setInterval(function() {
            $(".alert").addClass("d-none");
        }, 4000);

        $("#addexchange").on("click", function(e) {
            fromC = $("#cfrom").val();
            toC = $("#cto").val();
            rate = $("#rate").val();

            if (fromC == "" || fromC.length <= 0) {
                $(".alert").addClass("alert-danger").text("Please select you currency from which you want to convert").removeClass("d-none");
            } else if (toC == "" || toC.length <= 0) {
                $(".alert").addClass("alert-danger").text("Please select you currency to which you want to convert").removeClass("d-none");
            } else if (rate == "" || rate.length <= 0) {
                $(".alert").addClass("alert-danger").text("Please enter your rate").removeClass("d-none");
            } else {
                $.post("../app/Controllers/banks.php", {
                    "addExchange": true,
                    "fromC": fromC,
                    "toC": toC,
                    "rate": rate
                }, (data) => {
                    $(".alert").addClass("alert-info").text("Exchange Saved").removeClass("d-none");
                    $(".exchange")[0].reset();
                });
            }
        });
    });
</script>