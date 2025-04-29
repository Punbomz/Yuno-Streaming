-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 29, 2025 at 02:04 PM
-- Server version: 8.0.41-0ubuntu0.24.04.1
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `streaming`
--

-- --------------------------------------------------------

--
-- Table structure for table `Genre`
--

CREATE TABLE `Genre` (
  `genre_id` int NOT NULL,
  `genre_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `History`
--

CREATE TABLE `History` (
  `user_id` int NOT NULL,
  `media_id` int NOT NULL,
  `watch_date` date NOT NULL,
  `watch_length` double NOT NULL,
  `watch_status` tinyint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Media`
--

CREATE TABLE `Media` (
  `media_id` int NOT NULL,
  `media_title` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `media_desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `media_duration` double NOT NULL,
  `media_release` date NOT NULL,
  `media_rate` int NOT NULL,
  `type_id` int NOT NULL,
  `media_img` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `actors` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `directors` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Media`
--

INSERT INTO `Media` (`media_id`, `media_title`, `media_desc`, `media_duration`, `media_release`, `media_rate`, `type_id`, `media_img`, `actors`, `directors`) VALUES
(1, 'Spiderman', 'Coming', 15.3, '2025-03-04', 15, 1, '', '', ''),
(2, 'Ben 10', 'Omnitrix', 22, '2025-03-02', 10, 1, '', '', ''),
(3, 'ธี่หยด', '', 120, '2025-03-02', 15, 2, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `Media_Files`
--

CREATE TABLE `Media_Files` (
  `file_id` int NOT NULL,
  `media_id` int NOT NULL,
  `file_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `episode` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Movies_Genre`
--

CREATE TABLE `Movies_Genre` (
  `genre_id` int NOT NULL,
  `media_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Package`
--

CREATE TABLE `Package` (
  `package_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `price` int NOT NULL,
  `devices_available` int NOT NULL,
  `screens` int NOT NULL,
  `resolution` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Package`
--

INSERT INTO `Package` (`package_name`, `price`, `devices_available`, `screens`, `resolution`) VALUES
('Basic', 99, 1, 1, 'HD'),
('Premium', 499, 4, 4, '4K'),
('Standard', 199, 2, 2, 'Full HD');

-- --------------------------------------------------------

--
-- Table structure for table `Payment`
--

CREATE TABLE `Payment` (
  `payment_id` int NOT NULL,
  `user_id` int NOT NULL,
  `payment_type` tinyint NOT NULL,
  `card_number` char(16) COLLATE utf8mb4_general_ci NOT NULL,
  `payment_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Payment_History`
--

CREATE TABLE `Payment_History` (
  `phistory_id` int NOT NULL,
  `user_id` int NOT NULL,
  `package_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `payment_datetime` datetime NOT NULL,
  `payment_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Type`
--

CREATE TABLE `Type` (
  `type_id` int NOT NULL,
  `type_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Type`
--

INSERT INTO `Type` (`type_id`, `type_name`) VALUES
(1, 'Series'),
(2, 'Movie'),
(3, 'TV Shows');

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `user_id` int NOT NULL,
  `user_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `user_password` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `user_email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `user_birthdate` date NOT NULL,
  `package_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `user_lv` tinyint NOT NULL,
  `register_date` date NOT NULL,
  `package_start` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Watchlist`
--

CREATE TABLE `Watchlist` (
  `user_id` int NOT NULL,
  `media_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Genre`
--
ALTER TABLE `Genre`
  ADD PRIMARY KEY (`genre_id`);

--
-- Indexes for table `History`
--
ALTER TABLE `History`
  ADD PRIMARY KEY (`user_id`,`media_id`);

--
-- Indexes for table `Media`
--
ALTER TABLE `Media`
  ADD PRIMARY KEY (`media_id`);

--
-- Indexes for table `Media_Files`
--
ALTER TABLE `Media_Files`
  ADD PRIMARY KEY (`file_id`);

--
-- Indexes for table `Movies_Genre`
--
ALTER TABLE `Movies_Genre`
  ADD PRIMARY KEY (`genre_id`,`media_id`);

--
-- Indexes for table `Package`
--
ALTER TABLE `Package`
  ADD PRIMARY KEY (`package_name`);

--
-- Indexes for table `Payment`
--
ALTER TABLE `Payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `Payment_History`
--
ALTER TABLE `Payment_History`
  ADD PRIMARY KEY (`phistory_id`);

--
-- Indexes for table `Type`
--
ALTER TABLE `Type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `Watchlist`
--
ALTER TABLE `Watchlist`
  ADD PRIMARY KEY (`user_id`,`media_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Genre`
--
ALTER TABLE `Genre`
  MODIFY `genre_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Media`
--
ALTER TABLE `Media`
  MODIFY `media_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Media_Files`
--
ALTER TABLE `Media_Files`
  MODIFY `file_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Payment`
--
ALTER TABLE `Payment`
  MODIFY `payment_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Payment_History`
--
ALTER TABLE `Payment_History`
  MODIFY `phistory_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `Type`
--
ALTER TABLE `Type`
  MODIFY `type_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
