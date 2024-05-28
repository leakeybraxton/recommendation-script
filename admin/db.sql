-- Adminer 4.8.1 MySQL 10.11.7-MariaDB-cll-lve dump

SET NAMES utf8;
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
  `picked_up` text DEFAULT NULL,
  `pitched` text DEFAULT NULL,
  `call_end_result` text DEFAULT NULL,
  `call_history` text DEFAULT NULL,
  `appointment_setter` text DEFAULT NULL,
  `locked_status` int(1) DEFAULT NULL,
  `queue` int(22) DEFAULT NULL,
  `company_name` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `website` text DEFAULT NULL,
  `phone_number` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `google_rating` text DEFAULT NULL,
  `google_reviews` text DEFAULT NULL,
  `yelp_rating` text DEFAULT NULL,
  `yelp_reviews` text DEFAULT NULL,
  `fb_rating` text DEFAULT NULL,
  `fb_reviews` text DEFAULT NULL,
  `fb_likes` text DEFAULT NULL,
  `fb_checkins` text DEFAULT NULL,
  `fb_followers` text DEFAULT NULL,
  `is_title` text DEFAULT NULL,
  `is_description` text DEFAULT NULL,
  `is_adwords` text DEFAULT NULL,
  `is_facebook_ads` text DEFAULT NULL,
  `is_twitter_ads` text DEFAULT NULL,
  `is_linkedin_ads` text DEFAULT NULL,
  `is_bing_ads` text DEFAULT NULL,
  `is_robot` text DEFAULT NULL,
  `is_ssl` text DEFAULT NULL,
  `is_wordpress` text DEFAULT NULL,
  `fb_url` text DEFAULT NULL,
  `twitter_url` text DEFAULT NULL,
  `linkedin_url` text DEFAULT NULL,
  `youtube_url` text DEFAULT NULL,
  `instagram_url` text DEFAULT NULL,
  `category` text DEFAULT NULL,
  `search_type` text DEFAULT NULL,
  `crawler_status` text DEFAULT NULL,
  `founded` text DEFAULT NULL,
  `company_type` text DEFAULT NULL,
  `company_size` text DEFAULT NULL,
  `date_time_utc` text DEFAULT NULL,
  `city` text DEFAULT NULL,
  `title` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `robot_config` text DEFAULT NULL,
  `bbb_profile` text DEFAULT NULL,
  `state` text DEFAULT NULL,
  `years_in_business` text DEFAULT NULL,
  `first_name` text DEFAULT NULL,
  `last_name` text DEFAULT NULL,
  `contact_job_title` text DEFAULT NULL,
  `revenue` text DEFAULT NULL,
  `top_keywords` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `company_name` (`company_name`,`address`) USING HASH
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- 2024-05-28 06:15:04
