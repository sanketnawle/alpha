-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2013 at 09:49 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `fullcalendar`
--
CREATE DATABASE IF NOT EXISTS `fullcalendar` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `fullcalendar`;

-- --------------------------------------------------------

--
-- Table structure for table `course_event`
--

CREATE TABLE IF NOT EXISTS `course_event` (
  `eventid` bigint(20) NOT NULL AUTO_INCREMENT,
  `cid` bigint(20) NOT NULL,
  `profid` bigint(20) NOT NULL,
  `title` varchar(30) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `allday` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT 'false',
  PRIMARY KEY (`eventid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `course_event`
--

INSERT INTO `course_event` (`eventid`, `cid`, `profid`, `title`, `start`, `end`, `allday`) VALUES
(1, 1, 1, 'Homework Submission', '2013-11-13 21:00:00', '2013-11-13 23:00:00', 'false'),
(2, 1, 1, 'Exam', '2013-11-15 16:00:00', '2013-11-15 20:00:00', 'false');

-- --------------------------------------------------------

--
-- Table structure for table `evenement`
--

CREATE TABLE IF NOT EXISTS `evenement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_bin NOT NULL,
  `allday` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT 'false',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=7 ;

--
-- Dumping data for table `evenement`
--

INSERT INTO `evenement` (`id`, `title`, `start`, `end`, `url`, `allday`) VALUES
(1, 'nyu garbha', '2013-10-05 19:00:00', '2013-10-05 23:00:00', 'www.nyu.edu', 'false'),
(2, 'Java Class', '2013-10-08 18:00:00', '2013-10-08 20:30:00', 'www.poly.edu', 'false'),
(3, 'Software Engineering Class', '2013-10-11 18:00:00', '2013-10-11 20:30:00', 'http://www.poly.edu', 'false'),
(4, 'SE Midterm', '2013-10-23 18:00:00', '2013-10-23 20:30:00', '', 'false'),
(5, 'Operating System Class', '2013-10-24 18:00:00', '2013-10-24 20:30:00', '', 'false'),
(6, 'Exam', '2013-10-25 13:00:00', '2013-10-25 15:30:00', '', 'false');

-- --------------------------------------------------------

--
-- Table structure for table `group_event`
--

CREATE TABLE IF NOT EXISTS `group_event` (
  `eventid` bigint(20) NOT NULL AUTO_INCREMENT,
  `s_id` bigint(20) NOT NULL,
  `groupid` bigint(20) NOT NULL,
  `title` text NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  PRIMARY KEY (`eventid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `group_event`
--

INSERT INTO `group_event` (`eventid`, `s_id`, `groupid`, `title`, `start`, `end`) VALUES
(1, 1, 1, 'GISA Rubaroo', '2013-11-21 18:00:00', '2013-11-21 20:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `personal_event`
--

CREATE TABLE IF NOT EXISTS `personal_event` (
  `eventid` bigint(20) NOT NULL,
  `s_id` bigint(20) NOT NULL,
  `title` text NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `allday` varchar(255) NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
