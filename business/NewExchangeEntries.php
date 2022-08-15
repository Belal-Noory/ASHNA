<?php
$Active_nav_name = array("parent" => "Accounting", "child" => "Exchange Entries");
$page_title = "Exchange Entries";
include("./master/header.php");

$company = new Company();
$revenue = new Expense();

$allcurrency_data = $company->GetCompanyCurrency($user_data->company_id);
$allcurrency = $allcurrency_data->fetchAll(PDO::FETCH_OBJ);
?>

<div class="p-2">
    <div class="table-responsive">
        <table class="table display compact" id="entriestbl">
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
                <tr>
                    <td>1</td>
                    <td>Contact</td>
                    <td>001</td>
                    <td>Belal</td>
                    <td>12000</td>
                    <td>18000</td>
                    <td>4000</td>
                </tr>
            </tbody>
        </table>
    </div>
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