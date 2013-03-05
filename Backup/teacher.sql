-- MySQL dump 10.13  Distrib 5.5.28, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: teacher
-- ------------------------------------------------------
-- Server version	5.5.28-0ubuntu0.12.04.2

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
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` varchar(20) DEFAULT NULL,
  `content` varchar(100) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `new_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `new_id` (`new_id`),
  CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`new_id`) REFERENCES `news` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `comment` VALUES (1,'root','hello kitty真心不错','2013-03-04 02:19:12',1);
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `competence`
--

DROP TABLE IF EXISTS `competence`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `competence` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `competence`
--

LOCK TABLES `competence` WRITE;
/*!40000 ALTER TABLE `competence` DISABLE KEYS */;
INSERT INTO `competence` VALUES (1,'login');
/*!40000 ALTER TABLE `competence` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `competence_role`
--

DROP TABLE IF EXISTS `competence_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `competence_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `com_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `com_id` (`com_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `competence_role_ibfk_1` FOREIGN KEY (`com_id`) REFERENCES `competence` (`id`),
  CONSTRAINT `competence_role_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `competence_role`
--

LOCK TABLES `competence_role` WRITE;
/*!40000 ALTER TABLE `competence_role` DISABLE KEYS */;
INSERT INTO `competence_role` VALUES (1,1,1);
/*!40000 ALTER TABLE `competence_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `links`
--

DROP TABLE IF EXISTS `links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `links`
--

LOCK TABLES `links` WRITE;
/*!40000 ALTER TABLE `links` DISABLE KEYS */;
INSERT INTO `links` VALUES (1,'华南农业大学教务处','http://jwc.scau.edu.cn/index.html'),(2,'华农红满堂','http://hometown.scau.edu.cn/bbs/forum.php'),(3,'HTML5中文网','http://www.html5china.com/'),(4,'php','http://php.net/');
/*!40000 ALTER TABLE `links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` varchar(20) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `title` varchar(100) NOT NULL,
  `content` mediumtext,
  `commNum` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=306 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES (1,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(3,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(123,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(124,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(126,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(127,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(128,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(129,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(133,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(134,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(135,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(136,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(137,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(138,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(139,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(140,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(148,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(149,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(150,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(151,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(152,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(153,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(154,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(155,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(156,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(157,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(158,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(159,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(160,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(161,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(162,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(163,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(179,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(180,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(181,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(182,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(183,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(184,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(185,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(186,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(187,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(188,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(189,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(190,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(191,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(192,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(193,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(194,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(195,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(196,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(197,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(198,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(199,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(200,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(201,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(202,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(203,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(204,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(205,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(206,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(207,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(208,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(209,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(210,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(242,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(243,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(244,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(245,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(246,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(247,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(248,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(249,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(250,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(251,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(252,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(253,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(254,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(255,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(256,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(257,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(258,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(259,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(260,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(261,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(262,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(263,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(264,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(265,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(266,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(267,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(268,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(269,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(270,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(271,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(272,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(273,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(274,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(275,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(276,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(277,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(278,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(279,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(280,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(281,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(282,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(283,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(284,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(285,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(286,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(287,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(288,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(289,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(290,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(291,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(292,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(293,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(294,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(295,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(296,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(297,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(298,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(299,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(300,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(301,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(302,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(303,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2),(304,'root','2013-03-05 10:58:02','hello kitty','<p>&nbsp;&nbsp;hello kitty!!vgfdgdfgdfgfdgdfgdfgdfgfdgfdgdfgdfgfdgdfgdfgdf</p>',2),(305,'root','2013-03-05 11:10:48','hello kitty','<p>&nbsp;&nbsp;hello kitty!!bfhgfhfghgfhgfhfghfghfghgfhgfhfghdfgsdgdgdfgfghfgdfgfdgfdgfdg</p>',2);
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (1,'login');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_user`
--

DROP TABLE IF EXISTS `role_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `role_user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`),
  CONSTRAINT `role_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_user`
--

LOCK TABLES `role_user` WRITE;
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;
INSERT INTO `role_user` VALUES (1,1,1);
/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `number` varchar(15) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `avater` varchar(100) DEFAULT NULL,
  `gender` tinyint(1) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `living` varchar(100) DEFAULT NULL,
  `bornplace` varchar(100) DEFAULT NULL,
  `college` varchar(20) DEFAULT NULL,
  `post` varchar(20) DEFAULT NULL,
  `specialty` varchar(50) DEFAULT NULL,
  `tutorial` varchar(50) DEFAULT NULL,
  `office` varchar(100) DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `email` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'root','林滨','1','c4ca4238a0b923820dcc509a6f75849b','',0,'1990-01-01','广州','揭阳','信息学院','学生','计算机科学与技术','数据库理论','华山24-611','020-1234567',''),(2,'jackie_lin','linbin','200930740214','c4ca4238a0b923820dcc509a6f75849b',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-03-05 20:57:34
