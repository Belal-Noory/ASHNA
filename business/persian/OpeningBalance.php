<style>
    .balancehover:hover {
        font-weight: bold;
        color: white;
    }
</style>
<?php
$Active_nav_name = array("parent" => "Accounting", "child" => "Opening Balance");
$page_title = "Opening Balance";
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

$company_FT_data = $company->getCompanyFT($user_data->company_id);
$company_FT = $company_FT_data->fetchAll(PDO::FETCH_OBJ);

$term_id = 0;
foreach ($company_FT as $FT) {
    if ($FT->current == 1) {
        $term_id = $FT->term_id;
        break;
    }
}

echo $term_id;

$Assest_accounts_data = $banks->getAssetsAccounts(['Bank', 'Cash Register', 'Petty Cash', 'Accounts Receivable', 'notes receivable', $user_data->company_id]);
$Assest_accounts = $Assest_accounts_data->fetchAll(PDO::FETCH_OBJ);

$liblities_accounts_data = $banks->getLiabilitiesAccounts(['Accounts Payable', 'Notes payable', $user_data->company_id]);
$liblities_accounts = $liblities_accounts_data->fetchAll(PDO::FETCH_OBJ);

$equity_accounts_data = $banks->getEqityAccounts(['Capital', $user_data->company_id]);
$equity_accounts = $equity_accounts_data->fetchAll(PDO::FETCH_OBJ);

function recurSearch2($c, $parentID, $catanme,$term_id)
{
    $conn = new Connection();
    $query = "SELECT * FROM account_catagory 
    LEFT JOIN chartofaccount ON account_catagory.account_catagory_id = chartofaccount.account_catagory 
    WHERE account_catagory.parentID = ? AND chartofaccount.company_id = ? ORDER BY chartofaccount.chartofaccount_id ASC";
    $result = $conn->Query($query, [$parentID, $c]);
    $results = $result->fetchAll(PDO::FETCH_OBJ);
    foreach ($results as $item) {
        $total = 0;
        $q = "SELECT * FROM account_money 
        INNER JOIN general_leadger ON general_leadger.leadger_id = account_money.leadger_ID 
        WHERE account_money.detials = ? AND account_money.account_id = ? AND account_money.company_id = ? AND general_leadger.company_financial_term_id = ?";
        $r = $conn->Query($q, ["Opening Balance", $item->chartofaccount_id, $c,$term_id]);
        $RES = $r->fetchAll(PDO::FETCH_OBJ);
        foreach ($RES as $LID) {
            if ($LID->rate != 0) {
                $total += ($LID->amount * $LID->rate);
            } else {
                $total += $LID->amount;
            }
        }
        $total = round($total);
        echo "<a href='#' class='list-group-item list-group-item-action balancehover d-flex justify-content-evenly' catName='$catanme' id='$item->account_catagory' catID='$item->account_catagory_id' uadded='$item->useradded' pID='$item->account_kind' style='background-color: transparent;color:rgba(0,0,0,.5);' aria-current='true'>
                <span style='margin-right:auto'>$item->account_name</span>
                <span class='total'>$total</span>
            </a>";
        $total = 0;
        if (checkChilds($item->account_catagory_id) > 0) {
            recurSearch2($c, $item->account_catagory_id, $catanme,$term_id);
        }
    }
}

