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


    // Add company multi currency
    public function addCompanyCurrency($params)
    {
        $query = "INSERT INTO company_currency(companyID,currency) VALUES(?,?)";
        $result = $this->conn->Query($query, $params);
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


    // Add Company contract
    public function addCompanyContract($params)
    {
        $query = "INSERT INTO company_contract(companyID,contract_start,contract_end) VALUES(?,?,?)";
        $result = $this->conn->Query($query, $params);
        return $result;
    }

    // Add Company model
    public function addCompanyModel($params)
    {
        $query = "INSERT INTO company_model(companyID,modelID) VALUES(?,?)";
        $result = $this->conn->Query($query, $params, $returnLastID = true);
        return $result;
    }

    // Remove Company model
    public function deleteCompanyModel($modelID)
    {
        $query = "DELETE FROM company_model WHERE id = ?";
        $result = $this->conn->Query($query, [$modelID]);
        return $result->rowCount();
    }

    // Get Company models : models that are not allowed to be used by company
    public function getCompanyDenyModel($companyID)
    {
        $query = "SELECT company_model.id, company_model.companyID, system_models.name_dari FROM company_model INNER JOIN system_models ON company_model.modelID = system_models.id WHERE company_model.companyID = ?";
        $result = $this->conn->Query($query, [$companyID]);
        return $result;
    }

    // Get Company Main models : models that are allowed to be used by company
    public function getCompanyMainAllowedModel($companyID)
    {
        $query = "SELECT * FROM system_models WHERE system_models.id NOT IN(SELECT modelID FROM company_model WHERE company_model.companyID = ?) AND system_models.parentID = ?";
        $result = $this->conn->Query($query, [$companyID, 0]);
        return $result;
    }

    // Get Company Sub models : models that are allowed to be used by company
    public function getCompanySubAllowedModel($parentID)
    {
        $query = "SELECT * FROM system_models WHERE system_models.parentID = ?";
        $result = $this->conn->Query($query, [$parentID]);
        return $result;
    }

    // get login users
    public function getCompanyOnlineUser()
    {
        $query = "SELECT * FROM company_users WHERE is_online = ?";
        $result = $this->conn->Query($query, [1]);
        return $result;
    }

    // Get Company Login
    public function login($username, $password)
    {
        $query = "SELECT * FROM company_users INNER JOIN company ON company_users.company_id = company.company_id WHERE company_users.username = ? AND company_users.password = ?";
        $result = $this->conn->Query($query, [$username, $password]);
        return $result;
    }

    // Set Company user as online
    public function makeOnline($userID, $status){
        $query = "UPDATE company_users SET is_online = ? WHERE user_id = ?";
        $result = $this->conn->Query($query, [$status,$userID]);
        return $result;
    }

    // Get Company Login logs
    public function login_logs($user, $user_action)
    {
        $query = "INSERT INTO login_log(user,user_action,action_date) values(?,?,?)";
        $result = $this->conn->Query($query, [$user, $user_action, time()]);
        return $result;
    }
}
