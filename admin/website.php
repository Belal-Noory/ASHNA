<?php
include("../init.php");

$menu = array(
    array("name" => "صفحه عمومی", "url" => "dashboard.php", "icon" => "la-chart-area", "status" => "", "open" => "", "child" => array()),
    array("name" => "تجارت ", "url" => "", "icon" => "la-business-time", "status" => "", "open" => "", "child" => array(array("name" => "تجارت جدید", "url" => "business.php", "status" => ""), array("name" => "لیست تجارت ها", "url" => "businessList.php", "status" => ""))),
    array("name" => "اشخاص ", "url" => "", "icon" => "la-users", "status" => "", "open" => "", "child" => array(array("name" => "شخص جدید", "url" => "newuser.php", "status" => ""), array("name" => "لیست اشخاص", "url" => "users.php", "status" => ""))),
    array("name" => "ویب سایت ", "url" => "website.php", "icon" => "la-cogs", "status" => "active", "open" => "", "child" => array())
);

$page_title = "صفحه عمومی";

include("./master/header.php");

$company = new Company();
$all_companies = $company->getAllCompanies();
$all_active_company = $company->getAllActiveCompanies();
$all_inactive_company = $company->getAllInctiveCompanies();

$all_users = $company->getCompanyUsers();
$online_users = $company->getCompanyOnlineUser(); ?>

<!-- END: Main Menu-->
<!-- BEGIN: Content-->
<div class="container mt-2">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title" id="basic-layout-colored-form-control">اضعافه نمودن پیام چدید به ویب سایت</h4>
            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content collapse show">
            <div class="card-body">
                <form class="form">
                    <div class="form-body">
                        <div class="form-group">
                            <label for="title">عنوان</label>
                            <input class="form-control border-primary required" type="text" placeholder="عنوان" id="title" name="title">
                        </div>
                        <div class="form-group">
                            <label for="details">متن</label>
                            <textarea id="details" rows="5" class="form-control border-primary required" name="details" placeholder="متن"></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="addwebsitemsg" value="addwebsitemsg">
                    <div class="form-actions text-right">
                        <button type="button" class="btn btn-primary waves-effect waves-light" id="btnaddmsg">
                            <i class="la la-check-square-o"></i> اضعافه شود
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
                    <h5>موفقانه اضعفافه شد</h5>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Content-->
<?php include("./master/footer.php"); ?>

<script>
    $(document).ready(function() {
        $("#btnaddmsg").on("click", function() {
            if ($(".form").valid()) {
                $("#show").modal("show");
                $.post("../app/Controllers/SystemAdmin.php", $(".form").serialize(), function(data) {
                    console.log(data);
                    $(".container-waiting").addClass("d-none");
                    $(".container-done").removeClass("d-none");
                    setTimeout(function() {
                        $("#show").modal("hide");
                        $(".form")[0].reset();
                    }, 2000);
                });
            }
        });
    });

    // Initialize validation
    $(".form").validate({
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