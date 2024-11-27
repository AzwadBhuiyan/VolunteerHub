-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2024 at 06:37 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `volunteerhub`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `activityid` bigint(20) UNSIGNED NOT NULL,
  `userid` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `category` varchar(255) NOT NULL,
  `district` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `deadline` datetime NOT NULL,
  `min_volunteers` int(11) NOT NULL,
  `max_volunteers` int(11) DEFAULT NULL,
  `required_profession` varchar(255) DEFAULT NULL,
  `status` enum('open','closed','cancelled','completed') NOT NULL DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `accomplished_description` text DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `difficulty` varchar(255) DEFAULT NULL,
  `points` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`activityid`, `userid`, `title`, `description`, `date`, `time`, `category`, `district`, `address`, `deadline`, `min_volunteers`, `max_volunteers`, `required_profession`, `status`, `created_at`, `updated_at`, `accomplished_description`, `duration`, `difficulty`, `points`) VALUES
(1, 'org-001', 'Party on', 'lets go', '2024-10-04', '12:45:00', 'Agriculture', 'Dhaka', 'asdad', '2024-09-17 00:42:00', 1, 2, NULL, 'completed', '2024-09-20 12:42:20', '2024-10-06 04:12:39', 'it was great lets goooooooo', 4, NULL, 4),
(2, 'org-001', 'Lets go', 'lets go', '2024-09-27', '06:21:00', 'Agriculture', 'Dhaka', '1aaf', '2024-10-02 03:22:00', 1, 5, NULL, 'completed', '2024-09-25 15:22:15', '2024-09-26 15:24:28', NULL, NULL, NULL, 0),
(3, 'org-001', 'wall paint need artists', 'lets paint all the walls', '2024-09-30', '16:27:00', 'Agriculture', 'Dhaka', 'bashundhara', '2024-09-29 00:09:00', 3, 10, NULL, 'completed', '2024-09-26 15:52:59', '2024-09-26 16:11:06', 'all walls look beautiful', 6, 'easy', 0),
(5, 'org-001', 'EMERGENCY FLOOD RESCUE OPERATION', 'need 10 brave volunteers who are good swimmers', '2024-10-08', '06:28:00', 'Disaster Management', 'Gazipur', 'flood, bangladesh', '2024-10-07 23:28:00', 10, NULL, NULL, 'closed', '2024-10-04 18:29:14', '2024-11-20 15:07:32', NULL, NULL, 'easy', 0),
(6, 'org-001', 'Activity 1', 'This is a description for Activity 1', '2024-10-12', '20:16:44', 'Fundraising', 'Barguna', 'Address for Activity 1', '2024-10-11 20:16:44', 5, 24, NULL, 'closed', '2024-10-07 14:16:44', '2024-11-20 15:07:32', NULL, NULL, 'medium', 0),
(7, 'org-001', 'Activity 2', 'This is a description for Activity 2', '2024-11-06', '20:16:44', 'Arts and Culture', 'Dhaka', 'Address for Activity 2', '2024-11-04 20:16:44', 7, 24, 'Lawyer', 'closed', '2024-10-07 14:16:44', '2024-11-18 17:01:17', NULL, NULL, 'medium', 0),
(8, 'org-001', 'Activity 3', 'This is a description for Activity 3', '2024-10-20', '20:16:44', 'Advocacy', 'Dhaka', 'Address for Activity 3', '2024-10-15 20:16:44', 8, 15, NULL, 'open', '2024-10-07 14:16:44', '2024-11-20 15:07:32', NULL, NULL, 'medium', 0),
(9, 'org-001', 'Activity 4', 'This is a description for Activity 4', '2024-11-03', '20:16:44', 'Agriculture', 'Gazipur', 'Address for Activity 4', '2024-11-01 20:16:44', 8, 24, NULL, 'open', '2024-10-07 14:16:44', '2024-11-20 15:07:32', NULL, NULL, 'easy', 0),
(10, 'org-001', 'Activity 5', 'This is a description for Activity 5', '2024-10-23', '20:16:44', 'Agriculture', 'Faridpur', 'Address for Activity 5', '2024-10-19 20:16:44', 5, 23, NULL, 'open', '2024-10-07 14:16:44', '2024-11-20 15:07:32', NULL, NULL, 'easy', 0),
(11, 'org-001', 'Activity 6', 'This is a description for Activity 6', '2024-11-02', '20:16:44', 'Arts and Culture', 'Bhola', 'Address for Activity 6', '2024-11-01 20:16:44', 7, 21, NULL, 'closed', '2024-10-07 14:16:44', '2024-11-20 15:07:32', NULL, NULL, 'hard', 0),
(12, 'org-001', 'Activity 7', 'This is a description for Activity 7', '2024-10-13', '20:16:44', 'Environment', 'Thakurgaon', 'Address for Activity 7', '2024-10-08 20:16:44', 8, 28, NULL, 'open', '2024-10-07 14:16:44', '2024-11-20 15:07:32', NULL, NULL, 'hard', 0),
(13, 'org-001', 'Activity 8', 'This is a description for Activity 8', '2024-10-09', '20:16:44', 'Blood Donation', 'Manikganj', 'Address for Activity 8', '2024-10-05 20:16:44', 7, 18, NULL, 'closed', '2024-10-07 14:16:44', '2024-11-20 15:07:32', NULL, NULL, 'severe', 0),
(14, 'org-001', 'Activity 9', 'This is a description for Activity 9', '2024-10-20', '20:16:44', 'Advocacy', 'Nilphamari', 'Address for Activity 9', '2024-10-17 20:16:44', 6, 20, NULL, 'open', '2024-10-07 14:16:44', '2024-11-20 15:07:32', NULL, NULL, 'hard', 0),
(15, 'org-001', 'Activity 10', 'This is a description for Activity 10', '2024-10-15', '20:16:44', 'Fundraising', 'Kurigram', 'Address for Activity 10', '2024-10-13 20:16:44', 7, 23, NULL, 'closed', '2024-10-07 14:16:44', '2024-11-20 15:07:32', NULL, NULL, 'medium', 0);

