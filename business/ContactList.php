<?php
$Active_nav_name = array("parent" => "Contact", "child" => "Contact List");
$page_title = "Customers";
include("./master/header.php");

$bussiness = new Bussiness();

// Get all Customers of this company
$allCustomers_data = $bussiness->getCompanyCustomers($user_data->company_id, $user_data->user_id);
$allCustomers = $allCustomers_data->fetchAll(PDO::FETCH_OBJ);
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

    /* 
    .detais span {
        font-size: 1.2rem;
    } */
</style>

<!-- END: Main Menu-->
<!-- BEGIN: Content-->
<div class="row p-2 m-0">
    <div class="col-md-12 col-lg-4 p-0 m-0" style="height: 80vh; overflow-y: scroll;">
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
                                </tr>
                            </thead>
                            <tbody>
                                <?php $prevCus = "";
                                foreach ($allCustomers as $customer) {
                                    if ($customer->fname != $prevCus) {
                                        $balance_data = $bussiness->getCustomerAllTransaction($customer->customer_id);
                                        $res2 = $balance_data->fetchAll(PDO::FETCH_OBJ);
                                        $debet = 0;
                                        $crediet = 0;
                                        foreach ($res2 as $r2) {
                                            if ($r2->ammount_type == "Debet") {
                                                $debet += $r2->amount;
                                            } else {
                                                $crediet += $r2->amount;
                                            }
                                        } ?>
                                        <tr>
                                            <td><a href="#" data-href="<?php echo $customer->customer_id; ?>" class="showcustomerdetails"><?php echo $customer->fname . " " . $customer->lname; ?></a></td>
                                            <td><?php echo $debet - $crediet; ?></td>
                                        </tr>
                                <?php $prevCus = $customer->fname;
                                    }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        <!-- Material Data Tables -->
    </div>

    <div class="col-md-12 col-lg-8" style="height: 80vh; overflow-y: scroll">
        <div style='width:100%;height:100%;display:flex;justify-content:center;align-items:center;'>
            <h2 id="Nocustomer">Please select a customer</h2>
            <i class='la la-spinner spinner d-none' id="customerSpinner" style='font-size:3rem; color:dodgerblue'></i>
        </div>
        <div class="card d-none" id="customerContainer" style="height: 77.5vh;">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-6" id="customerInfo1">
                        <div class="detais">
                            <span>First Name:</span>
                            <span id="fname"></span>
                        </div>
                        <div class="detais">
                            <span>Last Name:</span>
                            <span id="lname"></span>
                        </div>
                        <div class="detais">
                            <span>Company Name:</span>
                            <span id="company_name"></span>
                        </div>
                        <div class="detais">
                            <span>Account Type:</span>
                            <div id="accountTypeContainer">

                            </div>
                        </div>
                        <div class="detais">
                            <span>Account Number:</span>
                            <span id="accountNumber"></span>
                        </div>
                        <div class="detais">
                            <span>Address:</span>
                            <span id="address"></span>
                        </div>
                    </div>
                    <div class="col-sm-6">
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
                                <div class="table-responsive">
                                    <table class="table material-table" id="SinglecustomerTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Number</th>
                                                <th>Debet</th>
                                                <th>Credit</th>
                                                <th>Details</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
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
</div>
<!-- END: Content-->
<?php
include("./master/footer.php");
?>
<script>
    $(document).ready(function() {
        // hide all error messages
        setInterval(function() {
            $(".nocustomerSelected").fadeOut();
        }, 3000);



        table = $('#SinglecustomerTable').DataTable();
        table.destroy();
        table = $('#SinglecustomerTable').DataTable({
            scrollY: '10vh',
            dom: 'Bfrtip',
            stateSave: true,
            colReorder: true,
            select: true,
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


        table1 = $('#customersTable').DataTable();
        table1.destroy();
        table1 = $('#customersTable').DataTable({
            scrollY: '49vh'
        });

        // Show customer details 
        $(document).on("click", ".showcustomerdetails", function(e) {
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
                AllAccounts = $.parseJSON(data[3].Accounts);
                transactions = $.parseJSON(data[1].transactions)
                transactionsExch = $.parseJSON(data[2].exchangeTransactions)

                // add personal data
                $("#fname").text(personalData.fname);
                $("#lname").text(personalData.lname);
                $("#company_name").text(personalData.company_id);

                accounts = "";
                AllAccounts.forEach(element => {
                    accounts += "<option value='" + element.currency_id + "'>" + element.currency + "</option>";
                });
                $("#accountTypeContainer").html(`<select id="accountType" class="form-control">
                                    <option value="all" selected>All</option>
                                    ${accounts}
                                </select>`);

                // $("#fname").text(personalData.fname);
                $("#address").text(personalData.detail_address);
                $("#phone1").text(personalData.personal_phone);
                $("#phone2").text(personalData.personal_phone_second);
                $("#office_phone").text(personalData.official_phone);
                $("#email").text(personalData.email);
                $("#website").text(personalData.website);
                $("#fax").text(personalData.fax);


                t = $("#SinglecustomerTable").DataTable();
                t.clear().draw(false);

                let counter = 0;
                // Add all transactions
                transactions.forEach(element => {
                    data = $.parseJSON(element);
                    data.forEach(element => {
                        // date
                        date = new Date(element.reg_date * 1000);
                        newdate = date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate();
                        debet = 0;
                        credit = 0;
                        if (element.ammount_type == "Debet") {
                            debet = element.amount;
                            credit = 0;
                        } else {
                            credit = element.amount;
                            debet = 0;
                        }

                        t.row.add([
                            counter,
                            newdate,
                            element.leadger_id,
                            debet,
                            credit,
                            element.remarks
                        ]).draw(false);
                        counter++;
                    });
                });

                transactionsExch.forEach(element => {
                    // date
                    date = new Date(element.reg_date * 1000);
                    newdate = date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate();

                    debet = "";
                    crediet = "";
                    $.get("../app/Controllers/Bussiness.php", {
                        "getCurrencyDetails": true,
                        "DebetID": element.debt_currecny_id,
                        "creditID": element.credit_currecny_id
                    }, function(data) {
                        newdata = $.parseJSON(data);
                        debet = element.debt_amount + " - " + newdata.debet.currency;
                        crediet = element.credit_amount + " - " + newdata.credeit.currency;
                        t.row.add([
                            counter,
                            newdate,
                            element.leadger_id,
                            debet,
                            crediet,
                            element.details
                        ]).draw(false);
                    });
                    counter++;
                });

                // Set New Note button data href to customer id
                $("#btnaddnewNote").attr("data-href", customerID);
                $("#btnaddnewreminder").attr("data-href", customerID);
                $("#btnaddnewAttach").attr("data-href", customerID);

                $("#customerSpinner").addClass("d-none");
                $("#customerSpinner").parent().addClass("d-none");
                $("#customerContainer").removeClass("d-none");
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
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
        $("#attachment-tab").on("click", function(){
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
        $(document).on("submit","#addnewattach",function(e){
            e.preventDefault();
            formdata = new FormData(this);
            formdata.append("addAttach","true");
            formdata.append("cus",$("#btnaddnewAttach").attr("data-href"));

            if($("#addnewattach").valid())
            {
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
        $(document).on("click",".btndeletattach",function(e){
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