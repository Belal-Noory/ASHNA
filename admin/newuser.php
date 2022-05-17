<?php
include("../init.php");

$page_title = "تحارت ها";

$menu = array(
    array("name" => "صفحه عمومی", "url" => "index.php", "icon" => "la-chart-area", "status" => "", "open" => "", "child" => array()),
    array("name" => "تجارت ", "url" => "", "icon" => "la-business-time", "status" => "", "open" => "", "child" => array(array("name" => "تجارت جدید", "url" => "business.php", "status" => ""), array("name" => "لیست تجارت ها", "url" => "businessList.php", "status" => ""))),
    array("name" => "اشخاص ", "url" => "", "icon" => "la-users", "status" => "", "open" => "open", "child" => array(array("name" => "شخص جدید", "url" => "newuser.php", "status" => "active"), array("name" => "لیست اشخاص", "url" => "users.php", "status" => "")))
);

$page_title = "شخص جدید";

include("./master/header.php");

$company = new Company();
$all_company = $company->getAllCompanies();
$all_company_data = $all_company->fetchAll(PDO::FETCH_OBJ);
?>
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <div class="col-md-10 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="basic-layout-form">شخص جدید</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
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
                            <div class="card-text">
                                <p>اشخاص یا یوزر های که شما در انیجا ثبت نام میکنید میتواند به سیستم مدیریت مالی کمپنی تعین شده دسترسی پیدا کنند.</p>
                            </div>
                            <form class="form" id="newuser">
                                <div class="form-body">
                                    <h4 class="form-section"><i class="ft-user"></i> معلومات شخص</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="fname">اسم</label>
                                                <input type="text" id="fname" class="form-control required" placeholder="اسم" name="fname">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="lname">تخلص</label>
                                                <input type="text" id="lname" class="form-control required" placeholder="تخلص" name="lname">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">ایمیل یا یوزر نیم</label>
                                                <input type="text" id="email" class="form-control required" placeholder="ایمیل یا یوزر نیم" name="email">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="pass">رمز عبور/پاسورد</label>
                                                <input type="password" id="pass" class="form-control required" placeholder="رمز عبور/پاسورد" name="pass">
                                            </div>
                                        </div>
                                    </div>

                                    <h4 class="form-section"><i class="la la-paperclip"></i> معلومات کمپنی شخص</h4>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="company">کمپنی</label>
                                                <select id="company" name="company" class="form-control required">
                                                    <option value="" selected>لطفآ کمپنی را انتخاب کنید</option>
                                                    <?php
                                                    foreach ($all_company_data as $company_data) {
                                                        echo "<option value='$company_data->company_id'>$company_data->company_name</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="addnewuser">
                                <div class="alert alert-arrow-left alert-success mb-2 d-none">
                                    شخص موفقانه ذخیره شد
                                </div>
                                <div class="form-actions">
                                    <button type="button" class="btn btn-primary" id="addnewuser">
                                        <i class="la la-check-square-o"></i> ثبت شود
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

<?php include("./master/footer.php"); ?>

<script>
    $(document).ready(() => {

        // Add new user
        $("#addnewuser").on("click", () => {
            if ($("#newuser").valid()) {
                $.post("../app/Controllers/Company.php", $("#newuser").serialize(), (data) => {
                    $(".alert").removeClass("d-none");
                    document.getElementById("newuser").reset();
                    setTimeout(() => {
                        $(".alert").addClass("d-none");
                    }, 5000);
                });
            }
        })
    });

    // Initialize validation
    $("#newuser").validate({
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
    })
</script>