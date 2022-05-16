<?php
include("../init.php");

$page_title = "تحارت ها";

$menu = array(
    array("name" => "صفحه عمومی", "url" => "index.php", "icon" => "la-chart-area", "status" => "", "open" => "", "child" => array()),
    array("name" => "تجارت ", "url" => "", "icon" => "la-business-time", "status" => "", "open" => "open", "child" => array(array("name" => "تجارت جدید", "url" => "business.php", "status" => ""), array("name" => "لیست تجارت ها", "url" => "businessList.php", "status" => "active"))),
    array("name" => "اشخاص ", "url" => "", "icon" => "la-users", "status" => "", "open" => "", "child" => array(array("name" => "شخص جدید", "url" => "newuser.php", "status" => ""), array("name" => "لیست اشخاص", "url" => "users.php", "status" => ""))),
    array("name" => " صلاحیت کمپنی ", "url" => "", "icon" => "la-lock", "status" => "", "open" => "", "child" => array(array("name" => "صلاحیت جدید", "url" => "newrule.php", "status" => ""), array("name" => "لیست صلاحیت", "url" => "rules.php", "status" => "")))
);

$page_title = "تجارت جدید";

include("./master/header.php");

$company = new Company();
$all_company = $company->getAllCompanies();
?>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <!-- Material Data Tables -->
            <section id="material-datatables">
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-0">
                            <div class="card-header">
                                <a class="heading-elements-toggle">
                                    <i class="la la-ellipsis-v font-medium-3"></i>
                                </a>
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
                                    <table class="table material-table">
                                        <thead>
                                            <tr>
                                                <th>نام تجارت</th>
                                                <th>نوعیت تجارت</th>
                                                <th>شماره تماس</th>
                                                <th>ایمیل</th>
                                                <th>آغاز سال مالی</th>
                                                <th>پایان سال مالی</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $all_company_data = $all_company->fetchAll(PDO::FETCH_OBJ);
                                            foreach ($all_company_data as $company_data) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $company_data->company_name; ?></td>
                                                    <td><?php echo $company_data->company_type; ?></td>
                                                    <td><?php echo $company_data->phone; ?></td>
                                                    <td><?php echo $company_data->email; ?></td>
                                                    <td><?php echo $company_data->fiscal_year_start; ?></td>
                                                    <td><?php echo $company_data->fiscal_year_end; ?></td>
                                                </tr>

                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Material Data Tables -->
        </div>
    </div>
</div>

<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

<?php include("./master/footer.php"); ?>