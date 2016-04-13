-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: 2016-04-13 09:20:29
-- 服务器版本： 5.5.42
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phyCSS`
--

-- --------------------------------------------------------

--
-- 表的结构 `assignment`
--

CREATE TABLE `assignment` (
  `number` int(20) NOT NULL,
  `number_display` varchar(255) DEFAULT NULL,
  `requi` text,
  `title` varchar(255) NOT NULL,
  `startTime` date NOT NULL,
  `endTime` date NOT NULL,
  `course` int(20) NOT NULL,
  `teacher` varchar(255) NOT NULL,
  `type` varchar(10) NOT NULL,
  `modify_time` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `assignment`
--

INSERT INTO `assignment` (`number`, `number_display`, `requi`, `title`, `startTime`, `endTime`, `course`, `teacher`, `type`, `modify_time`) VALUES
(1, 'PA0001', '测试', '作业1', '2016-04-22', '2016-04-30', 1, '141250001', 'pdf', '2016-04-07');

-- --------------------------------------------------------

--
-- 表的结构 `assignmentDis`
--

CREATE TABLE `assignmentDis` (
  `stdNumber` varchar(255) NOT NULL,
  `assNumber` int(20) NOT NULL,
  `cNumber` int(20) NOT NULL,
  `mark` tinyint(4) DEFAULT NULL,
  `comm` text,
  `url` varchar(255) DEFAULT NULL,
  `isSubmitted` tinyint(1) NOT NULL,
  `isExamined` tinyint(1) NOT NULL,
  `isWarning` tinyint(1) NOT NULL DEFAULT '0',
  `submitTime` date DEFAULT NULL,
  `submitName` varchar(255) DEFAULT NULL,
  `saveName` varchar(255) DEFAULT NULL,
  `saveType` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `course`
--

CREATE TABLE `course` (
  `number` int(20) NOT NULL,
  `number_display` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `time` varchar(50) NOT NULL,
  `teacher` varchar(255) NOT NULL,
  `teacher_name` varchar(255) NOT NULL,
  `depict` text,
  `selected` int(8) NOT NULL,
  `assignments` int(11) NOT NULL,
  `students` int(11) NOT NULL,
  `create_time` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `course`
--

INSERT INTO `course` (`number`, `number_display`, `title`, `time`, `teacher`, `teacher_name`, `depict`, `selected`, `assignments`, `students`, `create_time`) VALUES
(1, 'PC0001', 'test', '2016年 春季', '141250001', '陈睿', '测试一下', 0, 1, 100, '2016-04-07');

-- --------------------------------------------------------

--
-- 表的结构 `courseDis`
--

CREATE TABLE `courseDis` (
  `stdNumber` varchar(255) NOT NULL,
  `cNumber` int(20) NOT NULL,
  `add_time` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `feedback`
--

CREATE TABLE `feedback` (
  `number` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `permission` tinyint(1) NOT NULL,
  `content` text NOT NULL,
  `add_time` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `feedback`
--

INSERT INTO `feedback` (`number`, `name`, `permission`, `content`, `add_time`) VALUES
('t1', 't1', 1, 'test', '2016-03-27'),
('1402003', '孙寅', 3, '', '2016-03-27'),
('1402003', '孙寅', 3, '', '2016-03-27'),
('1402003', '孙寅', 3, '', '2016-03-27'),
('1402003', '孙寅', 3, '', '2016-03-27'),
('1402003', '孙寅', 3, '鼎折覆餗', '2016-03-27'),
('1402003', '孙寅', 3, 'dfd', '2016-03-27'),
('1402003', '孙寅', 3, '非常好', '2016-03-27');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `number` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `permission` tinyint(1) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `speciality` varchar(255) DEFAULT NULL,
  `academy` varchar(255) DEFAULT NULL,
  `grade` int(11) DEFAULT NULL,
  `save_time` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`number`, `password`, `email`, `phone`, `permission`, `name`, `speciality`, `academy`, `grade`, `save_time`) VALUES
('1402003', '99aff9b6171d44c79c99dcaa7424be5f', '1395314348@qq.com', '15261855293', 3, '孙寅', NULL, '哲学系', NULL, '2016-03-25'),
('141250001', '25d55ad283aa400af464c76d713c07ad', '1395314348@qq.com', '18362929116', 2, '陈睿', '考古学', '历史学院', NULL, '2016-04-07'),
('141250003', 'fcea920f7412b5da7be0cf42b8c93759', '1395314348@qq.com', '18362929116', 1, '陈丹妮', '考古学', '历史学院', 2012, '2016-04-07'),
('141250009', 'fcea920f7412b5da7be0cf42b8c93759', '1395314348@qq.com', '18362929116', 1, '成么', '考古学（文物鉴定）', '历史学院', 2011, '2016-04-07'),
('141250012', 'fcea920f7412b5da7be0cf42b8c93759', '1395314348@qq.com', '18362929116', 1, '陈睿', '考古学', '历史学院', 2011, '2016-04-07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignment`
--
ALTER TABLE `assignment`
  ADD PRIMARY KEY (`number`),
  ADD KEY `endTime` (`endTime`);

--
-- Indexes for table `assignmentDis`
--
ALTER TABLE `assignmentDis`
  ADD KEY `submitTime` (`submitTime`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`number`),
  ADD KEY `create_time` (`create_time`);

--
-- Indexes for table `courseDis`
--
ALTER TABLE `courseDis`
  ADD KEY `add_time` (`add_time`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignment`
--
ALTER TABLE `assignment`
  MODIFY `number` int(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `number` int(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
