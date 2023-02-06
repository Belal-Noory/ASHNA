<?php
$Active_nav_name = array("parent" => "Contact", "child" => "Contact List");
$page_title = "Customers";
include("./master/header.php");

$bussiness = new Bussiness();
$company = new Company();
$bank = new Banks();

// Get all Customers of this company
$allCustomers_data = $bussiness->getCompanyCustomers($user_data->company_id, $user_data->user_id);
$allCustomers = $allCustomers_data->fetchAll(PDO::FETCH_OBJ);

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
?>

<style>
    ::-webkit-scrollbar {
        display: none;
    }

    ::-webkit-scrollbar-button {
        display: none;
    }

    .detais {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        margin-bottom: 4px;
    }

    #SinglecustomerTable th {
        width: 100%;
    }

    .rowT {
        cursor: pointer;
    }

    .rowT:hover {
        font-weight: bold;
    }

    #SinglecustomerTable {
        table-layout: fixed;
    }

    #SinglecustomerTable tr td,
    #SinglecustomerTable th td {
        max-width: 100%;
    }
</style>

<!-- END: Main Menu-->
<!-- BEGIN: Content-->
<div class="row p-2 m-0" id="mainc" data-href="<?php echo $mainCurrency; ?>">
    <div class="col-md-12 col-lg-4 p-0 m-0">
        <!-- Material Data Tables -->
        <section id="material-datatables  p-0 m-0">
            <div class="card p-0 m-0">
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
                                    <th>Name</th>
                                    <th>Balance</th>
                                    <th>Payable</th>
                                    <th>Person Type</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Balance</th>
                                    <th>Payable</th>
                                    <th>Person Type</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                foreach ($allCustomers as $customer) {
                                    // get customer Payable account
                                    $cus_payable_data = $bussiness->getPayableAccount($user_data->company_id, $customer->customer_id);
                                    $cus_payable = $cus_payable_data->fetch(PDO::FETCH_OBJ);
                                    // get payable account transaction
                                    $payable_transaction_data = $bank->getAccountMoneyByTerm($cus_payable->chartofaccount_id, $term_id);
                                    $payable_transaction = $payable_transaction_data->fetchAll(PDO::FETCH_OBJ);
                                    $totalPayable = 0;
                                    foreach ($payable_transaction as $PT) {
                                        if ($PT->rate != 0) {
                                            $totalPayable += $PT->amount * $PT->rate;
                                        } else {
                                            $totalPayable += $PT->amount;
                                        }
                                    }

                                    // get customer Receivable account
                                    $cus_receivable_data = $bussiness->getRecivableAccount($user_data->company_id, $customer->customer_id);
                                    $cus_receivable = $cus_receivable_data->fetch(PDO::FETCH_OBJ);

                                    // get payable account transaction
                                    $receivable_transaction_data = $bank->getAccountMoneyByTerm($cus_receivable->chartofaccount_id, $term_id);
                                    $receivable_transaction = $receivable_transaction_data->fetchAll(PDO::FETCH_OBJ);
                                    $totalRecevible = 0;
                                    $debit = 0;
                                    $credit = 0;
                                    foreach ($receivable_transaction as $RT) {
                                        if ($RT->ammount_type == "Debet") {
                                            if ($RT->rate != 0) {
                                                $debit += $RT->amount * $RT->rate;
                                            } else {
                                                $debit += $RT->amount;
                                            }
                                        } else {
                                            if ($RT->rate != 0) {
                                                $credit += $RT->amount * $RT->rate;
                                            } else {
                                                $credit += $RT->amount;
                                            }
                                        }
                                    }
                                    $totalRecevible = ($debit - $credit);
                                    $Balance = ($totalRecevible-$totalPayable);
                                ?>
                                    <tr>
                                        <td><a href="#" data-href="<?php echo $customer->customer_id; ?>" class="showcustomerdetails"><?php echo $customer->alies_name; ?></a></td>
                                        <td style='<?php if ($Balance > 0) {
                                                        echo "color:tomato;";
                                                    } else {
                                                        echo "color:dodgerblue";
                                                    } ?>'><?php echo $Balance . " " . $mainCurrency; ?></td>
                                        <td><?php echo $totalPayable . " " . $mainCurrency;  ?></td>
                                        <td><?php echo strtolower(trim($customer->person_type)); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        <!-- Material Data Tables -->
    </div>

    <div class="col-md-12 col-lg-8">
        <div style='width:100%;height:100%;display:flex;justify-content:center;align-items:center;'>
            <h2 id="Nocustomer">Please select a customer</h2>
            <i class='la la-spinner spinner d-none' id="customerSpinner"></i>
        </div>
        <div class="card d-none" id="customerContainer">
            <div class="card-header">
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a class="btnEditCus"><i class="las la-edit"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    </ul>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-4" id="customerInfo1">
                        <div class="detais">
                            <span>Name:</span>
                            <span id="fname"></span>
                        </div>
                        <div class="detais">
                            <span>Father Name:</span>
                            <span id="fname"></span>
                        </div>
                        <div class="detais">
                            <span>Job Title:</span>
                            <span id="company_name"></span>
                        </div>
                        <div class="detais">
                            <span>Address:</span>
                            <span id="address"></span>
                        </div>
                        <div class="detais">
                            <span>Exchange to:</span>
                            <select class="form-control" id="accountType">
                                <option value="na">Select</option>
                                <option value="all">All</option>
                                <?php
                                foreach ($company_curreny as $currency) {
                                    echo "<option value='$currency->company_currency_id'>$currency->currency</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4 imgcontainer" style="display: flex; flex-direction: column; align-items:center">

                    </div>
                    <div class="col-sm-4">
                        <div class="detais">
                            <span>Phone 1:</span>
                            <span id="phone1"></span>
                        </div>
                        <div class="detais">
                            <span>Phone 2:</span>
                            <span id="phone2"></span>
                        </div>
                        <div class="detais">
                            <span>Office Phone:</span>
                            <span id="office_phone"></span>
                        </div>
                        <div class="detais">
                            <span>Email:</span>
                            <span id="email"></span>
                        </div>
                        <div class="detais">
                            <span>Website:</span>
                            <span id="website"></span>
                        </div>
                        <div class="detais">
                            <span>Fax:</span>
                            <span id="fax"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-underline nav-justified">
                            <li class="nav-item">
                                <a class="nav-link active" id="transactions-tab" data-toggle="tab" href="#transactionsPanel" aria-controls="activeIcon12" aria-expanded="true">
                                    <i class="ft-cog"></i> Transactions
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="Notes-tab" data-toggle="tab" href="#notesPanel" aria-controls="linkIconOpt11">
                                    <i class="ft-external-link"></i> Notes
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="Reminders-tab" data-toggle="tab" href="#remindersPanel" aria-controls="linkIconOpt11">
                                    <i class="ft-clock"></i> Reminders
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="attachment-tab" data-toggle="tab" href="#attachmentPanel" aria-controls="linkIconOpt11">
                                    <i class="las la-file-upload"></i> Attachments
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="transactionsPanel" aria-labelledby="transactions-tab" aria-expanded="true">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="min" id="min" placeholder="Date From" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="max" id="max" placeholder="Date To" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <button class="btn btn-danger mt-2" id="btnclearfilter"><span class="las la-trash white"></span>Clear Filter</button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="material-table w-100" id="SinglecustomerTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Code</th>
                                                <th>Date</th>
                                                <th>Details</th>
                                                <th>T-Type</th>
                                                <th>Currency</th>
                                                <th>Debet</th>
                                                <th>Credit</th>
                                                <th>Balance</th>
                                                <th>Remarks</th>
                                            </tr>
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
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>

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
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="notesPanel" role="tabpanel" aria-labelledby="Notes-tab" aria-expanded="false" style="overflow: scroll;">
                                <button type="button" class="btn btn-dark waves-effect waves-light" data-toggle="modal" data-target="#shownoteModel">
                                    <span class="las la-plus"></span>
                                </button>
                                <div class="col-lg-12 notescontainer p-1" style="height: 40vh; overflow-y:scroll">

                                </div>
                            </div>
                            <div class="tab-pane" id="remindersPanel" role="tabpanel" aria-labelledby="Reminders-tab" aria-expanded="false">
                                <button type="button" class="btn btn-dark waves-effect waves-light" data-toggle="modal" data-target="#showreminderModel">
                                    <span class="las la-plus"></span>
                                </button>
                                <div class="col-lg-12 remindercontainer mt-1" style="height: 40vh; overflow-y:scroll">

                                </div>
                            </div>
                            <div class="tab-pane" id="attachmentPanel" role="tabpanel" aria-labelledby="attachment-tab" aria-expanded="false">
                                <button type="button" class="btn btn-dark waves-effect waves-light" data-toggle="modal" data-target="#showattachModel">
                                    <span class="las la-plus"></span>
                                </button>
                                <div class="row attachcontainer mt-1" style="height: 40vh; overflow-y:scroll">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Content-->

<!-- Add Reminder Modal -->
<div class="modal fade text-center" id="showreminderModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body p-2">
                <form class="form form-horizontal" id="addnewreminderform">
                    <div class="form-body">
                        <h4 class="form-section"><i class="la la-plus"></i> Add New Reminder</h4>
                        <div class="form-group">
                            <input type="text" id="rtitle" class="form-control required" placeholder="Reminder Title" name="title">
                        </div>
                        <div class="form-group">
                            <textarea id="rdetails" rows="5" class="form-control required" name="rdetails" placeholder="Reminder Details"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="rdate">Remind Date</label>
                            <input type="date" class="form-control required" name="rdate" id="rdate">
                        </div>
                    </div>
                    <div class="form-actions">
                        <a href="#" class="btn btn-primary" id="btnaddnewreminder">
                            <i class="la la-check-square-o"></i> Add
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Note Modal -->
<div class="modal fade text-center" id="shownoteModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body p-2">
                <form class="form form-horizontal" id="addnewnotefome">
                    <div class="form-body">
                        <h4 class="form-section"><i class="la la-plus"></i> Add New Note</h4>
                        <div class="form-group">
                            <input type="text" id="title" class="form-control required" placeholder="Note Title" name="title">
                        </div>
                        <div class="form-group">
                            <textarea id="details" rows="5" class="form-control required" name="details" placeholder="Note Details"></textarea>
                        </div>
                    </div>
                    <div class="form-actions">
                        <a href="#" class="btn btn-primary" id="btnaddnewNote">
                            <i class="la la-check-square-o"></i> Add
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Attachment Modal -->
<div class="modal fade text-center" id="showattachModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body p-2">
                <form class="form form-horizontal" id="addnewattach">
                    <div class="form-body">
                        <h4 class="form-section"><i class="la la-plus"></i> Add New Attachment</h4>
                        <div class="form-group">
                            <label for="attachment_type">Attachment Type</label>
                            <select id="attachment_type" class="form-control required" name="attachment_type">
                                <option value="NID">NID</option>
                                <option value="profile">Profile</option>
                                <option value="signature">Signature</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="details">Details</label>
                            <textarea id="details" rows="1" class="form-control required" name="details" placeholder="Details" style="border:none; border-bottom:1px solid gray"></textarea>
                        </div>
                        <div class="attachement">
                            <label for='attachment'>
                                <span class='las la-file-upload blue'></span>
                            </label>
                            <i id="filename">filename</i>
                            <input type='file' class='form-control required d-none attachInput' id='attachment' name='attachment' />
                        </div>
                    </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary" id="btnaddnewAttach">
                    <i class="la la-check-square-o"></i> Add
                    </butt>
                    <span class="la la-spinner spinner blue ml-2 d-none" style="font-size: 30px;" id="spinneraddnewAttach"></span>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Attachment Modal -->
<div class="modal fade text-center" id="showSigModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body p-2">
            </div>
        </div>
    </div>
</div>

<!-- Add Attachment Modal -->
<div class="modal fade text-center" id="TDetailsModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-body p-2">
                <div class="table-responsive">
                    <table class="table material-table" id="TDetailsTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Leadger</th>
                                <th>Account</th>
                                <th>Details</th>
                                <th>Date</th>
                                <th>Currency</th>
                                <th>Amount</th>
                                <th>Type</th>
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

<div class="snackbar" id="loading">
    <div class="snackbar-body">
        Data is loading, please wait until this message hides. <span class="las la-spinner spinner white"></span>
    </div>
</div>
<!-- END: Content-->
<?php
include("./master/footer.php");
?>
<script>
    $(document).ready(function() {
        var getUrl = window.location;
        var baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];

        // Customer Account Types
        mainCurrency = $("#mainc").attr("data-href").trim();
        ColumnForFilter = Array();

        // hide all error messages
        setInterval(function() {
            $(".nocustomerSelected").fadeOut();
        }, 3000);

        table = $('#SinglecustomerTable').DataTable();
        table.destroy();
        table = $('#SinglecustomerTable').DataTable({
            dom: 'Bfrtip',
            ordering: false,
            orderCellsTop: true,
            autoWidth: false,
            filter: true,
            columnDefs: [{
                width: '80px',
                targets: 0
            }, ],
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
                    .column(6, {
                        search: 'applied'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                var creditTotal = api
                    .column(7, {
                        search: 'applied'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);


                // Update footer by showing the total with the reference of the column index 
                (debetTotal - creditTotal) > 0 ? $(api.column(8).footer()).html("<span style='color:tomato'>" + (creditTotal - debetTotal) + "</span>") : $(api.column(8).footer()).html("<span style='color:dodgerblue'>" + (creditTotal - debetTotal) + "</span>");
                $(api.column(6).footer()).html(debetTotal);
                $(api.column(7).footer()).html(creditTotal);
            }
        });

        tabletest1 = $('#customersTable').DataTable();
        tabletest1.destroy();
        table1 = $('#customersTable').DataTable({
            scrollY: '50vh',
            "searching": true
        });

        $("#customersTable").children("tfoot").children("tr").children("th").each(function(i) {
            var select = $('<select class="form-control"><option value="">Filter</option></select>')
                .appendTo($(this).empty())
                .on('change', function() {
                    table1.column(i)
                        .search($(this).val())
                        .draw();
                });
            table1.column(i).data().unique().sort().each(function(d, j) {
                text = d;
                if (text.indexOf("<a") > -1) {
                    var xmlString = text;
                    var doc = new DOMParser().parseFromString(xmlString, "text/xml");
                    text = doc.firstChild.innerHTML;
                }
                select.append('<option value="' + text + '">' + text + '</option>')
            });
        });

        // Show customer details 
        $(document).on("click", ".showcustomerdetails", function(e) {
            $("#loading").addClass("show");
            e.preventDefault();
            customerID = $(this).attr("data-href");
            $("#Nocustomer").addClass("d-none");
            $("#customerSpinner").removeClass("d-none");

            $.get("../app/Controllers/Bussiness.php", {
                "getCustomerByID": true,
                "customerID": customerID,
                "getAllTransactions": true
            }, function(data) {
                data = $.parseJSON(data);
                personalData = $.parseJSON(data[0].personalData);
                customerImgs = $.parseJSON(data[1].imgs);
                AllAccounts = $.parseJSON(data[4].Accounts);
                transactions = $.parseJSON(data[2].transactions)
                transactionsExch = $.parseJSON(data[3].exchangeTransactions)
                // add personal data
                $("#fname").text(personalData.fname + " " + personalData.lname);
                $("#lname").text(personalData.father);
                $("#company_name").text(personalData.job);

                // $("#fname").text(personalData.fname);
                $("#address").text(personalData.detail_address);
                $("#phone1").text(personalData.personal_phone);
                $("#phone2").text(personalData.personal_phone_second);
                $("#office_phone").text(personalData.official_phone);
                $("#email").text(personalData.email);
                $("#website").text(personalData.website);
                $("#fax").text(personalData.fax);

                img_tag = "";
                if (customerImgs.length > 0) {
                    customerImgs.forEach(element => {
                        if (element.attachment_type == "profile") {
                            img_tag += `<img src='uploadedfiles/customerattachment/${element.attachment_name}' class='mb-1' style='width:120px; height:120px;border-radius:50%' />`;
                        }

                        if (element.attachment_type == "signature") {
                            img_tag += `<button type="button" class="btn btn-dark waves-effect waves-light" data-toggle="modal" data-target="#showSigModel">
                                    <span class="las la-eye"></span> Signature
                                </button>`;
                            img = `<img src='uploadedfiles/customerattachment/${element.attachment_name}' style='width:100%;' />`;
                            $("#showSigModel").children(".modal-dialog").children(".modal-content").children(".modal-body").html(img);
                        }
                    });
                }
                $(".imgcontainer").html(img_tag);

                table.clear().draw(false);

                let counter = 0;
                // Add all transactions
                balance = 0;
                $debet = "";
                $crediet = "";
                if (transactions.length > 0) {
                    transactions.forEach(data => {
                        element = data[0];
                        console.log(element);
                        console.log(data);
                        if (element.ammount_type == "Debet") {
                            if (element.rate != 0 && element.rate != null) {
                                $debet = element.amount * element.rate;
                            } else {
                                $debet = element.amount;
                            }
                        } else {
                            if (element.rate != 0) {
                                $crediet = element.amount * element.rate;
                            } else {
                                $crediet = element.amount;
                            }
                        }
                        // date
                        date = new Date(element.reg_date * 1000);
                        newdate = date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate();

                        balance = Math.round(balance + ($debet - $crediet));
                        remarks = balance > 0 ? "DR" : balance < 0 ? "CR" : "";
                        table.row.add([
                            counter,
                            "<span class='rowT' data-href='" + element.leadger_id + "'>" + element.leadger_id + "</span>",
                            newdate,
                            element.detials,
                            element.op_type,
                            element.currency,
                            $debet,
                            $crediet,
                            balance,
                            remarks
                        ]).draw(false);
                        counter++;
                        next = false;
                        $debet = "";
                        $crediet = "";
                    });
                }

                // transactionsExch.forEach(element => {
                //     // date
                //     date = new Date(element.reg_date * 1000);
                //     newdate = date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate();
                //     debet = "";
                //     crediet = "";
                //     $.get("../app/Controllers/Bussiness.php", {
                //         "getCurrencyDetails": true,
                //         "DebetID": element.debt_currecny_id,
                //         "creditID": element.credit_currecny_id
                //     }, function(data) {
                //         newdata = $.parseJSON(data);
                //         debet = element.debt_amount + " - " + newdata.debet.currency;
                //         crediet = element.credit_amount + " - " + newdata.credeit.currency;
                //         balance = balance + (element.debt_amount - element.credit_amount);
                //         remarks = balance > 0 ? "DR" : balance < 0 ? "CR" : "";
                //         if (debet !== 0 && crediet !== 0) {
                //             table.row.add([
                //                 counter,
                //                 "<span class='rowT' data-href='" + element.leadger_id + "'>" + element.leadger_id + "</span>",
                //                 newdate,
                //                 element.detials,
                //                 element.op_type,
                //                 element.currency,
                //                 debet,
                //                 credit,
                //                 balance,
                //                 remarks,
                //                 element.currency_rate
                //             ]).draw(false);
                //             DefaultDataTable.push([counter, element.leadger_id, element.detials, element.op_type, newdate, debet, credit, balance, remarks]);
                //             counter++;
                //         }
                //     });
                // });

                // Set New Note button data href to customer id
                $("#btnaddnewNote").attr("data-href", customerID);
                $("#btnaddnewreminder").attr("data-href", customerID);
                $("#btnaddnewAttach").attr("data-href", customerID);

                // set edite button
                href = `Edite.php?edit=${customerID}&op=cus`;
                $(".btnEditCus").attr("href", href);

                $("#customerSpinner").addClass("d-none");
                $("#customerSpinner").parent().addClass("d-none");
                $("#customerContainer").removeClass("d-none");

                $(document).ajaxStop(function() {
                    // This function will be triggered every time any ajax request is requested and completed
                    $("#SinglecustomerTable").children("thead").children("tr:nth-child(2)").children("th").each(function(i) {
                        if (i > 1 && i < 10) {
                            var select = $('<select class="form-control"><option value="">Filter</option></select>')
                                .appendTo($(this).empty())
                                .on('change', function() {
                                    table.column(i)
                                        .search($(this).val())
                                        .draw();
                                });
                            table.column(i).data().unique().sort().each(function(d, j) {
                                select.append(`<option value='${d}'>${d}</option>`);
                            });
                        }
                    });
                    $("#loading").removeClass("show");
                    // table.columns.adjust().draw();
                });
            });
        });

        // Get Customer Note
        $("#Notes-tab").on("click", function() {
            if ($("#btnaddnewNote").attr("data-href")) {
                $(".notescontainer").html("<div style='width:100%;height:100%;display:flex;justify-content:center;align-items:center;' class='nocustomerSelected'><i class='la la-spinner spinner' style='font-size:2rem; color:seagreen'></i></div>");
                customerID = $("#btnaddnewNote").attr("data-href");
                $.get("../app/Controllers/Bussiness.php", {
                    "getCustomerNote": true,
                    "cutomerID": customerID
                }, function(data) {
                    newdata = $.parseJSON(data);
                    $(".notescontainer").html("");
                    newdata.forEach(element => {
                        date = new Date(element.reg_date * 1000);
                        newdate = date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate();
                        $(".notescontainer").append(`<div class="card bg-info text-white">
                                                        <div class="card-content">
                                                            <div class="card-body">
                                                                <h4 class="card-title text-white">${element.title}</h4>
                                                                <p class="card-text">${element.details}</p>
                                                                <span class='la la-clock'> ${newdate}</span>
                                                                <div class='mt-2'>
                                                                    <a href="#" class="btn btn-danger btnDeleteNote" data-href='${element.note_id}'><span class="la la-trash"></span></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>`);
                    });
                });
            } else {
                $(".notescontainer").html("<div style='width:100%;height:100%;display:flex;justify-content:center;align-items:center;' class='nocustomerSelected'><h2 class='text-danger'>Please select a customer first.</h2></div>");
            }
        });

        // Load all attachments
        $("#attachment-tab").on("click", function() {
            if ($("#btnaddnewAttach").attr("data-href")) {
                $(".attachcontainer").html("<div style='width:100%;height:100%;display:flex;justify-content:center;align-items:center;' class='nocustomerSelected'><i class='la la-spinner spinner' style='font-size:2rem; color:seagreen'></i></div>");
                customerID = $("#btnaddnewAttach").attr("data-href");
                $.get("../app/Controllers/Bussiness.php", {
                    "getCustomerAttach": true,
                    "cutomerID": customerID
                }, function(data) {
                    newdata = $.parseJSON(data);
                    $(".attachcontainer").html("");
                    newdata.forEach(element => {
                        $(".attachcontainer").append(`<div class="col-lg-3" style='display:flex;flex-direction:column;justify-content:center;align-items:center'>
                                                        <span class='la la-file-upload blue' style='font-size:40px'></span>
                                                        <i>${element.attachment_name} - ${element.attachment_type}</i>
                                                        <button class='btn btn-sm btn-danger btndeletattach mt-1' data-href='${element.attachment_name}'><span class='las la-trash'></span></button>
                                                    </div>`);
                    });
                });
            } else {
                $(".attachcontainer").html("<div style='width:100%;height:100%;display:flex;justify-content:center;align-items:center;' class='nocustomerSelected'><h2 class='text-danger'>Please select a customer first.</h2></div>");
            }
        });

        // Get Customer Reminder
        $("#Reminders-tab").on("click", function() {
            if ($("#btnaddnewNote").attr("data-href")) {
                $(".remindercontainer").html("<div style='width:100%;height:100%;display:flex;justify-content:center;align-items:center;' class='nocustomerSelected'><i class='la la-spinner spinner' style='font-size:2rem; color:seagreen'></i></div>");
                customerID = $("#btnaddnewNote").attr("data-href");
                $.get("../app/Controllers/Bussiness.php", {
                    "getCustomerReminder": true,
                    "cutomerID": customerID
                }, function(data) {
                    newdata = $.parseJSON(data);
                    $(".remindercontainer").html("");
                    newdata.forEach(element => {
                        $(".remindercontainer").prepend(` <div class="card crypto-card-3 bg-info">
                                                                <div class="card-content">
                                                                    <div class="card-body cc XRP pb-1">
                                                                        <h4 class="text-white mb-2"><i class="cc XRP" title="XRP"></i> ${element.title}</h4>
                                                                        <h5 class="text-white mb-1">${element.details}</h5>
                                                                        <h6 class="text-white">${element.remindate}</h6>
                                                                        <div class="mt-2">
                                                                            <a href="#" class="btn btn-danger btnDeleteReminder" data-href='${element.reminder_id}'><span class="la la-trash"></span></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>`);
                    });
                });
            } else {
                $(".remindercontainer").html("<div style='width:100%;height:100%;display:flex;justify-content:center;align-items:center;' class='nocustomerSelected'><h2 class='text-danger'>Please select a customer first.</h2></div>");
            }
        });

        // add new note to a customer
        $("#btnaddnewNote").on("click", function(e) {
            e.preventDefault();
            if ($("#addnewnotefome").valid()) {
                if ($(this).attr("data-href")) {
                    title = $("#title").val();
                    details = $("#details").val();
                    customerID = $(this).attr("data-href");
                    $.post("../app/Controllers/Bussiness.php", {
                        "addCustomerNote": true,
                        "title": title,
                        "details": details,
                        "cutomerID": customerID
                    }, function(data) {
                        if (data > 0) {
                            $(".notescontainer").prepend(`<div class="card bg-info text-white">
                                                        <div class="card-content">
                                                            <div class="card-body">
                                                                <h4 class="card-title text-white">${title}</h4>
                                                                <p class="card-text">${details}</p>
                                                                <a href="#" class="btn btn-danger btnDeleteNote" data-href='${data}'><span class="la la-trash"></span></a>
                                                            </div>
                                                        </div>
                                                    </div>`);
                        }
                    });


                    $("#title").val("");
                    $("#details").val("");
                } else {
                    $(".notescontainer").html("<div style='width:100%;height:100%;display:flex;justify-content:center;align-items:center;' class='nocustomerSelected'><h2 class='text-danger'>Please select a customer first.</h2>");
                }
            }

        });

        // Add New reminder
        $("#btnaddnewreminder").on("click", function(e) {
            e.preventDefault();
            if ($("#addnewreminderform").valid()) {
                if ($(this).attr("data-href")) {
                    title = $("#rtitle").val();
                    details = $("#rdetails").val();
                    date = $("#rdate").val();
                    customerID = $(this).attr("data-href");

                    $.post("../app/Controllers/Bussiness.php", {
                        "addCustomerReminder": true,
                        "title": title,
                        "details": details,
                        "date": date,
                        "cutomerID": customerID
                    }, function(data) {
                        if (data > 0) {
                            $(".remindercontainer").prepend(` <div class="card crypto-card-3 bg-info">
                                                                <div class="card-content">
                                                                    <div class="card-body cc XRP pb-1">
                                                                        <h4 class="text-white mb-2"><i class="cc XRP" title="XRP"></i>${title}</h4>
                                                                        <h5 class="text-white mb-1">${details}</h5>
                                                                        <h6 class="text-white">${date}</h6>
                                                                        <div class="mt-2">
                                                                            <a href="#" class="btn btn-danger btnDeleteReminder" data-href='${data}'><span class="la la-trash"></span></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>`);
                        }
                    });

                    $("#rtitle").val("");
                    $("#rdetails").val("");
                    $("#rdate").val("");
                } else {
                    $(".remindercontainer").html("<div style='width:100%;height:100%;display:flex;justify-content:center;align-items:center;' class='nocustomerSelected'><h2 class='text-danger'>Please select a customer first.</h2>");
                }
            }

        });

        // Delet Customer Note
        $(document).on("click", ".btnDeleteNote", function(e) {
            e.preventDefault();
            customerID = $(this).attr("data-href");
            parent = $(this);

            $.post("../app/Controllers/Bussiness.php", {
                "deleteCustomerNote": true,
                "cutomerID": customerID
            }, function(data) {
                if (data > 0) {
                    $(parent).parent().parent().parent().fadeOut();
                }
            });
        });

        // Delet Customer Reminder
        $(document).on("click", ".btnDeleteReminder", function(e) {
            e.preventDefault();
            customerID = $(this).attr("data-href");
            parent = $(this);

            $.post("../app/Controllers/Bussiness.php", {
                "deleteCustomerReminder": true,
                "cutomerID": customerID
            }, function(data) {
                if (data > 0) {
                    $(parent).parent().parent().parent().fadeOut();
                }
            });
        });

        // Add new Attachment
        $(document).on("submit", "#addnewattach", function(e) {
            e.preventDefault();
            formdata = new FormData(this);
            formdata.append("addAttach", "true");
            formdata.append("cus", $("#btnaddnewAttach").attr("data-href"));

            if ($("#addnewattach").valid()) {
                $.ajax({
                    url: "../app/Controllers/Bussiness.php",
                    type: "POST",
                    data: formdata,
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $("#btnaddnewAttach").addClass("d-none");
                        $("#apinneraddnewAttach").parent().children(".spinner").removeClass("d-none");
                    },
                    success: function(data) {
                        $("#btnaddnewAttach").removeClass("d-none");
                        $("#apinneraddnewAttach").parent().children(".spinner").addClass("d-none");
                        $("#addnewattach")[0].reset();
                        $(".attachcontainer").append(`<div class="col-lg-3" style='display:flex;flex-direction:column;justify-content:center;align-items:center'>
                                                        <span class='la la-file-upload blue' style='font-size:40px'></span>
                                                        <i>${data}</i>
                                                        <button class='btn btn-sm btn-danger btndeletattach mt-1' data-href='${data}'><span class='las la-trash'></span></button>
                                                    </div>`);
                    },
                    error: function(e) {
                        alert("an error occured ;)");
                    }
                });
            }
        });

        // Delete Attachment
        $(document).on("click", ".btndeletattach", function(e) {
            e.preventDefault();
            ths = $(this);
            customerID = $(this).attr("data-href");
            $.post("../app/Controllers/Bussiness.php", {
                "deleteCustomerAttach": true,
                "cutomerID": customerID
            }, function(data) {
                $(ths).parent().fadeOut();
            });
        });

        // load transactions based on amount type
        $(document).on("change", "#accountType", function(e) {
            e.preventDefault();
            currency = $(this).val();
            table.clear().draw();
            filterBalance = 0;
            counter = 0;
            $("#loading").addClass("show");
            if (currency != "na") {
                if (currency != "all") {
                    $.get("../app/Controllers/Bussiness.php", {
                        "customerID": customerID,
                        "currency": currency,
                        "getCustomerTransactions": true
                    }, function(data) {
                        newdata = $.parseJSON(data);
                        let counter = 0;
                        // Add all transactions
                        balance = 0;
                        $debet = "";
                        $crediet = "";
                        newdata[0].forEach(element => {
                            if (element.ammount_type == "Debet") {
                                $debet = element.amount;
                            } else {
                                $crediet = element.amount;
                            }
                            // date
                            date = new Date(element.reg_date * 1000);
                            newdate = date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate();

                            balance = Math.round(balance + ($debet - $crediet));
                            remarks = balance > 0 ? "DR" : balance < 0 ? "CR" : "";
                            table.row.add([
                                counter,
                                "<span class='rowT' data-href='" + element.leadger_id + "'>" + element.leadger_id + "</span>",
                                newdate,
                                element.detials,
                                element.op_type,
                                element.currency,
                                $debet,
                                $crediet,
                                balance,
                                remarks
                            ]).draw(false);
                            counter++;
                            next = false;
                            $debet = "";
                            $crediet = "";
                        });
                        $("#loading").removeClass("show");
                    });
                } else {
                    $.get("../app/Controllers/Bussiness.php", {
                        "customerID": customerID,
                        "currency": "all",
                        "getCustomerTransactions": true
                    }, function(data) {
                        newdata = $.parseJSON(data);
                        let counter = 0;
                        // Add all transactions
                        balance = 0;
                        $debet = "";
                        $crediet = "";
                        newdata[0].forEach(element => {
                            if (element.ammount_type == "Debet") {
                                if (element.rate != 0 && element.rate != null) {
                                    $debet = element.amount * element.rate;
                                } else {
                                    $debet = element.amount;
                                }
                            } else {
                                if (element.rate != 0) {
                                    $crediet = element.amount * element.rate;
                                } else {
                                    $crediet = element.amount;
                                }
                            }
                            // date
                            date = new Date(element.reg_date * 1000);
                            newdate = date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate();

                            balance = Math.round(balance + ($debet - $crediet));
                            remarks = balance > 0 ? "DR" : balance < 0 ? "CR" : "";
                            table.row.add([
                                counter,
                                "<span class='rowT' data-href='" + element.leadger_id + "'>" + element.leadger_id + "</span>",
                                newdate,
                                element.detials,
                                element.op_type,
                                element.currency,
                                $debet,
                                $crediet,
                                balance,
                                remarks
                            ]).draw(false);
                            counter++;
                            next = false;
                            $debet = "";
                            $crediet = "";
                        });
                    });
                    $("#loading").removeClass("show");
                }
            }
        });

        // filter table based on date range
        // Custom filtering function which will search data in column four between two values
        // Create date inputs
        minDate = new DateTime($('#min'), {
            format: 'Y/m/d'
        });
        maxDate = new DateTime($('#max'), {
            format: 'Y/m/d'
        });

        // Refilter the table
        pushCount = 0;
        $('#min,#max').on('change', function() {
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var min = minDate.val();
                    var max = maxDate.val();
                    var date = new Date(data[1]);
                    if (
                        (min === null && max === null) ||
                        (min === null && date <= max) ||
                        (min <= date && max === null) ||
                        (min <= date && date <= max)
                    ) {
                        return true;
                    }
                    return false;
                }
            );
            pushCount++;
            table.draw();
        });

        $("#btnclearfilter").on("click", function() {
            $("#max").val('');
            $("#min").val('');
            for (i = 1; i <= pushCount; i++) {
                $.fn.dataTable.ext.search.pop();
            }
            pushCount = 0;
            table.draw();
        });

        // show transaction details when clicked on leadger
        tblTDetails = $("#TDetailsTable").DataTable();
        $(document).on("click", ".rowT", function() {
            LID = $(this).attr("data-href");
            tblTDetails.clear();
            $("#loading").addClass("show");
            $.get("../app/Controllers/Bussiness.php", {
                "tDetails": true,
                "LID": LID,
            }, function(data) {
                ndata = $.parseJSON(data);
                PrevID = [];
                ndata.forEach((element, index) => {
                    if (!PrevID.includes(element.account_money_id)) {
                        // date
                        date = new Date(element.reg_date * 1000);
                        newdate = date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate();
                        tblTDetails.row.add([
                            index,
                            element.leadger_id,
                            element.account_name,
                            element.remarks,
                            newdate,
                            element.currency,
                            element.amount,
                            element.ammount_type
                        ]).draw(false);
                    }
                    PrevID.push(element.account_money_id);
                });
                $("#TDetailsModel").modal("show");
                $("#loading").removeClass("show");
            });
        });

        // edite Customer
        // $(document).on("click",".btnEditCus",function(e){
        //     e.preventDefault();
        //     ths = $(this);
        //     cusID = $(ths).attr("data-href");
        //     alert(cusID);
        // });
    });

    // Initialize validation
    $("#addnewnotefome").validate({
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

    // Initialize validation
    $("#addnewattach").validate({
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

    // Initialize validation
    $("#addnewreminderform").validate({
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