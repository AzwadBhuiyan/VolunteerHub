-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2024 at 01:43 PM
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
  `google_maps_link` varchar(255) DEFAULT NULL,
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

INSERT INTO `activities` (`activityid`, `userid`, `title`, `description`, `date`, `time`, `category`, `district`, `address`, `google_maps_link`, `deadline`, `min_volunteers`, `max_volunteers`, `required_profession`, `status`, `created_at`, `updated_at`, `accomplished_description`, `duration`, `difficulty`, `points`) VALUES
(1, 'org-001', 'Tran bitoron to flood affected areas near chittagong', 'We need all the help we can get. Together let\'s try to put a positive impact in those people\'s lives.', '2024-12-12', '10:00:00', 'Disaster Management', 'Chittagong', 'Chittagong', NULL, '2024-12-04 12:00:00', 20, 30, NULL, 'completed', '2024-11-27 15:34:44', '2024-11-27 17:58:05', 'It was a very succesfull event. The turnout was amazing. We could reach more people than what was initially aimed for. Lets bring this back soon.', 6, 'easy', 6),
(2, 'org-001', 'Clean Up Dhaka!', 'It\'s time to take things on our own hands. Let\'s make the place we live in more liveable. Gather your brooms and ready those gloves. We are hoping to cover most of north dhaka but volunteers from all areas are welcome', '2024-12-20', '12:00:00', 'Community Development', 'Dhaka', 'Uttara, 12no sector', 'https://maps.app.goo.gl/zpFgVnymy3b2grL66', '2024-12-16 12:00:00', 2, 15, NULL, 'open', '2024-11-27 17:47:10', '2024-11-27 17:47:10', NULL, NULL, 'easy', 0),
(3, 'org-001', 'test', 'test', '2024-12-31', '08:00:00', 'Research', 'Gazipur', 'test', NULL, '2024-12-16 12:00:00', 1, NULL, NULL, 'open', '2024-12-03 11:31:20', '2024-12-03 11:31:20', NULL, NULL, 'medium', 0),
(4, 'org-001', 'Relief for Noakhali: Volunteer for Flood Recovery 🌊', 'Be a beacon of hope for flood-affected families in Noakhali. Join us in our mission to provide essential aid, including food, clean water, clothing, and medical supplies, to those in need. Together, we can help rebuild lives and restore hope in this time of crisis. Your time, effort, and compassion can make a lasting difference in the lives of many.', '2024-12-27', '10:00:00', 'Disaster Management', 'Noakhali', 'Luxmipur, Noakhali', NULL, '2024-12-12 12:00:00', 15, NULL, NULL, 'open', '2024-12-06 06:41:52', '2024-12-06 06:41:52', NULL, NULL, 'medium', 0),
(5, 'org-001', 'Volunteer Day in Sylhet 🌿', 'Join us for an inspiring day of community service in the beautiful landscapes of Sylhet! This event includes tree planting in tea gardens, river clean-ups, and engaging with local communities to create a positive impact. Together, let’s make Sylhet greener, cleaner, and more vibrant for everyone. All ages are welcome, and your efforts will contribute to preserving the natural beauty and cultural heritage of this stunning region.', '2024-12-30', '12:00:00', 'Environment', 'Sylhet', 'Habiganj, Sylhet', NULL, '2024-12-18 12:00:00', 5, NULL, NULL, 'open', '2024-12-06 06:43:22', '2024-12-06 06:43:22', NULL, NULL, 'medium', 0);

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
(1, 1, 'There will be a pre-meeting before the actual event on 12th. We will be meeting at our office on 8th December, 2024 to discuss plans for the event day. See you everyone.', '2024-11-27 15:36:14', '2024-11-27 15:36:14'),
(2, 2, 'Volunteers we will provide you with all equipments. For any queries about this event visit our website or contact us at gift@good.com', '2024-11-27 17:50:17', '2024-11-27 17:50:17');

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

-- --------------------------------------------------------

--
-- Table structure for table `activity_volunteers`
--

