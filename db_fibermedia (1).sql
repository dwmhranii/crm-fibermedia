-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2026 at 03:58 AM
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
-- Database: `db_fibermedia`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(50) NOT NULL,
  `subject_type` varchar(100) DEFAULT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`properties`)),
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_desktop` varchar(255) NOT NULL,
  `image_mobile` varchar(255) DEFAULT NULL,
  `cta_text` varchar(50) DEFAULT NULL,
  `cta_url` varchar(255) DEFAULT NULL,
  `open_in_new_tab` tinyint(1) NOT NULL DEFAULT 0,
  `position` enum('home_hero','home_mid','home_bottom') NOT NULL DEFAULT 'home_hero',
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `start_at` timestamp NULL DEFAULT NULL,
  `end_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
('fibermediaplay-cache-admin@test.com|127.0.0.1', 'i:2;', 1772417577),
('fibermediaplay-cache-admin@test.com|127.0.0.1:timer', 'i:1772417577;', 1772417577),
('fibermediaplay-cache-site_settings.all', 'a:9:{s:9:\"site_name\";s:15:\"Fibermedia Play\";s:16:\"contact_whatsapp\";s:14:\"+62xxxxxxxxxxx\";s:13:\"contact_email\";s:15:\"info@domain.com\";s:15:\"contact_address\";N;s:17:\"seo_default_title\";N;s:23:\"seo_default_description\";N;s:13:\"instagram_url\";s:62:\"https://www.instagram.com/fibermediaplay?igsh=aHpua3VkY3Riem1m\";s:10:\"tiktok_url\";s:61:\"https://www.tiktok.com/@fibermediaplay?_r=1&_t=ZS-91vi4vu7IRQ\";s:4:\"logo\";s:53:\"settings/2jyuyxZRia19x3nKewmbhaypWueSwyDYSDcKEqY1.png\";}', 2087434044);

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
-- Table structure for table `coverages`
--

CREATE TABLE `coverages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `district` varchar(100) DEFAULT NULL,
  `city` varchar(100) NOT NULL DEFAULT 'Malang',
  `lat` decimal(10,7) DEFAULT NULL,
  `lng` decimal(10,7) DEFAULT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coverages`
--