-- --------------------------------------------------------

--
-- Table structure for table `activity_categories`
--

CREATE TABLE `activity_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_categories`
--

INSERT INTO `activity_categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Disaster Management', '2024-10-07 13:45:20', '2024-10-07 13:45:20'),
(2, 'Education', '2024-10-07 13:45:20', '2024-10-07 13:45:20'),
(3, 'Community Development', '2024-10-07 13:45:20', '2024-10-07 13:45:20'),
(4, 'Health', '2024-10-07 13:45:20', '2024-10-07 13:45:20'),
(5, 'Environment', '2024-10-07 13:45:20', '2024-10-07 13:45:20'),
(6, 'Child Care', '2024-10-07 13:45:20', '2024-10-07 13:45:20'),
(7, 'Donation', '2024-10-07 13:45:20', '2024-10-07 13:45:20'),
(8, 'Fundraising', '2024-10-07 13:45:20', '2024-10-07 13:45:20'),
(9, 'Poverty Reduction', '2024-10-07 13:45:20', '2024-10-07 13:45:20'),
(10, 'Microfinance', '2024-10-07 13:45:20', '2024-10-07 13:45:20'),
(11, 'Legal Assistance', '2024-10-07 13:45:20', '2024-10-07 13:45:20'),
(12, 'Blood Donation', '2024-10-07 13:45:20', '2024-10-07 13:45:20'),
(13, 'Technology', '2024-10-07 13:45:20', '2024-10-07 13:45:20'),
(14, 'Agriculture', '2024-10-07 13:45:20', '2024-10-07 13:45:20'),
(15, 'Arts and Culture', '2024-10-07 13:45:20', '2024-10-07 13:45:20'),
(16, 'Social Entrepreneurship', '2024-10-07 13:45:20', '2024-10-07 13:45:20'),
(17, 'Sports and Recreation', '2024-10-07 13:45:20', '2024-10-07 13:45:20'),
(18, 'Research', '2024-10-07 13:45:20', '2024-10-07 13:45:20'),
(19, 'Advocacy', '2024-10-07 13:45:20', '2024-10-07 13:45:20'),
(20, 'Humanitarian Aid', '2024-10-07 13:45:20', '2024-10-07 13:45:20'),
(21, 'Volunteer Coordination', '2024-10-07 13:45:20', '2024-10-07 13:45:20'),
(22, 'Others', '2024-10-07 13:45:20', '2024-10-07 13:45:20');

-- --------------------------------------------------------

--
-- Table structure for table `activity_milestones`
--

CREATE TABLE `activity_milestones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `activity_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_milestones`
--

INSERT INTO `activity_milestones` (`id`, `activity_id`, `message`, `created_at`, `updated_at`) VALUES
(1, 7, 'Startooo', '2024-10-27 13:34:45', '2024-10-27 13:34:45'),
(2, 7, 'Startooo', '2024-10-27 13:34:50', '2024-10-27 13:34:50'),
(3, 7, 'Endooooooo', '2024-10-27 13:35:15', '2024-10-27 13:35:15'),
(4, 7, 'surprise not end!!', '2024-10-27 13:57:25', '2024-10-27 13:57:25'),
(5, 11, 'meet up at bashundhara bus stand 8am', '2024-11-03 11:46:35', '2024-11-03 11:46:35'),
(6, 7, 'ss', '2024-11-11 10:40:49', '2024-11-11 10:40:49'),
(7, 7, 'hope everyone is doing well\r\n\r\nwe will resume tomorrow', '2024-11-22 00:43:19', '2024-11-22 00:43:19');

-- --------------------------------------------------------

--
-- Table structure for table `activity_requests`
--

CREATE TABLE `activity_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `volunteer_userid` varchar(255) NOT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `district` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `activity_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_requests`
--

INSERT INTO `activity_requests` (`id`, `volunteer_userid`, `approved_by`, `title`, `description`, `district`, `status`, `created_at`, `updated_at`, `activity_id`) VALUES
(1, '00002', 'org-001', 'Help our village', 'We live in a small village in the forest of sundarban. We\'ve been heavily affected by the flood please help us', 'Bhola', 'in_progress', '2024-11-22 03:36:21', '2024-11-22 12:23:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `activity_volunteers`
--

CREATE TABLE `activity_volunteers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `activityid` bigint(20) UNSIGNED NOT NULL,
  `volunteer_userid` varchar(255) NOT NULL,
  `approval_status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_volunteers`
--

