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
-- Table structure for table `tb_send_research`
--

CREATE TABLE `tb_send_research` (
  `seres_ID` int(5) NOT NULL,
  `seres_research_name` varchar(255) NOT NULL COMMENT 'ชื่องานวิจัย',
  `seres_namesubject` varchar(255) NOT NULL COMMENT 'ชื่อรายวิชา',
  `seres_coursecode` varchar(10) NOT NULL COMMENT 'รหัสวิชา',
  `seres_gradelevel` varchar(2) NOT NULL COMMENT 'ระดับชั้น',
  `seres_sendcomment` text NOT NULL COMMENT 'รายละเอียดเพิ่มเติม',
  `seres_createdate` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่ส่ง',
  `seres_usersend` varchar(20) NOT NULL COMMENT 'ผู้ส่ง',
  `seres_learning` varchar(15) NOT NULL COMMENT 'กลุ่มสาระ',
  `seres_year` varchar(4) NOT NULL COMMENT 'ปีการศึกษา',
  `seres_term` varchar(1) NOT NULL COMMENT 'ภาคเรียน',
  `seres_file` text NOT NULL COMMENT 'ไฟล์งานวิจัย',
  `seres_status` varchar(30) NOT NULL DEFAULT 'ส่งแล้ว' COMMENT 'สถานะการส่ง'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tb_send_research`
--

INSERT INTO `tb_send_research` (`seres_ID`, `seres_research_name`, `seres_namesubject`, `seres_coursecode`, `seres_gradelevel`, `seres_sendcomment`, `seres_createdate`, `seres_usersend`, `seres_learning`, `seres_year`, `seres_term`, `seres_file`, `seres_status`) VALUES
(2, 'งานดี', 'คอมพิวเตอร์', 'ว30122', '2', 'ส่งแล้ว', '2025-11-20 15:51:14', 'pers_021', 'lear_003', '', '', '691ed69516a14-_pers_021.pdf', 'ส่งแล้ว'),
(7, 'งานดี', 'คอมพิวเตอร์', 'ว30122', '2', '456', '2025-11-20 17:55:04', 'pers_021', 'lear_003', '2568', '2', '691ef4ee45361-_pers_021.pdf', 'ส่งแล้ว');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_send_research`
--
ALTER TABLE `tb_send_research`
  ADD PRIMARY KEY (`seres_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_send_research`
--
ALTER TABLE `tb_send_research`
  MODIFY `seres_ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
