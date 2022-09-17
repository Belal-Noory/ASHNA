<?php
$Active_nav_name = array("parent" => "Settings", "child" => "User Management");
$page_title = "User Management";
include("./master/header.php");

$bussiness = new Bussiness();

// Get all Customers of this company
$allCustomers_data = $bussiness->getCompanyUsers($user_data->company_id);
$allCustomers = $allCustomers_data->fetchAll(PDO::FETCH_OBJ);
?>

<div class="container pt-2">
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
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($allCustomers as $customer) { ?>
                                <tr>
                                    <td><?php echo $customer->fname ?></td>
                                    <td><?php echo $customer->lname ?></td>
                                    <td>
                                        <?php
                                        $login_data = $bussiness->checkLogin($customer->customer_id);
                                        $login_count = $login_data->rowCount();
                                        if ($login_count <= 0) { ?>
                                            <a href="#" data-href="<?php echo $customer->customer_id; ?>" class="btn btn-blue btnaddlogin"><span class="las la-plus"></span> Add Login</a>
                                            <?php } else {
                                            $login_details = $login_data->fetch(PDO::FETCH_OBJ);
                                            if ($login_details->block == 0) { ?>
                                                <a href="#" data-href="<?php echo $customer->customer_id; ?>" class="btn btn-danger btnblocklogin"><span class="las la-lock"></span>Block Login</a>
                                            <?php } else { ?>
                                                <a href="#" data-href="<?php echo $customer->customer_id; ?>" class="btn btn-danger btnunblocklogin"><span class="las la-lock"></span>Unblock Login</a>
                                        <?php }
                                        } ?>
                                        <a href="#" data-href="<?php echo $customer->customer_id; ?>" class="btn btn-primary btnshowpermissions"><span class="las la-users"></span>Permissions</a>
                                        <a href="#" data-href="<?php echo $customer->customer_id; ?>" class="btn btn-blue btnshowbankssaifs"><span class="las la-home"></span>Banks/Saifs</a>
                                    </td>
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
                    <h5>Successfully Added</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade text-center" id="showp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body p-2">
                <div class="col-lg-12">
                    <ul class="nav nav-tabs nav-underline no-hover-bg">
                        <li class="nav-item">
                            <a class="nav-link active waves-effect waves-dark" id="modelTab" data-toggle="tab" aria-controls="modelPanel" href="#modelPanel" aria-expanded="true">Models</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link waves-effect waves-dark" id="submodelTab" data-toggle="tab" aria-controls="submodelPanel" href="#submodelPanel" aria-expanded="false">Sub-Models</a>
                        </li>
                    </ul>
                    <div class="tab-content px-1 pt-1">
                        <div role="tabpanel" class="tab-pane active" id="modelPanel" aria-expanded="true" aria-labelledby="modelTab">
                            <form class="form" id="newmodel">
                                <div class="form-body">
                                    <p style="line-height: 26px; border:none" class="form-section text-danger">If you block this model, the user will be not be able to user it</p>
                                    <div class="col-md-12 text-left">
                                        <div class="form-group">
                                            <label for="modelname">Model</label>
                                            <select id="modelname" name="modelname" class="form-control required">
                                            </select>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary" id="addnewcompanymodeul">
                                        <i class="la la-lock"></i> Block Model
                                    </button>
                                </div>
                            </form>

                            <!-- Basic Tables start -->
                            <div class="col-12 mt-5">
                                <div class="card">
                                    <div class="card-content collapse show">
                                        <div class="card-body">
                                            <p><span class="text-bold-600">Models that are denied for the user</p>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Model</th>
                                                            <th>Ublock Model</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="companyDeniedModelsTable" class="text-left">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="submodelPanel" aria-labelledby="submodelTab">
                            <form class="form" id="newmodelTab2">
                                <div class="form-body">
                                    <div class="col-md-12 text-left">
                                        <div class="form-group">
                                            <label for="modelname2">Model</label>
                                            <select id="modelname2" name="modelname2" class="form-control required">
                                            </select>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary" id="addnewcruidblock">
                                        <i class="la la-lock"></i> Block Operation
                                    </button>
                                </div>
                            </form>

                            <!-- Basic Tables start -->
                            <div class="col-12 mt-5">
                                <div class="card">
                                    <div class="card-content collapse show">
                                        <div class="card-body">
                                            <p><span class="text-bold-600">Models that are denied for the user</p>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Model</th>
                                                            <th>Ublock Model</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="companyDeniedModelsTable2" class="text-left">

                                                    </tbody>
                                                </table>
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
</div>

<!-- Modal Banks/SAifs -->
<div class="modal fade text-center" id="showbankssaifs" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body p-2">
                <ul class="nav nav-tabs nav-underline nav-justified">
                    <li class="nav-item">
                        <a class="nav-link active" id="Ass-tab" data-toggle="tab" href="#AssPanel" aria-controls="activeIcon12" aria-expanded="true">
                            <i class="ft-cog"></i> Assigned
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="notA-tab" data-toggle="tab" href="#notAPanel" aria-controls="linkIconOpt11">
                            <i class="ft-external-link"></i> Not Assigned
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="AssPanel" aria-labelledby="Ass-tab" aria-expanded="true">
                        <table class="table" id="Assuseraccounts">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Account</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                    <div class="tab-pane" id="notAPanel" role="tabpanel" aria-labelledby="notA-tab" aria-expanded="false">
                        <table class="table" id="NotAssuseraccounts">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Account</th>
                                    <th>Type</th>
                                    <th>Action</th>
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
</div>
<?php
include("./master/footer.php");
?>

<script>
    $(document).ready(function() {
        tblNotAssUserAcc = $("#NotAssuseraccounts").DataTable();
        tblAssUserAcc = $("#Assuseraccounts").DataTable();

        // Add login to users
        $(document).on("click", ".btnaddlogin", function(e) {
            e.preventDefault();
            ths = $(this);
            cusID = $(ths).attr("data-href");
            username = $(ths).parent().parent().children("td:nth-child(1)").text() + $(ths).parent().parent().children("td:nth-child(2)").text();
            $("#show").modal("show");

            $.post("../app/Controllers/Company.php", {
                "addcompanyLoginUser": true,
                "cusID": cusID,
                "username": username
            }, function(data) {
                $(".container-waiting").addClass("d-none");
                $(".container-done").removeClass("d-none");
                $(".container-done").children("h5").append("<h4>User Name: " + username + " | Password: " + data + "</h4>");
                $(ths).fadeOut();
            });
        });

        // Show the module model
        $(document).on('click', '.btnshowpermissions', function(e) {
            e.preventDefault();
            ths = $(this);
            cusID = $(ths).attr("data-href");

            // Get Models that not denied for the company yet
            $.get("../app/Controllers/Company.php", {
                "getcompanymodels": "true",
                "cusID": cusID
            }, (data) => {
                let models = $.parseJSON(data);
                $("#modelname").empty();

                $("#modelname").append("<option value='' selected>Select Model</option>");
                for (var i = 0; i < models.length; i++) {
                    $("#modelname").append("<option value='" + models[i].id + "'>" + models[i].name_english + "</option>");
                }

                $("#addnewcompanymodeul").attr("data-href", cusID);
            });

            // Get sub Models that not denied for the company users yet
            $.get("../app/Controllers/Company.php", {
                "getcompanySubmodels": "true",
                "cusID": cusID
            }, (data) => {
                let models = $.parseJSON(data);
                $("#modelname2").empty();
                $("#modelname2").append("<option value='' selected>Select Model</option>");
                for (var i = 0; i < models.length; i++) {
                    $("#modelname2").append("<option value='" + models[i].id + "'>" + models[i].name_english + "</option>");
                }

                $("#addnewcruidblock").attr("data-href", cusID);
            });

            // Get Models that are denied for the company
            $.get("../app/Controllers/Company.php", {
                "getCompanyUserDenyModel": "true",
                "cusID": cusID
            }, (data) => {
                let Deniedmodels = $.parseJSON(data);
                $("#companyDeniedModelsTable").empty();

                for (var i = 0; i < Deniedmodels.length; i++) {
                    $("#companyDeniedModelsTable").append("<tr><td>" + Deniedmodels[i].name_english + "</td><td><a href='#' data-href='" + Deniedmodels[i].company_user_model_id + "' areaVisible='" + cusID + "' class='btn btn-sm btn-danger btnDeleteCompanyModel'><span class='la la-lock-open'></span></a></td></tr>");
                }
            });

            // Get Models CRUID that are denied for the company users to perform CRUID
            $.get("../app/Controllers/Company.php", {
                "getCompanyUserCRUIDModel": "true",
                "cusID": cusID
            }, (data) => {
                let Deniedmodels = $.parseJSON(data);
                $("#companyDeniedModelsTable2").empty();

                for (var i = 0; i < Deniedmodels.length; i++) {
                    $("#companyDeniedModelsTable2").append("<tr><td>" + Deniedmodels[i].name_english + "</td><td><a href='#' data-href='" + Deniedmodels[i].company_user_rule_id + "' class='btn btn-sm btn-danger btnDeleteCompanyUserSubModel'><span class='la la-lock-open'></span></a></td></tr>");
                }
            });

            $("#showp").modal("show");
        });

        // show Not Assigned banks/saifs model
        counterAss = 1;
        counterNotAss = 1;
        $(document).on("click", ".btnshowbankssaifs", function(e) {
            e.preventDefault();
            cusID = $(this).attr("data-href");
            // Get Not Assigned banks/saifs of users
            tblNotAssUserAcc.clear();
            $.get("../app/Controllers/banks.php", {
                "getuserbankssaifs": "true",
                "cusID": cusID
            }, function(data) {
                ndata = $.parseJSON(data);
                console.log(ndata);

                // Not Assigned
                NotAss = ndata[0];
                NotAss.forEach(element => {
                    btn = `<a href='#' user='${cusID}' acc='${element.chartofaccount_id}' class='btn btn-sm btn-blue btnaddAcc'><span class='las la-plus 2x'></span><span class='las la-spinner spinner 2x d-none'></span></a>`;
                    tblNotAssUserAcc.row.add([counterNotAss, element.account_name, element.currency, btn]).draw(false);
                    counterNotAss++;
                });

                // Assigned
                Ass = ndata[1];
                if(Ass !== 0)
                {
                    Ass.forEach(element => {
                        btn = `<a href='#' user='${cusID}' acc='${element.chartofaccount_id}' class='btn btn-sm btn-danger btnremoveAcc'><span class='las la-trash 2x'></span><span class='las la-spinner spinner 2x d-none'></span></a>`;
                        tblAssUserAcc.row.add([counterAss, element.account_name, element.currency, btn]).draw(false);
                        counterAss++;
                    });
                }
                $("#showbankssaifs").modal("show");
            });
        });

        // Add company module
        $("#addnewcompanymodeul").on("click", () => {
            cusID = $(ths).attr("data-href");
            if ($("#newmodel").valid()) {
                let li_ID = $("#modelname").val();
                $.post("../app/Controllers/Company.php", {
                    "addUserDenyModel": true,
                    "cusID": cusID,
                    "modelname": li_ID
                }, (data) => {
                    // Add the model to the table
                    $("#companyDeniedModelsTable").append("<tr><td>" + $("#modelname option:selected").text() + "</td><td><a href='#' data-href='" + data + "' areaVisible='" + cusID + "' class='btn btn-sm btn-danger btnDeleteCompanyModel'><span class='la la-lock-open'></span></a></td></tr>");
                    $("#modelname option[value='" + li_ID + "']").remove();
                    $("#modelname2 option[value='" + li_ID + "']").remove();
                    document.getElementById("newmodel").reset();
                });
            }
        });

        // Delete added models in show company model
        $(document).on("click", ".btnDeleteCompanyModel", function() {
            let modelID = $(this).attr("data-href");
            let cusID = $(this).attr("areaVisible");

            console.log(modelID + "|" + cusID);
            // remove Company model
            $.post("../app/Controllers/Company.php", {
                "removeCompanyUserModel": "true",
                "modelID": modelID,
                "cusID": cusID
            }, (data) => {
                console.log(data);
                if (data > 0) {
                    // Load the models again
                    // Get Models that not denied for the company yet
                    $.get("../app/Controllers/Company.php", {
                        "getcompanymodels": "true",
                        "cusID": cusID
                    }, (data) => {
                        let models = $.parseJSON(data);
                        $("#modelname").empty();
                        $("#modelname2").empty();
                        $("#modelname").append("<option value='' selected>Select Model</option>");
                        $("#modelname2").append("<option value='' selected>Select Model</option>");

                        for (var i = 0; i < models.length; i++) {
                            $("#modelname").append("<option value='" + models[i].id + "'>" + models[i].name_english + "</option>");
                            $("#modelname2").append("<option value='" + models[i].id + "'>" + models[i].name_english + "</option>");
                        }
                    });
                    $(this).parent().parent().fadeOut();
                }
            });
        });

        // block operation on user
        $(document).on("click", "#addnewcruidblock", function() {
            cusID = $(this).attr("data-href");
            modelID = $("#modelname2").val();

            $.post("../app/Controllers/Company.php", {
                "addUserSubDenyModel": true,
                "cusID": cusID,
                "modelname": modelID
            }, (data) => {
                // Add the model to the table
                $("#companyDeniedModelsTable2").append("<tr><td>" + $("#modelname2 option:selected").text() + "</td><td><a href='#' data-href='" + data + "' areaVisible='" + cusID + "' class='btn btn-sm btn-danger btnDeleteCompanyUserSubModel'><span class='la la-lock-open'></span></a></td></tr>");
                $("#modelname2 option[value='" + modelID + "']").remove();
                document.getElementById("newmodelTab2").reset();
            });
        });

        // delete company user Sub model
        $(document).on("click", ".btnDeleteCompanyUserSubModel", function(e) {
            e.preventDefault();
            let ID = $(this).attr("data-href");
            // remove Company model
            $.post("../app/Controllers/Company.php", {
                "removeCompanyUserSubModel": "true",
                "ID": ID
            }, (data) => {
                if (data > 0) {
                    // Load the models again
                    // Get Models that not denied for the company yet
                    $.get("../app/Controllers/Company.php", {
                        "getCompanyUserCRUIDModel": "true",
                        "cusID": cusID
                    }, (data) => {
                        let Deniedmodels = $.parseJSON(data);
                        $("#companyDeniedModelsTable2").empty();

                        for (var i = 0; i < Deniedmodels.length; i++) {
                            $("#companyDeniedModelsTable2").append("<tr><td>" + Deniedmodels[i].name_english + "</td><td>" + Deniedmodels[i].op_type + "</td><td><a href='#' data-href='" + Deniedmodels[i].company_user_rule_id + "' class='btn btn-sm btn-danger btnDeleteCompanyUserSubModel'><span class='la la-lock-open'></span></a></td></tr>");
                        }
                    });
                    $(this).parent().parent().fadeOut();
                }
            });
        });

        // Block Login
        $(document).on("click", ".btnblocklogin", function(e) {
            e.preventDefault();
            cusID = $(this).attr("data-href");
            ths = $(this);
            $("#show").modal("show");
            $.post("../app/Controllers/Company.php", {
                "blockLogin": true,
                "cusID": cusID
            }, function(data) {
                $(".container-waiting").addClass("d-none");
                $(".container-done").removeClass("d-none");
                $(ths).removeClass("btnblocklogin").addClass("btnunblocklogin").text("Unblock Login");
            });
        });

        // Unblock Login
        $(document).on("click", ".btnunblocklogin", function(e) {
            e.preventDefault();
            cusID = $(this).attr("data-href");
            ths = $(this);
            $("#show").modal("show");
            $.post("../app/Controllers/Company.php", {
                "unblockLogin": true,
                "cusID": cusID
            }, function(data) {
                $(".container-waiting").addClass("d-none");
                $(".container-done").removeClass("d-none");
                $(ths).removeClass("btnunblocklogin").addClass("btnblocklogin").text("Block Login");
            });
        });

        // Assign Bank/Safi to customer
        $(document).on("click",".btnaddAcc",function(e){
            e.preventDefault();
            ths = $(this);

            if (!$(this).is("[disabled]")) {
                user = $(this).attr("user");
                acc = $(this).attr("acc");
                
                accountName = $(this).parent().parent().children("td:nth-child(2)").text();
                currency = $(this).parent().parent().children("td:nth-child(3)").text();
                
                // button option
                $(ths).children("span:first-child()").addClass("d-none");
                $(ths).children("span:last-child()").removeClass("d-none");
                $(ths).attr("disabled",true);

                $.post("../app/Controllers/banks.php", {
                    "assignAcc": "true",
                    "user": user,
                    "acc":acc
                }, function(data) {
                    console.log(data);
                    // Remove current row
                    tblNotAssUserAcc.row($(ths).parent().parent()).remove().draw();
        
                    // Add to assigned table
                    btn = `<a href='#' user='${user}' acc='${acc}' class='btn btn-sm btn-danger btnremoveAcc'><span class='las la-trash 2x'></span></a>`;
                    tblAssUserAcc.row.add([counterAss,accountName,currency,btn]).draw();
                    counterAss++;
                });
            }
        });

        // Not assign Bank/Safi to customer
        $(document).on("click",".btnremoveAcc",function(e){
            e.preventDefault();
            ths = $(this);

            if (!$(this).is("[disabled]")) {
                user = $(this).attr("user");
                acc = $(this).attr("acc");
    
                accountName = $(this).parent().parent().children("td:nth-child(2)").text();
                currency = $(this).parent().parent().children("td:nth-child(3)").text();
                
                // button option
                $(ths).children("span:first-child()").addClass("d-none");
                $(ths).children("span:last-child()").removeClass("d-none");
                $(ths).attr("disabled",true);

                $.post("../app/Controllers/banks.php", {
                    "removeAcc": "true",
                    "user": user,
                    "acc":acc
                }, function(data) {
                    console.log(data);
                    // Remove current row
                    tblAssUserAcc.row($(ths).parent().parent()).remove().draw();
        
                    // Add to assigned table
                    btn = `<a href='#' user='${user}' acc='${acc}' class='btn btn-sm btn-blue btnaddAcc'><span class='las la-plus 2x'></span></a>`;
                    tblNotAssUserAcc.row.add([counterNotAss,accountName,currency,btn]).draw();
                    counterNotAss++;
                });
            }
        });
    });
</script>