INSERT INTO `activity_volunteers` (`id`, `activityid`, `volunteer_userid`, `approval_status`, `created_at`, `updated_at`) VALUES
(2, 1, '00002', 'approved', NULL, NULL),
(3, 3, '00002', 'approved', '2024-09-26 15:53:14', '2024-09-26 15:58:02'),
(4, 3, '00004', 'approved', '2024-09-26 15:54:10', '2024-09-26 15:58:02'),
(66, 3, '00003', 'approved', NULL, NULL),
(68, 11, '00002', 'approved', '2024-11-02 12:44:23', '2024-11-03 11:09:34'),
(69, 8, '00002', 'approved', '2024-11-02 12:44:33', '2024-11-03 11:09:11'),
(70, 13, '00002', 'pending', '2024-11-14 18:27:47', '2024-11-14 18:27:47'),
(75, 7, '00002', 'approved', '2024-11-14 18:56:07', '2024-11-14 18:56:07');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `volunteer_userid` varchar(255) NOT NULL,
  `favorite_categories` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`favorite_categories`)),
  `favorite_districts` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`favorite_districts`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `volunteer_userid`, `favorite_categories`, `favorite_districts`, `created_at`, `updated_at`) VALUES
(1, '00002', '[]', '[\"Bagerhat\"]', '2024-10-22 04:33:35', '2024-10-22 04:33:35'),
(2, '00004', '[\"Advocacy\"]', '[]', '2024-10-22 06:18:12', '2024-10-22 06:18:12');

-- --------------------------------------------------------

--
-- Table structure for table `idea_comments`
--

CREATE TABLE `idea_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idea_thread_id` bigint(20) UNSIGNED NOT NULL,
  `volunteer_userid` varchar(255) NOT NULL,
  `comment` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `idea_comments`
--

INSERT INTO `idea_comments` (`id`, `idea_thread_id`, `volunteer_userid`, `comment`, `created_at`, `updated_at`) VALUES
(1, 2, '00002', '2 words:\r\nmachine guns', '2024-10-03 12:28:33', '2024-10-03 12:28:33'),
(3, 2, '00004', 'time to build a medieval catapult', '2024-10-03 12:44:35', '2024-10-03 12:44:35'),
(4, 1, '00002', 'kill them all!', '2024-10-03 12:51:32', '2024-10-03 12:51:32'),
(5, 2, '00003', 'this is weird', '2024-10-03 15:55:21', '2024-10-03 15:55:21');

-- --------------------------------------------------------

--
-- Table structure for table `idea_polls`
--

CREATE TABLE `idea_polls` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idea_thread_id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `idea_polls`
--

INSERT INTO `idea_polls` (`id`, `idea_thread_id`, `question`, `created_at`, `updated_at`) VALUES
(3, 5, 'Communism will always fail', '2024-10-31 04:53:13', '2024-10-31 04:53:13');

-- --------------------------------------------------------

--
-- Table structure for table `idea_threads`
--

