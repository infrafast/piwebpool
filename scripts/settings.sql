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
  `key` int NOT NULL AUTO_INCREMENT,
  `id` varchar(40) NOT NULL,
  `value` varchar(255) NOT NULL,
  `userSetting` tinyint(1) NOT NULL,
  `description` varchar(40) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` (`id`,`value`,`userSetting`,`description`) VALUES ('tempOffset','-1.5',1,'Temperature calibration offset'),('actionTable','0',0,''),('blocklyTable','1',0,''),('domoURL','http://admin:Quintal74604@domoticz.infrafast.com/json.htm?type=command',1,'API pour domoticz ou autre'),('e_mail','szemrot@hotmail.com',1,'email recevant les notifications'),('logTable','1',0,''),('measureIndex','27',0,'Compteur dernière mesure'),('ORPConsign','750',1,'Consigne ORP'),('Parametres','0',0,''),('PHConsign','7.24',1,'Consigne PH'),('Planificateur','0',0,''),('prowlURL','https://api.prowlapp.com/publicapi/add?apikey=0e139710aceccf6abc6865983a98f0439a0e5ba2&application=piwebpool&event=%m&description=%v',1,'PROWL notification server URL'),('scheduler','1',1,'Activation planificateur filtration'),('sensorTable','0',0,''),('Souscripteurs','1',0,''),('TEMPConsign','28',1,'Consigne de tempÃ©rature');
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

-- Dump completed on 2016-10-07  9:44:47
