<?php
$Active_nav_name = array("parent" => "Settings", "child" => "Archeive");
$page_title = "Archeive";
include("./master/header.php");

$bussiness = new Bussiness();
$company = new Company();
$bank = new Banks();

$company_curreny_data = $company->GetCompanyCurrency($user_data->company_id);
$company_curreny = $company_curreny_data->fetchAll(PDO::FETCH_OBJ);
$mainCurrency = "";
foreach ($company_curreny as $currency) {
    if ($currency->mainCurrency) {
        $mainCurrency = $currency->currency;
    }
}

$company_FT_data = $company->getCompanyActiveFT($user_data->company_id);
$company_ft = $company_FT_data->fetch(PDO::FETCH_OBJ);
$term_id = 0;
if (isset($company_ft->term_id)) {
    $term_id = $company_ft->term_id;
}

// get archeived/deleted leadgers
$deleted_data = $company->getDeletedLeadgers($user_data->company_id, $term_id);

?>

<style>
    .buttonhover {
        color: dodgerblue;
    }

    .buttonhover:hover {
        transform: scale(1.09);
    }
</style>

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-center">Archeived Transactions</h4>
                </div>
                <div class="card-content">
                    <div class="table-responsive p-1">
                        <table class="table table-hover material-table" id="tblarcheive">
                            <thead>
                                <tr>
                                    <th class="border-top-0">#</th>
                                    <th class="border-top-0">شماره حساب</th>
                                    <th class="border-top-0">حساب دریافتنی</th>
                                    <th class="border-top-0">حساب پرداختنی</th>
                                    <th class="border-top-0">نوعیت حساب</th>
                                    <th class="border-top-0">شرح</th>
                                    <th class="border-top-0">حذب شده توسط</th>
                                    <th class="border-top-0">بازگشت</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $counter = 1;
                                foreach ($deleted_data as $deleted) {
                                    $rece_data = $bank->getSystemAccount($deleted->recievable_id);
                                    $rece = $rece_data->fetch(PDO::FETCH_OBJ);
                                    $receClass = "";
                                    if($rece->cutomer_id != 0){
                                        $receClass = "cusKYC";
                                    }
                                    else{
                                        $receClass = "";
                                    }

                                    $pay_data = $bank->getSystemAccount($deleted->payable_id);
                                    $pay = $pay_data->fetch(PDO::FETCH_OBJ);
                                    $payClass = "";
                                    if($pay->cutomer_id != 0){
                                        $payClass = "cusKYC";
                                    }
                                    else{
                                        $payClass = "";
                                    }
                                    echo "<tr style='cursor:pointer'>
                                                <td>$counter</td>
                                                <td class='ldetails' data-href='$deleted->leadger_id'>$deleted->leadger_id</td>
                                                <td class='adetails $receClass' data-href='$rece->cutomer_id'>$rece->account_name</td>
                                                <td class='adetails $payClass' data-href='$pay->cutomer_id'>$pay->account_name</td>
                                                <td>$deleted->op_type</td>
                                                <td>$deleted->remarks</td>
                                                <td>$deleted->fname $deleted->lname</td>
                                                <td><span class='la la-refresh fa-2x buttonhover btnrestore' data-href='$deleted->leadger_id'></span></td>
                                            </tr>";
                                    $counter++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Content-->

<!-- leadger details Modal -->
<div class="modal fade text-center" id="showleadgerModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body p-2">
                <table class="table table-hover material-table" id="tblleadger">
                    <thead>
                        <tr>
                            <th class="border-top-0">#</th>
                            <th class="border-top-0">حساب</th>
                            <th class="border-top-0">شرح</th>
                            <th class="border-top-0">مبلغ</th>
                            <th class="border-top-0">دریافت</th>
                            <th class="border-top-0">پرداخت</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
include("./master/footer.php");
?>
<script>
    $(document).ready(function() {
        // tables
        tblarcheive = $("#tblarcheive").DataTable();
        tblleadger = $("#tblleadger").DataTable();

        // show leadger data
        $(document).on("click", ".ldetails", function() {
            lid = $(this).attr("data-href");
            $.get("../app/Controllers/banks.php", {
                accountMoneyArcheive: true,
                LID: lid
            }, function(data) {
                ndata = $.parseJSON(data);
                console.log(ndata);
                counter = 1;
                tblleadger.clear();
                ndata.forEach(element => {
                    debit = 0;
                    credit = 0;
                    amount = 0;
                    if (element.ammount_type === "Debet") {
                        debit = "<span class='las la-check text-blue fa-2x' style='font-weight: bold;'></span>";
                        credit = "<span class='las la-times text-danger fa-2x' style='font-weight: bold;'></span>";
                    } else {
                        credit = "<span class='las la-check text-blue fa-2x' style='font-weight: bold;'></span>";
                        debit = "<span class='las la-times text-danger fa-2x' style='font-weight: bold;'></span>";
                    }

                    if (element.rate != 0) {
                        amount = element.amount * element.rate;
                    } else {
                        amount = element.amount;
                    }
                    tblleadger.row.add([counter, element.account_name, element.detials, element.amount, debit, credit]).draw(false);
                    counter++;
                });
                $("#showleadgerModel").modal("show");
            });
        });

        // restore leadger
        $(document).on("click",".btnrestore",function(){
            lid = $(this).attr("data-href");
            row = $(this).parent().parent();
            $.confirm({
                icon: 'fa fa-smile-o',
                theme: 'modern',
                closeIcon: true,
                animation: 'scale',
                type: 'blue',
                title: 'Are you sure?',
                content: 'Are you sure to restor this transaction back? if yes please confirm.',
                buttons: {
                    confirm: {
                        text: 'Yes',
                        action: function() {
                            $.post("../app/Controllers/SystemAdmin.php", {
                                RL: true,
                                LID: lid
                            }, function(data) {
                                console.log(data);
                                tblarcheive.row(row).remove().draw();
                            });
                        }
                    },
                    cancel: {
                        text: 'No',
                        action: function() {}
                    }
                }
            });
        })
    });
</script>