<?php
$Active_nav_name = array("parent" => "Settings", "child" => "Blocked NIDs");
$page_title = "Blocked NIDs";
include("./master/header.php");

$transfer = new Transfer();
$bussiness = new Bussiness();

$locked_data = $bussiness->GetBlockNIDs();
$locked = $locked_data->fetchAll(PDO::FETCH_OBJ);

?>
<style>
    .hover:hover span {
        transform: scale(1.09);
    }
</style>
<div class="app-content content">
    <div class="content-header row">
    </div>
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="card p-2">
                        <div class="table-responsive">
                            <table class="material-table" id="blockedlist">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>نمبر تذکره</th>
                                        <th>Name</th>
                                        <th>Father Name</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($locked_data->rowCount() > 0) {
                                        $counter = 1;
                                        foreach ($locked as $ptransfer) {
                                            $dat = date("m/d/Y", $ptransfer->reg_date);
                                            echo "<tr>
                                                    <td class='counter'>$counter</td>
                                                    <td>$ptransfer->nid_number</td>
                                                    <td>$ptransfer->fname $ptransfer->lname</td>
                                                    <td>$ptransfer->father</td>
                                                    <td>$dat</td>
                                                    <td><a class='btndelet hover' href='#' data-href='$ptransfer->blocked_nid_id'><span class='las la-trash text-danger la-2x'></span><span class='las la-spinner text-danger spinner la-2x d-none'></span></a></td>
                                                </tr>";
                                            $counter++;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card p-2">
                        <form class="form">
                            <div class="form-group">
                                <label for="nid">NID</label>
                                <input type="text" name="nid" id="nid" class="form-control required" placeholder="NID...">
                            </div>
                            <div class="form-group">
                                <label for="fname">First Name</label>
                                <input type="text" name="fname" id="fname" class="form-control required" placeholder="First Name...">
                            </div>
                            <div class="form-group">
                                <label for="lname">Last Name</label>
                                <input type="text" name="lname" id="lname" class="form-control required" placeholder="Last Name...">
                            </div>
                            <div class="form-group">
                                <label for="father">Father Name</label>
                                <input type="text" name="father" id="father" class="form-control required" placeholder="Father Name...">
                            </div>
                            <input type="hidden" name="addblockednids" id="addblockednids">
                            <div class="form-action">
                                <button class="btn btn-blue text-white" type="button" id="btnaddblockednid">
                                    <span class="las la-check text-white"></span>
                                    <span class="las la-spinner spinner text-white d-none"></span>
                                    Save
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
        tblblocked = $("#blockedlist").DataTable();

        // Add NID
        $("#btnaddblockednid").on("click", function(e) {
            e.preventDefault();
            if ($(".form").valid()) {
                $(this).children("span").first().addClass("d-none");
                $(this).children("span").last().removeClass("d-none");
                $(this).attr("disabled", true);
                ths = $(this);
                formdata = $(".form").serialize();
                $.post("../app/Controllers/Bussiness.php", formdata, function(data) {
                    console.log(data);
                    ndata = $.parseJSON(data);
                    if (ndata[0] == 'error') {
                        console.log("error");
                        console.log(data);
                    } else {
                        counter = 1;
                        if ($(".counter").last().length > 0) {
                            counter = $(".counter").last().text();
                        }
                        name = ndata[1] + " " + ndata[2];
                        btn = `<a class='btndelet hover' href='#' data-href='${ndata[4]}'><span class='las la-trash text-danger la-2x'></span><span class='las la-spinner text-danger spinner la-2x d-none'></span></a>`;
                        tblblocked.row.add([counter, ndata[0], name, ndata[3], ndata[5], btn]).draw(true);
                        $(".form")[0].reset();
                    }
                    $(ths).children("span").first().removeClass("d-none");
                    $(ths).children("span").last().addClass("d-none");
                    $(ths).removeAttr("disabled");
                });
            }
        });

        // Delete NID
        $(document).on("click", ".btndelet", function(e) {
            e.preventDefault();
            ths = $(this);
            parent = $(ths).parent().parent();
            nidID = $(ths).attr("data-href");
            if (!$(ths).attr("loading")) {
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
                                $(ths).attr("loading", true);
                                $(ths).children("span").first().addClass("d-none");
                                $(ths).children("span").last().removeClass("d-none");
                                $.post("../app/Controllers/Bussiness.php", {
                                    removeNID: true,
                                    ID: nidID
                                }, function(data) {
                                    console.log(data);
                                    if (data > 0) {
                                        tblblocked.row(parent).remove().draw(false);
                                    }
                                });
                            }
                        },
                        cancel: {
                            text: 'نخیر',
                            action: function() {}
                        }
                    }
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