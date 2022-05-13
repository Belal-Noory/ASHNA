<?php
include("../init.php");

$menu = array(
    array("name" => "صفحه عمومی", "url" => "index.php", "icon" => "la-chart-area", "status" => "", "child" => array()),
    array("name" => "تجارت ", "url" => "", "icon" => "la-business-time", "status" => "active", "child" => array(array("name" => "تجارت جدید", "url" => "business.php"), array("name" => "لیست تجارت ها", "url" => "businessList.php"))),
    array("name" => "اشخاص ", "url" => "", "icon" => "la-users", "status" => "", "child" => array(array("name" => "شخص جدید", "url" => "newuser.php"), array("name" => "لیست اشخاص", "url" => "users.php")))
);

$page_title = "تجارت جدید";

include("./master/header.php");
?>

<!-- END: Main Menu-->
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <!-- Form wzard with step validation section start -->
            <section id="validation">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">ایجاد تجارت/کمپنی چدید</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <form action="#" class="steps-validation wizard-notification">
                                        <!-- Step 1 -->
                                        <h6>مرحله اول</h6>
                                        <fieldset>
                                            <h3>معلومات کسب و کار</h3>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="cname">
                                                            نام :
                                                            <span class="danger">*</span>
                                                        </label>
                                                        <input type="text" class="form-control  " id="cname" name="cname" placeholder="نام">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="clegalname">
                                                            نام قانونی :
                                                            <span class="danger">*</span>
                                                        </label>
                                                        <input type="text" class="form-control  " id="clegalname" name="clegalname" placeholder="نام قانونی">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="ctype">
                                                            نوعیت تجارت :
                                                            <span class="danger">*</span>
                                                        </label>
                                                        <select class="c-select form-control  " id="ctype" name="ctype">
                                                            <option value="شرکت">شرکت</option>
                                                            <option value=" مغازه">مغازه</option>
                                                            <option value=" فروشگاه ">فروشگاه</option>
                                                            <option value=" اتحادیه ">اتحادیه</option>
                                                            <option value=" باشگاه ">باشگاه</option>
                                                            <option value=" موسسه ">موسسه</option>
                                                            <option value=" شخصی ">شخصی</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <h3>معلومات افتصادی</h3>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="clicense">
                                                            لیسانس نمبر :
                                                            <span class="danger">*</span>
                                                        </label>
                                                        <input type="text" class="form-control  " id="clicense" name="clicense" placeholder="لیسانس نمبر">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="maincurrency">واحد پولی اصلی :</label>
                                                        <select class="c-select form-control  " id="maincurrency" name="maincurrency">
                                                            <option value="AFA">افغانی</option>
                                                            <option value="IRR">ریال ایران</option>
                                                            <option value="PKR">روپیه پاکستان</option>
                                                            <option value="TRY">لیره ترکیه</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="cTIN">نمبر تشخیصه :</label>
                                                        <input type="tel" class="form-control" id="cTIN" name="cTIN" placeholder="نمبر تشخیصه">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="creginum">شماره ثبت :</label>
                                                        <input type="text" class="form-control" id="creginum" name="creginum" placeholder="شماره ثبت">
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <!-- Step 2 -->
                                        <h6>مرحله دوم</h6>
                                        <fieldset>
                                            <h3>معلومات تماس</h3>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="ccountry">
                                                            کشور :
                                                            <span class="danger">*</span>
                                                        </label>
                                                        <select class="c-select form-control  " id="ccountry" name="ccountry">
                                                            <option value="افغانستان">افغانستان</option>
                                                            <option value=" پاکستان">پاکستان</option>
                                                            <option value=" ایران ">ایران</option>
                                                            <option value=" ترکیه ">ترکیه</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="cprovince">
                                                            ولایت :
                                                            <span class="danger">*</span>
                                                        </label>
                                                        <input type="text" class="form-control  " id="cprovince" name="cprovince" placeholder="ولایت">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="cdistrict">
                                                            ولسوالی :
                                                            <span class="danger">*</span>
                                                        </label>
                                                        <input type="text" class="form-control  " id="cdistrict" name="cdistrict" placeholder="ولسوالی">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="cemail">
                                                            ایمیل :
                                                            <span class="danger">*</span>
                                                        </label>
                                                        <input type="email" class="form-control" id="cemail" name="cemail" placeholder="ایمیل">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="cpostalcode">
                                                            کدپوستی :
                                                            <span class="danger">*</span>
                                                        </label>
                                                        <input type="text" class="form-control" id="cpostalcode" name="cpostalcode" placeholder="کدپوستی">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="cphone">
                                                            شماره تماس :
                                                            <span class="danger">*</span>
                                                        </label>
                                                        <input type="text" class="form-control" id="cphone" name="cphone" placeholder="شماره تماس">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="cfax">
                                                            فکس :
                                                            <span class="danger">*</span>
                                                        </label>
                                                        <input type="text" class="form-control" id="cfax" name="cfax" placeholder="فکس">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="cwebsite">
                                                            ویب سایت :
                                                            <span class="danger">*</span>
                                                        </label>
                                                        <input type="text" class="form-control" id="cwebsite" name="cwebsite" placeholder="ویب سایت">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="caddress">
                                                            ادرس :
                                                            <span class="danger">*</span>
                                                        </label>
                                                        <input type="text" class="form-control  " id="caddress" name="caddress" placeholder="ادرس">
                                                    </div>
                                                </div>
                                                <input type="hidden" name="addcompany" id="addcompany">
                                            </div>
                                        </fieldset>

                                         <!-- Step 3 -->
                                         <h6>مرحله سوم</h6>
                                        <fieldset>
                                            <h3>معلومات تماس</h3>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="fiscal_year_start">
                                                            آغاز سال مالی :
                                                            <span class="danger">*</span>
                                                        </label>
                                                        <input type="date" class="form-control" name="fiscal_year_start" id="fiscal_year_start">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="fiscal_year_end">
                                                        پایان سال مالی :
                                                            <span class="danger">*</span>
                                                        </label>
                                                        <input type="date" class="form-control" id="fiscal_year_end" name="fiscal_year_end">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="fiscal_year_title">
                                                            عنوان سال مالی :
                                                            <span class="danger">*</span>
                                                        </label>
                                                        <input type="text" class="form-control  " id="fiscal_year_title" name="fiscal_year_title" placeholder="عنوان سال مالی">
                                                    </div>
                                                </div>
                                                <input type="hidden" name="addcompany" id="addcompany">
                                            </div>
                                        </fieldset>
                                    </form>

                                    <div class="alert bg-info alert-icon-left alert-arrow-left alert-dismissible mt-2 mb-2 d-none" role="alert" id="caddedalert">
                                        <span class="alert-icon"><i class="la la-thumbs-o-down"></i></span>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <strong>کسب و کار موفقانه درج شد تشکر</strong>
                                    </div>

                                    <div class="alert bg-danger alert-icon-left alert-arrow-left alert-dismissible mt-2 mb-2 d-none" role="alert" id="caddedalert">
                                        <span class="alert-icon"><i class="la la-thumbs-o-down"></i></span>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <strong id="addbusinessErrorText"></strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Form wzard with step validation section end -->
        </div>
    </div>
