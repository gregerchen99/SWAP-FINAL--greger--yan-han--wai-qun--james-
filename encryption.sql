-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 10, 2018 at 06:03 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `encryption`
--

-- --------------------------------------------------------

--
-- Table structure for table `book_info`
--

CREATE TABLE `book_info` (
  `book_id` int(10) NOT NULL,
  `book_name` varchar(20) NOT NULL,
  `book_author` varchar(20) NOT NULL,
  `book_price` double NOT NULL,
  `book_genre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `custlog_info`
--

CREATE TABLE `custlog_info` (
  `custlog_id` int(10) NOT NULL,
  `custlog_time` datetime NOT NULL,
  `custlog_user` varchar(200) NOT NULL,
  `custlog_event` varchar(200) NOT NULL,
  `custlog_comment` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `custlog_info`
--

INSERT INTO `custlog_info` (`custlog_id`, `custlog_time`, `custlog_user`, `custlog_event`, `custlog_comment`) VALUES
(1, '2018-02-07 12:22:47', 'greger', 'Staff: Successful login', ''),
(2, '2018-02-07 13:22:29', 'greger1', 'Customer: Login attempt failed; Incorrect username or password', ''),
(3, '2018-02-07 13:22:53', 'greger1', 'Customer: Login attempt failed; Incorrect username or password', ''),
(4, '2018-02-07 13:24:31', 'greger1', 'Customer: Successful login', ''),
(5, '2018-02-07 13:27:10', 'greger1', 'Customer: Update successful', ''),
(6, '2018-02-07 13:27:26', 'greger1', 'Customer: Login attempt failed; Incorrect username or password', ''),
(7, '2018-02-07 13:27:52', 'greger1', 'Customer: Successful login', ''),
(8, '2018-02-07 13:28:34', 'greger1', 'Customer: Update successful', ''),
(9, '2018-02-07 13:28:42', 'greger1', 'Customer: Login attempt failed; Incorrect username or password', ''),
(10, '2018-02-07 13:29:15', 'greger1', 'Customer: Successful login', ''),
(11, '2018-02-07 13:29:37', 'greger1', 'Customer: Update failed', ''),
(12, '2018-02-07 13:30:03', 'greger1', 'Customer: Update successful', ''),
(13, '2018-02-07 13:57:12', '', 'Customer: Update successful', ''),
(14, '2018-02-07 13:57:56', 'greger1', 'Customer: Update failed; Email in used', ''),
(15, '2018-02-07 13:58:11', 'greger1', 'Customer: Update failed; Username in used', ''),
(16, '2018-02-07 14:01:08', 'greger1', 'Customer: Deactivate failed', ''),
(17, '2018-02-07 14:12:24', 'greger1', 'Customer: Deactivate failed; Password incorrect', ''),
(18, '2018-02-07 14:12:33', 'greger1', 'Customer: Deactivate failed; Password incorrect', ''),
(19, '2018-02-07 14:12:43', 'greger1', 'Customer: Deactivate failed; Password incorrect', ''),
(20, '2018-02-07 14:12:59', 'greger1', 'Customer: Deactivate failed; Password incorrect', ''),
(21, '2018-02-07 14:13:20', 'greger1', 'Customer: Update successful', ''),
(22, '2018-02-07 14:13:27', 'greger1', 'Customer: Deactivate failed; Recaptcha error', ''),
(23, '2018-02-07 14:13:54', 'greger1', 'Customer: Deactivate failed; Password incorrect', ''),
(24, '2018-02-07 14:16:47', 'greger1', 'Customer: Deactivate failed; Password incorrect', ''),
(25, '2018-02-07 14:17:08', 'greger1', 'Customer: Deactivate failed; Password incorrect', ''),
(26, '2018-02-07 14:17:19', 'greger1', 'Customer: Deactivate failed; Password incorrect', ''),
(27, '2018-02-07 14:17:35', 'greger1', 'Customer: Deactivate failed; Password incorrect', ''),
(28, '2018-02-07 14:17:47', 'greger1', 'Customer: Deactivate failed; Password incorrect', ''),
(29, '2018-02-09 00:20:56', 'james', 'Customer: Successful created account', ''),
(30, '2018-02-09 00:37:56', 'james', 'Customer: Successful created account', ''),
(31, '2018-02-09 00:38:27', 'james', 'Customer: Successful login', ''),
(32, '2018-02-09 01:52:08', 'james', 'Customer: Successful created account', ''),
(33, '2018-02-09 01:53:13', 'james', 'Customer: Successful created account', ''),
(34, '2018-02-09 01:58:27', 'james', 'Customer: Successful created account', ''),
(35, '2018-02-09 02:00:10', 'james', 'Customer: Successful created account', ''),
(36, '2018-02-09 02:00:49', 'james', 'Customer: Successful created account', ''),
(37, '2018-02-09 02:09:01', 'james', 'Customer: Successful created account', ''),
(38, '2018-02-09 02:12:14', '123', 'Customer: Successful created account', ''),
(39, '2018-02-09 14:39:12', 'james', 'Customer: Successful created account', ''),
(40, '2018-02-09 14:48:28', 'james', 'Customer: Successful created account', ''),
(41, '2018-02-09 14:49:46', 'james', 'Customer: Successful login', ''),
(42, '2018-02-09 15:00:18', 'james', 'Customer: Successful created account', ''),
(43, '2018-02-09 15:03:47', 'james', 'Customer: Successful created account', ''),
(44, '2018-02-09 15:19:53', 'greger', 'Customer: Successful created account', ''),
(45, '2018-02-09 15:31:46', 'greger', 'Customer: Successful created account', ''),
(46, '2018-02-09 15:34:51', 'greger', 'Customer: Successful login', ''),
(47, '2018-02-09 15:35:45', 'greger', 'Customer: Successful login', ''),
(48, '2018-02-09 15:37:11', 'greger', 'Customer: Successful login', ''),
(49, '2018-02-09 16:24:31', 'greger', 'Customer: Successful login', ''),
(50, '2018-02-09 16:26:48', 'greger', 'Customer: Successful login', ''),
(51, '2018-02-09 16:27:54', 'greger', 'Customer: Successful login', ''),
(52, '2018-02-09 16:53:02', 'greger', 'Customer: Successful login', ''),
(53, '2018-02-09 17:19:59', 'greger', 'Customer: Successful login', ''),
(54, '2018-02-09 17:21:02', 'greger', 'Customer: Successful login', ''),
(55, '2018-02-09 21:54:03', 'greger1', 'Customer: Successful created account', ''),
(56, '2018-02-09 22:41:14', 'HR DEPARTMENT', 'HR DEPARTMENT has logged out.', ''),
(57, '2018-02-10 12:53:04', 'greger1', 'Customer: Successful created account', ''),
(58, '2018-02-10 12:54:54', 'greger1', 'Customer: Successful login', ''),
(59, '2018-02-10 13:00:37', 'greger1', 'Customer: Update successful', '');

-- --------------------------------------------------------

--
-- Table structure for table `customer_info`
--

CREATE TABLE `customer_info` (
  `cust_id` int(10) NOT NULL,
  `cust_email` varchar(40) NOT NULL,
  `cust_pw` varchar(200) NOT NULL,
  `cust_hp` varchar(9) NOT NULL,
  `cust_name` varchar(50) NOT NULL,
  `Address` varchar(200) NOT NULL,
  `Postalcode` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer_info`
--

INSERT INTO `customer_info` (`cust_id`, `cust_email`, `cust_pw`, `cust_hp`, `cust_name`, `Address`, `Postalcode`) VALUES
(10, 'jamestan99825@gmail.com', '$2y$12$7Wt.bC5n84lKmtlWr/nmY.Ich1rv.w1rNtETuLXUr08bs3qx8BkQG', '[èìÄ¬ˆîÖã', 'greger', '41A Bedok Ria Crescent', 489923),
(12, 'gregerchenzhien@gmail.com', '$2y$12$DFI3lovlnrCSMg0BkbqcyOO43Ck2.JuNid4UYadfi0QCtSawuBRvq', '9652-0338', 'greger1', '41A Bedok Ria Crescent', 489922);

-- --------------------------------------------------------

--
-- Table structure for table `custotp_expiry`
--

CREATE TABLE `custotp_expiry` (
  `id` int(11) NOT NULL,
  `otp` varchar(10) NOT NULL,
  `is_expired` int(11) NOT NULL,
  `create_at` datetime NOT NULL,
  `cust_email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `custotp_expiry`
--

INSERT INTO `custotp_expiry` (`id`, `otp`, `is_expired`, `create_at`, `cust_email`) VALUES
(1, '631644', 1, '2018-02-07 12:22:24', 'gregerchenzhien@gmail.com'),
(2, '854436', 1, '2018-02-07 13:23:12', 'gregerchenzhien1@gmail.com'),
(3, '811915', 1, '2018-02-07 13:27:37', 'gregerchenzhien1@gmail.com'),
(4, '821764', 1, '2018-02-07 13:29:03', 'gregerchenzhien1@gmail.com'),
(5, '651041', 1, '2018-02-09 00:38:13', 'jamestan99825@gmail.com'),
(6, '328668', 1, '2018-02-09 14:44:25', 'jamestan99825@gmail.com'),
(7, '863539', 1, '2018-02-09 14:49:32', 'jamestan99825@gmail.com'),
(8, '106959', 1, '2018-02-09 15:34:34', 'jamestan99825@gmail.com'),
(9, '318097', 1, '2018-02-09 15:35:23', 'jamestan99825@gmail.com'),
(10, '148772', 1, '2018-02-09 15:37:00', 'jamestan99825@gmail.com'),
(11, '950119', 1, '2018-02-09 16:19:40', 'jamestan99825@gmail.com'),
(12, '532456', 1, '2018-02-09 16:20:31', 'jamestan99825@gmail.com'),
(13, '469530', 1, '2018-02-09 16:21:49', 'jamestan99825@gmail.com'),
(14, '673508', 1, '2018-02-09 16:24:18', 'jamestan99825@gmail.com'),
(15, '484085', 1, '2018-02-09 16:26:36', 'jamestan99825@gmail.com'),
(16, '638093', 1, '2018-02-09 16:27:43', 'jamestan99825@gmail.com'),
(17, '334559', 1, '2018-02-09 16:27:46', 'jamestan99825@gmail.com'),
(18, '219544', 1, '2018-02-09 16:52:46', 'jamestan99825@gmail.com'),
(19, '486333', 1, '2018-02-09 16:53:41', 'jamestan99825@gmail.com'),
(20, '261645', 1, '2018-02-09 17:06:21', 'jamestan99825@gmail.com'),
(21, '338861', 1, '2018-02-09 17:19:47', 'jamestan99825@gmail.com'),
(22, '960107', 1, '2018-02-09 17:20:49', 'jamestan99825@gmail.com'),
(23, '606985', 1, '2018-02-09 22:10:44', 'gregerchenzhien@gmail.com'),
(24, '967448', 1, '2018-02-09 22:19:33', 'gregerchenzhien@gmail.com'),
(25, '485126', 1, '2018-02-10 12:54:31', 'gregerchenzhien@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `employee_info`
--

CREATE TABLE `employee_info` (
  `employee_id` int(10) NOT NULL,
  `employee_email` varchar(40) NOT NULL,
  `employee_pw` varchar(200) NOT NULL,
  `employee_hp` varchar(9) NOT NULL,
  `employee_address` varchar(100) NOT NULL,
  `employee_postal_code` varchar(6) NOT NULL,
  `employee_joined_date` date NOT NULL,
  `employee_salary` double NOT NULL,
  `employee_role` varchar(20) NOT NULL,
  `employee_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_info`
--

INSERT INTO `employee_info` (`employee_id`, `employee_email`, `employee_pw`, `employee_hp`, `employee_address`, `employee_postal_code`, `employee_joined_date`, `employee_salary`, `employee_role`, `employee_name`) VALUES
(1, 'hrdepart60@gmail.com', '$2y$12$quKaTz7xZPdqu7dARvtHx.eOlCnDXqB1mSsI6heMYvMf3RhgHfTuy', '9652-0338', '1 Raffles Place ', '269935', '2014-04-16', 2500, 'HR Crew', 'HR DEPARTMENT'),
(2, 'auditpro2231@gmail.com', '$2y$12$hxTqTOb/o.rjjNQYlbZqfOJSo.wvsCOy7IyUTYEgCrKhHImGKofKi', '9333-0226', '1 Raffles Place ', '269935', '2016-10-05', 2500, 'Auditor', 'AUDITOR'),
(6, 'codenewbie221@gmail.com', '$2y$12$cYfUWu9I5FI8M8Z.xaxHw.iFAAdx38rBj//IJ6G5fPTuDh2MVom1.', '9652-0338', '1 Raffles Place ', '269935', '2018-02-06', 2500, 'staff', 'staff'),
(7, 'waiqun.l@gmail.com', '$2y$12$8lm7s.asS5Y4cORc.9S36O9WKW1HafxHJ69..8htTe3tqVOCHAePm', '8121-3121', 'sadsdad', '312312', '1999-11-21', 23131, '3131', 'waiqun');

-- --------------------------------------------------------

--
-- Table structure for table `log_info`
--

CREATE TABLE `log_info` (
  `log_id` int(10) NOT NULL,
  `log_time` datetime NOT NULL,
  `log_user` varchar(200) NOT NULL,
  `log_event` varchar(200) NOT NULL,
  `log_comment` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log_info`
--

INSERT INTO `log_info` (`log_id`, `log_time`, `log_user`, `log_event`, `log_comment`) VALUES
(1, '2018-02-07 02:55:33', 'HR DEPARTMENT', 'Staff: Successful login', 'hhh'),
(2, '2018-02-07 11:38:40', 'HR DEPARTMENT', 'Staff: Successful login', 'Nothing'),
(3, '2018-02-07 14:22:05', 'HR DEPARTMENT', 'Staff: Successful login', ''),
(4, '2018-02-07 14:43:18', 'HR DEPARTMENT', 'Staff: Failed to create account; Email taken', ''),
(5, '2018-02-07 14:44:27', 'HR DEPARTMENT', 'Staff: Account created successfully', ''),
(6, '2018-02-07 14:45:28', 'HR DEPARTMENT', 'Staff: Failed to create account; Username taken', ''),
(7, '2018-02-07 14:45:52', 'HR DEPARTMENT', 'HR: Successful deactivated account', ''),
(8, '2018-02-07 14:45:57', 'HR DEPARTMENT', 'HR: Deactivate failed', ''),
(9, '2018-02-07 14:57:10', 'HR DEPARTMENT', 'HR: Successful deactivated account', ''),
(10, '2018-02-07 14:57:16', 'HR DEPARTMENT', 'HR: Successful deactivated account', ''),
(11, '2018-02-07 14:59:28', 'AUDITOR', 'AUDITOR: Successful login', ''),
(12, '2018-02-07 15:01:52', 'HR DEPARTMENT', 'HR: Successful login', ''),
(13, '2018-02-07 15:07:42', 'HR DEPARTMENT', 'HR: Successful updated account', ''),
(14, '2018-02-07 15:08:08', 'HR DEPARTMENT', 'HR: Successful updated account', ''),
(15, '2018-02-07 15:09:27', 'HR DEPARTMENT', 'Staff: Account created successfully', ''),
(16, '2018-02-07 15:10:31', 'staff', 'Staff: Successful login', ''),
(17, '2018-02-07 15:12:04', 'staff', 'Staff: Successful login', ''),
(18, '2018-02-08 00:02:24', 'staff', 'Staff: Successful login', ''),
(19, '2018-02-08 00:11:04', 'HR DEPARTMENT', 'HR: Successful login', ''),
(20, '2018-02-08 00:12:26', 'HR DEPARTMENT', 'Staff: Account created successfully', ''),
(21, '2018-02-09 00:39:56', 'HR DEPARTMENT', 'HR: Successful login', ''),
(22, '2018-02-09 00:40:26', 'HR DEPARTMENT', 'HR: Successful login', ''),
(23, '2018-02-09 22:27:34', 'HR DEPARTMENT', 'HR: Successful login', ''),
(24, '2018-02-09 22:28:33', 'HR DEPARTMENT', 'Staff: Account created successfully', ''),
(25, '2018-02-09 22:28:42', 'HR DEPARTMENT', 'HR: Successful deactivated account', ''),
(26, '2018-02-09 22:28:47', 'HR DEPARTMENT', 'HR: Deactivate failed', ''),
(27, '2018-02-09 22:28:53', 'HR DEPARTMENT', 'HR: Deactivate failed', ''),
(28, '2018-02-09 22:40:12', 'HR DEPARTMENT', 'Staff: Order failed to create; Invalid book id', ''),
(29, '2018-02-09 22:40:19', 'HR DEPARTMENT', 'Staff: Order failed to delete; Invalid order id', ''),
(30, '2018-02-09 15:40:21', 'HR DEPARTMENT', 'Staff: Order failed to update; Invalid order id', ''),
(31, '2018-02-09 15:40:31', 'HR DEPARTMENT', 'Staff: Book failed to update; Empty fields', ''),
(32, '2018-02-09 23:08:56', 'AUDITOR', 'AUDITOR: Successful login', ''),
(33, '2018-02-09 23:09:34', 'AUDITOR', 'AUDITOR: Successful login', ''),
(34, '2018-02-09 23:10:02', 'AUDITOR', 'AUDITOR has logged out.', ''),
(35, '2018-02-09 23:10:36', 'AUDITOR', 'AUDITOR: Successful login', ''),
(36, '2018-02-09 23:12:07', 'AUDITOR', 'AUDITOR has logged out.', '');

-- --------------------------------------------------------

--
-- Table structure for table `order_info`
--

CREATE TABLE `order_info` (
  `order_id` int(10) NOT NULL,
  `cust_id` int(10) NOT NULL,
  `book_id` int(10) NOT NULL,
  `order_date` varchar(10) NOT NULL,
  `total_price` varchar(10) NOT NULL,
  `order_status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `otp_expiry`
--

CREATE TABLE `otp_expiry` (
  `id` int(11) NOT NULL,
  `otp` varchar(10) NOT NULL,
  `is_expired` int(11) NOT NULL,
  `create_at` datetime NOT NULL,
  `employee_email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `otp_expiry`
--

INSERT INTO `otp_expiry` (`id`, `otp`, `is_expired`, `create_at`, `employee_email`) VALUES
(15, '612928', 1, '2018-02-05 23:40:22', 'waiqun.l@gmail.com'),
(16, '670965', 1, '2018-02-05 23:57:59', 'waiqun.l@gmail.com'),
(17, '870717', 1, '2018-02-06 00:01:32', 'waiqun.l@gmail.com'),
(18, '804670', 1, '2018-02-07 01:21:34', 'gregerchenzhien@gmail.com'),
(19, '143735', 0, '2018-02-07 01:23:37', 'gregerchenzhien@gmail.com'),
(20, '887911', 1, '2018-02-07 02:54:48', 'hrdepart60@gmail.com'),
(21, '148447', 1, '2018-02-07 11:37:26', 'hrdepart60@gmail.com'),
(22, '161913', 1, '2018-02-07 14:21:38', 'hrdepart60@gmail.com'),
(23, '771235', 1, '2018-02-07 14:58:12', 'auditpro2231@gmail.com'),
(24, '884304', 1, '2018-02-07 15:00:52', 'hrdepart60@gmail.com'),
(25, '664931', 1, '2018-02-07 15:00:55', 'hrdepart60@gmail.com'),
(26, '779096', 1, '2018-02-07 15:09:44', 'codenewbie221@gmail.com'),
(27, '838579', 1, '2018-02-07 15:11:50', 'codenewbie221@gmail.com'),
(28, '251538', 1, '2018-02-07 21:12:42', 'codenewbie221@gmail.com'),
(29, '972018', 1, '2018-02-08 00:01:34', 'codenewbie221@gmail.com'),
(30, '159330', 1, '2018-02-08 00:10:42', 'hrdepart60@gmail.com'),
(31, '822851', 1, '2018-02-09 00:39:19', 'hrdepart60@gmail.com'),
(32, '946561', 1, '2018-02-09 00:40:18', 'hrdepart60@gmail.com'),
(33, '630804', 1, '2018-02-09 22:27:16', 'hrdepart60@gmail.com'),
(34, '906912', 1, '2018-02-09 23:08:31', 'auditpro2231@gmail.com'),
(35, '769902', 1, '2018-02-09 23:09:28', 'auditpro2231@gmail.com'),
(36, '207060', 1, '2018-02-09 23:10:28', 'auditpro2231@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `otp_resetpw`
--

CREATE TABLE `otp_resetpw` (
  `id` int(11) NOT NULL,
  `otp` varchar(10) NOT NULL,
  `is_expired` int(11) NOT NULL,
  `create_at` datetime NOT NULL,
  `cust_email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `otp_resetpw`
--

INSERT INTO `otp_resetpw` (`id`, `otp`, `is_expired`, `create_at`, `cust_email`) VALUES
(1, '412865', 1, '2018-02-08 15:30:47', 'waiqun.l@gmail.com'),
(2, '595689', 1, '2018-02-08 22:37:59', 'waiqun.l@gmail.com'),
(3, '743058', 1, '2018-02-08 22:39:48', 'waiqun.l@gmail.com'),
(4, '173410', 1, '2018-02-08 23:45:17', 'gregerchenzhien@gmail.com'),
(5, '923414', 1, '2018-02-09 00:21:07', 'jamestan99825@gmail.com'),
(6, '944662', 1, '2018-02-09 00:23:29', 'jamestan99825@gmail.com'),
(7, '936700', 1, '2018-02-09 21:59:20', 'gregerchenzhien@gmail.com'),
(8, '257095', 1, '2018-02-09 22:03:20', 'gregerchenzhien@gmail.com'),
(9, '979940', 1, '2018-02-09 22:06:06', 'gregerchenzhien@gmail.com'),
(10, '380897', 1, '2018-02-09 22:10:15', 'gregerchenzhien@gmail.com'),
(11, '878684', 1, '2018-02-09 22:17:45', 'gregerchenzhien@gmail.com'),
(12, '276097', 1, '2018-02-09 22:20:16', 'gregerchenzhien@gmail.com'),
(13, '386591', 1, '2018-02-09 22:25:31', 'gregerchenzhien@gmail.com'),
(14, '698600', 1, '2018-02-09 22:26:34', 'gregerchenzhien@gmail.com'),
(15, '347020', 0, '2018-02-09 22:26:50', 'gregerchenzhien@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `password_expiry`
--

CREATE TABLE `password_expiry` (
  `username` varchar(50) NOT NULL,
  `last_update` date NOT NULL,
  `ID` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `password_expiry`
--

INSERT INTO `password_expiry` (`username`, `last_update`, `ID`) VALUES
('greger', '2018-01-26', 1),
('greger1', '2018-02-09', 2),
('greger1', '2018-02-10', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book_info`
--
ALTER TABLE `book_info`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `custlog_info`
--
ALTER TABLE `custlog_info`
  ADD PRIMARY KEY (`custlog_id`);

--
-- Indexes for table `customer_info`
--
ALTER TABLE `customer_info`
  ADD PRIMARY KEY (`cust_id`);

--
-- Indexes for table `custotp_expiry`
--
ALTER TABLE `custotp_expiry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_info`
--
ALTER TABLE `employee_info`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `log_info`
--
ALTER TABLE `log_info`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `order_info`
--
ALTER TABLE `order_info`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `otp_expiry`
--
ALTER TABLE `otp_expiry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `otp_resetpw`
--
ALTER TABLE `otp_resetpw`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_expiry`
--
ALTER TABLE `password_expiry`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book_info`
--
ALTER TABLE `book_info`
  MODIFY `book_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `custlog_info`
--
ALTER TABLE `custlog_info`
  MODIFY `custlog_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `customer_info`
--
ALTER TABLE `customer_info`
  MODIFY `cust_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `custotp_expiry`
--
ALTER TABLE `custotp_expiry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `employee_info`
--
ALTER TABLE `employee_info`
  MODIFY `employee_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `log_info`
--
ALTER TABLE `log_info`
  MODIFY `log_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `order_info`
--
ALTER TABLE `order_info`
  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `otp_expiry`
--
ALTER TABLE `otp_expiry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `otp_resetpw`
--
ALTER TABLE `otp_resetpw`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `password_expiry`
--
ALTER TABLE `password_expiry`
  MODIFY `ID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
