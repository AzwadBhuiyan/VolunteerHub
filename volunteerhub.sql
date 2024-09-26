-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2024 at 12:18 AM
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

INSERT INTO `activities` (`activityid`, `userid`, `title`, `description`, `date`, `time`, `category`, `district`, `address`, `deadline`, `min_volunteers`, `max_volunteers`, `status`, `created_at`, `updated_at`, `accomplished_description`, `duration`, `difficulty`, `points`) VALUES
(1, 'org-001', 'Party on', 'lets go', '2024-10-04', '12:45:00', 'education', 'eastern', 'asdad', '2024-09-17 00:42:00', 1, 2, 'closed', '2024-09-20 12:42:20', '2024-09-20 12:47:14', NULL, NULL, NULL, 0),
(2, 'org-001', 'Lets go', 'lets go', '2024-09-27', '06:21:00', 'environmental', 'central', '1aaf', '2024-10-02 03:22:00', 1, 5, 'completed', '2024-09-25 15:22:15', '2024-09-26 15:24:28', NULL, NULL, NULL, 0),
(3, 'org-001', 'wall paint need artists', 'lets paint all the walls', '2024-09-30', '16:27:00', 'education', 'central', 'bashundhara', '2024-09-29 00:09:00', 3, 10, 'completed', '2024-09-26 15:52:59', '2024-09-26 16:11:06', 'all walls look beautiful', 6, 'easy', 0);

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
(2, 1, '00002', 'pending', NULL, NULL),
(3, 3, '00002', 'approved', '2024-09-26 15:53:14', '2024-09-26 15:58:02'),
(4, 3, '00004', 'approved', '2024-09-26 15:54:10', '2024-09-26 15:58:02');

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
(31, '2024_09_26_210817_add_completion_details_to_activities_table', 5);

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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`userid`, `url`, `org_name`, `primary_address`, `secondary_address`, `website`, `org_mobile`, `org_telephone`, `description`, `verification_status`, `created_at`, `updated_at`) VALUES
('org-001', 'rahatinc', 'rahat inc', 'dh', 'dh', 'https://www.facebook.com/rht.krmO.o/', '123', '132', 'we believe in money', 'unverified', '2024-09-20 07:52:52', '2024-09-20 13:41:44'),
('org-002', 'org-002', 'org', 'org', 'org', 'https://org@c.com', '91239', '123123', NULL, 'unverified', '2024-09-20 10:18:14', '2024-09-20 10:18:14');

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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `verified`) VALUES
('00002', 'volunteer@gmail.com', '$2y$12$UoCj2BpNB1JrgIt52cSfzOMdn08Wk/HJj6ro8Gv6jB7vtw5GSEWLC', NULL, '2024-09-20 07:54:58', '2024-09-20 07:54:58', 1),
('00003', 'rht.krt@gmail.com', '$2y$12$V7A2GOSUdQgSk.EwzPdE.elMi29NAzgkxYZdVpfdhepWW86LsmCSa', NULL, '2024-09-20 10:19:02', '2024-09-20 10:19:02', 0),
('00004', 'as2@gmail.com', '$2y$12$jVXp.L4xCT/eGMS1mvziT.RyvbmZ57Rqx9L9gCBP/lOyXs8B34ucO', NULL, '2024-09-26 15:50:49', '2024-09-26 15:50:49', 1),
('org-001', 'organization@gmail.com', '$2y$12$eohVVZ72P3qUd9MFC/eKFOmQIHraB1FLZsIS3bLKuc5Gdk31p3I8a', NULL, '2024-09-20 07:52:52', '2024-09-20 07:52:52', 1),
('org-002', 'org2@gmail.com', '$2y$12$R1fNsPbwj5ZicKAPcZPnDe6XoqPKjfmkOl6mYNFBxGMoQW4Mif9gO', NULL, '2024-09-20 10:18:14', '2024-09-20 10:18:14', 1);

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
  `Badges` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`Badges`)),
  `bio` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `volunteers`
--

INSERT INTO `volunteers` (`userid`, `url`, `Name`, `Phone`, `NID`, `Gender`, `DOB`, `BloodGroup`, `PresentAddress`, `PermanentAddress`, `District`, `TrainedInEmergencyResponse`, `Points`, `Badges`, `bio`, `created_at`, `updated_at`) VALUES
('00002', 'rhtProMax', 'Rahatul Karim', '01990376524', NULL, 'M', '2024-09-25', 'A+', '4th floor, House 439, Rupayan Suraiya, Road 18, Block A, Bashundhara', '4th floor, House 439, Rupayan Suraiya, Road 18, Block A, Bashundhara', 'Dhaka', 0, 6, NULL, NULL, '2024-09-20 07:54:58', '2024-09-26 16:11:06'),
('00003', '00003', 'Rahatul Karim', '01990376524', NULL, 'M', '2024-09-11', 'A+', '4th floor, House 439, Rupayan Suraiya, Road 18, Block A, Bashundhara', '4th floor, House 439, Rupayan Suraiya, Road 18, Block A, Bashundhara', 'Dhaka', 0, 0, NULL, NULL, '2024-09-20 10:19:02', '2024-09-20 10:19:02'),
('00004', '00004', 'asdf', '01990376524', NULL, 'M', '1992-06-09', 'A+', '4th floor, House 439, Rupayan Suraiya, Road 18, Block A, Bashundhara', '4th floor, House 439, Rupayan Suraiya, Road 18, Block A, Bashundhara', 'Dhaka', 0, 6, NULL, NULL, '2024-09-26 15:50:49', '2024-09-26 16:11:07');

-- --------------------------------------------------------

--
-- Table structure for table `volunteer_favorite_categories`
--

CREATE TABLE `volunteer_favorite_categories` (
  `userid` varchar(255) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
-- Indexes for table `volunteer_favorite_categories`
--
ALTER TABLE `volunteer_favorite_categories`
  ADD PRIMARY KEY (`userid`,`category_id`),
  ADD KEY `volunteer_favorite_categories_category_id_foreign` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `activityid` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `activity_categories`
--
ALTER TABLE `activity_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `activity_volunteers`
--
ALTER TABLE `activity_volunteers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_userid_foreign` FOREIGN KEY (`userid`) REFERENCES `organizations` (`userid`) ON DELETE CASCADE;

--
-- Constraints for table `activity_volunteers`
--
ALTER TABLE `activity_volunteers`
  ADD CONSTRAINT `activity_volunteers_activityid_foreign` FOREIGN KEY (`activityid`) REFERENCES `activities` (`activityid`) ON DELETE CASCADE,
  ADD CONSTRAINT `activity_volunteers_volunteer_userid_foreign` FOREIGN KEY (`volunteer_userid`) REFERENCES `volunteers` (`userid`) ON DELETE CASCADE;

--
-- Constraints for table `organizations`
--
ALTER TABLE `organizations`
  ADD CONSTRAINT `organizations_userid_foreign` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`) ON DELETE CASCADE;

--
-- Constraints for table `volunteers`
--
ALTER TABLE `volunteers`
  ADD CONSTRAINT `volunteers_userid_foreign` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`) ON DELETE CASCADE;

--
-- Constraints for table `volunteer_favorite_categories`
--
ALTER TABLE `volunteer_favorite_categories`
  ADD CONSTRAINT `volunteer_favorite_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `activity_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `volunteer_favorite_categories_userid_foreign` FOREIGN KEY (`userid`) REFERENCES `volunteers` (`userid`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
