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
                                        <?php if ($bussiness->checkLogin($customer->customer_id) <= 0) { ?>
                                            <a href="#" data-href="<?php echo $customer->customer_id; ?>" class="btn btn-blue btnaddlogin"><span class="las la-plus"></span> Add Login</a>
                                        <?php } ?>
                                        <a href="#" data-href="<?php echo $customer->customer_id; ?>" class="btn btn-danger btnshowpermissions"><span class="las la-lock"></span>Permissions</a>
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

<?php
include("./master/footer.php");
?>

<script>
    $(document).ready(function() {

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
    });
</script>