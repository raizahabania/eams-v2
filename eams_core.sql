-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 17, 2023 at 01:51 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eams_core`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `activity_log_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `date_log` datetime NOT NULL DEFAULT current_timestamp(),
  `action` text NOT NULL,
  `session_id` varchar(255) NOT NULL DEFAULT '',
  `user_level` varchar(100) NOT NULL DEFAULT '0',
  `system_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`activity_log_id`, `user_id`, `date_log`, `action`, `session_id`, `user_level`, `system_id`) VALUES
(1, 1, '2022-05-16 06:08:22', 'Reset Password Admin Account:SAMPLE_REGS - DETAILS : \r\n({\"ADMIN_ID\":\"2\",\"ADMIN_NO\":\"SAMPLE_REGS\",\"FIRSTNAME\":\"SAMPLE_REGS\",\"LASTNAME\":\"LAST\",\"USERNAME\":\"SAMPLE_REGS\",\"USER_ROLE\":\"2\"})', '7484452f8fe5377df1a67a3a83e6d50bf705662458b4f799a61c6d1fd7948412', '1', 0),
(2, 1, '2022-05-16 06:09:46', 'Delete User/s - DETAILS : \r\n( SAMPLE_REGS::SAMPLE_REGS LAST::dark_devil888@yahoo.com [2] )', '7484452f8fe5377df1a67a3a83e6d50bf705662458b4f799a61c6d1fd7948412', '1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `makeup_class`
--

CREATE TABLE `makeup_class` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(250) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `section` varchar(255) DEFAULT NULL,
  `room` varchar(255) DEFAULT NULL,
  `subject_name` varchar(255) DEFAULT NULL,
  `subject_code` varchar(255) DEFAULT NULL,
  `check_remark` int(11) NOT NULL DEFAULT 0 COMMENT '0=not done\r\n1=done'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `makeup_class`
--

INSERT INTO `makeup_class` (`id`, `employee_id`, `date`, `start_time`, `end_time`, `section`, `room`, `subject_name`, `subject_code`, `check_remark`) VALUES
(1, '2019-0002', '2022-12-13', '07:30:00', '09:30:00', 'CS-1', 'Room 5', 'Data Structures and Algorithm', 'DSA101', 1),
(2, '2019-0004', '2022-12-12', '09:30:00', '11:30:00', 'CS-3', 'Room 5', 'Data Structures and Algorithm', 'DSA101', 1);

-- --------------------------------------------------------

--
-- Table structure for table `physical_checking`
--

CREATE TABLE `physical_checking` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(255) NOT NULL,
  `room` varchar(255) NOT NULL,
  `section` varchar(255) NOT NULL,
  `subject_code` varchar(255) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `date_check` datetime NOT NULL DEFAULT current_timestamp(),
  `remarks` int(11) NOT NULL COMMENT '0-schedule 1-makeup class',
  `check_status` int(50) NOT NULL COMMENT '0-checking\r\n1-present2-\r\nabsent\r\n3-not checked',
  `series_num` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `physical_checking`
--

INSERT INTO `physical_checking` (`id`, `employee_id`, `room`, `section`, `subject_code`, `date`, `date_check`, `remarks`, `check_status`, `series_num`) VALUES
(1, '2019-0001', 'B1', '', '', '2022-12-01', '2022-12-01 11:13:45', 0, 2, 'IM83-IU6Y-1K0T'),
(2, '2019-0001', 'B2', '', '', '2022-12-02', '2022-12-02 11:13:45', 0, 2, 'IM83-IU6Y-1K0T'),
(3, '2019-0004', 'A1', '', '', '2022-12-04', '2022-12-04 11:13:45', 0, 2, 'IM83-IU6Y-1K0T'),
(4, '2019-0003', 'Room 6', 'CS-2', 'GCE 401', '2022-12-12', '2022-12-12 11:13:45', 0, 2, 'IM83-IU6Y-1K0T'),
(5, '2019-0001', 'Room 6', '', '', '2022-12-05', '2022-12-13 11:13:45', 0, 2, 'IM83-IU6Y-1K0T'),
(6, '2019-0002', 'Room 5', '', '', '2022-12-05', '2022-12-13 11:13:45', 0, 2, 'IM83-IU6Y-1K0T'),
(7, '2019-0001', 'Room 5', '', '', '2022-12-06', '2022-12-13 11:13:45', 0, 2, 'IM83-IU6Y-1K0T'),
(11, '2019-01705', 'Room 5', '', '', '2022-12-06', '2022-12-13 11:13:45', 1, 2, 'IM83-IU6Y-1K0T'),
(15, '2019-0001', 'Room 5', '', '', '2022-12-07', '2022-12-07 09:09:06', 0, 2, 'IM83-IU6Y-1K0T'),
(16, '2019-0004', 'Room 5', '', '', '2022-12-07', '2022-12-07 09:05:51', 1, 1, 'OO96-EV7L-8P2Z'),
(17, '2019-0001', 'Room 5', '', '', '2022-12-07', '2022-12-07 13:48:31', 0, 1, 'G1V2-PP3O-3Q2F'),
(18, '2019-0004', 'Room 5', '', '', '2022-12-12', '2022-12-07 13:48:28', 1, 1, 'F9Z7-DE0W-3S6P'),
(19, '2019-0004', 'Room 5', '', '', '2022-12-13', '2022-12-13 11:41:40', 0, 1, 'G3V6-HD1Q-0Z8X'),
(20, '2019-0004', 'Room 5', 'CS-2', '[object HTMLInputElement]', '2022-12-13', '2022-12-13 11:46:19', 0, 2, 'G2M2-PC3X-3U8P'),
(21, '2019-0004', 'Room 5', 'CS-2', 'DSA101', '2022-12-13', '2022-12-13 14:40:16', 0, 1, 'V3P4-WL0B-0V4O'),
(22, '2019-0002', 'Room 6', 'CS-1', 'GCE 401', '2022-12-13', '2022-12-13 15:27:19', 0, 2, 'S3K1-SN0H-0X0G'),
(23, '2019-0002', 'Room 5', 'CS-1', 'DSA101', '2022-12-13', '2022-12-13 15:27:13', 1, 1, 'V2D0-XW4D-1B7I'),
(24, '2019-0002', 'Room 5', 'CS-1', 'DSA101', '2023-01-03', '2023-01-03 09:00:56', 0, 2, 'N8O3-UK9C-7N6D'),
(25, '2019-0004', 'Room 5', 'CS-2', 'DSA101', '2023-01-03', '2023-01-03 09:01:11', 0, 1, 'R8H4-IL4F-2H1H'),
(26, '2019-0001', 'Room 5', 'CS-1', 'DSA101', '2023-01-04', '2023-01-04 16:35:08', 0, 1, 'K1I7-AX7K-3F4A'),
(27, '2019-0004', 'Room 5', 'CS-3', 'DSA101', '2023-01-04', '2023-01-04 16:35:05', 0, 2, 'C3K9-OI0Q-7U9D'),
(28, '2019-0001', 'Room 5', 'CS-1', 'DSA101', '2023-01-09', '2023-01-09 07:54:49', 0, 1, 'R3A4-ZQ6G-9I3P'),
(29, '2019-0004', 'Room 5', 'CS-3', 'DSA101', '2023-01-09', '2023-01-09 07:54:56', 0, 2, 'K6A9-ZQ8M-2D8G'),
(30, '2019-0003', 'Room 6', 'CS-2', 'GCE 401', '2023-01-09', '2023-01-09 07:55:01', 0, 1, 'D9C5-IS7M-9U9R'),
(31, '2019-0004', 'Room 5', 'CS-1', 'DSA101', '2023-01-12', '2023-01-12 11:24:17', 0, 1, 'V3X5-QP0E-3D4G'),
(40, '2019-0002', 'Room 5', 'CS-1', 'DSA101', '2023-01-16', '2023-01-16 09:39:44', 0, 2, 'O0E9-OV8K-8Y1T'),
(41, '2019-0002', 'Room 5', 'CS-1', 'DSA101', '2023-01-16', '2023-01-16 09:52:11', 0, 1, 'K2T5-EM3R-2C0D'),
(42, '2019-0002', 'Room 5', 'CS-1', 'DSA101', '2023-01-16', '2023-01-16 09:54:08', 0, 1, 'L8R7-ZY8M-9B0Y'),
(43, '2019-0001', 'Room 5', 'CS-1', 'DSA101', '2023-01-16', '2023-01-16 09:55:07', 0, 1, 'L0R2-CY5P-6O1V'),
(44, '2019-0004', 'Room 5', 'CS-3', 'DSA101', '2023-01-16', '2023-01-16 09:56:30', 0, 2, 'A5R7-XK0P-8E3Y'),
(45, '2019-0003', 'Room 6', 'CS-2', 'GCE 401', '2023-01-16', '2023-01-16 09:55:17', 0, 1, 'Z2L2-AL4L-9F1T'),
(46, '2019-0002', 'Room 5', 'CS-1', 'DSA101', '2023-01-17', '2023-01-17 08:25:48', 0, 1, 'K7I9-SA7T-3Z1J'),
(47, '2019-0004', 'Room 5', 'CS-2', 'DSA101', '2023-01-17', '2023-01-17 08:25:52', 0, 1, 'P2A9-WH0S-3A5U'),
(48, '2019-0003', 'Room 5', 'CS-3', 'DSA101', '2023-01-17', '2023-01-17 08:26:02', 0, 1, 'A3I8-BH9Y-0T0U'),
(49, '2019-0002', 'Room 6', 'CS-1', 'GCE 401', '2023-01-17', '2023-01-17 08:25:58', 0, 1, 'Y5J7-TL9C-0B0Y');

-- --------------------------------------------------------

--
-- Table structure for table `reset_code`
--

CREATE TABLE `reset_code` (
  `reset_id` int(11) NOT NULL,
  `reset_code` varchar(50) NOT NULL DEFAULT '',
  `user_id` int(11) NOT NULL DEFAULT 0,
  `email_address` varchar(50) NOT NULL DEFAULT '',
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `expire_date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 0,
  `user_type` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(250) NOT NULL,
  `day` varchar(250) NOT NULL COMMENT '1-Mon\r\n2-Tue\r\n3-Wed\r\n4-Thu\r\n5-Fri\r\n6-Sat',
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `section` varchar(255) DEFAULT NULL,
  `room` varchar(255) DEFAULT NULL,
  `subject_name` varchar(255) DEFAULT NULL,
  `subject_code` varchar(255) DEFAULT NULL,
  `semester` varchar(255) NOT NULL,
  `active` int(11) NOT NULL DEFAULT 1 COMMENT '0=not active | 1= active',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `employee_id`, `day`, `start_time`, `end_time`, `section`, `room`, `subject_name`, `subject_code`, `semester`, `active`, `start_date`, `end_date`) VALUES
