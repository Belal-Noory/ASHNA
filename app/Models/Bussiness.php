<?php

class Bussiness
{
    // Database class
    private $conn;

    public function __construct()
    {
        $this->conn = new Connection();
    }

    // Add Customers
    public function addCustomer($params)
    {
        $query = "INSERT INTO customers(company_id,fname,lname,alies_name,gender,email,NID,TIN,office_address,office_details,official_phone,personal_phone,personal_phone_second,fax,website,note,person_type,added_date,createby,approve) 
        VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    // Add daily Customers
    public function addDailyCustomer($params)
    {
        $query = "INSERT INTO customers(fname,lname,alies_name,personal_phone,NID,note,person_type,added_date,createby,approve) 
        VALUES(?,?,?,?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    // Update daily Customers
    public function updateDailyCustomer($params)
    {
        $query = "UPDATE customers SET fname = ?,lname = ?,alies_name = ?,personal_phone = ?,NID = ?,note = ? 
         WHERE customer_id = ?";
        $result = $this->conn->Query($query, $params);
        return $result->rowCount();
    }

    // Add daily Customers attachment
    public function addDailyCustomerAttachment($params)
    {
        $query = "INSERT INTO dailycustomersattacment(cus_id,attachment_name,type) 
        VALUES(?,?,?)";
        $result = $this->conn->Query($query, $params);
        return $result;
    }

    // Add Customers Addresss
    public function addCustomerAddress($params)
    {
        $query = "INSERT INTO customeraddress(customer_id,address_type,detail_address,province,district) 
        VALUES(?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    // Add Customers Bank Details
    public function addCustomerBankDetails($params)
    {
        $query = "INSERT INTO customersbankdetails(customer_id,bank_name,account_number,currency,details) 
        VALUES(?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    // Add Customers attachements
    public function addCustomerAttachments($params)
    {
        $query = "INSERT INTO customersattacment(person_id,attachment_type,attachment_name,details,createby,updatedby) 
        VALUES(?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    // Get Customers attachements
    public function getCustomerAttachments($customerID)
    {
        $query = "SELECT * FROM customersattacment WHERE person_id = ?";
        $result = $this->conn->Query($query, [$customerID]);
        return $result;
    }

    // Delete Customers attachements
    public function deleteCustomerAttachments($customerID)
    {
        $query = "DELETE FROM customersattacment WHERE attachment_name = ?";
        $result = $this->conn->Query($query, [$customerID]);
        return $result->rowCount();
    }

    // add customer notes
    public function addCustomerNote($params)
    {
        $query = "INSERT INTO customer_notes(customer_id,title,details,reg_date) 
        VALUES(?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    // Get customer notes
    public function getCustomerNote($customerID)
    {
        $query = "SELECT * FROM customer_notes WHERE customer_id = ? ORDER BY note_id DESC";
        $result = $this->conn->Query($query, [$customerID]);
        return $result;
    }

    // Delete customer notes
    public function deleteCustomerNote($customerID)
    {
        $query = "DELETE FROM customer_notes WHERE note_id = ?";
        $result = $this->conn->Query($query, [$customerID]);
        return $result;
    }

    // add customer Reminder
    public function addCustomerReminder($params)
    {
        $query = "INSERT INTO customer_reminder(customer_id,title,details,remindate,reg_date) 
        VALUES(?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    // Get customer Reminder
    public function getCustomerReminder($customerID)
    {
        $query = "SELECT * FROM customer_reminder WHERE customer_id = ? ORDER BY reminder_id DESC";
        $result = $this->conn->Query($query, [$customerID]);
        return $result;
    }

    // Delete customer notes
    public function deleteCustomerReminder($reminder_id)
    {
        $query = "DELETE FROM customer_reminder WHERE reminder_id = ?";
        $result = $this->conn->Query($query, [$reminder_id]);
        return $result;
    }

    // Get company Customers
    public function getCompanyCustomers($companyID, $user_id)
    {
        $query = "SELECT * FROM chartofaccount LEFT JOIN customers ON chartofaccount.cutomer_id = customers.customer_id WHERE chartofaccount.company_id = ? AND chartofaccount.account_kind = ?";
        $result = $this->conn->Query($query, [$companyID, "Customer"]);
        return $result;
    }

    // Get company Unique Customers
    public function getCompanCustomersList($companyID)
    {
        $query = "SELECT DISTINCT * FROM customers WHERE company_id = ? GROUP BY fname";
        $result = $this->conn->Query($query, [$companyID]);
        return $result;
    }

    // Get company users
    public function getCompanyUsers($companyID)
    {
        $query = "SELECT * FROM customers WHERE company_id = ? AND person_type not in (?,?)";
        $result = $this->conn->Query($query, [$companyID, "Saraf", "Daily Customer"]);
        return $result;
    }

    // Get company unique users
    public function getCompanyUniqueCustomers($companyID)
    {
        $query = "SELECT * FROM customers WHERE company_id = ? AND person_type in (?,?)";
        $result = $this->conn->Query($query, [$companyID, "Saraf", "Customer"]);
        return $result;
    }

    // check Company Login
    public function checkLogin($customerID)
    {
        $query = "SELECT * FROM company_users WHERE customer_id = ?";
        $result = $this->conn->Query($query, [$customerID]);
        return $result;
    }

    // Block Company User Login
    public function blockCompanyLogin($customerID)
    {
        $query = "UPDATE company_users SET block = ? WHERE customer_id = ?";
        $result = $this->conn->Query($query, [1, $customerID]);
        return $result;
    }

    // Unblock Company User Login
    public function unBlockCompanyLogin($customerID)
    {
        $query = "UPDATE company_users SET block = ? WHERE customer_id = ?";
        $result = $this->conn->Query($query, [0, $customerID]);
        return $result;
    }

    // Get All Sarafs
    public function getAllSarafs()
    {
        $query = "SELECT * FROM customers INNER JOIN chartofaccount ON customers.customer_id = chartofaccount.cutomer_id WHERE person_type = ? ";
        $result = $this->conn->Query($query, ["Saraf"]);
        return $result;
    }

    // Get company Customers with their accounts details
    public function getCompanyCustomersWithAccounts($companyID, $user_id)
    {
        $query = "SELECT * FROM chartofaccount INNER JOIN customers ON chartofaccount.cutomer_id = customers.customer_id WHERE chartofaccount.company_id = ?";
        $result = $this->conn->Query($query, [$companyID]);
        return $result;
    }

    // Get company Customer by ID
    public function getCustomerByID($user_id)
    {
        $query = "SELECT * FROM customers LEFT JOIN customeraddress ON customers.customer_id = customeraddress.customer_id WHERE customers.customer_id = ?";
        $result = $this->conn->Query($query, [$user_id]);
        return $result;
    }

    // Get company Customer Accounts by ID
    public function getCustomerAccountsByID($user_id)
    {
        $query = "SELECT * FROM chartofaccount WHERE cutomer_id = ?";
        $result = $this->conn->Query($query, [$user_id]);
        return $result;
    }

    // Get company Customer All Transactions
    public function getCustomerAllTransaction($user_id)
    {
        $query = "SELECT * FROM general_leadger 
        LEFT JOIN company_currency ON general_leadger.currency_id = company_currency.company_currency_id 
        LEFT JOIN account_money ON general_leadger.leadger_id = account_money.leadger_ID 
        WHERE recievable_id = ? OR payable_id = ? AND cleared=?";
        $result = $this->conn->Query($query, [$user_id, $user_id, 0]);
        return $result;
    }

    // Get Transaction all details By ID
    public function getTransactionByID($TID)
    {
        $query = "SELECT * FROM general_leadger t
            LEFT JOIN chartofaccount cs ON cs.chartofaccount_id = t.recievable_id OR cs.chartofaccount_id = t.payable_id
            LEFT JOIN company_currency ON t.currency_id = company_currency.company_currency_id 
            LEFT JOIN account_money ON t.leadger_id = account_money.leadger_ID
            WHERE t.leadger_id = ?";
        $result = $this->conn->Query($query, [$TID]);
        return $result;
    }

    // Get company Customer All Exchange Transactions
    public function getCustomerAllExchangeTransaction($user_id)
    {
        $query = "SELECT * FROM exchange_currency WHERE customer_id = ?";
        $result = $this->conn->Query($query, [$user_id]);
        return $result;
    }

    // Get company Customer All account
    public function getCustomerAllAccounts($user_id)
    {
        $query = "SELECT * FROM customer_accounts 
        INNER JOIN company_currency ON customer_accounts.currency_id = company_currency.company_currency_id 
        WHERE customer_id = ?";
        $result = $this->conn->Query($query, [$user_id]);
        return $result;
    }

    // Get All Daily Customers
    public function GetAllDailyCustomers()
    {
        $query = "SELECT * FROM customers WHERE person_type = ?";
        $result = $this->conn->Query($query, ["Daily Customer"]);
        return $result;
    }

    // Get All Daily Customer
    public function GetDailyCustomer($phone)
    {
        $query = "SELECT * FROM customers WHERE person_type = ? AND personal_phone = ?";
        $result = $this->conn->Query($query, ["Daily Customer", $phone]);
        return $result;
    }

    // Get block nid
    public function GetBlockNID($nid)
    {
        $query = "SELECT * FROM blocked_nids WHERE nid_number = ?";
        $result = $this->conn->Query($query, [$nid]);
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
