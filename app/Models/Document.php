<?php

class Document
{
    // Database class
    private $conn;

    public function __construct()
    {
        $this->conn = new Connection();
    }

    public function addDocumentLeadger($params)
    {
        $query = "INSERT INTO general_leadger(recievable_id,payable_id,remarks,currency_id,company_financial_term_id,reg_date,approved,createby,updatedby,op_type,company_id) 
        VALUES(?,?,?,?,?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    public function addDocumentMoney($params)
    {
        $query = "INSERT INTO account_money(account_id,leadger_ID,amount,ammount_type,company_id,detials,temp) 
        VALUES(?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    // Get all account types from chart of account
    public function getAccountTypes($company_id)
    {
        $query = "SELECT DISTINCT op_type FROM general_leadger WHERE company_id = ?";
        $result = $this->conn->Query($query, [$company_id]);
        return $result;
    }

    // Get all Transactions
    public function getAllDocuments($company_id)
    {
        $query = "SELECT * FROM general_leadger LEFT JOIN account_money ON general_leadger.leadger_id = account_money.leadger_ID 
                LEFT JOIN company_currency ON general_leadger.currency_id = company_currency.company_currency_id
                WHERE account_money.ammount_type = ? AND general_leadger.company_id = ? AND general_leadger.cleared=?";
        $result = $this->conn->Query($query, ["Debet", $company_id, 0]);
        return $result;
    }

    // Get Document based on transaction type
    public function getDocumentBasedOnTransaction($companyID, $type)
    {
        $query = "SELECT * FROM general_leadger LEFT JOIN account_money ON general_leadger.leadger_id = account_money.leadger_ID 
                LEFT JOIN company_currency ON general_leadger.currency_id = company_currency.company_currency_id
                WHERE account_money.ammount_type = ? AND general_leadger.company_id = ? AND general_leadger.op_type = ? AND general_leadger.cleared=?";
        $result = $this->conn->Query($query, ["Debet", $companyID, $type, 0]);
        return $result;
    }

    // Get Pending Documents
    public function getAllPendingDocuments($company_id)
    {
        $query = "SELECT * FROM general_leadger 
        INNER JOIN account_money ON general_leadger.leadger_id = account_money.leadger_ID  
        WHERE general_leadger.company_id = ? AND approved = ? AND op_type = ?";
        $result = $this->conn->Query($query, [$company_id, 0, "Document"]);
        return $result;
    }

     // Get Active Documents
     public function getAllActiveDocuments($company_id)
     {
         $query = "SELECT * FROM general_leadger 
         INNER JOIN account_money ON general_leadger.leadger_id = account_money.leadger_ID  
         WHERE general_leadger.company_id = ? AND approved = ? AND op_type = ?";
         $result = $this->conn->Query($query, [$company_id, 1,"Document"]);
         return $result;
     }

     // Approve a Documents
     public function approveDocument($LID)
     {
         $query = "UPDATE general_leadger SET approved = ? WHERE leadger_id = ?";
         $result = $this->conn->Query($query, [1,$LID]);
         return $result->rowCount();
     }
}
