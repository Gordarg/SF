-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 21, 2020 at 07:50 AM
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
-- Database: `SnowKMS`
--

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `Id` bigint(20) NOT NULL,
  `UserId` int(11) NOT NULL,
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
-- Table structure for table `human-behaviour`
--

CREATE TABLE `human-behaviour` (
  `Id` bigint(20) NOT NULL,
  `Year` int(11) NOT NULL,
  `Month` tinyint(4) NOT NULL,
  `Day` tinyint(4) NOT NULL,
  `From` time NOT NULL,
  `To` time NOT NULL,
  `Quality` tinyint(4) NOT NULL,
  `Task` varchar(300) NOT NULL,
  `Brief` varchar(4000) NOT NULL,
  `UserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `Id` int(11) NOT NULL,
  `Event` varchar(10) DEFAULT 'LOGIN',
  `Key` varchar(100) DEFAULT 'USERNAME',
  `Value` varchar(3000) DEFAULT 'TOKEN',
  `Submit` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `MasterId` char(36) NOT NULL,
  `Id` int(11) NOT NULL,
  `Title` varchar(400) DEFAULT NULL,
  `Submit` datetime NOT NULL,
  `Type` char(5) NOT NULL DEFAULT 'POST' COMMENT 'POST, FILE, ARTL, COMT, SURV, QUST, ANSR,CHAT,TRNL,QUOT',
  `Level` char(2) DEFAULT 'DC' COMMENT 'Data Content by default. Other SEO and publish levels must be declared with integrers.',
  `BinContent` longblob,
  `Body` longtext,
  `UserId` int(11) DEFAULT NULL,
  `Status` char(7) DEFAULT 'DRAFT' COMMENT 'Post lifecycle',
  `Language` varchar(5) DEFAULT 'fa-IR',
  `RefrenceId` char(36) DEFAULT NULL,
  `Index` smallint(6) DEFAULT NULL,
  `IsDeleted` bit(1) NOT NULL DEFAULT b'0',
  `IsContentDeleted` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `post_contributers`
-- (See below for the actual view)
--
CREATE TABLE `post_contributers` (
`MasterId` char(36)
,`ID` int(11)
,`UserID` int(11)
,`Username` varchar(45)
,`Submit` datetime
,`Language` varchar(5)
);

-- --------------------------------------------------------

--
-- Table structure for table `staffs`
--

CREATE TABLE `staffs` (
  `UserId` int(11) NOT NULL,
  `DepartmentId` int(11) NOT NULL
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
  `UserId` int(11) DEFAULT NULL COMMENT 'Audience user',
  `Message` longtext,
  `File` longblob,
  `DepartmentId` int(11) DEFAULT NULL,
  `SubmitDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `AdminId` int(11) DEFAULT NULL,
  `IsUserReceiver` bit(1) NOT NULL DEFAULT b'0' COMMENT 'If admin opens a ticket with user',
  `ValidationCode` varchar(3000) DEFAULT NULL,
  `IsValid` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Id` int(11) NOT NULL,
  `Username` varchar(45) DEFAULT NULL,
  `HashPassword` tinytext,
  `IsActive` bit(1) DEFAULT b'1',
  `Role` tinyint(5) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure for view `post_contributers`
--
DROP TABLE IF EXISTS `post_contributers`;

CREATE VIEW `post_contributers`  AS  select `P`.`MasterId` AS `MasterId`,`P`.`Id` AS `ID`,`P`.`UserId` AS `UserID`,`U`.`Username` AS `Username`,`P`.`Submit` AS `Submit`,`P`.`Language` AS `Language` from (`posts` `P` join `users` `U` on((`P`.`UserId` = `U`.`Id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `post_details`
--
DROP TABLE IF EXISTS `post_details`;

CREATE VIEW `post_details` AS select `P`.`MasterId` AS `MasterId`,`P`.`Title` AS `Title`,`P`.`Id` AS `ID`,`P`.`Submit` AS `Submit`,`P`.`UserId` AS `UserID`,`U`.`Username` AS `Username`,`P`.`Body` AS `Body`,`P`.`Status` AS `Status`,`P`.`Language` AS `Language`,(case when ((select `P2`.`Submit` from `posts` `P2` where ((`P2`.`IsContentDeleted` = 1) and (`P`.`MasterId` = `P2`.`MasterId`)) order by `P2`.`Submit` desc limit 1) > (select `P1`.`Submit` from `posts` `P1` where ((`P1`.`BinContent` is not null) and (`P`.`MasterId` = `P1`.`MasterId`)) order by `P1`.`Submit` desc limit 1)) then NULL else (select `P1`.`BinContent` from `posts` `P1` where ((`P1`.`BinContent` is not null) and (`P`.`IsContentDeleted` = 0) and (`P`.`MasterId` = `P1`.`MasterId`)) order by `P1`.`Submit` desc limit 1) end) AS `BinContent` from (`posts` `P` join `users` `U` on((`P`.`UserId` = `U`.`Id`))) where (`P`.`Id` in (select max(`posts`.`Id`) from `posts` group by `posts`.`MasterId`,`posts`.`Language`) and (`P`.`IsDeleted` = '0'));

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `User_Contact` (`UserId`);

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
-- Indexes for table `human-behaviour`
--
ALTER TABLE `human-behaviour`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`Id`,`MasterId`),
  ADD KEY `fk_posts_user_idx` (`UserId`);

--
-- Indexes for table `staffs`
--
ALTER TABLE `staffs`
  ADD KEY `Staff_User` (`UserId`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Email_Id` (`EmailId`),
  ADD KEY `Reply_Id` (`ReplyId`),
  ADD KEY `Admin_Id` (`AdminId`),
  ADD KEY `User_Id` (`UserId`),
  ADD KEY `Department_Id` (`DepartmentId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Username` (`Username`);

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
-- AUTO_INCREMENT for table `human-behaviour`
--
ALTER TABLE `human-behaviour`
  MODIFY `Id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `User_Contact` FOREIGN KEY (`UserId`) REFERENCES `users` (`Id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_posts_user` FOREIGN KEY (`UserId`) REFERENCES `users` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `staffs`
--
ALTER TABLE `staffs`
  ADD CONSTRAINT `Staff_User` FOREIGN KEY (`UserId`) REFERENCES `users` (`Id`);

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `Admin_Id` FOREIGN KEY (`AdminId`) REFERENCES `users` (`Id`),
  ADD CONSTRAINT `Department_Id` FOREIGN KEY (`DepartmentId`) REFERENCES `departments` (`Id`),
  ADD CONSTRAINT `Email_Id` FOREIGN KEY (`EmailId`) REFERENCES `emails` (`Id`),
  ADD CONSTRAINT `Reply_Id` FOREIGN KEY (`ReplyId`) REFERENCES `tickets` (`Id`),
  ADD CONSTRAINT `User_Id` FOREIGN KEY (`UserId`) REFERENCES `users` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;