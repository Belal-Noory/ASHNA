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

    // Add In Transference
    public function addInTransfer($params)
    {
        $query = "INSERT INTO company_money_transfer(company_user_sender,company_user_sender_commission,company_user_receiver,company_user_receiver_commission,money_sender,money_receiver,amount,currency,reg_date,approve,paid,transfer_code,voucher_code,details,locked,transfer_type,company_id,leadger_id) 
        VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    // Get Out Transference pending
    public function getPendingOutTransfer($company_id)
    {
        $query = "SELECT * FROM company_money_transfer 
        INNER JOIN company_currency ON company_money_transfer.currency = company_currency.company_currency_id 
        WHERE company_money_transfer.company_id = ? AND company_money_transfer.paid = ? AND company_money_transfer.transfer_type = ?";
        $result = $this->conn->Query($query, [$company_id, 0, "out"]);
        return $result;
    }

    // Get Out Transference Paid
    public function getPaidOutTransfer($company_id)
    {
        $query = "SELECT * FROM company_money_transfer INNER JOIN company_currency ON company_money_transfer.currency = company_currency.company_currency_id WHERE company_money_transfer.company_id = ? AND company_money_transfer.paid = ? AND company_money_transfer.transfer_type = ?";
        $result = $this->conn->Query($query, [$company_id, 1, "out"]);
        return $result;
    }

    // Get All Out Transference
    public function getAllOutTransfer($company_id)
    {
        $query = "SELECT * FROM company_money_transfer 
        INNER JOIN company_currency ON company_money_transfer.currency = company_currency.company_currency_id 
        WHERE company_money_transfer.company_id = ? AND company_money_transfer.transfer_type = ?";
        $result = $this->conn->Query($query, [$company_id,"out"]);
        return $result;
    }

    // Get one Out Transference 
    public function getOutTransferBySaraf($SID, $company_id)
    {
        $query = "SELECT * FROM company_money_transfer 
        WHERE company_id = ? AND company_user_receiver = ? ORDER BY company_money_transfer_id DESC LIMIT 1";
        $result = $this->conn->Query($query, [$company_id,$SID]);
        return $result;
    }

    // Get In Transference Pending
    public function getPendingInTransfer($company_id)
    {
        $query = "SELECT * FROM company_money_transfer INNER JOIN company_currency ON company_money_transfer.currency = company_currency.company_currency_id WHERE company_money_transfer.company_id = ? AND company_money_transfer.paid = ? AND company_money_transfer.transfer_type = ?";
        $result = $this->conn->Query($query, [$company_id, 0, "in"]);
        return $result;
    }

    // Get In Transference Paid
    public function getPaidInTransfer($company_id)
    {
        $query = "SELECT * FROM company_money_transfer INNER JOIN company_currency ON company_money_transfer.currency = company_currency.company_currency_id WHERE company_money_transfer.company_id = ? AND company_money_transfer.paid = ? AND company_money_transfer.transfer_type = ?";
        $result = $this->conn->Query($query, [$company_id, 1, "in"]);
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

    // Add Transfer Out Leadger
    public function addTransferInLeadger($params)
    {
        $query = "INSERT INTO general_leadger(payable_id,recievable_id,company_financial_term_id,reg_date,remarks,approved,createby,updatedby,op_type,company_id,currency_id) 
        VALUES(?,?,?,?,?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    // Add Transfer Out Money
    public function addTransferOutMoney($params)
    {
        $query = "INSERT INTO account_money(account_id,leadger_ID,amount,ammount_type,company_id,detials,temp) 
        VALUES(?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    // Approve tansfered account money
    public function approveTransferMoneyByLeadger($leadger)
    {
        $query = "UPDATE account_money SET temp = ? WHERE leadger_ID = ?";
        $result = $this->conn->Query($query, [0, $leadger]);
        return $result;
    }

    // Get Transfer all details By Leadger
    public function getTransferByLeadger($leadgerID, $type)
    {
        $query = "SELECT * FROM general_leadger 
        INNER JOIN company_money_transfer ON company_money_transfer.leadger_id = general_leadger.leadger_id 
        INNER JOIN account_money ON general_leadger.leadger_id = account_money.leadger_ID 
        INNER JOIN company_currency ON general_leadger.currency_id = company_currency.company_currency_id 
        WHERE general_leadger.leadger_id = ? AND account_money.ammount_type = ?";
        $result = $this->conn->Query($query, [$leadgerID,"Debet"]);
        return $result;
    }

    // Get Transfer Daily customer detials
    public function getDailyCusDetails($id)
    {
        $query = "SELECT * FROM customers WHERE customer_id = ?";
        $result = $this->conn->Query($query, [$id]);
        return $result;
    }

    // delete account money by leadger
    public function deleteAccoumtMoneyByLeadger($leader)
    {
        $query = "DELETE FROM account_money WHERE leadger_ID = ?";
        $result = $this->conn->Query($query, [$leader]);
        return $result;
    }

    // delete transfer by leadger
    public function deleteTransferByLeadger($leader)
    {
        $query = "DELETE FROM company_money_transfer WHERE leadger_id = ?";
        $result = $this->conn->Query($query, [$leader]);
        return $result;
    }

    // Approve transfer by leadger
    public function approveTransfer($leader)
    {
        $query = "UPDATE company_money_transfer SET paid = ? WHERE leadger_id = ?";
        $result = $this->conn->Query($query, [1, $leader]);
        return $result;
    }

    // delete transfer leadger
    public function deleteTransferLeadger($leader)
    {
        $query = "DELETE FROM general_leadger WHERE leadger_id = ?";
        $result = $this->conn->Query($query, [$leader]);
        return $result;
    }
}
