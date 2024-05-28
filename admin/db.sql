SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET NAMES utf8mb4;

DROP DATABASE IF EXISTS `u956006469_rr_leads`;
CREATE DATABASE `u956006469_rr_leads` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `u956006469_rr_leads`;

DROP TABLE IF EXISTS `leads`;
CREATE TABLE `leads` (
  `id` int(22) NOT NULL AUTO_INCREMENT,
  `imported_time` int(11) DEFAULT NULL,
  `hidden` int(1) DEFAULT NULL,
  `picked_up` text DEFAULT NULL,
  `pitched` text DEFAULT NULL,
  `call_end_result` text DEFAULT NULL,
  `call_history` text DEFAULT NULL,
  `appointment_setter` text DEFAULT NULL,
  `locked_status` int(1) DEFAULT NULL,
  `queue` int(22) DEFAULT NULL,
  `company_name` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `company_name` (`company_name`,`address`) USING HASH
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;