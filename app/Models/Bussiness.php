<?php

class Bussiness
{
    // Database class
    private $conn;

    public function __construct()
    {
        $this->conn = new Connection();
    }

    // Add Customers
    public function addCustomer($params)
    {
        $query = "INSERT INTO customers(company_id,fname,lname,alies_name,gender,email,NID,TIN,office_address,office_details,official_phone,personal_phone,personal_phone_second,fax,website,note,person_type,added_date,createby,approve,father,dob,job,incomesource,monthlyincom,financialCredit,details) 
        VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    // updated Customers
    public function updateCustomer($params)
    {
        $query = "UPDATE customers SET fname = ?,lname = ?,alies_name = ?,gender = ?,email = ?,NID = ?,TIN = ?,office_address = ?,
        office_details = ?,official_phone = ?,personal_phone = ?,personal_phone_second = ?,fax = ?,website = ?,note = ?,person_type = ?,father = ?,
        dob = ?,job = ?,incomesource = ?,monthlyincom = ?,financialCredit = ?,details = ? WHERE customer_id = ?";
        $result = $this->conn->Query($query, $params);
        return $result->rowCount();
    }

    // Add daily Customers
    public function addDailyCustomer($params)
    {
        $query = "INSERT INTO customers(fname,lname,alies_name,personal_phone,NID,note,person_type,added_date,createby,approve) 
        VALUES(?,?,?,?,?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    // Update daily Customers
    public function updateDailyCustomer($params)
    {
        $query = "UPDATE customers SET fname = ?,lname = ?,alies_name = ?,personal_phone = ?,NID = ?,note = ? 
         WHERE customer_id = ?";
        $result = $this->conn->Query($query, $params);
        return $result->rowCount();
    }

    // Update daily Customers
    public function updateDailyCustomerByPhone($params)
    {
        $query = "UPDATE customers SET fname = ?,lname = ?,alies_name = ?,NID = ?,details = ? 
         WHERE personal_phone = ? AND person_type = ?";
        $result = $this->conn->Query($query, $params);
        return $result->rowCount();
    }

    // Add daily Customers attachment
    public function addDailyCustomerAttachment($params)
    {
        $query = "INSERT INTO dailycustomersattacment(cus_id,attachment_name,type) 
        VALUES(?,?,?)";
        $result = $this->conn->Query($query, $params);
        return $result;
    }

    // Add Customers Addresss
    public function addCustomerAddress($params)
    {
        $query = "INSERT INTO customeraddress(customer_id,address_type,detail_address,province,district) 
        VALUES(?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    // get Customers Addresss
    public function getCustomerAddress($cusID)
    {
        $query = "SELECT * FROM customeraddress WHERE customer_id = ?";
        $result = $this->conn->Query($query,[$cusID]);
        return $result;
    }

    // Update Customers Addresss
    public function updateCustomerAddress($params)
    {
        $query = "UPDATE customeraddress SET detail_address = ?,province = ?,district = ? WHERE person_address_id = ?";
        $result = $this->conn->Query($query, $params);
        return $result->rowCount();
    }

    // Add Customers Bank Details
    public function addCustomerBankDetails($params)
    {
        $query = "INSERT INTO customersbankdetails(customer_id,bank_name,account_number,currency,details) 
        VALUES(?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    // get Customers Bank Details
    public function getCustomerBankDetails($cusID)
    {
        $query = "SELECT * FROM customersbankdetails WHERE customer_id = ?";
        $result = $this->conn->Query($query,[$cusID]);
        return $result;
    }

    // update Customers Bank Details
    public function updateCustomerBankDetails($params)
    {
        $query = "UPDATE customersbankdetails SET bank_name = ?,account_number = ?,currency = ?,details = ? WHERE person_bank_details_id = ?";
        $result = $this->conn->Query($query,$params);
        return $result->rowCount();
    }

    // Add Customers attachements
    public function addCustomerAttachments($params)
    {
        $query = "INSERT INTO customersattacment(person_id,attachment_type,attachment_name,details,createby,updatedby) 
        VALUES(?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    // Get Customers attachements
    public function getCustomerAttachments($customerID)
    {
        $query = "SELECT * FROM customersattacment WHERE person_id = ?";
        $result = $this->conn->Query($query, [$customerID]);
        return $result;
    }

    // Get Customers profile image
    public function getStaffProfileImage($customerID)
    {
        $query = "SELECT * FROM customersattacment WHERE person_id = ? AND attachment_type = ?";
        $result = $this->conn->Query($query, [$customerID,"profile"]);
        return $result;
    }

    // Delete Customers attachements
    public function deleteCustomerAttachments($customerID)
    {
        $query = "DELETE FROM customersattacment WHERE attachment_name = ?";
        $result = $this->conn->Query($query, [$customerID]);
        return $result->rowCount();
    }

    // add customer notes
    public function addCustomerNote($params)
    {
        $query = "INSERT INTO customer_notes(customer_id,title,details,reg_date) 
        VALUES(?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    // Get customer notes
    public function getCustomerNote($customerID)
    {
        $query = "SELECT * FROM customer_notes WHERE customer_id = ? ORDER BY note_id DESC";
        $result = $this->conn->Query($query, [$customerID]);
        return $result;
    }

    // Delete customer notes
    public function deleteCustomerNote($customerID)
    {
        $query = "DELETE FROM customer_notes WHERE note_id = ?";
        $result = $this->conn->Query($query, [$customerID]);
        return $result;
    }

    // add customer Reminder
    public function addCustomerReminder($params)
    {
        $query = "INSERT INTO customer_reminder(customer_id,title,details,remindate,reg_date) 
        VALUES(?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    // Get customer Reminder
    public function getCustomerReminder($customerID)
    {
        $query = "SELECT * FROM customer_reminder WHERE customer_id = ? ORDER BY reminder_id DESC";
        $result = $this->conn->Query($query, [$customerID]);
        return $result;
    }

    // Delete customer notes
    public function deleteCustomerReminder($reminder_id)
    {
        $query = "DELETE FROM customer_reminder WHERE reminder_id = ?";
        $result = $this->conn->Query($query, [$reminder_id]);
        return $result;
    }

    // Get company Customers
    // public function getCompanyCustomers($companyID, $user_id)
    // {
    //     $query = "SELECT * FROM chartofaccount 
    //     LEFT JOIN customers ON chartofaccount.cutomer_id = customers.customer_id 
    //     WHERE chartofaccount.company_id = ? AND chartofaccount.account_kind IN('MSP','Legal Entity','Individual')";
    //     $result = $this->conn->Query($query, [$companyID]);
    //     return $result;
    // }
    public function getCompanyCustomers($companyID)
    {
        $query = "SELECT * FROM customers 
        WHERE company_id = ? AND person_type IN('MSP','Legal Entity','Individual')";
        $result = $this->conn->Query($query, [$companyID]);
        return $result;
    }

    public function getCompanyStaff($companyID)
    {
        $query = "SELECT * FROM customers 
        WHERE company_id = ? AND person_type IN('Share holders','user')";
        $result = $this->conn->Query($query, [$companyID]);
        return $result;
    }

    // Get company total Customers
    public function getTotalCompanyCustomers($companyID)
    {
        $query = "SELECT * FROM customers WHERE company_id = ? AND person_type IN('MSP','Legal Entity','Individual')";
        $result = $this->conn->Query($query, [$companyID]);
        return $result;
    }

    // Get company Unique Customers
    public function getCompanCustomersList($companyID)
    {
        $query = "SELECT DISTINCT * FROM customers WHERE company_id = ? GROUP BY fname";
        $result = $this->conn->Query($query, [$companyID]);
        return $result;
    }

    // Get company users
    public function getCompanyUsers($companyID)
    {
        $query = "SELECT * FROM customers WHERE company_id = ? AND person_type = ?";
        $result = $this->conn->Query($query, [$companyID, "user"]);
        return $result;
    }

    // Get company unique users
    public function getCompanyUniqueCustomers($companyID)
    {
        $query = "SELECT * FROM customers 
        LEFT JOIN chartofaccount ON chartofaccount.cutomer_id = customers.customer_id 
        WHERE customers.company_id = ? AND customers.person_type in (?,?)";
        $result = $this->conn->Query($query, [$companyID, "Saraf", "Customer"]);
        return $result;
    }

    // check Company Login
    public function checkLogin($customerID)
    {
        $query = "SELECT * FROM company_users WHERE customer_id = ?";
        $result = $this->conn->Query($query, [$customerID]);
        return $result;
    }

    // Block Company User Login
    public function blockCompanyLogin($customerID)
    {
        $query = "UPDATE company_users SET block = ? WHERE customer_id = ?";
        $result = $this->conn->Query($query, [1, $customerID]);
        return $result;
    }

    // Unblock Company User Login
    public function unBlockCompanyLogin($customerID)
    {
        $query = "UPDATE company_users SET block = ? WHERE customer_id = ?";
        $result = $this->conn->Query($query, [0, $customerID]);
        return $result;
    }

    // Get All Sarafs
    public function getAllSarafs($CID)
    {
        $query = "SELECT * FROM customers 
        INNER JOIN chartofaccount ON customers.customer_id = chartofaccount.cutomer_id 
        WHERE person_type = ? AND chartofaccount.company_id = ? AND customers.company_id = ?";
        $result = $this->conn->Query($query, ["MSP",$CID,$CID]);
        return $result;
    }

    // Get All Receivable Sarafs
    public function getAllSarafsReceivable($CID)
    {
        $query = "SELECT * FROM customers 
        INNER JOIN chartofaccount ON customers.customer_id = chartofaccount.cutomer_id 
        WHERE person_type = ? AND chartofaccount.company_id = ? AND customers.company_id = ? AND chartofaccount.account_type = ?";
        $result = $this->conn->Query($query, ["MSP",$CID,$CID,"receivable"]);
        return $result;
    }

    // Get All Payable Sarafs
    public function getAllSarafsPayable($CID)
    {
        $query = "SELECT * FROM customers 
        INNER JOIN chartofaccount ON customers.customer_id = chartofaccount.cutomer_id 
        WHERE person_type = ? AND chartofaccount.company_id = ? AND customers.company_id = ? AND chartofaccount.account_type = ?";
        $result = $this->conn->Query($query, ["MSP",$CID,$CID,"payable"]);
        return $result;
    }

    // Get Payable Customer
    public function getPayableAccount($CID,$customerID)
    {
        $query = "SELECT * FROM chartofaccount 
        WHERE account_kind IN('MSP','Legal Entity','Individual') AND company_id = ? AND account_type = ? AND cutomer_id = ?";
        $result = $this->conn->Query($query, [$CID,"payable",$customerID]);
        return $result;
    }

    // Get Payable Customer
    public function getRecivableAccount($CID,$customerID)
    {
        $query = "SELECT * FROM chartofaccount 
        WHERE account_kind IN('MSP','Legal Entity','Individual') AND company_id = ? AND account_type = ? AND cutomer_id = ?";
        $result = $this->conn->Query($query, [$CID,"receivable",$customerID]);
        return $result;
    }

    // Get company Customers with their accounts details
    public function getCompanyCustomersWithAccounts($companyID, $user_id)
    {
        $query = "SELECT * FROM chartofaccount 
        INNER JOIN customers ON chartofaccount.cutomer_id = customers.customer_id WHERE chartofaccount.company_id = ?";
        $result = $this->conn->Query($query, [$companyID]);
        return $result;
    }

    // Get company Customers Receivable Accounts
    public function getCompanyReceivableAccounts($companyID)
    {
        $query = "SELECT * FROM chartofaccount 
        INNER JOIN customers ON chartofaccount.cutomer_id = customers.customer_id WHERE chartofaccount.company_id = ? AND chartofaccount.account_type = ?";
        $result = $this->conn->Query($query, [$companyID,"receivable"]);
        return $result;
    }

     // Get company Customers Payable Accounts
     public function getCompanyPayableAccounts($companyID)
     {
         $query = "SELECT * FROM chartofaccount 
         INNER JOIN customers ON chartofaccount.cutomer_id = customers.customer_id WHERE chartofaccount.company_id = ? AND chartofaccount.account_type = ?";
         $result = $this->conn->Query($query, [$companyID,"payable"]);
         return $result;
     }

    // Get company Customer by ID
    public function getCustomerByID($user_id)
    {
        $query = "SELECT * FROM customers 
        LEFT JOIN customeraddress ON customers.customer_id = customeraddress.customer_id 
        WHERE customers.customer_id = ?";
        $result = $this->conn->Query($query, [$user_id]);
        return $result;
    }

    // Get company Customer by ID
    public function getCustomerByType($CID, $type)
    {
        $query = "SELECT * FROM customers WHERE company_id = ? AND person_type = ?";
        $result = $this->conn->Query($query, [$CID,$type]);
        return $result;
    }

    // Get company Customer by ID
    public function getCustomerDetails($user_id)
    {
        $query = "SELECT * FROM customers WHERE customer_id = ?";
        $result = $this->conn->Query($query, [$user_id]);
        return $result;
    }


    // Get company Customer Accounts by ID
    public function getCustomerAccountsByID($user_id)
    {
        $query = "SELECT * FROM chartofaccount WHERE cutomer_id = ?";
        $result = $this->conn->Query($query, [$user_id]);
        return $result;
    }

    // Get company Customer All Transactions
    public function getCustomerAllTransaction($user_id,$CID)
    {
        $query = "SELECT * FROM account_money 
        LEFT JOIN general_leadger ON general_leadger.leadger_id = account_money.leadger_ID 
        LEFT JOIN company_currency ON general_leadger.currency_id = company_currency.company_currency_id 
        WHERE account_id = ? AND cleared=? AND deleted = ? AND approved = ? AND account_money.company_id = ? AND general_leadger.company_id = ?";
        $result = $this->conn->Query($query, [$user_id, 0,0,1,$CID,$CID]);
        return $result;
    }

    // Get Transaction all details By ID
    public function getTransactionByID($TID)
    {
        $query = "SELECT * FROM general_leadger t
            LEFT JOIN chartofaccount cs ON cs.chartofaccount_id = t.recievable_id OR cs.chartofaccount_id = t.payable_id
            LEFT JOIN company_currency ON t.currency_id = company_currency.company_currency_id 
            LEFT JOIN account_money ON t.leadger_id = account_money.leadger_ID
            WHERE t.leadger_id = ?";
        $result = $this->conn->Query($query, [$TID]);
        return $result;
    }

    // Get company Customer All Exchange Transactions
    public function getCustomerAllExchangeTransaction($user_id)
    {
        $query = "SELECT * FROM exchange_currency WHERE customer_id = ?";
        $result = $this->conn->Query($query, [$user_id]);
        return $result;
    }

    // Get company Customer All account
    public function getCustomerAllAccounts($user_id)
    {
        $query = "SELECT * FROM customer_accounts 
        INNER JOIN company_currency ON customer_accounts.currency_id = company_currency.company_currency_id 
        WHERE customer_id = ?";
        $result = $this->conn->Query($query, [$user_id]);
        return $result;
    }

    // Get company Customer All account
    public function getCustomer($company)
    {
        $query = "SELECT * FROM customers WHERE company_id = ?";
        $result = $this->conn->Query($query, [$company]);
        return $result;
    }

    // Get All Daily Customers
    public function GetAllDailyCustomers()
    {
        $query = "SELECT * FROM customers WHERE person_type = ?";
        $result = $this->conn->Query($query, ["Daily Customer"]);
        return $result;
    }

    // Get All Daily Customer
    public function GetDailyCustomer($phone)
    {
        $query = "SELECT * FROM customers WHERE person_type = ? AND personal_phone = ?";
        $result = $this->conn->Query($query, ["Daily Customer", $phone]);
        return $result;
    }

    // Get All Daily Customer
    public function GetDailyCustomerByID($ID)
    {
        $query = "SELECT * FROM customers WHERE person_type = ? AND customer_id = ?";
        $result = $this->conn->Query($query, ["Daily Customer", $ID]);
        return $result;
    }

    // Get block nid
    public function GetBlockNID($nid)
    {
        $query = "SELECT * FROM blocked_nids WHERE nid_number = ?";
        $result = $this->conn->Query($query, [$nid]);
        return $result;
    }

    // Get block nids
    public function GetBlockNIDs()
    {
        $query = "SELECT * FROM blocked_nids";
        $result = $this->conn->Query($query);
        return $result;
    }

    // add block nid
    public function AddBlockNID($nid,$fname,$lname,$father,$reg_date,$user)
    {
        $query = "INSERT INTO blocked_nids(nid_number,fname,lname,father,reg_date,createby) VALUES(?,?,?,?,?,?)";
        $result = $this->conn->Query($query,[$nid,$fname,$lname,$father,$reg_date,$user],true);
        return $result;
    }

    // Remove block nid
    public function RemoveBlockNID($ID)
    {
        $query = "DELETE FROM blocked_nids WHERE blocked_nid_id = ?";
        $result = $this->conn->Query($query,[$ID]);
        return $result->rowCount();
    }

    // get login users
    public function getCompanyOnlineUser()
    {
        $query = "SELECT * FROM company_users WHERE is_online = ?";
        $result = $this->conn->Query($query, [1]);
        return $result;
    }

    // get top debetors
    public function getTopDebetos($company)
    {
        $query = "SELECT account_name,
        SUM(CASE WHEN ammount_type = 'Debet' THEN amount ELSE 0 END) debits,
        SUM(CASE WHEN ammount_type = 'Crediet' THEN amount ELSE 0 END) credits 
        FROM chartofaccount 
        LEFT JOIN account_money ON account_money.account_id = chartofaccount.chartofaccount_id 
        WHERE chartofaccount.account_kind = ? AND chartofaccount.company_id = ? 
        GROUP BY chartofaccount_id";
        $result = $this->conn->Query($query, ["Customer", $company]);
        return $result;
    }

    // change user password
    public function changeCredentials($userID, $username, $pass){
        $query = "UPDATE company_users SET username = ?, password = ? WHERE customer_id = ?";
        $result = $this->conn->Query($query, [$username, $pass, $userID]);
        return $result->rowCount();
    }
    
}
