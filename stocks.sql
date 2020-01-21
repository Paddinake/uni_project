-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 21. Jan 2020 um 16:22
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
('MSFT', 'FOOO', '2020-01-21 14:43:06', '166.6800', '31.50', '2.04 (1.22%)', '34.72%', 3),
('SBUX', 'FOOO', '2020-01-21 14:24:07', '92.9300', '32.06', '1.64 (1.75%)', '49.32%', 3),
('AMD', 'ERROR', '2020-01-21 14:20:31', '50.2000', '266.65', 'N/A', '0.00%', 2),
('RDS-A', 'FOOO', '2020-01-21 15:13:42', '57.8800', '11.50', '3.76 (6.42%)', '74.90%', 2),
('SIE.DE', 'FOOO', '2020-01-21 14:35:25', '116.5400', '18.53', '3.90 (3.33%)', '60.13%', 2),
('BP', 'FOOO', '2020-01-21 15:11:55', '38.5000', '27.42', '2.46 (6.35%)', '175.29%', 1),
('FB', 'ERROR', '2020-01-21 14:54:13', '222.1500', '35.19', 'N/A', '0.00%', 1),
('AMZN', 'ERROR', '2020-01-21 14:31:14', '1885.8900', '82.63', 'N/A', '0.00%', 1),
('GOOG', 'ERROR', '2020-01-21 14:29:14', '1462.9100', '31.77', 'N/A', '0.00%', 1),
('PLUG', 'ERROR', '2020-01-21 15:18:21', '4.2000', '0', '0', '0', 1),
('GOOGL', 'ERROR', '2020-01-21 14:27:47', '1462.5400', '31.75', 'N/A', '0.00%', 1),
('ALV.DE', 'FOOO', '2020-01-21 15:20:43', '220.9000', '12.76', '9.00 (4.06%)', '49.10%', 1),
('BEI.DE', 'FOOO', '2020-01-21 15:09:46', '106.1000', '32.41', '0.70 (0.66%)', '21.47%', 1),
('BMW.DE', 'FOOO', '2020-01-21 14:33:07', '71.3900', '6.62', '3.50 (4.93%)', '46.53%', 1),
('CBK.DE', 'FOOO', '2020-01-21 14:39:29', '5.1300', '8.13', '0.20 (3.87%)', '0.00%', 1),
('FME.DE', 'FOOO', '2020-01-21 15:07:41', '69.2000', '16.59', '1.17 (1.70%)', '27.84%', 1),
('SAP.DE', 'FOOO', '2020-01-21 14:56:07', '125.1200', '44.16', '1.50 (1.19%)', '52.82%', 1),
('BAYN.DE', 'ERROR', '2020-01-21 15:02:22', '75.3000', '0', '0', '0', 1),
('VOW3.DE', 'FOOO', '2020-01-21 15:16:36', '180.6000', '6.83', '4.86 (2.68%)', '18.24%', 1);

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
