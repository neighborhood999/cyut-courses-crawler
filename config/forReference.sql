-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- 主機: 127.0.0.1
-- 產生時間： 2016-03-22 02:20:35
-- 伺服器版本: 5.7.9
-- PHP 版本： 7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `cyutcourses`
--

-- --------------------------------------------------------

--
-- 資料表結構 `courses`
--

DROP TABLE IF EXISTS `courses`;
CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `department_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `year` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `department` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `grade` int(11) NOT NULL,
  `class` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lessonNumber` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lessonName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lessonType` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `period` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `courseCredit` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `speech` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `design` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `intern` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `teacher` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `courseClass` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remark` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `studentLimit` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pitchNumber` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `classroom` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
