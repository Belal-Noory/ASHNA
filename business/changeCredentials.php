<?php
$Active_nav_name = array("parent" => "Settings", "child" => "Change Credentials");
$page_title = "Change Credentials";
include("./master/header.php");
// Logged in user info 
$bank = new Banks();
$banks = $bank->getBanks($user_data->company_id);
$banks_data = $banks->fetchAll(PDO::FETCH_OBJ);

?>

<?php
include("./master/footer.php");
?>