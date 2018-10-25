-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 24, 2018 at 12:28 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `the_provider`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `accountID` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `token` varchar(20) DEFAULT NULL,
  `tokenTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `triggerUpdate` tinyint(4) NOT NULL DEFAULT '0',
  `type` enum('superadmin','admin','normal') NOT NULL DEFAULT 'normal'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`accountID`, `email`, `password`, `username`, `token`, `tokenTime`, `triggerUpdate`, `type`) VALUES
(1, '', '$2y$10$hqnzDWH8U6ME9XVsaNvKw.XGuwQOJDQOCIOVY8sivAwtDMzPQ5Vbq', 'theprovider', 'ad04fa3030769013db64', '2018-10-24 08:53:17', 0, 'superadmin');

-- --------------------------------------------------------

--
-- Table structure for table `activity`
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

-- --------------------------------------------------------

--
-- Table structure for table `admin_blog`
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
-- Table structure for table `admin_calendar`
--

CREATE TABLE `admin_calendar` (
  `admin_calendarID` int(11) NOT NULL,
  `activated_tp` tinyint(1) NOT NULL DEFAULT '1',
  `activated_user` tinyint(1) NOT NULL DEFAULT '1',
  `forAccountID` int(11) NOT NULL,
  `forCalendarID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `admin_game`
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
-- Table structure for table `admin_wiki`
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
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `articleID` int(11) NOT NULL,
  `forVersionID` int(11) DEFAULT NULL,
  `forWikiID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `articleversion`
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
-- Table structure for table `articleversion_reference`
--

CREATE TABLE `articleversion_reference` (
  `forVersionID` int(11) NOT NULL,
  `forReferenceID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `block_account`
--

