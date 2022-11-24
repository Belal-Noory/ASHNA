<?php
$Active_nav_name = array("parent" => "Reports", "child" => "All Reports");
$page_title = "KYC " . $_GET["type"];
include("./master/header.php");

$type = $_GET["type"];

$bussiness = new Bussiness();
$custer_type_data = $bussiness->getCustomerByType($user_data->company_id, $type);
$custer_type = $custer_type_data->fetchAll(PDO::FETCH_OBJ);
?>

<style>
    .info {
        cursor: pointer;
    }

    .info:hover {
        font-weight: bold;
    }

    .card-box {
        padding: 20px;
        border-radius: 3px;
        margin-bottom: 30px;
        background-color: #fff;
    }

    .file-man-box {
        padding: 20px;
        border: 1px solid #e3eaef;
        border-radius: 5px;
        position: relative;
        margin-bottom: 20px
    }

    .file-man-box .file-close {
        color: #f1556c;
        position: absolute;
        line-height: 24px;
        font-size: 24px;
        right: 10px;
        top: 10px;
        visibility: hidden
    }

    .file-man-box .file-img-box {
        line-height: 120px;
        text-align: center
    }

    .file-man-box .file-img-box img {
        height: 64px
    }

    .file-man-box .file-download {
        font-size: 32px;
        color: #98a6ad;
        position: absolute;
        right: 10px
    }

    .file-man-box .file-download:hover {
        color: #313a46
    }

    .file-man-box .file-man-title {
        padding-right: 25px
    }

    .file-man-box:hover {
        -webkit-box-shadow: 0 0 24px 0 rgba(0, 0, 0, .06), 0 1px 0 0 rgba(0, 0, 0, .02);
        box-shadow: 0 0 24px 0 rgba(0, 0, 0, .06), 0 1px 0 0 rgba(0, 0, 0, .02)
    }

    .file-man-box:hover .file-close {
        visibility: visible
    }

    .text-overflow {
        text-overflow: ellipsis;
        white-space: nowrap;
        display: block;
        width: 100%;
        overflow: hidden;
    }

    h5 {
        font-size: 15px;
    }
</style>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <div class="container mt-2">
                <div class="card">
                    <div class="card-header">
                        <a class="heading-elements-toggle">
                            <i class="la la-ellipsis-v font-medium-3"></i>
                        </a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <table class="table material-table" id="customersTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>نام</th>
                                        <th>نام نمایشی</th>
                                        <th>نام پدر</th>
                                        <th>جنسیت</th>
                                        <th>وظیفه</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $counter = 1;
                                    foreach ($custer_type as $cus) {
                                        echo "<tr>
                                                <td>$counter</td>
                                                <td class='info' data-href='$cus->customer_id'>$cus->fname $cus->lname</td>
                                                <td>$cus->alies_name</td>
                                                <td>$cus->father</td>
                                                <td>$cus->gender</td>
                                                <td>$cus->job</td>
                                            </tr>";
                                        $counter++;
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade text-center" id="show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true">
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
                                                    <p class="text-secondary mb-1" id="job">Full Stack Developer</p>
                                                    <p class="text-secondary mb-1" id="email">Full Stack Developer</p>
                                                    <p class="text-muted font-size-sm" id="details">Bay Area, San Francisco, CA</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-1 d-none">
                                            <h6 class="text-left">مشخصات بانک</h6>
                                            <ul class="list-group list-group-flush" id="banks"></ul>
                                        </div>
                                        <div class="mt-1 d-none">
                                            <h6 class="text-left">آدرس</h6>
                                            <ul class="list-group list-group-flush" id="address"></ul>
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
                                                            <h4 class="header-title m-b-30 text-left">سند من</h4>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="attach">
                                                        
                                                    </div>
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
        </div>
    </div>
</div>

<?php
include("./master/footer.php");
?>

<script>
    $(document).ready(function() {
        $(document).on("click", ".info", function() {
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
            $.get("../app/Controllers/Bussiness.php", {
                KYC: true,
                cusID: cusID
            }, function(data) {
                ndata = $.parseJSON(data);
                profile = ndata.profile;
                address = ndata.Address;
                bankDetails = ndata.bankDetails;
                attachment = ndata.attachment;
                $("#KYCdetails").html("");
                $("#banks").html("");
                $("#address").html("");
                $("#attach").html("");

                // profile
                name = profile.alies_name === "" ? profile.fname + " " + profile.lname : profile.fname + " " + profile.lname + "," + profile.alies_name;
                $("#name").text(name);
                $("#father").text(profile.father);
                $("#job").text(profile.job);
                $("#details").text(profile.details + " " + profile.note);
                $("#email").text(profile.email);

                generateRow("Gender", profile.gender);
                generateRow("Date of Birth", profile.dob);
                generateRow("Income Source", profile.incomesource);
                generateRow("Monthly Income", profile.monthlyincom);
                generateRow("NID", profile.NID);
                generateRow("TIN", profile.TIN);
                generateRow("Office Details", profile.office_details);
                generateRow("Office Address", profile.office_address);
                generateRow("Official Phone", profile.official_phone);
                generateRow("Phone", profile.personal_phone);
                generateRow("Fax", profile.fax);
                generateRow("Gender", profile.website);

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
                        file_ext = element.attachment_name.substr(element.attachment_name.lastIndexOf(".")+1);
                        file = `<div class="col-lg-3 col-xl-2">
                                    <div class="file-man-box">
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

                $("#show").modal("show");
            });
        });
    });
</script>