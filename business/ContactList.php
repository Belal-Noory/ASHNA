<?php
$Active_nav_name = array("parent" => "Contact", "child" => "Contact List");
include("./master/header.php");
$bussiness = new Bussiness();

// Get all Customers of this company
$allCustomers_data = $bussiness->getCompanyCustomers($user_data->company_id, $user_data->user_id);
$allCustomers = $allCustomers_data->fetchAll(PDO::FETCH_OBJ);
?>

<style>
    .detais {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        margin-bottom: 4px;
    }

    .detais span {
        font-size: 1.2rem;
    }
</style>

<!-- END: Main Menu-->
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <h2>Contacts List</h2>

            <div class="row">
                <div class="col-md-12 col-lg-4">
                    <!-- Material Data Tables -->
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
                                                <th>Name</th>
                                                <th>Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($allCustomers as $customer) { ?>
                                                <tr>
                                                    <td><a href="#" data-href="<?php echo $customer->customer_id; ?>" class="showcustomerdetails"><?php echo $customer->fname . " " . $customer->lname; ?></a></td>
                                                    <td>12800</td>
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
                    <div class="card">
                        <div class="card-header">
                            <h4 class="m-2">Customer Details</h4>
                            <div class="row p-2">
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
                                            <a class="nav-link" id="contacts-tab" data-toggle="tab" href="#contactsPanel" aria-controls="linkIcon12" aria-expanded="false">
                                                <i class="ft-user"></i> Contacts
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
                                    </ul>
                                    <div class="tab-content px-1 pt-1">
                                        <div role="tabpanel" class="tab-pane active" id="transactionsPanel" aria-labelledby="transactions-tab" aria-expanded="true">
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
                                                            <table class="table material-table" id="customerTable">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Date</th>
                                                                        <th>Number</th>
                                                                        <th>Remarks</th>
                                                                        <th>Debet</th>
                                                                        <th>Credit</th>
                                                                        <th>Balance</th>
                                                                        <th>Currency</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                        <div class="tab-pane" id="contactsPanel" role="tabpanel" aria-labelledby="contacts-tab" aria-expanded="false">
                                            <h2>contacts</h2>
                                        </div>
                                        <div class="tab-pane" id="notesPanel" role="tabpanel" aria-labelledby="Notes-tab" aria-expanded="false">
                                            <h2>Notes</h2>
                                        </div>
                                        <div class="tab-pane" id="remindersPanel" role="tabpanel" aria-labelledby="Reminders-tab" aria-expanded="false">
                                            <h2>Reminders</h2>
                                        </div>
                                    </div>
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
<?php
include("./master/footer.php");
?>
<script>
    $(document).ready(function() {
        $(document).on("click", ".showcustomerdetails", function(e) {
            e.preventDefault();
            customerID = $(this).attr("data-href");
            $.get("../app/Controllers/Bussiness.php", {
                "getCustomerByID": true,
                "customerID": customerID,
                "getAllTransactions": true
            }, function(data) {
                data = $.parseJSON(data);
                console.log(data);
                personalData = $.parseJSON(data[0].personalData);
                AllAccounts = $.parseJSON(data[3].Accounts);
                console.log(AllAccounts);

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


                t = $("#customerTable").DataTable();
                t.clear().draw(false);

                t.row.add([
                    '.1',
                    '.2',
                    '.3',
                    '.4',
                    '.5',
                    '.5',
                    '.5',
                    '.5'
                ]).draw(false);
            });
        });
    });
</script>