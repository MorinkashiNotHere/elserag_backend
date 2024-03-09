-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2024 at 08:05 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elserag`
--

-- --------------------------------------------------------

--
-- Table structure for table `aprogress`
--

CREATE TABLE `aprogress` (
  `learner_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aprogress`
--

INSERT INTO `aprogress` (`learner_id`, `lesson_id`) VALUES
(123, 1),
(123, 1),
(123, 3),
(123, 3);

-- --------------------------------------------------------

--
-- Table structure for table `caregiver`
--

CREATE TABLE `caregiver` (
  `user_id` int(250) NOT NULL,
  `password` text NOT NULL,
  `learner_id` int(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `caregiver`
--

INSERT INTO `caregiver` (`user_id`, `password`, `learner_id`) VALUES
(123, '$2y$10$/VpEKrJDXGA.n/N8xhcmNOCedupQY61nhGylGs.XDa2oWHJaREAs2', 123),
(5555, '', 5555);

-- --------------------------------------------------------

--
-- Table structure for table `care_edu`
--

CREATE TABLE `care_edu` (
  `educator_id` int(250) NOT NULL,
  `caregiver_id` int(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `care_edu`
--

INSERT INTO `care_edu` (`educator_id`, `caregiver_id`) VALUES
(123, 123),
(123, 5555);

-- --------------------------------------------------------

--
-- Table structure for table `cgroup`
--

CREATE TABLE `cgroup` (
  `group_id` int(250) NOT NULL,
  `caregiver_id` int(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cgroup`
--

INSERT INTO `cgroup` (`group_id`, `caregiver_id`) VALUES
(1, 123),
(1, 5555);

-- --------------------------------------------------------

--
-- Table structure for table `educator`
--

CREATE TABLE `educator` (
  `user_id` int(250) NOT NULL,
  `password` text NOT NULL,
  `SubjectSpecialization` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `educator`
--

INSERT INTO `educator` (`user_id`, `password`, `SubjectSpecialization`) VALUES
(123, '$2y$10$qkX0daxzttOsu/GDUOj1J.j1/BgvaOQjOR82ecfRXEKj1R0MJMftK', 'العربية'),
(1234, '', 'العربية');

-- --------------------------------------------------------

--
-- Table structure for table `eprogress`
--

CREATE TABLE `eprogress` (
  `learner_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `eprogress`
--

INSERT INTO `eprogress` (`learner_id`, `lesson_id`) VALUES
(123, 6),
(123, 6);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `Feedback ID` int(250) NOT NULL,
  `Type` varchar(256) NOT NULL,
  `Feedback_text` text NOT NULL,
  `user_id` int(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE `group` (
  `group_id` int(250) NOT NULL,
  `educator_id` int(250) NOT NULL,
  `material_id` int(250) NOT NULL,
  `complete` varchar(10) DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `group`
--

INSERT INTO `group` (`group_id`, `educator_id`, `material_id`, `complete`) VALUES
(1, 123, 1, 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `learner`
--

CREATE TABLE `learner` (
  `user_id` int(250) NOT NULL,
  `password` text NOT NULL,
  `points` int(250) NOT NULL,
  `Cdays` int(250) NOT NULL,
  `Agroup` varchar(10) NOT NULL DEFAULT 'no',
  `Egroup` varchar(10) NOT NULL DEFAULT 'no',
  `Ngroup` varchar(10) NOT NULL DEFAULT 'no',
  `Sgroup` varchar(10) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `learner`
--

INSERT INTO `learner` (`user_id`, `password`, `points`, `Cdays`, `Agroup`, `Egroup`, `Ngroup`, `Sgroup`) VALUES
(123, '$2y$10$vrWD5GGQ/W5VdH7LikB2DOUMtIlWsUXifu/F093rc8Mkg9bJy5DOi', 222, 20, 'yes', 'no', 'no', 'no'),
(1234, '', 0, 0, 'yes', 'no', 'no', 'no'),
(5555, '', 0, 0, 'yes', 'no', 'no', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `lesson`
--

CREATE TABLE `lesson` (
  `lesson_id` int(250) NOT NULL,
  `lesson_name` varchar(256) NOT NULL,
  `content` text NOT NULL,
  `course_id` int(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lesson`
--

INSERT INTO `lesson` (`lesson_id`, `lesson_name`, `content`, `course_id`) VALUES
(1, 'من حرف أ إلى ج', '', 1),
(2, 'من حرف خ إلى ص', '', 1),
(3, 'من حرف ض إلى ق', '', 1),
(4, 'من حرف ك إلى ي', '', 1),
(5, 'G إلى A من حرف ', '', 2),
(6, 'N إلى H من حرف ', '', 2),
(7, 'T إلى O من حرف ', '', 2),
(8, 'Z إلى U من حرف ', '', 2),
(9, 'من رقم 0 إلى رقم 9', '', 3),
(10, 'من رقم 10 إلى رقم 30', '', 3),
(11, 'من رقم 31 إلى رقم 40', '', 3),
(12, 'من رقم 40 و50 ومضاعفاتهم إلى  90', '', 3);

-- --------------------------------------------------------

--
-- Table structure for table `lgroup`
--

CREATE TABLE `lgroup` (
  `group_id` int(250) NOT NULL,
  `learner_id` int(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lgroup`
--

INSERT INTO `lgroup` (`group_id`, `learner_id`) VALUES
(1, 123),
(1, 1234),
(1, 5555);

-- --------------------------------------------------------

--
-- Table structure for table `material`
--

CREATE TABLE `material` (
  `material_id` int(250) NOT NULL,
  `Title` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `material`
--

INSERT INTO `material` (`material_id`, `Title`) VALUES
(1, 'العربية'),
(2, 'الإنجليزية'),
(3, 'الأرقام'),
(4, 'العلوم\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `nprogress`
--

CREATE TABLE `nprogress` (
  `learner_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nprogress`
--

INSERT INTO `nprogress` (`learner_id`, `lesson_id`) VALUES
(123, 10),
(123, 10);

-- --------------------------------------------------------

--
-- Table structure for table `upload_material`
--

CREATE TABLE `upload_material` (
  `material_id` int(250) NOT NULL,
  `educator_id` int(250) NOT NULL,
  `group_id` int(250) NOT NULL,
  `filename` varchar(200) NOT NULL,
  `filesize` int(11) NOT NULL,
  `filetype` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  `file_subject` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `caregiver`
--
ALTER TABLE `caregiver`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `educator`
--
ALTER TABLE `educator`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`Feedback ID`);

--
-- Indexes for table `group`
--
ALTER TABLE `group`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `learner`
--
ALTER TABLE `learner`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `lesson`
--
ALTER TABLE `lesson`
  ADD PRIMARY KEY (`lesson_id`);

--
-- Indexes for table `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`material_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `Feedback ID` int(250) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group`
--
ALTER TABLE `group`
  MODIFY `group_id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lesson`
--
ALTER TABLE `lesson`
  MODIFY `lesson_id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `material`
--
ALTER TABLE `material`
  MODIFY `material_id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
