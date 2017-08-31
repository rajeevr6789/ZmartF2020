-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 30, 2017 at 11:56 AM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smart_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_smart_form`
--

CREATE TABLE `tbl_smart_form` (
  `part_id` int(12) NOT NULL COMMENT 'primary key',
  `part_name` varchar(250) NOT NULL,
  `part_casting_metal` varchar(100) NOT NULL,
  `part_surface_area` varchar(15) NOT NULL,
  `part_weight` varchar(15) NOT NULL,
  `part_volume` varchar(15) NOT NULL,
  `mold_material` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_smart_form`
--

INSERT INTO `tbl_smart_form` (`part_id`, `part_name`, `part_casting_metal`, `part_surface_area`, `part_weight`, `part_volume`, `mold_material`) VALUES
(1, 'PART_ARS', 'Iron', '15', '26256.', '554.6', 'Iron Oxide'),
(2, 'fghgf', 'dghgh', 'dh', 'tyy', 'dhg', 'dhdh'),
(3, 'sdg', 'sdfg', 'sdg', 'sd', 'df', 'df'),
(4, 'asd', 'qqwe', '145', '1.52', '52.5', 'urbab');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_smart_form`
--
ALTER TABLE `tbl_smart_form`
  ADD PRIMARY KEY (`part_id`),
  ADD UNIQUE KEY `part_id` (`part_id`),
  ADD UNIQUE KEY `part_name` (`part_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_smart_form`
--
ALTER TABLE `tbl_smart_form`
  MODIFY `part_id` int(12) NOT NULL AUTO_INCREMENT COMMENT 'primary key', AUTO_INCREMENT=6;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
