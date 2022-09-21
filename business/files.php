<?php
$Active_nav_name = array("parent" => "Settings", "child" => "File Management");
$page_title = "File Manager";
include("./master/header.php");

$fileManager = new FileManagement();

$customers_type_data = $fileManager->getUniqueCustomerType($user_data->company_id);
$customers_type = $customers_type_data->fetchAll(PDO::FETCH_OBJ);
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
            <div class="card" style="">
                <div class="card-header">
                    <h4 class="card-title">Customer File Management</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <?php
                        if ($customers_type_data->rowCount() > 0) { ?>
                            <div class="nav-vertical">
                                <ul class="nav nav-tabs nav-left" style="height: 83.3px;">
                                    <?php
                                    $counter = 1;
                                    $active = "active";
                                    foreach ($customers_type as $ctype) {
                                        if ($counter == 1) {
                                            $active = "active";
                                        } else {
                                            $active = "";
                                        }
                                    ?>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo $active ?>" id="<?php echo str_replace(" ","-",$ctype->person_type) . "-tab"; ?>" data-toggle="tab" aria-controls="<?php echo str_replace(" ","-",$ctype->person_type) . "-panel"; ?>" href="#<?php echo str_replace(" ","-",$ctype->person_type) . "-panel"; ?>" aria-expanded="true">
                                                <?php echo strtoupper($ctype->person_type); ?></a>
                                        </li>
                                    <?php $counter++;
                                    } ?>
                                </ul>
                                <div class="tab-content px-1">
                                    <?php
                                    $counter = 1;
                                    $active = "active";
                                    foreach ($customers_type as $ctype) {
                                        if ($counter == 1) {
                                            $active = "active";
                                        } else {
                                            $active = "";
                                        }
                                    ?>
                                        <div role="tabpanel" class="tab-pane <?php echo $active ?>" id="<?php echo str_replace(" ","-",$ctype->person_type) . "-panel"; ?>" aria-expanded="true" aria-labelledby="<?php echo str_replace(" ","-",$ctype->person_type) . "-tab"; ?>">
                                            <div class="table-responsive">
                                                <table class="material-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>File Type</th>
                                                            <th>File</th>
                                                            <th>Downlaod</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if ($ctype->person_type == "Daily Customer") {
                                                            $filesD_data = $fileManager->getDilyCustomersFileByType($user_data->company_id, $ctype->person_type);
                                                            $filesD = $filesD_data->fetchAll(PDO::FETCH_OBJ);
                                                            if ($filesD_data->rowCount() > 0) {
                                                                foreach ($filesD as $file) {
                                                                    echo "<tr>
                                                                        <td>$file->fname $file->lname</td>
                                                                        <td>$file->type</td>
                                                                        <td>$file->attachment_name</td>
                                                                        <td><a class='hover' href='uploadedfiles/dailycustomer/$file->attachment_name'  download><span class='las la-download text-blue la-2x'></span><span class='las la-spinner text-blue spinner la-2x d-none'></span></a></td>
                                                                    </tr>";
                                                                }
                                                            }
                                                        } else {
                                                            $files_data = $fileManager->getCustomersFileByType($user_data->company_id, $ctype->person_type);
                                                            $files = $files_data->fetchAll(PDO::FETCH_OBJ);
                                                            if ($files_data->rowCount() > 0) {
                                                                foreach ($files as $file) {
                                                                    echo "<tr>
                                                                        <td>$file->fname $file->lname</td>
                                                                        <td>$file->attachment_type</td>
                                                                        <td>$file->attachment_name</td>
                                                                        <td><a class='hover' href='uploadedfiles/customerattachment/$file->attachment_name' download><span class='las la-download text-blue la-2x'></span><span class='las la-spinner text-blue spinner la-2x d-none'></span></a></td>
                                                                    </tr>";
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    <?php $counter++;
                                    } ?>

                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include("./master/footer.php");
?>