(1, '2019-0001', '3', '07:30:00', '09:30:00', 'CS-1', 'Room 5', 'Data Structures and Algorithm', 'DSA101', '1st Semester', 1, '2022-09-26', '2023-04-25'),
(2, '2019-0004', '2', '09:30:00', '11:30:00', 'CS-2', 'Room 5', 'Data Structures and Algorithm', 'DSA101', '1st Semester', 1, '2022-09-26', '2023-04-25'),
(3, '2019-0004', '3', '11:30:00', '01:30:00', 'CS-3', 'Room 5', 'Data Structures and Algorithm', 'DSA101', '1st Semester', 1, '2022-09-26', '2023-04-25'),
(4, '2019-0004', '4', '07:30:00', '09:30:00', 'CS-1', 'Room 5', 'Data Structures and Algorithm', 'DSA101', '1st Semester', 1, '2022-09-26', '2023-04-25'),
(5, '2019-0004', '4', '09:30:00', '11:30:00', 'CS-2', 'Room 5', 'Data Structures and Algorithm', 'DSA101', '1st Semester', 1, '2022-09-26', '2023-04-25'),
(6, '2019-0003', '2', '11:30:00', '01:30:00', 'CS-3', 'Room 5', 'Data Structures and Algorithm', 'DSA101', '1st Semester', 1, '2022-09-26', '2023-04-25'),
(7, '2019-0002', '2', '07:30:00', '09:30:00', 'CS-1', 'Room 5', 'Data Structures and Algorithm', 'DSA101', '1st Semester', 1, '2022-09-26', '2023-04-25'),
(8, '2019-0001', '1', '09:30:00', '11:30:00', 'CS-1', 'Room 5', 'Data Structures and Algorithm', 'DSA101', '1st Semester', 1, '2022-09-26', '2023-04-25'),
(9, '2019-0004', '1', '11:30:00', '01:30:00', 'CS-3', 'Room 5', 'Data Structures and Algorithm', 'DSA101', '1st Semester', 1, '2022-09-26', '2023-04-25'),
(10, '2019-0002', '2', '11:30:00', '13:30:00', 'CS-1', 'Room 6', 'Glocal Citizenship Education', 'GCE 401', '1st Semester', 1, '2022-09-26', '2023-04-25'),
(11, '2019-0003', '1', '13:30:00', '15:30:00', 'CS-2', 'Room 6', 'Glocal Citizenship Education', 'GCE 401', '1st Semester', 1, '2022-09-26', '2023-04-25');

-- --------------------------------------------------------

--
-- Table structure for table `sg_setting`
--

