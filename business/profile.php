<?php
$Active_nav_name = array("parent" => "Settings", "child" => "Company Profile");
$page_title = "Company Profile";
include("./master/header.php");

$company = new Company();
$bussiness = new Bussiness();
$banks = new Banks();

$company_data = $company->getCompany($user_data->company_id);
$company_profile = $company_data->fetch(PDO::FETCH_OBJ);
?>
<div class="app-content content">
    <div class="content-header row">
    </div>
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <div class="card col-6">
                <div class="card-header">
                    <h4 class="card-title">َUpload Company Logo</h4>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <form action="../app/Controllers/Company.php" class="dropzone" id="dropzone-form" method="POST"></form>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">معلومات کمپنی</h4>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <form class="form">
                            <!-- Step 1 -->
                            <h4 class='form-section'><i class='ft-user'></i>معلومات کسب و کار</h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cname">
                                            نام :
                                            <span class="danger">*</span>
                                        </label>
                                        <input type="text" class="form-control " id="cname" name="cname" placeholder="نام" value="<?php echo $company_profile->company_name ?>">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="clegalname">
                                            نام قانونی :
                                            <span class="danger">*</span>
                                        </label>
                                        <input type="text" class="form-control  " id="clegalname" name="clegalname" placeholder="نام قانونی" value="<?php echo $company_profile->legal_name ?>">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ctype">
                                            نوعیت تجارت :
                                            <span class="danger">*</span>
                                        </label>
                                        <select class="c-select form-control  " id="ctype" name="ctype">
                                            <?php
                                            $types = ["صرافی", "خدمات پولی", "صرافی و خدمات پولی"];
                                            foreach ($types as $type) {
                                                $selected = "";
                                                if ($type == $company_profile->company_type) {
                                                    $selected = "selected";
                                                }
                                                echo "<option value='$type' $selected>$type</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <h4 class='form-section'><i class='ft-user'></i>معلومات افتصادی</h4>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="clicense">
                                            لیسانس نمبر :
                                            <span class="danger">*</span>
                                        </label>
                                        <input type="text" class="form-control  " id="clicense" name="clicense" placeholder="لیسانس نمبر" value="<?php echo $company_profile->license_number ?>">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="maincurrency">واحد پولی اصلی :</label>
                                        <select class="c-select form-control  " id="maincurrency" name="maincurrency">
                                            <option value='<?php echo $company_profile->company_currency_id ?>'><?php echo $company_profile->currency ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cTIN">نمبر تشخیصه :</label>
                                        <input type="tel" class="form-control" id="cTIN" name="cTIN" placeholder="نمبر تشخیصه" value="<?php echo $company_profile->TIN ?>">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="creginum">شماره ثبت :</label>
                                        <input type="text" class="form-control" id="creginum" name="creginum" placeholder="شماره ثبت" value="<?php echo $company_profile->register_number ?>">
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2 -->
                            <h4 class='form-section'><i class='ft-user'></i>معلومات تماس</h4>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="ccountry">
                                            کشور :
                                            <span class="danger">*</span>
                                        </label>
                                        <select class="c-select form-control  " id="ccountry" name="ccountry">
                                            <?php
                                            $count = ["افغانستان", "پاکستان", "ایران", "ترکیه"];
                                            foreach ($count as $con) {
                                                $selected = "";
                                                if ($con == $company_profile->country) {
                                                    $selected = "selected";
                                                }
                                                echo "<option value='$con' $selected>$con</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cprovince">
                                            ولایت :
                                            <span class="danger">*</span>
                                        </label>
                                        <input type="text" class="form-control  " id="cprovince" name="cprovince" placeholder="ولایت" value="<?php echo $company_profile->province; ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cdistrict">
                                            ولسوالی :
                                            <span class="danger">*</span>
                                        </label>
                                        <input type="text" class="form-control  " id="cdistrict" name="cdistrict" placeholder="ولسوالی" value="<?php echo $company_profile->district; ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cemail">
                                            ایمیل :
                                            <span class="danger">*</span>
                                        </label>
                                        <input type="email" class="form-control" id="cemail" name="cemail" placeholder="ایمیل" value="<?php echo $company_profile->email; ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cpostalcode">
                                            کدپوستی :
                                            <span class="danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="cpostalcode" name="cpostalcode" placeholder="کدپوستی" value="<?php echo $company_profile->postal_code; ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cphone">
                                            شماره تماس :
                                            <span class="danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="cphone" name="cphone" placeholder="شماره تماس" value="<?php echo $company_profile->phone; ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cfax">
                                            فکس :
                                            <span class="danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="cfax" name="cfax" placeholder="فکس" value="<?php echo $company_profile->fax; ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cwebsite">
                                            ویب سایت :
                                            <span class="danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="cwebsite" name="cwebsite" placeholder="ویب سایت" value="<?php echo $company_profile->website; ?>">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="caddress">
                                            ادرس :
                                            <span class="danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="caddress" name="caddress" placeholder="ادرس" value="<?php echo $company_profile->addres; ?>">
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="updatecompany" id="updatecompany">
                            <div class="form-actions">
                                <button type="button" class="btn btn-info waves-effect waves-light" id="btnupdatecompany">
                                    <i class="la la-check-square-o"></i>
                                    <i class="las la-spinner spinner d-none"></i>
                                    Update
                                </button>
                            </div>
                        </form>
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
        // 
        $(".form :input").on("change",function() {
            $(".form").data("changed", true);
        });

        $("#btnupdatecompany").on("click", function(e) {
            ths = $(this);
            if ($(".form").data("changed")) {
                // submit the form
                formdata = $(".form").serialize();
                $(ths).children("span").first().addClass("d-none");
                $(ths).children("span").last().removeClass("d-none");
                $.post("../app/Controllers/Company.php", formdata, function(data) {
                    if (data > 0) {
                        $(ths).children("span").first().removeClass("d-none");
                        $(ths).children("span").last().addClass("d-none");
                    }
                });
            }
        });

    });
</script>

<script type="text/javascript">
   // dropzone configuration
        Dropzone.options.dropzoneForm = {
            paramName: "file",
            maxFilesize: 3, //3 MB
            maxFiles: 1,
            acceptFiles: "image/jpeg, image/png, image/jpg",
            accept: function(file, done) {
                if (file.type != "image/jpeg") {
                    done("Error! Files of this type are not accepted");
                } else {
                    done();
                }
            }
        };
 </script>