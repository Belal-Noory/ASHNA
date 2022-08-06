<?php
$Active_nav_name = array("parent" => "Accounting", "child" => "Fiscal Year CLose");
$page_title = "Fiscal Year";
include("./master/header.php");

$company = new Company();
$document = new Document();

$allcurrency_data = $company->GetCompanyCurrency($user_data->company_id);
$allcurrency = $allcurrency_data->fetchAll(PDO::FETCH_OBJ);

$holders_data = $company->getCompanyHolders($user_data->company_id);
$holders = $holders_data->fetchAll(PDO::FETCH_OBJ);

function recurSearch2($c, $parentID, $op_type)
{
    $total = 0;
    $conn = new Connection();
    $query = "SELECT * FROM account_catagory 
    INNER JOIN chartofaccount ON account_catagory.account_catagory_id = chartofaccount.account_catagory 
    WHERE parentID = ? AND account_catagory.company_id = ? AND chartofaccount.useradded = ?";
    $result = $conn->Query($query, [$parentID, $c, 0]);
    $results = $result->fetchAll(PDO::FETCH_OBJ);
    foreach ($results as $item) {
        $q = "SELECT * FROM general_leadger 
        LEFT JOIN account_money ON general_leadger.leadger_id = account_money.leadger_ID 
        WHERE (general_leadger.recievable_id = ? OR general_leadger.payable_id = ?) AND op_type = ?";
        $r = $conn->Query($q, [$item->chartofaccount_id, $item->chartofaccount_id, $op_type]);
        $RES = $r->fetchAll(PDO::FETCH_OBJ);
        foreach ($RES as $R) {
            echo $R->leadger_id . "-" . $R->amount . ' - ' . $R->ammount_type . "<br/>";
            $total += $R->amount;
        }
        if (checkChilds($item->account_catagory_id) > 0) {
            $total += recurSearch2($c, $item->account_catagory_id, "Revenue");
        }
    }
    return $total;
}

function checkChilds($patne)
{
    $conn = new Connection();
    $query = "SELECT * FROM account_catagory WHERE parentID = ? AND useradded = ?";
    $result = $conn->Query($query, [$patne, 0]);
    $results = $result->rowCount();
    return $results;
}

function getTotalAmount($company, $account, $op_type)
{
    $total = 0;
    $conn = new Connection();
    $query = "SELECT * FROM account_catagory 
    LEFT JOIN chartofaccount ON account_catagory.account_catagory_id = chartofaccount.account_catagory 
    WHERE parentID = ? AND account_catagory.company_id = ?";
    $result = $conn->Query($query, [$account, $company]);
    $results = $result->fetchAll(PDO::FETCH_OBJ);
    foreach ($results as $item) {
        $q = "SELECT * FROM general_leadger 
        LEFT JOIN account_money ON general_leadger.leadger_id = account_money.leadger_ID 
        WHERE (general_leadger.recievable_id = ? OR general_leadger.payable_id = ?) AND op_type = ?";
        $r = $conn->Query($q, [$item->chartofaccount_id, $item->chartofaccount_id, $op_type]);
        $RES = $r->fetchAll(PDO::FETCH_OBJ);
        foreach ($RES as $R) {
            echo $R->leadger_id . "-" . $R->amount . ' - ' . $R->ammount_type . "<br/>";
            $total += $R->amount;
        }

        if (checkChilds($item->account_catagory_id) > 0) {
            $total += recurSearch2($company, $item->account_catagory_id, "Revenue");
        }
    }
    return $total;
}

$totalRevenue = getTotalAmount($user_data->company_id, 4, "Revenue");
$totalExpense = getTotalAmount($user_data->company_id, 5, "Expense");

$totalProfit = $totalRevenue - $totalExpense;

