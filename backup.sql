-- MySQL dump 10.13  Distrib 5.5.35, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: jsrab
-- ------------------------------------------------------
-- Server version	5.5.35-0ubuntu0.13.10.1

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
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `phonenumber` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,'Sams Däck AB','0'),(2,'Samsfrakt AB','0'),(3,'Clas-Görans Lastbilar AB','0'),(4,'DHL AB','0'),(5,'Asia Delivery AB','0'),(6,'Gerts däck AB','0'),(7,'Mats Däck AB','0'),(8,'Filips Däck AB','0'),(9,'Fredriks Däck AB','0'),(10,'Franks Däck och Bygg AB','0'),(11,'Olofs Däck AB','0');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `customerID` int(11) DEFAULT NULL,
  `tiretreadID` int(11) DEFAULT NULL,
  `tiresizeID` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `comments` varchar(45) DEFAULT NULL,
  `deliverydate` varchar(45) DEFAULT NULL,
  `userID` varchar(45) DEFAULT NULL,
  `lastChange` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (15,'2014-01-15 15:31:58',1,7,3,111,NULL,'2014-01-08','1','2014-01-15'),(16,'2013-12-13 11:05:06',2,1,5,1000,'12345,2,3,5,4','12-20-2013','1','0000-00-00'),(17,'2014-01-15 15:39:05',3,4,1,44,NULL,'2014-02-04','1','2014-01-15'),(18,'2014-01-15 15:40:21',4,5,2,777,NULL,'2014-01-16','1','2014-01-15'),(19,'2014-01-16 07:28:53',2,7,3,99,NULL,'2014-01-23','1','2014-01-16'),(20,'2013-12-13 11:33:32',5,5,4,7,'77777,8,9,7,5','01/22/2014','1','0000-00-00'),(21,'2014-01-15 15:36:29',1,2,3,12,NULL,NULL,'1','2014-01-15'),(22,'2014-01-15 15:35:54',3,4,3,100,NULL,NULL,'1','2014-01-15'),(23,'2014-01-15 15:36:10',5,1,3,12,NULL,NULL,'1','2014-01-15'),(24,'2014-01-15 15:40:42',6,4,3,1,NULL,'2014-01-13','1','2014-01-15'),(25,'2014-01-15 16:38:01',7,1,4,2,NULL,'2014-01-16','1','2014-01-15'),(26,'2014-01-15 16:37:28',7,3,5,1,NULL,'2014-02-13','1','2014-01-15'),(27,'2014-01-15 16:20:31',7,7,2,12,NULL,'2014-01-16','1','2014-01-15'),(28,'2014-01-15 15:39:27',6,3,3,2,NULL,'2014-02-15','1','2014-01-15'),(29,'2014-01-15 15:37:36',2,4,1,1,NULL,'2014-01-16','1','2014-01-15'),(30,'2014-01-07 12:05:35',8,3,2,2,'1344,1,2,3,4','01/22/2014','1','2001-07-14'),(31,'2014-01-14 07:30:14',9,3,2,1,'12345,1,2,3,4','01/15/2014','1','0000-00-00'),(32,'2014-01-15 16:37:40',7,3,1,12,NULL,'2014-01-29','1','2014-01-15'),(33,'2014-01-15 15:38:03',10,2,1,12,NULL,'2014-01-31','1','2014-01-15'),(34,'2014-01-16 07:20:01',11,3,1,12,'98765,3,4,5,6','2014-01-16','1','0000-00-00');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tiresizes`
--

DROP TABLE IF EXISTS `tiresizes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tiresizes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tiresizes`
--

LOCK TABLES `tiresizes` WRITE;
/*!40000 ALTER TABLE `tiresizes` DISABLE KEYS */;
INSERT INTO `tiresizes` VALUES (1,'315/80-22,5'),(2,'315/70-22,5'),(3,'10.00-20'),(4,'265/70-19.5'),(5,'295/80-22.5'),(6,'2->315/70-22,5'),(7,'Sam');
/*!40000 ALTER TABLE `tiresizes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tiretreads`
--

DROP TABLE IF EXISTS `tiretreads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tiretreads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tiretreads`
--

LOCK TABLES `tiretreads` WRITE;
/*!40000 ALTER TABLE `tiretreads` DISABLE KEYS */;
INSERT INTO `tiretreads` VALUES (1,'BDR-W+'),(3,'BDR-HG'),(5,'BDY'),(7,'B104');
/*!40000 ALTER TABLE `tiretreads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (5,'sam','samsam123'),(6,'sam','34c1d5a41b77e2b42ddb3f351ac6fbee0ad74d4ac523e'),(7,'sam','34c1d5a41b77e2b42ddb3f351ac6fbee0ad74d4ac523ea05695aaf87b220bbf0'),(8,'sawise','04b748ed3906cbd75724392b129bad1f7ff5f9aaa7dc0ca2a790eb119c8ad854'),(9,'sam','34c1d5a41b77e2b42ddb3f351ac6fbee0ad74d4ac523ea05695aaf87b220bbf0');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-01-30 10:35:09
