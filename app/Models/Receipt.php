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
        $query = "INSERT INTO general_leadger(leadger_id,recievable_id,payable_id,currency_id,remarks,company_financial_term_id,reg_date,currency_rate,approved,createby,updatedby,op_type,company_id) 
        VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params);
        return $result;
    }

    public function getReceiptLeadger($companyID, $term_id)
    {
        $query = "SELECT * FROM general_leadger 
        LEFT JOIN account_money ON general_leadger.leadger_id = account_money.leadger_ID 
        LEFT JOIN company_currency ON general_leadger.currency_id = company_currency.company_currency_id 
        WHERE general_leadger.company_id = ? AND general_leadger.op_type = ? AND general_leadger.cleared=? 
        AND general_leadger.company_financial_term_id = ? AND account_money.ammount_type = ? 
        AND general_leadger.approved = ? AND deleted = ?";
        $result = $this->conn->Query($query, [$companyID, "Receipt", 0, $term_id, "Crediet", 1, 0]);
        return $result;
    }

    public function getReceiptAccount($leadger_id)
    {
        $query = "SELECT * FROM account_money INNER JOIN chartofaccount ON account_money.account_id = chartofaccount.chartofaccount_id 
                 WHERE account_money.leadger_ID = ? ";
        $result = $this->conn->Query($query, [$leadger_id]);
        return $result;
    }

}
