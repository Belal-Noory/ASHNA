<?php

class FileManagement
{
    // Database class
    private $conn;

    public function __construct()
    {
        $this->conn = new Connection();
    }

    // Add Customers
    public function getUniqueCustomerType($CID)
    {
        $query = "SELECT DISTINCT(person_type) FROM customers WHERE company_id = ? AND person_type NOT IN('admin','Share holders','user')";
        $result = $this->conn->Query($query, [$CID]);
        return $result;
    }

    // get Files bsed on type
    public function getCustomersFileByType($CID,$cus_type)
    {
        $query = "SELECT * FROM customers 
        INNER JOIN customersattacment ON customers.customer_id = customersattacment.person_id 
        WHERE customers.person_type = ? AND customers.company_id = ?";
        $result = $this->conn->Query($query, [$cus_type,$CID]);
        return $result;
    }

     // get Files bsed on type
     public function getDilyCustomersFileByType($CID,$cus_type)
     {
         $query = "SELECT * FROM customers 
         INNER JOIN dailycustomersattacment ON customers.customer_id = dailycustomersattacment.cus_id 
         WHERE customers.person_type = ? AND customers.company_id = ?";
         $result = $this->conn->Query($query, [$cus_type,$CID]);
         return $result;
     }
    
}
