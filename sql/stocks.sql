-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 23. Jan 2020 um 20:45
-- Server-Version: 10.4.8-MariaDB
-- PHP-Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `uni_project`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `stocks`
--

CREATE TABLE `stocks` (
  `Symbol` tinytext NOT NULL,
  `Name` text NOT NULL,
  `LastUpdated` timestamp NOT NULL DEFAULT current_timestamp(),
  `LastValue` decimal(10,4) DEFAULT NULL,
  `KGV` text NOT NULL,
  `yield` text NOT NULL,
  `payoutRatio` text NOT NULL,
  `clicks` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `stocks`
--

INSERT INTO `stocks` (`Symbol`, `Name`, `LastUpdated`, `LastValue`, `KGV`, `yield`, `payoutRatio`, `clicks`) VALUES
('BP', 'FOOO', '2020-01-23 19:30:30', '37.7800', '27.18', '2.46 (6.49%)', '175.29%', 1),
('AMD', 'ERROR', '2020-01-23 19:38:56', '51.3400', '269.95', 'N/A', '0.00%', 1),
('BAC', 'FOOO', '2020-01-23 19:40:36', '34.0900', '12.43', '0.72 (2.10%)', '24.00%', 1),
('DIS.MX', 'FOOO', '2020-01-23 19:32:14', '2668.0000', '402.00', '33.11 (1.23%)', '28.07%', 1);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`Symbol`(10));
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