CREATE TABLE `idea_threads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userid` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'open',
  `votes` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `winner_comment_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `idea_threads`
--

INSERT INTO `idea_threads` (`id`, `userid`, `title`, `description`, `status`, `votes`, `created_at`, `updated_at`, `winner_comment_id`) VALUES
(1, 'org-001', 'how to stop corruption', 'lets hear it', 'open', 0, '2024-10-03 01:58:52', '2024-10-03 01:58:55', NULL),
(2, 'org-001', 'How would you rob a bank?', 'Best idea maker will be taken to jail\r\n\r\nNo bombs allowed', 'closed', 0, '2024-10-03 12:20:24', '2024-11-04 06:43:42', 3),
(5, 'org-001', 'Communism will always fail', 'am i right boiss??', 'open', 0, '2024-10-31 04:53:13', '2024-10-31 04:53:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `idea_votes`
--

CREATE TABLE `idea_votes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idea_thread_id` bigint(20) UNSIGNED DEFAULT NULL,
  `idea_comment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_userid` varchar(255) NOT NULL,
  `vote` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `idea_votes`
--

INSERT INTO `idea_votes` (`id`, `idea_thread_id`, `idea_comment_id`, `user_userid`, `vote`, `created_at`, `updated_at`) VALUES
(13, 2, 1, '00003', 1, '2024-10-03 16:43:36', '2024-10-03 16:43:36'),
(15, 2, 3, '00003', 1, '2024-10-03 16:48:20', '2024-10-03 16:48:20'),
(17, 2, NULL, '00004', 1, '2024-10-03 16:48:38', '2024-10-03 16:48:38'),
(18, 1, NULL, '00004', 1, '2024-10-03 16:48:41', '2024-10-03 16:48:41'),
(20, 2, 3, '00004', 1, '2024-10-03 16:48:55', '2024-10-03 16:48:55'),
(21, 2, NULL, '00003', 1, '2024-10-03 16:49:10', '2024-10-03 16:49:10'),
(39, 2, 3, 'org-001', 1, '2024-10-05 10:05:51', '2024-10-05 10:05:51'),
(41, 2, 5, 'org-001', 1, '2024-10-07 06:34:02', '2024-10-07 06:34:02'),
(42, 2, NULL, 'org-001', 1, '2024-10-07 06:34:04', '2024-10-07 06:34:04'),
(50, 1, NULL, '00002', 1, '2024-10-25 07:18:59', '2024-10-25 07:18:59'),
(56, 2, 3, '00002', 1, '2024-11-05 13:32:52', '2024-11-05 13:32:52'),
(57, 2, 1, '00002', 1, '2024-11-07 13:16:25', '2024-11-07 13:16:25'),
(61, 2, 5, '00002', 1, '2024-11-17 20:18:01', '2024-11-17 20:18:01'),
(63, 2, NULL, '00002', 1, '2024-11-17 20:18:35', '2024-11-17 20:18:35');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(19, '2024_09_07_194436_add_bio_to_volunteers_table', 3),
(20, '0001_01_01_000000_create_users_table', 4),
(21, '0001_01_01_000001_create_cache_table', 4),
(22, '0001_01_01_000002_create_jobs_table', 4),
(23, '2024_08_28_170817_create_volunteers_table', 4),
(24, '2024_08_28_174453_create_organizations_table', 4),
(25, '2024_09_02_093608_add_verified_to_users_table', 4),
(26, '2024_09_06_131216_create_activity_categories_table', 4),
(27, '2024_09_06_131342_create_volunteer_favorite_categories_table', 4),
(28, '2024_09_06_143531_create_activities_table', 4),
(29, '2024_09_06_144947_create_activity_volunteers_table', 4),
(31, '2024_09_26_210817_add_completion_details_to_activities_table', 5),
(32, '2024_09_27_193349_add_profession_to_volunteer_table', 6),
(33, '2024_09_29_093437_create_idea_threads_table', 6),
(34, '2024_09_29_093438_create_idea_comments_table', 6),
(35, '2024_09_29_093438_create_idea_polls_table', 6),
(36, '2024_09_29_093438_create_poll_options_table', 6),
(39, '2024_09_29_093458_create_idea_votes_table', 7),
(41, '2024_10_03_221834_add_status_to_idea_threads_table', 8),
(47, '2024_10_07_184918_create_favorites_table', 9),
(48, '2024_10_08_193437_create_volunteer_follows_table', 9),
(49, '2024_10_22_121517_add_allow_follow_to_volunteers_table', 10),
(52, '2024_10_27_191728_create_activity_milestones_table', 11),
(53, '2024_10_31_104305_create_poll_votes_table', 12),
(54, '2024_11_04_101626_create_add_winner_column_to_ideathread_table', 13),
(57, '2024_11_10_184547_add_role_to_users_table', 14),
(58, '2024_11_13_185436_add_required_profession_to_activities_table', 14),
(59, '2024_11_15_173422_add_email_verified_at_to_users_table', 15),
(60, '2024_11_21_005530_create_add_lockout_fields_to_users_table', 16),
(61, '2024_11_21_012219_create_add_2fa_fields_to_users_table', 17),
(62, '2024_11_22_084012_add_show_posts_to_users_table', 18),
(63, '2024_11_22_091501_create_activity_requests_table', 19),
(64, '2024_11_22_093819_add_last_requests_read_to_organizations_table', 20),
(65, '2024_11_22_181015_add_activity_id_to_requests_table', 21),
(67, '2024_11_23_075817_create_tutorial_progress_table', 22);

-- --------------------------------------------------------

--
-- Table structure for table `milestone_reads`
--

CREATE TABLE `milestone_reads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `milestone_id` bigint(20) UNSIGNED NOT NULL,
  `volunteer_userid` varchar(255) NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `milestone_reads`
--

INSERT INTO `milestone_reads` (`id`, `milestone_id`, `volunteer_userid`, `is_read`, `read_at`, `created_at`, `updated_at`) VALUES
(1, 1, '00002', 1, '2024-11-26 19:09:27', '2024-10-27 13:34:45', '2024-11-26 19:09:27'),
(2, 2, '00002', 1, '2024-11-26 19:09:27', '2024-10-27 13:34:50', '2024-11-26 19:09:27'),
(3, 3, '00002', 1, '2024-11-26 19:09:27', '2024-10-27 13:35:15', '2024-11-26 19:09:27'),
(4, 4, '00002', 1, '2024-11-26 19:09:27', '2024-10-27 13:57:25', '2024-11-26 19:09:27'),
(5, 5, '00002', 1, '2024-11-03 13:07:38', '2024-11-03 11:46:35', '2024-11-03 13:07:38'),
(6, 6, '00002', 1, '2024-11-26 19:09:27', '2024-11-11 10:40:49', '2024-11-26 19:09:27'),
(7, 7, '00002', 1, '2024-11-26 19:09:27', '2024-11-22 00:43:19', '2024-11-26 19:09:27');

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `userid` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `org_name` varchar(255) NOT NULL,
  `primary_address` text NOT NULL,
  `secondary_address` text NOT NULL,
  `website` varchar(255) NOT NULL,
  `org_mobile` varchar(255) NOT NULL,
  `org_telephone` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `verification_status` enum('unverified','verified') NOT NULL DEFAULT 'unverified',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_requests_read_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`userid`, `url`, `org_name`, `primary_address`, `secondary_address`, `website`, `org_mobile`, `org_telephone`, `description`, `verification_status`, `created_at`, `updated_at`, `last_requests_read_at`) VALUES
