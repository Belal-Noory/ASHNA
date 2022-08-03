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

$Assest_accounts_data = $banks->getAssetsAccounts(['Bank', 'Cash Register', 'Petty Cash', 'Accounts Receivable', 'notes receivable']);
$Assest_accounts = $Assest_accounts_data->fetchAll(PDO::FETCH_OBJ);

$liblities_accounts_data = $banks->getLiabilitiesAccounts(['Accounts Payable', 'Notes payable']);
$liblities_accounts = $liblities_accounts_data->fetchAll(PDO::FETCH_OBJ);

$equity_accounts_data = $banks->getEqityAccounts(['Capital']);
$equity_accounts = $equity_accounts_data->fetchAll(PDO::FETCH_OBJ);
?>

<div class="container p-2">
    <div class="row">
        <div class="card col-12">
            <div class="card-body d-flex justify-content-center align-items-center p-4">
                <div class="p-2 d-flex flex-column justify-content-center align-items-center" style="background-color: rgba(26,179,148,.15); border-radius:10px">
                    <h2 style="color: #1ab394;">Assets</h2>
                    <span style="color:rgba(0,0,0,.5);" id="assettotal"></span>
                </div>
                <span style="font-size: 30px;" class="mx-2">=</span>
                <div class="p-2 d-flex flex-column justify-content-center align-items-center" style="background-color: rgba(237,85,101,.15); border-radius:10px">
                    <h2 style="color: #ed5565;">Liabilities</h2>
                    <span style="color:rgba(0,0,0,.5);" id="libtotal">12323445</span>
                </div>
                <span style="font-size: 30px;" class="mx-2">+</span>
                <div class="p-2 d-flex flex-column justify-content-center align-items-center" style="background-color: rgba(28,132,198,.15); border-radius:10px">
                    <h2 style="color: #1c84c6;">Equity</h2>
                    <span style="color:rgba(0,0,0,.5);" id="eqtotal">12323445</span>
                </div>
            </div>
        </div>
        <div class="card col-xs-12 col-md-6" style="background-color: rgba(26,179,148,.15);">
            <div class="card-content">
                <div class="card-body p-2">
                    <h5 class="card-title" style="color: #1ab394;">Assets</h5>
                    <div class="list-group list-group-flush">
                        <?php
                        $prevAccount = "";
                        foreach ($Assest_accounts as $Assestaccounts) {
                            if ($prevAccount !== $Assestaccounts->account_name) {
                                $money_data = $banks->getAccountMoney($user_data->company_id, $Assestaccounts->chartofaccount_id);
                                $money = $money_data->fetch();
                                $total = $money['total'] == 0 ? 0 : $money['total'];
                        ?>
                                <a href="#" class="list-group-item list-group-item-action balancehover d-flex justify-content-evenly" id="<?php echo $Assestaccounts->chartofaccount_id; ?>" style="background-color: transparent;color:rgba(0,0,0,.5);" aria-current="true">
                                    <span style="margin-right:auto"><?php echo $Assestaccounts->account_name ?></span>
                                    <span class="assettotal"><?php echo $total . ' ' . $mainCurrency ?></span>
                                </a>
                        <?php }
                            $prevAccount = $Assestaccounts->account_name;
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
                        <div class="list-group list-group-flush">
                            <?php
                            $prevAccount = "";
                            foreach ($liblities_accounts as $Assestaccounts) {
                                if ($prevAccount != $Assestaccounts->account_name) {
                                    $money_data = $banks->getAccountMoney($user_data->company_id, $Assestaccounts->chartofaccount_id);
                                    $money = $money_data->fetch();
                                    $total = $money['total'] == 0 ? 0 : $money['total'];
                            ?>
                                    <a href="#" class="list-group-item list-group-item-action balancehover d-flex justify-content-evenly" id="<?php echo $Assestaccounts->chartofaccount_id; ?>" style="background-color: transparent;color: rgba(0,0,0,.5);" aria-current="true">
                                        <span style="margin-right:auto"><?php echo $Assestaccounts->account_name ?></span>
                                        <span class="libtotal"><?php echo $total . ' ' . $mainCurrency ?></span>
                                    </a>
                            <?php }
                                $prevAccount = $Assestaccounts->account_name;
                            } ?>
                            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-evenly" id="libsum" style="background-color: transparent; color: rgba(0,0,0,.5);" aria-current="true">
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
                        <div class="list-group list-group-flush">
                            <?php
                            $prevAccount = "";
                            foreach ($equity_accounts as $Assestaccounts) {
                                if ($prevAccount != $Assestaccounts->account_name) {
                                    $money_data = $banks->getAccountMoney($user_data->company_id, $Assestaccounts->chartofaccount_id);
                                    $money = $money_data->fetch();
                                    $total = $money['total'] == 0 ? 0 : $money['total'];
                            ?>
                                    <a href="#" class="list-group-item list-group-item-action balancehover d-flex justify-content-evenly" id="<?php echo $Assestaccounts->chartofaccount_id; ?>" style="background-color: transparent; color: rgba(0,0,0,.5);" aria-current="true">
                                        <span style="margin-right:auto"><?php echo $Assestaccounts->account_name ?></span>
                                        <span class="eqtotal"><?php echo $total . ' ' . $mainCurrency ?></span>
                                    </a>
                            <?php }
                                $prevAccount = $Assestaccounts->account_name;
                            } ?>
                            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-evenly" id="eqsum" style="background-color: transparent; color: rgba(0,0,0,.5);" aria-current="true">
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


<!-- Modal -->
<div class="modal fade text-center" id="show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body p-2">
                <div class="p-4 d-flex justify-content-evenly">
                    <div style="margin-right: auto;" class="d-flex">
                        <button type="button" id="btnback" onclick="$('#show').modal('hide')" class="btn btn-icon btn-rounded btn-dark mr-1 mb-1 waves-effect waves-light text-white"><i class="la la-arrow-left"></i></button>
                        <h2 id="balancetitle">title</h2>
                    </div>
                    <button type="button" id="btnaddrow" class="btn btn-icon btn-dark mr-1 mb-1 waves-effect waves-light"><i class="la la-plus text-white"></i></button>
                    <button type="button" id="btnsave" class="btn btn-icon btn-primary mr-1 mb-1 waves-effect waves-light"><i class="la la-save text-white"></i><span class="la la-spinner spinner d-none text-white"></span></button>
                    <button type="button" id="btndeleteall" class="btn btn-icon btn-danger mr-1 mb-1 waves-effect waves-light"><i class="la la-trash text-white"></i></button>
                </div>
                <form>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th id="header">Account</th>
                                    <th>Amount</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody id="tbabalance">
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <select id="account" class="form-control" name="account"></select>
                                    </td>
                                    <td>
                                        <input type="number" name="bamount" id="bamount" placeholder="Amount" class="form-control">
                                    </td>
                                    <td>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <input type="hidden" name="rowCount" id="rowCount" value="1">
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
        let tbabalance = $("#tbabalance");

        libtotal = 0;
        $(".libtotal").each(function(i, obj) {
            libtotal += parseFloat($(obj).text());
        });
        $("#libtotal").text(libtotal + " " + mainCurrency);
        $("#libsum span:nth-child(2)").text(libtotal + " " + mainCurrency);

        eqtotal = 0;
        $(".eqtotal").each(function(i, obj) {
            eqtotal += parseFloat($(obj).text());
        });
        $("#eqtotal").text(eqtotal + " " + mainCurrency);
        $("#eqsum span:nth-child(2)").text(eqtotal + " " + mainCurrency);

        assetsTotal = 0;
        $(".assettotal").each(function(i, obj) {
            assetsTotal += parseFloat($(obj).text());
        });
        $("#assettotal").text((assetsTotal + libtotal + eqtotal) + " " + mainCurrency);
        $("#assum span:nth-child(2)").text(assetsTotal + " " + mainCurrency);

        $(document).on("click", ".balancehover", function(e) {
            e.preventDefault();
            ths = $(this);
            acc_id = $(ths).attr("id");
            $("#balancetitle").text("Opening Balance - " + $(ths).text());
            $("#account").html("");
            $("#account").append("<option value='0' selected></option>");
            $.get("../app/Controllers/banks.php", {
                getcompanyAccount: true,
                type: acc_id
            }, function(data) {
                ndata = $.parseJSON(data);
                ndata.forEach(element => {
                    option = "<option value='" + element.chartofaccount_id + "'>" + element.account_name + "</option>";
                    $("#account").append(option);
                });
                $("#show").modal({
                    backdrop: 'static',
                    keyboard: false
                }, "show");
            });
        });

        rowCount = 2;
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
            $accounts = $("#account").html();
            row = ` <tr>
                        <td>${rowCount}</td>
                        <td>
                            <select id="${account}" class="form-control" name="${account}">
                                ${$accounts}
                            </select>
                        </td>
                        <td>
                            <input type="number" name="${amount}" id="${amount}" placeholder="Amount" class="form-control">
                        </td>
                        <td>
                            <a href="#" class="deleteRow"><span class="las la-trash red" style="font-size: 25px;"></span></a>
                        </td>
                    </tr>`;
            $("#tbabalance").append(row);
            $("#rowCount").val(rowCount);
            rowCount++;
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
            $("#tbabalance").children("tr").not("tr:first").remove()
        });

        // save balance
        $("#btnsave").on("click", function(e) {
            e.preventDefault();
            ths = $(this);
            $(ths).children(".la-save").hide();
            $(ths).children(".la-spinner").removeClass("d-none");

            // disable buttons while saving
            $(ths).attr("disabled", '');
            $("#btnaddrow").attr("disabled", '');
            $("#btndeleteall").attr("disabled", '');
            $("#btnback").attr("disabled", '');
        })

    });

    // Initialize validation
    $("#addbankBalanceForm, #addcusBalanceForm, #addsaifBalanceForm").validate({
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