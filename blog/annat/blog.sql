-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 17 okt 2018 kl 16:08
-- Serverversion: 10.1.19-MariaDB
-- PHP-version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `blog`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `blog`
--

CREATE TABLE `blog` (
  `bid` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `blog`
--

INSERT INTO `blog` (`bid`, `title`, `uid`) VALUES
(1, 'Pelles liv', 1),
(2, 'Bös', 1),
(3, 'En ny blogg', 2),
(4, 'Min ny blogg', 3),
(5, 'Min ny blogg', 1);

-- --------------------------------------------------------

--
-- Tabellstruktur `blogger`
--

CREATE TABLE `blogger` (
  `uid` int(11) NOT NULL,
  `bid` int(11) NOT NULL,
  `bloggerid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `blogger`
--

INSERT INTO `blogger` (`uid`, `bid`, `bloggerid`) VALUES
(1, 1, 1),
(2, 1, 3);

-- --------------------------------------------------------

--
-- Tabellstruktur `comment`
--

CREATE TABLE `comment` (
  `cid` int(11) NOT NULL,
  `text` text NOT NULL,
  `date` date NOT NULL,
  `pid` int(11) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `comment`
--

INSERT INTO `comment` (`cid`, `text`, `date`, `pid`, `uid`) VALUES
(4, 'Detta är en kommentar', '2018-06-29', 1, 1),
(6, 'Detta är en kommentar', '2018-06-29', 1, 1),
(7, 'Detta är en kommentar', '2018-06-29', 1, 1),
(8, 'Detta är en kommentar', '2018-06-29', 1, 1),
(9, 'Detta är en kommentar', '2018-06-29', 1, 1),
(10, 'Detta är en kommentar', '2018-06-29', 1, 1),
(11, 'Detta är en kommentar', '2018-06-29', 1, 1),
(12, 'Detta är en kommentar', '2018-06-29', 1, 1),
(13, 'Detta är en kommentar', '2018-06-29', 1, 1),
(14, 'Detta är en kommentar', '2018-06-29', 1, 1),
(15, 'Detta är en kommentar', '2018-06-29', 1, 1),
(16, 'Detta är en kommentar', '2018-06-29', 1, 1);

-- --------------------------------------------------------

--
-- Tabellstruktur `post`
--

CREATE TABLE `post` (
  `pid` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `date` date NOT NULL,
  `bid` int(11) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `post`
--

INSERT INTO `post` (`pid`, `title`, `content`, `date`, `bid`, `uid`) VALUES
(5, 'Detta har jag gjort idag', 'Idag har jag inte gjort ett skit', '2018-06-29', 1, 1),
(6, 'Detta har jag gjort idag', 'Idag har jag inte gjort ett skit', '2018-06-29', 1, 1),
(8, 'Bös', 'fedgdafgs', '2018-10-03', 2, 1),
(9, 'Bös', 'lkjhg', '2018-10-03', 1, 1);

-- --------------------------------------------------------

--
-- Tabellstruktur `user`
--

CREATE TABLE `user` (
  `uid` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `user`
--

INSERT INTO `user` (`uid`, `name`, `email`) VALUES
(1, 'Bosse', 'bosse.bus@gmail.com'),
(2, 'Lasse', 'lars.bandars@gmail.com');

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`bid`);

--
-- Index för tabell `blogger`
--
ALTER TABLE `blogger`
  ADD PRIMARY KEY (`bloggerid`),
  ADD KEY `uid` (`uid`),
  ADD KEY `bid` (`bid`),
  ADD KEY `uid_2` (`uid`);

--
-- Index för tabell `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`cid`);

--
-- Index för tabell `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`pid`);

--
-- Index för tabell `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uid`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `blog`
--
ALTER TABLE `blog`
  MODIFY `bid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT för tabell `blogger`
--
ALTER TABLE `blogger`
  MODIFY `bloggerid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT för tabell `comment`
--
ALTER TABLE `comment`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT för tabell `post`
--
ALTER TABLE `post`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT för tabell `user`
--
ALTER TABLE `user`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
