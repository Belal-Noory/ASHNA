<?php
$Active_nav_name = array("parent" => "Reports", "child" => "All Reports");
$page_title = "Debitors/Creditors Report";
include("./master/header.php");
// Logged in user info 
$report = new Reports();
$bank = new Banks();
$bussiness = new Bussiness();

$allCatagories_data = $report->getReportsCatagory($user_data->company_id);
$allCatagories = $allCatagories_data->fetchAll(PDO::FETCH_OBJ);

$company_curreny_data = $company->GetCompanyCurrency($user_data->company_id);
$company_curreny = $company_curreny_data->fetchAll(PDO::FETCH_OBJ);
$mainCurrency = "";
foreach ($company_curreny as $currency) {
    if ($currency->mainCurrency) {
        $mainCurrency = $currency->currency;
    }
}

// Get all Customers of this company
$allCustomers_data = $bussiness->getCompanyCustomers($user_data->company_id,"");
$allCustomers = $allCustomers_data->fetchAll(PDO::FETCH_OBJ);
?>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <h4>Debitors/Creditors Report</h4>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-header">
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table material-table" id="customersTable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <?php
                                        foreach ($allcurrency as $cur) {
                                            echo "<th>$cur->currency</th>";
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <?php
                                        foreach ($allcurrency as $cur) {
                                            echo "<th>$cur->currency</th>";
                                        }
                                        ?>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                        foreach ($allCustomers as $cus) {
                                            $row = "<tr>";
                                            $row .= "<td>$cus->fname $cus->lname</td>";
                                            foreach ($allcurrency as $cur) {
                                                $transactions_data = $bank->getCustomerTransactionByCurrency($cus->chartofaccount_id,$cur->company_currency_id);
                                                $transactions = $transactions_data->fetch(PDO::FETCH_OBJ);
                                                $res = $transactions->Debet-$transactions->Credit;
                                                $color = "black";
                                                if($res > 0)
                                                {
                                                    $color = "info";
                                                }else if($res < 0)
                                                {
                                                    $color = "danger";
                                                }
                                                else{
                                                    $color = "black";
                                                }
                                                $row .= "<td class='text-$color'>$res</td>";
                                            }
                                            $row .= "</tr>";
                                            echo $row;
                                        }
                                    ?>
                                </tbody>
                            </table>
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