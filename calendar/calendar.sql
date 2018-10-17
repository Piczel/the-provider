-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 16 okt 2018 kl 12:35
-- Serverversion: 10.1.19-MariaDB
-- PHP-version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `calendar`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `activity`
--

CREATE TABLE `activity` (
  `activityID` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `location` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `repetition` tinyint(1) NOT NULL,
  `starttime` datetime NOT NULL,
  `endtime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `activity`
--

INSERT INTO `activity` (`activityID`, `name`, `location`, `description`, `repetition`, `starttime`, `endtime`) VALUES
(1, '', '', '', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Tabellstruktur `calendar`
--

CREATE TABLE `calendar` (
  `calendarID` int(11) NOT NULL,
  `kalender_månad` tinyint(12) NOT NULL,
  `kalender_dag` tinyint(31) NOT NULL,
  `kalender_år` smallint(6) NOT NULL,
  `kalender_kvartal` tinyint(4) NOT NULL,
  `dag_namn` varchar(7) NOT NULL,
  `dag_av_vecka` tinyint(7) NOT NULL,
  `dag_av_vecka_av_månad` tinyint(5) NOT NULL,
  `dag_av_vecka_av_månad_av_år` tinyint(53) NOT NULL,
  `dag_av_vecka_av_kvartal` tinyint(13) NOT NULL,
  `dag_av_kvartal` tinyint(92) NOT NULL,
  `dag_av_år` int(11) NOT NULL,
  `vecka_av_månad` tinyint(6) NOT NULL,
  `vecka_av_kvartal` tinyint(14) NOT NULL,
  `vecka_av_år` tinyint(53) NOT NULL,
  `månad_namn` varchar(9) NOT NULL,
  `första_datum_av_vecka` date NOT NULL,
  `sista_datum_av_vecka` date NOT NULL,
  `första_datum_av_måndag` date NOT NULL,
  `sista_datum_av_måndag` date NOT NULL,
  `första_datum_av_kvartal` date NOT NULL,
  `sista_datum_av_kvartal` date NOT NULL,
  `första_datum_av_år` date NOT NULL,
  `sista_datum_av_år` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `calendaruser`
--

CREATE TABLE `calendaruser` (
  `activityID` int(11) NOT NULL,
  `calendarID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`activityID`);

--
-- Index för tabell `calendar`
--
ALTER TABLE `calendar`
  ADD PRIMARY KEY (`calendarID`);

--
-- Index för tabell `calendaruser`
--
ALTER TABLE `calendaruser`
  ADD PRIMARY KEY (`activityID`,`calendarID`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `activity`
--
ALTER TABLE `activity`
  MODIFY `activityID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT för tabell `calendar`
--
ALTER TABLE `calendar`
  MODIFY `calendarID` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
