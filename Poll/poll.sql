-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 19, 2020 at 04:38 AM
-- Server version: 5.7.19
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `poll`
--

-- --------------------------------------------------------

--
-- Table structure for table `login_access`
--

DROP TABLE IF EXISTS `login_access`;
CREATE TABLE IF NOT EXISTS `login_access` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `email_id` varchar(100) NOT NULL,
  `mobile` bigint(13) NOT NULL,
  `password` varchar(20) NOT NULL,
  `role` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_id` (`email_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_access`
--

INSERT INTO `login_access` (`id`, `email_id`, `mobile`, `password`, `role`) VALUES
(1, 'admin@gmail.com', 0, '12345', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mas_category`
--

DROP TABLE IF EXISTS `mas_category`;
CREATE TABLE IF NOT EXISTS `mas_category` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(200) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mas_category`
--

INSERT INTO `mas_category` (`id`, `category_name`, `status`) VALUES
(1, 'Sports', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mas_time`
--

DROP TABLE IF EXISTS `mas_time`;
CREATE TABLE IF NOT EXISTS `mas_time` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time_val` int(10) NOT NULL,
  `hr_min_sec` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mas_time`
--

INSERT INTO `mas_time` (`id`, `time_val`, `hr_min_sec`) VALUES
(1, 30, 'days');

-- --------------------------------------------------------

--
-- Table structure for table `poll_answers`
--

DROP TABLE IF EXISTS `poll_answers`;
CREATE TABLE IF NOT EXISTS `poll_answers` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `poll_id` int(10) NOT NULL,
  `poll_ans_img` varchar(100) NOT NULL,
  `poll_ans_text` text NOT NULL,
  `poll_vote` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `poll_description`
--

DROP TABLE IF EXISTS `poll_description`;
CREATE TABLE IF NOT EXISTS `poll_description` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `poll_id` int(10) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `poll_question`
--

DROP TABLE IF EXISTS `poll_question`;
CREATE TABLE IF NOT EXISTS `poll_question` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `category_id` int(10) NOT NULL,
  `poll_type` varchar(7) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description_type` varchar(7) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `from_date` datetime NOT NULL,
  `to_date` datetime NOT NULL,
  `status` int(1) NOT NULL,
  `single_multi` varchar(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `poll_vote`
--

DROP TABLE IF EXISTS `poll_vote`;
CREATE TABLE IF NOT EXISTS `poll_vote` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `poll_id` int(10) NOT NULL,
  `poll_ans_id` int(10) NOT NULL,
  `vote_by` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `report_poll`
--

DROP TABLE IF EXISTS `report_poll`;
CREATE TABLE IF NOT EXISTS `report_poll` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `poll_id` int(10) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `report` text NOT NULL,
  `report_date` datetime NOT NULL,
  `report_status` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

DROP TABLE IF EXISTS `user_details`;
CREATE TABLE IF NOT EXISTS `user_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email_id` varchar(100) NOT NULL,
  `username` int(6) NOT NULL,
  `name` varchar(200) NOT NULL,
  `prof_pic` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_id` (`email_id`),
  UNIQUE KEY `user_name` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`id`, `email_id`, `username`, `name`, `prof_pic`, `dob`, `status`) VALUES
(1, 'admin@gmail.com', 11111, 'Administrator', NULL, NULL, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
