-- phpMyAdmin SQL Dump
-- version 4.7.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 31, 2017 at 10:55 AM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `raddb`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT '1',
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `collimatordata`
--

CREATE TABLE `collimatordata` (
  `id` int(10) UNSIGNED NOT NULL,
  `survey_id` int(10) UNSIGNED DEFAULT NULL,
  `machine_id` int(10) UNSIGNED DEFAULT NULL,
  `tube_id` int(10) UNSIGNED DEFAULT NULL,
  `receptor` enum('None','Table','Wall') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'None',
  `sid` float DEFAULT NULL,
  `indicated_trans` float DEFAULT NULL,
  `indicated_long` float DEFAULT NULL,
  `rad_trans` float DEFAULT NULL,
  `rad_long` float DEFAULT NULL,
  `pbl_trans` float DEFAULT NULL,
  `pbl_long` float DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(10) UNSIGNED NOT NULL,
  `person` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pager` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_rows`
--

CREATE TABLE `data_rows` (
  `id` int(10) UNSIGNED NOT NULL,
  `data_type_id` int(10) UNSIGNED NOT NULL,
  `field` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `browse` tinyint(1) NOT NULL DEFAULT '1',
  `read` tinyint(1) NOT NULL DEFAULT '1',
  `edit` tinyint(1) NOT NULL DEFAULT '1',
  `add` tinyint(1) NOT NULL DEFAULT '1',
  `delete` tinyint(1) NOT NULL DEFAULT '1',
  `details` text COLLATE utf8_unicode_ci,
  `order` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `data_types`
--

CREATE TABLE `data_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `display_name_singular` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `display_name_plural` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `controller` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `generate_permissions` tinyint(1) NOT NULL DEFAULT '0',
  `server_side` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `fluorodata`
--

CREATE TABLE `fluorodata` (
  `id` int(10) UNSIGNED NOT NULL,
  `survey_id` int(10) UNSIGNED DEFAULT NULL,
  `machine_id` int(10) UNSIGNED DEFAULT NULL,
  `tube_id` int(10) UNSIGNED DEFAULT NULL,
  `field_size` float DEFAULT NULL,
  `atten` float DEFAULT NULL,
  `dose1_mode` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dose1_kv` float DEFAULT NULL,
  `dose1_ma` float DEFAULT NULL,
  `dose1_rate` float DEFAULT NULL,
  `dose2_mode` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dose2_kv` float DEFAULT NULL,
  `dose2_ma` float DEFAULT NULL,
  `dose2_rate` float DEFAULT NULL,
  `dose3_mode` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dose3_kv` float DEFAULT NULL,
  `dose3_ma` float DEFAULT NULL,
  `dose3_rate` float DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gendata`
--

CREATE TABLE `gendata` (
  `id` int(10) UNSIGNED NOT NULL,
  `survey_id` int(10) UNSIGNED DEFAULT NULL,
  `tube_id` int(10) UNSIGNED DEFAULT NULL,
  `kv_set` tinyint(3) UNSIGNED DEFAULT NULL,
  `ma_set` double(8,2) DEFAULT NULL,
  `time_set` double(8,2) DEFAULT NULL,
  `mas_set` double(8,2) DEFAULT NULL,
  `add_filt` double(8,2) DEFAULT NULL,
  `distance` double(8,2) DEFAULT NULL,
  `kv_avg` double(8,2) DEFAULT NULL,
  `kv_max` double(8,2) DEFAULT NULL,
  `kv_eff` double(8,2) DEFAULT NULL,
  `exp_time` double(8,2) DEFAULT NULL,
  `exposure` double(8,2) DEFAULT NULL,
  `use_flags` tinyint(3) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hvldata`
--

CREATE TABLE `hvldata` (
  `id` int(10) UNSIGNED NOT NULL,
  `survey_id` int(10) UNSIGNED DEFAULT NULL,
  `machine_id` int(10) UNSIGNED DEFAULT NULL,
  `tube_id` int(10) UNSIGNED DEFAULT NULL,
  `kv` float DEFAULT NULL,
  `hvl` float DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `lastyear_view`
-- (See below for the actual view)
--
CREATE TABLE `lastyear_view` (
`machine_id` int(10) unsigned
,`survey_id` int(10) unsigned
,`test_date` date
,`report_file_path` text
,`recCount` bigint(21)
);

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(10) UNSIGNED NOT NULL,
  `location` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `machinephotos`
--

CREATE TABLE `machinephotos` (
  `id` int(10) UNSIGNED NOT NULL,
  `machine_id` int(10) UNSIGNED NOT NULL,
  `machine_photo_path` text COLLATE utf8_unicode_ci,
  `machine_photo_thumb` text COLLATE utf8_unicode_ci,
  `photo_description` text COLLATE utf8_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `machines`
--

CREATE TABLE `machines` (
  `id` int(10) UNSIGNED NOT NULL,
  `modality_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `description` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `manufacturer_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `vend_site_id` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `serial_number` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `manuf_date` date DEFAULT NULL,
  `install_date` date DEFAULT NULL,
  `remove_date` date DEFAULT NULL,
  `location_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `room` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `machine_status` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Active',
  `notes` text COLLATE utf8_unicode_ci,
  `software_version` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `manufacturers`
--

CREATE TABLE `manufacturers` (
  `id` int(10) UNSIGNED NOT NULL,
  `manufacturer` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maxfluorodata`
--

CREATE TABLE `maxfluorodata` (
  `id` int(10) UNSIGNED NOT NULL,
  `survey_id` int(10) UNSIGNED DEFAULT NULL,
  `machine_id` int(10) UNSIGNED DEFAULT NULL,
  `tube_id` int(10) UNSIGNED DEFAULT NULL,
  `dose1_kv` float DEFAULT NULL,
  `dose1_ma` float DEFAULT NULL,
  `dose1_rate` float DEFAULT NULL,
  `dose2_kv` float DEFAULT NULL,
  `dose2_ma` float DEFAULT NULL,
  `dose2_rate` float DEFAULT NULL,
  `dose3_kv` float DEFAULT NULL,
  `dose3_ma` float DEFAULT NULL,
  `dose3_rate` float DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `menu_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `target` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT '_self',
  `icon_class` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `color` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `order` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `route` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parameters` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `modalities`
--

CREATE TABLE `modalities` (
  `id` int(10) UNSIGNED NOT NULL,
  `modality` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `opnotes`
--

CREATE TABLE `opnotes` (
  `id` int(10) UNSIGNED NOT NULL,
  `machine_id` int(10) UNSIGNED NOT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `author_id` int(11) NOT NULL,
  `title` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8_unicode_ci,
  `body` text COLLATE utf8_unicode_ci,
  `image` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `meta_description` text COLLATE utf8_unicode_ci,
  `meta_keywords` text COLLATE utf8_unicode_ci,
  `status` enum('ACTIVE','INACTIVE') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'INACTIVE',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `table_name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `permission_group_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `permission_groups`
--

CREATE TABLE `permission_groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `author_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `seo_title` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `excerpt` text COLLATE utf8_unicode_ci NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `meta_description` text COLLATE utf8_unicode_ci NOT NULL,
  `meta_keywords` text COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('PUBLISHED','DRAFT','PENDING') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'DRAFT',
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `radoutputdata`
--

CREATE TABLE `radoutputdata` (
  `id` int(10) UNSIGNED NOT NULL,
  `survey_id` int(10) UNSIGNED DEFAULT NULL,
  `machine_id` int(10) UNSIGNED DEFAULT NULL,
  `tube_id` int(10) UNSIGNED DEFAULT NULL,
  `focus` enum('Large','Small') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Large',
  `kv` float DEFAULT NULL,
  `output` float DEFAULT NULL,
  `created_at` float DEFAULT NULL,
  `updated_at` float DEFAULT NULL,
  `deleted_at` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `radsurveydata`
--

CREATE TABLE `radsurveydata` (
  `id` int(10) UNSIGNED NOT NULL,
  `survey_id` int(10) UNSIGNED DEFAULT NULL,
  `machine_id` int(10) UNSIGNED DEFAULT NULL,
  `tube_id` int(10) UNSIGNED DEFAULT NULL,
  `sid_accuracy_error` float DEFAULT NULL,
  `avg_illumination` float DEFAULT NULL,
  `beam_alignment_error` float DEFAULT NULL,
  `rad_film_center_table` float DEFAULT NULL,
  `rad_film_center_wall` float DEFAULT NULL,
  `lfs_resolution` float DEFAULT NULL,
  `sfs_resolution` float DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `receptorentrance`
--

CREATE TABLE `receptorentrance` (
  `id` int(10) UNSIGNED NOT NULL,
  `survey_id` int(10) UNSIGNED DEFAULT NULL,
  `machine_id` int(10) UNSIGNED DEFAULT NULL,
  `tube_id` int(10) UNSIGNED DEFAULT NULL,
  `field_size` float DEFAULT NULL,
  `mode` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `kv` float DEFAULT NULL,
  `ma` float DEFAULT NULL,
  `rate` float DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recommendations`
--

CREATE TABLE `recommendations` (
  `id` int(10) UNSIGNED NOT NULL,
  `survey_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `recommendation` text COLLATE utf8_unicode_ci,
  `resolved` tinyint(4) NOT NULL DEFAULT '0',
  `rec_add_ts` datetime DEFAULT NULL,
  `rec_resolve_ts` datetime DEFAULT NULL,
  `rec_resolve_date` date DEFAULT NULL,
  `resolved_by` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rec_status` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'New',
  `wo_number` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `service_report_path` text COLLATE utf8_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `details` text COLLATE utf8_unicode_ci,
  `type` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `order` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `testdates`
--

CREATE TABLE `testdates` (
  `id` int(10) UNSIGNED NOT NULL,
  `machine_id` int(10) UNSIGNED DEFAULT NULL,
  `test_date` date DEFAULT NULL,
  `report_sent_date` date DEFAULT NULL,
  `tester1_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `tester2_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `type_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `notes` text COLLATE utf8_unicode_ci,
  `accession` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `report_file_path` text COLLATE utf8_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `testers`
--

CREATE TABLE `testers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `initials` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `testtypes`
--

CREATE TABLE `testtypes` (
  `id` int(10) UNSIGNED NOT NULL,
  `test_type` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `thisyear_view`
-- (See below for the actual view)
--
CREATE TABLE `thisyear_view` (
`machine_id` int(10) unsigned
,`survey_id` int(10) unsigned
,`test_date` date
,`report_file_path` text
,`recCount` bigint(21)
);

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE `translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `table_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `column_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `foreign_key` int(10) UNSIGNED NOT NULL,
  `locale` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `tubes`
--

CREATE TABLE `tubes` (
  `id` int(10) UNSIGNED NOT NULL,
  `machine_id` int(10) UNSIGNED NOT NULL,
  `housing_model` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `housing_sn` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `housing_manuf_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `insert_model` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `insert_sn` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `insert_manuf_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `manuf_date` date DEFAULT NULL,
  `install_date` date DEFAULT NULL,
  `remove_date` date DEFAULT NULL,
  `lfs` double(8,2) NOT NULL DEFAULT '0.00',
  `mfs` double(8,2) NOT NULL DEFAULT '0.00',
  `sfs` double(8,2) NOT NULL DEFAULT '0.00',
  `notes` text COLLATE utf8_unicode_ci,
  `tube_status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `is_admin` int(11) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `avatar` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure for view `lastyear_view`
--
DROP TABLE IF EXISTS `lastyear_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`eugenem`@`localhost` SQL SECURITY DEFINER VIEW `lastyear_view`  AS  select `testdates`.`machine_id` AS `machine_id`,`testdates`.`id` AS `survey_id`,`testdates`.`test_date` AS `test_date`,`testdates`.`report_file_path` AS `report_file_path`,count(`recommendations`.`recommendation`) AS `recCount` from (`testdates` left join `recommendations` on((`testdates`.`id` = `recommendations`.`survey_id`))) where ((`testdates`.`test_date` between makedate((year(curdate()) - 1),1) and makedate(year(curdate()),1)) and ((`testdates`.`type_id` = 1) or (`testdates`.`type_id` = 2))) group by `testdates`.`id` order by `testdates`.`test_date` ;

-- --------------------------------------------------------

--
-- Structure for view `thisyear_view`
--
DROP TABLE IF EXISTS `thisyear_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`eugenem`@`localhost` SQL SECURITY DEFINER VIEW `thisyear_view`  AS  select `testdates`.`machine_id` AS `machine_id`,`testdates`.`id` AS `survey_id`,`testdates`.`test_date` AS `test_date`,`testdates`.`report_file_path` AS `report_file_path`,count(`recommendations`.`recommendation`) AS `recCount` from (`testdates` left join `recommendations` on((`testdates`.`id` = `recommendations`.`survey_id`))) where ((`testdates`.`test_date` between makedate(year(curdate()),1) and makedate((year(curdate()) + 1),1)) and ((`testdates`.`type_id` = 1) or (`testdates`.`type_id` = 2))) group by `testdates`.`id` order by `testdates`.`test_date` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `collimatordata`
--
ALTER TABLE `collimatordata`
  ADD PRIMARY KEY (`id`),
  ADD KEY `survey_id` (`survey_id`),
  ADD KEY `machine_id` (`machine_id`),
  ADD KEY `tube_id` (`tube_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contacts_location_id_foreign` (`location_id`);

--
-- Indexes for table `data_rows`
--
ALTER TABLE `data_rows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `data_rows_data_type_id_foreign` (`data_type_id`);

--
-- Indexes for table `data_types`
--
ALTER TABLE `data_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `data_types_name_unique` (`name`),
  ADD UNIQUE KEY `data_types_slug_unique` (`slug`);

--
-- Indexes for table `fluorodata`
--
ALTER TABLE `fluorodata`
  ADD PRIMARY KEY (`id`),
  ADD KEY `survey_id` (`survey_id`),
  ADD KEY `machine_id` (`machine_id`),
  ADD KEY `tube_id` (`tube_id`);

--
-- Indexes for table `gendata`
--
ALTER TABLE `gendata`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gendata_survey_id_foreign` (`survey_id`),
  ADD KEY `gendata_tube_id_foreign` (`tube_id`);

--
-- Indexes for table `hvldata`
--
ALTER TABLE `hvldata`
  ADD PRIMARY KEY (`id`),
  ADD KEY `survey_id` (`survey_id`),
  ADD KEY `machine_id` (`machine_id`),
  ADD KEY `tube_id` (`tube_id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `machinephotos`
--
ALTER TABLE `machinephotos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `machine_id` (`machine_id`);

--
-- Indexes for table `machines`
--
ALTER TABLE `machines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `machines_location_id_foreign` (`location_id`),
  ADD KEY `machines_modality_id_foreign` (`modality_id`) USING BTREE,
  ADD KEY `machines_manufacturer_id_foreign` (`manufacturer_id`) USING BTREE;

--
-- Indexes for table `manufacturers`
--
ALTER TABLE `manufacturers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maxfluorodata`
--
ALTER TABLE `maxfluorodata`
  ADD PRIMARY KEY (`id`),
  ADD KEY `survey_id` (`survey_id`),
  ADD KEY `machine_id` (`machine_id`),
  ADD KEY `tube_id` (`tube_id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menus_name_unique` (`name`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_items_menu_id_foreign` (`menu_id`);

--
-- Indexes for table `modalities`
--
ALTER TABLE `modalities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `opnotes`
--
ALTER TABLE `opnotes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `opnotes_machine_id_foreign` (`machine_id`) USING BTREE;

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pages_slug_unique` (`slug`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permissions_key_index` (`key`);

--
-- Indexes for table `permission_groups`
--
ALTER TABLE `permission_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permission_groups_name_unique` (`name`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_permission_id_index` (`permission_id`),
  ADD KEY `permission_role_role_id_index` (`role_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `posts_slug_unique` (`slug`);

--
-- Indexes for table `radoutputdata`
--
ALTER TABLE `radoutputdata`
  ADD PRIMARY KEY (`id`),
  ADD KEY `survey_id` (`survey_id`),
  ADD KEY `machine_id` (`machine_id`),
  ADD KEY `tube_id` (`tube_id`);

--
-- Indexes for table `radsurveydata`
--
ALTER TABLE `radsurveydata`
  ADD PRIMARY KEY (`id`),
  ADD KEY `survey_id` (`survey_id`),
  ADD KEY `machine_id` (`machine_id`),
  ADD KEY `tube_id` (`tube_id`);

--
-- Indexes for table `receptorentrance`
--
ALTER TABLE `receptorentrance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `survey_id` (`survey_id`),
  ADD KEY `machine_id` (`machine_id`),
  ADD KEY `tube_id` (`tube_id`);

--
-- Indexes for table `recommendations`
--
ALTER TABLE `recommendations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recommendations_survey_id_foreign` (`survey_id`),
  ADD KEY `resolved` (`resolved`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `testdates`
--
ALTER TABLE `testdates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `testdates_machine_id_foreign` (`machine_id`),
  ADD KEY `testdates_tester1_id_foreign` (`tester1_id`),
  ADD KEY `testdates_tester2_id_foreign` (`tester2_id`),
  ADD KEY `testdates_type_id_foreign` (`type_id`);

--
-- Indexes for table `testers`
--
ALTER TABLE `testers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testtypes`
--
ALTER TABLE `testtypes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `translations_table_name_column_name_foreign_key_locale_unique` (`table_name`,`column_name`,`foreign_key`,`locale`);

--
-- Indexes for table `tubes`
--
ALTER TABLE `tubes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tubes_machine_id_foreign` (`machine_id`),
  ADD KEY `tubes_housing_manuf_id_foreign` (`housing_manuf_id`),
  ADD KEY `tubes_insert_manuf_id_foreign` (`insert_manuf_id`);

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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `collimatordata`
--
ALTER TABLE `collimatordata`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;
--
-- AUTO_INCREMENT for table `data_rows`
--
ALTER TABLE `data_rows`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=258;
--
-- AUTO_INCREMENT for table `data_types`
--
ALTER TABLE `data_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `fluorodata`
--
ALTER TABLE `fluorodata`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gendata`
--
ALTER TABLE `gendata`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11624;
--
-- AUTO_INCREMENT for table `hvldata`
--
ALTER TABLE `hvldata`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
--
-- AUTO_INCREMENT for table `machinephotos`
--
ALTER TABLE `machinephotos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `machines`
--
ALTER TABLE `machines`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=342;
--
-- AUTO_INCREMENT for table `manufacturers`
--
ALTER TABLE `manufacturers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT for table `maxfluorodata`
--
ALTER TABLE `maxfluorodata`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `modalities`
--
ALTER TABLE `modalities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `opnotes`
--
ALTER TABLE `opnotes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;
--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;
--
-- AUTO_INCREMENT for table `permission_groups`
--
ALTER TABLE `permission_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `radoutputdata`
--
ALTER TABLE `radoutputdata`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `radsurveydata`
--
ALTER TABLE `radsurveydata`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `receptorentrance`
--
ALTER TABLE `receptorentrance`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `recommendations`
--
ALTER TABLE `recommendations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3320;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `testdates`
--
ALTER TABLE `testdates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2124;
--
-- AUTO_INCREMENT for table `testers`
--
ALTER TABLE `testers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `testtypes`
--
ALTER TABLE `testtypes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `translations`
--
ALTER TABLE `translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tubes`
--
ALTER TABLE `tubes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=338;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`);

--
-- Constraints for table `gendata`
--
ALTER TABLE `gendata`
  ADD CONSTRAINT `gendata_survey_id_foreign` FOREIGN KEY (`survey_id`) REFERENCES `testdates` (`id`),
  ADD CONSTRAINT `gendata_tube_id_foreign` FOREIGN KEY (`tube_id`) REFERENCES `tubes` (`id`);

--
-- Constraints for table `machines`
--
ALTER TABLE `machines`
  ADD CONSTRAINT `machines_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`),
  ADD CONSTRAINT `machines_manufacturer_id_foreign` FOREIGN KEY (`manufacturer_id`) REFERENCES `manufacturers` (`id`),
  ADD CONSTRAINT `machines_modality_id_foreign` FOREIGN KEY (`modality_id`) REFERENCES `modalities` (`id`);

--
-- Constraints for table `opnotes`
--
ALTER TABLE `opnotes`
  ADD CONSTRAINT `opnotes_machine_id_foreign` FOREIGN KEY (`machine_id`) REFERENCES `machines` (`id`);

--
-- Constraints for table `recommendations`
--
ALTER TABLE `recommendations`
  ADD CONSTRAINT `recommendations_survey_id_foreign` FOREIGN KEY (`survey_id`) REFERENCES `testdates` (`id`);

--
-- Constraints for table `testdates`
--
ALTER TABLE `testdates`
  ADD CONSTRAINT `testdates_machine_id_foreign` FOREIGN KEY (`machine_id`) REFERENCES `machines` (`id`),
  ADD CONSTRAINT `testdates_tester1_id_foreign` FOREIGN KEY (`tester1_id`) REFERENCES `testers` (`id`),
  ADD CONSTRAINT `testdates_tester2_id_foreign` FOREIGN KEY (`tester2_id`) REFERENCES `testers` (`id`),
  ADD CONSTRAINT `testdates_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `testtypes` (`id`);

--
-- Constraints for table `tubes`
--
ALTER TABLE `tubes`
  ADD CONSTRAINT `tubes_housing_manuf_id_foreign` FOREIGN KEY (`housing_manuf_id`) REFERENCES `manufacturers` (`id`),
  ADD CONSTRAINT `tubes_insert_manuf_id_foreign` FOREIGN KEY (`insert_manuf_id`) REFERENCES `manufacturers` (`id`),
  ADD CONSTRAINT `tubes_machine_id_foreign` FOREIGN KEY (`machine_id`) REFERENCES `machines` (`id`);
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