('org-001', 'rahatinc', 'rahat inc', 'dh', 'dh', 'https://www.facebook.com/rht.krmO.o/', '123', '132', 'we believe in hella money $$$$$', 'verified', '2024-09-20 07:52:52', '2024-11-22 23:41:32', '2024-11-22 23:41:32'),
('org-002', 'org-002', 'org', 'org', 'org', 'https://org@c.com', '91239', '123123', NULL, 'unverified', '2024-09-20 10:18:14', '2024-09-20 10:18:14', NULL),
('org-003', 'org-003', 'Gift for good', 'bashundhara r/a', 'bashundhara r/a', 'https://www.netflix.com/', '01990385489', '01288841', NULL, 'unverified', '2024-11-07 13:34:29', '2024-11-07 13:34:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `poll_options`
--

CREATE TABLE `poll_options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idea_poll_id` bigint(20) UNSIGNED NOT NULL,
  `option_text` varchar(255) NOT NULL,
  `votes` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `poll_options`
--

INSERT INTO `poll_options` (`id`, `idea_poll_id`, `option_text`, `votes`, `created_at`, `updated_at`) VALUES
(6, 3, 'yes', 1, '2024-10-31 04:53:13', '2024-11-16 17:28:43'),
(7, 3, 'no', 2, '2024-10-31 04:53:13', '2024-11-16 17:28:43'),
(8, 3, 'it wasn\'t tried correctly!! boohooo I CRYYY', 0, '2024-10-31 04:53:13', '2024-11-04 03:43:07');

-- --------------------------------------------------------

--
-- Table structure for table `poll_votes`
--

CREATE TABLE `poll_votes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idea_poll_id` bigint(20) UNSIGNED NOT NULL,
  `poll_option_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `poll_votes`
--

INSERT INTO `poll_votes` (`id`, `idea_poll_id`, `poll_option_id`, `user_id`, `created_at`, `updated_at`) VALUES
(2, 3, 6, '00004', '2024-10-31 05:16:52', '2024-10-31 05:16:52'),
(20, 3, 7, '00002', '2024-11-05 13:32:13', '2024-11-05 13:32:13'),
(26, 3, 7, '00006', '2024-11-16 17:28:43', '2024-11-16 17:28:43');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tutorial_progress`
--

CREATE TABLE `tutorial_progress` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userid` varchar(255) NOT NULL,
  `page_name` varchar(255) NOT NULL,
  `dont_show_again` tinyint(1) NOT NULL DEFAULT 0,
  `last_step_seen` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tutorial_progress`
--

INSERT INTO `tutorial_progress` (`id`, `userid`, `page_name`, `dont_show_again`, `last_step_seen`, `created_at`, `updated_at`) VALUES
(1, '00002', 'volunteer_dashboard', 0, 0, NULL, NULL),
(2, '00007', 'volunteer_dashboard', 0, 0, '2024-11-26 21:30:40', '2024-11-26 23:29:57'),
(3, '00007', 'volunteer_profile', 0, 0, '2024-11-26 21:30:40', '2024-11-26 23:29:57'),
(4, '00007', 'favorites', 1, 0, '2024-11-26 21:30:40', '2024-11-26 23:30:19'),
(5, '00007', 'home', 0, 0, '2024-11-26 21:30:40', '2024-11-26 23:29:57'),
(6, '00002', 'favorites', 0, 0, '2024-11-27 05:31:08', '2024-11-27 05:31:08'),
(7, '00002', 'volunteer_profile', 0, 0, '2024-11-27 05:31:08', '2024-11-27 05:31:08'),
(8, '00002', 'home', 0, 0, '2024-11-27 05:31:47', '2024-11-27 05:31:47');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('admin','volunteer','organization') NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `login_attempts` int(11) NOT NULL DEFAULT 0,
  `locked_until` timestamp NULL DEFAULT NULL,
  `max_attempts` int(11) NOT NULL DEFAULT 5,
  `two_factor_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `show_posts` tinyint(1) NOT NULL DEFAULT 1,
  `two_factor_code` varchar(255) DEFAULT NULL,
  `two_factor_expires_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `email`, `role`, `password`, `remember_token`, `created_at`, `updated_at`, `verified`, `email_verified_at`, `login_attempts`, `locked_until`, `max_attempts`, `two_factor_enabled`, `show_posts`, `two_factor_code`, `two_factor_expires_at`) VALUES
