<?php

class organization
{
    // Database class
    private $conn;

    public function __construct()
    {
        $this->conn = new Connection();
    }

    public function getProfile()
    {
        $query = "SELECT * FROM org_profile";
        $res = $this->conn->Query($query);
        return $res;
    }

    public function updateCover($cover)
    {
        $query = "UPDATE org_profile SET cover = ?";
        $res = $this->conn->Query($query, [$cover]);
        return $res;
    }

    public function getService()
    {
        $query = "SELECT * FROM org_services";
        $res = $this->conn->Query($query);
        return $res;
    }

    public function addService($params)
    {
        $query = "INSERT INTO org_services(sr_name,details,icon,color) VALUES(?,?,?,?)";
        $result = $this->conn->Query($query, $params);
        return $result;
    }

    public function getSocialAccounts()
    {
        $query = "SELECT * FROM org_social_accounts";
        $res = $this->conn->Query($query);
        return $res;
    }

    public function addSocialAccounts($params)
    {
        $query = "INSERT INTO org_social_accounts(acc_name,link) VALUES(?,?)";
        $result = $this->conn->Query($query, $params);
        return $result;
    }


    public function getDoners()
    {
        $query = "SELECT * FROM org_donors";
        $res = $this->conn->Query($query);
        return $res;
    }

    public function addDoners($params)
    {
        $query = "INSERT INTO org_donors(PID,do_name,logo) VALUES(?,?,?)";
        $result = $this->conn->Query($query, $params);
        return $result;
    }


    public function deleteDoner($ID)
    {
        $query = "DELETE FROM org_donors WHERE ID = ?";
        $result = $this->conn->Query($query, [$ID]);
        return $result;
    }

    public function getLinks($name = null)
    {
        if (is_null($name)) {
            $query = "SELECT * FROM website_links ORDER BY ID ASC";
            $result = $this->conn->Query($query);
            return $result;
        } else {
            $query = "SELECT * FROM website_links WHERE link_name = ?";
            $result = $this->conn->Query($query, [$name]);
            return $result;
        }
    }

    public function addLinks($params)
    {
        $query = "INSERT INTO website_links(link_name,link) VALUES(?,?)";
        $result = $this->conn->Query($query, $params);
        return $result;
    }

    public function deleteLink($ID)
    {
        $query = "DELETE FROM website_links WHERE ID = ?";
        $result = $this->conn->Query($query, [$ID]);
        return $result;
    }

    public function addContactUS($params)
    {
        $query = "INSERT INTO contact_us(person_name,email,phone,title,msg,seen) VALUES(?,?,?,?,?,0)";
        $result = $this->conn->Query($query, $params);
        return $result;
    }

    public function getNewContactUS()
    {
        $query = "SELECT * FROM contact_us WHERE seen = ?";
        $result = $this->conn->Query($query, [0]);
        return $result;
    }

    public function getAllContactUS()
    {
        $query = "SELECT * FROM contact_us";
        $result = $this->conn->Query($query, [0]);
        return $result;
    }

    public function UpdateContactUS($ID)
    {
        $query = "UPDATE contact_us SET seen = ? WHERE ID = ?";
        $result = $this->conn->Query($query, [1, $ID]);
        return $result;
    }

    public function addFAQ($params)
    {
        $query = "INSERT INTO faq(question,answer,added_date) VALUES(?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    public function getFAQs()
    {
        $query = "SELECT * FROM faq";
        $result = $this->conn->Query($query);
        return $result;
    }

    public function deleteFAQ($ID)
    {
        $query = "DELETE FROM faq WHERE ID = ?";
        $result = $this->conn->Query($query, [$ID]);
        return $result;
    }
}
