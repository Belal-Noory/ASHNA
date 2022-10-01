<?php
$Active_nav_name = array("parent" => "Reports", "child" => "All Reports");
$page_title = "Profit & Loss";
include("./master/header.php");

$company = new Company();
$bussiness = new Bussiness();
$banks = new Banks();

$bank = $banks->getBanks($user_data->company_id);
$saifs = $banks->getSaifs($user_data->company_id);

$allcurrency_data = $company->GetCompanyCurrency($user_data->company_id);
$allcurrency = $allcurrency_data->fetchAll(PDO::FETCH_OBJ);

$mainCurrency = "";
foreach ($allcurrency as $c) {
    $mainCurrency = $c->mainCurrency == 1 ? $c->currency : $mainCurrency;
}

function recurSearch2($c, $parentID, $selector,$mainC)
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
        $debit = 0;
        $credit = 0;
        $rate = 0;
        foreach ($RES as $LID) {
            // get account currency details
            $acc_currency_data = $company->GetCurrencyDetails($LID->currency);
            $acc_currency = $acc_currency_data->fetch(PDO::FETCH_OBJ);
            if($acc_currency->currency != $mainC){
                $currency_exchange_data = $banks->getExchangeConversion($mainC, $acc_currency->currency,$c);
                $currency_exchange = $currency_exchange_data->fetch(PDO::FETCH_OBJ);
                if($currency_exchange->currency_from == $mainC)
                {
                    $rate = 1/$currency_exchange->rate;
                }
                else{
                    $rate = $currency_exchange->rate;
                }
            }
            
            if ($LID->ammount_type == "Crediet") {
                $credit += $LID->amount;
            } else {
                $debit += $LID->amount;
            }
        }
        $debit = $debit*$rate;
        $credit = $credit*$rate;
        $icon = "";
        if (checkChilds($item->account_catagory_id) > 0) {
            $icon = "<button class='btn btn-blue btn-xs p-0'><span class='las la-plus'></span></button>";
        }
        $total = round($debit - $credit);
        echo "<tr class='accordian-body collapse' id='child$item->parentID'>
                <td colspan='3' class='hiddenRow'>
                    <div data-toggle='collapse' class='accordion-toggle d-flex flex-row p-1 pl-5' data-target='#child$item->account_catagory_id'>
                        <div>
                            $icon
                            <span>$item->account_name</span>
                        </div>
                        <span class='text-right $selector' style='margin-left:auto'>$total</span>
                    </div>
                </td>
            </tr>";
        $total = 0;
        $debit = 0;
        $credit = 0;
        if (checkChilds($item->account_catagory_id) > 0) {
            recurSearch2($c, $item->account_catagory_id, $selector,$mainC);
        }
    }
}

function recurSearchLib($c, $parentID, $selector)
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
        $icon = "";
        if (checkChilds($item->account_catagory_id) > 0) {
            $icon = "<button class='btn btn-blue btn-xs p-0'><span class='las la-plus'></span></button>";
        }
        $total = round($debit - $credit);
        echo "<tr class='accordian-body collapse' data-href='$item->chartofaccount_id' id='child$item->parentID'>
                <td colspan='3' class='hiddenRow'>
                    <div data-toggle='collapse' class='accordion-toggle d-flex flex-row p-1 pl-5' data-target='#child$item->account_catagory_id'>
                        <div>
                            $icon
                            <span>$item->account_name</span>
                        </div>
                        <span class='text-right $selector' style='margin-left:auto'>$total</span>
                    </div>
                </td>
            </tr>";
        $total = 0;
        $debit = 0;
        $credit = 0;
        if (checkChilds($item->account_catagory_id) > 0) {
            recurSearchLib($c, $item->account_catagory_id, $selector);
        }
    }
}

function checkChilds($patne)
{
    $conn = new Connection();
    $query = "SELECT * FROM account_catagory WHERE parentID = ?";
    $result = $conn->Query($query, [$patne]);
    $results = $result->rowCount();
    return $results;
}

