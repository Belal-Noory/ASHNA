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
        $result = $this->conn->Query($query, [$companyID,"Bank"]);
        return $result;
    }

    public function getSaifs($companyID)
    {
        $query = "SELECT * FROM chartofaccount INNER JOIN company_currency ON chartofaccount.currency_id = company_currency.company_currency_id WHERE company_id = ? AND account_kind = ?";
        $result = $this->conn->Query($query, [$companyID,"Saif"]);
        return $result;
    }
}