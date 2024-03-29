<?php
$Active_nav_name = array("parent" => "Reports", "child" => "All Reports");
$page_title = "Debitors/Creditors Report";
include("./master/header.php");
// Logged in user info 
$report = new Reports();
$bank = new Banks();
$bussiness = new Bussiness();

$allCatagories_data = $report->getReportsCatagory($user_data->company_id);
$allCatagories = $allCatagories_data->fetchAll(PDO::FETCH_OBJ);

$company_curreny_data = $company->GetCompanyCurrency($user_data->company_id);
$company_curreny = $company_curreny_data->fetchAll(PDO::FETCH_OBJ);
$mainCurrency = "";
foreach ($company_curreny as $currency) {
    if ($currency->mainCurrency) {
        $mainCurrency = $currency->currency;
    }
}

// Get all Customers of this company
$allCustomers_data = $bussiness->getCompanyCustomers($user_data->company_id, "");
$allCustomers = $allCustomers_data->fetchAll(PDO::FETCH_OBJ);
?>

<style>
    .rowdata{
        cursor: pointer;
    }

    .rowdata:hover{
        font-weight: bold;
    }
</style>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <h4>گزارش حساب های دریافتنی و پرداختنی</h4>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-header">
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <table class="table material-table" id="customersTable">
                            <thead>
                                <tr>
                                    <th>نام</th>
                                    <?php
                                    foreach ($allcurrency as $cur) {
                                        echo "<th>$cur->currency</th>";
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>نام</th>
                                    <?php
                                    foreach ($allcurrency as $cur) {
                                        echo "<th>$cur->currency</th>";
                                    }
                                    ?>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                foreach ($allCustomers as $cus) {
                                    $rec_acc_data = $bussiness->getRecivableAccount($user_data->company_id, $cus->customer_id);
                                    $rec_acc = $rec_acc_data->fetch(PDO::FETCH_OBJ);
                                    $row = "<tr>";
                                    $row .= "<td class='customer rowdata' data-href='$rec_acc->chartofaccount_id'>$cus->alies_name</td>";
                                    foreach ($allcurrency as $cur) {
                                        $transactions_data = $bank->getCustomerTransactionByCurrency($rec_acc->chartofaccount_id, $cur->company_currency_id);
                                        $transactions = $transactions_data->fetch(PDO::FETCH_OBJ);
                                        $res = $transactions->Credit - $transactions->Debet;
                                        $color = "black";
                                        if ($res > 0) {
                                            $color = "info";
                                        } else if ($res < 0) {
                                            $color = "danger";
                                        } else {
                                            $color = "black";
                                        }
                                        $row .= "<td class='text-$color money rowdata' data-href='$rec_acc->chartofaccount_id' id='$cur->company_currency_id'>$res-$cur->currency</td>";
                                    }
                                    $row .= "</tr>";
                                    echo $row;
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

<!-- Customer Transaction Modal -->
<div class="modal fade" id="customerTModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <table class="table" id="singlecustomersTable">
                    <thead>
                        <tr>
                            <th>نام</th>
                            <th colspan="6" id="cuname1"></th>
                        </tr>
                        <tr>
                            <th>#</th>
                            <th>تاریخ</th>
                            <th>شرح</th>
                            <th>نوعیت تراکنش</th>
                            <th>اسعار</th>
                            <th>مبلغ</th>
                            <th>نتیجه</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Customer Transaction Modal -->
<div class="modal fade" id="customerTTModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <table class="table" id="singlecustomersTable2">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th colspan="7" id="cuname">Ahmad</th>
                        </tr>
                        <tr>
                            <th>#</th>
                            <th>تاریخ</th>
                            <th>شرح</th>
                            <th>نوعیت تراکنش</th>
                            <th>اسعار</th>
                            <th>دریافت</th>
                            <th>پرداخت</th>
                            <th>بیلانس</th>
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
        var getUrl = window.location;
        var baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];

        table = $("#singlecustomersTable").DataTable({
            dom: 'Bfrtip',
            stateSave: true,
            colReorder: true,
            select: true,
            autoWidth: false,
            buttons: [
                'excel', {
                    extend: 'pdf',
                    customize: function(doc) {
                        doc.content[1].table.widths =
                            Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                    }
                }, {
                    extend: 'print',
                    customize: function(win) {
                        $(win.document.body)
                            .css("margin", "40pt 20pt 20pt 20pt")
                            .prepend(
                                `<div style='display:flex;flex-direction:column;justify-content:center;align-items:center'><img src="${baseUrl}/app-assets/images/logo/ashna_trans.png" style='width:60pt' /><span>ASHNA Company</span></div>`
                            );

                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                }, 'colvis'
            ]
        });

        table1 = $("#singlecustomersTable2").DataTable({
            dom: 'Bfrtip',
            stateSave: true,
            colReorder: true,
            select: true,
            autoWidth: false,
            buttons: [
                'excel', {
                    extend: 'pdf',
                    customize: function(doc) {
                        doc.content[1].table.widths =
                            Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                    }
                }, {
                    extend: 'print',
                    customize: function(win) {
                        $(win.document.body)
                            .css("margin", "40pt 20pt 20pt 20pt")
                            .prepend(
                                `<div style='display:flex;flex-direction:column;justify-content:center;align-items:center'><img src="${baseUrl}/app-assets/images/logo/ashna_trans.png" style='width:60pt' /><span>ASHNA Company</span></div>`
                            );

                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                }, 'colvis'
            ]
        });

        // Load customer transactions By Name
        $(document).on("click", ".customer", function() {
            ID = $(this).attr("data-href");
            table.clear().draw(false);
            ths = $(this);
            $.get("../app/Controllers/Bussiness.php", {
                TByAccount: true,
                accID: ID
            }, function(data) {
                console.log(data);
                ndata = $.parseJSON(data);
                counter = 1;
                ndata.forEach(element => {
                    // date
                    date = new Date(element.reg_date * 1000);
                    newdate = date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate();
                    table.row.add([counter, newdate, element.detials, element.op_type, element.currency, element.amount, element.ammount_type]).draw(false);
                    counter++;
                });
                $("#cuname1").text($(ths).parent().children("td:first-child()").text());
                $("#customerTModel").modal("show");
            });
        });

        // Load customer transactions By Currency
        $(document).on("click", ".money", function() {
            ID = $(this).attr("data-href");
            cur = $(this).attr("id");
            table1.clear().draw(false);
            ths = $(this);
            $.get("../app/Controllers/Bussiness.php", {
                TByCurrency: true,
                accID: ID,
                cur: cur
            }, function(data) {
                ndata = $.parseJSON(data);
                counter = 1;
                balance = 0;
                ndata.forEach(element => {
                    debet = 0;
                    credit = 0;
                    if(element.ammount_type === "Debet"){
                        debet = element.amount;
                    }
                    else{
                        credit = element.amount;
                    }
                    balance = balance + (credit-debet);
                    // date
                    date = new Date(element.reg_date * 1000);
                    newdate = date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate();
                    table1.row.add([counter, newdate, element.detials, element.op_type, element.currency, debet,credit,balance]).draw(false);
                    counter++;
                });
                counter = 1;
                balance = 0;
                $("#cuname").text($(ths).parent().children("td:first-child()").text());
                $("#customerTTModel").modal("show");
            });
        });
    });
</script>