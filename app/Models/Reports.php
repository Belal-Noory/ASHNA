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

    // Banks Reports
    public function getBanksReports($company)
    {
        $query = "SELECT * FROM chartofaccount 
        INNER JOIN account_money ON account_money.account_id = chartofaccount.chartofaccount_id 
        WHERE chartofaccount.account_kind = ? AND chartofaccount.company_id = ? AND chartofaccount.useradded = ?";
        $result = $this->conn->Query($query, ["Bank", $company, 1]);
        return $result;
    }

    // Cash Register Reports
    public function getCashRegisterReports($company)
    {
        $query = "SELECT * FROM chartofaccount 
        INNER JOIN account_money ON account_money.account_id = chartofaccount.chartofaccount_id 
        WHERE chartofaccount.account_kind = ? AND chartofaccount.company_id = ? AND chartofaccount.useradded = ?";
        $result = $this->conn->Query($query, ["Cash Register", $company, 1]);
        return $result;
    }


    // Cash Register Reports
    public function getInTransfersReports($company)
    {
        $query = "SELECT CONCAT(cus.fname, cus.lname) as usersender_name,
         CONCAT(cur.fname, cur.lname) as userreceiver_name, 
         CONCAT(ms.fname, ms.lname) as moneysender_name, 
         CONCAT(mr.fname, mr.lname) as moneyreceiver_name, 
         cc.currency as currency, t.approve as approved, t.paid as paid, t.transfer_code as tcode, t.details as details, t.locked as locked, 
         t.leadger_id as leadger_id, t.amount as amount, t.company_user_sender_commission as sender_com, t.company_user_receiver_commission as receiver_com, t.company_money_transfer_id as TID, 
         t.reg_date as reg_date, t.company_user_sender as sender_id, t.company_user_receiver as receiver_id 
         FROM company_money_transfer t 
        LEFT JOIN company_currency cc ON t.currency = cc.company_currency_id 
        LEFT JOIN customers cus ON t.company_user_sender = cus.customer_id 
        LEFT JOIN customers cur ON t.company_user_receiver = cur.customer_id 
        LEFT JOIN customers ms ON t.money_sender = ms.customer_id 
        LEFT JOIN customers mr ON t.money_receiver = mr.customer_id 
        WHERE t.company_id = ? AND t.transfer_type = ?";
        $result = $this->conn->Query($query, [$company, "in"]);
        return $result;
    }

    // Cash Register Reports
    public function getOutTransfersReports($company)
    {
        $query = "SELECT CONCAT(cus.fname, cus.lname) as usersender_name,
         CONCAT(cur.fname, cur.lname) as userreceiver_name, 
         CONCAT(ms.fname, ms.lname) as moneysender_name, 
         CONCAT(mr.fname, mr.lname) as moneyreceiver_name, 
         cc.currency as currency, t.approve as approved, t.paid as paid, t.transfer_code as tcode, t.details as details, t.locked as locked, 
         t.leadger_id as leadger_id, t.amount as amount, t.company_user_sender_commission as sender_com, t.company_user_receiver_commission as receiver_com, t.company_money_transfer_id as TID, 
         t.reg_date as reg_date, t.company_user_sender as sender_id, t.company_user_receiver as receiver_id 
         FROM company_money_transfer t 
        LEFT JOIN company_currency cc ON t.currency = cc.company_currency_id 
        LEFT JOIN customers cus ON t.company_user_sender = cus.customer_id 
        LEFT JOIN customers cur ON t.company_user_receiver = cur.customer_id 
        LEFT JOIN customers ms ON t.money_sender = ms.customer_id 
        LEFT JOIN customers mr ON t.money_receiver = mr.customer_id 
        WHERE t.company_id = ? AND t.transfer_type = ?";
        $result = $this->conn->Query($query, [$company, "out"]);
        return $result;
    }

    // Exchange Transaction Reports
    public function getExchangeTransactionReports($company)
    {
        $query = "SELECT t.leadger_id as leadger_id, ac.account_money_id as EID, t.reg_date as reg_date,
         t.remarks as details, cf.currency as from_currency, ct.currency as currency_to, acf.account_name as acfrom, act.account_name as act, ac.amount as amount, 
         t.currency_rate as rate
          FROM general_leadger t 
          LEFT JOIN account_money ac ON ac.leadger_ID = t.leadger_id 
          LEFT JOIN chartofaccount acf ON acf.chartofaccount_id = t.recievable_id 
          LEFT JOIN chartofaccount act ON act.chartofaccount_id = t.payable_id  
          LEFT JOIN company_currency cf ON cf.company_currency_id = t.currency_id 
          LEFT JOIN company_currency ct ON ct.company_currency_id = t.rcode  
         WHERE t.op_type = ? AND t.company_id = ?";
        $result = $this->conn->Query($query, ["Bank Exchange", $company]);
        return $result;
    }
}
