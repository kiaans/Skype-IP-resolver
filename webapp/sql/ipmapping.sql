-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 14, 2014 at 03:30 PM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ipmapping`
--

-- --------------------------------------------------------

--
-- Table structure for table `ip_info`
--

CREATE TABLE IF NOT EXISTS `ip_info` (
  `ID` varchar(50) NOT NULL,
  `IP_Public` varchar(50) NOT NULL DEFAULT '',
  `IP_Internal` varchar(50) NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`,`IP_Public`,`TimeStamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ip_info`
--

INSERT INTO `ip_info` (`ID`, `IP_Public`, `IP_Internal`, `TimeStamp`) VALUES
('agarwal.lalit91', '122.176.180.18', '192.168.1.9', '2014-02-14 14:29:27'),
('anand.mudgerikar', '122.176.180.18', '192.168.1.129', '2014-02-14 14:30:07'),
('anand.mudgerikar', '182.67.89.107', '182.67.89.107', '2014-02-14 14:30:08'),
('krs.sumeet', '122.161.173.45', '192.168.1.6', '2014-02-14 14:26:36'),
('krs.sumeet', '122.176.180.18', '192.168.1.11', '2014-02-14 14:26:35'),
('sagar.mohite77', '68.37.252.155', '10.0.0.5', '2014-02-14 14:28:19');

-- --------------------------------------------------------

--
-- Table structure for table `ip_location`
--

CREATE TABLE IF NOT EXISTS `ip_location` (
  `IP_Public` varchar(50) NOT NULL,
  `City` text,
  `Country` text,
  `Latitude` varchar(20) NOT NULL,
  `Longitude` varchar(20) NOT NULL,
  PRIMARY KEY (`IP_Public`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ip_location`
--

INSERT INTO `ip_location` (`IP_Public`, `City`, `Country`, `Latitude`, `Longitude`) VALUES
('122.161.173.45', 'DELHI', 'IN', '28.6358', '77.2244'),
('122.176.180.18', 'DELHI', 'IN', '28.6358', '77.2244'),
('182.67.89.107', 'DELHI', 'IN', '28.6358', '77.2244'),
('68.37.252.155', 'NEW JERSEY', 'US', '40.7282', '-74.0776');

-- --------------------------------------------------------

--
-- Table structure for table `ip_status`
--

CREATE TABLE IF NOT EXISTS `ip_status` (
  `ID` varchar(50) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '0',
  `Lookup` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ip_status`
--

INSERT INTO `ip_status` (`ID`, `Status`, `Lookup`) VALUES
('agarwal.lalit91', 2, 1),
('anand.mudgerikar', 2, 1),
('krs.sumeet', 2, 1),
('pranjan123', 0, 1),
('rssha9661', 0, 1),
('sagar.mohite77', 2, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
