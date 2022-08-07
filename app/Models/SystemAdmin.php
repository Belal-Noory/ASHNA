<?php

class SystemAdmin
{
    // Database class
    private $conn;

    public function __construct()
    {
        $this->conn = new Connection();
    }

    // Login 
    public function login($params)
    {
        if (!is_null($params)) {
            $query = "SELECT * FROM sys_admin WHERE email = ? AND pass = ?";
            $res = $this->conn->Query($query, $params);
            return $res;
        }
    }

    // Add New Admin
    public function addAdmin($params)
    {
        $query = "INSERT INTO sys_admin(email,pass,fname,lname) VALUES(?,?,?,?)";
        $result = $this->conn->Query($query, $params);
        return $result;
    }

    // Get System model
    public function getSystemModelsParent()
    {
        $query = "SELECT * FROM system_models WHERE parentID = ?";
        $result = $this->conn->Query($query, [0]);
        return $result;
    }

    // Get System model childern
    public function getSystemModelschild($parentID)
    {
        $query = "SELECT * FROM system_models WHERE parentID = ?";
        $result = $this->conn->Query($query, [$parentID]);
        return $result;
    }

    // Get Company model
    public function getCompanyModel($companyID)
    {
        $query = "SELECT * FROM system_models WHERE system_models.id NOT IN (SELECT modelID FROM company_model WHERE companyID = ?) AND system_models.parentID = 0";
        $result = $this->conn->Query($query, [$companyID]);
        return $result;
    }

    // Get System catagory
    public function getCatagoryByName($name)
    {
        $query = "SELECT account_catagory_id FROM account_catagory WHERE catagory = ?";
        $result = $this->conn->Query($query, [$name]);
        return $result;
    }

    // Add website message
    public function addWebsiteMsg($params)
    {
        $query = "INSERT INTO website_message(title,details,time) VALUES(?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    // get website message
    public function getWebsiteMsg()
    {
        $query = "SELECT * FROM website_message ORDER BY msg_id DESC";
        $result = $this->conn->Query($query);
        return $result;
    }

    // Add website FAQ
    public function addWebsiteFAQ($params)
    {
        $query = "INSERT INTO website_faq(question,answer,time) VALUES(?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    // get website FAQ
    public function getWebsiteFAQs()
    {
        $query = "SELECT * FROM website_faq ORDER BY id DESC";
        $result = $this->conn->Query($query);
        return $result;
    }

    // get pending transactions
    public function getPendingTransactions($companyID, $term_id)
    {
        $query = "SELECT * FROM general_leadger 
        LEFT JOIN account_money ON general_leadger.leadger_id = account_money.leadger_ID 
        LEFT JOIN company_currency ON general_leadger.currency_id = company_currency.company_currency_id 
        WHERE general_leadger.company_id = ? AND general_leadger.company_financial_term_id = ? AND general_leadger.approved = ?";
        $result = $this->conn->Query($query, [$companyID, $term_id, 0]);
        return $result;
    }
}
