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
        $query = "INSERT INTO company(company_name,legal_name,company_type,license_number,TIN,register_number,country,province,district,postal_code,phone,fax,addres,website,email,maincurrency,fiscal_year_start,fiscal_year_end,fiscal_year_title) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params);
        return $result;
    }

    public function getAllCompanies(){
        $query = "SELECT * FROM company";
        $result = $this->conn->Query($query);
        return $result;
    }
}
