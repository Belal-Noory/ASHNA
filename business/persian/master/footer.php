<div class="snackbar snackbar-multi-line bg-danger" id="erroSnackbar">
    <div class="snackbar-body"></div>
    <button class="snackbar-btn text-white" type="button" onclick="$('#erroSnackbar').removeClass('show')"><span class="las la-window-close"></span></button>
</div>

<!-- Modal Single Pending Transaction -->
<div class="modal fade text-center" id="pendingTransctionsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body p-4">
                <div class="table-responsive">
                    <table class="table material-table" id="TablePendingTransaction">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>شماره لیجر</th>
                                <th>تاریخ</th>
                                <th>تفصیلات</th>
                                <th>اکونت</th>
                                <th>مقدار</th>
                                <th>نوعیت</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-blue" id="btnpendingapprove">تایید/پاس</button>
            </div>
        </div>
    </div>
</div>
<?php
$company_details_data = $company->getCompany($user_data->company_id);
$company_details = $company_details_data->fetch(PDO::FETCH_OBJ);
?>
<!-- print  -->
<div class="card print d-none">
    <div class="card-header text-center">
        <h2></h2>
    </div>
    <div class="card-content collapse show">
        <div class="card-body">
            <div class="pheader">
                <div id="section_info">
                    <img src="<?php echo $company_details->logo; ?>" alt="Logo" id="printimg" width="140" height="140">
                    <div id="pheader_address">
                        <span><?php echo $company_details->addres; ?></span>
                        <span><?php echo $company_details->district . "," . $company_details->province . "," . $company_details->country; ?></span>
                        <span><?php echo $company_details->phone; ?></span>
                        <span><?php echo $company_details->email; ?></span>
                        <span><?php echo $company_details->website; ?></span>
                    </div>
                </div>
                <h2><?php echo $company_details->company_name; ?></h2>
            </div>
            <div class="pbody">
                <h3 id="printtitle">Text Title</h3>
                <div id="details">
                    <div>
                        <span>تاریخ: </span>
                        <span id="pdate"></span>
                    </div>
                    <div>
                        <span>ساعت: </span>
                        <span id="ptime"></span>
                    </div>
                    <div>
                        <span>شماره لیجر: </span>
                        <span id="plid"></span>
                    </div>
                    <div class="transfer">
                        <span>نمبر حواله: </span>
                        <span id="ptcode"></span>
                    </div>
                    <div>
                        <span>نوعیت پول: </span>
                        <span id="pcurrency"></span>
                    </div>
                    <div id="amountDiv">
                        <span>Amount</span>
                        <span id="pamount"></span>
                        <span>مبلغ</span>
                    </div>
                </div>
                <div class="subdetails" id="subdetailsfirst">
                    <span id="rfromEtxt">Received From: </span>
                    <span id="rfrom">asd</span>
                    <span id="rfromtxt">دریافت وجه از</span>
                </div>
                <div class="subdetails">
                    <span>Details: </span>
                    <span id="pdetiails">asd</span>
                    <span>شرح</span>
                </div>
                <div class="transfer">
                    <span>ارسال کننده: </span>
                    <span id="psender"></span>
                </div>
                <div class="transfer">
                    <span>دریافت کننده: </span>
                    <span id="preceiver"></span>
                </div>
                <div class="subdetails">
                    <span>Amount by words: </span>
                    <span id="wordamount">as</span>
                    <span>مبلغ به حرف</span>
                </div>
                <div class="subdetails" id="subdetailslast">
                    <div>
                        <span>شصت مشتری</span>
                    </div>
                    <div>
                        <span>اجرا کننده</span>
                        <span id="pby"></span>
                    </div>
                    <div>
                        <span>تایید/پاس کننده</span>
                        <span id="vby"></span>
                    </div>
                </div>
                <div class="subdetails transfer" id="subdetailsAddress">
                    <span>Address: </span>
                    <span id="paddress"></span>
                    <span>آدرس:</span>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade text-center" id="showKYC" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="main-body p-5">
                    <div class="row gutters-sm">
                        <div class="col-md-4 mb-3">
                            <div>
                                <div class="d-flex flex-column align-items-center text-center">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" width="150" id="img" />
                                    <div class="mt-3">
                                        <h4 id="name">John Doe</h4>
                                        <h5 id="father">John Doe</h5>
                                        <p class="text-secondary mb-1" id="jobKYC">Full Stack Developer</p>
                                        <p class="text-secondary mb-1" id="emailKYC">Full Stack Developer</p>
                                        <p class="text-muted font-size-sm" id="detailsKYC">Bay Area, San Francisco, CA</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-1 d-none">
                                <h6 class="text-left">اطلاعات بانکی</h6>
                                <ul class="list-group list-group-flush" id="banksKYC"></ul>
                            </div>
                            <div class="mt-1 d-none">
                                <h6 class="text-left">جزییات آدرس</h6>
                                <ul class="list-group list-group-flush" id="addressKYC"></ul>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-3 p-2">
                                <div class="card-body" id="KYCdetails">

                                </div>
                            </div>
                        </div>
                    </div>
                    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
                    <div class="content">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card-box">
                                        <div class="row">
                                            <div class="col-lg-6 col-xl-6">
                                                <h4 class="header-title m-b-30 text-left">فایل ها</h4>
                                            </div>
                                        </div>
                                        <div class="row" id="attach"></div>
                                    </div>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row -->
                        </div>
                        <!-- container -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- BEGIN: Vendor JS-->
