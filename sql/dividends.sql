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
-- Tabellenstruktur für Tabelle `dividends`
--

CREATE TABLE `dividends` (
  `id` int(11) NOT NULL,
  `symbol` text NOT NULL,
  `date` date NOT NULL,
  `dividend` decimal(10,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Stores all dividend payouts.';

--
-- Daten für Tabelle `dividends`
--

INSERT INTO `dividends` (`id`, `symbol`, `date`, `dividend`) VALUES
(129, 'DIS.MX', '2019-12-13', '0.8800'),
(179, 'BAC', '2019-12-05', '0.1800'),
(63, 'BP', '2019-11-07', '0.6150'),
(174, 'BAC', '2019-09-05', '0.1800'),
(66, 'BP', '2019-08-08', '0.6150'),
(133, 'DIS.MX', '2019-07-05', '0.8800'),
(247, 'BAC', '2019-06-06', '0.1500'),
(7, 'BP', '2019-05-09', '0.6150'),
(150, 'BAC', '2019-02-28', '0.1500'),
(4, 'BP', '2019-02-14', '0.6150'),
(127, 'DIS.MX', '2018-12-07', '0.8800'),
(193, 'BAC', '2018-12-06', '0.1500'),
(77, 'BP', '2018-11-08', '0.6150'),
(190, 'BAC', '2018-09-06', '0.1500'),
(20, 'BP', '2018-08-09', '0.6150'),
(132, 'DIS.MX', '2018-07-06', '0.8400'),
(239, 'BAC', '2018-05-31', '0.1200'),
(85, 'BP', '2018-05-10', '0.6000'),
(189, 'BAC', '2018-03-01', '0.1200'),
(82, 'BP', '2018-02-15', '0.6000'),
(126, 'DIS.MX', '2017-12-08', '0.8400'),
(183, 'BAC', '2017-11-30', '0.1200'),
(32, 'BP', '2017-11-09', '0.6000'),
(255, 'BAC', '2017-08-30', '0.1200'),
(95, 'BP', '2017-08-09', '0.6000');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `dividends`
--
ALTER TABLE `dividends`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `dividends`
--
ALTER TABLE `dividends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=287;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
