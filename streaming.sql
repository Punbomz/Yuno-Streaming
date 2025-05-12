-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: May 12, 2025 at 03:39 PM
-- Server version: 9.2.0
-- PHP Version: 8.2.27

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
  `genre_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `History`
--

CREATE TABLE `History` (
  `user_id` int NOT NULL,
  `media_id` int NOT NULL,
  `watch_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `watch_length` double NOT NULL,
  `episode` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Media`
--

CREATE TABLE `Media` (
  `media_id` int NOT NULL,
  `media_title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `media_desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `media_release` date NOT NULL,
  `media_rate` int NOT NULL COMMENT '1 = Kids\r\n2 = Everyone\r\n3 = 13+\r\n4 = 15+\r\n5 = 18+',
  `type_id` int NOT NULL,
  `media_img` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `media_status` tinyint(1) NOT NULL COMMENT '0 = Stop\r\n1 = Showing'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Medias_Genre`
--

CREATE TABLE `Medias_Genre` (
  `genre_id` int NOT NULL,
  `media_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Media_Actor`
--

CREATE TABLE `Media_Actor` (
  `media_id` int NOT NULL,
  `actor_name` varchar(200) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `Media_Director`
--

CREATE TABLE `Media_Director` (
  `media_id` int NOT NULL,
  `director_name` varchar(200) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `Media_Files`
--

CREATE TABLE `Media_Files` (
  `file_id` int NOT NULL,
  `media_id` int NOT NULL,
  `file_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `episode` int NOT NULL,
  `media_duration` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Package`
--

CREATE TABLE `Package` (
  `package_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `price` double NOT NULL,
  `devices` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `screens` int NOT NULL,
  `resolution` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Payment`
--

CREATE TABLE `Payment` (
  `payment_id` int NOT NULL,
  `user_id` int NOT NULL,
  `payment_type` tinyint NOT NULL COMMENT '1 = Credit\r\n2 = Debit',
  `number` char(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `expired` char(5) COLLATE utf8mb4_general_ci NOT NULL,
  `cvv` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Payment_History`
--

CREATE TABLE `Payment_History` (
  `phistory_id` int NOT NULL,
  `user_id` int NOT NULL,
  `package_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `payment_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `payment_id` int NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Type`
--

CREATE TABLE `Type` (
  `type_id` int NOT NULL,
  `type_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `user_id` int NOT NULL,
  `user_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_birthdate` date DEFAULT NULL,
  `user_lv` tinyint NOT NULL COMMENT 'user = 0\r\nmain admin = 1\r\nmedia admin = 2',
  `register_date` date NOT NULL,
  `user_img` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`user_id`, `user_name`, `user_password`, `user_email`, `user_birthdate`, `user_lv`, `register_date`, `user_img`) VALUES
(3, 'Admin', '$2y$10$sM2/otboynXGJ0630AdCbeimWDXL5P21iN1uhXV5gScglw9XUOsye', 'Admin@gmail.com', '2004-09-24', 1, '2025-05-03', '-');

-- --------------------------------------------------------

--
-- Table structure for table `User_Package`
--

CREATE TABLE `User_Package` (
  `user_id` int NOT NULL,
  `package_name` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `package_start` date NOT NULL,
  `package_end` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

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
-- Indexes for table `Medias_Genre`
--
ALTER TABLE `Medias_Genre`
  ADD PRIMARY KEY (`genre_id`,`media_id`);

--
-- Indexes for table `Media_Actor`
--
ALTER TABLE `Media_Actor`
  ADD KEY `media_id` (`media_id`);

--
-- Indexes for table `Media_Director`
--
ALTER TABLE `Media_Director`
  ADD KEY `media_id` (`media_id`);

--
-- Indexes for table `Media_Files`
--
ALTER TABLE `Media_Files`
  ADD PRIMARY KEY (`file_id`);

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
  MODIFY `media_id` int NOT NULL AUTO_INCREMENT;

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
  MODIFY `phistory_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Type`
--
ALTER TABLE `Type`
  MODIFY `type_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Media_Actor`
--
ALTER TABLE `Media_Actor`
  ADD CONSTRAINT `Media_Actor_ibfk_1` FOREIGN KEY (`media_id`) REFERENCES `Media` (`media_id`);

--
-- Constraints for table `Media_Director`
--
ALTER TABLE `Media_Director`
  ADD CONSTRAINT `media_id` FOREIGN KEY (`media_id`) REFERENCES `Media` (`media_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
