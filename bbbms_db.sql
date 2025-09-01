-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 01, 2025 at 11:06 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bbbms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `submitted_at`) VALUES
(1, 'Abu Raihan', 'traihant443@gmail.com', '????', '?????', '2025-08-05 23:35:37');

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `ID` int(11) NOT NULL,
  `AdminName` varchar(100) NOT NULL,
  `UserName` varchar(50) NOT NULL,
  `MobileNumber` varchar(20) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`ID`, `AdminName`, `UserName`, `MobileNumber`, `Email`, `Password`) VALUES
(1, 'Super Admin', 'admin', '01700000000', 'admin@baust.edu.bd', '0192023a7bbd73250516f069df18b500'),
(2, 'Blood Manager', 'admin1', '01786777868', 'traihant443@gmail.com', '$2y$10$6GL.INKy6DNe0.vZzmpbV.cVQ9PSMKY57FCSSJbmmsMb0qi1LjEfq'),
(3, 'Blood Manager2', 'admin2', '01386777868', 'mansib@gmail.com', '$2y$10$4yvZ3V2ekg52a7fhFNno9ey7qMEgQvIzPrXt2sZswhKHHFiWvJTEK');

-- --------------------------------------------------------

--
-- Table structure for table `tblbaustdpts`
--

CREATE TABLE `tblbaustdpts` (
  `id` int(11) NOT NULL,
  `Department` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblbaustdpts`
--

INSERT INTO `tblbaustdpts` (`id`, `Department`) VALUES
(1, 'CSE'),
(2, 'EEE'),
(3, 'CE'),
(4, 'MEE'),
(5, 'BBA'),
(6, 'ENG'),
(7, 'ICT'),
(8, 'AIS');

-- --------------------------------------------------------

--
-- Table structure for table `tblblooddonars`
--

CREATE TABLE `tblblooddonars` (
  `id` int(11) NOT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `MobileNumber` varchar(20) DEFAULT NULL,
  `Emailid` varchar(100) DEFAULT NULL,
  `Gender` varchar(10) DEFAULT NULL,
  `Age` int(11) DEFAULT NULL,
  `BloodGroup` varchar(5) DEFAULT NULL,
  `Address` text,
  `Message` text,
  `PostingDate` date DEFAULT NULL,
  `Status` int(11) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Batch` varchar(20) DEFAULT NULL,
  `Department` varchar(50) DEFAULT NULL,
  `ProfileImage` varchar(255) DEFAULT 'uploads/default.png'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblblooddonars`
--

INSERT INTO `tblblooddonars` (`id`, `FullName`, `MobileNumber`, `Emailid`, `Gender`, `Age`, `BloodGroup`, `Address`, `Message`, `PostingDate`, `Status`, `Password`, `Batch`, `Department`, `ProfileImage`) VALUES
(2, 'aihan', '01686777868', 'ihant@gmail.com', 'Male', 25, '1', '', '', '2025-07-27', 1, '$2y$10$uPdMx3t.YeG.VglYYB76T.qNz/WQ1O8Flak5WwsOkvRqHfz/ZUFdW', '8th', '2', 'uploads/default.png'),
(3, 'tushar', '01340236919', 'tushar@gmail.com', 'Male', 23, '1', 'saidpur', 'nothing', '2025-07-28', 1, NULL, '8', '1', 'uploads/default.png'),
(5, 'Emon', '01701010101', 'emon@gmail.com', 'Male', 21, '1', 'rangpur', '', '2025-07-28', 1, '$2y$10$RP6wYbtEsmAuFofuc3ihqOUTRo/Tema6fJx4B8G7R.Pyw.XeU8Kku', '11', '1', 'uploads/default.png'),
(6, 'mansib', '01300183011', 'mansib@gmail.com', 'Male', 21, 'O+', '', '', '2025-07-28', 1, '$2y$10$Murbg3EYm5TA8RRh7fP1N.J5yHu84u0dQt5RibQ2bo9sOWe97bONa', '10th', 'Cse', 'uploads/default.png'),
(7, 'Rohim', '01000000000', 'rohim1@gmail.com', 'Male', 40, '6', 'Baust Saidpur', NULL, '2025-07-28', 1, '0', '15', '1', 'uploads/default.png'),
(8, 'sojib', '01788888888', 'sojib@gmail.com', 'Male', 25, '3', 'Bogura', NULL, '2025-07-29', 1, '0', '8th', '1', 'uploads/default.png'),
(9, 'Dada', '01798989898', 'dada@gmail.com', 'Male', 50, 'AB+', '', '', '2025-07-29', 1, '$2y$10$60toSOuegtV9xRuZUhga5OigQrTrHDXDP6Hum.6sLUTkMY8SniglG', '7th batch', 'cse', 'uploads/default.png'),
(10, 'Md. Minhajul', '01881818181', 'minhajul@gmail.com', 'Male', 21, '1', 'Rajshahi', '', '2025-08-03', 1, '$2y$10$NGLRylJ/EjYbjBKsobMdJ.hMtN/5J5XKrhXxUjL43w80bLB.1sX1G', '21th', '5', 'uploads/default.png'),
(11, 'Abu Raihan', '01786777868', 'traihant443@gmail.com', 'Male', 25, '1', 'Saidpure', '', '2025-08-03', 1, '$2y$10$cnnhnsICb5kyQ640Yq/MFeiXn0IVp33Y3HurT3y/l8apPBHzW37AK', '8th', '1', 'uploads/profile_6891e71ae8484.jpg'),
(12, 'mansib sonnet', '01300183099', 'sonnet@gmail.com', 'Male', 25, '1', '', '', '2025-08-05', 0, '$2y$10$ltwISydTTXtDNu7Vs3tPhe8YqI6x7r7BwI02f9fK1SNxgRfzGoiRK', '10th', '1', 'uploads/profile_6891f5ca918df.jpeg'),
(13, 'Taher mahade sir ', '01788663626', 'mahade@gmail.com', 'Male', 29, '1', '', '', '2025-08-06', 1, '$2y$10$RD3RGDUd64ig/GvklKabveXiSGO.pqccY2A/L123FCkZAjrEvAXhm', 'no', '1', 'uploads/default.png');

-- --------------------------------------------------------

--
-- Table structure for table `tblbloodgroup`
--

CREATE TABLE `tblbloodgroup` (
  `id` int(11) NOT NULL,
  `BloodGroup` varchar(10) NOT NULL,
  `PostingDate` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblbloodgroup`
--

INSERT INTO `tblbloodgroup` (`id`, `BloodGroup`, `PostingDate`) VALUES
(1, 'A+', '2025-07-28 18:54:05'),
(2, 'A-', '2025-07-28 18:54:05'),
(3, 'B+', '2025-07-28 18:54:05'),
(4, 'B-', '2025-07-28 18:54:05'),
(5, 'AB+', '2025-07-28 18:54:05'),
(6, 'AB-', '2025-07-28 18:54:05'),
(7, 'O+', '2025-07-28 18:54:05'),
(8, 'O-', '2025-07-28 18:54:05');

-- --------------------------------------------------------

--
-- Table structure for table `tblbloodrequirer`
--

CREATE TABLE `tblbloodrequirer` (
  `ID` int(11) NOT NULL,
  `BloodDonarID` int(11) NOT NULL,
  `BloodGroup` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `Emailid` varchar(100) NOT NULL,
  `ContactNumber` varchar(20) NOT NULL,
  `BloodRequirefor` varchar(100) NOT NULL,
  `Message` text,
  `ApplyDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblbloodrequirer`
--

INSERT INTO `tblbloodrequirer` (`ID`, `BloodDonarID`, `BloodGroup`, `name`, `Emailid`, `ContactNumber`, `BloodRequirefor`, `Message`, `ApplyDate`) VALUES
(1, 2, 'A+', 'Abu Raihan', 'traihant443@gmail.com', '01786777868', 'Operation', 'Need Within today', '2025-07-27 23:53:15'),
(2, 6, 'O+', 'Mansib', 'mansib@gmail.com', '01300183011', 'Accident', 'Emargency', '2025-07-28 14:05:59');

-- --------------------------------------------------------

--
-- Table structure for table `tblbloodresolved`
--

CREATE TABLE `tblbloodresolved` (
  `RequirerID` int(11) NOT NULL,
  `IsResolved` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblbloodresolved`
--

INSERT INTO `tblbloodresolved` (`RequirerID`, `IsResolved`) VALUES
(1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblrequests`
--

CREATE TABLE `tblrequests` (
  `id` int(11) NOT NULL,
  `PatientName` varchar(100) NOT NULL,
  `BloodGroup` int(11) NOT NULL,
  `Department` int(11) NOT NULL,
  `RequiredDate` date NOT NULL,
  `Details` text NOT NULL,
  `ContactNo` varchar(20) NOT NULL,
  `RequestDate` datetime DEFAULT CURRENT_TIMESTAMP,
  `Status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `IsResolved` tinyint(1) DEFAULT '0',
  `UserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblrequests`
--

INSERT INTO `tblrequests` (`id`, `PatientName`, `BloodGroup`, `Department`, `RequiredDate`, `Details`, `ContactNo`, `RequestDate`, `Status`, `IsResolved`, `UserId`) VALUES
(1, 'ronaldo', 3, 1, '2025-07-31', 'Injuries by Playing football', '01999999999', '2025-07-29 02:36:36', 'Pending', 0, 0),
(2, 'korim', 1, 1, '2025-07-31', 'Major  Operation', '01661616161', '2025-07-29 04:25:39', 'Pending', 0, 0),
(3, 'Jobbar', 6, 4, '2025-07-31', 'blood cancer', '01666666666', '2025-07-29 23:16:52', 'Pending', 0, 0),
(4, 'Md. Minhajul', 1, 5, '2025-08-06', 'for relatives operation', '01881818181', '2025-08-03 16:27:22', 'Pending', 0, 0),
(5, 'Abu Raihan', 1, 1, '2025-08-06', 'Accident', '01786777868', '2025-08-03 17:40:21', 'Pending', 0, 0),
(6, 'Harun', 2, 1, '2025-08-15', 'Needs For Something emargency', '01661616171', '2025-08-03 18:36:30', 'Pending', 1, 11),
(7, 'hatim', 7, 1, '2025-08-29', 'accident', '01300183011', '2025-08-05 12:09:32', 'Pending', 0, 12);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `UserName` (`UserName`);

--
-- Indexes for table `tblbaustdpts`
--
ALTER TABLE `tblbaustdpts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblblooddonars`
--
ALTER TABLE `tblblooddonars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblbloodgroup`
--
ALTER TABLE `tblbloodgroup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblbloodrequirer`
--
ALTER TABLE `tblbloodrequirer`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `BloodDonarID` (`BloodDonarID`);

--
-- Indexes for table `tblbloodresolved`
--
ALTER TABLE `tblbloodresolved`
  ADD PRIMARY KEY (`RequirerID`);

--
-- Indexes for table `tblrequests`
--
ALTER TABLE `tblrequests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `BloodGroup` (`BloodGroup`),
  ADD KEY `Department` (`Department`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblbaustdpts`
--
ALTER TABLE `tblbaustdpts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblblooddonars`
--
ALTER TABLE `tblblooddonars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tblbloodgroup`
--
ALTER TABLE `tblbloodgroup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblbloodrequirer`
--
ALTER TABLE `tblbloodrequirer`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblrequests`
--
ALTER TABLE `tblrequests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblbloodrequirer`
--
ALTER TABLE `tblbloodrequirer`
  ADD CONSTRAINT `tblbloodrequirer_ibfk_1` FOREIGN KEY (`BloodDonarID`) REFERENCES `tblblooddonars` (`id`);

--
-- Constraints for table `tblbloodresolved`
--
ALTER TABLE `tblbloodresolved`
  ADD CONSTRAINT `tblbloodresolved_ibfk_1` FOREIGN KEY (`RequirerID`) REFERENCES `tblbloodrequirer` (`ID`) ON DELETE CASCADE;

--
-- Constraints for table `tblrequests`
--
ALTER TABLE `tblrequests`
  ADD CONSTRAINT `tblrequests_ibfk_1` FOREIGN KEY (`BloodGroup`) REFERENCES `tblbloodgroup` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tblrequests_ibfk_2` FOREIGN KEY (`Department`) REFERENCES `tblbaustdpts` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