<script src="../app-assets/vendors/js/vendors.min.js"></script>
<!-- <script src="../app-assets/vendors/js/material-vendors.min.js"></script> -->
<!-- BEGIN Vendor JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.6/dist/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="../app-assets/js/core/libraries/bootstrap.min.js"></script>

<!-- BEGIN: Page Vendor JS-->
<script src="../app-assets/vendors/js/ui/jquery.sticky.js"></script>
<script src="../app-assets/vendors/js/forms/extended/card/jquery.card.js"></script>
<script src="../app-assets/vendors/js/extensions/moment.min.js"></script>
<script src="../app-assets/vendors/js/extensions/underscore-min.js"></script>
<script src="../app-assets/vendors/js/extensions/clndr.min.js"></script>
<script src="../app-assets/vendors/js/extensions/jquery.steps.min.js"></script>
<script src="../app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="../app-assets/js/core/app-menu.js"></script>
<script src="../app-assets/js/core/app.js"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script src="../app-assets/js/scripts/pages/material-app.js"></script>
<script src="../app-assets/js/scripts/modal/components-modal.js"></script>
<script src="../app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
<script src="../app-assets/js/scripts/navs/navs.js"></script>
<script src="../app-assets/js/scripts/tables/material-datatable.js"></script>
<script src="../app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js"></script>
<script src="../app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js"></script>

