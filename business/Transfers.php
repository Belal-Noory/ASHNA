<?php
$Active_nav_name = array("parent" => "Banking", "child" => "New Saif");
$page_title = "Transfers";
include("./master/header.php");

// Objects
$bank = new Banks();
$company = new Company();

?>


<?php
include("./master/footer.php");
?>