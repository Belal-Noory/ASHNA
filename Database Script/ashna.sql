-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 30, 2022 at 12:29 PM
-- Server version: 8.0.21
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ashna`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_catagory`
--

DROP TABLE IF EXISTS `account_catagory`;
CREATE TABLE IF NOT EXISTS `account_catagory` (
  `account_catagory_id` int NOT NULL AUTO_INCREMENT,
  `catagory` varchar(32) COLLATE utf8_general_mysql500_ci NOT NULL,
  PRIMARY KEY (`account_catagory_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `account_catagory`
--

INSERT INTO `account_catagory` (`account_catagory_id`, `catagory`) VALUES
(1, 'assets'),
(2, 'expenses'),
(3, 'liablity'),
(4, 'revenue'),
(5, 'capital');

-- --------------------------------------------------------

--
-- Table structure for table `account_money`
--

DROP TABLE IF EXISTS `account_money`;
CREATE TABLE IF NOT EXISTS `account_money` (
  `account_money_id` int NOT NULL AUTO_INCREMENT,
  `account_id` int DEFAULT NULL,
  `leadger_ID` int DEFAULT NULL,
  `amount` float DEFAULT '0',
  `ammount_type` varchar(64) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `company_id` int DEFAULT NULL,
  PRIMARY KEY (`account_money_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blocked_nids`
--

DROP TABLE IF EXISTS `blocked_nids`;
CREATE TABLE IF NOT EXISTS `blocked_nids` (
  `blocked_nid_id` int NOT NULL AUTO_INCREMENT,
  `nid_number` varchar(128) COLLATE utf8_general_mysql500_ci NOT NULL,
  `reg_date` bigint DEFAULT NULL,
  `createby` int NOT NULL,
  PRIMARY KEY (`blocked_nid_id`),
  KEY `createby` (`createby`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chartofaccount`
--

DROP TABLE IF EXISTS `chartofaccount`;
CREATE TABLE IF NOT EXISTS `chartofaccount` (
  `chartofaccount_id` int NOT NULL AUTO_INCREMENT,
  `account_catagory` int NOT NULL,
  `account_name` varchar(128) COLLATE utf8_general_mysql500_ci NOT NULL,
  `account_number` varchar(128) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `initial_ammount` float DEFAULT '0',
  `account_type` varchar(32) COLLATE utf8_general_mysql500_ci DEFAULT 'NA',
  `currency` varchar(8) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `reg_date` bigint DEFAULT NULL,
  `company_id` int DEFAULT NULL,
  `createby` int NOT NULL,
  `approve` int DEFAULT '1',
  `note` text COLLATE utf8_general_mysql500_ci,
  `account_kind` varchar(64) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `cutomer_id` int DEFAULT '0',
  PRIMARY KEY (`chartofaccount_id`),
  KEY `account_catagory` (`account_catagory`),
  KEY `createby` (`createby`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `chartofaccount`
--

INSERT INTO `chartofaccount` (`chartofaccount_id`, `account_catagory`, `account_name`, `account_number`, `initial_ammount`, `account_type`, `currency`, `reg_date`, `company_id`, `createby`, `approve`, `note`, `account_kind`, `cutomer_id`) VALUES
(9, 3, '', '123456', 0, 'NA', 'AFN', 1653818621, 1, 1, 1, '', 'Customer', 3),
(4, 3, 'Test Saif', NULL, 0, 'NA', 'AFN', 1653816642, 1, 1, 1, 'Test Saif', 'Saif', 0),
(8, 3, 'Test Bank', 'Test Bank', 0, 'Payable', 'AFN', 1653816881, 1, 1, 1, 'Test Bank', 'Bank', 0);

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

DROP TABLE IF EXISTS `company`;
CREATE TABLE IF NOT EXISTS `company` (
  `company_id` int NOT NULL AUTO_INCREMENT,
  `company_name` varchar(128) COLLATE utf8_general_mysql500_ci NOT NULL,
  `legal_name` varchar(128) COLLATE utf8_general_mysql500_ci NOT NULL,
  `company_type` varchar(128) COLLATE utf8_general_mysql500_ci NOT NULL,
  `license_number` varchar(64) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `TIN` varchar(64) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `register_number` varchar(64) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `country` varchar(64) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `province` varchar(64) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `district` varchar(64) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `postal_code` varchar(64) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `phone` varchar(64) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `fax` varchar(64) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `addres` varchar(64) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `website` varchar(64) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `email` varchar(64) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `disable` int NOT NULL DEFAULT '0',
  `reg_date` bigint DEFAULT NULL,
  PRIMARY KEY (`company_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`company_id`, `company_name`, `legal_name`, `company_type`, `license_number`, `TIN`, `register_number`, `country`, `province`, `district`, `postal_code`, `phone`, `fax`, `addres`, `website`, `email`, `disable`, `reg_date`) VALUES
(1, 'اشنا', 'اشنا', 'صرافی', '123456', '654321', '1212', 'افغانستان', 'کابل', 'کابل', '1302', '0797160881', 'fax@ashna', '', 'ashna.com', 'ashna@gmail.com', 0, 1653192462);

-- --------------------------------------------------------

--
-- Table structure for table `company_contract`
--

DROP TABLE IF EXISTS `company_contract`;
CREATE TABLE IF NOT EXISTS `company_contract` (
  `contractID` int NOT NULL AUTO_INCREMENT,
  `companyID` int DEFAULT NULL,
  `contract_start` bigint NOT NULL,
  `contract_end` bigint NOT NULL,
  PRIMARY KEY (`contractID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `company_contract`
--

INSERT INTO `company_contract` (`contractID`, `companyID`, `contract_start`, `contract_end`) VALUES
(1, 1, 1653192462, 1666137600);

-- --------------------------------------------------------

--
-- Table structure for table `company_currency`
--

DROP TABLE IF EXISTS `company_currency`;
CREATE TABLE IF NOT EXISTS `company_currency` (
  `company_currency_id` int NOT NULL AUTO_INCREMENT,
  `companyID` int DEFAULT NULL,
  `currency` varchar(16) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `mainCurrency` int DEFAULT '0',
  PRIMARY KEY (`company_currency_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `company_currency`
--

INSERT INTO `company_currency` (`company_currency_id`, `companyID`, `currency`, `mainCurrency`) VALUES
(1, 1, 'AFN', 1),
(2, 1, 'BGN', 0);

-- --------------------------------------------------------

--
-- Table structure for table `company_currency_conversion`
--

DROP TABLE IF EXISTS `company_currency_conversion`;
CREATE TABLE IF NOT EXISTS `company_currency_conversion` (
  `company_currency_conversion_id` int NOT NULL AUTO_INCREMENT,
  `currency_from` varchar(8) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `currency_to` varchar(8) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `rate` float DEFAULT '0',
  `reg_date` bigint DEFAULT NULL,
  `approve` int DEFAULT '1',
  `createby` int DEFAULT NULL,
  `companyID` int DEFAULT NULL,
  PRIMARY KEY (`company_currency_conversion_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `company_currency_conversion`
--

INSERT INTO `company_currency_conversion` (`company_currency_conversion_id`, `currency_from`, `currency_to`, `rate`, `reg_date`, `approve`, `createby`, `companyID`) VALUES
(3, 'BGN', 'AFN', 1000, 1653815661, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `company_financial_terms`
--

DROP TABLE IF EXISTS `company_financial_terms`;
CREATE TABLE IF NOT EXISTS `company_financial_terms` (
  `term_id` int NOT NULL AUTO_INCREMENT,
  `companyID` int DEFAULT NULL,
  `fiscal_year_start` date DEFAULT NULL,
  `fiscal_year_end` date DEFAULT NULL,
  `fiscal_year_title` varchar(128) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `reg_date` bigint DEFAULT NULL,
  `current` int DEFAULT '0',
  PRIMARY KEY (`term_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company_model`
--

DROP TABLE IF EXISTS `company_model`;
CREATE TABLE IF NOT EXISTS `company_model` (
  `company_model_id` int NOT NULL AUTO_INCREMENT,
  `companyID` int DEFAULT NULL,
  `modelID` int DEFAULT NULL,
  PRIMARY KEY (`company_model_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company_money_transfer`
--

DROP TABLE IF EXISTS `company_money_transfer`;
CREATE TABLE IF NOT EXISTS `company_money_transfer` (
  `company_money_transfer_id` int NOT NULL AUTO_INCREMENT,
  `company_user_sender` int DEFAULT NULL,
  `company_user_receiver` int DEFAULT NULL,
  `money_sender` int DEFAULT NULL,
  `money_receiver_name` varchar(128) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `money_receiver_phone` varchar(16) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `amount` float DEFAULT '0',
  `reg_date` bigint DEFAULT NULL,
  `approve` int DEFAULT '0',
  `paid_yes` int DEFAULT '0',
  `transfer_code` int DEFAULT '0',
  `remarks` text COLLATE utf8_general_mysql500_ci,
  PRIMARY KEY (`company_money_transfer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company_users`
--

DROP TABLE IF EXISTS `company_users`;
CREATE TABLE IF NOT EXISTS `company_users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `company_id` int NOT NULL,
  `customer_id` int DEFAULT NULL,
  `username` varchar(128) COLLATE utf8_general_mysql500_ci NOT NULL,
  `password` varchar(128) COLLATE utf8_general_mysql500_ci NOT NULL,
  `fname` varchar(64) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `lname` varchar(64) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `is_online` int DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `company_id` (`company_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `company_users`
--

INSERT INTO `company_users` (`user_id`, `company_id`, `customer_id`, `username`, `password`, `fname`, `lname`, `is_online`) VALUES
(1, 1, 1, 'belalnoory2@gmail.com', '143kakaw', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `company_users_approval`
--

DROP TABLE IF EXISTS `company_users_approval`;
CREATE TABLE IF NOT EXISTS `company_users_approval` (
  `company_user_approval_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `company_model_id` int DEFAULT NULL,
  PRIMARY KEY (`company_user_approval_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company_users_model`
--

DROP TABLE IF EXISTS `company_users_model`;
CREATE TABLE IF NOT EXISTS `company_users_model` (
  `company_user_model_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `company_model_id` int DEFAULT NULL,
  PRIMARY KEY (`company_user_model_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company_users_rules`
--

DROP TABLE IF EXISTS `company_users_rules`;
CREATE TABLE IF NOT EXISTS `company_users_rules` (
  `company_user_rule_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `company_model_id` int DEFAULT NULL,
  `insert_op` int DEFAULT '0',
  `update_op` int DEFAULT '0',
  `delete_op` int DEFAULT '0',
  PRIMARY KEY (`company_user_rule_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customeraddress`
--

DROP TABLE IF EXISTS `customeraddress`;
CREATE TABLE IF NOT EXISTS `customeraddress` (
  `person_address_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int DEFAULT NULL,
  `address_type` varchar(32) COLLATE utf8_general_mysql500_ci NOT NULL,
  `detail_address` varchar(256) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `province` varchar(16) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `district` varchar(16) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  PRIMARY KEY (`person_address_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `customeraddress`
--

INSERT INTO `customeraddress` (`person_address_id`, `customer_id`, `address_type`, `detail_address`, `province`, `district`) VALUES
(1, 2, 'Current', 'Sare dawra', 'balkh', 'mazar-e-sharef'),
(2, 2, 'Permenant', 'Omarkhail', 'Kunduz', 'Ali Abad'),
(3, 3, 'Current', 'Sare dawra', 'teset', 'teset');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `customer_id` int NOT NULL AUTO_INCREMENT,
  `company_id` int NOT NULL,
  `fname` varchar(32) COLLATE utf8_general_mysql500_ci NOT NULL,
  `lname` varchar(32) COLLATE utf8_general_mysql500_ci NOT NULL,
  `alies_name` varchar(128) COLLATE utf8_general_mysql500_ci NOT NULL,
  `gender` varchar(8) COLLATE utf8_general_mysql500_ci NOT NULL,
  `email` varchar(64) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `NID` varchar(128) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `TIN` varchar(32) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `office_address` varchar(128) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `office_details` varchar(256) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `official_phone` varchar(16) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `personal_phone` varchar(16) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `personal_phone_second` varchar(16) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `fax` varchar(16) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `website` varchar(64) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `note` varchar(256) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `person_type` varchar(64) COLLATE utf8_general_mysql500_ci NOT NULL,
  `added_date` bigint NOT NULL,
  `createby` int NOT NULL,
  `approve` int DEFAULT '1',
  PRIMARY KEY (`customer_id`),
  KEY `createby` (`createby`),
  KEY `company_id` (`company_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `company_id`, `fname`, `lname`, `alies_name`, `gender`, `email`, `NID`, `TIN`, `office_address`, `office_details`, `official_phone`, `personal_phone`, `personal_phone_second`, `fax`, `website`, `note`, `person_type`, `added_date`, `createby`, `approve`) VALUES
(1, 1, 'Belal', 'Noory', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', 1653192479, 0, 1),
(2, 1, 'Belal', 'Noory', 'Noory jan', 'Male', 'belalnoory2@gmail.com', '1212', '1212', 'Sare dawra', 'Sare dawra', '0789617824', '0789617824', '0789617824', 'faxw1212', 'belal.com', 'Noory is the owner of the a software company', 'Saraf', 1653204244, 1, 1),
(3, 1, 'teset', 'teset', 'teset', 'Male', 'belalnoory2@gmail.com', 'teset', 'teset', 'Sare dawra', 'teset', '0789617824', '0789617824', '0789617824', 'teset', 'teset.com', 'AFN', 'Saraf', 1653818621, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `customersattacment`
--

DROP TABLE IF EXISTS `customersattacment`;
CREATE TABLE IF NOT EXISTS `customersattacment` (
  `person_attachment_id` int NOT NULL AUTO_INCREMENT,
  `person_id` int DEFAULT NULL,
  `attachment_type` varchar(128) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `attachment_name` varchar(128) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `details` varchar(128) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `createby` int NOT NULL,
  `updatedby` int NOT NULL,
  PRIMARY KEY (`person_attachment_id`),
  KEY `person_id` (`person_id`),
  KEY `createby` (`createby`),
  KEY `updatedby` (`updatedby`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customersbankdetails`
--

DROP TABLE IF EXISTS `customersbankdetails`;
CREATE TABLE IF NOT EXISTS `customersbankdetails` (
  `person_bank_details_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int DEFAULT NULL,
  `bank_name` varchar(64) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `account_type` varchar(64) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `account_number` varchar(32) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `currency` varchar(8) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `details` varchar(256) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  PRIMARY KEY (`person_bank_details_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `customersbankdetails`
--

INSERT INTO `customersbankdetails` (`person_bank_details_id`, `customer_id`, `bank_name`, `account_type`, `account_number`, `currency`, `details`) VALUES
(1, 2, 'AIB', 'AFN', '123456678', 'AFN', 'teste');

-- --------------------------------------------------------

--
-- Table structure for table `customer_accounts`
--

DROP TABLE IF EXISTS `customer_accounts`;
CREATE TABLE IF NOT EXISTS `customer_accounts` (
  `customer_account_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int DEFAULT NULL,
  `currency_id` int DEFAULT NULL,
  `debt` float DEFAULT '0',
  `crediet` float DEFAULT '0',
  `remarks` text COLLATE utf8_general_mysql500_ci,
  PRIMARY KEY (`customer_account_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `customer_accounts`
--

INSERT INTO `customer_accounts` (`customer_account_id`, `customer_id`, `currency_id`, `debt`, `crediet`, `remarks`) VALUES
(1, 2, 1, 100, 0, 'testing');

-- --------------------------------------------------------

--
-- Table structure for table `customer_notes`
--

DROP TABLE IF EXISTS `customer_notes`;
CREATE TABLE IF NOT EXISTS `customer_notes` (
  `note_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `details` text COLLATE utf8_general_mysql500_ci,
  `reg_date` bigint DEFAULT NULL,
  PRIMARY KEY (`note_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `customer_notes`
--

INSERT INTO `customer_notes` (`note_id`, `customer_id`, `title`, `details`, `reg_date`) VALUES
(5, 2, 'setset', 'stesett', 1653397675),
(4, 2, 'test', 'setsetset', 1653397672),
(6, 2, 'sasadf', 'sadfsadf', 1653397678);

-- --------------------------------------------------------

--
-- Table structure for table `customer_reminder`
--

DROP TABLE IF EXISTS `customer_reminder`;
CREATE TABLE IF NOT EXISTS `customer_reminder` (
  `reminder_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `details` text COLLATE utf8_general_mysql500_ci,
  `remindate` date DEFAULT NULL,
  `reg_date` bigint DEFAULT NULL,
  PRIMARY KEY (`reminder_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `customer_reminder`
--

INSERT INTO `customer_reminder` (`reminder_id`, `customer_id`, `title`, `details`, `remindate`, `reg_date`) VALUES
(2, 2, 'test', 'testsetset', '2022-06-03', 1653397244),
(3, 2, 'sdfgsdfg', 'sdfgsdfg', '2022-05-13', 1653397251),
(4, 2, 'sdfgsdgf', 'sdfgsdfg', '2022-06-11', 1653397257);

-- --------------------------------------------------------

--
-- Table structure for table `exchange_currency`
--

DROP TABLE IF EXISTS `exchange_currency`;
CREATE TABLE IF NOT EXISTS `exchange_currency` (
  `exchange_currency_id` int NOT NULL AUTO_INCREMENT,
  `debt_currecny_id` int DEFAULT NULL,
  `credit_currecny_id` int DEFAULT NULL,
  `chartofaccount_id` int DEFAULT NULL,
  `customer_id` int DEFAULT NULL,
  `company_id` int DEFAULT NULL,
  `debt_amount` float DEFAULT '0',
  `credit_amount` float DEFAULT '0',
  `exchange_rate` float DEFAULT '0',
  `details` text COLLATE utf8_general_mysql500_ci,
  `remarks` text COLLATE utf8_general_mysql500_ci,
  `reg_date` bigint DEFAULT NULL,
  `createby` int DEFAULT NULL,
  `approve` int DEFAULT '0',
  PRIMARY KEY (`exchange_currency_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `exchange_currency`
--

INSERT INTO `exchange_currency` (`exchange_currency_id`, `debt_currecny_id`, `credit_currecny_id`, `chartofaccount_id`, `customer_id`, `company_id`, `debt_amount`, `credit_amount`, `exchange_rate`, `details`, `remarks`, `reg_date`, `createby`, `approve`) VALUES
(1, 1, 2, 1, 2, NULL, 8500, 100, 89, 'changed AFN to Dollar', NULL, 1653366430, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `general_leadger`
--

DROP TABLE IF EXISTS `general_leadger`;
CREATE TABLE IF NOT EXISTS `general_leadger` (
  `leadger_id` int NOT NULL AUTO_INCREMENT,
  `recievable_id` int DEFAULT NULL,
  `payable_id` int DEFAULT NULL,
  `currency_id` int DEFAULT NULL,
  `remarks` varchar(256) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `company_financial_term_id` int DEFAULT NULL,
  `reg_date` bigint DEFAULT NULL,
  `currency_rate` float DEFAULT '0',
  `approved` int DEFAULT '0',
  `createby` int NOT NULL,
  `updatedby` int NOT NULL,
  `op_type` varchar(128) COLLATE utf8_general_mysql500_ci NOT NULL,
  `company_id` int DEFAULT NULL,
  PRIMARY KEY (`leadger_id`),
  KEY `recievable_id` (`recievable_id`),
  KEY `payable_id` (`payable_id`),
  KEY `createby` (`createby`),
  KEY `updatedby` (`updatedby`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `general_leadger`
--

INSERT INTO `general_leadger` (`leadger_id`, `recievable_id`, `payable_id`, `currency_id`, `remarks`, `company_financial_term_id`, `reg_date`, `currency_rate`, `approved`, `createby`, `updatedby`, `op_type`, `company_id`) VALUES
(1, 2, 1, 1, 'This is a test transfer', NULL, 1653799571, 0, 1, 1, 0, 'Bank Transfer', 1),
(2, 2, 1, 1, 'This is a test transfer', 0, 1653800684, 0, 1, 1, 0, 'Bank Transfer', 1);

-- --------------------------------------------------------

--
-- Table structure for table `login_log`
--

DROP TABLE IF EXISTS `login_log`;
CREATE TABLE IF NOT EXISTS `login_log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user` int DEFAULT NULL,
  `user_action` varchar(16) COLLATE utf8_general_mysql500_ci NOT NULL,
  `action_date` bigint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `login_log_created` (`user`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `login_log`
--

INSERT INTO `login_log` (`id`, `user`, `user_action`, `action_date`) VALUES
(1, NULL, 'login', 1653191749),
(2, NULL, 'login', 1653191752),
(3, NULL, 'login', 1653191887),
(4, NULL, 'login', 1653192235),
(5, 1, 'login', 1653192486),
(6, 1, 'login', 1653277382),
(7, 1, 'login', 1653364462),
(8, 1, 'login', 1653392136),
(9, 1, 'login', 1653452076),
(10, 1, 'login', 1653481535),
(11, 1, 'login', 1653538163),
(12, 1, 'login', 1653798434),
(13, 1, 'login', 1653809748),
(14, 1, 'login', 1653888681);

-- --------------------------------------------------------

--
-- Table structure for table `logs_data`
--

DROP TABLE IF EXISTS `logs_data`;
CREATE TABLE IF NOT EXISTS `logs_data` (
  `logs_data_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `tble` varchar(128) COLLATE utf8_general_mysql500_ci NOT NULL,
  `user_action` varchar(16) COLLATE utf8_general_mysql500_ci NOT NULL,
  `details` varchar(1200) COLLATE utf8_general_mysql500_ci NOT NULL,
  `action_date` bigint DEFAULT NULL,
  PRIMARY KEY (`logs_data_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Table structure for table `saraf_login`
--

DROP TABLE IF EXISTS `saraf_login`;
CREATE TABLE IF NOT EXISTS `saraf_login` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int DEFAULT NULL,
  `username` varchar(128) COLLATE utf8_general_mysql500_ci NOT NULL,
  `password` varchar(128) COLLATE utf8_general_mysql500_ci NOT NULL,
  `is_online` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_models`
--

DROP TABLE IF EXISTS `system_models`;
CREATE TABLE IF NOT EXISTS `system_models` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name_dari` varchar(128) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `name_english` varchar(128) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `name_pashto` varchar(128) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `icon` varchar(128) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `color` varchar(64) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `url` varchar(128) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `sort_order` int DEFAULT NULL,
  `parentID` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `system_models`
--

INSERT INTO `system_models` (`id`, `name_dari`, `name_english`, `name_pashto`, `icon`, `color`, `url`, `sort_order`, `parentID`) VALUES
(1, 'اشخاص', 'Contacts', 'اړیکې', 'la-users', '', '', 1, 0),
(2, 'شخص جدید', 'New Contact', ' نوی اړیکې', '', '', 'NewContact.php', 1, 1),
(3, 'لیست اشخاص', 'Contact List', 'اړیکې لیست', '', '', 'ContactList.php', 2, 1),
(4, 'رسید و عواید', 'Receipt & Revenue', 'رسید او عواید', 'la-coins', '', '', 2, 0),
(5, 'رسید جدید', 'New Receipt', 'نوی رسید', '', '', 'NewReceipt.php', 1, 4),
(6, 'لیست رسید', 'Receipt List', ' د رسید لیست', '', '', 'Receipts.php', 2, 4),
(7, 'انتقال خارجی', 'Out Transference', 'بهر لیږد', '', '', 'NewOutTransference.php', 3, 4),
(8, 'لیست انتقال خارجی', 'Out Transference list', 'بهر لیږد لیست', '', '', 'OutTransferences.php', 4, 4),
(9, 'عواید', 'Revenue', 'عواید', '', '', 'NewRevenue.php', 5, 4),
(10, 'لیست عواید', 'Revenue List', 'عواید لیست', '', '', 'Revenues.php', 6, 4),
(11, 'پرداخت و هزینه', 'Payment & Expanse', 'تادیه او لګښت', 'la-wallet', '', '', 3, 0),
(12, 'پرداخت جدید', 'New Payment', 'نوې تادیه', '', '', 'NewPayment.php', 1, 11),
(13, 'لیست پرداخت', 'Payment List', ' د تادیه لیست', '', '', 'Payments.php', 2, 11),
(14, 'انتقال داخلی', 'In Transference', 'دننه لیږد', '', '', 'NewInTransference.php', 3, 11),
(15, 'لیست انتقال داخلی', 'In Transference list', 'دننه لیږد لیست', '', '', 'InTransferences.php', 4, 11),
(16, 'درآمد', 'Income', 'عاید', '', '', 'NewIncome.php', 5, 11),
(17, 'لیست درآمد', 'Income List', 'عاید لیست', '', '', 'Incomes.php', 6, 11),
(18, 'بانکداری', 'Banking', 'بانکداري', 'la-landmark', '', '', 4, 0),
(19, 'بانک جدید', 'New Bank', 'نوې بانک', '', '', 'NewBank.php', 1, 18),
(20, 'لیست بانک', 'Bank List', ' بانک لیست', '', '', 'Banks.php', 2, 18),
(21, 'سیف جدید', 'New Saif', 'نوی سیف', '', '', 'NewSaif.php', 3, 18),
(22, 'لیست سیف', 'Saif list', 'د سیف لیست', '', '', 'Saifs.php', 4, 18),
(23, 'انتقال', 'Transfer', 'لیږد', '', '', 'Transfer.php', 5, 18),
(24, 'لیست انتقال', 'Transfer List', 'لیږد لیست', '', '', 'Transfers.php', 6, 18),
(25, 'تبادله', 'Exchange', 'تبادله', '', '', 'NewExchange.php', 7, 18),
(26, 'لیست تبادله', 'Exchange List', 'تبادله لیست', '', '', 'Exchanges.php', 8, 18),
(27, 'حسابداری', 'Accounting', 'محاسبه', 'la-folder-open', '', '', 5, 0),
(28, 'سند جدید', 'New Document', 'سند جدید', '', '', 'NewDocument.php', 1, 27),
(29, 'لیست اسناد', 'Documents List', ' سندو لیست', '', '', 'Documents.php', 2, 27),
(30, 'ورودی های تبادل', 'Exchange Entries', 'د تبادلې ننوتل', '', '', 'NewExchangeEntries.php', 3, 27),
(31, 'لیست ورودی های تبادل', 'Exchange Conversion', 'د تبادلې ننوتل لیست', '', '', 'ExchangeConversion.php', 4, 27),
(32, 'ورودی های موجودی مخاطبین', 'Contact Balance Entries', 'د اړیکو بیلانس داخلونه', '', '', 'ContactBalanceEntries.php', 5, 27),
(33, 'سند حقوق و دستمزد', 'Payroll', 'د معاشونو سند', '', '', 'Payroll.php', 6, 27),
(34, 'نمودار حساب', 'Chart Of Accounts', 'د حسابونو چارټ', '', '', 'ChartOfAccounts.php', 7, 27),
(35, 'پایان سال مالی', 'Fiscal year Close', 'د مالي کال پای', '', '', 'FiscalyearClose.php', 8, 27),
(36, 'بیلانس افتتاح', 'Opening Balance', 'د پرانیستلو بیلانس', '', '', 'OpeningBalance.php', 9, 27),
(37, 'گزارش ها', 'Reports', 'راپورونه', 'la-chart-pie', '', '', 6, 0),
(38, 'همه گزارش ها', 'All Reports', 'ټول راپورونه', '', '', 'AllReports.php', 1, 37),
(39, 'تنظیمات', 'Settings', 'ترتیبات', 'la-cog', '', '', 7, 0),
(40, 'نرخ ارز زنده', 'Live Exchange Rates', 'ژوندۍ تبادلې نرخونه', '', '', 'LiveExchangeRates.php', 1, 39),
(41, 'مدیریت کاربر', 'User Management', 'د کارن مدیریت', '', '', 'UserManagement.php', 2, 39),
(42, 'تنظیمات چاپ', 'Print Settings', 'د چاپ ترتیبات', '', '', 'PrintSettings.php', 2, 39);

-- --------------------------------------------------------

--
-- Table structure for table `sys_admin`
--

DROP TABLE IF EXISTS `sys_admin`;
CREATE TABLE IF NOT EXISTS `sys_admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  `pass` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  `fname` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  `lname` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL,
  `created` bigint NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `sys_admin`
--

INSERT INTO `sys_admin` (`id`, `email`, `pass`, `fname`, `lname`, `created`) VALUES
(1, 'belalnoory2@gmail.com', '143kakaw', 'Belal', 'Noory', 1651938500);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
