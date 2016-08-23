-- MySQL dump 10.15  Distrib 10.0.23-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: ComplianceReports
-- ------------------------------------------------------
-- Server version	10.0.23-MariaDB-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ContactPeople`
--

DROP TABLE IF EXISTS `ContactPeople`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ContactPeople` (
  `ContactPID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Name` char(50) DEFAULT NULL,
  `Phone` char(10) DEFAULT '0',
  `Pager` char(6) DEFAULT '0',
  `Email` char(50) DEFAULT NULL,
  `LocationID` int(11) unsigned DEFAULT '0',
  `Title` char(50) DEFAULT NULL,
  PRIMARY KEY (`ContactPID`),
  KEY `LocationID` (`LocationID`)
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Contacts2Machine`
--

DROP TABLE IF EXISTS `Contacts2Machine`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Contacts2Machine` (
  `MachineID` int(11) unsigned NOT NULL DEFAULT '0',
  `ContactPID` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`MachineID`,`ContactPID`),
  KEY `ContactPID` (`ContactPID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `GenData`
--

DROP TABLE IF EXISTS `GenData`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GenData` (
  `GenID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `SurveyID` int(11) unsigned DEFAULT NULL,
  `TubeID` int(11) unsigned DEFAULT NULL,
  `kVset` tinyint(3) unsigned DEFAULT NULL,
  `mAset` float DEFAULT NULL,
  `Timeset` float DEFAULT NULL,
  `mAsset` float DEFAULT NULL,
  `AddFilt` float DEFAULT NULL,
  `Distance` float DEFAULT NULL,
  `kVAvg` float DEFAULT NULL,
  `kVMax` float DEFAULT NULL,
  `kVEff` float DEFAULT NULL,
  `ExpTime` float DEFAULT NULL,
  `Exp` float DEFAULT NULL,
  `UseFlags` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`GenID`),
  KEY `SurveyID` (`SurveyID`)
) ENGINE=MyISAM AUTO_INCREMENT=11624 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Location`
--

DROP TABLE IF EXISTS `Location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Location` (
  `LocationID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Location` char(65) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`LocationID`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Machines`
--

DROP TABLE IF EXISTS `Machines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Machines` (
  `MachineID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ModalityID` int(11) unsigned DEFAULT '0',
  `Description` varchar(60) DEFAULT NULL,
  `ManufacturerID` int(11) unsigned DEFAULT '0',
  `VendSiteID` varchar(25) DEFAULT NULL,
  `Model` varchar(20) DEFAULT NULL,
  `SerialNumber` varchar(20) DEFAULT NULL,
  `ManufDate` date NOT NULL DEFAULT '0000-00-00',
  `InstallDate` date NOT NULL DEFAULT '0000-00-00',
  `RemoveDate` date NOT NULL DEFAULT '0000-00-00',
  `LocationID` int(11) unsigned DEFAULT '0',
  `Room` varchar(20) DEFAULT NULL,
  `Active` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Not used anymore',
  `Status` enum('Active','Inactive','Removed') NOT NULL DEFAULT 'Active',
  `Notes` text,
  `Photo` varchar(50) NOT NULL DEFAULT '',
  `SurveyFreq` enum('Annual','Semi-annual','Quarterly','Monthly','Weekly','NA') NOT NULL,
  PRIMARY KEY (`MachineID`),
  KEY `ModalityID` (`ModalityID`),
  KEY `LocationID` (`LocationID`),
  KEY `ManufacturerID` (`ManufacturerID`),
  KEY `MachDesc` (`Description`,`SerialNumber`)
) ENGINE=MyISAM AUTO_INCREMENT=325 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Manufacturer`
--

DROP TABLE IF EXISTS `Manufacturer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Manufacturer` (
  `ManufacturerID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Manufacturer` char(20) CHARACTER SET latin1 NOT NULL DEFAULT '',
  PRIMARY KEY (`ManufacturerID`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Modality`
--

DROP TABLE IF EXISTS `Modality`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Modality` (
  `ModalityID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Modality` char(25) CHARACTER SET latin1 NOT NULL DEFAULT '',
  PRIMARY KEY (`ModalityID`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `OperationalNotes`
--

DROP TABLE IF EXISTS `OperationalNotes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `OperationalNotes` (
  `NoteID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `MachineID` int(11) unsigned DEFAULT NULL,
  `NoteDate` date DEFAULT NULL,
  `Note` text CHARACTER SET latin1,
  PRIMARY KEY (`NoteID`),
  KEY `MachineID` (`MachineID`)
) ENGINE=MyISAM AUTO_INCREMENT=120 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Recommendations`
--

DROP TABLE IF EXISTS `Recommendations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Recommendations` (
  `RecID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `SurveyID` int(11) unsigned DEFAULT '0',
  `Recommendation` text CHARACTER SET latin1,
  `Resolved` tinyint(4) NOT NULL DEFAULT '0',
  `RecAddTS` datetime DEFAULT NULL,
  `RecResolveTS` datetime DEFAULT NULL,
  `RecResolveDate` date DEFAULT NULL,
  `ResolvedBy` varchar(40) NOT NULL,
  `RecStatus` enum('New','In process','Waiting parts','Complete') CHARACTER SET latin1 NOT NULL DEFAULT 'New',
  `WONum` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `ServiceReportPath` text,
  PRIMARY KEY (`RecID`),
  KEY `Work_Order` (`SurveyID`,`WONum`)
) ENGINE=MyISAM AUTO_INCREMENT=3121 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Recommendations_bak`
--

DROP TABLE IF EXISTS `Recommendations_bak`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Recommendations_bak` (
  `RecID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `SurveyID` int(11) unsigned DEFAULT '0',
  `Recommendation` text CHARACTER SET latin1,
  `Resolved` tinyint(4) NOT NULL DEFAULT '0',
  `RecAddTS` datetime DEFAULT NULL,
  `RecResolveTS` datetime DEFAULT NULL,
  `RecStatus` enum('New','In process','Waiting parts','Complete') CHARACTER SET latin1 NOT NULL DEFAULT 'New',
  `WONum` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT '',
  PRIMARY KEY (`RecID`),
  KEY `Work_Order` (`SurveyID`,`WONum`)
) ENGINE=MyISAM AUTO_INCREMENT=2356 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ShieldingLogNumbers`
--

DROP TABLE IF EXISTS `ShieldingLogNumbers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ShieldingLogNumbers` (
  `LogID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `MachineID` int(10) unsigned NOT NULL,
  `LogNumber` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`LogID`),
  KEY `MachineID` (`MachineID`),
  KEY `LogNumber` (`LogNumber`)
) ENGINE=MyISAM AUTO_INCREMENT=121 DEFAULT CHARSET=utf16;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Survey2Machine`
--

DROP TABLE IF EXISTS `Survey2Machine`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Survey2Machine` (
  `SurveyID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `MachineID` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`SurveyID`),
  KEY `MachineID` (`MachineID`)
) ENGINE=MyISAM AUTO_INCREMENT=1920 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TestDates`
--

DROP TABLE IF EXISTS `TestDates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TestDates` (
  `SurveyID` int(11) unsigned NOT NULL DEFAULT '0',
  `MachineID` int(11) unsigned DEFAULT NULL,
  `TestDate` date DEFAULT NULL,
  `ReportSentDate` date DEFAULT NULL,
  `Tester1ID` int(11) unsigned DEFAULT '0',
  `Tester2ID` int(11) unsigned DEFAULT '0',
  `TypeID` int(11) unsigned DEFAULT '0',
  `Notes` text CHARACTER SET latin1,
  `Accession` int(11) unsigned DEFAULT '0',
  `ReportFilePath` text NOT NULL,
  PRIMARY KEY (`SurveyID`),
  KEY `MachineID` (`MachineID`),
  KEY `TestDate` (`TestDate`),
  KEY `Accession` (`Accession`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TestType`
--

DROP TABLE IF EXISTS `TestType`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TestType` (
  `TypeID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `TestType` char(30) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`TypeID`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Testers`
--

DROP TABLE IF EXISTS `Testers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Testers` (
  `TesterID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `TesterName` char(25) CHARACTER SET latin1 DEFAULT NULL,
  `TesterInitials` char(4) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`TesterID`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Tubes`
--

DROP TABLE IF EXISTS `Tubes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Tubes` (
  `TubeID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `MachineID` int(11) unsigned DEFAULT NULL,
  `HousingModel` varchar(30) DEFAULT NULL,
  `HousingSN` varchar(20) DEFAULT NULL,
  `InsertModel` varchar(30) DEFAULT NULL,
  `InsertSN` varchar(20) DEFAULT NULL,
  `ManufDate` date NOT NULL DEFAULT '0000-00-00',
  `LFS` float DEFAULT '0',
  `MFS` float DEFAULT '0',
  `SFS` float DEFAULT '0',
  `Notes` text,
  `Active` tinyint(4) DEFAULT NULL COMMENT 'Not used anymore',
  `HousingManufID` int(11) unsigned DEFAULT NULL,
  `Status` enum('Active','Inactive','Removed') NOT NULL DEFAULT 'Active',
  `InsertManufID` int(11) unsigned DEFAULT NULL,
  `InstallDate` date NOT NULL DEFAULT '0000-00-00',
  `RemoveDate` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`TubeID`),
  KEY `MachinesID` (`MachineID`)
) ENGINE=MyISAM AUTO_INCREMENT=326 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-05-31 14:59:04
