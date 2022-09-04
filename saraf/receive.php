<?php
$menue = array(
    array("name" => "ارسال ها", "url" => "send.php", "icon" => "la-send", "active" => ""),
    array("name" => "دریافت ها", "url" => "receive.php", "icon" => "la-arrow-left", "active" => "active"),
);
$page_title = "دریافت ها";
include("./master/header.php");

$company = new Company();
$saraf = new Saraf();

$pending_transfers_data = $saraf->getPendingInTransfer($loged_user->customer_id);
$pending_transfers = $pending_transfers_data->fetchAll(PDO::FETCH_OBJ);

$paid_transfers_data = $saraf->getPaidInTransfer($loged_user->customer_id);
$paid_transfers = $paid_transfers_data->fetchAll(PDO::FETCH_OBJ);
?>
<!-- END: Main Menu-->
<!-- BEGIN: Content-->
<div class="container pt-2">
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
                                                                <table class="table table-striped table-bordered zero-configuration" id="tb1">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>تاریخ</th>
                                                                            <th>نمبر حواله</th>
                                                                            <th>توضیحات</th>
                                                                            <th>شرکت</th>
                                                                            <th>از طرف(ارسال کننده پول)</th>
                                                                            <th>به کی(گیرینده پول)</th>
                                                                            <th>مقدار پول</th>
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
                                                                            <td>$ptransfer->transfer_code</td>
                                                                            <td class='tRow' data-href='$ptransfer->leadger_id'>$ptransfer->details</td>
                                                                            <td>$to->company_name</td>
                                                                            <td>$ptransfer->sender_fname $ptransfer->sender_lname</td>
                                                                            <td>$ptransfer->res_fname  $ptransfer->res_lname</td>
                                                                            <td>$ptransfer->amount-$ptransfer->currency</td>
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
                                                                        <th>تاریخ</th>
                                                                        <th>نمبر حواله</th>
                                                                        <th>توضیحات</th>
                                                                        <th>شرکت</th>
                                                                        <th>از طرف(ارسال کننده پول)</th>
                                                                        <th>به کی(گیرینده پول)</th>
                                                                        <th>مقدار پول</th>
                                                                        <th>تایید</th>
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
                                                                            <td>$ptransfer->transfer_code</td>
                                                                            <td class='tRow' data-href='$ptransfer->leadger_id'>$ptransfer->details</td>
                                                                            <td>$to->company_name</td>
                                                                            <td>$ptransfer->sender_fname $ptransfer->sender_lname</td>
                                                                            <td>
                                                                                <button type='button' data-href='$ptransfer->money_receiver' class='btn btn-danger block btn-sm waves-effect waves-light showreceiverModel'>
                                                                                    $ptransfer->res_fname $ptransfer->res_lname 
                                                                                </button>
                                                                            </td>
                                                                            <td>$ptransfer->amount-$ptransfer->currency</td>
                                                                            <td><a class='btn btn-blue btnapprovebysaraf' data-href='$ptransfer->company_money_transfer_id' href='#'><span class='las la-thumbs-up'></span></a></td>
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

<!-- Modal Receiver -->
<div class="modal fade text-left" id="receiverModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary white">
                <h4 class="modal-title white" id="myModalLabel8">Money Receiver Details</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="receiverForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="currency">Phone Number</label>
                        <input type="text" class="form-control" name="receiver_phone" id="receiver_phone" placeholder="Phone Number" />
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-xs-12">
                            <label for="currency">First Name</label>
                            <input type="text" class="form-control required" name="receiver_fname" id="receiver_fname" placeholder="First Name" />
                        </div>
                        <div class="form-group col-md-6 col-xs-12">
                            <label for="currency">Last Name</label>
                            <input type="text" class="form-control" name="receiver_lname" id="receiver_lname" placeholder="Last Name" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6 col-xs-12">
                            <label for="currency">Father Name</label>
                            <input type="text" class="form-control" name="receiver_Fathername" id="receiver_Fathername" placeholder="Father Name" />
                        </div>
                        <div class="form-group col-md-6 col-xs-12">
                            <label for="currency">NID</label>
                            <input type="text" class="form-control" name="receiver_nid" id="receiver_nid" placeholder="NID" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="details">Description</label>
                        <textarea id="receiver_details" class="form-control p-0" rows="1" style="border:none; border-bottom:1px solid gray" placeholder="Description" name="receiver_details"></textarea>
                    </div>
                    <div class="attachContainer">
                        <h6 class="text-muted">Uploaded Attachments</h6>
                        <ul class="list-group uploaded">

                        </ul>
                        <div class='form-group attachement'>
                            <div class="d-flex justify-content-between align-items-center receiverAttach">
                                <div class="form-group">
                                    <label for='attachmentreceiver'>
                                        <span class='las la-file-upload blue'></span>
                                    </label>
                                    <i id='filename'>filename</i>
                                    <input type='file' class='form-control d-none attachInput' id='attachmentreceiver' name='attachmentreceiver' />
                                </div>
                                <div class="form-group">
                                    <select type="text" id="attachTypereceiver" class="form-control" placeholder="Type" name="attachTypereceiver">
                                        <option value="NID">NID</option>
                                        <option value="Passport">Passport</option>
                                        <option value="Driving license">Driving license</option>
                                        <option value="Company license">Company license</option>
                                        <option value="TIN">TIN</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <span></span>
                            </div>
                        </div>
                        <button type="button" class="btn btn-blue" id="btnaddreceiverattach"><span class="las la-plus"></span></button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary waves-effect waves-light" id="updatereceiver">
                        <i class="la la-check"></i>
                        <i class="la la-spinner spinner d-none"></i>
                        Save changes
                    </button>
                </div>
                <input type="hidden" name="attachCountreceiver" id="attachCountreceiver" value="0">
                <input type="hidden" name="receiverID" id="receiverID">
                <input type="hidden" name="updatereceiver" id="updatereceiver">
            </form>
        </div>
    </div>
