<?php

class Receipt
{
    // Database class
    private $conn;

    public function __construct()
    {
        $this->conn = new Connection();
    }

    public function addReceiptLeadger($params)
    {
        $query = "INSERT INTO general_leadger(recievable_id,payable_id,currency_id,remarks,company_financial_term_id,reg_date,currency_rate,approved,createby,updatedby,op_type,company_id) 
        VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    
}
