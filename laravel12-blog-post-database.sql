-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 11, 2025 at 06:58 AM
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
-- Database: `blog-post`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_menus`
--

CREATE TABLE `admin_menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `sorting` int(11) NOT NULL DEFAULT 0,
  `sql_query` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_menus`
--

INSERT INTO `admin_menus` (`id`, `name`, `type`, `path`, `icon`, `parent_id`, `is_active`, `sorting`, `sql_query`, `created_at`, `updated_at`) VALUES
(9, 'Manage Banner', 'Route', 'getManageBanner', 'fa fa-th-list', 0, 1, 2, NULL, '2025-02-12 07:19:44', NULL),
(10, 'Manage Blog', 'Route', 'getManageBlog', 'fa fa-th-list', 0, 1, 1, NULL, '2025-02-12 07:57:58', '2025-06-07 14:45:27');

-- --------------------------------------------------------

--
-- Table structure for table `admin_privileges`
--

CREATE TABLE `admin_privileges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `is_superadmin` tinyint(4) NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `user_ip` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_privileges`
--

INSERT INTO `admin_privileges` (`id`, `name`, `is_superadmin`, `created_by`, `updated_by`, `user_ip`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 1, 1, 2, '127.0.0.1', '2024-10-28 02:36:55', '2025-02-22 03:39:38');

-- --------------------------------------------------------

--
-- Table structure for table `admin_privileges_roles`
--

CREATE TABLE `admin_privileges_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_admin_privileges` bigint(20) UNSIGNED NOT NULL,
  `id_admin_menus` int(11) DEFAULT NULL,
  `is_visible` tinyint(4) DEFAULT NULL,
  `is_create` tinyint(4) DEFAULT NULL,
  `is_read` tinyint(4) DEFAULT NULL,
  `is_edit` tinyint(4) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `user_ip` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_privileges_roles`
--

