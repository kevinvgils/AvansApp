-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 08 jun 2022 om 18:30
-- Serverversie: 10.4.24-MariaDB
-- PHP-versie: 8.1.6

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
-- Tabelstructuur voor tabel `answer`
--

CREATE TABLE `answer` (
  `answerId` int(11) NOT NULL,
  `answer` text NOT NULL,
  `questionId` int(11) NOT NULL,
  `isCorrect` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `answer`
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
-- Tabelstructuur voor tabel `course`
--

CREATE TABLE `course` (
  `courseId` int(11) NOT NULL,
  `courseName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `course`
--

INSERT INTO `course` (`courseId`, `courseName`) VALUES
(4, 'Informatica'),
(1, 'Technische Informatica');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `question`
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
-- Gegevens worden geëxporteerd voor tabel `question`
--

INSERT INTO `question` (`questionId`, `question`, `description`, `image`, `videoUrl`, `longitude`, `latitude`, `routeId`) VALUES
(3, 'Dit is de eerste vraag voor Technische Informatica', 'De eerste vraag voor informatica', NULL, NULL, '4.785294649261182', '51.58847188318798', 3),
(23, 'In welk jaar is Avans ontstaan?', 'Selecteer in welk jaar Avans hogeschool is ontstaan', NULL, NULL, '51.5891643', '4.7860003', 1),
(24, 'Hoeveel docenten in het trappenhuis behoren tot de opleiding Informatica', 'In het trappenhuis hangen foto’s van docenten. Hoeveel docenten hiervan zitten bij de opleiding Informatica?', NULL, NULL, '51.5874996', '4.7810686', 1),
(25, 'Waar kun je pizza scoren binnen de Avans locaties in Breda?', 'Selecteer de locatie waar je pizza\'s kunt scoren!', NULL, NULL, '51.5902832', '4.7872995094107', 1),
(26, 'Wie is de oudste docent?', 'Selecteer de oudste docent.', NULL, NULL, '51.58516', '4.797319', 1),
(27, 'Wie is de jongste docent?', 'Selecteer de jongste docent', NULL, NULL, NULL, NULL, 1),
(28, 'Welke docent heeft Biochemie gestudeerd?', 'Selecteer de docent die Biochemie heeft gestudeerd!', NULL, NULL, NULL, NULL, 1),
(29, 'Hoeveel opleidingen vallen er onder de ATiX academie?', 'De opleiding Informatica valt onder de academie ATiX. Hoeveel opleidingen vallen er onder deze academie?', NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `route`
--

CREATE TABLE `route` (
  `routeId` int(11) NOT NULL,
  `routeName` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `courseId` int(11) NOT NULL,
  `picture` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `route`
--

INSERT INTO `route` (`routeId`, `routeName`, `description`, `courseId`, `picture`) VALUES
(1, 'PuzzelTocht Informatica', 'Dit is een hele leuke tocht voor Technische informatica', 4, ''),
(3, 'Leuke tocht Technische Informatica', 'Dit is een hele leuke tocht voor informatica', 1, '');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `members` varchar(255) NOT NULL,
  `score` int(100) NOT NULL,
  `startTime` datetime NOT NULL,
  `endTime` datetime,
  `routeId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `team`
--

INSERT INTO `team` (`id`, `name`, `members`, `score`, `startTime`, `endTime`, `routeId`) VALUES
(10, 'De mannen', 'Bryan, Dimitri, Kevin, Mohammed, Thijs, Tim', 30, '2022-06-10 15:50:12', NULL, 1),
(11, 'De koters', 'Thijs', 0, '2022-06-08 16:48:46', '2022-06-08 17:25:41', 1),
(12, 'Biermannen', 'Bryan, Dimitri, Kevin, Thijs', 69, '2022-06-10 15:50:12', NULL, 1),
(13, 'Test team', 'Testuser1, Testuser2, SHEEEESH', 0, '2022-06-08 17:08:58', NULL, 1);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`answerId`),
  ADD KEY `FK_answer_question` (`questionId`);

--
-- Indexen voor tabel `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`courseId`),
  ADD UNIQUE KEY `UQ_course_name` (`courseName`);

--
-- Indexen voor tabel `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`questionId`),
  ADD KEY `FK_question_routeId` (`routeId`);

--
-- Indexen voor tabel `route`
--
ALTER TABLE `route`
  ADD PRIMARY KEY (`routeId`),
  ADD KEY `FK_route_courseId` (`courseId`);

--
-- Indexen voor tabel `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_team_routeId` (`routeId`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `answer`
--
ALTER TABLE `answer`
  MODIFY `answerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT voor een tabel `course`
--
ALTER TABLE `course`
  MODIFY `courseId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `question`
--
ALTER TABLE `question`
  MODIFY `questionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT voor een tabel `route`
--
ALTER TABLE `route`
  MODIFY `routeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT voor een tabel `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `FK_answer_question` FOREIGN KEY (`questionId`) REFERENCES `question` (`questionId`);

--
-- Beperkingen voor tabel `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `FK_question_routeId` FOREIGN KEY (`routeId`) REFERENCES `route` (`routeId`);

--
-- Beperkingen voor tabel `route`
--
ALTER TABLE `route`
  ADD CONSTRAINT `FK_route_courseId` FOREIGN KEY (`courseId`) REFERENCES `course` (`courseId`);

--
-- Beperkingen voor tabel `team`
--
ALTER TABLE `team`
  ADD CONSTRAINT `FK_team_routeId` FOREIGN KEY (`routeId`) REFERENCES `route` (`routeId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
