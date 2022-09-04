<?php
$menue = array(
    array("name" => "ارسال ها", "url" => "send.php", "icon" => "la-send", "active" => "active"),
    array("name" => "دریافت ها", "url" => "receive.php", "icon" => "la-arrow-left", "active" => ""),
);
$page_title = "ارسال ها";
include("./master/header.php");

$company = new Company();
$saraf = new Saraf();
$bussiness = new Bussiness();
// $transfer = new Transfer();

$all_companyies_data = $company->getAllCompaniesInfo();
$all_company = $all_companyies_data->fetchAll(PDO::FETCH_OBJ);

$pending_transfers_data = $saraf->getPendingOutTransfer($loged_user->customer_id);
$pending_transfers = $pending_transfers_data->fetchAll(PDO::FETCH_OBJ);

$paid_transfers_data = $saraf->getPaidOutTransfer($loged_user->customer_id);
$paid_transfers = $paid_transfers_data->fetchAll(PDO::FETCH_OBJ);

$allcurrency_data = $company->GetCompanyCurrency($user_data->company_id);
$allcurrency = $allcurrency_data->fetchAll(PDO::FETCH_OBJ);

// get Saraf Account ID
$ID_details = $saraf->getSarafAccount($loged_user->customer_id);
$ID = $ID_details->fetch(PDO::FETCH_OBJ);

