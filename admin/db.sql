SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `leads` (
  `id` int(22) NOT NULL,
  `imported_time` int(11) DEFAULT NULL,
  `picked_up` varchar(255) DEFAULT NULL,
  `pitched` varchar(255) DEFAULT NULL,
  `call_end_result` varchar(255) DEFAULT NULL,
  `call_history` longtext DEFAULT NULL,
  `appointment_setter` varchar(255) DEFAULT NULL,
  `locked_status` int(1) DEFAULT NULL,
  `queue` int(22) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `google_rating` varchar(255) DEFAULT NULL,
  `google_reviews` varchar(255) DEFAULT NULL,
  `yelp_rating` varchar(255) DEFAULT NULL,
  `yelp_reviews` varchar(255) DEFAULT NULL,
  `fb_rating` varchar(255) DEFAULT NULL,
  `fb_reviews` varchar(255) DEFAULT NULL,
  `fb_likes` varchar(255) DEFAULT NULL,
  `fb_checkins` varchar(255) DEFAULT NULL,
  `fb_followers` varchar(255) DEFAULT NULL,
  `is_title` varchar(255) DEFAULT NULL,
  `is_description` varchar(255) DEFAULT NULL,
  `is_adwords` varchar(255) DEFAULT NULL,
  `is_facebook_ads` varchar(255) DEFAULT NULL,
  `is_twitter_ads` varchar(255) DEFAULT NULL,
  `is_linkedin_ads` varchar(255) DEFAULT NULL,
  `is_bing_ads` varchar(255) DEFAULT NULL,
  `is_robot` varchar(255) DEFAULT NULL,
  `is_ssl` varchar(255) DEFAULT NULL,
  `is_wordpress` varchar(255) DEFAULT NULL,
  `fb_url` varchar(255) DEFAULT NULL,
  `twitter_url` varchar(255) DEFAULT NULL,
  `linkedin_url` varchar(255) DEFAULT NULL,
  `youtube_url` varchar(255) DEFAULT NULL,
  `instagram_url` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `search_type` varchar(255) DEFAULT NULL,
  `crawler_status` varchar(255) DEFAULT NULL,
  `founded` varchar(255) DEFAULT NULL,
  `company_type` varchar(255) DEFAULT NULL,
  `company_size` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `company_name` (`company_name`,`address`);


ALTER TABLE `leads`
  MODIFY `id` int(22) NOT NULL AUTO_INCREMENT;
COMMIT;
