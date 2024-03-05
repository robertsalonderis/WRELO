-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2024 at 12:31 AM
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
-- Database: `wrelo_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `darbinieki`
--

CREATE TABLE `darbinieki` (
  `id` int(4) NOT NULL,
  `lietotajvards` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `vards` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `uzvards` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `epasts` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `parole` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `darbinieki`
--

INSERT INTO `darbinieki` (`id`, `lietotajvards`, `vards`, `uzvards`, `epasts`, `parole`) VALUES
(1, 'ElvisBergs92m', 'Elvis', 'Bergs', '', '$2y$10$DeFPjMTjmsU5vm7H9qRHT.YBAecDSCWjlhlOWLyTcwc1RY.GihKKO'),
(2, 'AKuztnetsov23z', 'Artur', 'Kuztnetsov', '', '$2y$10$tx.O4CggqAl4zogncgQeXOYPmkqzt0Inaspe7YHGbX3kP2b5lBe6a'),
(3, 'DrulleKrista77v', 'Krista', 'Drulle', '', '$2y$10$sS68NMaHsJ7hpP1svCpgfeFEd/wVvPOHjoWZkpreLJuUXwHCDIBJO'),
(4, 'CerpaIeva03d', 'Ieva', 'Cerpa', '', '$2y$10$23u9UPQncHE.piyXxmR2Pu7tphU7ucpwXMnjbwB0u6.N1ne/7FsEa'),
(6, 'robertsadmin', 'Roberts', 'Alonderis', 'roberts1@gmail.com', '$2y$10$FaGJHuplMKoJfpyHPfG44eaiTsnL7rnV2Hw5ktz7ClcEeMPkc7O02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `darbinieki`
--
ALTER TABLE `darbinieki`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `darbinieki`
--
ALTER TABLE `darbinieki`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
