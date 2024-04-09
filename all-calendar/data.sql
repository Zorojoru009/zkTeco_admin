-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.22-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table db_dinerhris.tr_schedule
CREATE TABLE IF NOT EXISTS `tr_schedule` (
  `ns_id` int(10) NOT NULL AUTO_INCREMENT,
  `office_id` int(10) NOT NULL,
  `emp_id` int(10) NOT NULL,
  `code` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `color` varchar(7) DEFAULT NULL,
  `start` datetime NOT NULL,
  `end` datetime DEFAULT NULL,
  `duty_date_from` date DEFAULT NULL,
  `duty_date_to` date DEFAULT NULL,
  `time_in` varchar(50) DEFAULT NULL,
  `time_out` varchar(50) DEFAULT NULL,
  `added_by` int(10) DEFAULT NULL,
  `modified_by` int(10) DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `is_multiple` tinyint(1) NOT NULL,
  `is_break` tinyint(1) NOT NULL,
  `is_night_shift` tinyint(1) NOT NULL,
  PRIMARY KEY (`ns_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1011 DEFAULT CHARSET=utf8;

-- Dumping data for table db_dinerhris.tr_schedule: ~1 rows (approximately)
/*!40000 ALTER TABLE `tr_schedule` DISABLE KEYS */;
INSERT INTO `tr_schedule` (`ns_id`, `office_id`, `emp_id`, `code`, `title`, `color`, `start`, `end`, `duty_date_from`, `duty_date_to`, `time_in`, `time_out`, `added_by`, `modified_by`, `date_added`, `date_modified`, `is_multiple`, `is_break`, `is_night_shift`) VALUES
	(1007, 1001, 15, '15_904619s_23', 'Straight Shift', '#0071c5', '2023-02-21 00:00:00', '2023-02-23 00:00:00', '2023-02-21', '2023-02-23', '07:00', '01:00', 1002, 1002, '2023-02-22 02:03:50', '2023-02-22 02:03:52', 0, 0, 0),
	(1008, 1001, 8, '8_772898s_23', 'Straight Shift', '#0071c5', '2023-02-01 00:00:00', '2023-02-05 00:00:00', '2023-02-01', '2023-02-05', '08:00', '17:00', 1002, 1002, '2023-02-22 12:57:51', '2023-02-22 12:59:18', 0, 0, 0),
	(1009, 1001, 8, '8_902292s_23', 'Straight Shift', '#0071c5', '2023-02-20 00:00:00', '2023-02-25 00:00:00', '2023-02-20', '2023-02-25', '06:00', '18:00', 1002, 1002, '2023-02-22 12:58:49', '2023-02-22 13:12:36', 0, 0, 0),
	(1010, 1001, 8, '8_133316s_23', 'Straight Shift', '#0071c5', '2023-02-20 00:00:00', '2023-02-21 00:00:00', '2023-02-20', '2023-02-21', '01:00', '01:00', 1002, 1002, '2023-02-22 13:12:30', '2023-02-22 13:12:41', 0, 0, 0);
/*!40000 ALTER TABLE `tr_schedule` ENABLE KEYS */;

-- Dumping structure for table db_dinerhris.tr_schedule_days
CREATE TABLE IF NOT EXISTS `tr_schedule_days` (
  `sch_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(200) NOT NULL,
  `office_id` int(10) unsigned NOT NULL,
  `emp_id` int(10) NOT NULL,
  `sch_date` date NOT NULL,
  `sch_timein` varchar(20) NOT NULL,
  `sch_timeout` varchar(20) NOT NULL,
  `schedule_type` tinyint(1) NOT NULL COMMENT '1=duty; 2=break; 3=dayoff; 4=leave;',
  `shift_type` int(10) NOT NULL COMMENT '2=with break; 3=straight shift;',
  `is_deleted` tinyint(1) unsigned NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `modified_by` int(10) NOT NULL,
  `is_night_shift` tinyint(1) NOT NULL,
  PRIMARY KEY (`sch_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1104 DEFAULT CHARSET=latin1;

-- Dumping data for table db_dinerhris.tr_schedule_days: 2 rows
/*!40000 ALTER TABLE `tr_schedule_days` DISABLE KEYS */;
INSERT INTO `tr_schedule_days` (`sch_id`, `code`, `office_id`, `emp_id`, `sch_date`, `sch_timein`, `sch_timeout`, `schedule_type`, `shift_type`, `is_deleted`, `date_added`, `date_modified`, `modified_by`, `is_night_shift`) VALUES
	(1026, '15_904619s_23', 1001, 15, '2023-02-21', '07:00', '01:00', 1, 3, 0, '2023-02-22 02:03:52', '0000-00-00 00:00:00', 0, 0),
	(1027, '15_904619s_23', 1001, 15, '2023-02-22', '07:00', '01:00', 1, 3, 0, '2023-02-22 02:03:52', '0000-00-00 00:00:00', 0, 0),
	(1103, '8_133316s_23', 1001, 8, '2023-02-20', '01:00', '01:00', 1, 3, 0, '2023-02-22 13:12:41', '0000-00-00 00:00:00', 0, 0),
	(1085, '8_772898s_23', 1001, 8, '2023-02-04', '08:00', '17:00', 1, 3, 0, '2023-02-22 12:59:18', '0000-00-00 00:00:00', 0, 0),
	(1102, '8_902292s_23', 1001, 8, '2023-02-24', '06:00', '18:00', 1, 3, 0, '2023-02-22 13:12:36', '0000-00-00 00:00:00', 0, 0),
	(1101, '8_902292s_23', 1001, 8, '2023-02-23', '06:00', '18:00', 1, 3, 0, '2023-02-22 13:12:36', '0000-00-00 00:00:00', 0, 0),
	(1100, '8_902292s_23', 1001, 8, '2023-02-22', '06:00', '18:00', 1, 3, 0, '2023-02-22 13:12:36', '0000-00-00 00:00:00', 0, 0),
	(1099, '8_902292s_23', 1001, 8, '2023-02-21', '06:00', '18:00', 1, 3, 0, '2023-02-22 13:12:36', '0000-00-00 00:00:00', 0, 0),
	(1098, '8_902292s_23', 1001, 8, '2023-02-20', '06:00', '18:00', 1, 3, 0, '2023-02-22 13:12:36', '0000-00-00 00:00:00', 0, 0),
	(1084, '8_772898s_23', 1001, 8, '2023-02-03', '08:00', '17:00', 1, 3, 0, '2023-02-22 12:59:18', '0000-00-00 00:00:00', 0, 0),
	(1083, '8_772898s_23', 1001, 8, '2023-02-02', '08:00', '17:00', 1, 3, 0, '2023-02-22 12:59:18', '0000-00-00 00:00:00', 0, 0),
	(1082, '8_772898s_23', 1001, 8, '2023-02-01', '08:00', '17:00', 1, 3, 0, '2023-02-22 12:59:18', '0000-00-00 00:00:00', 0, 0);
/*!40000 ALTER TABLE `tr_schedule_days` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
