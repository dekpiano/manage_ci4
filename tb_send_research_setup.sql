-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 21, 2025 at 05:21 AM
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
-- Table structure for table `tb_send_research_setup`
--

CREATE TABLE `tb_send_research_setup` (
  `seres_setup_ID` int(11) NOT NULL,
  `seres_setup_startdate` datetime NOT NULL COMMENT 'วันที่เริ่มต้นการส่ง',
  `seres_setup_enddate` datetime NOT NULL COMMENT 'วันที่สิ้นสุดการส่ง',
  `seres_setup_year` varchar(4) NOT NULL COMMENT 'ปีการศึกษาที่เปิดรับ',
  `seres_setup_term` varchar(1) NOT NULL COMMENT 'ภาคเรียนที่เปิดรับ',
  `seres_setup_status` enum('on','off') NOT NULL DEFAULT 'off' COMMENT 'สถานะเปิด/ปิดการส่ง',
  `seres_setup_usersetup` varchar(20) DEFAULT NULL COMMENT 'ผู้ที่ตั้งค่าล่าสุด'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tb_send_research_setup`
--

INSERT INTO `tb_send_research_setup` (`seres_setup_ID`, `seres_setup_startdate`, `seres_setup_enddate`, `seres_setup_year`, `seres_setup_term`, `seres_setup_status`, `seres_setup_usersetup`) VALUES
(1, '2025-11-01 00:00:00', '2026-03-31 23:59:59', '2568', '2', 'on', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_send_research_setup`
--
ALTER TABLE `tb_send_research_setup`
  ADD PRIMARY KEY (`seres_setup_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_send_research_setup`
--
ALTER TABLE `tb_send_research_setup`
  MODIFY `seres_setup_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
