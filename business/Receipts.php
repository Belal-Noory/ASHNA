<?php
$Active_nav_name = array("parent" => "Receipt & Revenue", "child" => "Receipt List");
$page_title = "Recipts";
include("./master/header.php");
$receipt = new Receipt();
$company = new Company();
$bank = new Banks();
$all_receipt_data = $receipt->getReceiptLeadger($user_data->company_id);
$all_receipt = $all_receipt_data->fetchAll(PDO::FETCH_OBJ);

$company_curreny_data = $company->GetCompanyCurrency($user_data->company_id);
$company_curreny = $company_curreny_data->fetchAll(PDO::FETCH_OBJ);
$mainCurrency = "";
foreach ($company_curreny as $currency) {
    if ($currency->mainCurrency) {
        $mainCurrency = $currency->currency;
    }
}
?>
<style>
    .showreceiptdetails {
        cursor: pointer;
    }

    .showreceiptdetails:hover {
        background-color: lightgray;
    }
</style>
<!-- END: Main Menu-->
<!-- BEGIN: Content-->
<div class="container pt-5">
    <section id="material-datatables">
        <div class="card">
            <div class="card-header">
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
                    <table class="table material-table" id="customersTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>RID</th>
                                <th>Leadger</th>
                                <th>Date</th>
                                <th>Details</th>
                                <th>Amount</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $counter = 0;
                            foreach ($all_receipt as $transactions) {
                                $amount = 0;
                                    if ($transactions->currency == $mainCurrency) {
                                        $amount = $transactions->amount;
                                        $ndate = Date('m/d/Y', $transactions->reg_date);
                                        echo "<tr>
                                                                            <td>$counter</td>
                                                                            <td>$transactions->account_money_id</td>
                                                                            <td >$transactions->leadger_id</td>
                                                                            <td >$ndate</td>
                                                                            <td >$transactions->detials</td>
                                                                            <td >$amount</td>
                                                                            <td >$transactions->remarks</td>
                                                                        </tr>";
                                    } else {
                                        $conversion_data = $bank->getExchangeConversion($transactions->currency, $mainCurrency, $user_data->company_id);
                                        $conversion = $conversion_data->fetch(PDO::FETCH_OBJ);
                                        if ($conversion->currency_from == $transactions->currency) {
                                            $amount = $transactions->amount * $conversion->rate;
                                        } else {
                                            $amount = $transactions->amount / $conversion->rate;
                                        }
                                        $ndate = Date('m/d/Y', $transactions->reg_date);
                                        echo "<tr>
                                                <td>$counter</td>
                                                <td>$transactions->account_money_id</td>
                                                <td>$transactions->leadger_id</td>
                                                <td>$ndate</td>
                                                <td>$transactions->detials</td>
                                                <td>$amount</td>
                                                <td >$transactions->remarks</td>
                                            </tr>";
                                    }
                                    $counter++;
                            } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!-- Material Data Tables -->
</div>
<?php
include("./master/footer.php");
?>

<script>
    $(document).ready(function() {
        var getUrl = window.location;
        var baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];

        table1 = $('#customersTable').DataTable();
        table1.destroy();
        table1 = $('#customersTable').DataTable({
            dom: 'Bfrtip',
            colReorder: true,
            select: true,
            buttons: [
                'excel', {
                    extend: 'pdf',
                    customize: function(doc) {
                        doc.content[1].table.widths =
                            Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                    },
                    footer: true
                }, {
                    extend: 'print',
                    customize: function(win) {
                        $(win.document.body)
                            .css("margin", "40pt 20pt 20pt 20pt")
                            .prepend(
                                `<div style='display:flex;flex-direction:column;justify-content:center;align-items:center'><img src="${baseUrl}/business/app-assets/images/logo/ashna_trans.png" style='width:60pt' /><span>ASHNA Company</span></div>`
                            );

                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    },
                    footer: true
                }, 'colvis'
            ],
            "footerCallback": function(row, data, start, end, display) {
                var api = this.api(),
                    data;

                // converting to interger to find total
                var intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };

                // computing column Total of the complete result 
                var debetTotal = api
                    .column(5,{
                        search: 'applied'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);


                // Update footer by showing the total with the reference of the column index 
                $(api.column(5).footer()).html(debetTotal);
            },
            "processing": true
        });
    });
</script>