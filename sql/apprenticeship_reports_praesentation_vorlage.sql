-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 16. Jun 2021 um 19:23
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

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_apprentices`
--

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
(1, 'hans@peter.de', 'Hans', 'Peter', 'Fachinformatiker Anwendungsentwicklung', '1234'),
(2, 'Heinz@dieter.de', 'Heinz', 'Dieter', 'Fachinformatiker Systemintegration', '5678');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_booklets`
--

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
(1, '2021-08-01', 'SuperInnovativeDEVS', 1),
(2, '2021-08-01', 'TheBestITSupportGuys', 2),
(3, '2021-08-05', 'Zusammenarbeit IT & DEV', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_categories`
--

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

CREATE TABLE `t_memberof` (
  `id_booklet` bigint(20) UNSIGNED NOT NULL,
  `id_apprentice` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `t_memberof`
--

INSERT INTO `t_memberof` (`id_booklet`, `id_apprentice`) VALUES
(3, 2),
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `t_reports`
--

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
(1, '2021-08-01', '2021-08-01', 1, 1, 1, 'Liebes Berichtsheft, heute war mein erster Tag bei SuperInnovativeDEVS. In diesem Meeting wurden mir alle vorgestellt und alle hatten sich ganz doll lieb.'),
(2, '2021-08-02', '2021-08-03', 1, 1, 2, 'Liebes Berichtsheft, Es tut mir leid, dass ich gestern vergessen hab in dich reinzuschreiben. Deshalb hole ich das heute nach. Heute hab ich \"Hallo Welt\" in Assemblersprache programmiert. Das war komisch.'),
(3, '2021-08-02', '2021-08-03', 2, 3, 2, 'Liebes Berichtsheft, Heute habe ich zum ersten Mal mit Hans Peter von SuperInnovativeDEVS zusammengearbeitet. Das war toll.'),
(19, '2021-08-01', '2021-06-16', 2, 2, 1, 'Liebes Berichtsheft, heute war mein erster Tag bei TheBestITSupportGuys. Es war einfach genial! Wir sind alle voll die NERDS.');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `t_apprentices`
--
ALTER TABLE `t_apprentices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

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
  ADD KEY `id_booklet` (`id_booklet`),
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `t_booklets`
--
ALTER TABLE `t_booklets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT für Tabelle `t_categories`
--
ALTER TABLE `t_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `t_reports`
--
ALTER TABLE `t_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