CREATE TABLE `block_account` (
  `blockID` int(11) NOT NULL,
  `forBlogID` int(11) NOT NULL,
  `forAccountID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `blogID` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `forAccountID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `blog_account`
--

CREATE TABLE `blog_account` (
  `blog_accountID` int(11) NOT NULL,
  `forBlogID` int(11) NOT NULL,
  `forAccountID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bookmark`
--

CREATE TABLE `bookmark` (
  `forAccountID` int(11) NOT NULL,
  `forArticleID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `calendar`
--

CREATE TABLE `calendar` (
  `calendarID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `calendar_activity`
--

CREATE TABLE `calendar_activity` (
  `participationID` int(11) NOT NULL,
  `forActivityID` int(11) NOT NULL,
  `forCalendarID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `comment`
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
-- Table structure for table `friendship`
--

CREATE TABLE `friendship` (
  `friendshipID` int(11) NOT NULL,
  `forPlayerID` int(11) NOT NULL,
  `forFriendID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE `game` (
  `gameID` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `player`
--

CREATE TABLE `player` (
  `playerID` int(11) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `post`
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
-- Table structure for table `reference`
--

CREATE TABLE `reference` (
  `referenceID` int(11) NOT NULL,
  `forVersionID` int(11) NOT NULL,
  `forArticleID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `referenceversion`
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
-- Table structure for table `score`
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
-- Table structure for table `selected_accept`
--

CREATE TABLE `selected_accept` (
  `forWikiID` int(11) NOT NULL,
  `forAccountID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `selected_edit`
--

CREATE TABLE `selected_edit` (
  `forWikiID` int(11) NOT NULL,
  `forAccountID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wiki`
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

-- --------------------------------------------------------

--
-- Table structure for table `wikiuser`
--

CREATE TABLE `wikiuser` (
  `forAccountID` int(11) NOT NULL,
  `forename` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `forWikiID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`accountID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`activityID`),
  ADD KEY `forCalendarID` (`forCalendarID`) USING BTREE;

--
-- Indexes for table `admin_blog`
--
ALTER TABLE `admin_blog`
  ADD PRIMARY KEY (`admin_blogID`),
  ADD KEY `forAccountID` (`forAccountID`),
  ADD KEY `forBlogID` (`forBlogID`);

--
-- Indexes for table `admin_calendar`
--
ALTER TABLE `admin_calendar`
  ADD PRIMARY KEY (`admin_calendarID`),
  ADD KEY `forAccountID` (`forAccountID`),
  ADD KEY `forCalendarID` (`forCalendarID`);

--
-- Indexes for table `admin_game`
--
ALTER TABLE `admin_game`
  ADD PRIMARY KEY (`admin_gameID`),
  ADD KEY `forAccountID` (`forAccountID`),
  ADD KEY `forGameID` (`forGameID`);

--
-- Indexes for table `admin_wiki`
--
ALTER TABLE `admin_wiki`
  ADD PRIMARY KEY (`admin_wikiID`),
  ADD KEY `forAccountID` (`forAccountID`),
  ADD KEY `forWikiID` (`forWikiID`);

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`articleID`),
  ADD KEY `forWikiID` (`forWikiID`),
  ADD KEY `forVersionID` (`forVersionID`);

--
-- Indexes for table `articleversion`
--
ALTER TABLE `articleversion`
  ADD PRIMARY KEY (`versionID`),
  ADD KEY `forArticleID` (`forArticleID`),
  ADD KEY `forAccountID` (`forAccountID`);

--
-- Indexes for table `articleversion_reference`
--
ALTER TABLE `articleversion_reference`
  ADD UNIQUE KEY `articleversion_reference_unique` (`forVersionID`,`forReferenceID`),
  ADD KEY `forReferenceID` (`forReferenceID`);

--
-- Indexes for table `block_account`
--
ALTER TABLE `block_account`
  ADD PRIMARY KEY (`blockID`),
  ADD KEY `forAccountID` (`forAccountID`),
  ADD KEY `forBlogID` (`forBlogID`);

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`blogID`),
  ADD UNIQUE KEY `forAccountID` (`forAccountID`) USING BTREE;

--
-- Indexes for table `blog_account`
--
ALTER TABLE `blog_account`
  ADD PRIMARY KEY (`blog_accountID`),
  ADD UNIQUE KEY `blog_account_unique` (`forBlogID`,`forAccountID`) USING BTREE,
  ADD KEY `forAccountID` (`forAccountID`);

--
-- Indexes for table `bookmark`
--
ALTER TABLE `bookmark`
  ADD UNIQUE KEY `bookmark_unique` (`forAccountID`,`forArticleID`),
  ADD KEY `forArticleID` (`forArticleID`);

--
-- Indexes for table `calendar`
--
ALTER TABLE `calendar`
  ADD PRIMARY KEY (`calendarID`);

--
-- Indexes for table `calendar_activity`
--
ALTER TABLE `calendar_activity`
  ADD PRIMARY KEY (`participationID`),
  ADD KEY `forActivityID` (`forActivityID`),
  ADD KEY `forCalendarID` (`forCalendarID`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`commentID`),
  ADD KEY `forPostID` (`forPostID`),
  ADD KEY `forAccountID` (`forAccountID`);

--
-- Indexes for table `friendship`
--
ALTER TABLE `friendship`
  ADD PRIMARY KEY (`friendshipID`),
  ADD KEY `forPlayerID` (`forPlayerID`),
  ADD KEY `forFriendID` (`forFriendID`);

--
-- Indexes for table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`gameID`);

--
-- Indexes for table `player`
--
ALTER TABLE `player`
  ADD PRIMARY KEY (`playerID`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`postID`),
  ADD KEY `forBlogID` (`forBlogID`),
  ADD KEY `forAccountID` (`forAccountID`);

--
-- Indexes for table `reference`
--
ALTER TABLE `reference`
  ADD PRIMARY KEY (`referenceID`),
  ADD KEY `forVersionID` (`forVersionID`),
  ADD KEY `forArticleID` (`forArticleID`);

--
-- Indexes for table `referenceversion`
--
ALTER TABLE `referenceversion`
  ADD PRIMARY KEY (`versionID`),
  ADD KEY `forReferenceID` (`forReferenceID`),
  ADD KEY `forAccountID` (`forAccountID`);

--
-- Indexes for table `score`
--
ALTER TABLE `score`
  ADD PRIMARY KEY (`scoreID`),
  ADD KEY `forGameID` (`forGameID`),
  ADD KEY `forPlayerID` (`forPlayerID`);

--
-- Indexes for table `selected_accept`
--
ALTER TABLE `selected_accept`
  ADD UNIQUE KEY `selected_accept_unique` (`forWikiID`,`forAccountID`),
  ADD KEY `forAccountID` (`forAccountID`);

--
-- Indexes for table `selected_edit`
--
ALTER TABLE `selected_edit`
  ADD UNIQUE KEY `selected_edit_unique` (`forWikiID`,`forAccountID`) USING BTREE,
  ADD KEY `forAccountID` (`forAccountID`);

--
-- Indexes for table `wiki`
--
ALTER TABLE `wiki`
  ADD PRIMARY KEY (`wikiID`);

--
-- Indexes for table `wikiuser`
--
ALTER TABLE `wikiuser`
  ADD PRIMARY KEY (`forAccountID`),
  ADD KEY `forWikiID` (`forWikiID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `accountID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `activityID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_blog`
--
ALTER TABLE `admin_blog`
  MODIFY `admin_blogID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_calendar`
--
ALTER TABLE `admin_calendar`
  MODIFY `admin_calendarID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_game`
--
ALTER TABLE `admin_game`
  MODIFY `admin_gameID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_wiki`
--
ALTER TABLE `admin_wiki`
  MODIFY `admin_wikiID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `articleID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `articleversion`
--
ALTER TABLE `articleversion`
  MODIFY `versionID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `block_account`
--
ALTER TABLE `block_account`
  MODIFY `blockID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `blogID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_account`
--
ALTER TABLE `blog_account`
  MODIFY `blog_accountID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `calendar`
--
ALTER TABLE `calendar`
  MODIFY `calendarID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `calendar_activity`
--
ALTER TABLE `calendar_activity`
  MODIFY `participationID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `commentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `friendship`
--
ALTER TABLE `friendship`
  MODIFY `friendshipID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `game`
--
ALTER TABLE `game`
  MODIFY `gameID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `player`
--
ALTER TABLE `player`
  MODIFY `playerID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `postID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reference`
--
ALTER TABLE `reference`
  MODIFY `referenceID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `referenceversion`
--
ALTER TABLE `referenceversion`
  MODIFY `versionID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `score`
--
ALTER TABLE `score`
  MODIFY `scoreID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wiki`
--
ALTER TABLE `wiki`
  MODIFY `wikiID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity`
--
ALTER TABLE `activity`
  ADD CONSTRAINT `activity_ibfk_1` FOREIGN KEY (`forCalendarID`) REFERENCES `calendar` (`calendarID`);

--
-- Constraints for table `admin_blog`
--
ALTER TABLE `admin_blog`
  ADD CONSTRAINT `admin_blog_ibfk_1` FOREIGN KEY (`forAccountID`) REFERENCES `account` (`accountID`),
  ADD CONSTRAINT `admin_blog_ibfk_2` FOREIGN KEY (`forBlogID`) REFERENCES `blog` (`blogID`);

--
-- Constraints for table `admin_calendar`
--
ALTER TABLE `admin_calendar`
  ADD CONSTRAINT `admin_calendar_ibfk_1` FOREIGN KEY (`forAccountID`) REFERENCES `account` (`accountID`),
  ADD CONSTRAINT `admin_calendar_ibfk_2` FOREIGN KEY (`forCalendarID`) REFERENCES `calendar` (`calendarID`);

--
-- Constraints for table `admin_game`
--
ALTER TABLE `admin_game`
  ADD CONSTRAINT `admin_game_ibfk_1` FOREIGN KEY (`forAccountID`) REFERENCES `account` (`accountID`),
  ADD CONSTRAINT `admin_game_ibfk_2` FOREIGN KEY (`forGameID`) REFERENCES `game` (`gameID`);

--
-- Constraints for table `admin_wiki`
--
ALTER TABLE `admin_wiki`
  ADD CONSTRAINT `admin_wiki_ibfk_1` FOREIGN KEY (`forAccountID`) REFERENCES `account` (`accountID`),
  ADD CONSTRAINT `admin_wiki_ibfk_2` FOREIGN KEY (`forWikiID`) REFERENCES `wiki` (`wikiID`);

--
-- Constraints for table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`forWikiID`) REFERENCES `wiki` (`wikiID`),
  ADD CONSTRAINT `article_ibfk_2` FOREIGN KEY (`forVersionID`) REFERENCES `articleversion` (`versionID`);

--
-- Constraints for table `articleversion`
--
ALTER TABLE `articleversion`
  ADD CONSTRAINT `articleversion_ibfk_1` FOREIGN KEY (`forArticleID`) REFERENCES `article` (`articleID`),
  ADD CONSTRAINT `articleversion_ibfk_2` FOREIGN KEY (`forAccountID`) REFERENCES `wikiuser` (`forAccountID`);

--
-- Constraints for table `articleversion_reference`
--
ALTER TABLE `articleversion_reference`
  ADD CONSTRAINT `articleversion_reference_ibfk_1` FOREIGN KEY (`forVersionID`) REFERENCES `articleversion` (`versionID`),
  ADD CONSTRAINT `articleversion_reference_ibfk_2` FOREIGN KEY (`forReferenceID`) REFERENCES `reference` (`referenceID`);

--
-- Constraints for table `block_account`
--
ALTER TABLE `block_account`
  ADD CONSTRAINT `block_account_ibfk_1` FOREIGN KEY (`forAccountID`) REFERENCES `account` (`accountID`),
  ADD CONSTRAINT `block_account_ibfk_2` FOREIGN KEY (`forBlogID`) REFERENCES `blog` (`blogID`);

--
-- Constraints for table `blog`
--
ALTER TABLE `blog`
  ADD CONSTRAINT `blog_ibfk_1` FOREIGN KEY (`forAccountID`) REFERENCES `account` (`accountID`);

--
-- Constraints for table `blog_account`
--
ALTER TABLE `blog_account`
  ADD CONSTRAINT `blog_account_ibfk_1` FOREIGN KEY (`forBlogID`) REFERENCES `blog` (`blogID`),
  ADD CONSTRAINT `blog_account_ibfk_2` FOREIGN KEY (`forAccountID`) REFERENCES `account` (`accountID`);

--
-- Constraints for table `bookmark`
--
ALTER TABLE `bookmark`
  ADD CONSTRAINT `bookmark_ibfk_1` FOREIGN KEY (`forAccountID`) REFERENCES `wikiuser` (`forAccountID`),
  ADD CONSTRAINT `bookmark_ibfk_2` FOREIGN KEY (`forArticleID`) REFERENCES `article` (`articleID`);

--
-- Constraints for table `calendar_activity`
--
ALTER TABLE `calendar_activity`
  ADD CONSTRAINT `calendar_activity_ibfk_1` FOREIGN KEY (`forActivityID`) REFERENCES `activity` (`activityID`),
  ADD CONSTRAINT `calendar_activity_ibfk_2` FOREIGN KEY (`forCalendarID`) REFERENCES `calendar` (`calendarID`);

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`forPostID`) REFERENCES `post` (`postID`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`forAccountID`) REFERENCES `account` (`accountID`);

--
-- Constraints for table `friendship`
--
ALTER TABLE `friendship`
  ADD CONSTRAINT `friendship_ibfk_1` FOREIGN KEY (`forPlayerID`) REFERENCES `player` (`playerID`),
  ADD CONSTRAINT `friendship_ibfk_2` FOREIGN KEY (`forFriendID`) REFERENCES `player` (`playerID`);

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`forBlogID`) REFERENCES `blog` (`blogID`),
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`forAccountID`) REFERENCES `account` (`accountID`);

--
-- Constraints for table `reference`
--
ALTER TABLE `reference`
  ADD CONSTRAINT `reference_ibfk_1` FOREIGN KEY (`forVersionID`) REFERENCES `referenceversion` (`versionID`),
  ADD CONSTRAINT `reference_ibfk_2` FOREIGN KEY (`forArticleID`) REFERENCES `article` (`articleID`);

--
-- Constraints for table `referenceversion`
--
ALTER TABLE `referenceversion`
  ADD CONSTRAINT `referenceversion_ibfk_1` FOREIGN KEY (`forReferenceID`) REFERENCES `reference` (`referenceID`),
  ADD CONSTRAINT `referenceversion_ibfk_2` FOREIGN KEY (`forAccountID`) REFERENCES `wikiuser` (`forAccountID`);

--
-- Constraints for table `score`
--
ALTER TABLE `score`
  ADD CONSTRAINT `score_ibfk_1` FOREIGN KEY (`forGameID`) REFERENCES `game` (`gameID`),
  ADD CONSTRAINT `score_ibfk_2` FOREIGN KEY (`forPlayerID`) REFERENCES `player` (`playerID`);

--
-- Constraints for table `selected_accept`
--
ALTER TABLE `selected_accept`
  ADD CONSTRAINT `selected_accept_ibfk_1` FOREIGN KEY (`forWikiID`) REFERENCES `wiki` (`wikiID`),
  ADD CONSTRAINT `selected_accept_ibfk_2` FOREIGN KEY (`forAccountID`) REFERENCES `wikiuser` (`forAccountID`);

--
-- Constraints for table `selected_edit`
--
ALTER TABLE `selected_edit`
  ADD CONSTRAINT `selected_edit_ibfk_1` FOREIGN KEY (`forWikiID`) REFERENCES `wiki` (`wikiID`),
  ADD CONSTRAINT `selected_edit_ibfk_2` FOREIGN KEY (`forAccountID`) REFERENCES `wikiuser` (`forAccountID`);

--
-- Constraints for table `wikiuser`
--
ALTER TABLE `wikiuser`
  ADD CONSTRAINT `wikiuser_ibfk_1` FOREIGN KEY (`forAccountID`) REFERENCES `account` (`accountID`),
  ADD CONSTRAINT `wikiuser_ibfk_2` FOREIGN KEY (`forWikiID`) REFERENCES `wiki` (`wikiID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
