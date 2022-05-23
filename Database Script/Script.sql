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
        disable int NOT NULL DEFAULT '0',
        reg_date bigint,
        PRIMARY key(company_id)
    );

    CREATE TABLE company_financial_terms(
		term_id int primary key AUTO_INCREMENT,
		companyID int REFERENCES company(company_id),
        fiscal_year_start date DEFAULT NULL,
        fiscal_year_end date DEFAULT NULL,
        fiscal_year_title varchar(128) NULL,
        reg_date bigint
	);

    CREATE TABLE company_currency (
        company_currency_id int NOT NULL AUTO_INCREMENT,
        companyID int REFERENCES company(company_id),
        currency varchar(16),
        mainCurrency int default 0,
        PRIMARY KEY (company_currency_id)
    );

    CREATE TABLE company_currency_conversion(
        company_currency_conversion_id int PRIMARY KEY AUTO_INCREMENT,
        company_currency_id int REFERENCES company_currency(company_currency_id),
        rate float default 0,
        reg_date bigint,
        approve int DEFAULT 1,
        createby int REFERENCES company_users(user_id)
    );

    CREATE TABLE company_contract(
        contractID INT PRIMARY KEY AUTO_INCREMENT,
        companyID int REFERENCES company(company_id),
        contract_start BIGINT NOT NULL,
        contract_end BIGINT NOT NULL
    );

    CREATE TABLE company_model(
        company_model_id INT PRIMARY KEY AUTO_INCREMENT,
        companyID int REFERENCES company(company_id),
        modelID int REFERENCES system_models(id)
    );

    -- all users data that can access the system
    CREATE TABLE company_users(
        user_id int AUTO_INCREMENT,
        company_id int not null,
        customer_id int REFERENCES customers(customer_id),
        username varchar(128) not null,
        password varchar(128) not null,
        fname varchar(64) NULL,
        lname VARCHAR(64) NULL,
        is_online INT,
        PRIMARY key(user_id),
        FOREIGN key(company_id) REFERENCES company(company_id)
    );

    -- Company users models
    CREATE TABLE company_users_model(
        company_user_model_id int PRIMARY KEY AUTO_INCREMENT,
        user_id int REFERENCES company_company_users(user_id),
        company_model_id int REFERENCES company_model(company_model_id)
    );

    -- Company users rules on model
    CREATE TABLE company_users_rules(
        company_user_rule_id int PRIMARY KEY AUTO_INCREMENT,
        user_id int REFERENCES company_company_users(user_id),
        company_model_id int REFERENCES company_model(company_model_id),
        insert_op int default 0, 
        update_op int default 0,
        delete_op int default 0
    );

    -- Approval table for company users
    CREATE TABLE company_users_approval(
        company_user_approval_id int AUTO_INCREMENT,
        user_id int REFERENCES company_company_users(user_id),
        company_model_id int REFERENCES company_model(company_model_id),
        PRIMARY key(company_user_approval_id)
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
    
    -- Accounts group
    CREATE TABLE account_catagory(
        account_catagory_id int AUTO_INCREMENT,
        catagory varchar(32) not null,
        -- catagory
            -- assets
            -- liablity
            -- revenue
            -- expenses
            -- capital
        PRIMARY key(account_catagory_id)
    );

    -- chart of account
    CREATE TABLE chartofaccount(
        chartofaccount_id int AUTO_INCREMENT,
        account_name varchar(128) not null,
        account_catagory int not null,
        account_type varchar(32) not null,
        -- account type
            -- payable
            -- receivable
            -- NA
        currency_id int REFERENCES company_currency(company_currency_id),
        reg_date bigint,
        company_id int REFERENCES company(company_id),
        createby int not null,
        approve int DEFAULT 1,
        PRIMARY key(chartofaccount_id),
        FOREIGN key(account_catagory) REFERENCES account_catagory(account_catagory_id),
        FOREIGN KEY(createby) REFERENCES company_company_users(user_id)
    );

    -- General Leadger table
    CREATE TABLE general_leadger(
        leadger_id int AUTO_INCREMENT,
        recievable_id int not null,
        payable_id int not null,
        currency_id int REFERENCES company_currency(company_currency_id),
        debt_amount FLOAT DEFAULT 0,
        credit_amount FLOAT DEFAULT 0,
        remarks varchar(256),
        company_financial_term_id int REFERENCES company_financial_terms(term_id),
        reg_date BIGINT,
        approved int DEFAULT 0,
        createby int not null,
        updatedby int not null,
        currency_rate FLOAT DEFAULT 0 REFERENCES company_currency_conversion(company_currency_conversion_id),
        approve int DEFAULT 1,
        PRIMARY key(leadger_id),
        FOREIGN key(recievable_id) REFERENCES chartofaccount(chartofaccount_id),
        FOREIGN key(payable_id) REFERENCES chartofaccount(chartofaccount_id),
        FOREIGN KEY(createby) REFERENCES company_company_users(user_id),
        FOREIGN KEY(updatedby) REFERENCES company_company_users(user_id)
    );

    -- Persons/Customer Table
    CREATE TABLE customers(
        customer_id int AUTO_INCREMENT,
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
        approve int DEFAULT 1,
        PRIMARY KEY(customer_id),
        FOREIGN KEY(createby) REFERENCES company_users(user_id),
        FOREIGN key(company_id) REFERENCES company(company_id)
    );

    -- Customers address table
    CREATE TABLE customeraddress(
        person_address_id int AUTO_INCREMENT,
        customer_id int,
        address_type varchar(32) not null,
        detail_address varchar(256) null,
        province varchar(16) null,
        district varchar(16) null,
        PRIMARY KEY(person_address_id),
        FOREIGN KEY (customer_id) REFERENCES customers(customer_id)
    );

    CREATE TABLE customersbankdetails(
        person_bank_details_id int AUTO_INCREMENT ,
        customer_id int,
        bank_name varchar(64) null,
        account_type varchar(64) null,
        account_number varchar(32) null,
        currency varchar(8) null,
        details varchar(256) null,
        PRIMARY KEY(person_bank_details_id),
        FOREIGN KEY (customer_id) REFERENCES customers(customer_id)
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
        FOREIGN KEY(createby) REFERENCES company_users(user_id),
        FOREIGN KEY(updatedby) REFERENCES company_users(user_id)
    );
 
    CREATE TABLE blocked_nids(
        blocked_nid_id int PRIMARY KEY AUTO_INCREMENT,
        nid_number varchar(128) not null,
        reg_date bigint,
        createby int not null,
        FOREIGN KEY(createby) REFERENCES company_users(user_id)
    );

    -- Customers Account
    CREATE TABLE customer_accounts(
        customer_account_id int PRIMARY KEY AUTO_INCREMENT,
        customer_id int REFERENCES customers(customer_id),
        currency_id int REFERENCES company_currency(company_currency_id),
        debt float default 0,
        crediet float default 0,
        remarks text null
    );

    -- Daily logs data table
    CREATE TABLE logs_data
    (
        logs_data_id int PRIMARY KEY AUTO_INCREMENT,
        user_id INT REFERENCES company_company_users(user_id),
        tble VARCHAR(128) NOT NULL,
        user_action VARCHAR(16) NOT NULL,
        details VARCHAR(1200) NOT NULL,
        action_date bigint
    );

    -- exchange currency
    CREATE TABLE exchange_currency(
        exchange_currency_id int PRIMARY KEY AUTO_INCREMENT,
        debt_currecny_id int REFERENCES company_currency(company_currency_id),
        credit_currecny_id int REFERENCES company_currency(company_currency_id),
        chartofaccount_id int REFERENCES chartofaccount(chartofaccount_id),
        customer_id int REFERENCES customers(customer_id),
        company_id int REFERENCES company(company_id),
        debt_amount float default 0,
        credit_amount float default 0,
        exchange_rate float default 0,
        details TEXT NULL DEFAULT NULL,
        remarks TEXT NULL DEFAULT NULL,
        reg_date bigint,
        createby int REFERENCES company_users(user_id),
        approve int default 0
    );

    -- Money transfer
    CREATE TABLE company_money_transfer(
        company_money_transfer_id int PRIMARY KEY AUTO_INCREMENT,
        company_user_sender int REFERENCES company_users(user_id),
        company_user_receiver int REFERENCES company_users(user_id),
        money_sender int REFERENCES customers(customer_id),
        money_receiver_name varchar(128),
        money_receiver_phone varchar(16),
        amount float default 0,
        reg_date bigint,
        approve int default 0,
        paid_yes int default 0,
        transfer_code int default 0,
        remarks text
    );







