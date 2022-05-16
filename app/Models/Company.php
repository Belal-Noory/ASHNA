<?php

class Company
{
    // Database class
    private $conn;

    public function __construct()
    {
        $this->conn = new Connection();
    }

    // Add new company
    public function addCompany($params)
    {
        $query = "INSERT INTO company(company_name,legal_name,company_type,license_number,TIN,register_number,country,province,district,postal_code,phone,fax,addres,website,email,maincurrency,fiscal_year_start,fiscal_year_end,fiscal_year_title,reg_date) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, $returnLastID = true);
        return $result;
    }

    // Add company multi currency
    public function addCompanyCurrency($params)
    {
        $query = "INSERT INTO company_currency(companyID,currency) VALUES(?,?)";
        $result = $this->conn->Query($query, $params);
        return $result;
    }

    // get all companies
    public function getAllCompanies()
    {
        $query = "SELECT * FROM company";
        $result = $this->conn->Query($query);
        return $result;
    }

    // get Company by ID
    public function getCompanyByID($ID)
    {
        $query = "SELECT * FROM company WHERE company_id = ?";
        $result = $this->conn->Query($query, [$ID]);
        return $result;
    }

    // get All Active Companies
    public function getAllActiveCompanies()
    {
        $query = "SELECT * FROM company WHERE disable = ?";
        $result = $this->conn->Query($query, [0]);
        return $result;
    }

    // get All inactive Companies
    public function getAllInctiveCompanies()
    {
        $query = "SELECT * FROM company WHERE disable = ?";
        $result = $this->conn->Query($query, [1]);
        return $result;
    }

    // Add company users for login in business panel
    public function addCompanyUser($params)
    {
        $query = "INSERT INTO company_users(company_id,username,password,fname,lname) VALUES(?,?,?,?,?)";
        $result = $this->conn->Query($query, $params);
        return $result;
    }

    // get all company users
    public function getCompanyUsers()
    {
        $query = "SELECT * FROM company_users";
        $result = $this->conn->Query($query);
        return $result;
    }

    // get user by ID
    public function getCompanyUserByID($ID)
    {
        $query = "SELECT * FROM company_users WHERE user_id = ?";
        $result = $this->conn->Query($query, [$ID]);
        return $result;
    }

    // get login users
    public function getCompanyOnlineUser()
    {
        $query = "SELECT * FROM company_users WHERE is_online = ?";
        $result = $this->conn->Query($query, [1]);
        return $result;
    }
}
