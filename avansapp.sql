-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2022 at 11:56 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `avansapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE `answer` (
  `answerId` int(11) NOT NULL,
  `answer` text NOT NULL,
  `questionId` int(11) NOT NULL,
  `isCorrect` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `answer`
--

INSERT INTO `answer` (`answerId`, `answer`, `questionId`, `isCorrect`) VALUES
(11, '2000', 23, NULL),
(12, '2002', 23, NULL),
(13, '2004', 23, 1),
(14, '2006', 23, NULL),
(15, '3', 24, NULL),
(16, '6', 24, 1),
(17, '8', 24, NULL),
(18, '12', 24, NULL),
(19, 'Lovensedijkstraat', 25, NULL),
(20, 'Hogeschoollaan', 25, 1),
(21, 'Beukenlaan', 25, NULL),
(22, 'Onderwijsboulevard', 25, NULL),
(23, 'Pascal', 26, NULL),
(24, 'Erik', 26, NULL),
(25, 'Erco', 26, NULL),
(26, 'Ger', 26, 1),
(27, 'Nina', 27, NULL),
(28, 'Eefje', 27, NULL),
(29, 'Peter', 27, NULL),
(30, 'Frouke', 27, 1),
(31, 'Arno', 28, NULL),
(32, 'Dion', 28, NULL),
(33, 'Erik', 28, 1),
(34, 'Gitta', 28, NULL),
(35, '6', 29, NULL),
(36, '7', 29, NULL),
(37, '8', 29, 1),
(38, '9', 29, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `courseId` int(11) NOT NULL,
  `courseName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`courseId`, `courseName`) VALUES
(4, 'Informatica'),
(1, 'Technische Informatica');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `questionId` int(11) NOT NULL,
  `question` text NOT NULL,
  `description` text NOT NULL,
  `image` longblob DEFAULT NULL,
  `videoUrl` text DEFAULT NULL,
  `longitude` varchar(30) DEFAULT NULL,
  `latitude` varchar(30) DEFAULT NULL,
  `routeId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`questionId`, `question`, `description`, `image`, `videoUrl`, `longitude`, `latitude`, `routeId`) VALUES
(3, 'Dit is de eerste vraag voor Technische Informatica', 'De eerste vraag voor informatica', NULL, NULL, '4.785294649261182', '51.58847188318798', 3),
(23, 'In welk jaar is Avans ontstaan?', 'Selecteer in welk jaar Avans hogeschool is ontstaan', NULL, NULL, NULL, NULL, 1),
(24, 'Hoeveel docenten in het trappenhuis behoren tot de opleiding Informatica', 'In het trappenhuis hangen foto’s van docenten. Hoeveel docenten hiervan zitten bij de opleiding Informatica?', NULL, NULL, NULL, NULL, 1),
(25, 'Waar kun je pizza scoren binnen de Avans locaties in Breda?', 'Selecteer de locatie waar je pizza\'s kunt scoren!', NULL, NULL, NULL, NULL, 1),
(26, 'Wie is de oudste docent?', 'Selecteer de oudste docent.', NULL, NULL, NULL, NULL, 1),
(27, 'Wie is de jongste docent?', 'Selecteer de jongste docent', NULL, NULL, NULL, NULL, 1),
(28, 'Welke docent heeft Biochemie gestudeerd?', 'Selecteer de docent die Biochemie heeft gestudeerd!', NULL, NULL, NULL, NULL, 1),
(29, 'Hoeveel opleidingen vallen er onder de ATiX academie?', 'De opleiding Informatica valt onder de academie ATiX. Hoeveel opleidingen vallen er onder deze academie?', NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `route`
--

CREATE TABLE `route` (
  `routeId` int(11) NOT NULL,
  `routeName` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `courseId` int(11) NOT NULL,
  `picture` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `route`
--

INSERT INTO `route` (`routeId`, `routeName`, `description`, `courseId`, `picture`) VALUES
(1, 'PuzzelTocht Informatica', 'Dit is een hele leuke tocht voor Technische informatica', 4, ''),
(3, 'Leuke tocht Technische Informatica', 'Dit is een hele leuke tocht voor informatica', 1, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`answerId`),
  ADD KEY `FK_answer_question` (`questionId`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`courseId`),
  ADD UNIQUE KEY `UQ_course_name` (`courseName`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`questionId`),
  ADD KEY `FK_question_routeId` (`routeId`);

--
-- Indexes for table `route`
--
ALTER TABLE `route`
  ADD PRIMARY KEY (`routeId`),
  ADD KEY `FK_route_courseId` (`courseId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answer`
--
ALTER TABLE `answer`
  MODIFY `answerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `courseId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `questionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `route`
--
ALTER TABLE `route`
  MODIFY `routeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `FK_answer_question` FOREIGN KEY (`questionId`) REFERENCES `question` (`questionId`);

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `FK_question_routeId` FOREIGN KEY (`routeId`) REFERENCES `route` (`routeId`);

--
-- Constraints for table `route`
--
ALTER TABLE `route`
  ADD CONSTRAINT `FK_route_courseId` FOREIGN KEY (`courseId`) REFERENCES `course` (`courseId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
