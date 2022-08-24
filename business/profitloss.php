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

function recurSearch2($c, $parentID)
{
    $conn = new Connection();
    $query = "SELECT * FROM account_catagory 
    INNER JOIN chartofaccount ON account_catagory.account_catagory_id = chartofaccount.account_catagory 
    WHERE account_catagory.parentID = ? AND account_catagory.company_id = ?";
    $result = $conn->Query($query, [$parentID, $c]);
    $results = $result->fetchAll(PDO::FETCH_OBJ);
    foreach ($results as $item) {
        $q = "SELECT * FROM general_leadger 
                                 LEFT JOIN account_money ON general_leadger.leadger_id = account_money.leadger_ID 
                                 WHERE general_leadger.recievable_id = ? OR general_leadger.payable_id = ?";
        $r = $conn->Query($q, [$item->chartofaccount_id, $item->chartofaccount_id]);
        $RES = $r->fetchAll(PDO::FETCH_OBJ);
        $total = 0;
        foreach ($RES as $LID) {
            if ($item->chartofaccount_id == $LID->account_id) {
                if ($LID->op_type != "Bank Exchange") {
                    if ($LID->currency_rate != 0) {
                        $total += ($LID->amount * $LID->currency_rate);
                    } else {
                        $total += $LID->amount;
                    }
                } else {
                    if ($LID->currency_rate != 0) {
                        $total += ($LID->amount * $LID->currency_rate);
                    } else {
                        $total += $LID->amount;
                    }
                }
            }
        }
        echo "<a href='#' class='list-group-item list-group-item-action balancehover d-flex justify-content-evenly' id='$item->chartofaccount_id' style='background-color: transparent;color:rgba(0,0,0,.5);' aria-current='true'>
                                    <span style='margin-right:auto'>$item->account_name</span>
                                    <span class='total'>$total</span>
                                </a>";
        $total = 0;
        if (checkChilds($item->account_catagory_id) > 0) {
            recurSearch2($c, $item->account_catagory_id);
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

<div class="container">
    <div class="container">
        <div class="col-md-12">
            <div class="card panel-primary">
                <div class="card-content">
                    <div class="card-body">
                        <table class="table table-condensed table-striped mt-1 p-0">
                            <tbody class="p-0">
                                <tr data-toggle="collapse" data-target="#demo1" class="accordion-toggle p-0">
                                    <td>
                                        <button class="btn btn-blue btn-xs p-0"><span class="las la-plus"></span></button>
                                        <span>Account</span>
                                    </td>
                                    <td class="text-right">123123</td>
                                </tr>
                                <tr class="p-0">
                                    <td colspan="12" class="hiddenRow">
                                        <div class="accordian-body collapse" id="demo1">
                                            <table class="table table-striped">
                                                <tbody>
                                                    <tr data-toggle="collapse" class="accordion-toggle" data-target="#demo10">
                                                        <td>
                                                            <button class="btn btn-blue btn-xs p-0"><span class="las la-plus"></span></button>
                                                            <span>Account</span>
                                                        </td>
                                                        <td>123123</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include("./master/footer.php");
?>