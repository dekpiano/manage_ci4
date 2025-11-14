-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2025 at 11:24 AM
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
-- Table structure for table `tb_send_plan_type`
--

CREATE TABLE `tb_send_plan_type` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(100) NOT NULL,
  `type_description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='ตารางเก็บประเภทของเอกสารในระบบส่งแผนการสอน';

--
-- Dumping data for table `tb_send_plan_type`
--

INSERT INTO `tb_send_plan_type` (`type_id`, `type_name`, `type_description`, `is_active`) VALUES
(1, 'บันทึกตรวจใช้แผน', NULL, 1),
(2, 'แบบตรวจแผนการจัดการเรียนรู้', NULL, 1),
(3, 'โครงการสอน', NULL, 1),
(4, 'แผนการจัดดารเรียนรู้', NULL, 1),
(5, 'แผนการสอนเต็ม', NULL, 0),
(6, 'บันทึกหลังสอน', NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_send_plan_type`
--
ALTER TABLE `tb_send_plan_type`
  ADD PRIMARY KEY (`type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_send_plan_type`
--
ALTER TABLE `tb_send_plan_type`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