CREATE TABLE `activity_volunteers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `activityid` bigint(20) UNSIGNED NOT NULL,
  `volunteer_userid` varchar(255) NOT NULL,
  `approval_status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `visibility` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_volunteers`
--

INSERT INTO `activity_volunteers` (`id`, `activityid`, `volunteer_userid`, `approval_status`, `visibility`, `created_at`, `updated_at`) VALUES
(1, 1, '00001', 'approved', 0, '2024-11-27 16:05:31', '2024-11-30 23:32:52'),
(2, 1, '00003', 'approved', 1, '2024-11-27 16:15:42', '2024-11-27 17:51:52'),
(3, 2, '00001', 'pending', 1, '2024-11-27 18:22:45', '2024-11-27 18:22:45');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('c5d45e590efb5ee912f68f9060c3acef', 'i:2;', 1733486262),
('c5d45e590efb5ee912f68f9060c3acef:timer', 'i:1733486262;', 1733486262);

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
(1, '00001', '[\"Community Development\",\"Arts and Culture\",\"Community Development\",\"Fundraising\",\"Health\"]', '[\"Dhaka\"]', '2024-12-01 04:36:08', '2024-12-01 04:50:32');

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
(1, 2, '00001', 'It is only with the help of locals around those places can we hope to achieve this. They will know the best routes and methods. Then we can improve upon those ways.', '2024-11-27 18:38:01', '2024-11-27 18:38:01'),
(2, 2, '00003', 'We need to petition the government to create accessible roads to these places. This will not only benefit organizations trying to reach and help these areas but also the locals moving about here.', '2024-12-01 05:06:57', '2024-12-01 05:06:57');

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
(1, 1, 'Should we do clean up dhaka again soon?', '2024-11-27 18:04:21', '2024-11-27 18:04:21');

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
(1, 'org-001', 'Should we do clean up dhaka again soon?', 'Since the last event for clean up dhaka was successful we want to organize one again. But it hasn\'t been that long. We want to hear what you want.', 'open', 0, '2024-11-27 18:04:21', '2024-11-27 18:04:21', NULL),
(2, 'org-001', 'How to increase our reach into isolated areas of bangladesh?', 'The most accessible and implementable solution will win. The volunteer who wins will be taken into our project.', 'open', 0, '2024-11-27 18:21:40', '2024-11-27 18:21:40', NULL),
(3, 'org-001', 'What is the main issue the population of bangladesh is facing?', '.', 'open', 0, '2024-11-27 18:43:41', '2024-11-27 18:43:41', NULL);

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
(14, 2, 1, '00001', 1, '2024-12-01 00:43:15', '2024-12-01 00:43:15'),
(22, 2, 1, '00003', 1, '2024-12-01 04:58:53', '2024-12-01 04:58:53'),
(25, 2, NULL, '00001', 1, '2024-12-03 11:15:29', '2024-12-03 11:15:29'),
(27, 2, 2, '00001', 1, '2024-12-03 11:15:36', '2024-12-03 11:15:36');

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_08_28_170817_create_volunteers_table', 1),
(5, '2024_08_28_174453_create_organizations_table', 1),
(6, '2024_09_02_093608_add_verified_to_users_table', 1),
(7, '2024_09_06_131216_create_activity_categories_table', 1),
(8, '2024_09_06_143531_create_activities_table', 1),
(9, '2024_09_06_144947_create_activity_volunteers_table', 1),
(10, '2024_09_26_210817_add_completion_details_to_activities_table', 1),
(11, '2024_09_27_193349_add_profession_to_volunteer_table', 1),
(12, '2024_09_29_093437_create_idea_threads_table', 1),
(13, '2024_09_29_093438_create_idea_comments_table', 1),
(14, '2024_09_29_093438_create_idea_polls_table', 1),
(15, '2024_09_29_093438_create_poll_options_table', 1),
(16, '2024_09_29_093458_create_idea_votes_table', 1),
(17, '2024_10_03_221834_add_status_to_idea_threads_table', 1),
(18, '2024_10_07_184918_create_favorites_table', 1),
(19, '2024_10_08_193437_create_volunteer_follows_table', 1),
(20, '2024_10_22_121517_add_allow_follow_to_volunteers_table', 1),
(21, '2024_10_27_191728_create_activity_milestones_table', 1),
(22, '2024_10_31_104305_create_poll_votes_table', 1),
(23, '2024_11_04_101626_create_add_winner_column_to_ideathread_table', 1),
(24, '2024_11_10_184547_add_role_to_users_table', 1),
(25, '2024_11_13_185436_add_required_profession_to_activities_table', 1),
(26, '2024_11_15_173422_add_email_verified_at_to_users_table', 1),
(27, '2024_11_21_005530_create_add_lockout_fields_to_users_table', 1),
(28, '2024_11_21_012219_create_add_2fa_fields_to_users_table', 1),
(29, '2024_11_22_084012_add_show_posts_to_users_table', 1),
(30, '2024_11_22_091501_create_activity_requests_table', 1),
(31, '2024_11_22_093819_add_last_requests_read_to_organizations_table', 1),
(32, '2024_11_22_181015_add_activity_id_to_requests_table', 1),
(33, '2024_11_23_075817_create_tutorial_progress_table', 1),
(34, '2024_12_01_050249_add_visibility_to_activity_volunteers_table', 2),
(35, '2024_12_01_123447_add_map_location_to_activities_table', 3),
(36, '2024_12_06_112936_add_contact_email_to_organizations_table', 4);

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
  `contact_email` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `verification_status` enum('unverified','verified') NOT NULL DEFAULT 'unverified',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_requests_read_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`userid`, `url`, `org_name`, `primary_address`, `secondary_address`, `website`, `org_mobile`, `org_telephone`, `contact_email`, `description`, `verification_status`, `created_at`, `updated_at`, `last_requests_read_at`) VALUES
('org-001', 'org-001', 'Gift for Good', 'House 13, Rd 5, Anderkilla, Chittagong', 'House 13, Rd 5, Anderkilla, Chittagong', 'https://www.giftforgood.com', '12345678912', '1234124', 'contact@gfg.com', 'Lets do all we can for humanity', 'unverified', '2024-11-27 15:18:25', '2024-12-06 06:06:46', '2024-12-06 06:06:46');

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
(1, 1, 'Yes', 1, '2024-11-27 18:04:21', '2024-11-27 18:04:31'),
(2, 1, 'No', 0, '2024-11-27 18:04:21', '2024-11-27 18:04:21'),
(3, 1, 'Interested in any other similar work', 0, '2024-11-27 18:04:21', '2024-11-27 18:04:21');

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
(1, 1, 1, 'org-001', '2024-11-27 18:04:31', '2024-11-27 18:04:31');

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
(1, '00001', 'volunteer_dashboard', 1, 0, '2024-11-27 14:46:02', '2024-11-27 16:05:48'),
(2, '00001', 'volunteer_profile', 1, 0, '2024-11-27 14:46:02', '2024-11-27 18:47:56'),
(3, '00001', 'favorites', 1, 0, '2024-11-27 14:46:02', '2024-11-28 15:00:25'),
(4, '00001', 'home', 0, 0, '2024-11-27 14:46:02', '2024-11-27 14:46:02'),
(5, '00002', 'volunteer_dashboard', 0, 0, '2024-11-27 14:47:26', '2024-11-27 14:47:26'),
(6, '00002', 'volunteer_profile', 1, 0, '2024-11-27 14:47:26', '2024-11-27 14:58:08'),
(7, '00002', 'favorites', 0, 0, '2024-11-27 14:47:26', '2024-11-27 14:47:26'),
(8, '00002', 'home', 1, 0, '2024-11-27 14:47:26', '2024-11-27 15:02:30'),
(9, '00003', 'volunteer_dashboard', 1, 0, '2024-11-27 15:37:24', '2024-11-27 16:15:36'),
(10, '00003', 'volunteer_profile', 1, 0, '2024-11-27 15:37:24', '2024-11-27 15:44:31'),
(11, '00003', 'favorites', 0, 0, '2024-11-27 15:37:24', '2024-11-27 15:37:24'),
(12, '00003', 'home', 0, 0, '2024-11-27 15:37:24', '2024-11-27 15:37:24');

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
('00001', 'rht.krt@gmail.com', 'volunteer', '$2y$12$BOUFp.nyoWHWKcsqRsT/puPSl3RNvRK1ciFuT7wVPMVQI.PgPIzve', NULL, '2024-11-27 14:46:02', '2024-11-27 14:46:02', 1, '2024-11-27 21:40:47', 0, NULL, 5, 0, 1, NULL, NULL),
('00002', 'admin@kormonno.com', 'admin', '$2y$12$.XuunYNCSCJThSfCUhq4Cu7P1K7DDdLzaO8Y15YZjqBXrWS/a.AWq', NULL, '2024-11-27 14:47:26', '2024-11-27 14:47:26', 1, '2024-11-27 20:47:41', 0, NULL, 5, 0, 1, NULL, NULL),
('00003', 'rahat.karim95@gmail.com', 'volunteer', '$2y$12$oMlVbn8YF617Rba1IlS/hux5vU5h1GlM2RghNebdqajbd4bMln44m', NULL, '2024-11-27 15:37:24', '2024-11-27 15:37:24', 1, '2024-11-27 21:37:39', 0, NULL, 5, 0, 1, NULL, NULL),
('org-001', 'organization@gmail.com', 'organization', '$2y$12$Jvd7ymXJpb8V3h6xlExw9.Wo1o.FWbP0hsBounoI85rKEye4O5mg.', NULL, '2024-11-27 15:18:25', '2024-11-27 15:18:25', 1, '2024-11-27 21:18:33', 0, NULL, 5, 0, 1, NULL, NULL);

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
('00001', '00001', 'Rahatul Karim', '01990376524', NULL, 'M', '1995-06-17', 'A+', 'Flat 2A, Marquise Haus, Plot 1322, Road 20, Block i, Bashundhara R/A', 'Flat 2A, Marquise Haus, Plot 1322, Road 20, Block i, Bashundhara R/A', 'Dhaka', 0, 6, NULL, NULL, NULL, '2024-11-27 14:46:02', '2024-11-28 15:00:04', 1),
('00002', '00002', 'Rahatul Karim', '01990376514', NULL, 'M', '1997-03-11', 'Not Set', 'Flat 2A, Marquise Haus, Plot 1322, Road 20, Block i, Bashundhara R/A', 'Flat 2A, Marquise Haus, Plot 1322, Road 20, Block i, Bashundhara R/A', 'Dhaka', 0, 0, NULL, NULL, NULL, '2024-11-27 14:47:26', '2024-11-27 14:47:26', 1),
('00003', 'abbasali', 'Abbas Ali', '92883471839', NULL, 'M', '1987-10-14', 'A+', 'road 2, block A', 'road 2, block A', 'Dhaka', 0, 6, NULL, NULL, 'I like volunteering. Follow me to see my journey.', '2024-11-27 15:37:24', '2024-11-27 17:58:05', 1);

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
(2, '00001', 'org-001', 'organization', '2024-12-06 05:11:22', '2024-12-06 05:11:22');

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
  MODIFY `activityid` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `activity_categories`
--
ALTER TABLE `activity_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `activity_milestones`
--
ALTER TABLE `activity_milestones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `activity_requests`
--
ALTER TABLE `activity_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `activity_volunteers`
--
ALTER TABLE `activity_volunteers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `idea_comments`
--
ALTER TABLE `idea_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `idea_polls`
--
ALTER TABLE `idea_polls`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `idea_threads`
--
ALTER TABLE `idea_threads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `idea_votes`
--
ALTER TABLE `idea_votes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `milestone_reads`
--
ALTER TABLE `milestone_reads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `poll_options`
--
ALTER TABLE `poll_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `poll_votes`
--
ALTER TABLE `poll_votes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tutorial_progress`
--
ALTER TABLE `tutorial_progress`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `volunteer_follows`
--
ALTER TABLE `volunteer_follows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
