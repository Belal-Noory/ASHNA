<?php

class Transfer
{
    // Database class
    private $conn;

    public function __construct()
    {
        $this->conn = new Connection();
    }

    // Add Out Transference
    public function addOutTransfer($params)
    {
        $query = "INSERT INTO company_money_transfer(company_user_sender,company_user_sender_commission,company_user_receiver,company_user_receiver_commission,money_sender,money_receiver,amount,currency,reg_date,approve,paid,transfer_code,voucher_code,details,locked,transfer_type,company_id,leadger_id) 
        VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    // Get Out Transference
    public function getPendingOutTransfer($company_id)
    {
        $query = "SELECT * FROM company_money_transfer INNER JOIN company_currency ON company_money_transfer.currency = company_currency.company_currency_id WHERE company_money_transfer.company_id = ? AND company_money_transfer.paid = ?";
        $result = $this->conn->Query($query, [$company_id, 0]);
        return $result;
    }

    // Get Out Transference
    public function getPaidOutTransfer($company_id)
    {
        $query = "SELECT * FROM company_money_transfer INNER JOIN company_currency ON company_money_transfer.currency = company_currency.company_currency_id WHERE company_money_transfer.company_id = ? AND company_money_transfer.paid = ?";
        $result = $this->conn->Query($query, [$company_id, 1]);
        return $result;
    }

    // Add Transfer Out Leadger
    public function addTransferOutLeadger($params)
    {
        $query = "INSERT INTO general_leadger(recievable_id,payable_id,company_financial_term_id,reg_date,remarks,approved,createby,updatedby,op_type,company_id,currency_id) 
        VALUES(?,?,?,?,?,?,?,?,?,?,?)";
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

    // Get Transfer all details By Leadger
    public function getTransferByLeadger($leadgerID, $type)
    {
        $query = "SELECT * FROM general_leadger 
        INNER JOIN company_money_transfer ON company_money_transfer.leadger_id = general_leadger.leadger_id
        INNER JOIN account_money ON general_leadger.leadger_id = account_money.leadger_ID
        WHERE general_leadger.leadger_id = ? AND op_type = ?";
        $result = $this->conn->Query($query, [$leadgerID, $type]);
        return $result;
    }

    // Get Transfer Daily customer detials
    public function getDailyCusDetails($id)
    {
        $query = "SELECT * FROM customers WHERE customer_id = ?";
        $result = $this->conn->Query($query, [$id]);
        return $result;
    }
}
