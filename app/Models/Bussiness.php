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

    // get login users
    public function getCompanyOnlineUser()
    {
        $query = "SELECT * FROM company_users WHERE is_online = ?";
        $result = $this->conn->Query($query, [1]);
        return $result;
    }
}
