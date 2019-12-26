-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 26. Dez 2019 um 20:05
-- Server-Version: 10.4.6-MariaDB
-- PHP-Version: 7.1.32

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
-- Tabellenstruktur für Tabelle `bereich`
--

CREATE TABLE `bereich` (
  `b_id` int(10) NOT NULL,
  `b_name` varchar(300) COLLATE utf8_german2_ci NOT NULL,
  `b_inhalt` varchar(500) CHARACTER SET utf16 COLLATE utf16_german2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

--
-- Daten für Tabelle `bereich`
--

INSERT INTO `bereich` (`b_id`, `b_name`, `b_inhalt`) VALUES
(1, 'tets kategorie', 'das ist hier zum testen da'),
(2, 'weiterer test', 'ein weiteren test amcenen'),
(3, '234', 'kann ich das sehen'),
(4, 'haha ', 'hahahha ah sadfk s sdanndfs  isdfjn dfs'),
(5, 'haha', 'von 2'),
(12, 'admin', 'admin'),
(13, 'von 2', 'con 2'),
(14, '12', '12'),
(15, 'Peter', 'Enis'),
(16, 'admin', 'admin ');

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
(1, 'SKT', '2005-07-27', '0.3225'),
(2, 'SKT', '2009-07-28', '0.3825'),
(3, 'SKT', '2015-12-29', '0.2100'),
(4, 'SKT', '1996-10-23', '0.5200'),
(5, 'SKT', '1997-04-23', '0.5500'),
(6, 'SKT', '2013-07-26', '0.2250'),
(7, 'SKT', '2009-04-28', '0.3825'),
(8, 'SKT', '2014-01-28', '0.2250'),
(9, 'SKT', '2000-10-27', '0.6076'),
(10, 'SKT', '2001-04-26', '0.6100'),
(11, 'SKT', '2017-07-27', '0.3425'),
(12, 'SKT', '2013-04-26', '0.2250'),
(13, 'SKT', '2018-01-30', '0.3425'),
(14, 'SKT', '2014-06-05', '0.0000'),
(15, 'SKT', '2004-10-27', '0.6250'),
(16, 'SKT', '2005-04-27', '0.3225'),
(17, 'SKT', '2017-04-26', '0.3425'),
(18, 'SKT', '2008-10-29', '0.3800'),
(19, 'SKT', '2012-10-26', '0.2100'),
(20, 'SKT', '1993-12-13', '0.1050'),
(21, 'SKT', '1995-10-25', '0.5000'),
(22, 'SKT', '2016-10-27', '0.3250'),
(23, 'SKT', '1999-10-27', '0.6050'),
(24, 'SKT', '2003-10-29', '0.6150'),
(25, 'SKT', '2003-07-29', '0.6150'),
(26, 'SKT', '2014-06-11', '0.0000'),
(27, 'SKT', '2007-07-27', '0.3600'),
(28, 'SKT', '1994-10-24', '0.4600'),
(29, 'SKT', '2011-07-27', '0.2000'),
(30, 'SKT', '2007-04-26', '0.3600'),
(31, 'SKT', '1998-10-28', '0.6000'),
(32, 'SKT', '1999-04-28', '0.6050'),
(33, 'SKT', '2015-07-28', '0.2850'),
(34, 'SKT', '2011-04-27', '0.2000'),
(35, 'SKT', '2016-01-27', '0.2850'),
(36, 'SKT', '2002-10-29', '0.6126'),
(37, 'SKT', '2003-04-28', '0.6150'),
(38, 'SKT', '2019-07-30', '0.3550'),
(39, 'SKT', '2015-04-28', '0.2850'),
(40, 'SKT', '2006-10-27', '0.3400'),
(41, 'SKT', '2002-01-29', '0.6100'),
(42, 'SKT', '2019-04-29', '0.3550'),
(43, 'SKT', '2010-10-27', '0.3875'),
(44, 'SKT', '2006-01-27', '0.3225'),
(45, 'SKT', '2014-07-28', '0.2400'),
(46, 'SKT', '2010-01-27', '0.3825'),
(47, 'SKT', '2018-10-30', '0.3500'),
(48, 'SKT', '1993-07-28', '0.1150'),
(49, 'SKT', '1994-01-13', '0.4200'),
(50, 'SKT', '1997-07-23', '0.5500'),
(51, 'SKT', '1998-01-28', '0.5500'),
(52, 'SKT', '2001-07-27', '0.6100'),
(53, 'SKT', '2001-01-29', '0.6076'),
(54, 'SKT', '2018-04-27', '0.3500'),
(55, 'SKT', '2009-10-28', '0.3825'),
(56, 'SKT', '2005-01-27', '0.3125'),
(57, 'SKT', '2013-10-28', '0.2250'),
(58, 'SKT', '2009-01-28', '0.3800'),
(59, 'SKT', '1996-04-24', '0.5200'),
(60, 'SKT', '2017-10-30', '0.3425'),
(61, 'SKT', '2014-10-28', '0.2400'),
(62, 'SKT', '1996-07-24', '0.5200'),
(63, 'SKT', '1997-01-22', '0.5200'),
(64, 'SKT', '2000-07-27', '0.6076'),
(65, 'SKT', '2014-04-28', '0.2400'),
(66, 'SKT', '2004-01-28', '0.6150'),
(67, 'SKT', '2004-07-28', '0.6250'),
(68, 'SKT', '2008-01-29', '0.3600'),
(69, 'SKT', '2008-07-28', '0.3800'),
(70, 'SKT', '1995-04-24', '0.5000'),
(71, 'SKT', '2012-01-26', '0.2000'),
(72, 'SKT', '2012-07-26', '0.2100'),
(73, 'SKT', '2008-04-28', '0.3800'),
(74, 'SKT', '2013-01-28', '0.2100'),
(75, 'SKT', '1995-07-26', '0.5000'),
(76, 'SKT', '2000-04-26', '0.6076'),
(77, 'SKT', '2016-07-27', '0.3250'),
(78, 'SKT', '1996-01-24', '0.5000'),
(79, 'SKT', '2012-04-26', '0.2100'),
(80, 'SKT', '2017-01-27', '0.3250'),
(81, 'SKT', '1999-07-28', '0.6050'),
(82, 'SKT', '2004-04-28', '0.6250'),
(83, 'SKT', '2000-01-27', '0.6050'),
(84, 'SKT', '2016-04-27', '0.3250'),
(85, 'SKT', '2007-10-29', '0.3600'),
(86, 'SKT', '2003-01-29', '0.6126'),
(87, 'SKT', '2011-10-26', '0.2000'),
(88, 'SKT', '2007-01-29', '0.3400'),
(89, 'SKT', '2014-05-16', '0.0000'),
(90, 'SKT', '1994-04-25', '0.4600'),
(91, 'SKT', '2015-10-28', '0.2850'),
(92, 'SKT', '2011-01-27', '0.1938'),
(93, 'SKT', '2019-10-30', '0.3550'),
(94, 'SKT', '1994-07-25', '0.4600'),
(95, 'SKT', '1995-01-23', '0.4600'),
(96, 'SKT', '1998-07-28', '0.6000'),
(97, 'SKT', '1999-01-27', '0.6000'),
(98, 'SKT', '2002-07-29', '0.6126'),
(99, 'SKT', '2006-07-27', '0.3400'),
(100, 'SKT', '1993-10-26', '0.4200'),
(101, 'SKT', '2010-07-28', '0.3875'),
(102, 'SKT', '1997-10-22', '0.5500'),
(103, 'SKT', '1998-04-28', '0.6000'),
(104, 'SKT', '2014-05-20', '0.0000'),
(105, 'SKT', '2010-04-28', '0.3875'),
(106, 'SKT', '2015-01-28', '0.2400'),
(107, 'SKT', '2001-10-29', '0.6100'),
(108, 'SKT', '2002-04-26', '0.6126'),
(109, 'SKT', '2018-07-30', '0.3500'),
(110, 'SKT', '2014-04-02', '0.0000'),
(111, 'SKT', '2019-01-30', '0.3500'),
(112, 'SKT', '2005-10-27', '0.3225'),
(113, 'SKT', '2006-04-26', '0.3400'),
(114, 'LHA.DE', '2017-05-08', '0.1500'),
(115, 'LHA.DE', '2018-05-09', '0.5600'),
(116, 'LHA.DE', '2019-05-08', '0.8000'),
(117, 'LHA.DE', '2007-04-19', '0.7000'),
(118, 'LHA.DE', '2008-04-30', '1.2500'),
(119, 'LHA.DE', '2009-04-27', '0.7000'),
(120, 'LHA.DE', '2005-05-26', '0.3000'),
(121, 'LHA.DE', '2000-06-16', '0.5624'),
(122, 'LHA.DE', '2006-05-18', '0.5000'),
(123, 'LHA.DE', '2001-06-21', '0.6000'),
(124, 'LHA.DE', '2003-06-19', '0.6000'),
(125, 'LHA.DE', '2014-04-30', '0.4500'),
(126, 'LHA.DE', '2011-05-04', '0.6000'),
(127, 'LHA.DE', '2016-04-29', '0.5000'),
(128, 'LHA.DE', '2012-05-09', '0.2500');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `posts`
--

CREATE TABLE `posts` (
  `p_id` int(8) NOT NULL,
  `p_inhalt` text CHARACTER SET utf16 COLLATE utf16_german2_ci NOT NULL,
  `p_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `p_thema` int(8) NOT NULL,
  `p_ersteller` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

--
-- Daten für Tabelle `posts`
--

INSERT INTO `posts` (`p_id`, `p_inhalt`, `p_date`, `p_thema`, `p_ersteller`) VALUES
(1, 'g', '2019-11-09 17:23:44', 8, 29),
(2, 'das war mal wieder eine qual', '2019-11-09 17:24:08', 9, 29),
(9, 'ptptptpt', '2019-11-10 14:27:24', 10, 29),
(10, 'ptptptpt', '2019-11-10 14:27:31', 11, 29),
(11, 'test', '2019-11-10 14:42:31', 10, 29),
(12, 'test2', '2019-11-10 14:43:21', 10, 29),
(13, '1', '2019-11-10 17:38:00', 1, 29),
(14, '1', '2019-11-10 17:39:44', 1, 29),
(15, '1', '2019-11-10 17:41:21', 1, 29),
(16, 'k', '2019-11-10 17:42:18', 1, 29),
(17, 'k', '2019-11-10 17:45:12', 1, 29),
(18, '2', '2019-11-10 17:45:26', 10, 29),
(19, 'haha', '2019-11-10 17:50:47', 10, 29),
(20, 'haha', '2019-11-10 17:51:21', 10, 29),
(21, '234', '2019-11-10 17:54:08', 10, 29),
(22, 'llk', '2019-11-10 17:55:02', 1, 29),
(23, 'etet', '2019-11-10 18:03:50', 10, 29),
(33, 'test\r\n', '2019-11-10 22:38:09', 18, 52),
(38, 'äöokikgh', '2019-11-12 12:03:58', 10, 29),
(39, 't342', '2019-11-12 12:47:44', 23, 29),
(40, 'sgmn', '2019-11-12 12:49:34', 24, 29),
(41, '', '2019-11-15 10:39:05', 25, 29),
(42, 'wer', '2019-11-19 08:22:02', 26, 29),
(43, 'sdg', '2019-11-19 08:22:14', 27, 29),
(44, 'rt', '2019-11-19 08:26:46', 28, 29),
(45, 'qtrzq', '2019-11-19 08:27:25', 29, 29),
(46, 'test', '2019-12-13 09:50:43', 30, 63),
(47, 'w', '2019-12-13 10:05:34', 31, 63),
(48, 'r', '2019-12-13 10:08:15', 32, 63),
(49, 'ghd', '2019-12-13 10:14:46', 33, 63),
(55, 'h', '2019-12-13 10:54:31', 34, 63),
(56, 'gjk', '2019-12-13 10:57:25', 35, 63),
(57, 'Der Brexit kommt. Daran kann es nach dieser Wahl keinen Zweifel mehr geben. Boris Johnson hat einen derart klaren Sieg errungen, dass er nun freie Hand hat, Großbritannien aus der Europäischen Union zu führen. Genau das war Johnsons Versprechen im Wahlkampf. Mit seinem Slogan \"Get Brexit done\" hat er die Stimmung im Land auf den Punkt gebracht. Die Mehrheit der Briten war des elenden Streits überdrüssig und sehnte ein Ende des Dramas herbei. Die dreieinhalb Jahre nach dem Brexit-Referendum haben das Land paralysiert und gespalten. Ob das nun mit Johnsons Wahlsieg aufhört, ist allerdings alles andere als gewiss.\r\nDer Premierminister muss jetzt zeigen, was sein Brexit-Mantra bedeutet und welche Politik er daraus ableitet. Er wird Antworten geben müssen auf all jene Fragen, denen er im Wahlkampf ausgewichen ist. Johnson muss erklären, wie er sich die künftige Beziehung mit der EU vorstellt und wo er Großbritanniens Platz in der Welt verortet. Er wird auch zeigen müssen, was er unter seinem \"One-Nation Konservatismus\" versteht, der den Hedgefonds-Managern in der Londoner City genauso gefallen soll wie der Arbeiterklasse in Stoke-on-Trent.\r\nInwieweit Johnson das Land überhaupt einen kann, dürfte sich vor allem in Schottland entscheiden. Der dortige Wille, sich vom Vereinigten Königreich zu lösen, ist unübersehbar. Die Scottish National Party (SNP) wird nach dem deutlichen Wahlsieg in ihrer Heimat weiter auf ein Unabhängigkeitsreferendum dringen. Die Fliehkräfte, die am Vereinigten Königreich in Schottland, Wales und Nordirland zerren, sind so groß wie nie zuvor. Das Wahlergebnis lässt nur einen Schlu', '2019-12-13 11:24:56', 30, 52),
(58, 'jd', '2019-12-13 11:26:56', 30, 52),
(59, 'h', '2019-12-13 11:29:17', 30, 52),
(60, 'fdsfsd', '2019-12-26 18:45:04', 36, 52),
(61, 'was', '2019-12-26 18:45:10', 36, 52);

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
('GOOG', 'FOO', '2019-12-26 13:30:17', '0.0000'),
('GOOGL', 'FOO', '2019-12-26 13:30:11', '0.0000'),
('LHA.DE', 'FOO', '2019-12-26 14:16:24', '0.0000'),
('SKT', 'FOO', '2019-12-26 13:28:37', '0.0000');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `thema`
--

CREATE TABLE `thema` (
  `t_id` int(10) NOT NULL,
  `t_bereich` int(10) NOT NULL,
  `t_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `t_ersteller` int(10) NOT NULL,
  `t_subject` varchar(300) CHARACTER SET utf16 COLLATE utf16_german2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

--
-- Daten für Tabelle `thema`
--

INSERT INTO `thema` (`t_id`, `t_bereich`, `t_date`, `t_ersteller`, `t_subject`) VALUES
(1, 1, '2019-11-09 15:20:27', 29, 'mal ssehen ob das heir klappt'),
(8, 1, '2019-11-09 17:23:44', 29, 'rg'),
(9, 2, '2019-11-09 17:24:08', 29, 'test'),
(10, 3, '2019-11-10 14:27:24', 29, 'pp'),
(11, 3, '2019-11-10 14:27:31', 29, 'pp'),
(18, 1, '2019-11-10 22:38:09', 52, 'test'),
(23, 1, '2019-11-12 12:47:44', 29, '235'),
(24, 1, '2019-11-12 12:49:34', 29, 'sjfgnh'),
(25, 1, '2019-11-15 10:39:05', 29, 'hhhhnhuhnhnuh'),
(26, 1, '2019-11-19 08:22:02', 29, 'wer'),
(27, 1, '2019-11-19 08:22:14', 29, 'werwet'),
(28, 3, '2019-11-19 08:26:46', 29, 'tze'),
(29, 1, '2019-11-19 08:27:25', 29, '35zeth'),
(30, 14, '2019-12-13 09:50:43', 63, 'test'),
(31, 3, '2019-12-13 10:05:34', 63, 'w'),
(32, 3, '2019-12-13 10:08:15', 63, 'e'),
(33, 2, '2019-12-13 10:14:46', 63, 'gh'),
(34, 3, '2019-12-13 10:54:31', 63, 'h'),
(35, 3, '2019-12-13 10:57:25', 63, 'fzil'),
(36, 2, '2019-12-26 18:45:04', 52, 'test123');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `user_id` int(50) NOT NULL,
  `name` varchar(500) COLLATE utf8_german2_ci NOT NULL,
  `email` varchar(500) COLLATE utf8_german2_ci NOT NULL,
  `passwort` varchar(5000) COLLATE utf8_german2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`user_id`, `name`, `email`, `passwort`) VALUES
(29, '222', '222', ''),
(52, 'admin', 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918'),
(59, 'f', 'f', '252f10c83610ebca1a059c0bae8255eba2f95be4d1d7bcfa89d7248a82d9f111'),
(62, '234', '234', '114bd151f8fb0c58642d2170da4ae7d7c57977260ac2cc8905306cab6b2acabc'),
(63, '123', '123', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3'),
(65, '1', '1', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b'),
(66, 'test', 'test@test.de', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `bereich`
--
ALTER TABLE `bereich`
  ADD PRIMARY KEY (`b_id`),
  ADD UNIQUE KEY `b_id_unique` (`b_id`);

--
-- Indizes für die Tabelle `dividends`
--
ALTER TABLE `dividends`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`p_id`),
  ADD KEY `p_ersteller` (`p_ersteller`),
  ADD KEY `p_thema` (`p_thema`);

--
-- Indizes für die Tabelle `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`Symbol`(10));

--
-- Indizes für die Tabelle `thema`
--
ALTER TABLE `thema`
  ADD PRIMARY KEY (`t_id`),
  ADD KEY `t_ersteller` (`t_ersteller`),
  ADD KEY `t_bereich` (`t_bereich`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email_unique` (`email`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `bereich`
--
ALTER TABLE `bereich`
  MODIFY `b_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT für Tabelle `dividends`
--
ALTER TABLE `dividends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT für Tabelle `posts`
--
ALTER TABLE `posts`
  MODIFY `p_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT für Tabelle `thema`
--
ALTER TABLE `thema`
  MODIFY `t_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_3` FOREIGN KEY (`p_ersteller`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_ibfk_4` FOREIGN KEY (`p_thema`) REFERENCES `thema` (`t_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `thema`
--
ALTER TABLE `thema`
  ADD CONSTRAINT `thema_ibfk_6` FOREIGN KEY (`t_ersteller`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `thema_ibfk_7` FOREIGN KEY (`t_bereich`) REFERENCES `bereich` (`b_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
