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

    public function updateBank($params)
    {
        $query = "UPDATE chartofaccount SET account_name = ?,account_number = ?,currency = ?, note = ? WHERE chartofaccount_id = ?";
        $result = $this->conn->Query($query, $params);
        return $result->rowCount();
    }

    public function addSaif($params)
    {
        $query = "INSERT INTO chartofaccount(account_catagory,account_name,currency,reg_date,company_id,createby,approve,note,account_kind,useradded) 
        VALUES(?,?,?,?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    public function updateSaif($params)
    {
        $query = "UPDATE chartofaccount SET account_name = ?, currency = ?, note = ? WHERE chartofaccount_id = ?";
        $result = $this->conn->Query($query, $params);
        return $result->rowCount();
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
        $query = "SELECT * FROM account_money 
                  INNER JOIN general_leadger ON general_leadger.leadger_id = account_money.leadger_ID 
                  WHERE account_money.account_id = ? AND account_money.temp = ? AND general_leadger.cleared = ?";
        $result = $this->conn->Query($query, [$customer_account_id, 0, 0]);
        return $result;
    }

    public function getBanks($companyID)
    {
        $query = "SELECT * FROM chartofaccount WHERE company_id = ? AND account_kind = ? and useradded = ?";
        $result = $this->conn->Query($query, [$companyID, "Bank", 1]);
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
        $result = $this->conn->Query($query, [$companyID, "Cash Register", 1]);
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
        $query = "SELECT * FROM chartofaccount WHERE company_id = ? AND account_catagory = ? AND useradded = ?";
        $result = $this->conn->Query($query, [$companyID, $type, 1]);
        return $result;
    }

    public function getAccountMoney($companyID, $type)
    {
        $query = "SELECT chartofaccount_id, SUM(CASE WHEN ammount_type ='Debet' THEN amount ELSE 0 END) as Debet,
        SUM(CASE WHEN ammount_type ='Crediet' THEN amount ELSE 0 END) as Credit FROM chartofaccount 
        LEFT JOIN account_money ON account_money.account_id = chartofaccount.chartofaccount_id
        WHERE chartofaccount.company_id = ? AND chartofaccount.account_catagory = ? AND chartofaccount.useradded = ? AND ammount_type = ? 
        GROUP BY chartofaccount_id";
        $result = $this->conn->Query($query, [$companyID, $type, 1, "Debet"]);
        return $result;
    }

    public function getAccountMoneyByID($ID)
    {
        $query = "SELECT SUM(CASE WHEN ammount_type ='Debet' THEN amount ELSE 0 END) as Debet,
        SUM(CASE WHEN ammount_type ='Crediet' THEN amount ELSE 0 END) as Credit FROM account_money 
        WHERE account_id = ?";
        $result = $this->conn->Query($query, [$ID]);
        return $result;
    }

    public function getAccountMoneyWithRate($ID)
    {
        $query = "SELECT * FROM account_money 
        WHERE account_id = ?";
        $result = $this->conn->Query($query, [$ID]);
        return $result;
    }

    public function getSystemAccount($ID)
    {
        $query = "SELECT * FROM chartofaccount WHERE chartofaccount_id = ?";
        $result = $this->conn->Query($query, [$ID]);
        return $result;
    }

    public function getAccountByName($company,$name)
    {
        $query = "SELECT * FROM chartofaccount WHERE company_id = ? AND account_name = ? ORDER BY chartofaccount_id DESC";
        $result = $this->conn->Query($query, [$company,$name]);
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
        $query = "INSERT INTO general_leadger(leadger_id,recievable_id,payable_id,currency_id,remarks,company_financial_term_id,reg_date,currency_rate,approved,createby,updatedby,op_type,company_id,rcode) 
        VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    public function addLoseProfitLeadger($params)
    {
        $query = "INSERT INTO general_leadger(leadger_id,recievable_id,currency_id,remarks,company_financial_term_id,reg_date,createby,op_type,company_id) 
        VALUES(?,?,?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    public function addOpeningBalanceLeadger($params)
    {
        $query = "INSERT INTO general_leadger(leadger_id,recievable_id,payable_id,currency_id,remarks,company_financial_term_id,reg_date,approved,createby,updatedby,op_type,company_id) 
        VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    public function getAccountOpeningBalance($company,$acc,$type)
    {
        $res = 0;
        $query = "SELECT leadger_id,account_name, chartofaccount_id, company_currency.currency, amount from chartofaccount 
        INNER JOIN account_money ON account_money.account_id = chartofaccount.chartofaccount_id 
        INNER JOIN company_currency ON company_currency.company_currency_id = account_money.currency 
        WHERE chartofaccount.chartofaccount_id = ? AND chartofaccount.company_id = ? AND account_money.detials = ? AND ammount_type = ?";
        $result = $this->conn->Query($query, [$acc,$company,'Opening Balance',$type]);
        return $result;
    }

    public function addTransferMoney($params)
    {
        $query = "INSERT INTO account_money(account_id,leadger_ID,amount,ammount_type,company_id,detials,temp,currency,rate) 
        VALUES(?,?,?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    public function getMoney($acc,$LID)
    {
        $query = "SELECT * FROM account_money WHERE account_id = ? AND leadger_ID = ?";
        $result = $this->conn->Query($query, [$acc,$LID]);
        return $result;
    }

    public function updateTransferMoney($params)
    {
        $query = "UPDATE account_money SET account_id = ?,amount = ?,currency = ?,rate = ? WHERE leadger_ID = ? AND ammount_type = ?";
        $result = $this->conn->Query($query, $params);
        return $result;
    }

    public function updateTransferMoneyINOUT($params)
    {
        $query = "UPDATE account_money SET account_id = ?,amount = ?,currency = ?,rate = ? WHERE leadger_ID = ? AND ammount_type = ? AND amount = ?";
        $result = $this->conn->Query($query, $params);
        return $result;
    }

    public function getTransfersLeadger($companyID)
    {
        $query = "SELECT * FROM general_leadger WHERE company_id = ? AND op_type = ? AND cleared = ?";
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
        $query = "SELECT * FROM company_currency_conversion 
        WHERE ((currency_from = ? AND currency_to  = ?) OR (currency_from = ? AND currency_to  = ?)) 
        AND companyID = ? ORDER BY reg_date DESC LIMIT 1";
        $result = $this->conn->Query($query, [$from, $to, $to, $from, $companyID]);
        return $result;
    }

    // Get Exchange conversion
    public function getCompanyExchangeConversion($companyID)
    {
        $query = "SELECT * FROM company_currency_conversion 
        WHERE companyID = ? ORDER BY reg_date DESC";
        $result = $this->conn->Query($query, [$companyID]);
        return $result;
    }

    // Add Exchange Money
    public function addExchangeLeadger($leadger_id,$receivable, $payable, $currencyid, $remarks, $termID, $regdate, $currencyRate, $approved, $createby, $updatedby, $op_type, $companyID, $clear, $rcode)
    {
        $query = "INSERT INTO general_leadger(leadger_id,recievable_id, payable_id, currency_id, remarks, company_financial_term_id, reg_date, currency_rate, approved, createby, updatedby, op_type, company_id, cleared, rcode) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, [$leadger_id,$receivable, $payable, $currencyid, $remarks, $termID, $regdate, $currencyRate, $approved, $createby, $updatedby, $op_type, $companyID, $clear, $rcode], true);
        return $result;
    }

    // get all Exchange Money
    public function getAllExchangeMoney($company)
    {
        $query = "SELECT * FROM general_leadger 
        WHERE general_leadger.company_id = ? AND general_leadger.op_type = ?";
        $result = $this->conn->Query($query, [$company, "Bank Exchange"]);
        return $result;
    }

    // get Exchange Money
    public function getExchangeMoney($LID)
    {
        $query = "SELECT * FROM general_leadger WHERE leadger_id = ? AND op_type = ?";
        $result = $this->conn->Query($query, [$LID, "Bank Exchange"]);
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
        $query = "INSERT INTO chartofaccount(account_catagory,account_name,account_type,currency,reg_date,company_id,createby,account_kind,cutomer_id,useradded) 
        VALUES(?,?,?,?,?,?,?,?,?,?)";
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
        $query = "SELECT chartofaccount_id, cutomer_id,account_name, account_id, SUM(CASE WHEN ammount_type = 'Debet' THEN amount ELSE 0 END) debits,
        SUM(CASE WHEN ammount_type = 'Crediet' THEN amount ELSE 0 END) credits
        FROM chartofaccount 
        INNER JOIN general_leadger ON chartofaccount.chartofaccount_id = general_leadger.recievable_id OR chartofaccount.chartofaccount_id = general_leadger.payable_id 
        INNER JOIN account_money ON general_leadger.recievable_id = account_money.account_id OR account_money.account_id = general_leadger.payable_id 
        WHERE chartofaccount.chartofaccount_id = ? AND general_leadger.cleared = ? 
        GROUP BY account_money.account_id 
        ORDER BY account_money.account_id ASC ";
        $result = $this->conn->Query($query, [$cusID, 0]);
        $res = $result->fetchAll(PDO::FETCH_OBJ);
        return json_encode($res);
    }

    // get leadger debets
    public function getLeadgerDebets_Credits($cusID)
    {
        $query = "SELECT * FROM account_money 
        INNER JOIN general_leadger ON account_money.leadger_ID = general_leadger.leadger_id  
        INNER JOIN chartofaccount ON chartofaccount.chartofaccount_id = account_money.account_id 
        WHERE general_leadger.cleared = ? AND account_money.account_id = ?";
        $result = $this->conn->Query($query, [0, $cusID]);
        $res = $result->fetchAll(PDO::FETCH_OBJ);
        return json_encode($res);
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
        $query = "UPDATE general_leadger SET cleared = ? WHERE leadger_id = ?";
        $result = $this->conn->Query($query, [1, $LID]);
        return $result->rowCount();
    }

    // get assets accounts
    public function  getAssetsAccounts($IDs)
    {
        $query = "SELECT * FROM account_catagory 
        LEFT JOIN chartofaccount ON account_catagory.account_catagory_id = chartofaccount.account_catagory 
        WHERE catagory IN (?,?,?,?,?) AND chartofaccount.company_id = ? AND chartofaccount.useradded = 0 ";
        $result = $this->conn->Query($query, $IDs);
        return $result;
    }

    // get Liabilities accounts
    public function  getLiabilitiesAccounts($IDs)
    {
        $query = "SELECT * FROM account_catagory 
        LEFT JOIN chartofaccount ON account_catagory.account_catagory_id = chartofaccount.account_catagory 
        WHERE catagory IN (?,?) AND chartofaccount.company_id = ? AND chartofaccount.useradded = 0";
        $result = $this->conn->Query($query, $IDs);
        return $result;
    }

    // get Equity accounts
    public function  getEqityAccounts($IDs)
    {
        $query = "SELECT * FROM account_catagory 
        LEFT JOIN chartofaccount ON account_catagory.account_catagory_id = chartofaccount.account_catagory 
        WHERE catagory = ? AND chartofaccount.company_id = ? AND chartofaccount.useradded = 0";
        $result = $this->conn->Query($query, $IDs);
        return $result;
    }

    // get exchange entries
    public function getExchangeEntires($company_id, $mainCurrency)
    {
        $query = "SELECT catagory,chartofaccount_id,account_name, currency_rate, general_leadger.currency_id,
        SUM(CASE WHEN ammount_type = 'Debet' THEN amount ELSE 0 END) debits,
        SUM(CASE WHEN ammount_type = 'Crediet' THEN amount ELSE 0 END) credits FROM general_leadger 
        INNER JOIN chartofaccount ON general_leadger.recievable_id = chartofaccount.chartofaccount_id OR general_leadger.payable_id = chartofaccount.chartofaccount_id 
        INNER JOIN account_money ON account_money.account_id = chartofaccount.chartofaccount_id 
        LEFT JOIN account_catagory ON account_catagory.account_catagory_id = chartofaccount.account_catagory 
        INNER JOIN company_currency ON company_currency.company_currency_id = general_leadger.currency_id 
        WHERE general_leadger.company_id = ? AND general_leadger.currency_rate != ? AND general_leadger.currency_id != ? AND chartofaccount.useradded = ? 
        GROUP BY chartofaccount_id ORDER BY chartofaccount_id";
        $result = $this->conn->Query($query, [$company_id, 0, $mainCurrency, 1]);
        return $result;
    }

    // update exchange entreis
    public function updatedExchangeEntries($charofAccountID, $newrate)
    {
        $query = "UPDATE general_leadger SET currency_rate = ? WHERE recievable_id = ? OR payable_id = ?";
        $result = $this->conn->Query($query, [$newrate, $charofAccountID, $charofAccountID]);
        return $result->rowCount();
    }

    // get customer transaction by currency
    public function getCustomerTransactionByCurrency($customer,$currency)
    {
        $query = "SELECT company_currency.currency, SUM(CASE WHEN ammount_type ='Debet' THEN amount ELSE 0 END) as Debet,
        SUM(CASE WHEN ammount_type ='Crediet' THEN amount ELSE 0 END) as Credit FROM account_money 
        LEFT JOIN company_currency ON company_currency.company_currency_id = account_money.currency 
        WHERE account_id = ? AND account_money.currency = ?";
        $result = $this->conn->Query($query, [$customer, $currency]);
        return $result;
    }

    // get customer transaction by currency
    public function getCustomerAllTransactionByCurrency($customer,$currency)
    {
        $query = "SELECT * FROM account_money 
        LEFT JOIN general_leadger ON general_leadger.leadger_id = account_money.leadger_ID  
        LEFT JOIN company_currency ON company_currency.company_currency_id = account_money.currency 
        WHERE account_id = ? AND account_money.currency = ?";
        $result = $this->conn->Query($query, [$customer, $currency]);
        return $result;
    }

    // Get users banks/saifs that are not assigned to user yet
    public function userNotAssignedBanks($userID, $company){
        $query = "SELECT * FROM chartofaccount 
        WHERE chartofaccount_id NOT IN(SELECT banks FROM userbanks WHERE user_id = ?) 
        AND account_kind IN('Cash Register','Bank') AND company_id = ? AND useradded = ?";
        $result = $this->conn->Query($query, [$userID,$company,1]);
        $results = $result->fetchAll(PDO::FETCH_OBJ);
        return $results;
    }

    // Get users banks/saifs that are not assigned to user yet
    public function userAssignedBanks($userID, $company, $type = null){
        if(!is_null($type))
        {
            $query = "SELECT * FROM chartofaccount 
            WHERE chartofaccount_id IN(SELECT banks FROM userbanks WHERE user_id = ?) 
            AND account_kind IN('Cash Register','Bank') AND company_id = ? AND useradded = ? AND account_kind = ?";
            $result = $this->conn->Query($query, [$userID,$company,1, $type]);
            $results = 0;
            if($result->rowCount() > 0)
            {
                $results = $result->fetchAll(PDO::FETCH_OBJ);
            }
            return $results;
        }
        else{
            $query = "SELECT * FROM chartofaccount 
            WHERE chartofaccount_id IN(SELECT banks FROM userbanks WHERE user_id = ?) 
            AND account_kind IN('Cash Register','Bank') AND company_id = ? AND useradded = ?";
            $result = $this->conn->Query($query, [$userID,$company,1]);
            $results = 0;
            if($result->rowCount() > 0)
            {
                $results = $result->fetchAll(PDO::FETCH_OBJ);
            }
            return $results;
        }
    }

    // Assign bank/saif to user
    public function AssignAcc($user,$bank)
    {
        $query = "INSERT INTO userbanks(user_id,banks) VALUES(?,?)";
        $result = $this->conn->Query($query, [$user,$bank],true);
        return $result;
    }

    // Remove bank/saif to user
    public function RemoveAcc($user,$bank)
    {
        $query = "DELETE FROM userbanks WHERE user_id = ? AND banks = ?";
        $result = $this->conn->Query($query, [$user,$bank]);
        return $result->rowCount();
    }

    // get recipt details by leadger
    public function getLeadger($LID)
    {
        $query = "SELECT * FROM account_money 
        LEFT JOIN general_leadger ON general_leadger.leadger_id = account_money.leadger_ID 
        LEFT JOIN company_currency ON general_leadger.currency_id = company_currency.company_currency_id 
        WHERE account_money.leadger_ID = ?";
        $result = $this->conn->Query($query, [$LID]);
        return $result;
    }

    
    public function updatedLeadger($params)
    {
        $query = "UPDATE general_leadger SET recievable_id = ?,payable_id = ?,currency_id = ?,remarks = ?,reg_date = ?,currency_rate = ?,updatedby = ? 
        WHERE leadger_id = ?";
        $result = $this->conn->Query($query, $params);
        return $result;
    }

    // delete opening balance
    public function deleteOp($LID,$CID){
        $query = "DELETE FROM account_money WHERE leadger_ID = ? AND company_id = ?";
        $result = $this->conn->Query($query, [$LID,$CID]);

        $query1 = "DELETE FROM general_leadger WHERE leadger_id = ? AND company_id = ?";
        $result1 = $this->conn->Query($query1, [$LID,$CID]);

        return $result1->rowCount();
    }

}
