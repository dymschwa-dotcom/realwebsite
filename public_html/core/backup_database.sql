/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.6.25-MariaDB, for debian-linux-gnu (aarch64)
--
-- Host: localhost    Database: my_database
-- ------------------------------------------------------
-- Server version	10.6.25-MariaDB-ubu2204

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `activities`
--

DROP TABLE IF EXISTS `activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `activities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT 0,
  `influencer_id` int(10) unsigned NOT NULL DEFAULT 0,
  `title` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=192 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activities`
--

LOCK TABLES `activities` WRITE;
/*!40000 ALTER TABLE `activities` DISABLE KEYS */;
INSERT INTO `activities` VALUES (1,0,1,'Registration process completed successfully','2026-02-19 02:16:57','2026-02-19 02:16:57'),(2,0,4,'Registration process completed successfully','2026-02-19 04:04:14','2026-02-19 04:04:14'),(3,0,5,'Registration process completed successfully','2026-02-19 04:23:58','2026-02-19 04:23:58'),(4,0,5,'Profile updated successfully','2026-02-19 04:47:07','2026-02-19 04:47:07'),(5,0,5,'Profile updated successfully','2026-02-19 04:47:22','2026-02-19 04:47:22'),(6,0,5,'Profile updated successfully','2026-02-19 04:57:21','2026-02-19 04:57:21'),(7,0,5,'Profile updated successfully','2026-02-19 04:59:11','2026-02-19 04:59:11'),(8,1,0,'Registration process completed successfully','2026-02-19 05:17:02','2026-02-19 05:17:02'),(9,1,0,'Campaign request is pending','2026-02-19 07:49:30','2026-02-19 07:49:30'),(10,1,0,'Campaign request is pending','2026-02-19 07:51:00','2026-02-19 07:51:00'),(11,0,5,'Profile updated successfully','2026-02-19 07:57:47','2026-02-19 07:57:47'),(12,1,0,'Campaign request is pending','2026-02-19 08:02:51','2026-02-19 08:02:51'),(13,0,5,'Profile updated successfully','2026-02-19 08:09:17','2026-02-19 08:09:17'),(14,1,0,'Campaign request is pending','2026-02-19 08:18:26','2026-02-19 08:18:26'),(15,1,0,'Sent invite request for campaign','2026-02-19 08:19:15','2026-02-19 08:19:15'),(16,1,0,'New participate request added your campaign','2026-02-19 08:31:24','2026-02-19 08:31:24'),(17,0,5,'Participate request sent successfully','2026-02-19 08:31:24','2026-02-19 08:31:24'),(18,1,0,'You have accepted the dsfdasfdsf participation request','2026-02-19 08:32:19','2026-02-19 08:32:19'),(19,0,5,'kjhhfdsfdsf has accepted your participant request','2026-02-19 08:32:19','2026-02-19 08:32:19'),(20,1,0,'Influencer delivered your campaign job','2026-02-19 08:37:21','2026-02-19 08:37:21'),(21,0,5,'You have delivered the campaign job','2026-02-19 08:37:21','2026-02-19 08:37:21'),(22,1,0,'You have decided your campaign job is completed','2026-02-19 08:38:15','2026-02-19 08:38:15'),(23,0,5,'kjhhfdsfdsf has decided campaign job is completed','2026-02-19 08:38:15','2026-02-19 08:38:15'),(24,1,0,'You purchased service fdgsg from dsfdasfdsf','2026-02-19 08:58:53','2026-02-19 08:58:53'),(25,0,5,'kjhhfdsfdsf purchased your service fdgsg','2026-02-19 08:58:53','2026-02-19 08:58:53'),(26,1,0,'Started a conversation with dsfdasfdsf','2026-02-19 09:17:19','2026-02-19 09:17:19'),(27,0,6,'Registration process completed successfully','2026-02-19 10:15:04','2026-02-19 10:15:04'),(28,1,0,'Started a conversation with dsafdsf','2026-02-19 10:15:35','2026-02-19 10:15:35'),(29,1,0,'You purchased service sdaf from dsafdsf','2026-02-19 10:49:58','2026-02-19 10:49:58'),(30,0,6,'kjhhfdsfdsf purchased your service sdaf','2026-02-19 10:49:58','2026-02-19 10:49:58'),(31,2,0,'Registration process completed successfully','2026-02-19 18:36:30','2026-02-19 18:36:30'),(32,2,0,'Started a conversation with dsafdsf','2026-02-19 18:37:11','2026-02-19 18:37:11'),(33,2,0,'Started a conversation with dsfdasfdsf','2026-02-19 18:58:25','2026-02-19 18:58:25'),(34,0,5,'Sent a custom proposal to vdfaafafvadf','2026-02-19 19:52:27','2026-02-19 19:52:27'),(35,0,5,'Sent a custom proposal to vdfaafafvadf','2026-02-19 20:17:46','2026-02-19 20:17:46'),(36,3,0,'Registration process completed successfully','2026-02-19 21:41:17','2026-02-19 21:41:17'),(37,0,7,'Registration process completed successfully','2026-02-19 21:44:01','2026-02-19 21:44:01'),(38,3,0,'You purchased service Basic Shotout from influencerexample','2026-02-19 21:47:16','2026-02-19 21:47:16'),(39,0,7,'examplebrand purchased your service Basic Shotout','2026-02-19 21:47:16','2026-02-19 21:47:16'),(40,0,7,'Sent a custom proposal to examplebrand','2026-02-19 22:19:43','2026-02-19 22:19:43'),(41,0,7,'Sent a custom proposal to examplebrand','2026-02-19 22:21:24','2026-02-19 22:21:24'),(42,3,0,'Influencer delivered your campaign job','2026-02-19 22:44:17','2026-02-19 22:44:17'),(43,0,7,'You have delivered the campaign job','2026-02-19 22:44:17','2026-02-19 22:44:17'),(44,3,0,'You have decided your campaign job is completed','2026-02-19 22:44:35','2026-02-19 22:44:35'),(45,0,7,'examplebrand has decided campaign job is completed','2026-02-19 22:44:35','2026-02-19 22:44:35'),(46,3,0,'Campaign request is pending','2026-02-19 23:38:18','2026-02-19 23:38:18'),(47,3,0,'Campaign request is pending','2026-02-19 23:48:30','2026-02-19 23:48:30'),(48,0,7,'Profile updated successfully','2026-02-20 01:08:21','2026-02-20 01:08:21'),(49,0,7,'Profile updated successfully','2026-02-20 01:08:27','2026-02-20 01:08:27'),(50,3,0,'You purchased service Basic Shotout from influencerexample','2026-02-20 01:10:05','2026-02-20 01:10:05'),(51,0,7,'examplebrand purchased your service Basic Shotout','2026-02-20 01:10:05','2026-02-20 01:10:05'),(52,0,7,'Profile updated successfully','2026-02-20 01:12:41','2026-02-20 01:12:41'),(53,3,0,'New participate request added your campaign','2026-02-20 01:18:23','2026-02-20 01:18:23'),(54,0,7,'Participate request sent successfully','2026-02-20 01:18:23','2026-02-20 01:18:23'),(55,3,0,'You have accepted the influencerexample participation request','2026-02-20 01:19:39','2026-02-20 01:19:39'),(56,0,7,'examplebrand has accepted your participant request','2026-02-20 01:19:39','2026-02-20 01:19:39'),(57,3,0,'Review added successfully','2026-02-20 01:21:25','2026-02-20 01:21:25'),(58,0,7,'examplebrand has reviewed for your campaign job','2026-02-20 01:21:25','2026-02-20 01:21:25'),(59,3,0,'You purchased service Basic Reel from influencerexample','2026-02-20 01:44:31','2026-02-20 01:44:31'),(60,0,7,'examplebrand purchased your service Basic Reel','2026-02-20 01:44:31','2026-02-20 01:44:31'),(61,0,7,'Sent a custom proposal to examplebrand','2026-02-20 01:49:07','2026-02-20 01:49:07'),(62,3,0,'Influencer delivered your campaign job','2026-02-20 01:50:43','2026-02-20 01:50:43'),(63,0,7,'You have delivered the campaign job','2026-02-20 01:50:43','2026-02-20 01:50:43'),(64,3,0,'Campaign request is pending','2026-02-20 01:53:30','2026-02-20 01:53:30'),(65,3,0,'New participate request added your campaign','2026-02-20 01:54:33','2026-02-20 01:54:33'),(66,0,7,'Participate request sent successfully','2026-02-20 01:54:33','2026-02-20 01:54:33'),(67,3,0,'Review added successfully','2026-02-20 01:56:25','2026-02-20 01:56:25'),(68,0,7,'examplebrand has reviewed for your campaign job','2026-02-20 01:56:25','2026-02-20 01:56:25'),(69,3,0,'You have accepted the influencerexample participation request','2026-02-20 02:12:21','2026-02-20 02:12:21'),(70,0,7,'examplebrand has accepted your participant request','2026-02-20 02:12:21','2026-02-20 02:12:21'),(71,0,6,'Profile updated successfully','2026-02-20 02:21:52','2026-02-20 02:21:52'),(72,0,5,'Profile updated successfully','2026-02-20 02:22:12','2026-02-20 02:22:12'),(73,0,5,'Profile updated successfully','2026-02-20 02:49:08','2026-02-20 02:49:08'),(74,0,5,'Profile updated successfully','2026-02-20 02:52:18','2026-02-20 02:52:18'),(75,0,6,'Profile updated successfully','2026-02-20 02:53:14','2026-02-20 02:53:14'),(76,0,7,'Profile updated successfully','2026-02-20 02:53:43','2026-02-20 02:53:43'),(77,0,8,'Registration process completed successfully','2026-02-20 03:04:32','2026-02-20 03:04:32'),(78,0,8,'Profile updated successfully','2026-02-20 03:11:51','2026-02-20 03:11:51'),(79,0,7,'Profile updated successfully','2026-02-20 04:42:04','2026-02-20 04:42:04'),(80,3,0,'Influencer delivered your campaign job','2026-02-20 09:18:42','2026-02-20 09:18:42'),(81,0,7,'You have delivered the campaign job','2026-02-20 09:18:42','2026-02-20 09:18:42'),(82,3,0,'You have decided your campaign job is completed','2026-02-20 10:28:27','2026-02-20 10:28:27'),(83,0,7,'examplebrand has decided campaign job is completed','2026-02-20 10:28:27','2026-02-20 10:28:27'),(84,3,0,'Review added successfully','2026-02-20 10:46:05','2026-02-20 10:46:05'),(85,0,7,'examplebrand has reviewed for your campaign job','2026-02-20 10:46:05','2026-02-20 10:46:05'),(86,0,7,'Sent a custom proposal to examplebrand','2026-02-20 11:50:04','2026-02-20 11:50:04'),(87,3,0,'Influencer delivered your campaign job','2026-02-20 11:50:12','2026-02-20 11:50:12'),(88,0,7,'You have delivered the campaign job','2026-02-20 11:50:12','2026-02-20 11:50:12'),(89,0,7,'Profile updated successfully','2026-02-20 21:40:59','2026-02-20 21:40:59'),(90,0,7,'Profile updated successfully','2026-02-20 21:55:39','2026-02-20 21:55:39'),(91,0,7,'Profile updated successfully','2026-02-20 21:59:59','2026-02-20 21:59:59'),(92,0,7,'Profile updated successfully','2026-02-20 22:04:57','2026-02-20 22:04:57'),(93,0,7,'Profile updated successfully','2026-02-20 22:05:09','2026-02-20 22:05:09'),(94,0,7,'Profile updated successfully','2026-02-20 22:37:24','2026-02-20 22:37:24'),(95,0,7,'Profile updated successfully','2026-02-20 22:43:23','2026-02-20 22:43:23'),(96,0,7,'Profile updated successfully','2026-02-20 22:46:51','2026-02-20 22:46:51'),(97,0,7,'Profile updated successfully','2026-02-20 22:51:59','2026-02-20 22:51:59'),(98,3,0,'influencerexample is added in your favorite list','2026-02-20 23:55:50','2026-02-20 23:55:50'),(99,3,0,'Started a conversation with influencerexample','2026-02-20 23:56:32','2026-02-20 23:56:32'),(100,3,0,'Influencer delivered your campaign job','2026-02-21 00:05:37','2026-02-21 00:05:37'),(101,0,7,'You have delivered the campaign job','2026-02-21 00:05:37','2026-02-21 00:05:37'),(102,3,0,'Influencer delivered your campaign job','2026-02-21 00:05:43','2026-02-21 00:05:43'),(103,0,7,'You have delivered the campaign job','2026-02-21 00:05:43','2026-02-21 00:05:43'),(104,3,0,'Influencer delivered your campaign job','2026-02-21 00:05:48','2026-02-21 00:05:48'),(105,0,7,'You have delivered the campaign job','2026-02-21 00:05:48','2026-02-21 00:05:48'),(106,3,0,'Influencer delivered your campaign job','2026-02-21 00:05:54','2026-02-21 00:05:54'),(107,0,7,'You have delivered the campaign job','2026-02-21 00:05:54','2026-02-21 00:05:54'),(108,3,0,'Influencer delivered your campaign job','2026-02-21 00:05:59','2026-02-21 00:05:59'),(109,0,7,'You have delivered the campaign job','2026-02-21 00:05:59','2026-02-21 00:05:59'),(110,3,0,'You have decided your campaign job is completed','2026-02-21 00:06:16','2026-02-21 00:06:16'),(111,0,7,'examplebrand has decided campaign job is completed','2026-02-21 00:06:16','2026-02-21 00:06:16'),(112,3,0,'Review added successfully','2026-02-21 00:06:24','2026-02-21 00:06:24'),(113,0,7,'examplebrand has reviewed for your campaign job','2026-02-21 00:06:24','2026-02-21 00:06:24'),(114,3,0,'You have decided your campaign job is completed','2026-02-21 00:06:43','2026-02-21 00:06:43'),(115,0,7,'examplebrand has decided campaign job is completed','2026-02-21 00:06:43','2026-02-21 00:06:43'),(116,3,0,'Review added successfully','2026-02-21 00:06:51','2026-02-21 00:06:51'),(117,0,7,'examplebrand has reviewed for your campaign job','2026-02-21 00:06:51','2026-02-21 00:06:51'),(118,3,0,'You have decided your campaign job is completed','2026-02-21 00:07:04','2026-02-21 00:07:04'),(119,0,7,'examplebrand has decided campaign job is completed','2026-02-21 00:07:04','2026-02-21 00:07:04'),(120,3,0,'Review added successfully','2026-02-21 00:07:11','2026-02-21 00:07:11'),(121,0,7,'examplebrand has reviewed for your campaign job','2026-02-21 00:07:11','2026-02-21 00:07:11'),(122,3,0,'You have decided your campaign job is completed','2026-02-21 00:07:21','2026-02-21 00:07:21'),(123,0,7,'examplebrand has decided campaign job is completed','2026-02-21 00:07:21','2026-02-21 00:07:21'),(124,3,0,'Review added successfully','2026-02-21 00:07:30','2026-02-21 00:07:30'),(125,0,7,'examplebrand has reviewed for your campaign job','2026-02-21 00:07:30','2026-02-21 00:07:30'),(126,3,0,'You have decided your campaign job is completed','2026-02-21 00:07:51','2026-02-21 00:07:51'),(127,0,7,'examplebrand has decided campaign job is completed','2026-02-21 00:07:51','2026-02-21 00:07:51'),(128,3,0,'Review added successfully','2026-02-21 00:09:06','2026-02-21 00:09:06'),(129,0,7,'examplebrand has reviewed for your campaign job','2026-02-21 00:09:06','2026-02-21 00:09:06'),(130,3,0,'You have decided your campaign job is completed','2026-02-21 00:09:12','2026-02-21 00:09:12'),(131,0,7,'examplebrand has decided campaign job is completed','2026-02-21 00:09:12','2026-02-21 00:09:12'),(132,3,0,'Review added successfully','2026-02-21 00:09:19','2026-02-21 00:09:19'),(133,0,7,'examplebrand has reviewed for your campaign job','2026-02-21 00:09:19','2026-02-21 00:09:19'),(134,0,7,'Profile updated successfully','2026-02-21 03:35:48','2026-02-21 03:35:48'),(135,0,7,'Profile updated successfully','2026-02-21 03:44:09','2026-02-21 03:44:09'),(136,4,0,'Registration process completed successfully','2026-02-21 05:12:14','2026-02-21 05:12:14'),(137,3,0,'Campaign request is pending','2026-02-21 06:42:58','2026-02-21 06:42:58'),(138,3,0,'Campaign request is pending','2026-02-21 06:44:46','2026-02-21 06:44:46'),(139,4,0,'Campaign request is pending','2026-02-21 06:46:50','2026-02-21 06:46:50'),(140,4,0,'Campaign request is pending','2026-02-21 06:48:00','2026-02-21 06:48:00'),(141,0,7,'Sent a custom proposal to examplebrand','2026-02-21 21:53:04','2026-02-21 21:53:04'),(142,0,7,'Sent a custom proposal to examplebrand','2026-02-21 21:55:04','2026-02-21 21:55:04'),(143,0,7,'Sent a custom proposal to examplebrand','2026-02-21 22:01:30','2026-02-21 22:01:30'),(144,0,7,'Sent a custom proposal to examplebrand','2026-02-21 22:14:00','2026-02-21 22:14:00'),(145,3,0,'Influencer delivered your campaign job','2026-02-22 12:10:47','2026-02-22 12:10:47'),(146,0,7,'You have delivered the campaign job','2026-02-22 12:10:47','2026-02-22 12:10:47'),(147,3,0,'You have decided your campaign job is completed','2026-02-22 12:10:56','2026-02-22 12:10:56'),(148,0,7,'examplebrand has decided campaign job is completed','2026-02-22 12:10:56','2026-02-22 12:10:56'),(149,3,0,'Review added successfully','2026-02-22 12:11:04','2026-02-22 12:11:04'),(150,0,7,'examplebrand has reviewed for your campaign job','2026-02-22 12:11:04','2026-02-22 12:11:04'),(151,3,0,'Started a conversation with dsfdasfdsf','2026-02-22 14:31:54','2026-02-22 14:31:54'),(152,3,0,'Started a conversation with janeinfluencer','2026-02-22 14:39:03','2026-02-22 14:39:03'),(153,3,0,'Started a conversation with dsafdsf','2026-02-22 14:49:38','2026-02-22 14:49:38'),(154,4,0,'Started a conversation with influencerexample','2026-02-22 15:03:10','2026-02-22 15:03:10'),(155,3,0,'Influencer delivered your campaign job via message','2026-02-22 18:54:15','2026-02-22 18:54:15'),(156,3,0,'You have decided your campaign job is completed','2026-02-22 19:20:14','2026-02-22 19:20:14'),(157,0,7,'examplebrand has decided campaign job is completed','2026-02-22 19:20:14','2026-02-22 19:20:14'),(158,3,0,'Review added successfully','2026-02-22 19:20:22','2026-02-22 19:20:22'),(159,0,7,'examplebrand has reviewed for your campaign job','2026-02-22 19:20:22','2026-02-22 19:20:22'),(160,0,7,'Sent a custom proposal to examplebrand','2026-02-22 19:25:42','2026-02-22 19:25:42'),(161,3,0,'Influencer delivered your campaign job via message','2026-02-22 19:26:37','2026-02-22 19:26:37'),(162,3,0,'You have decided your campaign job is completed','2026-02-22 19:48:17','2026-02-22 19:48:17'),(163,0,7,'examplebrand has decided campaign job is completed','2026-02-22 19:48:17','2026-02-22 19:48:17'),(164,3,0,'Review added successfully','2026-02-22 19:48:22','2026-02-22 19:48:22'),(165,0,7,'examplebrand has reviewed for your campaign job','2026-02-22 19:48:22','2026-02-22 19:48:22'),(166,3,0,'New participate request added your campaign','2026-02-22 20:13:20','2026-02-22 20:13:20'),(167,0,7,'Participate request sent successfully','2026-02-22 20:13:20','2026-02-22 20:13:20'),(168,3,0,'You have accepted the influencerexample participation request','2026-02-22 20:14:26','2026-02-22 20:14:26'),(169,0,7,'examplebrand has accepted your participant request','2026-02-22 20:14:26','2026-02-22 20:14:26'),(170,3,0,'You purchased service sdaf from dsafdsf','2026-02-22 22:52:54','2026-02-22 22:52:54'),(171,0,6,'examplebrand purchased your service sdaf','2026-02-22 22:52:54','2026-02-22 22:52:54'),(172,0,7,'Sent a custom proposal to brandsubscriber','2026-02-22 22:55:02','2026-02-22 22:55:02'),(173,0,7,'Sent a custom proposal to brandsubscriber','2026-02-22 22:55:23','2026-02-22 22:55:23'),(174,5,0,'Registration process completed successfully','2026-02-23 15:56:47','2026-02-23 15:56:47'),(175,5,0,'Started a conversation with influencerexample','2026-02-23 15:59:30','2026-02-23 15:59:30'),(176,5,0,'influencerexample is added in your favorite list','2026-02-23 16:13:09','2026-02-23 16:13:09'),(177,5,0,'Started a conversation with dsfdasfdsf','2026-02-23 16:17:54','2026-02-23 16:17:54'),(178,0,7,'Sent a custom proposal to brandtest','2026-02-23 16:43:38','2026-02-23 16:43:38'),(179,0,7,'Sent a custom proposal to brandtest','2026-02-23 16:47:38','2026-02-23 16:47:38'),(180,5,0,'Influencer delivered your campaign job via message','2026-02-23 17:02:23','2026-02-23 17:02:23'),(181,0,7,'Brand requested a revision on your delivery','2026-02-23 17:05:30','2026-02-23 17:05:30'),(182,5,0,'Influencer delivered your campaign job via message','2026-02-23 17:06:11','2026-02-23 17:06:11'),(183,5,0,'You have decided your campaign job is completed','2026-02-23 17:07:47','2026-02-23 17:07:47'),(184,0,7,'brandtest has decided campaign job is completed','2026-02-23 17:07:47','2026-02-23 17:07:47'),(185,5,0,'Review added successfully','2026-02-23 17:07:55','2026-02-23 17:07:55'),(186,0,7,'brandtest has reviewed for your campaign job','2026-02-23 17:07:55','2026-02-23 17:07:55'),(187,0,5,'Profile updated successfully','2026-02-23 17:35:19','2026-02-23 17:35:19'),(188,4,0,'New participate request added your campaign','2026-02-23 17:35:34','2026-02-23 17:35:34'),(189,0,5,'Participate request sent successfully','2026-02-23 17:35:34','2026-02-23 17:35:34'),(190,4,0,'Started a conversation with dsfdasfdsf','2026-02-23 17:39:30','2026-02-23 17:39:30'),(191,1,0,'Started a conversation with influencerexample','2026-02-23 22:43:08','2026-02-23 22:43:08');
/*!40000 ALTER TABLE `activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_notifications`
--

DROP TABLE IF EXISTS `admin_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_notifications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT 0,
  `influencer_id` int(11) NOT NULL DEFAULT 0,
  `title` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `click_url` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_notifications`
--

LOCK TABLES `admin_notifications` WRITE;
/*!40000 ALTER TABLE `admin_notifications` DISABLE KEYS */;
INSERT INTO `admin_notifications` VALUES (1,0,1,'New influencer registered',0,'/admin/brands/detail/1','2026-02-19 02:09:56','2026-02-19 02:09:56'),(2,0,2,'New influencer registered',0,'/admin/brands/detail/2','2026-02-19 03:16:05','2026-02-19 03:16:05'),(3,0,3,'New influencer registered',0,'/admin/brands/detail/3','2026-02-19 03:23:58','2026-02-19 03:23:58'),(4,0,4,'New influencer registered',0,'/admin/brands/detail/4','2026-02-19 03:24:20','2026-02-19 03:24:20'),(5,0,5,'New influencer registered',0,'/admin/brands/detail/5','2026-02-19 04:21:23','2026-02-19 04:21:23'),(6,1,0,'New member registered',0,'/admin/brands/detail/1','2026-02-19 05:12:03','2026-02-19 05:12:03'),(7,1,0,'New campaign request from kjhhfdsfdsf',0,'/admin/campaign/detail/1','2026-02-19 07:49:30','2026-02-19 07:49:30'),(8,1,0,'New campaign request from kjhhfdsfdsf',0,'/admin/campaign/detail/1','2026-02-19 07:51:00','2026-02-19 07:51:00'),(9,1,0,'New campaign request from kjhhfdsfdsf',0,'/admin/campaign/detail/2','2026-02-19 08:02:51','2026-02-19 08:02:51'),(10,1,0,'New campaign request from kjhhfdsfdsf',0,'/admin/campaign/detail/3','2026-02-19 08:18:26','2026-02-19 08:18:26'),(11,0,5,'New participate request for campaign',0,'/admin/campaign/participants/3','2026-02-19 08:31:24','2026-02-19 08:31:24'),(12,0,6,'New influencer registered',0,'/admin/brands/detail/6','2026-02-19 10:14:29','2026-02-19 10:14:29'),(13,2,0,'New member registered',0,'/admin/brands/detail/2','2026-02-19 18:36:03','2026-02-19 18:36:03'),(14,3,0,'New member registered',0,'/admin/brands/detail/3','2026-02-19 21:40:37','2026-02-19 21:40:37'),(15,0,7,'New influencer registered',0,'/admin/brands/detail/7','2026-02-19 21:42:00','2026-02-19 21:42:00'),(16,3,0,'New campaign request from examplebrand',0,'/admin/campaign/detail/15','2026-02-19 23:38:18','2026-02-19 23:38:18'),(17,3,0,'New campaign request from examplebrand',0,'/admin/campaign/detail/16','2026-02-19 23:48:30','2026-02-19 23:48:30'),(18,0,7,'New participate request for campaign',0,'/admin/campaign/participants/16','2026-02-20 01:18:23','2026-02-20 01:18:23'),(19,3,0,'New campaign request from examplebrand',0,'/admin/campaign/detail/20','2026-02-20 01:53:30','2026-02-20 01:53:30'),(20,0,7,'New participate request for campaign',0,'/admin/campaign/participants/20','2026-02-20 01:54:33','2026-02-20 01:54:33'),(21,0,8,'New influencer registered',0,'/admin/brands/detail/8','2026-02-20 03:03:09','2026-02-20 03:03:09'),(22,4,0,'New member registered',0,'/admin/brands/detail/4','2026-02-21 05:10:47','2026-02-21 05:10:47'),(23,3,0,'New campaign request from examplebrand',0,'/admin/campaign/detail/23','2026-02-21 06:42:58','2026-02-21 06:42:58'),(24,3,0,'New campaign request from examplebrand',0,'/admin/campaign/detail/24','2026-02-21 06:44:46','2026-02-21 06:44:46'),(25,4,0,'New campaign request from brandsubscriber',0,'/admin/campaign/detail/25','2026-02-21 06:46:50','2026-02-21 06:46:50'),(26,4,0,'New campaign request from brandsubscriber',0,'/admin/campaign/detail/26','2026-02-21 06:48:00','2026-02-21 06:48:00'),(27,0,7,'New participate request for campaign',0,'/admin/campaign/participants/15','2026-02-22 20:13:20','2026-02-22 20:13:20'),(28,5,0,'New member registered',0,'/admin/brands/detail/5','2026-02-23 15:52:19','2026-02-23 15:52:19'),(29,0,5,'New participate request for campaign',0,'/admin/campaign/participants/25','2026-02-23 17:35:34','2026-02-23 17:35:34');
/*!40000 ALTER TABLE `admin_notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_password_resets`
--

DROP TABLE IF EXISTS `admin_password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_password_resets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(40) DEFAULT NULL,
  `token` varchar(40) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_password_resets`
--

LOCK TABLES `admin_password_resets` WRITE;
/*!40000 ALTER TABLE `admin_password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `admins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `username` varchar(40) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`,`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,'Super Admins','dymschwa@gmail.com','dymschwa',NULL,'66fa27dcf01781727670236.png','$2y$12$YgEXj8ZBcRJP9GdNm4QMb.mFWEdvZLFv6sP/rZX42bBl7pfVf2o7O',NULL,NULL,'2026-02-19 02:10:49');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `campaign_categories`
--

DROP TABLE IF EXISTS `campaign_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `campaign_categories` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `campaign_id` int(10) unsigned NOT NULL DEFAULT 0,
  `category_id` int(10) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `campaign_categories`
--

