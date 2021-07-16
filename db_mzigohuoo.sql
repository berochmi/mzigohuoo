-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 16, 2021 at 01:05 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mzigohuoo`
--

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

DROP TABLE IF EXISTS `branches`;
CREATE TABLE IF NOT EXISTS `branches` (
  `c0d` int(10) NOT NULL AUTO_INCREMENT,
  `branch_name` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `physical_address` text NOT NULL,
  `country` varchar(255) NOT NULL,
  `contacts` varchar(255) NOT NULL,
  `lat` decimal(10,6) DEFAULT NULL,
  `lon` decimal(10,6) DEFAULT NULL,
  `created_by` int(10) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `edited_by` int(10) NOT NULL,
  `edited_on` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`c0d`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`c0d`, `branch_name`, `city`, `physical_address`, `country`, `contacts`, `lat`, `lon`, `created_by`, `created_on`, `edited_by`, `edited_on`) VALUES
(1, 'Dar es Salaam, Sheik Lango', 'Dar es Salaam', 'Dar es Salaam, Sheik Lango', 'Tanzania', '0769545223', NULL, NULL, 1, '2021-07-13 21:51:41', 1, '2021-07-13 21:51:41'),
(2, 'Dodoma Main', 'Dodoma', 'Main Dodoma Roundabout', 'Tanzania', '0687819514', NULL, NULL, 1, '2021-07-13 21:51:41', 1, '2021-07-13 21:51:41');

-- --------------------------------------------------------

--
-- Table structure for table `collecting_packages`
--

DROP TABLE IF EXISTS `collecting_packages`;
CREATE TABLE IF NOT EXISTS `collecting_packages` (
  `c0d` int(10) NOT NULL AUTO_INCREMENT,
  `sending_package_id` int(10) NOT NULL,
  `collected_date` date NOT NULL,
  `collected_time` time NOT NULL,
  `collected_by_name` varchar(255) NOT NULL,
  `collected_by_contacts` varchar(255) NOT NULL,
  `collected_by_idno` varchar(255) NOT NULL,
  `collected_by_id_type` varchar(255) NOT NULL,
  `sms_sent` int(1) DEFAULT 0,
  `created_by` int(10) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `edited_by` int(10) NOT NULL,
  `edited_on` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`c0d`),
  UNIQUE KEY `sending_package_id` (`sending_package_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `collecting_packages`
--

INSERT INTO `collecting_packages` (`c0d`, `sending_package_id`, `collected_date`, `collected_time`, `collected_by_name`, `collected_by_contacts`, `collected_by_idno`, `collected_by_id_type`, `sms_sent`, `created_by`, `created_on`, `edited_by`, `edited_on`) VALUES
(7, 5, '2021-07-14', '12:00:00', 'Maradona', '0769 545223', '123455', 'OTHER', 0, 2, '2021-07-14 09:52:52', 2, '2021-07-14 09:52:52'),
(8, 4, '2021-07-14', '12:22:00', 'Ronaldo', '0687 819514', '12344', 'OTHER', 0, 2, '2021-07-14 09:58:58', 2, '2021-07-14 09:58:58'),
(10, 2, '2021-07-14', '12:00:00', 'Dotto Mwenda', '0687 819514', 'ssssss', 'OTHER', 0, 2, '2021-07-14 10:01:52', 2, '2021-07-14 10:01:52'),
(11, 3, '2021-07-14', '19:09:00', 'Dotto Mwenda', '0687 819514', 'wwwwqw', 'DRIVERS LICENSE', 0, 2, '2021-07-14 10:21:03', 2, '2021-07-14 10:21:03'),
(13, 1, '2021-07-14', '12:30:00', 'Dotto Mwenda', '0687 819514', 'sssss', 'NATIONAL ID', 0, 2, '2021-07-14 10:25:53', 2, '2021-07-14 10:25:53'),
(14, 6, '2021-07-14', '11:11:00', 'Robe', '0687 819514', '111111', 'DRIVERS LICENSE', 0, 2, '2021-07-14 11:00:19', 2, '2021-07-14 11:00:19'),
(15, 7, '2021-07-14', '13:00:00', 'Dotto Mwenda', '0689 643369', '11111', 'OTHER', 0, 2, '2021-07-14 18:54:36', 2, '2021-07-14 18:54:36'),
(17, 10, '2021-07-15', '14:08:00', 'Robert Okwakol', '0769545223', 'Ahahahsh', 'NATIONAL ID', 0, 2, '2021-07-15 14:08:42', 2, '2021-07-15 14:08:42'),
(18, 12, '2021-07-15', '14:09:00', 'Robert', '0769545223', 'Jzhzhsh', 'NATIONAL ID', 0, 2, '2021-07-15 14:09:37', 2, '2021-07-15 14:09:37'),
(20, 13, '2021-07-15', '14:11:00', 'Robert', '0769545223', 'ahahahs', 'NATIONAL ID', 0, 2, '2021-07-15 14:11:47', 2, '2021-07-15 14:11:47'),
(21, 14, '2021-07-15', '15:19:00', 'Robert', '0769545223', 'ASDGMAA', 'NATIONAL ID', 0, 2, '2021-07-15 15:19:36', 2, '2021-07-15 15:19:36'),
(22, 17, '2021-07-15', '15:43:00', 'Robert', '0769545223', 'nNJja', 'NATIONAL ID', 0, 2, '2021-07-15 15:43:30', 2, '2021-07-15 15:43:30'),
(23, 15, '2021-07-15', '16:59:00', 'Roberto', '0769545223', 'Ajajasjj', 'NATIONAL ID', 0, 2, '2021-07-15 16:59:33', 2, '2021-07-15 16:59:33'),
(24, 19, '2021-07-16', '08:20:00', 'Robe', '0769545223', 'AB1923', 'NATIONAL ID', 0, 2, '2021-07-16 08:20:41', 2, '2021-07-16 08:20:41'),
(25, 22, '2021-07-16', '08:29:00', 'Robert', '0769545223', 'AB122992', 'NATIONAL ID', 1, 2, '2021-07-16 08:29:24', 2, '2021-07-16 08:29:25'),
(26, 24, '2021-07-16', '10:29:00', 'Michael', '0687 819514', 'Ananajaja', 'NATIONAL ID', 1, 2, '2021-07-16 10:29:46', 2, '2021-07-16 10:29:47'),
(27, 20, '2021-07-16', '12:00:00', 'Micho', '0687 819514', '10101', 'NATIONAL ID', 1, 2, '2021-07-16 11:26:33', 2, '2021-07-16 11:31:43'),
(28, 27, '2021-07-16', '12:01:00', 'DOTTO MWENDA', '0689743369', 'ABC', 'NATIONAL ID', 1, 2, '2021-07-16 12:01:09', 2, '2021-07-16 12:01:10');

