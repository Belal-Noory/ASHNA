<?php

class SystemAdmin
{
    // Database class
    private $conn;

    public function __construct()
    {
        $this->conn = new Connection();
    }

    public function login($params)
    {
        if(!is_null($params)){
            $query = "SELECT * FROM sys_admin WHERE email = ? AND pass = ?";
            $res = $this->conn->Query($query, $params);
            return $res;
        }
    }

    public function addAdmin($params)
    {
        $query = "INSERT INTO sys_admin(email,pass,fname,lname) VALUES(?,?,?,?)";
        $result = $this->conn->Query($query, $params);
        return $result;
    }
}
