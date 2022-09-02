<?php

class Expense
{
    // Database class
    private $conn;

    public function __construct()
    {
        $this->conn = new Connection();
    }

    public function addExpendseLeadger($params)
    {
        $query = "INSERT INTO general_leadger(recievable_id,payable_id,currency_id,remarks,company_financial_term_id,reg_date,currency_rate,approved,createby,updatedby,op_type,company_id) 
        VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    public function getExpenseLeadger($companyID, $term)
    {
        $query = "SELECT * FROM general_leadger 
        LEFT JOIN account_money ON general_leadger.leadger_id = account_money.leadger_ID 
        LEFT JOIN company_currency ON general_leadger.currency_id = company_currency.company_currency_id 
        WHERE general_leadger.company_id = ? AND general_leadger.op_type = ? AND general_leadger.cleared=? AND general_leadger.company_financial_term_id = ? AND account_money.ammount_type = ?";
        $result = $this->conn->Query($query, [$companyID, "Expense", 0, $term, "Debet"]);
        return $result;
    }

    public function getExpenseAccount($leadger_id)
    {
        $query = "SELECT * FROM account_money INNER JOIN chartofaccount ON account_money.account_id = chartofaccount.chartofaccount_id 
                 WHERE account_money.leadger_ID = ? ";
        $result = $this->conn->Query($query, [$leadger_id]);
        return $result;
    }

    // Get Revenue Accounts
    public function getExpenseAccounts($company_id)
    {
        $query = "SELECT * FROM account_catagory 
        INNER JOIN chartofaccount ON account_catagory.account_catagory_id = chartofaccount.account_catagory
        WHERE account_catagory.catagory = ? AND chartofaccount.company_id = ? ORDER BY account_catagory_id ASC";
        $result = $this->conn->Query($query, ["Expenses", $company_id]);
        return $result;
    }

    // Get customer balance
    public function getExpenseBalance($customer_account_id)
    {
        $query = "SELECT * FROM general_leadger LEFT JOIN account_money ON general_leadger.leadger_id = account_money.leadger_ID
                  LEFT JOIN company_currency ON general_leadger.currency_id = company_currency.company_currency_id
                  WHERE general_leadger.recievable_id = ? OR general_leadger.payable_id = ? AND general_leadger.cleared=?";
        $result = $this->conn->Query($query, [$customer_account_id, $customer_account_id, 0]);
        return $result;
    }

    // Get Revenue all list from account_catagory
    public function getExpenseListWithChildred()
    {
        $query = "SELECT account_catagory_id FROM account_catagory WHERE catagory = ? ";
        $result = $this->conn->Query($query, ['expenses']);
        $results = $result->fetch(PDO::FETCH_OBJ);
        $res = $this->getSubCategories($results->account_catagory_id);
        return $res;
    }

    function getSubCategories($parent_id)
    {

        $query = "SELECT * FROM account_catagory WHERE parentID = ? ";
        $result = $this->conn->Query($query, [$parent_id]);
        $data = array();
        $res = $result->fetchAll(PDO::FETCH_OBJ);
        foreach ($res as $re) {
            if ($re->parentID != 0) {
                $child = $this->getSubCategories($re->account_catagory_id);
                array_push($data, ["parent" => array("name" => $re->catagory, "id" => $re->account_catagory_id), "child" => $child]);
            } else {
                array_push($data, ["parent" => array("name" => $re->catagory, "id" => $re->account_catagory_id), "child" => []]);
            }
        }
        return $data;
    }
}
