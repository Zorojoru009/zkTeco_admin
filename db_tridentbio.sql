-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 12, 2024 at 08:24 AM
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
  `device_serial_number` varchar(100) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bs_config`
--

INSERT INTO `bs_config` (`il_id`, `api`, `branch_number`, `branch_location`, `device_serial_number`) VALUES
(1, 'https://hris.triapps.co', 1, 'Bata', 'A8N5222560809');

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
(1, 'User', 0);

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
(1000, 0, NULL, 'Trident', '', 'Technology', 'admin@gmail.com', 'admin', '17f1ee26412752dfd580a901b16270e0', 'gamechanger', 'Super Admin', '123456789', 'Bacolod City', 'e427302bf01ae63e2b0f53543bd85208.png', '29f7ab71c780e0f09e384c0174093e92.png', 1, 1, 1, 1, 1, 1, '2022-11-09 19:09:24', 0, '2023-12-14 20:12:04', 1002, NULL, 0, 0, 1, '2024-04-12 02:39:19', '2024-01-23 05:58:16', 'fba9d88164f3e2d9109ee770223212a0');

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
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attendance`
--

CREATE TABLE `tbl_attendance` (
  `al_id` int(11) NOT NULL,
  `type` int(11) DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  `is_sent` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `last_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`ul_id`, `user_id`, `role`, `password`, `is_sent`, `first_name`, `middle_name`, `last_name`) VALUES
(23, 120241, 4, 0, 0, 'Kevin', '', 'Cortez');

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
(36, 2465, '::1', 'admin', 'gamechanger', 0, 0, '2024-04-12 10:39:19', NULL);

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
  MODIFY `al_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `ul_id` int(55) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tr_login_attempt`
--
ALTER TABLE `tr_login_attempt`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
