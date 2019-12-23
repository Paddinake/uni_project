-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 23. Dez 2019 um 14:09
-- Server-Version: 10.4.10-MariaDB
-- PHP-Version: 7.3.12

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
-- Tabellenstruktur für Tabelle `dividends`
--

CREATE TABLE `dividends` (
  `Symbol` tinytext NOT NULL,
  `Date` date NOT NULL,
  `Dividend` decimal(10,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Saves dividend history for a single stock.';

--
-- Daten für Tabelle `dividends`
--

INSERT INTO `dividends` (`Symbol`, `Date`, `Dividend`) VALUES
('SKT', '2005-07-27', '0.3225'),
('SKT2', '2005-07-28', '0.3225'),
('SKT3', '2005-07-29', '0.3225');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `stocks`
--

CREATE TABLE `stocks` (
  `Symbol` tinytext NOT NULL,
  `Name` text NOT NULL,
  `LastUpdated` timestamp NOT NULL DEFAULT current_timestamp(),
  `LastValue` decimal(10,4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `stocks`
--

INSERT INTO `stocks` (`Symbol`, `Name`, `LastUpdated`, `LastValue`) VALUES
('AAPL', 'Apple Inc.', '2019-12-23 11:27:50', '279.4400');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `dividends`
--
ALTER TABLE `dividends`
  ADD PRIMARY KEY (`Symbol`(10));

--
-- Indizes für die Tabelle `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`Symbol`(10));
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
