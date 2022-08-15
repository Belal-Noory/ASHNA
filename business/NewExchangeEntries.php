<?php
$Active_nav_name = array("parent" => "Accounting", "child" => "Exchange Entries");
$page_title = "Exchange Entries";
include("./master/header.php");

$company = new Company();
$banks = new Banks();

$exchange_entries_data = $banks->getExchangeEntires($user_data->company_id, $mainCurrencyID);
$exchange_entries = $exchange_entries_data->fetchAll(PDO::FETCH_OBJ);
?>

<div class="p-2">
        <table class="table" id="entriestbl">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Type</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Balance</th>
                    <th>Currency Balance</th>
                    <th>Difference</th>
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $counter = 0;
                $prevCode = 0;
                $next = false;
                foreach ($exchange_entries as $entries) {
                    $catagory = "";
                    if ($entries->catagory == "") {
                        $catagory = "Contact";
                    } else {
                        $catagory = $entries->catagory;
                    }
                    // get currency details
                    $currency_details_data = $company->GetCompanyCurrencyDetails($user_data->company_id,$entries->currency_id);
                    $currency_details = $currency_details_data->fetch(PDO::FETCH_OBJ);

                    // get the latest exchange conversion
                    $newCurrencyExchange_data = $banks->getExchangeConversion($mainCurrency, $currency_details->currency, $user_data->company_id);
                    $newCurrencyExchange = $newCurrencyExchange_data->fetch(PDO::FETCH_OBJ);

                    $balance = ($entries->debits - $entries->credits) * $entries->currency_rate;
                    $cbalance = $entries->debits - $entries->credits;

                    $nbalance = 0;
                    if ($currency_details->currency == $newCurrencyExchange->currency_from) {
                        $nbalance += ($entries->debits - $entries->credits) * $newCurrencyExchange->rate;
                    } else {
                        $nbalance += ($entries->debits - $entries->credits) * (1 / $newCurrencyExchange->rate);
                    }
                    $diff = $balance - $nbalance;
                    $diff = $diff < 0 ? "<span style='color:tomato'>$diff</span>" : $diff;

                    echo "<tr>
                                    <td>$counter</td>
                                    <td>$catagory</td>
                                    <td>$entries->chartofaccount_id</td>
                                    <td>$entries->account_name</td>
                                    <td>$balance $mainCurrency</td>
                                    <td>$cbalance $currency_details->currency</td>
                                    <td>$diff</td>
                                </tr>";
                    $counter++;
                    // if ($entries->currency != $mainCurrency) {
                    //     // if ($prevCode != 0 && $prevCode != $entries->chartofaccount_id) {
                    //     //     $next = true;
                    //     // }

                    //     // if ($prevCode == $entries->chartofaccount_id || $prevCode == 0) {
                    //     //     
                    //     //   

                    //     //     $balance += ($entries->amount * $entries->currency_rate);
                    //     //     
                    //     //     $cbalance += $entries->amount;
                    //     // }


                    //         $diff = $balance - $nbalance;
                    //         $diff = $diff < 0 ? "<span style='color:tomato'>$diff</span>" : $diff;

                    //         $counter++;
                    //         $balance = 0;
                    //         $cbalance = 0;
                    //         $prevCode = 0;
                    //         $nbalance = 0;
                    //         $diff = 0;
                    //         $next = false;
                    // }
                }
                ?>
            </tbody>
        </table>
</div>

<?php
include("./master/footer.php");
?>

<script>
    $(document).ready(function() {
        tble = $("#entriestbl").DataTable({
            dom: 'Bfrtip',
            orderCellsTop: true,
            fixedHeader: true,
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
                }
            ],
        });

        $("#entriestbl").children("thead").children("tr:last").children("th:nth-child(2)").each(function(i) {
            var select = $('<select class="form-control"><option value="">Filter</option></select>')
                .appendTo($(this).empty())
                .on('change', function() {
                    tble.column(1)
                        .search($(this).val())
                        .draw();
                });
            tble.column(1).data().unique().sort().each(function(d, j) {
                text = d;
                if (text.indexOf("<a") > -1) {
                    var xmlString = text;
                    var doc = new DOMParser().parseFromString(xmlString, "text/xml");
                    text = doc.firstChild.innerHTML;
                }
                select.append('<option value="' + text + '">' + text + '</option>')
            });
        });
    });
</script>