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
-- Table structure for table `Deli`
--

CREATE TABLE `Deli` (
  `deli_id` int(11) NOT NULL,
  `darbtelpa_id` int(11) DEFAULT NULL,
  `nosaukums` varchar(255) DEFAULT NULL,
  `bg_krasa` varchar(7) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `Deli`
--

INSERT INTO `Deli` (`deli_id`, `darbtelpa_id`, `nosaukums`, `bg_krasa`) VALUES
(16, 14, 'sds', '#ffeaa7'),
(15, 13, 'sds', '#55efc4'),
(14, 12, 'exam', '#55efc4'),
(13, 12, 'exam', '#74b9ff'),
(12, 10, 'sdsd', '#ffeaa7'),
(11, 10, 'dsd', '#74b9ff'),
(10, 9, 'sd', '#ffeaa7'),
(9, 8, 'Test1', '#74b9ff'),
(17, 15, 'sds', '#fab1a0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Deli`
--
ALTER TABLE `Deli`
  ADD PRIMARY KEY (`deli_id`),
  ADD KEY `darbtelpa_id` (`darbtelpa_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Deli`
--
ALTER TABLE `Deli`
  MODIFY `deli_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
