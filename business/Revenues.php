<?php
$Active_nav_name = array("parent" => "Receipt & Revenue", "child" => "Revenue List");
$page_title = "Revenues";
include("./master/header.php");
$revenue = new Revenue();
$company = new Company();

$all_receipt_data = $revenue->getRevenueLeadger($user_data->company_id);
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
                                <th>Leadger</th>
                                <th>Details</th>
                                <th>Date</th>
                                <th>Debet</th>
                                <th>Credit</th>
                                <th>Balance</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $counter = 0;
                            $balance = 0;
                            foreach ($all_receipt as $transactions) {
                                $debet = 0;
                                $credit = 0;
                                if ($transactions->currency == $mainCurrency) {
                                    if ($transactions->ammount_type == "Debet") {
                                        $debet = $transactions->amount;
                                    } else {
                                        $credit = $transactions->amount;
                                    }
                                    $balance = $balance + ($debet - $credit);
                                    $remarks = "";
                                    if ($balance > 0) {
                                        $remarks = "DR";
                                    } else if ($balance < 0) {
                                        $remarks = "CR";
                                    } else {
                                        $remarks = "";
                                    }
                                    $ndate = Date('m/d/Y', $transactions->reg_date);
                                    echo "<tr>
                                                                        <td>$counter</td>
                                                                        <td >$transactions->leadger_id</td>
                                                                        <td >$transactions->detials</td>
                                                                        <td >$ndate</td>
                                                                        <td >$debet</td>
                                                                        <td >$credit</td>
                                                                        <td >$balance</td>
                                                                        <td >$remarks</td>
                                                                    </tr>";
                                } else {
                                    $conversion_data = $bank->getExchangeConversion($transactions->currency, $mainCurrency, $user_data->company_id);
                                    $conversion = $conversion_data->fetch(PDO::FETCH_OBJ);
                                    if ($conversion->currency_from == $transactions->currency) {
                                        $temp_ammount = $transactions->amount * $conversion->rate;
                                        if ($transactions->ammount_type == "Debet") {
                                            $debet += $temp_ammount;
                                        } else {
                                            $credit += $temp_ammount;
                                        }
                                    } else {
                                        $temp_ammount = $transactions->amount / $conversion->rate;
                                        if ($transactions->ammount_type == "Debet") {
                                            $debet += $temp_ammount;
                                        } else {
                                            $credit += $temp_ammount;
                                        }
                                    }

                                    $balance = $balance + ($debet - $credit);
                                    $remarks = "";
                                    if ($balance > 0) {
                                        $remarks = "DR";
                                    } else if ($balance < 0) {
                                        $remarks = "CR";
                                    } else {
                                        $remarks = "";
                                    }
                                    $ndate = Date('m/d/Y', $transactions->reg_date);
                                    echo "<tr>
                                                                        <td>$counter</td>
                                                                        <td>$transactions->leadger_id</td>
                                                                        <td>$transactions->detials</td>
                                                                        <td>$ndate</td>
                                                                        <td>$debet</td>
                                                                        <td>$credit</td>
                                                                        <td>$balance</td>
                                                                        <td>$remarks</td>
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
                    .column(4)
                    .data()
                    .reduce(function(a, b) {
                        console.log(a);
                        return intVal(a) + intVal(b);
                    }, 0);

                var creditTotal = api
                    .column(5)
                    .data()
                    .reduce(function(a, b) {
                        console.log(a);
                        return intVal(a) + intVal(b);
                    }, 0);


                // Update footer by showing the total with the reference of the column index 
                color = (debetTotal - creditTotal) > 0 ? $(api.column(6).footer()).html("<span style='color:tomato'>" + (debetTotal - creditTotal) + "</span>") : $(api.column(6).footer()).html("<span style='color:dodgerblue'>" + (debetTotal - creditTotal) + "</span>");
                $(api.column(4).footer()).html(debetTotal);
                $(api.column(5).footer()).html(creditTotal);
            },
            "processing": true
        });
    });
</script>