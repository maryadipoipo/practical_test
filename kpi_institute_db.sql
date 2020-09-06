-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Sep 06, 2020 at 02:37 AM
-- Server version: 8.0.18
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
-- Database: `kpi_institute_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

DROP TABLE IF EXISTS `activities`;
CREATE TABLE IF NOT EXISTS `activities` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `skills` json NOT NULL,
  `participants` json NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `created_at`, `updated_at`, `deleted_at`, `user_id`, `title`, `description`, `start_date`, `end_date`, `skills`, `participants`) VALUES
(1, '2020-09-05 07:37:35', '2020-09-05 07:37:35', NULL, 3, 'First activity', 'First activity', '2020-09-05', '2020-09-11', '[{\"key\": \"2\", \"skill_name\": \"laravel\"}]', '[{\"key\": \"3\", \"name\": \"kpi_admin\"}, {\"key\": \"8\", \"name\": \"board3\"}]'),
(2, '2020-09-05 08:55:26', '2020-09-05 09:02:41', '2020-09-05 09:02:41', 3, 'First activity', 'First activity', '2020-09-05', '2020-09-11', '[{\"key\": \"2\", \"skill_name\": \"laravel\"}]', '[{\"key\": \"3\", \"name\": \"kpi_admin\"}]'),
(3, '2020-09-05 08:56:51', '2020-09-05 08:58:29', NULL, 3, 'First activity', 'First activity', '2020-09-05', '2020-09-11', '[{\"key\": \"2\", \"skill_name\": \"laravel\"}, {\"key\": \"7\", \"skill_name\": \"css\"}]', '[{\"key\": \"6\", \"name\": \"trainer1\"}, {\"key\": \"8\", \"name\": \"board3\"}]');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2020_09_04_114510_add_new_column_to_users', 1),
(5, '2020_09_04_121458_add_profiles_table', 2),
(6, '2020_09_04_141909_create_skills_table', 3),
(9, '2020_09_04_142648_create_activities_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

DROP TABLE IF EXISTS `profiles`;
CREATE TABLE IF NOT EXISTS `profiles` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `title` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `created_at`, `updated_at`, `deleted_at`, `title`, `user_id`) VALUES
(1, '2020-09-04 07:10:41', '2020-09-04 07:15:57', '0000-00-00 00:00:00', 'edited_profile', 3),
(2, '2020-09-04 08:16:05', '2020-09-05 09:18:21', NULL, 'board', 3),
(3, '2020-09-04 14:54:32', '2020-09-04 18:46:01', NULL, 'expert', 3),
(4, '2020-09-04 16:56:31', '2020-09-04 18:46:10', NULL, 'trainer', 3),
(5, '2020-09-04 17:01:18', '2020-09-04 17:58:07', '2020-09-04 17:58:07', 'profile_4', 3),
(6, '2020-09-04 17:01:26', '2020-09-04 17:33:52', '2020-09-04 17:33:52', 'profile_6', 3),
(7, '2020-09-04 17:35:51', '2020-09-04 17:35:57', '2020-09-04 17:35:57', 'test_profile_edit', 3),
(8, '2020-09-04 17:59:48', '2020-09-04 18:00:00', '2020-09-04 18:00:00', 'test_profile', 3);

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

DROP TABLE IF EXISTS `skills`;
CREATE TABLE IF NOT EXISTS `skills` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `title` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `created_at`, `updated_at`, `deleted_at`, `title`, `user_id`) VALUES
(1, '2020-09-04 07:54:50', '2020-09-04 07:56:56', '2020-09-04 07:56:56', 'edited_skill', 3),
(2, '2020-09-04 18:10:08', '2020-09-05 09:18:39', NULL, 'laravel', 3),
(3, '2020-09-04 18:34:07', '2020-09-04 18:34:07', NULL, 'jquery', 3),
(7, '2020-09-04 20:00:28', '2020-09-04 20:00:28', NULL, 'css', 3),
(4, '2020-09-04 18:37:34', '2020-09-04 18:39:08', '2020-09-04 18:39:08', 'test', 3),
(5, '2020-09-04 18:37:39', '2020-09-04 18:37:43', '2020-09-04 18:37:43', 'test2', 3),
(6, '2020-09-04 18:39:15', '2020-09-04 18:39:26', '2020-09-04 18:39:26', 'skill2', 3),
(8, '2020-09-04 20:00:35', '2020-09-04 20:00:35', NULL, 'javascript', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'guest_user',
  `skills` json DEFAULT NULL,
  `profile_id` int(10) UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`, `username`, `skills`, `profile_id`) VALUES
(3, 'kpi_admin', 'kpi@institute.net', '$2y$10$bfGcWQWpIG5WCEvfJg0iP.XqZ8O6fb/.CLigrPQNTj1hUCVHCUZv2', NULL, '2020-09-04 05:51:06', '2020-09-04 05:51:06', NULL, 'kpi@institute.net', '[{\"key\": 2, \"skill_name\": \"laravel\"}, {\"key\": 3, \"skill_name\": \"jquery\"}]', 3),
(4, 'board_1', 'board1@board.com', '$2y$10$euK85zu01lE1SL9KTT/wFegNthFja45qYd0sfueafsAos861iLQwG', NULL, '2020-09-05 04:35:38', '2020-09-05 05:01:56', '2020-09-05 05:01:56', 'board_1', '[{\"key\": \"7\", \"skill_name\": \"css\"}, {\"key\": \"8\", \"skill_name\": \"javascript\"}]', 2),
(5, 'board2', 'board2@mail.com', '$2y$10$eQFT27W2H5.Y6PDHtPrFmeZyq4EXdjh05Ewm7mXFgAl66eIOsJgDe', NULL, '2020-09-05 04:41:52', '2020-09-05 05:02:37', '2020-09-05 05:02:37', 'board2@mail.com', '[{\"key\": \"2\", \"skill_name\": \"laravel\"}, {\"key\": \"3\", \"skill_name\": \"jquery\"}]', 2),
(6, 'trainer1', 'trainer1@kpi.net', '$2y$10$3W93ZVoMi2gmzJUrp3bA1eubvggjdmJChEnGHu01R4NBvEmYlHB2S', NULL, '2020-09-05 04:44:09', '2020-09-05 04:44:09', NULL, 'trainer1@kpi.net', '[{\"key\": \"7\", \"skill_name\": \"css\"}, {\"key\": \"8\", \"skill_name\": \"javascript\"}]', 4),
(7, 'board1', 'board1@gmail.com', '$2y$10$xXb56kA3MPXulXAm.pC.YOi2emqTiFLoOFp1ZQFfLFw7lwtHEsf3O', NULL, '2020-09-05 05:05:33', '2020-09-05 05:05:40', '2020-09-05 05:05:40', 'board1@gmail.com', '[{\"key\": \"3\", \"skill_name\": \"jquery\"}, {\"key\": \"7\", \"skill_name\": \"css\"}, {\"key\": \"8\", \"skill_name\": \"javascript\"}]', 2),
(8, 'board3', 'board@board.com', '$2y$10$8Yza3OKWZdTGR5KnBy2xgOefxc.MP2TtKGFAuUSH4MoK/6srOfTta', NULL, '2020-09-05 07:08:32', '2020-09-05 18:43:29', NULL, 'board3', '[{\"key\": \"2\", \"skill_name\": \"laravel\"}, {\"key\": \"8\", \"skill_name\": \"javascript\"}]', 2);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
