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

    // Get Company Login
    public function login($username, $password)
    {
        $query = "SELECT * FROM saraf_login INNER JOIN customers ON saraf_login.customer_id = customers.customer_id
        WHERE saraf_login.username = ? AND saraf_login.password = ?";
        $result = $this->conn->Query($query, [$username, $password]);
        return $result;
    }

    // Set Company user as online
    public function makeOnline($userID, $status)
    {
        $query = "UPDATE saraf_login SET is_online = ? WHERE customer_id = ?";
        $result = $this->conn->Query($query, [$status, $userID]);
        return $result;
    }

    // Approve the transfered money
    public function approverTansaction($TID)
    {
        $query = "UPDATE company_money_transfer SET paid = ? WHERE company_money_transfer_id = ?";
        $result = $this->conn->Query($query, [1, $TID]);
        return $result;
    }

    // Get Out Transference pending
    public function getSarafReceivableAccount($customerID, $currency)
    {
        $query = "SELECT * FROM chartofaccount WHERE cutomer_id = ? AND currency = ? AND account_type = ?";
        $result = $this->conn->Query($query, [$customerID, $currency, "Receivable"]);
        return $result;
    }

    // Get Out Transference pending
    public function getTransfer($ID)
    {
        $query = "SELECT * FROM company_money_transfer WHERE company_money_transfer_id = ? ";
        $result = $this->conn->Query($query, [$ID]);
        return $result;
    }

    // Get Out Transference pending
    public function getPendingOutTransfer($sarafID)
    {
        $query = "SELECT * FROM company_money_transfer INNER JOIN company_currency ON company_money_transfer.currency = company_currency.company_currency_id WHERE company_money_transfer.company_user_sender = ? AND company_money_transfer.paid = ? AND company_money_transfer.transfer_type = ?";
        $result = $this->conn->Query($query, [$sarafID, 0, "out"]);
        return $result;
    }

    // Get Out Transference Paid
    public function getPaidOutTransfer($sarafID)
    {
        $query = "SELECT * FROM company_money_transfer INNER JOIN company_currency ON company_money_transfer.currency = company_currency.company_currency_id WHERE company_money_transfer.company_user_sender = ? AND company_money_transfer.paid = ? AND company_money_transfer.transfer_type = ?";
        $result = $this->conn->Query($query, [$sarafID, 1, "out"]);
        return $result;
    }

    // Get In Transference pending
    public function getPendingInTransfer($sarafID)
    {
        $query = "SELECT * FROM company_money_transfer INNER JOIN company_currency ON company_money_transfer.currency = company_currency.company_currency_id WHERE company_money_transfer.company_user_receiver = ? AND company_money_transfer.paid = ? AND company_money_transfer.transfer_type = ?";
        $result = $this->conn->Query($query, [$sarafID, 0, "in"]);
        return $result;
    }

    // Get In Transference Paid
    public function getPaidInTransfer($sarafID)
    {
        $query = "SELECT * FROM company_money_transfer INNER JOIN company_currency ON company_money_transfer.currency = company_currency.company_currency_id WHERE company_money_transfer.company_user_receiver = ? AND company_money_transfer.paid = ? AND company_money_transfer.transfer_type = ?";
        $result = $this->conn->Query($query, [$sarafID, 1, "in"]);
        return $result;
    }
}