function recurSearchCapital($c, $parentID, $amount_type, $catanme)
{
    $conn = new Connection();
    $query = "SELECT * FROM account_catagory 
    LEFT JOIN chartofaccount ON account_catagory.account_catagory_id = chartofaccount.account_catagory 
    WHERE account_catagory.parentID = ? AND chartofaccount.company_id = ? ORDER BY chartofaccount.chartofaccount_id ASC";
    $result = $conn->Query($query, [$parentID, $c]);
    $results = $result->fetchAll(PDO::FETCH_OBJ);
    $total = 0;
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
        echo "<span class='capital d-none'>$total</span>";
        $total = 0;
        if (checkChilds($item->account_catagory_id) > 0) {
            recurSearchCapital($c, $item->account_catagory_id, $amount_type, $catanme);
        }
    }
}
?>
<style>
    .hiddenRow {
        padding: 0 !important;
    }
</style>

<div class="container mt-2">
    <div class="col-md-12">
        <div class="card panel-primary">
            <div class="card-content">
                <div class="card-body">
                    <table class="table table-condensed table-striped mt-1 p-0">
                        <tbody class="p-0">
                            <?php
                            $conn = new Connection();
                            // Revenue
                            $query = "SELECT * FROM account_catagory 
                         LEFT JOIN chartofaccount ON account_catagory.account_catagory_id = chartofaccount.account_catagory 
                         WHERE account_catagory.catagory  = ? AND chartofaccount.company_id = ?";
                            $result = $conn->Query($query, ["Revenue", $user_data->company_id]);
                            $results = $result->fetchAll(PDO::FETCH_OBJ);
                            foreach ($results as $item) {
                                $q = "SELECT * FROM account_money WHERE account_id = ? AND company_id = ?";
                                $r = $conn->Query($q, [$item->chartofaccount_id, $user_data->company_id]);
                                $RES = $r->fetchAll(PDO::FETCH_OBJ);
                                $debit = 0;
                                $credit = 0;
                                foreach ($RES as $LID) {
                                    if ($LID->ammount_type == "Crediet") {
                                        if ($LID->rate != 0) {
                                            $credit += ($LID->amount * $LID->rate);
                                        } else {
                                            $credit += $LID->amount;
                                        }
                                    } else {
                                        if ($LID->rate != 0) {
                                            $debit += ($LID->amount * $LID->rate);
                                        } else {
                                            $debit += $LID->amount;
                                        }
                                    }
                                }
                                $icon = "";
                                if (checkChilds($item->account_catagory_id) > 0) {
                                    $icon = "<button class='btn btn-blue btn-xs p-0'><span class='las la-plus'></span></button>";
                                }
                                $total = round($debit - $credit);
                                echo "<tr data-toggle='collapse' data-target='#child$item->account_catagory_id' class='accordion-toggle p-0 revenuerow'>
                                            <td>
                                                $icon
                                                <span>$item->account_name</span>
                                            </td>
                                            <td class='text-right revenue'>$total</td>
                                        </tr>";
                                $total = 0;
                                $debit = 0;
                                $credit = 0;
                                if (checkChilds($item->account_catagory_id) > 0) {
                                    recurSearch2($user_data->company_id, $item->account_catagory_id, "revenue",$mainCurrency);
                                }
                            }

                            //    Expenses
                            $query = "SELECT * FROM account_catagory 
                         LEFT JOIN chartofaccount ON account_catagory.account_catagory_id = chartofaccount.account_catagory 
                         WHERE account_catagory.catagory  = ? AND chartofaccount.company_id = ?";
                            $result = $conn->Query($query, ["Expenses", $user_data->company_id]);
                            $results = $result->fetchAll(PDO::FETCH_OBJ);
                            foreach ($results as $item) {
                                $q = "SELECT * FROM account_money WHERE account_id = ? AND company_id = ?";
                                $r = $conn->Query($q, [$item->chartofaccount_id, $user_data->company_id]);
                                $RES = $r->fetchAll(PDO::FETCH_OBJ);
                                $debit = 0;
                                $credit = 0;
                                foreach ($RES as $LID) {
                                    if ($LID->ammount_type == "Crediet") {
                                        if ($LID->rate != 0) {
                                            $credit += ($LID->amount * $LID->rate);
                                        } else {
                                            $credit += $LID->amount;
                                        }
                                    } else {
                                        if ($LID->rate != 0) {
                                            $debit += ($LID->amount * $LID->rate);
                                        } else {
                                            $debit += $LID->amount;
                                        }
                                    }
                                }
                                $icon = "";
                                if (checkChilds($item->account_catagory_id) > 0) {
                                    $icon = "<button class='btn btn-blue btn-xs p-0'><span class='las la-plus'></span></button>";
                                }
                                $total = round($debit - $credit);
                                echo "<tr data-toggle='collapse' data-target='#child$item->account_catagory_id' class='accordion-toggle p-0 expenserow'>
                                            <td>
                                                $icon
                                                <span>$item->account_name</span>
                                            </td>
                                            <td class='text-right expenses'>$total</td>
                                        </tr>";
                                $total = 0;
                                $debit = 0;
                                $credit = 0;
                                if (checkChilds($item->account_catagory_id) > 0) {
                                    recurSearch2($user_data->company_id, $item->account_catagory_id, "expenses",$mainCurrency);
                                }
                            }

                            // Liabilities
                            $query = "SELECT * FROM account_catagory 
                             LEFT JOIN chartofaccount ON account_catagory.account_catagory_id = chartofaccount.account_catagory 
                             WHERE account_catagory.catagory  = ? AND chartofaccount.company_id = ?";
                            $result = $conn->Query($query, ["Liabilities", $user_data->company_id]);
                            $results = $result->fetchAll(PDO::FETCH_OBJ);
                            foreach ($results as $item) {
                                $q = "SELECT * FROM account_money WHERE account_id = ? AND company_id = ?";
                                $r = $conn->Query($q, [$item->chartofaccount_id, $user_data->company_id]);
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
                                $icon = "";
                                if (checkChilds($item->account_catagory_id) > 0) {
                                    $icon = "<button class='btn btn-blue btn-xs p-0'><span class='las la-plus'></span></button>";
                                }
                                $total = round($debit - $credit);
                                echo "<tr data-toggle='collapse' data-href='$item->chartofaccount_id' data-target='#child$item->account_catagory_id' class='accordion-toggle p-0 Liabilitiesrow'>
                                                <td>
                                                    $icon
                                                    <span>$item->account_name</span>
                                                </td>
                                                <td class='text-right Liabilities'>$total</td>
                                            </tr>";
                                $total = 0;
                                $debit = 0;
                                $credit = 0;
                                if (checkChilds($item->account_catagory_id) > 0) {
                                    recurSearchLib($user_data->company_id, $item->account_catagory_id, "Liabilities",$mainCurrency);
                                }
                            }

                            // Assets
                            $query = "SELECT * FROM account_catagory 
                             LEFT JOIN chartofaccount ON account_catagory.account_catagory_id = chartofaccount.account_catagory 
                             WHERE account_catagory.catagory  = ? AND chartofaccount.company_id = ?";
                            $result = $conn->Query($query, ["Assets", $user_data->company_id]);
                            $results = $result->fetchAll(PDO::FETCH_OBJ);
                            foreach ($results as $item) {
                                $q = "SELECT * FROM account_money WHERE account_id = ? AND company_id = ?";
                                $r = $conn->Query($q, [$item->chartofaccount_id, $user_data->company_id]);
                                $RES = $r->fetchAll(PDO::FETCH_OBJ);
                                $debit = 0;
                                $credit = 0;
                                $rate = 0;
                                foreach ($RES as $LID) {
                                    // get account currency details
                                    $acc_currency_data = $company->GetCurrencyDetails($LID->currency);
                                    $acc_currency = $acc_currency_data->fetch(PDO::FETCH_OBJ);
                                    if($LID->currency != $mainCurrencyID){
                                        $currency_exchange_data = $banks->getExchangeConversion($mainCurrency, $acc_currency->currency,$user_data->company_id);
                                        $currency_exchange = $currency_exchange_data->fetch(PDO::FETCH_OBJ);
                                        if($currency_exchange->currency_from == $mainCurrency)
                                        {
                                            $rate = 1/$currency_exchange->rate;
                                        }
                                        else{
                                            $rate = $currency_exchange->rate;
                                        }
                                    }
                                    
                                    if ($LID->ammount_type == "Crediet") {
                                        $credit += $LID->amount;
                                    } else {
                                        $debit += $LID->amount;
                                    }
                                }
                                $debit = $debit*$rate;
                                $credit = $credit*$rate;
                                $icon = "";
                                if (checkChilds($item->account_catagory_id) > 0) {
                                    $icon = "<button class='btn btn-blue btn-xs p-0'><span class='las la-plus'></span></button>";
                                }
                                $total = round($debit - $credit);
                                echo "<tr data-toggle='collapse' data-target='#child$item->account_catagory_id' class='accordion-toggle p-0 Assetsrow'>
                                                <td>
                                                    $icon
                                                    <span>$item->account_name</span>
                                                </td>
                                                <td class='text-right Assets'>$total</td>
                                            </tr>";
                                $total = 0;
                                $debit = 0;
                                $credit = 0;
                                if (checkChilds($item->account_catagory_id) > 0) {
                                    recurSearch2($user_data->company_id, $item->account_catagory_id, "Assets",$mainCurrency);
                                }
                            }
                            ?>
                            <tr class="bg-info text-white">
                                <td>Initial Capital</td>
                                <td class='text-right' id="Icapital"></td>
                            </tr>
                            <tr class="bg-info text-white">
                                <td>Current Capital</td>
                                <td class='text-right' id="Ccapital"></td>
                            </tr>
                            <tr class="bg-info text-white">
                                <td>Profit/Loss</td>
                                <td class='text-right' id="ptotal"></td>
                            </tr>
                        </tbody>
                    </table>

                    <?php
                    $conn = new Connection();
                    $query = "SELECT * FROM account_catagory 
                          LEFT JOIN chartofaccount ON account_catagory.account_catagory_id = chartofaccount.account_catagory 
                          WHERE account_catagory.catagory  = ? AND chartofaccount.company_id = ? ORDER BY chartofaccount.chartofaccount_id ASC";
                    $result = $conn->Query($query, ["Equity", $user_data->company_id]);
                    $results = $result->fetchAll(PDO::FETCH_OBJ);
                    $acc_kind = "";
                    $total = 0;
                    foreach ($results as $item) {
                        $q = "SELECT * FROM account_money WHERE detials = ? AND account_id = ? AND company_id = ?";
                        $r = $conn->Query($q, ["Opening Balance", $item->chartofaccount_id, $user_data->company_id]);
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
                        echo "<span class='capital d-none'>$total</span>";
                        $total = 0;
                        if (checkChilds($item->account_catagory_id) > 0) {
                            recurSearchCapital($user_data->company_id, $item->account_catagory_id, "Crediet", 'cap');
                        }
                    }
                    ?>
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
        // all revenues
        totalRev = 0;
        $(".revenue").each(function() {
            totalRev += parseFloat($(this).text());
        });
        $(".revenuerow").children("td:last-child").text(totalRev);


        // all Expense
        totalEx = 0;
        $(".expenses").each(function() {
            totalEx += parseFloat($(this).text());
        });
        $(".expenserow").children("td:last-child").text(totalEx);

        // all Liabilities
        totalLib = 0;
        $(".Liabilities").each(function() {
            totalLib += parseFloat($(this).text());
        });
        $(".Liabilitiesrow").children("td:last-child").text(totalLib);

        // all Assets
        totalAss = 0;
        $(".Assets").each(function() {
            totalAss += parseFloat($(this).text());
        });
        $(".Assetsrow").children("td:last-child").text(totalAss);

        $("#ptotal").text(((totalRev + totalAss) - (totalEx + totalLib)));

        // Capital
        InitialCapital = 0;
        $(".capital").each(function() {
            InitialCapital += parseFloat($(this).text());
        });

        currenyCapital = totalAss - totalLib;

        $("#Icapital").text(InitialCapital);
        $("#Ccapital").text(currenyCapital);
        $("#ptotal").text((currenyCapital - InitialCapital));
    });
</script>