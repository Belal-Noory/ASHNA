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

$company_FT_data = $company->getCompanyFT($user_data->company_id);
$company_FT = $company_FT_data->fetchAll(PDO::FETCH_OBJ);

function recurSearch2($c, $parentID, $selector, $mainC)
{
    $conn = new Connection();
    $company = new Company();
    $banks = new Banks();
    $query = "SELECT * FROM account_catagory 
    INNER JOIN chartofaccount ON chartofaccount.account_catagory = account_catagory.account_catagory_id 
    WHERE account_catagory.parentID = ? AND chartofaccount.company_id = ?";
    $result = $conn->Query($query, [$parentID, $c]);
    $results = $result->fetchAll(PDO::FETCH_OBJ);
    foreach ($results as $item) {
        $q = "SELECT * FROM account_money WHERE account_id = ? AND company_id = ?";
        $r = $conn->Query($q, [$item->chartofaccount_id, $c]);
        $RES = $r->fetchAll(PDO::FETCH_OBJ);
        $rate = 0;
        $credit = 0;
        $debit = 0;
        $total = 0;
        foreach ($RES as $LID) {
            // get account currency details
            $acc_currency_data = $company->GetCurrencyDetails($LID->currency);
            $acc_currency = $acc_currency_data->fetch(PDO::FETCH_OBJ);
            if ($acc_currency->currency != $mainC) {
                $currency_exchange_data = $banks->getExchangeConversion($mainC, $acc_currency->currency, $c);
                $currency_exchange = $currency_exchange_data->fetch(PDO::FETCH_OBJ);
                if ($currency_exchange->currency_from == $mainC) {
                    $rate = 1 / $currency_exchange->rate;
                } else {
                    $rate = $currency_exchange->rate;
                }
            } else {
                $rate = 1;
            }

            if ($selector == "revenue" || $selector == "expenses") {
                $credit += $LID->amount;
            } else {
                if ($LID->ammount_type == "Crediet") {
                    $credit += $LID->amount;
                } else {
                    $debit += $LID->amount;
                }
            }
            $debit *= $rate;
            $credit *= $rate;
            if ($selector == "revenue" || $selector == "expenses") {
                $total += round($credit);
            } else {
                $total += round($debit - $credit);
            }
        }
        echo "<span class='$selector d-none'>$total</span>";
        if (checkChilds($item->account_catagory_id) > 0) {
            recurSearch2($c, $item->account_catagory_id, $selector, $mainC);
        }
    }
}

function recurSearchLib($c, $parentID, $selector, $total)
{
    $conn = new Connection();
    $query = "SELECT * FROM account_catagory 
    INNER JOIN chartofaccount ON chartofaccount.account_catagory LIKE concat( '%',account_catagory.account_catagory_id,'%' ) 
    WHERE account_catagory.parentID = ? AND chartofaccount.company_id = ?";
    $result = $conn->Query($query, [$parentID, $c]);
    $results = $result->fetchAll(PDO::FETCH_OBJ);
    foreach ($results as $item) {
        $q = "SELECT * FROM account_money WHERE account_id = ? AND company_id = ?";
        $r = $conn->Query($q, [$item->chartofaccount_id, $c]);
        $RES = $r->fetchAll(PDO::FETCH_OBJ);
        $debit = 0;
        $credit = 0;
        foreach ($RES as $LID) {
            if ($LID->ammount_type == "Crediet") {
                if ($LID->rate != 0) {
                    $credit -= ($LID->amount * $LID->rate);
                } else {
                    $credit -= $LID->amount;
                }
            } else {
                if ($LID->rate != 0) {
                    $debit += ($LID->amount * $LID->rate);
                } else {
                    $debit += $LID->amount;
                }
            }
        }
        $total += round($debit - $credit);
        if (checkChilds($item->account_catagory_id) > 0) {
            $total += recurSearchLib($c, $item->account_catagory_id, $selector, $total);
        }
    }
    return $total;
}

