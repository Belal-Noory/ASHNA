<?php

class Transfer
{
    // Database class
    private $conn;

    public function __construct()
    {
        $this->conn = new Connection();
    }

    // Add Customers
    public function addOutTransfer($params)
    {
        $query = "INSERT INTO company_money_transfer(company_user_sender,company_user_sender_commission,company_user_receiver,company_user_receiver_commission,money_sender,money_receiver,amount,currency,reg_date,approve,paid,transfer_code,voucher_code,details,locked,transfer_type,company_id,leadger_id) 
        VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }
    
    // Add Transfer Out Leadger
    public function addTransferOutLeadger($params)
    {
        $query = "INSERT INTO general_leadger(recievable_id,payable_id,company_financial_term_id,reg_date,remarks,approved,createby,updatedby,op_type,company_id) 
        VALUES(?,?,?,?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    // Add Transfer Out Money
    public function addTransferOutMoney($params)
    {
        $query = "INSERT INTO account_money(account_id,leadger_ID,amount,ammount_type,company_id) 
        VALUES(?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }
}
