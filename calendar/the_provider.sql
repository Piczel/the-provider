-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 18 okt 2018 kl 11:10
-- Serverversion: 10.1.35-MariaDB
-- PHP-version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `the_provider`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `account`
--

CREATE TABLE `account` (
  `accountID` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `token` varchar(20) DEFAULT NULL,
  `tokenTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `triggerUpdate` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `account`
--

INSERT INTO `account` (`accountID`, `email`, `password`, `username`, `token`, `tokenTime`, `triggerUpdate`) VALUES
(1, 'user@theprovider.com', '$2y$10$/hUr3xBZ9uzr1TSSy0I2ZuFgXhi9PMSlt5tFx79c40ZkZRt/wQVGy', 'User', 'b2987030d5c94b6e9615', '2018-10-18 08:33:39', 1),
(2, 'user@the-provider.com', 'qwer1234', 'TheUser', 'aaaaaaaaaaaaaaaaaaaa', '2018-10-18 08:25:30', 1);

-- --------------------------------------------------------

--
-- Tabellstruktur `activity`
--

CREATE TABLE `activity` (
  `activityID` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `location` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `repetition` smallint(6) NOT NULL,
  `startTime` datetime NOT NULL,
  `endTime` datetime NOT NULL,
  `forCalendarID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `activity`
--

INSERT INTO `activity` (`activityID`, `name`, `location`, `description`, `repetition`, `startTime`, `endTime`, `forCalendarID`) VALUES
(3, 'asdasdfasdfg', 'asdf', 'asdfasdf', 3, '2018-10-05 00:00:00', '2018-10-06 00:00:00', 2);

-- --------------------------------------------------------

--
-- Tabellstruktur `admin_blog`
--

CREATE TABLE `admin_blog` (
  `admin_blogID` int(11) NOT NULL,
  `activated_tp` tinyint(1) NOT NULL DEFAULT '1',
  `activated_user` tinyint(1) NOT NULL DEFAULT '1',
  `forAccountID` int(11) NOT NULL,
  `forBlogID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `admin_calendar`
--

CREATE TABLE `admin_calendar` (
  `admin_calendarID` int(11) NOT NULL,
  `activated_tp` tinyint(1) NOT NULL DEFAULT '1',
  `activated_user` tinyint(1) NOT NULL DEFAULT '1',
  `forAccountID` int(11) NOT NULL,
  `forCalendarID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `admin_calendar`
--

INSERT INTO `admin_calendar` (`admin_calendarID`, `activated_tp`, `activated_user`, `forAccountID`, `forCalendarID`) VALUES
(1, 1, 1, 2, 1),
(2, 1, 1, 1, 2);

-- --------------------------------------------------------

--
-- Tabellstruktur `admin_game`
--

CREATE TABLE `admin_game` (
  `admin_gameID` int(11) NOT NULL,
  `activated_tp` tinyint(1) NOT NULL DEFAULT '1',
  `activated_user` tinyint(1) NOT NULL DEFAULT '1',
  `forAccountID` int(11) NOT NULL,
  `forGameID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `admin_wiki`
--

CREATE TABLE `admin_wiki` (
  `admin_wikiID` int(11) NOT NULL,
  `activated_tp` tinyint(1) NOT NULL DEFAULT '1',
  `activated_user` tinyint(1) NOT NULL DEFAULT '1',
  `forAccountID` int(11) NOT NULL,
  `forWikiID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `article`
--

CREATE TABLE `article` (
  `articleID` int(11) NOT NULL,
  `forVersionID` int(11) DEFAULT NULL,
  `forWikiID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `articleversion`
--

CREATE TABLE `articleversion` (
  `versionID` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `forArticleID` int(11) NOT NULL,
  `forAccountID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `articleversion_reference`
--

CREATE TABLE `articleversion_reference` (
  `forVersionID` int(11) NOT NULL,
  `forReferenceID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `blog`
--

CREATE TABLE `blog` (
  `blogID` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `forAccountID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `blog`
--

INSERT INTO `blog` (`blogID`, `title`, `forAccountID`) VALUES
(1, 'Min ny blogg', 1);

-- --------------------------------------------------------

--
-- Tabellstruktur `blog_account`
--

CREATE TABLE `blog_account` (
  `blog_accountID` int(11) NOT NULL,
  `forBlogID` int(11) NOT NULL,
  `forAccountID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `bookmark`
--

CREATE TABLE `bookmark` (
  `forAccountID` int(11) NOT NULL,
  `forArticleID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `calendar`
--

CREATE TABLE `calendar` (
  `calendarID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `calendar`
--

INSERT INTO `calendar` (`calendarID`) VALUES
(1),
(2);

-- --------------------------------------------------------

--
-- Tabellstruktur `comment`
--

CREATE TABLE `comment` (
  `commentID` int(11) NOT NULL,
  `content` text NOT NULL,
  `date` date NOT NULL,
  `forPostID` int(11) NOT NULL,
  `forAccountID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `friendship`
--

CREATE TABLE `friendship` (
  `friendshipID` int(11) NOT NULL,
  `forPlayerID` int(11) NOT NULL,
  `forFriendID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `game`
--

CREATE TABLE `game` (
  `gameID` int(11) NOT NULL,
  `name` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `participation`
--

CREATE TABLE `participation` (
  `participationID` int(11) NOT NULL,
  `forActivityID` int(11) NOT NULL,
  `forCalendarID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `player`
--

CREATE TABLE `player` (
  `playerID` int(11) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `post`
--

CREATE TABLE `post` (
  `postID` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `date` date NOT NULL,
  `forBlogID` int(11) NOT NULL,
  `forAccountID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `reference`
--

CREATE TABLE `reference` (
  `referenceID` int(11) NOT NULL,
  `forVersionID` int(11) NOT NULL,
  `forArticleID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `referenceversion`
--

CREATE TABLE `referenceversion` (
  `versionID` int(11) NOT NULL,
  `content` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `forReferenceID` int(11) NOT NULL,
  `forAccountID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `score`
--

CREATE TABLE `score` (
  `scoreID` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `forGameID` int(11) NOT NULL,
  `forPlayerID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `selected_accept`
--

CREATE TABLE `selected_accept` (
  `forWikiID` int(11) NOT NULL,
  `forAccountID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `selected_edit`
--

CREATE TABLE `selected_edit` (
  `forWikiID` int(11) NOT NULL,
  `forAccountID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `wiki`
--

CREATE TABLE `wiki` (
  `wikiID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(3000) NOT NULL,
  `mayEdit` enum('superuser','selected','any') NOT NULL DEFAULT 'any',
  `mayAccept` enum('superuser','selected','auto') NOT NULL DEFAULT 'selected',
  `mayAssignEdit` enum('superuser','selected') NOT NULL DEFAULT 'superuser',
  `mayAssignAccept` enum('superuser','selected') NOT NULL DEFAULT 'superuser',
  `forAccountID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `wiki`
--

INSERT INTO `wiki` (`wikiID`, `name`, `description`, `mayEdit`, `mayAccept`, `mayAssignEdit`, `mayAssignAccept`, `forAccountID`) VALUES
(1, 'Namn på wiki', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.', 'superuser', 'auto', 'selected', 'selected', 2),
(2, 'Namn på wiki', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.', 'any', 'selected', 'superuser', 'superuser', 2),
(3, 'Namn på wiki', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.', 'any', 'selected', 'superuser', 'superuser', 2),
(4, 'Namn på wiki', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.', 'any', 'selected', 'superuser', 'superuser', 2),
(5, 'Namn på wiki', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.', 'any', 'selected', 'superuser', 'superuser', 2),
(6, 'Namn på wiki', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.', 'any', 'selected', 'superuser', 'superuser', 2),
(7, 'Namn på wiki', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.', 'any', 'selected', 'superuser', 'superuser', 2),
(8, 'Namn på wiki', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.', 'any', 'selected', 'superuser', 'superuser', 2),
(9, 'Namn på wiki', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.', 'any', 'selected', 'superuser', 'superuser', 2),
(10, 'Namn på wiki', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.', 'any', 'selected', 'superuser', 'superuser', 2),
(11, 'Namn på wikiaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.', 'any', 'selected', 'superuser', 'superuser', 2),
(12, 'Namn på wiki', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.', 'any', 'selected', 'superuser', 'superuser', 2),
(13, 'Namn på wiki', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.', 'any', 'selected', 'superuser', 'superuser', 2),
(14, 'Namn på wiki', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.', 'any', 'selected', 'superuser', 'superuser', 2),
(15, 'Namn på wiki', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.', 'any', 'selected', 'superuser', 'superuser', 2),
(16, 'Namn på wiki', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.', 'any', 'selected', 'superuser', 'superuser', 2),
(17, 'Namn på wiki', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.', 'any', 'selected', 'superuser', 'superuser', 2),
(18, 'Namn på wiki', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.', 'any', 'selected', 'superuser', 'superuser', 2),
(19, 'Namn på wiki', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.', 'any', 'selected', 'superuser', 'superuser', 2),
(21, 'Namn på wiki', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.', 'any', 'selected', 'superuser', 'superuser', 2),
(22, 'Namn på wiki', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.', 'any', 'selected', 'superuser', 'superuser', 2),
(26, 'Namn på wiki', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.', 'any', 'selected', 'superuser', 'superuser', 2),
(27, 'Namn på wiki', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.', 'any', 'selected', 'superuser', 'superuser', 2),
(28, 'Namn på wiki', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.', 'any', 'selected', 'superuser', 'superuser', 2),
(29, 'Namn på wiki', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.', 'any', 'selected', 'superuser', 'superuser', 2),
(30, 'Namn på wiki', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.', 'any', 'selected', 'superuser', 'superuser', 2),
(31, 'Namn på wiki', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.', 'any', 'selected', 'superuser', 'superuser', 2),
(32, 'Namn på wiki', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.', 'any', 'selected', 'superuser', 'superuser', 2),
(33, 'Namn på wiki', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.', 'any', 'selected', 'superuser', 'superuser', 2),
(34, 'Namn på wiki', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.', 'any', 'selected', 'superuser', 'superuser', 2),
(35, 'Namn på wiki', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.', 'any', 'selected', 'superuser', 'superuser', 0),
(36, 'Namn på wiki', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.', 'any', 'selected', 'superuser', 'superuser', 0),
(37, 'Namn på wiki', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.', 'any', 'selected', 'superuser', 'superuser', 0);

-- --------------------------------------------------------

--
-- Tabellstruktur `wikiuser`
--

CREATE TABLE `wikiuser` (
  `forAccountID` int(11) NOT NULL,
  `forWikiID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `wikiuser`
--

INSERT INTO `wikiuser` (`forAccountID`, `forWikiID`) VALUES
(1, 1);

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`accountID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Index för tabell `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`activityID`),
  ADD KEY `forCalendarID` (`forCalendarID`) USING BTREE;

--
-- Index för tabell `admin_blog`
--
ALTER TABLE `admin_blog`
  ADD PRIMARY KEY (`admin_blogID`),
  ADD KEY `forAccountID` (`forAccountID`),
  ADD KEY `forBlogID` (`forBlogID`);

--
-- Index för tabell `admin_calendar`
--
ALTER TABLE `admin_calendar`
  ADD PRIMARY KEY (`admin_calendarID`),
  ADD KEY `forAccountID` (`forAccountID`),
  ADD KEY `forCalendarID` (`forCalendarID`);

--
-- Index för tabell `admin_game`
--
ALTER TABLE `admin_game`
  ADD PRIMARY KEY (`admin_gameID`),
  ADD KEY `forAccountID` (`forAccountID`),
  ADD KEY `forGameID` (`forGameID`);

--
-- Index för tabell `admin_wiki`
--
ALTER TABLE `admin_wiki`
  ADD PRIMARY KEY (`admin_wikiID`),
  ADD KEY `forAccountID` (`forAccountID`),
  ADD KEY `forWikiID` (`forWikiID`);

--
-- Index för tabell `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`articleID`),
  ADD KEY `forWikiID` (`forWikiID`),
  ADD KEY `forVersionID` (`forVersionID`);

--
-- Index för tabell `articleversion`
--
ALTER TABLE `articleversion`
  ADD PRIMARY KEY (`versionID`),
  ADD KEY `forArticleID` (`forArticleID`),
  ADD KEY `forAccountID` (`forAccountID`);

--
-- Index för tabell `articleversion_reference`
--
ALTER TABLE `articleversion_reference`
  ADD UNIQUE KEY `articleversion_reference_unique` (`forVersionID`,`forReferenceID`),
  ADD KEY `forReferenceID` (`forReferenceID`);

--
-- Index för tabell `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`blogID`),
  ADD UNIQUE KEY `forAccountID` (`forAccountID`) USING BTREE;

--
-- Index för tabell `blog_account`
--
ALTER TABLE `blog_account`
  ADD PRIMARY KEY (`blog_accountID`),
  ADD UNIQUE KEY `blog_account_unique` (`forBlogID`,`forAccountID`) USING BTREE,
  ADD KEY `forAccountID` (`forAccountID`);

--
-- Index för tabell `bookmark`
--
ALTER TABLE `bookmark`
  ADD UNIQUE KEY `bookmark_unique` (`forAccountID`,`forArticleID`),
  ADD KEY `forArticleID` (`forArticleID`);

--
-- Index för tabell `calendar`
--
ALTER TABLE `calendar`
  ADD PRIMARY KEY (`calendarID`);

--
-- Index för tabell `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`commentID`),
  ADD KEY `forPostID` (`forPostID`),
  ADD KEY `forAccountID` (`forAccountID`);

--
-- Index för tabell `friendship`
--
ALTER TABLE `friendship`
  ADD PRIMARY KEY (`friendshipID`),
  ADD KEY `forPlayerID` (`forPlayerID`),
  ADD KEY `forFriendID` (`forFriendID`);

--
-- Index för tabell `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`gameID`);

--
-- Index för tabell `participation`
--
ALTER TABLE `participation`
  ADD PRIMARY KEY (`participationID`),
  ADD KEY `forActivityID` (`forActivityID`),
  ADD KEY `forCalendarID` (`forCalendarID`);

--
-- Index för tabell `player`
--
ALTER TABLE `player`
  ADD PRIMARY KEY (`playerID`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index för tabell `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`postID`),
  ADD KEY `forBlogID` (`forBlogID`),
  ADD KEY `forAccountID` (`forAccountID`);

--
-- Index för tabell `reference`
--
ALTER TABLE `reference`
  ADD PRIMARY KEY (`referenceID`),
  ADD KEY `forVersionID` (`forVersionID`),
  ADD KEY `forArticleID` (`forArticleID`);

--
-- Index för tabell `referenceversion`
--
ALTER TABLE `referenceversion`
  ADD PRIMARY KEY (`versionID`),
  ADD KEY `forReferenceID` (`forReferenceID`),
  ADD KEY `forAccountID` (`forAccountID`);

--
-- Index för tabell `score`
--
ALTER TABLE `score`
  ADD PRIMARY KEY (`scoreID`),
  ADD KEY `forGameID` (`forGameID`),
  ADD KEY `forPlayerID` (`forPlayerID`);

--
-- Index för tabell `selected_accept`
--
ALTER TABLE `selected_accept`
  ADD UNIQUE KEY `selected_accept_unique` (`forWikiID`,`forAccountID`),
  ADD KEY `forAccountID` (`forAccountID`);

--
-- Index för tabell `selected_edit`
--
ALTER TABLE `selected_edit`
  ADD UNIQUE KEY `selected_edit_unique` (`forWikiID`,`forAccountID`) USING BTREE,
  ADD KEY `forAccountID` (`forAccountID`);

--
-- Index för tabell `wiki`
--
ALTER TABLE `wiki`
  ADD PRIMARY KEY (`wikiID`);

--
-- Index för tabell `wikiuser`
--
ALTER TABLE `wikiuser`
  ADD PRIMARY KEY (`forAccountID`),
  ADD KEY `forWikiID` (`forWikiID`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `account`
--
ALTER TABLE `account`
  MODIFY `accountID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT för tabell `activity`
--
ALTER TABLE `activity`
  MODIFY `activityID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT för tabell `admin_blog`
--
ALTER TABLE `admin_blog`
  MODIFY `admin_blogID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `admin_calendar`
--
ALTER TABLE `admin_calendar`
  MODIFY `admin_calendarID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT för tabell `admin_game`
--
ALTER TABLE `admin_game`
  MODIFY `admin_gameID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `admin_wiki`
--
ALTER TABLE `admin_wiki`
  MODIFY `admin_wikiID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `article`
--
ALTER TABLE `article`
  MODIFY `articleID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `articleversion`
--
ALTER TABLE `articleversion`
  MODIFY `versionID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `blog`
--
ALTER TABLE `blog`
  MODIFY `blogID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT för tabell `blog_account`
--
ALTER TABLE `blog_account`
  MODIFY `blog_accountID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `calendar`
--
ALTER TABLE `calendar`
  MODIFY `calendarID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT för tabell `comment`
--
ALTER TABLE `comment`
  MODIFY `commentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `friendship`
--
ALTER TABLE `friendship`
  MODIFY `friendshipID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `game`
--
ALTER TABLE `game`
  MODIFY `gameID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `participation`
--
ALTER TABLE `participation`
  MODIFY `participationID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `player`
--
ALTER TABLE `player`
  MODIFY `playerID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `post`
--
ALTER TABLE `post`
  MODIFY `postID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `reference`
--
ALTER TABLE `reference`
  MODIFY `referenceID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `referenceversion`
--
ALTER TABLE `referenceversion`
  MODIFY `versionID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `score`
--
ALTER TABLE `score`
  MODIFY `scoreID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `wiki`
--
ALTER TABLE `wiki`
  MODIFY `wikiID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Restriktioner för dumpade tabeller
--

--
-- Restriktioner för tabell `activity`
--
ALTER TABLE `activity`
  ADD CONSTRAINT `activity_ibfk_1` FOREIGN KEY (`forCalendarID`) REFERENCES `calendar` (`calendarID`);

--
-- Restriktioner för tabell `admin_blog`
--
ALTER TABLE `admin_blog`
  ADD CONSTRAINT `admin_blog_ibfk_1` FOREIGN KEY (`forAccountID`) REFERENCES `account` (`accountID`),
  ADD CONSTRAINT `admin_blog_ibfk_2` FOREIGN KEY (`forBlogID`) REFERENCES `blog` (`blogID`);

--
-- Restriktioner för tabell `admin_calendar`
--
ALTER TABLE `admin_calendar`
  ADD CONSTRAINT `admin_calendar_ibfk_1` FOREIGN KEY (`forAccountID`) REFERENCES `account` (`accountID`),
  ADD CONSTRAINT `admin_calendar_ibfk_2` FOREIGN KEY (`forCalendarID`) REFERENCES `calendar` (`calendarID`);

--
-- Restriktioner för tabell `admin_game`
--
ALTER TABLE `admin_game`
  ADD CONSTRAINT `admin_game_ibfk_1` FOREIGN KEY (`forAccountID`) REFERENCES `account` (`accountID`),
  ADD CONSTRAINT `admin_game_ibfk_2` FOREIGN KEY (`forGameID`) REFERENCES `game` (`gameID`);

--
-- Restriktioner för tabell `admin_wiki`
--
ALTER TABLE `admin_wiki`
  ADD CONSTRAINT `admin_wiki_ibfk_1` FOREIGN KEY (`forAccountID`) REFERENCES `account` (`accountID`),
  ADD CONSTRAINT `admin_wiki_ibfk_2` FOREIGN KEY (`forWikiID`) REFERENCES `wiki` (`wikiID`);

--
-- Restriktioner för tabell `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`forWikiID`) REFERENCES `wiki` (`wikiID`),
  ADD CONSTRAINT `article_ibfk_2` FOREIGN KEY (`forVersionID`) REFERENCES `articleversion` (`versionID`);

--
-- Restriktioner för tabell `articleversion`
--
ALTER TABLE `articleversion`
  ADD CONSTRAINT `articleversion_ibfk_1` FOREIGN KEY (`forArticleID`) REFERENCES `article` (`articleID`),
  ADD CONSTRAINT `articleversion_ibfk_2` FOREIGN KEY (`forAccountID`) REFERENCES `wikiuser` (`forAccountID`);

--
-- Restriktioner för tabell `articleversion_reference`
--
ALTER TABLE `articleversion_reference`
  ADD CONSTRAINT `articleversion_reference_ibfk_1` FOREIGN KEY (`forVersionID`) REFERENCES `articleversion` (`versionID`),
  ADD CONSTRAINT `articleversion_reference_ibfk_2` FOREIGN KEY (`forReferenceID`) REFERENCES `reference` (`referenceID`);

--
-- Restriktioner för tabell `blog`
--
ALTER TABLE `blog`
  ADD CONSTRAINT `blog_ibfk_1` FOREIGN KEY (`forAccountID`) REFERENCES `account` (`accountID`);

--
-- Restriktioner för tabell `blog_account`
--
ALTER TABLE `blog_account`
  ADD CONSTRAINT `blog_account_ibfk_1` FOREIGN KEY (`forBlogID`) REFERENCES `blog` (`blogID`),
  ADD CONSTRAINT `blog_account_ibfk_2` FOREIGN KEY (`forAccountID`) REFERENCES `account` (`accountID`);

--
-- Restriktioner för tabell `bookmark`
--
ALTER TABLE `bookmark`
  ADD CONSTRAINT `bookmark_ibfk_1` FOREIGN KEY (`forAccountID`) REFERENCES `wikiuser` (`forAccountID`),
  ADD CONSTRAINT `bookmark_ibfk_2` FOREIGN KEY (`forArticleID`) REFERENCES `article` (`articleID`);

--
-- Restriktioner för tabell `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`forPostID`) REFERENCES `post` (`postID`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`forAccountID`) REFERENCES `account` (`accountID`);

--
-- Restriktioner för tabell `friendship`
--
ALTER TABLE `friendship`
  ADD CONSTRAINT `friendship_ibfk_1` FOREIGN KEY (`forPlayerID`) REFERENCES `player` (`playerID`),
  ADD CONSTRAINT `friendship_ibfk_2` FOREIGN KEY (`forFriendID`) REFERENCES `player` (`playerID`);

--
-- Restriktioner för tabell `participation`
--
ALTER TABLE `participation`
  ADD CONSTRAINT `participation_ibfk_1` FOREIGN KEY (`forActivityID`) REFERENCES `activity` (`activityID`),
  ADD CONSTRAINT `participation_ibfk_2` FOREIGN KEY (`forCalendarID`) REFERENCES `calendar` (`calendarID`);

--
-- Restriktioner för tabell `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`forBlogID`) REFERENCES `blog` (`blogID`),
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`forAccountID`) REFERENCES `account` (`accountID`);

--
-- Restriktioner för tabell `reference`
--
ALTER TABLE `reference`
  ADD CONSTRAINT `reference_ibfk_1` FOREIGN KEY (`forVersionID`) REFERENCES `referenceversion` (`versionID`),
  ADD CONSTRAINT `reference_ibfk_2` FOREIGN KEY (`forArticleID`) REFERENCES `article` (`articleID`);

--
-- Restriktioner för tabell `referenceversion`
--
ALTER TABLE `referenceversion`
  ADD CONSTRAINT `referenceversion_ibfk_1` FOREIGN KEY (`forReferenceID`) REFERENCES `reference` (`referenceID`),
  ADD CONSTRAINT `referenceversion_ibfk_2` FOREIGN KEY (`forAccountID`) REFERENCES `wikiuser` (`forAccountID`);

--
-- Restriktioner för tabell `score`
--
ALTER TABLE `score`
  ADD CONSTRAINT `score_ibfk_1` FOREIGN KEY (`forGameID`) REFERENCES `game` (`gameID`),
  ADD CONSTRAINT `score_ibfk_2` FOREIGN KEY (`forPlayerID`) REFERENCES `player` (`playerID`);

--
-- Restriktioner för tabell `selected_accept`
--
ALTER TABLE `selected_accept`
  ADD CONSTRAINT `selected_accept_ibfk_1` FOREIGN KEY (`forWikiID`) REFERENCES `wiki` (`wikiID`),
  ADD CONSTRAINT `selected_accept_ibfk_2` FOREIGN KEY (`forAccountID`) REFERENCES `wikiuser` (`forAccountID`);

--
-- Restriktioner för tabell `selected_edit`
--
ALTER TABLE `selected_edit`
  ADD CONSTRAINT `selected_edit_ibfk_1` FOREIGN KEY (`forWikiID`) REFERENCES `wiki` (`wikiID`),
  ADD CONSTRAINT `selected_edit_ibfk_2` FOREIGN KEY (`forAccountID`) REFERENCES `wikiuser` (`forAccountID`);

--
-- Restriktioner för tabell `wikiuser`
--
ALTER TABLE `wikiuser`
  ADD CONSTRAINT `wikiuser_ibfk_1` FOREIGN KEY (`forAccountID`) REFERENCES `account` (`accountID`),
  ADD CONSTRAINT `wikiuser_ibfk_2` FOREIGN KEY (`forWikiID`) REFERENCES `wiki` (`wikiID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
