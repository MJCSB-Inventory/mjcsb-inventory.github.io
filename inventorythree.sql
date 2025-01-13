-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2025 at 02:31 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventorythree`
--

-- --------------------------------------------------------

--
-- Table structure for table `assigned`
--

CREATE TABLE `assigned` (
  `AID` int(11) NOT NULL,
  `UID` int(11) DEFAULT NULL,
  `PID` int(11) DEFAULT NULL,
  `Type` enum('Electrical','Mechanical','Other') NOT NULL,
  `Director1` varchar(200) DEFAULT NULL,
  `Director2` varchar(200) DEFAULT NULL,
  `Engineer1` varchar(200) DEFAULT NULL,
  `Engineer2` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assigned`
--

INSERT INTO `assigned` (`AID`, `UID`, `PID`, `Type`, `Director1`, `Director2`, `Engineer1`, `Engineer2`) VALUES
(4, 1, 13, 'Electrical', 'HILMI', '', '', ''),
(8, 1, 16, 'Mechanical', 'AMIN', '', '', ''),
(9, 1, 17, 'Other', 'NURULHAYATI', '', 'AINA', ''),
(11, 1, 18, 'Mechanical', '', '', '', ''),
(14, 1, 22, 'Other', 'NURULHAYATI', '', 'AINA', ''),
(15, 1, 23, 'Electrical', 'MMA', '', 'DANIAL', ''),
(16, 1, 23, 'Mechanical', 'AMIN', '', 'MUAZ', ''),
(17, 1, 23, 'Other', 'NURULHAYATI', '', 'AINAFILZA', ''),
(18, 1, 25, 'Mechanical', 'AMIN', '', 'SYED', ''),
(19, 1, 26, 'Electrical', 'MMA', '', 'DANIAL', ''),
(20, 1, 26, 'Mechanical', 'AMIN', '', 'SYED', ''),
(21, 1, 27, 'Electrical', '', '', '', ''),
(22, 3, 28, 'Electrical', 'MMA', '', '', ''),
(23, 3, 28, 'Mechanical', 'AMIN', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `PID` int(11) NOT NULL,
  `Year` int(4) DEFAULT NULL,
  `Name` varchar(200) DEFAULT NULL,
  `FileNo` int(4) DEFAULT NULL,
  `FileName` varchar(200) DEFAULT NULL,
  `Category` varchar(100) DEFAULT NULL,
  `Status` enum('Complete','Ongoing','KIV') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`PID`, `Year`, `Name`, `FileNo`, `FileName`, `Category`, `Status`) VALUES
(13, 2024, 'KELANA JAYA LINE LPS', 540, 'MJC PMB GEM 2024', 'Railway', 'KIV'),
(16, 2024, 'SISTEM PERPARITAN MAJLIS PERBANDARAN SEPANG', 441, 'MJC PASSB GEM 2020', 'Properties', 'Ongoing'),
(17, 2023, 'WANG KELIAN VIEW POINT', 531, 'MJC ARSB GEM 2023', 'Residental', 'KIV'),
(18, 2022, 'PRSB BANGI ', 526, 'MJC AJSR GEM 2023', 'School', 'Ongoing'),
(20, 2024, 'BEKALAN ELEKTRIK TMN SAUJANA UTAMA', 545, 'MJC DE GE 2024', 'Residental', 'Ongoing'),
(21, 2022, 'PROJEK MENGKUANG', 495, 'MJC KAA GEM 2022  ', 'School', 'Ongoing'),
(22, 2022, 'TNB MERLIMAU', 479, 'MJC GVESB GEM 2021', 'Hospital', 'KIV'),
(23, 2022, 'KONTENA NASIONAL', 506, 'MJC KNB GEM 2022', 'Hospital', 'Complete'),
(24, 2023, 'DEWAN MASJID PUNCAK ALAM', 527, 'MJC ABNZ GEM 2023', 'Other', 'Complete'),
(25, 2024, 'HIGHWAY AKLEH', 256, 'MJC EC GEM 2012 ', 'Road & Highway', 'Ongoing'),
(26, 2024, 'AIRPORT TERENGGANU', 134, 'MJC JKR GE ', 'Airport & Seaport', 'KIV'),
(27, 2024, 'HOSPITAL KLUANG', 522, 'MJC QSE GEM 2023', 'Hospital', 'Ongoing'),
(28, 2024, 'PERUMAHAN RINCHING', 546, 'MJC JDSB GEM 2024', 'Housing', 'Complete'),
(29, 2024, 'KLINIK KESIHATAN SETAPAK', 533, 'MJC DSE GEM 2023', 'Clinic', 'KIV');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UID` int(11) NOT NULL,
  `Name` varchar(200) DEFAULT NULL,
  `Username` varchar(100) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL,
  `Role` enum('ADMIN','USER') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UID`, `Name`, `Username`, `Password`, `Role`) VALUES
(1, 'NUR RIDHWAH BINTI RASFAN', 'INT001', '$2y$10$SgO9i5SxqfKYgGFG03Cgq.vFWDSO2ICS4S4jp7/NJdSc5qfnMHcwO', 'ADMIN'),
(2, 'AINA FILZA', 'ICT002', '$2y$10$OJ9ODxza842jeuzoDnc6BeVjlu2Y0d5xKOT4cTgOrJdR1Ys0CqLb.', 'USER'),
(3, 'ADMIN 2', 'INT002', '$2y$10$79qijTbTYHLTp9erHBr4Y.SIDkl32WmVQM.pDEsuvSIJzPIKXEnP6', 'ADMIN'),
(4, 'INT 2', 'INT002', '$2y$10$kcOw9/DuMQVP3vdGensk7OC7FqJB5Mnr/V63B.SZ4qDxUoa/fwYfu', 'USER');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assigned`
--
ALTER TABLE `assigned`
  ADD PRIMARY KEY (`AID`),
  ADD KEY `UID` (`UID`),
  ADD KEY `fk_project` (`PID`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`PID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assigned`
--
ALTER TABLE `assigned`
  MODIFY `AID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `PID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assigned`
--
ALTER TABLE `assigned`
  ADD CONSTRAINT `PID` FOREIGN KEY (`PID`) REFERENCES `project` (`PID`) ON DELETE CASCADE,
  ADD CONSTRAINT `assigned_ibfk_1` FOREIGN KEY (`UID`) REFERENCES `users` (`UID`),
  ADD CONSTRAINT `assigned_ibfk_2` FOREIGN KEY (`PID`) REFERENCES `project` (`PID`),
  ADD CONSTRAINT `fk_project` FOREIGN KEY (`PID`) REFERENCES `project` (`PID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