function recurSearchCapital($c, $parentID, $amount_type, $catanme,$term_id)
{
    $conn = new Connection();
    $query = "SELECT * FROM account_catagory 
    LEFT JOIN chartofaccount ON account_catagory.account_catagory_id = chartofaccount.account_catagory 
    WHERE account_catagory.parentID = ? AND chartofaccount.company_id = ? ORDER BY chartofaccount.chartofaccount_id ASC";
    $result = $conn->Query($query, [$parentID, $c]);
    $results = $result->fetchAll(PDO::FETCH_OBJ);
    $total = 0;
    foreach ($results as $item) {
        $q = "SELECT * FROM account_money 
        INNER JOIN general_leadger ON general_leadger.leadger_id = account_money.leadger_ID 
        WHERE account_money.detials = ? AND account_money.account_id = ? AND account_money.company_id = ? AND general_leadger.company_financial_term_id = ?";
        $r = $conn->Query($q, ["Opening Balance", $item->chartofaccount_id, $c,$term_id]);
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
        echo "<a href='#' class='list-group-item list-group-item-action balancehover d-flex justify-content-evenly' data-href='capital' catName='$catanme' id='$item->account_catagory' catID='$item->account_catagory_id' uadded='$item->useradded' pID='$item->account_kind' style='background-color: transparent;color:rgba(0,0,0,.5);' aria-current='true'>
                <span style='margin-right:auto'>$item->account_name</span>
                <span class='total'>$total</span>
            </a>";
        $total = 0;
        if (checkChilds($item->account_catagory_id) > 0) {
            recurSearchCapital($c, $item->account_catagory_id, $amount_type, $catanme,$term_id);
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
        <div class="card col-12">
            <div class="card-body d-flex justify-content-center align-items-center p-4">
                <div class="p-2 d-flex flex-column justify-content-center align-items-center" style="background-color: rgba(26,179,148,.15); border-radius:10px">
                    <h2 style="color: #1ab394;">دارای ها</h2>
                    <span style="color:rgba(0,0,0,.5);" id="assettotal"></span>
                </div>
                <span style="font-size: 30px;" class="mx-2">=</span>
                <div class="p-2 d-flex flex-column justify-content-center align-items-center" style="background-color: rgba(237,85,101,.15); border-radius:10px">
                    <h2 style="color: #ed5565;">بدهی ها</h2>
                    <span style="color:rgba(0,0,0,.5);" id="libtotal"></span>
                </div>
                <span style="font-size: 30px;" class="mx-2">+</span>
                <div class="p-2 d-flex flex-column justify-content-center align-items-center" style="background-color: rgba(28,132,198,.15); border-radius:10px">
                    <h2 style="color: #1c84c6;">حقوق صاحبان سهام</h2>
                    <span style="color:rgba(0,0,0,.5);" id="eqalltotal"></span>
                </div>
            </div>
        </div>
        <div class="card col-xs-12 col-md-6" style="background-color: rgba(26,179,148,.15);">
            <div class="card-content">
                <div class="card-body p-2">
                    <h5 class="card-title" style="color: #1ab394;">دارای ها</h5>
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
                            $q = "SELECT * FROM account_money 
                            INNER JOIN general_leadger ON general_leadger.leadger_id = account_money.leadger_ID 
                            WHERE account_money.detials = ? AND account_money.account_id = ? AND account_money.company_id = ? AND general_leadger.company_financial_term_id = ?";
                            $r = $conn->Query($q, ["Opening Balance", $item->chartofaccount_id, $user_data->company_id,$term_id]);
                            $RES = $r->fetchAll(PDO::FETCH_OBJ);
                            foreach ($RES as $LID) {
                                if ($LID->rate != 0) {
                                    $total += ($LID->amount * $LID->rate);
                                } else {
                                    $total += $LID->amount;
                                }
                            }
                            echo "<a href='#' class='list-group-item list-group-item-action balancehover d-flex justify-content-evenly' data-href='assets' catName='assets' id='$item->account_catagory' catID='$item->account_catagory_id' uadded='$item->useradded' pID='$item->account_kind' style='background-color: transparent;color:rgba(0,0,0,.5);' aria-current='true'>
                                            <span style='margin-right:auto'>$item->account_name</span>
                                            <span class='total'>$total</span>
                                        </a>";
                            $total = 0;
                            if (checkChilds($item->account_catagory_id) > 0) {
                                recurSearch2($user_data->company_id, $item->account_catagory_id,'assets',$term_id);
                            }
                        }
                        ?>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-evenly" id="assum" style="background-color: transparent; color: rgba(0,0,0,.5);" aria-current="true">
                            <span style="margin-right:auto">مجموعه</span>
                            <span id="aassum"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column col-sm-12 col-md-6">
            <div class="card col-xs-12" style="background-color: rgba(237,85,101,.15);">
                <div class="card-content">
                    <div class="card-body p-2">
                        <h5 class="card-title" style="color: #ed5565">بدهی ها</h5>
                        <div class="list-group list-group-flush" id="liabilities">
                            <?php
                            $conn = new Connection();
                            $query = "SELECT * FROM account_catagory 
                         LEFT JOIN chartofaccount ON account_catagory.account_catagory_id = chartofaccount.account_catagory 
                         WHERE account_catagory.catagory  = ? AND chartofaccount.company_id = ? ORDER BY chartofaccount.chartofaccount_id ASC";
                            $result = $conn->Query($query, ["Liabilities", $user_data->company_id]);
                            $results = $result->fetchAll(PDO::FETCH_OBJ);
                            $acc_kind = "";
                            foreach ($results as $item) {
                                $total = 0;
                                $q = "SELECT * FROM account_money 
                                INNER JOIN general_leadger ON general_leadger.leadger_id = account_money.leadger_ID 
                                WHERE account_money.detials = ? AND account_money.account_id = ? AND account_money.company_id = ? 
                                AND general_leadger.company_financial_term_id = ?";
                                $r = $conn->Query($q, ["Opening Balance", $item->chartofaccount_id,$user_data->company_id,$term_id]);
                                $RES = $r->fetchAll(PDO::FETCH_OBJ);
                                foreach ($RES as $LID) {
                                    if ($LID->rate != 0) {
                                        $total += ($LID->amount * $LID->rate);
                                    } else {
                                        $total += $LID->amount;
                                    }
                                }
                                echo "<a href='#' class='list-group-item list-group-item-action balancehover d-flex justify-content-evenly' data-href='liblities' catName='lib' id='$item->account_catagory' catID='$item->account_catagory_id' uadded='$item->useradded' pID='$item->account_kind' style='background-color: transparent;color:rgba(0,0,0,.5);' aria-current='true'>
                                            <span style='margin-right:auto'>$item->account_name</span>
                                            <span class='total'>$total</span>
                                        </a>";
                                $total = 0;
                                if (checkChilds($item->account_catagory_id) > 0) {
                                    recurSearch2($user_data->company_id, $item->account_catagory_id, 'lib',$term_id);
                                }
                            }
                            ?>
                            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-evenly" id="libsum" style="background-color: transparent; color: rgba(0,0,0,.5);" aria-current="true">
                                <span style="margin-right:auto">مجموعه</span>
                                <span id="libsumm"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card col-xs-12" style="background-color: rgba(28,132,198,.15);">
                <div class="card-content">
                    <div class="card-body p-2">
                        <h5 class="card-title" style="color: #1c84c6">حقوق صاحبان سهام</h5>
                        <div class="list-group list-group-flush" id="equity">
                            <?php
                            $conn = new Connection();
                            $query = "SELECT * FROM account_catagory 
                          LEFT JOIN chartofaccount ON account_catagory.account_catagory_id = chartofaccount.account_catagory 
                          WHERE account_catagory.catagory  = ? AND chartofaccount.company_id = ? ORDER BY chartofaccount.chartofaccount_id ASC";
                            $result = $conn->Query($query, ["Equity", $user_data->company_id]);
                            $results = $result->fetchAll(PDO::FETCH_OBJ);
                            $acc_kind = "";
                            foreach ($results as $item) {
                                $total = 0;
                                $q = "SELECT * FROM account_money 
                                INNER JOIN general_leadger ON general_leadger.leadger_id = account_money.leadger_ID 
                                WHERE account_money.detials = ? AND account_money.account_id = ? AND account_money.company_id = ? AND general_leadger.company_financial_term_id = ?";
                                $r = $conn->Query($q, ["Opening Balance", $item->chartofaccount_id, $user_data->company_id,$term_id]);
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
                                echo "<a href='#' class='list-group-item list-group-item-action balancehover d-flex justify-content-evenly' data-href='capital' catName='cap' id='$item->account_catagory' catID='$item->account_catagory_id' uadded='$item->useradded' pID='$item->account_kind' style='background-color: transparent;color:rgba(0,0,0,.5);' aria-current='true'>
                                             <span style='margin-right:auto'>$item->account_name</span>
                                             <span class='total'>$total</span>
                                         </a>";
                                if (checkChilds($item->account_catagory_id) > 0) {
                                    recurSearchCapital($user_data->company_id, $item->account_catagory_id, "Crediet", 'cap',$term_id);
                                }
                            }
                            ?>
                            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-evenly" data-href="capital" id="capsum" style="background-color: transparent; color: rgba(0,0,0,.5);" aria-current="true">
                                <span style="margin-right:auto">مجموعه</span>
                                <span id="capsums"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade text-center" id="show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body p-2">
                <div class="p-4 d-flex justify-content-evenly">
                    <div style="margin-right: auto;" class="d-flex">
                        <button type="button" id="btnback" onclick="$('#show').modal('hide')" class="btn btn-icon btn-rounded btn-dark mr-1 mb-1 waves-effect waves-light text-white"><i class="la la-arrow-left"></i></button>
                        <h2 id="balancetitle">عنوان</h2>
                    </div>
                    <button type="button" id="btnaddrow" class="btn btn-icon btn-dark mr-1 mb-1 waves-effect waves-light"><i class="la la-plus text-white"></i></button>
                    <button type="button" id="btnsave" class="btn btn-icon btn-primary mr-1 mb-1 waves-effect waves-light"><i class="la la-save text-white"></i><span class="la la-spinner spinner d-none text-white"></span></button>
                    <button type="button" id="btndeleteall" class="btn btn-icon btn-danger mr-1 mb-1 waves-effect waves-light"><i class="la la-trash text-white"></i></button>
                </div>
                <form id="BalanceForm">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th id="header">حساب</th>
                                    <th class="modelcurrencyParent d-none">اسعار</th>
                                    <th>مبلغ</th>
                                    <th>حذب</th>
                                </tr>
                            </thead>
                            <tbody id="tbabalance">
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <select id="account" class="form-control accounts required" name="account"></select>
                                    </td>
                                    <td class="d-none">
                                        <select type="text" id="modelcurrency" class="form-control modelcurrency" placeholder="Currency" name="modelcurrency">
                                            <option value="0" selected>انتخاب</option>
                                            <?php
                                            foreach ($allcurrency as $currency) {
                                                echo "<option value='$currency->company_currency_id'>$currency->currency</option>";
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="bamount" id="bamount" placeholder="Amount" class="form-control required bamount">
                                    </td>
                                    <td></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <input type="hidden" name="rowCount" id="rowCount" value="1">
                    <input type="hidden" name="currency" id="balancecurrency">
                    <input type="hidden" name="amount_type" id="amount_type" value="Debet">
                    <input type="hidden" name="parent" id="parent" value="">
                    <input type="hidden" name="addbalance" id="addbalance">
                </form>

                <!-- list opening balance -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="header">بیلانس افتتاحیه</h5>
                        <a class="heading-elements-toggle">
                            <i class="la la-ellipsis-v font-medium-3"></i>
                        </a>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <table class="table material-table" id="balancesTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>حساب</th>
                                        <th>اسعار</th>
                                        <th>مبلغ</th>
                                        <th>حذب</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
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
        tblBalances = $("#balancesTable").DataTable();
        // ============================= Assets =================================
        // hid all banks
        banksTotal = 0;
        $("#assets").children("a[pid='Bank']").each(function() {
            total = parseFloat($(this).children(".total").text());
            banksTotal += total;
        });

        $("#assets").children("a[pid='Bank']").first().children("span:last-child").text(banksTotal);
        $("#assets").children("a[pid='Bank']").not(':first').remove();

        // hid all Saifs
        saifTotal = 0;
        $("#assets").children("a[pid='Cash Register']").each(function() {
            total = parseFloat($(this).children(".total").text());
            saifTotal += total;
        });

        $("#assets").children("a[pid='Cash Register']").first().children("span:last-child").text(saifTotal);
        $("#assets").children("a[pid='Cash Register']").not(':first').remove();

        // get receivable accounts
        totalReceivableAccs = 0;
        $(".balancehover[catid = '17']").each(function() {
            total = parseFloat($(this).children(".total").text());
            totalReceivableAccs += total;
        });
        $(".balancehover[id = '17']").children("span:last-child").text(totalReceivableAccs);

        // hide all customers
        $("#assets").children("a[pid='Individual']").remove();
        $("#assets").children("a[pid='MSP']").remove();
        $("#assets").children("a[pid='Share holders']").remove();
        $("#assets").children("a[pid='Legal Entity']").remove();
        $("#16").remove();

        assetsTotal = 0;
        $("#assets").children("a").each(function() {
            if ($(this).attr("id") !== "assum") {
                total = parseFloat($(this).children(".total").text());
                assetsTotal += total;
            }
        });
        $("#assettotal").text(assetsTotal);
        $("#aassum").text(assetsTotal);

        $("#assets").children("a").each(function() {
            if ($(this).attr("id") !== "assum") {
                txt = $(this).children("span:first-child").text();
                if (txt !== "Bank" && txt !== "Cash Register" && txt !== "Petty Cash" && txt !== "Accounts Receivable" && txt !== "notes receivable") {
                    $(this).remove();
                }
            }
        });


        // ================================= Liblitites ===================================
        libtotal = 0;
        $("#liabilities").children("a").each(function() {
            if ($(this).attr("id") !== "libsum") {
                txt = $(this).children("span:first-child").text();
                if (txt !== "Accounts Payable") {
                    $(this).remove();
                } else {
                    ID = $(this).attr("id");
                    // get Payable accounts
                    $.get("../app/Controllers/banks.php", {
                        getPayableAccounts: true,
                        cat: ID
                    }, function(data) {
                        total = parseFloat(data);
                        libtotal = parseFloat(total);
                        $("#liabilities a[catid='43']").children("span:last-child").text(total);
                        $("#libtotal").text(libtotal + " " + mainCurrency);
                        $("#libsumm").text(libtotal + " " + mainCurrency);

                    });
                }
            }
        });

        // ================================ Capital =======================================
        captotal = 0;
        $("#equity").children("a").each(function() {
            if ($(this).attr("id") !== "capsum") {
                total = parseFloat($(this).children(".total").text());
                captotal += total;
            }
        });
        $("#capsums").text(captotal);
        $("#eqalltotal").text(captotal);

        let tbabalance = $("#tbabalance");

        eqtotal = 0;
        $(".eqtotal").each(function(i, obj) {
            eqtotal += parseFloat($(obj).text());
        });
        $("#eqtotal").text(eqtotal + " " + mainCurrency);
        $("#eqsum span:nth-child(2)").text(eqtotal + " " + mainCurrency);

        $(document).on("click", ".balancehover", function(e) {
            e.preventDefault();
            ths = $(this);
            acc_id = $(ths).attr("id");
            catname = $(this).attr("catName");
            $("#parent").val(catname);
            if ($(ths).attr("data-href") !== "capital") {
                $("#balancetitle").text("Opening Balance - " + $(ths).children("span:first").text());
                $("#account").html("");
                $("#account").append("<option value='0' selected></option>");
                bcurryncy = $(this).attr("data-href");
                console.log(acc_id);
                $.get("../app/Controllers/banks.php", {
                    getcompanyAccount: true,
                    type: acc_id
                }, function(data) {
                    ndata = $.parseJSON(data);
                    // accounts
                    accounts = Array();
                    ndata.forEach(element => {
                        option = "<option value='" + element.chartofaccount_id + "' data-href='" + element.currency + "'>" + element.account_name + "</option>";
                        accounts.push(element.chartofaccount_id);
                        $("#account").append(option);
                    });

                    type = "Debet";
                    if ($(ths).children("span:first").text() == "Accounts Receivable" || $(ths).children("span:first").text() == "Accounts Payable") {
                        if ($(ths).children("span:first").text() == "Accounts Payable") {
                            $(".modelcurrency").parent().removeClass("d-none");
                            $(".modelcurrencyParent").removeClass("d-none");
                            $("#amount_type").val("Crediet");
                            type = "Crediet";
                        } else {
                            $("#amount_type").val("Debet");
                            type = "Debet";
                        }
                        $(".modelcurrency").parent().removeClass("d-none");
                        $(".modelcurrencyParent").removeClass("d-none");
                    } else {
                        $(".modelcurrency").parent().addClass("d-none");
                        $(".modelcurrencyParent").addClass("d-none");
                        type = "Debet";
                    }

                    // get accounts opening balance
                    tblBalances.clear();
                    $.get("../app/Controllers/banks.php", {
                        getAccountsOpeningBalance: true,
                        accounts: JSON.stringify(accounts),
                        type: type
                    }, function(data) {
                        console.log(data);
                        ndata = $.parseJSON(data);
                        counter = 1;
                        tblBalances.clear().draw(false);
                        ndata.forEach(element => {
                            if (element != 0) {
                                btn = `<a href='#' data-href='${element.leadger_id}' class='btndeleteop'><span class='las la-trash text-danger la-2x'></span></a>`;
                                tblBalances.row.add([counter, element.account_name, element.currency, element.amount, btn]).draw(false);
                                counter++;
                            }
                        });
                        counter = 1;
                    });

                    $("#show").modal({
                        backdrop: 'static',
                        keyboard: false
                    }, "show");
                });
            }
        });

        rowCount = 1;
        fieldCounts = 1;

        // on model hide
        $('#show').on('hidden.bs.modal', function() {
            $("#tbabalance").children("tr").not("tr:first").remove();
            rowCount = 2;
            fieldCounts = 1;
        });

        // add row to table
        $("#btnaddrow").on("click", function(e) {
            e.preventDefault();
            account = "account" + fieldCounts;
            amount = "bamount" + fieldCounts;
            crncies = "modelcurrency" + fieldCounts;
            $accounts = $("#account").html();
            $crncy = $("#modelcurrency").html();

            // type
            type = $("#balancetitle").text();

            rowCount++;
            row = ` <tr>
                        <td>${rowCount}</td>
                        <td>
                            <select id="${account}" class="form-control required accounts" name="${account}">
                                ${$accounts}
                            </select>
                        </td>`;
            if (type.indexOf("Accounts Payable") > 0 || type.indexOf("Accounts Receivable") > 0) {
                row += `<td>
                            <select type="text" id="modelcurrency" class="form-control modelcurrency" placeholder="Currency" name="${crncies}">
                                ${$crncy}
                            </select>
                        </td>`;

            }

            row += `<td>
                            <input type="number" name="${amount}" id="${amount}" placeholder="Amount" class="form-control required bamount">
                        </td>
                        <td>
                            <a href="#" class="deleteRow"><span class="las la-trash red" style="font-size: 25px;"></span></a>
                        </td>
                    </tr>`;
            $("#tbabalance").append(row);
            $("#rowCount").val(rowCount);
            fieldCounts++;
        });

        // delete single row
        $(document).on("click", ".deleteRow", function(e) {
            e.preventDefault();
            $(this).parent().parent().fadeOut();
            rowCount--;
            fieldCounts--;
        });

        // Delete all rows
        $("#btndeleteall").on("click", function(e) {
            e.preventDefault();
            $("#tbabalance").children("tr").not("tr:first").remove();
            rowCount = 1;
            fieldCounts = 1;
        });

        // save balance
        $("#btnsave").on("click", function(e) {
            e.preventDefault();
            ths = $(this);
            if ($("#BalanceForm").valid()) {
                $(ths).children(".la-save").hide();
                $(ths).children(".la-spinner").removeClass("d-none");
                // disable buttons while saving
                $(ths).attr("disabled", true);
                $("#btnaddrow").attr("disabled", true);
                $("#btndeleteall").attr("disabled", true);
                $("#btnback").attr("disabled", true);
                $.post("../app/Controllers/banks.php", $("#BalanceForm").serialize(), function(data) {
                    console.log(data);
                    $(ths).children(".la-save").show();
                    $(ths).children(".la-spinner").addClass("d-none");
                    $(ths).removeAttr("disabled");
                    $("#btnaddrow").removeAttr("disabled");
                    $("#btndeleteall").removeAttr("disabled");
                    $("#btnback").removeAttr("disabled");
                    $("#show").modal("hide");
                    $("#tbabalance").children('tr:not(:first)').remove();
                    $("#BalanceForm")[0].reset();
                    rowCount = 1;
                    fieldCounts = 1;
                });
            }
        })

        // Delete Opening Balance
        $(document).on("click", ".btndeleteop", function(e) {
            e.preventDefault();
            LID = $(this).attr("data-href");
            parent = $(this).parent().parent();
            $.confirm({
                icon: 'fa fa-smile-o',
                theme: 'modern',
                closeIcon: true,
                animation: 'scale',
                type: 'blue',
                title: 'Are you sure?',
                content: '',
                buttons: {
                    confirm: {
                        text: 'Yes',
                        action: function() {
                            $.post("../app/Controllers/banks.php", {
                                deleteOp: true,
                                LID: LID
                            }, function(data) {
                                if (data > 0) {
                                    tblBalances.row(parent).remove().draw(false);
                                }
                            });
                        }
                    },
                    cancel: {
                        text: 'No',
                        action: function() {}
                    }
                }
            });

        });
    });

    // Initialize validation
    $("#BalanceForm").validate({
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
        },
        rules: {
            email: {
                email: true
            }
        }
    });
</script>