<?php

class Payments
{
    // Database class
    private $conn;

    public function __construct()
    {
        $this->conn = new Connection();
    }

    public function addPaymentLeadger($params)
    {
        $query = "INSERT INTO general_leadger(recievable_id,payable_id,currency_id,remarks,company_financial_term_id,reg_date,currency_rate,approved,createby,updatedby,op_type,company_id) 
        VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    public function getPaymentLeadger($companyID)
    {
        $query = "SELECT * FROM general_leadger INNER JOIN account_money ON general_leadger.leadger_id = account_money.leadger_ID 
                INNER JOIN company_currency ON general_leadger.currency_id = company_currency.company_currency_id
                WHERE account_money.ammount_type = ? AND general_leadger.company_id = ? AND general_leadger.op_type = ? AND general_leadger.cleared=?";
        $result = $this->conn->Query($query, ["Debet", $companyID, "Payment", 0]);
        return $result;
    }

    public function getPaymentAccount($leadger_id)
    {
        $query = "SELECT * FROM account_money INNER JOIN chartofaccount ON account_money.account_id = chartofaccount.chartofaccount_id 
                 WHERE account_money.leadger_ID = ? ";
        $result = $this->conn->Query($query, [$leadger_id]);
        return $result;
    }
}
