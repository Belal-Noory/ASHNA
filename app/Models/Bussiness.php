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
        $query = "INSERT INTO customersbankdetails(customer_id,bank_name,account_type,account_number,currency,details) 
        VALUES(?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    // Get company Customers
    public function getCompanyCustomers($companyID, $user_id)
    {
        $query = "SELECT * FROM customers WHERE company_id = ? AND customer_id != ?";
        $result = $this->conn->Query($query, [$companyID, $user_id]);
        return $result;
    }

    // Get company Customer by ID
    public function getCustomerByID($user_id)
    {
        $query = "SELECT * FROM customers INNER JOIN customeraddress ON customers.customer_id = customeraddress.customer_id WHERE customers.customer_id = ?";
        $result = $this->conn->Query($query, [$user_id]);
        return $result;
    }

    // Get company Customer All Transactions
    public function getCustomerAllTransaction($user_id)
    {
        $query = "SELECT * FROM general_leadger WHERE recievable_id = ? OR payable_id = ?";
        $result = $this->conn->Query($query, [$user_id, $user_id]);
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
        $query = "SELECT * FROM customer_accounts INNER JOIN company_currency ON customer_accounts.currency_id = company_currency.company_currency_id WHERE customer_id = ?";
        $result = $this->conn->Query($query, [$user_id]);
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
