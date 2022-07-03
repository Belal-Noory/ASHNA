<?php
$Active_nav_name = array("parent" => "Reports", "child" => "All Reports");
$page_title = "Reports";
include("./master/header.php");
// Logged in user info 
$report = new Reports();
$bank = new Banks();

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
// cards color
$colors = array("info", "danger", "success", "warning");
?>
<style>
    .showreceiptdetails {
        cursor: pointer;
    }
</style>
<div class="col-lg-12 mt-2" id="mainc" data-href="<?php echo $mainCurrency; ?>">
    <div class="card" style="">
        <div class="card-header">
            <h4 class="card-title">All Reports</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <p>Get Reports based on the main catagories and sub catagories.</p>
                <ul class="nav nav-tabs nav-underline no-hover-bg nav-tabs-material">
                    <?php
                    $index = 0;
                    $Prev_account_kind = array();
                    foreach ($allCatagories as $account) {
                        if (!in_array($account->account_kind, $Prev_account_kind)) { ?>
                            <li class="nav-item">
                                <a class="nav-link waves-effect waves-dark <?php if ($index == 0) {
                                                                                echo "active";
                                                                            } ?>" id="<?php echo str_replace(' ', '', $account->account_kind) . "-tab"; ?>" data-toggle="tab" href="#<?php echo str_replace(' ', '', $account->account_kind) . "-panel"; ?>" aria-controls="link32" aria-expanded="<?php if ($index == 0) {
                                                                                                                                                                                                                                                                                                        echo "true";
                                                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                                                        echo "false";
                                                                                                                                                                                                                                                                                                    } ?>"><?php echo $account->account_kind; ?></a>
                            </li>
                    <?php }
                        array_push($Prev_account_kind, $account->account_kind);
                        $index++;
                    }  ?>
                </ul>
                <div class="tab-content px-1 pt-1">
                    <?php
                    $index = 0;
                    $Prev_account_kind = array();
                    foreach ($allCatagories as $account) {
                        $total_balance = $report->getCatagoriesDebetCredit($account->account_kind, $user_data->company_id);
                        if (!in_array($account->account_kind, $Prev_account_kind)) { ?>
                            <div class="tab-pane <?php if ($index == 0) {
                                                        echo "active";
                                                    } ?>" id="<?php echo str_replace(' ', '', $account->account_kind) . "-panel"; ?>" role="tabpanel" aria-labelledby="<?php echo str_replace(' ', '', $account->account_kind) . "-tab"; ?>" aria-expanded="<?php if ($index == 0) {
                                                                                                                                                                                                                                                                echo "true";
                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                echo "false";
                                                                                                                                                                                                                                                            } ?>">
                                <?php
                                $all_data = $report->getReportsBasedOnTransaction($user_data->company_id, $account->chartofaccount_id);
                                $all_details = $all_data->fetchAll(PDO::FETCH_OBJ);
                                ?>
                                <section id="material-datatables">
                                    <div class="card">
                                        <div class="card-header">
                                            <a class="heading-elements-toggle">
                                                <i class="la la-ellipsis-v font-medium-3"></i>
                                            </a>
                                            <div class="heading-elements">
                                                <ul class="list-inline mb-0">
                                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-content">
                                            <div class="card-body">
                                                <table class="table material-table customersTable" id="<?php echo $account->account_kind; ?>">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Leadger</th>
                                                            <th>Details</th>
                                                            <th>T-Type</th>
                                                            <th>Date</th>
                                                            <th>Debet</th>
                                                            <th>Credit</th>
                                                            <th>Balance</th>
                                                            <th>Remarks</th>
                                                        </tr>
                                                    </thead>
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
                                                            <th></th>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>
                                                        <?php
                                                        $counter = 0;
                                                        $balance = 0;
                                                        foreach ($all_details as $transactions) {
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
                                                                        <td data-href='$transactions->leadger_id' class='showreceiptdetails'>$transactions->leadger_id</td>
                                                                        <td data-href='$transactions->leadger_id' class='showreceiptdetails'>$transactions->detials</td>
                                                                        <td data-href='$transactions->leadger_id' class='showreceiptdetails'>$transactions->op_type</td>
                                                                        <td data-href='$transactions->leadger_id' class='showreceiptdetails'>$ndate</td>
                                                                        <td data-href='$transactions->leadger_id' class='showreceiptdetails'>$debet</td>
                                                                        <td data-href='$transactions->leadger_id' class='showreceiptdetails'>$credit</td>
                                                                        <td data-href='$transactions->leadger_id' class='showreceiptdetails'>$balance</td>
                                                                        <td data-href='$transactions->leadger_id' class='showreceiptdetails'>$remarks</td>
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
                                                                        <td data-href='$transactions->leadger_id' class='showreceiptdetails'>$transactions->leadger_id</td>
                                                                        <td data-href='$transactions->leadger_id' class='showreceiptdetails'>$transactions->detials</td>
                                                                        <td data-href='$transactions->leadger_id' class='showreceiptdetails'>$transactions->op_type</td>
                                                                        <td data-href='$transactions->leadger_id' class='showreceiptdetails'>$ndate</td>
                                                                        <td data-href='$transactions->leadger_id' class='showreceiptdetails'>$debet</td>
                                                                        <td data-href='$transactions->leadger_id' class='showreceiptdetails'>$credit</td>
                                                                        <td data-href='$transactions->leadger_id' class='showreceiptdetails'>$balance</td>
                                                                        <td data-href='$transactions->leadger_id' class='showreceiptdetails'>$remarks</td>
                                                                    </tr>";
                                                            }
                                                            $counter++;
                                                        } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                    <?php }
                        array_push($Prev_account_kind, $account->account_kind);
                        $index++;
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-body p-2">
                <div class="container container-waiting">
                    <div class="loader-wrapper">
                        <div class="loader-container">
                            <div class="ball-clip-rotate loader-primary">
                                <div></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-done d-none p-3">
                    <table class="table material-table" id="AccountsTable">
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
                        <tbody>

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
        var getUrl = window.location;
        var baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];

        table = $('.customersTable').DataTable();
        table.destroy();
        table = $('.customersTable').DataTable({
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
                    .column(5)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var creditTotal = api
                    .column(6)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);


                // Update footer by showing the total with the reference of the column index 
                color = (debetTotal - creditTotal) > 0 ? $(api.column(7).footer()).html("<span style='color:tomato'>" + (debetTotal - creditTotal) + "</span>") : $(api.column(7).footer()).html("<span style='color:dodgerblue'>" + (debetTotal - creditTotal) + "</span>");
                $(api.column(5).footer()).html(debetTotal);
                $(api.column(6).footer()).html(creditTotal);
            },
            "processing": true
        });


        table1 = $('#AccountsTable').DataTable();
        table1.destroy();
        table1 = $('#AccountsTable').DataTable({
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
                    .column(5)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var creditTotal = api
                    .column(6)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);


                // Update footer by showing the total with the reference of the column index 
                color = (debetTotal - creditTotal) > 0 ? $(api.column(7).footer()).html("<span style='color:tomato'>" + (debetTotal - creditTotal) + "</span>") : $(api.column(7).footer()).html("<span style='color:dodgerblue'>" + (debetTotal - creditTotal) + "</span>");
                $(api.column(5).footer()).html(debetTotal);
                $(api.column(6).footer()).html(creditTotal);
            },
            "processing": true
        });

        $(".customersTable").each(function() {
            ths = $(this);
            currentTable = $(ths).DataTable();
            $(ths).children("tfoot").children("tr").children("th:nth-child(4)").each(function(i) {
                var select = $('<select class="form-control"><option value="">Filter</option></select>')
                    .appendTo($(this).empty())
                    .on('change', function() {
                        currentTable.column(3)
                            .search($(this).val())
                            .draw();
                    });
                currentTable.column(3).data().unique().sort().each(function(d, j) {
                    select.append(`<option value='${d}'>${d}</option>`);
                });
            });
        });

        $(document).on("click", ".showreceiptdetails", function(e) {
            $("#show").modal("show");
            table1.clear();
            mainCurrency = $("#mainc").attr("data-href").trim();
            balance = 0;
            let counter = 0;
            var leadger_id = $(this).attr("data-href");
            $.get("../app/Controllers/banks.php", {
                "getLeadgerAccounts": true,
                "leadgerID": leadger_id
            }, function(data) {
                ndata = $.parseJSON(data);
                ndata.forEach(element => {
                    console.log(element);
                    date = new Date(element.reg_date * 1000);
                    newdate = date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate();
                    let debet = 0;
                    let credit = 0;
                    if (element.currency == mainCurrency) {
                        if (element.ammount_type == "Debet") {
                            debet = element.amount;
                        } else {
                            credit = element.amount;
                        }

                        balance = balance + (debet - credit);
                        remarks = balance > 0 ? "DR" : balance < 0 ? "BR" : "";
                        table1.row.add([
                            counter,
                            element.leadger_ID,
                            element.detials,
                            newdate,
                            debet,
                            credit,
                            balance,
                            remarks
                        ]).draw(false);
                        counter++;
                    } else {
                        $.get("../app/Controllers/banks.php", {
                                "getExchange": true,
                                "from": element.currency,
                                "to": mainCurrency
                            },
                            function(data) {
                                if (data != "false") {
                                    ndata = JSON.parse(data);
                                    if (ndata.currency_from == element.currency) {
                                        $temp_ammount = parseFloat(element.amount) * parseFloat(ndata.rate);
                                        if (element.ammount_type == "Debet") {
                                            debet += parseFloat($temp_ammount);
                                        } else {
                                            credit += parseFloat($temp_ammount);
                                        }
                                    } else {
                                        $temp_ammount = parseFloat(element.amount) / parseFloat(ndata.rate);
                                        if (element.ammount_type == "Debet") {
                                            debet += parseFloat($temp_ammount);
                                        } else {
                                            credit += parseFloat($temp_ammount);
                                        }
                                    }
                                } else {
                                    if (!$("#erroSnackbar").hasClass("show")) {
                                        $("#erroSnackbar").addClass("show");
                                    }
                                }

                                balance = balance + (debet - credit);
                                remarks = balance > 0 ? "DR" : balance < 0 ? "BR" : "";
                                table1.row.add([
                                    counter,
                                    element.leadger_ID,
                                    element.detials,
                                    newdate,
                                    debet,
                                    credit,
                                    balance,
                                    remarks
                                ]).draw(false);
                                counter++;
                            });
                    }
                });
            });
            $(".container-waiting").addClass("d-none");
            $(".container-done").removeClass("d-none");
        });

    });
</script>