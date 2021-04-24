-- phpMyAdmin SQL Dump
-- version 4.0.10.18
-- https://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Jan 21, 2018 at 08:29 AM
-- Server version: 5.5.54-38.7-log
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `domaizq9_takeaway`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `articles_slug_unique` (`slug`),
  KEY `articles_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `article_tag`
--

CREATE TABLE IF NOT EXISTS `article_tag` (
  `article_id` int(10) unsigned NOT NULL,
  `tag_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`article_id`,`tag_id`),
  KEY `article_tag_tag_id_foreign` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `article_id` int(10) unsigned NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_user_id_foreign` (`user_id`),
  KEY `comments_article_id_foreign` (`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE IF NOT EXISTS `favorites` (
  `user_id` int(10) unsigned NOT NULL,
  `article_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`,`article_id`),
  KEY `favorites_article_id_foreign` (`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `follows`
--

CREATE TABLE IF NOT EXISTS `follows` (
  `follower_id` int(10) unsigned NOT NULL,
  `followed_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`follower_id`,`followed_id`),
  KEY `follows_followed_id_foreign` (`followed_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2017_04_25_201852_create_articles_table', 1),
(3, '2017_04_25_201935_create_comments_table', 1),
(4, '2017_04_25_201944_create_tags_table', 1),
(5, '2017_04_27_200628_create_favorites_table', 1),
(6, '2017_04_27_200850_create_follows_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tags_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `gender` tinyint(1) NOT NULL COMMENT '1= male,2 for female,3 for other',
  `country_code` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` bigint(15) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0-inactive,1-active',
  `social_type` tinyint(1) NOT NULL,
  `social_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` tinyint(1) NOT NULL,
  `lng` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bio` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp` int(6) NOT NULL,
  `otp_time` bigint(15) NOT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `users_username_email_unique` (`name`,`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=24 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`gender`, `country_code`, `mobile`, `status`, `social_type`, `social_id`, `user_type`, `lng`, `lat`, `user_id`, `name`, `email`, `password`, `bio`, `image`, `remember_token`, `otp`, `otp_time`, `is_verified`, `created_at`, `updated_at`) VALUES
(1, '+91', 9876543212, 1, 0, '', 0, '14141', '3122', 6, 'neeraj', 'neeraj@yopmail.com', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', NULL, NULL, NULL, 123456, 1516474031, 1, '2018-01-18 17:25:34', '2018-01-18 17:25:34'),
(1, '+91', 5454545433, 1, 0, '', 1, '14141', '3122', 7, 'Baba', 'baba@yopmail.com', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', NULL, NULL, NULL, 0, 0, 1, '2018-01-18 20:00:58', '2018-01-18 20:00:58'),
(1, 'US', 1243353453, 1, 0, '', 1, '78.2134', '28.0234223', 8, 'testing', 'testing@gmail.com', '88586265b13f2929e648f525060c8554526a4fb4de38cc4950b346541c71f720', NULL, NULL, NULL, 0, 0, 1, '2018-01-20 16:13:33', '2018-01-20 16:13:33'),
(1, 'US', 3453546576, 1, 0, '', 1, '78.2134', '28.0234223', 9, 'raj', 'dfg@gmail.com', '88586265b13f2929e648f525060c8554526a4fb4de38cc4950b346541c71f720', NULL, NULL, NULL, 0, 0, 1, '2018-01-20 16:25:27', '2018-01-20 16:25:27'),
(1, 'US', 3453546575, 1, 0, '', 1, '78.2134', '28.0234223', 10, 'raj', 'dfgh@gmail.com', '88586265b13f2929e648f525060c8554526a4fb4de38cc4950b346541c71f720', NULL, NULL, NULL, 0, 0, 1, '2018-01-20 16:27:15', '2018-01-20 16:27:15'),
(1, 'US', 3453546571, 1, 0, '', 1, '78.2134', '28.0234223', 11, 'raj', 'dfgh1@gmail.com', '88586265b13f2929e648f525060c8554526a4fb4de38cc4950b346541c71f720', NULL, NULL, NULL, 0, 0, 1, '2018-01-20 16:28:59', '2018-01-20 16:28:59'),
(1, 'US', 4552323232, 1, 0, '', 1, '78.2134', '28.0234223', 12, 'robin', 'dfddx@gmail.com', '88586265b13f2929e648f525060c8554526a4fb4de38cc4950b346541c71f720', NULL, NULL, NULL, 0, 0, 1, '2018-01-20 16:34:18', '2018-01-20 16:34:18'),
(1, 'US', 2343534565, 1, 0, '', 1, '78.2134', '28.0234223', 13, 'test1', 'test1@gmail.com', '88586265b13f2929e648f525060c8554526a4fb4de38cc4950b346541c71f720', NULL, NULL, NULL, 0, 0, 1, '2018-01-20 16:36:25', '2018-01-20 16:36:25'),
(0, 'US', 6768677886, 1, 0, '', 1, '78.2134', '28.0234223', 14, 'dfg', 'svd@gmail.com', '88586265b13f2929e648f525060c8554526a4fb4de38cc4950b346541c71f720', NULL, NULL, NULL, 0, 0, 1, '2018-01-20 17:03:43', '2018-01-20 17:03:43'),
(0, 'US', 8800575923, 1, 0, '', 1, '78.2134', '28.0234223', 15, 'brajpal', 'abcd@gmail.com', '88586265b13f2929e648f525060c8554526a4fb4de38cc4950b346541c71f720', NULL, NULL, NULL, 0, 0, 1, '2018-01-20 17:09:35', '2018-01-20 17:09:35'),
(0, '+90', 1212121212, 1, 0, '', 1, '2', '2', 16, 'akki', 'akki@gmail.com', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', NULL, NULL, NULL, 0, 0, 1, '2018-01-20 17:42:10', '2018-01-20 17:42:10'),
(0, 'US', 8800575971, 1, 0, '', 1, '78.2134', '28.0234223', 17, 'brajpal', 'abcddf@gmail.com', '88586265b13f2929e648f525060c8554526a4fb4de38cc4950b346541c71f720', NULL, NULL, NULL, 0, 0, 1, '2018-01-20 18:06:44', '2018-01-20 18:06:44'),
(0, 'US', 2345467578, 1, 0, '', 1, '78.2134', '28.0234223', 18, 'brajpal singh', 'ddfg@gmail.com', '88586265b13f2929e648f525060c8554526a4fb4de38cc4950b346541c71f720', NULL, NULL, NULL, 0, 0, 1, '2018-01-20 18:08:59', '2018-01-20 18:08:59'),
(0, 'US', 3454365766, 1, 0, '', 1, '78.2134', '28.0234223', 19, 'brijpal', 'kdsf@gmail.com', '88586265b13f2929e648f525060c8554526a4fb4de38cc4950b346541c71f720', NULL, NULL, NULL, 123456, 1516472725, 1, '2018-01-20 18:24:00', '2018-01-20 18:24:00'),
(0, '+90', 1212121213, 1, 0, '', 1, '2', '2', 21, 'akki', 'akki1@gmail.com', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', NULL, NULL, NULL, 123456, 1516478635, 1, '2018-01-20 19:37:31', '2018-01-20 19:37:31'),
(0, 'US', 8800575972, 1, 0, '', 1, '78.2134', '28.0234223', 23, 'brajpal', 'brajpalsingh02@gmail.com', '88586265b13f2929e648f525060c8554526a4fb4de38cc4950b346541c71f720', NULL, NULL, NULL, 123456, 1516519639, 1, '2018-01-21 07:27:09', '2018-01-21 07:27:09');

-- --------------------------------------------------------

--
-- Table structure for table `users_login_session`
--

CREATE TABLE IF NOT EXISTS `users_login_session` (
  `device_token` varchar(255) NOT NULL,
  `session_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `access_token` varchar(255) NOT NULL,
  `device_type` tinyint(1) NOT NULL COMMENT '1 for android, 2 for ios',
  `device_id` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

--
-- Dumping data for table `users_login_session`
--

INSERT INTO `users_login_session` (`device_token`, `session_id`, `user_id`, `access_token`, `device_type`, `device_id`, `created_at`) VALUES
('', 1, 3, '17d960c83834cedb64f5d14a795f6ebd', 1, '', '2018-01-18 22:52:22'),
('', 2, 4, 'd7a4fc31e51be5df699fd6db2f520882', 1, '', '2018-01-18 22:53:00'),
('', 3, 5, 'd8d57c902cccd3fd42316fc65102ec9f', 1, '', '2018-01-18 22:53:56'),
('', 4, 6, '91c5882a8cade8e46703447d6031026d', 1, '', '2018-01-18 22:55:34'),
('0', 5, 6, 'c9d79a6528dafa4692343b32bbaf7563', 0, '0', '2018-01-18 23:16:07'),
('0', 6, 6, '1d1f980fefdbbb35400532b313bd6049', 0, '0', '2018-01-18 23:16:55'),
('0', 7, 6, 'b6b9d1a92154cad93d4a16aed9f2e320', 0, '0', '2018-01-18 19:46:38'),
('', 8, 7, '78c8624d5c1a3ca7cee1069ae1c88554', 1, '', '2018-01-18 20:00:58'),
('656868656bve6c67565c76776b6n76nb6b67', 9, 8, 'e5e452a802f98fbd8b50849ac0a4def3', 1, '', '2018-01-20 16:13:33'),
('656868656bve6c67565c76776b6n76nb6b67', 10, 9, 'd67a8151f31d520cae68861a6e0b62d7', 1, '', '2018-01-20 16:25:27'),
('656868656bve6c67565c76776b6n76nb6b67', 11, 10, 'bf531ca4d311acb94cb559d8a9e33814', 1, '', '2018-01-20 16:27:15'),
('656868656bve6c67565c76776b6n76nb6b67', 12, 11, 'bab2de541050bd5ce60a67eef22d4504', 1, '', '2018-01-20 16:28:59'),
('656868656bve6c67565c76776b6n76nb6b67', 13, 12, '7827b10fb8680dd435306d358037a2b7', 1, '', '2018-01-20 16:34:18'),
('656868656bve6c67565c76776b6n76nb6b67', 14, 13, 'b15de4d2a16a555f18ffca5deb3a3e53', 1, '', '2018-01-20 16:36:25'),
('656868656bve6c67565c76776b6n76nb6b67', 15, 14, '65b1346f1c199db129f3cac0c242fc31', 1, '', '2018-01-20 17:03:43'),
('656868656bve6c67565c76776b6n76nb6b67', 16, 15, 'd6e0fbd111278c5c41636c4fcf092120', 1, '', '2018-01-20 17:09:35'),
('12345678', 17, 16, '815e9f6cebba27404c6a10ca0ddeaf4c', 2, '', '2018-01-20 17:42:10'),
('656868656bve6c67565c76776b6n76nb6b67', 18, 17, 'fac2a42345f18d4d261618424d38ddf3', 1, '', '2018-01-20 18:06:44'),
('656868656bve6c67565c76776b6n76nb6b67', 19, 18, '466fc8e67e11cce4993cac7f3c7bf5e1', 1, '', '2018-01-20 18:08:59'),
('656868656bve6c67565c76776b6n76nb6b67', 20, 19, '273f9fe6a96afc1e82a8333b8432dba8', 1, '', '2018-01-20 18:24:00'),
('656868656bve6c67565c76776b6n76nb6b67', 21, 20, '9850e135f2666b3a35fc58381398ee25', 1, '', '2018-01-20 18:27:18'),
('45464564cc45f654v465b6v46gf45c6v65756v5655775v6', 22, 20, '3a23a9b6fe53114e80c95f802702643f', 0, '0', '2018-01-20 18:27:36'),
('0', 23, 6, '6325b6233fd2a3eea537d358be4553c5', 0, '0', '2018-01-20 18:46:56'),
('0', 24, 6, '6ebc2fdb7a6a45fae5a274a9714272e1', 0, '0', '2018-01-20 18:47:18'),
('0', 25, 6, 'fb8b191dab156d49cd1300603b5e74f5', 0, '0', '2018-01-20 18:51:12'),
('0', 26, 20, 'b5a6b41d2c1cfd8aa5b120724ce0a4dc', 0, '0', '2018-01-20 18:54:49'),
('0', 27, 16, 'c80c66ddc21604a2de1b27e19c04d37e', 0, '0', '2018-01-20 19:33:08'),
('0', 28, 16, '0ecd26c4b3aab20ab431e75d21cd9efe', 0, '0', '2018-01-20 19:34:55'),
('0', 29, 16, 'e7e6e3bb2a135000072db02039a6fc0c', 0, '0', '2018-01-20 19:35:15'),
('656868656bve6c67565c76776b6n76nb6b67', 30, 16, '5042a24c6ffef0efcc2d06600d0b95e9', 1, '0', '2018-01-20 19:35:26'),
('0', 31, 16, '8875a12a7f4c1b966b08cee30292e90f', 0, '0', '2018-01-20 19:35:29'),
('0', 32, 16, 'a547163d66e3c377c268227367dc5e53', 0, '0', '2018-01-20 19:36:34'),
('12345678', 33, 21, 'd07f0ba825f95f4d512f05013da92e96', 2, '', '2018-01-20 19:37:31'),
('0', 34, 21, '8340bb811895b00009676ed159d4c89f', 0, '0', '2018-01-20 19:38:00'),
('0', 35, 21, 'fa969cfa0661f7b8f81552be636055de', 0, '0', '2018-01-20 19:38:19'),
('0', 36, 21, 'd4d58db9b96d574675d0a3989fb22510', 0, '0', '2018-01-20 19:38:37'),
('akki1@gmail.com', 37, 21, '3a96af467ad44efd2018810a3cb8803b', 0, '0', '2018-01-20 19:45:43'),
('0', 38, 21, '0aee647f372c05268f66a8fe090436ee', 0, '0', '2018-01-20 19:46:39'),
('0', 39, 21, 'a00f08651c0b84a251ab582579fbd044', 0, '0', '2018-01-20 19:46:54'),
('0', 40, 21, '15827778110780e03bb3ca80b1ac4a05', 0, '0', '2018-01-20 19:58:39'),
('0', 41, 21, '2aa181a7ea206f45cb4463ec6b656a40', 0, '0', '2018-01-20 19:59:58'),
('0', 42, 21, 'cf76d3a545c7b62793c97274608c0777', 0, '0', '2018-01-20 20:02:47'),
('656868656bve6c67565c76776b6n76nb6b67', 43, 22, '7afdec09457be5961b9305cfb36a9995', 1, '', '2018-01-21 06:19:59'),
('45464564cc45f654v465b6v46gf45c6v65756v5655775v6', 44, 22, '42721e141394295fef8c145e165ddd5e', 0, '0', '2018-01-21 06:20:25'),
('0', 45, 16, '1b83ee0258dcf6fe9abda2a097fa5547', 0, '0', '2018-01-21 06:39:58'),
('0', 46, 22, 'f74678b8f30487d387af60c72aad7bd1', 0, '0', '2018-01-21 06:52:19'),
('0', 47, 22, 'b772ced42806ba90c6e3108ae2199f24', 0, '0', '2018-01-21 07:12:56'),
('656868656bve6c67565c76776b6n76nb6b67', 48, 23, '9863433a2d25032df649ed7c14bdff80', 1, '', '2018-01-21 07:27:09'),
('45464564cc45f654v465b6v46gf45c6v65756v5655775v6', 49, 23, '44153e430f044841100049b0d0d019b9', 0, '0', '2018-01-21 07:27:29');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `article_tag`
--
ALTER TABLE `article_tag`
  ADD CONSTRAINT `article_tag_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `article_tag_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `follows`
--
ALTER TABLE `follows`
  ADD CONSTRAINT `follows_followed_id_foreign` FOREIGN KEY (`followed_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `follows_follower_id_foreign` FOREIGN KEY (`follower_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
