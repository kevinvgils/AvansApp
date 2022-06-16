-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2022 at 11:28 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

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
  `questionType` int(11) NOT NULL,
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

INSERT INTO `question` (`questionId`, `questionType`, `question`, `description`, `image`, `videoUrl`, `longitude`, `latitude`, `routeId`) VALUES
(3, 0, 'Dit is de eerste vraag voor Technische Informatica', 'De eerste vraag voor informatica', NULL, NULL, '4.785294649261182', '51.58847188318798', 3),
(23, 0, 'In welk jaar is Avans ontstaan?', 'Selecteer in welk jaar Avans hogeschool is ontstaan', NULL, NULL, '51.5891643', '4.7860003', 1),
(24, 0, 'Hoeveel docenten in het trappenhuis behoren tot de opleiding Informatica', 'In het trappenhuis hangen foto’s van docenten. Hoeveel docenten hiervan zitten bij de opleiding Informatica?', NULL, NULL, '51.5874996', '4.7810686', 1),
(25, 0, 'Waar kun je pizza scoren binnen de Avans locaties in Breda?', 'Selecteer de locatie waar je pizza\'s kunt scoren!', NULL, NULL, '51.5902832', '4.7872995094107', 1),
(26, 0, 'Wie is de oudste docent?', 'Selecteer de oudste docent.', NULL, NULL, '51.58516', '4.797319', 1),
(27, 0, 'Wie is de jongste docent?', 'Selecteer de jongste docent', NULL, NULL, NULL, NULL, 1),
(28, 0, 'Welke docent heeft Biochemie gestudeerd?', 'Selecteer de docent die Biochemie heeft gestudeerd!', NULL, NULL, NULL, NULL, 1),
(29, 0, 'Hoeveel opleidingen vallen er onder de ATiX academie?', 'De opleiding Informatica valt onder de academie ATiX. Hoeveel opleidingen vallen er onder deze academie?', NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `route`
--

CREATE TABLE `route` (
  `routeId` int(11) NOT NULL,
  `routeName` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `courseId` int(11) NOT NULL,
  `picture` longblob NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `route`
--

INSERT INTO `route` (`routeId`, `routeName`, `description`, `courseId`, `picture`, `isActive`) VALUES
(1, 'PuzzelTocht Informatica', 'Dit is een hele leuke tocht voor Technische informatica', 4, '', 0),
(3, 'Leuke tocht Technische Informatica', 'Dit is een hele leuke tocht voor informatica', 1, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `members` varchar(255) NOT NULL,
  `score` int(100) NOT NULL,
  `startTime` datetime NOT NULL,
  `endTime` datetime DEFAULT NULL,
  `routeId` int(11) NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `name`, `members`, `score`, `startTime`, `endTime`, `routeId`, `isActive`) VALUES
(10, 'De mannen', 'Bryan, Dimitri, Kevin, Mohammed, Thijs, Tim', 30, '2022-06-10 15:50:12', NULL, 1, 1),
(11, 'De koters', 'Thijs', 0, '2022-06-08 16:48:46', '2022-06-08 17:25:41', 1, 1),
(12, 'Biermannen', 'Bryan, Dimitri, Kevin, Thijs', 69, '2022-06-10 15:50:12', NULL, 1, 1),
(13, 'Test team', 'Testuser1, Testuser2, SHEEEESH', 0, '2022-06-08 17:08:58', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `team_questions`
--

CREATE TABLE `team_questions` (
  `id` int(11) NOT NULL,
  `teamId` int(11) NOT NULL,
  `questionId` int(11) NOT NULL,
  `multipleChoiceAnswer` text DEFAULT NULL,
  `imageAnswer` longblob DEFAULT NULL,
  `videoAnswer` longblob DEFAULT NULL,
  `openAnswer` text DEFAULT NULL,
  `correct` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_team_routeId` (`routeId`);

--
-- Indexes for table `team_questions`
--
ALTER TABLE `team_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questionRelation` (`questionId`),
  ADD KEY `teamRelation` (`teamId`);

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
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `team_questions`
--
ALTER TABLE `team_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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

--
-- Constraints for table `team`
--
ALTER TABLE `team`
  ADD CONSTRAINT `FK_team_routeId` FOREIGN KEY (`routeId`) REFERENCES `route` (`routeId`);

--
-- Constraints for table `team_questions`
--
ALTER TABLE `team_questions`
  ADD CONSTRAINT `questionRelation` FOREIGN KEY (`questionId`) REFERENCES `question` (`questionId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `teamRelation` FOREIGN KEY (`teamId`) REFERENCES `team` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;
