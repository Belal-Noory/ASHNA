<div class="snackbar snackbar-multi-line bg-danger" id="erroSnackbar">
    <div class="snackbar-body">

    </div>
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
                                <th>TID</th>
                                <th>Leadger</th>
                                <th>Date</th>
                                <th>Details</th>
                                <th>Amount</th>
                                <th>T-Type</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-blue" id="btnpendingapprove">Approve</button>
            </div>
        </div>
    </div>
</div>

<!-- BEGIN: Vendor JS-->
<script src="app-assets/vendors/js/vendors.min.js"></script>
<!-- <script src="app-assets/vendors/js/material-vendors.min.js"></script> -->
<!-- BEGIN Vendor JS-->
<script src="app-assets/js/core/libraries/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>

<!-- BEGIN: Page Vendor JS-->
<script src="app-assets/vendors/js/ui/jquery.sticky.js"></script>
<script src="app-assets/vendors/js/forms/extended/card/jquery.card.js"></script>
<script src="app-assets/vendors/js/extensions/moment.min.js"></script>
<script src="app-assets/vendors/js/extensions/underscore-min.js"></script>
<script src="app-assets/vendors/js/extensions/clndr.min.js"></script>
<script src="app-assets/vendors/js/extensions/jquery.steps.min.js"></script>
<script src="app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="app-assets/js/core/app-menu.js"></script>
<script src="app-assets/js/core/app.js"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script src="app-assets/js/scripts/pages/material-app.js"></script>
<script src="app-assets/js/scripts/modal/components-modal.js"></script>
<script src="app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
<script src="app-assets/js/scripts/navs/navs.js"></script>
<script src="app-assets/js/scripts/tables/material-datatable.js"></script>
<script src="app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js"></script>
<script src="app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js"></script>

<script src="app-assets/vendors/js/ui/jquery.sticky.js"></script>
<script src="app-assets/vendors/js/charts/jquery.sparkline.min.js"></script>
<script src="app-assets/vendors/js/extensions/jquery.knob.min.js"></script>
<script src="app-assets/vendors/js/charts/raphael-min.js"></script>
<script src="app-assets/vendors/js/charts/morris.min.js"></script>
<script src="app-assets/js/scripts/ui/scrollable.js"></script>

<!-- END: Page JS-->

<script src="assets/confirm/js/jquery-confirm.js"></script>
<script src="assets/comboTreePlugin.js"></script>
<!-- JS -->
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/chosen/1.1.0/chosen.jquery.min.js"></script>

