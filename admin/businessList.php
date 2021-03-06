<?php
include("../init.php");

$page_title = "تحارت ها";

$menu = array(
    array("name" => "صفحه عمومی", "url" => "dashboard.php", "icon" => "la-chart-area", "status" => "", "open" => "", "child" => array()),
    array("name" => "تجارت ", "url" => "", "icon" => "la-business-time", "status" => "", "open" => "open", "child" => array(array("name" => "تجارت جدید", "url" => "business.php", "status" => ""), array("name" => "لیست تجارت ها", "url" => "businessList.php", "status" => "active"))),
    array("name" => "ویب سایت ", "url" => "website.php", "icon" => "la-cogs", "status" => "", "open" => "", "child" => array())
);

$page_title = "تجارت جدید";

include("./master/header.php");

$company = new Company();
$systemAdmin = new SystemAdmin();

$all_company = $company->getAllCompanies();

?>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <!-- Material Data Tables -->
            <section id="material-datatables">
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-0">
                            <div class="card-header">
                                <a class="heading-elements-toggle">
                                    <i class="la la-ellipsis-v font-medium-3"></i>
                                </a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <table class="table material-table">
                                        <thead>
                                            <tr>
                                                <th>نام تجارت</th>
                                                <th>نوعیت تجارت</th>
                                                <th>شماره تماس</th>
                                                <th>آغاز قرارداد</th>
                                                <th>پایان قرارداد</th>
                                                <th>صلاحیت مودل</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $all_company_data = $all_company->fetchAll(PDO::FETCH_OBJ);
                                            foreach ($all_company_data as $company_data) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $company_data->company_name; ?></td>
                                                    <td><?php echo $company_data->company_type; ?></td>
                                                    <td><?php echo $company_data->phone; ?></td>
                                                    <td><?php echo Date("d/m/Y", $company_data->contract_start); ?></td>
                                                    <td><?php echo Date("d/m/Y", $company_data->contract_end); ?></td>
                                                    <td>
                                                        <a href="#" data-href="<?php echo $company_data->company_id; ?>" class="btn btn-sm btn-info btnshowmodel" data-toggle="modal" data-show="false" data-target="#show">
                                                            <span class="la la-plus"></span>
                                                        </a>
                                                        <a href="#" data-href="<?php echo $company_data->company_id; ?>" class="btn btn-sm btn-danger btndeletecompany">
                                                            <span class="la la-trash"></span>
                                                        </a>
                                                        <a href="#" data-href="<?php echo $company_data->company_id; ?>" class="btn btn-sm btn-blue btnrenewcontract">
                                                            <span class="la la-plus"></span> قرار داد جدید
                                                        </a>
                                                    </td>
                                                </tr>

                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Material Data Tables -->
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade text-left lg" id="show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel5">صلاحیت های مودل کمپنی</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-2">
                <form class="form" id="newmodel">
                    <div class="form-body">
                        <p style="line-height: 26px; border:none" class="form-section text-danger text-right">زمانیکه یکی از این مودل ها را در اینجا ثبت کنید کمپنی دیگر قادر به دسترسی به این مودل نمیباشد</p>
                        <div class="col-md-12 text-right">
                            <div class="form-group">
                                <select id="modelname" name="modelname" class="form-control required">
                                </select>
                                <input type="hidden" name="userID" id="userID">
                                <input type="hidden" name="addmodel" id="addmodel">
                            </div>
                        </div>
                        <input type="hidden" name="blockmodel">
                        <button type="button" class="btn btn-primary" id="addnewcompanymodeul">
                            <i class="la la-check-square-o"></i> ثبت شود
                        </button>
                    </div>
                </form>

                <!-- Basic Tables start -->
                <div class="col-12 mt-5">
                    <div class="card">
                        <div class="card-content collapse show">
                            <div class="card-body">
                                <p class="text-right"><span class="text-bold-600">لسیت صلاحیت های مودل کمئنی</p>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>مودل</th>
                                                <th>حذف صلاحیت</th>
                                            </tr>
                                        </thead>
                                        <tbody id="companyDeniedModelsTable">

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

<!-- Modal -->
<div class="modal fade" id="showcontract" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel5">صلاحیت های مودل کمپنی</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-2">
                <form class="form" id="renewContractForm">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="startdata">تاریخ آغاز</label>
                                    <input type="date" class="form-control" name="sdate" id="sdate" placeholder="تاریخ آغاز" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="startdata">تاریخ ختم</label>
                                    <input type="date" class="form-control" name="edate" id="edate" placeholder="تاریخ ختم" />
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="newcontract" id="newcontract">
                        <input type="hidden" name="CID" id="CID">

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary" id="btnNewContract">
                                <i class="la la-check-square-o"></i> تمدید شود
                            </button>
                            <span class="las la-spinner spinner blue ml-2 d-none" style="font-size: 30px;" id="spinnerNewContract"></span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

