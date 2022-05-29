<?php

class Banks
{
    // Database class
    private $conn;

    public function __construct()
    {
        $this->conn = new Connection();
    }

    public function addBank($params)
    {
        $query = "INSERT INTO chartofaccount(account_catagory,account_name,account_number,initial_ammount,account_type,currency_id,reg_date,company_id,createby,approve,note,account_kind) 
        VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    public function addSaif($params)
    {
        $query = "INSERT INTO chartofaccount(account_catagory,account_name,currency_id,reg_date,company_id,createby,approve,note,account_kind) 
        VALUES(?,?,?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    public function getBanks($companyID)
    {
        $query = "SELECT * FROM chartofaccount INNER JOIN company_currency ON chartofaccount.currency_id = company_currency.company_currency_id WHERE company_id = ? AND account_kind = ?";
        $result = $this->conn->Query($query, [$companyID, "Bank"]);
        return $result;
    }

    public function getSaifs($companyID)
    {
        $query = "SELECT * FROM chartofaccount INNER JOIN company_currency ON chartofaccount.currency_id = company_currency.company_currency_id WHERE company_id = ? AND account_kind = ?";
        $result = $this->conn->Query($query, [$companyID, "Saif"]);
        return $result;
    }

    public function getBank_Saif($bankID)
    {
        $query = "SELECT * FROM chartofaccount WHERE chartofaccount_id = ?";
        $result = $this->conn->Query($query, [$bankID]);
        return $result;
    }

    public function addTransferLeadger($params)
    {
        $query = "INSERT INTO general_leadger(recievable_id,payable_id,currency_id,remarks,company_financial_term_id,reg_date,currency_rate,approved,createby,updatedby,op_type,company_id) 
        VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    public function addTransferMoney($params)
    {
        $query = "INSERT INTO account_money(account_id,leadger_ID,amount,ammount_type,company_id) 
        VALUES(?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    public function getTransfersLeadger($companyID)
    {
        $query = "SELECT * FROM general_leadger WHERE company_id = ?";
        $result = $this->conn->Query($query, [$companyID]);
        return $result;
    }

    public function getTransfersMoney($companyID, $leadgerID)
    {
        $query = "SELECT * FROM account_money WHERE company_id = ? AND leadger_ID = ?";
        $result = $this->conn->Query($query, [$companyID, $leadgerID]);
        return $result;
    }
}
