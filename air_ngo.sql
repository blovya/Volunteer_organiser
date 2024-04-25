-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 20, 2023 at 10:21 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `air_ngo`
--
CREATE DATABASE IF NOT EXISTS `air_ngo` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `air_ngo`;

-- --------------------------------------------------------

--
-- Table structure for table `organiser`
--

CREATE TABLE `organiser` (
  `username` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `organiser`:
--

--
-- Dumping data for table `organiser`
--

INSERT INTO `organiser` (`username`, `password`) VALUES
('Adam Binge', 'AusBinge*'),
('Archana Kandarpa', 'ItsArchu30*'),
('Josh Buckland', 'AusBuckland*');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `task_id` smallint(6) NOT NULL,
  `task_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `task`:
--

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`task_id`, `task_name`) VALUES
(2, 'Admissions'),
(3, 'Cleaning'),
(4, 'Crowd Control'),
(6, 'Pack Up'),
(5, 'Run Competition'),
(1, 'Set Up');

-- --------------------------------------------------------

--
-- Table structure for table `time_slot`
--

CREATE TABLE `time_slot` (
  `time_slot_id` tinyint(4) NOT NULL COMMENT 'AUTO_INCREMENT',
  `time_slot_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `time_slot`:
--

--
-- Dumping data for table `time_slot`
--

INSERT INTO `time_slot` (`time_slot_id`, `time_slot_name`) VALUES
(2, 'Day1, Afternoon'),
(1, 'Day1, Morning'),
(3, 'Day1, Night'),
(5, 'Day2, Afternoon'),
(4, 'Day2, Morning'),
(6, 'Day2, Night');

-- --------------------------------------------------------

--
-- Table structure for table `volunteer`
--

CREATE TABLE `volunteer` (
  `email` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `phone_number` varchar(25) NOT NULL,
  `postcode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `volunteer`:
--

-- --------------------------------------------------------

--
-- Table structure for table `volunteer_time_slot`
--

CREATE TABLE `volunteer_time_slot` (
  `email` varchar(50) NOT NULL,
  `time_slot_id` tinyint(4) NOT NULL,
  `task_id` smallint(6) DEFAULT NULL,
  `details` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `volunteer_time_slot`:
--   `email`
--       `volunteer` -> `email`
--   `time_slot_id`
--       `time_slot` -> `time_slot_id`
--   `task_id`
--       `task` -> `task_id`
--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `organiser`
--
ALTER TABLE `organiser`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`task_id`),
  ADD UNIQUE KEY `task_name` (`task_name`);

--
-- Indexes for table `time_slot`
--
ALTER TABLE `time_slot`
  ADD PRIMARY KEY (`time_slot_id`),
  ADD UNIQUE KEY `time_slot_name` (`time_slot_name`);

--
-- Indexes for table `volunteer`
--
ALTER TABLE `volunteer`
  ADD PRIMARY KEY (`email`),
  ADD UNIQUE KEY `phone_number` (`phone_number`);

--
-- Indexes for table `volunteer_time_slot`
--
ALTER TABLE `volunteer_time_slot`
  ADD PRIMARY KEY (`email`,`time_slot_id`),
  ADD KEY `time_slot_id` (`time_slot_id`),
  ADD KEY `task_id` (`task_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `task_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `time_slot`
--
ALTER TABLE `time_slot`
  MODIFY `time_slot_id` tinyint(4) NOT NULL AUTO_INCREMENT COMMENT 'AUTO_INCREMENT', AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `volunteer_time_slot`
--
ALTER TABLE `volunteer_time_slot`
  ADD CONSTRAINT `volunteer_time_slot_ibfk_1` FOREIGN KEY (`email`) REFERENCES `volunteer` (`email`),
  ADD CONSTRAINT `volunteer_time_slot_ibfk_2` FOREIGN KEY (`time_slot_id`) REFERENCES `time_slot` (`time_slot_id`),
  ADD CONSTRAINT `volunteer_time_slot_ibfk_3` FOREIGN KEY (`task_id`) REFERENCES `task` (`task_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
