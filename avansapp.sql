-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 30 mei 2022 om 16:44
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
-- Tabelstructuur voor tabel ` educations`
--

CREATE TABLE ` educations` (
  `id` int(11) NOT NULL,
  `name` varchar(65) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel ` educations`
--

INSERT INTO ` educations` (`id`, `name`) VALUES
(1, 'BiM'),
(2, 'Ti'),
(3, 'Informatica');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `routename`
--

CREATE TABLE `routename` (
  `id` int(11) NOT NULL,
  `routeName` varchar(50) NOT NULL,
  `education` varchar(65) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `routename`
--

INSERT INTO `routename` (`id`, `routeName`, `education`) VALUES
(1, 'eerste test route', ''),
(2, 'Tweede test route', '');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel ` educations`
--
ALTER TABLE ` educations`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `routename`
--
ALTER TABLE `routename`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel ` educations`
--
ALTER TABLE ` educations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `routename`
--
ALTER TABLE `routename`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
