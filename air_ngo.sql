-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2023 at 09:52 PM
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
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `log_id` int(11) NOT NULL,
  `log_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `ip_address` varchar(50) NOT NULL,
  `event_type` varchar(50) NOT NULL,
  `event_details` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `log`:
--

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`log_id`, `log_date`, `ip_address`, `event_type`, `event_details`) VALUES
(84, '2023-10-24 01:02:42', '::1', 'Registration (Volunteer)', 'lovyab@our.ecu.edu.au registered');

-- --------------------------------------------------------

--
-- Table structure for table `organiser`
--

CREATE TABLE `organiser` (
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `organiser`:
--

--
-- Dumping data for table `organiser`
--

INSERT INTO `organiser` (`username`, `password_hash`) VALUES
('lovish', '$2y$10$xiU.FW8STHFKSX2uzxRWdeAABylviMhwt9mK1.4bDW3rC6zjteucC'),
('lovya', '$2y$10$n/P9JeRphjMLcGUkg3X99ObbtH8DjoIUWdQoGfcg/PRqEgTYsZBMi');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `task_id` smallint(6) NOT NULL,
  `task_name` varchar(20) NOT NULL,
  `eighteen_plus` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `task`:
--

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`task_id`, `task_name`, `eighteen_plus`) VALUES
(1, 'Set Up', 0),
(2, 'Admissions', 0),
(3, 'Cleaning', 0),
(5, 'Run Competition', 0),
(6, 'Pack Up', 0),
(7, 'New Task', 0),
(16, 'Crowd Control', 1);

-- --------------------------------------------------------

--
-- Table structure for table `time_slot`
--

CREATE TABLE `time_slot` (
  `time_slot_id` tinyint(4) NOT NULL,
  `time_slot_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `time_slot`:
--

--
-- Dumping data for table `time_slot`
--

INSERT INTO `time_slot` (`time_slot_id`, `time_slot_name`) VALUES
(2, 'Day 1, Afternoon'),
(1, 'Day 1, Morning'),
(3, 'Day 1, Night'),
(5, 'Day 2, Afternoon'),
(4, 'Day 2, Morning '),
(6, 'Day 2, Night'),
(8, 'Day 3, Afternoon'),
(7, 'Day 3, Morning'),
(9, 'Day 3, Night');

-- --------------------------------------------------------

--
-- Table structure for table `volunteer`
--

CREATE TABLE `volunteer` (
  `email` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `date_of_birth` date NOT NULL,
  `phone_number` varchar(25) NOT NULL,
  `postcode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `volunteer`:
--

--
-- Dumping data for table `volunteer`
--

INSERT INTO `volunteer` (`email`, `password_hash`, `first_name`, `last_name`, `date_of_birth`, `phone_number`, `postcode`) VALUES
('blovya@gmail.com', '$2y$10$jXeSzxGbWtRv7ogdBgGhF.7DzFK9.ncHd7x3Yw63sSA9WKTu4ycii', 'Lovya', 'Bajaj', '2000-02-10', '0455456329', 6036),
('lovish@gmail.com', '$2y$10$OpahBRPI4B/T/Cq7MIhfuefPVyqxZXRKFw8PX/kEty9MobnMcg9Je', 'Lovish', 'Bajaj', '2015-02-20', '04554889329', 6036);

-- --------------------------------------------------------

--
-- Table structure for table `volunteer_time_slot`
--

CREATE TABLE `volunteer_time_slot` (
  `Volunteer_time_slot_ID` int(100) NOT NULL,
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
-- Dumping data for table `volunteer_time_slot`
--

INSERT INTO `volunteer_time_slot` (`Volunteer_time_slot_ID`, `email`, `time_slot_id`, `task_id`, `details`) VALUES
(17, 'lovish@gmail.com', 4, NULL, NULL),
(18, 'lovish@gmail.com', 2, NULL, NULL),
(19, 'lovish@gmail.com', 6, 3, 'Cleaning the area'),
(20, 'lovish@gmail.com', 9, NULL, NULL),
(21, 'blovya@gmail.com', 3, NULL, NULL),
(22, 'blovya@gmail.com', 1, 2, 'Running Admissions'),
(23, 'blovya@gmail.com', 8, 6, 'Packing up the equipments'),
(24, 'blovya@gmail.com', 2, 1, 'Setting Up The room');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`log_id`);

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
  ADD PRIMARY KEY (`Volunteer_time_slot_ID`),
  ADD KEY `email` (`email`),
  ADD KEY `time_slot_id` (`time_slot_id`),
  ADD KEY `task_id` (`task_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `task_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `volunteer_time_slot`
--
ALTER TABLE `volunteer_time_slot`
  MODIFY `Volunteer_time_slot_ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `volunteer_time_slot`
--
ALTER TABLE `volunteer_time_slot`
  ADD CONSTRAINT `volunteer_time_slot_ibfk_1` FOREIGN KEY (`email`) REFERENCES `volunteer` (`email`),
  ADD CONSTRAINT `volunteer_time_slot_ibfk_2` FOREIGN KEY (`time_slot_id`) REFERENCES `time_slot` (`time_slot_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `volunteer_time_slot_ibfk_3` FOREIGN KEY (`task_id`) REFERENCES `task` (`task_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
