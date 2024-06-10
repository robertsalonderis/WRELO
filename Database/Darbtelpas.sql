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
-- Table structure for table `Darbtelpas`
--

CREATE TABLE `Darbtelpas` (
  `darbtelpa_id` int(11) NOT NULL,
  `lietotajs_id` int(11) DEFAULT NULL,
  `nosaukums` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `Darbtelpas`
--

INSERT INTO `Darbtelpas` (`darbtelpa_id`, `lietotajs_id`, `nosaukums`) VALUES
(13, 6, 'Skola'),
(12, 6, 'Majaslapas'),
(11, 6, 'Majas'),
(10, 6, 'Darbs'),
(9, 6, 'Skola'),
(8, 6, 'Test'),
(14, 6, 'sds'),
(15, 6, 'sdsd');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Darbtelpas`
--
ALTER TABLE `Darbtelpas`
  ADD PRIMARY KEY (`darbtelpa_id`),
  ADD KEY `lietotajs_id` (`lietotajs_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Darbtelpas`
--
ALTER TABLE `Darbtelpas`
  MODIFY `darbtelpa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
