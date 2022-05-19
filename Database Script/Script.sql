-- ASHNA Database
CREATE DATABASE ASHNA;

-- 1: PERSONS/CUSTOMER(ASHKHAS)
    -- System Admin Users
    CREATE TABLE sys_admin(
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(64) NOT NULL,
        pass VARCHAR(128) NOT NULL,
        fname VARCHAR(64) NOT NULL,
        lname VARCHAR(64) NOT NULL,
        created BIGINT NOT NULL 
    );

-- System models
    create table system_models(
        id int PRIMARY key AUTO_INCREMENT,
        name_dari varchar(128),
        name_english varchar(128),
        name_pashto varchar(128),
        icon varchar(128),
        color varchar(64),
        url varchar(128),
        sort_order int,
        parentID int null
    );

INSERT INTO `system_models` (`name_dari`, `name_english`, `name_pashto`, `icon`, `color`, `url`, `sort_order`, `parentID`) VALUES
('اشخاص', 'Contacts', 'اړیکې', 'la-users', '', '', 1, 0),
('شخص جدید', 'New Contact', ' نوی اړیکې', '', '', 'NewContact.php', 1, 1),
('لیست اشخاص', 'Contact List', 'اړیکې لیست', '', '', 'Contacts.php', 2, 1),
('رسید و عواید', 'Receipt & Revenue', 'رسید او عواید', 'la-coins', '', '', 2, 0),
('رسید جدید', 'New Receipt', 'نوی رسید', '', '', 'NewReceipt.php', 1, 4),
('لیست رسید', 'Receipt List', ' د رسید لیست', '', '', 'Receipts.php', 2, 4),
('انتقال خارجی', 'Out Transference', 'بهر لیږد', '', '', 'NewOutTransference.php', 3, 4),
('لیست انتقال خارجی', 'Out Transference list', 'بهر لیږد لیست', '', '', 'OutTransferences.php', 4, 4),
('عواید', 'Revenue', 'عواید', '', '', 'NewRevenue.php', 5, 4),
('لیست عواید', 'Revenue List', 'عواید لیست', '', '', 'Revenues.php', 6, 4),
('پرداخت و هزینه', 'Payment & Expanse', 'تادیه او لګښت', 'la-wallet', '', '', 3, 0),
('پرداخت جدید', 'New Payment', 'نوې تادیه', '', '', 'NewPayment.php', 1, 11),
('لیست پرداخت', 'Payment List', ' د تادیه لیست', '', '', 'Payments.php', 2, 11),
('انتقال داخلی', 'In Transference', 'دننه لیږد', '', '', 'NewInTransference.php', 3, 11),
('لیست انتقال داخلی', 'In Transference list', 'دننه لیږد لیست', '', '', 'InTransferences.php', 4, 11),
('درآمد', 'Income', 'عاید', '', '', 'NewIncome.php', 5, 11),
('لیست درآمد', 'Income List', 'عاید لیست', '', '', 'Incomes.php', 6, 11),
('بانکداری', 'Banking', 'بانکداري', 'la-landmark', '', '', 4, 0),
('بانک جدید', 'New Bank', 'نوې بانک', '', '', 'NewBank.php', 1, 18),
('لیست بانک', 'Bank List', ' بانک لیست', '', '', 'Banks.php', 2, 18),
('سیف جدید', 'New Saif', 'نوی سیف', '', '', 'NewSaif.php', 3, 18),
('لیست سیف', 'Saif list', 'د سیف لیست', '', '', 'Saifs.php', 4, 18),
('انتقال', 'Transfer', 'لیږد', '', '', 'Transfer.php', 5, 18),
('لیست انتقال', 'Transfer List', 'لیږد لیست', '', '', 'Transfers.php', 6, 18),
('تبادله', 'Exchange', 'تبادله', '', '', 'NewExchange.php', 7, 18),
('لیست تبادله', 'Exchange List', 'تبادله لیست', '', '', 'Exchanges.php', 8, 18),
('حسابداری', 'Accounting', 'محاسبه', 'la-folder-open', '', '', 5, 0),
('سند جدید', 'New Document', 'سند جدید', '', '', 'NewDocument.php', 1, 27),
('لیست اسناد', 'Documents List', ' سندو لیست', '', '', 'Documents.php', 2, 27),
('ورودی های تبادل', 'Exchange Entries', 'د تبادلې ننوتل', '', '', 'NewExchangeEntries.php', 3, 27),
('لیست ورودی های تبادل', 'Exchange Conversion', 'د تبادلې ننوتل لیست', '', '', 'ExchangeEntriesList.php', 4, 27),
('ورودی های موجودی مخاطبین', 'Contact Balance Entries', 'د اړیکو بیلانس داخلونه', '', '', 'ContactBalanceEntries.php', 5, 27),
('سند حقوق و دستمزد', 'Payroll', 'د معاشونو سند', '', '', 'Payroll.php', 6, 27),
('نمودار حساب', 'Chart Of Accounts', 'د حسابونو چارټ', '', '', 'ChartOfAccounts.php', 7, 27),
('پایان سال مالی', 'Fiscal year Close', 'د مالي کال پای', '', '', 'FiscalyearClose.php', 8, 27),
('بیلانس افتتاح', 'Opening Balance', 'د پرانیستلو بیلانس', '', '', 'OpeningBalance.php', 9, 27),
('گزارش ها', 'Reports', 'راپورونه', 'la-chart-pie', '', '', 6, 0),
('همه گزارش ها', 'All Reports', 'ټول راپورونه', '', '', 'AllReports.php', 1, 37),
('تنظیمات', 'Settings', 'ترتیبات', 'la-cog', '', '', 7, 0),
('نرخ ارز زنده', 'Live Exchange Rates', 'ژوندۍ تبادلې نرخونه', '', '', 'LiveExchangeRates.php', 1, 39),
('مدیریت کاربر', 'User Management', 'د کارن مدیریت', '', '', 'UserManagement.php', 2, 39),
('تنظیمات چاپ', 'Print Settings', 'د چاپ ترتیبات', '', '', 'PrintSettings.php', 2, 39);

    -- Company table
    CREATE TABLE company(
        company_id int AUTO_INCREMENT ,
        company_name varchar(128) not null,
        legal_name varchar(128) not null,
        company_type varchar(128) not null,
        license_number varchar(64) null,
        TIN varchar(64) null,
        register_number varchar(64) null,
        country varchar(64) null,
        province varchar(64) null,
        district varchar(64) null,
        postal_code varchar(64) null,
        phone varchar(64) null,
        fax varchar(64) null,
        addres varchar(64) null,
        website varchar(64) null,
        email varchar(64) null,
        maincurrency varchar(64) NULL,
        fiscal_year_start date DEFAULT NULL,
        fiscal_year_end date DEFAULT NULL,
        fiscal_year_title varchar(128) NULL,
        disable int NOT NULL DEFAULT '0',
        reg_date bigint,
        PRIMARY key(company_id)
    );

    CREATE TABLE company_currency (
        ID int NOT NULL AUTO_INCREMENT,
        companyID int REFERENCES company(company_id),
        currency varchar(16),
        PRIMARY KEY (ID)
    );

    CREATE TABLE company_contract(
        contractID INT PRIMARY KEY AUTO_INCREMENT,
        companyID int REFERENCES company(company_id),
        contract_start BIGINT NOT NULL,
        contract_end BIGINT NOT NULL
    );

    CREATE TABLE company_model(
        id INT PRIMARY KEY AUTO_INCREMENT,
        companyID int REFERENCES company(company_id),
        modelID int REFERENCES system_models(id)
    );

    -- all users data that can access the system
    CREATE TABLE company_users(
        user_id int AUTO_INCREMENT ,
        company_id int not null,
        username varchar(128) not null,
        password varchar(128) not null,
        fname varchar(64) NULL,
        lname VARCHAR(64) NULL,
        is_online INT,
        PRIMARY key(user_id),
        FOREIGN key(company_id) REFERENCES company(company_id)
    );

    -- login logs
    CREATE TABLE login_log
    (
        id INT PRIMARY KEY AUTO_INCREMENT,
        user int,
        user_action VARCHAR(16) NOT NULL,
        action_date BIGINT NOT NULL,
        CONSTRAINT login_log_created FOREIGN KEY(user) REFERENCES company_users(id)
    );

    -- Persons/Customer Table
    CREATE TABLE customers(
        person_id int AUTO_INCREMENT ,
        account_group_id int not null,
        company_id int not null,
        fname varchar(32) not null,
        lname varchar(32) not null,
        alies_name varchar(128) not null,
        gender varchar(8) not null,
        email varchar(64) null,
        NID varchar(128) null,
        TIN varchar(32) null,
        office_address varchar(128) null,
        office_details varchar(256) null,
        official_phone varchar(16) null,
        personal_phone varchar(16) null,
        personal_phone_second varchar(16) null,
        fax varchar(16) null,
        website varchar(64) null,
        note varchar(256) null,
        person_type varchar(64) not null,
        -- person type (Permenant customer, Safar, staff, share holders)
        added_date bigint not null,
        createby int not null,
        updatedby int not null,
        PRIMARY KEY(person_id),
        FOREIGN KEY(createby) REFERENCES users(user_id),
        FOREIGN KEY(updatedby) REFERENCES users(user_id),
        FOREIGN key(company_id) REFERENCES company(company_id),
        FOREIGN key(account_group_id) REFERENCES account_group(account_group_id)
    );

    CREATE TABLE customeraddress(
        person_address_id int AUTO_INCREMENT,
        person_id int,
        address_type varchar(32) not null,
        detail_address varchar(256) null,
        province varchar(16) null,
        district varchar(16) null,
        PRIMARY KEY(person_address_id),
        FOREIGN KEY (person_id) REFERENCES Person(person_id)
    );

    CREATE TABLE customersbankdetails(
        person_bank_details_id int AUTO_INCREMENT ,
        person_id int,
        bank_name varchar(64) null,
        account_type varchar(64) null,
        account_number varchar(32) null,
        currency varchar(8) null,
        details varchar(256) null,
        account_status varchar(32) null,
        PRIMARY KEY(person_bank_details_id),
        FOREIGN KEY (person_id) REFERENCES Person(person_id)
    );

    -- PERSON DOCUMENTS ATTACHMENT
    CREATE TABLE customersattacment(
        person_attachment_id int AUTO_INCREMENT ,
        person_id int,
        attachment_type varchar(128) null,
        attachment_name varchar(128) null,
        details varchar(128) null,
        createby int not null,
        updatedby int not null,
        PRIMARY KEY(person_attachment_id),
        FOREIGN KEY (person_id) REFERENCES Person(person_id),
        FOREIGN KEY(createby) REFERENCES users(user_id),
        FOREIGN KEY(updatedby) REFERENCES users(user_id)
    );
 
    -- Daily Customer table
    
