<?php
include("../init.php");

$menu = array(
    array("name" => "صفحه عمومی", "url" => "dashboard.php", "icon" => "la-chart-area", "status" => "active", "open" => "", "child" => array()),
    array("name" => "تجارت ", "url" => "", "icon" => "la-business-time", "status" => "", "open" => "", "child" => array(array("name" => "تجارت جدید", "url" => "business.php", "status" => ""), array("name" => "لیست تجارت ها", "url" => "businessList.php", "status" => ""))),
    array("name" => "اشخاص ", "url" => "", "icon" => "la-users", "status" => "", "open" => "", "child" => array(array("name" => "شخص جدید", "url" => "newuser.php", "status" => ""), array("name" => "لیست اشخاص", "url" => "users.php", "status" => "")))
);

$page_title = "صفحه عمومی";

include("./master/header.php");

$company = new Company();
$all_companies = $company->getAllCompanies();
$all_active_company = $company->getAllActiveCompanies();
$all_inactive_company = $company->getAllInctiveCompanies();

$all_users = $company->getCompanyUsers();
$online_users = $company->getCompanyOnlineUser();
?>

<!-- END: Main Menu-->
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- eCommerce statistic -->
            <div class="row">
                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card pull-up">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="media-body text-right">
                                        <h3 class="success"><?php echo $online_users->rowCount(); ?></h3>
                                        <h5>مشتریان انلاین</h5>
                                    </div>
                                    <div>
                                        <i class="la la-users success font-large-2 float-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card pull-up">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="media-body text-right">
                                        <h3 class="danger"><?php echo $all_active_company->rowCount(); ?></h3>
                                        <h5>تجارت ها فعال</h5>
                                    </div>
                                    <div>
                                        <i class="la la-bank info font-large-2 float-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card pull-up">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="media-body text-right">
                                        <h3 class="danger"><?php echo $all_inactive_company->rowCount(); ?></h3>
                                        <h5>تجارت ها غیر فعال</h5>
                                    </div>
                                    <div>
                                        <i class="la la-bank danger font-large-2 float-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card pull-up">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="media-body text-right">
                                        <h3 class="danger"><?php echo $all_companies->rowCount(); ?></h3>
                                        <h5>تجارت ها</h5>
                                    </div>
                                    <div>
                                        <i class="la la-bank success font-large-2 float-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ eCommerce statistic -->
        </div>
    </div>
</div>
<!-- END: Content-->

<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

<?php include("./master/footer.php"); ?>