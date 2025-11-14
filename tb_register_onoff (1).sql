-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2025 at 09:55 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skjacth_academic`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_register_onoff`
--

CREATE TABLE `tb_register_onoff` (
  `onoff_id` int(11) NOT NULL,
  `onoff_name` varchar(50) NOT NULL,
  `onoff_status` varchar(15) NOT NULL,
  `onoff_year` varchar(10) NOT NULL,
  `onoff_Level` varchar(20) NOT NULL COMMENT 'ระดับชั้น',
  `onoff_detail` text NOT NULL,
  `onoff_StartDate` datetime NOT NULL,
  `onoff_EndDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tb_register_onoff`
--

INSERT INTO `tb_register_onoff` (`onoff_id`, `onoff_name`, `onoff_status`, `onoff_year`, `onoff_Level`, `onoff_detail`, `onoff_StartDate`, `onoff_EndDate`) VALUES
(1, 'DoGradeStudent', 'true', '2/2567', '1|2|3|4|5|6', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'ก่อนกลางภาค', 'off', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'สอบกลางภาค', 'on', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'หลังกลางภาค', 'on', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'สอบปลายภาค', 'on', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'กรอกเกรดครู', 'on', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'เรียนซ้ำ', 'on', '1/2568', '', 'เรียนซ้ำครั้งที่ 2', '2022-11-06 22:44:02', '2022-11-07 22:44:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_register_onoff`
--
ALTER TABLE `tb_register_onoff`
  ADD PRIMARY KEY (`onoff_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_register_onoff`
--
ALTER TABLE `tb_register_onoff`
  MODIFY `onoff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