<?php include("./master/footer.php"); ?>
<script>
    $(document).ready(function() {

        $(document).on("click", ".btnrenewcontract", function() {
            CID = $(this).attr("data-href");
            $("#CID").val(CID);
            $("#showcontract").modal("show");
        });

        // Add customer
        $(document).on("submit", "#renewContractForm", function(e) {
            e.preventDefault();
            if ($("#renewContractForm").valid()) {
                $.ajax({
                    url: "../app/Controllers/Company.php",
                    type: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $("#btnNewContract").addClass("d-none");
                        $("#spinnerNewContract").removeClass("d-none");
                    },
                    success: function(data) {
                        $("#btnNewContract").removeClass("d-none");
                        $("#spinnerNewContract").addClass("d-none");
                        $("#showcontract").modal("hide");
                    },
                    error: function(e) {
                        $("#btnNewContract").removeClass("d-none");
                        $("#spinnerNewContract").addClass("d-none");
                        $("#renewContractForm").html(e);
                    }
                });
            }
        });


        // Show the module model
        $(document).on('click', '.btnshowmodel', function() {
            let data = $(this).attr("data-href");
            $("#userID").val(data);

            // Get Models that not denied for the company yet
            $.get("../app/Controllers/SystemAdmin.php", {
                "getcompanymodels": "true",
                "companyID": data
            }, (data) => {
                console.log("not denieyd models = " + data);
                let models = $.parseJSON(data);
                $("#modelname").empty();
                $("#modelname").append("<option value='' selected>لطفآ مودل را انتخاب کنید</option>");
                for (var i = 0; i < models.length; i++) {
                    $("#modelname").append("<option value='" + models[i].id + "'>" + models[i].name_dari + "</option>");
                }
            });

            // Get Models that are denied for the company
            $.get("../app/Controllers/Company.php", {
                "getCompanyDenyModel": "true",
                "companyID": data
            }, (data) => {
                console.log("denieyd models = " + data);
                let Deniedmodels = $.parseJSON(data);
                $("#companyDeniedModelsTable").empty();

                for (var i = 0; i < Deniedmodels.length; i++) {
                    $("#companyDeniedModelsTable").append("<tr class='text-right'><td>" + Deniedmodels[i].name_dari + "</td><td><a href='#' data-href='" + Deniedmodels[i].company_model_id + "' class='btn btn-sm btn-danger btnDeleteCompanyModel'><span class='la la-trash'></span></a></td></tr>");
                }
            });
        });

        // Add company module
        $("#addnewcompanymodeul").on("click", () => {
            if ($("#newmodel").valid()) {
                let li_ID = $("#modelname").val();

                $.post("../app/Controllers/Company.php", $("#newmodel").serialize(), (data) => {
                    // Add the model to the table
                    $("#companyDeniedModelsTable").append("<tr class='text-right'><td>" + $("#modelname option:selected").text() + "</td><td><a href='#' data-href='" + data + "' class='btn btn-sm btn-danger btnDeleteCompanyModel'><span class='la la-trash'></span></a></td></tr>");

                    $("#modelname option[value='" + li_ID + "']").remove();
                    document.getElementById("newmodel").reset();
                });
            }
        });

        // Delete added models in show company model
        $(document).on("click", ".btnDeleteCompanyModel", function() {
            let modelID = $(this).attr("data-href");

            // remove Company model
            $.post("../app/Controllers/Company.php", {
                "removeCompanyModel": "true",
                "modelID": modelID
            }, (data) => {
                if (data > 0) {
                    // Load the models again
                    // Get Models that not denied for the company yet
                    $.get("../app/Controllers/SystemAdmin.php", {
                        "getcompanymodels": "true",
                        "companyID": data
                    }, (data) => {
                        let models = $.parseJSON(data);
                        $("#modelname").empty();
                        $("#modelname").append("<option value='' selected>لطفآ مودل را انتخاب کنید</option>");
                        for (var i = 0; i < models.length; i++) {
                            $("#modelname").append("<option value='" + models[i].id + "'>" + models[i].name_dari + "</option>");
                        }
                    });
                    $(this).parent().parent().fadeOut();
                }
            });
        });

        $(document).on("click", ".btndeletecompany", function(e) {
            e.preventDefault();
            $(this).addClass("disabled");
            company = $(this).attr("data-href");
            ths = $(this);
            $.post("../app/Controllers/Company.php", {
                "deleteCompany": "true",
                "companyID": company
            }, function(data) {
                console.log(data);
                $(ths).parent().parent().fadeOut();
            });
        });
    });


    // Initialize validation
    $("#newmodel").validate({
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
        }
    });

    // Initialize validation
    $("#renewContractForm").validate({
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
        }
    });
</script>