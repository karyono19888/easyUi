-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 07, 2020 at 09:47 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hris_saga`
--

-- --------------------------------------------------------

--
-- Table structure for table `departemen`
--

CREATE TABLE `departemen` (
  `departemen_id` int(1) UNSIGNED NOT NULL,
  `departemen_induk` int(1) NOT NULL,
  `departemen_nama` varchar(30) NOT NULL,
  `departemen_penilai` varchar(30) NOT NULL,
  `departemen_workday` int(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Master Departemen';

--
-- Dumping data for table `departemen`
--

INSERT INTO `departemen` (`departemen_id`, `departemen_induk`, `departemen_nama`, `departemen_penilai`, `departemen_workday`) VALUES
(1, 0, 'HRD GA', '', 1),
(2, 0, 'MARKETING', '', 1),
(3, 0, 'ACC - FINN', '', 1),
(4, 0, 'PI', '', 1),
(5, 0, 'IT', '', 1),
(6, 3, 'COLLECTOR', '', 1),
(7, 12, 'DELIVERY', '', 1),
(8, 3, 'ACC-FINN', '', 1),
(9, 1, 'DRIVER', '', 2),
(10, 1, 'AST. DRIVER', '', 2),
(11, 2, 'MARKETING', '', 1),
(12, 0, 'WAREHOUSE', '', 1),
(13, 2, 'SALES', '', 1),
(14, 1, 'PERSIAPAN', '', 1),
(15, 4, 'ADM COST & SAMPLE', '', 1),
(16, 1, 'PELAYANAN UMUM OFFICE & KANTIN', '', 1),
(17, 12, 'PACKING', '', 1),
(18, 12, 'INCOMING', '', 1),
(20, 5, 'IT', 'feri', 1),
(21, 5, 'STAF IT', '', 1),
(22, 2, 'DELIVERY', '', 1),
(23, 1, 'PELAYANAN UMUM LAPANGAN', '', 1),
(24, 2, 'ADMINISTRASI', '', 1),
(25, 3, 'ADMINISTRASI', '', 1),
(26, 1, 'LEGAL', '', 1),
(27, 0, 'QHSE', '', 1),
(28, 27, 'QHSE', '', 1),
(29, 1, 'GA LAPANGAN', '', 1),
(30, 1, 'DELIVERY', '', 2),
(31, 1, 'HRD-GA', '', 1),
(32, 12, 'ADM CLAIM & QUALITY', '', 1),
(33, 12, 'PERSIAPAN', '', 1),
(35, 5, 'HELPDESK', '', 1),
(36, 5, 'DEVELOPER', '', 1),
(37, 27, 'SECRETARY', '', 1),
(38, 27, 'DOCUMENT CONTROL', '', 1),
(39, 27, 'LEGAL', '', 1),
(40, 27, 'ASDAM & HIRADC', '', 1),
(41, 27, 'TRAINING', '', 1),
(42, 27, 'WASTE MANAGEMENT', '', 1),
(43, 27, 'MANAGER', '', 1),
(45, 1, 'GA', '', 1),
(46, 5, 'EDP', '', 1),
(47, 5, 'MULTIMEDIA', '', 1),
(48, 12, 'ADM DELIVERY CUSTOMER', '', 1),
(50, 4, 'PI', '', 1),
(51, 4, 'ADM. CLAIM & QUALITY', '', 1),
(52, 4, 'ADM. DELIVERY CUSTOMER', '', 1),
(53, 4, 'ADM. DELIVERY SUPPLIER', '', 1),
(54, 4, 'DELIVERY', '', 1),
(55, 4, 'INCOMING', '', 1),
(56, 4, 'PACKING', '', 1),
(57, 4, 'WH INCOMING', '', 1),
(58, 12, 'CHECKER', '', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departemen`
--
ALTER TABLE `departemen`
  ADD PRIMARY KEY (`departemen_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departemen`
--
ALTER TABLE `departemen`
  MODIFY `departemen_id` int(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
