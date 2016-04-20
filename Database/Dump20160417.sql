-- MySQL dump 10.13  Distrib 5.7.9, for Win64 (x86_64)
--
-- Host: localhost    Database: koerswest
-- ------------------------------------------------------
-- Server version	5.7.9-log

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
-- Table structure for table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Categorie` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorie`
--

LOCK TABLES `categorie` WRITE;
/*!40000 ALTER TABLE `categorie` DISABLE KEYS */;
INSERT INTO `categorie` VALUES (1,'Techniek'),(2,'Schijven'),(3,'Huishouden'),(4,'Lezen');
/*!40000 ALTER TABLE `categorie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dienst`
--

DROP TABLE IF EXISTS `dienst`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dienst` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dienst` varchar(45) NOT NULL,
  `omschijving` text NOT NULL,
  `Afbeelding` blob,
  `Catogorie_catogorie_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Dienst_Catogorie1_idx` (`Catogorie_catogorie_id`),
  CONSTRAINT `fk_Dienst_Catogorie1` FOREIGN KEY (`Catogorie_catogorie_id`) REFERENCES `categorie` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dienst`
--

LOCK TABLES `dienst` WRITE;
/*!40000 ALTER TABLE `dienst` DISABLE KEYS */;
INSERT INTO `dienst` VALUES (1,'Brieven schijven','Ik kan brieven voor u schrijven. Stuur mij een bericht als u hulp hiermee nodig heeft.',NULL,2);
/*!40000 ALTER TABLE `dienst` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gebruiker`
--

DROP TABLE IF EXISTS `gebruiker`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gebruiker` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(45) NOT NULL,
  `Wachtwoord` varchar(45) NOT NULL,
  `telefoonnummer` varchar(45) NOT NULL,
  `straat` varchar(45) NOT NULL,
  `postcode` varchar(45) NOT NULL,
  `woonplaats` varchar(45) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gebruiker`
--

LOCK TABLES `gebruiker` WRITE;
/*!40000 ALTER TABLE `gebruiker` DISABLE KEYS */;
INSERT INTO `gebruiker` VALUES (1,'test','test','test','test','test','test');
/*!40000 ALTER TABLE `gebruiker` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gebruiker_bied_dienst_aan`
--

DROP TABLE IF EXISTS `gebruiker_bied_dienst_aan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gebruiker_bied_dienst_aan` (
  `Gebruiker_Id` int(11) NOT NULL,
  `Dienst_id` int(11) NOT NULL,
  PRIMARY KEY (`Gebruiker_Id`,`Dienst_id`),
  KEY `fk_Gebruiker_has_Dienst_Dienst1_idx` (`Dienst_id`),
  KEY `fk_Gebruiker_has_Dienst_Gebruiker1_idx` (`Gebruiker_Id`),
  CONSTRAINT `fk_Gebruiker_has_Dienst_Dienst1` FOREIGN KEY (`Dienst_id`) REFERENCES `dienst` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Gebruiker_has_Dienst_Gebruiker1` FOREIGN KEY (`Gebruiker_Id`) REFERENCES `gebruiker` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gebruiker_bied_dienst_aan`
--

LOCK TABLES `gebruiker_bied_dienst_aan` WRITE;
/*!40000 ALTER TABLE `gebruiker_bied_dienst_aan` DISABLE KEYS */;
/*!40000 ALTER TABLE `gebruiker_bied_dienst_aan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gebruiker_is_goed_in_categorie`
--

DROP TABLE IF EXISTS `gebruiker_is_goed_in_categorie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gebruiker_is_goed_in_categorie` (
  `Gebruiker_Id` int(11) NOT NULL,
  `Categorie_id` int(11) NOT NULL,
  PRIMARY KEY (`Gebruiker_Id`,`Categorie_id`),
  KEY `fk_Gebruiker_has_Catogorie_Catogorie1_idx` (`Categorie_id`),
  KEY `fk_Gebruiker_has_Catogorie_Gebruiker1_idx` (`Gebruiker_Id`),
  CONSTRAINT `fk_Gebruiker_has_Catogorie_Catogorie1` FOREIGN KEY (`Categorie_id`) REFERENCES `categorie` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Gebruiker_has_Catogorie_Gebruiker1` FOREIGN KEY (`Gebruiker_Id`) REFERENCES `gebruiker` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gebruiker_is_goed_in_categorie`
--

LOCK TABLES `gebruiker_is_goed_in_categorie` WRITE;
/*!40000 ALTER TABLE `gebruiker_is_goed_in_categorie` DISABLE KEYS */;
/*!40000 ALTER TABLE `gebruiker_is_goed_in_categorie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gebruiker_is_slecht_in_categorie`
--

DROP TABLE IF EXISTS `gebruiker_is_slecht_in_categorie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gebruiker_is_slecht_in_categorie` (
  `Gebruiker_Id` int(11) NOT NULL,
  `Categorie_id` int(11) NOT NULL,
  PRIMARY KEY (`Gebruiker_Id`,`Categorie_id`),
  KEY `fk_Gebruiker_has_Catogorie1_Catogorie1_idx` (`Categorie_id`),
  KEY `fk_Gebruiker_has_Catogorie1_Gebruiker1_idx` (`Gebruiker_Id`),
  CONSTRAINT `fk_Gebruiker_has_Catogorie1_Catogorie1` FOREIGN KEY (`Categorie_id`) REFERENCES `categorie` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Gebruiker_has_Catogorie1_Gebruiker1` FOREIGN KEY (`Gebruiker_Id`) REFERENCES `gebruiker` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gebruiker_is_slecht_in_categorie`
--

LOCK TABLES `gebruiker_is_slecht_in_categorie` WRITE;
/*!40000 ALTER TABLE `gebruiker_is_slecht_in_categorie` DISABLE KEYS */;
/*!40000 ALTER TABLE `gebruiker_is_slecht_in_categorie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gebruiker_vraagt_dienst`
--

DROP TABLE IF EXISTS `gebruiker_vraagt_dienst`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gebruiker_vraagt_dienst` (
  `Gebruiker_Id` int(11) NOT NULL,
  `Dienst_id` int(11) NOT NULL,
  PRIMARY KEY (`Gebruiker_Id`,`Dienst_id`),
  KEY `fk_Gebruiker_has_Dienst_Dienst2_idx` (`Dienst_id`),
  KEY `fk_Gebruiker_has_Dienst_Gebruiker2_idx` (`Gebruiker_Id`),
  CONSTRAINT `fk_Gebruiker_has_Dienst_Dienst2` FOREIGN KEY (`Dienst_id`) REFERENCES `dienst` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Gebruiker_has_Dienst_Gebruiker2` FOREIGN KEY (`Gebruiker_Id`) REFERENCES `gebruiker` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gebruiker_vraagt_dienst`
--

LOCK TABLES `gebruiker_vraagt_dienst` WRITE;
/*!40000 ALTER TABLE `gebruiker_vraagt_dienst` DISABLE KEYS */;
/*!40000 ALTER TABLE `gebruiker_vraagt_dienst` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'koerswest'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-04-17 10:57:06
