<?php
include("../init.php");

$page_title = "تحارت ها";

$menu = array(
    array("name" => "صفحه عمومی", "url" => "index.php", "icon" => "la-chart-area", "status" => "", "child" => array()),
    array("name" => "تجارت ", "url" => "", "icon" => "la-business-time", "status" => "", "child" => array(array("name" => "تجارت جدید", "url" => "business.php"), array("name" => "لیست تجارت ها", "url" => "businessList.php"))),
    array("name" => "اشخاص ", "url" => "", "icon" => "la-users", "status" => "active", "child" => array(array("name" => "شخص جدید", "url" => "newuser.php"), array("name" => "لیست اشخاص", "url" => "users.php")))
);

$page_title = "تجارت جدید";

include("./master/header.php");

$company = new Company();
$all_company = $company->getAllCompanies();
?>



<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

<?php include("./master/footer.php"); ?>