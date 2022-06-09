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
        $query = "INSERT INTO chartofaccount(account_catagory,account_name,account_number,initial_ammount,account_type,currency,reg_date,company_id,createby,approve,note,account_kind) 
        VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    public function addSaif($params)
    {
        $query = "INSERT INTO chartofaccount(account_catagory,account_name,currency,reg_date,company_id,createby,approve,note,account_kind) 
        VALUES(?,?,?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    public function addCustomerAccount($params)
    {
        $query = "INSERT INTO chartofaccount(account_catagory,account_name,account_number,currency,reg_date,company_id,createby,approve,note,account_kind,cutomer_id) 
        VALUES(?,?,?,?,?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    // Get customer balance
    public function getCustomerBalance($customer_account_id)
    {
        $query = "SELECT * FROM general_leadger INNER JOIN account_money ON general_leadger.leadger_id = account_money.leadger_ID
                  INNER JOIN company_currency ON general_leadger.currency_id = company_currency.company_currency_id
                  WHERE general_leadger.recievable_id = ? OR general_leadger.payable_id = ? AND account_money.temp = ?";
        $result = $this->conn->Query($query, [$customer_account_id, $customer_account_id, 0]);
        return $result;
    }

    public function getBanks($companyID)
    {
        $query = "SELECT * FROM chartofaccount WHERE company_id = ? AND account_kind = ?";
        $result = $this->conn->Query($query, [$companyID, "Bank"]);
        return $result;
    }

    public function getBankByID($bankID)
    {
        $query = "SELECT * FROM chartofaccount WHERE chartofaccount_id = ?";
        $result = $this->conn->Query($query, [$bankID]);
        return $result;
    }

    public function getCustomerByBank($bankID)
    {
        $query = "SELECT * FROM chartofaccount INNER JOIN customers ON chartofaccount.cutomer_id = customers.customer_id WHERE chartofaccount_id = ?";
        $result = $this->conn->Query($query, [$bankID]);
        return $result;
    }

    public function getSaifs($companyID)
    {
        $query = "SELECT * FROM chartofaccount WHERE company_id = ? AND account_kind = ?";
        $result = $this->conn->Query($query, [$companyID, "Saif"]);
        return $result;
    }

    public function getCustomers($companyID)
    {
        $query = "SELECT * FROM chartofaccount WHERE company_id = ? AND account_kind = ?";
        $result = $this->conn->Query($query, [$companyID, "Customer"]);
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
        $query = "INSERT INTO account_money(account_id,leadger_ID,amount,ammount_type,company_id,detials) 
        VALUES(?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    public function getTransfersLeadger($companyID)
    {
        $query = "SELECT * FROM general_leadger WHERE company_id = ? AND op_type = ?";
        $result = $this->conn->Query($query, [$companyID, "Bank Transfer"]);
        return $result;
    }

    public function getTransfersMoney($companyID, $leadgerID)
    {
        $query = "SELECT * FROM account_money WHERE company_id = ? AND leadger_ID = ?";
        $result = $this->conn->Query($query, [$companyID, $leadgerID]);
        return $result;
    }

    // Add Exchange conversion
    public function addExchangeConversion($params)
    {
        $query = "INSERT INTO company_currency_conversion(currency_from,currency_to,rate,reg_date,approve,createby,companyID) 
        VALUES(?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    // Get Exchange conversion
    public function getExchangeConversion($from, $to, $companyID)
    {
        $query = "SELECT * FROM company_currency_conversion WHERE ((currency_from = ? AND currency_to  = ?) OR (currency_from = ? AND currency_to  = ?)) AND companyID = ? ORDER BY reg_date DESC LIMIT 1";
        $result = $this->conn->Query($query, [$from, $to, $to, $from, $companyID]);
        return $result;
    }

    // Get All Accounts Catagory 
    public function getAllAccountsCatagory()
    {
        $query = "SELECT * FROM account_catagory";
        $result = $this->conn->Query($query);
        return $result;
    }

    // Add Account Catagory
    public function addCatagory($name, $parentID, $company)
    {
        $query = "INSERT INTO account_catagory(catagory,parentID,company_id) VALUES(?,?,?)";
        $result = $this->conn->Query($query, [$name, $parentID, $company], true);
        return $result;
    }

    // Add Chart of account
    public function addCatagoryAccount($params)
    {
        $query = "INSERT INTO chartofaccount(account_catagory,account_name,account_type,currency,reg_date,company_id,createby,account_kind) 
        VALUES(?,?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }
}
