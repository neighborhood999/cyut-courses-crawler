-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- 主機: 127.0.0.1
-- 產生時間： 2016-01-28: 13:58:52
-- 伺服器版本: 5.6.17
-- PHP 版本： 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 資料庫： `cyutcourse`
--

-- --------------------------------------------------------

--
-- 資料表結構 `ice`
--

CREATE TABLE IF NOT EXISTS `ice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` int(11) NOT NULL COMMENT '學年度',
  `semester` int(11) NOT NULL COMMENT '學期',
  `department` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT '系別',
  `grade` int(11) NOT NULL COMMENT '年級',
  `class` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT '班級',
  `lessonNumber` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT '課號',
  `lessonName` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT '課名',
  `lessonType` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT '課別',
  `period` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT '學年期',
  `courseCredit` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT '學分數',
  `speech` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT '演講',
  `design` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT '設計',
  `intern` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT '實習',
  `teacher` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT '授課老師',
  `courseClass` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT '開課班級',
  `remark` varchar(16) COLLATE utf8_unicode_ci NOT NULL COMMENT '備註',
  `studentLimit` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT '人數限制',
  `pitchNumber` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT '上課節數',
  `classroom` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT '教室地點',
  `time` int(11) NOT NULL COMMENT '上課時間',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
