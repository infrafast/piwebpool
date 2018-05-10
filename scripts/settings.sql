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
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `pkey` int(11) NOT NULL AUTO_INCREMENT,
  `id` varchar(40) NOT NULL,
  `value` varchar(255) NOT NULL,
  `userSetting` tinyint(1) NOT NULL,
  `description` varchar(40) NOT NULL,
  PRIMARY KEY (`pkey`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'tempOffset','-1.5',1,'Temperature calibration offset'),(2,'actionTable','0',0,''),(3,'blocklyTable','0',0,''),(4,'domoURL','http://admin:Quintal74604@domoticz.infrafast.com/json.htm?type=command',1,'API pour domoticz ou autre'),(5,'e_mail','szemrot@hotmail.com',1,'email recevant les notifications'),(6,'logTable','0',0,''),(7,'measureIndex','139',0,'Compteur dernière mesure'),(8,'ORPConsign','730',1,'Consigne ORP'),(9,'Parametres','1',0,''),(10,'PHConsign','7.24',1,'Consigne PH'),(11,'Planificateur','0',0,''),(12,'prowlURL','https://api.prowlapp.com/publicapi/add?apikey=0e139710aceccf6abc6865983a98f0439a0e5ba2&application=piwebpool&event=%m&description=%v',1,'PROWL notification server URL'),(13,'scheduler','on',1,'Activation planificateur filtration'),(14,'sensorTable','0',0,''),(15,'Souscripteurs','1',0,''),(16,'TEMPConsign','28',1,'Consigne de tempÃ©rature'),(19,'offsetORP','-50',1,'offset lecture ORP'),(20,'offsetPH','0',1,'offset lecture PH'),(21,'tempCompensation','0',1,'temperature compensation on/off');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
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