INSERT INTO `admin_privileges_roles` (`id`, `id_admin_privileges`, `id_admin_menus`, `is_visible`, `is_create`, `is_read`, `is_edit`, `is_delete`, `created_by`, `updated_by`, `user_ip`, `created_at`, `updated_at`) VALUES
(45, 1, 10, 1, 1, 1, 1, 1, 2, NULL, NULL, '2025-02-22 03:39:38', NULL),
(46, 1, 9, 1, 1, 1, 1, 1, 2, NULL, NULL, '2025-02-22 03:39:38', NULL),
(47, 1, 5, 1, 1, 1, 1, 1, 2, NULL, NULL, '2025-02-22 03:39:38', NULL),
(48, 1, 6, 1, 1, 1, 1, 1, 2, NULL, NULL, '2025-02-22 03:39:38', NULL),
(49, 1, 11, 1, 1, 1, 1, 1, 2, NULL, NULL, '2025-02-22 03:39:38', NULL),
(50, 1, 12, 1, 1, 1, 1, 1, 2, NULL, NULL, '2025-02-22 03:39:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admin_settings`
--

CREATE TABLE `admin_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `appname` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `footer_logo` varchar(255) DEFAULT NULL,
  `site_email` varchar(255) DEFAULT NULL,
  `site_address` varchar(255) DEFAULT NULL,
  `site_phone_number` varchar(255) DEFAULT NULL,
  `site_about` text DEFAULT NULL,
  `facebook_link` varchar(255) DEFAULT NULL,
  `instagram_link` varchar(255) DEFAULT NULL,
  `twitter_link` varchar(255) DEFAULT NULL,
  `linkedin_link` varchar(255) DEFAULT NULL,
  `youtube_link` varchar(255) DEFAULT NULL,
  `maintenance_mode` tinyint(4) NOT NULL DEFAULT 0,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `user_ip` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_settings`
--

INSERT INTO `admin_settings` (`id`, `appname`, `logo`, `favicon`, `footer_logo`, `site_email`, `site_address`, `site_phone_number`, `site_about`, `facebook_link`, `instagram_link`, `twitter_link`, `linkedin_link`, `youtube_link`, `maintenance_mode`, `created_by`, `updated_by`, `user_ip`, `created_at`, `updated_at`) VALUES
(1, 'Admin Panel', NULL, NULL, NULL, 'site_email@email.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, 2, NULL, '2024-10-28 02:36:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_admin_privileges` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `user_ip` varchar(45) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `name`, `photo`, `email`, `password`, `id_admin_privileges`, `created_by`, `updated_by`, `user_ip`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Administrator', '', 'superadmin@gmail.com', '$2y$10$f3vwAkgDf2R9rgpkLAlYo.B9IcD1bM/L4T4z/csLoAcUDm.eZUL6e', 1, 1, 1, NULL, 1, '2024-10-28 02:36:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `order` int(11) DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT 'Status: 1=Active, 0=Inactive',
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_comments`
--

CREATE TABLE `blog_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `blog_page_id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_comments`
--

INSERT INTO `blog_comments` (`id`, `user_id`, `blog_page_id`, `full_name`, `email`, `comment`, `created_at`, `updated_at`) VALUES
(1, 1, 6, 'Tapan Das', 'tpnds123@gmail.com', 'Test Comment1', '2025-06-08 14:09:39', NULL),
(2, 9, 6, 'Utpal Das', 'utpal@gmail.com', '', '2025-06-08 14:56:30', NULL),
(3, NULL, 6, NULL, NULL, 'checking now', '2025-06-08 09:49:22', '2025-06-08 09:49:22');

-- --------------------------------------------------------

--
-- Table structure for table `blog_logs`
--

CREATE TABLE `blog_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ipaddress` varchar(45) NOT NULL,
  `useragent` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `id_cms_users` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_logs`
--

INSERT INTO `blog_logs` (`id`, `ipaddress`, `useragent`, `url`, `description`, `details`, `id_cms_users`, `created_at`, `updated_at`) VALUES
(22, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/logout', 'superadmin@gmail.com logout', '', 2, '2025-06-08 10:45:08', NULL),
(23, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/logout', 'superadmin@gmail.com logout', '', 2, '2025-06-08 10:46:12', NULL),
(24, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/logout', 'superadmin@gmail.com logout', '', 2, '2025-06-08 10:55:39', NULL),
(25, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'http://127.0.0.1:8000/logout', 'superadmin@gmail.com logout', '', 2, '2025-06-10 16:18:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `blog_pages`
--

CREATE TABLE `blog_pages` (
  `id` int(11) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `page_slug` varchar(255) NOT NULL,
  `page_content` longtext DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `banner_image` varchar(250) DEFAULT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_keywords` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `banner_heading` varchar(255) DEFAULT NULL,
  `banner_heading_sub` varchar(255) DEFAULT NULL,
  `banner_content` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `user_ip` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_pages`
--

INSERT INTO `blog_pages` (`id`, `page_title`, `page_slug`, `page_content`, `featured_image`, `banner_image`, `meta_title`, `meta_keywords`, `meta_description`, `status`, `banner_heading`, `banner_heading_sub`, `banner_content`, `created_by`, `updated_by`, `user_ip`, `created_at`, `updated_at`) VALUES
(4, 'Dolorum optio tempore voluptas dignissimos', 'Modern Web Development', '<p>The landscape of web development continues to evolve at an unprecedented pace, bringing new technologies, frameworks, and methodologies that reshape how we build modern web applications.</p>\r\n\r\n<p>As we delve into 2025, the web development ecosystem has transformed dramatically, introducing innovative approaches to building faster, more secure, and highly engaging web experiences. This comprehensive guide explores the latest trends and best practices that are defining the future of web development.</p>', 'admin/uploads/images/blogpage/featured-image-1749377683.webp', NULL, 'Modern Web Development', NULL, NULL, 1, NULL, NULL, NULL, 2, NULL, '127.0.0.1', '2025-06-08 04:44:43', NULL),
(5, 'Nisi magni odit consequatur autem nulla dolorem', 'Best Practices and Future Trends', '<p>The landscape of web development continues to evolve at an unprecedented pace, bringing new technologies, frameworks, and methodologies that reshape how we build modern web applications.</p>\r\n\r\n<p>As we delve into 2025, the web development ecosystem has transformed dramatically, introducing innovative approaches to building faster, more secure, and highly engaging web experiences. This comprehensive guide explores the latest trends and best practices that are defining the future of web development.</p>', 'admin/uploads/images/blogpage/featured-image-1749377993.webp', NULL, 'Best Practices and Future Trends', NULL, NULL, 1, NULL, NULL, NULL, 2, NULL, '127.0.0.1', '2025-06-08 04:49:53', NULL),
(6, 'Possimus soluta ut id suscipit ea ut in quo quia e', 'The landscape of web development', '<p>As we delve into 2025, the web development ecosystem has transformed dramatically, introducing innovative approaches to building faster, more secure, and highly engaging web experiences. This comprehensive guide explores the latest trends and best practices that are defining the future of web development.</p>', 'admin/uploads/images/blogpage/featured-image-1749378105.webp', NULL, 'The landscape of web development', NULL, NULL, 1, NULL, NULL, NULL, 2, NULL, '127.0.0.1', '2025-06-08 04:51:45', NULL);

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
('laravel_cache_setting_appname', 's:11:\"Admin Panel\";', 2064977422),
('laravel_cache_setting_logo', 'N;', 2064977422);

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_06_08_135246_create_blog_comments_table', 2);

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

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('FxdTDigU3lz15ZjjN3BmtRJ52gkbmSv32wpH2xpw', NULL, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YToxMDp7czo2OiJfdG9rZW4iO3M6NDA6InlvNjNOTEVwMUhBRDlIZ1MzWGtwSVl3b1pUaE0wSnpBTDV3aXFGU04iO3M6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM3OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4vZGFzaGJvYXJkIjt9czo4OiJhZG1pbl9pZCI7aToyO3M6MTA6ImFkbWluX25hbWUiO3M6MTM6IkFkbWluaXN0cmF0b3IiO3M6MTE6ImFkbWluX3Bob3RvIjtzOjQ1OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4vaW1hZ2VzL2F2YXRhci5qcGciO3M6MTY6ImFkbWluX3ByaXZpbGVnZXMiO2k6MTtzOjIxOiJhZG1pbl9wcml2aWxlZ2VzX25hbWUiO3M6MTE6IlN1cGVyIEFkbWluIjtzOjEwOiJhZG1pbl9sb2NrIjtpOjA7czo3OiJhcHBuYW1lIjtzOjU6IkFkbWluIjt9', 1749617422);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Tapan Das', 'tpnds123@gmail.com', NULL, '$2y$12$UwBNJsiN9j1EfxwF1RKWwOxa74dKtlzN7qQOrWvjhg4ADcvGTgDIi', NULL, '2025-06-07 02:05:59', '2025-06-07 02:05:59'),
(2, 'Tapan2 Das', 'tapan2@gmail.com', NULL, '$2y$12$wrOUkCrpJW3.b9BeN.LoceuOocJg7Eex2DWCd307tx/VWLWnAUnMm', NULL, '2025-06-10 15:26:07', '2025-06-10 15:26:07'),
(3, 'Test User', 'testuser@mailinator.com', NULL, '$2y$12$u64ASRhFJ62vxOCpSHrJweJBbGykemqkJ/xzuWN/RJU442d1wKL5.', NULL, '2025-06-10 22:23:52', '2025-06-10 22:23:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_menus`
--
ALTER TABLE `admin_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_privileges`
--
ALTER TABLE `admin_privileges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_privileges_roles`
--
ALTER TABLE `admin_privileges_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_settings`
--
ALTER TABLE `admin_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_users_email_unique` (`email`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_comments`
--
ALTER TABLE `blog_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_logs`
--
ALTER TABLE `blog_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_pages`
--
ALTER TABLE `blog_pages`
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_menus`
--
ALTER TABLE `admin_menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `admin_privileges`
--
ALTER TABLE `admin_privileges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `admin_privileges_roles`
--
ALTER TABLE `admin_privileges_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `admin_settings`
--
ALTER TABLE `admin_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `blog_comments`
--
ALTER TABLE `blog_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `blog_logs`
--
ALTER TABLE `blog_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `blog_pages`
--
ALTER TABLE `blog_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
