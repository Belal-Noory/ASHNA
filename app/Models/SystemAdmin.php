<?php

class SystemAdmin
{
    // Database class
    private $conn;

    public function __construct()
    {
        $this->conn = new Connection();
    }

    // Login 
    public function login($params)
    {
        if(!is_null($params)){
            $query = "SELECT * FROM sys_admin WHERE email = ? AND pass = ?";
            $res = $this->conn->Query($query, $params);
            return $res;
        }
    }

    // Add New Admin
    public function addAdmin($params)
    {
        $query = "INSERT INTO sys_admin(email,pass,fname,lname) VALUES(?,?,?,?)";
        $result = $this->conn->Query($query, $params);
        return $result;
    }

    // Get System model
    public function getSystemModelsParent()
    {
        $query = "SELECT * FROM system_models WHERE parentID = ?";
        $result = $this->conn->Query($query, [0]);
        return $result;
    }

    // Get System model childer
    public function getSystemModelschild($parentID)
    {
        $query = "SELECT * FROM system_models WHERE parentID = ?";
        $result = $this->conn->Query($query, [$parentID]);
        return $result;
    }
}
