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

function recurSearch2($c, $parentID, $selector)
{
    $conn = new Connection();
    $query = "SELECT * FROM account_catagory 
    INNER JOIN chartofaccount ON account_catagory.account_catagory_id = chartofaccount.account_catagory 
    WHERE account_catagory.parentID = ? AND chartofaccount.company_id = ?";
    $result = $conn->Query($query, [$parentID, $c]);
    $results = $result->fetchAll(PDO::FETCH_OBJ);
    foreach ($results as $item) {
        $q = "SELECT * FROM account_money WHERE account_id = ?";
        $r = $conn->Query($q, [$item->chartofaccount_id]);
        $RES = $r->fetchAll(PDO::FETCH_OBJ);
        $total = 0;
        foreach ($RES as $LID) {
            if ($LID->rate != 0) {
                $total += ($LID->amount * $LID->rate);
            } else {
                $total += $LID->amount;
            }
        }
        $icon = "";
        if (checkChilds($item->account_catagory_id) > 0) {
            $icon = "<button class='btn btn-blue btn-xs p-0'><span class='las la-plus'></span></button>";
        }
        $total = round($total);
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
        if (checkChilds($item->account_catagory_id) > 0) {
            recurSearch2($c, $item->account_catagory_id, $selector);
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
                            $query = "SELECT * FROM account_catagory 
                         LEFT JOIN chartofaccount ON account_catagory.account_catagory_id = chartofaccount.account_catagory 
                         WHERE account_catagory.catagory  = ? AND chartofaccount.company_id = ?";
                            $result = $conn->Query($query, ["Revenue", $user_data->company_id]);
                            $results = $result->fetchAll(PDO::FETCH_OBJ);
                            foreach ($results as $item) {
                                $q = "SELECT * FROM account_money WHERE account_id = ?";
                                $r = $conn->Query($q, [$item->chartofaccount_id]);
                                $RES = $r->fetchAll(PDO::FETCH_OBJ);
                                $total = 0;
                                foreach ($RES as $LID) {
                                    if ($LID->rate != 0) {
                                        $total += ($LID->amount * $LID->rate);
                                    } else {
                                        $total += $LID->amount;
                                    }
                                }
                                $icon = "";
                                if (checkChilds($item->account_catagory_id) > 0) {
                                    $icon = "<button class='btn btn-blue btn-xs p-0'><span class='las la-plus'></span></button>";
                                }
                                $total = round($total);
                                echo "<tr data-toggle='collapse' data-target='#child$item->account_catagory_id' class='accordion-toggle p-0 revenuerow'>
                                            <td>
                                                $icon
                                                <span>$item->account_name</span>
                                            </td>
                                            <td class='text-right revenue'>$total</td>
                                        </tr>";
                                $total = 0;
                                if (checkChilds($item->account_catagory_id) > 0) {
                                    recurSearch2($user_data->company_id, $item->account_catagory_id, "revenue");
                                }
                            }


                            $query = "SELECT * FROM account_catagory 
                         LEFT JOIN chartofaccount ON account_catagory.account_catagory_id = chartofaccount.account_catagory 
                         WHERE account_catagory.catagory  = ? AND chartofaccount.company_id = ?";
                            $result = $conn->Query($query, ["Expenses", $user_data->company_id]);
                            $results = $result->fetchAll(PDO::FETCH_OBJ);
                            foreach ($results as $item) {
                                $q = "SELECT * FROM account_money WHERE account_id = ?";
                                $r = $conn->Query($q, [$item->chartofaccount_id]);
                                $RES = $r->fetchAll(PDO::FETCH_OBJ);
                                $total = 0;
                                foreach ($RES as $LID) {
                                    if ($LID->rate != 0) {
                                        $total += ($LID->amount * $LID->rate);
                                    } else {
                                        $total += $LID->amount;
                                    }
                                }
                                $icon = "";
                                if (checkChilds($item->account_catagory_id) > 0) {
                                    $icon = "<button class='btn btn-blue btn-xs p-0'><span class='las la-plus'></span></button>";
                                }
                                $total = round($total);
                                echo "<tr data-toggle='collapse' data-target='#child$item->account_catagory_id' class='accordion-toggle p-0 expenserow'>
                                            <td>
                                                $icon
                                                <span>$item->account_name</span>
                                            </td>
                                            <td class='text-right expenses'>$total</td>
                                        </tr>";
                                $total = 0;
                                if (checkChilds($item->account_catagory_id) > 0) {
                                    recurSearch2($user_data->company_id, $item->account_catagory_id, "expenses");
                                }
                            }
                            ?>
                            <tr class="bg-info text-white">
                                <td>Profit</td>
                                <td class='text-right' id="ptotal"></td>
                            </tr>
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


        $("#ptotal").text((totalRev - totalEx));
    });
</script>