INSERT INTO `coverages` (`id`, `name`, `district`, `city`, `lat`, `lng`, `sort_order`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Wandanpuro', NULL, 'Malang', NULL, NULL, 0, 1, '2026-01-01 09:18:57', '2026-01-01 09:18:57', NULL),
(2, 'Bululawang', NULL, 'Malang', NULL, NULL, 0, 1, '2026-01-01 09:18:57', '2026-01-01 09:18:57', NULL),
(3, 'Krebet', NULL, 'Malang', NULL, NULL, 0, 1, '2026-01-01 09:18:57', '2026-01-01 09:18:57', NULL),
(4, 'Senggrong', NULL, 'Malang', NULL, NULL, 0, 1, '2026-01-01 09:18:57', '2026-01-01 09:18:57', NULL),
(5, 'Lumbangsari', NULL, 'Malang', NULL, NULL, 0, 1, '2026-01-01 09:18:57', '2026-01-01 09:18:57', NULL),
(6, 'Gading', NULL, 'Malang', NULL, NULL, 0, 1, '2026-01-01 09:18:57', '2026-01-01 09:18:57', NULL),
(7, 'Karang Jambe', NULL, 'Malang', NULL, NULL, 0, 1, '2026-01-01 09:18:57', '2026-01-01 09:18:57', NULL),
(8, 'Sempalwadak', NULL, 'Malang', NULL, NULL, 0, 1, '2026-01-01 09:18:57', '2026-01-01 09:18:57', NULL),
(9, 'Tambakasri', NULL, 'Malang', NULL, NULL, 0, 1, '2026-01-01 09:18:57', '2026-01-01 09:18:57', NULL),
(10, 'Kendalpayak', NULL, 'Malang', NULL, NULL, 0, 1, '2026-01-01 09:18:57', '2026-01-01 09:18:57', NULL),
(11, 'Segenggeng', NULL, 'Malang', NULL, NULL, 0, 1, '2026-01-01 09:18:57', '2026-01-01 09:18:57', NULL),
(12, 'Arjowinangun', NULL, 'Malang', NULL, NULL, 0, 1, '2026-01-01 09:18:57', '2026-01-01 09:18:57', NULL),
(13, 'Tlogowaru', NULL, 'Malang', NULL, NULL, 0, 1, '2026-01-01 09:18:57', '2026-01-01 09:18:57', NULL),
(14, 'Wonokoyo', NULL, 'Malang', NULL, NULL, 0, 1, '2026-01-01 09:18:57', '2026-01-01 09:18:57', NULL),
(15, 'Gadang', NULL, 'Malang', NULL, NULL, 0, 1, '2026-01-01 09:18:57', '2026-01-01 09:18:57', NULL);

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
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `category`, `sort_order`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Apa itu PT Fibermedia Linktel Akses Indonesia?', 'PT Fibermedia Linktel Akses Indonesia adalah ISP berbasis fiber optik.', 'Umum', 1, 1, '2026-01-01 09:18:57', '2026-01-01 09:18:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gallery_albums`
--

CREATE TABLE `gallery_albums` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gallery_albums`
--

INSERT INTO `gallery_albums` (`id`, `title`, `slug`, `description`, `cover_image`, `sort_order`, `is_active`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Kantor', 'kantor', NULL, 'gallery/albums/R92iQRvqQRtqn3XK0MX8VLwVVOuhaaUrxXbEGodK.png', 0, 1, 1, 1, '2026-03-01 19:53:52', '2026-03-01 19:53:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gallery_items`
--

CREATE TABLE `gallery_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `album_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` enum('image','video') NOT NULL DEFAULT 'image',
  `title` varchar(191) DEFAULT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `thumb_path` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
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
-- Table structure for table `leads`
--

CREATE TABLE `leads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `email` varchar(191) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `coverage_id` bigint(20) UNSIGNED DEFAULT NULL,
  `package_id` bigint(20) UNSIGNED DEFAULT NULL,
  `message` text DEFAULT NULL,
  `source` varchar(50) DEFAULT NULL,
  `status` enum('new','contacted','closed','spam') NOT NULL DEFAULT 'new',
  `handled_by` bigint(20) UNSIGNED DEFAULT NULL,
  `handled_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `disk` varchar(50) NOT NULL DEFAULT 'public',
  `path` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `mime_type` varchar(100) DEFAULT NULL,
  `size` bigint(20) UNSIGNED DEFAULT NULL,
  `alt_text` varchar(191) DEFAULT NULL,
  `uploaded_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(4, '2025_12_31_075300_create_roles_table', 1),
(5, '2025_12_31_075349_create_coverages_table', 1),
(6, '2025_12_31_075350_create_faqs_table', 1),
(7, '2025_12_31_075350_create_packages_table', 1),
(8, '2025_12_31_075351_create_pages_table', 1),
(9, '2025_12_31_075351_create_why_cards_table', 1),
(10, '2025_12_31_075352_create_media_table', 1),
(11, '2025_12_31_075352_create_site_settings_table', 1),
(12, '2025_12_31_075353_create_activity_logs_table', 1),
(13, '2025_12_31_075353_create_leads_table', 1),
(14, '2025_12_31_075354_create_banners_table', 1),
(15, '2025_12_31_075354_create_gallery_albums_table', 1),
(16, '2025_12_31_075354_create_gallery_items_table', 1),
(17, '2025_12_31_080226_add_role_fields_to_users_table', 1),
(18, '2026_01_03_001034_add_sort_order_to_coverages_table', 2),
(19, '2026_01_06_030351_add_district_to_coverages_table', 3),
(20, '2026_01_07_035105_add_lat_lng_to_coverages_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `type` enum('home','business') NOT NULL DEFAULT 'home',
  `category` enum('internet_only','internet_tv','streaming','kuota_hp') DEFAULT NULL,
  `includes_tv` tinyint(1) NOT NULL DEFAULT 0,
  `includes_streaming_app` tinyint(1) NOT NULL DEFAULT 0,
  `includes_mobile_quota` tinyint(1) NOT NULL DEFAULT 0,
  `good_for_gaming` tinyint(1) NOT NULL DEFAULT 0,
  `good_for_streaming` tinyint(1) NOT NULL DEFAULT 0,
  `good_for_wfh` tinyint(1) NOT NULL DEFAULT 0,
  `min_users` tinyint(3) UNSIGNED DEFAULT NULL,
  `max_users` tinyint(3) UNSIGNED DEFAULT NULL,
  `best_for` varchar(191) DEFAULT NULL,
  `speed_mbps` int(10) UNSIGNED NOT NULL,
  `price_monthly` int(10) UNSIGNED NOT NULL,
  `device_ideal` varchar(100) DEFAULT NULL,
  `duration_months` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `features` text DEFAULT NULL,
  `whatsapp_order_url` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_best_seller` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `content` longtext NOT NULL,
  `meta_title` varchar(191) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `og_image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `description` varchar(191) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'superadmin', 'Full akses semua menu', 1, '2026-01-01 09:18:56', '2026-01-01 09:18:56'),
(2, 'Admin', 'admin', 'Kelola konten & leads', 1, '2026-01-01 09:18:56', '2026-01-01 09:18:56');

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
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(100) NOT NULL,
  `value` longtext DEFAULT NULL,
  `group` varchar(50) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `key`, `value`, `group`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'Fibermedia Play', 'general', 1, '2026-01-01 09:18:57', '2026-01-05 19:18:29'),
(2, 'contact_whatsapp', '+62xxxxxxxxxxx', 'contact', 1, '2026-01-01 09:18:57', '2026-01-01 09:18:57'),
(3, 'contact_email', 'info@domain.com', 'contact', 1, '2026-01-01 09:18:57', '2026-01-01 09:18:57'),
(4, 'contact_address', NULL, 'contact', 1, '2026-01-02 16:40:25', '2026-01-02 16:40:25'),
(5, 'seo_default_title', NULL, 'seo', 1, '2026-01-02 16:40:25', '2026-01-02 16:40:25'),
(6, 'seo_default_description', NULL, 'seo', 1, '2026-01-02 16:40:25', '2026-01-02 16:40:25'),
(7, 'instagram_url', 'https://www.instagram.com/fibermediaplay?igsh=aHpua3VkY3Riem1m', 'social', 1, '2026-01-02 16:40:25', '2026-01-04 06:38:25'),
(8, 'tiktok_url', 'https://www.tiktok.com/@fibermediaplay?_r=1&_t=ZS-91vi4vu7IRQ', 'social', 1, '2026-01-02 16:40:25', '2026-01-04 06:38:25'),
(9, 'logo', 'settings/2jyuyxZRia19x3nKewmbhaypWueSwyDYSDcKEqY1.png', 'general', 1, '2026-01-02 16:40:26', '2026-01-05 18:33:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `is_active`, `last_login_at`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Superadmin', 'superadmin@local.test', NULL, '$2y$12$xUWLIrefdNG.SJICin2ucuxgMAirZK4ZhI2CyXsR5VuC.pUL9TVKq', NULL, 1, NULL, '6OZEasVx9atpzkWDA2OFLFUesBMaPUxeh51LZMbPsHtxUKaK8vwR0e7qG5eG', '2026-01-01 09:18:57', '2026-01-01 09:18:57', NULL),
(2, 2, 'Admin Operasional', 'admin@fibermedia.com', NULL, '$2y$12$pKVMMdTyVIgAPuq9GG5La.h13gwMHhwh8525pPfFJ4.JkF1YVTTpi', NULL, 1, NULL, NULL, '2026-01-07 01:29:04', '2026-01-07 01:29:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `why_cards`
--

CREATE TABLE `why_cards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(150) NOT NULL,
  `subtitle` varchar(200) DEFAULT NULL,
  `description` text NOT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `bg_color` varchar(20) DEFAULT NULL,
  `text_color` varchar(20) DEFAULT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_subject_index` (`subject_type`,`subject_id`),
  ADD KEY `activity_logs_user_id_index` (`user_id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `banners_created_by_foreign` (`created_by`),
  ADD KEY `banners_updated_by_foreign` (`updated_by`),
  ADD KEY `banners_active_period_index` (`start_at`,`end_at`),
  ADD KEY `banners_position_index` (`position`),
  ADD KEY `banners_sort_order_index` (`sort_order`),
  ADD KEY `banners_is_active_index` (`is_active`);

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
-- Indexes for table `coverages`
--
ALTER TABLE `coverages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coverages_city_index` (`city`),
  ADD KEY `coverages_is_active_index` (`is_active`),
  ADD KEY `coverages_sort_order_index` (`sort_order`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faqs_category_index` (`category`),
  ADD KEY `faqs_sort_order_index` (`sort_order`),
  ADD KEY `faqs_is_active_index` (`is_active`);

--
-- Indexes for table `gallery_albums`
--
ALTER TABLE `gallery_albums`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gallery_albums_slug_unique` (`slug`),
  ADD KEY `gallery_albums_sort_order_index` (`sort_order`),
  ADD KEY `gallery_albums_is_active_index` (`is_active`),
  ADD KEY `gallery_albums_created_by_index` (`created_by`),
  ADD KEY `gallery_albums_updated_by_index` (`updated_by`);

--
-- Indexes for table `gallery_items`
--
ALTER TABLE `gallery_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gallery_items_album_id_index` (`album_id`),
  ADD KEY `gallery_items_type_index` (`type`),
  ADD KEY `gallery_items_sort_order_index` (`sort_order`),
  ADD KEY `gallery_items_is_active_index` (`is_active`),
  ADD KEY `gallery_items_created_by_index` (`created_by`),
  ADD KEY `gallery_items_updated_by_index` (`updated_by`);

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
-- Indexes for table `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leads_phone_index` (`phone`),
  ADD KEY `leads_coverage_id_index` (`coverage_id`),
  ADD KEY `leads_package_id_index` (`package_id`),
  ADD KEY `leads_status_index` (`status`),
  ADD KEY `leads_handled_by_index` (`handled_by`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `1` (`uploaded_by`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `packages_slug_unique` (`slug`),
  ADD KEY `packages_type_index` (`type`),
  ADD KEY `packages_category_index` (`category`),
  ADD KEY `packages_is_featured_index` (`is_featured`),
  ADD KEY `packages_is_best_seller_index` (`is_best_seller`),
  ADD KEY `packages_is_active_index` (`is_active`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pages_slug_unique` (`slug`),
  ADD KEY `pages_is_active_index` (`is_active`),
  ADD KEY `pages_created_by_index` (`created_by`),
  ADD KEY `pages_updated_by_index` (`updated_by`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `site_settings_key_unique` (`key`),
  ADD KEY `site_settings_group_index` (`group`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_index` (`role_id`);

--
-- Indexes for table `why_cards`
--
ALTER TABLE `why_cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `why_cards_sort_order_index` (`sort_order`),
  ADD KEY `why_cards_is_active_index` (`is_active`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coverages`
--
ALTER TABLE `coverages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gallery_albums`
--
ALTER TABLE `gallery_albums`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gallery_items`
--
ALTER TABLE `gallery_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `why_cards`
--
ALTER TABLE `why_cards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `banners`
--
ALTER TABLE `banners`
  ADD CONSTRAINT `banners_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `banners_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `gallery_albums`
--
ALTER TABLE `gallery_albums`
  ADD CONSTRAINT `gallery_albums_created_by_fk` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `gallery_albums_updated_by_fk` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `gallery_items`
--
ALTER TABLE `gallery_items`
  ADD CONSTRAINT `gallery_items_album_fk` FOREIGN KEY (`album_id`) REFERENCES `gallery_albums` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `gallery_items_created_by_fk` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `gallery_items_updated_by_fk` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `leads`
--
ALTER TABLE `leads`
  ADD CONSTRAINT `leads_coverage_fk` FOREIGN KEY (`coverage_id`) REFERENCES `coverages` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `leads_handled_by_fk` FOREIGN KEY (`handled_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `leads_package_fk` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `1` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `pages_created_by_fk` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pages_updated_by_fk` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