</body>
<!-- END: Body-->
<script>
    $(document).ready(function() {
        $(".loader").delay(1000).fadeOut("slow");
        $("#overlayer").delay(1000).fadeOut("slow");

        mainCurrency = $("#mainC").attr("data-href");
        $("#amount").val(0);
        formReady = false;

        elements = `<label class="d-none" id="currencyrate"></label>
                    <span class="las la-spinner spinner blue d-none" id="amountspinner" style="font-size: 30px;"></span>`;
        if ($("#amount").parent().find("label#currencyrate, span.spinner").length === 0) {
            $("#amount").parent().append(elements);
        }

        setInterval(function() {
            $(".alert").fadeOut();
            $(".contract").fadeIn();
        }, 5000);

        // Load company Banks
        bankslist = Array();
        $.get("../app/Controllers/banks.php", {
            "getcompanyBanks": true
        }, function(data) {
            newdata = $.parseJSON(data);
            bankslist = newdata;
        });

        // Load company Saifs
        saiflist = Array();
        $.get("../app/Controllers/banks.php", {
            "getcompanySafis": true
        }, function(data) {
            newdata = $.parseJSON(data);
            saiflist = newdata;
        });

        customersList = Array();
        $.get("../app/Controllers/banks.php", {
            "getcompanycustomersAccounts": true
        }, function(data) {
            newdata = $.parseJSON(data);
            customersList = newdata;
        });

        // user logout
        $("#btnbusinesslogout").on("click", function(e) {
            e.preventDefault();
            $.post("../app/Controllers/Company.php", {
                "bussinessLogout": "true"
            }, (data) => {
                window.location.replace("index.php");
            });
        });

        // get upload file name
        $(document).on("change", ".attachInput", function() {
            $(this).parent().children("#filename").text($(this).val().substr($(this).val().lastIndexOf("\\") + 1));
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

        counter = 1;
        first = true;
        // load all banks when clicked on add banks
        $(".addreciptItem").on("click", function() {
            type = $(this).attr("item");

            amoutn_name = "reciptItemAmount";
            item_name = "reciptItemID";
            details_name = "reciptItemdetails";

            // if its not first time that clicked this button
            if (first == false) {
                amoutn_name = "reciptItemAmount" + counter;
                item_name = "reciptItemID" + counter;
                details = "reciptItemdetails" + counter;
                $("#receptItemCounter").val(counter);
                counter++;
            }

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
                                                            <label for="${item_name}">Bank</label>
                                                            <select class="form-control customer" name="${item_name}" id="${item_name}" data='bank'>
                                                                <option value="" selected>Select</option>`;
                bankslist.forEach(element => {
                    form += "<option class='" + element.currency + "' value='" + element.chartofaccount_id + "'>" + element.account_name + "</option>";
                });
                form += `</select><label class="d-none balance"></label>
                            </div>
                        </div>`;
            }
            if (type == "saif") {
                form += `<i class="la la-box" style="font-size: 50px;color:dodgerblue"></i></div>
                                                    <div class="col-lg-7">
                                                        <div class="form-group">
                                                            <label for="${item_name}">Saif</label>
                                                            <select class="form-control customer" name="${item_name}" id="${item_name}" data='saif'>
                                                                <option value="" selected>Select</option>`;
                saiflist.forEach(element => {
                    form += "<option class='" + element.currency + "' value='" + element.chartofaccount_id + "'>" + element.account_name + "</option>";
                });
                form += `</select><label class="d-none balance"></label>
                            </div>
                        </div>`;
            }

            if (type == "customer") {
                form += `<i class="la la-user" style="font-size: 50px;color:dodgerblue"></i></div>
                                                    <div class="col-lg-7">
                                                        <div class="form-group">
                                                            <label for="${item_name}">Contact</label>
                                                            <select class="form-control" name="${item_name}" id="${item_name}" data='customer'>`;
                customersList.forEach(element => {
                    form += "<option class='" + element.currency + "' value='" + element.chartofaccount_id + "'>" + element.account_name + "</option>";
                });
                form += '</select><label class="d-none balance"></label></div></div>';

            }

            details = $("#details").val();
            amount = 0;
            if (first) {
                amount = $("#amount").val();
            } else {
                amount = 0;
            }

            form += ` <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="${amoutn_name}">Amount</label>
                                            <input type="number" name="${amoutn_name}" id="${amoutn_name}" class="form-control required receiptamount" value="${amount}" placeholder="Amount" prev="${amount}">
                                            <label class="d-none rate"></label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="${details_name}">Details</label>
                                            <input type="text" name="${details_name}" id="${details_name}" class="form-control details" placeholder="Details" value="${details}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;

            $(".receiptItemsContainer, .paymentContainer").append(form);
            if (first) {
                $("#sum").text(amount);
                $("#rest").text("0");
            }
            $("#paymentIDcounter").val(counter);
            first = false;
            formReady = true;
        });

        recipt_item_currency = "";
        // Load customer balance
        $(document).on("change", ".customer", function() {
            ths = $(this);
            if ($(ths).val() != "") {
                if ($(ths).attr("data") == "customer") {
                    $.get("../app/Controllers/banks.php", {
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
                                    debet += parseFloat(element.amount);
                                } else {
                                    crediet += parseFloat(element.amount);
                                }
                                recipt_item_currency = element.currency;
                            });
                            $(ths).parent().children(".balance").removeClass("d-none").text("Balance: " + (debet - crediet));
                        }
                    });
                }

                if ($(ths).attr("data") == "bank") {
                    $.get("../app/Controllers/banks.php", {
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
                                    debet += parseFloat(element.amount);
                                } else {
                                    crediet += parseFloat(element.amount);
                                }
                                recipt_item_currency = element.currency;
                            });
                            $(ths).parent().children(".balance").removeClass("d-none").text("Balance: " + (debet - crediet));
                        }
                    });
                }

                if ($(ths).attr("data") == "saif") {
                    $.get("../app/Controllers/banks.php", {
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
                                    debet += parseFloat(element.amount);
                                } else {
                                    crediet += parseFloat(element.amount);
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
        });

        $("#details").on("keyup", function() {
            $(".details").val($(this).val());
        });

        $("#amount").on("keyup", function() {
            rest = parseFloat($("#rest").text());
            if (rest != 0 && find(".receiptamountr").length > 0) {
                $(".receiptamount").each(function() {
                    rest -+ parseFloat($(this).val());
                });
                $("#rest").text(rest);
            } else {
                $("#rest").text($(this).val());
            }
            $("#sum").text($(this).val());
        });

        $("#amount").on("blur", function() {
            amount = $(this).val();
            currency = $("#currency option:selected").text();
            if (amount.length > 0) {
                if (currency != mainCurrency) {
                    $("#amountspinner").removeClass("d-none");
                    $.get("../app/Controllers/banks.php", {
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
            console.log($("#rest").text());
            $(this).parent().parent().parent().parent().parent().fadeOut();
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
            $.get("../app/Controllers/SystemAdmin.php", {
                pendingT: true,
                LID: LID
            }, function(data) {
                if (data) {
                    ndata = $.parseJSON(data);
                    counter = 1;
                    ndata.forEach(element => {
                        pendingTable.row.add([counter, element.account_money_id, element.leadger_id, element.reg_date, element.detials, element.amount, element.ammount_type]).draw(false);
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
            $.post("../app/Controllers/SystemAdmin.php", {
                apporveTransactions: true,
                LID: LID
            }, function(data) {
                pendingTable.clear().draw();
                $("#pendingTransctionsModal").modal("hide");
                $(lastNoti).parent().parent().parent().parent().fadeOut();
                totalN = parseInt($("#totalNotifi").text());
                totalN--;
                $("#totalNotifi").text(totalN);
            });
        });
    });
</script>

</html>