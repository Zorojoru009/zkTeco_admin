-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2024 at 05:58 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_tridentbio`
--

-- --------------------------------------------------------

--
-- Table structure for table `bs_config`
--

CREATE TABLE `bs_config` (
  `il_id` int(10) NOT NULL,
  `api` varchar(1000) NOT NULL,
  `branch_number` int(10) NOT NULL,
  `branch_location` varchar(100) NOT NULL,
  `device_serial_number` varchar(100) DEFAULT '',
  `initalized` int(3) NOT NULL,
  `latitude` varchar(50) DEFAULT '',
  `longitude` varchar(50) DEFAULT '',
  `ip` varchar(100) NOT NULL DEFAULT '',
  `last_updated` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bs_config`
--

INSERT INTO `bs_config` (`il_id`, `api`, `branch_number`, `branch_location`, `device_serial_number`, `initalized`, `latitude`, `longitude`, `ip`, `last_updated`) VALUES
(1, 'https://breadbox-hris.triapps.co', 1, 'Mandalagan', 'A8N5222560809', 0, NULL, NULL, '192.168.0.50', '');

-- --------------------------------------------------------

--
-- Table structure for table `bs_page`
--

CREATE TABLE `bs_page` (
  `p_id` int(10) NOT NULL,
  `page_name` text DEFAULT NULL,
  `is_deleted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bs_page`
--

INSERT INTO `bs_page` (`p_id`, `page_name`, `is_deleted`) VALUES
(1, 'Report', 0);

-- --------------------------------------------------------

--
-- Table structure for table `bs_setting`
--

CREATE TABLE `bs_setting` (
  `setting_id` int(10) UNSIGNED NOT NULL,
  `directory` varchar(100) NOT NULL DEFAULT '',
  `admin_dir` varchar(70) NOT NULL,
  `system_title` varchar(100) NOT NULL DEFAULT '',
  `abrv` varchar(70) NOT NULL DEFAULT '',
  `year_developed` year(4) NOT NULL,
  `description` text NOT NULL,
  `developer` varchar(100) NOT NULL,
  `website` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `bs_setting`
--

INSERT INTO `bs_setting` (`setting_id`, `directory`, `admin_dir`, `system_title`, `abrv`, `year_developed`, `description`, `developer`, `website`) VALUES
(1001, 'zkTeco_admin', 'zkTeco_admin', 'HRIS', 'HRIS', '2023', '', 'Trident Technology', 'www.tridentechnology.com');

-- --------------------------------------------------------

--
-- Table structure for table `bs_user`
--

CREATE TABLE `bs_user` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `e_id` int(11) NOT NULL DEFAULT 0,
  `id_num` text DEFAULT NULL,
  `firstname` varchar(100) NOT NULL DEFAULT '',
  `middlename` varchar(100) NOT NULL DEFAULT '',
  `lastname` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(100) DEFAULT '',
  `username` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `pass_text` varchar(200) NOT NULL DEFAULT '',
  `title` varchar(100) DEFAULT '',
  `contactno` varchar(100) DEFAULT '',
  `address` text DEFAULT NULL,
  `image` varchar(200) NOT NULL DEFAULT '',
  `thumbnail` varchar(200) NOT NULL DEFAULT '',
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `access_level` int(10) NOT NULL DEFAULT 0,
  `is_user` int(1) NOT NULL DEFAULT 0,
  `is_user_add` int(1) NOT NULL DEFAULT 0,
  `is_user_edit` int(1) NOT NULL DEFAULT 0,
  `is_user_delete` int(1) NOT NULL DEFAULT 0,
  `date_added` varchar(50) DEFAULT NULL,
  `added_by` int(10) NOT NULL DEFAULT 0,
  `date_modified` varchar(50) DEFAULT NULL,
  `modified_by` int(10) NOT NULL DEFAULT 0,
  `date_deleted` varchar(50) DEFAULT NULL,
  `deleted_by` int(10) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `last_login` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `last_logout` timestamp NOT NULL DEFAULT current_timestamp(),
  `uid` varchar(170) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `bs_user`
--

INSERT INTO `bs_user` (`user_id`, `e_id`, `id_num`, `firstname`, `middlename`, `lastname`, `email`, `username`, `password`, `pass_text`, `title`, `contactno`, `address`, `image`, `thumbnail`, `is_admin`, `access_level`, `is_user`, `is_user_add`, `is_user_edit`, `is_user_delete`, `date_added`, `added_by`, `date_modified`, `modified_by`, `date_deleted`, `deleted_by`, `is_deleted`, `is_active`, `last_login`, `last_logout`, `uid`) VALUES
(1000, 0, NULL, 'Trident', '', 'Technology', 'admin@gmail.com', 'admin', '17f1ee26412752dfd580a901b16270e0', 'gamechanger', 'Super Admin', '123456789', 'Bacolod City', 'e427302bf01ae63e2b0f53543bd85208.png', '29f7ab71c780e0f09e384c0174093e92.png', 1, 1, 1, 1, 1, 1, '2022-11-09 19:09:24', 0, '2023-12-14 20:12:04', 1002, NULL, 0, 0, 1, '2024-04-29 04:27:07', '2024-01-23 05:58:16', 'fba9d88164f3e2d9109ee770223212a0');

-- --------------------------------------------------------

--
-- Table structure for table `bs_user_count`
--

CREATE TABLE `bs_user_count` (
  `sl_id` int(10) NOT NULL,
  `user_count` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bs_user_count`
--

INSERT INTO `bs_user_count` (`sl_id`, `user_count`) VALUES
(1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attendance`
--

CREATE TABLE `tbl_attendance` (
  `al_id` int(11) NOT NULL,
  `id_num` int(50) NOT NULL,
  `log_type` int(11) DEFAULT NULL,
  `date_time` varchar(120) DEFAULT NULL,
  `is_sent` int(11) DEFAULT 0,
  `is_deleted` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_attendance`
--

INSERT INTO `tbl_attendance` (`al_id`, `id_num`, `log_type`, `date_time`, `is_sent`, `is_deleted`) VALUES
(1, 120241, 1, '2', 0, 0),
(10, 120241, 0, '2024-04-15 11:36:00', 1, 0),
(11, 120241, 1, '2024-04-15 13:32:41', 1, 0),
(12, 120241, 0, '2024-04-16 14:14:42', 1, 0),
(13, 120241, 0, '2024-04-16 14:14:48', 1, 0),
(14, 120242, 0, '2024-04-17 15:49:49', 1, 0),
(15, 120242, 0, '2024-04-17 15:49:59', 1, 0),
(16, 120241, 5, '2024-04-17 16:42:48', 0, 0),
(17, 120243, 0, '2024-04-17 16:43:26', 0, 0),
(18, 120242, 1, '2024-04-17 17:04:41', 0, 0),
(19, 120242, 0, '2024-04-18 07:44:36', 0, 0),
(20, 120243, 0, '2024-04-18 07:50:15', 0, 0),
(21, 120243, 0, '2024-04-18 12:02:21', 0, 0),
(22, 120242, 0, '2024-04-18 12:02:26', 0, 0),
(23, 120242, 0, '2024-04-18 12:53:17', 0, 0),
(24, 120243, 0, '2024-04-18 12:55:45', 0, 0),
(25, 120243, 0, '2024-04-18 17:00:57', 0, 0),
(26, 120242, 0, '2024-04-18 17:07:12', 0, 0),
(27, 120243, 0, '2024-04-19 07:44:05', 0, 0),
(28, 120242, 0, '2024-04-19 07:48:38', 0, 0),
(29, 120243, 0, '2024-04-19 12:01:35', 0, 0),
(30, 120242, 0, '2024-04-19 12:10:13', 0, 0),
(31, 120242, 0, '2024-04-19 12:56:37', 0, 0),
(32, 120243, 0, '2024-04-19 12:58:41', 0, 0),
(33, 120243, 0, '2024-04-19 17:37:55', 0, 0),
(34, 120242, 0, '2024-04-19 17:41:02', 0, 0),
(35, 120242, 0, '2024-04-20 07:43:37', 0, 0),
(36, 120242, 0, '2024-04-20 12:15:10', 0, 0),
(37, 120242, 0, '2024-04-20 13:00:50', 0, 0),
(38, 120242, 0, '2024-04-20 17:08:47', 0, 0),
(39, 120243, 0, '2024-04-22 07:45:32', 0, 0),
(40, 120242, 0, '2024-04-22 07:48:25', 0, 0),
(41, 120243, 0, '2024-04-22 12:01:40', 0, 0),
(42, 120242, 0, '2024-04-22 12:04:50', 0, 0),
(43, 120242, 0, '2024-04-22 12:49:16', 0, 0),
(44, 120243, 0, '2024-04-22 12:53:14', 0, 0),
(45, 120243, 0, '2024-04-22 17:02:02', 0, 0),
(46, 120242, 0, '2024-04-22 17:07:18', 0, 0),
(47, 120243, 0, '2024-04-23 07:41:05', 0, 0),
(48, 120242, 0, '2024-04-23 07:53:34', 0, 0),
(49, 120242, 0, '2024-04-23 12:00:29', 1, 0),
(50, 120243, 0, '2024-04-23 12:02:13', 1, 0),
(51, 120243, 0, '2024-04-23 12:57:40', 1, 0),
(52, 120242, 0, '2024-04-23 13:00:19', 1, 0),
(53, 120243, 0, '2024-04-23 17:01:04', 1, 0),
(54, 120242, 0, '2024-04-23 17:03:30', 1, 0),
(55, 120242, 0, '2024-04-24 07:32:46', 1, 0),
(56, 120243, 0, '2024-04-24 07:59:40', 1, 0),
(57, 120243, 0, '2024-04-24 12:02:05', 1, 0),
(58, 120242, 0, '2024-04-24 12:04:07', 1, 0),
(59, 120243, 0, '2024-04-24 13:00:42', 1, 0),
(60, 120242, 0, '2024-04-24 13:01:08', 1, 0),
(61, 120243, 0, '2024-04-24 17:02:17', 1, 0),
(62, 120242, 0, '2024-04-24 17:02:29', 1, 0),
(63, 120243, 0, '2024-04-25 07:22:27', 1, 0),
(64, 120242, 0, '2024-04-25 07:36:49', 1, 0),
(65, 120243, 0, '2024-04-25 12:03:06', 1, 0),
(66, 120242, 0, '2024-04-25 12:05:04', 1, 0),
(67, 120243, 0, '2024-04-25 12:57:48', 1, 0),
(68, 120242, 0, '2024-04-25 12:59:07', 1, 0),
(69, 120243, 0, '2024-04-25 17:01:47', 1, 0),
(70, 120242, 1, '2024-04-25 17:02:29', 1, 0),
(71, 120242, 1, '2024-04-26 07:44:24', 1, 0),
(72, 120243, 1, '2024-04-26 07:57:01', 1, 0),
(73, 120243, 1, '2024-04-26 12:01:27', 1, 0),
(74, 120242, 1, '2024-04-26 12:04:02', 1, 0),
(75, 120243, 1, '2024-04-26 12:58:39', 1, 0),
(76, 120242, 1, '2024-04-26 12:59:54', 1, 0),
(77, 120243, 1, '2024-04-26 17:01:39', 1, 0),
(78, 120242, 1, '2024-04-26 17:03:14', 1, 0),
(79, 120242, 1, '2024-04-27 12:57:28', 1, 0),
(80, 120242, 1, '2024-04-27 17:05:20', 1, 0),
(81, 120242, 1, '2024-04-29 07:35:51', 1, 0),
(82, 120243, 1, '2024-04-29 07:36:01', 1, 0),
(83, 120243, 1, '2024-04-29 12:00:24', 1, 0),
(84, 120242, 1, '2024-04-29 12:04:35', 1, 0),
(85, 120242, 1, '2024-04-29 12:59:20', 1, 0),
(86, 120243, 1, '2024-04-29 12:59:46', 1, 0),
(87, 120243, 1, '2024-04-29 17:03:49', 1, 0),
(88, 120242, 1, '2024-04-29 17:05:44', 1, 0),
(89, 120243, 1, '2024-04-30 07:44:12', 1, 0),
(90, 120242, 1, '2024-04-30 07:46:40', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `ul_id` int(55) NOT NULL,
  `user_id` int(55) NOT NULL DEFAULT 0,
  `role` int(55) NOT NULL DEFAULT 0,
  `password` int(55) NOT NULL DEFAULT 0,
  `is_sent` int(55) NOT NULL DEFAULT 0,
  `first_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `is_deleted` int(11) NOT NULL,
  `date_time` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`ul_id`, `user_id`, `role`, `password`, `is_sent`, `first_name`, `middle_name`, `last_name`, `is_deleted`, `date_time`) VALUES
(23, 120241, 4, 0, 1, 'Kevin', '', 'Cortez', 0, '2024-04-17 03:43:44'),
(24, 120242, 4, 0, 1, ' Lalaine', '', 'Norbe', 0, '2024-04-17 03:43:44'),
(25, 120243, 4, 0, 1, 'Mirriam', 'Mahilum', 'Lachica', 0, '2024-04-17 16:42:43'),
(26, 120243, 4, 0, 1, 'Mirriam', 'Mahilum', 'Lachica', 0, '2024-04-17 16:42:43');

-- --------------------------------------------------------

--
-- Table structure for table `tr_login_attempt`
--

CREATE TABLE `tr_login_attempt` (
  `id` int(10) NOT NULL,
  `rand` int(10) NOT NULL,
  `ip` varchar(250) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `status` int(10) NOT NULL,
  `auth` int(10) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `idnumber` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tr_login_attempt`
--

INSERT INTO `tr_login_attempt` (`id`, `rand`, `ip`, `username`, `password`, `status`, `auth`, `datetime`, `idnumber`) VALUES
(1, 7071, '49.146.154.22', 'admin', 'gamechanger', 0, 0, '2024-01-18 10:08:51', NULL),
(2, 2118, '49.146.154.22', 'admin', 'ggamechanger', 0, 1, '2024-01-18 16:56:07', NULL),
(3, 3238, '49.146.154.22', 'admin', 'gamechanger', 0, 0, '2024-01-18 16:56:12', NULL),
(4, 2804, '180.194.77.17', 'admin', 'gamechanger', 0, 0, '2024-01-19 12:52:49', NULL),
(5, 3777, '180.194.77.17', 'admin', 'gamechanger', 0, 0, '2024-01-19 16:47:29', NULL),
(6, 2565, '49.146.142.44', 'admin', 'gamechanger', 0, 0, '2024-01-22 10:54:52', NULL),
(7, 3648, '49.146.142.44', 'admin', '1234', 1, 1, '2024-01-22 10:58:48', NULL),
(8, 2241, '49.146.142.44', 'admin', 'admin', 1, 1, '2024-01-22 10:58:54', NULL),
(9, 1822, '49.146.142.44', 'admin', 'admin', 1, 1, '2024-01-22 10:59:03', NULL),
(10, 6984, '180.194.83.16', 'ADMIN', 'GAMECHANGER', 0, 1, '2024-01-23 13:55:04', NULL),
(11, 3667, '180.194.83.16', 'admin', 'ganechanger', 0, 1, '2024-01-23 13:55:10', NULL),
(12, 4180, '180.194.83.16', 'admin', 'gamechanger', 0, 0, '2024-01-23 13:55:15', NULL),
(13, 6248, '180.194.64.75', 'admin', 'gamechanger', 0, 0, '2024-01-24 11:05:41', NULL),
(14, 1237, '180.194.64.75', 'admin', 'gamechanger', 0, 0, '2024-01-24 11:05:44', NULL),
(15, 7855, '49.146.153.55', 'admin', 'gamechanger', 0, 0, '2024-01-25 10:55:45', NULL),
(16, 8122, '180.194.78.19', 'admin', 'gamechanger', 0, 0, '2024-01-26 10:52:02', NULL),
(17, 8768, '49.146.144.185', 'admin', 'gamechanger', 0, 0, '2024-01-29 11:24:03', NULL),
(18, 3894, '49.146.144.185', 'admin', 'gamechanger', 0, 0, '2024-01-29 14:35:23', NULL),
(19, 1532, '180.194.78.252', 'admin', 'gamechangee', 0, 1, '2024-02-05 11:08:22', NULL),
(20, 8465, '180.194.78.252', 'admin', 'gamechanger', 0, 0, '2024-02-05 11:08:33', NULL),
(21, 2598, '180.194.78.252', 'admin', 'gamechanger', 0, 0, '2024-02-05 11:10:06', NULL),
(22, 8569, '180.194.89.206', 'admin', 'gamechanger', 0, 0, '2024-02-06 09:43:22', NULL),
(23, 6680, '180.194.89.206', 'admin', 'gamechanger', 0, 0, '2024-02-06 15:11:33', NULL),
(24, 6739, '::1', 'admin', 'gamechanger', 0, 0, '2024-02-15 16:18:13', NULL),
(25, 6900, '::1', 'admin', 'gamechanger\\', 0, 1, '2024-02-16 12:43:58', NULL),
(26, 3269, '::1', 'admin', 'gamechanger', 0, 0, '2024-02-16 12:44:03', NULL),
(27, 6059, '::1', 'admin', 'gamechanger', 0, 0, '2024-02-19 13:04:10', NULL),
(28, 1487, '::1', 'admin', 'admin', 0, 1, '2024-04-08 13:05:31', NULL),
(29, 2517, '::1', 'admin', 'gamechanger', 0, 0, '2024-04-08 13:05:37', NULL),
(30, 2386, '::1', 'admin', 'gamechanger', 0, 0, '2024-04-09 08:10:31', NULL),
(31, 2946, '::1', 'admin', 'gamechanger', 0, 0, '2024-04-09 11:27:15', NULL),
(32, 2653, '::1', 'admin', 'gamechanger', 0, 0, '2024-04-09 15:48:13', NULL),
(33, 6807, '::1', 'admin', 'gamechnager', 0, 1, '2024-04-10 09:19:41', NULL),
(34, 5563, '::1', 'admin', 'gamechanger', 0, 0, '2024-04-10 09:19:45', NULL),
(35, 3513, '::1', 'admin', 'gamechanger', 0, 0, '2024-04-12 09:01:08', NULL),
(36, 2465, '::1', 'admin', 'gamechanger', 0, 0, '2024-04-12 10:39:19', NULL),
(37, 2669, '::1', 'admin', 'gamechanger', 0, 0, '2024-04-15 09:16:28', NULL),
(38, 7604, '::1', 'admin', 'gamechanger', 0, 0, '2024-04-17 16:39:16', NULL),
(39, 1950, '::1', 'admin', 'gamechanger', 0, 0, '2024-04-17 17:05:46', NULL),
(40, 8262, '::1', 'admin', 'gamechanger', 0, 0, '2024-04-18 09:24:28', NULL),
(41, 7303, '::1', 'admin', 'ganecgabger', 0, 1, '2024-04-24 09:36:34', NULL),
(42, 3114, '::1', 'admin', 'admin\'', 0, 1, '2024-04-24 09:36:40', NULL),
(43, 7421, '::1', 'admin', 'gamechanger', 0, 0, '2024-04-24 09:36:46', NULL),
(44, 8812, '::1', 'admin', 'gamechanger', 0, 0, '2024-04-24 12:55:10', NULL),
(45, 1668, '::1', 'admin', 'admin', 0, 1, '2024-04-29 12:26:52', NULL),
(46, 2653, '::1', 'admin', 'admin', 0, 1, '2024-04-29 12:26:57', NULL),
(47, 6701, '::1', 'admin', 'gamechanger', 0, 0, '2024-04-29 12:27:07', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bs_config`
--
ALTER TABLE `bs_config`
  ADD PRIMARY KEY (`il_id`);

--
-- Indexes for table `bs_page`
--
ALTER TABLE `bs_page`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `bs_setting`
--
ALTER TABLE `bs_setting`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `bs_user`
--
ALTER TABLE `bs_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `bs_user_count`
--
ALTER TABLE `bs_user_count`
  ADD PRIMARY KEY (`sl_id`);

--
-- Indexes for table `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  ADD PRIMARY KEY (`al_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`ul_id`);

--
-- Indexes for table `tr_login_attempt`
--
ALTER TABLE `tr_login_attempt`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bs_config`
--
ALTER TABLE `bs_config`
  MODIFY `il_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bs_page`
--
ALTER TABLE `bs_page`
  MODIFY `p_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bs_setting`
--
ALTER TABLE `bs_setting`
  MODIFY `setting_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1014;

--
-- AUTO_INCREMENT for table `bs_user`
--
ALTER TABLE `bs_user`
  MODIFY `user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1009;

--
-- AUTO_INCREMENT for table `bs_user_count`
--
ALTER TABLE `bs_user_count`
  MODIFY `sl_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  MODIFY `al_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `ul_id` int(55) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tr_login_attempt`
--
ALTER TABLE `tr_login_attempt`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