-- --------------------------------------------------------

--
-- Table structure for table `controllers_actions`
--

DROP TABLE IF EXISTS `controllers_actions`;
CREATE TABLE IF NOT EXISTS `controllers_actions` (
  `c0d` int(11) NOT NULL AUTO_INCREMENT,
  `controller_name` varchar(255) NOT NULL,
  `action_name` varchar(255) NOT NULL,
  `status` varchar(80) NOT NULL DEFAULT 'ACTIVE',
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `edited_on` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`c0d`),
  UNIQUE KEY `controller_name` (`controller_name`,`action_name`)
) ENGINE=InnoDB AUTO_INCREMENT=1694 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `controllers_actions`
--

INSERT INTO `controllers_actions` (`c0d`, `controller_name`, `action_name`, `status`, `created_on`, `edited_on`) VALUES
(444, 'Logout', 'index', 'ACTIVE', '2021-07-13 22:01:10', '2021-07-13 22:01:10'),
(974, 'SalesCounter', 'receivePackageAjax', 'ACTIVE', '2021-07-14 18:51:31', '2021-07-14 18:51:31'),
(1660, 'SalesCounter', 'collectPackageAjax', 'ACTIVE', '2021-07-16 11:26:32', '2021-07-16 11:26:32'),
(1665, 'SalesCounter', 'collectPackage', 'ACTIVE', '2021-07-16 11:31:50', '2021-07-16 11:31:50'),
(1666, 'SalesCounter', 'allSentPackages', 'ACTIVE', '2021-07-16 11:36:15', '2021-07-16 11:36:15'),
(1667, 'SalesCounter', 'receivePackage', 'ACTIVE', '2021-07-16 11:36:20', '2021-07-16 11:36:20'),
(1668, 'Login', 'runSetUp', 'ACTIVE', '2021-07-16 11:36:40', '2021-07-16 11:36:40'),
(1675, 'Login', 'index', 'ACTIVE', '2021-07-16 11:51:48', '2021-07-16 11:51:48'),
(1676, 'SalesCounter', 'index', 'ACTIVE', '2021-07-16 11:51:48', '2021-07-16 11:51:48'),
(1679, 'SalesCounter', 'loadBranchesToAjax', 'ACTIVE', '2021-07-16 11:52:19', '2021-07-16 11:52:19'),
(1680, 'SalesCounter', 'sendPackage', 'ACTIVE', '2021-07-16 11:53:18', '2021-07-16 11:53:18'),
(1684, 'SalesCounter', 'vOneSentPackage', 'ACTIVE', '2021-07-16 11:58:50', '2021-07-16 11:58:50'),
(1686, 'Login', 'runScanPackage', 'ACTIVE', '2021-07-16 11:59:29', '2021-07-16 11:59:29'),
(1687, 'Login', 'runTransitPackage', 'ACTIVE', '2021-07-16 11:59:38', '2021-07-16 11:59:38'),
(1688, 'Login', 'runReceivePackage', 'ACTIVE', '2021-07-16 11:59:44', '2021-07-16 11:59:44'),
(1689, 'Login', 'runCollectPackage', 'ACTIVE', '2021-07-16 12:01:09', '2021-07-16 12:01:09'),
(1693, 'Login', 'downloadAllPackages', 'ACTIVE', '2021-07-16 12:13:30', '2021-07-16 12:13:30');