function recurSearchCapital($c, $parentID, $amount_type, $total)
{
    $conn = new Connection();
    $query = "SELECT * FROM account_catagory 
    LEFT JOIN chartofaccount ON account_catagory.account_catagory_id = chartofaccount.account_catagory 
    WHERE account_catagory.parentID = ? AND chartofaccount.company_id = ? ORDER BY chartofaccount.chartofaccount_id ASC";
    $result = $conn->Query($query, [$parentID, $c]);
    $results = $result->fetchAll(PDO::FETCH_OBJ);
    foreach ($results as $item) {
        $q = "SELECT * FROM account_money WHERE detials = ? AND account_id = ? AND company_id = ?";
        $r = $conn->Query($q, ["Opening Balance", $item->chartofaccount_id, $c]);
        $RES = $r->fetchAll(PDO::FETCH_OBJ);
        foreach ($RES as $LID) {
            if ($LID->ammount_type == "Crediet") {
                if ($LID->rate != 0) {
                    $total += ($LID->amount * $LID->rate);
                } else {
                    $total += $LID->amount;
                }
            } else {
                if ($LID->rate != 0) {
                    $total -= ($LID->amount * $LID->rate);
                } else {
                    $total -= $LID->amount;
                }
            }
        }
        $total = round($total);
        if (checkChilds($item->account_catagory_id) > 0) {
            $total += recurSearchCapital($c, $item->account_catagory_id, $amount_type, $total);
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

// $totalRevenue = 0;
// $conn = new Connection();
// // Revenue
// $query = "SELECT * FROM account_catagory 
//         LEFT JOIN chartofaccount ON account_catagory.account_catagory_id = chartofaccount.account_catagory 
//         WHERE account_catagory.catagory  = ? AND chartofaccount.company_id = ?";
// $result = $conn->Query($query, ["Revenue", $user_data->company_id]);
// $results = $result->fetchAll(PDO::FETCH_OBJ);
// $credit = 0;
// foreach ($results as $item) {
//     $q = "SELECT * FROM account_money WHERE account_id = ? AND company_id = ?";
//     $r = $conn->Query($q, [$item->chartofaccount_id, $user_data->company_id]);
//     $RES = $r->fetchAll(PDO::FETCH_OBJ);
//     $rate = 0;
//     foreach ($RES as $LID) {
//         // get account currency details
//         $acc_currency_data = $company->GetCurrencyDetails($LID->currency);
//         $acc_currency = $acc_currency_data->fetch(PDO::FETCH_OBJ);
//         if ($LID->currency != $mainCurrencyID) {
//             $currency_exchange_data = $banks->getExchangeConversion($mainCurrency, $acc_currency->currency, $user_data->company_id);
//             $currency_exchange = $currency_exchange_data->fetch(PDO::FETCH_OBJ);
//             if ($currency_exchange->currency_from == $mainCurrency) {
//                 $rate = 1 / $currency_exchange->rate;
//             } else {
//                 $rate = $currency_exchange->rate;
//             }
//         } else {
//             $rate = 1;
//         }
//         $credit += $LID->amount;
//     }
//     $credit *= $rate;
//     $totalRevenue = round($credit);
//     if (checkChilds($item->account_catagory_id) > 0) {
//        $totalRevenue += recurSearch2($user_data->company_id, $item->account_catagory_id, "revenue", $mainCurrency,$totalRevenue);
//     }
// }

// //    Expenses
// $totalExp = 0;
// $query = "SELECT * FROM account_catagory 
// LEFT JOIN chartofaccount ON account_catagory.account_catagory_id = chartofaccount.account_catagory 
// WHERE account_catagory.catagory  = ? AND chartofaccount.company_id = ?";
//    $result = $conn->Query($query, ["Expenses", $user_data->company_id]);
//    $results = $result->fetchAll(PDO::FETCH_OBJ);
//    $debit = 0;
//    foreach ($results as $item) {
//        $q = "SELECT * FROM account_money WHERE account_id = ? AND company_id = ?";
//        $r = $conn->Query($q, [$item->chartofaccount_id, $user_data->company_id]);
//        $RES = $r->fetchAll(PDO::FETCH_OBJ);
//        $rate = 0;
//        foreach ($RES as $LID) {
//            // get account currency details
//            $acc_currency_data = $company->GetCurrencyDetails($LID->currency);
//            $acc_currency = $acc_currency_data->fetch(PDO::FETCH_OBJ);
//            if ($LID->currency != $mainCurrencyID) {
//                $currency_exchange_data = $banks->getExchangeConversion($mainCurrency, $acc_currency->currency, $user_data->company_id);
//                $currency_exchange = $currency_exchange_data->fetch(PDO::FETCH_OBJ);
//                if ($currency_exchange->currency_from == $mainCurrency) {
//                    $rate = 1 / $currency_exchange->rate;
//                } else {
//                    $rate = $currency_exchange->rate;
//                }
//            } else {
//                $rate = 1;
//            }
//            $debit += $LID->amount;
//        }
//        $debit = $debit * $rate;
//        $total = round($debit);
//        if (checkChilds($item->account_catagory_id) > 0) {
//             $totalExp += recurSearch2($user_data->company_id, $item->account_catagory_id, "expenses", $mainCurrency,$totalExp);
//        }
//        return $totalExp;
//    }

//    // Liabilities
//    $totalLib = 0;
//    $query = "SELECT * FROM account_catagory 
//     LEFT JOIN chartofaccount ON account_catagory.account_catagory_id = chartofaccount.account_catagory 
//     WHERE account_catagory.catagory  = ? AND chartofaccount.company_id = ?";
//    $result = $conn->Query($query, ["Liabilities", $user_data->company_id]);
//    $results = $result->fetchAll(PDO::FETCH_OBJ);
//    foreach ($results as $item) {
//        $q = "SELECT * FROM account_money WHERE account_id = ? AND company_id = ?";
//        $r = $conn->Query($q, [$item->chartofaccount_id, $user_data->company_id]);
//        $RES = $r->fetchAll(PDO::FETCH_OBJ);
//        $debit = 0;
//        $credit = 0;
//        $rate = 0;
//        foreach ($RES as $LID) {
//            // get account currency details
//            $acc_currency_data = $company->GetCurrencyDetails($LID->currency);
//            $acc_currency = $acc_currency_data->fetch(PDO::FETCH_OBJ);
//            if ($LID->currency != $mainCurrencyID) {
//                $currency_exchange_data = $banks->getExchangeConversion($mainCurrency, $acc_currency->currency, $user_data->company_id);
//                $currency_exchange = $currency_exchange_data->fetch(PDO::FETCH_OBJ);
//                if ($currency_exchange->currency_from == $mainCurrency) {
//                    $rate = 1 / $currency_exchange->rate;
//                } else {
//                    $rate = $currency_exchange->rate;
//                }
//            } else {
//                $rate = 1;
//            }
//            if ($LID->ammount_type == "Crediet") {
//                $credit += $LID->amount;
//            } else {
//                $debit += $LID->amount;
//            }
//        }
//        $debit = $debit * $rate;
//        $credit = $credit * $rate;
//        $totalLib = round($debit - $credit);
//        if (checkChilds($item->account_catagory_id) > 0) {
//             $totalLib += recurSearch2($user_data->company_id, $item->account_catagory_id, "Liabilities", $mainCurrency,$totalLib);
//        }
//        return $totalLib;
//    }

// Assets
$conn = new Connection();
$query = "SELECT * FROM account_catagory 
    LEFT JOIN chartofaccount ON account_catagory.account_catagory_id = chartofaccount.account_catagory 
    WHERE account_catagory.catagory  = ? AND chartofaccount.company_id = ?";
$result = $conn->Query($query, ["Assets", $user_data->company_id]);
$results = $result->fetchAll(PDO::FETCH_OBJ);
foreach ($results as $item) {
    $q = "SELECT * FROM account_money WHERE account_id = ? AND company_id = ?";
    $r = $conn->Query($q, [$item->chartofaccount_id, $user_data->company_id]);
    $RES = $r->fetchAll(PDO::FETCH_OBJ);
    $credit = 0;
    $debit = 0;
    $rate = 0;
    $Total = 0;
    foreach ($RES as $LID) {
        // get account currency details
        $acc_currency_data = $company->GetCurrencyDetails($LID->currency);
        $acc_currency = $acc_currency_data->fetch(PDO::FETCH_OBJ);
        if ($LID->currency != $mainCurrencyID) {
            $currency_exchange_data = $banks->getExchangeConversion($mainCurrency, $acc_currency->currency, $user_data->company_id);
            $currency_exchange = $currency_exchange_data->fetch(PDO::FETCH_OBJ);
            if ($currency_exchange->currency_from == $mainCurrency) {
                $rate = 1 / $currency_exchange->rate;
            } else {
                $rate = $currency_exchange->rate;
            }
        } else {
            $rate = 1;
        }
        if ($LID->ammount_type == "Crediet") {
            $credit += $LID->amount;
        } else {
            $debit += $LID->amount;
        }
        $debit *= $rate;
        $credit *= $rate;
        $Total = round($debit - $credit);
    }
    echo "<span class='Assets d-none'>$Total</span>";
    if (checkChilds($item->account_catagory_id) > 0) {
        recurSearch2($user_data->company_id, $item->account_catagory_id, "Assets", $mainCurrency);
    }
}

// $totalProfit = $totalRevenue - $totalExpense;

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
                    <strong id="totalprofit">Net Profit - 0</strong>
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

                <div class="card">
                    <div class="card-header">
                        <h3 class="header">Financial Terms List</h3>
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
                                            <th>Title</th>
                                            <th>Start</th>
                                            <th>End</th>
                                            <th>Date</th>
                                            <th>Current</th>
                                        </tr>
                                    </thead>
                                    <tbody id="currencyTable">
                                        <?php
                                        $counter = 1;
                                        foreach ($company_FT as $FT) {
                                            $dat = Date("Y-m-d", $FT->reg_date);
                                            echo "<tr>
                                                <td class='counter'>$counter</td>
                                                <td>$FT->fiscal_year_title</td>
                                                <td>$FT->fiscal_year_start</td>
                                                <td>$FT->fiscal_year_end</td>
                                                <td>$dat</td>
                                                <td>$FT->current</td>
                                            </tr>";
                                            $counter++;
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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

        // find total assets
        totalAssets = 0;
        $("span.Assets").each(function() {
            totalAssets = parseFloat($(this).text());
            // $(this).remove();
        });
        console.log(totalAssets);
        totalProfit = $("#totalprofit").text().toString()
        totalProfit = totalProfit.substr(totalProfit.lastIndexOf("-") + 1);
        $("#tprofit").text(totalProfit);

        $(".percent").on("blur", function() {
            percent = 0;
            if ($(this).val() <= 100 && $(this).val() > 0) {
                percent = $(this).val();
            } else {
                percent = 100;
                $(this).val(percent);
            }
            if ($(this).parent().parent().parent().children("div:last").children(".form-group").children("input").hasAttr('prev')) {
                prevValue = parseFloat($(this).parent().parent().parent().children("div:last").children(".form-group").children("input").attr("prev"));
                totalProfit += prevValue;
                profit = Math.round((percent / 100) * totalProfit);
                $(this).parent().parent().parent().children("div:last").children(".form-group").children("input").val(profit);
                $(this).parent().parent().parent().children("div:last").children(".form-group").children("input").attr("prev", profit);
                totalProfit = totalProfit - profit;
                $("#tprofit").text(totalProfit);
            } else {
                profit = Math.round((percent / 100) * totalProfit);
                $(this).parent().parent().parent().children("div:last").children(".form-group").children("input").val(profit);
                $(this).parent().parent().parent().children("div:last").children(".form-group").children("input").attr("prev", profit);
                $("#tprofit").text(profit - totalProfit);
                totalProfit = totalProfit - profit;
            }
        });

        // Add financial year
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