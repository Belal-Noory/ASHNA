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
        $query = "INSERT INTO company(company_name,legal_name,company_type,license_number,TIN,register_number,country,province,district,postal_code,phone,fax,addres,website,email,reg_date) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    // Add company attachment
    public function addCompanyAttachment($params)
    {
        $query = "INSERT INTO companyattacment(company_id,attachment_name) VALUES(?,?)";
        $result = $this->conn->Query($query, $params);
        return $result;
    }

    // Delete company
    public function deleteCompany($ID)
    {
        $query = "DELETE FROM company WHERE company_id = ?";
        $result = $this->conn->Query($query, [$ID]);
        return $result->rowCount();
    }

    // get all companies with contarcts
    public function getAllCompanies()
    {
        $query = "SELECT * FROM company INNER JOIN company_contract ON company.company_id = company_contract.companyID WHERE company_contract.ended = ?";
        $result = $this->conn->Query($query, [0]);
        return $result;
    }

    // get all companies basic details
    public function getAllCompaniesInfo()
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

    // get All inactive Companies
    public function checkContract($companyID)
    {
        $query = "SELECT * FROM company_contract WHERE companyID = ? AND ended = ?";
        $result = $this->conn->Query($query, [$companyID, 0]);
        return $result;
    }


    // Add company multi currency
    public function addCompanyCurrency($params)
    {
        $query = "INSERT INTO company_currency(companyID,currency,mainCurrency) VALUES(?,?,?)";
        $result = $this->conn->Query($query, $params);
        return $result;
    }

    // Delete company multi currency
    public function deleteCompanyCurrency($ID)
    {
        $query = "DELETE FROM company_currency WHERE companyID = ?";
        $result = $this->conn->Query($query, [$ID]);
        return $result;
    }

    // Get company currency Details
    public function GetCompanyCurrencyDetails($company, $currency)
    {
        $query = "SELECT * FROM company_currency WHERE companyID = ? AND company_currency_id = ?";
        $result = $this->conn->Query($query, [$company, $currency]);
        return $result;
    }

    // Get currency Details
    public function GetCurrencyDetails($currencyID)
    {
        $query = "SELECT * FROM company_currency WHERE company_currency_id = ?";
        $result = $this->conn->Query($query, [$currencyID]);
        return $result;
    }

    public function GetCurrencyByName($currencyID, $company)
    {
        $query = "SELECT * FROM company_currency WHERE currency = ? AND companyID = ?";
        $result = $this->conn->Query($query, [$currencyID, $company]);
        return json_encode($result->fetch(PDO::FETCH_OBJ));
    }

    // Get company currency
    public function GetCompanyCurrency($company)
    {
        $query = "SELECT * FROM company_currency WHERE companyID = ?";
        $result = $this->conn->Query($query, [$company]);
        return $result;
    }

    // Get company currency
    public function GetCompanyCurrencyConversion($company)
    {
        $query = "SELECT * FROM company_currency_conversion WHERE companyID = ?";
        $result = $this->conn->Query($query, [$company]);
        return $result;
    }

    // Get company Current Financial Term
    public function getCompanyActiveFT($company_id)
    {
        $query = "SELECT * FROM company_financial_terms WHERE companyID = ? AND current = ?";
        $result = $this->conn->Query($query, [$company_id, 1]);
        return $result;
    }

    // Get System catagory
    public function getCatagoryByName($name)
    {
        $query = "SELECT * FROM account_catagory WHERE catagory = ?";
        $result = $this->conn->Query($query, [$name]);
        return $result;
    }

    // Get System catagory
    public function getAllCatagory()
    {
        $query = "SELECT * FROM account_catagory";
        $result = $this->conn->Query($query);
        return $result;
    }

    // Add company users for login in business panel
    public function addCompanyUser($params)
    {
        $query = "INSERT INTO company_users(company_id,customer_id,username,password) VALUES(?,?,?,?)";
        $result = $this->conn->Query($query, $params);
        return $result;
    }

    // Delete company users for login in business panel
    public function deleteCompanyUser($ID)
    {
        $query = "DELETE FROM company_users WHERE company_id = ?";
        $result = $this->conn->Query($query, [$ID]);
        return $result;
    }

    // Add company users for login in business panel
    public function addCompanyCustomer($params, $columns, $values)
    {
        $query = "INSERT INTO customers(" . $columns . ") VALUES(" . $values . ")";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    // get all company users
    public function getCompanyUsers()
    {
        $query = "SELECT * FROM company_users INNER JOIN company ON company_users.company_id = company.company_id 
        INNER JOIN customers ON company_users.customer_id = customers.customer_id";
        $result = $this->conn->Query($query);
        return $result;
    }

    // get user by ID
    public function getCompanyUserByID($ID)
    {
        $query = "SELECT * FROM company_users INNER JOIN company ON company_users.company_id = company.company_id 
        INNER JOIN customers ON company_users.customer_id = customers.customer_id WHERE company_users.user_id = ?";
        $result = $this->conn->Query($query, [$ID]);
        return $result;
    }

    // get user by Customer ID
    public function getCompanyUserByCustomerID($ID)
    {
        $query = "SELECT * FROM company_users INNER JOIN company ON company_users.company_id = company.company_id 
        INNER JOIN customers ON company_users.customer_id = customers.customer_id WHERE company_users.customer_id = ?";
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

    // Add Company contract
    public function updateCompanyContract($company)
    {
        $query = "UPDATE company_contract SET ended = ? WHERE companyID = ?";
        $result = $this->conn->Query($query, [1, $company]);
        return $result;
    }

    // Delete Company contract
    public function deleteCompanyContract($ID)
    {
        $query = "DELETE FROM company_contract WHERE companyID = ?";
        $result = $this->conn->Query($query, [$ID]);
        return $result;
    }

    // Add Company Financial Terms
    public function addCompanyFinancialTerms($params)
    {
        $query = "INSERT INTO company_financial_terms(companyID,fiscal_year_start,fiscal_year_end,fiscal_year_title,reg_date) VALUES(?,?,?,?,?)";
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

    // Add Company User model
    public function addCompanyUserModel($params)
    {
        $query = "INSERT INTO company_users_model(user_id,company_model_id) VALUES(?,?)";
        $result = $this->conn->Query($query, $params, $returnLastID = true);
        return $result;
    }

    // Add Company User model
    public function getCompanyModelAllChilds($modelID)
    {
        $query = "SELECT * FROM system_models WHERE parentID = ?";
        $result = $this->conn->Query($query, [$modelID]);
        return $result;
    }

    // Add Company User Sub model
    public function addCompanyUserSubModel($params)
    {
        $query = "INSERT INTO company_users_rules(user_id,company_model_id) VALUES(?,?)";
        $result = $this->conn->Query($query, $params, $returnLastID = true);
        return $result;
    }

    // Remove Company model
    public function deleteCompanyModel($modelID)
    {
        $query = "DELETE FROM company_model WHERE company_model_id = ?";
        $result = $this->conn->Query($query, [$modelID]);
        return $result->rowCount();
    }

    // Remove Company User model
    public function deleteCompanyUserModel($modelID, $userID)
    {
        $query = "DELETE FROM company_users_model WHERE company_user_model_id = ? AND user_id = ?";
        $result = $this->conn->Query($query, [$modelID, $userID]);
        return $result->rowCount();
    }

    // Get Company User model Details
    public function getCompanyUserModel($modelID)
    {
        $query = "SELECT * FROM company_users_model WHERE company_user_model_id = ?";
        $result = $this->conn->Query($query, [$modelID]);
        return $result;
    }

    // Remove Company User Sub model
    public function deleteCompanyUserSubModel($modelID)
    {
        $query = "DELETE FROM company_users_rules WHERE company_user_rule_id = ?";
        $result = $this->conn->Query($query, [$modelID]);
        return $result->rowCount();
    }


    // Remove Company User Sub model by user
    public function deleteCompanyUserSubModelByUser($modelID, $userID)
    {
        $query = "DELETE FROM company_users_rules WHERE company_model_id = ? AND user_id = ?";
        $result = $this->conn->Query($query, [$modelID, $userID]);
        return $result->rowCount();
    }


    // Get Company models : models that are not allowed to be used by company
    public function getCompanyDenyModel($companyID)
    {
        $query = "SELECT * FROM company_model INNER JOIN system_models ON company_model.modelID = system_models.id WHERE company_model.companyID = ?";
        $result = $this->conn->Query($query, [$companyID]);
        return $result;
    }

    // Get Company Users models : models that are not allowed to be used by company User
    public function getCompanyUserDenyModel($userID)
    {
        $query = "SELECT * FROM company_users_model INNER JOIN system_models ON company_users_model.company_model_id = system_models.id WHERE company_users_model.user_id = ?";
        $result = $this->conn->Query($query, [$userID]);
        return $result;
    }

    // Get Company Users models : models that are not allowed to perform CRUIDS operation by company User
    public function getCompanyUserCRUIDModel($userID)
    {
        $query = "SELECT * FROM company_users_rules INNER JOIN system_models ON company_users_rules.company_model_id = system_models.id WHERE company_users_rules.user_id = ?";
        $result = $this->conn->Query($query, [$userID]);
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

    // Check if company has current fiscal open year
    public function checkFY($companyID)
    {
        $query = "SELECT * FROM company_financial_terms WHERE companyID = ? AND current = ?";
        $result = $this->conn->Query($query, [$companyID, 1]);
        return $result;
    }

    // close company current fiscal year
    public function closeFY($companyID)
    {
        $query = "UPDATE company_financial_terms SET current = ? WHERE companyID = ?";
        $result = $this->conn->Query($query, [0, $companyID]);
        return $result;
    }

    // open company new fiscal year
    public function openFY($params)
    {
        $query = "INSERT INTO company_financial_terms(companyID,fiscal_year_start,fiscal_year_end,fiscal_year_title,reg_date,current) 
        VALUES(?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
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
        $query = "SELECT * FROM company_users 
        LEFT JOIN company ON company_users.company_id = company.company_id 
        LEFT JOIN customers ON company_users.customer_id = customers.customer_id 
        WHERE company_users.username = ? AND company_users.password = ? AND company_users.block = ?";
        $result = $this->conn->Query($query, [$username, $password, 0]);
        return $result;
    }

    // Set Company user as online
    public function makeOnline($userID, $status)
    {
        $query = "UPDATE company_users SET is_online = ? WHERE user_id = ?";
        $result = $this->conn->Query($query, [$status, $userID]);
        return $result;
    }

    // Add Company Login logs
    public function login_logs($user, $user_action)
    {
        $query = "INSERT INTO login_log(user,user_action,action_date) values(?,?,?)";
        $result = $this->conn->Query($query, [$user, $user_action, time()]);
        return $result;
    }

    // Get Company model
    public function getCompanyModel($userID, $companyID)
    {
        $query = "SELECT * FROM system_models WHERE system_models.id NOT IN (SELECT modelID FROM company_model WHERE company_model.companyID = ?) AND system_models.parentID = 0 
         AND system_models.id NOT IN (SELECT company_model_id FROM company_users_model WHERE company_users_model.user_id = ?)";
        $result = $this->conn->Query($query, [$companyID, $userID]);
        return $result;
    }

    // Get Company model Details
    public function getCompanyModelDetails($modelURL)
    {
        $query = "SELECT * FROM system_models WHERE system_models.url = ?";
        $result = $this->conn->Query($query, [$modelURL]);
        return $result;
    }

    // Get Company User Allowed Sub model
    public function getCompanySubModel($userID, $companyID)
    {
        $query = "SELECT * FROM system_models WHERE system_models.id NOT IN (SELECT modelID FROM company_model WHERE company_model.companyID = ?) AND system_models.parentID != 0 
         AND system_models.id NOT IN (SELECT company_model_id FROM company_users_rules WHERE company_users_rules.user_id = ?)";
        $result = $this->conn->Query($query, [$companyID, $userID]);
        return $result;
    }

    // Check if model is blocked on user
    public function checkIfModelBlocked($userID, $modelID)
    {
        $query = "SELECT * FROM company_users_model WHERE user_id = ? AND company_model_id = ?";
        $result = $this->conn->Query($query, [$userID, $modelID]);
        return $result->rowCount();
    }

    // Check if sub model is blocked on user
    public function checkIfSubModelBlocked($userID, $modelID)
    {
        $query = "SELECT * FROM company_users_rules WHERE user_id = ? AND company_model_id = ?";
        $result = $this->conn->Query($query, [$userID, $modelID]);
        return $result->rowCount();
    }

    // Get Company Share Holders
    public function getCompanyHolders($companyID)
    {
        $query = "SELECT * FROM customers WHERE company_id = ? AND person_type = ?";
        $result = $this->conn->Query($query, [$companyID, "Share holders"]);
        return $result;
    }

    // get last leadger ID of company
    public function getLeadgerID($company)
    {
        $LID = 1;
        $query = "SELECT leadger_id FROM general_leadger WHERE company_id = ? ORDER BY leadger_id DESC LIMIT 1";
        $result = $this->conn->Query($query, [$company]);
        if($result->rowCount() > 0)
        {
            $data = $result->fetch(PDO::FETCH_OBJ);
            $lid = $data->leadger_id;
            $lid++;
            $LID = $lid;
        }
        return $LID;
    }
}
