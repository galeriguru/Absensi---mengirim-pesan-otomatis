-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2024 at 09:37 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absensi_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(2, 'admin', '$2y$10$pweYz0QbdoLzSRTiDI4XWOqwX.RftgkiQe9ibVnMrOBHjPQGbKVkq');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role` enum('teacher','student') NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `user_id`, `role`, `timestamp`) VALUES
(1, 101, 'student', '2024-07-05 15:47:40'),
(2, 102, 'student', '2024-07-05 15:50:54'),
(4, 107, 'student', '2024-07-04 17:00:00'),
(7, 12345, 'student', '2024-07-06 07:13:05'),
(8, 101010, 'teacher', '2024-07-06 07:13:27');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `unique_id` varchar(10) NOT NULL,
  `chat_id` varchar(255) DEFAULT NULL,
  `class` varchar(225) CHARACTER SET swe7 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `unique_id`, `chat_id`, `class`) VALUES
(1, 'John', '101', '1276733470', '9A'),
(2, 'Sarah', '102', '@sarah456', '9A'),
(3, 'Michael', '103', '@mike789', '9B'),
(4, 'Emily', '104', '@emily_23', '9C'),
(5, 'David', '105', '@david_m', '9B'),
(6, 'Jessica', '106', '@jess_77', '9C'),
(7, 'Kevin', '107', '@kevin_k', '9A'),
(8, 'Lisa', '108', '@lisa_90', ''),
(9, 'Matthew', '109', '@matt_99', '9A'),
(21, 'John', '54534', '1276733470', '9A'),
(22, 'Sarah', '54645', '@sarah456', '9A'),
(23, 'Michael', '7567567', '@mike789', '9A'),
(24, 'Emily', '786786', '@emily_23', '9A'),
(25, 'David', '464574', '@david_m', '9A'),
(26, 'Jessica', '787975', '@jess_77', '9B'),
(27, 'Kevin', '645656', '@kevin_k', '9B'),
(28, 'Lisa', '645676', '@lisa_90', '9B'),
(29, 'Matthew', '564564', '@matt_99', '9B'),
(30, 'Olivia', '775685', '@olivia_11', '9B'),
(31, 'nama siswa baru', '12345', '1373249909', '');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `unique_id` varchar(10) NOT NULL,
  `chat_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `name`, `unique_id`, `chat_id`) VALUES
(24, 'Asep Jaenudin', '101010', '1276733470');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_id` (`unique_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_id` (`unique_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
