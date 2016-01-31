-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 21, 2013 at 06:01 AM
-- Server version: 5.1.58
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pm`
--

-- --------------------------------------------------------

--
-- Table structure for table `Agenda`
--

CREATE TABLE IF NOT EXISTS `Agenda` (
  `AgendaID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `Topic` varchar(250) NOT NULL,
  `Description` text NOT NULL,
  `DateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`AgendaID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `Agenda`
--

INSERT INTO `Agenda` (`AgendaID`, `UserID`, `Topic`, `Description`, `DateCreated`) VALUES
(4, 1, 'Vergadering IN', 'Aanstaande woensdag is er weer een nieuwe vergadering van Integraal Natuurlijk te Maarssen.', '2013-09-07 03:53:49'),
(5, 2, 'finish pending work by tomorrow', 'finish pending work by tomorrow', '2013-09-10 18:09:08'),
(6, 2, 'test', 'test 123', '2013-09-12 17:29:16'),
(7, 2, 'asdfa', '123123123', '2013-09-12 17:34:03');

-- --------------------------------------------------------

--
-- Table structure for table `Documents`
--

CREATE TABLE IF NOT EXISTS `Documents` (
  `DocumentID` int(11) NOT NULL AUTO_INCREMENT,
  `DocumentName` varchar(100) NOT NULL,
  `ParentDocumentID` int(11) DEFAULT NULL,
  `DocumentPath` varchar(500) DEFAULT NULL,
  `IsFolder` char(1) DEFAULT NULL,
  `WorkgroupID` int(11) DEFAULT '0',
  `DateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CreatedBy` int(11) NOT NULL,
  PRIMARY KEY (`DocumentID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `Documents`
--

INSERT INTO `Documents` (`DocumentID`, `DocumentName`, `ParentDocumentID`, `DocumentPath`, `IsFolder`, `WorkgroupID`, `DateCreated`, `CreatedBy`) VALUES
(1, 'excel', 0, '/excel', 'Y', 0, '2013-08-16 17:11:27', 1),
(3, 'Mobile Contact List.csv', 1, '/excel/Mobile Contact List.csv', 'N', 0, '2013-08-16 17:12:02', 1),
(9, 'pdf', 0, '/pdf', 'Y', 3, '2013-08-27 17:12:49', 2),
(10, 'Account_Summary_profile.png', 9, '/pdf/Account_Summary_profile.png', 'N', 3, '2013-08-27 17:18:05', 2),
(11, 'Gaurav', 0, '/Gaurav', 'Y', 3, '2013-08-29 19:03:08', 0),
(12, 'rakesh.rar', 11, '/Gaurav/rakesh.rar', 'N', 3, '2013-08-29 19:05:18', 2),
(33, 'test786', 30, '/excel/test/test786', 'Y', 0, '2013-09-12 17:25:16', 2),
(32, 'invoice.html', 30, '/excel/test/invoice.html', 'N', 0, '2013-09-12 17:05:42', 0),
(31, 'index.txt', 0, '/index.txt', 'N', 0, '2013-09-12 16:56:36', 0),
(25, 'Submit.zip', 11, '/Gaurav/Submit.zip', 'N', 3, '2013-09-02 18:25:36', 2),
(29, 'Rakesh', 0, '/Rakesh', 'Y', 0, '2013-09-10 13:00:51', 0),
(30, 'test', 1, '/excel/test', 'Y', 0, '2013-09-10 14:30:05', 0),
(27, 'ga.js', 1, '/excel/ga.js', 'N', 0, '2013-09-03 12:47:42', 0),
(23, '1.xps', 0, '/1.xps', 'N', 0, '2013-08-31 05:25:17', 1),
(28, 'jquery.js', 11, '/Gaurav/jquery.js', 'N', 3, '2013-09-03 12:48:02', 0);

-- --------------------------------------------------------

--
-- Table structure for table `JoinUserWorkgroup`
--

CREATE TABLE IF NOT EXISTS `JoinUserWorkgroup` (
  `JoinUserWorkgroupID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `WorkgroupID` int(11) NOT NULL,
  `RoleID` smallint(6) NOT NULL,
  PRIMARY KEY (`JoinUserWorkgroupID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `JoinUserWorkgroup`
--

INSERT INTO `JoinUserWorkgroup` (`JoinUserWorkgroupID`, `UserID`, `WorkgroupID`, `RoleID`) VALUES
(1, 2, 3, 2),
(2, 3, 2, 2),
(3, 4, 1, 3),
(4, 5, 4, 0),
(5, 6, 4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `Message`
--

CREATE TABLE IF NOT EXISTS `Message` (
  `MessageID` int(11) NOT NULL AUTO_INCREMENT,
  `MessageText` text NOT NULL,
  `DateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CreatedBy` int(11) NOT NULL,
  `SubjectID` int(11) NOT NULL,
  PRIMARY KEY (`MessageID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `Message`
--

INSERT INTO `Message` (`MessageID`, `MessageText`, `DateCreated`, `CreatedBy`, `SubjectID`) VALUES
(1, 'Samantha Power is first U.S. official to directly accuse Syria regime of using chemical weapons on civilians;', '2013-08-27 19:28:09', 1, 1),
(2, 'Samantha Power is first U.S. official to directly accuse Syria regime of using chemical weapons on civilians; CBS reports that Obama ordered advisers to compile document justifying Syria strike', '2013-08-27 19:28:27', 1, 1),
(17, 'On the contrary, &lt;b&gt;mark at dreamjunky.comno-spam&lt;/b&gt;, this function is rightfully named.  Allow me to explain.  Although it does re-add the line break, it does so in an attempt to stay standards-compliant with the W3C recommendations for code format.\r\n\r\nAccording to said recommendations, a new line character must follow a line break tag.  In this situation, the new line is not removed, but a break tag is added for proper browser display where a paragraph isn''t necessary or wanted.', '2013-09-12 17:19:59', 2, 4),
(16, 'New Message added', '2013-09-12 17:14:35', 2, 9),
(11, 'Hallo allemaal,\r\n\r\nAanstaande woensdag is er een vergadering van IN. Is het mogelijk dat ik met iemand kan meerijden?\r\n\r\nGroetjes Stefanie', '2013-09-07 03:38:06', 1, 8),
(12, 'Hoi Stefanie,,\r\n\r\nJe kunt met mij meerijden.', '2013-09-07 03:39:15', 1, 8),
(13, 'test message', '2013-09-10 14:28:38', 1, 3),
(14, 'test message updated', '2013-09-10 14:29:00', 1, 3),
(15, 'TTTTT admin123', '2013-09-12 16:24:20', 1, 3),
(10, 'http://192.168.1.1/pm/admin/index.php?model=messageboard&amp;type=int&amp;action=edit&amp;id=10', '2013-09-03 12:05:13', 1, 7);

-- --------------------------------------------------------

--
-- Table structure for table `MessageSubject`
--

CREATE TABLE IF NOT EXISTS `MessageSubject` (
  `MessageSubjectID` int(11) NOT NULL AUTO_INCREMENT,
  `SubjectName` varchar(250) NOT NULL,
  `WorkgroupID` int(11) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `DateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`MessageSubjectID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `MessageSubject`
--

INSERT INTO `MessageSubject` (`MessageSubjectID`, `SubjectName`, `WorkgroupID`, `CreatedBy`, `DateCreated`) VALUES
(1, 'Employee : After Kerry cites evidence of gas attack', 1, 1, '2013-08-27 19:27:45'),
(9, 'New Subject updated', 0, 2, '2013-09-12 17:13:54'),
(3, 'test123', 0, 4, '2013-08-27 19:46:55'),
(4, 'CEO', 3, 1, '2013-08-29 13:10:27'),
(7, 'internal mesage updated', 1, 1, '2013-09-03 11:58:11'),
(10, 'Test', 0, 2, '2013-09-16 16:07:10'),
(8, 'Vergadering IN 11 september', 0, 1, '2013-09-07 03:37:24');

-- --------------------------------------------------------

--
-- Table structure for table `Role`
--

CREATE TABLE IF NOT EXISTS `Role` (
  `RoleID` smallint(6) NOT NULL AUTO_INCREMENT,
  `RoleName` varchar(50) NOT NULL,
  PRIMARY KEY (`RoleID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `Role`
--

INSERT INTO `Role` (`RoleID`, `RoleName`) VALUES
(2, 'Contributor'),
(3, 'ReadOnly');

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE IF NOT EXISTS `User` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(50) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `IsAdmin` tinyint(1) NOT NULL,
  `IsBoardMember` enum('Y','N') NOT NULL DEFAULT 'N',
  `Email` varchar(50) NOT NULL,
  `Status` char(1) NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`UserID`, `UserName`, `Password`, `IsAdmin`, `IsBoardMember`, `Email`, `Status`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1, 'N', 'rakesh@gmail.com', '0'),
(2, 'gaurav', '29be54a52396750258d886abc5417fda', 0, 'N', 'gaurav@gmail.com', '0'),
(3, 'pankaj', '95deb5011a8fe1ccf6552bb5bcda2ff0', 0, 'N', 'pankaj@gmail.com', '0'),
(4, 'rakesh', '67a05e3822ce48a6386746388e6c81f5', 0, 'N', 'rakesh@gmail.com', '0'),
(5, 'KTNO Stefanie', 'd7ba5feab6f2bcf67959f861ac39c06d', 0, 'N', 's.straeter@illustraeter.nl', '0'),
(6, 'demo', 'fe01ce2a7fbac8fafaed7c982a04e229', 0, 'Y', 'rakesh@arxmind.com', '0');

-- --------------------------------------------------------

--
-- Table structure for table `Workgroup`
--

CREATE TABLE IF NOT EXISTS `Workgroup` (
  `WorkgroupID` int(11) NOT NULL AUTO_INCREMENT,
  `WorkgroupName` varchar(50) NOT NULL,
  `DateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`WorkgroupID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `Workgroup`
--

INSERT INTO `Workgroup` (`WorkgroupID`, `WorkgroupName`, `DateCreated`) VALUES
(1, 'Employee', '2013-08-01 12:40:02'),
(2, 'Manager', '2013-08-01 12:43:26'),
(3, 'CEO', '2013-08-02 11:26:52'),
(4, 'Communicatie', '2013-09-07 03:29:23');
