-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2020 at 10:00 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reservervation_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `orderId` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `phoneNumber` varchar(10) DEFAULT NULL,
  `email` text NOT NULL,
  `licensePlate` varchar(8) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `carChoice` int(11) DEFAULT NULL,
  `meeting` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`orderId`, `name`, `phoneNumber`, `email`, `licensePlate`, `description`, `carChoice`, `meeting`) VALUES
(1, 'Example van Example', NULL, 'example@example.com', 'de-fa2-c', NULL, NULL, 'APK'),
(2, 'Example de Example', NULL, 'example@example.nl', 'ab-cde-f', 'Winterbanden', NULL, 'Onderhoud'),
(3, 'Example Example', '0612345678', 'example@example.com', NULL, NULL, 2, 'Auto lenen'),
(4, 'Voorbeeld van Voorbeeld', '0623231345', 'voorbeeld@email.com', 'h2-ef-24', NULL, NULL, 'APK'),
(5, 'Niet de Voorbeeld', NULL, 'ikbeneenvoorbeeld@voorbeeld.nl', '2s-24h-b', NULL, NULL, 'APK'),
(6, 'John Doe', '0658752035', 'doe@voorbeeld.com', 'a-2e4-ed', 'Servicebeurt', NULL, 'Onderhoud'),
(7, 'Voorbeeld van de Doe', NULL, 'vandedoe@example.nl', NULL, NULL, 1, 'Auto lenen'),
(8, 'Voorbeeld \'d Example', '0657234515', 'example.1990@voorbeeld.nl', 'hf-2d-ek', NULL, NULL, 'APK'),
(9, 'Voorbeeld Example', NULL, 'example.voorbeeld@moreexample.com', 'je-23d-f', 'Winterbanden', NULL, 'Onderhoud'),
(10, 'Example Voorbeeld-Example', '0678215369', 'voorbeeldexample@voorbeeld.com', 'hd-23e-f', 'Aircoservice', NULL, 'Onderhoud');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`orderId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `orderId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
