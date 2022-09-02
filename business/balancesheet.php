<?php
$Active_nav_name = array("parent" => "Reports", "child" => "All Reports");
$page_title = "Balance Sheet";
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
    LEFT JOIN chartofaccount ON account_catagory.account_catagory_id = chartofaccount.account_catagory 
    WHERE account_catagory.parentID = ? AND chartofaccount.company_id = ?";
    $result = $conn->Query($query, [$parentID, $c]);
    $results = $result->fetchAll(PDO::FETCH_OBJ);
    $total = 0;
    foreach ($results as $item) {
        $q = "SELECT * FROM general_leadger 
                                 LEFT JOIN account_money ON general_leadger.leadger_id = account_money.leadger_ID 
                                 WHERE general_leadger.recievable_id = ? OR general_leadger.payable_id = ?";
        $r = $conn->Query($q, [$item->chartofaccount_id, $item->chartofaccount_id]);
        $RES = $r->fetchAll(PDO::FETCH_OBJ);
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
        if($item->useradded === "0" || $item->useradded === 0)
        {
            echo "<a href='#' class='list-group-item list-group-item-action balancehover d-flex justify-content-evenly' id='$item->chartofaccount_id' style='background-color: transparent;color:rgba(0,0,0,.5);' aria-current='true'>
                                        <span style='margin-right:auto'>$item->account_name</span>
                                        <span class='total'>$total</span>
                                    </a>";
            $total = 0;
        }
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

<div class="container p-2">
    <div class="row">
        <span class="col d-flex bg-dark justify-content-center align-items-center p-1 m-1">
            <span style="color: #1ab394;">Assets</span>
            <span style="color:white; margin-left:auto" id="assettotal"></span>
        </span>
        <span class="col d-flex bg-dark justify-content-center align-items-center p-2 m-1">
            <span style="color: #ed5565;">Liabilities+Equity</span>
            <span style="color:white; margin-left:auto" id="libtotal">12323445</span>
        </span>
    </div>
    <div class="row mt-2">
        <div class="card col-xs-12 col-md-6" style="background-color: rgba(26,179,148,.15);">
            <div class="card-content">
                <div class="card-body p-2">
                    <h5 class="card-title" style="color: #1ab394;">Assets</h5>
                    <div class="list-group list-group-flush" id="assets">
                        <?php
                        $conn = new Connection();
                        $query = "SELECT * FROM account_catagory 
                         LEFT JOIN chartofaccount ON account_catagory.account_catagory_id = chartofaccount.account_catagory 
                         WHERE account_catagory.catagory  = ? AND chartofaccount.company_id = ? ORDER BY chartofaccount.chartofaccount_id ASC";
                        $result = $conn->Query($query, ["Assets", $user_data->company_id]);
                        $results = $result->fetchAll(PDO::FETCH_OBJ);
                        $acc_kind = "";
                        $total = 0;
                        foreach ($results as $item) {
                            $q = "SELECT * FROM general_leadger 
                                 LEFT JOIN account_money ON general_leadger.leadger_id = account_money.leadger_ID 
                                 WHERE general_leadger.recievable_id = ? OR general_leadger.payable_id = ?";
                            $r = $conn->Query($q, [$item->chartofaccount_id, $item->chartofaccount_id]);
                            $RES = $r->fetchAll(PDO::FETCH_OBJ);
                            foreach ($RES as $LID) {
                                if ($item->chartofaccount_id == $LID->account_id) {
                                    if ($LID->currency_rate != 0) {
                                        $total += ($LID->amount * $LID->currency_rate);
                                    } else {
                                        $total += $LID->amount;
                                    }
                                }
                            }
                            if($item->useradded === "0" || $item->useradded === 0)
                            {
                                echo "<a href='#' class='list-group-item list-group-item-action balancehover d-flex justify-content-evenly' id='$item->chartofaccount_id' style='background-color: transparent;color:rgba(0,0,0,.5);' aria-current='true'>
                                        <span style='margin-right:auto'>$item->account_name</span>
                                        <span class='total'>$total</span>
                                    </a>";
                                    $total = 0;
                            }
                            if (checkChilds($item->account_catagory_id) > 0) {
                                recurSearch2($user_data->company_id, $item->account_catagory_id);
                            }
                        }
                        ?>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-evenly" id="assum" style="background-color: transparent; color: rgba(0,0,0,.5);" aria-current="true">
                            <span style="margin-right:auto">Sum</span>
                            <span></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column col-sm-12 col-md-6">
            <div class="card col-xs-12" style="background-color: rgba(237,85,101,.15);">
                <div class="card-content">
                    <div class="card-body p-2">
                        <h5 class="card-title" style="color: #ed5565">Liabilities</h5>
                        <div class="list-group list-group-flush" id="libs">
                            <?php
                            $conn = new Connection();
                            $query = "SELECT * FROM account_catagory 
                         LEFT JOIN chartofaccount ON account_catagory.account_catagory_id = chartofaccount.account_catagory 
                         WHERE account_catagory.catagory  = ? AND chartofaccount.company_id = ? ORDER BY chartofaccount.chartofaccount_id ASC";
                            $result = $conn->Query($query, ["Liabilities", $user_data->company_id]);
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
                                        if ($LID->currency_rate != 0) {
                                            $total += ($LID->amount * $LID->currency_rate);
                                        } else {
                                            $total += $LID->amount;
                                        }
                                    }
                                }
                                echo "<a href='#' class='list-group-item list-group-item-action balancehover d-flex justify-content-evenly' id='$item->chartofaccount_id' style='background-color: transparent;color:rgba(0,0,0,.5);' aria-current='true'>
                                    <span style='margin-right:auto'>$item->account_name</span>
                                    <span class='total'>$total</span>
                                </a>";
                                $total = 0;
                                if (checkChilds($item->account_catagory_id) > 0) {
                                    recurSearch2($user_data->company_id, $item->account_catagory_id);
                                }
                            }
                            ?>
                            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-evenly" id="assum" style="background-color: transparent; color: rgba(0,0,0,.5);" aria-current="true">
                                <span style="margin-right:auto">Sum</span>
                                <span></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card col-xs-12" style="background-color: rgba(28,132,198,.15);">
                <div class="card-content">
                    <div class="card-body p-2">
                        <h5 class="card-title" style="color: #1c84c6">Equity</h5>
                        <div class="list-group list-group-flush" id="eq">
                            <?php
                            $conn = new Connection();
                            $query = "SELECT * FROM account_catagory 
                             LEFT JOIN chartofaccount ON account_catagory.account_catagory_id = chartofaccount.account_catagory 
                             WHERE account_catagory.catagory  = ? AND chartofaccount.company_id = ? ORDER BY chartofaccount.chartofaccount_id ASC";
                            $result = $conn->Query($query, ["Equity", $user_data->company_id]);
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
                                        if ($LID->currency_rate != 0) {
                                            $total += ($LID->amount * $LID->currency_rate);
                                        } else {
                                            $total += $LID->amount;
                                        }
                                    }
                                }
                                echo "<a href='#' class='list-group-item list-group-item-action balancehover d-flex justify-content-evenly' id='$item->chartofaccount_id' style='background-color: transparent;color:rgba(0,0,0,.5);' aria-current='true'>
                                        <span style='margin-right:auto'>$item->account_name</span>
                                        <span class='total'>$total</span>
                                    </a>";
                                $total = 0;
                                if (checkChilds($item->account_catagory_id) > 0) {
                                    recurSearch2($user_data->company_id, $item->account_catagory_id);
                                }
                            }
                            ?>
                            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-evenly" id="assum" style="background-color: transparent; color: rgba(0,0,0,.5);" aria-current="true">
                                <span style="margin-right:auto">Sum</span>
                                <span></span>
                            </a>
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
    $(document).ready(function() {
        totalAssets = 0;
        $("#assets").children("a").children(".total").each(function() {
            totalAssets += parseFloat($(this).text());
        })
        $("#assettotal").text(totalAssets);

        totalEq = 0;
        $("#eq").children("a").children(".total").each(function() {
            totalEq += parseFloat($(this).text());
        })

        $("#libs").children("a").children(".total").each(function() {
            totalEq += parseFloat($(this).text());
        })
        $("#libtotal").text(totalEq);
    });
</script>