</div>
<!-- END: Content-->

<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

<?php include("./master/footer.php"); ?>

<script>
    $(document).ready(() => {
        // Show form
        var form = $(".steps-validation").show();
        $(".steps-validation").steps({
            headerTag: "h6",
            bodyTag: "fieldset",
            transitionEffect: "fade",
            titleTemplate: '<span class="step">#index#</span> #title#',
            labels: {
                finish: 'ثبت شود',
                next: 'بعدی',
                previous: 'قبلی'
            },
            onStepChanging: function(event, currentIndex, newIndex) {
                // Allways allow previous action even if the current form is not valid!
                if (currentIndex > newIndex) {
                    return true;
                }
                // Needed in some cases if the user went back (clean up)
                if (currentIndex < newIndex) {
                    // To remove error styles
                    form.find(".body:eq(" + newIndex + ") label.error").remove();
                    form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
                }
                form.validate().settings.ignore = ":disabled,:hidden";
                return form.valid();
            },
            onFinishing: function(event, currentIndex) {
                form.validate().settings.ignore = ":disabled";
                return form.valid();
            },
            onFinished: function(event, currentIndex) {
                $.post("../app/Controllers/Company.php", $(".steps-validation").serialize(), (data) => {
                    if (data == 1) {
                        $('.steps-validation').trigger("reset");
                        $("#caddedalert").removeClass("d-none");
                        setTimeout(() => {
                            $("#caddedalert").addClass("d-none");
                            window.location.reload();
                        }, 5000);
                    }
                    else{
                        $("#addbusinessErrorText").text(data);
                        $("#addbusinessErrorText").removeClass("d-none");
                    }
                });
            }
        });
    })

    // Initialize validation
    $(".steps-validation").validate({
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