$result = $saraf->getTransferCode($loged_user->customer_id, $loged_user->company_id);
$transferCode = 0;
if ($result->rowCount() > 0) {
    $res = $result->fetch(PDO::FETCH_OBJ);
    $ID_array = explode("-", $res->transfer_code);
    $transferCode = $ID_array[1];
    $transferCode++;
    $transferCode = $ID->chartofaccount_id."-".$transferCode;
} else {
    $transferCode = 0;
    $transferCode = $ID->chartofaccount_id."-".$transferCode;
}
?>
<!-- END: Main Menu-->
<!-- BEGIN: Content-->
<div class="container pt-5">
    <section id="basic-form-layouts">
        <div class="row match-height">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
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
                                        <label for="details">توضیحات</label>
                                        <textarea id="details" class="form-control required" placeholder="توضیحات" name="details"></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="date">تاریخ</label>
                                                <input type="date" id="date" class="form-control required" placeholder="تاریخ" name="date">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="date">نمبر حواله</label>
                                                <input type="text" id="transfercode" class="form-control" placeholder="نمبر حواله" name="transfercode" value="<?php echo $transferCode; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="date">صراف</label>
                                                <select class="form-control required" name="rsaraf_ID" id="rsaraf_ID" data-placeholder="صراف">
                                                    <option value="" selected>انتخاب کنید</option>
                                                    <?php
                                                    foreach ($all_company as $saraf) {
                                                        echo "<option value='$saraf->company_id' >$saraf->company_name</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="currency">نوعیت پول</label>
                                                <select type="text" id="currency" class="form-control" placeholder="نوعیت پول" name="currency">
                                                    <option value="" selected>انتخاب کنید</option>
                                                    <?php
                                                    foreach ($allcurrency as $currency) {
                                                        $selected = $currency->currency == $mainCurrency ? "selected" : "";
                                                        echo "<option value='$currency->company_currency_id' $selected>$currency->currency</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="currency">مقدار پول</label>
                                                <input type="number" id="amount" class="form-control required" placeholder="مقدار پول" name="amount">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="currency">کمیشن شما</label>
                                                <input type="number" id="mycommission" class="form-control required" placeholder="کمیشن شما" name="mycommission">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="currency">کمیشن صراف</label>
                                                <input type="number" id="sarafcommission" class="form-control required" placeholder="کمیشن صراف" name="sarafcommission">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="card bg-light">
                                                <div class="card-header">
                                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                                </div>
                                                <div class="card-content collapse show">
                                                    <div class="card-header">
                                                        <h3 class="card-title text-center">ارسال کننده پول</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="currency">شماره تلفون</label>
                                                            <input type="text" class="form-control required" name="sender_phone" id="sender_phone" placeholder="شماره تلفون" list="dailyCustomers" />
                                                            <datalist id="dailyCustomers">
                                                                <?php
                                                                foreach ($allDailyCus as $dailyCus) {
                                                                    echo "<option value='$dailyCus->personal_phone'>$dailyCus->fname $dailyCus->lname</option>";
                                                                }
                                                                ?>
                                                            </datalist>
                                                            <span class="la la-spinner spinner blue mt-1 d-none" style="font-size: 25px;"></span>
                                                        </div>
                                                        <div class="form-group d-none">
                                                            <label for="currency">نام</label>
                                                            <input type="text" class="form-control required" name="sender_fname" id="sender_fname" placeholder="نام" />
                                                        </div>
                                                        <div class="form-group d-none">
                                                            <label for="currency">تخلص</label>
                                                            <input type="text" class="form-control" name="sender_lname" id="sender_lname" placeholder="تخلص" />
                                                        </div>
                                                        <div class="form-group d-none">
                                                            <label for="currency">نام پدر</label>
                                                            <input type="text" class="form-control" name="sender_Fathername" id="sender_Fathername" placeholder="نام پدر" />
                                                        </div>
                                                        <div class="form-group d-none">
                                                            <label for="currency">نمبر تذکره</label>
                                                            <input type="text" class="form-control" name="sender_nid" id="sender_nid" placeholder="نمبر تذکره" />
                                                        </div>
                                                        <div class="form-group d-none">
                                                            <label for="details">توضیحات</label>
                                                            <textarea id="sender_details" class="form-control" placeholder="توضیحات" name="sender_details"></textarea>
                                                        </div>
                                                        <input type="hidden" name="addsender" id="addsender" value="true">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="card bg-light">
                                                <div class="card-header">
                                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                                </div>
                                                <div class="card-content collapse show">
                                                    <div class="card-header">
                                                        <h3 class="card-title text-center">دریافت کننده پول</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="currency">شماره تلفون</label>
                                                            <input type="text" list="dailyCustomers2" class="form-control" name="receiver_phone" id="receiver_phone" placeholder="شماره تلفون" />
                                                            <datalist id="dailyCustomers2">
                                                                <?php
                                                                foreach ($allDailyCus as $dailyCus) {
                                                                    echo "<option value='$dailyCus->personal_phone'>$dailyCus->fname $dailyCus->lname</option>";
                                                                }
                                                                ?>
                                                            </datalist>
                                                            <span class="la la-spinner spinner blue mt-1 d-none" style="font-size: 25px;"></span>
                                                        </div>
                                                        <div class="form-group d-none">
                                                            <label for="currency">نام</label>
                                                            <input type="text" class="form-control required" name="receiver_fname" id="receiver_fname" placeholder="نام" />
                                                        </div>
                                                        <div class="form-group d-none">
                                                            <label for="currency">تخلص</label>
                                                            <input type="text" class="form-control" name="receiver_lname" id="receiver_lname" placeholder="تخلص" />
                                                        </div>
                                                        <div class="form-group d-none">
                                                            <label for="currency">نام پدر</label>
                                                            <input type="text" class="form-control" name="receiver_Fathername" id="receiver_Fathername" placeholder="نام پدر" />
                                                        </div>
                                                        <div class="form-group d-none">
                                                            <label for="currency">نمبر تذکره</label>
                                                            <input type="text" class="form-control" name="receiver_nid" id="receiver_nid" placeholder="نمبر تذکره" />
                                                        </div>
                                                        <div class="form-group d-none">
                                                            <label for="details">توضیحات</label>
                                                            <textarea id="receiver_details" class="form-control" placeholder="توضیحات" name="receiver_details"></textarea>
                                                        </div>
                                                        <input type="hidden" name="addreceiver" id="addreceiver" value="true">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 error d-none">
                                            <span class="alert alert-danger"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="button" id="btnaddouttransfere" class="btn btn-info waves-effect waves-light">
                                        <i class="la la-check-square-o"></i> ارسال کردن
                                    </button>
                                </div>
                                <input type="hidden" name="addouttransfer">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- transfers list -->
    <section id="justified-bottom-border">
        <div class="row match-height">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-underline no-hover-bg nav-justified">
                                <li class="nav-item">
                                    <a class="nav-link active" id="active-tab32" data-toggle="tab" href="#active32" aria-controls="active32" aria-expanded="true">پرداخت شده</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="link-tab32" data-toggle="tab" href="#link32" aria-controls="link32" aria-expanded="false">پرداخت نشده</a>
                                </li>
                            </ul>
                            <div class="tab-content px-1 pt-1">
                                <div role="tabpanel" class="tab-pane active" id="active32" aria-labelledby="active-tab32" aria-expanded="true">
                                    <section id="configuration">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <div class="heading-elements">
                                                            <ul class="list-inline mb-0">
                                                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="card-content collapse show">
                                                        <div class="card-body card-dashboard">
                                                            <div class="table-responsive">
                                                                <table class="table table-striped table-bordered zero-configuration">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Date</th>
                                                                            <th>Description</th>
                                                                            <th>To</th>
                                                                            <th>Amount</th>
                                                                            <th>Transfer Code</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        foreach ($paid_transfers as $ptransfer) {
                                                                            $to_data = $company->getCompanyByID($ptransfer->company_id);
                                                                            $to = $to_data->fetch(PDO::FETCH_OBJ);

                                                                            $dat = date("m/d/Y", $ptransfer->reg_date);
                                                                            echo "<tr class='mainrow'>
                                                                            <td>$dat</td>
                                                                            <td class='tRow' data-href='$ptransfer->leadger_id'>$ptransfer->details</td>
                                                                            <td>$to->company_name</td>
                                                                            <td>$ptransfer->amount-$ptransfer->currency</td>
                                                                            <td>$ptransfer->transfer_code</td>
                                                                        </tr>";
                                                                        }
                                                                        ?>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <div class="tab-pane" id="link32" role="tabpanel" aria-labelledby="link-tab32" aria-expanded="false">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <div class="heading-elements">
                                                        <ul class="list-inline mb-0">
                                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="card-content collapse show">
                                                    <div class="card-body card-dashboard">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-bordered zero-configuration">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Date</th>
                                                                        <th>Description</th>
                                                                        <th>To</th>
                                                                        <th>Amount</th>
                                                                        <th>Transfer Code</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    foreach ($pending_transfers as $ptransfer) {
                                                                        $to_data = $company->getCompanyByID($ptransfer->company_id);
                                                                        $to = $to_data->fetch(PDO::FETCH_OBJ);
                                                                        $dat = date("m/d/Y", $ptransfer->reg_date);
                                                                        echo "<tr class='mainrow'>
                                                                            <td>$dat</td>
                                                                            <td class='tRow' data-href='$ptransfer->leadger_id'>$ptransfer->details</td>
                                                                            <td>$to->company_name</td>
                                                                            <td>$ptransfer->amount-$ptransfer->currency</td>
                                                                            <td>$ptransfer->transfer_code</td>
                                                                        </tr>";
                                                                    }
                                                                    ?>
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
        </div>
    </section>
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
                    <h5>موفقانه ارسال گردید</h5>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Content-->


<?php include("./master/footer.php") ?>

<script>
    $(document).ready(function() {
        // check sender daily customer based on phone number
        $("#sender_phone").on("blur", function() {
            phone = $(this).val();
            ths = $(this);
            $(ths).parent().children("span.la").removeClass("d-none");

            $.get("../app/Controllers/Bussiness.php", {
                "getDailyCus": true,
                "dailyCusID": phone
            }, function(data) {
                ndata = $.parseJSON(data);
                if (ndata.length > 0) {
                    $(ths).parent().parent().children(".form-group").children("input#sender_fname").val(ndata[0].fname);
                    $(ths).parent().parent().children(".form-group").children("#sender_lname").val(ndata[0].lname);
                    $(ths).parent().parent().children(".form-group").children("#sender_Fathername").val(ndata[0].alies_name);
                    $(ths).parent().parent().children(".form-group").children("#sender_nid").val(ndata[0].NID);
                    $(ths).parent().parent().children(".form-group").children("#sender_details").val(ndata[0].details);
                    $(ths).parent().parent().children("#addsender").val("false");
                } else {
                    $(ths).parent().parent().children(".form-group").each(function() {
                        $(this).find("input:not(#sender_phone)").val("");
                    });
                    $(ths).parent().parent().children("#addsender").val("true");
                }
            });
            $(ths).parent().parent().children(".form-group").removeClass("d-none");
            $(ths).parent().children("span.la").addClass("d-none");
        });

        // check receiver daily customer based on phone number
        $("#receiver_phone").on("blur", function() {
            phone = $(this).val();
            ths = $(this);
            $(ths).parent().children("span.la").removeClass("d-none");

            $.get("../app/Controllers/Bussiness.php", {
                "getDailyCus": true,
                "dailyCusID": phone
            }, function(data) {
                ndata = $.parseJSON(data);
                if (ndata.length > 0) {
                    $(ths).parent().parent().children(".form-group").children("#receiver_fname").val(ndata[0].fname);
                    $(ths).parent().parent().children(".form-group").children("#receiver_lname").val(ndata[0].lname);
                    $(ths).parent().parent().children(".form-group").children("#receiver_Fathername").val(ndata[0].alies_name);
                    $(ths).parent().parent().children(".form-group").children("#receiver_nid").val(ndata[0].NID);
                    $(ths).parent().parent().children(".form-group").children("#receiver_details").val(ndata[0].details);
                    $(ths).parent().parent().children("#addreceiver").val("false");
                } else {
                    $(ths).parent().parent().children(".form-group").each(function() {
                        $(this).find("input:not(#receiver_phone").val("");
                    });
                    $(ths).parent().parent().children("#addreceiver").val("true");
                }
            });
            $(ths).parent().parent().children(".form-group").removeClass("d-none");
            $(ths).parent().children("span.la").addClass("d-none");
        });

        // check for block nids
        receiver_nid_blocked = false;
        $("#receiver_nid").on("blur", function() {
            nid = $(this).val();
            $.get("../app/Controllers/Bussiness.php", {
                "checkNID": nid
            }, function(data) {
                ndata = $.parseJSON(data);
                if (ndata.length > 0) {
                    receiver_nid_blocked = true;
                    $(".error").removeClass("d-none").children("span").text("Receiver NID is blocked please check it again");
                }
            });
        });

        // check for block nids
        sender_nid_blocked = false;
        $("#sender_nid").on("blur", function() {
            nid = $(this).val();
            $.get("../app/Controllers/Bussiness.php", {
                "checkNID": nid
            }, function(data) {
                ndata = $.parseJSON(data);
                if (ndata.length > 0) {
                    sender_nid_blocked = true;
                    $(".error").removeClass("d-none").children("span").text("Sender NID is blocked please check it again");
                }
            });
        });

        // Load currency based on Saraf/company
        $("#rsaraf_ID").on("change", function() {
            company = $(this).val();
            $.get("../app/Controllers/Saraf.php", {
                "company_currency": true,
                "currency": company
            }, function(data) {
                ndata = $.parseJSON(data);
                ndata.forEach(element => {
                    $("#currency").append("<option value='" + element.company_currency_id + "'>" + element.currency + "</option>");
                });
            });
        });


        // Add Out Transfere
        $("#btnaddouttransfere").on("click", function() {
            if ($(".form").valid()) {
                if (receiver_nid_blocked == false && sender_nid_blocked == false) {
                    $(".error").addClass("d-none");
                    $("#show").modal("show");
                    $(".container-waiting").addClass("d-none");
                    // $(".container-done").removeClass("d-none");

                    $.post("../app/Controllers/Saraf.php", $(".form").serialize(), function(data) {

                        $(".container-done").removeClass("d-none");
                        setTimeout(function() {
                            $("#show").modal("hide");
                        }, 2000);
                        $(".form")[0].reset();
                    });

                } else {
                    $(".error").removeClass("d-none").children("span").text("One of NID is blocked please check it again");
                }
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