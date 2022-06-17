<?php

class Reports
{
    // Database class
    private $conn;

    public function __construct()
    {
        $this->conn = new Connection();
    }

    // Get Report Catagory
    public function getReportsCatagory($companyID)
    {
        $query = "SELECT DISTINCT * FROM chartofaccount WHERE company_id = ?";
        $result = $this->conn->Query($query, [$companyID]);
        return $result;
    }

    // Get Leagers based on Reports catagory
    public function getReportsBasedOnTransaction($companyID, $ID)
    {
        $query = "SELECT * FROM general_leadger LEFT JOIN account_money ON general_leadger.leadger_id = account_money.leadger_ID 
                LEFT JOIN company_currency ON general_leadger.currency_id = company_currency.company_currency_id
                WHERE account_money.ammount_type = ? AND general_leadger.company_id = ? AND (general_leadger.recievable_id = ? OR general_leadger.payable_id = ?)";
        $result = $this->conn->Query($query, ["Debet", $companyID, $ID,$ID]);
        return $result;
    }

}
