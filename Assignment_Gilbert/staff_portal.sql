-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2024 at 08:38 AM
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
-- Database: `staff_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_staff`
--

CREATE TABLE `tbl_staff` (
  `Index_Number` varchar(50) NOT NULL,
  `Full_Names` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Current_Location` varchar(50) NOT NULL,
  `Highest_Level_Of_Education` varchar(50) NOT NULL,
  `Duty_Station` varchar(50) NOT NULL,
  `Availability_For_Remote_Work` varchar(50) NOT NULL,
  `Software_Expertise` varchar(50) NOT NULL,
  `Software_Expertise_Level` varchar(50) NOT NULL,
  `Language` varchar(50) NOT NULL,
  `Level_of_Responsibility` varchar(50) NOT NULL,
  `R_created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `R_updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_staff`
--

INSERT INTO `tbl_staff` (`Index_Number`, `Full_Names`, `Email`, `Current_Location`, `Highest_Level_Of_Education`, `Duty_Station`, `Availability_For_Remote_Work`, `Software_Expertise`, `Software_Expertise_Level`, `Language`, `Level_of_Responsibility`, `R_created_at`, `R_updated_at`) VALUES
('54354354', 'Gilvert', 'unuser@un.unpe', 'Nairobi', 'Level 2', 'Station 2', '20.1', 'Expertise 2', 'Expertise Level 2', 'English', 'Responsibility 2', '2024-10-28 07:33:44', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_staff_user`
--

CREATE TABLE `tbl_staff_user` (
  `id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_staff_user`
--

INSERT INTO `tbl_staff_user` (`id`, `user_name`, `password`, `created_at`, `updated_at`) VALUES
(1, 'user@unep.un', '1q2w3e4r5t', '2024-10-28 06:36:16', '2024-10-28 07:35:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_staff_user`
--
ALTER TABLE `tbl_staff_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_staff_user`
--
ALTER TABLE `tbl_staff_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
