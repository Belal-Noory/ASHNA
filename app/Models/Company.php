<?php

class Company
{
    // Database class
    private $conn;

    public function __construct()
    {
        $this->conn = new Connection();
    }


    public function addCompany($params)
    {
        $query = "INSERT INTO company(company_name,legal_name,company_type,license_number,TIN,register_number,country,province,district,postal_code,phone,fax,addres,website,email) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params);
        return $result;
    }
}
