-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 17. Sep 2021 um 09:01
-- Server-Version: 10.4.8-MariaDB
-- PHP-Version: 7.2.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `apprenticeship_reports`
--
CREATE DATABASE IF NOT EXISTS `apprenticeship_reports` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `apprenticeship_reports`;

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `getcoauthors`
-- (Siehe unten für die tatsächliche Ansicht)
--
DROP VIEW IF EXISTS `getcoauthors`;
CREATE TABLE `getcoauthors` (
`bookletid` bigint(20) unsigned
,`userid` bigint(20) unsigned
,`email` varchar(255)
,`firstname` varchar(255)
,`lastname` varchar(255)
,`occupation` varchar(255)
);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_apprentices`
--

DROP TABLE IF EXISTS `t_apprentices`;
CREATE TABLE `t_apprentices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `occupation` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `t_apprentices`
--

INSERT INTO `t_apprentices` (`id`, `email`, `firstname`, `lastname`, `occupation`, `password`) VALUES
(4, 'hans@peter.de', 'Hans', 'Peter', 'Fachinformatiker Anwendungsentwicklung', '597e1fa82f708f6c7b399938f58ca11cf785dd3a0943977b602b35c47a7e3ab8e9c4e67d7b0559ff0969e886bbd27aa9b393544550aafabbe2fd05b2b2741098'),
(5, 'Heinz@dieter.de', 'Heinz', 'Dieter', 'Fachinformatiker Systemintegration', '0dfa94c36719f0b67c07b3740ab3924fa37b6cd746543a5a1d47dd7f71eb42ed084531ba353943fa83e220ca8d77429e2ebf38e114f40950c4c00a493610cb7d'),
(6, 'Cute@katze.net', 'Kitty', 'Cute', 'Staadlich geprüfte Glas-vom-Tisch-schupserin', 'd836d65dfe8cc15b06dc1b22232b212717b75a6eaa10504624e0017d72596fab0101552ea1c7f4f59cef1880942ed35883630697294c5e488e1ab809bf629ef1');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_booklets`
--

DROP TABLE IF EXISTS `t_booklets`;
CREATE TABLE `t_booklets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `creationdate` date NOT NULL,
  `subject` varchar(255) NOT NULL,
  `id_creator` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `t_booklets`
--

INSERT INTO `t_booklets` (`id`, `creationdate`, `subject`, `id_creator`) VALUES
(10, '2021-09-17', 'Bericht', 4);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_categories`
--

DROP TABLE IF EXISTS `t_categories`;
CREATE TABLE `t_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `t_categories`
--

INSERT INTO `t_categories` (`id`, `description`) VALUES
(1, 'Meeting'),
(2, 'Projekt'),
(3, 'Berufsschule');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_memberof`
--

DROP TABLE IF EXISTS `t_memberof`;
CREATE TABLE `t_memberof` (
  `id_booklet` bigint(20) UNSIGNED NOT NULL,
  `id_apprentice` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `t_memberof`
--

INSERT INTO `t_memberof` (`id_booklet`, `id_apprentice`) VALUES
(10, 4),
(10, 6);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_reports`
--

DROP TABLE IF EXISTS `t_reports`;
CREATE TABLE `t_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reportdate` date NOT NULL,
  `creationdate` date NOT NULL,
  `id_author` bigint(20) UNSIGNED DEFAULT NULL,
  `id_booklet` bigint(20) UNSIGNED DEFAULT NULL,
  `id_category` bigint(20) UNSIGNED DEFAULT NULL,
  `description` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `t_reports`
--

INSERT INTO `t_reports` (`id`, `reportdate`, `creationdate`, `id_author`, `id_booklet`, `id_category`, `description`) VALUES
(27, '2021-09-17', '2021-09-17', 4, 10, 1, 'Heute habe ich Kuchen gegessen');

-- --------------------------------------------------------

--
-- Struktur des Views `getcoauthors`
--
DROP TABLE IF EXISTS `getcoauthors`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `getcoauthors`  AS  select `t_memberof`.`id_booklet` AS `bookletid`,`t_apprentices`.`id` AS `userid`,`t_apprentices`.`email` AS `email`,`t_apprentices`.`firstname` AS `firstname`,`t_apprentices`.`lastname` AS `lastname`,`t_apprentices`.`occupation` AS `occupation` from (`t_memberof` left join `t_apprentices` on(`t_memberof`.`id_apprentice` = `t_apprentices`.`id`)) ;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `t_apprentices`
--
ALTER TABLE `t_apprentices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indizes für die Tabelle `t_booklets`
--
ALTER TABLE `t_booklets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_creator` (`id_creator`);

--
-- Indizes für die Tabelle `t_categories`
--
ALTER TABLE `t_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indizes für die Tabelle `t_memberof`
--
ALTER TABLE `t_memberof`
  ADD UNIQUE KEY `id_booklet` (`id_booklet`,`id_apprentice`),
  ADD KEY `id_apprentice` (`id_apprentice`);

--
-- Indizes für die Tabelle `t_reports`
--
ALTER TABLE `t_reports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_author` (`id_author`),
  ADD KEY `id_booklet` (`id_booklet`),
  ADD KEY `id_category` (`id_category`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `t_apprentices`
--
ALTER TABLE `t_apprentices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `t_booklets`
--
ALTER TABLE `t_booklets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT für Tabelle `t_categories`
--
ALTER TABLE `t_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `t_reports`
--
ALTER TABLE `t_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `t_booklets`
--
ALTER TABLE `t_booklets`
  ADD CONSTRAINT `t_booklets_ibfk_1` FOREIGN KEY (`id_creator`) REFERENCES `t_apprentices` (`id`);

--
-- Constraints der Tabelle `t_memberof`
--
ALTER TABLE `t_memberof`
  ADD CONSTRAINT `t_memberof_ibfk_1` FOREIGN KEY (`id_booklet`) REFERENCES `t_booklets` (`id`),
  ADD CONSTRAINT `t_memberof_ibfk_2` FOREIGN KEY (`id_apprentice`) REFERENCES `t_apprentices` (`id`);

--
-- Constraints der Tabelle `t_reports`
--
ALTER TABLE `t_reports`
  ADD CONSTRAINT `t_reports_ibfk_1` FOREIGN KEY (`id_author`) REFERENCES `t_apprentices` (`id`),
  ADD CONSTRAINT `t_reports_ibfk_2` FOREIGN KEY (`id_booklet`) REFERENCES `t_booklets` (`id`),
  ADD CONSTRAINT `t_reports_ibfk_3` FOREIGN KEY (`id_category`) REFERENCES `t_categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
