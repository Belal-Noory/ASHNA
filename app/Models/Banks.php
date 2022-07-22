<?php

class Banks
{
    // Database class
    private $conn;

    public function __construct()
    {
        $this->conn = new Connection();
    }

    public function addBank($params)
    {
        $query = "INSERT INTO chartofaccount(account_catagory,account_name,account_number,initial_ammount,currency,reg_date,company_id,createby,approve,note,account_kind,useradded) 
        VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    public function addSaif($params)
    {
        $query = "INSERT INTO chartofaccount(account_catagory,account_name,currency,reg_date,company_id,createby,approve,note,account_kind,useradded) 
        VALUES(?,?,?,?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    public function addCustomerAccount($params)
    {
        $query = "INSERT INTO chartofaccount(account_catagory,account_name,account_number,currency,reg_date,company_id,createby,approve,note,account_type,account_kind,cutomer_id) 
        VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    // Get customer balance
    public function getCustomerBalance($customer_account_id)
    {
        $query = "SELECT * FROM general_leadger LEFT JOIN account_money ON general_leadger.leadger_id = account_money.leadger_ID
                  LEFT JOIN company_currency ON general_leadger.currency_id = company_currency.company_currency_id
                  WHERE general_leadger.recievable_id = ? OR general_leadger.payable_id = ? AND account_money.temp = ? AND general_leadger.cleared = ?";
        $result = $this->conn->Query($query, [$customer_account_id, $customer_account_id, 0, 0]);
        return $result;
    }

    public function getBanks($companyID)
    {
        $query = "SELECT * FROM chartofaccount WHERE company_id = ? AND account_kind = ? and useradded = ?";
        $result = $this->conn->Query($query, [$companyID, "Bank",1]);
        return $result;
    }

    public function getBankByID($bankID)
    {
        $query = "SELECT * FROM chartofaccount WHERE chartofaccount_id = ?";
        $result = $this->conn->Query($query, [$bankID]);
        return $result;
    }

    public function getCustomerByBank($bankID)
    {
        $query = "SELECT * FROM chartofaccount INNER JOIN customers ON chartofaccount.cutomer_id = customers.customer_id WHERE chartofaccount_id = ?";
        $result = $this->conn->Query($query, [$bankID]);
        return $result;
    }

    public function getSaifs($companyID)
    {
        $query = "SELECT * FROM chartofaccount WHERE company_id = ? AND account_kind = ? AND useradded = ?";
        $result = $this->conn->Query($query, [$companyID, "Cash Register",1]);
        return $result;
    }

    public function getCustomers($companyID)
    {
        $query = "SELECT * FROM chartofaccount WHERE company_id = ? AND account_kind = ?";
        $result = $this->conn->Query($query, [$companyID, "Customer"]);
        return $result;
    }

    public function getAccount($companyID, $type)
    {
        $query = "SELECT * FROM chartofaccount WHERE company_id = ? AND account_kind = ?";
        $result = $this->conn->Query($query, [$companyID, $type]);
        return $result;
    }

    public function getBank_Saif($bankID)
    {
        $query = "SELECT * FROM chartofaccount WHERE chartofaccount_id = ?";
        $result = $this->conn->Query($query, [$bankID]);
        return $result;
    }

    public function addTransferLeadger($params)
    {
        $query = "INSERT INTO general_leadger(recievable_id,payable_id,currency_id,remarks,company_financial_term_id,reg_date,currency_rate,approved,createby,updatedby,op_type,company_id,rcode) 
        VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    public function addOpeningBalanceLeadger($params)
    {
        $query = "INSERT INTO general_leadger(recievable_id,currency_id,remarks,company_financial_term_id,reg_date,approved,createby,updatedby,op_type,company_id) 
        VALUES(?,?,?,?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    public function addTransferMoney($params)
    {
        $query = "INSERT INTO account_money(account_id,leadger_ID,amount,ammount_type,company_id,detials) 
        VALUES(?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    public function getTransfersLeadger($companyID)
    {
        $query = "SELECT * FROM general_leadger
        INNER JOIN account_money ON account_money.leadger_ID = general_leadger.leadger_id 
        WHERE general_leadger.company_id = ? AND op_type = ? AND cleared = ?";
        $result = $this->conn->Query($query, [$companyID, "Bank Transfer", 0]);
        return $result;
    }

    public function getTransfersMoney($companyID, $leadgerID)
    {
        $query = "SELECT * FROM account_money WHERE company_id = ? AND leadger_ID = ?";
        $result = $this->conn->Query($query, [$companyID, $leadgerID]);
        return $result;
    }

    // Add Exchange conversion
    public function addExchangeConversion($params)
    {
        $query = "INSERT INTO company_currency_conversion(currency_from,currency_to,rate,reg_date,approve,createby,companyID) 
        VALUES(?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    // Get Exchange conversion
    public function getExchangeConversion($from, $to, $companyID)
    {
        $query = "SELECT * FROM company_currency_conversion WHERE ((currency_from = ? AND currency_to  = ?) OR (currency_from = ? AND currency_to  = ?)) AND companyID = ? ORDER BY reg_date DESC LIMIT 1";
        $result = $this->conn->Query($query, [$from, $to, $to, $from, $companyID]);
        return $result;
    }

    // Add Exchange Money
    public function addExchangeMoney($params)
    {
        $query = "INSERT INTO exchange_currency(debt_currecny_id,credit_currecny_id,chartofaccount_id,customer_id,company_id,debt_amount,credit_amount,exchange_rate,details,reg_date,createby) 
        VALUES(?,?,?,?,?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    // Add Exchange Money
    public function getAllExchangeMoney($company)
    {
        $query = "SELECT * FROM exchange_currency WHERE company_id = ?";
        $result = $this->conn->Query($query, [$company]);
        return $result;
    }

    // Get All Accounts Catagory 
    public function getAllAccountsCatagory()
    {
        $query = "SELECT * FROM account_catagory";
        $result = $this->conn->Query($query);
        return $result;
    }

    // Add Account Catagory
    public function addCatagory($name, $parentID, $company)
    {
        $query = "INSERT INTO account_catagory(catagory,parentID,company_id) VALUES(?,?,?)";
        $result = $this->conn->Query($query, [$name, $parentID, $company], true);
        return $result;
    }

    // Add Chart of account
    public function addCatagoryAccount($params)
    {
        $query = "INSERT INTO chartofaccount(account_catagory,account_name,account_type,currency,reg_date,company_id,createby,account_kind,cutomer_id) 
        VALUES(?,?,?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    // Delete Chart of account
    public function deleteCatagoryAccount($ID)
    {
        $query = "DELETE FROM chartofaccount WHERE company_id = ?";
        $result = $this->conn->Query($query, [$ID]);
        return $result;
    }

    // get customer/account debets
    public function getDebets_Credits($cusID)
    {
        $query = "SELECT * FROM general_leadger WHERE recievable_id = ? OR payable_id = ? AND cleared = ?";
        $result = $this->conn->Query($query, [$cusID, $cusID, 0]);
        $res = $result->fetchAll(PDO::FETCH_OBJ);

        $debet = 0;
        $crediet = 0;

        foreach ($res as $r) {
            $query = "SELECT * FROM account_money WHERE leadger_ID = ?";
            $result2 = $this->conn->Query($query, [$r->leadger_id]);
            $res2 = $result2->fetchAll(PDO::FETCH_OBJ);
            foreach ($res2 as $r2) {
                if ($r2->ammount_type == "Debet") {
                    $debet += $r2->amount;
                } else {
                    $crediet += $r2->amount;
                }
            }
        }

        return array("debet" => $debet, "credit" => $crediet);
    }

    // get leadger debets
    public function getLeadgerDebets_Credits($cusID)
    {
        $query = "SELECT * FROM chartofaccount INNER JOIN general_leadger ON chartofaccount.chartofaccount_id = general_leadger.recievable_id OR chartofaccount.chartofaccount_id = general_leadger.payable_id WHERE general_leadger.cleared = ? AND chartofaccount.cutomer_id = ?";
        $result = $this->conn->Query($query, [0, $cusID]);
        $res = $result->fetchAll(PDO::FETCH_OBJ);

        $debet = 0;
        $crediet = 0;
        $final_res = array();

        foreach ($res as $r) {
            $query = "SELECT * FROM account_money WHERE leadger_ID = ?";
            $result2 = $this->conn->Query($query, [$r->leadger_id]);
            $res2 = $result2->fetchAll(PDO::FETCH_OBJ);
            foreach ($res2 as $r2) {
                if ($r2->ammount_type == "Debet") {
                    $debet += $r2->amount;
                } else {
                    $crediet += $r2->amount;
                }
            }
            array_push($final_res, ["debet" => $debet, "credit" => $crediet, "leadger" => $r->leadger_id]);
        }
        return json_encode($final_res);
    }

    // get account details
    public function getchartofaccountDetails($ID)
    {
        $query = "SELECT * FROM chartofaccount WHERE chartofaccount_id = ?";
        $result = $this->conn->Query($query, [$ID]);
        $res = $result->fetch(PDO::FETCH_OBJ);
        return json_encode($res);
    }

    // clear Leadger
    public function clearLeadger($LID)
    {
        $query = "UPDATE `general_leadger` SET cleared = ? WHERE leadger_id = ?";
        $result = $this->conn->Query($query, [1, $LID]);
        return $result->rowCount();
    }
}
