-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 27, 2020 at 11:16 AM
-- Server version: 5.7.29-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `SF2`
--

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `Id` bigint(20) NOT NULL,
  `PersonId` int(11) NOT NULL,
  `Type` varchar(300) NOT NULL,
  `Value` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `Id` int(11) NOT NULL,
  `Name` varchar(3000) NOT NULL,
  `IsPrivate` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `domains`
--

CREATE TABLE `domains` (
  `Id` int(11) NOT NULL,
  `Name` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `emails`
--

CREATE TABLE `emails` (
  `Id` bigint(20) NOT NULL,
  `IsOutbound` bit(1) NOT NULL,
  `Title` varchar(3000) NOT NULL,
  `ReceiveDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `RAW` longtext NOT NULL,
  `MessageId` varchar(500) NOT NULL,
  `ReplyId` varchar(500) NOT NULL,
  `Sender` varchar(300) NOT NULL,
  `Date` varchar(50) NOT NULL,
  `Message` longtext NOT NULL,
  `MessageNormal` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `MasterId` char(36) NOT NULL,
  `Id` int(11) NOT NULL,
  `Title` varchar(400) DEFAULT NULL,
  `Submit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `BinContent` longblob,
  `Body` longtext,
  `PersonId` int(11) DEFAULT NULL,
  `Status` char(15) DEFAULT 'DRAFT' COMMENT 'Post lifecycle',
  `Language` varchar(5) DEFAULT 'fa-IR',
  `IsDeleted` bit(1) NOT NULL DEFAULT b'0',
  `IsContentDeleted` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `post_contributers`
-- (See below for the actual view)
--
CREATE TABLE `post_contributers` (
`MasterID` char(36)
,`ID` int(11)
,`PersonId` int(11)
,`Username` varchar(45)
,`Submit` datetime
,`Language` varchar(5)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `post_details`
-- (See below for the actual view)
--
CREATE TABLE `post_details` (
`MasterId` char(36)
,`Title` varchar(400)
,`ID` int(11)
,`Submit` datetime
,`PersonId` int(11)
,`Username` varchar(45)
,`Body` longtext
,`Status` char(15)
,`Language` varchar(5)
,`BinContent` longblob
);

-- --------------------------------------------------------

--
-- Table structure for table `share_post_people`
--

CREATE TABLE `share_post_people` (
  `Id` bigint(20) NOT NULL,
  `PostMasterId` char(36) NOT NULL,
  `PersonId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `share_post_team`
--

CREATE TABLE `share_post_team` (
  `Id` bigint(20) NOT NULL,
  `PostMasterId` char(36) NOT NULL,
  `TeamId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `staffs`
--

CREATE TABLE `staffs` (
  `PersonId` int(11) NOT NULL,
  `DepartmentId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `Id` int(11) NOT NULL,
  `Code` varchar(50) NOT NULL,
  `Title` varchar(300) NOT NULL,
  `Owner` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `team_domains`
--

CREATE TABLE `team_domains` (
  `Id` bigint(20) NOT NULL,
  `TeamId` int(11) NOT NULL,
  `DomainId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `Id` bigint(20) NOT NULL,
  `ReplyId` bigint(20) DEFAULT NULL,
  `Title` varchar(3000) DEFAULT NULL,
  `EmailId` bigint(20) DEFAULT NULL,
  `IsDeleted` bit(1) NOT NULL COMMENT 'Logical Delete',
  `IsClosed` bit(1) NOT NULL,
  `Priority` tinyint(4) NOT NULL DEFAULT '3' COMMENT '3 Means high',
  `SenderEmail` varchar(300) DEFAULT NULL,
  `PersonId` int(11) DEFAULT NULL COMMENT 'Audience Person',
  `Message` longtext,
  `File` longblob,
  `DepartmentId` int(11) DEFAULT NULL,
  `SubmitDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `AdminId` int(11) DEFAULT NULL,
  `IsPersonReceiver` bit(1) NOT NULL DEFAULT b'0' COMMENT 'If admin opens a ticket with Person',
  `ValidationCode` varchar(3000) DEFAULT NULL,
  `IsValid` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `people`
--

CREATE TABLE `people` (
  `Id` int(11) NOT NULL,
  `Username` varchar(45) DEFAULT NULL,
  `HashPassword` tinytext,
  `IsActive` bit(1) DEFAULT b'1',
  `Role` varchar(10) DEFAULT 'visitor'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `visits`
--

CREATE TABLE `visits` (
  `Id` bigint(20) NOT NULL,
  `Submit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CONTEXT_DOCUMENT_ROOT` varchar(500) DEFAULT NULL,
  `CONTEXT_PREFIX` varchar(500) DEFAULT NULL,
  `DOCUMENT_ROOT` varchar(500) DEFAULT NULL,
  `GATEWAY_INTERFACE` varchar(500) DEFAULT NULL,
  `HTTP_ACCEPT` varchar(500) DEFAULT NULL,
  `HTTP_ACCEPT_ENCODING` varchar(500) DEFAULT NULL,
  `HTTP_ACCEPT_LANGUAGE` varchar(500) DEFAULT NULL,
  `HTTP_CACHE_CONTROL` varchar(500) DEFAULT NULL,
  `HTTP_CONNECTION` varchar(500) DEFAULT NULL,
  `HTTP_COOKIE` varchar(500) DEFAULT NULL,
  `HTTP_HOST` varchar(500) DEFAULT NULL,
  `HTTP_REFERER` varchar(500) DEFAULT NULL,
  `HTTP_SEC_FETCH_DEST` varchar(500) DEFAULT NULL,
  `HTTP_SEC_FETCH_MODE` varchar(500) DEFAULT NULL,
  `HTTP_SEC_FETCH_SITE` varchar(500) DEFAULT NULL,
  `HTTP_SEC_FETCH_Person` varchar(500) DEFAULT NULL,
  `HTTP_UPGRADE_INSECURE_REQUESTS` varchar(500) DEFAULT NULL,
  `HTTP_Person_AGENT` varchar(500) DEFAULT NULL,
  `PATH` varchar(500) DEFAULT NULL,
  `PATH_INFO` varchar(500) DEFAULT NULL,
  `PATH_TRANSLATED` varchar(500) DEFAULT NULL,
  `PHP_SELF` varchar(500) DEFAULT NULL,
  `QUERY_STRING` varchar(500) DEFAULT NULL,
  `REDIRECT_STATUS` varchar(500) DEFAULT NULL,
  `REDIRECT_URL` varchar(500) DEFAULT NULL,
  `REMOTE_ADDR` varchar(500) DEFAULT NULL,
  `REMOTE_PORT` varchar(500) DEFAULT NULL,
  `REQUEST_METHOD` varchar(500) DEFAULT NULL,
  `REQUEST_SCHEME` varchar(500) DEFAULT NULL,
  `REQUEST_TIME` varchar(500) DEFAULT NULL,
  `REQUEST_TIME_FLOAT` varchar(500) DEFAULT NULL,
  `REQUEST_URI` varchar(500) DEFAULT NULL,
  `SCRIPT_FILENAME` varchar(500) DEFAULT NULL,
  `SCRIPT_NAME` varchar(500) DEFAULT NULL,
  `SERVER_ADDR` varchar(500) DEFAULT NULL,
  `SERVER_ADMIN` varchar(500) DEFAULT NULL,
  `SERVER_NAME` varchar(500) DEFAULT NULL,
  `SERVER_PORT` varchar(500) DEFAULT NULL,
  `SERVER_PROTOCOL` varchar(500) DEFAULT NULL,
  `SERVER_SIGNATURE` varchar(500) DEFAULT NULL,
  `SERVER_SOFTWARE` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure for view `post_contributers`
--
DROP TABLE IF EXISTS `post_contributers`;

CREATE VIEW `post_contributers`  AS  select `P`.`MasterId` AS `MasterID`,`P`.`Id` AS `ID`,`P`.`PersonId` AS `PersonId`,`U`.`Username` AS `Username`,`P`.`Submit` AS `Submit`,`P`.`Language` AS `Language` from (`posts` `P` join `people` `U` on((`P`.`PersonId` = `U`.`Id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `post_details`
--
DROP TABLE IF EXISTS `post_details`;

CREATE VIEW `post_details`  AS  select `P`.`MasterId` AS `MasterId`,`P`.`Title` AS `Title`,`P`.`Id` AS `ID`,`P`.`Submit` AS `Submit`,`P`.`PersonId` AS `PersonId`,`U`.`Username` AS `Username`,`P`.`Body` AS `Body`,`P`.`Status` AS `Status`,`P`.`Language` AS `Language`,(case when ((select `P2`.`Submit` from `posts` `P2` where ((`P2`.`IsContentDeleted` = 1) and (`P`.`MasterId` = `P2`.`MasterId`)) order by `P2`.`Submit` desc limit 1) > (select `P1`.`Submit` from `posts` `P1` where ((`P1`.`BinContent` is not null) and (`P`.`MasterId` = `P1`.`MasterId`)) order by `P1`.`Submit` desc limit 1)) then NULL else (select `P1`.`BinContent` from `posts` `P1` where ((`P1`.`BinContent` is not null) and (`P`.`IsContentDeleted` = 0) and (`P`.`MasterId` = `P1`.`MasterId`)) order by `P1`.`Submit` desc limit 1) end) AS `BinContent` from (`posts` `P` join `people` `U` on((`P`.`PersonId` = `U`.`Id`))) where (`P`.`Id` in (select max(`posts`.`Id`) from `posts` group by `posts`.`MasterId`,`posts`.`Language`) and (`P`.`IsDeleted` = '0')) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Person_Contact` (`PersonId`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `emails`
--
ALTER TABLE `emails`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`Id`,`MasterId`),
  ADD KEY `fk_posts_Person_idx` (`PersonId`);

--
-- Indexes for table `staffs`
--
ALTER TABLE `staffs`
  ADD KEY `Staff_Person` (`PersonId`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Email_Id` (`EmailId`),
  ADD KEY `Reply_Id` (`ReplyId`),
  ADD KEY `Admin_Id` (`AdminId`),
  ADD KEY `Person_Id` (`PersonId`),
  ADD KEY `Department_Id` (`DepartmentId`);

--
-- Indexes for table `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- Indexes for table `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `Id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emails`
--
ALTER TABLE `emails`
  MODIFY `Id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `Id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `people`
--
ALTER TABLE `people`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `visits`
--
ALTER TABLE `visits`
  MODIFY `Id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `Person_Contact` FOREIGN KEY (`PersonId`) REFERENCES `people` (`Id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_posts_Person` FOREIGN KEY (`PersonId`) REFERENCES `people` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `staffs`
--
ALTER TABLE `staffs`
  ADD CONSTRAINT `Staff_Person` FOREIGN KEY (`PersonId`) REFERENCES `people` (`Id`);

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `Admin_Id` FOREIGN KEY (`AdminId`) REFERENCES `people` (`Id`),
  ADD CONSTRAINT `Department_Id` FOREIGN KEY (`DepartmentId`) REFERENCES `departments` (`Id`),
  ADD CONSTRAINT `Email_Id` FOREIGN KEY (`EmailId`) REFERENCES `emails` (`Id`),
  ADD CONSTRAINT `Reply_Id` FOREIGN KEY (`ReplyId`) REFERENCES `tickets` (`Id`),
  ADD CONSTRAINT `Person_Id` FOREIGN KEY (`PersonId`) REFERENCES `people` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

CREATE TABLE `Todos` ( `Id` BIGINT NOT NULL AUTO_INCREMENT , `Title` INT NOT NULL , `Details` INT NULL , `Submit` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`Id`)) ENGINE = InnoDB;
ALTER TABLE `Todos` CHANGE `Title` `Title` VARCHAR(500) NOT NULL;
ALTER TABLE `Todos` CHANGE `Details` `Details` VARCHAR(3000) NOT NULL;