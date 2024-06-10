-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 10, 2024 at 12:23 PM
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
-- Table structure for table `wrelo_lietotaji`
--

CREATE TABLE `wrelo_lietotaji` (
  `lietotajs_id` int(4) NOT NULL,
  `lietotajvards` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `liet_vards` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `liet_uzvards` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `liet_epasts` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `parole` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `reg_sistema` datetime NOT NULL DEFAULT current_timestamp(),
  `statuss` enum('aktīvs','dzēsts','','') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `lietotaja_loma` enum('Adminisrators','Lietotājs','','') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `wrelo_lietotaji`
--

INSERT INTO `wrelo_lietotaji` (`lietotajs_id`, `lietotajvards`, `liet_vards`, `liet_uzvards`, `liet_epasts`, `parole`, `reg_sistema`, `statuss`, `lietotaja_loma`) VALUES
(1, 'ElvisBergs92m', 'Elvis', 'Bergs', '', '$2y$10$DeFPjMTjmsU5vm7H9qRHT.YBAecDSCWjlhlOWLyTcwc1RY.GihKKO', '2024-06-02 20:42:31', 'aktīvs', 'Lietotājs'),
(2, 'AKuztnetsov23z', 'Artur', 'Kuztnetsov', '', '$2y$10$tx.O4CggqAl4zogncgQeXOYPmkqzt0Inaspe7YHGbX3kP2b5lBe6a', '2024-06-02 20:42:31', 'aktīvs', 'Lietotājs'),
(3, 'DrulleKrista77v', 'Krista', 'Drulle', '', '$2y$10$sS68NMaHsJ7hpP1svCpgfeFEd/wVvPOHjoWZkpreLJuUXwHCDIBJO', '2024-06-02 20:42:31', 'aktīvs', 'Lietotājs'),
(4, 'CerpaIeva03d', 'Ieva', 'Cerpa', '', '$2y$10$23u9UPQncHE.piyXxmR2Pu7tphU7ucpwXMnjbwB0u6.N1ne/7FsEa', '2024-06-02 20:42:31', 'aktīvs', 'Lietotājs'),
(6, 'robertsadmin', 'Roberts', 'Alonderis', 'roberts1@gmail.com', '$2y$10$FaGJHuplMKoJfpyHPfG44eaiTsnL7rnV2Hw5ktz7ClcEeMPkc7O02', '2024-06-02 20:42:31', 'aktīvs', 'Adminisrators');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wrelo_lietotaji`
--
ALTER TABLE `wrelo_lietotaji`
  ADD PRIMARY KEY (`lietotajs_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wrelo_lietotaji`
--
ALTER TABLE `wrelo_lietotaji`
  MODIFY `lietotajs_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
