-- MySQL dump 10.13  Distrib 5.5.8, for Win32 (x86)
--
-- Host: localhost    Database: orbis
-- ------------------------------------------------------
-- Server version	5.0.45-community-nt

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
-- Not dumping tablespaces as no INFORMATION_SCHEMA.FILES table on this server
--

--
-- Table structure for table `acos`
--

DROP TABLE IF EXISTS `acos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acos` (
  `id` int(10) NOT NULL auto_increment,
  `parent_id` int(10) default NULL,
  `model` varchar(255) default NULL,
  `foreign_key` int(10) default NULL,
  `alias` varchar(255) default NULL,
  `lft` int(10) default NULL,
  `rght` int(10) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2252 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acos`
--

LOCK TABLES `acos` WRITE;
/*!40000 ALTER TABLE `acos` DISABLE KEYS */;
INSERT INTO `acos` VALUES (2093,NULL,NULL,NULL,'controllers',1,160),(2095,2093,'Pages',NULL,'Pages',2,17),(2097,2095,'Pages',NULL,'display',3,4),(2099,2095,'Pages',NULL,'updateJSONFile',5,6),(2101,2095,'Pages',NULL,'add',7,8),(2103,2095,'Pages',NULL,'edit',9,10),(2105,2095,'Pages',NULL,'index',11,12),(2107,2095,'Pages',NULL,'view',13,14),(2109,2095,'Pages',NULL,'delete',15,16),(2111,2093,'Phones',NULL,'Phones',18,29),(2113,2111,'Phones',NULL,'index',19,20),(2115,2111,'Phones',NULL,'view',21,22),(2117,2111,'Phones',NULL,'add',23,24),(2119,2111,'Phones',NULL,'edit',25,26),(2121,2111,'Phones',NULL,'delete',27,28),(2123,2093,'DrugsTreatments',NULL,'DrugsTreatments',30,41),(2125,2123,'DrugsTreatments',NULL,'index',31,32),(2127,2123,'DrugsTreatments',NULL,'add',33,34),(2129,2123,'DrugsTreatments',NULL,'edit',35,36),(2131,2123,'DrugsTreatments',NULL,'delete',37,38),(2133,2123,'DrugsTreatments',NULL,'view',39,40),(2135,2093,'Treatments',NULL,'Treatments',42,53),(2137,2135,'Treatments',NULL,'index',43,44),(2139,2135,'Treatments',NULL,'view',45,46),(2141,2135,'Treatments',NULL,'add',47,48),(2143,2135,'Treatments',NULL,'edit',49,50),(2145,2135,'Treatments',NULL,'delete',51,52),(2147,2093,'Groups',NULL,'Groups',54,65),(2149,2147,'Groups',NULL,'index',55,56),(2151,2147,'Groups',NULL,'view',57,58),(2153,2147,'Groups',NULL,'add',59,60),(2155,2147,'Groups',NULL,'edit',61,62),(2157,2147,'Groups',NULL,'delete',63,64),(2159,2093,'Drugs',NULL,'Drugs',66,77),(2161,2159,'Drugs',NULL,'index',67,68),(2163,2159,'Drugs',NULL,'view',69,70),(2165,2159,'Drugs',NULL,'add',71,72),(2167,2159,'Drugs',NULL,'edit',73,74),(2169,2159,'Drugs',NULL,'delete',75,76),(2171,2093,'Locations',NULL,'Locations',78,89),(2173,2171,'Locations',NULL,'index',79,80),(2175,2171,'Locations',NULL,'view',81,82),(2177,2171,'Locations',NULL,'add',83,84),(2179,2171,'Locations',NULL,'edit',85,86),(2181,2171,'Locations',NULL,'delete',87,88),(2183,2093,'Stats',NULL,'Stats',90,111),(2185,2183,'Stats',NULL,'index',91,92),(2187,2183,'Stats',NULL,'view',93,94),(2189,2183,'Stats',NULL,'add',95,96),(2191,2183,'Stats',NULL,'edit',97,98),(2193,2183,'Stats',NULL,'delete',99,100),(2195,2183,'Stats',NULL,'update_select',101,102),(2197,2183,'Stats',NULL,'updateJSONFile',103,104),(2199,2183,'Stats',NULL,'sdrugs',105,106),(2201,2183,'Stats',NULL,'streatments',107,108),(2203,2183,'Stats',NULL,'options',109,110),(2205,2093,'Rawreports',NULL,'Rawreports',112,123),(2207,2205,'Rawreports',NULL,'index',113,114),(2209,2205,'Rawreports',NULL,'view',115,116),(2211,2205,'Rawreports',NULL,'add',117,118),(2213,2205,'Rawreports',NULL,'edit',119,120),(2215,2205,'Rawreports',NULL,'delete',121,122),(2217,2093,'Views',NULL,'Views',124,135),(2219,2217,'Views',NULL,'add',125,126),(2221,2217,'Views',NULL,'edit',127,128),(2223,2217,'Views',NULL,'index',129,130),(2225,2217,'Views',NULL,'view',131,132),(2227,2217,'Views',NULL,'delete',133,134),(2229,2093,'Users',NULL,'Users',136,159),(2231,2229,'Users',NULL,'login',137,138),(2233,2229,'Users',NULL,'logout',139,140),(2235,2229,'Users',NULL,'index',141,142),(2237,2229,'Users',NULL,'view',143,144),(2239,2229,'Users',NULL,'add',145,146),(2241,2229,'Users',NULL,'edit',147,148),(2243,2229,'Users',NULL,'delete',149,150),(2245,2229,'Users',NULL,'initDB',151,152),(2247,2229,'Users',NULL,'build_acl',153,154),(2249,2229,'Users',NULL,'changePass',155,156),(2251,2229,'Users',NULL,'resetUsers',157,158);
/*!40000 ALTER TABLE `acos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aros`
--

DROP TABLE IF EXISTS `aros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aros` (
  `id` int(10) NOT NULL auto_increment,
  `parent_id` int(10) default NULL,
  `model` varchar(255) default NULL,
  `foreign_key` int(10) default NULL,
  `alias` varchar(255) default NULL,
  `lft` int(10) default NULL,
  `rght` int(10) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aros`
--

LOCK TABLES `aros` WRITE;
/*!40000 ALTER TABLE `aros` DISABLE KEYS */;
INSERT INTO `aros` VALUES (1,NULL,'Group',8,NULL,1,4),(2,NULL,'Group',9,NULL,5,8),(3,NULL,'Group',10,NULL,9,12),(4,1,'User',1,NULL,2,3),(5,2,'User',2,NULL,6,7),(6,3,'User',3,NULL,10,11);
/*!40000 ALTER TABLE `aros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aros_acos`
--

DROP TABLE IF EXISTS `aros_acos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aros_acos` (
  `id` int(10) NOT NULL auto_increment,
  `aro_id` int(10) NOT NULL,
  `aco_id` int(10) NOT NULL,
  `_create` varchar(2) NOT NULL default '0',
  `_read` varchar(2) NOT NULL default '0',
  `_update` varchar(2) NOT NULL default '0',
  `_delete` varchar(2) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `ARO_ACO_KEY` (`aro_id`,`aco_id`)
) ENGINE=InnoDB AUTO_INCREMENT=958 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aros_acos`
--

LOCK TABLES `aros_acos` WRITE;
/*!40000 ALTER TABLE `aros_acos` DISABLE KEYS */;
INSERT INTO `aros_acos` VALUES (871,1,2093,'1','1','1','1'),(873,2,2093,'1','1','1','1'),(875,2,2197,'1','1','1','1'),(877,2,2199,'1','1','1','1'),(879,2,2201,'1','1','1','1'),(881,2,2185,'1','1','1','1'),(883,2,2187,'1','1','1','1'),(885,2,2159,'1','1','1','1'),(887,2,2135,'1','1','1','1'),(889,2,2123,'1','1','1','1'),(891,2,2171,'1','1','1','1'),(893,2,2111,'1','1','1','1'),(895,2,2207,'1','1','1','1'),(897,2,2209,'1','1','1','1'),(899,2,2233,'1','1','1','1'),(901,2,2203,'1','1','1','1'),(903,2,2249,'1','1','1','1'),(905,2,2229,'-1','-1','-1','-1'),(907,2,2147,'-1','-1','-1','-1'),(909,2,2245,'-1','-1','-1','-1'),(911,2,2247,'-1','-1','-1','-1'),(913,2,2183,'-1','-1','-1','-1'),(915,2,2205,'-1','-1','-1','-1'),(917,3,2093,'1','1','1','1'),(919,3,2197,'1','1','1','1'),(921,3,2199,'1','1','1','1'),(923,3,2201,'1','1','1','1'),(925,3,2233,'1','1','1','1'),(927,3,2163,'1','1','1','1'),(929,3,2139,'1','1','1','1'),(931,3,2175,'1','1','1','1'),(933,3,2249,'1','1','1','1'),(935,3,2229,'-1','-1','-1','-1'),(937,3,2147,'-1','-1','-1','-1'),(939,3,2245,'-1','-1','-1','-1'),(941,3,2247,'-1','-1','-1','-1'),(943,3,2159,'-1','-1','-1','-1'),(945,3,2135,'-1','-1','-1','-1'),(947,3,2171,'-1','-1','-1','-1'),(949,3,2111,'-1','-1','-1','-1'),(951,3,2183,'-1','-1','-1','-1'),(953,3,2205,'-1','-1','-1','-1'),(955,3,2123,'-1','-1','-1','-1'),(957,3,2203,'-1','-1','-1','-1');
/*!40000 ALTER TABLE `aros_acos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `drug_reports`
--

DROP TABLE IF EXISTS `drug_reports`;
/*!50001 DROP VIEW IF EXISTS `drug_reports`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `drug_reports` (
  `quantity` int(5),
  `timestamp` datetime,
  `drug_name` varchar(40),
  `phone` varchar(13),
  `location_name` varchar(70),
  `latitude` varchar(13),
  `longitude` varchar(13)
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `drug_status`
--

DROP TABLE IF EXISTS `drug_status`;
/*!50001 DROP VIEW IF EXISTS `drug_status`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `drug_status` (
  `timestamp` datetime,
  `drug_name` varchar(40),
  `location_name` varchar(70),
  `quantity` int(5)
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `drugs`
--

DROP TABLE IF EXISTS `drugs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `drugs` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(40) NOT NULL,
  `code` varchar(3) NOT NULL,
  `presentation` varchar(20) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `drugs`
--

LOCK TABLES `drugs` WRITE;
/*!40000 ALTER TABLE `drugs` DISABLE KEYS */;
INSERT INTO `drugs` VALUES (14,'Zithromax Oral','ZIM','Oral solution'),(16,'Zithromax Tablets','ZIT','Tablets'),(18,'Albendazole','ALB','Tablets'),(20,'Mebendazole','MEB','Tablets'),(22,'Ivermectin','IVM','Tablets'),(24,'Praziquantel','PZQ','Tablets');
/*!40000 ALTER TABLE `drugs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `drugs_treatments`
--

DROP TABLE IF EXISTS `drugs_treatments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `drugs_treatments` (
  `id` int(11) NOT NULL auto_increment,
  `drug_id` int(11) NOT NULL,
  `treatment_id` int(11) NOT NULL,
  `quantity` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=133 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `drugs_treatments`
--

LOCK TABLES `drugs_treatments` WRITE;
/*!40000 ALTER TABLE `drugs_treatments` DISABLE KEYS */;
INSERT INTO `drugs_treatments` VALUES (128,22,26,NULL),(40,18,26,1),(44,22,28,1),(130,24,29,NULL),(115,18,31,NULL),(119,20,31,NULL),(125,16,33,NULL),(132,14,33,NULL);
/*!40000 ALTER TABLE `drugs_treatments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (8,'administrators','2010-08-29 23:47:59','2010-11-22 15:35:45'),(9,'moderators','2010-08-29 23:48:10','2010-08-30 14:48:54'),(10,'users','2010-08-29 23:48:18','2010-08-30 14:49:02');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `locations` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(70) NOT NULL,
  `shortname` varchar(4) NOT NULL,
  `locationLatitude` varchar(13) NOT NULL,
  `locationLongitude` varchar(13) NOT NULL,
  `deleted` int(1) default '0',
  `parent_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
INSERT INTO `locations` VALUES (2,'Gulu Hospital','GLH','2.78','32.3',1,NULL),(5,'Iganga District Office','IGNC','0.616111','33.482222',0,18),(6,'Jinja District Office ','JINC','0.424444','33.204167',0,18),(7,'Kamuli Health Center','KAMH','0.945','33.125',0,18),(9,'Buyende Health Center','BUYH','1.175711','33.148029',0,7),(11,'Oyam Healt Post','OYAP','2.234444','32.385',0,7),(13,'Taskforce','TF','0.00','0.00',1,NULL),(14,'Kampala Office','KMPL','2.248889','32.9',0,7),(16,'Abim District Office','ABIM','2.73','33.67',0,5),(18,'Bugiri District Office','BUGR','0.56','33.75',0,NULL),(20,'Kaliro District Office','KLRO','0.89','33.5',0,5),(22,'Kotido District Office','KTDO','3.01','34.11',0,20),(24,'Mayuge District Office','MAYG','0.46','33.48',0,20),(26,'Nakapiripirit District office','NKPT','1.85','34.72',0,24),(28,'Namutumba District Office','NMTB','0.98','34.33',0,6),(30,'Dokolo District Office','DKLO','0.62','33.48',0,26),(32,'Dokolo Sub-County','DKLS','0.68','33.64',0,26),(34,'Kaabong District Office','KBNG','3.52','34.12',0,6);
/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phones`
--

DROP TABLE IF EXISTS `phones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phones` (
  `id` int(11) NOT NULL auto_increment,
  `phonenumber` varchar(13) default NULL,
  `active` int(1) NOT NULL,
  `location_id` int(11) default NULL,
  `name` varchar(30) NOT NULL,
  `deleted` int(1) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=125 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phones`
--

LOCK TABLES `phones` WRITE;
/*!40000 ALTER TABLE `phones` DISABLE KEYS */;
INSERT INTO `phones` VALUES (36,'17064491387',1,5,'Fernanda Deballian',0),(38,'17068928570',1,5,'Jamie Tallant ',0),(40,'14045208973',1,6,'Anne Heggen ',0),(42,'16786021760',1,7,'Anyess Travers ',0),(44,'19193604046',1,7,'Pablo Destefanis',0),(60,'+27724008226',1,7,'Lachko',0),(73,'4047135544',1,6,'PJ Hooper',0),(75,'7402433266',1,6,'Alex Pavluck',0),(77,'7706343554',1,5,'PJ Otherphone',0),(78,'19196967441',1,2,'Martha Decain',1),(82,'+256754125160',1,9,'Pablo Destefanis (Airtel)',0),(84,'+256778726734',1,6,'Alex Paveleck @ UG',0),(86,'778726704',1,7,'Pablo Destefanis (MTN)',0),(88,'+256752642388',1,14,'Harriet',0),(90,'+256772497180',1,14,'Ambrose',0),(92,'0774122368',1,16,'Buteraba Mathias',0),(94,'0772342834',1,18,'Kadama Frederick',0),(96,'0782265645',1,22,'Dilla A. Kotol',0),(98,'0782702050',1,24,'Nabonge Juma',0),(100,'0772854832',1,26,'Siloi Philip',0),(104,'0782735640',1,28,'Balisanyuka Ronald',0),(106,'0772318182',1,30,'Opio Tom Richard',0),(108,'0775428516',1,6,'Bayenda Gilbert',0),(110,'0782801190',1,5,'Ochola Anthony',0),(112,'+256712813493',1,14,'Martin',0),(114,'+256777655829',1,14,'Anna',0),(116,'+256772479318',1,34,'Andrew',0),(118,'+256774805158',1,20,'Anatole',0),(120,'+256783409824',1,20,'Richard',0),(122,'+256775323247',1,2,'Richard',0),(124,'+256758805158',0,NULL,'Unknown',0);
/*!40000 ALTER TABLE `phones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rawreports`
--

DROP TABLE IF EXISTS `rawreports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rawreports` (
  `id` int(11) NOT NULL auto_increment,
  `raw_message` varchar(160) NOT NULL,
  `message_code` varchar(90) NOT NULL,
  `created` datetime NOT NULL,
  `phone_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2115 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rawreports`
--

LOCK TABLES `rawreports` WRITE;
/*!40000 ALTER TABLE `rawreports` DISABLE KEYS */;
INSERT INTO `rawreports` VALUES (992,'ALB 5000 +256778726734','Phone number +256778726734 not found in database','2011-03-07 14:22:34',84),(994,'ALB 3000 +256778726734','OK','2011-03-07 14:26:01',84),(996,'IVN 100 +256778726734','OK','2011-03-07 15:08:07',84),(998,'MEB 200 +256778726734','OK','2011-03-07 15:08:16',84),(1000,'ZIT 400 +256778726734','OK','2011-03-07 15:09:14',84),(1002,'PZQ 500 +256778726734','OK','2011-03-07 15:09:24',84),(1004,'ZIM 300 +256778726734','OK','2011-03-07 15:09:34',84),(1006,'ALB 5000 +256778726704','Phone number +256778726704 not found in database','2011-03-07 15:09:49',86),(1008,'LFIL 1 +256778726734','Treatment ID doesn\'t exist: LFIL','2011-03-07 15:10:09',84),(1010,'PZQ 3524 +256754125160','OK','2011-03-07 15:11:44',82),(1012,'SCTS 3 +256778726734','OK','2011-03-07 15:11:54',84),(1014,'TECH 5 +256778726734','Treatment ID doesn\'t exist: TECH','2011-03-07 15:12:04',84),(1020,'OWCC 2 +256778726734','Treatment ID doesn\'t exist: OWCC','2011-03-07 15:12:55',84),(1024,'IWRM 4 +256778726734','OK','2011-03-07 15:13:30',84),(1026,'ZIM 590 +256778726704','OK','2011-03-07 15:16:28',86),(1028,'ZIT 663 +256778726704','OK','2011-03-07 15:16:43',86),(1032,'ZIT 550 +256778726704','OK','2011-03-07 15:17:03',86),(1034,'ALB 489 +256754125160','OK','2011-03-07 15:17:18',82),(1036,'LYFL 250 +256778726704','OK','2011-03-07 15:17:28',86),(1038,'SCTS 1000 +256778726704','OK','2011-03-07 15:18:03',86),(1040,'ONCC 1000 +256778726704','OK','2011-03-07 15:18:28',86),(1042,'LYFL 1000 +256778726704','OK','2011-03-07 15:18:39',86),(1044,'TRCH 7 +256778726734','OK','2011-03-07 15:19:14',84),(1046,'ZIM 1000 +256778726704','OK','2011-03-07 15:21:46',86),(1048,'LYFL 6 +256778726734','OK','2011-03-07 15:21:56',84),(1050,'IWRM 1000 +256778726704','OK','2011-03-07 15:22:11',86),(1052,'ALB 1000 +256778726704','OK','2011-03-07 15:22:21',86),(1054,'ZIT 1000 +256778726704','OK','2011-03-07 15:22:31',86),(1056,'MEB 1000 +256778726704','OK','2011-03-07 15:22:46',86),(1058,'PZQ 1000 +256778726704','OK','2011-03-07 15:22:56',86),(1060,'IVR 1000 +256778726704','Drug ID doesn\'t exist: IVR','2011-03-07 15:23:06',86),(1062,'IVN 1000 +256778726704','OK','2011-03-07 15:28:24',86),(1064,'TRCH 1000 +256778726704','OK','2011-03-07 15:28:34',86),(1066,'MEN 500 +256778726734','Drug ID doesn\'t exist: MEN','2011-03-08 08:34:12',84),(1068,'MEB 500 +256778726734','OK','2011-03-08 08:35:20',84),(1070,'ALB 500 +256778726704','OK','2011-03-08 08:48:25',86),(1072,'SCTS 1350 +256778726704','OK','2011-03-08 08:49:37',86),(1080,'PZQ 8653 +256752642388','Phone number +256752642388 not found in database','2011-03-08 11:49:43',88),(1082,'IVM 275000 +256772497180','Phone number +256772497180 not found in database','2011-03-08 11:50:25',90),(1084,'PZQ 21000 +256772497180','OK','2011-03-08 11:56:57',90),(1086,'PZQ 400 +256752642388','OK','2011-03-08 12:02:27',88),(1088,'PZQ 210000 +256772497180','OK','2011-03-08 12:03:56',90),(1090,'LFIL 265000 +256772497180','OK','2011-03-08 12:25:08',90),(1092,'STHS 299000 +256772497180','OK','2011-03-08 12:28:11',90),(1102,'ALB 12000 +256778726704','OK','2011-03-08 13:41:44',86),(1104,'ALB 14000 +256778726704','OK','2011-03-08 13:43:35',86),(1106,'ALB 6789 +19193604046','OK','2011-03-08 14:12:24',44),(1108,'TRAC 10 +256778726734','OK','2011-03-09 07:16:46',84),(1110,'STHS 25 +256778726734','OK','2011-03-09 07:17:38',84),(1112,'LFIL 20 +256778726734','OK','2011-03-09 07:17:48',84),(1114,'LFIL 200 +256778726734','OK','2011-03-09 07:22:17',84),(1116,'ALB 200 +256778726734','OK','2011-03-09 07:22:59',84),(1118,'ALB 5000 +256778726704','OK','2011-03-09 08:23:47',86),(1120,'ZIM 5632 +256752642388','OK','2011-03-09 08:42:33',88),(1122,'ALB 200 +256775428516','OK','2011-03-09 08:44:02',108),(1124,'ALB 3640 +256782702050','OK','2011-03-09 08:44:12',98),(1126,'ALB 14587 +256712813493','Phone number +256712813493 not found in database','2011-03-09 08:45:10',112),(1128,'TRAC 78923 +256752642388','OK','2011-03-09 08:45:30',88),(1130,'ALB 500 +256777655829','Phone number +256777655829 not found in database','2011-03-09 08:45:45',114),(1132,'ALB 500 +256772318182','Incorrect argument set.','2011-03-09 08:46:05',-1),(1134,'ALB 72,500 +256774122368','Incorrect argument set.','2011-03-09 08:47:41',-1),(1136,'KLRO ALB +256783409824','Incorrect argument set.','2011-03-09 08:47:52',-1),(1138,'ALB 230 +256772342834','OK','2011-03-09 08:48:02',94),(1140,'ALB 2000 +256782265645','Incorrect argument set.','2011-03-09 08:48:52',-1),(1142,'ALB 500 +256772854832','OK','2011-03-09 08:49:02',100),(1144,'ZIT 514 +256775428516','OK','2011-03-09 08:49:12',108),(1146,'LFIL 5325 +256754125160','OK','2011-03-09 08:49:37',82),(1148,'ALB  +256782735640','Incorrect argument set.','2011-03-09 08:49:48',-1),(1150,'ZIM  +256700370918','Incorrect argument set.','2011-03-09 08:50:03',-1),(1152,'ALB 600 +256774122368','OK','2011-03-09 08:52:50',92),(1154,'Z  +256782801190','Incorrect argument set.','2011-03-09 08:53:01',-1),(1156,'KLRO ALB +256774805158','Incorrect argument set.','2011-03-09 08:53:11',-1),(1158,'ZIM 400 +256772479318','Phone number +256772479318 not found in database','2011-03-09 08:53:26',116),(1160,'ALB 14587 +256712813493','OK','2011-03-09 08:54:21',112),(1162,'MEB 600 +256782265645','OK','2011-03-09 08:54:46',96),(1164,'TRAC 2020 +256772342834','OK','2011-03-09 08:55:11',94),(1166,'PZQ 1111 +256772342834','OK','2011-03-09 08:58:53',94),(1168,'ALB 300 +256777655829','OK','2011-03-09 08:59:03',114),(1170,'ALB 14587 +256712813493','OK','2011-03-09 08:59:18',112),(1172,'PZQ 600 +256774805158','Phone number +256774805158 not found in database','2011-03-09 08:59:28',118),(1174,'SCHT 4422 +256772342834','OK','2011-03-09 08:59:38',94),(1176,'ALB 600 +256783409824','Phone number +256783409824 not found in database','2011-03-09 08:59:53',120),(1178,'ZIT 50 +256782801190','OK','2011-03-09 09:00:04',110),(1180,'ALB 2000 +256782265645','OK','2011-03-09 09:00:14',96),(1182,'STHS 30000 +256782702050','OK','2011-03-09 09:00:39',98),(1184,'ALB 500 +256772318182','OK','2011-03-09 09:01:24',106),(1186,'IVM 500 +256782801190','OK','2011-03-09 09:01:39',110),(1188,'ALB 500 +256772318182','OK','2011-03-09 09:04:53',106),(1190,'ALB 500 +256774122368','OK','2011-03-09 09:05:08',92),(1192,'ALB 2000 +256775323247','Phone number +256775323247 not found in database','2011-03-09 09:05:18',122),(1194,'IVM 2Ã’OÃ– +256782735640','Quantity must be numeric.','2011-03-09 09:05:28',104),(1196,'IVM 5000 +256782801190','OK','2011-03-09 09:05:53',110),(1198,'TRAC 5O +256782735640','Quantity must be numeric.','2011-03-09 09:07:14',104),(1200,'ZIM 7503 +256754125160','OK','2011-03-09 09:09:41',82),(1202,'LFIL 4500 +256782801190','OK','2011-03-09 09:09:51',110),(1204,'LFIL 165938 +256772497180','OK','2011-03-09 09:10:07',90),(1206,'ZIT 200,TRAC +256782702050','Incorrect argument set.','2011-03-09 09:12:35',-1),(1208,'PZQ 200 +256774805158','OK','2011-03-09 09:12:45',118),(1210,'IVM 52 +256772479318','OK','2011-03-09 09:12:55',116),(1212,'MEB 200 +256783409824','OK','2011-03-09 09:15:03',120),(1214,'ALB A +256775323247','Incorrect argument set.','2011-03-09 09:16:22',-1),(1216,'ALB 5800 +256775323247','OK','2011-03-09 09:20:15',122),(1218,'PZQ 1000 +256712813493','OK','2011-03-09 09:36:30',112),(1220,'STHS 1256 +256775428516','OK','2011-03-09 10:04:03',108),(1222,'ALB 2000 +256775323247','OK','2011-03-09 10:04:55',122),(1224,'ZIM 2000 +256774805158','OK','2011-03-09 10:05:05',118),(1226,'YOU HAVE MTN','Incorrect argument set.','2011-03-09 11:29:47',-1),(1228,'YOU HAVE MTN','Incorrect argument set.','2011-03-09 11:30:00',-1),(1230,'LFIL 23400 +256772342834','OK','2011-03-09 11:40:24',94),(1232,'PZQ 13000 +256782702050','OK','2011-03-09 11:41:03',98),(1234,'SCHT 4300 +256782702050','OK','2011-03-09 11:41:11',98),(1236,'FREDKADAMA@YAHOO.COM  +256772342834','Incorrect argument set.','2011-03-09 11:41:19',-1),(1238,'SORRY IM +256777655829','Incorrect argument set.','2011-03-09 11:44:40',-1),(1240,'ALB 10000 +256772497180','OK','2011-03-09 11:59:18',90),(1242,'ALB 8000 +256775428516','OK','2011-03-09 11:59:31',108),(1244,'IVM 12000 +256775428516','OK','2011-03-09 12:00:11',108),(1246,'ALB 24000 +256772479318','OK','2011-03-09 12:01:30',116),(1248,'STHS 100 +256775428516','OK','2011-03-09 12:01:39',108),(1250,'ALB 12000 +256782702050','OK','2011-03-09 12:01:52',98),(1252,'IVM 6000 +256772497180','OK','2011-03-09 12:02:05',90),(1254,'IVM 15500 +256782702050','OK','2011-03-09 12:02:30',98),(1256,'ALB 8000 +256772342834','OK','2011-03-09 12:02:37',94),(1258,'ALB 8000 +256772342834','OK','2011-03-09 12:04:57',94),(1260,'IVM 6500 +256772479318','OK','2011-03-09 12:05:05',116),(1262,'ALB 17500 +256772318182','OK','2011-03-09 12:05:18',106),(1264,'ONCH  +256775428516','Incorrect argument set.','2011-03-09 12:05:32',-1),(1266,'STHS 100 +256772479318','OK','2011-03-09 12:05:40',116),(1268,'IVM 20000 +256772342834','OK','2011-03-09 12:05:53',94),(1270,'STHS 100 +256782702050','OK','2011-03-09 12:06:06',98),(1272,'IVM 17000 +256772318182','OK','2011-03-09 12:06:14',106),(1274,'STHS 100 +256772497180','OK','2011-03-09 12:06:42',90),(1276,'ALB 100 +256782265645','OK','2011-03-09 12:06:51',96),(1278,'ONCH 100 +256772479318','OK','2011-03-09 12:07:04',116),(1280,'IVM 1500 +256772497180','OK','2011-03-09 12:07:28',90),(1282,'ONCH 100 +256772318182','OK','2011-03-09 12:10:12',106),(1284,'STHS 100 +256772342834','OK','2011-03-09 12:10:22',94),(1286,'STHS 100 +256772318182','OK','2011-03-09 12:10:35',106),(1288,'ALB 12000 +256774122368','OK','2011-03-09 12:11:09',92),(1290,'ONCH 100 +256772342834','OK','2011-03-09 12:11:27',94),(1292,'ALB 15500 +256782735640','OK','2011-03-09 12:11:35',104),(1294,'ALB 20000 +256772854832','OK','2011-03-09 12:11:43',100),(1296,'ALB 6000 +256758805158','Phone number +256758805158 not found in database','2011-03-09 12:12:01',124),(1298,'IVM 12000 +256774122368','OK','2011-03-09 12:12:09',92),(1300,'STHS 1500 +256782265645','OK','2011-03-09 12:12:45',96),(1302,'IVM 17500 +256772854832','OK','2011-03-09 12:15:27',100),(1304,'STHS 100 +256782735640','OK','2011-03-09 12:15:36',104),(1306,'IVM 1500 +256782801190','OK','2011-03-09 12:15:50',110),(1308,'ONCH 100 +256782735640','OK','2011-03-09 12:15:59',104),(1310,'ALB 10000; +256775323247','Incorrect argument set.','2011-03-09 12:16:08',-1),(1312,'STHS 100 +256772854832','OK','2011-03-09 12:16:26',100),(1314,'IVM1500  +256754125160','Incorrect argument set.','2011-03-09 12:17:10',-1),(1316,'STHS100  +256754125160','Incorrect argument set.','2011-03-09 12:17:20',-1),(1318,'YOU HAVE MTN','Incorrect argument set.','2011-03-10 12:58:55',-1),(1320,'YOU HAVE MTN','Incorrect argument set.','2011-03-10 13:03:30',-1),(1322,'STHS 100 +256772342834','OK','2011-03-11 11:18:36',94),(1324,'ONCH 100 +256772342834','OK','2011-03-11 11:18:50',94),(1326,'ALB 8000 +256772342834','OK','2011-03-11 11:19:00',94),(1328,'TRAC 500 +256754125160','OK','2011-03-11 11:19:10',82),(1330,'XXXXX  +256754125160','Incorrect argument set.','2011-03-11 11:19:25',-1),(1332,'TEST  +256754125160','Incorrect argument set.','2011-03-11 11:19:35',-1),(1334,'ABLE 5000 +256754125160','Treatment ID doesn\'t exist: ABLE','2011-03-11 11:21:20',82),(1336,'ABL 500 +256754125160','Drug ID doesn\'t exist: ABL','2011-03-11 11:21:30',82),(1338,'IVM 20000 +256772342834','OK','2011-03-11 11:43:53',94),(1340,'ONCH 100 +256772497180','OK','2011-03-11 11:44:03',90),(1342,'ALB  +256782801190','Incorrect argument set.','2011-03-11 11:45:21',-1),(1344,'IVM  +256782801190','Incorrect argument set.','2011-03-11 11:45:36',-1),(1346,'IVM 1500 +256782801190','OK','2011-03-14 06:32:34',110),(1348,'ONCH 100 +256782801190','OK','2011-03-14 06:32:49',110),(1350,'ALB 12000 +256782801190','OK','2011-03-14 06:32:59',110),(1352,'STHS 100 +256782801190','OK','2011-03-14 06:33:09',110),(1354,'IVM 1500 +256782801190','OK','2011-03-14 06:33:24',110),(1356,'STHS 100 +256782702050','OK','2011-03-14 06:33:34',98),(1358,'IVM 15500 +256782702050','OK','2011-03-14 06:33:44',98),(1360,'ALB 12000 +256782702050','OK','2011-03-14 06:33:59',98),(1362,'SCHT 100 +256782702050','OK','2011-03-14 06:34:09',98),(1364,'ALB 16000 +256772854832','OK','2011-03-14 13:50:45',100),(1366,'IVM 14000 +256772854832','OK','2011-03-14 13:55:25',100),(1368,'STHS 105 +256772854832','OK','2011-03-14 13:58:31',100),(1370,'ONCH 120 +256772854832','OK','2011-03-14 14:01:17',100),(1372,'+256782801190  ','Incorrect argument set.','2011-03-17 05:40:38',-1),(1374,'ONCH  +256782801190','Incorrect argument set.','2011-03-17 05:44:10',-1),(1376,'ONCH 100 +256782801190','OK','2011-03-17 05:46:52',110),(1378,'ALB 9600 +256782801190','OK','2011-03-17 05:50:49',110),(1380,'STHS 114 +256782801190','OK','2011-03-17 05:52:43',110),(1382,'IVM 1200 +256782801190','OK','2011-03-17 05:55:25',110),(1384,'ONCH 165 +256782801190','OK','2011-03-17 05:58:06',110),(1386,'ALB 8000 +256772497180','OK','2011-03-18 09:32:50',90),(1388,'IVM 1200 +256772497180','OK','2011-03-18 09:33:42',90),(1390,'ONCH 134 +256772497180','OK','2011-03-18 16:04:30',90),(1392,'STHS 110 +256782265645','OK','2011-03-21 08:25:01',96),(1394,'ONCH 155 +256775428516','OK','2011-03-21 11:50:45',108),(1396,'STHS 110 +256774122368','OK','2011-03-22 17:33:39',92),(1398,'ONCH 195 +256774122368','OK','2011-03-22 18:34:01',92),(1400,'ONCH 195 +256774122368','OK','2011-03-22 20:35:58',92),(1402,'ALB 9600 +256774122368','OK','2011-03-22 21:35:40',92),(1404,'ALB 9600 +256774122368','OK','2011-03-22 22:54:29',92),(1406,'ALB 500 +19193604046','OK','2011-03-23 13:06:36',44),(1408,'YOU HAVE MTN','Incorrect argument set.','2011-03-23 13:32:35',-1),(1410,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-03-23 13:39:30',-1),(1412,'YOU HAVE MTN','Incorrect argument set.','2011-03-23 13:39:44',-1),(1414,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-03-23 13:39:54',-1),(1416,'ALB 9600 +256782702050','OK','2011-03-23 13:40:04',98),(1418,'IVM 12400 +256782702050','OK','2011-03-23 13:40:19',98),(1420,'STHS 130 +256782702050','OK','2011-03-23 13:40:29',98),(1422,'ONCH 190 +256782702050','OK','2011-03-23 13:40:39',98),(1424,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-03-23 14:05:32',-1),(1426,'YOU HAVE MTN','Incorrect argument set.','2011-03-23 14:05:42',-1),(1428,'YOU HAVE MTN','Incorrect argument set.','2011-03-23 14:06:17',-1),(1430,'YOU HAVE MTN','Incorrect argument set.','2011-03-23 14:24:32',-1),(1432,'YOU HAVE MTN','Incorrect argument set.','2011-03-23 14:24:55',-1),(1434,'YOU HAVE MTN','Incorrect argument set.','2011-03-23 14:32:21',-1),(1436,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-03-23 14:32:34',-1),(1438,'YOU HAVE MTN','Incorrect argument set.','2011-03-23 14:32:41',-1),(1440,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-03-23 14:32:59',-1),(1442,'YOU HAVE MTN','Incorrect argument set.','2011-03-23 14:33:07',-1),(1444,'YOU HAVE MTN','Incorrect argument set.','2011-03-23 14:33:20',-1),(1446,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-03-23 14:33:33',-1),(1448,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-03-23 14:33:41',-1),(1450,'YOU HAVE MTN','Incorrect argument set.','2011-03-23 14:33:55',-1),(1452,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-03-23 14:34:07',-1),(1454,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-03-23 15:25:33',-1),(1456,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-03-23 15:25:46',-1),(1458,'THANX O +256782801190','Incorrect argument set.','2011-03-23 15:38:38',-1),(1460,'I WAS +256772342834','Incorrect argument set.','2011-03-23 18:50:07',-1),(1462,'ALB 6400 +256772342834','OK','2011-03-23 18:53:41',94),(1464,'IVM 16000 +256772342834','OK','2011-03-23 18:56:45',94),(1466,'STHS 120 +256772342834','OK','2011-03-23 18:58:03',94),(1468,'THIS IS +447781481761','Incorrect argument set.','2011-03-23 19:58:05',-1),(1470,'THANKS FOR +256772318182','Incorrect argument set.','2011-03-24 05:47:01',-1),(1472,'ALB 9600 +256782801190','OK','2011-03-24 07:27:19',110),(1474,'ALB 7680 +256782801190','OK','2011-03-24 07:30:47',110),(1476,'STHS 130 +256782801190','OK','2011-03-24 07:34:25',110),(1478,'IVM 960 +256782801190','OK','2011-03-24 07:37:14',110),(1480,'ALB 7680 +256782702050','OK','2011-03-24 15:19:28',98),(1482,'IVM 9920 +256782702050','OK','2011-03-24 15:20:19',98),(1484,'STHS 169 +256782702050','OK','2011-03-24 15:21:01',98),(1486,'ONCH 361 +256782702050','OK','2011-03-24 15:25:30',98),(1488,'ALB 5120 +256772342834','OK','2011-03-25 06:33:55',94),(1490,'STHS 144 +256772342834','OK','2011-03-25 06:34:55',94),(1492,'IVM 12800 +256772342834','OK','2011-03-25 06:35:05',94),(1494,'ONCH 144 +256772342834','OK','2011-03-25 06:35:15',94),(1496,'STHS 121 +256782265645','OK','2011-03-25 06:35:31',96),(1498,'ALB 960 +256782265645','OK','2011-03-25 06:35:41',96),(1500,'IVM 11200 +256782265645','OK','2011-03-25 06:35:51',96),(1502,'ALB 12800 +256772854832','OK','2011-03-25 07:25:22',100),(1504,'IVM 11200 +256772854832','OK','2011-03-25 07:27:42',100),(1506,'STHS 110 +256772854832','OK','2011-03-25 07:29:36',100),(1508,'ONCH 144 +256772854832','OK','2011-03-25 07:31:52',100),(1510,'ALB 15360 +256772479318','OK','2011-03-25 13:37:18',116),(1512,'IVM 4160 +256772479318','OK','2011-03-25 13:38:32',116),(1514,'ALB 6400 +256775323247','OK','2011-03-25 13:39:29',122),(1516,'STHS 130 +256772479318','OK','2011-03-25 13:41:23',116),(1518,'ONCH 306 +256772479318','OK','2011-03-25 13:42:12',116),(1520,'STHS 116 +256772854832','OK','2011-03-25 13:43:04',100),(1522,'IVM 3840 +256775323247','OK','2011-03-25 13:43:24',122),(1524,'ONCH 173 +256772854832','OK','2011-03-25 13:44:44',100),(1526,'ALB 10240 +256772854832','OK','2011-03-25 13:47:03',100),(1528,'+256775323247  ','Incorrect argument set.','2011-03-25 13:47:54',-1),(1530,'IVM 8960 +256772854832','OK','2011-03-25 13:49:20',100),(1532,'STHS 132 +256775323247','OK','2011-03-25 13:50:15',122),(1534,'ONCH 306 +256775323247','OK','2011-03-25 13:53:11',122),(1536,'ALB 11200 +256772318182','OK','2011-03-28 10:55:43',106),(1538,'IVM 10880 +256772318182','OK','2011-03-28 10:55:53',106),(1540,'STHS 123 +256772318182','OK','2011-03-28 10:57:10',106),(1542,'ONCH 180 +256772318182','OK','2011-03-28 12:56:52',106),(1544,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-03-31 13:14:19',-1),(1546,'YOU HAVE MTN','Incorrect argument set.','2011-03-31 13:14:34',-1),(1548,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-03-31 13:14:44',-1),(1550,'YOU HAVE MTN','Incorrect argument set.','2011-03-31 13:14:54',-1),(1552,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-03-31 13:30:45',-1),(1554,'YOU HAVE MTN','Incorrect argument set.','2011-03-31 13:30:55',-1),(1556,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-03-31 13:31:05',-1),(1558,'YOU HAVE MTN','Incorrect argument set.','2011-03-31 13:31:20',-1),(1560,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-03-31 13:31:30',-1),(1562,'YOU HAVE MTN','Incorrect argument set.','2011-03-31 13:31:40',-1),(1564,'YOU HAVE MTN','Incorrect argument set.','2011-03-31 13:31:55',-1),(1566,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-03-31 13:32:06',-1),(1568,'YOU HAVE MTN','Incorrect argument set.','2011-03-31 13:32:16',-1),(1570,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-03-31 13:32:30',-1),(1572,'I WILL +256782265645','Incorrect argument set.','2011-03-31 14:10:24',-1),(1574,'YOU HAVE MTN','Incorrect argument set.','2011-03-31 14:19:39',-1),(1576,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-03-31 14:23:53',-1),(1578,'YOU HAVE MTN','Incorrect argument set.','2011-03-31 14:24:03',-1),(1580,'ALB 4096 +256772342834','OK','2011-04-01 11:04:38',94),(1582,'STHS 173 +256772342834','OK','2011-04-01 11:04:52',94),(1584,'ONCH 173 +256772342834','OK','2011-04-01 11:05:03',94),(1586,'ALB 8960 +256772318182','OK','2011-04-01 11:05:13',106),(1588,'IVM 8704 +256772318182','OK','2011-04-01 11:05:28',106),(1590,'STHS 137 +256772318182','OK','2011-04-01 11:05:38',106),(1592,'ONCH 241 +256772318182','OK','2011-04-01 11:05:48',106),(1594,'ONCH 272 +256782801190','OK','2011-04-01 11:06:03',110),(1596,'ONCH 272 +256782801190','OK','2011-04-01 11:06:13',110),(1598,'IVM 89600 +256782265645','OK','2011-04-01 11:06:23',96),(1600,'ALB 6144 +256782801190','OK','2011-04-01 11:13:44',110),(1602,'STHS  +256782801190','Incorrect argument set.','2011-04-01 11:15:59',-1),(1604,'STHS 148 +256782801190','OK','2011-04-01 11:21:20',110),(1606,'IVM 768 +256782801190','OK','2011-04-01 11:23:15',110),(1608,'ONCH 449 +256782801190','OK','2011-04-01 11:25:11',110),(1610,'ALB 7680 +256774122368','OK','2011-04-01 13:53:25',92),(1612,'IVM 7680 +256774122368','OK','2011-04-01 13:54:27',92),(1614,'ALB 6144 +256774122368','OK','2011-04-01 13:56:29',92),(1616,'IVM 6144 +256774122368','OK','2011-04-01 13:57:19',92),(1618,'YOU HAVE MTN','Incorrect argument set.','2011-04-02 09:33:10',-1),(1620,'ALB 20000 +256783409824','OK','2011-04-02 11:15:02',120),(1622,'MEB 19500 +256783409824','OK','2011-04-02 11:18:37',120),(1624,'IVM 23000 +256783409824','OK','2011-04-02 11:20:10',120),(1626,'ZIM 13000 +256783409824','OK','2011-04-02 11:24:03',120),(1628,'ZIT 22000 +256783409824','OK','2011-04-02 11:24:55',120),(1630,'STHS 220 +256782702050','OK','2011-04-04 11:04:35',98),(1632,'ONCHO 686 +256782702050','Drug/Treatment ID incorrect.','2011-04-04 11:04:50',98),(1634,'ALB 6144 +256782702050','OK','2011-04-04 11:23:46',98),(1636,'IVM 7936 +256782702050','OK','2011-04-04 11:25:04',98),(1638,'ALB 4915 +256782801190','OK','2011-04-04 13:26:09',110),(1640,'STHS 169 +256782801190','OK','2011-04-04 13:29:28',110),(1642,'IVM 614 +256782801190','OK','2011-04-04 13:32:13',110),(1644,'ONCH 741 +256782801190','OK','2011-04-04 13:33:47',110),(1646,'YOU HAVE MTN','Incorrect argument set.','2011-04-05 14:29:44',-1),(1648,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-05 14:29:53',-1),(1650,'YOU HAVE MTN','Incorrect argument set.','2011-04-05 16:41:28',-1),(1652,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-05 16:41:38',-1),(1654,'ALB 8192 +256772854832','OK','2011-04-06 06:47:28',100),(1656,'IVM 7168 +256772854832','OK','2011-04-06 06:51:07',100),(1658,'ONCH 207 +256772854832','OK','2011-04-06 06:56:17',100),(1660,'ONCH 249 +256772854832','OK','2011-04-06 14:26:50',100),(1662,'STHS 128 +256772854832','OK','2011-04-06 14:28:46',100),(1664,'ALB 6554 +256772854832','OK','2011-04-06 14:30:51',100),(1666,'IVM 5734 +256772854832','OK','2011-04-06 14:33:11',100),(1668,'ALB 614 +256782265645','OK','2011-04-11 11:04:33',96),(1670,'IVM 7168 +256782265645','OK','2011-04-11 11:04:48',96),(1672,'STHS 146 +256782265645','OK','2011-04-11 11:04:58',96),(1674,'ALB 7168 +256772318182','OK','2011-04-11 11:05:08',106),(1676,'IVM 6963 +256772318182','OK','2011-04-11 11:05:23',106),(1678,'STHS 152 +256772318182','OK','2011-04-11 11:05:34',106),(1680,'ONCH 322 +256772318182','OK','2011-04-11 11:05:44',106),(1682,'ALB 3932 +256782801190','OK','2011-04-11 11:05:59',110),(1684,'STHS 193 +256782801190','OK','2011-04-11 11:06:09',110),(1686,'ONCH 1303 +256782702050','OK','2011-04-11 11:06:19',98),(1688,'IVM 492 +256782801190','OK','2011-04-11 12:40:00',110),(1690,'ONCH 1223 +256782801190','OK','2011-04-11 12:42:00',110),(1692,'ALB 3146 +256782801190','OK','2011-04-11 12:44:52',110),(1694,'STHS 219 +256782801190','OK','2011-04-11 12:47:34',110),(1696,'IVM 393 +256782801190','OK','2011-04-11 12:49:21',110),(1698,'ONCH 2018 +256782801190','OK','2011-04-11 12:52:03',110),(1700,'ALB 2517 +256782801190','OK','2011-04-11 12:57:35',110),(1702,'STHS 250 +256782801190','OK','2011-04-11 12:59:30',110),(1704,'IVM 315 +256782801190','OK','2011-04-11 13:00:49',110),(1706,'ONCH 3330 +256782801190','OK','2011-04-11 13:02:45',110),(1708,'YOU HAVE MTN','Incorrect argument set.','2011-04-11 16:52:20',-1),(1710,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-11 16:56:38',-1),(1712,'YOU HAVE MTN','Incorrect argument set.','2011-04-11 18:12:15',-1),(1714,'YOU HAVE MTN','Incorrect argument set.','2011-04-11 18:12:41',-1),(1716,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-11 18:22:45',-1),(1718,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-11 18:22:55',-1),(1720,'YOU HAVE MTN','Incorrect argument set.','2011-04-11 18:23:10',-1),(1722,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-11 18:23:30',-1),(1724,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-11 18:23:45',-1),(1726,'YOU HAVE MTN','Incorrect argument set.','2011-04-11 18:23:56',-1),(1728,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-11 18:34:12',-1),(1730,'YOU HAVE MTN','Incorrect argument set.','2011-04-11 18:34:22',-1),(1732,'YOU HAVE MTN','Incorrect argument set.','2011-04-11 18:34:32',-1),(1734,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-11 18:34:47',-1),(1736,'YOU HAVE MTN','Incorrect argument set.','2011-04-11 18:34:57',-1),(1738,'YOU HAVE MTN','Incorrect argument set.','2011-04-11 18:35:07',-1),(1740,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-11 18:35:22',-1),(1742,'YOU HAVE MTN','Incorrect argument set.','2011-04-11 20:26:55',-1),(1744,'YOU HAVE MTN','Incorrect argument set.','2011-04-11 20:27:18',-1),(1746,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-11 20:27:31',-1),(1748,'YOU HAVE MTN','Incorrect argument set.','2011-04-11 20:27:44',-1),(1750,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-11 20:27:57',-1),(1752,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-11 20:28:10',-1),(1754,'YOU HAVE MTN','Incorrect argument set.','2011-04-11 20:28:24',-1),(1756,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-11 20:51:22',-1),(1758,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-11 20:51:34',-1),(1760,'YOU HAVE MTN','Incorrect argument set.','2011-04-11 20:51:48',-1),(1762,'ALB 4915 +256774122368','OK','2011-04-11 20:52:21',92),(1764,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-11 20:52:34',-1),(1766,'SORRY, YOU MTN','Incorrect argument set.','2011-04-11 20:52:47',-1),(1768,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-11 20:52:59',-1),(1770,'YOU HAVE MTN','Incorrect argument set.','2011-04-11 20:53:13',-1),(1772,'IVM 4915 +256774122368','OK','2011-04-11 21:31:53',92),(1774,'ALB 3932 +256774122368','OK','2011-04-11 21:32:11',92),(1776,'IVM 3932 +256774122368','OK','2011-04-11 21:32:24',92),(1778,'ALB 3277 +256772342834','OK','2011-04-12 04:57:42',94),(1780,'IVM 8192 +256772342834','OK','2011-04-12 04:59:11',94),(1782,'STHS 207 +256772342834','OK','2011-04-12 05:01:06',94),(1784,'ONCH 207 +256772342834','OK','2011-04-12 05:02:10',94),(1786,'IVM 20000 +256783409824','OK','2011-04-12 07:26:16',120),(1788,'ALB 17000 +256783409824','OK','2011-04-12 07:27:05',120),(1790,'MEB 17200 +256783409824','OK','2011-04-12 07:28:20',120),(1792,'ZIM 11000 +256783409824','OK','2011-04-12 07:28:40',120),(1794,'ZIT 20000 +256783409824','OK','2011-04-12 07:29:44',120),(1796,'IVM 20000 +256783409824','OK','2011-04-12 07:38:58',120),(1798,'ALB 17000 +256783409824','OK','2011-04-12 07:41:18',120),(1800,'MEB 17200 +256783409824','OK','2011-04-12 07:42:47',120),(1802,'ZIM 11000 +256783409824','OK','2011-04-12 07:43:39',120),(1804,'ZIT 20000 +256783409824','OK','2011-04-12 07:44:57',120),(1806,'ALB 2458 +256774805158','OK','2011-04-12 11:16:15',118),(1808,'IVM  +256774805158','Incorrect argument set.','2011-04-12 11:19:06',-1),(1810,'IVM  +256774805158','Incorrect argument set.','2011-04-12 11:25:49',-1),(1812,'STHS  +256774805158','Incorrect argument set.','2011-04-12 11:28:04',-1),(1814,'ONCH  +256774805158','Incorrect argument set.','2011-04-12 11:30:33',-1),(1816,'STHS  +256774805158','Incorrect argument set.','2011-04-12 12:20:25',-1),(1818,'ONCH  +256774805158','Incorrect argument set.','2011-04-12 12:22:46',-1),(1820,'ALB 6400 +256775428516','OK','2011-04-12 16:48:00',108),(1822,'IVM 9600 +256775428516','OK','2011-04-12 16:48:42',108),(1824,'STHS 110 +256775428516','OK','2011-04-12 16:49:45',108),(1826,'ONCH 125 +256775428516','OK','2011-04-12 16:49:55',108),(1828,'ALB 5120 +256775428516','OK','2011-04-12 16:52:26',108),(1830,'IVM 7680 +256775428516','OK','2011-04-12 16:53:55',108),(1832,'STHS 121 +256775428516','OK','2011-04-12 16:54:48',108),(1834,'ONCH 240 +256775428516','OK','2011-04-12 16:56:02',108),(1836,'STHS 161 +256774122368','OK','2011-04-12 20:50:02',92),(1838,'ONCH 2820 +256774122368','OK','2011-04-12 20:51:30',92),(1840,'STHS 169 +256772497180','OK','2011-04-13 11:04:34',90),(1842,'ONCH 322 +256772497180','OK','2011-04-13 11:04:49',90),(1844,'ALB 4096 +256772497180','OK','2011-04-13 11:04:59',90),(1846,'IVM 614 +256772497180','OK','2011-04-13 11:05:09',90),(1848,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-13 14:15:48',-1),(1850,'YOU HAVE MTN','Incorrect argument set.','2011-04-13 14:15:58',-1),(1852,'IVM 3670 +256772854832','OK','2011-04-14 08:09:23',100),(1854,'ALB 4194 +256772854832','OK','2011-04-14 08:12:30',100),(1856,'STHS 141 +256772854832','OK','2011-04-14 08:14:51',100),(1858,'ONCH 358 +256772854832','OK','2011-04-14 08:16:20',100),(1860,'ALB 492 +256782265645','OK','2011-04-15 08:06:14',96),(1862,'IVM 5734 +256782265645','OK','2011-04-15 08:07:17',96),(1864,'STHS 161 +256782265645','OK','2011-04-15 08:07:59',96),(1866,'STHS 193 +256772497180','OK','2011-04-15 08:58:39',90),(1868,'ONCH 432 +256772497180','OK','2011-04-15 08:59:47',90),(1870,'ALB 3277 +256772497180','OK','2011-04-15 09:01:17',90),(1872,'IVM 492 +256772497180','OK','2011-04-15 09:01:58',90),(1874,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-15 13:18:20',-1),(1876,'YOU HAVE MTN','Incorrect argument set.','2011-04-15 13:18:35',-1),(1878,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-15 13:18:46',-1),(1880,'YOU HAVE MTN','Incorrect argument set.','2011-04-15 13:18:56',-1),(1882,'YOU HAVE MTN','Incorrect argument set.','2011-04-15 13:35:38',-1),(1884,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-15 13:35:58',-1),(1886,'YOU HAVE MTN','Incorrect argument set.','2011-04-15 13:36:13',-1),(1888,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-15 13:36:23',-1),(1890,'YOU HAVE MTN','Incorrect argument set.','2011-04-15 13:36:33',-1),(1892,'YOU HAVE MTN','Incorrect argument set.','2011-04-15 13:36:48',-1),(1894,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-15 13:40:21',-1),(1896,'YOU HAVE MTN','Incorrect argument set.','2011-04-15 13:40:31',-1),(1898,'YOU HAVE MTN','Incorrect argument set.','2011-04-15 13:40:56',-1),(1900,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-15 13:41:07',-1),(1902,'YOU HAVE MTN','Incorrect argument set.','2011-04-15 13:41:22',-1),(1904,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-15 13:41:32',-1),(1906,'YOU HAVE MTN','Incorrect argument set.','2011-04-15 13:41:42',-1),(1908,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-15 13:42:07',-1),(1910,'YOU HAVE MTN','Incorrect argument set.','2011-04-15 14:24:48',-1),(1912,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-15 15:09:00',-1),(1914,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-15 15:09:10',-1),(1916,'YOU HAVE MTN','Incorrect argument set.','2011-04-15 15:17:15',-1),(1918,'YOU HAVE MTN','Incorrect argument set.','2011-04-15 15:17:36',-1),(1920,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-15 15:17:51',-1),(1922,'STHS 169 +256772318182','OK','2011-04-15 16:58:10',106),(1924,'ONCH 432 +256772318182','OK','2011-04-15 16:59:27',106),(1926,'ALB 5734 +256772318182','OK','2011-04-15 17:00:31',106),(1928,'IVM 5571 +256772318182','OK','2011-04-15 17:01:40',106),(1930,'ALB 4096 +256775428516','OK','2011-04-18 11:04:41',108),(1932,'IVM 6144 +256775428516','OK','2011-04-18 11:04:56',108),(1934,'STHS 133 +256775428516','OK','2011-04-18 11:05:06',108),(1936,'ONCH 372 +256775428516','OK','2011-04-18 11:05:16',108),(1938,'+256775428516  ','Incorrect argument set.','2011-04-18 11:05:31',-1),(1940,'ALB 3277 +256775428516','OK','2011-04-18 11:05:42',108),(1942,'IVM 4915 +256775428516','OK','2011-04-18 11:05:52',108),(1944,'STHS 146 +256775428516','OK','2011-04-18 11:06:07',108),(1946,'ONCH 577 +256775428516','OK','2011-04-18 11:06:17',108),(1948,'ALB 2621 +256775428516','OK','2011-04-18 11:06:27',108),(1950,'ALB 2621 +256772342834','OK','2011-04-19 03:33:56',94),(1952,'IVM 6554 +256772342834','OK','2011-04-19 03:35:25',94),(1954,'STHS 249 +256772342834','OK','2011-04-19 03:36:50',94),(1956,'ONCH 249 +256772342834','OK','2011-04-19 03:38:08',94),(1958,'STHS 371 +256782702050','OK','2011-04-19 06:51:57',98),(1960,'ONCH 2476 +256782702050','OK','2011-04-19 06:53:41',98),(1962,'ALB 3932 +256782702050','OK','2011-04-19 06:55:43',98),(1964,'IVM 5079 +256782702050','OK','2011-04-19 06:58:35',98),(1966,'+256775428516  ','Incorrect argument set.','2011-04-20 08:32:38',-1),(1968,'+256775428516  ','Incorrect argument set.','2011-04-20 19:52:40',-1),(1970,'ALB 3146 +256782702050','OK','2011-04-26 23:04:37',98),(1972,'IVM 4063 +256782702050','OK','2011-04-26 23:04:52',98),(1974,'STHS 483 +256782702050','OK','2011-04-26 23:05:02',98),(1976,'4705  +256782702050','Incorrect argument set.','2011-04-26 23:05:12',-1),(1978,'ONCH 4705 +256782702050','OK','2011-04-27 11:04:32',98),(1980,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-28 13:59:16',-1),(1982,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-28 14:11:50',-1),(1984,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-28 14:16:20',-1),(1986,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-28 14:19:25',-1),(1988,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-28 14:19:45',-1),(1990,'YOU HAVE MTN','Incorrect argument set.','2011-04-28 14:20:00',-1),(1992,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-28 14:20:11',-1),(1994,'YOU HAVE MTN','Incorrect argument set.','2011-04-28 14:20:21',-1),(1996,'YOU HAVE MTN','Incorrect argument set.','2011-04-28 14:20:46',-1),(1998,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-28 14:34:03',-1),(2000,'YOU HAVE MTN','Incorrect argument set.','2011-04-28 14:34:13',-1),(2002,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-28 14:34:23',-1),(2004,'YOU HAVE MTN','Incorrect argument set.','2011-04-28 14:34:38',-1),(2006,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-28 14:34:48',-1),(2008,'YOU HAVE MTN','Incorrect argument set.','2011-04-28 14:34:58',-1),(2010,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-28 14:35:13',-1),(2012,'SORRY, YOU MTN','Incorrect argument set.','2011-04-28 14:35:48',-1),(2014,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-28 14:52:45',-1),(2016,'YOU HAVE MTN','Incorrect argument set.','2011-04-28 14:52:55',-1),(2018,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-28 14:53:10',-1),(2020,'STHS 219 +256772497180','OK','2011-04-28 15:32:46',90),(2022,'STHS 177 +256782265645','OK','2011-04-28 15:33:11',96),(2024,'ONCH 579 +256772497180','OK','2011-04-28 15:33:21',90),(2026,'IVM 4588 +256782265645','OK','2011-04-28 15:33:31',96),(2028,'IVM 4588 +256782265645','OK','2011-04-28 15:33:46',96),(2030,'ALB 393 +256782265645','OK','2011-04-28 15:33:56',96),(2032,'ALB 2621 +256772497180','OK','2011-04-28 15:34:06',90),(2034,'YOU HAVE MTN','Incorrect argument set.','2011-04-28 15:51:14',-1),(2036,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-28 15:51:24',-1),(2038,'YOU HAVE MTN','Incorrect argument set.','2011-04-28 15:51:34',-1),(2040,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-28 15:51:49',-1),(2042,'SORRY, YOU MTN','Incorrect argument set.','2011-04-28 15:51:59',-1),(2044,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-28 15:52:26',-1),(2046,'YOU HAVE MTN','Incorrect argument set.','2011-04-28 15:52:36',-1),(2048,'SORRY, YOUR MTN','Incorrect argument set.','2011-04-28 15:52:46',-1),(2050,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-28 15:53:01',-1),(2052,'YOU HAVE MTN','Incorrect argument set.','2011-04-28 15:53:11',-1),(2054,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-28 15:53:21',-1),(2056,'SORRY, YOUR MTN','Incorrect argument set.','2011-04-28 15:53:36',-1),(2058,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-28 15:53:47',-1),(2060,'IVM 393 +256772497180','OK','2011-04-28 16:21:55',90),(2062,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-28 16:52:13',-1),(2064,'SORRY, YOUR MTN','Incorrect argument set.','2011-04-28 16:52:23',-1),(2066,'SORRY, YOUR MTN','Incorrect argument set.','2011-04-28 16:52:50',-1),(2068,'PROCESSING REQUEST, MTN','Incorrect argument set.','2011-04-28 16:53:16',-1),(2070,'ALB 1678 +256772342834','OK','2011-04-29 11:04:35',94),(2072,'IVM 4194 +256772342834','OK','2011-04-29 11:04:50',94),(2074,'STHS 358 +256772342834','OK','2011-04-29 11:05:00',94),(2076,'ONCH 358 +256772342834','OK','2011-04-29 11:05:10',94),(2078,'ALB 315 +256782265645','OK','2011-04-29 11:05:25',96),(2080,'IVM 3670 +256782265645','OK','2011-04-29 11:05:36',96),(2082,'STHS 195 +256782265645','OK','2011-04-29 11:05:46',96),(2084,'ALB 2517 +256782801190','OK','2011-04-29 11:06:00',110),(2086,'STHS 250 +256782801190','OK','2011-04-29 11:06:11',110),(2088,'IVM 315 +256782801190','OK','2011-04-29 11:06:21',110),(2090,'ALB 3670 +256772318182','OK','2011-04-29 12:43:54',106),(2092,'IVM 3565 +256772318182','OK','2011-04-29 12:45:06',106),(2094,'STHS 208 +256772318182','OK','2011-04-29 12:45:57',106),(2096,'ONCH 776 +256772318182','OK','2011-04-29 12:46:44',106),(2098,'IVM 315 +256772497180','OK','2011-04-29 14:29:08',90),(2100,'STHS 250 +256772497180','OK','2011-04-29 14:29:34',90),(2102,'ONCH 776 +256772497180','OK','2011-04-29 14:29:44',90),(2104,'ZIT 513282, +256782735640','Incorrect argument set.','2011-04-29 18:35:52',-1),(2106,'ALB 2517 +256782702050','OK','2011-05-11 12:45:46',98),(2108,'IVM 3251 +256782702050','OK','2011-05-11 12:46:01',98),(2110,'STHS 627 +256782702050','OK','2011-05-11 12:46:11',98),(2112,'ONCH 8939 +256782702050','OK','2011-05-11 12:46:21',98),(2114,'DOWNLOAD ANGELAA MTN','Incorrect argument set.','2011-06-02 16:22:21',-1);
/*!40000 ALTER TABLE `rawreports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stats`
--

DROP TABLE IF EXISTS `stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stats` (
  `id` int(11) NOT NULL auto_increment,
  `quantity` int(5) NOT NULL,
  `created` datetime NOT NULL,
  `drug_id` int(11) default '0',
  `treatment_id` int(11) default '0',
  `rawreport_id` int(11) NOT NULL,
  `phone_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=929 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stats`
--

LOCK TABLES `stats` WRITE;
/*!40000 ALTER TABLE `stats` DISABLE KEYS */;
INSERT INTO `stats` VALUES (236,100,'2011-03-07 15:08:07',22,0,996,84,6),(238,200,'2011-03-07 15:08:16',20,0,998,84,6),(240,400,'2011-03-07 15:09:14',16,0,1000,84,6),(242,500,'2011-03-07 15:09:24',24,0,1002,84,6),(244,300,'2011-03-07 15:09:34',14,0,1004,84,6),(248,3,'2011-03-07 15:11:54',0,29,1012,84,6),(256,4,'2011-03-07 15:13:30',0,31,1024,84,6),(258,590,'2011-03-07 15:16:28',14,0,1026,86,7),(260,663,'2011-03-07 15:16:43',16,0,1028,86,7),(264,550,'2011-03-07 15:17:03',16,0,1032,86,7),(266,489,'2011-03-07 15:17:18',18,0,1034,82,9),(268,250,'2011-03-07 15:17:28',0,26,1036,86,7),(270,1000,'2011-03-07 15:18:03',0,29,1038,86,7),(272,1000,'2011-03-07 15:18:28',0,28,1040,86,7),(274,1000,'2011-03-07 15:18:39',0,26,1042,86,7),(276,7,'2011-03-07 15:19:14',0,33,1044,84,6),(278,1000,'2011-03-07 15:21:46',14,0,1046,86,7),(280,6,'2011-03-07 15:21:56',0,26,1048,84,6),(282,1000,'2011-03-07 15:22:11',0,31,1050,86,7),(284,1000,'2011-03-07 15:22:21',18,0,1052,86,7),(286,1000,'2011-03-07 15:22:31',16,0,1054,86,7),(288,1000,'2011-03-07 15:22:46',20,0,1056,86,7),(290,1000,'2011-03-07 15:22:56',24,0,1058,86,7),(292,1000,'2011-03-07 15:28:24',22,0,1062,86,7),(294,1000,'2011-03-07 15:28:34',0,33,1064,86,7),(296,500,'2011-03-08 08:35:20',20,0,1068,84,6),(298,500,'2011-03-08 08:48:25',18,0,1070,86,7),(300,1350,'2011-03-08 08:49:37',0,29,1072,86,7),(302,21000,'2011-03-08 11:56:57',24,0,1084,90,14),(304,400,'2011-03-08 12:02:27',24,0,1086,88,14),(306,210000,'2011-03-08 12:03:56',24,0,1088,90,14),(308,265000,'2011-03-08 12:25:08',0,26,1090,90,14),(310,299000,'2011-03-08 12:28:11',0,31,1092,90,14),(312,12000,'2011-03-08 13:41:44',18,0,1102,86,7),(314,14000,'2011-03-08 13:43:35',18,0,1104,86,7),(316,6789,'2011-03-08 14:12:24',18,0,1106,44,7),(318,10,'2011-03-09 07:16:46',0,33,1108,84,6),(320,25,'2011-03-09 07:17:38',0,31,1110,84,6),(322,20,'2011-03-09 07:17:48',0,26,1112,84,6),(324,200,'2011-03-09 07:22:17',0,26,1114,84,6),(326,200,'2011-03-09 07:22:59',18,0,1116,84,6),(328,5000,'2011-03-09 08:23:47',18,0,1118,86,7),(330,5632,'2011-03-09 08:42:33',14,0,1120,88,14),(332,200,'2011-03-09 08:44:02',18,0,1122,108,6),(334,3640,'2011-03-09 08:44:12',18,0,1124,98,24),(336,78923,'2011-03-09 08:45:30',0,33,1128,88,14),(338,230,'2011-03-09 08:48:02',18,0,1138,94,18),(340,500,'2011-03-09 08:49:02',18,0,1142,100,26),(342,514,'2011-03-09 08:49:12',16,0,1144,108,6),(344,5325,'2011-03-09 08:49:37',0,26,1146,82,9),(346,600,'2011-03-09 08:52:50',18,0,1152,92,16),(348,14587,'2011-03-09 08:54:21',18,0,1160,112,14),(350,600,'2011-03-09 08:54:46',20,0,1162,96,22),(352,2020,'2011-03-09 08:55:11',0,33,1164,94,18),(354,1111,'2011-03-09 08:58:53',24,0,1166,94,18),(356,300,'2011-03-09 08:59:03',18,0,1168,114,14),(358,14587,'2011-03-09 08:59:18',18,0,1170,112,14),(360,4422,'2011-03-09 08:59:38',0,29,1174,94,18),(362,50,'2011-03-09 09:00:04',16,0,1178,110,5),(364,2000,'2011-03-09 09:00:14',18,0,1180,96,22),(366,30000,'2011-03-09 09:00:39',0,31,1182,98,24),(368,500,'2011-03-09 09:01:24',18,0,1184,106,30),(370,500,'2011-03-09 09:01:39',22,0,1186,110,5),(372,500,'2011-03-09 09:04:53',18,0,1188,106,30),(374,500,'2011-03-09 09:05:08',18,0,1190,92,16),(376,5000,'2011-03-09 09:05:53',22,0,1196,110,5),(378,7503,'2011-03-09 09:09:41',14,0,1200,82,9),(380,4500,'2011-03-09 09:09:51',0,26,1202,110,5),(382,165938,'2011-03-09 09:10:07',0,26,1204,90,14),(384,200,'2011-03-09 09:12:45',24,0,1208,118,20),(386,52,'2011-03-09 09:12:55',22,0,1210,116,34),(388,200,'2011-03-09 09:15:03',20,0,1212,120,20),(390,5800,'2011-03-09 09:20:15',18,0,1216,122,2),(392,1000,'2011-03-09 09:36:30',24,0,1218,112,14),(394,1256,'2011-03-09 10:04:03',0,31,1220,108,6),(396,2000,'2011-03-09 10:04:55',18,0,1222,122,2),(398,2000,'2011-03-09 10:05:05',14,0,1224,118,20),(400,23400,'2011-03-09 11:40:24',0,26,1230,94,18),(402,13000,'2011-03-09 11:41:03',24,0,1232,98,24),(404,4300,'2011-03-09 11:41:11',0,29,1234,98,24),(406,10000,'2011-03-09 11:59:18',18,0,1240,90,14),(408,8000,'2011-03-09 11:59:31',18,0,1242,108,6),(410,12000,'2011-03-09 12:00:11',22,0,1244,108,6),(412,24000,'2011-03-09 12:01:30',18,0,1246,116,34),(414,100,'2011-03-09 12:01:39',0,31,1248,108,6),(416,12000,'2011-03-09 12:01:52',18,0,1250,98,24),(418,6000,'2011-03-09 12:02:05',22,0,1252,90,14),(420,15500,'2011-03-09 12:02:30',22,0,1254,98,24),(422,8000,'2011-03-09 12:02:37',18,0,1256,94,18),(424,8000,'2011-03-09 12:04:57',18,0,1258,94,18),(426,6500,'2011-03-09 12:05:05',22,0,1260,116,34),(428,17500,'2011-03-09 12:05:18',18,0,1262,106,30),(430,100,'2011-03-09 12:05:40',0,31,1266,116,34),(432,20000,'2011-03-09 12:05:53',22,0,1268,94,18),(434,100,'2011-03-09 12:06:06',0,31,1270,98,24),(436,17000,'2011-03-09 12:06:14',22,0,1272,106,30),(438,100,'2011-03-09 12:06:42',0,31,1274,90,14),(440,100,'2011-03-09 12:06:51',18,0,1276,96,22),(442,100,'2011-03-09 12:07:04',0,28,1278,116,34),(444,1500,'2011-03-09 12:07:28',22,0,1280,90,14),(446,100,'2011-03-09 12:10:12',0,28,1282,106,30),(448,100,'2011-03-09 12:10:22',0,31,1284,94,18),(450,100,'2011-03-09 12:10:35',0,31,1286,106,30),(452,12000,'2011-03-09 12:11:09',18,0,1288,92,16),(454,100,'2011-03-09 12:11:27',0,28,1290,94,18),(456,15500,'2011-03-09 12:11:35',18,0,1292,104,28),(458,20000,'2011-03-09 12:11:43',18,0,1294,100,26),(460,12000,'2011-03-09 12:12:09',22,0,1298,92,16),(462,1500,'2011-03-09 12:12:45',0,31,1300,96,22),(464,17500,'2011-03-09 12:15:27',22,0,1302,100,26),(466,100,'2011-03-09 12:15:36',0,31,1304,104,28),(468,1500,'2011-03-09 12:15:50',22,0,1306,110,5),(470,100,'2011-03-09 12:15:59',0,28,1308,104,28),(472,100,'2011-03-09 12:16:26',0,31,1312,100,26),(474,100,'2011-03-11 11:18:36',0,31,1322,94,18),(476,100,'2011-03-11 11:18:50',0,28,1324,94,18),(478,8000,'2011-03-11 11:19:00',18,0,1326,94,18),(480,500,'2011-03-11 11:19:10',0,33,1328,82,9),(482,20000,'2011-03-11 11:43:53',22,0,1338,94,18),(484,100,'2011-03-11 11:44:03',0,28,1340,90,14),(486,1500,'2011-03-14 06:32:34',22,0,1346,110,5),(488,100,'2011-03-14 06:32:49',0,28,1348,110,5),(490,12000,'2011-03-14 06:32:59',18,0,1350,110,5),(492,100,'2011-03-14 06:33:09',0,31,1352,110,5),(494,1500,'2011-03-14 06:33:24',22,0,1354,110,5),(496,100,'2011-03-14 06:33:34',0,31,1356,98,24),(498,15500,'2011-03-14 06:33:44',22,0,1358,98,24),(500,12000,'2011-03-14 06:33:59',18,0,1360,98,24),(502,100,'2011-03-14 06:34:09',0,29,1362,98,24),(504,16000,'2011-03-14 13:50:45',18,0,1364,100,26),(506,14000,'2011-03-14 13:55:25',22,0,1366,100,26),(508,105,'2011-03-14 13:58:31',0,31,1368,100,26),(510,120,'2011-03-14 14:01:17',0,28,1370,100,26),(512,100,'2011-03-17 05:46:52',0,28,1376,110,5),(514,9600,'2011-03-17 05:50:49',18,0,1378,110,5),(516,114,'2011-03-17 05:52:43',0,31,1380,110,5),(518,1200,'2011-03-17 05:55:25',22,0,1382,110,5),(520,165,'2011-03-17 05:58:06',0,28,1384,110,5),(522,8000,'2011-03-18 09:32:50',18,0,1386,90,14),(524,1200,'2011-03-18 09:33:42',22,0,1388,90,14),(526,110,'2011-03-21 08:25:01',0,31,1392,96,22),(528,155,'2011-03-21 11:50:45',0,28,1394,108,6),(530,9600,'2011-03-22 21:35:40',18,0,1402,92,16),(532,9600,'2011-03-22 22:54:29',18,0,1404,92,16),(534,500,'2011-03-23 13:06:36',18,0,1406,44,7),(536,9600,'2011-03-23 13:40:04',18,0,1416,98,24),(538,12400,'2011-03-23 13:40:19',22,0,1418,98,24),(540,130,'2011-03-23 13:40:29',0,31,1420,98,24),(542,190,'2011-03-23 13:40:39',0,28,1422,98,24),(544,6400,'2011-03-23 18:53:41',18,0,1462,94,18),(546,16000,'2011-03-23 18:56:45',22,0,1464,94,18),(548,120,'2011-03-23 18:58:03',0,31,1466,94,18),(550,9600,'2011-03-24 07:27:19',18,0,1472,110,5),(552,7680,'2011-03-24 07:30:47',18,0,1474,110,5),(554,130,'2011-03-24 07:34:25',0,31,1476,110,5),(556,960,'2011-03-24 07:37:14',22,0,1478,110,5),(558,7680,'2011-03-24 15:19:28',18,0,1480,98,24),(560,9920,'2011-03-24 15:20:19',22,0,1482,98,24),(562,169,'2011-03-24 15:21:01',0,31,1484,98,24),(564,361,'2011-03-24 15:25:30',0,28,1486,98,24),(566,5120,'2011-03-25 06:33:55',18,0,1488,94,18),(568,144,'2011-03-25 06:34:55',0,31,1490,94,18),(570,12800,'2011-03-25 06:35:05',22,0,1492,94,18),(572,144,'2011-03-25 06:35:15',0,28,1494,94,18),(574,121,'2011-03-25 06:35:31',0,31,1496,96,22),(576,960,'2011-03-25 06:35:41',18,0,1498,96,22),(578,11200,'2011-03-25 06:35:51',22,0,1500,96,22),(580,12800,'2011-03-25 07:25:22',18,0,1502,100,26),(582,11200,'2011-03-25 07:27:42',22,0,1504,100,26),(584,110,'2011-03-25 07:29:36',0,31,1506,100,26),(586,144,'2011-03-25 07:31:52',0,28,1508,100,26),(588,15360,'2011-03-25 13:37:18',18,0,1510,116,34),(590,4160,'2011-03-25 13:38:32',22,0,1512,116,34),(592,6400,'2011-03-25 13:39:29',18,0,1514,122,2),(594,130,'2011-03-25 13:41:23',0,31,1516,116,34),(596,306,'2011-03-25 13:42:12',0,28,1518,116,34),(598,116,'2011-03-25 13:43:04',0,31,1520,100,26),(600,3840,'2011-03-25 13:43:24',22,0,1522,122,2),(602,173,'2011-03-25 13:44:44',0,28,1524,100,26),(604,10240,'2011-03-25 13:47:03',18,0,1526,100,26),(606,8960,'2011-03-25 13:49:20',22,0,1530,100,26),(608,132,'2011-03-25 13:50:15',0,31,1532,122,2),(610,306,'2011-03-25 13:53:11',0,28,1534,122,2),(612,11200,'2011-03-28 10:55:43',18,0,1536,106,30),(614,10880,'2011-03-28 10:55:53',22,0,1538,106,30),(616,123,'2011-03-28 10:57:10',0,31,1540,106,30),(618,180,'2011-03-28 12:56:52',0,28,1542,106,30),(620,4096,'2011-04-01 11:04:38',18,0,1580,94,18),(622,173,'2011-04-01 11:04:52',0,31,1582,94,18),(624,173,'2011-04-01 11:05:03',0,28,1584,94,18),(626,8960,'2011-04-01 11:05:13',18,0,1586,106,30),(628,8704,'2011-04-01 11:05:28',22,0,1588,106,30),(630,137,'2011-04-01 11:05:38',0,31,1590,106,30),(632,241,'2011-04-01 11:05:48',0,28,1592,106,30),(634,272,'2011-04-01 11:06:03',0,28,1594,110,5),(636,272,'2011-04-01 11:06:13',0,28,1596,110,5),(638,89600,'2011-04-01 11:06:23',22,0,1598,96,22),(640,6144,'2011-04-01 11:13:44',18,0,1600,110,5),(642,148,'2011-04-01 11:21:20',0,31,1604,110,5),(644,768,'2011-04-01 11:23:15',22,0,1606,110,5),(646,449,'2011-04-01 11:25:11',0,28,1608,110,5),(648,7680,'2011-04-01 13:53:25',18,0,1610,92,16),(650,7680,'2011-04-01 13:54:27',22,0,1612,92,16),(652,6144,'2011-04-01 13:56:29',18,0,1614,92,16),(654,6144,'2011-04-01 13:57:19',22,0,1616,92,16),(656,20000,'2011-04-02 11:15:02',18,0,1620,120,20),(658,19500,'2011-04-02 11:18:37',20,0,1622,120,20),(660,23000,'2011-04-02 11:20:10',22,0,1624,120,20),(662,13000,'2011-04-02 11:24:03',14,0,1626,120,20),(664,22000,'2011-04-02 11:24:55',16,0,1628,120,20),(666,220,'2011-04-04 11:04:35',0,31,1630,98,24),(668,6144,'2011-04-04 11:23:46',18,0,1634,98,24),(670,7936,'2011-04-04 11:25:04',22,0,1636,98,24),(672,4915,'2011-04-04 13:26:09',18,0,1638,110,5),(674,169,'2011-04-04 13:29:28',0,31,1640,110,5),(676,614,'2011-04-04 13:32:13',22,0,1642,110,5),(678,741,'2011-04-04 13:33:47',0,28,1644,110,5),(680,8192,'2011-04-06 06:47:28',18,0,1654,100,26),(682,7168,'2011-04-06 06:51:07',22,0,1656,100,26),(684,207,'2011-04-06 06:56:17',0,28,1658,100,26),(686,249,'2011-04-06 14:26:50',0,28,1660,100,26),(688,128,'2011-04-06 14:28:46',0,31,1662,100,26),(690,6554,'2011-04-06 14:30:51',18,0,1664,100,26),(692,5734,'2011-04-06 14:33:11',22,0,1666,100,26),(694,614,'2011-04-11 11:04:33',18,0,1668,96,22),(696,7168,'2011-04-11 11:04:48',22,0,1670,96,22),(698,146,'2011-04-11 11:04:58',0,31,1672,96,22),(700,7168,'2011-04-11 11:05:08',18,0,1674,106,30),(702,6963,'2011-04-11 11:05:23',22,0,1676,106,30),(704,152,'2011-04-11 11:05:34',0,31,1678,106,30),(706,322,'2011-04-11 11:05:44',0,28,1680,106,30),(708,3932,'2011-04-11 11:05:59',18,0,1682,110,5),(710,193,'2011-04-11 11:06:09',0,31,1684,110,5),(712,1303,'2011-04-11 11:06:19',0,28,1686,98,24),(714,492,'2011-04-11 12:40:00',22,0,1688,110,5),(716,1223,'2011-04-11 12:42:00',0,28,1690,110,5),(718,3146,'2011-04-11 12:44:52',18,0,1692,110,5),(720,219,'2011-04-11 12:47:34',0,31,1694,110,5),(722,393,'2011-04-11 12:49:21',22,0,1696,110,5),(724,2018,'2011-04-11 12:52:03',0,28,1698,110,5),(726,2517,'2011-04-11 12:57:35',18,0,1700,110,5),(728,250,'2011-04-11 12:59:30',0,31,1702,110,5),(730,315,'2011-04-11 13:00:49',22,0,1704,110,5),(732,3330,'2011-04-11 13:02:45',0,28,1706,110,5),(734,4915,'2011-04-11 20:52:21',18,0,1762,92,16),(736,4915,'2011-04-11 21:31:53',22,0,1772,92,16),(738,3932,'2011-04-11 21:32:11',18,0,1774,92,16),(740,3932,'2011-04-11 21:32:24',22,0,1776,92,16),(742,3277,'2011-04-12 04:57:42',18,0,1778,94,18),(744,8192,'2011-04-12 04:59:11',22,0,1780,94,18),(746,207,'2011-04-12 05:01:06',0,31,1782,94,18),(748,207,'2011-04-12 05:02:10',0,28,1784,94,18),(750,20000,'2011-04-12 07:26:16',22,0,1786,120,20),(752,17000,'2011-04-12 07:27:05',18,0,1788,120,20),(754,17200,'2011-04-12 07:28:20',20,0,1790,120,20),(756,11000,'2011-04-12 07:28:40',14,0,1792,120,20),(758,20000,'2011-04-12 07:29:44',16,0,1794,120,20),(760,20000,'2011-04-12 07:38:58',22,0,1796,120,20),(762,17000,'2011-04-12 07:41:18',18,0,1798,120,20),(764,17200,'2011-04-12 07:42:47',20,0,1800,120,20),(766,11000,'2011-04-12 07:43:39',14,0,1802,120,20),(768,20000,'2011-04-12 07:44:57',16,0,1804,120,20),(770,2458,'2011-04-12 11:16:15',18,0,1806,118,20),(772,6400,'2011-04-12 16:48:00',18,0,1820,108,6),(774,9600,'2011-04-12 16:48:42',22,0,1822,108,6),(776,110,'2011-04-12 16:49:45',0,31,1824,108,6),(778,125,'2011-04-12 16:49:55',0,28,1826,108,6),(780,5120,'2011-04-12 16:52:26',18,0,1828,108,6),(782,7680,'2011-04-12 16:53:55',22,0,1830,108,6),(784,121,'2011-04-12 16:54:48',0,31,1832,108,6),(786,240,'2011-04-12 16:56:02',0,28,1834,108,6),(788,161,'2011-04-12 20:50:02',0,31,1836,92,16),(790,2820,'2011-04-12 20:51:30',0,28,1838,92,16),(792,169,'2011-04-13 11:04:34',0,31,1840,90,14),(794,322,'2011-04-13 11:04:49',0,28,1842,90,14),(796,4096,'2011-04-13 11:04:59',18,0,1844,90,14),(798,614,'2011-04-13 11:05:09',22,0,1846,90,14),(800,3670,'2011-04-14 08:09:23',22,0,1852,100,26),(802,4194,'2011-04-14 08:12:30',18,0,1854,100,26),(804,141,'2011-04-14 08:14:51',0,31,1856,100,26),(806,358,'2011-04-14 08:16:20',0,28,1858,100,26),(808,492,'2011-04-15 08:06:14',18,0,1860,96,22),(810,5734,'2011-04-15 08:07:17',22,0,1862,96,22),(812,161,'2011-04-15 08:07:59',0,31,1864,96,22),(814,193,'2011-04-15 08:58:39',0,31,1866,90,14),(816,432,'2011-04-15 08:59:47',0,28,1868,90,14),(818,3277,'2011-04-15 09:01:17',18,0,1870,90,14),(820,492,'2011-04-15 09:01:58',22,0,1872,90,14),(822,169,'2011-04-15 16:58:10',0,31,1922,106,30),(824,432,'2011-04-15 16:59:27',0,28,1924,106,30),(826,5734,'2011-04-15 17:00:31',18,0,1926,106,30),(828,5571,'2011-04-15 17:01:40',22,0,1928,106,30),(830,4096,'2011-04-18 11:04:41',18,0,1930,108,6),(832,6144,'2011-04-18 11:04:56',22,0,1932,108,6),(834,133,'2011-04-18 11:05:06',0,31,1934,108,6),(836,372,'2011-04-18 11:05:16',0,28,1936,108,6),(838,3277,'2011-04-18 11:05:42',18,0,1940,108,6),(840,4915,'2011-04-18 11:05:52',22,0,1942,108,6),(842,146,'2011-04-18 11:06:07',0,31,1944,108,6),(844,577,'2011-04-18 11:06:17',0,28,1946,108,6),(846,2621,'2011-04-18 11:06:27',18,0,1948,108,6),(848,2621,'2011-04-19 03:33:56',18,0,1950,94,18),(850,6554,'2011-04-19 03:35:25',22,0,1952,94,18),(852,249,'2011-04-19 03:36:50',0,31,1954,94,18),(854,249,'2011-04-19 03:38:08',0,28,1956,94,18),(856,371,'2011-04-19 06:51:57',0,31,1958,98,24),(858,2476,'2011-04-19 06:53:41',0,28,1960,98,24),(860,3932,'2011-04-19 06:55:43',18,0,1962,98,24),(862,5079,'2011-04-19 06:58:35',22,0,1964,98,24),(864,3146,'2011-04-26 23:04:37',18,0,1970,98,24),(866,4063,'2011-04-26 23:04:52',22,0,1972,98,24),(868,483,'2011-04-26 23:05:02',0,31,1974,98,24),(870,4705,'2011-04-27 11:04:32',0,28,1978,98,24),(872,219,'2011-04-28 15:32:46',0,31,2020,90,14),(874,177,'2011-04-28 15:33:11',0,31,2022,96,22),(876,579,'2011-04-28 15:33:21',0,28,2024,90,14),(878,4588,'2011-04-28 15:33:31',22,0,2026,96,22),(880,4588,'2011-04-28 15:33:46',22,0,2028,96,22),(882,393,'2011-04-28 15:33:56',18,0,2030,96,22),(884,2621,'2011-04-28 15:34:06',18,0,2032,90,14),(886,393,'2011-04-28 16:21:55',22,0,2060,90,14),(888,1678,'2011-04-29 11:04:35',18,0,2070,94,18),(890,4194,'2011-04-29 11:04:50',22,0,2072,94,18),(892,358,'2011-04-29 11:05:00',0,31,2074,94,18),(894,358,'2011-04-29 11:05:10',0,28,2076,94,18),(896,315,'2011-04-29 11:05:25',18,0,2078,96,22),(898,3670,'2011-04-29 11:05:36',22,0,2080,96,22),(900,195,'2011-04-29 11:05:46',0,31,2082,96,22),(902,2517,'2011-04-29 11:06:00',18,0,2084,110,5),(904,250,'2011-04-29 11:06:11',0,31,2086,110,5),(906,315,'2011-04-29 11:06:21',22,0,2088,110,5),(908,3670,'2011-04-29 12:43:54',18,0,2090,106,30),(910,3565,'2011-04-29 12:45:06',22,0,2092,106,30),(912,208,'2011-04-29 12:45:57',0,31,2094,106,30),(914,776,'2011-04-29 12:46:44',0,28,2096,106,30),(916,315,'2011-04-29 14:29:08',22,0,2098,90,14),(918,250,'2011-04-29 14:29:34',0,31,2100,90,14),(920,776,'2011-04-29 14:29:44',0,28,2102,90,14),(922,2517,'2011-05-11 12:45:46',18,0,2106,98,24),(924,3251,'2011-05-11 12:46:01',22,0,2108,98,24),(926,627,'2011-05-11 12:46:11',0,31,2110,98,24),(928,8939,'2011-05-11 12:46:21',0,28,2112,98,24);
/*!40000 ALTER TABLE `stats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `treatment_reports`
--

DROP TABLE IF EXISTS `treatment_reports`;
/*!50001 DROP VIEW IF EXISTS `treatment_reports`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `treatment_reports` (
  `quantity` int(5),
  `timestamp` datetime,
  `treatment_description` varchar(256),
  `treatment_code` varchar(4),
  `phone` varchar(13),
  `location_name` varchar(70),
  `latitude` varchar(13),
  `longitude` varchar(13)
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `treatment_status`
--

DROP TABLE IF EXISTS `treatment_status`;
/*!50001 DROP VIEW IF EXISTS `treatment_status`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `treatment_status` (
  `timestamp` datetime,
  `treatment_code` varchar(4),
  `location_name` varchar(70),
  `quantity` int(5)
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `treatments`
--

DROP TABLE IF EXISTS `treatments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `treatments` (
  `id` int(11) NOT NULL auto_increment,
  `code` varchar(4) NOT NULL,
  `units` int(2) NOT NULL,
  `description` varchar(256) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `treatments`
--

LOCK TABLES `treatments` WRITE;
/*!40000 ALTER TABLE `treatments` DISABLE KEYS */;
INSERT INTO `treatments` VALUES (26,'LFIL',0,'Lymphatic Filariasis. Treated with Ivermectin +Albendazole'),(28,'ONCH',0,'Onchocerciasis. Treated with Ivermectin'),(29,'SCHT',0,'Schistosomiasis. Treated with Praziquantel'),(31,'STHS',0,'Intestinal worms. Treated with Albendazole or Mebendazole'),(33,'TRAC',0,'Trachoma. Treated with Zithromax');
/*!40000 ALTER TABLE `treatments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `updates`
--

DROP TABLE IF EXISTS `updates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `updates` (
  `id` int(12) NOT NULL auto_increment,
  `last_processed_id` int(12) default NULL,
  `created` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `updates`
--

LOCK TABLES `updates` WRITE;
/*!40000 ALTER TABLE `updates` DISABLE KEYS */;
INSERT INTO `updates` VALUES (18,0,'2010-11-24 11:35:50'),(20,104,'2010-12-06 22:13:01'),(22,116,'2010-12-06 22:17:06'),(24,124,'2010-12-06 22:20:04'),(26,126,'2010-12-06 22:55:01'),(28,128,'2011-02-15 15:05:01');
/*!40000 ALTER TABLE `updates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(255) NOT NULL,
  `password` char(40) NOT NULL,
  `group_id` int(11) NOT NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `location_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','8db57f058f3daac554698a07b8eaf8df1e1d319b',8,'2010-08-29 23:11:29','2011-08-06 09:19:02',2),(2,'moderator','972b31ee3bed7b8b8f965bbc967dcc4a4d8b67b5',9,'2010-08-29 23:11:44','2011-08-06 09:20:30',20),(3,'user','6a694882e95141fab40d4170356884698ceb88b6',10,'2010-08-29 23:11:57','2011-08-06 09:17:36',24);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `drug_reports`
--

/*!50001 DROP TABLE IF EXISTS `drug_reports`*/;
/*!50001 DROP VIEW IF EXISTS `drug_reports`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `drug_reports` AS select `stats`.`quantity` AS `quantity`,`stats`.`created` AS `timestamp`,`drugs`.`name` AS `drug_name`,`phones`.`phonenumber` AS `phone`,`locations`.`name` AS `location_name`,`locations`.`locationLatitude` AS `latitude`,`locations`.`locationLongitude` AS `longitude` from (((`stats` join `phones` on((`stats`.`phone_id` = `phones`.`id`))) join `locations` on((`stats`.`location_id` = `locations`.`id`))) join `drugs` on((`stats`.`drug_id` = `drugs`.`id`))) order by `stats`.`created` desc */;

--
-- Final view structure for view `drug_status`
--

/*!50001 DROP TABLE IF EXISTS `drug_status`*/;
/*!50001 DROP VIEW IF EXISTS `drug_status`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `drug_status` AS select `d1`.`timestamp` AS `timestamp`,`d1`.`drug_name` AS `drug_name`,`d1`.`location_name` AS `location_name`,`d1`.`quantity` AS `quantity` from `drug_reports` `d1` where (`d1`.`timestamp` = (select max(`d2`.`timestamp`) AS `MAX(``d2``.``timestamp``)` from `drug_reports` `d2` where ((`d1`.`drug_name` = `d2`.`drug_name`) and (`d1`.`location_name` = `d2`.`location_name`)))) */;

--
-- Final view structure for view `treatment_reports`
--

/*!50001 DROP TABLE IF EXISTS `treatment_reports`*/;
/*!50001 DROP VIEW IF EXISTS `treatment_reports`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `treatment_reports` AS select `stats`.`quantity` AS `quantity`,`stats`.`created` AS `timestamp`,`treatments`.`description` AS `treatment_description`,`treatments`.`code` AS `treatment_code`,`phones`.`phonenumber` AS `phone`,`locations`.`name` AS `location_name`,`locations`.`locationLatitude` AS `latitude`,`locations`.`locationLongitude` AS `longitude` from (((`stats` join `phones` on((`stats`.`phone_id` = `phones`.`id`))) join `locations` on((`stats`.`location_id` = `locations`.`id`))) join `treatments` on((`stats`.`treatment_id` = `treatments`.`id`))) order by `stats`.`created` desc */;

--
-- Final view structure for view `treatment_status`
--

/*!50001 DROP TABLE IF EXISTS `treatment_status`*/;
/*!50001 DROP VIEW IF EXISTS `treatment_status`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `treatment_status` AS select `t1`.`timestamp` AS `timestamp`,`t1`.`treatment_code` AS `treatment_code`,`t1`.`location_name` AS `location_name`,`t1`.`quantity` AS `quantity` from `treatment_reports` `t1` where (`t1`.`timestamp` = (select max(`t2`.`timestamp`) AS `MAX(``t2``.``timestamp``)` from `treatment_reports` `t2` where ((`t1`.`treatment_code` = `t2`.`treatment_code`) and (`t1`.`location_name` = `t2`.`location_name`)))) */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-08-06 11:40:09
