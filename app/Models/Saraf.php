<?php

class Saraf
{
    // Database class
    private $conn;

    public function __construct()
    {
        $this->conn = new Connection();
    }

    public function addSarafLogin($params)
    {
        $query = "INSERT INTO saraf_login(customer_id,username,password,is_online) 
        VALUES(?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }
}
