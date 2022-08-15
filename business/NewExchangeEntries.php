<?php
$Active_nav_name = array("parent" => "Accounting", "child" => "Exchange Entries");
$page_title = "Exchange Entries";
include("./master/header.php");

$company = new Company();
$revenue = new Expense();

$allcurrency_data = $company->GetCompanyCurrency($user_data->company_id);
$allcurrency = $allcurrency_data->fetchAll(PDO::FETCH_OBJ);


?>


<?php
include("./master/footer.php");
?>