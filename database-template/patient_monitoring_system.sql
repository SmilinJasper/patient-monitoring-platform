-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2022 at 09:46 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `patient_monitoring_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_credentials`
--

CREATE TABLE `admin_credentials` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_credentials`
--

INSERT INTO `admin_credentials` (`id`, `username`, `password`) VALUES
(1, 'admin', 'selvin');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_credentials`
--

CREATE TABLE `doctor_credentials` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `doctor_credentials`
--

INSERT INTO `doctor_credentials` (`id`, `username`, `password`) VALUES
(1, 'doctor', '$2y$10$2M98hInHoF8KcREyTD1v8u4NR5/vCR.XnlcafREQ9nAYWEhOscspy');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_profiles`
--

CREATE TABLE `doctor_profiles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `credentials` varchar(255) NOT NULL,
  `experience` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `doctor_profiles`
--

INSERT INTO `doctor_profiles` (`id`, `name`, `credentials`, `experience`) VALUES
(1, 'Selvin', 'MBBS, MD, DM', '10 Years, 6 Months');

-- --------------------------------------------------------

--
-- Table structure for table `patient_credentials`
--

CREATE TABLE `patient_credentials` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `patient_credentials`
--

INSERT INTO `patient_credentials` (`id`, `username`, `password`) VALUES
(1, 'patient', '$2y$10$x8JJnL.HAvLdF2BrESGMbO6ZNwxxNfeEoD2NrNa7mvBP1ZHbSZ9Zu');

-- --------------------------------------------------------

--
-- Table structure for table `patient_medicines`
--

CREATE TABLE `patient_medicines` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `medicine` varchar(255) NOT NULL,
  `morning` varchar(255) NOT NULL,
  `afternoon` varchar(255) NOT NULL,
  `evening` varchar(255) NOT NULL,
  `night` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `patient_medicines`
--

INSERT INTO `patient_medicines` (`id`, `patient_id`, `doctor_id`, `medicine`, `morning`, `afternoon`, `evening`, `night`) VALUES
(1, 1, 1, 'Dolo 650', 'Prescribed', 'Prescribed', '', 'Prescribed');

-- --------------------------------------------------------

--
-- Table structure for table `patient_profiles`
--

CREATE TABLE `patient_profiles` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `age` varchar(255) NOT NULL,
  `blood_group` varchar(255) NOT NULL,
  `height` int(255) NOT NULL,
  `weight` int(255) NOT NULL,
  `bmi` int(255) NOT NULL,
  `contact_number` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `patient_profiles`
--

INSERT INTO `patient_profiles` (`id`, `doctor_id`, `name`, `date_of_birth`, `age`, `blood_group`, `height`, `weight`, `bmi`, `contact_number`) VALUES
(1, 1, 'Sel', '2001-04-03', '20', 'B+', 173, 63, 21, '9344012834');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_credentials`
--
ALTER TABLE `admin_credentials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor_credentials`
--
ALTER TABLE `doctor_credentials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor_profiles`
--
ALTER TABLE `doctor_profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient_credentials`
--
ALTER TABLE `patient_credentials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient_medicines`
--
ALTER TABLE `patient_medicines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medicine_patient_id` (`patient_id`),
  ADD KEY `medicine_doctor_id` (`doctor_id`);

--
-- Indexes for table `patient_profiles`
--
ALTER TABLE `patient_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_doctor_id` (`doctor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_credentials`
--
ALTER TABLE `admin_credentials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `doctor_credentials`
--
ALTER TABLE `doctor_credentials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `patient_credentials`
--
ALTER TABLE `patient_credentials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `patient_medicines`
--
ALTER TABLE `patient_medicines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `doctor_profiles`
--
ALTER TABLE `doctor_profiles`
  ADD CONSTRAINT `doctor_profile_id` FOREIGN KEY (`id`) REFERENCES `doctor_credentials` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `patient_medicines`
--
ALTER TABLE `patient_medicines`
  ADD CONSTRAINT `medicine_doctor_id` FOREIGN KEY (`doctor_id`) REFERENCES `doctor_credentials` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `medicine_patient_id` FOREIGN KEY (`patient_id`) REFERENCES `patient_credentials` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `patient_profiles`
--
ALTER TABLE `patient_profiles`
  ADD CONSTRAINT `patient_doctor_id` FOREIGN KEY (`doctor_id`) REFERENCES `doctor_credentials` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `patient_profile_id` FOREIGN KEY (`id`) REFERENCES `patient_credentials` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
