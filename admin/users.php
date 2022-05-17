<?php
include("../init.php");

$page_title = "تحارت ها";

$menu = array(
    array("name" => "صفحه عمومی", "url" => "index.php", "icon" => "la-chart-area", "status" => "", "open" => "", "child" => array()),
    array("name" => "تجارت ", "url" => "", "icon" => "la-business-time", "status" => "", "open" => "", "child" => array(array("name" => "تجارت جدید", "url" => "business.php", "status" => ""), array("name" => "لیست تجارت ها", "url" => "businessList.php", "status" => ""))),
    array("name" => "اشخاص ", "url" => "", "icon" => "la-users", "status" => "", "open" => "open", "child" => array(array("name" => "شخص جدید", "url" => "newuser.php", "status" => ""), array("name" => "لیست اشخاص", "url" => "users.php", "status" => "active")))
);

$page_title = "لیست تجارت ها";

include("./master/header.php");

$company = new Company();
$systemAdmin = new SystemAdmin();

$all_company = $company->getAllCompanies();

$all_company_users = $company->getCompanyUsers();

$system_models = $systemAdmin->getSystemModelsParent();
$system_models_data = $system_models->fetchAll(PDO::FETCH_OBJ);
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
                                                <th>کمپنی</th>
                                                <th>انلاین</th>
                                                <th>دسترسی</th>
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
                                                    <td>
                                                        <a href="#" data-href="<?php echo $company_user_data->id; ?>" class="btn btn-sm btn-info btnshowmodel" data-toggle="modal" data-show="false" data-target="#show">
                                                            <span class="la la-plus"></span>
                                                        </a>
                                                    </td>
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

<!-- Modal -->
<div class="modal fade text-left lg" id="show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel5">صلاحیت های مودل ویوزر</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-5">
                <form class="form" id="newuser">
                    <div class="form-body">
                        <p style="line-height: 26px; border:none" class="form-section text-danger text-right">زمانیکه یکی از این مودل ها را در اینجا ثبت کنید یوزر دیگر قادر به دسترسی به این مودل نمیباشد</p>
                        <div class="col-md-12 text-right">
                            <div class="form-group">
                                <select id="modelname" name="modelname" class="form-control required">
                                    <option value="" selected>لطفآ مودل را انتخاب کنید</option>
                                    <?php
                                    foreach ($system_models_data as $model) {
                                        echo "<option value='$model->id'>$model->name_dari</option>";
                                    }
                                    ?>
                                </select>
                                <input type="hidden" name="userID" id="userID">
                            </div>
                        </div>
                        <input type="hidden" name="blockmodel">
                        <button type="button" class="btn btn-primary" id="addnewuser">
                            <i class="la la-check-square-o"></i> ثبت شود
                        </button>
                    </div>
                </form>
            </div>

            <div class="sidenav-overlay"></div>
            <div class="drag-target"></div>

            <?php include("./master/footer.php"); ?>

            <script>
                $(document).ready(function(){
                    $(document).on('click','.btnshowmodel',function(){
                        let data = $(this).attr("data-href");
                        $("#userID").val(data);
                    });
                });
            </script>