CREATE TABLE `sg_setting` (
  `id` int(11) NOT NULL,
  `operator` varchar(255) NOT NULL,
  `time_In` time NOT NULL,
  `time_Out` time NOT NULL,
  `building` int(11) NOT NULL COMMENT '1 - main building gate 1\r\n2 - main building gate 2\r\n3 - new building gate 1\r\n4 - new building gate 2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sg_setting`
--

INSERT INTO `sg_setting` (`id`, `operator`, `time_In`, `time_Out`, `building`) VALUES
(1, '2019-0003', '08:00:00', '17:00:00', 1),
(2, '2019-01254', '08:00:00', '17:00:00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `time_log`
--

CREATE TABLE `time_log` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(255) NOT NULL,
  `card_id` varchar(100) NOT NULL,
  `time_in` datetime DEFAULT NULL,
  `time_out` datetime DEFAULT NULL,
  `break_in` datetime DEFAULT NULL,
  `break_out` datetime DEFAULT NULL,
  `building` int(11) NOT NULL COMMENT '1 - main building gate 1\r\n2 - main building gate 2 \r\n3 - new building gate 1 \r\n4 - new building gate 2	',
  `way` varchar(10) NOT NULL,
  `date_log` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `time_log`
--

INSERT INTO `time_log` (`id`, `employee_id`, `card_id`, `time_in`, `time_out`, `break_in`, `break_out`, `building`, `way`, `date_log`) VALUES
(1, '', '1259180195', '2023-01-12 15:58:28', NULL, NULL, NULL, 0, 'onsite', '2023-01-12'),
(2, '2019-0001', '1170621265', '2023-01-12 16:01:38', '2023-01-12 16:11:05', '2023-01-12 16:10:15', '2023-01-12 16:09:50', 0, 'onsite', '2023-01-12'),
(3, '2019-0003', '0102003425', '2023-01-12 16:04:14', '2023-01-12 16:11:02', '2023-01-12 16:10:13', '2023-01-12 16:09:48', 0, 'onsite', '2023-01-12'),
(4, '2019-0004', '1163785281', '2023-01-12 16:06:55', '2023-01-12 16:11:08', '2023-01-12 16:10:18', '2023-01-12 16:10:03', 0, 'onsite', '2023-01-12'),
(5, '2019-0002', '0102857441', '2023-01-12 16:08:09', '2023-01-12 16:11:11', '2023-01-12 16:10:21', '2023-01-12 16:10:06', 0, 'onsite', '2023-01-12'),
(6, '2019-01254', '1259180195', '2023-01-13 09:42:18', '2023-01-13 10:50:56', '2023-01-13 09:42:24', NULL, 0, 'onsite', '2023-01-13'),
(7, '2019-0003', '0102003425', '2023-01-13 11:28:11', NULL, '2023-01-13 16:28:48', '2023-01-13 15:53:13', 0, 'onsite', '2023-01-13'),
(8, '2019-0001', '1170621265', '2023-01-13 11:28:14', NULL, '2023-01-13 16:29:10', '2023-01-13 15:53:24', 0, 'onsite', '2023-01-13'),
(9, '2019-0004', '1163785281', '2023-01-13 11:28:17', NULL, '2023-01-13 16:31:05', '2023-01-13 15:53:37', 1, 'onsite', '2023-01-13'),
(10, '2019-0002', '0102857441', '2023-01-13 11:28:20', NULL, '2023-01-13 16:31:02', '2023-01-13 15:53:29', 1, 'onsite', '2023-01-13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `employee_id` varchar(255) NOT NULL,
  `card_id` varchar(100) NOT NULL,
  `img` varchar(255) NOT NULL DEFAULT 'profile-img.png',
  `f_name` varchar(255) NOT NULL,
  `m_name` varchar(255) DEFAULT NULL,
  `l_name` varchar(255) NOT NULL,
  `suffix` varchar(255) DEFAULT NULL,
  `user_role` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `locked` int(11) NOT NULL,
  `flag_employee` int(11) NOT NULL COMMENT '0 - employee\r\n1 - user only',
  `last_signin` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `employee_id`, `card_id`, `img`, `f_name`, `m_name`, `l_name`, `suffix`, `user_role`, `username`, `password`, `email_address`, `position`, `status`, `locked`, `flag_employee`, `last_signin`) VALUES
(1, '2019-0001', '1170621265', 'profile-img.png', 'Landon', '', 'Adriatico', '', 1, 'admin', 'b9c37d31b839993b4fb537335cba0d3a2406b2be', 'admin@gmail.com', 'Teaching Personnel', 0, 0, 0, NULL),
(2, '2019-0002', '0102857441', 'profile-img.png', 'John', '', 'Paunlagi', '', 2, 'admin_staff', '5c41e0f33419041e5bd0631205ea05e590a99009', 'adminstaff@gmail.com', 'Teaching Personnel', 0, 0, 0, NULL),
(3, '2019-0003', '0102003425', 'profile-img.png', 'Marlon', '', 'Reolo', '', 3, 'onsite', 'a03973f44ba83a2648ecdd97c1f5b2727a0800ae', 'onsite@gmail.com', 'Teaching Personnel', 0, 0, 1, NULL),
(4, '2019-0004', '1163785281', 'profile-img.png', 'Ryzen', '', 'Budejas', '', 4, 'end_user', 'e27ac7ceeba81dc5384ddfa4557a647a104a5b77', 'enduser@gmail.com', 'Non-Teaching Personnel', 0, 0, 0, NULL),
(6, '2019-2564', '445431231', 'profile-img.png', 'Marlon', '', 'Reolo', '', 4, 'username04', '32afb0427e9010f40b4d2e85a5dd700fc0f11609', 'email0411@gmail.com', 'Teaching Personnel', 0, 0, 0, NULL),
(7, '2019-01254', '1259180195', 'profile-img.png', 'Operator', '', 'Two', '', 3, 'operator2', '5cd47b2169613aab59241854ca86ed90ff9a5282', 'operator@gmail.com', 'Non-Teaching Personnel', 0, 0, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

CREATE TABLE `user_log` (
  `user_log_id` int(11) NOT NULL,
  `login_date` datetime NOT NULL,
  `logout_date` datetime NOT NULL,
  `action` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `session_id` varchar(100) NOT NULL,
  `ip_address` varchar(20) NOT NULL,
  `device` varchar(255) NOT NULL,
  `system_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_log`
--

INSERT INTO `user_log` (`user_log_id`, `login_date`, `logout_date`, `action`, `user_id`, `session_id`, `ip_address`, `device`, `system_id`) VALUES
(1, '2022-05-16 05:44:34', '2022-05-16 05:45:46', 'LOGIN', 1, '654faac42003f64c70203ed26c20191d278b97f44f5e3916e3dd54cb76a8f7e7', '::1', '{\"device\":\"Chrome\",\"version\":\"101.0.4951.54\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 101.0.4951.54 on Windows 10 64-bit\"}', 0),
(2, '2022-05-16 05:45:22', '2022-05-16 05:45:46', 'LOGIN', 1, '654faac42003f64c70203ed26c20191d278b97f44f5e3916e3dd54cb76a8f7e7', '::1', '{\"device\":\"Chrome\",\"version\":\"101.0.4951.54\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 101.0.4951.54 on Windows 10 64-bit\"}', 0),
(3, '2022-05-16 05:46:56', '2022-05-16 06:04:49', 'LOGIN', 1, '91fb6aa2a34f2cafc6c94880a00020301a0e957cb8e33639a2ea45a61b4cd35a', '::1', '{\"device\":\"Chrome\",\"version\":\"101.0.4951.54\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 101.0.4951.54 on Windows 10 64-bit\"}', 0),
(4, '2022-05-16 06:05:00', '2022-05-16 06:10:22', 'LOGIN', 1, '7484452f8fe5377df1a67a3a83e6d50bf705662458b4f799a61c6d1fd7948412', '::1', '{\"device\":\"Chrome\",\"version\":\"101.0.4951.54\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 101.0.4951.54 on Windows 10 64-bit\"}', 0),
(5, '2022-10-20 15:40:19', '2022-10-20 15:40:31', 'LOGIN', 1, '8e4938c141531f2819e3081cb89d6749f8a2246032a4e36be1072b2868d761b5', '::1', '{\"device\":\"Chrome\",\"version\":\"106.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 106.0.0.0 on Windows 10 64-bit\"}', 0),
(6, '2022-10-20 15:42:50', '2022-10-20 15:42:57', 'LOGIN', 1, '3ccf2545ba72ae36402bc732a83a108317269d0b41a39ab92870310a2ee02a3e', '::1', '{\"device\":\"Chrome\",\"version\":\"106.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 106.0.0.0 on Windows 10 64-bit\"}', 0),
(7, '2022-10-20 15:45:34', '2022-10-20 15:46:23', 'LOGIN', 1, '2b5528b9663d3bf35628c296169b267082b61a81dd759e7fc873f743bba078b7', '::1', '{\"device\":\"Chrome\",\"version\":\"106.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 106.0.0.0 on Windows 10 64-bit\"}', 0),
(8, '2022-10-20 15:46:29', '2022-10-20 15:50:28', 'LOGIN', 1, 'd87516b9e588adc00fc20c60f178296916e4c85139b1cc2d559247749ff3e7ba', '::1', '{\"device\":\"Chrome\",\"version\":\"106.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 106.0.0.0 on Windows 10 64-bit\"}', 0),
(9, '2022-10-20 15:50:33', '2022-10-20 15:51:01', 'LOGIN', 1, '1902dec0fc1e83c789656efc03c8c72ba07e49c74deedb0c2e73d70402c2880d', '::1', '{\"device\":\"Chrome\",\"version\":\"106.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 106.0.0.0 on Windows 10 64-bit\"}', 0),
(10, '2022-10-20 15:51:08', '2022-10-20 15:56:57', 'LOGIN', 1, 'a95edb4572bc5934c5749e3b2052cdcd6f5042a285e76e16a28d02cb86af718c', '::1', '{\"device\":\"Chrome\",\"version\":\"106.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 106.0.0.0 on Windows 10 64-bit\"}', 0),
(11, '2022-10-20 15:57:17', '0000-00-00 00:00:00', 'LOGIN', 1, 'a859306f62a31e14cc4434934eeb6c5ebf62e3acdd5319140db903b4fc8a6255', '::1', '{\"device\":\"Chrome\",\"version\":\"106.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 106.0.0.0 on Windows 10 64-bit\"}', 0),
(12, '2022-10-20 15:59:56', '0000-00-00 00:00:00', 'LOGIN', 1, 'a859306f62a31e14cc4434934eeb6c5ebf62e3acdd5319140db903b4fc8a6255', '::1', '{\"device\":\"Chrome\",\"version\":\"106.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 106.0.0.0 on Windows 10 64-bit\"}', 0),
(13, '2022-10-20 16:03:48', '0000-00-00 00:00:00', 'LOGIN', 1, 'a859306f62a31e14cc4434934eeb6c5ebf62e3acdd5319140db903b4fc8a6255', '::1', '{\"device\":\"Chrome\",\"version\":\"106.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 106.0.0.0 on Windows 10 64-bit\"}', 0),
(14, '2022-10-20 16:04:38', '0000-00-00 00:00:00', 'LOGIN', 1, 'a859306f62a31e14cc4434934eeb6c5ebf62e3acdd5319140db903b4fc8a6255', '::1', '{\"device\":\"Chrome\",\"version\":\"106.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 106.0.0.0 on Windows 10 64-bit\"}', 0),
(15, '2022-10-20 16:04:42', '0000-00-00 00:00:00', 'LOGIN', 1, 'a859306f62a31e14cc4434934eeb6c5ebf62e3acdd5319140db903b4fc8a6255', '::1', '{\"device\":\"Chrome\",\"version\":\"106.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 106.0.0.0 on Windows 10 64-bit\"}', 0),
(16, '2022-10-20 16:06:06', '0000-00-00 00:00:00', 'LOGIN', 1, 'a859306f62a31e14cc4434934eeb6c5ebf62e3acdd5319140db903b4fc8a6255', '::1', '{\"device\":\"Chrome\",\"version\":\"106.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 106.0.0.0 on Windows 10 64-bit\"}', 0),
(17, '2022-10-20 16:06:20', '0000-00-00 00:00:00', 'LOGIN', 1, 'a859306f62a31e14cc4434934eeb6c5ebf62e3acdd5319140db903b4fc8a6255', '::1', '{\"device\":\"Chrome\",\"version\":\"106.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 106.0.0.0 on Windows 10 64-bit\"}', 0),
(18, '2022-10-20 16:12:50', '0000-00-00 00:00:00', 'LOGIN', 1, '20eca632fd1b24bb36c1637cb67c5ad79ec054a7368b4277d6f5ec35caaa67f1', '::1', '{\"device\":\"Chrome\",\"version\":\"106.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 106.0.0.0 on Windows 10 64-bit\"}', 0),
(19, '2022-10-20 16:24:28', '0000-00-00 00:00:00', 'LOGIN', 1, 'a3eaa3c369ae5d67897fee081d73f94251d28598723d736406f3d1521d014c97', '::1', '{\"device\":\"Chrome Mobile\",\"version\":\"106.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":32,\"family\":\"Android\",\"version\":\"6.0\"},\"description\":\"Chrome Mobile 106.0.0.0 on Google Nexus 5 (Android 6.0)\"}', 0),
(20, '2022-10-20 16:26:03', '0000-00-00 00:00:00', 'LOGIN', 1, 'a3eaa3c369ae5d67897fee081d73f94251d28598723d736406f3d1521d014c97', '::1', '{\"device\":\"Chrome Mobile\",\"version\":\"106.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":32,\"family\":\"Android\",\"version\":\"6.0\"},\"description\":\"Chrome Mobile 106.0.0.0 on Google Nexus 5 (Android 6.0)\"}', 0),
(21, '2022-10-20 16:27:03', '0000-00-00 00:00:00', 'LOGIN', 1, 'a3eaa3c369ae5d67897fee081d73f94251d28598723d736406f3d1521d014c97', '::1', '{\"device\":\"Chrome Mobile\",\"version\":\"106.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":32,\"family\":\"Android\",\"version\":\"6.0\"},\"description\":\"Chrome Mobile 106.0.0.0 on Google Nexus 5 (Android 6.0)\"}', 0),
(22, '2022-10-20 16:34:05', '0000-00-00 00:00:00', 'LOGIN', 1, 'b786d375a8c2c4fa02bdfbb72557f47b72de0d4e91418d158152be1bafc0ab82', '::1', '{\"device\":\"Chrome Mobile\",\"version\":\"106.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":32,\"family\":\"Android\",\"version\":\"6.0\"},\"description\":\"Chrome Mobile 106.0.0.0 on Google Nexus 5 (Android 6.0)\"}', 0),
(23, '2022-10-20 16:34:51', '0000-00-00 00:00:00', 'LOGIN', 1, 'a0f30800dcb1d2820d4a73084cdba4c6322bcbc8769faa02ba53b205a1452a5e', '::1', '{\"device\":\"Chrome\",\"version\":\"106.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 106.0.0.0 on Windows 10 64-bit\"}', 0),
(24, '2022-10-20 16:35:09', '0000-00-00 00:00:00', 'LOGIN', 1, 'a0f30800dcb1d2820d4a73084cdba4c6322bcbc8769faa02ba53b205a1452a5e', '::1', '{\"device\":\"Chrome\",\"version\":\"106.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 106.0.0.0 on Windows 10 64-bit\"}', 0),
(25, '2022-10-20 16:37:14', '0000-00-00 00:00:00', 'LOGIN', 1, 'a0f30800dcb1d2820d4a73084cdba4c6322bcbc8769faa02ba53b205a1452a5e', '::1', '{\"device\":\"Chrome\",\"version\":\"106.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 106.0.0.0 on Windows 10 64-bit\"}', 0),
(26, '2022-10-20 16:39:55', '0000-00-00 00:00:00', 'LOGIN', 1, 'a0f30800dcb1d2820d4a73084cdba4c6322bcbc8769faa02ba53b205a1452a5e', '::1', '{\"device\":\"Chrome\",\"version\":\"106.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 106.0.0.0 on Windows 10 64-bit\"}', 0),
(27, '2022-11-07 09:06:06', '0000-00-00 00:00:00', 'LOGIN', 1, '0b0fa22fba44a91d4345f16597fea28d4408449abb14e1d080617c7bdbaf328b', '::1', '{\"device\":\"Chrome\",\"version\":\"106.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 106.0.0.0 on Windows 10 64-bit\"}', 0),
(28, '2022-11-07 09:06:44', '0000-00-00 00:00:00', 'LOGIN', 1, '0b0fa22fba44a91d4345f16597fea28d4408449abb14e1d080617c7bdbaf328b', '::1', '{\"device\":\"Chrome\",\"version\":\"106.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 106.0.0.0 on Windows 10 64-bit\"}', 0),
(29, '2022-11-07 09:37:52', '2022-11-07 09:39:09', 'LOGIN', 3, '0249b94ad096e15160d73e8916a41a68582d9213c45b22e917d5cd3055a3f971', '::1', '[]', 0),
(30, '2022-11-07 09:39:14', '2022-11-07 09:42:26', 'LOGIN', 3, '0d755a4795e8cf5349faed8e9d2a103c80885d6b5ed2f46a69ab6d4d2257e5b2', '::1', '[]', 0),
(31, '2022-11-07 09:42:42', '2022-11-07 09:42:47', 'LOGIN', 3, '3a3d9411c57c9e0cba55e635f65e5f470323bbf1638578fc43f5df279dca3a7c', '::1', '[]', 0),
(32, '2022-11-07 10:08:38', '0000-00-00 00:00:00', 'LOGIN', 3, 'b24642562dfa26f2da960d1788ff797878ab9601c304fcd0099d55039c52bdff', '::1', '[]', 0),
(33, '2022-11-07 10:12:12', '0000-00-00 00:00:00', 'LOGIN', 3, '270f2f93a012b603c61b8335272d570da0dac8743cb0e8e3dcc20fff5fb313b4', '::1', '[]', 0),
(34, '2022-11-07 12:49:05', '0000-00-00 00:00:00', 'LOGIN', 1, '9345d3faf8fecc5fa7e01fa4845190bd948a80feec4d0a6d52463302f754fcdb', '::1', '[]', 0),
(35, '2022-11-07 13:19:02', '0000-00-00 00:00:00', 'LOGIN', 1, '3f53c6828a7afece9bb2c8fe0d7e1d0c6ea17659dbef3c8b1731e9826c137330', '::1', '[]', 0),
(36, '2022-11-07 13:26:11', '0000-00-00 00:00:00', 'LOGIN', 1, '8e72c6ec81ad41759441cc7d53071f699fe2b54a565c476acc3204a43d708387', '::1', '[]', 0),
(37, '2022-11-07 13:26:41', '0000-00-00 00:00:00', 'LOGIN', 1, '8e72c6ec81ad41759441cc7d53071f699fe2b54a565c476acc3204a43d708387', '::1', '[]', 0),
(38, '2022-11-07 13:27:57', '0000-00-00 00:00:00', 'LOGIN', 1, '1b7d204e917bbc097f9d9c0a29b89cb62b0216aa64239c4694afeb7d833d833b', '::1', '[]', 0),
(39, '2022-11-07 13:29:18', '0000-00-00 00:00:00', 'LOGIN', 1, '1b7d204e917bbc097f9d9c0a29b89cb62b0216aa64239c4694afeb7d833d833b', '::1', '[]', 0),
(40, '2022-11-07 13:30:21', '0000-00-00 00:00:00', 'LOGIN', 1, '1b7d204e917bbc097f9d9c0a29b89cb62b0216aa64239c4694afeb7d833d833b', '::1', '[]', 0),
(41, '2022-11-07 13:31:14', '0000-00-00 00:00:00', 'LOGIN', 1, 'e79eedbbc7abf38e769336e652cd230179d7b0719198d0aabae6fd8efc91583d', '::1', '[]', 0),
(42, '2022-11-07 13:31:27', '0000-00-00 00:00:00', 'LOGIN', 1, '5a5477e1ef3cad313254e5935e420bcaa74d76f44f7edbf8999ce7e8395f6880', '::1', '[]', 0),
(43, '2022-11-07 13:38:46', '0000-00-00 00:00:00', 'LOGIN', 1, 'cd8cd8e7712f62478fee16de820dcd8e75959a62ec37a65acab30106e89c9092', '::1', '[]', 0),
(44, '2022-11-07 13:47:19', '0000-00-00 00:00:00', 'LOGIN', 1, 'dbfe1ed998008390075c537d98574acc84d99d77e8d84cf8aa35640e333e0031', '::1', '[]', 0),
(45, '2022-11-07 13:53:18', '0000-00-00 00:00:00', 'LOGIN', 1, '98044176a2445e896fe9a6c7c270565aa4dcb61a4a7b7e88afd17d083232db4a', '::1', '[]', 0),
(46, '2022-11-07 14:11:13', '0000-00-00 00:00:00', 'LOGIN', 1, '4b6776d744ea907e9252e3755378381bbcc2bdb09f9ac57312eb9cb221343206', '::1', '[]', 0),
(47, '2022-11-07 14:11:21', '0000-00-00 00:00:00', 'LOGIN', 1, '529f567dfdc8b73ed08fa68062945846aa07e1dc3d6134f7d85e9bb4ed1fb59e', '::1', '[]', 0),
(48, '2022-11-07 14:22:16', '0000-00-00 00:00:00', 'LOGIN', 1, '7fcfd474650a4fa2312f8642037174b8c78ac436a5a30b49881e78259a42adca', '::1', '[]', 0),
(49, '2022-11-07 14:29:46', '0000-00-00 00:00:00', 'LOGIN', 1, 'a91be4a9ff424cb0bffd1e5600d4aeda4efcfb02f2933237a542f8e76b3a4c2f', '::1', '[]', 0),
(50, '2022-11-07 14:33:02', '0000-00-00 00:00:00', 'LOGIN', 1, '8d1a8493092a30dc07d2bc54b0dbb16efa9bd50f18783ab390a53a217a34b1c7', '::1', '[]', 0),
(51, '2022-11-07 14:47:56', '0000-00-00 00:00:00', 'LOGIN', 5, '86ce2729bd76a4997d8b827499efb72560b75063e269f45f0b256ce6ddb58579', '::1', '[]', 0),
(52, '2022-11-07 14:49:37', '0000-00-00 00:00:00', 'LOGIN', 5, 'b888b736b7a26319b3cb64327e8f2c8d5bb3f55022c78386da7ea593b42ce8aa', '::1', '[]', 0),
(53, '2022-11-07 14:49:47', '0000-00-00 00:00:00', 'LOGIN', 5, 'e4e367efd3f1e27b86f7d21c7f6571c6464a50e4df2543ae4f6e22a6548c76f2', '::1', '[]', 0),
(54, '2022-11-07 14:58:11', '0000-00-00 00:00:00', 'LOGIN', 5, '2883f51fc3e70fa50ee43689096d6629531ee24533901296e874667b0922f64c', '::1', '[]', 0),
(55, '2022-11-07 15:02:30', '0000-00-00 00:00:00', 'LOGIN', 5, '2883f51fc3e70fa50ee43689096d6629531ee24533901296e874667b0922f64c', '::1', '[]', 0),
(56, '2022-11-07 15:02:57', '0000-00-00 00:00:00', 'LOGIN', 5, '001f5b921f315b021b0750d6a9ced5b6d3bb5b465569421babe7f064cc3c4d6a', '::1', '[]', 0),
(57, '2022-11-07 15:11:57', '0000-00-00 00:00:00', 'LOGIN', 5, 'bdb0c61b1ea80e2a086f68a22d1b4dc2640923ca3b091ada39d645c2a4136aa4', '::1', '[]', 0),
(58, '2022-11-07 15:26:23', '0000-00-00 00:00:00', 'LOGIN', 3, 'b57deaf2eea0cb0e9c55f7ed422b382068fd9e44c3770f3a8c8d65ce21786aa0', '::1', '[]', 0),
(59, '2022-11-07 15:26:55', '0000-00-00 00:00:00', 'LOGIN', 3, '54d876a605d7f406a644bd092810e7c1a281023b2514452e31062a8c8ba15923', '::1', '[]', 0),
(60, '2022-11-07 15:27:19', '0000-00-00 00:00:00', 'LOGIN', 3, '54d876a605d7f406a644bd092810e7c1a281023b2514452e31062a8c8ba15923', '::1', '[]', 0),
(61, '2022-11-07 15:32:41', '0000-00-00 00:00:00', 'LOGIN', 3, '885de54440cd00b083cc6db03b16c119179bc1d285ef3b04386ae78d485662b8', '::1', '[]', 0),
(62, '2022-11-07 15:36:33', '0000-00-00 00:00:00', 'LOGIN', 3, '1c101e0b9c7f8b0c34174bbfe51fcbf23dd5b993139ea3f418e58d356bdd37b8', '::1', '[]', 0),
(63, '2022-11-07 16:06:19', '0000-00-00 00:00:00', 'LOGIN', 1, 'abd3c2584b955ff7efec084d780f41aaebbe0dc7872ec83e01089a44a48d4a5d', '::1', '[]', 0),
(64, '2022-11-07 16:06:42', '0000-00-00 00:00:00', 'LOGIN', 3, 'abd3c2584b955ff7efec084d780f41aaebbe0dc7872ec83e01089a44a48d4a5d', '::1', '[]', 0),
(65, '2022-11-07 16:19:00', '0000-00-00 00:00:00', 'LOGIN', 3, '43cd9974874e42c8ea3730d4f3f0ce0d71d644f2d8fe94551ea085d2899228f1', '::1', '[]', 0),
(66, '2022-11-07 16:19:25', '0000-00-00 00:00:00', 'LOGIN', 3, 'a66e7ed19507ee81a1b8a45e40045a640c880b196bb573eebf1d768bde43290e', '::1', '[]', 0),
(67, '2022-11-07 16:25:51', '0000-00-00 00:00:00', 'LOGIN', 3, 'c02c38df6c25ec0cc8a6a887aca84edad4b9e51d8fb692edc98353ac67ac2ec4', '::1', '[]', 0),
(68, '2022-11-07 16:27:51', '0000-00-00 00:00:00', 'LOGIN', 3, 'c02c38df6c25ec0cc8a6a887aca84edad4b9e51d8fb692edc98353ac67ac2ec4', '::1', '[]', 0),
(69, '2022-11-07 16:46:01', '0000-00-00 00:00:00', 'LOGIN', 3, '35b251abf27c649aa1901e593cc0c1764f5da76d21a556ce9e1794e512916a27', '::1', '[]', 0),
(70, '2022-11-07 16:48:38', '0000-00-00 00:00:00', 'LOGIN', 3, 'f4a8be7549bb8a1bfb363d3322398e0fc491bd704d5d59bb04bf1b7d178a458a', '::1', '[]', 0),
(71, '2022-11-07 16:50:48', '0000-00-00 00:00:00', 'LOGIN', 3, 'a6e68574c525880ecefe837834452f772b244657d6246de001b82e947ab09792', '::1', '[]', 0),
(72, '2022-11-07 16:55:49', '0000-00-00 00:00:00', 'LOGIN', 3, 'ad22425f5054909101ad8fc138eb5a969bbfcf16a76212ec5d576f7ce77daad5', '::1', '[]', 0),
(73, '2022-11-07 16:56:21', '0000-00-00 00:00:00', 'LOGIN', 3, '12c4dcb45ef35bee983cc2ad472f84fa078b9dde9e382d74db98c3ea62eaac95', '::1', '[]', 0),
(74, '2022-11-07 16:58:40', '0000-00-00 00:00:00', 'LOGIN', 3, 'bb6ff139a027af99a1dddbc24cb7b5c2979caf4c24bfa8cc2b158bf91a4ec123', '::1', '[]', 0),
(75, '2022-11-07 16:59:36', '0000-00-00 00:00:00', 'LOGIN', 3, 'f923393db2172e598aa3195402b5e535f6ed759d9e54b0abec5dcfa5a83e5b90', '::1', '[]', 0),
(76, '2022-11-08 10:00:14', '0000-00-00 00:00:00', 'LOGIN', 3, '3cbcfaed0cab8178250361cb5a3ff90c387717f042905cfcdb5a090bb549a0ff', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(77, '2022-11-08 10:00:15', '0000-00-00 00:00:00', 'LOGIN', 3, '3cbcfaed0cab8178250361cb5a3ff90c387717f042905cfcdb5a090bb549a0ff', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(78, '2022-11-08 10:00:17', '0000-00-00 00:00:00', 'LOGIN', 3, '3cbcfaed0cab8178250361cb5a3ff90c387717f042905cfcdb5a090bb549a0ff', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(79, '2022-11-08 10:00:17', '0000-00-00 00:00:00', 'LOGIN', 3, '3cbcfaed0cab8178250361cb5a3ff90c387717f042905cfcdb5a090bb549a0ff', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(80, '2022-11-08 10:00:17', '0000-00-00 00:00:00', 'LOGIN', 3, '3cbcfaed0cab8178250361cb5a3ff90c387717f042905cfcdb5a090bb549a0ff', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(81, '2022-11-08 10:00:17', '0000-00-00 00:00:00', 'LOGIN', 3, '3cbcfaed0cab8178250361cb5a3ff90c387717f042905cfcdb5a090bb549a0ff', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(82, '2022-11-08 10:00:17', '0000-00-00 00:00:00', 'LOGIN', 3, '3cbcfaed0cab8178250361cb5a3ff90c387717f042905cfcdb5a090bb549a0ff', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(83, '2022-11-08 10:00:30', '0000-00-00 00:00:00', 'LOGIN', 3, 'aff8a772f81f2905ea4e21105471d988da994b91ad4bac026e274ede6883ded3', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(84, '2022-11-08 10:00:59', '0000-00-00 00:00:00', 'LOGIN', 3, '4f040a05ad1903ea44fd41aa77b012061d1c924d37a5d2c10a55c194637640b3', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(85, '2022-11-08 10:02:32', '0000-00-00 00:00:00', 'LOGIN', 3, '184d055ac9942067f1d9d7010945c1233259bcf1528919a845b95799485466cf', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(86, '2022-11-08 10:06:07', '0000-00-00 00:00:00', 'LOGIN', 3, 'ed7d343680bf82ba76644bededba51a8e064e56b24590c8ab79347fa8a1e0a3c', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(87, '2022-11-08 10:06:52', '0000-00-00 00:00:00', 'LOGIN', 3, 'bf88d37819ca2f01ad91b5c6a266c6d1519671bfdb1555ba38b7979ccd821b64', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(88, '2022-11-08 10:07:42', '0000-00-00 00:00:00', 'LOGIN', 3, 'ce8af7fa636ce7749522d5a05b8ef3a953958341a26290550709b69ba7316b32', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(89, '2022-11-08 10:08:01', '0000-00-00 00:00:00', 'LOGIN', 3, '09cb90a344a4fab1fe1f92bf33e28877df705cbe2e751f60f29574c1b4f22c58', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(90, '2022-11-08 10:08:36', '0000-00-00 00:00:00', 'LOGIN', 3, 'd822024704fa8ec5eef0cd22588ccd6576b803bd060d126e533395d650287720', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(91, '2022-11-08 10:09:47', '0000-00-00 00:00:00', 'LOGIN', 3, '36b295bae9d0dc44cd4e45acc5f4645a0056967ffb0a02b616107e33aaf4f923', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(92, '2022-11-08 10:09:56', '0000-00-00 00:00:00', 'LOGIN', 3, '056ca82c4580727c71dc1af756c8ace6b6c18a1a7c8ce497ab1e7183c66519f9', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(93, '2022-11-08 10:10:07', '0000-00-00 00:00:00', 'LOGIN', 3, 'ec1d0339813d687fb670c6b5f8f376dcda350994540cf3bdcac0698c17f66067', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(94, '2022-11-08 10:24:50', '0000-00-00 00:00:00', 'LOGIN', 3, '0733a6d10eae7e93801ec896d4590359016046d6b0fedb36fbb3c7c82ac7cfac', '::1', '{\"device\":\"Chrome Mobile\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":32,\"family\":\"Android\",\"version\":\"6.0\"},\"description\":\"Chrome Mobile 107.0.0.0 on Google Nexus 5 (Android 6.0)\"}', 0),
(95, '2022-11-08 10:41:35', '0000-00-00 00:00:00', 'LOGIN', 3, '2ba6421a06de6126be20ff0940fa8eb4a2648b2011ede8d3a738a07ba11f2de3', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(96, '2022-11-08 10:41:44', '0000-00-00 00:00:00', 'LOGIN', 3, '87d9b9b9efe39a73e11c594811ceb1f3e71c3571b1c9e4a32c033da89c2d96b8', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(97, '2022-11-08 10:41:54', '0000-00-00 00:00:00', 'LOGIN', 3, 'a2b405fa19051079e95ea2feee5d2d6007379cccf61e8defd4b8237deb826da9', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(98, '2022-11-08 10:42:02', '0000-00-00 00:00:00', 'LOGIN', 3, '1cb47b6262355ac68d421b86959021e70aef871ff76f8d1a487a524046bee627', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(99, '2022-11-08 10:43:30', '0000-00-00 00:00:00', 'LOGIN', 3, '26a8a3d9c0996a07ba62049f52c0928389d4524b148bc68fd1e320581253c459', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(100, '2022-11-08 13:22:40', '0000-00-00 00:00:00', 'LOGIN', 3, '3611eb20bf57eaa2f11ae94774b01664b0a4996c56411a122394cbb2bdba084b', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(101, '2022-11-08 14:31:06', '0000-00-00 00:00:00', 'LOGIN', 3, 'bd7ce43392a8b711f15fa898e88673b26bab31ba64a10c1ac850213fdb2424af', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(102, '2022-11-08 14:31:06', '0000-00-00 00:00:00', 'LOGIN', 3, 'bd7ce43392a8b711f15fa898e88673b26bab31ba64a10c1ac850213fdb2424af', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(103, '2022-11-08 14:59:02', '0000-00-00 00:00:00', 'LOGIN', 3, 'c34d49344daaa0cfaab9f4de9abe715b2fb592f891f139d6e724c96afc04afec', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(104, '2022-11-08 16:36:23', '0000-00-00 00:00:00', 'LOGIN', 3, 'd4abd9008d53e2c10fd78405a0b4eb6b2b1016525312465177c15e4926186f5f', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(105, '2022-11-22 10:20:01', '0000-00-00 00:00:00', 'LOGIN', 2, '3cdfa0bd2adfc792cfdaab3bce9f50f04ac9b7cc99018d32e1dd8cfc74717816', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(106, '2022-11-22 10:21:28', '0000-00-00 00:00:00', 'LOGIN', 2, '3cdfa0bd2adfc792cfdaab3bce9f50f04ac9b7cc99018d32e1dd8cfc74717816', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(107, '2022-11-22 10:26:55', '0000-00-00 00:00:00', 'LOGIN', 2, '3387deaf1862f59edfedf2458d51fbf9ca98110ad39060b36089f57d0b8590ea', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(108, '2022-11-22 10:27:00', '0000-00-00 00:00:00', 'LOGIN', 2, '3387deaf1862f59edfedf2458d51fbf9ca98110ad39060b36089f57d0b8590ea', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(109, '2022-11-22 10:28:13', '0000-00-00 00:00:00', 'LOGIN', 2, '3387deaf1862f59edfedf2458d51fbf9ca98110ad39060b36089f57d0b8590ea', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(110, '2022-11-22 10:32:32', '0000-00-00 00:00:00', 'LOGIN', 2, '065014609eb24baff1ac7bd08e75c26391d337e1c98545388b6a6889bd03fd28', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(111, '2022-11-22 10:42:33', '0000-00-00 00:00:00', 'LOGIN', 2, '1fb6ec16cad8f5022ac9ffefc5df5e9fc009d0d08ae24feef87b5bb9d300ce78', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(112, '2022-11-22 10:43:27', '0000-00-00 00:00:00', 'LOGIN', 2, '037d940b8b39d4a9b4972b49ab43a277116dd4b0c542403c2e3e3f305248d3a0', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(113, '2022-11-22 13:31:57', '0000-00-00 00:00:00', 'LOGIN', 2, '3c738037d886b3adfe0bc57b6f27f47b050cc555431467d5862b7b5961d256ed', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(114, '2022-11-22 14:13:25', '0000-00-00 00:00:00', 'LOGIN', 2, 'd7c5dd902cee79325340ce05af32ef8414b9a7c0ea924da08e75184c8c917ff3', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(115, '2022-11-22 16:16:58', '0000-00-00 00:00:00', 'LOGIN', 2, 'addc66aa8324bad054fc668c775b0d8e2dae5ba499a8a0d73337abb3ef131213', '::1', '{\"device\":\"Microsoft Edge\",\"version\":\"107.0.1418.52\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Microsoft Edge 107.0.1418.52 on Windows 10 64-bit\"}', 0),
(116, '2022-11-22 16:17:26', '0000-00-00 00:00:00', 'LOGIN', 2, '08093dd256aa7f1f3639d8b6ce2c32d696951c5fd6dcdfa0b1089f1c03c46937', '::1', '{\"device\":\"Microsoft Edge\",\"version\":\"107.0.1418.52\",\"layout\":\"Blink\",\"os\":{\"architecture\":32,\"family\":\"Android\",\"version\":\"6.0\"},\"description\":\"Microsoft Edge 107.0.1418.52 on Google Nexus 5 (Android 6.0)\"}', 0),
(117, '2022-11-23 08:20:36', '0000-00-00 00:00:00', 'LOGIN', 2, '1fe53a97f90db030d9f60187d3f419f4dc654eb696860d6e1cb43c983c69a96b', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(118, '2022-11-23 10:24:17', '0000-00-00 00:00:00', 'LOGIN', 1, '22a1a47380f6c9f73ff4dda949776cb63333276e17e4487a2ca9fd5c66c86f4e', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(119, '2022-11-23 10:25:41', '0000-00-00 00:00:00', 'LOGIN', 3, '22a1a47380f6c9f73ff4dda949776cb63333276e17e4487a2ca9fd5c66c86f4e', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(120, '2022-11-23 10:31:24', '0000-00-00 00:00:00', 'LOGIN', 2, 'd22d2b73760331821db9f989e0719134502be053b31a60bd84f4dd70615cde0f', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(121, '2022-11-23 10:32:21', '0000-00-00 00:00:00', 'LOGIN', 2, 'd22d2b73760331821db9f989e0719134502be053b31a60bd84f4dd70615cde0f', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(122, '2022-11-23 10:32:29', '0000-00-00 00:00:00', 'LOGIN', 2, 'd22d2b73760331821db9f989e0719134502be053b31a60bd84f4dd70615cde0f', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(123, '2022-11-23 10:35:57', '0000-00-00 00:00:00', 'LOGIN', 2, '76dc815e869b812a66fb14aa73885b5fddc7e3b3af8a6d518048bb4af4b73a3b', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(124, '2022-11-23 10:36:26', '0000-00-00 00:00:00', 'LOGIN', 2, '76dc815e869b812a66fb14aa73885b5fddc7e3b3af8a6d518048bb4af4b73a3b', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(125, '2022-11-23 10:56:14', '0000-00-00 00:00:00', 'LOGIN', 3, 'e9a7fce516e5a0c8808df41f3cacd9db9c8f308f91e9fa211ed625f5c48c21bf', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(126, '2022-11-23 11:00:27', '0000-00-00 00:00:00', 'LOGIN', 2, 'df6a6985c4de768003c790aecaec17c749947f4cac08ba2df1cbd26a81c1ebb2', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(127, '2022-11-23 11:13:07', '0000-00-00 00:00:00', 'LOGIN', 3, 'f869801454f0a61274a0651dfe7dfd330a35fd6b3feca4b9e0edd1af47704ae0', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(128, '2022-11-23 11:34:26', '0000-00-00 00:00:00', 'LOGIN', 2, '309bfba4280375a606a92a780f765ef0bb1fcc86be175c6d08272552b42cb9d4', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(129, '2022-11-23 13:15:15', '0000-00-00 00:00:00', 'LOGIN', 2, '276b2b59e1a81def1359e38edc5983d657555510b613d8ded86e68817a07fb2d', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(130, '2022-11-23 13:26:52', '0000-00-00 00:00:00', 'LOGIN', 2, '4ad1da9c86c78c23aa0d85e63aefef86ae10e384fcaa0551c5505a5fc663573f', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(131, '2022-11-23 13:38:56', '2022-11-23 13:39:08', 'LOGIN', 1, '2c0b46829b16e65ac111a5786810ec46dae89ae75535be5f96661261a00a6dc3', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(132, '2022-11-23 13:39:13', '0000-00-00 00:00:00', 'LOGIN', 1, '3a639fefd098c21646096e2bcbc142d89c724e88c147674d60aad7fb651d0292', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(133, '2022-11-23 13:39:56', '0000-00-00 00:00:00', 'LOGIN', 2, '3a639fefd098c21646096e2bcbc142d89c724e88c147674d60aad7fb651d0292', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(134, '2022-11-23 14:29:17', '0000-00-00 00:00:00', 'LOGIN', 3, 'eb89266602cedd076362e01a4d22b161067c8a4b28d5e449a9f1743005b8ffb4', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(135, '2022-11-23 15:29:16', '0000-00-00 00:00:00', 'LOGIN', 2, 'a8cebca8ab35ecaa881de8c3d6168a06610e06cf71bcd9b64d8cb375afb88a30', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(136, '2022-11-24 08:02:31', '0000-00-00 00:00:00', 'LOGIN', 3, '61447d639a35b1fa97dd535bdd0e2a514fedb454b4af230a2457fd655df218c3', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(137, '2022-11-24 08:10:40', '0000-00-00 00:00:00', 'LOGIN', 2, 'e775a5b4b97f662714150720b31fc7c6a085a61df888a06df495241c611c38ac', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(138, '2022-11-24 11:07:11', '0000-00-00 00:00:00', 'LOGIN', 2, 'c2de65c312c3d1bc65f61345c15eb07bd54c604fdb42896e9d12a34b59c592f8', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(139, '2022-11-24 13:30:28', '0000-00-00 00:00:00', 'LOGIN', 2, '1615fdc5d667276b51b025e76c516cafe09505984f8ce9d6d4a6ec4d97ba82d8', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(140, '2022-11-24 15:05:50', '0000-00-00 00:00:00', 'LOGIN', 3, '2ffa14214625e9fcc26c8f7215a51bbb54139ceee891f8102c91ea943c879d6c', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(141, '2022-11-24 15:07:48', '0000-00-00 00:00:00', 'LOGIN', 2, 'd3cb119e6f181e48006eee3422747f6ef8af4452903e77b25f89dc7275e52100', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(142, '2022-11-24 15:44:56', '0000-00-00 00:00:00', 'LOGIN', 2, '295db61325cbf0325c2728fb96d4941ce68cbb6a04812e79be114fd4067927a7', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(143, '2022-11-24 16:40:08', '0000-00-00 00:00:00', 'LOGIN', 3, 'af5c14b63d17ae07df1e6453f1265686e20e592313292b7a9bfe627272c9f562', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(144, '2022-11-25 08:04:14', '0000-00-00 00:00:00', 'LOGIN', 2, 'b7554d8c9323bd63d2e6e4766761ea536aa2af87b676cc461b07f79f9caa4f96', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(145, '2022-11-25 14:32:41', '0000-00-00 00:00:00', 'LOGIN', 2, '9096e23eb7e1fca7f9f3eaee9a36ca28e84df792ea851ac02baf8138337e0e47', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(146, '2022-11-27 18:42:33', '0000-00-00 00:00:00', 'LOGIN', 2, '3a6118e9ea959a214b4e2fa6c4c6fc4a5095c0d292f8d1a35134f6f1fa097574', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(147, '2022-11-27 23:19:23', '0000-00-00 00:00:00', 'LOGIN', 2, 'f14cac3314600e0173ab3c1f30c614a00e469db66d3b8b364387e5f70dddddb7', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(148, '2022-11-28 07:04:07', '0000-00-00 00:00:00', 'LOGIN', 2, '8bea087ec469961b1cbf25246082199983ef4df8d4f270ef0c8813761c089bd5', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(149, '2022-11-30 18:35:42', '0000-00-00 00:00:00', 'LOGIN', 2, 'f3c50d53be95d98aab477a15c77cb90ebe595fa9e55491a0e67d925ba73d27f1', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(150, '2022-11-30 18:36:40', '0000-00-00 00:00:00', 'LOGIN', 2, 'f3c50d53be95d98aab477a15c77cb90ebe595fa9e55491a0e67d925ba73d27f1', '::1', '{\"device\":\"Chrome\",\"version\":\"107.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 107.0.0.0 on Windows 10 64-bit\"}', 0),
(151, '2022-12-05 08:06:42', '0000-00-00 00:00:00', 'LOGIN', 2, '710f2eb88bf771fcc5c3ffe1709309095bd92b359993da93a7d1cd34706926ba', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(152, '2022-12-05 10:33:10', '0000-00-00 00:00:00', 'LOGIN', 2, '24d0c05ed851f0f48fda7c5331561b61a3e481979fcfb0bc3ac1593c0779e525', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(153, '2022-12-06 08:04:45', '0000-00-00 00:00:00', 'LOGIN', 2, '6e77b6a80b879fb3b34c86cb3f397bf37643f8acd4bd0c0de0a7eefecba405d1', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(154, '2022-12-07 07:25:35', '0000-00-00 00:00:00', 'LOGIN', 2, '190fda539d29ba47cf6961f27325ff063e68b24f4eaa0600673aa589fbad7531', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(155, '2022-12-07 08:20:23', '0000-00-00 00:00:00', 'LOGIN', 2, 'd69c282885e06d88dcfa2b8f31617ebbbad7964093cb497acfc370249b223773', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(156, '2022-12-07 11:05:17', '0000-00-00 00:00:00', 'LOGIN', 2, '2112c09150d713298e14116cf149d30b707af7ffbbcf1506150025c78e97e08e', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(157, '2022-12-07 13:38:44', '0000-00-00 00:00:00', 'LOGIN', 2, 'ddab10ae35fea6091d0cd69f3ef5bb14b23d18f6c99840495cc5a188de3036d9', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(158, '2022-12-07 13:58:51', '0000-00-00 00:00:00', 'LOGIN', 2, 'ab3b74739d8b215e7f5169a2d1b8675a85f134413bbd071884122bd50a922506', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(159, '2022-12-13 09:25:54', '0000-00-00 00:00:00', 'LOGIN', 2, '27de580dc5b6a891dcc667866c3214ba0313315fa731b71002040e1570e1f592', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(160, '2022-12-13 13:59:39', '0000-00-00 00:00:00', 'LOGIN', 2, 'ce3e4245156cb3de52785450cd46a70acda51f964fc44d6c98cf125d4f508270', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(161, '2022-12-13 14:44:37', '0000-00-00 00:00:00', 'LOGIN', 2, '11c876c14932d483ef4f38223005a31c0b37821fc7793361f355afd7226ddeaf', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(162, '2023-01-03 08:24:23', '0000-00-00 00:00:00', 'LOGIN', 2, '1e0a1a6cd74de6ad5e22aaf824a4e32e3267ec6ac4fe502ef7c255869d6b7c41', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(163, '2023-01-03 08:58:33', '0000-00-00 00:00:00', 'LOGIN', 3, '79062cb72aa214aeed10a10e4da417d876c8d4d69351e87cde0dfafba89b7380', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(164, '2023-01-03 08:59:29', '0000-00-00 00:00:00', 'LOGIN', 3, '14794279003cd4ee65bef43c6683a70e3a4a61132cdba3996dd1cda2165721ae', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(165, '2023-01-03 09:00:00', '0000-00-00 00:00:00', 'LOGIN', 2, '14794279003cd4ee65bef43c6683a70e3a4a61132cdba3996dd1cda2165721ae', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(166, '2023-01-03 09:45:51', '0000-00-00 00:00:00', 'LOGIN', 3, '16760a4df5772b6ed81888fa9190c5728f5aac29f82f5a08afbd8af6187c69ce', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(167, '2023-01-03 09:46:24', '0000-00-00 00:00:00', 'LOGIN', 2, '28da4a9db01fd5726f7af77e001a4df80654eeb9bc4dd259570aa1647ea1baa8', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(168, '2023-01-03 09:46:45', '0000-00-00 00:00:00', 'LOGIN', 2, '28da4a9db01fd5726f7af77e001a4df80654eeb9bc4dd259570aa1647ea1baa8', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(169, '2023-01-03 13:10:03', '0000-00-00 00:00:00', 'LOGIN', 2, '2f2e77bba37dae05a266fe551923b08e7f9cb130402d912ce1fd1d7dd4c0180a', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(170, '2023-01-03 13:18:47', '0000-00-00 00:00:00', 'LOGIN', 2, 'b6d4c3e27e97c0272f96eb6c5c24bfe529c0137b7077daa231b6f233b22eac7b', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(171, '2023-01-04 10:20:13', '0000-00-00 00:00:00', 'LOGIN', 2, 'd906c91d1e9d3cf7ef427a53528f6ff963fb49bb8b3f7808f81f2e14c6e87a1d', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0);
INSERT INTO `user_log` (`user_log_id`, `login_date`, `logout_date`, `action`, `user_id`, `session_id`, `ip_address`, `device`, `system_id`) VALUES
(172, '2023-01-04 11:32:29', '0000-00-00 00:00:00', 'LOGIN', 2, 'a3c39ee44671536624cba96157f49fc01111cbe108033a208235a61ab62a9608', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(173, '2023-01-04 11:38:30', '0000-00-00 00:00:00', 'LOGIN', 2, '9780547390d494e09e93bc11f5588b5562c386e8ea24730a9dbe34218470a32c', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(174, '2023-01-04 11:45:54', '0000-00-00 00:00:00', 'LOGIN', 2, '6dfdad17b8b7fb214eca960a3b072cc5ab7620dfa4a5a0d4dfaf7cc638269fea', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(175, '2023-01-04 11:46:34', '0000-00-00 00:00:00', 'LOGIN', 2, '0df03900fc1c51c8ba9888e75c3d63f541956542330093b0174e0050694ad48a', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(176, '2023-01-04 11:49:00', '0000-00-00 00:00:00', 'LOGIN', 2, 'd322eacc66450e28d9956b0ec4f2a0a1c154bd68ee93109b99ed2c63cbb9f3a6', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(177, '2023-01-04 11:49:21', '0000-00-00 00:00:00', 'LOGIN', 2, '4bba00c18f2d744177d98f242deed483633abc7dc894bd204615d76f8e0d9014', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(178, '2023-01-04 11:50:47', '0000-00-00 00:00:00', 'LOGIN', 2, '501d530e24e9d26c1dd8c22ed7e944d369e8d11d5b796a2bbca4a380e554c397', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(179, '2023-01-04 11:52:12', '0000-00-00 00:00:00', 'LOGIN', 2, '0cd191d472715c2a5291f77cd17222d599fbc733f6a19fa8b2b32726827b1ccf', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(180, '2023-01-04 12:15:52', '0000-00-00 00:00:00', 'LOGIN', 2, '7ea77bd69c8483f122d85080950fd89c65a7ff408072b750cd3a17df968ed7f4', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(181, '2023-01-04 12:16:56', '0000-00-00 00:00:00', 'LOGIN', 2, '25edc3ef43ddea819989f1f3419593ffbd685befc558ffd51ea2b37d7c29c882', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(182, '2023-01-04 12:17:59', '0000-00-00 00:00:00', 'LOGIN', 2, 'bf576dbca3008e7b6f56ad68a79a27fbadd83d9819f22a4deb3c10f39ce29b04', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(183, '2023-01-04 12:18:45', '0000-00-00 00:00:00', 'LOGIN', 2, 'e90899b5d29271e6bfeca7e8a61dcc4046a81983cc92c656f26b9793589930df', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(184, '2023-01-04 14:32:23', '0000-00-00 00:00:00', 'LOGIN', 4, 'b18b32ce447cd7d2ddef3ce878a44f4b478632e8b984bf52d87ca078c8d2bcd9', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(185, '2023-01-04 14:33:31', '0000-00-00 00:00:00', 'LOGIN', 4, 'b18b32ce447cd7d2ddef3ce878a44f4b478632e8b984bf52d87ca078c8d2bcd9', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(186, '2023-01-04 14:34:31', '0000-00-00 00:00:00', 'LOGIN', 4, '4bcb13535dac9118450378c5bde19b541af536a405d74768d7cbef94daa752ea', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(187, '2023-01-04 14:40:46', '0000-00-00 00:00:00', 'LOGIN', 2, '69f172d15a7f3900c436648b720b971be5362886004a0c006c4691db96460e1a', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(188, '2023-01-04 14:42:16', '0000-00-00 00:00:00', 'LOGIN', 4, '1f6e9d45b8797f4787126e8261d4fb592adcc77c8dcf97d4b4259bd0c5f2da1b', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(189, '2023-01-04 14:44:19', '0000-00-00 00:00:00', 'LOGIN', 4, '1f58e0b1baff3ef182cfc9d86bfb92be24d9ae0db1549d82b34f93c51a3b8ad7', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(190, '2023-01-04 14:45:57', '0000-00-00 00:00:00', 'LOGIN', 4, 'df7513895bc4fa003c0a1f226d36a87b0bb4a66ad88c8dd598045273ec01dd79', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(191, '2023-01-04 14:46:52', '0000-00-00 00:00:00', 'LOGIN', 4, 'e89e8ef217eb8541421ea577411e98ff75814ef0783d61c8a4e30e2c0fb606e4', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(192, '2023-01-04 14:47:44', '0000-00-00 00:00:00', 'LOGIN', 4, '9e1e8f4520a83383be11c3318b9024ec2d45f2c60d80e687f0852a3018315937', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(193, '2023-01-04 14:48:10', '0000-00-00 00:00:00', 'LOGIN', 4, 'd55ae99d176f266762c2baf058e2b9e3d9e26e18fe18b91834630374df67be7a', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(194, '2023-01-04 14:48:42', '0000-00-00 00:00:00', 'LOGIN', 4, '6fa64deeb08365d79b7a31b88d4a23308351fff1ac42628be52cffc976f63512', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(195, '2023-01-04 14:58:07', '0000-00-00 00:00:00', 'LOGIN', 4, '5a8e6b4bdf0837100ac9ff99b32949206eaeb8b653a07b4088c9c30655f42653', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(196, '2023-01-04 15:00:15', '0000-00-00 00:00:00', 'LOGIN', 4, 'e578f954bac741c33bfe2e8932f7e6b79390a57fc807f7d6e05601a8608fce51', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(197, '2023-01-04 15:05:00', '0000-00-00 00:00:00', 'LOGIN', 4, 'f600acd62fa1b9d85553f643b0ea0fcae057b4beda8653120b335ba20b9e4c5b', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(198, '2023-01-04 15:05:36', '0000-00-00 00:00:00', 'LOGIN', 4, 'e07f73896fd26e404ea4c88338384273280d2ce95037cb74545e16f682f6675b', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(199, '2023-01-04 15:07:14', '0000-00-00 00:00:00', 'LOGIN', 4, 'fa633f3ffddc6fc327bf2b8fba19c729ef283072da9f6cfda5247e4d88f58b5f', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(200, '2023-01-04 15:26:39', '0000-00-00 00:00:00', 'LOGIN', 2, 'a67881f6beaa36a3edfb62b7f53597d059fb4fc0afd57ef320cf0cc82f2bc711', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(201, '2023-01-04 15:27:21', '0000-00-00 00:00:00', 'LOGIN', 2, '8eb4acaa23761d3a63885fe55dbb7b11b0e11cf8379bd43a017e780d131d790b', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(202, '2023-01-04 15:34:04', '0000-00-00 00:00:00', 'LOGIN', 2, '9ed023a603552b41dbf059ff91e50f32d4f4ed435c01d95e43f96b37f2297568', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(203, '2023-01-04 16:07:57', '0000-00-00 00:00:00', 'LOGIN', 2, '9197343664ef151265fbf18cf0a3882ac35554dfbcf4d4bb7df8fbfc1ea4d951', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(204, '2023-01-04 16:08:14', '0000-00-00 00:00:00', 'LOGIN', 4, 'd490c7db9fc83ad8c5dc1724d480f3b775a3325a24cfdfab7dacfb4289e7b851', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(205, '2023-01-04 16:08:22', '0000-00-00 00:00:00', 'LOGIN', 2, 'e62494b5b9a8b3946879860dfacff3d3c75e02f8e8320513a50ac39974fe63ea', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(206, '2023-01-04 17:08:07', '0000-00-00 00:00:00', 'LOGIN', 2, '34aa3c2c1b2f3f747fc1ccb6030695961e03088e55bf4e75f772921707f3d342', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(207, '2023-01-05 08:44:41', '0000-00-00 00:00:00', 'LOGIN', 2, 'ad91dd4c969de5706360efe9a991bdc485e98af05bfc7154b6aa545dceb0f1ae', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(208, '2023-01-05 09:10:04', '0000-00-00 00:00:00', 'LOGIN', 2, 'd477216db514b731d9e5b41d1e53b68ee2dd7e8a474cbfa63ed9ec1673a3aa2d', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(209, '2023-01-05 15:17:45', '0000-00-00 00:00:00', 'LOGIN', 2, 'd223f36883de64d57e4d2fa16546199975ea599d02eeb08717ef61066575d37a', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(210, '2023-01-05 16:01:12', '0000-00-00 00:00:00', 'LOGIN', 2, '8fe2f146abb1076fcc9dacb4e3eb2bbbb8c4e0f85c5f8c460eb7cc1fae186976', '::1', '{\"device\":\"Chrome Mobile\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":32,\"family\":\"Android\",\"version\":\"6.0\"},\"description\":\"Chrome Mobile 108.0.0.0 on Google Nexus 5 (Android 6.0)\"}', 0),
(211, '2023-01-05 16:04:34', '0000-00-00 00:00:00', 'LOGIN', 2, '36992c656d32d2e8df572e912fe0e146a35e6dff9a6f59801b4af73b4f5ab9c6', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(212, '2023-01-05 16:18:53', '0000-00-00 00:00:00', 'LOGIN', 2, '7a0133a5cd444684d58614aa75ec20c8f222738494bd8242de2af211b18d024c', '::1', '{\"device\":\"Microsoft Edge\",\"version\":\"108.0.1462.54\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Microsoft Edge 108.0.1462.54 on Windows 10 64-bit\"}', 0),
(213, '2023-01-09 07:53:14', '0000-00-00 00:00:00', 'LOGIN', 2, 'ab342c7d765b9c374eb2d488e11a1026d610e1bdcd8c52848cf9caaadca127c2', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(214, '2023-01-09 14:18:27', '0000-00-00 00:00:00', 'LOGIN', 2, 'ba0a6c1772474bba1e4de0afe6ff26874a88b3b90c981a8309b19e69498b8091', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(215, '2023-01-10 08:09:30', '0000-00-00 00:00:00', 'LOGIN', 2, 'd252db89ff0586701087632ca659e8fdd560a2eb6f88c224d041e073353b63fe', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(216, '2023-01-10 09:54:45', '0000-00-00 00:00:00', 'LOGIN', 4, '155694257febe5d7d33406b0d3b0b8412e6f8d6fa14df36952d0c1a2c13c8f72', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(217, '2023-01-10 09:57:23', '0000-00-00 00:00:00', 'LOGIN', 4, '1411023d51374bd2865f4c053ee20f11ffde5b28bbe44f7f90f4b60794577acb', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(218, '2023-01-10 09:57:37', '0000-00-00 00:00:00', 'LOGIN', 2, '155694257febe5d7d33406b0d3b0b8412e6f8d6fa14df36952d0c1a2c13c8f72', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(219, '2023-01-10 10:27:11', '0000-00-00 00:00:00', 'LOGIN', 2, 'f9e66e6be016f8973e01fbeccfb4a69bacc4874cc025fafe9672a1a07419e9f6', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(220, '2023-01-10 13:36:17', '0000-00-00 00:00:00', 'LOGIN', 2, 'c119104064607203a17cf255ebdf9b15bc580ff07014cf53da2743943a65d1df', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(221, '2023-01-10 15:47:08', '0000-00-00 00:00:00', 'LOGIN', 2, '0892ec2a0eb7afea2abc3b89d71667e25adf9f79136932bc3bdaa05abace8d7d', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(222, '2023-01-11 08:34:05', '0000-00-00 00:00:00', 'LOGIN', 2, 'da3b2a477e3a50e42141b6b7947491682b48bcd0eaecb76f7995116b236a0c92', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(223, '2023-01-11 15:51:59', '0000-00-00 00:00:00', 'LOGIN', 7, '392f74c8f2e236a37b0370cb32440c3c99dfff5bf03c0b11a62ac3bfaf06f549', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(224, '2023-01-11 16:02:30', '0000-00-00 00:00:00', 'LOGIN', 7, 'e13fa34a6d54143e4ce13e14159318330702532972022793631b24b7b0b2f41a', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(225, '2023-01-11 16:05:36', '0000-00-00 00:00:00', 'LOGIN', 7, 'a5cc1b1c2b8ca0f9849a7e472f0ba4bf25507902041653c7edc45db8f9a09f32', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(226, '2023-01-11 16:09:24', '0000-00-00 00:00:00', 'LOGIN', 7, 'ba8d0281e81f131e5227943cf59f3df4dd477d3eba851d9c6a1397b9efd69117', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(227, '2023-01-11 16:10:29', '0000-00-00 00:00:00', 'LOGIN', 7, '1c8df1a1e5a0bde5f1131a2fc803849bee7e670eab1eff974a1b0b2ffccdee64', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(228, '2023-01-12 08:21:53', '0000-00-00 00:00:00', 'LOGIN', 2, '65b9dc29accea33a7e5422231c770b17ed7136f7e273118120c98bedfc919728', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(229, '2023-01-12 08:22:21', '0000-00-00 00:00:00', 'LOGIN', 6, '2101cb630be3bde0450803e8435b856c9d604aeb8e49ec777ba5db3ff4238bde', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(230, '2023-01-12 08:28:16', '0000-00-00 00:00:00', 'LOGIN', 6, 'f8aeefeaa2f6606b7761db07b7ad044fd0a12c5986973b67240f47bca5882608', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(231, '2023-01-12 08:30:15', '0000-00-00 00:00:00', 'LOGIN', 2, 'bd03cfdd8838596095c14fc193cdc4cd9219ff7b048f14ae0d9b667b7e81a5e9', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(232, '2023-01-12 08:31:26', '0000-00-00 00:00:00', 'LOGIN', 2, 'cf000c70882536869cfc58a95b0efb5620d52f5178acfb53e1c41bfe084f7143', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(233, '2023-01-12 08:35:14', '0000-00-00 00:00:00', 'LOGIN', 2, '95ba3c078ae7588bc5ed6ffb74a63499d8344c0f4bec32271689830871a18705', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(234, '2023-01-12 08:35:21', '0000-00-00 00:00:00', 'LOGIN', 2, '1d5368cd86958118ef4ad56df5c01d3130986daf62d5f0e761082a9d3b843361', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(235, '2023-01-12 08:37:57', '0000-00-00 00:00:00', 'LOGIN', 6, 'fb7d7953f03caf55f46bbbf60b8527b7fbc831c4b1ff9490d7993ceb40d1d75e', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(236, '2023-01-12 08:38:11', '0000-00-00 00:00:00', 'LOGIN', 6, '09aa80f40a64e1d062483f3996f3122f4d1794c8768366c0c0b0516b7fb3c128', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(237, '2023-01-12 08:43:52', '0000-00-00 00:00:00', 'LOGIN', 3, '7c01a12f7b4ffb48a5695c2aaa2d44b5c73593eac14344797794e37c96ea47fa', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(238, '2023-01-12 08:45:30', '0000-00-00 00:00:00', 'LOGIN', 3, '7c01a12f7b4ffb48a5695c2aaa2d44b5c73593eac14344797794e37c96ea47fa', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(239, '2023-01-12 09:32:43', '0000-00-00 00:00:00', 'LOGIN', 2, '9a1b83ae0bc535958cbd41ae4fd504c5fb132e70535b9339ce27f34bb6d5fbbe', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(240, '2023-01-12 09:33:03', '0000-00-00 00:00:00', 'LOGIN', 3, 'e42a8a948181fec1a28155439b42ebfa26ab763585964b7e737001bec405477c', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(241, '2023-01-12 09:33:11', '0000-00-00 00:00:00', 'LOGIN', 3, 'f80b177bdcbfa404de7b1ff3ad82eca6bb41c317b1a42fcb9b83f4eb42711def', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(242, '2023-01-12 11:16:13', '0000-00-00 00:00:00', 'LOGIN', 3, '8811ed52b2897a0aef12975ac299457a3fdba2d575a9ee0139f49d16cb2fe9e9', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(243, '2023-01-12 11:16:45', '0000-00-00 00:00:00', 'LOGIN', 3, 'e4cd96ee6003e047b4742cf48d03ed655bce933b3ebf7fcb05078916f9e54d1e', '::1', '{\"device\":\"Chrome Mobile\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":32,\"family\":\"Android\",\"version\":\"6.0\"},\"description\":\"Chrome Mobile 108.0.0.0 on Google Nexus 5 (Android 6.0)\"}', 0),
(244, '2023-01-12 11:17:20', '0000-00-00 00:00:00', 'LOGIN', 3, '36145371529181028fbe5aeaba345ec211f63d9592d04d2ab1015230dba7444b', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(245, '2023-01-12 11:19:21', '0000-00-00 00:00:00', 'LOGIN', 3, 'f9ede12dfa7256ec8adf9d6db9557753ce00d40404ae6aa7fd22ca62c608737d', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(246, '2023-01-12 11:23:09', '0000-00-00 00:00:00', 'LOGIN', 2, 'a67efce254d1939dd62626abff3b0245d6f4cee017561340cb9062ab7d42528b', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(247, '2023-01-12 11:30:09', '0000-00-00 00:00:00', 'LOGIN', 3, 'e4a69d22a20c083ec1f39971b3985522ba7191c53708ec01672a1e86d3eb5b61', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(248, '2023-01-12 11:31:26', '0000-00-00 00:00:00', 'LOGIN', 3, '9431270e967ebf8e11e6137abee7e5e74b25d44a4a3cc35704df53cefa5d191a', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(249, '2023-01-12 13:18:14', '0000-00-00 00:00:00', 'LOGIN', 3, 'fb3807b200a43729d7ba924548b1a6c8aeffec39040741305fe4d1c8acd501e1', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(250, '2023-01-12 13:22:32', '0000-00-00 00:00:00', 'LOGIN', 3, '309cbe6f4924ac3fb07816636f30bff3ddb844842c930b6d42ae017483233134', '::1', '{\"device\":\"Chrome Mobile\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":32,\"family\":\"Android\",\"version\":\"6.0\"},\"description\":\"Chrome Mobile 108.0.0.0 on Google Nexus 5 (Android 6.0)\"}', 0),
(251, '2023-01-12 13:22:59', '0000-00-00 00:00:00', 'LOGIN', 3, '66933499769e3ed07b1000a1668c8b764900b4ccca946fdd82455b9999ea95a2', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(252, '2023-01-12 13:33:12', '0000-00-00 00:00:00', 'LOGIN', 2, '2a9b25881be8c29a8d4a0c72b0fead7c0946ceacdd5c8ff689016ed85abb097c', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(253, '2023-01-12 14:17:22', '0000-00-00 00:00:00', 'LOGIN', 3, '43b165936ce67e716031b763c0835b2776e108954683adf5251b8faf0e1b7a1b', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(254, '2023-01-12 14:17:29', '0000-00-00 00:00:00', 'LOGIN', 3, '7dc946c34e24dfd9ea2bc548919d6f840cb8196dade24c63deba1d44dd629a60', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(255, '2023-01-12 14:17:55', '0000-00-00 00:00:00', 'LOGIN', 3, 'bd73bd1842baa8d96d8b0c02920b6b3e45b917002702053d10472557c9534264', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(256, '2023-01-12 14:18:02', '0000-00-00 00:00:00', 'LOGIN', 3, 'f893ce07b5d3b48cebf3f8d49b2e144213b214c9149a163eae937fc870169af8', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(257, '2023-01-13 08:33:23', '0000-00-00 00:00:00', 'LOGIN', 3, '33a9b36466e43ca5caf828af180b5251558523ad06963564df1d25d23b298a42', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(258, '2023-01-13 08:33:31', '0000-00-00 00:00:00', 'LOGIN', 3, 'f28ccb718f035a8348a8095a664e76cf034b2626838eb8d0d500003e7f5db129', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(259, '2023-01-13 09:05:01', '0000-00-00 00:00:00', 'LOGIN', 3, 'c690798384f84142fd75a0ff05f98abe7263dc6c4d3c3eac73c0d42afd35b528', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(260, '2023-01-13 09:07:53', '0000-00-00 00:00:00', 'LOGIN', 2, '1da53e9e56fbf51f7f7bbaab0db7324d8bcc5a2fd45c5f2dd872a9daee4593f1', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(261, '2023-01-13 09:18:55', '0000-00-00 00:00:00', 'LOGIN', 7, 'd4cdee8daa9b0a00dd598ff3f98c10ebb25a6fcf7cee0156a230b80387778164', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(262, '2023-01-13 09:56:11', '0000-00-00 00:00:00', 'LOGIN', 7, '4ae4fc1b0f1c875b5b6a002e3c5e3ca0c33a0f8fefcd2c9ad5cb536d91bbe61c', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(263, '2023-01-13 10:03:28', '0000-00-00 00:00:00', 'LOGIN', 3, '7292b38dce5df55687a8aa592fa036e819f0202acf89960bfe3c62525f5ee77d', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(264, '2023-01-13 10:59:18', '0000-00-00 00:00:00', 'LOGIN', 7, 'a916ec1a398ba4661d72f6892c32e3bfd57334a31be864dedd6e0a44ac934dc3', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(265, '2023-01-13 11:59:24', '0000-00-00 00:00:00', 'LOGIN', 7, 'efbf0de7c72b5f7361c779a884d5d52d226454a655c2004275230d9c04f95937', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(266, '2023-01-13 15:39:37', '0000-00-00 00:00:00', 'LOGIN', 3, 'e9673b8a9e12e3350f20f9d6d65a1c9230f50b09af0fb67d15573041efe58ae5', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(267, '2023-01-16 08:51:33', '0000-00-00 00:00:00', 'LOGIN', 3, '9edf109388f668c35d87d68f106dd4002353821d75de9ee00f76fb40df063e52', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(268, '2023-01-16 08:51:57', '0000-00-00 00:00:00', 'LOGIN', 3, 'c0c289d3cb5dcd7fbaee83bf8fbf81c5c5bd28afc96b885174e89003c69c785f', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(269, '2023-01-16 09:14:24', '0000-00-00 00:00:00', 'LOGIN', 2, '7414a32ef2c852c4728a701270d0ab832cf12aa8e071a5feed775f8074894adf', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(270, '2023-01-16 14:24:33', '0000-00-00 00:00:00', 'LOGIN', 2, '3f518f2d4acd46b6969c43a0c680273cc1721a45ca32ccb2bf88355fe66c3987', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(271, '2023-01-16 14:25:00', '0000-00-00 00:00:00', 'LOGIN', 2, '2529dcd54faf8f80101cc63d180b4d835b85b973efacb865731b671164c0fd9e', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(272, '2023-01-16 14:25:21', '2023-01-16 14:29:11', 'LOGIN', 1, '8f44e40eef46e103c1d122b40d2e42c04c5339fc779494e12e0839d56cf46ba3', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(273, '2023-01-16 14:29:13', '0000-00-00 00:00:00', 'LOGIN', 2, 'b4ede1e4989826ba681fddb4fe3d1fe80b7ec411653835bf0b3d5ab7f4c2e073', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(274, '2023-01-16 14:30:44', '0000-00-00 00:00:00', 'LOGIN', 2, '99b04f254b947b4ae84211a6ae7a6a9bc9c201c6aefb8adec328ab7d2ea3e900', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(275, '2023-01-16 14:36:29', '0000-00-00 00:00:00', 'LOGIN', 1, '0b967fd808bc2373559d6f3d66802304988bc38d39dc0e93d3265ef1b3bb1de9', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(276, '2023-01-16 14:38:25', '0000-00-00 00:00:00', 'LOGIN', 1, '0b967fd808bc2373559d6f3d66802304988bc38d39dc0e93d3265ef1b3bb1de9', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(277, '2023-01-16 14:38:48', '0000-00-00 00:00:00', 'LOGIN', 1, '0b967fd808bc2373559d6f3d66802304988bc38d39dc0e93d3265ef1b3bb1de9', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(278, '2023-01-16 14:43:54', '0000-00-00 00:00:00', 'LOGIN', 2, 'a0a4c8f591483bc393dee5ac8a812f8a99602bff90ec60cfe771290fcf371455', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(279, '2023-01-16 14:52:21', '0000-00-00 00:00:00', 'LOGIN', 2, '0269c96883168aca282e220f7258a82b66884169552616377a7df1c0fff32f78', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(280, '2023-01-16 14:52:30', '0000-00-00 00:00:00', 'LOGIN', 2, '000331eda8dba795f33109753fc2c6a7f452d4f74cde5e2e87302fa67868d75c', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(281, '2023-01-16 15:02:34', '2023-01-16 15:48:31', 'LOGIN', 1, '5dc9580669c60ed9d50c48552a28ff7d58268d9a7795efd2f6c15272bf1c2de9', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(282, '2023-01-16 15:02:57', '0000-00-00 00:00:00', 'LOGIN', 2, '698bcbe2c3e41197a647630ed4ecd5da53eb8352dc82505d94e89fec504034a6', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(283, '2023-01-16 15:06:50', '0000-00-00 00:00:00', 'LOGIN', 2, '25a611205cd9594c1ee8aa89a9ab1925bb10e56179bf01a60f758da8f4eeb54d', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(284, '2023-01-16 15:07:01', '0000-00-00 00:00:00', 'LOGIN', 2, '25a611205cd9594c1ee8aa89a9ab1925bb10e56179bf01a60f758da8f4eeb54d', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(285, '2023-01-16 15:07:13', '2023-01-16 15:34:32', 'LOGIN', 1, '088580b6a96fa16d8e07ef8f155990c53069917451cb14bc036fb34f0cb2d1c9', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(286, '2023-01-16 15:34:34', '0000-00-00 00:00:00', 'LOGIN', 2, 'b6072e71978ca196171987998802273914e58868a80c5f905b5a62c7fae89368', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(287, '2023-01-16 15:42:46', '0000-00-00 00:00:00', 'LOGIN', 4, '46c7eedd8c60c288f17a42f7dde891ac4fb6cbe6e5d73a839367008d2272abe7', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(288, '2023-01-16 15:48:40', '0000-00-00 00:00:00', 'LOGIN', 4, '766c7a92ad862a6bd91b508f4298d9676134c451f13f585bbecc1fb1085e4829', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(289, '2023-01-16 15:58:42', '0000-00-00 00:00:00', 'LOGIN', 2, 'fcdf44224bb0c3adbcc3a79820dd0f0a95093007b3f93cae380e7774672ecf62', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(290, '2023-01-16 15:59:07', '2023-01-16 15:59:12', 'LOGIN', 1, '50097724a2d8f2bf619043432d45aba8d074ee28f419788def32453102714125', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(291, '2023-01-16 16:00:51', '0000-00-00 00:00:00', 'LOGIN', 4, 'ed53b783f685524e0a6559a6a4a7801c2b419ae5694ffbdfff9b0de3f96c5eb3', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(292, '2023-01-16 16:01:16', '0000-00-00 00:00:00', 'LOGIN', 2, 'f675895af5aee0fdbe86f3e1798b828ece07182f13f1dba33c5706c1eef89ee4', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(293, '2023-01-16 16:04:56', '0000-00-00 00:00:00', 'LOGIN', 1, '5c837872c466382b4d548f70a7e9d9953172a5dad6630febbdef58ef9584958c', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(294, '2023-01-16 16:14:38', '2023-01-16 16:49:44', 'LOGIN', 1, 'ab47ad2ced6dc742ed86683d9f711b318226d49af952a760621251b3d28c7fc5', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(295, '2023-01-16 16:15:56', '2023-01-16 16:49:44', 'LOGIN', 1, 'ab47ad2ced6dc742ed86683d9f711b318226d49af952a760621251b3d28c7fc5', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(296, '2023-01-17 08:02:51', '2023-01-17 08:05:30', 'LOGIN', 1, 'b4c4ddce226aa4bb5bcd0a4936dab3e7241dc0017dcdf6d177330641827058ed', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(297, '2023-01-17 08:05:32', '0000-00-00 00:00:00', 'LOGIN', 2, 'ec264736f335e64926cc55c2c689b657e3674e38b2161e95003f3553cd7b5d16', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(298, '2023-01-17 08:20:45', '0000-00-00 00:00:00', 'LOGIN', 2, '41edbdc3acd7dedccbf201ac86fd99e8a6a0de929d70ad25b00886b58f17e4b7', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(299, '2023-01-17 08:21:02', '0000-00-00 00:00:00', 'LOGIN', 2, '41edbdc3acd7dedccbf201ac86fd99e8a6a0de929d70ad25b00886b58f17e4b7', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(300, '2023-01-17 08:21:07', '0000-00-00 00:00:00', 'LOGIN', 2, '41edbdc3acd7dedccbf201ac86fd99e8a6a0de929d70ad25b00886b58f17e4b7', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(301, '2023-01-17 08:32:50', '2023-01-17 08:32:58', 'LOGIN', 1, '2077d2716edfe228dab230dd8317f9d7f0a205dfc0de1eaed7ac095ad53b887b', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0),
(302, '2023-01-17 08:33:00', '0000-00-00 00:00:00', 'LOGIN', 2, 'f0ab166f158964deceafe24e6aa7b915c3f086854d7a25b47b6e4e2c21b08736', '::1', '{\"device\":\"Chrome\",\"version\":\"108.0.0.0\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 108.0.0.0 on Windows 10 64-bit\"}', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`activity_log_id`);

--
-- Indexes for table `makeup_class`
--
ALTER TABLE `makeup_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `physical_checking`
--
ALTER TABLE `physical_checking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reset_code`
--
ALTER TABLE `reset_code`
  ADD PRIMARY KEY (`reset_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sg_setting`
--
ALTER TABLE `sg_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `time_log`
--
ALTER TABLE `time_log`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_id` (`employee_id`,`way`,`date_log`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `employee_id` (`employee_id`,`card_id`);

--
-- Indexes for table `user_log`
--
ALTER TABLE `user_log`
  ADD PRIMARY KEY (`user_log_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `activity_log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `makeup_class`
--
ALTER TABLE `makeup_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `physical_checking`
--
ALTER TABLE `physical_checking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `reset_code`
--
ALTER TABLE `reset_code`
  MODIFY `reset_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sg_setting`
--
ALTER TABLE `sg_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `time_log`
--
ALTER TABLE `time_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_log`
--
ALTER TABLE `user_log`
  MODIFY `user_log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=303;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
