-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 15, 2022 at 04:13 PM
-- Server version: 5.7.31
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
-- Table structure for table `company`
--

DROP TABLE IF EXISTS `company`;
CREATE TABLE IF NOT EXISTS `company` (
  `company_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `maincurrency` varchar(64) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `fiscal_year_start` date DEFAULT NULL,
  `fiscal_year_end` date DEFAULT NULL,
  `fiscal_year_title` varchar(128) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  PRIMARY KEY (`company_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`company_id`, `company_name`, `legal_name`, `company_type`, `license_number`, `TIN`, `register_number`, `country`, `province`, `district`, `postal_code`, `phone`, `fax`, `addres`, `website`, `email`, `maincurrency`, `fiscal_year_start`, `fiscal_year_end`, `fiscal_year_title`) VALUES
(1, 'آشنا', 'آشنا', 'شرکت', '۱۳۲۲۴', '۲۳۴۲۳۴۲۳۴', '۲۳۴۲۳۴', 'افغانستان', 'کابل', 'کابل', 'ashna@gmail.com', '3501', '0797160881', 'ashna1212', 'www.ashna.com', 'سرای مندوی کابل', 'AFA', '2022-05-13', '2022-10-19', 'سال مالی 2022'),
(19, 'khan', 'khan', 'شرکت', 'khan', 'khan', 'khan', 'افغانستان', 'khan', 'khan', 'khan@gmail.com', 'khan', '324345456', '', '', '', 'BDT', '2022-05-15', '2022-06-09', ''),
(18, 'teset', 'teset', 'شرکت', 'teset', 'teset', 'teset', 'افغانستان', 'teset', 'teset', 'teset@gmail.com', 'teset', '234345345456', 'teset', '', '', 'BDT', '2022-05-15', '2022-06-10', ''),
(17, 'teset', 'teset', 'شرکت', 'teset', 'teset', 'teset', 'افغانستان', 'teset', 'teset', 'teset@gmail.com', 'teset', '234345345456', 'teset', '', '', 'BDT', '2022-05-15', '2022-06-10', '');

-- --------------------------------------------------------

--
-- Table structure for table `company_currency`
--

DROP TABLE IF EXISTS `company_currency`;
CREATE TABLE IF NOT EXISTS `company_currency` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `companyID` int(11) DEFAULT NULL,
  `currency` varchar(16) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `company_currency`
--

INSERT INTO `company_currency` (`ID`, `companyID`, `currency`) VALUES
(15, 19, 'BHD'),
(14, 19, 'BDT'),
(13, 18, 'BWP'),
(12, 18, 'BDT'),
(11, 17, 'BWP'),
(10, 17, 'BDT'),
(16, 19, 'BRL');

-- --------------------------------------------------------

--
-- Table structure for table `sys_admin`
--

DROP TABLE IF EXISTS `sys_admin`;
CREATE TABLE IF NOT EXISTS `sys_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(64) COLLATE utf8_general_mysql500_ci NOT NULL,
  `pass` varchar(128) COLLATE utf8_general_mysql500_ci NOT NULL,
  `fname` varchar(64) COLLATE utf8_general_mysql500_ci NOT NULL,
  `lname` varchar(64) COLLATE utf8_general_mysql500_ci NOT NULL,
  `created` bigint(20) NOT NULL,
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