-- --------------------------------------------------------

--
-- Table structure for table `my_bases`
--

DROP TABLE IF EXISTS `my_bases`;
CREATE TABLE IF NOT EXISTS `my_bases` (
  `c0d` int(11) NOT NULL AUTO_INCREMENT,
  `base_name` varchar(80) NOT NULL,
  `created_by` int(10) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `edited_by` int(10) NOT NULL,
  `edited_on` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`c0d`),
  UNIQUE KEY `base_name` (`base_name`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `my_bases`
--

INSERT INTO `my_bases` (`c0d`, `base_name`, `created_by`, `created_on`, `edited_by`, `edited_on`) VALUES
(1, 'DAR ES SALAAM', 1, '2021-06-24 05:48:21', 1, '2021-06-24 05:48:21'),
(8, 'DODOMA', 1, '2021-06-24 05:48:21', 1, '2021-06-24 05:48:21');

-- --------------------------------------------------------

--
-- Table structure for table `order_settings`
--

DROP TABLE IF EXISTS `order_settings`;
CREATE TABLE IF NOT EXISTS `order_settings` (
  `c0d` int(11) NOT NULL AUTO_INCREMENT,
  `order_type` varchar(80) NOT NULL,
  `start_no` int(11) NOT NULL,
  `next_no` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `edited_by` int(11) NOT NULL,
  `edited_on` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`c0d`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_settings`
--

INSERT INTO `order_settings` (`c0d`, `order_type`, `start_no`, `next_no`, `created_by`, `created_on`, `edited_by`, `edited_on`) VALUES
(1, 'RECEIPT NUMBERS', 1000, 1024, 1, '2021-07-14 03:35:26', 2, '2021-07-16 11:53:18');

-- --------------------------------------------------------

--
-- Table structure for table `qrcode_images`
--

DROP TABLE IF EXISTS `qrcode_images`;
CREATE TABLE IF NOT EXISTS `qrcode_images` (
  `c0d` int(10) NOT NULL AUTO_INCREMENT,
  `sending_package_id` int(10) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  PRIMARY KEY (`c0d`),
  UNIQUE KEY `sending_package_id` (`sending_package_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `receiving_packages`
--

DROP TABLE IF EXISTS `receiving_packages`;
CREATE TABLE IF NOT EXISTS `receiving_packages` (
  `c0d` int(10) NOT NULL AUTO_INCREMENT,
  `sending_package_id` int(10) NOT NULL,
  `received_package_description` text NOT NULL,
  `received_package_qty` decimal(10,2) NOT NULL,
  `received_date` date NOT NULL,
  `received_time` time NOT NULL,
  `received_collection_date` date DEFAULT NULL,
  `received_collection_time` time DEFAULT NULL,
  `created_by` int(10) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `edited_by` int(10) NOT NULL,
  `edited_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `receiving_packages_status` varchar(40) NOT NULL DEFAULT 'ARRIVED',
  `sms_sent` int(1) DEFAULT 0,
  PRIMARY KEY (`c0d`),
  UNIQUE KEY `sending_package_id` (`sending_package_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `receiving_packages`
--

INSERT INTO `receiving_packages` (`c0d`, `sending_package_id`, `received_package_description`, `received_package_qty`, `received_date`, `received_time`, `received_collection_date`, `received_collection_time`, `created_by`, `created_on`, `edited_by`, `edited_on`, `receiving_packages_status`, `sms_sent`) VALUES
(2, 5, 'Parcel', '1.00', '2021-07-14', '20:00:00', '2021-07-15', '10:00:00', 2, '2021-07-14 08:40:31', 2, '2021-07-14 09:52:53', 'COLLECTED', 0),
(3, 4, 'Parcel 1', '1.00', '2021-07-14', '12:00:00', '2021-07-15', '10:00:00', 2, '2021-07-14 09:58:17', 2, '2021-07-14 09:58:58', 'COLLECTED', 0),
(4, 2, 'Parcel', '1.00', '2021-07-14', '11:00:00', '2021-07-15', '10:00:00', 2, '2021-07-14 10:00:08', 2, '2021-07-14 10:01:53', 'COLLECTED', 0),
(5, 3, 'Parcel', '1.00', '2021-07-14', '12:20:00', '2021-07-15', '10:00:00', 2, '2021-07-14 10:14:55', 2, '2021-07-14 10:21:03', 'COLLECTED', 0),
(6, 1, 'Parcel', '1.00', '2021-07-14', '12:00:00', '2021-07-15', '10:00:00', 2, '2021-07-14 10:23:45', 2, '2021-07-14 10:25:54', 'COLLECTED', 0),
(9, 6, 'Parcel', '1.00', '2021-07-14', '12:22:00', '2021-07-15', '10:00:00', 2, '2021-07-14 10:58:22', 2, '2021-07-14 11:00:19', 'COLLECTED', 0),
(10, 7, 'Parcel', '1.00', '2021-07-14', '12:00:00', '2021-07-15', '10:00:00', 2, '2021-07-14 18:51:31', 2, '2021-07-14 18:54:37', 'COLLECTED', 0),
(11, 12, 'Parcel', '1.00', '2021-07-15', '08:21:00', '2021-07-15', '10:00:00', 1, '2021-07-15 08:21:47', 2, '2021-07-15 14:09:38', 'COLLECTED', 0),
(12, 10, 'Parcel', '1.00', '2021-07-15', '08:22:00', '2021-07-15', '10:00:00', 1, '2021-07-15 08:22:58', 2, '2021-07-15 14:08:42', 'COLLECTED', 0),
(13, 13, 'Parcel', '1.00', '2021-07-15', '08:24:00', '2021-07-15', '10:00:00', 1, '2021-07-15 08:24:32', 2, '2021-07-15 14:11:47', 'COLLECTED', 0),
(14, 14, 'Parcel', '1.00', '2021-07-15', '08:24:00', '2021-07-15', '20:00:00', 1, '2021-07-15 08:24:57', 2, '2021-07-15 15:19:36', 'COLLECTED', 0),
(15, 15, 'Parcel', '1.00', '2021-07-15', '08:25:00', '2021-07-15', '20:00:00', 1, '2021-07-15 08:25:10', 2, '2021-07-15 16:59:33', 'COLLECTED', 0),
(16, 17, 'Parcel', '1.00', '2021-07-15', '15:15:00', '2021-07-15', '12:00:00', 2, '2021-07-15 15:15:52', 2, '2021-07-15 15:43:30', 'COLLECTED', 0),
(17, 16, 'Parcel', '1.00', '2021-07-15', '17:00:00', '2021-07-15', '12:00:00', 2, '2021-07-15 17:00:23', 2, '2021-07-15 17:00:23', 'ARRIVED', 0),
(18, 18, 'Parcel', '1.00', '2021-07-15', '20:03:00', '2021-07-15', '12:00:00', 2, '2021-07-15 20:03:09', 2, '2021-07-15 20:03:09', 'ARRIVED', 0),
(19, 8, 'Parcel', '1.00', '2021-07-15', '21:35:00', '2021-07-15', '10:00:00', 2, '2021-07-15 21:35:22', 2, '2021-07-15 21:35:22', 'ARRIVED', 0),
(21, 11, 'Parcel', '1.00', '2021-07-15', '21:39:00', '2021-07-15', '10:00:00', 2, '2021-07-15 21:39:37', 2, '2021-07-15 21:39:37', 'ARRIVED', 0),
(22, 19, 'Parcel', '1.00', '2021-07-15', '21:43:00', '2021-07-16', '12:00:00', 2, '2021-07-15 21:43:25', 2, '2021-07-16 08:20:42', 'COLLECTED', 0),
(23, 20, 'Parcel', '1.00', '2021-07-15', '21:52:00', '2021-07-16', '13:00:00', 2, '2021-07-15 21:52:41', 2, '2021-07-16 11:26:33', 'COLLECTED', 0),
(24, 21, 'Parcel', '1.00', '2021-07-16', '08:25:00', '2021-07-16', '12:00:00', 2, '2021-07-16 08:25:37', 2, '2021-07-16 08:25:37', 'ARRIVED', 0),
(25, 22, 'Parcel', '1.00', '2021-07-16', '08:27:00', '2021-07-16', '12:00:00', 2, '2021-07-16 08:27:10', 2, '2021-07-16 08:29:24', 'COLLECTED', 1),
(26, 23, 'Parcel', '1.00', '2021-07-16', '10:04:00', '2021-07-16', '14:00:00', 2, '2021-07-16 10:04:19', 2, '2021-07-16 10:04:20', 'ARRIVED', 1),
(27, 24, 'Parcel', '1.00', '2021-07-16', '10:26:00', '2021-07-16', '12:00:00', 2, '2021-07-16 10:26:40', 2, '2021-07-16 10:29:46', 'COLLECTED', 1),
(28, 25, 'Parcel', '1.00', '2021-07-16', '10:27:00', '2021-07-16', '14:00:00', 2, '2021-07-16 10:27:06', 2, '2021-07-16 10:27:08', 'ARRIVED', 1),
(29, 27, 'Parcel', '1.00', '2021-07-16', '11:59:00', '2021-07-17', '10:00:00', 2, '2021-07-16 11:59:44', 2, '2021-07-16 12:01:09', 'COLLECTED', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sending_packages`
--

DROP TABLE IF EXISTS `sending_packages`;
CREATE TABLE IF NOT EXISTS `sending_packages` (
  `c0d` int(11) NOT NULL AUTO_INCREMENT,
  `city_from` varchar(255) NOT NULL,
  `city_to` varchar(255) NOT NULL,
  `from_branch_id` int(10) NOT NULL,
  `to_branch_id` int(10) NOT NULL,
  `sender_name` varchar(255) NOT NULL,
  `sender_contacts` varchar(40) NOT NULL,
  `package_description` text NOT NULL,
  `package_qty` decimal(8,2) NOT NULL,
  `package_amount_paid` decimal(10,2) NOT NULL DEFAULT 0.00,
  `date_received` date NOT NULL,
  `time_received` time NOT NULL,
  `collection_date` date NOT NULL,
  `collection_time` time NOT NULL,
  `receiver_name` varchar(80) NOT NULL,
  `receiver_contacts` varchar(40) NOT NULL,
  `receipt_no` int(10) NOT NULL,
  `sending_package_status` varchar(20) NOT NULL,
  `sms_sent` int(1) DEFAULT 0,
  `created_by` int(10) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `edited_by` int(10) NOT NULL,
  `edited_on` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`c0d`),
  UNIQUE KEY `receipt_no` (`receipt_no`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sending_packages`
--

INSERT INTO `sending_packages` (`c0d`, `city_from`, `city_to`, `from_branch_id`, `to_branch_id`, `sender_name`, `sender_contacts`, `package_description`, `package_qty`, `package_amount_paid`, `date_received`, `time_received`, `collection_date`, `collection_time`, `receiver_name`, `receiver_contacts`, `receipt_no`, `sending_package_status`, `sms_sent`, `created_by`, `created_on`, `edited_by`, `edited_on`) VALUES
(5, 'DAR ES SALAAM', 'DODOMA', 1, 2, 'Pele', '0769 545223', 'Parcel', '1.00', '10000.00', '2021-07-14', '10:00:00', '2021-07-15', '10:00:00', 'Maradona', '0687 819514', 1001, 'COLLECTED', 0, 2, '2021-07-14 06:09:11', 2, '2021-07-14 09:52:53'),
(6, 'DAR ES SALAAM', 'DODOMA', 1, 2, 'John Doe', '0769 545223', 'Parcel', '1.00', '10000.00', '2021-07-14', '10:00:00', '2021-07-15', '10:00:00', 'Robe', '0687 819514', 1002, 'COLLECTED', 0, 2, '2021-07-14 10:54:43', 2, '2021-07-14 11:00:19'),
(7, 'DAR ES SALAAM', 'DODOMA', 1, 2, 'Robe', '0769 545223', 'Parcel', '1.00', '10000.00', '2021-07-14', '10:00:00', '2021-07-15', '10:00:00', 'Dotto Mwenda', '0689 643369', 1003, 'COLLECTED', 0, 2, '2021-07-14 18:47:06', 2, '2021-07-14 18:54:37'),
(8, 'DAR ES SALAAM', 'DAR ES SALAAM', 1, 1, 'John doe', '0769 545223', 'Parcel', '1.00', '10000.00', '2021-07-14', '09:30:00', '2021-07-15', '10:00:00', 'Jane Doe', '0687 819514', 1004, 'ARRIVED', 0, 2, '2021-07-14 18:57:14', 2, '2021-07-15 21:35:22'),
(10, 'DAR ES SALAAM', 'DAR ES SALAAM', 1, 1, 'John doe', '0769 545223', 'Parcel', '1.00', '10000.00', '2021-07-14', '09:30:00', '2021-07-15', '10:00:00', 'Jane Doe', '0687 819514', 1006, 'COLLECTED', 0, 2, '2021-07-14 18:59:28', 2, '2021-07-15 14:08:42'),
(11, 'DAR ES SALAAM', 'DODOMA', 1, 2, 'Jim Jam', '0769 545223', 'Parcel', '1.00', '10000.00', '2021-07-14', '08:00:00', '2021-07-15', '10:00:00', 'Jam Jim', '0687 819514', 1007, 'ARRIVED', 0, 2, '2021-07-14 19:03:07', 2, '2021-07-15 21:39:37'),
(12, 'DAR ES SALAAM', 'DODOMA', 1, 2, 'Jim Jam', '0769 545223', 'Parcel', '1.00', '10000.00', '2021-07-14', '08:00:00', '2021-07-15', '10:00:00', 'Jam Jim', '0687 819514', 1008, 'COLLECTED', 0, 2, '2021-07-14 19:06:12', 2, '2021-07-15 14:09:37'),
(13, 'DAR ES SALAAM', 'DODOMA', 1, 2, 'Jim Jam', '0769 545223', 'Parcel', '1.00', '10000.00', '2021-07-14', '08:00:00', '2021-07-15', '10:00:00', 'Jam Jim', '0687 819514', 1009, 'COLLECTED', 0, 2, '2021-07-14 19:06:17', 2, '2021-07-15 14:11:47'),
(14, 'DAR ES SALAAM', 'DODOMA', 1, 2, 'Test', '9769 545233', 'Parcel', '1.00', '10000.00', '2021-07-14', '11:11:00', '2021-07-15', '20:00:00', 'Jaribio', '0687 819514', 1010, 'COLLECTED', 0, 2, '2021-07-14 19:09:10', 2, '2021-07-15 15:19:36'),
(15, 'DAR ES SALAAM', 'DODOMA', 1, 2, 'Donadoni', '0769 545223', 'Parcel', '1.00', '10000.00', '2021-07-14', '10:00:00', '2021-07-15', '20:00:00', 'Roberto', '0687 819514', 1011, 'COLLECTED', 0, 2, '2021-07-14 19:17:35', 2, '2021-07-15 16:59:33'),
(16, 'DAR ES SALAAM', 'DODOMA', 1, 2, 'Robe', '0769 545223', 'Parcel', '1.00', '10000.00', '2021-07-15', '10:00:00', '2021-07-15', '12:00:00', 'Bero', '0687 819514', 1012, 'ARRIVED', 0, 2, '2021-07-15 02:55:39', 2, '2021-07-15 17:00:23'),
(17, 'DAR ES SALAAM', 'DODOMA', 1, 2, 'Jim', '0796 545223', 'Parcel', '1.00', '10000.00', '2021-07-15', '10:00:00', '2021-07-15', '12:00:00', 'Jam', '0687 819514', 1013, 'COLLECTED', 0, 2, '2021-07-15 15:06:17', 2, '2021-07-15 15:43:30'),
(18, 'DAR ES SALAAM', 'DODOMA', 1, 2, 'Robert M. O.', '0769 545223', 'Parcel', '1.00', '10000.00', '2021-07-15', '10:00:00', '2021-07-15', '12:00:00', 'Dotto Mwenda', '0689 743369', 1014, 'ARRIVED', 0, 2, '2021-07-15 19:43:54', 2, '2021-07-15 20:03:10'),
(19, 'DAR ES SALAAM', 'DAR ES SALAAM', 1, 1, 'Robe', '0769 545223', 'Parcel', '1.00', '10000.00', '2021-07-16', '10:00:00', '2021-07-16', '12:00:00', 'Mich', '0687 819514', 1015, 'COLLECTED', 0, 2, '2021-07-15 21:42:48', 2, '2021-07-16 08:20:41'),
(20, 'DAR ES SALAAM', 'DAR ES SALAAM', 1, 1, 'Roberto', '0769 545223', 'Parcel', '1.00', '10000.00', '2021-07-16', '12:00:00', '2021-07-16', '13:00:00', 'Micho', '0687 819514', 1016, 'COLLECTED', 0, 2, '2021-07-15 21:52:08', 2, '2021-07-16 11:26:33'),
(21, 'DAR ES SALAAM', 'DODOMA', 1, 2, 'Robert', '0769 545223', 'Parcel', '1.00', '10000.00', '2021-07-16', '10:00:00', '2021-07-16', '12:00:00', 'Michael', '0687 819514', 1017, 'ARRIVED', 0, 2, '2021-07-16 02:51:52', 2, '2021-07-16 08:25:37'),
(22, 'DAR ES SALAAM', 'DAR ES SALAAM', 1, 1, 'Roby', '0769 545223', 'Parcel', '1.00', '10000.00', '2021-07-16', '10:00:00', '2021-07-16', '12:00:00', 'Jimy', '0687 819514', 1018, 'COLLECTED', 0, 2, '2021-07-16 06:07:34', 2, '2021-07-16 08:29:24'),
(23, 'DAR ES SALAAM', 'DAR ES SALAAM', 1, 1, 'Robert M. O.', '0769 545223', 'Parcel', '1.00', '10000.00', '2021-07-16', '12:00:00', '2021-07-16', '14:00:00', 'Dotto Mwenda', '0687 819514', 1019, 'ARRIVED', 1, 2, '2021-07-16 07:21:50', 2, '2021-07-16 10:04:19'),
(24, 'DAR ES SALAAM', 'DAR ES SALAAM', 1, 1, 'Robert Okwakol', '0769 545223', 'Parcel', '1.00', '10000.00', '2021-07-16', '10:00:00', '2021-07-16', '12:00:00', 'Michael', '0687 819514', 1020, 'COLLECTED', 0, 2, '2021-07-16 08:59:36', 2, '2021-07-16 10:29:46'),
(25, 'DAR ES SALAAM', 'DAR ES SALAAM', 1, 1, 'Robe', '0769 545223', 'Parcel', '1.00', '10000.00', '2021-07-16', '12:00:00', '2021-07-16', '14:00:00', 'Jane', '0687 819514', 1021, 'ARRIVED', 1, 2, '2021-07-16 10:15:30', 2, '2021-07-16 10:27:06'),
(26, 'DAR ES SALAAM', 'DAR ES SALAAM', 1, 1, 'Robert', '0769 545223', 'Parcel', '1.00', '10000.00', '2021-07-16', '10:00:00', '2021-07-16', '13:00:00', 'Don', '0687 819514', 1022, 'IN TRANSIT', 0, 2, '2021-07-16 10:43:09', 2, '2021-07-16 10:43:32'),
(27, 'DAR ES SALAAM', 'DODOMA', 1, 2, 'Robert M. O.', '0769 545223', 'Parcel', '1.00', '10000.00', '2021-07-16', '10:00:00', '2021-07-17', '10:00:00', 'Dotto Mwenda', '0689 743369', 1023, 'COLLECTED', 1, 2, '2021-07-16 11:53:18', 2, '2021-07-16 12:01:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` varchar(80) NOT NULL,
  `f_name` varchar(80) NOT NULL,
  `l_name` varchar(80) NOT NULL,
  `m_name` varchar(80) NOT NULL,
  `username` varchar(80) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_group_id` int(11) DEFAULT 0,
  `role` varchar(80) NOT NULL DEFAULT 'NONE',
  `access_code` int(11) NOT NULL,
  `my_base` text DEFAULT '',
  `my_branch_id` int(10) DEFAULT 0,
  `deleted` int(2) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `edited_by` int(11) NOT NULL,
  `edited_on` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `staff_id`, `f_name`, `l_name`, `m_name`, `username`, `password`, `user_group_id`, `role`, `access_code`, `my_base`, `my_branch_id`, `deleted`, `created_by`, `created_on`, `edited_by`, `edited_on`) VALUES
(2, '1', 'admin', 'admin', '', 'admin', '$2y$10$Z2LV1hJ1y30V2RL.vBAIjeA2.0FHGVxswxR5iPyLxC5O93eDoX.u6', 1, 'NONE', 1, 'DAR ES SALAAM', 1, 0, 1, '2020-09-10 16:07:35', 2, '2021-03-01 07:32:30'),
(14, '111', 'Sales', 'Sales', 'Sales', 'sales', '$2y$10$R62i24KN2Z40RlBIce3b5e554owRiICf9cyWL/fKAH838cfrv7702', 10, 'NONE', 1234, '', 0, 0, 2, '2021-06-21 16:45:33', 2, '2021-06-21 16:45:33'),
(15, '22', 'Delivery', 'Guy', '', 'deli', '$2y$10$Xu2X8hpSXifAzB8qAcJlRu.mgAb.M3xPETrr91mBYY0Wbr6WqcTgm', 11, 'NONE', 1234, '', 0, 0, 2, '2021-06-21 16:48:01', 2, '2021-06-21 16:48:01'),
(16, '1,122', 'Robe', 'Robe', 'Robe', 'robe', '$2y$10$uUfgttump5CNs9O65pMVuuCbRwQ7444F92UdSh1nq/Kdcwqy3IMZS', 10, 'NONE', 1234, '', 0, 0, 2, '2021-06-22 05:43:34', 2, '2021-06-22 05:43:34'),
(17, '1', 'admin2', 'admin', '', 'admin2', '$2y$10$Z2LV1hJ1y30V2RL.vBAIjeA2.0FHGVxswxR5iPyLxC5O93eDoX.u6', 1, 'NONE', 1, 'DODOMA', 2, 0, 1, '2020-09-10 16:07:35', 2, '2021-03-01 07:32:30');

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

DROP TABLE IF EXISTS `user_groups`;
CREATE TABLE IF NOT EXISTS `user_groups` (
  `c0d` int(11) NOT NULL AUTO_INCREMENT,
  `user_group_name` varchar(80) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `edited_by` int(11) NOT NULL,
  `edited_on` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`c0d`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`c0d`, `user_group_name`, `created_by`, `created_on`, `edited_by`, `edited_on`) VALUES
(1, 'Admin', 1, '2021-03-22 09:05:19', 1, '2021-03-22 09:05:19'),
(10, 'Sales', 1, '2021-03-22 09:05:19', 1, '2021-03-22 09:05:19'),
(11, 'Courier', 1, '2021-03-22 09:05:19', 1, '2021-03-22 09:05:19');

-- --------------------------------------------------------

--
-- Table structure for table `user_groups_perms`
--

DROP TABLE IF EXISTS `user_groups_perms`;
CREATE TABLE IF NOT EXISTS `user_groups_perms` (
  `c0d` int(11) NOT NULL AUTO_INCREMENT,
  `user_group_id` int(11) NOT NULL,
  `controller_allowed` varchar(80) NOT NULL,
  `action_allowed` varchar(80) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `edited_by` int(11) NOT NULL,
  `edited_on` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`c0d`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_groups_perms`
--

INSERT INTO `user_groups_perms` (`c0d`, `user_group_id`, `controller_allowed`, `action_allowed`, `created_by`, `created_on`, `edited_by`, `edited_on`) VALUES
(1, 1, '*', '*', 1, '2021-06-07 11:33:29', 1, '2021-06-07 11:33:29');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_sending_packages`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `v_sending_packages`;
CREATE TABLE IF NOT EXISTS `v_sending_packages` (
`sending_package_id` int(11)
,`city_from` varchar(255)
,`city_to` varchar(255)
,`from_branch_id` int(10)
,`from_branch_name` varchar(255)
,`to_branch_id` int(10)
,`to_branch_name` varchar(255)
,`sender_name` varchar(255)
,`sender_contacts` varchar(40)
,`package_description` text
,`package_qty` decimal(8,2)
,`package_amount_paid` decimal(10,2)
,`date_received` date
,`time_received` time
,`collection_date` date
,`collection_time` time
,`receiver_name` varchar(80)
,`receiver_contacts` varchar(40)
,`receipt_no` int(10)
,`sending_package_status` varchar(20)
,`sms_sent` int(1)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_users`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `v_users`;
CREATE TABLE IF NOT EXISTS `v_users` (
`user_id` int(11)
,`staff_id` varchar(80)
,`f_name` varchar(80)
,`l_name` varchar(80)
,`m_name` varchar(80)
,`username` varchar(80)
,`password` varchar(255)
,`user_group_id` int(11)
,`user_group_name` varchar(80)
,`role` varchar(80)
,`access_code` int(11)
,`my_base` text
,`my_branch_id` int(10)
,`deleted` int(2)
,`created_by` int(11)
,`created_on` timestamp
,`edited_by` int(11)
,`edited_on` timestamp
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_user_groups_perms`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `v_user_groups_perms`;
CREATE TABLE IF NOT EXISTS `v_user_groups_perms` (
`c0d` int(11)
,`user_group_id` int(11)
,`user_group_name` varchar(80)
,`controller_allowed` varchar(80)
,`action_allowed` varchar(80)
,`created_by` int(11)
,`created_on` timestamp
,`edited_by` int(11)
,`edited_on` timestamp
);

-- --------------------------------------------------------

--
-- Structure for view `v_sending_packages`
--
DROP TABLE IF EXISTS `v_sending_packages`;

CREATE  VIEW `v_sending_packages`  AS  select `a`.`c0d` AS `sending_package_id`,`a`.`city_from` AS `city_from`,`a`.`city_to` AS `city_to`,`a`.`from_branch_id` AS `from_branch_id`,`b1`.`branch_name` AS `from_branch_name`,`a`.`to_branch_id` AS `to_branch_id`,`b2`.`branch_name` AS `to_branch_name`,`a`.`sender_name` AS `sender_name`,`a`.`sender_contacts` AS `sender_contacts`,`a`.`package_description` AS `package_description`,`a`.`package_qty` AS `package_qty`,`a`.`package_amount_paid` AS `package_amount_paid`,`a`.`date_received` AS `date_received`,`a`.`time_received` AS `time_received`,`a`.`collection_date` AS `collection_date`,`a`.`collection_time` AS `collection_time`,`a`.`receiver_name` AS `receiver_name`,`a`.`receiver_contacts` AS `receiver_contacts`,`a`.`receipt_no` AS `receipt_no`,`a`.`sending_package_status` AS `sending_package_status`,`a`.`sms_sent` AS `sms_sent` from ((`sending_packages` `a` left join `branches` `b1` on(`b1`.`c0d` = `a`.`from_branch_id`)) left join `branches` `b2` on(`b2`.`c0d` = `a`.`to_branch_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `v_users`
--
DROP TABLE IF EXISTS `v_users`;

CREATE  VIEW `v_users`  AS  select `a`.`id` AS `user_id`,`a`.`staff_id` AS `staff_id`,`a`.`f_name` AS `f_name`,`a`.`l_name` AS `l_name`,`a`.`m_name` AS `m_name`,`a`.`username` AS `username`,`a`.`password` AS `password`,`a`.`user_group_id` AS `user_group_id`,`b`.`user_group_name` AS `user_group_name`,`a`.`role` AS `role`,`a`.`access_code` AS `access_code`,`a`.`my_base` AS `my_base`,`a`.`my_branch_id` AS `my_branch_id`,`a`.`deleted` AS `deleted`,`a`.`created_by` AS `created_by`,`a`.`created_on` AS `created_on`,`a`.`edited_by` AS `edited_by`,`a`.`edited_on` AS `edited_on` from (`users` `a` left join `user_groups` `b` on(`b`.`c0d` = `a`.`user_group_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `v_user_groups_perms`
--
DROP TABLE IF EXISTS `v_user_groups_perms`;

CREATE  VIEW `v_user_groups_perms`  AS  select `a`.`c0d` AS `c0d`,`a`.`user_group_id` AS `user_group_id`,`b`.`user_group_name` AS `user_group_name`,`a`.`controller_allowed` AS `controller_allowed`,`a`.`action_allowed` AS `action_allowed`,`a`.`created_by` AS `created_by`,`a`.`created_on` AS `created_on`,`a`.`edited_by` AS `edited_by`,`a`.`edited_on` AS `edited_on` from (`user_groups_perms` `a` left join `user_groups` `b` on(`b`.`c0d` = `a`.`user_group_id`)) ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