LOCK TABLES `campaign_categories` WRITE;
/*!40000 ALTER TABLE `campaign_categories` DISABLE KEYS */;
INSERT INTO `campaign_categories` VALUES (1,1,4,NULL,NULL),(2,2,7,NULL,NULL),(3,3,2,NULL,NULL),(4,15,7,NULL,NULL),(5,16,4,NULL,NULL),(6,16,7,NULL,NULL),(7,20,7,NULL,NULL),(8,23,1,NULL,NULL),(9,23,7,NULL,NULL),(10,24,6,NULL,NULL),(11,25,8,NULL,NULL),(12,26,1,NULL,NULL);
/*!40000 ALTER TABLE `campaign_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `campaign_conversations`
--

DROP TABLE IF EXISTS `campaign_conversations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `campaign_conversations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `participant_id` int(10) unsigned NOT NULL DEFAULT 0,
  `user_id` int(10) unsigned NOT NULL DEFAULT 0,
  `influencer_id` int(10) unsigned NOT NULL DEFAULT 0,
  `admin_id` int(10) unsigned NOT NULL DEFAULT 0,
  `sender` varchar(40) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `attachments` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_deliverable` tinyint(1) DEFAULT 0,
  `approval_status` tinyint(1) DEFAULT 0,
  `rejection_reason` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `campaign_conversations`
--

LOCK TABLES `campaign_conversations` WRITE;
/*!40000 ALTER TABLE `campaign_conversations` DISABLE KEYS */;
INSERT INTO `campaign_conversations` VALUES (1,1,1,5,0,'influencer','hi',NULL,'2026-02-19 08:33:07','2026-02-19 08:33:07',0,0,NULL),(2,1,1,5,0,'brand','hi',NULL,'2026-02-19 08:37:05','2026-02-19 08:37:05',0,0,NULL),(3,2,1,5,0,'brand','hi',NULL,'2026-02-19 08:59:07','2026-02-19 08:59:07',0,0,NULL),(4,6,2,6,0,'brand','xcv',NULL,'2026-02-19 21:24:53','2026-02-19 21:24:53',0,0,NULL),(5,6,2,6,0,'brand','fdh',NULL,'2026-02-19 21:25:07','2026-02-19 21:25:07',0,0,NULL),(6,6,2,6,0,'brand','dgsdg',NULL,'2026-02-19 21:26:07','2026-02-19 21:26:07',0,0,NULL),(7,6,2,6,0,'brand','dgdf',NULL,'2026-02-19 21:26:45','2026-02-19 21:26:45',0,0,NULL),(8,6,2,6,0,'brand','bxcvb',NULL,'2026-02-19 21:27:31','2026-02-19 21:27:31',0,0,NULL),(9,6,2,6,0,'brand','fghfg',NULL,'2026-02-19 21:28:41','2026-02-19 21:28:41',0,0,NULL),(10,7,2,5,0,'influencer','fdhfg',NULL,'2026-02-19 21:28:50','2026-02-19 21:28:50',0,0,NULL),(11,7,2,5,0,'brand','hi',NULL,'2026-02-19 21:29:55','2026-02-19 21:29:55',0,0,NULL),(12,8,2,5,0,'influencer','hi',NULL,'2026-02-19 21:30:35','2026-02-19 21:30:35',0,0,NULL),(13,7,2,5,0,'brand','hi',NULL,'2026-02-19 21:31:01','2026-02-19 21:31:01',0,0,NULL),(14,7,2,5,0,'brand','hello',NULL,'2026-02-19 21:31:08','2026-02-19 21:31:08',0,0,NULL),(15,9,2,5,0,'brand','hi',NULL,'2026-02-19 21:32:58','2026-02-19 21:32:58',0,0,NULL),(16,9,2,5,0,'influencer','hello',NULL,'2026-02-19 21:33:22','2026-02-19 21:33:22',0,0,NULL),(17,10,3,7,0,'brand','Hi',NULL,'2026-02-19 21:47:25','2026-02-19 21:47:25',0,0,NULL),(18,10,3,7,0,'influencer','Hello',NULL,'2026-02-19 21:47:42','2026-02-19 21:47:42',0,0,NULL),(19,12,3,7,0,'brand','Test',NULL,'2026-02-19 22:24:47','2026-02-19 22:24:47',0,0,NULL),(20,15,3,7,0,'influencer','Hi there buddy.',NULL,'2026-02-20 01:48:14','2026-02-20 01:48:14',0,0,NULL),(21,19,3,7,0,'influencer',NULL,'[\"699972294197a1771663913.jpg\"]','2026-02-21 21:51:53','2026-02-21 21:51:53',0,0,NULL),(22,22,3,7,0,'influencer',NULL,'[\"699a2ee9118691771712233.jpg\"]','2026-02-22 11:17:13','2026-02-22 11:48:45',1,1,NULL),(23,23,3,7,0,'influencer','Here is the tiktok','[\"699a2fee128f01771712494.jpg\"]','2026-02-22 11:21:34','2026-02-22 11:48:37',1,1,NULL),(24,23,3,7,0,'influencer','Here is my deliverable','[\"699a36042b0ab1771714052.jpg\"]','2026-02-22 11:47:32','2026-02-22 11:48:03',1,2,'change the colour'),(25,20,3,7,0,'influencer','Here is my IG','[\"699a3ada835bb1771715290.jpg\"]','2026-02-22 12:08:10','2026-02-22 12:09:11',1,1,NULL),(26,23,3,7,0,'influencer','hi',NULL,'2026-02-22 14:16:53','2026-02-22 14:16:53',0,0,NULL),(27,23,3,7,0,'influencer',NULL,'[\"699a591f949221771723039.jpg\"]','2026-02-22 14:17:19','2026-02-22 14:17:19',0,0,NULL),(28,10,3,7,0,'brand','thanks',NULL,'2026-02-22 15:11:36','2026-02-22 15:11:36',0,0,NULL),(29,10,3,7,0,'brand','hi',NULL,'2026-02-22 15:18:23','2026-02-22 15:18:23',0,0,NULL),(30,23,3,7,0,'influencer','hi',NULL,'2026-02-22 15:18:38','2026-02-22 15:18:38',0,0,NULL),(31,10,3,7,0,'brand','hi',NULL,'2026-02-22 15:32:11','2026-02-22 15:32:11',0,0,NULL),(32,23,3,7,0,'influencer','hi',NULL,'2026-02-22 15:32:21','2026-02-22 15:32:21',0,0,NULL),(33,10,3,7,0,'brand','hi',NULL,'2026-02-22 15:32:41','2026-02-22 15:32:41',0,0,NULL),(34,23,3,7,0,'influencer','hi',NULL,'2026-02-22 15:36:01','2026-02-22 15:36:01',0,0,NULL),(35,10,3,7,0,'brand','hi',NULL,'2026-02-22 15:36:11','2026-02-22 15:36:11',0,0,NULL),(36,10,3,7,0,'brand','hi',NULL,'2026-02-22 15:42:02','2026-02-22 15:42:02',0,0,NULL),(37,10,3,7,0,'brand','hi',NULL,'2026-02-22 15:43:07','2026-02-22 15:43:07',0,0,NULL),(38,23,3,7,0,'influencer','hi',NULL,'2026-02-22 15:43:13','2026-02-22 15:43:13',0,0,NULL),(39,23,3,7,0,'influencer','hi',NULL,'2026-02-22 15:46:59','2026-02-22 15:46:59',0,0,NULL),(40,10,3,7,0,'brand','hi',NULL,'2026-02-22 15:49:51','2026-02-22 15:49:51',0,0,NULL),(41,10,3,7,0,'brand','hi',NULL,'2026-02-22 15:54:00','2026-02-22 15:54:00',0,0,NULL),(42,23,3,7,0,'influencer','Whats up',NULL,'2026-02-22 15:54:13','2026-02-22 15:54:13',0,0,NULL),(43,10,3,7,0,'brand','hi',NULL,'2026-02-22 15:56:06','2026-02-22 15:56:06',0,0,NULL),(44,10,3,7,0,'brand','hi',NULL,'2026-02-22 16:03:57','2026-02-22 16:03:57',0,0,NULL),(45,23,3,7,0,'influencer','hi',NULL,'2026-02-22 16:04:02','2026-02-22 16:04:02',0,0,NULL),(46,10,3,7,0,'brand','hi',NULL,'2026-02-22 16:09:33','2026-02-22 16:09:33',0,0,NULL),(47,23,3,7,0,'influencer','hi',NULL,'2026-02-22 16:10:24','2026-02-22 16:10:24',0,0,NULL),(48,10,3,7,0,'brand','hi',NULL,'2026-02-22 16:11:08','2026-02-22 16:11:08',0,0,NULL),(49,10,3,7,0,'brand','hi',NULL,'2026-02-22 16:14:03','2026-02-22 16:14:03',0,0,NULL),(50,23,3,7,0,'influencer','hi',NULL,'2026-02-22 16:14:14','2026-02-22 16:14:14',0,0,NULL),(51,10,3,7,0,'brand','hi',NULL,'2026-02-22 16:23:07','2026-02-22 16:23:07',0,0,NULL),(52,10,3,7,0,'brand','hi',NULL,'2026-02-22 16:23:10','2026-02-22 16:23:10',0,0,NULL),(53,10,3,7,0,'brand','hi',NULL,'2026-02-22 16:23:11','2026-02-22 16:23:11',0,0,NULL),(54,23,3,7,0,'influencer','hi',NULL,'2026-02-22 16:23:17','2026-02-22 16:23:17',0,0,NULL),(55,23,3,7,0,'influencer','hi',NULL,'2026-02-22 16:23:17','2026-02-22 16:23:17',0,0,NULL),(56,23,3,7,0,'influencer','hi',NULL,'2026-02-22 16:23:18','2026-02-22 16:23:18',0,0,NULL),(57,23,3,7,0,'influencer','hi',NULL,'2026-02-22 16:23:18','2026-02-22 16:23:18',0,0,NULL),(58,10,3,7,0,'brand','hi',NULL,'2026-02-22 16:26:00','2026-02-22 16:26:00',0,0,NULL),(59,23,3,7,0,'influencer','hi',NULL,'2026-02-22 16:26:05','2026-02-22 16:26:05',0,0,NULL),(60,10,3,7,0,'brand','hi',NULL,'2026-02-22 16:26:45','2026-02-22 16:26:45',0,0,NULL),(61,23,3,7,0,'influencer','hi',NULL,'2026-02-22 16:26:49','2026-02-22 16:26:49',0,0,NULL),(62,21,3,7,0,'influencer',NULL,'[\"699a91788449e1771737464.jpg\"]','2026-02-22 18:17:44','2026-02-22 18:18:11',1,1,NULL),(63,21,3,7,0,'influencer','link',NULL,'2026-02-22 18:18:52','2026-02-22 18:34:22',1,1,NULL),(64,23,3,7,0,'influencer',NULL,'[\"699a9a07159e01771739655.jpg\"]','2026-02-22 18:54:15','2026-02-22 18:54:29',1,1,NULL),(65,23,3,7,0,'influencer','https://tiktok.com',NULL,'2026-02-22 18:58:48','2026-02-22 19:07:10',1,1,NULL),(66,23,3,7,0,'influencer','tiktok.com/me',NULL,'2026-02-22 19:07:31','2026-02-22 19:20:30',1,1,NULL),(67,28,3,7,0,'influencer','facebook.com',NULL,'2026-02-22 19:26:37','2026-02-22 19:48:10',1,1,NULL),(68,33,5,7,0,'brand','Hello',NULL,'2026-02-23 16:17:29','2026-02-23 16:17:29',0,0,NULL),(69,34,5,5,0,'brand','Hi mate',NULL,'2026-02-23 16:18:16','2026-02-23 16:18:16',0,0,NULL),(70,33,5,7,0,'brand','hi',NULL,'2026-02-23 16:21:50','2026-02-23 16:21:50',0,0,NULL),(71,33,5,7,0,'influencer','hi',NULL,'2026-02-23 16:23:33','2026-02-23 16:23:33',0,0,NULL),(72,33,5,7,0,'brand','I want a fb campaign',NULL,'2026-02-23 16:24:24','2026-02-23 16:24:24',0,0,NULL),(73,33,5,7,0,'influencer','Yup no worries',NULL,'2026-02-23 16:42:52','2026-02-23 16:42:52',0,0,NULL),(74,36,5,7,0,'brand','Hey I want 4 reels instead of',NULL,'2026-02-23 16:51:29','2026-02-23 16:51:29',0,0,NULL),(75,35,5,7,0,'brand','For the fb campaign I need 2 reels',NULL,'2026-02-23 16:51:50','2026-02-23 16:51:50',0,0,NULL),(76,36,5,7,0,'brand',NULL,'[\"699bcf42874891771818818.jpg\"]','2026-02-23 16:53:38','2026-02-23 16:53:38',0,0,NULL),(77,35,5,7,0,'influencer','https://instagram.com',NULL,'2026-02-23 17:02:23','2026-02-23 17:03:45',1,1,NULL),(78,35,5,7,0,'influencer',NULL,'[\"699bd1818075f1771819393.jpg\"]','2026-02-23 17:03:13','2026-02-23 17:05:30',1,2,'More colours'),(79,35,5,7,0,'influencer','2nd draft','[\"699bd233ae4b11771819571.jpg\"]','2026-02-23 17:06:11','2026-02-23 17:06:30',1,1,NULL);
/*!40000 ALTER TABLE `campaign_conversations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `campaign_platforms`
--

DROP TABLE IF EXISTS `campaign_platforms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `campaign_platforms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `campaign_id` int(10) unsigned NOT NULL DEFAULT 0,
  `platform_id` int(10) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `campaign_platforms_campaign_id_foreign` (`campaign_id`),
  KEY `campaign_platforms_platform_id_foreign` (`platform_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `campaign_platforms`
--

LOCK TABLES `campaign_platforms` WRITE;
/*!40000 ALTER TABLE `campaign_platforms` DISABLE KEYS */;
INSERT INTO `campaign_platforms` VALUES (1,1,2,NULL,NULL),(2,2,1,NULL,NULL),(3,3,1,NULL,NULL),(4,10,2,NULL,NULL),(5,11,2,NULL,NULL),(6,13,2,NULL,NULL),(7,14,3,NULL,NULL),(8,15,1,NULL,NULL),(9,16,1,NULL,NULL),(10,19,4,NULL,NULL),(11,20,1,NULL,NULL),(12,21,2,NULL,NULL),(13,23,4,NULL,NULL),(14,24,3,NULL,NULL),(15,25,1,NULL,NULL),(16,26,1,NULL,NULL),(17,27,2,NULL,NULL),(18,28,3,NULL,NULL),(19,29,2,NULL,NULL),(20,30,4,NULL,NULL),(21,35,1,NULL,NULL),(22,37,1,NULL,NULL),(23,38,2,NULL,NULL),(24,41,1,NULL,NULL),(25,42,2,NULL,NULL);
/*!40000 ALTER TABLE `campaign_platforms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `campaign_tags`
--

DROP TABLE IF EXISTS `campaign_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `campaign_tags` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `campaign_id` int(10) unsigned NOT NULL DEFAULT 0,
  `tag_id` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `campaign_tags`
--

LOCK TABLES `campaign_tags` WRITE;
/*!40000 ALTER TABLE `campaign_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `campaign_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `campaigns`
--

DROP TABLE IF EXISTS `campaigns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `campaigns` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT 0,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `campaign_type` varchar(40) DEFAULT NULL,
  `payment_type` varchar(40) DEFAULT NULL,
  `promoting_type` varchar(40) DEFAULT NULL,
  `send_product` varchar(40) DEFAULT NULL,
  `content_creator` varchar(40) DEFAULT NULL,
  `campaign_step` tinyint(1) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `content_requirements` text DEFAULT NULL,
  `monetary_value` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `description` text DEFAULT NULL,
  `review_process` text DEFAULT NULL,
  `approval_process` text DEFAULT NULL,
  `influencer_requirements` text DEFAULT NULL,
  `budget` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `hash_tags` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `campaigns`
--

LOCK TABLES `campaigns` WRITE;
/*!40000 ALTER TABLE `campaigns` DISABLE KEYS */;
INSERT INTO `campaigns` VALUES (1,1,'fhfdh','fhfdh-q5whkh','general','giveway','physical','no','influencer',4,'6996c0de082b31771487454.jpg',NULL,'{\"facebook_type\":null,\"facebook_placement\":null,\"facebook_post_count\":null,\"instagram_type\":[\"photo\"],\"instagram_placement\":[\"post\"],\"instagram_post_count\":\"1\",\"youtube_placement\":null,\"youtube_video_count\":null,\"tiktok_type\":null,\"tiktok_placement\":null,\"tiktok_video_count\":null,\"video_length\":null}',0.00000000,'sshdfh','hfghf','hfgh','{\"required_influencer\":\"1\",\"gender\":[\"male\"],\"follower_facebook_start\":null,\"follower_facebook_end\":null,\"follower_instagram_start\":\"1\",\"follower_instagram_end\":\"10\",\"follower_youtube_start\":null,\"follower_youtube_end\":null,\"follower_tiktok_start\":null,\"follower_tiktok_end\":null}',0.00000000,'2026-02-19','2026-02-20',NULL,'[]',1,'2026-02-19 05:31:48','2026-02-19 07:54:07'),(2,1,'fdhfdghgfh','fdhfdghgfh-n3sncd','general','paid','physical','no','influencer',4,NULL,NULL,'{\"facebook_type\":[\"photo\"],\"facebook_placement\":[\"post\"],\"facebook_post_count\":\"1\",\"instagram_type\":null,\"instagram_placement\":null,\"instagram_post_count\":null,\"youtube_placement\":null,\"youtube_video_count\":null,\"tiktok_type\":null,\"tiktok_placement\":null,\"tiktok_video_count\":null,\"video_length\":null}',0.00000000,'fgdfg','gdfsg','gdfg','{\"required_influencer\":\"1\",\"gender\":[\"male\"],\"follower_facebook_start\":\"1\",\"follower_facebook_end\":\"1000\",\"follower_instagram_start\":null,\"follower_instagram_end\":null,\"follower_youtube_start\":null,\"follower_youtube_end\":null,\"follower_tiktok_start\":null,\"follower_tiktok_end\":null}',78.00000000,'2026-02-19','2026-02-26',NULL,'[]',1,'2026-02-19 07:59:11','2026-02-19 08:03:04'),(3,1,'test','test-xm8b6s','invite','paid','physical','no','influencer',4,NULL,NULL,'{\"facebook_type\":[\"photo\"],\"facebook_placement\":[\"story\"],\"facebook_post_count\":\"1\",\"instagram_type\":null,\"instagram_placement\":null,\"instagram_post_count\":null,\"youtube_placement\":null,\"youtube_video_count\":null,\"tiktok_type\":null,\"tiktok_placement\":null,\"tiktok_video_count\":null,\"video_length\":null}',0.00000000,'vxbhxdf','gdfsgd','hdfh','{\"required_influencer\":\"1\",\"gender\":[\"male\"],\"follower_facebook_start\":\"1\",\"follower_facebook_end\":\"100\",\"follower_instagram_start\":null,\"follower_instagram_end\":null,\"follower_youtube_start\":null,\"follower_youtube_end\":null,\"follower_tiktok_start\":null,\"follower_tiktok_end\":null}',60.00000000,'2026-02-19','2026-03-06',NULL,'[]',1,'2026-02-19 08:17:45','2026-02-19 08:18:42'),(4,1,'Service: fdgsg',NULL,'invite','paid',NULL,NULL,NULL,0,NULL,NULL,NULL,0.00000000,NULL,NULL,NULL,'{\"required_influencer\":1,\"gender\":[\"Male\",\"Female\"]}',100.00000000,'2026-02-19','2036-02-19',NULL,NULL,1,'2026-02-19 08:58:53','2026-02-19 08:58:53'),(5,1,'General Inquiry: kjhhfdsfdsf x dsfdasfdsf',NULL,'invite','paid',NULL,NULL,NULL,0,NULL,NULL,NULL,0.00000000,NULL,NULL,NULL,'{\"required_influencer\":1,\"gender\":[\"Male\",\"Female\"]}',100.00000000,'2026-02-19','2036-02-19',NULL,NULL,1,'2026-02-19 09:17:19','2026-02-19 09:43:11'),(6,1,'General Inquiry: kjhhfdsfdsf x dsafdsf',NULL,'invite','paid',NULL,NULL,NULL,0,NULL,NULL,NULL,0.00000000,NULL,NULL,NULL,'{\"required_influencer\":1,\"gender\":[\"Male\",\"Female\"]}',50.00000000,'2026-02-19','2036-02-19',NULL,NULL,1,'2026-02-19 10:15:35','2026-02-19 10:38:13'),(7,1,'Service: sdaf',NULL,'invite','paid',NULL,NULL,NULL,0,NULL,NULL,NULL,0.00000000,NULL,NULL,NULL,'{\"required_influencer\":1,\"gender\":[\"Male\",\"Female\"]}',45.00000000,'2026-02-19','2036-02-19',NULL,NULL,1,'2026-02-19 10:49:58','2026-02-19 10:49:58'),(8,2,'General Inquiry: vdfaafafvadf x dsafdsf','general-inquiry-vdfaafafvadf-x-dsafdsf-L16LI','invite','paid',NULL,NULL,NULL,0,NULL,NULL,NULL,0.00000000,NULL,NULL,NULL,'{\"required_influencer\":1,\"gender\":[\"Male\",\"Female\"]}',0.00000000,'2026-02-19','2036-02-19',NULL,NULL,1,'2026-02-19 18:37:11','2026-02-19 18:37:11'),(9,2,'General Inquiry: vdfaafafvadf x dsfdasfdsf','general-inquiry-vdfaafafvadf-x-dsfdasfdsf-FGXP7','invite','paid',NULL,NULL,NULL,0,NULL,NULL,NULL,0.00000000,NULL,NULL,NULL,'{\"required_influencer\":1,\"gender\":[\"Male\",\"Female\"]}',0.00000000,'2026-02-19','2036-02-19',NULL,NULL,1,'2026-02-19 18:58:25','2026-02-19 18:58:25'),(10,2,'2 IG stories','2-ig-stories-8FGH8','invite','paid',NULL,NULL,NULL,0,NULL,NULL,'{\"instagram_post_count\":\"2\",\"video_length\":null}',0.00000000,'dfsdsf',NULL,NULL,NULL,500.00000000,'2026-02-19','2026-02-26',NULL,NULL,1,'2026-02-19 19:52:27','2026-02-19 19:52:27'),(11,2,'2 stories','2-stories-IVPFO','invite','paid',NULL,NULL,NULL,0,NULL,NULL,'{\"instagram_post_count\":\"1\",\"video_length\":null}',0.00000000,'hdfsh',NULL,NULL,NULL,500.00000000,'2026-02-19','2026-02-26',NULL,NULL,1,'2026-02-19 20:17:46','2026-02-19 20:17:46'),(12,3,'Service: Basic Shotout','service-basic-shotout-J8ZSE','invite','paid',NULL,NULL,NULL,0,NULL,NULL,'{\"facebook_post_count\":null,\"video_length\":null}',0.00000000,NULL,NULL,NULL,'{\"required_influencer\":1,\"gender\":[\"Male\",\"Female\"]}',100.00000000,'2026-02-19','2026-03-21',NULL,NULL,4,'2026-02-19 21:47:16','2026-02-21 00:06:16'),(13,3,'2 stories','2-stories-E52IJ','invite','paid',NULL,NULL,NULL,0,NULL,NULL,NULL,0.00000000,'dfhgd',NULL,NULL,NULL,100.00000000,'2026-02-19','2026-02-26',NULL,NULL,4,'2026-02-19 22:19:43','2026-02-21 00:06:43'),(14,3,'1 Youtube','1-youtube-551P4','invite','paid',NULL,NULL,NULL,0,NULL,NULL,NULL,0.00000000,'One video',NULL,NULL,NULL,50.00000000,'2026-02-19','2026-02-26',NULL,NULL,1,'2026-02-19 22:21:24','2026-02-19 22:21:24'),(15,3,'The Best Campaign','the-best-campaign-zkoyx1','general','paid','physical','no','influencer',4,NULL,NULL,'{\"facebook_type\":[\"photo\"],\"facebook_placement\":[\"post\"],\"facebook_post_count\":\"1\",\"instagram_type\":null,\"instagram_placement\":null,\"instagram_post_count\":null,\"youtube_placement\":null,\"youtube_video_count\":null,\"tiktok_type\":null,\"tiktok_placement\":null,\"tiktok_video_count\":null,\"video_length\":null}',0.00000000,'A great cmapaign','3 revision rounds','On final delivery','{\"required_influencer\":\"1\",\"gender\":[\"male\",\"female\"],\"follower_facebook_start\":\"1\",\"follower_facebook_end\":\"10000\",\"follower_instagram_start\":null,\"follower_instagram_end\":null,\"follower_youtube_start\":null,\"follower_youtube_end\":null,\"follower_tiktok_start\":null,\"follower_tiktok_end\":null}',500.00000000,'2026-02-20','2026-03-06',NULL,'[]',1,'2026-02-19 23:37:35','2026-02-19 23:38:44'),(16,3,'Example Campaign','gh-8i9tvj','general','paid','physical','no','influencer',4,NULL,NULL,'{\"facebook_type\":[\"photo\"],\"facebook_placement\":[\"post\"],\"facebook_post_count\":\"1\",\"instagram_type\":null,\"instagram_placement\":null,\"instagram_post_count\":null,\"youtube_placement\":null,\"youtube_video_count\":null,\"tiktok_type\":null,\"tiktok_placement\":null,\"tiktok_video_count\":null,\"video_length\":null}',0.00000000,'A great example campaign','Solid review','When I say so','{\"required_influencer\":\"1\",\"gender\":[\"male\",\"female\"],\"follower_facebook_start\":\"1\",\"follower_facebook_end\":\"100\",\"follower_instagram_start\":null,\"follower_instagram_end\":null,\"follower_youtube_start\":null,\"follower_youtube_end\":null,\"follower_tiktok_start\":null,\"follower_tiktok_end\":null}',200.00000000,'2026-02-20','2026-03-07',NULL,'[]',4,'2026-02-19 23:46:13','2026-02-21 00:07:21'),(17,3,'Service: Basic Shotout','service-basic-shotout-8DMY4','invite','paid','digital','no','influencer',4,NULL,NULL,'{\"post_count\":1,\"video_length\":null}',0.00000000,'A shoutout for your brand',NULL,NULL,'{\"required_influencer\":1,\"gender\":[\"male\",\"female\",\"other\"]}',100.00000000,'2026-02-20','2026-02-27',NULL,NULL,4,'2026-02-20 01:10:05','2026-02-21 00:07:04'),(18,3,'Service: Basic Reel','service-basic-reel-XJXP2','invite','paid','digital','no','influencer',4,NULL,NULL,'{\"post_count\":1,\"video_length\":null}',0.00000000,'A basic reel for your brand',NULL,NULL,'{\"required_influencer\":1,\"gender\":[\"male\",\"female\",\"other\"]}',200.00000000,'2026-02-20','2026-02-27',NULL,NULL,4,'2026-02-20 01:44:31','2026-02-20 10:28:27'),(19,3,'1 x TikTok reel','1-x-tiktok-reel-2XU62','invite','paid',NULL,NULL,NULL,0,NULL,NULL,NULL,0.00000000,'1 x reel',NULL,NULL,NULL,50.00000000,'2026-02-20','2026-02-27',NULL,NULL,1,'2026-02-20 01:49:07','2026-02-20 01:49:07'),(20,3,'Best Campaign Ever','best-campaign-ever-hk9jey','general','paid','physical','no','influencer',4,'6997be69353c61771552361.jpg',NULL,'{\"facebook_type\":[\"photo\"],\"facebook_placement\":[\"post\"],\"facebook_post_count\":\"1\",\"instagram_type\":null,\"instagram_placement\":null,\"instagram_post_count\":null,\"youtube_placement\":null,\"youtube_video_count\":null,\"tiktok_type\":null,\"tiktok_placement\":null,\"tiktok_video_count\":null,\"video_length\":null}',0.00000000,'Deliver me good content','3 revision rounds','When Is ay its good enough','{\"required_influencer\":\"1\",\"gender\":[\"male\",\"female\",\"other\"],\"follower_facebook_start\":\"1\",\"follower_facebook_end\":\"600\",\"follower_instagram_start\":null,\"follower_instagram_end\":null,\"follower_youtube_start\":null,\"follower_youtube_end\":null,\"follower_tiktok_start\":null,\"follower_tiktok_end\":null}',500.00000000,'2026-02-20','2026-03-06',NULL,'[]',4,'2026-02-20 01:52:41','2026-02-21 00:07:51'),(21,3,'2 Stories','2-stories-HXHIG','invite','paid',NULL,NULL,NULL,0,NULL,NULL,NULL,0.00000000,'2 Stories',NULL,NULL,NULL,100.00000000,'2026-02-20','2026-02-27',NULL,NULL,4,'2026-02-20 11:50:04','2026-02-21 00:09:12'),(22,3,'General Inquiry: examplebrand x influencerexample','general-inquiry-examplebrand-x-influencerexample-45F58','invite','paid','digital','no','influencer',4,NULL,NULL,NULL,0.00000000,NULL,NULL,NULL,'{\"required_influencer\":1,\"gender\":[\"male\",\"female\",\"other\"]}',0.00000000,'2026-02-20','2036-02-20',NULL,NULL,1,'2026-02-20 23:56:32','2026-02-20 23:56:32'),(23,3,'Example 2','example-2-jyzakt','general','paid','physical','no','influencer',4,NULL,NULL,'{\"facebook_type\":null,\"facebook_placement\":null,\"facebook_post_count\":null,\"instagram_type\":null,\"instagram_placement\":null,\"instagram_post_count\":null,\"youtube_placement\":null,\"youtube_video_count\":null,\"tiktok_type\":[\"video\"],\"tiktok_placement\":[\"video\"],\"tiktok_video_count\":\"1\",\"video_length\":null}',0.00000000,'This is the deescription.','This is the deescription.','This is the deescription.','{\"required_influencer\":\"1\",\"gender\":[\"male\"],\"follower_facebook_start\":null,\"follower_facebook_end\":null,\"follower_instagram_start\":null,\"follower_instagram_end\":null,\"follower_youtube_start\":null,\"follower_youtube_end\":null,\"follower_tiktok_start\":\"1\",\"follower_tiktok_end\":\"999\"}',250.00000000,'2026-02-21','2026-03-06',NULL,'[]',1,'2026-02-21 06:42:12','2026-02-21 06:43:27'),(24,3,'Example 3','example-3-1hes3q','general','paid','physical','no','influencer',4,NULL,NULL,'{\"facebook_type\":null,\"facebook_placement\":null,\"facebook_post_count\":null,\"instagram_type\":null,\"instagram_placement\":null,\"instagram_post_count\":null,\"youtube_placement\":[\"video\"],\"youtube_video_count\":\"1\",\"tiktok_type\":null,\"tiktok_placement\":null,\"tiktok_video_count\":null,\"video_length\":null}',0.00000000,'This is my description','This is my description','This is my description','{\"required_influencer\":\"1\",\"gender\":[\"female\"],\"follower_facebook_start\":null,\"follower_facebook_end\":null,\"follower_instagram_start\":null,\"follower_instagram_end\":null,\"follower_youtube_start\":\"1\",\"follower_youtube_end\":\"3000\",\"follower_tiktok_start\":null,\"follower_tiktok_end\":null}',250.00000000,'2026-02-21','2026-02-27',NULL,'[]',1,'2026-02-21 06:44:12','2026-02-21 06:45:03'),(25,4,'Example 4','example-4-morpqm','general','paid','digital','no','influencer',4,NULL,NULL,'{\"facebook_type\":[\"photo\"],\"facebook_placement\":[\"story\"],\"facebook_post_count\":\"1\",\"instagram_type\":null,\"instagram_placement\":null,\"instagram_post_count\":null,\"youtube_placement\":null,\"youtube_video_count\":null,\"tiktok_type\":null,\"tiktok_placement\":null,\"tiktok_video_count\":null,\"video_length\":null}',0.00000000,'This is the brief','This is the brief','This is the brief','{\"required_influencer\":\"1\",\"gender\":[\"male\"],\"follower_facebook_start\":\"1\",\"follower_facebook_end\":\"800\",\"follower_instagram_start\":null,\"follower_instagram_end\":null,\"follower_youtube_start\":null,\"follower_youtube_end\":null,\"follower_tiktok_start\":null,\"follower_tiktok_end\":null}',1000.00000000,'2026-02-21','2026-02-28',NULL,'[]',1,'2026-02-21 06:46:19','2026-02-21 06:47:02'),(26,4,'Example 5','example-5-qs6r4r','general','paid','digital','no','influencer',4,NULL,NULL,'{\"facebook_type\":[\"photo\"],\"facebook_placement\":[\"reels\"],\"facebook_post_count\":\"1\",\"instagram_type\":null,\"instagram_placement\":null,\"instagram_post_count\":null,\"youtube_placement\":null,\"youtube_video_count\":null,\"tiktok_type\":null,\"tiktok_placement\":null,\"tiktok_video_count\":null,\"video_length\":null}',0.00000000,'This is a campaign','This is a campaign','This is a campaign','{\"required_influencer\":\"1\",\"gender\":[\"male\"],\"follower_facebook_start\":\"1000\",\"follower_facebook_end\":\"2000\",\"follower_instagram_start\":null,\"follower_instagram_end\":null,\"follower_youtube_start\":null,\"follower_youtube_end\":null,\"follower_tiktok_start\":null,\"follower_tiktok_end\":null}',500.00000000,'2026-02-21','2026-03-06',NULL,'[]',1,'2026-02-21 06:47:24','2026-02-21 06:48:16'),(27,3,'1 Instagram Post','1-instagram-post-BOG3V','invite','paid',NULL,NULL,NULL,0,NULL,NULL,NULL,0.00000000,'1 post',NULL,NULL,NULL,50.00000000,'2026-02-21','2026-02-28',NULL,NULL,4,'2026-02-21 21:53:04','2026-02-22 12:10:56'),(28,3,'1 story','1-story-L7HK8','invite','paid',NULL,NULL,NULL,0,NULL,NULL,NULL,0.00000000,'Stuff',NULL,NULL,NULL,50.00000000,'2026-02-21','2026-02-28',NULL,NULL,1,'2026-02-21 21:55:04','2026-02-21 21:55:04'),(29,3,'1 Video','1-video-33IAR','invite','paid',NULL,NULL,NULL,0,NULL,NULL,NULL,0.00000000,'stuff',NULL,NULL,NULL,50.00000000,'2026-02-21','2026-02-28',NULL,NULL,1,'2026-02-21 22:01:30','2026-02-21 22:01:30'),(30,3,'1 tiktok','1-tiktok-IWTI3','invite','paid',NULL,NULL,NULL,0,NULL,NULL,NULL,0.00000000,'1 tiktok for you',NULL,NULL,NULL,100.00000000,'2026-02-21','2026-02-28',NULL,NULL,4,'2026-02-21 22:14:00','2026-02-22 19:20:14'),(31,3,'General Inquiry: examplebrand x dsfdasfdsf','general-inquiry-examplebrand-x-dsfdasfdsf-EM2YP','invite','paid','digital','no','influencer',4,NULL,NULL,NULL,0.00000000,NULL,NULL,NULL,'{\"required_influencer\":1,\"gender\":[\"male\",\"female\",\"other\"]}',0.00000000,'2026-02-22','2036-02-22',NULL,NULL,4,'2026-02-22 14:31:54','2026-02-22 14:34:36'),(32,3,'General Inquiry: examplebrand x janeinfluencer','general-inquiry-examplebrand-x-janeinfluencer-5XBER','invite','paid','digital','no','influencer',4,NULL,NULL,NULL,0.00000000,NULL,NULL,NULL,'{\"required_influencer\":1,\"gender\":[\"male\",\"female\",\"other\"]}',0.00000000,'2026-02-22','2036-02-22',NULL,NULL,4,'2026-02-22 14:39:03','2026-02-22 14:39:10'),(33,3,'General Inquiry: examplebrand x dsafdsf','general-inquiry-examplebrand-x-dsafdsf-ZSWLF','invite','paid','digital','no','influencer',4,NULL,NULL,NULL,0.00000000,NULL,NULL,NULL,'{\"required_influencer\":1,\"gender\":[\"male\",\"female\",\"other\"]}',0.00000000,'2026-02-22','2036-02-22',NULL,NULL,1,'2026-02-22 14:49:38','2026-02-22 14:49:38'),(34,4,'General Inquiry: brandsubscriber x influencerexample','general-inquiry-brandsubscriber-x-influencerexample-UYFSJ','invite','paid','digital','no','influencer',4,NULL,NULL,NULL,0.00000000,NULL,NULL,NULL,'{\"required_influencer\":1,\"gender\":[\"male\",\"female\",\"other\"]}',0.00000000,'2026-02-22','2036-02-22',NULL,NULL,1,'2026-02-22 15:03:10','2026-02-22 15:03:10'),(35,3,'1 FB','1-fb-KSW82','invite','paid',NULL,NULL,NULL,0,NULL,NULL,NULL,0.00000000,'stuff',NULL,NULL,NULL,10.00000000,'2026-02-22','2026-03-01',NULL,NULL,4,'2026-02-22 19:25:42','2026-02-22 19:48:17'),(36,3,'Service: sdaf','service-sdaf-QPXKE','invite','paid','digital','no','influencer',4,NULL,NULL,'{\"post_count\":1,\"video_length\":null}',0.00000000,'fsadfsadf',NULL,NULL,'{\"required_influencer\":1,\"gender\":[\"male\",\"female\",\"other\"]}',45.00000000,'2026-02-22','2026-03-01',NULL,NULL,1,'2026-02-22 22:52:54','2026-02-22 22:52:54'),(37,4,'2 stories','2-stories-QYJOU','invite','paid',NULL,NULL,NULL,0,NULL,NULL,NULL,0.00000000,'stuff',NULL,NULL,NULL,51.00000000,'2026-02-22','2026-03-01',NULL,NULL,1,'2026-02-22 22:55:02','2026-02-22 22:55:02'),(38,4,'2 posts','2-posts-5JPQI','invite','paid',NULL,NULL,NULL,0,NULL,NULL,NULL,0.00000000,'great stuff',NULL,NULL,NULL,50.00000000,'2026-02-22','2026-03-01',NULL,NULL,1,'2026-02-22 22:55:23','2026-02-22 22:55:23'),(39,5,'General Inquiry: brandtest x influencerexample','general-inquiry-brandtest-x-influencerexample-XGYX1','invite','paid','digital','no','influencer',4,NULL,NULL,NULL,0.00000000,NULL,NULL,NULL,'{\"required_influencer\":1,\"gender\":[\"male\",\"female\",\"other\"]}',0.00000000,'2026-02-23','2036-02-23',NULL,NULL,4,'2026-02-23 15:59:30','2026-02-23 16:18:50'),(40,5,'General Inquiry: brandtest x dsfdasfdsf','general-inquiry-brandtest-x-dsfdasfdsf-7WRWC','invite','paid','digital','no','influencer',4,NULL,NULL,NULL,0.00000000,NULL,NULL,NULL,'{\"required_influencer\":1,\"gender\":[\"male\",\"female\",\"other\"]}',0.00000000,'2026-02-23','2036-02-23',NULL,NULL,1,'2026-02-23 16:17:54','2026-02-23 16:17:54'),(41,5,'1 FB Campaign','1-fb-campaign-MTGXO','invite','paid',NULL,NULL,NULL,0,NULL,NULL,NULL,0.00000000,'Here\'s the deliverables',NULL,NULL,NULL,200.00000000,'2026-02-23','2026-03-02',NULL,NULL,4,'2026-02-23 16:43:38','2026-02-23 17:07:47'),(42,5,'3 x reels','3-x-reels-7TASZ','invite','paid',NULL,NULL,NULL,0,NULL,NULL,NULL,0.00000000,'Instagram deliverables',NULL,NULL,NULL,500.00000000,'2026-02-23','2026-03-02',NULL,NULL,1,'2026-02-23 16:47:38','2026-02-23 16:47:38'),(43,4,'General Inquiry: brandsubscriber x dsfdasfdsf','general-inquiry-brandsubscriber-x-dsfdasfdsf-5VS3B','invite','paid','digital','no','influencer',4,NULL,NULL,NULL,0.00000000,NULL,NULL,NULL,'{\"required_influencer\":1,\"gender\":[\"male\",\"female\",\"other\"]}',0.00000000,'2026-02-23','2036-02-23',NULL,NULL,1,'2026-02-23 17:39:30','2026-02-23 17:39:30'),(44,1,'General Inquiry: kjhhfdsfdsf x influencerexample','general-inquiry-kjhhfdsfdsf-x-influencerexample-XH3PD','invite','paid','digital','no','influencer',4,NULL,NULL,NULL,0.00000000,NULL,NULL,NULL,'{\"required_influencer\":1,\"gender\":[\"male\",\"female\",\"other\"]}',0.00000000,'2026-02-23','2036-02-23',NULL,NULL,1,'2026-02-23 22:43:08','2026-02-23 22:43:08');
/*!40000 ALTER TABLE `campaigns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) DEFAULT NULL,
  `slug` varchar(40) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Health & Wellness','health-wellness',1,'6998d3ebf032a.jpg','2026-02-19 02:13:25','2026-02-20 21:36:44'),(2,'Fitness','fitness',1,'6998d3bea182f.jpg','2026-02-19 02:13:38','2026-02-20 21:35:58'),(3,'Tech & Finance','tech-finance',1,'6998d3be4bf10.jpg','2026-02-19 02:13:59','2026-02-20 21:35:58'),(4,'Beauty & Skincare','beauty-skincare',1,'6998d3bde9d97.jpg','2026-02-19 02:14:14','2026-02-20 21:35:58'),(5,'Parenting & Baby','parenting-baby',1,'6998d3ec2e415.jpg','2026-02-19 02:14:29','2026-02-20 21:36:44'),(6,'Travel','travel',1,'6998d3bec9b92.jpg','2026-02-19 02:14:41','2026-02-20 21:35:58'),(7,'Fashion','fashion',1,'6998d3bd7cde2.jpg','2026-02-19 02:15:20','2026-02-20 21:35:57'),(8,'Food & Drink','food-drink',1,'6998d3beefcac.jpg','2026-02-19 02:15:29','2026-02-20 21:35:59');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deposits`
--

DROP TABLE IF EXISTS `deposits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `deposits` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT 0,
  `method_code` int(10) unsigned NOT NULL DEFAULT 0,
  `amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `method_currency` varchar(40) DEFAULT NULL,
  `charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `rate` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `final_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `detail` text DEFAULT NULL,
  `btc_amount` varchar(255) DEFAULT NULL,
  `btc_wallet` varchar(255) DEFAULT NULL,
  `trx` varchar(40) DEFAULT NULL,
  `payment_try` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=>success, 2=>pending, 3=>cancel',
  `from_api` tinyint(1) NOT NULL DEFAULT 0,
  `admin_feedback` varchar(255) DEFAULT NULL,
  `success_url` varchar(255) DEFAULT NULL,
  `failed_url` varchar(255) DEFAULT NULL,
  `last_cron` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `success_action` varchar(255) DEFAULT NULL,
  `success_action_data` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deposits`
--

LOCK TABLES `deposits` WRITE;
/*!40000 ALTER TABLE `deposits` DISABLE KEYS */;
/*!40000 ALTER TABLE `deposits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `device_tokens`
--

DROP TABLE IF EXISTS `device_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `device_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT 0,
  `influencer_id` int(10) unsigned NOT NULL DEFAULT 0,
  `is_app` tinyint(1) NOT NULL DEFAULT 0,
  `token` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `device_tokens`
--

LOCK TABLES `device_tokens` WRITE;
/*!40000 ALTER TABLE `device_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `device_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `extensions`
--

DROP TABLE IF EXISTS `extensions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `extensions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `act` varchar(40) DEFAULT NULL,
  `name` varchar(40) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `script` text DEFAULT NULL,
  `shortcode` text DEFAULT NULL COMMENT 'object',
  `support` text DEFAULT NULL COMMENT 'help section',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=>enable, 2=>disable',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `extensions`
--

LOCK TABLES `extensions` WRITE;
/*!40000 ALTER TABLE `extensions` DISABLE KEYS */;
INSERT INTO `extensions` VALUES (1,'tawk-chat','Tawk.to','Key location is shown bellow','tawky_big.png','<script>\r\n                        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();\r\n                        (function(){\r\n                        var s1=document.createElement(\"script\"),s0=document.getElementsByTagName(\"script\")[0];\r\n                        s1.async=true;\r\n                        s1.src=\"https://embed.tawk.to/{{app_key}}\";\r\n                        s1.charset=\"UTF-8\";\r\n                        s1.setAttribute(\"crossorigin\",\"*\");\r\n                        s0.parentNode.insertBefore(s1,s0);\r\n                        })();\r\n                    </script>','{\"app_key\":{\"title\":\"App Key\",\"value\":\"------\"}}','twak.png',0,'2019-10-18 11:16:05','2024-05-16 06:23:02'),(2,'google-recaptcha2','Google Recaptcha 2','Key location is shown bellow','recaptcha3.png','\n<script src=\"https://www.google.com/recaptcha/api.js\"></script>\n<div class=\"g-recaptcha\" data-sitekey=\"{{site_key}}\" data-callback=\"verifyCaptcha\"></div>\n<div id=\"g-recaptcha-error\"></div>','{\"site_key\":{\"title\":\"Site Key\",\"value\":\"6LdPC88fAAAAADQlUf_DV6Hrvgm-pZuLJFSLDOWV\"},\"secret_key\":{\"title\":\"Secret Key\",\"value\":\"6LdPC88fAAAAAG5SVaRYDnV2NpCrptLg2XLYKRKB\"}}','recaptcha.png',0,'2019-10-18 11:16:05','2024-10-09 00:45:38'),(3,'custom-captcha','Custom Captcha','Just put any random string','customcaptcha.png',NULL,'{\"random_key\":{\"title\":\"Random String\",\"value\":\"SecureString\"}}','na',0,'2019-10-18 11:16:05','2024-10-01 07:15:51'),(4,'google-analytics','Google Analytics','Key location is shown bellow','google_analytics.png','<script async src=\"https://www.googletagmanager.com/gtag/js?id={{measurement_id}}\"></script>\n                <script>\n                  window.dataLayer = window.dataLayer || [];\n                  function gtag(){dataLayer.push(arguments);}\n                  gtag(\"js\", new Date());\n                \n                  gtag(\"config\", \"{{measurement_id}}\");\n                </script>','{\"measurement_id\":{\"title\":\"Measurement ID\",\"value\":\"------\"}}','ganalytics.png',0,NULL,'2021-05-03 22:19:12'),(5,'fb-comment','Facebook Comment ','Key location is shown bellow','Facebook.png','<div id=\"fb-root\"></div><script async defer crossorigin=\"anonymous\" src=\"https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v4.0&appId={{app_key}}&autoLogAppEvents=1\"></script>','{\"app_key\":{\"title\":\"App Key\",\"value\":\"----\"}}','fb_com.png',0,NULL,'2022-03-21 17:18:36');
/*!40000 ALTER TABLE `extensions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `favorites`
--

DROP TABLE IF EXISTS `favorites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `favorites` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT 0,
  `influencer_id` int(10) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favorites`
--

LOCK TABLES `favorites` WRITE;
/*!40000 ALTER TABLE `favorites` DISABLE KEYS */;
INSERT INTO `favorites` VALUES (1,3,7,'2026-02-20 23:55:50','2026-02-20 23:55:50'),(2,5,7,'2026-02-23 16:13:09','2026-02-23 16:13:09');
/*!40000 ALTER TABLE `favorites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forms`
--

DROP TABLE IF EXISTS `forms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `forms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `act` varchar(40) DEFAULT NULL,
  `form_data` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forms`
--

LOCK TABLES `forms` WRITE;
/*!40000 ALTER TABLE `forms` DISABLE KEYS */;
/*!40000 ALTER TABLE `forms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `frontends`
--

DROP TABLE IF EXISTS `frontends`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `frontends` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `data_keys` varchar(40) DEFAULT NULL,
  `data_values` longtext DEFAULT NULL,
  `seo_content` longtext DEFAULT NULL,
  `tempname` varchar(40) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=129 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `frontends`
--

LOCK TABLES `frontends` WRITE;
/*!40000 ALTER TABLE `frontends` DISABLE KEYS */;
INSERT INTO `frontends` VALUES (1,'seo.data','{\"seo_image\":\"1\",\"keywords\":[\"collab\",\"campaign\",\"influencer\",\"marketing\",\"brand\"],\"description\":\"Discover a powerful solution for brands and influencers with CollabStar, your go-to platform for managing influencer marketing campaigns effortlessly. Whether you\'re a brand looking to increase visibility or an influencer aiming to connect with top-tier campaigns, CollabStar offers the tools and features to streamline your process.\",\"social_title\":\"CollabStar - Influencer Marketing Platform\",\"social_description\":\"Discover a powerful solution for brands and influencers with CollabStar, your go-to platform for managing influencer marketing campaigns effortlessly. Whether you\'re a brand looking to increase visibility or an influencer aiming to connect with top-tier campaigns, CollabStar offers the tools and features to streamline your process.\",\"image\":\"66fbe0ed487741727783149.png\"}',NULL,NULL,'','2020-07-04 23:42:52','2024-10-01 05:48:40'),(25,'blog.content','{\"heading\":\"Latest Blog Post\"}',NULL,'basic','','2020-10-28 00:51:34','2024-09-01 00:06:24'),(27,'contact_us.content','{\"has_image\":\"1\",\"heading\":\"Get in Touch\",\"short_description\":\"Use the form below to contact us or email us at hello@influenced.co.nz\",\"email_address\":\"hello@influenced.co.nz\",\"contact_details\":\"28 Royal Mesa, New York\",\"contact_number\":\"+99-0022-0033\",\"map_link\":\"https:\\/\\/www.google.com\\/maps\\/embed?pb=!1m18!1m12!1m3!1d2310.886823714306!2d-1.2899147229705012!3d54.60598637973359!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x487e8d57705b779d%3A0x5b163d0825b7670a!2sCode%20Canyon!5e0!3m2!1sen!2sbd!4v1707634430732!5m2!1sen!2sbd\",\"image\":\"67051af6220c71728387830.png\"}',NULL,'basic','','2020-10-28 00:59:19','2026-02-22 20:59:10'),(28,'counter.content','{\"heading\":\"Latest News\",\"subheading\":\"Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloribus necessitatibus repudiandae porro reprehenderit, beatae perferendis repellat quo ipsa omnis, vitae!\"}',NULL,'basic',NULL,'2020-10-28 01:04:02','2024-03-13 23:54:07'),(31,'social_icon.element','{\"social_icon\":\"<i class=\\\"fab fa-facebook\\\"><\\/i>\",\"url\":\"https:\\/\\/www.facebook.com\\/\"}',NULL,'basic','','2020-11-12 04:07:30','2024-09-01 04:21:39'),(33,'feature.content','{\"has_image\":\"1\",\"heading\":\"New Zealand & Australia\'s Premiere Influencer Network\",\"image\":\"66d31084dcf831725108356.png\"}',NULL,'basic','','2021-01-03 23:40:54','2026-02-20 21:18:42'),(34,'feature.element','{\"has_image\":\"1\",\"title\":\"Money Back Guarantee\",\"description\":\"Funds are verified before a service is purchased and released when a job is completed.\",\"image\":\"66d3109d810cd1725108381.png\"}',NULL,'basic','','2021-01-03 23:41:02','2026-02-20 21:24:21'),(41,'cookie.data','{\"short_desc\":\"We may use cookies or any other tracking technologies when you visit our website, including any other media form, mobile website, or mobile application related or connected to help customize the Site and improve your experience.\",\"description\":\"<div class=\\\"mb-5\\\">\\r\\n    <h4 class=\\\"mb-2\\\">Cookie Policy<\\/h4>\\r\\n\\r\\n<p>This Cookie Policy explains how to use cookies and similar technologies to recognize you when you visit our website. It explains what these technologies are and why we use them, as well as your rights to control our use of them.<\\/p>\\r\\n\\r\\n<\\/div>\\r\\n\\r\\n<div class=\\\"mb-5\\\">\\r\\n    <h4 class=\\\"mb-2\\\">What are cookies?<\\/h4>\\r\\n\\r\\n<p>Cookies are small pieces of data stored on your computer or mobile device when you visit a website. Cookies are widely used by website owners to make their websites work, or to work more efficiently, as well as to provide reporting information.<\\/p>\\r\\n\\r\\n<\\/div>\\r\\n\\r\\n<div class=\\\"mb-5\\\">\\r\\n    <h4 class=\\\"mb-2\\\">Why do we use cookies?<\\/h4>\\r\\n\\r\\n<p>We use cookies for several reasons. Some cookies are required for technical reasons for our Website to operate, and we refer to these as \\\"essential\\\" or \\\"strictly necessary\\\" cookies. Other cookies enable us to track and target the interests of our users to enhance the experience on our Website. Third parties serve cookies through our Website for advertising, analytics, and other purposes.<\\/p>\\r\\n\\r\\n<\\/div>\\r\\n\\r\\n<div class=\\\"mb-5\\\">\\r\\n    <h4 class=\\\"mb-2\\\">What types of cookies do we use?<\\/h4>\\r\\n\\r\\n<div>\\r\\n    <ul style=\\\"list-style: unset;\\\">\\r\\n        <li>\\r\\n            <strong>Essential Website Cookies:<\\/strong> \\r\\n            These cookies are strictly necessary to provide you with services available through our Website and to use some of its features.\\r\\n        <\\/li>\\r\\n        <li>\\r\\n            <strong>Analytics and Performance Cookies:<\\/strong> \\r\\n            These cookies allow us to count visits and traffic sources to measure and improve our Website\'s performance.\\r\\n        <\\/li>\\r\\n        <li>\\r\\n            <strong>Advertising Cookies:<\\/strong> \\r\\n            These cookies make advertising messages more relevant to you and your interests. They perform functions like preventing the same ad from continuously reappearing, ensuring that ads are properly displayed, and in some cases selecting advertisements that are based on your interests.\\r\\n        <\\/li>\\r\\n    <\\/ul>\\r\\n<\\/div>\\r\\n<\\/div>\\r\\n\\r\\n<div class=\\\"mb-5\\\">\\r\\n    <h4 class=\\\"mb-2\\\">Data Collected by Cookies<\\/h4>\\r\\n<p>Cookies may collect various types of data, including but not limited to:<\\/p>\\r\\n<ul style=\\\"list-style: unset;\\\">\\r\\n    <li>IP addresses<\\/li>\\r\\n    <li>Browser and device information<\\/li>\\r\\n    <li>Referring website addresses<\\/li>\\r\\n    <li>Pages visited on our website<\\/li>\\r\\n    <li>Interactions with our website, such as clicks and mouse movements<\\/li>\\r\\n    <li>Time spent on our website<\\/li>\\r\\n<\\/ul>\\r\\n\\r\\n<\\/div>\\r\\n\\r\\n<div class=\\\"mb-5\\\">\\r\\n    <h4 class=\\\"mb-2\\\">How We Use Collected Data<\\/h4>\\r\\n\\r\\n<p>We may use data collected by cookies for the following purposes:<\\/p>\\r\\n<ul style=\\\"list-style: unset;\\\">\\r\\n    <li>To personalize your experience on our website<\\/li>\\r\\n    <li>To improve our website\'s functionality and performance<\\/li>\\r\\n    <li>To analyze trends and gather demographic information about our user base<\\/li>\\r\\n    <li>To deliver targeted advertising based on your interests<\\/li>\\r\\n    <li>To prevent fraudulent activity and enhance website security<\\/li>\\r\\n<\\/ul>\\r\\n<\\/div>\\r\\n\\r\\n<div class=\\\"mb-5\\\">\\r\\n    <h4 class=\\\"mb-2\\\">Third-party cookies<\\/h4>\\r\\n\\r\\n<p>In addition to our cookies, we may also use various third-party cookies to report usage statistics of our Website, deliver advertisements on and through our Website, and so on.<\\/p>\\r\\n\\r\\n<\\/div>\\r\\n\\r\\n\\r\\n<div class=\\\"mb-5\\\">\\r\\n    <h4 class=\\\"mb-2\\\">How can we control cookies?<\\/h4>\\r\\n\\r\\n<p>You have the right to decide whether to accept or reject cookies. You can exercise your cookie preferences by clicking on the \\\"Cookie Settings\\\" link in the footer of our website. You can also set or amend your web browser controls to accept or refuse cookies. If you choose to reject cookies, you may still use our Website though your access to some functionality and areas of our Website may be restricted.<\\/p>\\r\\n\\r\\n<\\/div>\\r\\n\\r\\n<div>\\r\\n    <h4 class=\\\"mb-2\\\">Changes to our Cookie Policy<\\/h4>\\r\\n\\r\\n<p>We may update our Cookie Policy from time to time. We will notify you of any changes by posting the new Cookie Policy on this page.<\\/p>\\r\\n<\\/div>\",\"status\":1}',NULL,NULL,NULL,'2020-07-04 23:42:52','2024-09-29 00:45:47'),(42,'policy_pages.element','{\"title\":\"Privacy Policy\",\"details\":\"<div class=\\\"mb-5\\\">\\r\\n    <h4 class=\\\"mb-2\\\">Introduction<\\/h4>\\r\\n        <p>\\r\\n            This Privacy Policy describes how we collects, uses, and discloses information, including personal information, in connection with your use of our website.\\r\\n        <\\/p>\\r\\n<\\/div>\\r\\n     \\r\\n        \\r\\n        <div class=\\\"mb-5\\\">\\r\\n            <h4 class=\\\"mb-2\\\">Information We Collect<\\/h4>\\r\\n        <p>We collect two main types of information on the Website:<\\/p>\\r\\n        <ul>\\r\\n            <li><p><strong>Personal Information: <\\/strong>This includes data that can identify you as an individual, such as your name, email address, phone number, or mailing address. We only collect this information when you voluntarily provide it to us, like signing up for a newsletter, contacting us through a form, or making a purchase.<\\/p><\\/li>\\r\\n            <li><p><strong>Non-Personal Information: <\\/strong>This data cannot be used to identify you directly. It includes details like your browser type, device type, operating system, IP address, browsing activity, and usage statistics. We collect this information automatically through cookies and other tracking technologies.<\\/p><\\/li>\\r\\n        <\\/ul>\\r\\n        <\\/div>\\r\\n     \\r\\n        \\r\\n        <div class=\\\"mb-5\\\">\\r\\n            <h4 class=\\\"mb-2\\\">How We Use Information<\\/h4>\\r\\n        <p>The information we collect allows us to:<\\/p>\\r\\n        <ul>\\r\\n            <li>Operate and maintain the Website effectively.<\\/li>\\r\\n            <li>Send you newsletters or marketing communications, but only with your consent.<\\/li>\\r\\n            <li>Respond to your inquiries and fulfill your requests.<\\/li>\\r\\n            <li>Improve the Website and your user experience.<\\/li>\\r\\n            <li>Personalize your experience on the Website based on your browsing habits.<\\/li>\\r\\n            <li>Analyze how the Website is used to improve our services.<\\/li>\\r\\n            <li>Comply with legal and regulatory requirements.<\\/li>\\r\\n        <\\/ul>\\r\\n     \\r\\n        <\\/div>\\r\\n        \\r\\n       <div class=\\\"mb-5\\\">\\r\\n        <h4 class=\\\"mb-2\\\">Sharing of Information<\\/h4>\\r\\n        <p>We may share your information with trusted third-party service providers who assist us in operating the Website and delivering our services. These providers are obligated by contract to keep your information confidential and use it only for the specific purposes we disclose it for.<\\/p>\\r\\n        <p>We will never share your personal information with any third parties for marketing purposes without your explicit consent.<\\/p>\\r\\n     \\r\\n       <\\/div>\\r\\n        \\r\\n        <div class=\\\"mb-5\\\">\\r\\n            <h4 class=\\\"mb-2\\\">Data Retention<\\/h4>\\r\\n        <p>We retain your personal information only for as long as necessary to fulfill the purposes it was collected for. We may retain it for longer periods only if required or permitted by law.<\\/p>\\r\\n     \\r\\n        <\\/div>\\r\\n        \\r\\n        <div class=\\\"mb-5\\\">\\r\\n            <h4 class=\\\"mb-2\\\">Security Measures<\\/h4>\\r\\n        <p>We take reasonable precautions to protect your information from unauthorized access, disclosure, alteration, or destruction. However, complete security cannot be guaranteed for any website or internet transmission.<\\/p>\\r\\n     \\r\\n        <\\/div>\\r\\n        \\r\\n<div>\\r\\n    <h4 class=\\\"mb-2\\\">Changes to this Privacy Policy<\\/h4>\\r\\n    <p>We may update this Privacy Policy periodically. We will notify you of any changes by posting the revised policy on the Website. We recommend reviewing this policy regularly to stay informed of any updates.<\\/p>\\r\\n    <p><strong>Remember:<\\/strong>  This is a sample policy and may need adjustments to comply with specific laws and reflect your website\'s unique data practices. Consider consulting with a legal professional to ensure your policy is fully compliant.<\\/p>\\r\\n<\\/div>\"}',NULL,'basic','privacy-policy','2021-06-09 08:50:42','2024-09-29 00:47:44'),(43,'policy_pages.element','{\"title\":\"Terms of Service\",\"details\":\"<div class=\\\"mb-5\\\">\\r\\n    <h4 class=\\\"mb-2\\\">Introduction<\\/h4>\\r\\n        <p>\\r\\n            This Privacy Policy describes how we collects, uses, and discloses information, including personal information, in connection with your use of our website.\\r\\n        <\\/p>\\r\\n<\\/div>\\r\\n     \\r\\n        \\r\\n        <div class=\\\"mb-5\\\">\\r\\n            <h4 class=\\\"mb-2\\\">Information We Collect<\\/h4>\\r\\n        <p>We collect two main types of information on the Website:<\\/p>\\r\\n        <ul>\\r\\n            <li><p><strong>Personal Information: <\\/strong>This includes data that can identify you as an individual, such as your name, email address, phone number, or mailing address. We only collect this information when you voluntarily provide it to us, like signing up for a newsletter, contacting us through a form, or making a purchase.<\\/p><\\/li>\\r\\n            <li><p><strong>Non-Personal Information: <\\/strong>This data cannot be used to identify you directly. It includes details like your browser type, device type, operating system, IP address, browsing activity, and usage statistics. We collect this information automatically through cookies and other tracking technologies.<\\/p><\\/li>\\r\\n        <\\/ul>\\r\\n        <\\/div>\\r\\n     \\r\\n        \\r\\n        <div class=\\\"mb-5\\\">\\r\\n            <h4 class=\\\"mb-2\\\">How We Use Information<\\/h4>\\r\\n        <p>The information we collect allows us to:<\\/p>\\r\\n        <ul>\\r\\n            <li>Operate and maintain the Website effectively.<\\/li>\\r\\n            <li>Send you newsletters or marketing communications, but only with your consent.<\\/li>\\r\\n            <li>Respond to your inquiries and fulfill your requests.<\\/li>\\r\\n            <li>Improve the Website and your user experience.<\\/li>\\r\\n            <li>Personalize your experience on the Website based on your browsing habits.<\\/li>\\r\\n            <li>Analyze how the Website is used to improve our services.<\\/li>\\r\\n            <li>Comply with legal and regulatory requirements.<\\/li>\\r\\n        <\\/ul>\\r\\n     \\r\\n        <\\/div>\\r\\n        \\r\\n       <div class=\\\"mb-5\\\">\\r\\n        <h4 class=\\\"mb-2\\\">Sharing of Information<\\/h4>\\r\\n        <p>We may share your information with trusted third-party service providers who assist us in operating the Website and delivering our services. These providers are obligated by contract to keep your information confidential and use it only for the specific purposes we disclose it for.<\\/p>\\r\\n        <p>We will never share your personal information with any third parties for marketing purposes without your explicit consent.<\\/p>\\r\\n     \\r\\n       <\\/div>\\r\\n        \\r\\n        <div class=\\\"mb-5\\\">\\r\\n            <h4 class=\\\"mb-2\\\">Data Retention<\\/h4>\\r\\n        <p>We retain your personal information only for as long as necessary to fulfill the purposes it was collected for. We may retain it for longer periods only if required or permitted by law.<\\/p>\\r\\n     \\r\\n        <\\/div>\\r\\n        \\r\\n        <div class=\\\"mb-5\\\">\\r\\n            <h4 class=\\\"mb-2\\\">Security Measures<\\/h4>\\r\\n        <p>We take reasonable precautions to protect your information from unauthorized access, disclosure, alteration, or destruction. However, complete security cannot be guaranteed for any website or internet transmission.<\\/p>\\r\\n     \\r\\n        <\\/div>\\r\\n        \\r\\n<div>\\r\\n    <h4 class=\\\"mb-2\\\">Changes to this Privacy Policy<\\/h4>\\r\\n    <p>We may update this Privacy Policy periodically. We will notify you of any changes by posting the revised policy on the Website. We recommend reviewing this policy regularly to stay informed of any updates.<\\/p>\\r\\n    <p><strong>Remember:<\\/strong>  This is a sample policy and may need adjustments to comply with specific laws and reflect your website\'s unique data practices. Consider consulting with a legal professional to ensure your policy is fully compliant.<\\/p>\\r\\n<\\/div>\"}',NULL,'basic','terms-of-service','2021-06-09 08:51:18','2024-09-29 00:47:53'),(44,'maintenance.data','{\"description\":\"<div><h3 class=\\\"mb-3\\\" style=\\\"text-align: center; \\\">THE SITE IS UNDER MAINTENANCE<\\/h3><p style=\\\"text-align: center; \\\">We\'re just tuning up a few things.We apologize for the inconvenience but Front is currently undergoing planned maintenance. Thanks for your patience.<\\/p><\\/div>\",\"image\":\"6603c203472ad1711522307.png\"}',NULL,NULL,NULL,'2020-07-04 23:42:52','2024-10-01 05:58:55'),(52,'blog.element','{\"has_image\":[\"1\"],\"title\":\"Morbi ac felis. In ut quam vitae odio lacinia tincidunt.\",\"description\":\"<h6 class=\\\"m-0\\\">The Reactive Model of Service Centers: Addressing Issues After They Arise<\\/h6>\\r\\n<div>The landscape of service center automation has undergone a remarkable transformation over the past few decades,\\r\\n    shifting from reactive to proactive approaches. Initially, service centers operated on a reactive model, primarily\\r\\n    addressing issues only after they arose. This method often involved responding to customer complaints and\\r\\n    troubleshooting problems as they emerged, leading to higher levels of downtime and customer dissatisfaction. The\\r\\n    focus was largely on fixing problems rather than preventing them, which created a cycle of continuous reaction to\\r\\n    service issues.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<blockquote style=\\\"font-style:italic;text-align:center;padding:20px;background:#ffeaef;font-weight:500;font-size:18px;border-left:4px solid #df3459;\\\">\\r\\n    Aenean metus lectus at id. Morbi aliquet commodo a sodales eget. Eu justo ante nibh et a turpis, aliquam phasellus\\r\\n    hymenaeos, imperdiet eget cras sociosqu, tincidunt a amet. Faucibus urna luctus, arcu ni<\\/blockquote>\\r\\n<h6 class=\\\"m-0\\\">Shifting Paradigms: The Move Toward Proactive Service Models<\\/h6>\\r\\n<div>As technology advanced, the paradigm began to shift towards a more proactive approach. The rise of advanced data\\r\\n    analytics and machine learning techniques enabled service centers to anticipate potential issues before they\\r\\n    occurred. By analyzing historical data and recognizing patterns, service centers could now predict when equipment\\r\\n    might fail or when a system could encounter problems. This shift not only reduced the frequency of unexpected\\r\\n    disruptions but also improved overall operational efficiency. Predictive maintenance became a key feature of\\r\\n    proactive service centers, allowing them to schedule maintenance activities during non-peak hours and address issues\\r\\n    before they impacted the customer experience.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">Harnessing Data Analytics and Machine Learning for Predictive Maintenance<\\/h6>\\r\\n<div>This evolution was further accelerated by the integration of artificial intelligence (AI) and automation tools.\\r\\n    AI-driven systems can now monitor and analyze real-time data from various sources, providing insights into potential\\r\\n    issues and suggesting preventive measures. Automation tools facilitate swift responses to identified issues, often\\r\\n    without the need for human intervention. For instance, automated systems can initiate repairs or adjustments based\\r\\n    on predefined parameters, ensuring that minor issues are resolved before they escalate into significant problems.\\r\\n<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">The Role of AI and Automation in Revolutionizing Service Center Operations<\\/h6>\\r\\n<div>The proactive approach not only enhances operational efficiency but also fosters a more positive customer\\r\\n    experience. By addressing potential issues before they impact customers, service centers can ensure a higher level\\r\\n    of service continuity and reliability. Customers benefit from fewer disruptions and a more streamlined experience,\\r\\n    leading to increased satisfaction and loyalty.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">Enhancing Customer Experience Through Proactive Service Strategies<\\/h6>\\r\\n<div>In essence, the evolution from a reactive to a proactive model in service center automation represents a\\r\\n    significant leap forward. It highlights the importance of leveraging advanced technologies to not only address\\r\\n    problems but to anticipate and prevent them, ultimately leading to a more efficient and customer-centric operation.\\r\\n    As technology continues to evolve, service centers will likely see even more sophisticated solutions that further\\r\\n    enhance their ability to provide seamless and proactive service.<\\/div>\",\"image\":\"66d4049155b171725170833.png\"}',NULL,'basic','morbi-ac-felis-in-ut-quam-vitae-odio-lacinia-tincidunt','2024-03-23 06:52:04','2024-10-01 06:03:10'),(55,'counter.content','{\"heading\":\"Latest Newsss\",\"subheading\":\"Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloribus necessitatibus repudiandae porro reprehenderit, beatae perferendis repellat quo ipsa omnis, vitae!\"}',NULL,'basic','','2024-04-21 01:13:50','2024-04-21 01:13:50'),(56,'counter.content','{\"heading\":\"Latest News\",\"subheading\":\"Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloribus necessitatibus repudiandae porro reprehenderit, beatae perferendis repellat quo ipsa omnis, vitae!\"}',NULL,'basic','','2024-04-21 01:13:52','2024-04-21 01:13:52'),(62,'blog.content','{\"heading\":\"Latest News\",\"subheading\":\"------\"}',NULL,'basic','','2024-04-30 07:31:30','2024-04-30 07:31:30'),(64,'banner.content','{\"has_image\":\"1\",\"heading\":\"New Zealand\'s Only Influencer Platform\",\"subheading\":\"Join a thriving community, connect with top brands, and take your influence to new heights\",\"button_name\":\"Get Started\",\"button_url\":\"influencer\\/register\",\"image\":\"66d303643904f1725104996.png\"}',NULL,'basic','','2024-05-01 00:06:45','2026-02-20 21:06:43'),(65,'faq.element','{\"question\":\"What is an Influencer Marketing Platform?\",\"answer\":\"An Influencer Marketing Platform is a digital tool or service that connects brands with influencers, facilitating collaboration, content creation, and marketing campaigns.\"}',NULL,'basic','','2024-05-04 00:21:20','2024-09-01 03:06:10'),(67,'partner.element','{\"has_image\":\"1\",\"image\":\"66f8fb21f38341727593249.png\"}',NULL,'basic','','2024-08-31 04:58:36','2024-09-29 01:00:50'),(68,'partner.element','{\"has_image\":\"1\",\"image\":\"66f8fb1c032951727593244.png\"}',NULL,'basic','','2024-08-31 04:59:24','2024-09-29 01:00:44'),(69,'partner.element','{\"has_image\":\"1\",\"image\":\"66f8fb16751881727593238.png\"}',NULL,'basic','','2024-08-31 04:59:29','2024-09-29 01:00:38'),(70,'partner.element','{\"has_image\":\"1\",\"image\":\"66f8fb11816251727593233.png\"}',NULL,'basic','','2024-08-31 04:59:35','2024-09-29 01:00:33'),(71,'partner.element','{\"has_image\":\"1\",\"image\":\"66f8fb0ccbe7f1727593228.png\"}',NULL,'basic','','2024-08-31 04:59:41','2024-09-29 01:00:28'),(72,'partner.element','{\"has_image\":\"1\",\"image\":\"66f8fb0759e221727593223.png\"}',NULL,'basic','','2024-08-31 04:59:47','2024-09-29 01:00:23'),(73,'partner.element','{\"has_image\":\"1\",\"image\":\"66f8fb02322f11727593218.png\"}',NULL,'basic','','2024-08-31 04:59:52','2024-09-29 01:00:18'),(74,'category.content','{\"heading\":\"Top Categories\"}',NULL,'basic','','2024-08-31 05:56:48','2026-02-20 21:07:23'),(75,'top_influencer.content','{\"heading\":\"Our Top Influencers\"}',NULL,'basic','','2024-08-31 06:15:37','2024-08-31 06:15:37'),(76,'how_work.content','{\"heading\":\"How does Influenced work?\",\"button_name\":\"Register Today\",\"button_url\":\"\\/brand\\/register\"}',NULL,'basic','','2024-08-31 06:21:58','2026-02-20 21:15:13'),(80,'how_work.element','{\"has_image\":\"1\",\"heading\":\"Create Campaigns\",\"subheading\":\"Let influencers come to you who meet your requirements\",\"image\":\"66d30badb8d681725107117.png\"}',NULL,'basic','','2024-08-31 06:25:17','2026-02-20 21:14:55'),(81,'how_work.element','{\"has_image\":\"1\",\"heading\":\"Connect with Influencers\",\"subheading\":\"Buy services directly in the app or create custom packages\",\"image\":\"66d30bc1df01e1725107137.png\"}',NULL,'basic','','2024-08-31 06:25:37','2026-02-20 21:15:49'),(82,'how_work.element','{\"has_image\":\"1\",\"heading\":\"Create Account\",\"subheading\":\"Influencers and brands create a profile\",\"image\":\"66d30be313c431725107171.png\"}',NULL,'basic','','2024-08-31 06:26:11','2026-02-20 21:12:08'),(83,'feature.element','{\"has_image\":\"1\",\"title\":\"User Generated Content\",\"description\":\"Generate buzz using powerful social media marketing.\",\"image\":\"66d310b2d4f781725108402.png\"}',NULL,'basic','','2024-08-31 06:46:42','2026-02-20 21:23:17'),(84,'feature.element','{\"has_image\":\"1\",\"title\":\"Top Rated Influencers\",\"description\":\"Creators work across a range of categories and geographic locations.\",\"image\":\"66d310c6569371725108422.png\"}',NULL,'basic','','2024-08-31 06:47:02','2026-02-20 21:22:33'),(85,'feature.element','{\"has_image\":\"1\",\"title\":\"Verified Analytics\",\"description\":\"Influencers with a verified badge have audience insights and follower counts directly from the platform.\",\"image\":\"66d310e0473791725108448.png\"}',NULL,'basic','','2024-08-31 06:47:28','2026-02-20 21:21:55'),(86,'feature.element','{\"has_image\":\"1\",\"title\":\"Simple Payments\",\"description\":\"Top up your wallet to pay in app.\",\"image\":\"66d310f69f9ec1725108470.png\"}',NULL,'basic','','2024-08-31 06:47:50','2026-02-20 21:24:51'),(87,'feature.element','{\"has_image\":\"1\",\"title\":\"Local\",\"description\":\"Influencers are based in ANZ and you can search by region and state.\",\"image\":\"66d311138b5aa1725108499.png\"}',NULL,'basic','','2024-08-31 06:48:19','2026-02-20 21:19:32'),(88,'counter.element','{\"title\":\"Categories\",\"counter_digit\":\"15\",\"counter_symbol\":\"+\"}',NULL,'basic','','2024-08-31 07:00:02','2024-08-31 07:00:02'),(89,'counter.element','{\"title\":\"Job Completed\",\"counter_digit\":\"3000\",\"counter_symbol\":\"+\"}',NULL,'basic','','2024-08-31 07:00:23','2024-08-31 07:00:23'),(90,'counter.element','{\"title\":\"Total Client\",\"counter_digit\":\"100\",\"counter_symbol\":\"k\"}',NULL,'basic','','2024-08-31 07:00:34','2024-08-31 07:00:34'),(91,'counter.element','{\"title\":\"Influencers\",\"counter_digit\":\"130\",\"counter_symbol\":\"k\"}',NULL,'basic','','2024-08-31 07:00:49','2024-08-31 07:00:49'),(92,'testimonial.content','{\"heading\":\"What Brands are Saying\"}',NULL,'basic','','2024-08-31 07:48:10','2026-02-22 20:54:09'),(93,'testimonial.element','{\"has_image\":[\"1\"],\"quote\":\"We relied on infulab for influencer partnerships, and it exceeded our expectations. The platform\'s user-friendly interface, insightful data, and efficient collaboration tools helped us achieve remarkable results. A must-have for any advertiser!\",\"name\":\"Quentin Edwards\",\"designation\":\"UI\\/UX Designer\",\"image\":\"66d31f32d7ec41725112114.png\"}',NULL,'basic','','2024-08-31 07:48:34','2024-08-31 07:48:34'),(94,'testimonial.element','{\"has_image\":[\"1\"],\"quote\":\"Infulab revolutionized our approach to influencer marketing. With its comprehensive profiles and streamlined communication, we found influencers aligned with our brand seamlessly. It\'s a game-changer in the industry, highly recommended.\",\"name\":\"Maia Bridges\",\"designation\":\"System Engineer\",\"image\":\"66d31f4f00d521725112143.png\"}',NULL,'basic','','2024-08-31 07:49:02','2024-08-31 07:49:03'),(95,'testimonial.element','{\"has_image\":[\"1\"],\"quote\":\"Thanks to infulab, influencer collaboration became effortless. The platform\'s intuitive interface, rich analytics, and seamless negotiation tools ensured we partnered with influencers who truly resonate with our audience. Exceptional service!\\\"\",\"name\":\"Manix Hanson\",\"designation\":\"Web Developer\",\"image\":\"66d31f627534a1725112162.png\"}',NULL,'basic','','2024-08-31 07:49:22','2024-08-31 07:49:22'),(96,'testimonial.element','{\"has_image\":[\"1\"],\"quote\":\"Discovering infulab transformed our influencer marketing strategy. Easy search, detailed insights, and smooth communication empowered us to connect with influencers authentically. It\'s our go-to for impactful campaigns\",\"name\":\"Mark Thompson\",\"designation\":\"Marketing Manager\",\"image\":\"66d31f751c37c1725112181.png\"}',NULL,'basic','','2024-08-31 07:49:41','2024-08-31 07:49:41'),(97,'blog.element','{\"has_image\":[\"1\"],\"title\":\"Morbi mollis tellus ac sapien Phasellus volutpat, metus eget egestas\",\"description\":\"<h6 class=\\\"m-0\\\">The Reactive Model of Service Centers: Addressing Issues After They Arise<\\/h6>\\r\\n<div>The landscape of service center automation has undergone a remarkable transformation over the past few decades,\\r\\n    shifting from reactive to proactive approaches. Initially, service centers operated on a reactive model, primarily\\r\\n    addressing issues only after they arose. This method often involved responding to customer complaints and\\r\\n    troubleshooting problems as they emerged, leading to higher levels of downtime and customer dissatisfaction. The\\r\\n    focus was largely on fixing problems rather than preventing them, which created a cycle of continuous reaction to\\r\\n    service issues.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<blockquote style=\\\"font-style:italic;text-align:center;padding:20px;background:#ffeaef;font-weight:500;font-size:18px;border-left:4px solid #df3459;\\\">\\r\\n    Aenean metus lectus at id. Morbi aliquet commodo a sodales eget. Eu justo ante nibh et a turpis, aliquam phasellus\\r\\n    hymenaeos, imperdiet eget cras sociosqu, tincidunt a amet. Faucibus urna luctus, arcu ni<\\/blockquote>\\r\\n<h6 class=\\\"m-0\\\">Shifting Paradigms: The Move Toward Proactive Service Models<\\/h6>\\r\\n<div>As technology advanced, the paradigm began to shift towards a more proactive approach. The rise of advanced data\\r\\n    analytics and machine learning techniques enabled service centers to anticipate potential issues before they\\r\\n    occurred. By analyzing historical data and recognizing patterns, service centers could now predict when equipment\\r\\n    might fail or when a system could encounter problems. This shift not only reduced the frequency of unexpected\\r\\n    disruptions but also improved overall operational efficiency. Predictive maintenance became a key feature of\\r\\n    proactive service centers, allowing them to schedule maintenance activities during non-peak hours and address issues\\r\\n    before they impacted the customer experience.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">Harnessing Data Analytics and Machine Learning for Predictive Maintenance<\\/h6>\\r\\n<div>This evolution was further accelerated by the integration of artificial intelligence (AI) and automation tools.\\r\\n    AI-driven systems can now monitor and analyze real-time data from various sources, providing insights into potential\\r\\n    issues and suggesting preventive measures. Automation tools facilitate swift responses to identified issues, often\\r\\n    without the need for human intervention. For instance, automated systems can initiate repairs or adjustments based\\r\\n    on predefined parameters, ensuring that minor issues are resolved before they escalate into significant problems.\\r\\n<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">The Role of AI and Automation in Revolutionizing Service Center Operations<\\/h6>\\r\\n<div>The proactive approach not only enhances operational efficiency but also fosters a more positive customer\\r\\n    experience. By addressing potential issues before they impact customers, service centers can ensure a higher level\\r\\n    of service continuity and reliability. Customers benefit from fewer disruptions and a more streamlined experience,\\r\\n    leading to increased satisfaction and loyalty.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">Enhancing Customer Experience Through Proactive Service Strategies<\\/h6>\\r\\n<div>In essence, the evolution from a reactive to a proactive model in service center automation represents a\\r\\n    significant leap forward. It highlights the importance of leveraging advanced technologies to not only address\\r\\n    problems but to anticipate and prevent them, ultimately leading to a more efficient and customer-centric operation.\\r\\n    As technology continues to evolve, service centers will likely see even more sophisticated solutions that further\\r\\n    enhance their ability to provide seamless and proactive service.<\\/div>\",\"image\":\"66d404cdc1d581725170893.png\"}',NULL,'basic','morbi-mollis-tellus-ac-sapien-phasellus-volutpat-metus-eget-egestas','2024-09-24 00:08:13','2024-10-01 06:02:50'),(98,'blog.element','{\"has_image\":[\"1\"],\"title\":\"Etiam sit amet orci eget eros faucibus tincidunt\",\"description\":\"<h6 class=\\\"m-0\\\">The Reactive Model of Service Centers: Addressing Issues After They Arise<\\/h6>\\r\\n<div>The landscape of service center automation has undergone a remarkable transformation over the past few decades,\\r\\n    shifting from reactive to proactive approaches. Initially, service centers operated on a reactive model, primarily\\r\\n    addressing issues only after they arose. This method often involved responding to customer complaints and\\r\\n    troubleshooting problems as they emerged, leading to higher levels of downtime and customer dissatisfaction. The\\r\\n    focus was largely on fixing problems rather than preventing them, which created a cycle of continuous reaction to\\r\\n    service issues.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<blockquote style=\\\"font-style:italic;text-align:center;padding:20px;background:#ffeaef;font-weight:500;font-size:18px;border-left:4px solid #df3459;\\\">\\r\\n    Aenean metus lectus at id. Morbi aliquet commodo a sodales eget. Eu justo ante nibh et a turpis, aliquam phasellus\\r\\n    hymenaeos, imperdiet eget cras sociosqu, tincidunt a amet. Faucibus urna luctus, arcu ni<\\/blockquote>\\r\\n<h6 class=\\\"m-0\\\">Shifting Paradigms: The Move Toward Proactive Service Models<\\/h6>\\r\\n<div>As technology advanced, the paradigm began to shift towards a more proactive approach. The rise of advanced data\\r\\n    analytics and machine learning techniques enabled service centers to anticipate potential issues before they\\r\\n    occurred. By analyzing historical data and recognizing patterns, service centers could now predict when equipment\\r\\n    might fail or when a system could encounter problems. This shift not only reduced the frequency of unexpected\\r\\n    disruptions but also improved overall operational efficiency. Predictive maintenance became a key feature of\\r\\n    proactive service centers, allowing them to schedule maintenance activities during non-peak hours and address issues\\r\\n    before they impacted the customer experience.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">Harnessing Data Analytics and Machine Learning for Predictive Maintenance<\\/h6>\\r\\n<div>This evolution was further accelerated by the integration of artificial intelligence (AI) and automation tools.\\r\\n    AI-driven systems can now monitor and analyze real-time data from various sources, providing insights into potential\\r\\n    issues and suggesting preventive measures. Automation tools facilitate swift responses to identified issues, often\\r\\n    without the need for human intervention. For instance, automated systems can initiate repairs or adjustments based\\r\\n    on predefined parameters, ensuring that minor issues are resolved before they escalate into significant problems.\\r\\n<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">The Role of AI and Automation in Revolutionizing Service Center Operations<\\/h6>\\r\\n<div>The proactive approach not only enhances operational efficiency but also fosters a more positive customer\\r\\n    experience. By addressing potential issues before they impact customers, service centers can ensure a higher level\\r\\n    of service continuity and reliability. Customers benefit from fewer disruptions and a more streamlined experience,\\r\\n    leading to increased satisfaction and loyalty.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">Enhancing Customer Experience Through Proactive Service Strategies<\\/h6>\\r\\n<div>In essence, the evolution from a reactive to a proactive model in service center automation represents a\\r\\n    significant leap forward. It highlights the importance of leveraging advanced technologies to not only address\\r\\n    problems but to anticipate and prevent them, ultimately leading to a more efficient and customer-centric operation.\\r\\n    As technology continues to evolve, service centers will likely see even more sophisticated solutions that further\\r\\n    enhance their ability to provide seamless and proactive service.<\\/div>\",\"image\":\"66d4050bdfe421725170955.png\"}',NULL,'basic','etiam-sit-amet-orci-eget-eros-faucibus-tincidunt','2024-09-25 00:09:15','2024-10-01 06:02:18'),(99,'blog.element','{\"has_image\":[\"1\"],\"title\":\"Quisque rutrum. Pellentesque habitant morbi tristique senectus\",\"description\":\"<h6 class=\\\"m-0\\\">The Reactive Model of Service Centers: Addressing Issues After They Arise<\\/h6>\\r\\n<div>The landscape of service center automation has undergone a remarkable transformation over the past few decades,\\r\\n    shifting from reactive to proactive approaches. Initially, service centers operated on a reactive model, primarily\\r\\n    addressing issues only after they arose. This method often involved responding to customer complaints and\\r\\n    troubleshooting problems as they emerged, leading to higher levels of downtime and customer dissatisfaction. The\\r\\n    focus was largely on fixing problems rather than preventing them, which created a cycle of continuous reaction to\\r\\n    service issues.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<blockquote style=\\\"font-style:italic;text-align:center;padding:20px;background:#ffeaef;font-weight:500;font-size:18px;border-left:4px solid #df3459;\\\">\\r\\n    Aenean metus lectus at id. Morbi aliquet commodo a sodales eget. Eu justo ante nibh et a turpis, aliquam phasellus\\r\\n    hymenaeos, imperdiet eget cras sociosqu, tincidunt a amet. Faucibus urna luctus, arcu ni<\\/blockquote>\\r\\n<h6 class=\\\"m-0\\\">Shifting Paradigms: The Move Toward Proactive Service Models<\\/h6>\\r\\n<div>As technology advanced, the paradigm began to shift towards a more proactive approach. The rise of advanced data\\r\\n    analytics and machine learning techniques enabled service centers to anticipate potential issues before they\\r\\n    occurred. By analyzing historical data and recognizing patterns, service centers could now predict when equipment\\r\\n    might fail or when a system could encounter problems. This shift not only reduced the frequency of unexpected\\r\\n    disruptions but also improved overall operational efficiency. Predictive maintenance became a key feature of\\r\\n    proactive service centers, allowing them to schedule maintenance activities during non-peak hours and address issues\\r\\n    before they impacted the customer experience.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">Harnessing Data Analytics and Machine Learning for Predictive Maintenance<\\/h6>\\r\\n<div>This evolution was further accelerated by the integration of artificial intelligence (AI) and automation tools.\\r\\n    AI-driven systems can now monitor and analyze real-time data from various sources, providing insights into potential\\r\\n    issues and suggesting preventive measures. Automation tools facilitate swift responses to identified issues, often\\r\\n    without the need for human intervention. For instance, automated systems can initiate repairs or adjustments based\\r\\n    on predefined parameters, ensuring that minor issues are resolved before they escalate into significant problems.\\r\\n<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">The Role of AI and Automation in Revolutionizing Service Center Operations<\\/h6>\\r\\n<div>The proactive approach not only enhances operational efficiency but also fosters a more positive customer\\r\\n    experience. By addressing potential issues before they impact customers, service centers can ensure a higher level\\r\\n    of service continuity and reliability. Customers benefit from fewer disruptions and a more streamlined experience,\\r\\n    leading to increased satisfaction and loyalty.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">Enhancing Customer Experience Through Proactive Service Strategies<\\/h6>\\r\\n<div>In essence, the evolution from a reactive to a proactive model in service center automation represents a\\r\\n    significant leap forward. It highlights the importance of leveraging advanced technologies to not only address\\r\\n    problems but to anticipate and prevent them, ultimately leading to a more efficient and customer-centric operation.\\r\\n    As technology continues to evolve, service centers will likely see even more sophisticated solutions that further\\r\\n    enhance their ability to provide seamless and proactive service.<\\/div>\",\"image\":\"66d4054622eef1725171014.png\"}',NULL,'basic','quisque-rutrum-pellentesque-habitant-morbi-tristique-senectus','2024-09-26 00:10:14','2024-10-01 06:02:03'),(100,'blog.element','{\"has_image\":[\"1\"],\"title\":\"Praesent ac sem eget est egestas volutpat Nullam dictur\",\"description\":\"<h6 class=\\\"m-0\\\">The Reactive Model of Service Centers: Addressing Issues After They Arise<\\/h6>\\r\\n<div>The landscape of service center automation has undergone a remarkable transformation over the past few decades,\\r\\n    shifting from reactive to proactive approaches. Initially, service centers operated on a reactive model, primarily\\r\\n    addressing issues only after they arose. This method often involved responding to customer complaints and\\r\\n    troubleshooting problems as they emerged, leading to higher levels of downtime and customer dissatisfaction. The\\r\\n    focus was largely on fixing problems rather than preventing them, which created a cycle of continuous reaction to\\r\\n    service issues.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<blockquote style=\\\"font-style:italic;text-align:center;padding:20px;background:#ffeaef;font-weight:500;font-size:18px;border-left:4px solid #df3459;\\\">\\r\\n    Aenean metus lectus at id. Morbi aliquet commodo a sodales eget. Eu justo ante nibh et a turpis, aliquam phasellus\\r\\n    hymenaeos, imperdiet eget cras sociosqu, tincidunt a amet. Faucibus urna luctus, arcu ni<\\/blockquote>\\r\\n<h6 class=\\\"m-0\\\">Shifting Paradigms: The Move Toward Proactive Service Models<\\/h6>\\r\\n<div>As technology advanced, the paradigm began to shift towards a more proactive approach. The rise of advanced data\\r\\n    analytics and machine learning techniques enabled service centers to anticipate potential issues before they\\r\\n    occurred. By analyzing historical data and recognizing patterns, service centers could now predict when equipment\\r\\n    might fail or when a system could encounter problems. This shift not only reduced the frequency of unexpected\\r\\n    disruptions but also improved overall operational efficiency. Predictive maintenance became a key feature of\\r\\n    proactive service centers, allowing them to schedule maintenance activities during non-peak hours and address issues\\r\\n    before they impacted the customer experience.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">Harnessing Data Analytics and Machine Learning for Predictive Maintenance<\\/h6>\\r\\n<div>This evolution was further accelerated by the integration of artificial intelligence (AI) and automation tools.\\r\\n    AI-driven systems can now monitor and analyze real-time data from various sources, providing insights into potential\\r\\n    issues and suggesting preventive measures. Automation tools facilitate swift responses to identified issues, often\\r\\n    without the need for human intervention. For instance, automated systems can initiate repairs or adjustments based\\r\\n    on predefined parameters, ensuring that minor issues are resolved before they escalate into significant problems.\\r\\n<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">The Role of AI and Automation in Revolutionizing Service Center Operations<\\/h6>\\r\\n<div>The proactive approach not only enhances operational efficiency but also fosters a more positive customer\\r\\n    experience. By addressing potential issues before they impact customers, service centers can ensure a higher level\\r\\n    of service continuity and reliability. Customers benefit from fewer disruptions and a more streamlined experience,\\r\\n    leading to increased satisfaction and loyalty.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">Enhancing Customer Experience Through Proactive Service Strategies<\\/h6>\\r\\n<div>In essence, the evolution from a reactive to a proactive model in service center automation represents a\\r\\n    significant leap forward. It highlights the importance of leveraging advanced technologies to not only address\\r\\n    problems but to anticipate and prevent them, ultimately leading to a more efficient and customer-centric operation.\\r\\n    As technology continues to evolve, service centers will likely see even more sophisticated solutions that further\\r\\n    enhance their ability to provide seamless and proactive service.<\\/div>\",\"image\":\"66d4056b13db41725171051.png\"}',NULL,'basic','praesent-ac-sem-eget-est-egestas-volutpat-nullam-dictur','2024-09-27 00:10:51','2024-10-01 06:01:53'),(101,'blog.element','{\"has_image\":[\"1\"],\"title\":\"Suspendisse pulvinar, augue ac venenatis condimentum.\",\"description\":\"<h6 class=\\\"m-0\\\">The Reactive Model of Service Centers: Addressing Issues After They Arise<\\/h6>\\r\\n<div>The landscape of service center automation has undergone a remarkable transformation over the past few decades,\\r\\n    shifting from reactive to proactive approaches. Initially, service centers operated on a reactive model, primarily\\r\\n    addressing issues only after they arose. This method often involved responding to customer complaints and\\r\\n    troubleshooting problems as they emerged, leading to higher levels of downtime and customer dissatisfaction. The\\r\\n    focus was largely on fixing problems rather than preventing them, which created a cycle of continuous reaction to\\r\\n    service issues.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<blockquote style=\\\"font-style:italic;text-align:center;padding:20px;background:#ffeaef;font-weight:500;font-size:18px;border-left:4px solid #df3459;\\\">\\r\\n    Aenean metus lectus at id. Morbi aliquet commodo a sodales eget. Eu justo ante nibh et a turpis, aliquam phasellus\\r\\n    hymenaeos, imperdiet eget cras sociosqu, tincidunt a amet. Faucibus urna luctus, arcu ni<\\/blockquote>\\r\\n<h6 class=\\\"m-0\\\">Shifting Paradigms: The Move Toward Proactive Service Models<\\/h6>\\r\\n<div>As technology advanced, the paradigm began to shift towards a more proactive approach. The rise of advanced data\\r\\n    analytics and machine learning techniques enabled service centers to anticipate potential issues before they\\r\\n    occurred. By analyzing historical data and recognizing patterns, service centers could now predict when equipment\\r\\n    might fail or when a system could encounter problems. This shift not only reduced the frequency of unexpected\\r\\n    disruptions but also improved overall operational efficiency. Predictive maintenance became a key feature of\\r\\n    proactive service centers, allowing them to schedule maintenance activities during non-peak hours and address issues\\r\\n    before they impacted the customer experience.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">Harnessing Data Analytics and Machine Learning for Predictive Maintenance<\\/h6>\\r\\n<div>This evolution was further accelerated by the integration of artificial intelligence (AI) and automation tools.\\r\\n    AI-driven systems can now monitor and analyze real-time data from various sources, providing insights into potential\\r\\n    issues and suggesting preventive measures. Automation tools facilitate swift responses to identified issues, often\\r\\n    without the need for human intervention. For instance, automated systems can initiate repairs or adjustments based\\r\\n    on predefined parameters, ensuring that minor issues are resolved before they escalate into significant problems.\\r\\n<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">The Role of AI and Automation in Revolutionizing Service Center Operations<\\/h6>\\r\\n<div>The proactive approach not only enhances operational efficiency but also fosters a more positive customer\\r\\n    experience. By addressing potential issues before they impact customers, service centers can ensure a higher level\\r\\n    of service continuity and reliability. Customers benefit from fewer disruptions and a more streamlined experience,\\r\\n    leading to increased satisfaction and loyalty.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">Enhancing Customer Experience Through Proactive Service Strategies<\\/h6>\\r\\n<div>In essence, the evolution from a reactive to a proactive model in service center automation represents a\\r\\n    significant leap forward. It highlights the importance of leveraging advanced technologies to not only address\\r\\n    problems but to anticipate and prevent them, ultimately leading to a more efficient and customer-centric operation.\\r\\n    As technology continues to evolve, service centers will likely see even more sophisticated solutions that further\\r\\n    enhance their ability to provide seamless and proactive service.<\\/div>\",\"image\":\"66d4058e9fe641725171086.png\"}',NULL,'basic','suspendisse-pulvinar-augue-ac-venenatis-condimentum','2024-09-28 00:11:26','2024-10-01 06:01:44'),(102,'blog.element','{\"has_image\":[\"1\"],\"title\":\"Duis lobortis massa imperdiet quam. Nunc egestas, augue\",\"description\":\"<h6 class=\\\"m-0\\\">The Reactive Model of Service Centers: Addressing Issues After They Arise<\\/h6>\\r\\n<div>The landscape of service center automation has undergone a remarkable transformation over the past few decades,\\r\\n    shifting from reactive to proactive approaches. Initially, service centers operated on a reactive model, primarily\\r\\n    addressing issues only after they arose. This method often involved responding to customer complaints and\\r\\n    troubleshooting problems as they emerged, leading to higher levels of downtime and customer dissatisfaction. The\\r\\n    focus was largely on fixing problems rather than preventing them, which created a cycle of continuous reaction to\\r\\n    service issues.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<blockquote style=\\\"font-style:italic;text-align:center;padding:20px;background:#ffeaef;font-weight:500;font-size:18px;border-left:4px solid #df3459;\\\">\\r\\n    Aenean metus lectus at id. Morbi aliquet commodo a sodales eget. Eu justo ante nibh et a turpis, aliquam phasellus\\r\\n    hymenaeos, imperdiet eget cras sociosqu, tincidunt a amet. Faucibus urna luctus, arcu ni<\\/blockquote>\\r\\n<h6 class=\\\"m-0\\\">Shifting Paradigms: The Move Toward Proactive Service Models<\\/h6>\\r\\n<div>As technology advanced, the paradigm began to shift towards a more proactive approach. The rise of advanced data\\r\\n    analytics and machine learning techniques enabled service centers to anticipate potential issues before they\\r\\n    occurred. By analyzing historical data and recognizing patterns, service centers could now predict when equipment\\r\\n    might fail or when a system could encounter problems. This shift not only reduced the frequency of unexpected\\r\\n    disruptions but also improved overall operational efficiency. Predictive maintenance became a key feature of\\r\\n    proactive service centers, allowing them to schedule maintenance activities during non-peak hours and address issues\\r\\n    before they impacted the customer experience.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">Harnessing Data Analytics and Machine Learning for Predictive Maintenance<\\/h6>\\r\\n<div>This evolution was further accelerated by the integration of artificial intelligence (AI) and automation tools.\\r\\n    AI-driven systems can now monitor and analyze real-time data from various sources, providing insights into potential\\r\\n    issues and suggesting preventive measures. Automation tools facilitate swift responses to identified issues, often\\r\\n    without the need for human intervention. For instance, automated systems can initiate repairs or adjustments based\\r\\n    on predefined parameters, ensuring that minor issues are resolved before they escalate into significant problems.\\r\\n<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">The Role of AI and Automation in Revolutionizing Service Center Operations<\\/h6>\\r\\n<div>The proactive approach not only enhances operational efficiency but also fosters a more positive customer\\r\\n    experience. By addressing potential issues before they impact customers, service centers can ensure a higher level\\r\\n    of service continuity and reliability. Customers benefit from fewer disruptions and a more streamlined experience,\\r\\n    leading to increased satisfaction and loyalty.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">Enhancing Customer Experience Through Proactive Service Strategies<\\/h6>\\r\\n<div>In essence, the evolution from a reactive to a proactive model in service center automation represents a\\r\\n    significant leap forward. It highlights the importance of leveraging advanced technologies to not only address\\r\\n    problems but to anticipate and prevent them, ultimately leading to a more efficient and customer-centric operation.\\r\\n    As technology continues to evolve, service centers will likely see even more sophisticated solutions that further\\r\\n    enhance their ability to provide seamless and proactive service.<\\/div>\",\"image\":\"66d405c4b41841725171140.png\"}',NULL,'basic','duis-lobortis-massa-imperdiet-quam-nunc-egestas-augue','2024-09-29 00:12:20','2024-10-01 06:01:35'),(103,'blog.element','{\"has_image\":[\"1\"],\"title\":\"Etiam feugiat lorem non metus. Sed libero\",\"description\":\"<h6 class=\\\"m-0\\\">The Reactive Model of Service Centers: Addressing Issues After They Arise<\\/h6>\\r\\n<div>The landscape of service center automation has undergone a remarkable transformation over the past few decades,\\r\\n    shifting from reactive to proactive approaches. Initially, service centers operated on a reactive model, primarily\\r\\n    addressing issues only after they arose. This method often involved responding to customer complaints and\\r\\n    troubleshooting problems as they emerged, leading to higher levels of downtime and customer dissatisfaction. The\\r\\n    focus was largely on fixing problems rather than preventing them, which created a cycle of continuous reaction to\\r\\n    service issues.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<blockquote style=\\\"font-style:italic;text-align:center;padding:20px;background:#ffeaef;font-weight:500;font-size:18px;border-left:4px solid #df3459;\\\">\\r\\n    Aenean metus lectus at id. Morbi aliquet commodo a sodales eget. Eu justo ante nibh et a turpis, aliquam phasellus\\r\\n    hymenaeos, imperdiet eget cras sociosqu, tincidunt a amet. Faucibus urna luctus, arcu ni<\\/blockquote>\\r\\n<h6 class=\\\"m-0\\\">Shifting Paradigms: The Move Toward Proactive Service Models<\\/h6>\\r\\n<div>As technology advanced, the paradigm began to shift towards a more proactive approach. The rise of advanced data\\r\\n    analytics and machine learning techniques enabled service centers to anticipate potential issues before they\\r\\n    occurred. By analyzing historical data and recognizing patterns, service centers could now predict when equipment\\r\\n    might fail or when a system could encounter problems. This shift not only reduced the frequency of unexpected\\r\\n    disruptions but also improved overall operational efficiency. Predictive maintenance became a key feature of\\r\\n    proactive service centers, allowing them to schedule maintenance activities during non-peak hours and address issues\\r\\n    before they impacted the customer experience.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">Harnessing Data Analytics and Machine Learning for Predictive Maintenance<\\/h6>\\r\\n<div>This evolution was further accelerated by the integration of artificial intelligence (AI) and automation tools.\\r\\n    AI-driven systems can now monitor and analyze real-time data from various sources, providing insights into potential\\r\\n    issues and suggesting preventive measures. Automation tools facilitate swift responses to identified issues, often\\r\\n    without the need for human intervention. For instance, automated systems can initiate repairs or adjustments based\\r\\n    on predefined parameters, ensuring that minor issues are resolved before they escalate into significant problems.\\r\\n<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">The Role of AI and Automation in Revolutionizing Service Center Operations<\\/h6>\\r\\n<div>The proactive approach not only enhances operational efficiency but also fosters a more positive customer\\r\\n    experience. By addressing potential issues before they impact customers, service centers can ensure a higher level\\r\\n    of service continuity and reliability. Customers benefit from fewer disruptions and a more streamlined experience,\\r\\n    leading to increased satisfaction and loyalty.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">Enhancing Customer Experience Through Proactive Service Strategies<\\/h6>\\r\\n<div>In essence, the evolution from a reactive to a proactive model in service center automation represents a\\r\\n    significant leap forward. It highlights the importance of leveraging advanced technologies to not only address\\r\\n    problems but to anticipate and prevent them, ultimately leading to a more efficient and customer-centric operation.\\r\\n    As technology continues to evolve, service centers will likely see even more sophisticated solutions that further\\r\\n    enhance their ability to provide seamless and proactive service.<\\/div>\",\"image\":\"66d405e507a791725171173.png\"}',NULL,'basic','etiam-feugiat-lorem-non-metus-sed-libero','2024-09-30 00:12:53','2024-10-01 06:01:26'),(104,'cta.content','{\"heading\":\"Ready to Get Started?\",\"subheading\":\"Join Our Network, Partner with Brands, and Elevate Your Online Influence \\u2013 Your Journey Starts Here\",\"button_name\":\"Get Started\",\"button_url\":\"influencer\\/register\"}',NULL,'basic','','2024-09-01 02:57:19','2026-02-22 20:55:39'),(105,'faq.content','{\"heading\":\"Frequently Asked Questions\"}',NULL,'basic','','2024-09-01 03:05:54','2024-09-01 03:05:54'),(106,'faq.element','{\"question\":\"How does your platform work?\",\"answer\":\"Our platform works by allowing brands to create campaigns and connect with influencers who fit their target audience and brand values. Influencers can browse through available campaigns, apply to participate, and collaborate with brands to create sponsored content. You can also buy packages directly from influencers and create custom projects.\"}',NULL,'basic','','2024-09-01 03:07:11','2026-02-23 15:32:35'),(107,'faq.element','{\"question\":\"How do brands benefit?\",\"answer\":\"Our platform offers brands the ability to reach a highly targeted audience through trusted influencers. It provides access to detailed analytics, real-time campaign tracking, and the ability to manage multiple campaigns and influencers in one centralised location.\"}',NULL,'basic','','2024-09-01 03:07:25','2026-02-23 15:32:00'),(108,'faq.element','{\"question\":\"How do influencers benefit?\",\"answer\":\"Influencers benefit from our platform by gaining access to a diverse range of brands and campaigns to collaborate with. They can monetise their influence, expand their reach, and gain valuable insights into their audience demographics and engagement metrics.\"}',NULL,'basic','','2024-09-01 03:07:41','2026-02-23 15:31:31'),(109,'faq.element','{\"question\":\"How do you verify influencer authenticity?\",\"answer\":\"We carefully vet influencers before allowing them to join our platform. We verify their audience demographics, engagement rates, and content quality to ensure authenticity and relevance for our brand partners.\"}',NULL,'basic','','2024-09-01 03:07:53','2024-10-08 23:41:08'),(110,'faq.element','{\"question\":\"What campaigns can brands run?\",\"answer\":\"Brands can run various types of campaigns, including sponsored content, product reviews, giveaways, events, and more. Our platform offers flexibility in campaign types to accommodate diverse marketing objectives and strategies.\"}',NULL,'basic','','2024-09-01 03:08:06','2024-10-08 23:44:15'),(111,'faq.element','{\"question\":\"What is the ROI of joining?\",\"answer\":\"Using our platform, brands save themselves hours of manual admin finding influencers, negotiating terms and managing campaigns. Influenced is your one stop shop for everything from a simple giveaway collab to a multi influencer ad campaign.\"}',NULL,'basic','','2024-09-01 03:08:20','2026-02-23 15:30:43'),(112,'faq.element','{\"question\":\"Is there a fee for influencers to join your platform?\",\"answer\":\"No, there is no fee for influencers to join our platform. It is free for influencers to create profiles, browse available campaigns, and apply to participate in collaborations. We charge a 10% service fee for any services booked.\"}',NULL,'basic','','2024-09-01 03:08:29','2026-02-23 15:29:17'),(113,'social_icon.element','{\"social_icon\":\"<i class=\\\"fab fa-instagram\\\"><\\/i>\",\"url\":\"https:\\/\\/www.instagram.com\\/\"}',NULL,'basic','','2024-09-01 04:21:51','2024-09-01 04:21:51'),(114,'social_icon.element','{\"social_icon\":\"<i class=\\\"fab fa-youtube\\\"><\\/i>\",\"url\":\"https:\\/\\/www.youtube.com\"}',NULL,'basic','','2024-09-01 04:22:01','2024-09-01 04:22:01'),(115,'footer.content','{\"description\":\"Join our influencer marketplace and unlock the potential of authentic collaborations. Connect with top brands and influencers to amplify your reach.\"}',NULL,'basic','','2024-09-01 04:22:50','2024-09-01 04:22:50'),(116,'brand_login.content','{\"heading\":\"Login as Brand\",\"subheading\":\"Access Your Brand Power and Influence\",\"title\":\"Connect, Collaborate, and Elevate Your Brand with Influencers\",\"short_description\":\"Unlock the potential of authentic influencer collaborations to elevate your brands reach and impact\"}',NULL,'basic','','2024-09-01 23:28:57','2024-09-01 23:28:57'),(117,'brand_register.content','{\"heading\":\"Register as Brand\",\"subheading\":\"Start Your Brand Journey Today\",\"title\":\"Register Your Brand and Connect with Top Influencers\",\"short_description\":\"Register and Amplify Your Reach with Our Influencer Marketplace. Your Success Story Begins Here\"}',NULL,'basic','','2024-09-01 23:29:27','2024-09-01 23:29:27'),(118,'influencer_login.content','{\"heading\":\"Login as Influencer\",\"subheading\":\"Next Step in Your Influencer Journey\",\"title\":\"Your Path to Influence and Success\",\"short_description\":\"Empower Your Influence and Amplify Your Reach with Our Comprehensive Platform.\"}',NULL,'basic','','2024-09-02 00:51:58','2024-09-02 00:51:58'),(119,'influencer_register.content','{\"heading\":\"Register as Influencer\",\"subheading\":\"Step into the World of Influence\",\"title\":\"Register as an Influencer to Connect with Brands\",\"short_description\":\"Unlock Your Influence Potential \\u2013 Join Our Platform to Connect with Top Brands and Amplify Your Reach\"}',NULL,'basic','','2024-09-02 00:52:22','2024-09-02 00:52:22'),(120,'ongoing_campaign.content','{\"heading\":\"Ongoing Campaigns\"}',NULL,'basic','','2024-09-11 06:53:55','2024-09-29 01:29:19'),(121,'empty_data.content','{\"has_image\":\"1\",\"image\":\"66e7d3375c8cb1726468919.png\"}',NULL,'basic','','2024-09-16 00:41:59','2024-09-16 00:42:00'),(122,'policy_pages.element','{\"title\":\"Refund Policy\",\"details\":\"<div class=\\\"mb-5\\\">\\r\\n    <h4 class=\\\"mb-2\\\">Introduction<\\/h4>\\r\\n        <p>\\r\\n            This Privacy Policy describes how we collects, uses, and discloses information, including personal information, in connection with your use of our website.\\r\\n        <\\/p>\\r\\n<\\/div>\\r\\n     \\r\\n        \\r\\n        <div class=\\\"mb-5\\\">\\r\\n            <h4 class=\\\"mb-2\\\">Information We Collect<\\/h4>\\r\\n        <p>We collect two main types of information on the Website:<\\/p>\\r\\n        <ul>\\r\\n            <li><p><strong>Personal Information: <\\/strong>This includes data that can identify you as an individual, such as your name, email address, phone number, or mailing address. We only collect this information when you voluntarily provide it to us, like signing up for a newsletter, contacting us through a form, or making a purchase.<\\/p><\\/li>\\r\\n            <li><p><strong>Non-Personal Information: <\\/strong>This data cannot be used to identify you directly. It includes details like your browser type, device type, operating system, IP address, browsing activity, and usage statistics. We collect this information automatically through cookies and other tracking technologies.<\\/p><\\/li>\\r\\n        <\\/ul>\\r\\n        <\\/div>\\r\\n     \\r\\n        \\r\\n        <div class=\\\"mb-5\\\">\\r\\n            <h4 class=\\\"mb-2\\\">How We Use Information<\\/h4>\\r\\n        <p>The information we collect allows us to:<\\/p>\\r\\n        <ul>\\r\\n            <li>Operate and maintain the Website effectively.<\\/li>\\r\\n            <li>Send you newsletters or marketing communications, but only with your consent.<\\/li>\\r\\n            <li>Respond to your inquiries and fulfill your requests.<\\/li>\\r\\n            <li>Improve the Website and your user experience.<\\/li>\\r\\n            <li>Personalize your experience on the Website based on your browsing habits.<\\/li>\\r\\n            <li>Analyze how the Website is used to improve our services.<\\/li>\\r\\n            <li>Comply with legal and regulatory requirements.<\\/li>\\r\\n        <\\/ul>\\r\\n     \\r\\n        <\\/div>\\r\\n        \\r\\n       <div class=\\\"mb-5\\\">\\r\\n        <h4 class=\\\"mb-2\\\">Sharing of Information<\\/h4>\\r\\n        <p>We may share your information with trusted third-party service providers who assist us in operating the Website and delivering our services. These providers are obligated by contract to keep your information confidential and use it only for the specific purposes we disclose it for.<\\/p>\\r\\n        <p>We will never share your personal information with any third parties for marketing purposes without your explicit consent.<\\/p>\\r\\n     \\r\\n       <\\/div>\\r\\n        \\r\\n        <div class=\\\"mb-5\\\">\\r\\n            <h4 class=\\\"mb-2\\\">Data Retention<\\/h4>\\r\\n        <p>We retain your personal information only for as long as necessary to fulfill the purposes it was collected for. We may retain it for longer periods only if required or permitted by law.<\\/p>\\r\\n     \\r\\n        <\\/div>\\r\\n        \\r\\n        <div class=\\\"mb-5\\\">\\r\\n            <h4 class=\\\"mb-2\\\">Security Measures<\\/h4>\\r\\n        <p>We take reasonable precautions to protect your information from unauthorized access, disclosure, alteration, or destruction. However, complete security cannot be guaranteed for any website or internet transmission.<\\/p>\\r\\n     \\r\\n        <\\/div>\\r\\n        \\r\\n<div>\\r\\n    <h4 class=\\\"mb-2\\\">Changes to this Privacy Policy<\\/h4>\\r\\n    <p>We may update this Privacy Policy periodically. We will notify you of any changes by posting the revised policy on the Website. We recommend reviewing this policy regularly to stay informed of any updates.<\\/p>\\r\\n    <p><strong>Remember:<\\/strong>  This is a sample policy and may need adjustments to comply with specific laws and reflect your website\'s unique data practices. Consider consulting with a legal professional to ensure your policy is fully compliant.<\\/p>\\r\\n<\\/div>\"}',NULL,'basic','refund-policy','2024-09-24 05:31:42','2024-09-29 00:48:01'),(123,'banned.content','{\"has_image\":\"1\",\"image\":\"66f3d7772f3d91727256439.png\"}',NULL,'basic','','2024-09-25 03:23:17','2024-09-25 03:27:19'),(124,'brand_kyc.content','{\"required\":\"Complete KYC to unlock the full potential of our platform! KYC helps us verify your identity and keep things secure. It is quick and easy just follow the on-screen instructions. Get started with KYC verification now!\",\"pending\":\"Your KYC verification is being reviewed. We might need some additional information. You will get an email update soon. In the meantime, explore our platform with limited features.\",\"reject\":\"We regret to inform you that the Know Your Customer (KYC) information provided has been reviewed and unfortunately, it has not met our verification standards.\"}',NULL,'basic','','2024-09-25 05:23:38','2024-09-25 05:23:38'),(125,'influencer_kyc.content','{\"required\":\"Complete KYC to unlock the full potential of our platform! KYC helps us verify your identity and keep things secure. It is quick and easy just follow the on-screen instructions. Get started with KYC verification now!\",\"pending\":\"Your KYC verification is being reviewed. We might need some additional information. You will get an email update soon. In the meantime, explore our platform with limited features.\",\"reject\":\"We regret to inform you that the Know Your Customer (KYC) information provided has been reviewed and unfortunately, it has not met our verification standards.\"}',NULL,'basic','','2024-09-25 05:24:18','2024-09-25 05:25:25'),(126,'partner.element','{\"has_image\":\"1\",\"image\":\"66f8fb270ae921727593255.png\"}',NULL,'basic','','2024-09-29 01:00:55','2024-09-29 01:00:55'),(127,'breadcrumb.content','{\"has_image\":\"1\",\"image\":\"66fbcd6f171071727778159.png\"}',NULL,'basic','','2024-10-01 02:29:54','2024-10-01 04:22:39'),(128,'social_icon.element','{\"social_icon\":\"<i class=\\\"fa-brands fa-x-twitter\\\"><\\/i>\",\"url\":\"https:\\/\\/www.twitter.com\\/\"}',NULL,'basic','','2024-10-08 23:38:09','2024-10-08 23:38:29');
/*!40000 ALTER TABLE `frontends` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gateway_currencies`
--

DROP TABLE IF EXISTS `gateway_currencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `gateway_currencies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) DEFAULT NULL,
  `currency` varchar(40) DEFAULT NULL,
  `symbol` varchar(40) DEFAULT NULL,
  `method_code` int(11) DEFAULT NULL,
  `gateway_alias` varchar(40) DEFAULT NULL,
  `min_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `max_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `percent_charge` decimal(5,2) NOT NULL DEFAULT 0.00,
  `fixed_charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `rate` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `gateway_parameter` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gateway_currencies`
--

LOCK TABLES `gateway_currencies` WRITE;
/*!40000 ALTER TABLE `gateway_currencies` DISABLE KEYS */;
/*!40000 ALTER TABLE `gateway_currencies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gateways`
--

DROP TABLE IF EXISTS `gateways`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `gateways` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(10) unsigned NOT NULL DEFAULT 0,
  `code` int(11) DEFAULT NULL,
  `name` varchar(40) DEFAULT NULL,
  `alias` varchar(40) NOT NULL DEFAULT 'NULL',
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=>enable, 2=>disable',
  `gateway_parameters` text DEFAULT NULL,
  `supported_currencies` text DEFAULT NULL,
  `crypto` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: fiat currency, 1: crypto currency',
  `extra` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gateways`
--

LOCK TABLES `gateways` WRITE;
/*!40000 ALTER TABLE `gateways` DISABLE KEYS */;
INSERT INTO `gateways` VALUES (1,0,101,'Paypal','Paypal','663a38d7b455d1715091671.png',1,'{\"paypal_email\":{\"title\":\"PayPal Email\",\"global\":true,\"value\":\"sb-owud61543012@business.example.com\"}}','{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"$\"}',0,NULL,NULL,'2019-09-14 13:14:22','2024-05-07 08:21:11'),(2,0,102,'Perfect Money','PerfectMoney','663a3920e30a31715091744.png',1,'{\"passphrase\":{\"title\":\"ALTERNATE PASSPHRASE\",\"global\":true,\"value\":\"hR26aw02Q1eEeUPSIfuwNypXX\"},\"wallet_id\":{\"title\":\"PM Wallet\",\"global\":false,\"value\":\"\"}}','{\"USD\":\"$\",\"EUR\":\"\\u20ac\"}',0,NULL,NULL,'2019-09-14 13:14:22','2024-05-07 08:22:24'),(3,0,103,'Stripe Hosted','Stripe','663a39861cb9d1715091846.png',1,'{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_test_51I6GGiCGv1sRiQlEi5v1or9eR0HVbuzdMd2rW4n3DxC8UKfz66R4X6n4yYkzvI2LeAIuRU9H99ZpY7XCNFC9xMs500vBjZGkKG\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_51I6GGiCGv1sRiQlEOisPKrjBqQqqcFsw8mXNaZ2H2baN6R01NulFS7dKFji1NRRxuchoUTEDdB7ujKcyKYSVc0z500eth7otOM\"}}','{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}',0,NULL,NULL,'2019-09-14 13:14:22','2024-05-07 08:24:06'),(4,0,104,'Skrill','Skrill','663a39494c4a91715091785.png',1,'{\"pay_to_email\":{\"title\":\"Skrill Email\",\"global\":true,\"value\":\"merchant@skrill.com\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"---\"}}','{\"AED\":\"AED\",\"AUD\":\"AUD\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"HRK\":\"HRK\",\"HUF\":\"HUF\",\"ILS\":\"ILS\",\"INR\":\"INR\",\"ISK\":\"ISK\",\"JOD\":\"JOD\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"KWD\":\"KWD\",\"MAD\":\"MAD\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"OMR\":\"OMR\",\"PLN\":\"PLN\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RSD\":\"RSD\",\"SAR\":\"SAR\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TND\":\"TND\",\"TRY\":\"TRY\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\",\"COP\":\"COP\"}',0,NULL,NULL,'2019-09-14 13:14:22','2024-05-07 08:23:05'),(5,0,105,'PayTM','Paytm','663a390f601191715091727.png',1,'{\"MID\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"DIY12386817555501617\"},\"merchant_key\":{\"title\":\"Merchant Key\",\"global\":true,\"value\":\"bKMfNxPPf_QdZppa\"},\"WEBSITE\":{\"title\":\"Paytm Website\",\"global\":true,\"value\":\"DIYtestingweb\"},\"INDUSTRY_TYPE_ID\":{\"title\":\"Industry Type\",\"global\":true,\"value\":\"Retail\"},\"CHANNEL_ID\":{\"title\":\"CHANNEL ID\",\"global\":true,\"value\":\"WEB\"},\"transaction_url\":{\"title\":\"Transaction URL\",\"global\":true,\"value\":\"https:\\/\\/pguat.paytm.com\\/oltp-web\\/processTransaction\"},\"transaction_status_url\":{\"title\":\"Transaction STATUS URL\",\"global\":true,\"value\":\"https:\\/\\/pguat.paytm.com\\/paytmchecksum\\/paytmCallback.jsp\"}}','{\"AUD\":\"AUD\",\"ARS\":\"ARS\",\"BDT\":\"BDT\",\"BRL\":\"BRL\",\"BGN\":\"BGN\",\"CAD\":\"CAD\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"COP\":\"COP\",\"HRK\":\"HRK\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EGP\":\"EGP\",\"EUR\":\"EUR\",\"GEL\":\"GEL\",\"GHS\":\"GHS\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"KES\":\"KES\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"MAD\":\"MAD\",\"NPR\":\"NPR\",\"NZD\":\"NZD\",\"NGN\":\"NGN\",\"NOK\":\"NOK\",\"PKR\":\"PKR\",\"PEN\":\"PEN\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"ZAR\":\"ZAR\",\"KRW\":\"KRW\",\"LKR\":\"LKR\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"TRY\":\"TRY\",\"UGX\":\"UGX\",\"UAH\":\"UAH\",\"AED\":\"AED\",\"GBP\":\"GBP\",\"USD\":\"USD\",\"VND\":\"VND\",\"XOF\":\"XOF\"}',0,NULL,NULL,'2019-09-14 13:14:22','2024-05-07 08:22:07'),(6,0,106,'Payeer','Payeer','663a38c9e2e931715091657.png',1,'{\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"866989763\"},\"secret_key\":{\"title\":\"Secret key\",\"global\":true,\"value\":\"7575\"}}','{\"USD\":\"USD\",\"EUR\":\"EUR\",\"RUB\":\"RUB\"}',0,'{\"status\":{\"title\": \"Status URL\",\"value\":\"ipn.Payeer\"}}',NULL,'2019-09-14 13:14:22','2024-05-07 08:20:57'),(7,0,107,'PayStack','Paystack','663a38fc814e91715091708.png',1,'{\"public_key\":{\"title\":\"Public key\",\"global\":true,\"value\":\"pk_test_cd330608eb47970889bca397ced55c1dd5ad3783\"},\"secret_key\":{\"title\":\"Secret key\",\"global\":true,\"value\":\"sk_test_8a0b1f199362d7acc9c390bff72c4e81f74e2ac3\"}}','{\"USD\":\"USD\",\"NGN\":\"NGN\"}',0,'{\"callback\":{\"title\": \"Callback URL\",\"value\":\"ipn.Paystack\"},\"webhook\":{\"title\": \"Webhook URL\",\"value\":\"ipn.Paystack\"}}\r\n',NULL,'2019-09-14 13:14:22','2024-05-07 08:21:48'),(9,0,109,'Flutterwave','Flutterwave','663a36c2c34d61715091138.png',1,'{\"public_key\":{\"title\":\"Public Key\",\"global\":true,\"value\":\"----------------\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"-----------------------\"},\"encryption_key\":{\"title\":\"Encryption Key\",\"global\":true,\"value\":\"------------------\"}}','{\"BIF\":\"BIF\",\"CAD\":\"CAD\",\"CDF\":\"CDF\",\"CVE\":\"CVE\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"GHS\":\"GHS\",\"GMD\":\"GMD\",\"GNF\":\"GNF\",\"KES\":\"KES\",\"LRD\":\"LRD\",\"MWK\":\"MWK\",\"MZN\":\"MZN\",\"NGN\":\"NGN\",\"RWF\":\"RWF\",\"SLL\":\"SLL\",\"STD\":\"STD\",\"TZS\":\"TZS\",\"UGX\":\"UGX\",\"USD\":\"USD\",\"XAF\":\"XAF\",\"XOF\":\"XOF\",\"ZMK\":\"ZMK\",\"ZMW\":\"ZMW\",\"ZWD\":\"ZWD\"}',0,NULL,NULL,'2019-09-14 13:14:22','2024-05-07 08:12:18'),(10,0,110,'RazorPay','Razorpay','663a393a527831715091770.png',1,'{\"key_id\":{\"title\":\"Key Id\",\"global\":true,\"value\":\"rzp_test_kiOtejPbRZU90E\"},\"key_secret\":{\"title\":\"Key Secret \",\"global\":true,\"value\":\"osRDebzEqbsE1kbyQJ4y0re7\"}}','{\"INR\":\"INR\"}',0,NULL,NULL,'2019-09-14 13:14:22','2024-05-07 08:22:50'),(11,0,111,'Stripe Storefront','StripeJs','663a3995417171715091861.png',1,'{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_test_51I6GGiCGv1sRiQlEi5v1or9eR0HVbuzdMd2rW4n3DxC8UKfz66R4X6n4yYkzvI2LeAIuRU9H99ZpY7XCNFC9xMs500vBjZGkKG\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_51I6GGiCGv1sRiQlEOisPKrjBqQqqcFsw8mXNaZ2H2baN6R01NulFS7dKFji1NRRxuchoUTEDdB7ujKcyKYSVc0z500eth7otOM\"}}','{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}',0,NULL,NULL,'2019-09-14 13:14:22','2024-05-07 08:24:21'),(12,0,112,'Instamojo','Instamojo','663a384d54a111715091533.png',1,'{\"api_key\":{\"title\":\"API KEY\",\"global\":true,\"value\":\"test_2241633c3bc44a3de84a3b33969\"},\"auth_token\":{\"title\":\"Auth Token\",\"global\":true,\"value\":\"test_279f083f7bebefd35217feef22d\"},\"salt\":{\"title\":\"Salt\",\"global\":true,\"value\":\"19d38908eeff4f58b2ddda2c6d86ca25\"}}','{\"INR\":\"INR\"}',0,NULL,NULL,'2019-09-14 13:14:22','2024-05-07 08:18:53'),(13,0,501,'Blockchain','Blockchain','663a35efd0c311715090927.png',1,'{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"55529946-05ca-48ff-8710-f279d86b1cc5\"},\"xpub_code\":{\"title\":\"XPUB CODE\",\"global\":true,\"value\":\"xpub6CKQ3xxWyBoFAF83izZCSFUorptEU9AF8TezhtWeMU5oefjX3sFSBw62Lr9iHXPkXmDQJJiHZeTRtD9Vzt8grAYRhvbz4nEvBu3QKELVzFK\"}}','{\"BTC\":\"BTC\"}',1,NULL,NULL,'2019-09-14 13:14:22','2024-05-07 08:08:47'),(15,0,503,'CoinPayments','Coinpayments','663a36a8d8e1d1715091112.png',1,'{\"public_key\":{\"title\":\"Public Key\",\"global\":true,\"value\":\"---------------------\"},\"private_key\":{\"title\":\"Private Key\",\"global\":true,\"value\":\"---------------------\"},\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"---------------------\"}}','{\"BTC\":\"Bitcoin\",\"BTC.LN\":\"Bitcoin (Lightning Network)\",\"LTC\":\"Litecoin\",\"CPS\":\"CPS Coin\",\"VLX\":\"Velas\",\"APL\":\"Apollo\",\"AYA\":\"Aryacoin\",\"BAD\":\"Badcoin\",\"BCD\":\"Bitcoin Diamond\",\"BCH\":\"Bitcoin Cash\",\"BCN\":\"Bytecoin\",\"BEAM\":\"BEAM\",\"BITB\":\"Bean Cash\",\"BLK\":\"BlackCoin\",\"BSV\":\"Bitcoin SV\",\"BTAD\":\"Bitcoin Adult\",\"BTG\":\"Bitcoin Gold\",\"BTT\":\"BitTorrent\",\"CLOAK\":\"CloakCoin\",\"CLUB\":\"ClubCoin\",\"CRW\":\"Crown\",\"CRYP\":\"CrypticCoin\",\"CRYT\":\"CryTrExCoin\",\"CURE\":\"CureCoin\",\"DASH\":\"DASH\",\"DCR\":\"Decred\",\"DEV\":\"DeviantCoin\",\"DGB\":\"DigiByte\",\"DOGE\":\"Dogecoin\",\"EBST\":\"eBoost\",\"EOS\":\"EOS\",\"ETC\":\"Ether Classic\",\"ETH\":\"Ethereum\",\"ETN\":\"Electroneum\",\"EUNO\":\"EUNO\",\"EXP\":\"EXP\",\"Expanse\":\"Expanse\",\"FLASH\":\"FLASH\",\"GAME\":\"GameCredits\",\"GLC\":\"Goldcoin\",\"GRS\":\"Groestlcoin\",\"KMD\":\"Komodo\",\"LOKI\":\"LOKI\",\"LSK\":\"LSK\",\"MAID\":\"MaidSafeCoin\",\"MUE\":\"MonetaryUnit\",\"NAV\":\"NAV Coin\",\"NEO\":\"NEO\",\"NMC\":\"Namecoin\",\"NVST\":\"NVO Token\",\"NXT\":\"NXT\",\"OMNI\":\"OMNI\",\"PINK\":\"PinkCoin\",\"PIVX\":\"PIVX\",\"POT\":\"PotCoin\",\"PPC\":\"Peercoin\",\"PROC\":\"ProCurrency\",\"PURA\":\"PURA\",\"QTUM\":\"QTUM\",\"RES\":\"Resistance\",\"RVN\":\"Ravencoin\",\"RVR\":\"RevolutionVR\",\"SBD\":\"Steem Dollars\",\"SMART\":\"SmartCash\",\"SOXAX\":\"SOXAX\",\"STEEM\":\"STEEM\",\"STRAT\":\"STRAT\",\"SYS\":\"Syscoin\",\"TPAY\":\"TokenPay\",\"TRIGGERS\":\"Triggers\",\"TRX\":\" TRON\",\"UBQ\":\"Ubiq\",\"UNIT\":\"UniversalCurrency\",\"USDT\":\"Tether USD (Omni Layer)\",\"USDT.BEP20\":\"Tether USD (BSC Chain)\",\"USDT.ERC20\":\"Tether USD (ERC20)\",\"USDT.TRC20\":\"Tether USD (Tron/TRC20)\",\"VTC\":\"Vertcoin\",\"WAVES\":\"Waves\",\"XCP\":\"Counterparty\",\"XEM\":\"NEM\",\"XMR\":\"Monero\",\"XSN\":\"Stakenet\",\"XSR\":\"SucreCoin\",\"XVG\":\"VERGE\",\"XZC\":\"ZCoin\",\"ZEC\":\"ZCash\",\"ZEN\":\"Horizen\"}',1,NULL,NULL,'2019-09-14 13:14:22','2024-05-07 08:11:52'),(16,0,504,'CoinPayments Fiat','CoinpaymentsFiat','663a36b7b841a1715091127.png',1,'{\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"6515561\"}}','{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"ISK\":\"ISK\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"RUB\":\"RUB\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TWD\":\"TWD\"}',0,NULL,NULL,'2019-09-14 13:14:22','2024-05-07 08:12:07'),(17,0,505,'Coingate','Coingate','663a368e753381715091086.png',1,'{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"6354mwVCEw5kHzRJ6thbGo-N\"}}','{\"USD\":\"USD\",\"EUR\":\"EUR\"}',0,NULL,NULL,'2019-09-14 13:14:22','2024-05-07 08:11:26'),(18,0,506,'Coinbase Commerce','CoinbaseCommerce','663a367e46ae51715091070.png',1,'{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"c47cd7df-d8e8-424b-a20a\"},\"secret\":{\"title\":\"Webhook Shared Secret\",\"global\":true,\"value\":\"55871878-2c32-4f64-ab66\"}}','{\"USD\":\"USD\",\"EUR\":\"EUR\",\"JPY\":\"JPY\",\"GBP\":\"GBP\",\"AUD\":\"AUD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CNY\":\"CNY\",\"SEK\":\"SEK\",\"NZD\":\"NZD\",\"MXN\":\"MXN\",\"SGD\":\"SGD\",\"HKD\":\"HKD\",\"NOK\":\"NOK\",\"KRW\":\"KRW\",\"TRY\":\"TRY\",\"RUB\":\"RUB\",\"INR\":\"INR\",\"BRL\":\"BRL\",\"ZAR\":\"ZAR\",\"AED\":\"AED\",\"AFN\":\"AFN\",\"ALL\":\"ALL\",\"AMD\":\"AMD\",\"ANG\":\"ANG\",\"AOA\":\"AOA\",\"ARS\":\"ARS\",\"AWG\":\"AWG\",\"AZN\":\"AZN\",\"BAM\":\"BAM\",\"BBD\":\"BBD\",\"BDT\":\"BDT\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"BIF\":\"BIF\",\"BMD\":\"BMD\",\"BND\":\"BND\",\"BOB\":\"BOB\",\"BSD\":\"BSD\",\"BTN\":\"BTN\",\"BWP\":\"BWP\",\"BYN\":\"BYN\",\"BZD\":\"BZD\",\"CDF\":\"CDF\",\"CLF\":\"CLF\",\"CLP\":\"CLP\",\"COP\":\"COP\",\"CRC\":\"CRC\",\"CUC\":\"CUC\",\"CUP\":\"CUP\",\"CVE\":\"CVE\",\"CZK\":\"CZK\",\"DJF\":\"DJF\",\"DKK\":\"DKK\",\"DOP\":\"DOP\",\"DZD\":\"DZD\",\"EGP\":\"EGP\",\"ERN\":\"ERN\",\"ETB\":\"ETB\",\"FJD\":\"FJD\",\"FKP\":\"FKP\",\"GEL\":\"GEL\",\"GGP\":\"GGP\",\"GHS\":\"GHS\",\"GIP\":\"GIP\",\"GMD\":\"GMD\",\"GNF\":\"GNF\",\"GTQ\":\"GTQ\",\"GYD\":\"GYD\",\"HNL\":\"HNL\",\"HRK\":\"HRK\",\"HTG\":\"HTG\",\"HUF\":\"HUF\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"IMP\":\"IMP\",\"IQD\":\"IQD\",\"IRR\":\"IRR\",\"ISK\":\"ISK\",\"JEP\":\"JEP\",\"JMD\":\"JMD\",\"JOD\":\"JOD\",\"KES\":\"KES\",\"KGS\":\"KGS\",\"KHR\":\"KHR\",\"KMF\":\"KMF\",\"KPW\":\"KPW\",\"KWD\":\"KWD\",\"KYD\":\"KYD\",\"KZT\":\"KZT\",\"LAK\":\"LAK\",\"LBP\":\"LBP\",\"LKR\":\"LKR\",\"LRD\":\"LRD\",\"LSL\":\"LSL\",\"LYD\":\"LYD\",\"MAD\":\"MAD\",\"MDL\":\"MDL\",\"MGA\":\"MGA\",\"MKD\":\"MKD\",\"MMK\":\"MMK\",\"MNT\":\"MNT\",\"MOP\":\"MOP\",\"MRO\":\"MRO\",\"MUR\":\"MUR\",\"MVR\":\"MVR\",\"MWK\":\"MWK\",\"MYR\":\"MYR\",\"MZN\":\"MZN\",\"NAD\":\"NAD\",\"NGN\":\"NGN\",\"NIO\":\"NIO\",\"NPR\":\"NPR\",\"OMR\":\"OMR\",\"PAB\":\"PAB\",\"PEN\":\"PEN\",\"PGK\":\"PGK\",\"PHP\":\"PHP\",\"PKR\":\"PKR\",\"PLN\":\"PLN\",\"PYG\":\"PYG\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RSD\":\"RSD\",\"RWF\":\"RWF\",\"SAR\":\"SAR\",\"SBD\":\"SBD\",\"SCR\":\"SCR\",\"SDG\":\"SDG\",\"SHP\":\"SHP\",\"SLL\":\"SLL\",\"SOS\":\"SOS\",\"SRD\":\"SRD\",\"SSP\":\"SSP\",\"STD\":\"STD\",\"SVC\":\"SVC\",\"SYP\":\"SYP\",\"SZL\":\"SZL\",\"THB\":\"THB\",\"TJS\":\"TJS\",\"TMT\":\"TMT\",\"TND\":\"TND\",\"TOP\":\"TOP\",\"TTD\":\"TTD\",\"TWD\":\"TWD\",\"TZS\":\"TZS\",\"UAH\":\"UAH\",\"UGX\":\"UGX\",\"UYU\":\"UYU\",\"UZS\":\"UZS\",\"VEF\":\"VEF\",\"VND\":\"VND\",\"VUV\":\"VUV\",\"WST\":\"WST\",\"XAF\":\"XAF\",\"XAG\":\"XAG\",\"XAU\":\"XAU\",\"XCD\":\"XCD\",\"XDR\":\"XDR\",\"XOF\":\"XOF\",\"XPD\":\"XPD\",\"XPF\":\"XPF\",\"XPT\":\"XPT\",\"YER\":\"YER\",\"ZMW\":\"ZMW\",\"ZWL\":\"ZWL\"}\r\n\r\n',0,'{\"endpoint\":{\"title\": \"Webhook Endpoint\",\"value\":\"ipn.CoinbaseCommerce\"}}',NULL,'2019-09-14 13:14:22','2024-05-07 08:11:10'),(24,0,113,'Paypal Express','PaypalSdk','663a38ed101a61715091693.png',1,'{\"clientId\":{\"title\":\"Paypal Client ID\",\"global\":true,\"value\":\"Ae0-tixtSV7DvLwIh3Bmu7JvHrjh5EfGdXr_cEklKAVjjezRZ747BxKILiBdzlKKyp-W8W_T7CKH1Ken\"},\"clientSecret\":{\"title\":\"Client Secret\",\"global\":true,\"value\":\"EOhbvHZgFNO21soQJT1L9Q00M3rK6PIEsdiTgXRBt2gtGtxwRer5JvKnVUGNU5oE63fFnjnYY7hq3HBA\"}}','{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"$\"}',0,NULL,NULL,'2019-09-14 13:14:22','2024-05-07 08:21:33'),(25,0,114,'Stripe Checkout','StripeV3','663a39afb519f1715091887.png',1,'{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_test_51I6GGiCGv1sRiQlEi5v1or9eR0HVbuzdMd2rW4n3DxC8UKfz66R4X6n4yYkzvI2LeAIuRU9H99ZpY7XCNFC9xMs500vBjZGkKG\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_51I6GGiCGv1sRiQlEOisPKrjBqQqqcFsw8mXNaZ2H2baN6R01NulFS7dKFji1NRRxuchoUTEDdB7ujKcyKYSVc0z500eth7otOM\"},\"end_point\":{\"title\":\"End Point Secret\",\"global\":true,\"value\":\"whsec_lUmit1gtxwKTveLnSe88xCSDdnPOt8g5\"}}','{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}',0,'{\"webhook\":{\"title\": \"Webhook Endpoint\",\"value\":\"ipn.StripeV3\"}}',NULL,'2019-09-14 13:14:22','2024-05-07 08:24:47'),(27,0,115,'Mollie','Mollie','663a387ec69371715091582.png',1,'{\"mollie_email\":{\"title\":\"Mollie Email \",\"global\":true,\"value\":\"vi@gmail.com\"},\"api_key\":{\"title\":\"API KEY\",\"global\":true,\"value\":\"test_cucfwKTWfft9s337qsVfn5CC4vNkrn\"}}','{\"AED\":\"AED\",\"AUD\":\"AUD\",\"BGN\":\"BGN\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"HRK\":\"HRK\",\"HUF\":\"HUF\",\"ILS\":\"ILS\",\"ISK\":\"ISK\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\"}',0,NULL,NULL,'2019-09-14 13:14:22','2024-05-07 08:19:42'),(30,0,116,'Cashmaal','Cashmaal','663a361b16bd11715090971.png',1,'{\"web_id\":{\"title\":\"Web Id\",\"global\":true,\"value\":\"3748\"},\"ipn_key\":{\"title\":\"IPN Key\",\"global\":true,\"value\":\"546254628759524554647987\"}}','{\"PKR\":\"PKR\",\"USD\":\"USD\"}',0,'{\"webhook\":{\"title\": \"IPN URL\",\"value\":\"ipn.Cashmaal\"}}',NULL,NULL,'2024-05-07 08:09:31'),(36,0,119,'Mercado Pago','MercadoPago','663a386c714a91715091564.png',1,'{\"access_token\":{\"title\":\"Access Token\",\"global\":true,\"value\":\"APP_USR-7924565816849832-082312-21941521997fab717db925cf1ea2c190-1071840315\"}}','{\"USD\":\"USD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"NOK\":\"NOK\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"AUD\":\"AUD\",\"NZD\":\"NZD\"}',0,NULL,NULL,NULL,'2024-05-07 08:19:24'),(37,0,120,'Authorize.net','Authorize','663a35b9ca5991715090873.png',1,'{\"login_id\":{\"title\":\"Login ID\",\"global\":true,\"value\":\"59e4P9DBcZv\"},\"transaction_key\":{\"title\":\"Transaction Key\",\"global\":true,\"value\":\"47x47TJyLw2E7DbR\"}}','{\"USD\":\"USD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"NOK\":\"NOK\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"AUD\":\"AUD\",\"NZD\":\"NZD\"}',0,NULL,NULL,NULL,'2024-05-07 08:07:53'),(46,0,121,'NMI','NMI','663a3897754cf1715091607.png',1,'{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"2F822Rw39fx762MaV7Yy86jXGTC7sCDy\"}}','{\"AED\":\"AED\",\"ARS\":\"ARS\",\"AUD\":\"AUD\",\"BOB\":\"BOB\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"COP\":\"COP\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PEN\":\"PEN\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"PYG\":\"PYG\",\"RUB\":\"RUB\",\"SEC\":\"SEC\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TRY\":\"TRY\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\"}',0,NULL,NULL,NULL,'2024-05-07 08:20:07'),(50,0,507,'BTCPay','BTCPay','663a35cd25a8d1715090893.png',1,'{\"store_id\":{\"title\":\"Store Id\",\"global\":true,\"value\":\"HsqFVTXSeUFJu7caoYZc3CTnP8g5LErVdHhEXPVTheHf\"},\"api_key\":{\"title\":\"Api Key\",\"global\":true,\"value\":\"4436bd706f99efae69305e7c4eff4780de1335ce\"},\"server_name\":{\"title\":\"Server Name\",\"global\":true,\"value\":\"https:\\/\\/testnet.demo.btcpayserver.org\"},\"secret_code\":{\"title\":\"Secret Code\",\"global\":true,\"value\":\"SUCdqPn9CDkY7RmJHfpQVHP2Lf2\"}}','{\"BTC\":\"Bitcoin\",\"LTC\":\"Litecoin\"}',1,'{\"webhook\":{\"title\": \"IPN URL\",\"value\":\"ipn.BTCPay\"}}',NULL,NULL,'2024-05-07 08:08:13'),(51,0,508,'Now payments hosted','NowPaymentsHosted','663a38b8d57a81715091640.png',1,'{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"--------\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"------------\"}}','{\"BTG\":\"BTG\",\"ETH\":\"ETH\",\"XMR\":\"XMR\",\"ZEC\":\"ZEC\",\"XVG\":\"XVG\",\"ADA\":\"ADA\",\"LTC\":\"LTC\",\"BCH\":\"BCH\",\"QTUM\":\"QTUM\",\"DASH\":\"DASH\",\"XLM\":\"XLM\",\"XRP\":\"XRP\",\"XEM\":\"XEM\",\"DGB\":\"DGB\",\"LSK\":\"LSK\",\"DOGE\":\"DOGE\",\"TRX\":\"TRX\",\"KMD\":\"KMD\",\"REP\":\"REP\",\"BAT\":\"BAT\",\"ARK\":\"ARK\",\"WAVES\":\"WAVES\",\"BNB\":\"BNB\",\"XZC\":\"XZC\",\"NANO\":\"NANO\",\"TUSD\":\"TUSD\",\"VET\":\"VET\",\"ZEN\":\"ZEN\",\"GRS\":\"GRS\",\"FUN\":\"FUN\",\"NEO\":\"NEO\",\"GAS\":\"GAS\",\"PAX\":\"PAX\",\"USDC\":\"USDC\",\"ONT\":\"ONT\",\"XTZ\":\"XTZ\",\"LINK\":\"LINK\",\"RVN\":\"RVN\",\"BNBMAINNET\":\"BNBMAINNET\",\"ZIL\":\"ZIL\",\"BCD\":\"BCD\",\"USDT\":\"USDT\",\"USDTERC20\":\"USDTERC20\",\"CRO\":\"CRO\",\"DAI\":\"DAI\",\"HT\":\"HT\",\"WABI\":\"WABI\",\"BUSD\":\"BUSD\",\"ALGO\":\"ALGO\",\"USDTTRC20\":\"USDTTRC20\",\"GT\":\"GT\",\"STPT\":\"STPT\",\"AVA\":\"AVA\",\"SXP\":\"SXP\",\"UNI\":\"UNI\",\"OKB\":\"OKB\",\"BTC\":\"BTC\"}',1,'',NULL,NULL,'2024-05-07 08:20:40'),(52,0,509,'Now payments checkout','NowPaymentsCheckout','663a38a59d2541715091621.png',1,'{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"---------------\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"-----------\"}}','{\"USD\":\"USD\",\"EUR\":\"EUR\"}',1,'',NULL,NULL,'2024-05-07 08:20:21'),(53,0,122,'2Checkout','TwoCheckout','663a39b8e64b91715091896.png',1,'{\"merchant_code\":{\"title\":\"Merchant Code\",\"global\":true,\"value\":\"253248016872\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"eQM)ID@&vG84u!O*g[p+\"}}','{\"AFN\": \"AFN\",\"ALL\": \"ALL\",\"DZD\": \"DZD\",\"ARS\": \"ARS\",\"AUD\": \"AUD\",\"AZN\": \"AZN\",\"BSD\": \"BSD\",\"BDT\": \"BDT\",\"BBD\": \"BBD\",\"BZD\": \"BZD\",\"BMD\": \"BMD\",\"BOB\": \"BOB\",\"BWP\": \"BWP\",\"BRL\": \"BRL\",\"GBP\": \"GBP\",\"BND\": \"BND\",\"BGN\": \"BGN\",\"CAD\": \"CAD\",\"CLP\": \"CLP\",\"CNY\": \"CNY\",\"COP\": \"COP\",\"CRC\": \"CRC\",\"HRK\": \"HRK\",\"CZK\": \"CZK\",\"DKK\": \"DKK\",\"DOP\": \"DOP\",\"XCD\": \"XCD\",\"EGP\": \"EGP\",\"EUR\": \"EUR\",\"FJD\": \"FJD\",\"GTQ\": \"GTQ\",\"HKD\": \"HKD\",\"HNL\": \"HNL\",\"HUF\": \"HUF\",\"INR\": \"INR\",\"IDR\": \"IDR\",\"ILS\": \"ILS\",\"JMD\": \"JMD\",\"JPY\": \"JPY\",\"KZT\": \"KZT\",\"KES\": \"KES\",\"LAK\": \"LAK\",\"MMK\": \"MMK\",\"LBP\": \"LBP\",\"LRD\": \"LRD\",\"MOP\": \"MOP\",\"MYR\": \"MYR\",\"MVR\": \"MVR\",\"MRO\": \"MRO\",\"MUR\": \"MUR\",\"MXN\": \"MXN\",\"MAD\": \"MAD\",\"NPR\": \"NPR\",\"TWD\": \"TWD\",\"NZD\": \"NZD\",\"NIO\": \"NIO\",\"NOK\": \"NOK\",\"PKR\": \"PKR\",\"PGK\": \"PGK\",\"PEN\": \"PEN\",\"PHP\": \"PHP\",\"PLN\": \"PLN\",\"QAR\": \"QAR\",\"RON\": \"RON\",\"RUB\": \"RUB\",\"WST\": \"WST\",\"SAR\": \"SAR\",\"SCR\": \"SCR\",\"SGD\": \"SGD\",\"SBD\": \"SBD\",\"ZAR\": \"ZAR\",\"KRW\": \"KRW\",\"LKR\": \"LKR\",\"SEK\": \"SEK\",\"CHF\": \"CHF\",\"SYP\": \"SYP\",\"THB\": \"THB\",\"TOP\": \"TOP\",\"TTD\": \"TTD\",\"TRY\": \"TRY\",\"UAH\": \"UAH\",\"AED\": \"AED\",\"USD\": \"USD\",\"VUV\": \"VUV\",\"VND\": \"VND\",\"XOF\": \"XOF\",\"YER\": \"YER\"}',0,'{\"approved_url\":{\"title\": \"Approved URL\",\"value\":\"ipn.TwoCheckout\"}}',NULL,NULL,'2024-05-07 08:24:56'),(54,0,123,'Checkout','Checkout','663a3628733351715090984.png',1,'{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"------\"},\"public_key\":{\"title\":\"PUBLIC KEY\",\"global\":true,\"value\":\"------\"},\"processing_channel_id\":{\"title\":\"PROCESSING CHANNEL\",\"global\":true,\"value\":\"------\"}}','{\"USD\":\"USD\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"AUD\":\"AUD\",\"CAN\":\"CAN\",\"CHF\":\"CHF\",\"SGD\":\"SGD\",\"JPY\":\"JPY\",\"NZD\":\"NZD\"}',0,NULL,NULL,NULL,'2024-05-07 08:09:44'),(56,0,510,'Binance','Binance','663a35db4fd621715090907.png',1,'{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"tsu3tjiq0oqfbtmlbevoeraxhfbp3brejnm9txhjxcp4to29ujvakvfl1ibsn3ja\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"jzngq4t04ltw8d4iqpi7admfl8tvnpehxnmi34id1zvfaenbwwvsvw7llw3zdko8\"},\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"231129033\"}}','{\"BTC\":\"Bitcoin\",\"USD\":\"USD\",\"BNB\":\"BNB\"}',1,'{\"cron\":{\"title\": \"Cron Job URL\",\"value\":\"ipn.Binance\"}}',NULL,NULL,'2024-05-07 08:08:27'),(57,0,124,'SslCommerz','SslCommerz','663a397a70c571715091834.png',1,'{\"store_id\":{\"title\":\"Store ID\",\"global\":true,\"value\":\"---------\"},\"store_password\":{\"title\":\"Store Password\",\"global\":true,\"value\":\"----------\"}}','{\"BDT\":\"BDT\",\"USD\":\"USD\",\"EUR\":\"EUR\",\"SGD\":\"SGD\",\"INR\":\"INR\",\"MYR\":\"MYR\"}',0,NULL,NULL,NULL,'2024-05-07 08:23:54'),(58,0,125,'Aamarpay','Aamarpay','663a34d5d1dfc1715090645.png',1,'{\"store_id\":{\"title\":\"Store ID\",\"global\":true,\"value\":\"---------\"},\"signature_key\":{\"title\":\"Signature Key\",\"global\":true,\"value\":\"----------\"}}','{\"BDT\":\"BDT\"}',0,NULL,NULL,NULL,'2024-05-07 08:04:05');
/*!40000 ALTER TABLE `gateways` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `general_settings`
--

DROP TABLE IF EXISTS `general_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `general_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `site_name` varchar(40) DEFAULT NULL,
  `cur_text` varchar(40) DEFAULT NULL COMMENT 'currency text',
  `cur_sym` varchar(40) DEFAULT NULL COMMENT 'currency symbol',
  `email_from` varchar(40) DEFAULT NULL,
  `email_from_name` varchar(255) DEFAULT NULL,
  `email_template` text DEFAULT NULL,
  `sms_template` varchar(255) DEFAULT NULL,
  `sms_from` varchar(255) DEFAULT NULL,
  `push_title` varchar(255) DEFAULT NULL,
  `push_template` varchar(255) DEFAULT NULL,
  `base_color` varchar(40) DEFAULT NULL,
  `mail_config` text DEFAULT NULL COMMENT 'email configuration',
  `sms_config` text DEFAULT NULL,
  `firebase_config` text DEFAULT NULL,
  `global_shortcodes` text DEFAULT NULL,
  `kv` tinyint(1) NOT NULL DEFAULT 0,
  `influencer_kv` tinyint(1) NOT NULL DEFAULT 0,
  `ev` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'email verification, 0 - dont check, 1 - check',
  `en` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'email notification, 0 - dont send, 1 - send',
  `sv` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'mobile verication, 0 - dont check, 1 - check',
  `sn` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'sms notification, 0 - dont send, 1 - send',
  `pn` tinyint(1) NOT NULL DEFAULT 1,
  `force_ssl` tinyint(1) NOT NULL DEFAULT 0,
  `in_app_payment` tinyint(1) NOT NULL DEFAULT 1,
  `maintenance_mode` tinyint(1) NOT NULL DEFAULT 0,
  `secure_password` tinyint(1) NOT NULL DEFAULT 0,
  `agree` tinyint(1) NOT NULL DEFAULT 0,
  `multi_language` tinyint(1) NOT NULL DEFAULT 1,
  `registration` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: Off	, 1: On',
  `influencer_registration` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0: Off , 1: On ',
  `active_template` varchar(40) DEFAULT NULL,
  `socialite_credentials` text DEFAULT NULL,
  `last_cron` datetime DEFAULT NULL,
  `available_version` varchar(40) DEFAULT NULL,
  `system_customized` tinyint(1) NOT NULL DEFAULT 0,
  `max_image_upload` int(11) DEFAULT 0,
  `campaign_approval_charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `brand_register_bonus_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `influencer_register_bonus_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `campaign_approve` tinyint(1) NOT NULL DEFAULT 0,
  `branregister_commission` tinyint(1) NOT NULL DEFAULT 0,
  `influencer_register_commission` tinyint(1) NOT NULL DEFAULT 0,
  `brand_register_commission` tinyint(1) NOT NULL DEFAULT 0,
  `influencer_withdrawal_commission` tinyint(1) NOT NULL DEFAULT 0,
  `campaign_charge` tinyint(1) NOT NULL DEFAULT 0,
  `paginate_number` int(11) NOT NULL DEFAULT 0,
  `currency_format` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=>Both\r\n2=>Text Only\r\n3=>Symbol Only',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `brand_campaign_commission` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `influencer_campaign_commission` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `gst_rate` decimal(5,2) NOT NULL DEFAULT 15.00,
  `marketplace_commission_gst_rate` decimal(5,2) NOT NULL DEFAULT 15.00,
  `influencer_gst_rate` decimal(5,2) NOT NULL DEFAULT 15.00,
  `marketplace_gst_return_rate` decimal(5,2) NOT NULL DEFAULT 8.50,
  `marketplace_gst_return_to` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1: Influencer, 2: Marketplace',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general_settings`
--

LOCK TABLES `general_settings` WRITE;
/*!40000 ALTER TABLE `general_settings` DISABLE KEYS */;
INSERT INTO `general_settings` VALUES (1,'Influenced','NZD','$','info@viserlab.com','{{site_name}}','<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\r\n  <!--[if !mso]><!-->\r\n  <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\r\n  <!--<![endif]-->\r\n  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\r\n  <title></title>\r\n  <style type=\"text/css\">\r\n.ReadMsgBody { width: 100%; background-color: #ffffff; }\r\n.ExternalClass { width: 100%; background-color: #ffffff; }\r\n.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div { line-height: 100%; }\r\nhtml { width: 100%; }\r\nbody { -webkit-text-size-adjust: none; -ms-text-size-adjust: none; margin: 0; padding: 0; }\r\ntable { border-spacing: 0; table-layout: fixed; margin: 0 auto;border-collapse: collapse; }\r\ntable table table { table-layout: auto; }\r\n.yshortcuts a { border-bottom: none !important; }\r\nimg:hover { opacity: 0.9 !important; }\r\na { color: #0087ff; text-decoration: none; }\r\n.textbutton a { font-family: \'open sans\', arial, sans-serif !important;}\r\n.btn-link a { color:#FFFFFF !important;}\r\n\r\n@media only screen and (max-width: 480px) {\r\nbody { width: auto !important; }\r\n*[class=\"table-inner\"] { width: 90% !important; text-align: center !important; }\r\n*[class=\"table-full\"] { width: 100% !important; text-align: center !important; }\r\n/* image */\r\nimg[class=\"img1\"] { width: 100% !important; height: auto !important; }\r\n}\r\n</style>\r\n\r\n\r\n\r\n  <table bgcolor=\"#414a51\" width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n    <tbody><tr>\r\n      <td height=\"50\"></td>\r\n    </tr>\r\n    <tr>\r\n      <td align=\"center\" style=\"text-align:center;vertical-align:top;font-size:0;\">\r\n        <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n          <tbody><tr>\r\n            <td align=\"center\" width=\"600\">\r\n              <!--header-->\r\n              <table class=\"table-inner\" width=\"95%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n                <tbody><tr>\r\n                  <td bgcolor=\"#0087ff\" style=\"border-top-left-radius:6px; border-top-right-radius:6px;text-align:center;vertical-align:top;font-size:0;\" align=\"center\">\r\n                    <table width=\"90%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n                      <tbody><tr>\r\n                        <td height=\"20\"></td>\r\n                      </tr>\r\n                      <tr>\r\n                        <td align=\"center\" style=\"font-family: \'Open sans\', Arial, sans-serif; color:#FFFFFF; font-size:16px; font-weight: bold;\">This is a System Generated Email</td>\r\n                      </tr>\r\n                      <tr>\r\n                        <td height=\"20\"></td>\r\n                      </tr>\r\n                    </tbody></table>\r\n                  </td>\r\n                </tr>\r\n              </tbody></table>\r\n              <!--end header-->\r\n              <table class=\"table-inner\" width=\"95%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n                <tbody><tr>\r\n                  <td bgcolor=\"#FFFFFF\" align=\"center\" style=\"text-align:center;vertical-align:top;font-size:0;\">\r\n                    <table align=\"center\" width=\"90%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n                      <tbody><tr>\r\n                        <td height=\"35\"></td>\r\n                      </tr>\r\n                      <!--logo-->\r\n                      <tr>\r\n                        <td align=\"center\" style=\"vertical-align:top;font-size:0;\">\r\n                          <a href=\"#\">\r\n                            <img style=\"display:block; line-height:0px; font-size:0px; border:0px;\" src=\"https://i.ibb.co/rw2fTRM/logo-dark.png\" width=\"220\" alt=\"img\">\r\n                          </a>\r\n                        </td>\r\n                      </tr>\r\n                      <!--end logo-->\r\n                      <tr>\r\n                        <td height=\"40\"></td>\r\n                      </tr>\r\n                      <!--headline-->\r\n                      <tr>\r\n                        <td align=\"center\" style=\"font-family: \'Open Sans\', Arial, sans-serif; font-size: 22px;color:#414a51;font-weight: bold;\">Hello {{fullname}} ({{username}})</td>\r\n                      </tr>\r\n                      <!--end headline-->\r\n                      <tr>\r\n                        <td align=\"center\" style=\"text-align:center;vertical-align:top;font-size:0;\">\r\n                          <table width=\"40\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n                            <tbody><tr>\r\n                              <td height=\"20\" style=\" border-bottom:3px solid #0087ff;\"></td>\r\n                            </tr>\r\n                          </tbody></table>\r\n                        </td>\r\n                      </tr>\r\n                      <tr>\r\n                        <td height=\"20\"></td>\r\n                      </tr>\r\n                      <!--content-->\r\n                      <tr>\r\n                        <td align=\"left\" style=\"font-family: \'Open sans\', Arial, sans-serif; color:#7f8c8d; font-size:16px; line-height: 28px;\">{{message}}</td>\r\n                      </tr>\r\n                      <!--end content-->\r\n                      <tr>\r\n                        <td height=\"40\"></td>\r\n                      </tr>\r\n              \r\n                    </tbody></table>\r\n                  </td>\r\n                </tr>\r\n                <tr>\r\n                  <td height=\"45\" align=\"center\" bgcolor=\"#f4f4f4\" style=\"border-bottom-left-radius:6px;border-bottom-right-radius:6px;\">\r\n                    <table align=\"center\" width=\"90%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n                      <tbody><tr>\r\n                        <td height=\"10\"></td>\r\n                      </tr>\r\n                      <!--preference-->\r\n                      <tr>\r\n                        <td class=\"preference-link\" align=\"center\" style=\"font-family: \'Open sans\', Arial, sans-serif; color:#95a5a6; font-size:14px;\">\r\n                          © 2024 <a href=\"#\">{{site_name}}</a>&nbsp;. All Rights Reserved. \r\n                        </td>\r\n                      </tr>\r\n                      <!--end preference-->\r\n                      <tr>\r\n                        <td height=\"10\"></td>\r\n                      </tr>\r\n                    </tbody></table>\r\n                  </td>\r\n                </tr>\r\n              </tbody></table>\r\n            </td>\r\n          </tr>\r\n        </tbody></table>\r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td height=\"60\"></td>\r\n    </tr>\r\n  </tbody></table>','hi {{fullname}} ({{username}}), {{message}}','{{site_name}}','{{site_name}}','hi {{fullname}} ({{username}}), {{message}}','df3459','{\"name\":\"php\"}','{\"name\":\"clickatell\",\"clickatell\":{\"api_key\":\"----------------\"},\"infobip\":{\"username\":\"------------8888888\",\"password\":\"-----------------\"},\"message_bird\":{\"api_key\":\"-------------------\"},\"nexmo\":{\"api_key\":\"----------------------\",\"api_secret\":\"----------------------\"},\"sms_broadcast\":{\"username\":\"----------------------\",\"password\":\"-----------------------------\"},\"twilio\":{\"account_sid\":\"-----------------------\",\"auth_token\":\"---------------------------\",\"from\":\"----------------------\"},\"text_magic\":{\"username\":\"-----------------------\",\"apiv2_key\":\"-------------------------------\"},\"custom\":{\"method\":\"get\",\"url\":\"https:\\/\\/hostname.com\\/demo-api-v1\",\"headers\":{\"name\":[\"api_key\"],\"value\":[\"test_api 555\"]},\"body\":{\"name\":[\"from_number\"],\"value\":[\"5657545757\"]}}}','{\"apiKey\":\"------------------------\",\"authDomain\":\"---------------------\",\"projectId\":\"----------------------\",\"storageBucket\":\"--------------------------\",\"messagingSenderId\":\"----------------------\",\"appId\":\"--------------------\",\"measurementId\":\"------------------------\"}','{\n    \"site_name\":\"Name of your site\",\n    \"site_currency\":\"Currency of your site\",\n    \"currency_symbol\":\"Symbol of currency\"\n}',0,0,0,0,0,0,0,0,0,0,0,1,1,1,1,'basic','{\"facebook\":{\"client_id\":\"----------------------\",\"client_secret\":\"---------------------\"},\"instagram\":{\"client_id\":\"---------------------\",\"client_secret\":\"--------------------\"},\"youtube\":{\"client_id\":\"---------------------------\",\"client_secret\":\"---------------------------\",\"api_key\":\"--------------------------\"},\"tiktok\":{\"client_id\":\"\",\"client_secret\":\"\"}}','2024-06-27 10:36:16','1.0.1',0,12,0.00000000,0.00000000,0.00000000,0,0,0,0,0,0,20,1,NULL,'2026-02-22 22:56:15',10.00000000,0.00000000,15.00,15.00,15.00,8.50,1);
/*!40000 ALTER TABLE `general_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `influencer_categories`
--

DROP TABLE IF EXISTS `influencer_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `influencer_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `influencer_id` int(10) unsigned NOT NULL DEFAULT 0,
  `category_id` int(10) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `influencer_id` (`influencer_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `influencer_categories`
--

LOCK TABLES `influencer_categories` WRITE;
/*!40000 ALTER TABLE `influencer_categories` DISABLE KEYS */;
INSERT INTO `influencer_categories` VALUES (1,1,1,NULL,NULL),(2,4,2,NULL,NULL),(3,5,2,NULL,NULL),(4,5,7,NULL,NULL),(5,6,2,NULL,NULL),(6,7,3,NULL,NULL),(7,7,4,NULL,NULL),(8,8,2,NULL,NULL);
/*!40000 ALTER TABLE `influencer_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `influencer_packages`
--

DROP TABLE IF EXISTS `influencer_packages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `influencer_packages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `influencer_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `platform_id` bigint(20) unsigned DEFAULT NULL,
  `delivery_time` int(11) NOT NULL DEFAULT 7,
  `post_count` int(11) NOT NULL DEFAULT 1,
  `video_length` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `influencer_packages`
--

LOCK TABLES `influencer_packages` WRITE;
/*!40000 ALTER TABLE `influencer_packages` DISABLE KEYS */;
INSERT INTO `influencer_packages` VALUES (1,5,'fdgsg','gdfg',100.00000000,'2026-02-19 04:24:29','2026-02-23 17:35:19',1,7,1,0),(2,5,'gdfg','gdfg',100.00000000,'2026-02-19 04:24:29','2026-02-23 17:35:19',2,7,1,0),(3,5,'gdfg','gdfg',100.00000000,'2026-02-19 04:24:29','2026-02-23 17:35:19',1,7,1,0),(4,6,'sdaf','fsadfsadf',45.00000000,'2026-02-19 10:15:27','2026-02-20 02:53:14',NULL,7,1,NULL),(5,6,'fsadf','fsadf',45.00000000,'2026-02-19 10:15:27','2026-02-20 02:53:14',NULL,7,1,NULL),(6,6,'sdf','fasdfasdf',56.00000000,'2026-02-19 10:15:27','2026-02-20 02:53:14',NULL,7,1,NULL),(7,7,'Basic Shotout','A shoutout for your brand. Words. A shoutout for your brand. Words. A shoutout for your brand. Words. A shoutout for your brand. Words. A shoutout for your brand. Words. A shoutout for your brand. Words. A shoutout for your brand. Words. A shoutout for your brand. Words. A shoutout for your brand. Words. A shoutout for your brand. Words. A shoutout for your brand. Words. A shoutout for your brand. Words. A shoutout for your brand. Words. A shoutout for your brand. Words. A shoutout for your brand. Words.',100.00000000,'2026-02-19 21:45:34','2026-02-21 03:44:09',1,7,1,0),(8,7,'Basic Reel','A basic reel for your brand',200.00000000,'2026-02-19 21:45:34','2026-02-21 03:44:09',1,7,1,0),(9,7,'Basic Photo','A basic photo for your brand',50.00000000,'2026-02-19 21:45:34','2026-02-21 03:44:09',1,7,1,0),(10,8,'Basic Reel','Greatness',100.00000000,'2026-02-20 03:11:37','2026-02-20 03:11:51',1,7,1,NULL),(11,8,'Basic Post','Greatness',100.00000000,'2026-02-20 03:11:37','2026-02-20 03:11:51',1,7,1,NULL),(12,8,'Basic Shoutout','Greatness',100.00000000,'2026-02-20 03:11:37','2026-02-20 03:11:51',1,7,1,NULL),(13,7,'Bundle','Greatness',50.00000000,'2026-02-20 22:37:24','2026-02-21 03:44:09',1,7,1,0),(14,7,'Reel','Great reels on instagram',50.00000000,'2026-02-20 22:46:51','2026-02-21 03:44:09',2,7,1,0);
/*!40000 ALTER TABLE `influencer_packages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `influencer_password_resets`
--

DROP TABLE IF EXISTS `influencer_password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `influencer_password_resets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(40) DEFAULT NULL,
  `token` varchar(40) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `influencer_password_resets`
--

LOCK TABLES `influencer_password_resets` WRITE;
/*!40000 ALTER TABLE `influencer_password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `influencer_password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `influencers`
--

DROP TABLE IF EXISTS `influencers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `influencers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(40) DEFAULT NULL,
  `lastname` varchar(40) DEFAULT NULL,
  `username` varchar(40) DEFAULT NULL,
  `email` varchar(40) NOT NULL,
  `dial_code` varchar(40) DEFAULT NULL,
  `country_code` varchar(40) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zip` varchar(255) DEFAULT NULL,
  `country_name` varchar(255) DEFAULT NULL,
  `mobile` varchar(40) DEFAULT NULL,
  `bio` varchar(255) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `ref_by` int(10) unsigned NOT NULL DEFAULT 0,
  `referral_code` varchar(40) DEFAULT NULL,
  `balance` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL COMMENT 'contains full address',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0: banned, 1: active',
  `is_gst_registered` tinyint(1) NOT NULL DEFAULT 0,
  `gst_number` varchar(255) DEFAULT NULL,
  `tax_number` varchar(255) DEFAULT NULL,
  `kyc_data` text DEFAULT NULL,
  `kyc_rejection_reason` varchar(255) DEFAULT NULL,
  `kv` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: KYC Unverified, 2: KYC pending, 1: KYC verified',
  `ev` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: email unverified, 1: email verified',
  `sv` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: mobile unverified, 1: mobile verified',
  `profile_complete` tinyint(1) NOT NULL DEFAULT 0,
  `profile_step` tinyint(4) NOT NULL DEFAULT 1,
  `ver_code` varchar(40) DEFAULT NULL COMMENT 'stores verification code',
  `ver_code_send_at` datetime DEFAULT NULL COMMENT 'verification send time',
  `ts` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: 2fa off, 1: 2fa on',
  `tv` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0: 2fa unverified, 1: 2fa verified',
  `tsc` varchar(255) DEFAULT NULL,
  `ban_reason` varchar(255) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `last_seen` timestamp NULL DEFAULT NULL,
  `order_completed` int(11) NOT NULL DEFAULT 0,
  `rating` decimal(5,2) NOT NULL DEFAULT 0.00,
  `total_review` int(11) NOT NULL DEFAULT 0,
  `skills` text DEFAULT NULL,
  `gender` varchar(40) DEFAULT NULL,
  `languages` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `engagement` varchar(255) DEFAULT NULL,
  `avg_views` varchar(255) DEFAULT NULL,
  `primary_gender` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `influencers`
--

LOCK TABLES `influencers` WRITE;
/*!40000 ALTER TABLE `influencers` DISABLE KEYS */;
INSERT INTO `influencers` VALUES (1,'Dylan','Schwartz','dymschwa','dymschwa@gmail.com','64','NZ','Queenstown',NULL,NULL,'9300','New Zealand','2352512',NULL,'2026-02-03',0,'Q92AYTLPXLQE',0.00000000,'$2y$12$uzVF2eSt6To5QIb3U5PqN.EF1h6D7icBaZdbTFVZkElv9WGYNIev2','6996729933a631771467417.jpg','96 Wynyard Crescent',1,0,NULL,NULL,NULL,NULL,1,1,1,1,2,NULL,NULL,0,1,NULL,NULL,NULL,'2026-02-19 03:16:05',0,0.00,0,NULL,'male',NULL,'2026-02-19 02:09:56','2026-02-19 04:13:51',NULL,NULL,NULL),(2,'Dylan','Schwartz',NULL,'dgsag@gmail.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'Z6DBWBB6HN4K',0.00000000,'$2y$12$LY94IEV8ikIHfMhzASWgA.aGjMa23p0l7hhfr4g7IrFmnR5I0XeUq',NULL,NULL,1,0,NULL,NULL,NULL,NULL,1,1,1,0,1,NULL,NULL,0,1,NULL,NULL,NULL,'2026-02-19 03:23:57',0,0.00,0,NULL,NULL,NULL,'2026-02-19 03:16:05','2026-02-19 04:13:57',NULL,NULL,NULL),(3,'Dylan','Schwartz',NULL,'dymschwa@gdsvmail.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'T1MW8SJK7AEW',0.00000000,'$2y$12$CATd3jh7jCqipaeFUuoJHOPVVWeiCetoaRgSDYphoRRgmGTHeS5ZG',NULL,NULL,1,0,NULL,NULL,NULL,NULL,1,1,1,0,1,NULL,NULL,0,1,NULL,NULL,NULL,'2026-02-19 03:24:20',0,0.00,0,NULL,NULL,NULL,'2026-02-19 03:23:58','2026-02-19 04:13:57',NULL,NULL,NULL),(4,'Toast','Films','dsgdsvg','hello@toast.wedding','64','NZ','gdfg',NULL,NULL,NULL,'New Zealand','43242421523',NULL,'2026-02-19',0,'FHZ8HXZV6J9E',0.00000000,'$2y$12$IXvEf3chxrE9akIbP37cmOo/YO2dI7z44ZjymBIQJvg0vujUykKPK','69968bbe46db81771473854.jpg',NULL,1,0,NULL,NULL,NULL,NULL,1,1,1,1,2,NULL,NULL,0,1,NULL,NULL,NULL,'2026-02-19 04:21:22',0,0.00,0,NULL,'male',NULL,'2026-02-19 03:24:20','2026-02-19 04:21:22',NULL,NULL,NULL),(5,'Dylan','Schwartz','dsfdasfdsf','dsgfds@gmail.com','64','NZ','Auckland','Auckland',NULL,NULL,'New Zealand','4324324432432','adsfsad','2026-02-19',0,'XH2LGYPAE1EC',60.00000000,'$2y$12$qpDjegguJ3gmGbKXlteQOu.WvBn6aeAODyNaj5f84O3uSvX2RiT5C','6996905e5c7fc1771475038.jpg','123 Mai. street',1,0,NULL,'123456789',NULL,NULL,1,1,1,1,3,NULL,NULL,0,1,NULL,NULL,NULL,'2026-02-23 17:53:59',1,0.00,0,NULL,'male',NULL,'2026-02-19 04:21:23','2026-02-23 17:53:59','5%','1.2K','Female'),(6,'dsfadf','fsadf','dsafdsf','fsdfsf@mail.com','64','NZ','Wellington','Wellington',NULL,NULL,'New Zealand','5432543','fdgdfgsdg','2026-02-03',0,'9AXJ88Z3YWXC',0.00000000,'$2y$12$2Evdxxn051BbBxsOoAmKh.mdhCsdcAGqkYbsQCv9enAFeg04nvx1u','6996e2a8cc48a1771496104.jpg',NULL,1,0,NULL,NULL,NULL,NULL,1,1,1,1,3,NULL,NULL,0,1,NULL,NULL,NULL,'2026-02-20 02:53:26',0,0.00,0,NULL,'male',NULL,'2026-02-19 10:14:29','2026-02-20 02:53:26',NULL,NULL,NULL),(7,'Influencer','Example','influencerexample','influencer@example.com','64','NZ','Queenstown','Otago',NULL,NULL,'New Zealand','1234532','I have been working with brands for a long time. They are everything to me.','1991-02-20',0,'31M6J1HFDCVN',1727.00000000,'$2y$12$H7PyKAIdr5O9yKkv530SD.cPOMAzRlAvSdxlXUsdKSdrT8zc7U6EC','6998da95849951771625109.JPG',NULL,1,0,NULL,NULL,NULL,NULL,1,1,1,1,3,NULL,NULL,0,1,NULL,NULL,NULL,'2026-02-23 18:01:50',12,4.64,11,NULL,'female',NULL,'2026-02-19 21:42:00','2026-02-23 18:01:50','5%','1.2K','Female'),(8,'Jane','Johnny','janeinfluencer','djdjd@gmail.com','64','NZ','Auckland','Auckland',NULL,NULL,'New Zealand','124343434','Greatness','2026-02-20',0,'SM87LWPMV5AW',0.00000000,'$2y$12$0cVBUjBwEn4B.6lqe0DXz.jt3zaBWxatqyzQtAMOZbzSPLOiIaiAO','6997cf4017dd51771556672.jpg',NULL,1,0,NULL,NULL,NULL,NULL,1,1,1,1,3,NULL,NULL,0,1,NULL,NULL,NULL,'2026-02-21 21:51:16',0,0.00,0,NULL,'female',NULL,'2026-02-20 03:03:09','2026-02-21 21:51:16',NULL,NULL,NULL);
/*!40000 ALTER TABLE `influencers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invite_campaigns`
--

DROP TABLE IF EXISTS `invite_campaigns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `invite_campaigns` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `campaign_id` int(10) unsigned NOT NULL DEFAULT 0,
  `influencer_id` int(10) unsigned NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invite_campaigns`
--

LOCK TABLES `invite_campaigns` WRITE;
/*!40000 ALTER TABLE `invite_campaigns` DISABLE KEYS */;
INSERT INTO `invite_campaigns` VALUES (1,3,5,1,'2026-02-19 08:19:15','2026-02-19 08:31:24');
/*!40000 ALTER TABLE `invite_campaigns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `languages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) DEFAULT NULL,
  `code` varchar(40) DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: not default language, 1: default language',
  `image` varchar(40) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `languages`
--

LOCK TABLES `languages` WRITE;
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;
INSERT INTO `languages` VALUES (1,'English','en',1,'66fbe212d637b1727783442.png','2020-07-06 03:47:55','2024-10-01 05:50:42'),(14,'Hindi','hi',0,'66fbe21c262581727783452.png','2024-10-01 05:50:52','2024-10-01 05:50:52'),(15,'Bangla','bn',0,'66fbe227099d21727783463.png','2024-10-01 05:51:03','2024-10-01 05:51:03');
/*!40000 ALTER TABLE `languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2024_01_01_000001_add_fields_to_influencer_packages',1),(2,'2024_01_01_000000_add_video_url_to_profile_galleries_table',2),(3,'0001_01_01_000000_create_users_table',1),(4,'0001_01_01_000001_create_cache_table',1),(5,'0001_01_01_000002_create_jobs_table',1),(6,'2024_01_01_000000_add_audience_to_influencers',1),(7,'2024_01_01_000002_create_plans_and_add_to_users',1),(8,'2026_02_21_070437_add_commission_fields_to_general_settings',1),(9,'2026_02_22_224545_add_action_to_deposits_table',3),(10,'2024_05_22_000000_add_gst_fields_to_influencers_table',4),(11,'2024_05_22_000001_add_gst_fields_to_transactions_and_participants',4),(12,'2024_05_22_000002_add_influencer_snapshot_to_participants',4),(13,'2024_05_22_000003_add_tax_fields_to_users_and_influencers',4),(14,'2024_05_25_000000_add_address_and_gst_to_users_and_influencers',4);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification_logs`
--

DROP TABLE IF EXISTS `notification_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `notification_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT 0,
  `influencer_id` int(10) unsigned NOT NULL DEFAULT 0,
  `sender` varchar(40) DEFAULT NULL,
  `sent_from` varchar(40) DEFAULT NULL,
  `sent_to` varchar(40) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `notification_type` varchar(40) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `user_read` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification_logs`
--

LOCK TABLES `notification_logs` WRITE;
/*!40000 ALTER TABLE `notification_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `notification_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification_templates`
--

DROP TABLE IF EXISTS `notification_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `notification_templates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `act` varchar(40) DEFAULT NULL,
  `name` varchar(40) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `push_title` varchar(255) DEFAULT NULL,
  `email_body` text DEFAULT NULL,
  `sms_body` text DEFAULT NULL,
  `push_body` text DEFAULT NULL,
  `shortcodes` text DEFAULT NULL,
  `email_status` tinyint(1) NOT NULL DEFAULT 1,
  `email_sent_from_name` varchar(40) DEFAULT NULL,
  `email_sent_from_address` varchar(40) DEFAULT NULL,
  `sms_status` tinyint(1) NOT NULL DEFAULT 1,
  `sms_sent_from` varchar(40) DEFAULT NULL,
  `push_status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification_templates`
--

LOCK TABLES `notification_templates` WRITE;
/*!40000 ALTER TABLE `notification_templates` DISABLE KEYS */;
INSERT INTO `notification_templates` VALUES (1,'BAL_ADD','Balance - Added','Your Account has been Credited','{{site_name}} - Balance Added','<div>We\'re writing to inform you that an amount of {{amount}} {{site_currency}} has been successfully added to your account.</div><div><br></div><div>Here are the details of the transaction:</div><div><br></div><div><b>Transaction Number: </b>{{trx}}</div><div><b>Current Balance:</b> {{post_balance}} {{site_currency}}</div><div><b>Admin Note:</b> {{remark}}</div><div><br></div><div>If you have any questions or require further assistance, please don\'t hesitate to contact us. We\'re here to assist you.</div>','We\'re writing to inform you that an amount of {{amount}} {{site_currency}} has been successfully added to your account.','{{amount}} {{site_currency}} has been successfully added to your account.','{\"trx\":\"Transaction number for the action\",\"amount\":\"Amount inserted by the admin\",\"remark\":\"Remark inserted by the admin\",\"post_balance\":\"Balance of the user after this transaction\"}',1,'{{site_name}} Finance',NULL,0,NULL,1,'2021-11-03 12:00:00','2024-05-25 00:49:44'),(2,'BAL_SUB','Balance - Subtracted','Your Account has been Debited','{{site_name}} - Balance Subtracted','<div>We wish to inform you that an amount of {{amount}} {{site_currency}} has been successfully deducted from your account.</div><div><br></div><div>Below are the details of the transaction:</div><div><br></div><div><b>Transaction Number:</b> {{trx}}</div><div><b>Current Balance: </b>{{post_balance}} {{site_currency}}</div><div><b>Admin Note:</b> {{remark}}</div><div><br></div><div>Should you require any further clarification or assistance, please do not hesitate to reach out to us. We are here to assist you in any way we can.</div><div><br></div><div>Thank you for your continued trust in {{site_name}}.</div>','We wish to inform you that an amount of {{amount}} {{site_currency}} has been successfully deducted from your account.','{{amount}} {{site_currency}} debited from your account.','{\"trx\":\"Transaction number for the action\",\"amount\":\"Amount inserted by the admin\",\"remark\":\"Remark inserted by the admin\",\"post_balance\":\"Balance of the user after this transaction\"}',1,'{{site_name}} Finance',NULL,1,NULL,0,'2021-11-03 12:00:00','2024-05-08 07:17:48'),(3,'DEPOSIT_COMPLETE','Deposit - Automated - Successful','Deposit Completed Successfully','{{site_name}} - Deposit successful','<div>We\'re delighted to inform you that your deposit of {{amount}} {{site_currency}} via {{method_name}} has been completed.</div><div><br></div><div>Below, you\'ll find the details of your deposit:</div><div><br></div><div><b>Amount:</b> {{amount}} {{site_currency}}</div><div><b>Charge: </b>{{charge}} {{site_currency}}</div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>Received:</b> {{method_amount}} {{method_currency}}</div><div><b>Paid via:</b> {{method_name}}</div><div><b>Transaction Number:</b> {{trx}}</div><div><br></div><div>Your current balance stands at {{post_balance}} {{site_currency}}.</div><div><br></div><div>If you have any questions or need further assistance, feel free to reach out to our support team. We\'re here to assist you in any way we can.</div>','We\'re delighted to inform you that your deposit of {{amount}} {{site_currency}} via {{method_name}} has been completed.','Deposit Completed Successfully','{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after this transaction\"}',1,'{{site_name}} Billing',NULL,1,NULL,1,'2021-11-03 12:00:00','2024-05-08 07:20:34'),(4,'DEPOSIT_APPROVE','Deposit - Manual - Approved','Deposit Request Approved','{{site_name}} - Deposit Request Approved','<div>We are pleased to inform you that your deposit request of {{amount}} {{site_currency}} via {{method_name}} has been approved.</div><div><br></div><div>Here are the details of your deposit:</div><div><br></div><div><b>Amount:</b> {{amount}} {{site_currency}}</div><div><b>Charge: </b>{{charge}} {{site_currency}}</div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>Received: </b>{{method_amount}} {{method_currency}}</div><div><b>Paid via: </b>{{method_name}}</div><div><b>Transaction Number: </b>{{trx}}</div><div><br></div><div>Your current balance now stands at {{post_balance}} {{site_currency}}.</div><div><br></div><div>Should you have any questions or require further assistance, please feel free to contact our support team. We\'re here to help.</div>','We are pleased to inform you that your deposit request of {{amount}} {{site_currency}} via {{method_name}} has been approved.','Deposit of {{amount}} {{site_currency}} via {{method_name}} has been approved.','{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after this transaction\"}',1,'{{site_name}} Billing',NULL,1,NULL,0,'2021-11-03 12:00:00','2024-05-08 07:19:49'),(5,'DEPOSIT_REJECT','Deposit - Manual - Rejected','Deposit Request Rejected','{{site_name}} - Deposit Request Rejected','<div>We regret to inform you that your deposit request of {{amount}} {{site_currency}} via {{method_name}} has been rejected.</div><div><br></div><div>Here are the details of the rejected deposit:</div><div><br></div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>Received:</b> {{method_amount}} {{method_currency}}</div><div><b>Paid via:</b> {{method_name}}</div><div><b>Charge:</b> {{charge}}</div><div><b>Transaction Number:</b> {{trx}}</div><div><br></div><div>If you have any questions or need further clarification, please don\'t hesitate to contact us. We\'re here to assist you.</div><div><br></div><div>Rejection Reason:</div><div>{{rejection_message}}</div><div><br></div><div>Thank you for your understanding.</div>','We regret to inform you that your deposit request of {{amount}} {{site_currency}} via {{method_name}} has been rejected.','Your deposit request of {{amount}} {{site_currency}} via {{method_name}} has been rejected.','{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"rejection_message\":\"Rejection message by the admin\"}',1,'{{site_name}} Billing',NULL,1,NULL,0,'2021-11-03 12:00:00','2024-05-08 07:20:13'),(6,'DEPOSIT_REQUEST','Deposit - Manual - Requested','Deposit Request Submitted Successfully',NULL,'<div>We are pleased to confirm that your deposit request of {{amount}} {{site_currency}} via {{method_name}} has been submitted successfully.</div><div><br></div><div>Below are the details of your deposit:</div><div><br></div><div><b>Amount:</b> {{amount}} {{site_currency}}</div><div><b>Charge:</b> {{charge}} {{site_currency}}</div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>Payable:</b> {{method_amount}} {{method_currency}}</div><div><b>Pay via: </b>{{method_name}}</div><div><b>Transaction Number:</b> {{trx}}</div><div><br></div><div>Should you have any questions or require further assistance, please feel free to reach out to our support team. We\'re here to assist you.</div>','We are pleased to confirm that your deposit request of {{amount}} {{site_currency}} via {{method_name}} has been submitted successfully.','Your deposit request of {{amount}} {{site_currency}} via {{method_name}} submitted successfully.','{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\"}',1,'{{site_name}} Billing',NULL,1,NULL,0,'2021-11-03 12:00:00','2024-04-25 03:27:42'),(7,'PASS_RESET_CODE','Password - Reset - Code','Password Reset','{{site_name}} Password Reset Code','<div>We\'ve received a request to reset the password for your account on <b>{{time}}</b>. The request originated from\r\n            the following IP address: <b>{{ip}}</b>, using <b>{{browser}}</b> on <b>{{operating_system}}</b>.\r\n    </div><br>\r\n    <div><span>To proceed with the password reset, please use the following account recovery code</span>: <span><b><font size=\"6\">{{code}}</font></b></span></div><br>\r\n    <div><span>If you did not initiate this password reset request, please disregard this message. Your account security\r\n            remains our top priority, and we advise you to take appropriate action if you suspect any unauthorized\r\n            access to your account.</span></div>','To proceed with the password reset, please use the following account recovery code: {{code}}','To proceed with the password reset, please use the following account recovery code: {{code}}','{\"code\":\"Verification code for password reset\",\"ip\":\"IP address of the user\",\"browser\":\"Browser of the user\",\"operating_system\":\"Operating system of the user\",\"time\":\"Time of the request\"}',1,'{{site_name}} Authentication Center',NULL,0,NULL,0,'2021-11-03 12:00:00','2024-05-08 07:24:57'),(8,'PASS_RESET_DONE','Password - Reset - Confirmation','Password Reset Successful',NULL,'<div><div><span>We are writing to inform you that the password reset for your account was successful. This action was completed at {{time}} from the following browser</span>: <span>{{browser}}</span><span>on {{operating_system}}, with the IP address</span>: <span>{{ip}}</span>.</div><br><div><span>Your account security is our utmost priority, and we are committed to ensuring the safety of your information. If you did not initiate this password reset or notice any suspicious activity on your account, please contact our support team immediately for further assistance.</span></div></div>','We are writing to inform you that the password reset for your account was successful.','We are writing to inform you that the password reset for your account was successful.','{\"ip\":\"IP address of the user\",\"browser\":\"Browser of the user\",\"operating_system\":\"Operating system of the user\",\"time\":\"Time of the request\"}',1,'{{site_name}} Authentication Center',NULL,1,NULL,0,'2021-11-03 12:00:00','2024-04-25 03:27:24'),(9,'ADMIN_SUPPORT_REPLY','Support - Reply','Re: {{ticket_subject}} - Ticket #{{ticket_id}}','{{site_name}} - Support Ticket Replied','<div>\r\n    <div><span>Thank you for reaching out to us regarding your support ticket with the subject</span>:\r\n        <span>\"{{ticket_subject}}\"&nbsp;</span><span>and ticket ID</span>: {{ticket_id}}.</div><br>\r\n    <div><span>We have carefully reviewed your inquiry, and we are pleased to provide you with the following\r\n            response</span><span>:</span></div><br>\r\n    <div>{{reply}}</div><br>\r\n    <div><span>If you have any further questions or need additional assistance, please feel free to reply by clicking on\r\n            the following link</span>: <a href=\"{{link}}\" title=\"\" target=\"_blank\">{{link}}</a><span>. This link will take you to\r\n            the ticket thread where you can provide further information or ask for clarification.</span></div><br>\r\n    <div><span>Thank you for your patience and cooperation as we worked to address your concerns.</span></div>\r\n</div>','Thank you for reaching out to us regarding your support ticket with the subject: \"{{ticket_subject}}\" and ticket ID: {{ticket_id}}. We have carefully reviewed your inquiry. To check the response, please go to the following link: {{link}}','Re: {{ticket_subject}} - Ticket #{{ticket_id}}','{\"ticket_id\":\"ID of the support ticket\",\"ticket_subject\":\"Subject  of the support ticket\",\"reply\":\"Reply made by the admin\",\"link\":\"URL to view the support ticket\"}',1,'{{site_name}} Support Team',NULL,1,NULL,0,'2021-11-03 12:00:00','2024-05-08 07:26:06'),(10,'EVER_CODE','Verification - Email','Email Verification Code',NULL,'<div>\r\n    <div><span>Thank you for taking the time to verify your email address with us. Your email verification code\r\n            is</span>: <b><font size=\"6\">{{code}}</font></b></div><br>\r\n    <div><span>Please enter this code in the designated field on our platform to complete the verification\r\n            process.</span></div><br>\r\n    <div><span>If you did not request this verification code, please disregard this email. Your account security is our\r\n            top priority, and we advise you to take appropriate measures if you suspect any unauthorized access.</span>\r\n    </div><br>\r\n    <div><span>If you have any questions or encounter any issues during the verification process, please don\'t hesitate\r\n            to contact our support team for assistance.</span></div><br>\r\n    <div><span>Thank you for choosing us.</span></div>\r\n</div>','---','---','{\"code\":\"Email verification code\"}',1,'{{site_name}} Verification Center',NULL,0,NULL,0,'2021-11-03 12:00:00','2024-04-25 03:27:12'),(11,'SVER_CODE','Verification - SMS','Verify Your Mobile Number',NULL,'---','Your mobile verification code is {{code}}. Please enter this code in the appropriate field to verify your mobile number. If you did not request this code, please ignore this message.','---','{\"code\":\"SMS Verification Code\"}',0,'{{site_name}} Verification Center',NULL,1,NULL,0,'2021-11-03 12:00:00','2024-04-25 03:27:03'),(12,'WITHDRAW_APPROVE','Withdraw - Approved','Withdrawal Confirmation: Your Request Processed Successfully','{{site_name}} - Withdrawal Request Approved','<div>We are writing to inform you that your withdrawal request of {{amount}} {{site_currency}} via {{method_name}} has been processed successfully.</div><div><br></div><div>Below are the details of your withdrawal:</div><div><br></div><div><b>Amount:</b> {{amount}} {{site_currency}}</div><div><b>Charge:</b> {{charge}} {{site_currency}}</div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>You will receive:</b> {{method_amount}} {{method_currency}}</div><div><b>Via:</b> {{method_name}}</div><div><b>Transaction Number:</b> {{trx}}</div><div><br></div><hr><div><br></div><div><b>Details of Processed Payment:</b></div><div>{{admin_details}}</div><div><br></div><div>Should you have any questions or require further assistance, feel free to reach out to our support team. We\'re here to help.</div>','We are writing to inform you that your withdrawal request of {{amount}} {{site_currency}} via {{method_name}} has been processed successfully.','Withdrawal Confirmation: Your Request Processed Successfully','{\"trx\":\"Transaction number for the withdraw\",\"amount\":\"Amount requested by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the withdraw method\",\"method_currency\":\"Currency of the withdraw method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"admin_details\":\"Details provided by the admin\"}',1,'{{site_name}} Finance',NULL,1,NULL,0,'2021-11-03 12:00:00','2024-05-08 07:26:37'),(13,'WITHDRAW_REJECT','Withdraw - Rejected','Withdrawal Request Rejected','{{site_name}} - Withdrawal Request Rejected','<div>We regret to inform you that your withdrawal request of {{amount}} {{site_currency}} via {{method_name}} has been rejected.</div><div><br></div><div>Here are the details of your withdrawal:</div><div><br></div><div><b>Amount:</b> {{amount}} {{site_currency}}</div><div><b>Charge:</b> {{charge}} {{site_currency}}</div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>Expected Amount:</b> {{method_amount}} {{method_currency}}</div><div><b>Via:</b> {{method_name}}</div><div><b>Transaction Number:</b> {{trx}}</div><div><br></div><hr><div><br></div><div><b>Refund Details:</b></div><div>{{amount}} {{site_currency}} has been refunded to your account, and your current balance is {{post_balance}} {{site_currency}}.</div><div><br></div><hr><div><br></div><div><b>Reason for Rejection:</b></div><div>{{admin_details}}</div><div><br></div><div>If you have any questions or concerns regarding this rejection or need further assistance, please do not hesitate to contact our support team. We apologize for any inconvenience this may have caused.</div>','We regret to inform you that your withdrawal request of {{amount}} {{site_currency}} via {{method_name}} has been rejected.','Withdrawal Request Rejected','{\"trx\":\"Transaction number for the withdraw\",\"amount\":\"Amount requested by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the withdraw method\",\"method_currency\":\"Currency of the withdraw method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after fter this action\",\"admin_details\":\"Rejection message by the admin\"}',1,'{{site_name}} Finance',NULL,1,NULL,0,'2021-11-03 12:00:00','2024-05-08 07:26:55'),(14,'WITHDRAW_REQUEST','Withdraw - Requested','Withdrawal Request Confirmation','{{site_name}} - Requested for withdrawal','<div>We are pleased to inform you that your withdrawal request of {{amount}} {{site_currency}} via {{method_name}} has been submitted successfully.</div><div><br></div><div>Here are the details of your withdrawal:</div><div><br></div><div><b>Amount:</b> {{amount}} {{site_currency}}</div><div><b>Charge:</b> {{charge}} {{site_currency}}</div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>Expected Amount:</b> {{method_amount}} {{method_currency}}</div><div><b>Via:</b> {{method_name}}</div><div><b>Transaction Number:</b> {{trx}}</div><div><br></div><div>Your current balance is {{post_balance}} {{site_currency}}.</div><div><br></div><div>Should you have any questions or require further assistance, feel free to reach out to our support team. We\'re here to help.</div>','We are pleased to inform you that your withdrawal request of {{amount}} {{site_currency}} via {{method_name}} has been submitted successfully.','Withdrawal request submitted successfully','{\"trx\":\"Transaction number for the withdraw\",\"amount\":\"Amount requested by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the withdraw method\",\"method_currency\":\"Currency of the withdraw method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after fter this transaction\"}',1,'{{site_name}} Finance',NULL,1,NULL,0,'2021-11-03 12:00:00','2024-05-08 07:27:20'),(15,'DEFAULT','Default Template','{{subject}}','{{subject}}','{{message}}','{{message}}','{{message}}','{\"subject\":\"Subject\",\"message\":\"Message\"}',1,NULL,NULL,1,NULL,1,'2019-09-14 13:14:22','2024-05-16 01:32:53'),(16,'KYC_APPROVE','KYC Approved','KYC Details has been approved','{{site_name}} - KYC Approved','<div><div><span>We are pleased to inform you that your Know Your Customer (KYC) information has been successfully reviewed and approved. This means that you are now eligible to conduct any payout operations within our system.</span></div><br><div><span>Your commitment to completing the KYC process promptly is greatly appreciated, as it helps us ensure the security and integrity of our platform for all users.</span></div><br><div><span>With your KYC verification now complete, you can proceed with confidence to carry out any payout transactions you require. Should you encounter any issues or have any questions along the way, please don\'t hesitate to reach out to our support team. We\'re here to assist you every step of the way.</span></div><br><div><span>Thank you once again for choosing {{site_name}} and for your cooperation in this matter.</span></div></div>','We are pleased to inform you that your Know Your Customer (KYC) information has been successfully reviewed and approved. This means that you are now eligible to conduct any payout operations within our system.','Your  Know Your Customer (KYC) information has been approved successfully','[]',1,'{{site_name}} Verification Center',NULL,1,NULL,0,NULL,'2024-05-08 07:23:57'),(17,'KYC_REJECT','KYC Rejected','KYC has been rejected','{{site_name}} - KYC Rejected','<div><div><span>We regret to inform you that the Know Your Customer (KYC) information provided has been reviewed and unfortunately, it has not met our verification standards. As a result, we are unable to approve your KYC submission at this time.</span></div><br><div><span>We understand that this news may be disappointing, and we want to assure you that we take these matters seriously to maintain the security and integrity of our platform.</span></div><br><div><span>Reasons for rejection may include discrepancies or incomplete information in the documentation provided. If you believe there has been a misunderstanding or if you would like further clarification on why your KYC was rejected, please don\'t hesitate to contact our support team.</span></div><br><div><span>We encourage you to review your submitted information and ensure that all details are accurate and up-to-date. Once any necessary adjustments have been made, you are welcome to resubmit your KYC information for review.</span></div><br><div><span>We apologize for any inconvenience this may cause and appreciate your understanding and cooperation in this matter.</span></div><br><div>Rejection Reason:</div><div>{{reason}}</div><div><br></div><div><span>Thank you for your continued support and patience.</span></div></div>','We regret to inform you that the Know Your Customer (KYC) information provided has been reviewed and unfortunately, it has not met our verification standards. As a result, we are unable to approve your KYC submission at this time. We encourage you to review your submitted information and ensure that all details are accurate and up-to-date. Once any necessary adjustments have been made, you are welcome to resubmit your KYC information for review.','Your  Know Your Customer (KYC) information has been rejected','{\"reason\":\"Rejection Reason\"}',1,'{{site_name}} Verification Center',NULL,1,NULL,0,NULL,'2024-05-08 07:24:13'),(18,'CAMPAIGN_REQUEST_PENDING','Campaign Request Pending','Campaign Request Pending','Campaign Request Pending','Hi {{username}},<div><br></div><div>This is a friendly reminder that your campaign request is still pending.<br><br>Here is a summary of your request:</div><div><br></div><div>Campaign Title : {{title}}</div><div>Start Date : {{start_date}}</div><div>End Date : {{end_date}}<br><div>Budget : {{budget}} {{site_currency}}<br><br>Thanks<br></div></div>','Hi {{username}},\r\n\r\nThis is a friendly reminder that your campaign request is still pending.','Hi {{username}},\r\n\r\nThis is a friendly reminder that your campaign request is still pending.','{\"username\":\"Brand Username\",\"title\":\"Campaign Title\",\"budget\":\"Campaign Budget\",\"start_date\":\"The campaign will be start\",\"end_date\":\"The campaign will be end\"}',1,NULL,NULL,1,NULL,0,NULL,NULL),(19,'CAMPAIGN_REQUEST_APPROVED','Campaign Request Approved','Campaign Request Approved','Campaign Request Approved','<div><span style=\"color: rgb(33, 37, 41);\">Hi {{username}},</span><div><br></div><div>We are excited to let you know that your campaign request for <b>{{title}} </b>has been approved.</div><div><br></div><div>Your campaign will launch on {{start_date}} and run till {{end_date}}.&nbsp;&nbsp;</div><div>Your budget is {{budget}} {{site_currency}}</div><div><br></div><div><div>Thanks</div></div></div>','We are excited to let you know that your campaign request for {{title}} has been approved.','We are excited to let you know that your campaign request for {{title}} has been approved.','{\"username\":\"Brand Username\",\"title\":\"Campaign Title\",\"budget\":\"Campaign Budget\",\"start_date\":\"The campaign will be start\",\"end_date\":\"The campaign will be end\"}',1,NULL,NULL,1,NULL,0,NULL,NULL),(20,'BRAND_ACCEPT_REQUEST','Brand Accept Participation Request','Brand has accepted campaign participation request','Brand has accepted campaign participation request','<span style=\"color: rgb(33, 37, 41);\">Hi {{brand}},</span><div><br></div><div>You have accepted {{influencer}} in your campaign.</div><div>Your campaign {{title}}</div><div>Participant Number : {{participant_number}}</div><div>Campaign Budget : {{budget}} {{site_currency}}</div><div>{{budget}} {{site_currency}} has been subtacted in your account .</div><div>Your Post balance : {{post_balance}}</div><div>Transaction Number : {{trx}}</div><div><div>Thanks</div></div>','You have accepted {{influncer}} in your campaign.','You have accepted {{influncer}} in your campaign.','{\r\n\"influencer\":\"Participate Influencer Username\", \"brand\":\"Campaign Creator\",\"participant_number\":\"Participant Number\",\"title\":\"Campaign Title\",\"budget\":\"Campaign Budget\",\"post_balance\":\"Advertiser Post Balance\",\"trx\":\"Transaction Number\"\r\n}',1,NULL,NULL,1,NULL,0,NULL,NULL),(21,'PARTICIPATE_REQUEST_ACCEPTED','Campaign Participation Request Accepted','Campaign Participation Request Accepted','Campaign Participation Request Accepted','<span style=\"color: rgb(33, 37, 41);\">Hi {{influencer}},</span><div><br></div><div>My Name is {{brand}}. I am letting you know that we have accepted your campaign participation request for our campaign.</div><div><br></div><div>Participant Number : {{participant_number}}</div><div><br></div><div><div>Thanks</div></div>','Hi {{influencer}},\r\nI am letting you know that we have accepted your campaign participation request for our campaign.','Hi {{influencer}},\r\nI am letting you know that we have accepted your campaign participation request for our campaign.','{\r\n            \"influencer\":\"Participate Influencer Username\", \"brand\":\"Campaign Creator\",\"participant_number\":\"Participant Number\",\"title\":\"Campaign Title\"\r\n        }',1,NULL,NULL,1,NULL,0,NULL,NULL),(22,'PARTICIPATE_REQUEST_REJECTED','Campaign Participation Request Rejected','Campaign Participation Request Rejected','Campaign Participation Request Rejected','<span style=\"color: rgb(33, 37, 41);\">Hi {{influencer}},</span><div><br></div><div>My Name is {{brand}}. I am writing to inform you that we have declined your campaign participation request for our campaign.</div><div>Campaign Title : {{title}}</div><div>Participant Number : {{participant_number}}</div><div><br></div><div><div>Thanks</div></div>','I am writing to inform you that we have declined your campaign participation request for our campaign.\r\nParticipant Number : {{participant_number}}','I am writing to inform you that we have declined your campaign participation request for our campaign.\r\nParticipant Number : {{participant_number}}','{\r\n            \"influencer\":\"Participate Influencer Username\", \"brand\":\"Campaign Creator\",\"participant_number\":\"Participant Number\",\"title\":\"Campaign Title\"\r\n        }',1,NULL,NULL,1,NULL,0,NULL,NULL),(23,'CAMPAIGN_JOB_COMPLETED','Campaign Job Completed','Campaign Job Completed Successfully','Campaign Job Completed Successfully','<span style=\"color: rgb(33, 37, 41);\">Dear {{influencer}},</span><div><br></div><div>My name is {{brand}} and I am writing to inform you that your job successfully completed.<br></div><div>The campaign title : {{title}}<br></div><div>Participant Number : {{participant_number}}</div><div>{{budget}} {{site_currency}} added in you account<br></div><div><div>Thanks</div></div>','My name is {{brand}} and I am writing to inform you that your job successfully','My name is {{brand}} and I am writing to inform you that your job successfully','{\r\n            \"title\":\"Campaign Title\",\r\n            \"brand\":\"Campaign Creator\",\r\n            \"influencer\":\"Particated influencer in Campaign\",\r\n            \"participant_number\":\"Participant Number\",\"budget\":\"Campaign Budget\",\"trx\":\"Transaction Number\"        }',1,NULL,NULL,1,NULL,0,NULL,NULL),(24,'CAMPAIGN_JOB_REPORTED','Campaign Job Reported','Brand Reported the Campaign Job','Brand Reported the Campaign Job','<span style=\"color: rgb(33, 37, 41);\">Dear {{influencer}},</span><div><br></div><div>My name is {{brand}} and I am writing to inform you that I have reported on your job.</div><div>The campaign title : {{title}}<br></div><div>The reason is {{reason}}.</div><div>Participant Number : {{participant_number}}</div><div><div>Thanks</div></div>','My name is {{brand}} and I am writing to inform you that I have reported on your job.','My name is {{brand}} and I am writing to inform you that I have reported on your job.','{\r\n            \"title\":\"Campaign Title\",\r\n            \"brand\":\"Campaign Creator\",\r\n            \"influencer\":\"Particated influencer in Campaign\",\r\n            \"participant_number\":\"Participant Number\",\"reason\":\"Reported Reason\"\r\n        }',1,NULL,NULL,1,NULL,0,NULL,NULL),(25,'CAMPAIGN_PARTICIPANT_REQUEST','Campaign Participate Request','Campaign Participate Request','Campaign Participate Request','<div><span style=\"color: rgb(33, 37, 41);\">Hi {{brand}},</span></div><div><br></div><div>{{influencer}} is request on your campaign.</div><div>Campaign Title : {{title}}</div><div>Participant Number : {{participant_number}}</div><div><br><div><div>Thanks</div></div></div>','Hi {{brand}},\r\n\r\n{{influencer}} is request on your campaign.','Hi {{brand}},\r\n\r\n{{influencer}} is request on your campaign.','{\r\n            \"brand\":\"Campaign Creator Username\",\r\n            \"influencer\":\"Participant Influencer Username\",\r\n            \"participant_number\":\"Participant Number\",\"title\":\"Campaign Title\"\r\n        }',1,NULL,NULL,1,NULL,0,NULL,NULL),(26,'PARTICIPATE_REQUEST_PENDING','Campaign Participation Request Pending','Campaign Participation Request Pending','Campaign Participation Request Pending','<span style=\"color: rgb(33, 37, 41);\">Hi {{influencer}},</span><div><br></div><div>I am the at {{brand}}. I am writing to let you know that we have received your campaign participation request for our campaign.</div><div>We are currenlty reviewing all request, and we will be in touch with you as soon as we have a decision.</div><div>Campaign Title : {{title}}</div><div>Participant Number : {{participant_number}}</div><div><br></div><div>Thanks</div>','I am writing to let you know that we have received your campaign participation request for our campaign.\r\nParticipant Number : {{participant_number}}','I am writing to let you know that we have received your campaign participation request for our campaign.\r\nParticipant Number : {{participant_number}}','{\r\n            \"influencer\":\"Participate Influencer Username\", \"brand\":\"Brand Name\",\"participant_number\":\"Participant Number\",\"title\":\"Campaign Title\"\r\n        }',1,NULL,NULL,1,NULL,0,NULL,NULL),(27,'IN_FAVOUR_OF_BRAND','Admin In Favour of Advertiser','Admin In Favour of Brand','Admin In Favour of Brand','<div><span style=\"color: rgb(33, 37, 41);\">Dear {{brand}},</span></div><div><span style=\"color: rgb(33, 37, 41);\"><br></span></div>The administrator has decided in favour to you<div><br></div><div>The Campaign Title : {{title}}<br></div><div>Participant Number : {{participant_number}}</div><div><br></div><div>{{budget}}&nbsp;{{site_currency}} {{site_currency}} added in your account</div><div>Transaction Number : {{trx}}<br></div><div><div>Thanks</div></div>','The administrator has decided in favour to you','The administrator has decided in favour to you','{\r\n            \"title\":\"Campaign Title\",\r\n            \"brand\":\"Campaign Creator\",\r\n        \"participant_number\":\"Participant Number\",\"budget\":\"Campaign Budget\",\"trx\":\"Transaction Number\"        }',1,NULL,NULL,1,NULL,0,NULL,'2024-09-25 06:58:57'),(28,'CAMPAIGN_JOB_REJECTED','Campaign Job Rejected','Campaign Job Rejected Successfully','Campaign Job Rejected Successfully','<span style=\"color: rgb(33, 37, 41);\">Dear {{influencer}},</span><div><br></div><div>I am an administrator. I am writing to inform you that your campaign job has been rejected.</div><div>Administrator in favor of {{brand}}</div><div>The campaign title : {{title}}<br></div><div>Participant Number : {{participant_number}}</div><div><div><br></div><div>Thanks</div></div>','Dear {{influencer}},\r\nI am writing to inform you that your campaign job has been rejected','Dear {{influencer}},\r\nI am writing to inform you that your campaign job has been rejected','{\r\n            \"title\":\"Campaign Title\",\r\n            \"brand\":\"Campaign Creator\",\r\n            \"influencer\":\"Particated influencer in Campaign\",\r\n            \"participant_number\":\"Participant Number\"       }',1,NULL,NULL,1,NULL,0,NULL,NULL),(29,'IN_FAVOUR_OF_INFLUENCER','Admin In Favour of Influencer','Admin in favour of Influencer','Admin in favour of Influencer','<span style=\"color: rgb(33, 37, 41);\">Dear {{brand}},</span><div><br></div><div>Administrator has decided in favour of {{influencer}}<br></div><div>The campaign title : {{title}}<br></div><div>Participant Number : {{participant_number}}</div><div><div>Thanks</div></div>','Administrator has decided in favour of {{influencer}}','Administrator has decided in favour of {{influencer}}','{\r\n            \"title\":\"Campaign Title\",\r\n            \"brand\":\"Campaign Creator\",\r\n            \"influencer\":\"Particated influencer in Campaign\",\r\n            \"participant_number\":\"Participant Number\"       }',1,NULL,NULL,1,NULL,0,NULL,NULL),(30,'SEND_INVITE_REQUEST','Send Invite Request For Campaign','Send Invite Request For Campaign','Send Invite Request For Campaign','<div>Hi {{username}},</div><div><br></div><div>You are invited to this campaign.</div><div>Campaign Title : {{title}}</div><div>Campaign will be end&nbsp; : {{end_date}}<br></div><br><div>Thanks<br></div><div><br></div>','Hi {{username}},\r\n\r\nYou are invited to this campaign.','Hi {{username}},\r\n\r\nYou are invited to this campaign.','{\r\n                \"username\" :\"Influencer Username\",\r\n                \"title\" : \"Campaign Title\",\r\n                \"end_date\": \"Campaign Ending Date\"\r\n            }',1,NULL,NULL,1,NULL,0,NULL,NULL),(31,'CAMPAIGN_APPROVAL_CHARGE','Campaign Approval Charge','Campaign Approval Charge','Campaign Approval Charge','<span style=\"color: rgb(33, 37, 41);\">Hi {{brand}},</span><div><br></div><div>We are excited to let you know that your campaign request for <b>{{title}} </b>has been approved.</div><div><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\">we deducted {{charge}} {{site_currency}} from your account for campaign approval.</span><br></div><div>TRX : {{trx}}</div><div><br></div><div><div>Thanks<br></div></div>','We are excited to let you know that your campaign request for {{title}} has been approved.\r\nwe deducted {{charge}} {{site_currency}} from your account for campaign approval.','We are excited to let you know that your campaign request for {{title}} has been approved.\r\nwe deducted {{charge}} {{site_currency}} from your account for campaign approval.','{\r\n                \"brand\":\"Brand Username\",\r\n                \"charge\":\"Campaign Approval Charge\",\r\n                \"trx\":\"Transaction Number\",\r\n                \"title\":\"Campaign Title\"\r\n            }',1,NULL,NULL,1,NULL,0,NULL,NULL),(32,'REFERRAL_COMMISSION','Referral Commission','Referral Commission','Referral Commission','<div>Hi,</div><div>You have got {{amount}} {{site_currency}} for {{type}} referral commission.</div><div>Commission level is {{level}}</div><div>Transaction Number : {{trx}}</div><div>Post Balance : {{post_balance}}<br></div>','You have got {{amount}} {{site_currency}} for {{type}} referral commission.','You have got {{amount}} {{site_currency}} for {{type}} referral commission.','{\"amount\":\"Referral Commission Amount\",\"amount\":\"Post Balance\",\"trx\":\"Transaction Number\",\"level\":\"Commission of level\",\"type\":\"Commission Type\"}',1,NULL,NULL,1,NULL,0,NULL,NULL),(33,'CAMPAIGN_JOB_DELIVERED','Campaign Job Delivered','Influencer Delivered the Campaign Job','Influencer Delivered the Campaign Job','<span style=\"color: rgb(33, 37, 41);\">Dear {{brand}},</span><div><br></div><div>My name is {{influencer}}, and I am writing to inform you that I have delivered all of the campaign materials for the {{title}} campaign<br></div><div>I have attached all of the deliverables to this email.<br></div><div>Participant Number : {{participant_number}}</div><div><div>Thanks</div></div>','My name is {{influencer}}, and I am writing to inform you that I have delivered all of the campaign materials for the {{title}} campaign','My name is {{influencer}}, and I am writing to inform you that I have delivered all of the campaign materials for the {{title}} campaign','{\r\n            \"title\":\"Campaign Title\",\r\n            \"brand\":\"Campaign Creator\",\r\n            \"influencer\":\"Particated influencer in Campaign\",\r\n            \"participant_number\":\"Participant Number\"\r\n        }',1,NULL,NULL,1,NULL,0,NULL,NULL),(34,'CAMPAIGN_JOB_CANCELED','Campaign Job Canceled','Influencer Canceled the Campaign Job','Influencer Canceled the Campaign Job','<span style=\"color: rgb(33, 37, 41);\">Dear {{brand}},</span><div><br></div><div>My name is {{influencer}}, and I am wrtting to inform you that i will be unable to participate in the campaign.</div><div><br></div><div>I wish you all the best with the campaign, and i hope that we can collaborate in the future.</div><div>Campaign : {{title}},</div><div>Participant Number : {{participant_number}}</div><div><br></div><div>{{budget}} {{site_currency}} added in your account.</div><div>Transaction Number : {{trx}}</div><div><br></div><div><div>Thanks</div></div>','My name is {{influencer}}, and I am wrtting to inform you that i will be unable to participate in the campaign.','My name is {{influencer}}, and I am wrtting to inform you that i will be unable to participate in the campaign.','{\r\n            \"title\":\"Campaign Title\",\r\n            \"brand\":\"Campaign Creator\",\r\n            \"influencer\":\"Particated influencer in Campaign\",\r\n            \"participant_number\":\"Participant Number\",\r\n            \"budget\" : \"Campaign Budget\",\r\n            \"trx\":\"Transaction Number\"\r\n        }',1,NULL,NULL,1,NULL,0,NULL,NULL),(35,'CAMPAIGN_REQUEST_REJECTED','Campaign Request Rejected','Campaign Request Rejected','Campaign Request Rejected','<div><span style=\"color: rgb(33, 37, 41);\">Hi {{username}},</span><div><br></div><div>We are writing to inform you that your campaign request for <b>{{title}} </b>has been rejected.</div><div>The reason for the rejection is {{reason}}</div><div>Your campaign will launch on {{start_date}} and run till {{end_date}}.&nbsp;&nbsp;</div><div>Your budget is {{budget}} {{site_currency}}</div><div><br></div><div><div>Thanks</div></div></div>','We are writing to inform you that your campaign request for {{title}} has been rejected.','We are writing to inform you that your campaign request for {{title}} has been rejected.','{\"username\":\"Brand Username\",\"title\":\"Campaign Title\",\"budget\":\"Campaign Budget\",\"start_date\":\"The campaign will be start\",\"end_date\":\"The campaign will be end\",\"reason\":\"Campaign Rejected Reason\"}',1,NULL,NULL,1,NULL,0,NULL,NULL),(36,'INFLUENCER_REGISTER_COMMISSION','Influencer Register Commission','Influencer Register Commission','Influencer Register Commission','Hello {{fullname}},<div>You have got a register bonus.</div><div>{{amount}} {{site_currency}} add on your wallet.</div><div><br></div>','Hello {{fullname}},\r\nYou have got a register bonus.\r\n{{amount}} {{site_currency}} add on your wallet.','Hello {{fullname}},\r\nYou have got a register bonus.\r\n{{amount}} {{site_currency}} add on your wallet.','{\"username\":\"New Registered Influencer Fullname\",\"amount\":\"Influencer Register Bonus\"}',1,NULL,NULL,1,NULL,0,NULL,NULL),(37,'BRAND_REGISTER_COMMISSION','Brand Register Commission','Brand Register Commission','Brand Register Commission','Hello {{fullname}},<div>You have got a register bonus.</div><div>{{amount}} {{site_currency}} add on your wallet.</div><div><br></div>','Hello {{fullname}},\r\nYou have got a register bonus.\r\n{{amount}} {{site_currency}} add on your wallet.','Hello {{fullname}},\r\nYou have got a register bonus.\r\n{{amount}} {{site_currency}} add on your wallet.','{\"username\":\"New Registered Brand Fullname\",\"amount\":\"Brand Register Bonus\"}',1,NULL,NULL,1,NULL,0,NULL,NULL);
/*!40000 ALTER TABLE `notification_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `pages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) DEFAULT NULL,
  `slug` varchar(40) DEFAULT NULL,
  `tempname` varchar(40) DEFAULT NULL COMMENT 'template name',
  `secs` text DEFAULT NULL,
  `seo_content` text DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES (1,'HOME','/','templates.basic.','[\"partner\",\"top_influencer\",\"category\",\"how_work\",\"feature\",\"counter\",\"ongoing_campaign\",\"testimonial\",\"cta\"]',NULL,1,'2020-07-11 06:23:58','2026-02-22 20:51:38'),(4,'Blog','blog','templates.basic.',NULL,NULL,1,'2020-10-22 01:14:43','2020-10-22 01:14:43'),(5,'Contact','contact','templates.basic.','[\"faq\"]',NULL,1,'2020-10-22 01:14:53','2024-10-08 05:38:45'),(28,'Campaigns','campaigns','templates.basic.',NULL,NULL,1,'2024-09-18 05:26:29','2024-09-18 05:26:29'),(29,'Influencers','influencers','templates.basic.',NULL,NULL,1,'2024-09-18 05:34:44','2024-09-18 05:34:44'),(30,'Categories','categories','templates.basic.',NULL,NULL,1,'2024-09-27 23:51:56','2024-09-27 23:55:52');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `participants`
--

DROP TABLE IF EXISTS `participants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `participants` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `influencer_id` int(10) unsigned NOT NULL DEFAULT 0,
  `influencer_is_gst_registered` tinyint(1) NOT NULL DEFAULT 0,
  `influencer_country_code` varchar(10) DEFAULT NULL,
  `campaign_id` int(10) unsigned NOT NULL DEFAULT 0,
  `participant_number` varchar(40) DEFAULT NULL,
  `budget` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `gst_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `commission_gst_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `influencer_gst_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `marketplace_gst_return_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `invitation_letter` text DEFAULT NULL,
  `report_reason` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `participants`
--

LOCK TABLES `participants` WRITE;
/*!40000 ALTER TABLE `participants` DISABLE KEYS */;
INSERT INTO `participants` VALUES (1,5,0,NULL,3,'JBQOICNBNMGS',60.00000000,0.00000000,0.00000000,0.00000000,0.00000000,NULL,NULL,3,'2026-02-19 08:31:24','2026-02-19 08:38:15'),(2,5,0,NULL,4,'9CK68HOBNX8E',100.00000000,0.00000000,0.00000000,0.00000000,0.00000000,NULL,NULL,1,'2026-02-19 08:58:53','2026-02-19 08:58:53'),(3,5,0,NULL,5,'R4M87QCN9STS',100.00000000,0.00000000,0.00000000,0.00000000,0.00000000,NULL,NULL,1,'2026-02-19 09:17:19','2026-02-19 09:43:11'),(4,6,0,NULL,6,'78UKG33QD7TF',50.00000000,0.00000000,0.00000000,0.00000000,0.00000000,NULL,NULL,1,'2026-02-19 10:15:35','2026-02-19 10:38:13'),(5,6,0,NULL,7,'53BAFMEOGJER',45.00000000,0.00000000,0.00000000,0.00000000,0.00000000,NULL,NULL,1,'2026-02-19 10:49:58','2026-02-19 10:49:58'),(6,6,0,NULL,8,'WH6E1P8R4WRQ',0.00000000,0.00000000,0.00000000,0.00000000,0.00000000,NULL,NULL,8,'2026-02-19 18:37:11','2026-02-19 18:37:11'),(7,5,0,NULL,9,'8Z34SWSIW21J',0.00000000,0.00000000,0.00000000,0.00000000,0.00000000,NULL,NULL,8,'2026-02-19 18:58:25','2026-02-19 18:58:25'),(8,5,0,NULL,10,'ITTKTLM78LSR',500.00000000,0.00000000,0.00000000,0.00000000,0.00000000,NULL,NULL,9,'2026-02-19 19:52:27','2026-02-19 19:52:27'),(9,5,0,NULL,11,'L3QLHT5GUD2U',500.00000000,0.00000000,0.00000000,0.00000000,0.00000000,NULL,NULL,9,'2026-02-19 20:17:46','2026-02-19 20:17:46'),(10,7,0,NULL,12,'4VGFYHK3FRNS',100.00000000,0.00000000,0.00000000,0.00000000,0.00000000,NULL,NULL,3,'2026-02-19 21:47:16','2026-02-21 00:06:16'),(11,7,0,NULL,13,'WWUHX2D4N5NY',100.00000000,0.00000000,0.00000000,0.00000000,0.00000000,NULL,NULL,3,'2026-02-19 22:19:43','2026-02-21 00:06:43'),(12,7,0,NULL,14,'HA394YQPGQVQ',50.00000000,0.00000000,0.00000000,0.00000000,0.00000000,NULL,NULL,3,'2026-02-19 22:21:24','2026-02-19 22:44:35'),(13,7,0,NULL,17,'EGGA6GOIFTWD',100.00000000,0.00000000,0.00000000,0.00000000,0.00000000,NULL,NULL,3,'2026-02-20 01:10:05','2026-02-21 00:07:04'),(14,7,0,NULL,16,'NUV9ZY19UBRN',100.00000000,0.00000000,0.00000000,0.00000000,0.00000000,NULL,NULL,3,'2026-02-20 01:18:23','2026-02-21 00:07:21'),(15,7,0,NULL,18,'41E7781CL4FU',200.00000000,0.00000000,0.00000000,0.00000000,0.00000000,NULL,NULL,3,'2026-02-20 01:44:31','2026-02-20 10:28:27'),(16,7,0,NULL,19,'Z9JK12GYFGRC',50.00000000,0.00000000,0.00000000,0.00000000,0.00000000,NULL,NULL,3,'2026-02-20 01:49:07','2026-02-20 01:51:21'),(17,7,0,NULL,20,'JQQV4TSMFCXV',500.00000000,0.00000000,0.00000000,0.00000000,0.00000000,NULL,NULL,3,'2026-02-20 01:54:33','2026-02-21 00:07:51'),(18,7,0,NULL,21,'CQM86I66C98J',100.00000000,0.00000000,0.00000000,0.00000000,0.00000000,NULL,NULL,3,'2026-02-20 11:50:04','2026-02-21 00:09:12'),(19,7,0,NULL,22,'NJ82C517ME5R',0.00000000,0.00000000,0.00000000,0.00000000,0.00000000,NULL,NULL,3,'2026-02-20 23:56:32','2026-02-21 22:14:07'),(20,7,0,NULL,27,'DFTLVZV2SB9P',50.00000000,0.00000000,0.00000000,0.00000000,0.00000000,NULL,NULL,3,'2026-02-21 21:53:04','2026-02-22 12:10:56'),(21,7,0,NULL,28,'FTLPESXXYX8N',50.00000000,0.00000000,0.00000000,0.00000000,0.00000000,NULL,NULL,1,'2026-02-21 21:55:04','2026-02-21 21:55:41'),(22,7,0,NULL,29,'7ZLPAYECLU1T',50.00000000,0.00000000,0.00000000,0.00000000,0.00000000,NULL,NULL,1,'2026-02-21 22:01:30','2026-02-21 22:01:41'),(23,7,0,NULL,30,'H2K2PS1NC5DO',100.00000000,0.00000000,0.00000000,0.00000000,0.00000000,NULL,NULL,3,'2026-02-21 22:14:00','2026-02-22 19:20:14'),(24,5,0,NULL,31,'TD3PZUTDRZ1W',0.00000000,0.00000000,0.00000000,0.00000000,0.00000000,NULL,NULL,3,'2026-02-22 14:31:54','2026-02-22 14:34:36'),(25,8,0,NULL,32,'XBN2Y44Y3BMW',0.00000000,0.00000000,0.00000000,0.00000000,0.00000000,NULL,NULL,3,'2026-02-22 14:39:03','2026-02-22 14:42:09'),(26,6,0,NULL,33,'WUF3JR8G5TGR',0.00000000,0.00000000,0.00000000,0.00000000,0.00000000,NULL,NULL,8,'2026-02-22 14:49:38','2026-02-22 14:49:38'),(27,7,0,NULL,34,'9PHEU4P8IDW7',0.00000000,0.00000000,0.00000000,0.00000000,0.00000000,NULL,NULL,3,'2026-02-22 15:03:10','2026-02-22 22:55:07'),(28,7,0,NULL,35,'GE2KBMLGPYIS',10.00000000,0.00000000,0.00000000,0.00000000,0.00000000,NULL,NULL,3,'2026-02-22 19:25:42','2026-02-22 19:48:17'),(29,7,0,NULL,15,'XV23AW4M4G9C',100.00000000,0.00000000,0.00000000,0.00000000,0.00000000,NULL,NULL,1,'2026-02-22 20:13:20','2026-02-22 20:14:26'),(30,6,0,NULL,36,'K3HOK19T7GJF',45.00000000,0.00000000,0.00000000,0.00000000,0.00000000,NULL,NULL,1,'2026-02-22 22:52:54','2026-02-22 22:52:54'),(31,7,0,NULL,37,'4AQH9HBDCS3Z',51.00000000,0.00000000,0.00000000,0.00000000,0.00000000,NULL,NULL,1,'2026-02-22 22:55:02','2026-02-22 22:55:07'),(32,7,0,NULL,38,'L5O5GU4KAO5V',50.00000000,0.00000000,0.00000000,0.00000000,0.00000000,NULL,NULL,9,'2026-02-22 22:55:23','2026-02-22 22:55:23'),(33,7,0,NULL,39,'GFNX287L8WQR',0.00000000,0.00000000,0.00000000,0.00000000,0.00000000,NULL,NULL,3,'2026-02-23 15:59:30','2026-02-23 16:18:50'),(34,5,0,NULL,40,'QWZMJK73FZYL',0.00000000,0.00000000,0.00000000,0.00000000,0.00000000,NULL,NULL,8,'2026-02-23 16:17:54','2026-02-23 16:17:54'),(35,7,0,'NZ',41,'IXD2XYV1C1R3',200.00000000,33.00000000,0.00000000,30.00000000,17.00000000,NULL,NULL,3,'2026-02-23 16:43:38','2026-02-23 17:07:47'),(36,7,0,'NZ',42,'YY52RFCBKYYN',500.00000000,82.50000000,0.00000000,0.00000000,0.00000000,NULL,NULL,1,'2026-02-23 16:47:38','2026-02-23 16:50:38'),(37,5,0,NULL,25,'AMJT7WFSQAB5',500.00000000,0.00000000,0.00000000,0.00000000,0.00000000,NULL,NULL,0,'2026-02-23 17:35:34','2026-02-23 17:35:34'),(38,5,0,NULL,43,'LOA1WS43UO2H',0.00000000,0.00000000,0.00000000,0.00000000,0.00000000,NULL,NULL,8,'2026-02-23 17:39:30','2026-02-23 17:39:30'),(39,7,0,NULL,44,'V45LMBHZICTQ',0.00000000,0.00000000,0.00000000,0.00000000,0.00000000,NULL,NULL,8,'2026-02-23 22:43:08','2026-02-23 22:43:08');
/*!40000 ALTER TABLE `participants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(40) DEFAULT NULL,
  `token` varchar(40) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plans`
--

DROP TABLE IF EXISTS `plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `plans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `campaign_limit` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plans`
--

LOCK TABLES `plans` WRITE;
/*!40000 ALTER TABLE `plans` DISABLE KEYS */;
INSERT INTO `plans` VALUES (1,'Starter',49.00000000,1,1,'2026-02-21 04:59:42','2026-02-21 20:31:02'),(2,'Professional',99.00000000,-1,1,'2026-02-21 04:59:42','2026-02-21 20:31:02'),(3,'Explorer',0.00000000,0,1,'2026-02-21 06:32:11','2026-02-21 20:31:02');
/*!40000 ALTER TABLE `plans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `platforms`
--

DROP TABLE IF EXISTS `platforms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `platforms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) DEFAULT NULL,
  `icon` varchar(40) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `platforms`
--

LOCK TABLES `platforms` WRITE;
/*!40000 ALTER TABLE `platforms` DISABLE KEYS */;
INSERT INTO `platforms` VALUES (1,'Facebook','<i class=\"fab fa-facebook\"></i>',1,'2023-09-12 06:05:03','2024-09-11 01:10:55'),(2,'Instagram','<i class=\"fab fa-instagram\"></i>',1,'2023-09-12 06:06:05','2024-10-01 04:27:33'),(3,'Youtube','<i class=\"fab fa-youtube\"></i>',1,'2023-09-12 06:06:37','2023-09-12 06:06:37'),(4,'TikTok','<i class=\"fab fa-tiktok\"></i>',1,'2026-02-19 03:56:31','2026-02-19 03:56:31');
/*!40000 ALTER TABLE `platforms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profile_galleries`
--

DROP TABLE IF EXISTS `profile_galleries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `profile_galleries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `influencer_id` int(10) unsigned NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `video_type` varchar(50) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profile_galleries`
--

LOCK TABLES `profile_galleries` WRITE;
/*!40000 ALTER TABLE `profile_galleries` DISABLE KEYS */;
INSERT INTO `profile_galleries` VALUES (1,5,'6996907d1a21f1771475069.jpg',NULL,NULL,1,'2026-02-19 04:24:29','2026-02-19 04:24:29',0),(2,5,'699695cb05f9b1771476427.jpg',NULL,NULL,1,'2026-02-19 04:47:07','2026-02-19 04:47:07',0),(3,5,'69969831d199b1771477041.jpg',NULL,NULL,1,'2026-02-19 04:57:21','2026-02-19 04:57:21',0),(4,5,'6996989fa3ff01771477151.jpg',NULL,NULL,1,'2026-02-19 04:59:11','2026-02-19 04:59:11',0),(5,6,'6996e2bf1aa421771496127.jpg',NULL,NULL,1,'2026-02-19 10:15:27','2026-02-19 10:15:27',0),(8,8,'6997d0e98f17e1771557097.jpg',NULL,NULL,1,'2026-02-20 03:11:37','2026-02-20 03:11:37',0),(10,7,'6998d4eabc3d61771623658.jpg',NULL,NULL,1,'2026-02-20 21:40:59','2026-02-21 04:12:37',1),(11,7,'6998d4eb049211771623659.jpg',NULL,NULL,1,'2026-02-20 21:40:59','2026-02-21 04:12:37',2),(12,7,'6998d4eb304381771623659.jpg',NULL,NULL,1,'2026-02-20 21:40:59','2026-02-21 04:12:37',3),(13,7,'6998d85a1aef11771624538.jpg',NULL,NULL,1,'2026-02-20 21:55:39','2026-02-21 04:12:37',4),(15,7,'yt_69992a09bf5ce.jpg','https://youtu.be/xL-GKmLlCIw','youtube',1,'2026-02-21 03:44:09','2026-02-21 04:12:37',5);
/*!40000 ALTER TABLE `profile_galleries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `referrals`
--

DROP TABLE IF EXISTS `referrals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `referrals` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `commission_type` varchar(40) DEFAULT NULL,
  `level` int(11) NOT NULL DEFAULT 0,
  `percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `referrals`
--

LOCK TABLES `referrals` WRITE;
/*!40000 ALTER TABLE `referrals` DISABLE KEYS */;
/*!40000 ALTER TABLE `referrals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `participant_id` int(10) unsigned NOT NULL DEFAULT 0,
  `user_id` int(10) unsigned NOT NULL DEFAULT 0,
  `influencer_id` int(10) unsigned NOT NULL DEFAULT 0,
  `star` tinyint(1) NOT NULL DEFAULT 0,
  `review` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (1,12,3,7,5,'Great Influencer','2026-02-20 01:21:25','2026-02-20 01:21:25'),(2,10,3,7,5,'Awesome','2026-02-21 00:06:24','2026-02-21 00:06:24'),(3,11,3,7,5,'Stupendous','2026-02-21 00:06:51','2026-02-21 00:06:51'),(4,13,3,7,5,'Great','2026-02-21 00:07:11','2026-02-21 00:07:11'),(5,14,3,7,1,'Terrible','2026-02-21 00:07:30','2026-02-21 00:07:30'),(6,17,3,7,5,'Good','2026-02-21 00:09:06','2026-02-21 00:09:06'),(7,18,3,7,5,'Best ever','2026-02-21 00:09:19','2026-02-21 00:09:19'),(8,20,3,7,5,'Great','2026-02-22 12:11:04','2026-02-22 12:11:04'),(9,23,3,7,5,'Awesome','2026-02-22 19:20:22','2026-02-22 19:20:22'),(10,28,3,7,5,'great','2026-02-22 19:48:22','2026-02-22 19:48:22'),(11,35,5,7,5,'Stellar work','2026-02-23 17:07:55','2026-02-23 17:07:55');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `social_links`
--

DROP TABLE IF EXISTS `social_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `social_links` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `influencer_id` int(10) unsigned NOT NULL DEFAULT 0,
  `platform_id` int(10) unsigned NOT NULL DEFAULT 0,
  `followers` bigint(20) NOT NULL DEFAULT 0,
  `social_link` varchar(255) DEFAULT NULL,
  `channel_connect` tinyint(1) NOT NULL DEFAULT 0,
  `social_user_id` bigint(20) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_links`
--

LOCK TABLES `social_links` WRITE;
/*!40000 ALTER TABLE `social_links` DISABLE KEYS */;
INSERT INTO `social_links` VALUES (1,1,1,0,'https://face.com/lskanf',0,0,'2026-02-19 02:16:57','2026-02-19 02:16:57'),(2,1,2,0,'https://face.com/lskanf',0,0,'2026-02-19 02:16:57','2026-02-19 02:16:57'),(3,1,3,0,'https://face.com/lskanf',0,0,'2026-02-19 02:16:57','2026-02-19 02:16:57'),(4,4,1,35,'https://face.com/lskanf',0,0,'2026-02-19 04:04:14','2026-02-19 04:04:14'),(5,5,1,67,'https://face.com/lskanf',0,0,'2026-02-19 04:23:58','2026-02-19 04:23:58'),(6,5,3,78,'https://youtube.com',0,0,'2026-02-19 04:47:22','2026-02-19 04:47:22'),(7,5,2,5,'https://instagram.com',0,0,'2026-02-19 07:57:47','2026-02-19 07:57:47'),(8,6,2,2345,'https://lkjklj.com',0,0,'2026-02-19 10:15:04','2026-02-19 10:15:04'),(9,7,1,20,'https://facebook.com/examlpe',0,0,'2026-02-19 21:44:01','2026-02-20 01:12:41'),(10,8,1,1789,'https://facebook.com',0,0,'2026-02-20 03:04:32','2026-02-20 03:04:32'),(11,7,2,3467,'https://instagram.com',0,0,'2026-02-20 22:43:23','2026-02-20 22:43:23');
/*!40000 ALTER TABLE `social_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `support_attachments`
--

DROP TABLE IF EXISTS `support_attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `support_attachments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `support_message_id` int(10) unsigned NOT NULL DEFAULT 0,
  `attachment` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `support_attachments`
--

LOCK TABLES `support_attachments` WRITE;
/*!40000 ALTER TABLE `support_attachments` DISABLE KEYS */;
/*!40000 ALTER TABLE `support_attachments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `support_messages`
--

DROP TABLE IF EXISTS `support_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `support_messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `support_ticket_id` int(10) unsigned NOT NULL DEFAULT 0,
  `admin_id` int(10) unsigned NOT NULL DEFAULT 0,
  `message` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `support_messages`
--

LOCK TABLES `support_messages` WRITE;
/*!40000 ALTER TABLE `support_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `support_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `support_tickets`
--

DROP TABLE IF EXISTS `support_tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `support_tickets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT 0,
  `influencer_id` int(10) unsigned NOT NULL DEFAULT 0,
  `name` varchar(40) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `ticket` varchar(40) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: Open, 1: Answered, 2: Replied, 3: Closed',
  `priority` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = Low, 2 = medium, 3 = heigh',
  `last_reply` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `support_tickets`
--

LOCK TABLES `support_tickets` WRITE;
/*!40000 ALTER TABLE `support_tickets` DISABLE KEYS */;
/*!40000 ALTER TABLE `support_tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tags` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT 0,
  `influencer_id` int(11) NOT NULL DEFAULT 0,
  `amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `gst_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `post_balance` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `trx_type` varchar(40) DEFAULT NULL,
  `trx` varchar(40) DEFAULT NULL,
  `details` varchar(255) DEFAULT NULL,
  `remark` varchar(40) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES (1,1,0,50000.00000000,0.00000000,0.00000000,50000.00000000,'+','5RWPEV8YCEC1','test','balance_add','2026-02-19 08:32:12','2026-02-19 08:32:12'),(2,1,0,60.00000000,0.00000000,0.00000000,49940.00000000,'-','OIJCYAK5ALAK','Accepted the influencer for the campaign','campaign','2026-02-19 08:32:19','2026-02-19 08:32:19'),(3,0,5,60.00000000,0.00000000,0.00000000,60.00000000,'+','SYAQKXI65UO5','Campaign job completed','campaign_completed','2026-02-19 08:38:15','2026-02-19 08:38:15'),(4,1,0,100.00000000,0.00000000,0.00000000,49840.00000000,'-','9B5AYUAMM16D','Purchased service: fdgsg','service_purchase','2026-02-19 08:58:53','2026-02-19 08:58:53'),(5,1,0,100.00000000,0.00000000,0.00000000,49740.00000000,'-','TUVROTO8WVEL','Hired from inquiry: General Inquiry: kjhhfdsfdsf x dsfdasfdsf','service_purchase','2026-02-19 09:43:11','2026-02-19 09:43:11'),(6,1,0,50.00000000,0.00000000,0.00000000,49690.00000000,'-','WAZ4UVGGAOUX','Hired from inquiry: General Inquiry: kjhhfdsfdsf x dsafdsf','service_purchase','2026-02-19 10:38:13','2026-02-19 10:38:13'),(7,1,0,45.00000000,0.00000000,0.00000000,49645.00000000,'-','GT9KIZ63HDGY','Purchased service: sdaf','service_purchase','2026-02-19 10:49:58','2026-02-19 10:49:58'),(8,3,0,1000.00000000,0.00000000,0.00000000,1000.00000000,'+','YNDIA4OFXQMA','Test','balance_add','2026-02-19 21:47:03','2026-02-19 21:47:03'),(9,3,0,100.00000000,0.00000000,0.00000000,900.00000000,'-','TVKEO6NMB755','Purchased service: Basic Shotout','service_purchase','2026-02-19 21:47:16','2026-02-19 21:47:16'),(10,3,0,100.00000000,0.00000000,0.00000000,800.00000000,'-','D4LKVE4BV9VG','Accepted proposal: 2 stories','proposal_acceptance','2026-02-19 22:19:57','2026-02-19 22:19:57'),(11,3,0,50.00000000,0.00000000,0.00000000,750.00000000,'-','FMCIH5RO6L19','Accepted proposal: 1 Youtube','proposal_acceptance','2026-02-19 22:21:38','2026-02-19 22:21:38'),(12,0,7,50.00000000,0.00000000,0.00000000,50.00000000,'+','LEBN2O3E1XE4','Campaign job completed','campaign_completed','2026-02-19 22:44:35','2026-02-19 22:44:35'),(13,3,0,100.00000000,0.00000000,0.00000000,650.00000000,'-','G529PNBMPK4C','Purchased service: Basic Shotout','service_purchase','2026-02-20 01:10:05','2026-02-20 01:10:05'),(14,3,0,100.00000000,0.00000000,0.00000000,550.00000000,'-','7MGPL9CNIGZE','Accepted the influencer for the campaign','campaign','2026-02-20 01:19:39','2026-02-20 01:19:39'),(15,3,0,200.00000000,0.00000000,0.00000000,350.00000000,'-','OZUR3LE4UY11','Purchased service: Basic Reel','service_purchase','2026-02-20 01:44:31','2026-02-20 01:44:31'),(16,3,0,50.00000000,0.00000000,0.00000000,300.00000000,'-','MP6D8VCI8QQ9','Accepted proposal: 1 x TikTok reel','proposal_acceptance','2026-02-20 01:49:19','2026-02-20 01:49:19'),(17,3,0,10000.00000000,0.00000000,0.00000000,10300.00000000,'+','UDTDJP7AGBBL','test','balance_add','2026-02-20 02:12:15','2026-02-20 02:12:15'),(18,3,0,500.00000000,0.00000000,0.00000000,9800.00000000,'-','ZUFF89G1GOXD','Accepted the influencer for the campaign','campaign','2026-02-20 02:12:21','2026-02-20 02:12:21'),(19,0,7,200.00000000,0.00000000,0.00000000,250.00000000,'+','UOLVE4X6EAPW','Campaign job completed','campaign_completed','2026-02-20 10:28:27','2026-02-20 10:28:27'),(20,3,0,100.00000000,0.00000000,0.00000000,9700.00000000,'-','6MK9UPXVO8JV','Accepted proposal: 2 Stories','proposal_acceptance','2026-02-20 11:50:24','2026-02-20 11:50:24'),(21,0,7,100.00000000,0.00000000,0.00000000,350.00000000,'+','2L9U63U135AO','Campaign job completed','campaign_completed','2026-02-21 00:06:16','2026-02-21 00:06:16'),(22,0,7,100.00000000,0.00000000,0.00000000,450.00000000,'+','9NB3HWRWH94T','Campaign job completed','campaign_completed','2026-02-21 00:06:43','2026-02-21 00:06:43'),(23,0,7,100.00000000,0.00000000,0.00000000,550.00000000,'+','A8QSVGKZDSK1','Campaign job completed','campaign_completed','2026-02-21 00:07:04','2026-02-21 00:07:04'),(24,0,7,100.00000000,0.00000000,0.00000000,750.00000000,'+','XZMVTON55QOZ','Campaign job completed','campaign_completed','2026-02-21 00:07:21','2026-02-21 00:07:21'),(25,0,7,500.00000000,0.00000000,0.00000000,1250.00000000,'+','ZTHM4OCHPG5L','Campaign job completed','campaign_completed','2026-02-21 00:07:51','2026-02-21 00:07:51'),(26,0,7,100.00000000,0.00000000,0.00000000,1350.00000000,'+','LUQASHNJZ3ML','Campaign job completed','campaign_completed','2026-02-21 00:09:12','2026-02-21 00:09:12'),(27,3,0,99.00000000,0.00000000,0.00000000,9601.00000000,'-','KVSW2P5OQA2K','Subscribed to Professional plan (monthly)','subscription','2026-02-21 05:05:07','2026-02-21 05:05:07'),(28,4,0,100.00000000,0.00000000,0.00000000,100.00000000,'+','PFS3CGESYPTX','test','balance_add','2026-02-21 06:41:41','2026-02-21 06:41:41'),(29,3,0,49.00000000,0.00000000,0.00000000,9552.00000000,'-','ELNKBR41ZZ9T','Subscribed to Starter plan (monthly)','subscription','2026-02-21 06:41:49','2026-02-21 06:41:49'),(30,4,0,49.00000000,0.00000000,0.00000000,51.00000000,'-','E9EOWUDINOKF','Subscribed to Starter plan (monthly)','subscription','2026-02-21 06:45:57','2026-02-21 06:45:57'),(31,3,0,50.00000000,0.00000000,0.00000000,9502.00000000,'-','6GB3HWKMD73W','Accepted proposal: 1 Instagram Post','proposal_acceptance','2026-02-21 21:53:12','2026-02-21 21:53:12'),(32,3,0,50.00000000,0.00000000,0.00000000,9452.00000000,'-','H7B99HW9VFI5','Accepted proposal: 1 story','proposal_acceptance','2026-02-21 21:55:41','2026-02-21 21:55:41'),(33,3,0,50.00000000,0.00000000,0.00000000,9402.00000000,'-','2VMQGYDF8NW2','Accepted proposal: 1 Video','proposal_acceptance','2026-02-21 22:01:41','2026-02-21 22:01:41'),(34,3,0,100.00000000,0.00000000,0.00000000,9302.00000000,'-','TPJNC7M65AHR','Accepted proposal: 1 tiktok','proposal_acceptance','2026-02-21 22:14:07','2026-02-21 22:14:07'),(35,0,7,50.00000000,0.00000000,0.00000000,1400.00000000,'+','XOHIX6DGZ14F','Campaign job completed','campaign_completed','2026-02-22 12:10:56','2026-02-22 12:10:56'),(36,0,7,100.00000000,0.00000000,0.00000000,1500.00000000,'+','S65XG4864HZX','Campaign job completed','campaign_completed','2026-02-22 19:20:14','2026-02-22 19:20:14'),(37,3,0,10.00000000,0.00000000,0.00000000,9292.00000000,'-','SGABZFJA1H4W','Accepted proposal: 1 FB','proposal_acceptance','2026-02-22 19:25:50','2026-02-22 19:25:50'),(38,0,7,10.00000000,0.00000000,0.00000000,1510.00000000,'+','BA41SA41HGNZ','Campaign job completed','campaign_completed','2026-02-22 19:48:17','2026-02-22 19:48:17'),(39,3,0,100.00000000,0.00000000,0.00000000,9192.00000000,'-','88R2O1UKRN2J','Accepted the influencer for the campaign','campaign','2026-02-22 20:14:26','2026-02-22 20:14:26'),(40,3,0,45.00000000,0.00000000,0.00000000,9147.00000000,'-','XMWLU2FA1UNQ','Purchased service: sdaf','service_purchase','2026-02-22 22:52:54','2026-02-22 22:52:54'),(41,4,0,51.00000000,0.00000000,0.00000000,0.00000000,'-','HND22TVK3UL2','Accepted proposal: 2 stories','proposal_acceptance','2026-02-22 22:55:07','2026-02-22 22:55:07'),(42,5,0,0.00000000,0.00000000,0.00000000,0.00000000,'-','N6AHU5K28BT2','Subscribed to Explorer (monthly). Pro-rata discount of $$0 NZD applied.','subscription_plan','2026-02-23 15:58:15','2026-02-23 15:58:15'),(43,5,0,1000.00000000,0.00000000,0.00000000,1000.00000000,'+','4TX4Y2SKSO7N','test','balance_add','2026-02-23 16:01:55','2026-02-23 16:01:55'),(44,5,0,49.00000000,0.00000000,0.00000000,951.00000000,'-','JZOQP4ZKOZHJ','Subscribed to Starter (monthly). Pro-rata discount of $$0 NZD applied.','subscription_plan','2026-02-23 16:02:06','2026-02-23 16:02:06'),(45,5,0,53.26698765,0.00000000,0.00000000,897.73301235,'-','1ZW4Z5CO9FM8','Subscribed to Professional (monthly). Pro-rata discount of $$46 NZD applied.','subscription_plan','2026-02-23 16:02:22','2026-02-23 16:02:22'),(46,5,0,253.00000000,20.00000000,33.00000000,644.73301235,'-','1GVUXG6RATUD','Accepted proposal: 1 FB Campaign (Incl. GST)','proposal_acceptance','2026-02-23 16:45:52','2026-02-23 16:45:52'),(47,5,0,632.50000000,50.00000000,82.50000000,12.23301235,'-','92Y98O8CDGCC','Accepted proposal: 3 x reels (Incl. GST)','proposal_acceptance','2026-02-23 16:50:38','2026-02-23 16:50:38'),(48,0,7,217.00000000,0.00000000,0.00000000,1727.00000000,'+','AKQ6OYBZOTOE','Campaign job completed (Incl. GST Return)','campaign_completed','2026-02-23 17:07:47','2026-02-23 17:07:47'),(49,4,0,633.00000000,0.00000000,0.00000000,633.00000000,'+','FQHI8IG1XLHB','test','balance_add','2026-02-23 17:47:30','2026-02-23 17:47:30'),(50,1,0,0.00000000,0.00000000,0.00000000,49645.00000000,'-','ZJD7DD4S1LNY','Subscribed to Explorer (monthly). Pro-rata discount of $$0 NZD applied.','subscription_plan','2026-02-23 22:42:55','2026-02-23 22:42:55'),(51,1,0,49.00000000,0.00000000,0.00000000,49596.00000000,'-','Q821VZ17LYDF','Subscribed to Starter (monthly). Pro-rata discount of $$0 NZD applied.','subscription_plan','2026-02-23 23:04:23','2026-02-23 23:04:23'),(52,5,0,0.00000000,0.00000000,0.00000000,12.23301235,'-','GLALRYX93FLF','Subscribed to Starter (monthly). Pro-rata discount of $$91 NZD applied.','subscription_plan','2026-02-23 23:05:06','2026-02-23 23:05:06'),(53,3,0,66.30444592,0.00000000,8.64840599,9080.69555408,'-','TSK4P7Z921RL','Subscribed to Professional (monthly). (Incl. GST) Pro-rata discount of $$41 NZD applied.','subscription_plan','2026-02-23 23:11:37','2026-02-23 23:11:37'),(54,5,0,0.00000000,0.00000000,0.00000000,12.23301235,'-','A36I44I5PXQ8','Subscribed to Explorer (monthly). (Incl. GST) Pro-rata discount of $$46 NZD applied.','subscription_plan','2026-02-23 23:13:37','2026-02-23 23:13:37');
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `update_logs`
--

DROP TABLE IF EXISTS `update_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `update_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(40) DEFAULT NULL,
  `update_log` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `update_logs`
--

LOCK TABLES `update_logs` WRITE;
/*!40000 ALTER TABLE `update_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `update_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_logins`
--

DROP TABLE IF EXISTS `user_logins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_logins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT 0,
  `influencer_id` int(10) unsigned NOT NULL DEFAULT 0,
  `user_ip` varchar(40) DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `country` varchar(40) DEFAULT NULL,
  `country_code` varchar(40) DEFAULT NULL,
  `longitude` varchar(40) DEFAULT NULL,
  `latitude` varchar(40) DEFAULT NULL,
  `browser` varchar(40) DEFAULT NULL,
  `os` varchar(40) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_logins`
--

LOCK TABLES `user_logins` WRITE;
/*!40000 ALTER TABLE `user_logins` DISABLE KEYS */;
INSERT INTO `user_logins` VALUES (1,0,1,'192.168.65.1','','','','','','Chrome','Mac OS X','2026-02-19 02:09:57','2026-02-19 02:09:57'),(2,0,2,'192.168.65.1','','','','','','Chrome','Mac OS X','2026-02-19 03:16:06','2026-02-19 03:16:06'),(3,0,3,'178.237.33.50','','','','','','Chrome','Mac OS X','2026-02-19 03:23:58','2026-02-19 03:23:58'),(4,0,4,'178.237.33.50','','','','','','Chrome','Mac OS X','2026-02-19 03:24:21','2026-02-19 03:24:21'),(5,0,5,'192.168.65.1','','','','','','Chrome','Mac OS X','2026-02-19 04:21:23','2026-02-19 04:21:23'),(6,1,0,'192.168.65.1','','','','','','Chrome','Mac OS X','2026-02-19 05:12:03','2026-02-19 05:12:03'),(7,0,6,'192.168.65.1','','','','','','Chrome','Mac OS X','2026-02-19 10:14:30','2026-02-19 10:14:30'),(8,2,0,'192.168.65.1','','','','','','Chrome','Mac OS X','2026-02-19 18:36:03','2026-02-19 18:36:03'),(9,3,0,'192.168.65.1','','','','','','Chrome','Mac OS X','2026-02-19 21:40:37','2026-02-19 21:40:37'),(10,0,7,'178.237.33.50','','','','','','Chrome','Mac OS X','2026-02-19 21:42:00','2026-02-19 21:42:00'),(11,0,8,'192.168.65.1','','','','','','Chrome','Mac OS X','2026-02-20 03:03:10','2026-02-20 03:03:10'),(12,4,0,'192.168.65.1','','','','','','Chrome','Mac OS X','2026-02-21 05:10:47','2026-02-21 05:10:47'),(13,5,0,'192.168.65.1','','','','','','Chrome','Mac OS X','2026-02-23 15:52:19','2026-02-23 15:52:19');
/*!40000 ALTER TABLE `user_logins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(40) DEFAULT NULL,
  `lastname` varchar(40) DEFAULT NULL,
  `username` varchar(40) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `tax_number` varchar(255) DEFAULT NULL,
  `is_gst_registered` tinyint(1) NOT NULL DEFAULT 0,
  `gst_number` varchar(255) DEFAULT NULL,
  `email` varchar(40) NOT NULL,
  `dial_code` varchar(40) DEFAULT NULL,
  `country_code` varchar(40) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zip` varchar(255) DEFAULT NULL,
  `mobile` varchar(40) DEFAULT NULL,
  `balance` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `plan_id` bigint(20) unsigned DEFAULT NULL,
  `plan_ends_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `country_name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL COMMENT 'contains full address',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0: banned, 1: active',
  `kyc_data` text DEFAULT NULL,
  `kyc_rejection_reason` varchar(255) DEFAULT NULL,
  `kv` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: KYC Unverified, 2: KYC pending, 1: KYC verified',
  `ev` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: email unverified, 1: email verified',
  `sv` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: mobile unverified, 1: mobile verified',
  `profile_complete` tinyint(1) NOT NULL DEFAULT 0,
  `ver_code` varchar(40) DEFAULT NULL COMMENT 'stores verification code',
  `ver_code_send_at` datetime DEFAULT NULL COMMENT 'verification send time',
  `ban_reason` varchar(255) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `user_last_seen` timestamp NULL DEFAULT NULL,
  `brand_name` varchar(40) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`,`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Dylan','Schwartz','kjhhfdsfdsf',NULL,NULL,0,NULL,'dymschwa@gmail.com','64','NZ',NULL,NULL,NULL,'43254354325',49596.00000000,1,'2026-03-23 23:04:23','$2y$12$pu6PsPQKLvyebpWE0hvCUO2N4eOOoheu120BDFfY9ZyjLv0AvEni6','New Zealand','69969cce4ddf21771478222.jpg',NULL,1,NULL,NULL,1,1,1,1,NULL,NULL,NULL,NULL,'2026-02-23 23:04:55','dsfgfdg','https://toast.wedding','2026-02-19 05:12:03','2026-02-23 23:04:55'),(2,'Dylan','Schwartz','vdfaafafvadf',NULL,NULL,0,NULL,'fsadfsdf@mail.com','64','NZ',NULL,NULL,NULL,'22356565656',0.00000000,NULL,NULL,'$2y$12$TifgQeUVVgs./TuaBavRU.cFGOSHT8CDRBTpnvgIgUWvelSCWtXe6','New Zealand','6997582e6b3d51771526190.jpg',NULL,1,NULL,NULL,1,1,1,1,NULL,NULL,NULL,NULL,'2026-02-22 22:53:52','sgdfsgfdgd','https://kldsjfakj.com','2026-02-19 18:36:03','2026-02-22 22:53:52'),(3,'Example','brand','examplebrand',NULL,'123456789',1,'123456789','example@example.com','64','NZ',NULL,NULL,NULL,'1234567',9080.69555408,2,'2026-03-23 23:11:37','$2y$12$Vl6nza.saMLYMrNU6HuGn.TXKKBZrVwqHB7z634IR6P1vEynnDOY2','New Zealand','6997837d259381771537277.jpg','123 Main Street',1,NULL,NULL,1,1,1,1,NULL,NULL,NULL,NULL,'2026-02-23 23:12:50','Example Brand','https://example.com','2026-02-19 21:40:37','2026-02-23 23:12:50'),(4,'John','Ivan','brandsubscriber',NULL,'12345678',1,'12345678','dsfds@gmail.com','64','NZ',NULL,NULL,NULL,'4334634634',633.00000000,1,'2026-03-21 06:45:57','$2y$12$Pt4/2KSPEgvEsPyF0hVM3u1EIb2biy.JM6vXHpOeO7thFba2rO6xi','New Zealand','69993eae342941771650734.JPG','96 Wynyard Crescent',1,NULL,NULL,1,1,1,1,NULL,NULL,NULL,NULL,'2026-02-23 23:10:57','Best Brand','https://bestbrad.com','2026-02-21 05:10:47','2026-02-23 23:10:57'),(5,'Test','Brand','brandtest',NULL,'123456789',1,'123456789','brand@brand.com','64','NZ',NULL,NULL,NULL,'32431446546543634565436534',12.23301235,3,'2026-03-23 23:13:37','$2y$12$nvn8mwuTaqUr3ruDZ/Ak7uPAPlezb.1JEMEfI6ouIaWOES1BZM8Ou','New Zealand','699bc1ef345f11771815407.png','111 Any Street, New Zealand',1,NULL,NULL,1,1,1,1,NULL,NULL,NULL,NULL,'2026-02-23 23:48:32','Test Brand','https://bestbrand.com','2026-02-23 15:52:19','2026-02-23 23:48:32');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `withdraw_methods`
--

DROP TABLE IF EXISTS `withdraw_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `withdraw_methods` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(10) unsigned NOT NULL DEFAULT 0,
  `name` varchar(40) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `min_limit` decimal(28,8) DEFAULT 0.00000000,
  `max_limit` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `fixed_charge` decimal(28,8) DEFAULT 0.00000000,
  `rate` decimal(28,8) DEFAULT 0.00000000,
  `percent_charge` decimal(5,2) DEFAULT NULL,
  `currency` varchar(40) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `withdraw_methods`
--

LOCK TABLES `withdraw_methods` WRITE;
/*!40000 ALTER TABLE `withdraw_methods` DISABLE KEYS */;
/*!40000 ALTER TABLE `withdraw_methods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `withdrawals`
--

DROP TABLE IF EXISTS `withdrawals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `withdrawals` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `method_id` int(10) unsigned NOT NULL DEFAULT 0,
  `influencer_id` int(10) unsigned NOT NULL DEFAULT 0,
  `amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `currency` varchar(40) DEFAULT NULL,
  `rate` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `trx` varchar(40) DEFAULT NULL,
  `final_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `after_charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `withdraw_information` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=>success, 2=>pending, 3=>cancel,  ',
  `admin_feedback` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `withdrawals`
--

LOCK TABLES `withdrawals` WRITE;
/*!40000 ALTER TABLE `withdrawals` DISABLE KEYS */;
/*!40000 ALTER TABLE `withdrawals` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-02-23 10:49:29
