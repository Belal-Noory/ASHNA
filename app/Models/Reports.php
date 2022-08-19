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

    // Login Reports
    public function getLoginReports($company)
    {
        $query = "SELECT * FROM login_log 
        INNER JOIN company_users ON login_log.user = company_users.user_id 
        INNER JOIN customers ON company_users.customer_id = customers.customer_id 
        WHERE company_users.company_id = ? ";
        $result = $this->conn->Query($query, [$company]);
        return $result;
    }

    // Activity Reports
    public function getActivityReports($company)
    {
        $query = "SELECT customers.fname,customers.lname,tble,user_action,CAST(action_date AS DATE) AS reg_date,logs_data.details  FROM logs_data 
        INNER JOIN customers ON logs_data.user_id = customers.customer_id 
        WHERE customers.company_id = ? ";
        $result = $this->conn->Query($query, [$company]);
        return $result;
    }
}
