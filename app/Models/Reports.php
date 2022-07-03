<?php

use LDAP\Result;

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
                WHERE general_leadger.company_id = ? AND (general_leadger.recievable_id = ? OR general_leadger.payable_id = ?)";
        $result = $this->conn->Query($query, [$companyID, $ID, $ID]);
        return $result;
    }

    // Get total debets and credits of report catagory
    public function getCatagoriesDebetCredit($account_kind, $companyID)
    {
        $finak_res = array();
        $query = "SELECT DISTINCT * FROM chartofaccount WHERE company_id = ? AND account_kind = ?";
        $result = $this->conn->Query($query, [$companyID, $account_kind]);
        $res1 = $result->fetchAll(PDO::FETCH_OBJ);
        $credit = 0;
        $debet = 0;

        foreach ($res1 as $r1) {
            $query = "SELECT * FROM general_leadger LEFT JOIN account_money ON general_leadger.leadger_id = account_money.leadger_ID 
            LEFT JOIN company_currency ON general_leadger.currency_id = company_currency.company_currency_id
            WHERE general_leadger.recievable_id = ? OR general_leadger.payable_id = ?";
            $res = $this->conn->Query($query, [$r1->chartofaccount_id, $r1->chartofaccount_id]);
            $res2 = $res->fetchAll(PDO::FETCH_OBJ);
            foreach ($res2 as $r2) {
                if ($r2->ammount_type == "Debet") {
                    $debet += $r2->amount;
                } {
                    $credit += $r2->amount;
                }
            }
        }
        $finak_res["debet"] = $debet;
        $finak_res["credit"] = $credit;
        return $finak_res;
    }
}
