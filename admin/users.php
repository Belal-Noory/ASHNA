<?php
include("../init.php");

$page_title = "تحارت ها";

$menu = array(
    array("name" => "صفحه عمومی", "url" => "index.php", "icon" => "la-chart-area", "status" => "", "open" => "", "child" => array()),
    array("name" => "تجارت ", "url" => "", "icon" => "la-business-time", "status" => "", "open" => "", "child" => array(array("name" => "تجارت جدید", "url" => "business.php", "status" => ""), array("name" => "لیست تجارت ها", "url" => "businessList.php", "status" => ""))),
    array("name" => "اشخاص ", "url" => "", "icon" => "la-users", "status" => "", "open" => "open", "child" => array(array("name" => "شخص جدید", "url" => "newuser.php", "status" => ""), array("name" => "لیست اشخاص", "url" => "users.php", "status" => "active"))),
    array("name" => " صلاحیت کمپنی ", "url" => "", "icon" => "la-lock", "status" => "", "open" => "", "child" => array(array("name" => "صلاحیت جدید", "url" => "newrule.php", "status" => ""), array("name" => "لیست صلاحیت", "url" => "rules.php", "status" => "")))
);

$page_title = "لیست تجارت ها";

include("./master/header.php");

$company = new Company();
$all_company = $company->getAllCompanies();

$all_company_users = $company->getCompanyUsers();
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
                                                <th>نام</th>
                                                <th>ایمل/یوزرنیم</th>
                                                <th>پاسورد</th>
                                                <th>کمپنی</th>
                                                <th>آیا انلاین است</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $all_company_users_data = $all_company_users->fetchAll(PDO::FETCH_OBJ);
                                            foreach ($all_company_users_data as $company_user_data) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $company_user_data->fname . " " . $company_user_data->lname; ?></td>
                                                    <td><?php echo $company_user_data->username; ?></td>
                                                    <td><?php echo $company_user_data->password; ?></td>
                                                    <td>
                                                        <?php
                                                        $res = $company->getCompanyByID($company_user_data->company_id);
                                                        $data = $res->fetch(PDO::FETCH_OBJ);
                                                        echo $data->company_name;
                                                        ?>
                                                    </td>
                                                    <td><?php if ($company_user_data->is_online == 1) {
                                                            echo "بلی";
                                                        } else {
                                                            echo "نخیر";
                                                        }; ?></td>
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