</div>

<!-- END: Content-->
<?php include("./master/footer.php") ?>

<script>
    $(document).ready(function() {
        t = $("#tb1").DataTable();

        // show receiver model
        $(document).on("click", ".showreceiverModel", function(e) {
            e.preventDefault();
            $RID = $(this).attr("data-href");
            $("#receiverID").val($RID);
            $.get("../app/Controllers/Transfer.php", {
                DCMSAttach: true,
                id: $RID
            }, function(data) {
                ndata = $.parseJSON(data);
                $("#receiver_phone").val(ndata[0].personal_phone);
                $("#receiver_fname").val(ndata[0].fname);
                $("#receiver_lname").val(ndata[0].lname);
                $("#receiver_Fathername").val(ndata[0].alies_name);
                $("#receiver_nid").val(ndata[0].NID);
                $("#receiver_details").val(ndata[0].note);

                $(".uploaded").html("");
                ndata.forEach(element => {
                    if (element.type) {
                        $(".uploaded").append(`<li class="list-group-item">
                                    <span class="float-right">
                                        <i class="la la-check"></i>
                                    </span>
                                    ${element.type}
                                </li>`);
                    }
                });
            });
            $("#receiverModel").modal("show");
        });

        receiverCounter = 1;
        $("#btnaddreceiverattach").on("click", function() {
            name = "attachmentreceiver" + receiverCounter;
            type = "attachTypereceiver" + receiverCounter;
            if (receiverCounter < 6) {
                form = `<div class="d-flex justify-content-between align-items-center">
                            <div class="form-group">
                                <label for='${name}'>
                                    <span class='las la-file-upload blue'></span>
                                </label>
                                <i id='filename'>filename</i>
                                <input type='file' class='form-control d-none attachInput' id='${name}' name='${name}' />
                            </div>
                            <div class="form-group">
                                <select type="text" id="${type}" class="form-control" placeholder="Type" name="${type}">
                                    <option value="NID">NID</option>
                                    <option value="Passport">Passport</option>
                                    <option value="Driving license">Driving license</option>
                                    <option value="Company license">Company license</option>
                                    <option value="TIN">TIN</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <a href='#' class='deletedailyattachreceiver' style='font-size:25px'><span class='las la-trash danger'></span></a>
                    </div>
                `
                $(".receiverAttach").parent().append(form);
                $("#attachCountreceiver").val(receiverCounter);
                receiverCounter++;
            } else {
                if ($(this).parent().children(".alert").length <= 0) {
                    error = `<span class='alert alert-danger mt-1'>Cannot add more then 6 attachments</span>`;
                    $(this).parent().append(error);
                }
            }
        });

         // update receiver details
         $(document).on("submit", ".receiverForm", function(e) {
            e.preventDefault();
            $.ajax({
                url: "../app/Controllers/Transfer.php",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $("#updatereceiver").children(".spinner").removeClass("d-none");
                    $("#updatereceiver").children(".la-check").addClass("d-none");
                    $("#updatereceiver").attr("disabled");
                },
                success: function(data) {
                    console.log(data);
                    $("#updatereceiver").children(".spinner").addClass("d-none");
                    $("#updatereceiver").children(".la-check").removeClass("d-none");
                    $("#updatereceiver").removeAttr("disabled");
                },
                error: function(e) {
                    console.log(e);
                }
            });
        });

        // approve pending transaction
        $(document).on("click", ".btnapprovebysaraf", function(e) {
            e.preventDefault();
            TID = $(this).attr("data-href");
            ths = $(this);

            $.confirm({
                icon: 'fa fa-smile-o',
                theme: 'modern',
                closeIcon: true,
                animation: 'scale',
                type: 'blue',
                title: 'لطفآ مطمین شوید که قل از تایید کردن معلومات گیرنده پول را خانه پوری کنید',
                content: '',
                buttons: {
                    confirm: {
                        text: 'بلی خانه پری شده',
                        action: function() {
                            $.post("../app/Controllers/Saraf.php", {
                                "approve": true,
                                "TID": TID
                            }, function(data) {
                                $(ths).parent().parent().fadeOut();
                                t.row.add([$(ths).parent().parent().children("td:nth-child(1)").text(), $(ths).parent().parent().children("td:nth-child(2)").text(), $(ths).parent().parent().children("td:nth-child(3)").text(), $(ths).parent().parent().children("td:nth-child(4)").text(), $(ths).parent().parent().children("td:nth-child(5)").text()]).draw(false);
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
    });
</script>