-- Recent Changes
-- exchange_currency customer_id int default 0 REFERENCES customers(customer_id)
-- general_leadger ALTER TABLE `general_leadger` ADD `cleared` INT NOT NULL DEFAULT '0' AFTER `company_id`;
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
    company_id int AUTO_INCREMENT,
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
    companyID int default 0,
    fiscal_year_start date DEFAULT NULL,
    fiscal_year_end date DEFAULT NULL,
    fiscal_year_title varchar(128) NULL,
    reg_date bigint,
    current int default 0
);
CREATE TABLE company_currency (
    company_currency_id int NOT NULL AUTO_INCREMENT,
    companyID int default 0,
    currency varchar(16),
    mainCurrency int default 0,
    PRIMARY KEY (company_currency_id)
);
CREATE TABLE company_currency_conversion(
    company_currency_conversion_id int PRIMARY KEY AUTO_INCREMENT,
    currency_from varchar(8),
    currency_to varchar(8),
    rate float default 0,
    reg_date bigint,
    approve int DEFAULT 1,
    createby int default 0,
    companyID int default 0
);
CREATE TABLE company_contract(
    contractID INT PRIMARY KEY AUTO_INCREMENT,
    companyID int default 0,
    contract_start BIGINT NOT NULL,
    contract_end BIGINT NOT NULL,
    ended INT default 0
);
CREATE TABLE company_model(
    company_model_id INT PRIMARY KEY AUTO_INCREMENT,
    companyID int default 0,
    modelID int default 0
);
-- all users data that can access the system
CREATE TABLE company_users(
    user_id int AUTO_INCREMENT,
    company_id int default 0,
    customer_id int DEFAULT 0,
    username varchar(128) not null,
    password varchar(128) not null,
    block int DEFAULT 0,
    is_online INT,
    PRIMARY key(user_id)
);
-- Company users models
CREATE TABLE company_users_model(
    company_user_model_id int PRIMARY KEY AUTO_INCREMENT,
    user_id int default 0,
    company_model_id int default 0
);
-- Company users rules on model
CREATE TABLE company_users_rules(
    company_user_rule_id int PRIMARY KEY AUTO_INCREMENT,
    user_id int default 0,
    company_model_id int default 0
);
-- Approval table for company users
CREATE TABLE company_users_approval(
    company_user_approval_id int AUTO_INCREMENT,
    user_id int default 0,
    company_model_id int default 0,
    PRIMARY key(company_user_approval_id)
);
-- login logs
CREATE TABLE login_log (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user int default 0,
    user_action VARCHAR(16) NOT NULL,
    action_date BIGINT NOT NULL
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
    parentID int DEFAULT 0,
    company_id int default 0,
    PRIMARY key(account_catagory_id)
);
-- chart of account
CREATE TABLE chartofaccount(
    chartofaccount_id int AUTO_INCREMENT,
    account_catagory int not null,
    account_name varchar(128) not null,
    account_number VARCHAR(128) null,
    initial_ammount float default 0,
    account_type varchar(32) null default 'NA',
    -- account type
    -- payable
    -- receivable
    -- NA
    currency varchar(8),
    reg_date bigint,
    company_id int default 0,
    createby int not null,
    approve int DEFAULT 1,
    note text null,
    account_kind VARCHAR(64),
    cutomer_id int DEFAULT 0,
    PRIMARY key(chartofaccount_id)
);
-- General Leadger table
CREATE TABLE general_leadger(
    leadger_id int AUTO_INCREMENT,
    recievable_id int null,
    payable_id int null,
    currency_id int default 0,
    remarks varchar(256),
    company_financial_term_id int default 0,
    reg_date BIGINT,
    currency_rate FLOAT DEFAULT 0,
    approved int DEFAULT 0,
    createby int default 0,
    updatedby int default 0,
    op_type varchar(128) not null,
    cleared INT NOT NULL DEFAULT 0,
    company_id int REFERENCES company(company_id),
    PRIMARY key(leadger_id),
    FOREIGN key(recievable_id) REFERENCES chartofaccount(chartofaccount_id),
    FOREIGN key(payable_id) REFERENCES chartofaccount(chartofaccount_id)
);
-- Accounts balance or money
CREATE TABLE account_money(
    account_money_id int PRIMARY key AUTO_INCREMENT,
    account_id int default 0,
    leadger_ID int default 0,
    amount float default 0,
    ammount_type varchar(64),
    detials text null,
    company_id int REFERENCES company(company_id),
    temp int default 0
);
-- Persons/Customer Table
CREATE TABLE customers(
    customer_id int AUTO_INCREMENT,
    company_id int not null,
    fname varchar(32) not null,
    lname varchar(32) not null,
    alies_name varchar(128) not null,
    gender varchar(8) null,
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
    createby int default 0,
    approve int DEFAULT 1,
    details text null,
    PRIMARY KEY(customer_id)
);
-- Customers address table
CREATE TABLE customeraddress(
    person_address_id int AUTO_INCREMENT,
    customer_id int default 0,
    address_type varchar(32) not null,
    detail_address varchar(256) null,
    province varchar(16) null,
    district varchar(16) null,
    PRIMARY KEY(person_address_id)
);
CREATE TABLE customersbankdetails(
    person_bank_details_id int AUTO_INCREMENT,
    customer_id int default 0,
    bank_name varchar(64) null,
    account_number varchar(32) null,
    currency varchar(8) null,
    details varchar(256) null,
    PRIMARY KEY(person_bank_details_id)
);
-- PERSON DOCUMENTS ATTACHMENT
CREATE TABLE customersattacment(
    person_attachment_id int AUTO_INCREMENT,
    person_id int default 0,
    attachment_type varchar(128) null,
    attachment_name varchar(128) null,
    details varchar(128) null,
    createby int default 0,
    updatedby int default 0,
    PRIMARY KEY(person_attachment_id)
);
-- Customers note
CREATE TABLE customer_notes(
    note_id int PRIMARY KEY AUTO_INCREMENT,
    customer_id int default 0,
    title VARCHAR(255),
    details text,
    reg_date bigint
);
-- Customers note
CREATE TABLE customer_reminder(
    reminder_id int PRIMARY KEY AUTO_INCREMENT,
    customer_id int default 0,
    title VARCHAR(255),
    details text,
    remindate date,
    reg_date bigint
);
-- Create table for saraf login
CREATE TABLE saraf_login(
    id int AUTO_INCREMENT,
    customer_id int default 0,
    username varchar(128) not null,
    password varchar(128) not null,
    is_online INT,
    PRIMARY key(id)
);
CREATE TABLE blocked_nids(
    blocked_nid_id int PRIMARY KEY AUTO_INCREMENT,
    nid_number varchar(128) not null,
    reg_date bigint,
    createby int default 0
);
-- Customers Account
CREATE TABLE customer_accounts(
    customer_account_id int PRIMARY KEY AUTO_INCREMENT,
    customer_id int default 0,
    currency_id int default 0,
    debt float default 0,
    crediet float default 0,
    remarks text null
);
-- Daily logs data table
CREATE TABLE logs_data (
    logs_data_id int PRIMARY KEY AUTO_INCREMENT,
    user_id INT REFERENCES company_users(user_id),
    tble VARCHAR(128) NOT NULL,
    user_action VARCHAR(16) NOT NULL,
    details VARCHAR(1200) NOT NULL,
    action_date bigint
);
-- exchange currency
CREATE TABLE exchange_currency(
    exchange_currency_id int PRIMARY KEY AUTO_INCREMENT,
    debt_currecny_id int default 0,
    credit_currecny_id int default 0,
    chartofaccount_id int default 0,
    customer_id int default 0,
    company_id int REFERENCES company(company_id),
    debt_amount float default 0,
    credit_amount float default 0,
    exchange_rate float default 0,
    details TEXT NULL DEFAULT NULL,
    remarks TEXT NULL DEFAULT NULL,
    reg_date bigint,
    createby int default 0,
    approve int default 0
);
-- Money transfer
CREATE TABLE company_money_transfer(
    company_money_transfer_id int PRIMARY KEY AUTO_INCREMENT,
    company_user_sender int default 0,
    company_user_sender_commission float default 0,
    company_user_receiver int default 0,
    company_user_receiver_commission float default 0,
    money_sender int default 0,
    money_receiver int default 0,
    amount float default 0,
    currency varchar(16) null,
    reg_date bigint,
    approve int default 0,
    paid int default 0,
    transfer_code int default 0,
    voucher_code varchar(64) null,
    details text,
    locked int default 0,
    transfer_type varchar(8),
    company_id int REFERENCES company(company_id),
    leadger_id int default 0
);
-- website messges
CREATE TABLE website_message(
    msg_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    details text,
    time BIGINT
);
-- website FAQs
CREATE TABLE website_faq(
    id INT AUTO_INCREMENT PRIMARY KEY,
    question VARCHAR(255),
    answer text,
    time BIGINT
);
CREATE TABLE dailycustomersattacment(
    attachment_id int AUTO_INCREMENT,
    cus_id int default 0,
    attachment_name varchar(128) null,
    PRIMARY KEY(attachment_id)
);
CREATE TABLE companyattacment(
    attachment_id int AUTO_INCREMENT,
    company_id int default 0,
    attachment_name varchar(128) null,
    PRIMARY KEY(attachment_id)
);

CREATE TRIGGER general_leadger_INSERT AFTER INSERT ON general_leadger FOR EACH ROW 
INSERT INTO logs_data 
SET user_id = NEW.createby,
tble = '$triger',
user_action = '$action',
details = CONCAT(NEW.op_type,' has been added by ',NEW.createby),
action_date = NOW();

