-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 13 jun 2022 om 15:15
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
  `picture` longblob NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `route`
--

INSERT INTO `route` (`routeId`, `routeName`, `description`, `courseId`, `picture`, `isActive`) VALUES
(1, 'PuzzelTocht Informatica', 'Dit is een hele leuke tocht voor Technische informatica', 4, '', 1),
(3, 'Leuke tocht Technische Informatica', 'Dit is een hele leuke tocht voor informatica', 1, '', 1),
(11, 'route 15', 'e', 4, 0x89504e470d0a1a0a0000000d49484452000000e1000000e10803000000096d224800000180504c5445ffffff34a853fbbc044285f4ea43351a73e8fbb800fbba00ffbd00fbbd00006de72ea64f006be70069e73e83f41ba34425a449fcc2002d7cf3e9311ee9362517a2423981f42a7af34889f40074efbed2fb2779e94788f5ea3f304183f75690f533aa4240ad5de93536f4faf68eca9cfef5dfe8f4eb4cb066f2f7feabc6f5f6f9ff83abf7e9f0fed1dffcf7c1be91b4f8f33f1ef5b2aef39d974997c9a0d2acbbdec3cfe8d5e92a13feeac273a1f6fef0d07ec38efdd8885eb573f07638f8ccc9fbc437fcc94efde1a5fcd06c13a758b6dcbfdce8fb97b9f35c92ecc7d8fbaac5fa5f67c5916cadfce6e5ae6492eb4f43ce596cf08982e0514f5e7ad57e78c3a16da5c167863e9ca7d558644990dff63f149470aeb8658d47a887ee6e664179e04c9cc149a49bbab3d7f1846e498ee6ed613240a874f7a100489eaff49425ef7972f18133ec563b4b9bc3f9b01f42a877f49233ed6055fcd57e3ba1897db6c6ef6f3697c686b8c775d5c14465af5389b249afb73fe5bc21f9be7a9ab54abcb8392af3ec7200000a9849444154789ced9ded77dbb6158745499125cba2553aa63429b262394ee4c8aad22e4da23a59ec78b19d6e699a756bba9776cdd6acebea75afdddaaddbfef511a228f1052070010320593ee7f4f4b41f78fc1c5cfcee0544d985424e4e4e4e4e4e4e4e4ece7789e1c9b8b3773a419c9eee75c6fbba7fa00b64ffc9e9b4bdda6834d6d6565dd6d69cff6a74cf267be39bba7f3a51f6f7a6dd466375f5120e47b5b1da9ea4d8723ce936d6f0727ecfc6da59278d9227a3d506d56e4ed7b6a66993dceb32eb3982ed52c9b4ecd189ee9f9a99e1a4b1c6ace7e008226cabff44f78fcec4fe88bef7708225b490ed8eee1f9fca700428cf9020c2ba9270c753e0fa5dba54ba520a62f5c7ba2dc83ce982f61fa2db2e85315ba384e6ea70da80fae10451e6d8892cd50e617289052b8822679abc65e45840a2e06c1913d6394eba1c0b1823e8d03ad52de5678f67012fb5c3311ac43a4b4ea54eb804bbf1824ea5b69372883ce3138cadd119a6958cd6d80737c119744154a909681b37b9328651d0517c27e3824ea46a56e415a4854c7256915330326ec7aea2cebd78c62748ed13a155d437de4cf95294a14f04302d5df71b6ffee87b5c864041849ee9e6f5bbb77ecca3c821689fe9107cba512edf7ab7a542d0d98a130d86cf7a6547f13da820284697b4d4a7cdf3cb65c4e59ffc1a54a9d094f1306dd553f8c38db24baffc3e4011d827fc8a7dc586bdb2470f92379c2b88503cdbcc6bd4e5d6bbac8a02828ea2ca3a7d78b7ec87356f84044be654a1e1b35ec0d0c99b2ec3320af995944e6f6f6c9443f49ed1f3863f653cdaca0c7b614194373fa528f2f609ff22aa0a9b372f470d9dcdf8b3784571416704576418a9d1b9e20792054bd68b6b4a04f14be8b0f121396f2e4270ebfb579b3b2a0c49824ea43e238d70c22183047f7ed568de5620f806d9b0dcebe1f3463c46d1d866d40dc3506048f6438abff82546d18d51d3b62d8796f38f6dc205b76e20c1f5b7a40b3e24e4cc226f7e153932cedeb5b0adfea4333ed91f0ef7c79dd3a96dd930c3ad8f9a8ea051bf21ddf0634c330c2abed70da78c69b7a69d61f039e349c902ac64ebc55563c6e675c9824fef5204a347c6b66d4db04373a76f31afe0277341a329bb61c4e5cc6233f6fc235ca9351a929ed6b9c256ab2846174836fc0bad48678abe2363b71f7b1538612955f3d37a7d21b87e47aae0534ace782c8e8cab23ca13c7f45c35afdc580a1a75b965ca52a4aea27b645cdba33e72bf4dabd4ad3f350d1f4da986d4245d303b3236584e7437fbf18aad9757fd8292d3949ea40b7ae5f71b8c9fa9f4e30ad5fa7d5050eee4466bf741c5bbbf617cec30c6d019b7838246fd814443e2b1026bf85be6e79eb488829f8605e56e44a65ee1f10af0e05342ef37dbdbf588a1cc7e0111bc750ff264c256dcfa5d332268341fcbf263ee86b31a3d063d1a5fa75b2fd7a38246fd40925fa1f03afb361c7cb60b7bf614b38891189d1b6ecbd12b408266f0f911f0d927d19d188d516f234ab143fc81751f0ebea8bd0d7df859781103e376d0505acf0f5f7513f9eab543f0c39f8416717e6b81359416a6ac13cd796de53efce94143d3c4c5a8ec306535acd42ac09c4104b3667e6b81379435b731368bc197b5e20ac7e3dff10fe0d60bd2263424b60bb6a974f0f96bc522344911635f996efd314650de64ca6438f8c211e4d98685e1720dc9312ad790a5e10fbe72048b95473ccf37bd8d689ed54931ea1acaba526439e09f23c1620534937a789f6d046f2d7086b2861a16c34a6d6608eef708afe7c7c5a86e4314a3c286d6cbd84d88d066388b515143eb13aaa036c3c19fe7829cfbb01f3b6e27a04a073ff00439b3b464a25b8b667ccacc0c656529a55bbc5a08f2f743ecad853a434ac72fd69686b003be0b3a21862e7f4986b23a7eec5ceac5a84b8de3f17b76698b1ea3da0c079ff9058b3c678b914db8b5881aca9abc630c9731ca1f35364b8cce90f71922f17c381bb7031c821f3e6ec58fdb7e4369f7fac42c7d1516e428d3519b786b113194f6ba02e9cafbbc560b1baefc15f8eca145beb50823ef9ee639c1f0cb88a0b388c0b797267f63169478d786bf2f1de004a12d713feed62252a592fc0843cd62dc16da897f07084a7ca706d72ea231ca13a7d7719f4f100de57d6e81f9ecc9bdb5c02f22fb70bac3be070db91f0247c3f49c28083943516e2d42c8fcfcf0796423aee05266a1c878107e005a42635de24ba6e1a8c1c72854f11f3041a92fef85de6a23c5284cf19f3041c96fb695fd1b313c6e63156923f8eed74041c9af98faa71adfad459ce251ecae79f42dd0cf3036a5beebed3fe647c76d2c2b31cbb87bb4021694fa3a4d2170bc28c6a78c6f198b78c7dde34af51bb0a1ec97d9171f74d36234e4783f3cc3eddc3bacac54fff543b0a1bcb1dbc5eb17a15b0b865a2d1e3f7a7baeb97beffe91f33f8ad57fc305e5bfe8bdc11ca35149c4fcdfe87f54bf860b2af8c6c52c4dd9629442f55b0e41f96fb2bb69ca18a3f182450e3fe9498a709afe39738cc619c263d450f28d12f4e905244689821c318a902fe8b4c40b11e488514345ce20fe731182ffe35b419907a725bb157141ae1855f0859939472ba2825c316aa868152ee28bb8cd2728f30a2a88e022f2f509854b28ba88d5fff26d4265bb10712cb088bc31aa2a485d041691374655f5428ffbbc8a55f8adc51c89efaf63e1eefadbbc869b0a26523ff7f816913b46951c2a8270750cee18957f791185276c38c76d84da9871790456e4bab570511d332e875041ee3ea1729af103ac53ee71dbd053a308589df2c7a88a5f15410092a7bcb71608f539eab1cb6e2810a3c6babc6f545261eefb0231aaa1d7fb396653148951a3aef04881814df0709b5f7053eeefc1a0c2d4320462d458d7d4289630b40c1141bd9bd085ba1505c66ded9bd08532bdf1df5a18fa37a14bfc56148a51fd9bd025ae2bf2df5a383495dd8fd288bbb5d9e617d47364c2431c50abdf80dec90ba2e7c84480242812a39b1ac7d128f8b4118a519537dc2ce0d24664dc4e44ab0f124d1bb171db4842ab0f124e9baa488c262b653c22312a2298a894f108a68dc8ad45e252c6c39f3622b716094c198f65da88c568220e1478bcb4118ad1841c2808d4e6312ae0a7f56a8d8e9b3642319a9c03051e74a92114a3faeeb75939ae088ddb1aefb799298a8cdbca3fcbe66117f245bb30496df541dedae4164cfe267439807ecf6781ca778284807d9d70491a36a10be83baf4b92de09fd706dc5b46c42179ead98c8432f19965fa41324d9e36814f0564cee9990c46da06282cf8424602d23d1674202a03a4d53a358f2985d31499fc14078c05ca769ac5104739da6e3448183b14eeb4abe902607b63a4d6b8d2298ea349d39ea719b613e55f3f7f0a4419f4fd3368f86b9433b47a56f1e0d430b9b949d993050c246dd570ae5712d366c5273f714c34edc4e4cef34e3276e11b3b084b1bf8c4dd7f7282e1af2226663099d3825ed44c97fe84f2107849e98fe5ee87107df13d33fce2cc1df4a49fe7b9b4a798ccb9ab45ece60d9c19569565a850b2e6bb29333084cd664296710d13594f8570cb5102dd3945f5e44889469d68ab450882c616a3eb367255ca6727f0ba90e42659abd222d1482634dd69214112cd3ac9c0cfd04ca348b451a6cfa592cd242e19a4f316beddec57799918d4bc428cb17a5b29833881def4faa25f33b3f17c1f5edf57abddedcccd4d137c4e3830707b73375f2cdc9c9c9c9c9c9c9c9c9c9f96ef07fca1f7c001a66d48f0000000049454e44ae426082, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `members` varchar(255) NOT NULL,
  `score` int(100) NOT NULL,
  `time` datetime NOT NULL,
  `routeId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `team`
--

INSERT INTO `team` (`id`, `name`, `members`, `score`, `time`, `routeId`) VALUES
(10, 'bert', 'a, v, da, e, a, d', 0, '2022-06-08 12:09:12', 1),
(11, 'Hutsers', 'Bryan,Dimitri,Thijs,Tim,Kevin,Mohammed,', 0, '2022-06-08 16:48:46', 1),
(12, 'test', 'test,', 0, '2022-06-08 17:08:58', 1),
(13, 'bert', '', 0, '2022-06-13 14:14:28', 1);

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
  MODIFY `routeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT voor een tabel `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
