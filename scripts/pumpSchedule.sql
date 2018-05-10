-- MySQL dump 10.13  Distrib 5.5.50, for debian-linux-gnu (armv7l)
--
-- Host: localhost    Database: pool
-- ------------------------------------------------------
-- Server version	5.5.50-0+deb8u1

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
-- Table structure for table `pumpSchedule`
--

DROP TABLE IF EXISTS `pumpSchedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pumpSchedule` (
  `timeWindow` varchar(4) NOT NULL,
  `below0` tinyint(1) NOT NULL,
  `0to2` tinyint(1) NOT NULL,
  `2to4` tinyint(1) NOT NULL,
  `4to6` tinyint(1) NOT NULL,
  `6to8` tinyint(1) NOT NULL,
  `8to10` tinyint(1) NOT NULL,
  `10to12` tinyint(1) NOT NULL,
  `12to14` tinyint(1) NOT NULL,
  `14to16` tinyint(1) NOT NULL,
  `16to18` tinyint(1) NOT NULL,
  `18to20` tinyint(1) NOT NULL,
  `20to22` tinyint(1) NOT NULL,
  `22to24` tinyint(1) NOT NULL,
  `24to26` tinyint(1) NOT NULL,
  `26to28` tinyint(1) NOT NULL,
  `above28` tinyint(1) NOT NULL,
  PRIMARY KEY (`timeWindow`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pumpSchedule`
--

LOCK TABLES `pumpSchedule` WRITE;
/*!40000 ALTER TABLE `pumpSchedule` DISABLE KEYS */;
INSERT INTO `pumpSchedule` VALUES ('00h',1,1,1,1,1,1,1,1,1,1,0,0,0,0,0,0),('02h',1,1,0,1,0,0,1,1,1,1,0,0,0,0,0,1),('04h',1,1,0,0,0,0,0,1,1,1,0,0,0,0,1,1),('06h',1,1,1,0,0,0,0,0,0,0,1,0,0,0,1,1),('08h',1,1,0,0,0,0,0,0,0,0,1,1,1,1,1,1),('10h',1,1,0,0,0,0,0,0,0,0,0,1,1,1,1,1),('12h',1,1,0,0,0,0,0,0,0,0,0,1,1,1,1,1),('14h',1,1,0,0,0,0,1,1,0,0,1,1,1,1,1,1),('16h',1,1,0,0,0,0,1,1,0,0,1,1,1,1,1,1),('18h',1,1,0,0,0,0,1,1,0,0,1,1,1,1,1,1),('20h',1,1,0,0,0,0,0,0,0,0,0,0,0,0,1,1),('22h',1,1,1,0,0,0,0,0,0,1,0,0,0,0,0,1);
/*!40000 ALTER TABLE `pumpSchedule` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-05-10  9:51:17