-- ingore this
    CREATE TABLE daily_customer(
        daily_customer_id int AUTO_INCREMENT ,
        fname varchar(32),
        lname varchar(32),
        father_name varchar(32),
        phone varchar(16),
        NID varchar(32),
        note varchar(256),
        createby int not null,
        updatedby int not null,
        PRIMARY key(daily_customer_id),
        FOREIGN KEY(createby) REFERENCES person(person_id),
        FOREIGN KEY(updatedby) REFERENCES person(person_id),
        FOREIGN KEY(createby) REFERENCES users(user_id),
        FOREIGN KEY(updatedby) REFERENCES users(user_id)
    );

 
-- Banking
-- 3: DEBT/REVENUE
-- 4: CREDIET/EXPENSES
-- 5: ACCOUNTING

    -- Daily customer transactions
    CREATE TABLE moneytransactions(
        id int AUTO_INCREMENT ,
        person_sender int not null,
        -- company person
        person_receiver int not null,
        -- company person
        money_sender_id int not null,
        money_receiver_id int,
        money_receiver_name varchar(64) null,
        amount int not null,
        commision int not null,
        status varchar(16) not null,
        createby int not null,
        updatedby int not null,
        PRIMARY key(id),
        FOREIGN key(money_sender_id) REFERENCES daily_customer(daily_customer_id),
        FOREIGN key(money_receiver_id) REFERENCES daily_customer(daily_customer_id),
        FOREIGN KEY(createby) REFERENCES person(person_id),
        FOREIGN KEY(updatedby) REFERENCES person(person_id),
        FOREIGN KEY(person_sender) REFERENCES person(person_id),
        FOREIGN KEY(person_receiver) REFERENCES person(person_id)
    );

    
    -- Accounts group
    CREATE TABLE account_group(
        account_group_id int AUTO_INCREMENT ,
        group_name varchar(128) not null,
        account_type varchar(32) not null,
        -- account types
            -- assets
            -- liablity
            -- revenue
            -- expenses
            -- capital
        statement_type varchar(128) not null,
        -- Statement Type 
            -- Balance sheet
            -- Income Sheet
        parent_id INT,
        PRIMARY key(account_group_id)
    );

    -- PHP code to retreive the catagories with nth subcatagories
    --  try {
    --          $pdo = getPdo();

    --          $sql  = 'select * from products_categories where parent_id = 0';           
    --          $stmt = $pdo->prepare($sql);
    --          $stmt->execute(); 

    --          $data = [];

    --          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    --              echo $row['category_name'] . '<br>';
    --              getSubCategories($row['category_id'], 0);
    --          }                  

    --     } catch (Exception $e) {
    --         echo $e->getMessage();
    --     }

    -- function getSubCategories($parent_id, $level) {

    --     try {

    --         $pdo = getPdo();

    --         $sql = "select * from products_categories where parent_id = '$parent_id'";                

    --         $stmt = $pdo->prepare($sql);
    --         $stmt->execute(); 

    --         $data = [];  

    --         $level++;                 

    --         while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    --             echo str_repeat("-", ($level * 4)) . $row['category_name'] . '<br>';                    
    --             getSubCategories($row['category_id'], $level);                                    
    --         } 

    --     } catch (Exception $e) {
    --         echo $e->getMessage();
    --     }                 
    -- }

    -- chart of account
    CREATE TABLE chartofaccount(
        id int AUTO_INCREMENT ,
        person_id int not null,
        account_name varchar(128) not null,
        account_group_id int not null,
        account_type varchar(32) not null,
        -- account type
            -- payable
            -- receivable
        date datetime,
        createby int not null,
        updatedby int not null,
        parent_id int,
        PRIMARY key(id),
        FOREIGN key(account_group_id) REFERENCES account_group(account_group_id),
        FOREIGN key(person_id) REFERENCES person(person_id),
        FOREIGN KEY(createby) REFERENCES users(user_id),
        FOREIGN KEY(updatedby) REFERENCES users(user_id)
    );

    -- chart of account permissions
    CREATE TABLE account_permission(
        id int AUTO_INCREMENT ,
        user_id int not null,
        account_id int not null,
        PRIMARY key(id),
        FOREIGN key(user_id) REFERENCES users(user_id),
        FOREIGN key(account_id) REFERENCES chartofaccount(id)
    );

    -- vouchers table ingnor this one 
    CREATE TABLE voucher(
        id int AUTO_INCREMENT ,
        person_id int not null,
        voucher_number varchar(64) null,
        type varchar(32) not null,
        -- types
            -- payment
            -- recipt
            -- journal
            -- contra
        voucher_date datetime not null,
        note varchar(256) null,
        PRIMARY key(id),
        FOREIGN key(person_id) REFERENCES person(person_id)
    );



    -- General Leadger table
    CREATE TABLE general_leadger(
        id int AUTO_INCREMENT ,
        person_id int not null,
        voucher_number int not null,
        account_number int not null,
        type varchar(16),
        -- Type
            -- debt
            -- credit
        amount int,
        remarks varchar(256),
        date datetime,
        cleared varchar(16) null,
        cleared_date datetime null,
        PRIMARY key(id),
        FOREIGN key(voucher_number) REFERENCES voucher(id),
        FOREIGN key(account_number) REFERENCES chartofaccount(id),
        FOREIGN key(person_id) REFERENCES person(person_id)
    );

<<<<<<< HEAD


=======
>>>>>>> 3bea3c04ab67830f6f571aba22bbe94be1093a17
-- 6: REPORTS
-- 7: SETTINGS/OPTIONS
-- 8: logs table
    -- Daily log data table
    CREATE TABLE logs_data
    (
        user INT NOT NULL,
        tble VARCHAR(128) NOT NULL,
        user_action VARCHAR(16) NOT NULL,
        details VARCHAR(1200) NOT NULL,
        action_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        CONSTRAINT FK_USER_ID FOREIGN KEY(user) REFERENCES users(user_id)
    );

-- Approval table for all operations like adding person, transactions ...
    CREATE TABLE approval(
        approval_id int AUTO_INCREMENT ,
        table_name varchar(64) not null,
        user_id int not null,
        approved_user int not null,
        status varchar(16) not null,
        PRIMARY key(approval_id),
        FOREIGN key(approved_user) REFERENCES users(user_id),
        FOREIGN key(user_id) REFERENCES person(person_id),
        FOREIGN key(user_id) REFERENCES voucher(person_id),
        FOREIGN key(user_id) REFERENCES chartofaccount(person_id),
        FOREIGN key(user_id) REFERENCES general_leadger(person_id)
    );