('00002', 'volunteer@gmail.com', 'volunteer', '$2y$12$UoCj2BpNB1JrgIt52cSfzOMdn08Wk/HJj6ro8Gv6jB7vtw5GSEWLC', NULL, '2024-09-20 07:54:58', '2024-11-22 02:58:56', 1, '2024-11-11 02:01:23', 0, NULL, 5, 0, 0, NULL, '2024-11-22 00:19:18'),
('00003', 'rht.krt@gmail.com', 'volunteer', '$2y$12$V7A2GOSUdQgSk.EwzPdE.elMi29NAzgkxYZdVpfdhepWW86LsmCSa', NULL, '2024-09-20 10:19:02', '2024-09-20 10:19:02', 1, NULL, 0, NULL, 5, 0, 1, NULL, NULL),
('00004', 'as2@gmail.com', 'volunteer', '$2y$12$jVXp.L4xCT/eGMS1mvziT.RyvbmZ57Rqx9L9gCBP/lOyXs8B34ucO', NULL, '2024-09-26 15:50:49', '2024-09-26 15:50:49', 0, NULL, 0, NULL, 5, 0, 1, NULL, NULL),
('00005', 'real@gmail.com', 'volunteer', '$2y$12$6K3SsBVUR/cfj.pZhCJr/O3cMTtm.qVlP6kc7H6S1VJDyfzxhMqpa', NULL, '2024-11-07 13:46:08', '2024-11-07 13:46:08', 1, NULL, 0, NULL, 5, 0, 1, NULL, NULL),
('00006', 'test@test.com', 'admin', '$2y$12$QGwn3t/.ezDJOy28KOWKIOSuuOqvL45e8OWBVWhDB3kM/bKzkZhyW', NULL, '2024-11-16 16:48:03', '2024-11-16 16:48:03', 1, NULL, 0, NULL, 5, 0, 1, NULL, NULL),
('00007', 'a@b.com', 'volunteer', '$2y$12$7savz3GUMPYzTDUWFMKxBuPvS.NxEPMVfLdT9ApGWit9W7u3N6Jzm', NULL, '2024-11-26 21:30:40', '2024-11-26 21:30:40', 1, '2024-11-27 03:31:31', 0, NULL, 5, 0, 1, NULL, NULL),
('org-001', 'organization@gmail.com', 'organization', '$2y$12$eohVVZ72P3qUd9MFC/eKFOmQIHraB1FLZsIS3bLKuc5Gdk31p3I8a', NULL, '2024-09-20 07:52:52', '2024-11-22 00:42:32', 1, '2024-11-05 02:24:37', 0, NULL, 5, 0, 1, NULL, '2024-11-22 00:52:20'),
('org-002', 'org2@gmail.com', 'organization', '$2y$12$R1fNsPbwj5ZicKAPcZPnDe6XoqPKjfmkOl6mYNFBxGMoQW4Mif9gO', NULL, '2024-09-20 10:18:14', '2024-09-20 10:18:14', 1, '2024-11-19 19:56:25', 0, NULL, 5, 0, 1, NULL, NULL),
('org-003', 'org@gmail.com', 'organization', '$2y$12$iebVwhgixO161EblQEmMruTLsMtLZnrmvjeA42AgCXPLIJm/bojCC', NULL, '2024-11-07 13:34:29', '2024-11-07 13:34:29', 0, NULL, 0, NULL, 5, 0, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `volunteers`
--

CREATE TABLE `volunteers` (
  `userid` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Phone` varchar(255) NOT NULL,
  `NID` varchar(255) DEFAULT NULL,
  `Gender` enum('M','F','O') NOT NULL,
  `DOB` date NOT NULL,
  `BloodGroup` varchar(255) NOT NULL,
  `PresentAddress` text NOT NULL,
  `PermanentAddress` text NOT NULL,
  `District` enum('Dhaka','Chittagong','Rajshahi','Khulna','Barisal','Sylhet','Rangpur','Mymensingh','Comilla','Narayanganj','Gazipur','Faridpur','Gopalganj','Kishoreganj','Madaripur','Manikganj','Munshiganj','Narsingdi','Rajbari','Shariatpur','Tangail','Brahmanbaria','Chandpur','Coxs Bazar','Feni','Khagrachari','Lakshmipur','Noakhali','Rangamati','Bandarban','Bagerhat','Chuadanga','Jashore','Jhenaidah','Kushtia','Magura','Meherpur','Narail','Satkhira','Barguna','Bhola','Jhalokathi','Patuakhali','Pirojpur','Bogra','Jaipurhat','Naogaon','Natore','Nawabganj','Pabna','Sirajganj','Dinajpur','Gaibandha','Kurigram','Lalmonirhat','Nilphamari','Panchagarh','Thakurgaon','Habiganj','Maulvibazar','Sunamganj','Jamalpur','Netrokona','Sherpur') NOT NULL,
  `TrainedInEmergencyResponse` tinyint(1) NOT NULL DEFAULT 0,
  `Points` int(11) NOT NULL DEFAULT 0,
  `profession` varchar(255) DEFAULT NULL,
  `Badges` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`Badges`)),
  `bio` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `allow_follow` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `volunteers`
--

INSERT INTO `volunteers` (`userid`, `url`, `Name`, `Phone`, `NID`, `Gender`, `DOB`, `BloodGroup`, `PresentAddress`, `PermanentAddress`, `District`, `TrainedInEmergencyResponse`, `Points`, `profession`, `Badges`, `bio`, `created_at`, `updated_at`, `allow_follow`) VALUES
('00002', 'TheGreatestVolunteerWhoLived', 'Abbas ali', '01990376524', '1293847561', 'M', '2024-09-25', 'A+', '4th floor, House 439, Rupayan Suraiya, Road 18, Block A, Bashundhara', '4th floor, House 439, Rupayan Suraiya, Road 18, Block A, Bashundhara', 'Dhaka', 0, 33, 'Lawyer', NULL, 'I am TheGreatestVolunteerWhoLived. Bow down before me', '2024-09-20 07:54:58', '2024-11-13 13:33:44', 1),
('00003', '00003', 'Rahatul Karim', '01990376524', NULL, 'M', '2024-09-11', 'A+', '4th floor, House 439, Rupayan Suraiya, Road 18, Block A, Bashundhara', '4th floor, House 439, Rupayan Suraiya, Road 18, Block A, Bashundhara', 'Dhaka', 0, 0, NULL, NULL, NULL, '2024-09-20 10:19:02', '2024-09-20 10:19:02', 1),
('00004', 'fatherTeresa', 'asdf', '01990376524', NULL, 'M', '1992-06-09', 'A+', '4th floor, House 439, Rupayan Suraiya, Road 18, Block A, Bashundhara', '4th floor, House 439, Rupayan Suraiya, Road 18, Block A, Bashundhara', 'Gopalganj', 0, 6, NULL, NULL, NULL, '2024-09-26 15:50:49', '2024-10-30 07:30:12', 0),
('00005', '00005', 'Real Person', '01234567891', NULL, 'M', '2002-01-30', 'Not Set', 'Real Address', 'Real Address', 'Dhaka', 0, 0, NULL, NULL, NULL, '2024-11-07 13:46:08', '2024-11-07 13:46:08', 1),
('00007', '00007', 'abc', '12345689011', NULL, 'M', '1981-04-02', 'Not Set', 'abc', 'abc', 'Dhaka', 0, 0, NULL, NULL, NULL, '2024-11-26 21:30:40', '2024-11-26 21:30:40', 1);

-- --------------------------------------------------------

--
-- Table structure for table `volunteer_follows`
--

CREATE TABLE `volunteer_follows` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `follower_id` varchar(255) NOT NULL,
  `followed_id` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `volunteer_follows`
--

INSERT INTO `volunteer_follows` (`id`, `follower_id`, `followed_id`, `type`, `created_at`, `updated_at`) VALUES
(2, '00002', 'org-001', 'organization', '2024-10-22 04:50:54', '2024-10-22 04:50:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`activityid`),
  ADD KEY `activities_userid_foreign` (`userid`);

--
-- Indexes for table `activity_categories`
--
ALTER TABLE `activity_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activity_milestones`
--
ALTER TABLE `activity_milestones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_milestones_activity_id_foreign` (`activity_id`);

--
-- Indexes for table `activity_requests`
--
ALTER TABLE `activity_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_requests_volunteer_userid_foreign` (`volunteer_userid`),
  ADD KEY `activity_requests_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `activity_volunteers`
--
ALTER TABLE `activity_volunteers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `activity_volunteers_activityid_volunteer_userid_unique` (`activityid`,`volunteer_userid`),
  ADD KEY `activity_volunteers_volunteer_userid_foreign` (`volunteer_userid`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `favorites_volunteer_userid_foreign` (`volunteer_userid`);

--
-- Indexes for table `idea_comments`
--
ALTER TABLE `idea_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idea_comments_idea_thread_id_foreign` (`idea_thread_id`),
  ADD KEY `idea_comments_volunteer_userid_foreign` (`volunteer_userid`);

--
-- Indexes for table `idea_polls`
--
ALTER TABLE `idea_polls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idea_polls_idea_thread_id_foreign` (`idea_thread_id`);

--
-- Indexes for table `idea_threads`
--
ALTER TABLE `idea_threads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idea_threads_userid_foreign` (`userid`),
  ADD KEY `idea_threads_winner_comment_id_foreign` (`winner_comment_id`);

--
-- Indexes for table `idea_votes`
--
ALTER TABLE `idea_votes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idea_vote_unique` (`idea_thread_id`,`idea_comment_id`,`user_userid`),
  ADD KEY `idea_votes_idea_comment_id_foreign` (`idea_comment_id`),
  ADD KEY `idea_votes_user_userid_foreign` (`user_userid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `milestone_reads`
--
ALTER TABLE `milestone_reads`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `milestone_reads_milestone_id_volunteer_userid_unique` (`milestone_id`,`volunteer_userid`),
  ADD KEY `milestone_reads_volunteer_userid_foreign` (`volunteer_userid`);

--
-- Indexes for table `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`userid`),
  ADD UNIQUE KEY `organizations_url_unique` (`url`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `poll_options`
--
ALTER TABLE `poll_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `poll_options_idea_poll_id_foreign` (`idea_poll_id`);

--
-- Indexes for table `poll_votes`
--
ALTER TABLE `poll_votes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `poll_votes_idea_poll_id_user_id_unique` (`idea_poll_id`,`user_id`),
  ADD KEY `poll_votes_poll_option_id_foreign` (`poll_option_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `tutorial_progress`
--
ALTER TABLE `tutorial_progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tutorial_progress_userid_foreign` (`userid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `volunteers`
--
ALTER TABLE `volunteers`
  ADD PRIMARY KEY (`userid`),
  ADD UNIQUE KEY `volunteers_url_unique` (`url`);

--
-- Indexes for table `volunteer_follows`
--
ALTER TABLE `volunteer_follows`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vol_follows_unique` (`follower_id`,`followed_id`,`type`),
  ADD KEY `volunteer_follows_followed_id_type_index` (`followed_id`,`type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `activityid` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `activity_categories`
--
ALTER TABLE `activity_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `activity_milestones`
--
ALTER TABLE `activity_milestones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `activity_requests`
--
ALTER TABLE `activity_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `activity_volunteers`
--
ALTER TABLE `activity_volunteers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `idea_comments`
--
ALTER TABLE `idea_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `idea_polls`
--
ALTER TABLE `idea_polls`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `idea_threads`
--
ALTER TABLE `idea_threads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `idea_votes`
--
ALTER TABLE `idea_votes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `milestone_reads`
--
ALTER TABLE `milestone_reads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `poll_options`
--
ALTER TABLE `poll_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `poll_votes`
--
ALTER TABLE `poll_votes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tutorial_progress`
--
ALTER TABLE `tutorial_progress`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `volunteer_follows`
--
ALTER TABLE `volunteer_follows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_userid_foreign` FOREIGN KEY (`userid`) REFERENCES `organizations` (`userid`) ON DELETE CASCADE;

--
-- Constraints for table `activity_milestones`
--
ALTER TABLE `activity_milestones`
  ADD CONSTRAINT `activity_milestones_activity_id_foreign` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`activityid`) ON DELETE CASCADE;

--
-- Constraints for table `activity_requests`
--
ALTER TABLE `activity_requests`
  ADD CONSTRAINT `activity_requests_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `organizations` (`userid`) ON DELETE SET NULL,
  ADD CONSTRAINT `activity_requests_volunteer_userid_foreign` FOREIGN KEY (`volunteer_userid`) REFERENCES `volunteers` (`userid`) ON DELETE CASCADE;

--
-- Constraints for table `activity_volunteers`
--
ALTER TABLE `activity_volunteers`
  ADD CONSTRAINT `activity_volunteers_activityid_foreign` FOREIGN KEY (`activityid`) REFERENCES `activities` (`activityid`) ON DELETE CASCADE,
  ADD CONSTRAINT `activity_volunteers_volunteer_userid_foreign` FOREIGN KEY (`volunteer_userid`) REFERENCES `volunteers` (`userid`) ON DELETE CASCADE;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_volunteer_userid_foreign` FOREIGN KEY (`volunteer_userid`) REFERENCES `volunteers` (`userid`) ON DELETE CASCADE;

--
-- Constraints for table `idea_comments`
--
ALTER TABLE `idea_comments`
  ADD CONSTRAINT `idea_comments_idea_thread_id_foreign` FOREIGN KEY (`idea_thread_id`) REFERENCES `idea_threads` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `idea_comments_volunteer_userid_foreign` FOREIGN KEY (`volunteer_userid`) REFERENCES `volunteers` (`userid`) ON DELETE CASCADE;

--
-- Constraints for table `idea_polls`
--
ALTER TABLE `idea_polls`
  ADD CONSTRAINT `idea_polls_idea_thread_id_foreign` FOREIGN KEY (`idea_thread_id`) REFERENCES `idea_threads` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `idea_threads`
--
ALTER TABLE `idea_threads`
  ADD CONSTRAINT `idea_threads_userid_foreign` FOREIGN KEY (`userid`) REFERENCES `organizations` (`userid`) ON DELETE CASCADE,
  ADD CONSTRAINT `idea_threads_winner_comment_id_foreign` FOREIGN KEY (`winner_comment_id`) REFERENCES `idea_comments` (`id`);

--
-- Constraints for table `idea_votes`
--
ALTER TABLE `idea_votes`
  ADD CONSTRAINT `idea_votes_idea_comment_id_foreign` FOREIGN KEY (`idea_comment_id`) REFERENCES `idea_comments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `idea_votes_idea_thread_id_foreign` FOREIGN KEY (`idea_thread_id`) REFERENCES `idea_threads` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `idea_votes_user_userid_foreign` FOREIGN KEY (`user_userid`) REFERENCES `users` (`userid`) ON DELETE CASCADE;

--
-- Constraints for table `milestone_reads`
--
ALTER TABLE `milestone_reads`
  ADD CONSTRAINT `milestone_reads_milestone_id_foreign` FOREIGN KEY (`milestone_id`) REFERENCES `activity_milestones` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `milestone_reads_volunteer_userid_foreign` FOREIGN KEY (`volunteer_userid`) REFERENCES `volunteers` (`userid`) ON DELETE CASCADE;

--
-- Constraints for table `organizations`
--
ALTER TABLE `organizations`
  ADD CONSTRAINT `organizations_userid_foreign` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`) ON DELETE CASCADE;

--
-- Constraints for table `poll_options`
--
ALTER TABLE `poll_options`
  ADD CONSTRAINT `poll_options_idea_poll_id_foreign` FOREIGN KEY (`idea_poll_id`) REFERENCES `idea_polls` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `poll_votes`
--
ALTER TABLE `poll_votes`
  ADD CONSTRAINT `poll_votes_idea_poll_id_foreign` FOREIGN KEY (`idea_poll_id`) REFERENCES `idea_polls` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `poll_votes_poll_option_id_foreign` FOREIGN KEY (`poll_option_id`) REFERENCES `poll_options` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tutorial_progress`
--
ALTER TABLE `tutorial_progress`
  ADD CONSTRAINT `tutorial_progress_userid_foreign` FOREIGN KEY (`userid`) REFERENCES `volunteers` (`userid`) ON DELETE CASCADE;

--
-- Constraints for table `volunteers`
--
ALTER TABLE `volunteers`
  ADD CONSTRAINT `volunteers_userid_foreign` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`) ON DELETE CASCADE;

--
-- Constraints for table `volunteer_follows`
--
ALTER TABLE `volunteer_follows`
  ADD CONSTRAINT `volunteer_follows_follower_id_foreign` FOREIGN KEY (`follower_id`) REFERENCES `volunteers` (`userid`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
