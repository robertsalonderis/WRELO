-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 10, 2024 at 11:38 AM
-- Server version: 10.6.17-MariaDB-cll-lve
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `grobina1_alonderis`
--

-- --------------------------------------------------------

--
-- Table structure for table `Kartis`
--

CREATE TABLE `Kartis` (
  `kartis_id` int(11) NOT NULL,
  `deli_id` int(11) DEFAULT NULL,
  `apraksts` text DEFAULT NULL,
  `krasu_etikete` varchar(7) DEFAULT NULL,
  `file_attachment` varchar(255) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `checklist` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `Kartis`
--

INSERT INTO `Kartis` (`kartis_id`, `deli_id`, `apraksts`, `krasu_etikete`, `file_attachment`, `comments`, `checklist`) VALUES
(11, 13, 'Sveiki', '', NULL, NULL, NULL),
(10, 12, 'sdsd', '', NULL, NULL, NULL),
(9, 9, 'Testesana', '', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Kartis`
--
ALTER TABLE `Kartis`
  ADD PRIMARY KEY (`kartis_id`),
  ADD KEY `deli_id` (`deli_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Kartis`
--
ALTER TABLE `Kartis`
  MODIFY `kartis_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
