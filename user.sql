-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2025 at 09:41 PM
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
-- Database: `task1`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID#` int(11) NOT NULL,
  `USERID` varchar(256) NOT NULL,
  `PASSWORD` varchar(256) NOT NULL,
  `USERTYPE` char(5) NOT NULL,
  `USERSTATUS` char(8) NOT NULL,
  `FIRSTNAME` varchar(256) NOT NULL,
  `LASTNAME` varchar(256) NOT NULL,
  `EMAIL` varchar(256) NOT NULL,
  `TIMECREATED` datetime NOT NULL DEFAULT current_timestamp(),
  `LASTUPDATED` datetime NOT NULL,
  `FAILED_ATTEMPTS` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID#`, `USERID`, `PASSWORD`, `USERTYPE`, `USERSTATUS`, `FIRSTNAME`, `LASTNAME`, `EMAIL`, `TIMECREATED`, `LASTUPDATED`, `FAILED_ATTEMPTS`) VALUES
(1, 'admin', '9a43abea141d3972f7e98a22fd53a402', 'ADMIN', 'ACTIVE', 'Admin', 'User', 'admin@example.com', '2025-04-13 01:15:55', '2025-04-13 01:15:55', 0),
(2, 'bsmith', '32aa0c466818e1ccba25b8793db98c94', 'USER', 'ACTIVE', 'Bill', 'Smith', 'bsmith@example.com', '2025-04-13 01:15:55', '2025-04-13 01:15:55', 0),
(3, 'pjones', '53eb1f29c1f8a132441a4fad1d6f667d', 'USER', 'ACTIVE', 'Pauline', 'Jones', 'pjones@example.com', '2025-04-13 01:15:55', '2025-04-13 01:15:55', 0),
(4, 'rkm010300', '1c2ce0226e8fd1a1eeebf1117887951c', 'ADMIN', 'ACTIVE', 'Richard', 'Min', 'rkm010300@example.com', '2025-04-13 01:15:55', '2025-04-13 01:15:55', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID#`),
  ADD UNIQUE KEY `EMAIL` (`EMAIL`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID#` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
