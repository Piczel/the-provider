-- MySQL dump 10.16  Distrib 10.1.34-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: theprovider_db
-- ------------------------------------------------------
-- Server version	10.1.34-MariaDB-0ubuntu0.18.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account` (
  `accountID` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `token` varchar(20) DEFAULT NULL,
  `tokenTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `triggerUpdate` tinyint(4) NOT NULL DEFAULT '0',
  `type` enum('superadmin','admin','normal') NOT NULL DEFAULT 'normal',
  PRIMARY KEY (`accountID`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account`
--

LOCK TABLES `account` WRITE;
/*!40000 ALTER TABLE `account` DISABLE KEYS */;
INSERT INTO `account` VALUES (1,'user@theprovider.com','$2y$10$/hUr3xBZ9uzr1TSSy0I2ZuFgXhi9PMSlt5tFx79c40ZkZRt/wQVGy','User','b2987030d5c94b6e9615','2018-10-18 08:33:39',1,'normal'),(2,'user@the-provider.com','qwer1234','TheUser','aaaaaaaaaaaaaaaaaaaa','2018-10-18 08:25:30',1,'normal');
/*!40000 ALTER TABLE `account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `activity`
--

DROP TABLE IF EXISTS `activity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity` (
  `activityID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `location` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `repetition` smallint(6) NOT NULL,
  `startTime` datetime NOT NULL,
  `endTime` datetime NOT NULL,
  `forCalendarID` int(11) NOT NULL,
  PRIMARY KEY (`activityID`),
  KEY `forCalendarID` (`forCalendarID`) USING BTREE,
  CONSTRAINT `activity_ibfk_1` FOREIGN KEY (`forCalendarID`) REFERENCES `calendar` (`calendarID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity`
--

LOCK TABLES `activity` WRITE;
/*!40000 ALTER TABLE `activity` DISABLE KEYS */;
INSERT INTO `activity` VALUES (2,'Pedram','ITG','lmao',1,'2018-10-16 12:00:00','2018-10-17 21:00:00',2),(3,'asdasdfasdfg','asdf','asdfasdf',3,'2018-10-05 00:00:00','2018-10-06 00:00:00',2);
/*!40000 ALTER TABLE `activity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_blog`
--

DROP TABLE IF EXISTS `admin_blog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_blog` (
  `admin_blogID` int(11) NOT NULL AUTO_INCREMENT,
  `activated_tp` tinyint(1) NOT NULL DEFAULT '1',
  `activated_user` tinyint(1) NOT NULL DEFAULT '1',
  `forAccountID` int(11) NOT NULL,
  `forBlogID` int(11) NOT NULL,
  PRIMARY KEY (`admin_blogID`),
  KEY `forAccountID` (`forAccountID`),
  KEY `forBlogID` (`forBlogID`),
  CONSTRAINT `admin_blog_ibfk_1` FOREIGN KEY (`forAccountID`) REFERENCES `account` (`accountID`),
  CONSTRAINT `admin_blog_ibfk_2` FOREIGN KEY (`forBlogID`) REFERENCES `blog` (`blogID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_blog`
--

LOCK TABLES `admin_blog` WRITE;
/*!40000 ALTER TABLE `admin_blog` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_blog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_calendar`
--

DROP TABLE IF EXISTS `admin_calendar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_calendar` (
  `admin_calendarID` int(11) NOT NULL AUTO_INCREMENT,
  `activated_tp` tinyint(1) NOT NULL DEFAULT '1',
  `activated_user` tinyint(1) NOT NULL DEFAULT '1',
  `forAccountID` int(11) NOT NULL,
  `forCalendarID` int(11) NOT NULL,
  PRIMARY KEY (`admin_calendarID`),
  KEY `forAccountID` (`forAccountID`),
  KEY `forCalendarID` (`forCalendarID`),
  CONSTRAINT `admin_calendar_ibfk_1` FOREIGN KEY (`forAccountID`) REFERENCES `account` (`accountID`),
  CONSTRAINT `admin_calendar_ibfk_2` FOREIGN KEY (`forCalendarID`) REFERENCES `calendar` (`calendarID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_calendar`
--

LOCK TABLES `admin_calendar` WRITE;
/*!40000 ALTER TABLE `admin_calendar` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_calendar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_game`
--

DROP TABLE IF EXISTS `admin_game`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_game` (
  `admin_gameID` int(11) NOT NULL AUTO_INCREMENT,
  `activated_tp` tinyint(1) NOT NULL DEFAULT '1',
  `activated_user` tinyint(1) NOT NULL DEFAULT '1',
  `forAccountID` int(11) NOT NULL,
  `forGameID` int(11) NOT NULL,
  PRIMARY KEY (`admin_gameID`),
  KEY `forAccountID` (`forAccountID`),
  KEY `forGameID` (`forGameID`),
  CONSTRAINT `admin_game_ibfk_1` FOREIGN KEY (`forAccountID`) REFERENCES `account` (`accountID`),
  CONSTRAINT `admin_game_ibfk_2` FOREIGN KEY (`forGameID`) REFERENCES `game` (`gameID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_game`
--

LOCK TABLES `admin_game` WRITE;
/*!40000 ALTER TABLE `admin_game` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_game` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_wiki`
--

DROP TABLE IF EXISTS `admin_wiki`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_wiki` (
  `admin_wikiID` int(11) NOT NULL AUTO_INCREMENT,
  `activated_tp` tinyint(1) NOT NULL DEFAULT '1',
  `activated_user` tinyint(1) NOT NULL DEFAULT '1',
  `forAccountID` int(11) NOT NULL,
  `forWikiID` int(11) NOT NULL,
  PRIMARY KEY (`admin_wikiID`),
  KEY `forAccountID` (`forAccountID`),
  KEY `forWikiID` (`forWikiID`),
  CONSTRAINT `admin_wiki_ibfk_1` FOREIGN KEY (`forAccountID`) REFERENCES `account` (`accountID`),
  CONSTRAINT `admin_wiki_ibfk_2` FOREIGN KEY (`forWikiID`) REFERENCES `wiki` (`wikiID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_wiki`
--

LOCK TABLES `admin_wiki` WRITE;
/*!40000 ALTER TABLE `admin_wiki` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_wiki` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article`
--

DROP TABLE IF EXISTS `article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article` (
  `articleID` int(11) NOT NULL AUTO_INCREMENT,
  `forVersionID` int(11) DEFAULT NULL,
  `forWikiID` int(11) NOT NULL,
  PRIMARY KEY (`articleID`),
  KEY `forWikiID` (`forWikiID`),
  KEY `forVersionID` (`forVersionID`),
  CONSTRAINT `article_ibfk_1` FOREIGN KEY (`forWikiID`) REFERENCES `wiki` (`wikiID`),
  CONSTRAINT `article_ibfk_2` FOREIGN KEY (`forVersionID`) REFERENCES `articleversion` (`versionID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article`
--

LOCK TABLES `article` WRITE;
/*!40000 ALTER TABLE `article` DISABLE KEYS */;
/*!40000 ALTER TABLE `article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `articleversion`
--

DROP TABLE IF EXISTS `articleversion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articleversion` (
  `versionID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `forArticleID` int(11) NOT NULL,
  `forAccountID` int(11) NOT NULL,
  PRIMARY KEY (`versionID`),
  KEY `forArticleID` (`forArticleID`),
  KEY `forAccountID` (`forAccountID`),
  CONSTRAINT `articleversion_ibfk_1` FOREIGN KEY (`forArticleID`) REFERENCES `article` (`articleID`),
  CONSTRAINT `articleversion_ibfk_2` FOREIGN KEY (`forAccountID`) REFERENCES `wikiuser` (`forAccountID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articleversion`
--

LOCK TABLES `articleversion` WRITE;
/*!40000 ALTER TABLE `articleversion` DISABLE KEYS */;
/*!40000 ALTER TABLE `articleversion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `articleversion_reference`
--

DROP TABLE IF EXISTS `articleversion_reference`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articleversion_reference` (
  `forVersionID` int(11) NOT NULL,
  `forReferenceID` int(11) NOT NULL,
  UNIQUE KEY `articleversion_reference_unique` (`forVersionID`,`forReferenceID`),
  KEY `forReferenceID` (`forReferenceID`),
  CONSTRAINT `articleversion_reference_ibfk_1` FOREIGN KEY (`forVersionID`) REFERENCES `articleversion` (`versionID`),
  CONSTRAINT `articleversion_reference_ibfk_2` FOREIGN KEY (`forReferenceID`) REFERENCES `reference` (`referenceID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articleversion_reference`
--

LOCK TABLES `articleversion_reference` WRITE;
/*!40000 ALTER TABLE `articleversion_reference` DISABLE KEYS */;
/*!40000 ALTER TABLE `articleversion_reference` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog`
--

DROP TABLE IF EXISTS `blog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog` (
  `blogID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `forAccountID` int(11) NOT NULL,
  PRIMARY KEY (`blogID`),
  UNIQUE KEY `forAccountID` (`forAccountID`) USING BTREE,
  CONSTRAINT `blog_ibfk_1` FOREIGN KEY (`forAccountID`) REFERENCES `account` (`accountID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog`
--

LOCK TABLES `blog` WRITE;
/*!40000 ALTER TABLE `blog` DISABLE KEYS */;
INSERT INTO `blog` VALUES (1,'Min ny blogg',1);
/*!40000 ALTER TABLE `blog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_account`
--

DROP TABLE IF EXISTS `blog_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_account` (
  `blog_accountID` int(11) NOT NULL AUTO_INCREMENT,
  `forBlogID` int(11) NOT NULL,
  `forAccountID` int(11) NOT NULL,
  PRIMARY KEY (`blog_accountID`),
  UNIQUE KEY `blog_account_unique` (`forBlogID`,`forAccountID`) USING BTREE,
  KEY `forAccountID` (`forAccountID`),
  CONSTRAINT `blog_account_ibfk_1` FOREIGN KEY (`forBlogID`) REFERENCES `blog` (`blogID`),
  CONSTRAINT `blog_account_ibfk_2` FOREIGN KEY (`forAccountID`) REFERENCES `account` (`accountID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_account`
--

LOCK TABLES `blog_account` WRITE;
/*!40000 ALTER TABLE `blog_account` DISABLE KEYS */;
/*!40000 ALTER TABLE `blog_account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bookmark`
--

DROP TABLE IF EXISTS `bookmark`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bookmark` (
  `forAccountID` int(11) NOT NULL,
  `forArticleID` int(11) NOT NULL,
  UNIQUE KEY `bookmark_unique` (`forAccountID`,`forArticleID`),
  KEY `forArticleID` (`forArticleID`),
  CONSTRAINT `bookmark_ibfk_1` FOREIGN KEY (`forAccountID`) REFERENCES `wikiuser` (`forAccountID`),
  CONSTRAINT `bookmark_ibfk_2` FOREIGN KEY (`forArticleID`) REFERENCES `article` (`articleID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookmark`
--

LOCK TABLES `bookmark` WRITE;
/*!40000 ALTER TABLE `bookmark` DISABLE KEYS */;
/*!40000 ALTER TABLE `bookmark` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `calendar`
--

DROP TABLE IF EXISTS `calendar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calendar` (
  `calendarID` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`calendarID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calendar`
--

LOCK TABLES `calendar` WRITE;
/*!40000 ALTER TABLE `calendar` DISABLE KEYS */;
INSERT INTO `calendar` VALUES (1),(2);
/*!40000 ALTER TABLE `calendar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment` (
  `commentID` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `date` date NOT NULL,
  `forPostID` int(11) NOT NULL,
  `forAccountID` int(11) NOT NULL,
  PRIMARY KEY (`commentID`),
  KEY `forPostID` (`forPostID`),
  KEY `forAccountID` (`forAccountID`),
  CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`forPostID`) REFERENCES `post` (`postID`),
  CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`forAccountID`) REFERENCES `account` (`accountID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `friendship`
--

DROP TABLE IF EXISTS `friendship`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `friendship` (
  `friendshipID` int(11) NOT NULL AUTO_INCREMENT,
  `forPlayerID` int(11) NOT NULL,
  `forFriendID` int(11) NOT NULL,
  PRIMARY KEY (`friendshipID`),
  KEY `forPlayerID` (`forPlayerID`),
  KEY `forFriendID` (`forFriendID`),
  CONSTRAINT `friendship_ibfk_1` FOREIGN KEY (`forPlayerID`) REFERENCES `player` (`playerID`),
  CONSTRAINT `friendship_ibfk_2` FOREIGN KEY (`forFriendID`) REFERENCES `player` (`playerID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friendship`
--

LOCK TABLES `friendship` WRITE;
/*!40000 ALTER TABLE `friendship` DISABLE KEYS */;
/*!40000 ALTER TABLE `friendship` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `game`
--

DROP TABLE IF EXISTS `game`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `game` (
  `gameID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`gameID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `game`
--

LOCK TABLES `game` WRITE;
/*!40000 ALTER TABLE `game` DISABLE KEYS */;
/*!40000 ALTER TABLE `game` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `participation`
--

DROP TABLE IF EXISTS `participation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `participation` (
  `participationID` int(11) NOT NULL AUTO_INCREMENT,
  `forActivityID` int(11) NOT NULL,
  `forCalendarID` int(11) NOT NULL,
  PRIMARY KEY (`participationID`),
  KEY `forActivityID` (`forActivityID`),
  KEY `forCalendarID` (`forCalendarID`),
  CONSTRAINT `participation_ibfk_1` FOREIGN KEY (`forActivityID`) REFERENCES `activity` (`activityID`),
  CONSTRAINT `participation_ibfk_2` FOREIGN KEY (`forCalendarID`) REFERENCES `calendar` (`calendarID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `participation`
--

LOCK TABLES `participation` WRITE;
/*!40000 ALTER TABLE `participation` DISABLE KEYS */;
/*!40000 ALTER TABLE `participation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `player`
--

DROP TABLE IF EXISTS `player`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `player` (
  `playerID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`playerID`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `player`
--

LOCK TABLES `player` WRITE;
/*!40000 ALTER TABLE `player` DISABLE KEYS */;
/*!40000 ALTER TABLE `player` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post` (
  `postID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `date` date NOT NULL,
  `forBlogID` int(11) NOT NULL,
  `forAccountID` int(11) NOT NULL,
  PRIMARY KEY (`postID`),
  KEY `forBlogID` (`forBlogID`),
  KEY `forAccountID` (`forAccountID`),
  CONSTRAINT `post_ibfk_1` FOREIGN KEY (`forBlogID`) REFERENCES `blog` (`blogID`),
  CONSTRAINT `post_ibfk_2` FOREIGN KEY (`forAccountID`) REFERENCES `account` (`accountID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post`
--

LOCK TABLES `post` WRITE;
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
/*!40000 ALTER TABLE `post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reference`
--

DROP TABLE IF EXISTS `reference`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reference` (
  `referenceID` int(11) NOT NULL AUTO_INCREMENT,
  `forVersionID` int(11) NOT NULL,
  `forArticleID` int(11) NOT NULL,
  PRIMARY KEY (`referenceID`),
  KEY `forVersionID` (`forVersionID`),
  KEY `forArticleID` (`forArticleID`),
  CONSTRAINT `reference_ibfk_1` FOREIGN KEY (`forVersionID`) REFERENCES `referenceversion` (`versionID`),
  CONSTRAINT `reference_ibfk_2` FOREIGN KEY (`forArticleID`) REFERENCES `article` (`articleID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reference`
--

LOCK TABLES `reference` WRITE;
/*!40000 ALTER TABLE `reference` DISABLE KEYS */;
/*!40000 ALTER TABLE `reference` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `referenceversion`
--

DROP TABLE IF EXISTS `referenceversion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `referenceversion` (
  `versionID` int(11) NOT NULL AUTO_INCREMENT,
  `content` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `forReferenceID` int(11) NOT NULL,
  `forAccountID` int(11) NOT NULL,
  PRIMARY KEY (`versionID`),
  KEY `forReferenceID` (`forReferenceID`),
  KEY `forAccountID` (`forAccountID`),
  CONSTRAINT `referenceversion_ibfk_1` FOREIGN KEY (`forReferenceID`) REFERENCES `reference` (`referenceID`),
  CONSTRAINT `referenceversion_ibfk_2` FOREIGN KEY (`forAccountID`) REFERENCES `wikiuser` (`forAccountID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `referenceversion`
--

LOCK TABLES `referenceversion` WRITE;
/*!40000 ALTER TABLE `referenceversion` DISABLE KEYS */;
/*!40000 ALTER TABLE `referenceversion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `score`
--

DROP TABLE IF EXISTS `score`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `score` (
  `scoreID` int(11) NOT NULL AUTO_INCREMENT,
  `score` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `forGameID` int(11) NOT NULL,
  `forPlayerID` int(11) NOT NULL,
  PRIMARY KEY (`scoreID`),
  KEY `forGameID` (`forGameID`),
  KEY `forPlayerID` (`forPlayerID`),
  CONSTRAINT `score_ibfk_1` FOREIGN KEY (`forGameID`) REFERENCES `game` (`gameID`),
  CONSTRAINT `score_ibfk_2` FOREIGN KEY (`forPlayerID`) REFERENCES `player` (`playerID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `score`
--

LOCK TABLES `score` WRITE;
/*!40000 ALTER TABLE `score` DISABLE KEYS */;
/*!40000 ALTER TABLE `score` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `selected_accept`
--

DROP TABLE IF EXISTS `selected_accept`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `selected_accept` (
  `forWikiID` int(11) NOT NULL,
  `forAccountID` int(11) NOT NULL,
  UNIQUE KEY `selected_accept_unique` (`forWikiID`,`forAccountID`),
  KEY `forAccountID` (`forAccountID`),
  CONSTRAINT `selected_accept_ibfk_1` FOREIGN KEY (`forWikiID`) REFERENCES `wiki` (`wikiID`),
  CONSTRAINT `selected_accept_ibfk_2` FOREIGN KEY (`forAccountID`) REFERENCES `wikiuser` (`forAccountID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `selected_accept`
--

LOCK TABLES `selected_accept` WRITE;
/*!40000 ALTER TABLE `selected_accept` DISABLE KEYS */;
/*!40000 ALTER TABLE `selected_accept` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `selected_edit`
--

DROP TABLE IF EXISTS `selected_edit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `selected_edit` (
  `forWikiID` int(11) NOT NULL,
  `forAccountID` int(11) NOT NULL,
  UNIQUE KEY `selected_edit_unique` (`forWikiID`,`forAccountID`) USING BTREE,
  KEY `forAccountID` (`forAccountID`),
  CONSTRAINT `selected_edit_ibfk_1` FOREIGN KEY (`forWikiID`) REFERENCES `wiki` (`wikiID`),
  CONSTRAINT `selected_edit_ibfk_2` FOREIGN KEY (`forAccountID`) REFERENCES `wikiuser` (`forAccountID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `selected_edit`
--

LOCK TABLES `selected_edit` WRITE;
/*!40000 ALTER TABLE `selected_edit` DISABLE KEYS */;
/*!40000 ALTER TABLE `selected_edit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wiki`
--

DROP TABLE IF EXISTS `wiki`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wiki` (
  `wikiID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(3000) NOT NULL,
  `mayEdit` enum('superuser','selected','any') NOT NULL DEFAULT 'any',
  `mayAccept` enum('superuser','selected','auto') NOT NULL DEFAULT 'selected',
  `mayAssignEdit` enum('superuser','selected') NOT NULL DEFAULT 'superuser',
  `mayAssignAccept` enum('superuser','selected') NOT NULL DEFAULT 'superuser',
  `forAccountID` int(11) NOT NULL,
  PRIMARY KEY (`wikiID`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wiki`
--

LOCK TABLES `wiki` WRITE;
/*!40000 ALTER TABLE `wiki` DISABLE KEYS */;
INSERT INTO `wiki` VALUES (1,'Namn på wiki','Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.','superuser','auto','selected','selected',2),(2,'Namn på wiki','Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.','any','selected','superuser','superuser',2),(3,'Namn på wiki','Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.','any','selected','superuser','superuser',2),(4,'Namn på wiki','Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.','any','selected','superuser','superuser',2),(5,'Namn på wiki','Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.','any','selected','superuser','superuser',2),(6,'Namn på wiki','Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.','any','selected','superuser','superuser',2),(7,'Namn på wiki','Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.','any','selected','superuser','superuser',2),(8,'Namn på wiki','Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.','any','selected','superuser','superuser',2),(9,'Namn på wiki','Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.','any','selected','superuser','superuser',2),(10,'Namn på wiki','Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.','any','selected','superuser','superuser',2),(11,'Namn på wikiaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa','Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.','any','selected','superuser','superuser',2),(12,'Namn på wiki','Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.','any','selected','superuser','superuser',2),(13,'Namn på wiki','Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.','any','selected','superuser','superuser',2),(14,'Namn på wiki','Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.','any','selected','superuser','superuser',2),(15,'Namn på wiki','Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.','any','selected','superuser','superuser',2),(16,'Namn på wiki','Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.','any','selected','superuser','superuser',2),(17,'Namn på wiki','Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.','any','selected','superuser','superuser',2),(18,'Namn på wiki','Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.','any','selected','superuser','superuser',2),(19,'Namn på wiki','Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.','any','selected','superuser','superuser',2),(21,'Namn på wiki','Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.','any','selected','superuser','superuser',2),(22,'Namn på wiki','Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.','any','selected','superuser','superuser',2),(26,'Namn på wiki','Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.','any','selected','superuser','superuser',2),(27,'Namn på wiki','Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.','any','selected','superuser','superuser',2),(28,'Namn på wiki','Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.','any','selected','superuser','superuser',2),(29,'Namn på wiki','Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.','any','selected','superuser','superuser',2),(30,'Namn på wiki','Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.','any','selected','superuser','superuser',2),(31,'Namn på wiki','Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.','any','selected','superuser','superuser',2),(32,'Namn på wiki','Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.','any','selected','superuser','superuser',2),(33,'Namn på wiki','Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.','any','selected','superuser','superuser',2),(34,'Namn på wiki','Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.','any','selected','superuser','superuser',2),(35,'Namn på wiki','Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.','any','selected','superuser','superuser',0),(36,'Namn på wiki','Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.','any','selected','superuser','superuser',0),(37,'Namn på wiki','Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis dolor dignissimos odio quaerat dolorum vel facere ratione necessitatibus distinctio dolores veniam corrupti praesentium sint excepturi, illum totam, quia quibusdam animi.','any','selected','superuser','superuser',0);
/*!40000 ALTER TABLE `wiki` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wikiuser`
--

DROP TABLE IF EXISTS `wikiuser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wikiuser` (
  `forAccountID` int(11) NOT NULL,
  `forename` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `forWikiID` int(11) NOT NULL,
  PRIMARY KEY (`forAccountID`),
  KEY `forWikiID` (`forWikiID`),
  CONSTRAINT `wikiuser_ibfk_1` FOREIGN KEY (`forAccountID`) REFERENCES `account` (`accountID`),
  CONSTRAINT `wikiuser_ibfk_2` FOREIGN KEY (`forWikiID`) REFERENCES `wiki` (`wikiID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wikiuser`
--

LOCK TABLES `wikiuser` WRITE;
/*!40000 ALTER TABLE `wikiuser` DISABLE KEYS */;
INSERT INTO `wikiuser` VALUES (1,'','',1);
/*!40000 ALTER TABLE `wikiuser` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-10-24 10:36:29
