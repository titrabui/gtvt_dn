-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2017 at 11:22 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gtvt_dn`
--

-- --------------------------------------------------------

--
-- Table structure for table `measuring_points`
--

CREATE TABLE `measuring_points` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `x_coordinate` double DEFAULT NULL,
  `y_coordinate` double DEFAULT NULL,
  `road_height` double DEFAULT NULL,
  `account` varchar(512) DEFAULT NULL,
  `battery` int(11) DEFAULT NULL,
  `is_request` tinyint(1) NOT NULL DEFAULT '0',
  `note` varchar(1000) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `measuring_points`
--

INSERT INTO `measuring_points` (`id`, `project_id`, `name`, `location`, `x_coordinate`, `y_coordinate`, `road_height`, `account`, `battery`, `is_request`, `note`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'code 1', NULL, NULL, NULL, NULL, 'hdshdsh shdbshdbs hbdshdbsh hdbshdb', 100, 0, NULL, 1489824309, 1489832365, NULL),
(2, 1, 'code 2', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 1489824309, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `measuring_values`
--

CREATE TABLE `measuring_values` (
  `id` int(11) NOT NULL,
  `measuring_point_id` int(11) NOT NULL,
  `total_time_surveying` int(11) DEFAULT NULL,
  `weather` varchar(255) DEFAULT NULL,
  `value1` double DEFAULT NULL,
  `value2` double DEFAULT NULL,
  `value3` double DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `measuring_values`
--

INSERT INTO `measuring_values` (`id`, `measuring_point_id`, `total_time_surveying`, `weather`, `value1`, `value2`, `value3`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, NULL, NULL, 3434, 3434, 34343, 1489824309, NULL, NULL),
(2, 1, NULL, NULL, 3434, 3434, 34343, 1489825831, NULL, NULL),
(3, 2, NULL, NULL, 3434, 3434, 34343, 1489825885, NULL, NULL),
(4, 1, NULL, NULL, 3434, 3434, 34343, 1489826152, NULL, NULL),
(5, 1, NULL, NULL, 13.23, 1, 1.1, 1489831250, NULL, NULL),
(6, 1, NULL, NULL, 13.23, 1, 1.1, 1489831268, NULL, NULL),
(7, 1, NULL, NULL, 13.23, 1, 1.1, 1489831279, NULL, NULL),
(8, 1, NULL, NULL, 13.23, 1, 1.1, 1489831395, NULL, NULL),
(9, 1, NULL, NULL, 13.23, 1, 1.1, 1489831499, NULL, NULL),
(10, 1, NULL, NULL, 13.23, 1, 1.1, 1489831507, NULL, NULL),
(11, 1, NULL, NULL, 13.23, 1, 1.1, 1489831575, NULL, NULL),
(12, 1, NULL, NULL, 13.23, 1, 1.1, 1489831680, NULL, NULL),
(13, 1, NULL, NULL, 13.23, 1, 1.1, 1489831719, NULL, NULL),
(14, 1, NULL, NULL, 13.23, 1, 1.1, 1489831790, NULL, NULL),
(15, 1, NULL, NULL, 13.23, 1, 1.1, 1489832018, NULL, NULL),
(16, 1, NULL, NULL, 13.23, 1, 1.1, 1489832058, NULL, NULL),
(17, 1, NULL, NULL, 13.23, 1, 1.1, 1489832342, NULL, NULL),
(18, 1, NULL, NULL, 13.23, 1, 1.1, 1489832365, NULL, NULL),
(19, 1, NULL, NULL, 13.23, 1, 1.1, 1489832476, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `investor` varchar(255) DEFAULT NULL,
  `note` varchar(1000) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `location`, `investor`, `note`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Project 1', NULL, NULL, NULL, 1489824309, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `group` int(11) NOT NULL DEFAULT '1',
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `last_login` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `login_hash` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `profile_fields` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) UNSIGNED NOT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `group`, `email`, `last_login`, `login_hash`, `profile_fields`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin', 'JlrhzICFNoBXTH7U3K2PYg1poWRUJfH1q9AOsoi3P3s=', 100, 'titrabui@gmail.com', '1489651431', 'b0077e5c32421212ae7ae89239f58a1db470bde7', 'a:0:{}', 1489378749, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `measuring_points`
--
ALTER TABLE `measuring_points`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `measuring_values`
--
ALTER TABLE `measuring_values`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`,`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `measuring_points`
--
ALTER TABLE `measuring_points`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `measuring_values`
--
ALTER TABLE `measuring_values`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
