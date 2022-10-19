<?php
$Active_nav_name = array("parent" => "Receipt & Revenue", "child" => "Receipt List");
$page_title = "Recipts";
include("./master/header.php");
$receipt = new Receipt();
$company = new Company();
$bank = new Banks();

$company_FT_data = $company->getCompanyActiveFT($user_data->company_id);
$company_ft = $company_FT_data->fetch();

$financial_term = 0;
if ($company_FT_data->rowCount() > 0) {
    $financial_term = $company_ft['term_id'];
}

$all_receipt_data = $receipt->getReceiptLeadger($user_data->company_id, $financial_term);
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

    .hover:hover{
        transform: scale(1.09);
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
                                <th>Date</th>
                                <th>Details</th>
                                <th>Amount</th>
                                <th>Remarks</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $counter = 0;
                            foreach ($all_receipt as $transactions) {
                                $amount = 0;
                                if($transactions->rate != 0 && $transactions->rate != null)
                                {
                                    $amount = $transactions->amount * $transactions->rate;
                                }
                                else{
                                    $amount = $transactions->amount;
                                }
                                $ndate = Date('m/d/Y', $transactions->reg_date);
                                echo "<tr>
                                        <td>$counter</td>
                                        <td>$transactions->leadger_id</td>
                                        <td>$ndate</td>
                                        <td>$transactions->detials</td>
                                        <td>$amount $transactions->currency</td>
                                        <td>$transactions->remarks</td>
                                        <td>
                                            <a class='text-blue' href='Edite.php?edit=$transactions->leadger_id&op=receipt'><span class='las la-edit la-2x hover'></span></a>
                                            <a class='text-danger btndeleteLeadger' href='#' data-href='$transactions->leadger_id'><span class='las la-trash la-2x hover'></span></a>
                                        </td>
                                    </tr>";

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
                        i.replace(/[A-z]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };

                // computing column Total of the complete result 
                var debetTotal = api
                    .column(4, {
                        search: 'applied'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);


                // Update footer by showing the total with the reference of the column index 
                $(api.column(4).footer()).html(debetTotal);
            },
            "processing": true
        });

        // Delete leagder
        $(document).on("click", ".btndeleteLeadger", function(e) {
            e.preventDefault();
            LID = $(this).attr("data-href");
            row = $(this).parent().parent();
            $.confirm({
                icon: 'fa fa-smile-o',
                theme: 'modern',
                closeIcon: true,
                animation: 'scale',
                type: 'blue',
                title: 'Are you sure?',
                content: 'if you delete this transaction, it will be avilable in archeive section.',
                buttons: {
                    confirm: {
                        text: 'Yes',
                        action: function() {
                            $.post("../app/Controllers/SystemAdmin.php", {
                                DL: true,
                                LID: LID
                            }, function(data) {
                                table1.row(row).remove().draw();
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

        // get new receipts
        setInterval(() => {
            $.post("../app/Controllers/Receipt.php", {
                newReceipts: true
            }, function(data) {
                ndata = $.parseJSON(data);
                if (ndata.length > 0) {
                    table1.clear();
                    counter = 0;
                    ndata.forEach(element => {
                        // date
                        date = new Date(element.reg_date * 1000);
                        newdate = date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate();
                        b
                        amount = 0;
                        if(element.rate != 0 && element.rate != null)
                        {
                            amount = element.amount * element.rate;
                        }
                        else{
                            amount = element.amount;
                        }
                        table1.row.add([counter, element.leadger_ID, newdate, element.remarks, amount+" "+element.currency, element.remarks, btn]).draw(false);
                        counter++;
                    });
                }
            });
        }, 10000);
    });
</script>