<script src="../app-assets/vendors/js/ui/jquery.sticky.js"></script>
<script src="../app-assets/vendors/js/charts/jquery.sparkline.min.js"></script>
<script src="../app-assets/vendors/js/extensions/jquery.knob.min.js"></script>
<script src="../app-assets/vendors/js/charts/raphael-min.js"></script>
<script src="../app-assets/vendors/js/charts/morris.min.js"></script>
<script src="../app-assets/js/scripts/ui/scrollable.js"></script>
<script src="../assets/js/towords.js"></script>
<!-- END: Page JS-->
<script src="../assets/confirm/js/jquery-confirm.js"></script>
<script src="../assets/comboTreePlugin.js"></script>
<script src="../app-assets/printThis.js"></script>
<script src="../assets/js/print.js"></script>
<!-- JS -->
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/chosen/1.1.0/chosen.jquery.min.js"></script>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
</body>
<!-- END: Body-->
<script>
    $(document).ready(function() {
        $(".loader").delay(1000).fadeOut("slow");
        $("#overlayer").delay(1000).fadeOut("slow");
        $('.toast').toast('show');
        Date.prototype.toDateInputValue = (function() {
            var local = new Date(this);
            local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
            return local.toJSON().slice(0, 10);
        });
        $("input[type='date']").val(new Date().toDateInputValue());

        mainCurrency = $("#mainC").attr("data-href");
        formReady = false;

        elements = `<label class="d-none" id="currencyrate"></label>
                    <span class="las la-spinner spinner blue d-none" id="amountspinner" style="font-size: 30px;"></span>`;
        if ($("#amount").parent().find("label#currencyrate, span.spinner").length === 0) {
            $("#amount").parent().append(elements);
        }

        setInterval(function() {
            $(".alert").not(".alert.contract").fadeOut();
        }, 5000);

        // Load company Banks
        bankslist = Array();
        $.get("../../app/Controllers/banks.php", {
            "getcompanyBanks": true
        }, function(data) {
            newdata = $.parseJSON(data);
            bankslist = newdata;
        });

        // Load company Saifs
        saiflist = Array();
        $.get("../../app/Controllers/banks.php", {
            "getcompanySafis": true
        }, function(data) {
            newdata = $.parseJSON(data);
            saiflist = newdata;
        });

        customersList = Array();
        $.get("../../app/Controllers/banks.php", {
            "getcompanycustomersAccounts": true
        }, function(data) {
            newdata = $.parseJSON(data);
            customersList = newdata;
        });

        // user logout
        $("#btnbusinesslogout").on("click", function(e) {
            e.preventDefault();
            $.post("../../app/Controllers/Company.php", {
                "bussinessLogout": "true"
            }, (data) => {
                window.location.replace("index.php");
            });
        });

        // get upload file name
        $(document).on("change", ".attachInput", function() {
            name = $(this).val().substr($(this).val().lastIndexOf("\\") + 1).toString();
            type = name.substr(name.lastIndexOf(".") + 1).toString();
            if (type == "jpg" || type === "JPG" || type === "pdf" || type === "PDF") {
                $(this).parent().children("#filename").text(name);
            } else {
                $(".mainerror").removeClass("d-none");
                setTimeout(function() {
                    $(".mainerror").addClass("d-none");
                }, 2000);
            }
        });

        // reference to last opened menu
        var $lastOpened = false;

        // simply close the last opened menu on document click
        $(document).click(function() {
            if ($lastOpened) {
                $lastOpened.removeClass('open');
            }
        });

        // simple event delegation
        $(document).on('click', '.pulldown-toggle', function(event) {

            // jquery wrap the el
            var el = $(event.currentTarget);

            // prevent this from propagating up
            event.preventDefault();
            event.stopPropagation();

            // check for open state
            if (el.hasClass('open')) {
                el.removeClass('open');
            } else {
                if ($lastOpened) {
                    $lastOpened.removeClass('open');
                }
                el.addClass('open');
                $lastOpened = el;
            }

        });

        // List accounts based on selected curreny
        $("#currency").on("change", function() {
            currency = $("#currency option:selected").text();
            // hide all options of customer
            $(".customer option").addClass("d-none");

            // hide all option of Revenue items
            $(".customer > option").each(function() {
                if ($(this).hasClass(currency)) {
                    $(this).removeClass("d-none");
                }
            });

            $("#amount").blur();
        });

        // load all banks when clicked on add banks
        $(".addreciptItem").on("click", function() {
            type = $(this).attr("item");

            amoutn_name = "reciptItemAmount";
            item_name = "reciptItemID";
            details_name = "reciptItemdetails";
            // check if selected payable currency is equal to 
            form = `<div class='card bg-light'>
                        <div class="card-header">
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a class='deleteMore' href='#'><i class="ft-x"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-1">`;

            if (type == "bank") {
                form += `<i class="la la-bank" style="font-size: 50px;color:dodgerblue"></i></div>
                                                    <div class="col-lg-7">
                                                        <div class="form-group">
                                                            <label for="${item_name}">بانک</label>
                                                            <select class="form-control customer" name="${item_name}" id="${item_name}" data='bank'>
                                                                <option value="" selected>انتخاب کنید</option>`;
                bankslist.forEach(element => {
                    if (element.currency == $("#currency option:selected").text()) {
                        form += "<option class='" + element.currency + "' value='" + element.chartofaccount_id + "'>" + element.account_name + "</option>";
                    } else {
                        form += "<option class='d-none " + element.currency + "' value='" + element.chartofaccount_id + "'>" + element.account_name + "</option>";
                    }
                });
                form += `</select><label class="d-none balance"></label>
                            </div>
                        </div>`;
            }
            if (type == "saif") {
                form += `<i class="la la-box" style="font-size: 50px;color:dodgerblue"></i></div>
                                                    <div class="col-lg-7">
                                                        <div class="form-group">
                                                            <label for="${item_name}">سیف</label>
                                                            <select class="form-control customer" name="${item_name}" id="${item_name}" data='saif'>
                                                                <option value="" selected>انتخاب کنید</option>`;
                saiflist.forEach(element => {
                    if (element.currency == $("#currency option:selected").text()) {
                        form += "<option class='" + element.currency + "' value='" + element.chartofaccount_id + "'>" + element.account_name + "</option>";
                    } else {
                        form += "<option class='d-none " + element.currency + "' value='" + element.chartofaccount_id + "'>" + element.account_name + "</option>";
                    }
                });
                form += `</select><label class="d-none balance"></label>
                            </div>
                        </div>`;
            }

            if (type == "customer") {
                form += `<i class="la la-user" style="font-size: 50px;color:dodgerblue"></i></div>
                                                    <div class="col-lg-7">
                                                        <div class="form-group">
                                                            <label for="${item_name}">مشتری</label>
                                                            <select class="form-control customer" name="${item_name}" id="${item_name}" data='customer'>`;
                customersList.forEach(element => {
                    form += "<option class='" + element.currency + "' value='" + element.chartofaccount_id + "'>" + element.account_name + "</option>";
                });
                form += '</select><label class="d-none balance"></label></div></div>';

            }

            details = $("#details").val();
            amount = parseFloat($("#sum").text());
            form += ` <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="${amoutn_name}">مقدار</label>
                                            <input type="number" name="${amoutn_name}" id="${amoutn_name}" class="form-control required receiptamount" value="${amount}" placeholder="مقدار" prev="${amount}">
                                            <label class="d-none rate"></label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="${details_name}">تفصیلات</label>
                                            <input type="text" name="${details_name}" id="${details_name}" class="form-control details" placeholder="تفصیلات" value="${details}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;

            $(".receiptItemsContainer, .paymentContainer").html(form);
            if ($(".customer").length > 1) {
                total = 0;
                $(".customer").parent().parent().parent().find("input").each(function() {
                    val = parseFloat($(this).val());
                    if (!isNaN(val)) {
                        total += parseFloat(val);
                    }
                });
                $("#sum").text(amount);
                $("#rest").text((amount - total));
            } else {
                $("#sum").text(amount);
                $("#rest").text(0);
            }
            formReady = true;
        });

        recipt_item_currency = "";
        // Load customer balance
        $(document).on("change", ".customer", function(e) {
            ths = $(this);
            if ($(ths).val() != "") {
                if ($(ths).attr("data") == "customer") {
                    $.get("../../app/Controllers/banks.php", {
                        "getCustomerBalance": true,
                        "cusID": $(ths).val()
                    }, function(data) {
                        res = $.parseJSON(data);
                        if (res.length <= 0) {
                            $(ths).parent().children(".balance").removeClass("d-none").text("Balance: 0");
                        } else {
                            debet = 0;
                            crediet = 0;
                            res.forEach(element => {
                                if (element.ammount_type == "Debet") {
                                    if (element.rate != 0 && element.rate != null) {
                                        debet += parseFloat(element.amount * element.rate);
                                    } else {
                                        debet += parseFloat(element.amount);
                                    }
                                } else {
                                    if (element.rate != 0 && element.rate != null) {
                                        crediet += parseFloat(element.amount * element.rate);
                                    } else {
                                        crediet += parseFloat(element.amount);
                                    }
                                }
                                recipt_item_currency = element.currency;
                            });
                            $(ths).parent().children(".balance").removeClass("d-none").text("Balance: " + (debet - crediet));
                        }
                    });
                }

                if ($(ths).attr("data") == "bank") {
                    $.get("../../app/Controllers/banks.php", {
                        "getBalance": true,
                        "AID": $(ths).val()
                    }, function(data) {
                        res = $.parseJSON(data);
                        if (res.length <= 0) {
                            $(ths).parent().children(".balance").removeClass("d-none").text("Balance: 0");
                        } else {
                            debet = 0;
                            crediet = 0;

                            res.forEach(element => {
                                if (element.ammount_type == "Debet") {
                                    if (element.rate != 0 && element.rate != null) {
                                        debet += parseFloat(element.amount * element.rate);
                                    } else {
                                        debet += parseFloat(element.amount);
                                    }
                                } else {
                                    if (element.rate != 0 && element.rate != null) {
                                        crediet += parseFloat(element.amount * element.rate);
                                    } else {
                                        crediet += parseFloat(element.amount);
                                    }
                                }
                                recipt_item_currency = element.currency;
                            });
                            $(ths).parent().children(".balance").removeClass("d-none").text("Balance: " + (debet - crediet));
                        }
                    });
                }

                if ($(ths).attr("data") == "saif") {
                    $.get("../../app/Controllers/banks.php", {
                        "getBalance": true,
                        "AID": $(ths).val()
                    }, function(data) {
                        res = $.parseJSON(data);
                        if (res.length <= 0) {
                            $(ths).parent().children(".balance").removeClass("d-none").text("Balance: 0");
                        } else {
                            debet = 0;
                            crediet = 0;

                            res.forEach(element => {
                                if (element.ammount_type == "Debet") {
                                    if (element.rate != 0 && element.rate != null) {
                                        debet += parseFloat(element.amount * element.rate);
                                    } else {
                                        debet += parseFloat(element.amount);
                                    }
                                } else {
                                    if (element.rate != 0 && element.rate != null) {
                                        crediet += parseFloat(element.amount * element.rate);
                                    } else {
                                        crediet += parseFloat(element.amount);
                                    }
                                }
                                recipt_item_currency = element.currency;
                            });
                            $(ths).parent().children(".balance").removeClass("d-none").text("Balance: " + (debet - crediet));
                        }
                    });
                }

            } else {
                $(ths).parent().children(".balance").addClass("d-none")
            }

            cusID = $(".customer option:selected").attr("data-href");
            name = $(".customer option:selected").text();
            $(ths).parent().children(".cusKYC").attr("data-href", cusID);
            $(ths).parent().children(".cusKYC").children("span").last().text(name);
            $(ths).parent().children(".cusKYC").removeClass("d-none");
        });

        $(document).on("click", ".cusKYC", function(e) {
            e.preventDefault();
            generateRow = (name, value) => {
                if (value !== "") {
                    $("#KYCdetails").append(`<div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">${name}</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">${value}</div>
                            </div><hr/>`);
                }
            }
            cusID = $(this).attr("data-href");
            $.get("../../app/Controllers/Bussiness.php", {
                KYC: true,
                cusID: cusID
            }, function(data) {
                ndata = $.parseJSON(data);
                profile = ndata.profile;
                address = ndata.Address;
                bankDetails = ndata.bankDetails;
                attachment = ndata.attachment;
                $("#KYCdetails").html("");
                $("#banksKYC").html("");
                $("#addressKYC").html("");
                $("#attach").html("");

                // profile
                name = profile.alies_name === "" ? profile.fname + " " + profile.lname : profile.fname + " " + profile.lname + "," + profile.alies_name;
                $("#name").text(name);
                $("#father").text(profile.father);
                $("#jobKYC").text(profile.job);
                $("#detailsKYC").text(profile.details + " " + profile.note);
                $("#emailKYC").text(profile.email);

                generateRow("جنسیت", profile.gender);
                generateRow("تاریخ تولد", profile.dob);
                generateRow("منبع درآمد", profile.incomesource);
                generateRow("درآمد ماهانه", profile.monthlyincom);
                generateRow("تذکره", profile.NID);
                generateRow("نمبر تشخصیه", profile.TIN);
                generateRow("اطلاعات دفتر", profile.office_details);
                generateRow("ادرس دفتر", profile.office_address);
                generateRow("شماره تماس رسمی", profile.official_phone);
                generateRow("شماره تماس", profile.personal_phone);
                generateRow("فاکس", profile.fax);
                generateRow("ویب سایت", profile.website);

                // Bank Details
                bankDetails.forEach(element => {
                    if (element.bank_name != "") {

                        details = `<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0" style="display: flex;align-items:center;">
                                            <span class="las la-credit-card mr-1" style="font-size: 2rem;color:dodgerblue"></span>
                                            ${element.bank_name}
                                        </h6>
                                        <span class="text-secondary">${element.currency}</span>
                                    </li>`;
                        $("#banks").append(details);
                        $("#banks").parent().removeClass("d-none");
                    }
                });

                // address Details
                address.forEach(element => {
                    if (element.province !== "") {
                        details = `<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0" style="display: flex;align-items:center;">
                                            <span class="las la-map mr-1" style="font-size: 2rem;color:dodgerblue"></span>
                                            ${element.address_type+": "+element.detail_address+","+element.district}
                                        </h6>
                                        <span class="text-secondary">${element.province}</span>
                                    </li>`;
                        $("#address").append(details);
                        $("#address").parent().removeClass("d-none");
                    }
                });

                // attachments
                attachment.forEach(element => {
                    if (element.attachment_type == "profile") {
                        $("#img").attr("src", "uploadedfiles/customerattachment/" + element.attachment_name);
                    } else {
                        // types = ["pdf.svg","doc.svg","png.svg","jpg.svg"];
                        // get the file extenstion
                        file_ext = element.attachment_name.substr(element.attachment_name.lastIndexOf(".") + 1);
                        file = `<div class="col-lg-3 col-xl-2">
                                    <div class="file-man-box">
                                        <a href="uploadedfiles/customerattachment/${element.attachment_name}" class="lightbox file-close" aria-haspopup="dialog" title="${element.attachment_name}"><i class="fa fa-eye"></i></a>
                                        <div class="file-img-box">
                                            <img src="https://coderthemes.com/highdmin/layouts/assets/images/file_icons/${file_ext}.svg" alt="icon">
                                        </div>
                                        <a href="uploadedfiles/customerattachment/${element.attachment_name}" class="file-download" download><i class="fa fa-download"></i></a>
                                        <div class="file-man-title">
                                            <h5 class="mb-0 text-overflow">${element.attachment_name}</h5>
                                        </div>
                                    </div>
                                </div>`;
                        $("#attach").append(file);
                    }
                });

                $("#showKYC").modal("show");
            });
        });

        $("#details").on("keyup", function() {
            $(".details").val($(this).val());
        });

        $("#amount").on("keyup", function(e) {
            e.preventDefault();
            val = $(this).val().toString();
            if (val.length > 0) {
                val = parseFloat($(this).val());
                rest = parseFloat($("#rest").text());
                if (rest != 0 && find(".receiptamountr").length > 0) {
                    $(".receiptamount").each(function() {
                        rest - +parseFloat(val);
                    });
                    $("#rest").text(rest);
                } else {
                    $("#rest").text(val);
                }
                $("#sum").text(val);
            }
        });

        $("#amount").on("blur", function(e) {
            e.preventDefault();
            amount = parseFloat($(this).val());
            currency = $("#currency option:selected").text();
            if (amount > 0) {
                if (currency != mainCurrency) {
                    $("#amountspinner").removeClass("d-none");
                    $.get("../../app/Controllers/banks.php", {
                            "getExchange": true,
                            "from": currency,
                            "to": mainCurrency
                        },
                        function(data) {
                            $("#amountspinner").addClass("d-none");
                            if (data != "false") {
                                ndata = JSON.parse(data);
                                $("#currencyrate").removeClass("d-none");
                                $("#currencyrate").addClass("mt-1");
                                if (ndata.currency_from == currency) {
                                    $("#currencyrate").html(`<span class='badge badge-danger'>Rate: ${ndata.rate}</span> <span class='badge badge-blue'>New amount: ${parseFloat(ndata.rate)*parseFloat(amount)} - ${mainCurrency} </span>`);
                                    $("#rate").val(parseFloat(ndata.rate));
                                } else {
                                    $("#rate").val(parseFloat((1 / ndata.rate)));
                                    $("#currencyrate").text(`Rate: ${1/ndata.rate} New amount: ${parseFloat((1/ndata.rate))*parseFloat(amount)}`);
                                    $("#currencyrate").html(`<span class='badge badge-danger'>Rate: ${ndata.rate}</span> <span class='badge badge-blue'>New amount: ${parseFloat((1/ndata.rate))*parseFloat(amount)} - ${mainCurrency}</span>`);
                                }
                            } else {
                                if (!$("#erroSnackbar").hasClass("show")) {
                                    $("#erroSnackbar").addClass("show");
                                    $("#erroSnackbar").children(".snackbar-body").html(`Please add exchange from ${currency} to ${mainCurrency}`);
                                }
                            }
                        });
                } else {
                    $("#erroSnackbar").removeClass("show");
                    $("#amountspinner").addClass("d-none");
                    $("#currencyrate").addClass("d-none");
                    $("#rate").val('0');
                }
            } else {
                $("#erroSnackbar").removeClass("show");
                $("#amountspinner").addClass("d-none");
                $("#currencyrate").addClass("d-none");
                $("#rate").val('0');
            }
        });

        $(document).on("change", ".receiptamount", function() {
            if (parseFloat($(this).attr("prev")) > 0) {
                $("#rest").text((parseFloat($("#rest").text()) - parseFloat($(this).attr("prev"))) + parseFloat($(this).val()));
            } else {
                $("#rest").text((parseFloat($("#rest").text()) - parseFloat($(this).val())));
            }
            $(this).attr("prev", $(this).val());
        });

        $(document).on("keyup", ".receiptamount", function() {
            $(this).attr("value", $(this).val());
        });

        $(document).on("click", ".deleteMore", function(e) {
            e.preventDefault();
            val = $(this).parent().parent().parent().parent().parent().children(".card-content").children(".card-body").children(".row").children("div").children(".form-group").children("input");
            $("#rest").text((parseFloat($("#rest").text()) + parseFloat($(val).val())));
            $(this).parent().parent().parent().parent().parent().remove();
            counter--;
            $("#paymentIDcounter").val(counter);
        });

        // show single transaction
        let pendingTable = $("#TablePendingTransaction").DataTable();
        lastNoti = null;
        $(document).on("click", ".btnshowpendingtransactionmodel", function(e) {
            e.preventDefault();
            pendingTable.clear().draw();
            LID = $(this).attr("data-href");
            lastNoti = $(this);
            $("#btnpendingapprove").attr("data-href", LID);
            $.get("../../app/Controllers/SystemAdmin.php", {
                pendingT: true,
                LID: LID
            }, function(data) {
                if (data) {
                    ndata = $.parseJSON(data);
                    counter = 1;
                    var clean = ndata.filter((arr, index, self) => index === self.findIndex((t) => (t.reg_date === arr.reg_date && t.amount === arr.amount && t.ammount_type === arr.ammount_type)))

                    clean.forEach(element => {
                        // date
                        date = new Date(element.reg_date * 1000);
                        newdate = date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate();
                        pendingTable.row.add([counter, element.leadger_id, newdate, element.detials, element.account_name, element.amount, element.ammount_type]).draw(false);
                        counter++;
                    });
                    $("#pendingTransctionsModal").modal("show");
                }
            });
        });

        // approve transactions
        $("#btnpendingapprove").on("click", function(e) {
            e.preventDefault();
            LID = $(this).attr("data-href");
            ths = $(this);
            $.confirm({
                icon: 'fa fa-smile-o',
                theme: 'modern',
                closeIcon: true,
                animation: 'scale',
                type: 'blue',
                title: 'مطمین هستید؟',
                content: '',
                buttons: {
                    confirm: {
                        text: 'بلی',
                        action: function() {
                            $.post("../../app/Controllers/SystemAdmin.php", {
                                apporveTransactions: true,
                                LID: LID
                            }, function(data) {
                                console.log(data);
                                pendingTable.clear().draw();
                                $("#pendingTransctionsModal").modal("hide");
                                $(lastNoti).parent().parent().parent().parent().fadeOut();
                                totalN = parseInt($("#totalNotifi").text());
                                totalN--;
                                $("#totalNotifi").text(totalN);
                            });
                        }
                    },
                    cancel: {
                        text: 'نخیر',
                        action: function() {}
                    }
                }
            });
        });

        // Delete leagder
        $(document).on("click", ".btndelete", function() {
            LID = $(this).attr("data-href");
            ths = $(this);
            $(this).children("i:first").addClass("d-none");
            $(this).children("i:last").removeClass("d-none");
            $.confirm({
                icon: 'fa fa-smile-o',
                theme: 'modern',
                closeIcon: true,
                animation: 'scale',
                type: 'blue',
                title: 'مطمین هستید؟',
                content: '',
                buttons: {
                    confirm: {
                        text: 'بلی',
                        action: function() {
                            $.post("../../app/Controllers/SystemAdmin.php", {
                                DL: true,
                                LID: LID
                            }, function(data) {
                                $(ths).parent().parent().remove();
                            });
                        }
                    },
                    cancel: {
                        text: 'نخیر',
                        action: function() {}
                    }
                }
            });
        });

        // get new notification
        setInterval(() => {
            $.post("../../app/Controllers/SystemAdmin.php", {
                newNotification: true
            }, function(data) {
                ndata = $.parseJSON(data);
                getNotificationLength = parseInt($("#totalNotifi").text());
                getNotificationLength = ndata[0];
                $("#totalNotifi").text(getNotificationLength);
                if ($("#notifications").children("#noNotification").length > 0) {
                    $("#notifications").children("#noNotification").remove();
                }
                if ($("#notifications").children(".notification").length > 0) {
                    $("#notifications").children(".notification").remove();
                }

                op_types = {transferout:"حواله خروجی",transferin:"حواله داخلی",Revenue:"درآمد",Expense:"مصارف",Payment:"پرداخت",Receipt:"دریافت"};
                ndata[1].forEach(element => {
                    type = op_types[element.op_type];
                    li = `<li class='media-list w-100 notification' dir='rtl'>
                                        <a href='javascript:void(0)'>
                                            <div class='media'>
                                                <div class='media-left align-self-center'>
                                                    <i class='la la-eye icon-bg-circle bg-cyan mr-0 btnshowpendingtransactionmodel' data-href='${element.leadger_id}'></i>
                                                </div>
                                                <div class='media-body'>
                                                    <h6 class='media-heading'>${type}: شماره ${element.leadger_id}</h6>
                                                    <p class='notification-text font-small-3 text-muted'>${element.remarks}</p><small>
                                                </div>
                                            </div>
                                        </a>
                                </li>`;
                    $("#notifications").append(li);
                });
            });
        }, 10000);

        // check session
        setInterval(() => {
            $.post("../../app/Controllers/Company.php", {
                checkSession: true
            }, function(data) {
                lang = document.getElementsByTagName('html')[0].getAttribute('lang');
                if (data == 1) {
                    if(lang === "fa")
                    {
                        window.location.replace("../index.php");
                    }
                    else{
                        window.location.replace("index.php");
                    }
                }
            });
        }, 5000);


        // attachement overlay
        // When the exit button is clicked
        $("#overlayimg").hide();
        $("#overlayimg").on("click",function() {
            // Fade out the overlay
            $("#overlayimg").fadeOut("slow");
        });

        $(document).on("click",".lightbox",function(event) {
            // Prevents default behavior
            event.preventDefault();
            // Adds href attribute to variable
            var imageLocation = $(this).attr("href");
            // Add the image src to $image
            $("#imgoverlay").attr("src", imageLocation);
            // Fade in the overlay
            $("#overlayimg").fadeIn("slow");
        });
    });
</script>

</html>