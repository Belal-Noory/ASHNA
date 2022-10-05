<?php 
session_start();
require "../../init.php";
include('../../vendor/autoload.php');
use Coderatio\SimpleBackup\SimpleBackup;

    if (isset($_SESSION["bussiness_user"])) {
        $loged_user = json_decode($_SESSION["bussiness_user"]);
    }

    $company = new Company();
    $company_FT_data = $company->getCompanyActiveFT($loged_user->company_id);
    $company_ft = $company_FT_data->fetch(PDO::FETCH_OBJ);
    $company_financial_term_id = 0;
        if (isset($company_ft->term_id)) {
            $company_financial_term_id = $company_ft->term_id;
        }

    $tables = [
        "'general_leadger' => 'company_financial_term_id'='$company_financial_term_id'"
      ];
    $simpleBackup = SimpleBackup::setDatabase(['ASHNA', 'root', '', 'localhost'])
      ->includeOnly(['general_leadger'])
      ->setTableConditions($tables)
      ->downloadAfterExport();