?>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <div class="container">
                <div class="bs-callout-primary mb-2">
                    <div class="media align-items-stretch">
                        <div class="media-left media-middle bg-pink d-flex align-items-center p-2">
                            <i class="la la-sun-o white font-medium-5"></i>
                        </div>
                        <div class="media-body p-1">
                            <strong>Attention Please!</strong>
                            <p>If you register new fiscal year your all transactions will be closed, and a new new financial term will be opened.</p>
                            <p>Before closing the fiscal year, check the balance sheet and balance of the accounts and make corrections if necessary.</p>
                        </div>
                    </div>
                </div>

                <div class="bs-callout-success callout-border-left mt-1 p-2 mb-2">
                    <strong id="totalprofit">Net Profit - <?php echo $totalProfit; ?></strong>
                </div>

                <div class="bs-callout-blue callout-border-left mt-1 p-1 mb-2">
                    <strong>Division of Profit</strong>
                    <p class="mt-2">If you want to divide the profit of current fiscal year between the stockholders, specify its amount.</p>
                    <p>The net profit after tax for this fiscal year is [ <?php echo $totalProfit . ' ' . $mainCurrency; ?> ]. Determine how much of this profit will be divided between the stockholders and how much of it will be transferred to the new fiscal year as retained earning.</p>

                    <form class="form bg-white p-3" disabled>
                        <div class="form-body">
                            <h4 class="form-section d-flex justify-content-between align-items-center">
                                <i class="la la-users"></i>
                                <span>Share Holders</span>
                                <span class="ml-auto badge badge-danger mb-1">
                                    Remided Profit:
                                    <span class="la la-dollar" id="tprofit"></span>
                                </span>
                            </h4>
                            <?php
                            $counter = 1;
                            foreach ($holders as $holdr) {
                                $holder = "holder" . $counter;
                                $percent = "percent" . $counter;
                                $profit = "profit" . $counter;
                            ?>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for=<?php echo $holder ?>>Share Holder</label>
                                            <input type="text" id=<?php echo $holder ?> class="form-control border-blue" placeholder="Share Holder" name=<?php echo $holder ?> value=<?php echo $holdr->customer_id . "-" . $holdr->fname . " " . $holdr->lname ?> readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for=<?php echo $percent ?>>Percentage</label>
                                            <input type="number" id=<?php echo $percent ?> class="form-control border-blue required percent" value="0" placeholder="Percentage" name=<?php echo $percent ?>>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for=<?php echo $profit ?>>Profit</label>
                                            <input type="text" id=<?php echo $profit ?> class="form-control border-blue" placeholder="Profit" name=<?php echo $profit ?> readonly>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <input type="hidden" name="holdersCount" value=<?php echo $counter; ?>>
                            <h4 class="form-section"><i class="la la-users"></i>Accounts</h4>
                            <select name="account" id="account" class="form-control">
                                <option value="67">Profit and Loss</option>
                                <option value="43">Accounts Payable</option>
                            </select>

                            <h4 class="form-section mt-3"><i class="la la-users"></i>Financial Term</h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="fiscal_year_start">Term Start</label>
                                        <input type="date" id="fiscal_year_start" class="form-control border-blue required" placeholder="Term Start" name="fiscal_year_start">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="fiscal_year_end">Term End</label>
                                        <input type="date" id="fiscal_year_end" class="form-control border-blue required" placeholder="Term End" name="fiscal_year_end">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" id="title" class="form-control border-blue required" placeholder="Title" name="title">
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions center">
                                <button type="reset" class="btn btn-danger mr-1 waves-effect waves-light text-white" id="btnreset">
                                    <i class="ft-x"></i> Cancel
                                </button>
                                <button type="submit" class="btn btn-blue waves-effect waves-light text-white" id="btn_submit">
                                    <i class="la la-check-square-o"></i>
                                    <i class="la la-spinner spinner d-none"></i>
                                    Close/New Fiscal Year
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="addcompany_financial_terms">
                    </form>
                </div>
            </div>
        </div>
    </div> <!-- Form wzard with step validation section start -->
</div>


<!-- Modal -->
<div class="modal fade text-center" id="show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body p-2">
                <div class="container container-waiting">
                    <div class="loader-wrapper">
                        <div class="loader-container">
                            <div class="ball-clip-rotate loader-primary">
                                <div></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container container-done d-none">
                    <i class="font-large-2 icon-line-height la la-check" style="color: seagreen;"></i>
                    <h5>Prevois Fiscal Year closed and new fiscal year added</h5>
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
        $.fn.hasAttr = function(name) {
            return this.attr(name) !== undefined;
        };

        totalProfit = $("#totalprofit").text().toString()
        totalProfit = totalProfit.substr(totalProfit.lastIndexOf("-") + 1);
        $("#tprofit").text(totalProfit);

        $(".percent").on("blur", function() {
            percent = 0;
            if($(this).val() <= 100 && $(this).val() > 0)
            {
                percent = $(this).val();
            }
            else{
                percent = 100;
                $(this).val(percent);
            }
            if ($(this).parent().parent().parent().children("div:last").children(".form-group").children("input").hasAttr('prev'))
            {
                prevValue = parseFloat($(this).parent().parent().parent().children("div:last").children(".form-group").children("input").attr("prev"));
                totalProfit += prevValue;
                profit = Math.round((percent / 100) * totalProfit);
                $(this).parent().parent().parent().children("div:last").children(".form-group").children("input").val(profit);
                $(this).parent().parent().parent().children("div:last").children(".form-group").children("input").attr("prev", profit);
                totalProfit = totalProfit-profit;
                $("#tprofit").text(totalProfit);
            }
            else{
                profit = Math.round((percent / 100) * totalProfit);
                $(this).parent().parent().parent().children("div:last").children(".form-group").children("input").val(profit);
                $(this).parent().parent().parent().children("div:last").children(".form-group").children("input").attr("prev", profit);
                $("#tprofit").text(profit-totalProfit);
                totalProfit = totalProfit-profit;
            }
        });

        // Add customer
        $(".form").on("submit", function(e) {
            e.preventDefault();
            if ($(".form").valid()) {
                $("#btn_submit").children("i.la-check-square-o").hide();
                $("#btn_submit").children("i.spinner").removeClass("d-none");
                $("#btn_submit").attr("disabled", '');
                $("#btnreset").attr("disabled", '');

                $.ajax({
                    url: "../app/Controllers/Company.php",
                    type: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        console.log(data);
                        window.location.reload();
                    },
                    error: function(e) {
                        console.log(e);
                    }
                });
            }
        });
    });

    // Initialize validation
    $(".form").validate({
        ignore: 'input[type=hidden]', // ignore hidden fields
        errorClass: 'danger',
        successClass: 'success',
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        unhighlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        }
    });
</script>