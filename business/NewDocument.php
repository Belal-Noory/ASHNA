<?php
$Active_nav_name = array("parent" => "Accounting", "child" => "New Document");
$page_title = "New Document";
include("./master/header.php");

$company = new Company();
$revenue = new Expense();

$allcurrency_data = $company->GetCompanyCurrency($user_data->company_id);
$allcurrency = $allcurrency_data->fetchAll(PDO::FETCH_OBJ);
?>

<div class="container pt-5">
    <div class="bs-callout-primary mb-2">
        <div class="media align-items-stretch">
            <div class="media-left media-middle bg-pink d-flex align-items-center p-2">
                <i class="la la-sun-o white font-medium-5"></i>
            </div>
            <div class="media-body p-1">
                <strong>Attention Please!</strong>
                <p>While deleting rows from the table below please delete from the last one.</p>
            </div>
        </div>
    </div>
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
                    <form id="formDocument">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <input type="date" id="date" class="form-control required" placeholder="Date" name="date">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="currency">Currency</label>
                                    <select id="currency" class="form-control" placeholder="Currency" name="currency">
                                        <?php
                                        foreach ($allcurrency as $currency) {
                                            echo "<option value='$currency->company_currency_id'>$currency->currency</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="details">Description</label>
                                    <textarea id="details" class="form-control required" placeholder="Description" name="details" rows="1" style='border:none;border-bottom:1px solid gray'></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <button type="button" id="btnaddrow" class="btn btn-icon btn-dark mr-1 mb-1 waves-effect waves-light"><i class="la la-plus"></i></button>
                            <div class="badge badge-info">Debet: <span id="dubet">0</span></div>
                            <div class="badge badge-danger">Credit: <span id="credit">0</span></div>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Account</th>
                                        <th>Sub Account</th>
                                        <th>Description</th>
                                        <th>Debet</th>
                                        <th>Credit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody id="table">
                                    <tr>
                                        <td>1</td>
                                        <td>
                                            <select id="account" class="form-control account" name="account">
                                                <option value="NA">Select</option>
                                                <option value="cus">Contact</option>
                                                <option value="Bank">Bank</option>
                                                <option value="Saif">Saif</option>
                                                <option value="Revenue">Revenue</option>
                                                <option value="Expense">Expense</option>
                                                <option value="Assets">Assets</option>
                                                <option value="Liablity">Liablity</option>
                                                <option value="Capital">Capital</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select id="subaccount" class="form-control required" name="subaccount">
                                                <option value="0">Select</option>
                                            </select>
                                        </td>
                                        <td>
                                            <textarea name="accdetails" id="accdetails" rows="1" placeholder="Details" class="form-control required" style='border:none;border-bottom:1px solid gray'></textarea>
                                        </td>
                                        <td>
                                            <input type="number" name="debetamount" data-initial="0" id="debetamount" placeholder="Debet" class="form-control debet">
                                        </td>
                                        <td>
                                            <input type="number" name="creditamount" data-initial="0" id="creditamount" placeholder="Credit" class="form-control credit">
                                        </td>
                                        <td>

                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <button type="button" id="btnadddocument" class="btn btn-icon btn-pink mr-1 mb-1 waves-effect waves-light"><i class="la la-save"></i> Save</button>
                        <input type="hidden" name="rowCount" id="rowCount" value="1">
                        <input type="hidden" name="adddocument">
                    </form>
                </div>
            </div>
        </div>
    </section>

    <div class="bs-callout-pink callout-border-left mt-1 p-1 mt-2 d-none error">
        <strong>Debet VS Credit!</strong>
        <p></p>
    </div>
    <!-- Material Data Tables -->
</div>

<!-- Modal -->
<div class="modal fade text-center" id="show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true">
    <div class="modal-dialog" role="document">
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

                <div class="container container-done d-none">
                    <i class="font-large-2 icon-line-height la la-check" style="color: seagreen;"></i>
                    <h5>Document Added</h5>
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

        setInterval(function() {
            $(".error").addClass("d-none");
        }, 5000);

        $(document).on("click", ".deleteRow", function(e) {
            e.preventDefault();
            $(this).parent().parent().fadeOut();
        });

        rowCount = 2;
        fieldCounts = 1;
        // add row to table
        $("#btnaddrow").on("click", function() {
            account = "account" + fieldCounts;
            subaccount = "subaccount" + fieldCounts;
            details = "accdetails" + fieldCounts;
            debetamount = "debetamount" + fieldCounts;
            creditamount = "creditamount" + fieldCounts;

            row = ` <tr>
                        <td>${rowCount}</td>
                        <td>
                            <select id="${account}" class="form-control account" name="${account}">
                                <option value="NA">Select</option>
                                <option value="cus">Contact</option>
                                <option value="Bank">Bank</option>
                                <option value="Saif">Saif</option>
                                <option value="Revenue">Revenue</option>
                                <option value="Expense">Expense</option>
                                <option value="Assets">Assets</option>
                                <option value="Liablity">Liablity</option>
                                <option value="Capital">Capital</option>
                            </select>
                        </td>
                        <td>
                            <select id="${subaccount}" class="form-control required" name="${subaccount}">
                            <option value="0">Select</option>
                            </select>
                        </td>
                        <td>
                            <textarea name="${details}" id="${details}" rows="1" placeholder="Details" class="form-control required" style='border:none;border-bottom:1px solid gray'></textarea>
                        </td>
                        <td>
                            <input type="number" data-initial="0" name="${debetamount}" id="${debetamount}" placeholder="Debet" class="form-control debet">
                        </td>
                        <td>
                            <input type="number" data-initial="0" name="${creditamount}" id="${creditamount}" placeholder="Credit" class="form-control credit">
                        </td>
                        <td>
                            <a href="#" class="deleteRow"><span class="las la-trash red" style="font-size: 25px;"></span></a>
                        </td>
                    </tr>`;
            $("#table").append(row);
            $("#rowCount").val(rowCount);
            rowCount++;
        });


        // load sub accounts based on accounts
        $(document).on("change", ".account", function() {
            type = $(this).val();
            ths = $(this);

            options = "";
            if (type == "cus") {
                // Load company Banks
                cuslist = Array();
                $.get("../app/Controllers/banks.php", {
                    "getcompanyCustomers": true
                }, function(data) {
                    newdata = $.parseJSON(data);
                    cuslist = newdata;
                    if (cuslist.length > 0) {
                        cuslist.forEach(element => {
                            options += "<option value='" + element.chartofaccount_id + "'>" + element.account_name + " - " + element.currency + "</option>";
                        });
                    } else {
                        options += "<option value='0'>No Account</option>";
                    }
                    $(ths).parent().parent().children("td:nth-child(3)").children("select").html(options);
                });
            } else {
                // Load company Banks
                list = Array();
                $.get("../app/Controllers/banks.php", {
                    "getcompanyAccount": true,
                    "type": type
                }, function(data) {
                    newdata = $.parseJSON(data);
                    list = newdata;
                    if (list.length > 0) {
                        list.forEach(element => {
                            options += "<option value='" + element.chartofaccount_id + "'>" + element.account_name + " - " + element.currency + "</option>";
                        });
                    } else {
                        options += "<option value='0'>No Account</option>";
                    }
                    $(ths).parent().parent().children("td:nth-child(3)").children("select").html(options);
                });
            }

        });

        // total debets
        var debets = 0;
        var credit = 0;

        $(document).on("blur", ".debet", function() {
            initial = parseFloat($(this).attr("data-initial"));
            val = parseFloat($(this).val());
            if (!isNaN(val)) {
                if (initial == 0) {
                    $(this).attr("data-initial", val);
                    debets += val;
                } else {
                    debets = (debets - initial) + val;
                }
                $("#dubet").text(debets);
            }
        });

        $(document).on("blur", ".credit", function() {
            initial = parseFloat($(this).attr("data-initial"));
            val = parseFloat($(this).val());
            if (!isNaN(val)) {
                if (initial == 0) {
                    $(this).attr("data-initial", val);
                    credit += val;
                } else {
                    credit = (credit - initial) + val;
                }
                $("#credit").text(credit);
            }
        });

        // Add new document
        $("#btnadddocument").on("click", function() {
            // check all debet amount
            if (debets == credit && debets > 0 && credit > 0) {
                if ($("#formDocument").valid()) {
                    $("#show").modal("show");
                    $.post("../app/Controllers/Document.php", $("#formDocument").serialize(), function(data) {
                        console.log(data);
                        $(".container-waiting").addClass("d-none");
                        $(".container-done").removeClass("d-none");
                        setTimeout(function() {
                            $("#show").modal("hide");
                        }, 2000);
                        $("#formDocument")[0].reset();
                        $("#table").children('tr:not(:first)').remove();
                    });
                }
            } else {
                $(".error").removeClass("d-none").children("p").text("There are deferences between Debet and Credit, please check it once again");
            }
        });
    });

    // Initialize validation
    $("#formDocument").validate({
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