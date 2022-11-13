-- MariaDB dump 10.19  Distrib 10.4.25-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: gamedb
-- ------------------------------------------------------
-- Server version	10.4.25-MariaDB

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
-- Table structure for table `game_status`
--

DROP TABLE IF EXISTS `game_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `game_status` (
  `status` enum('not active','initialized','started','ended','aborded') NOT NULL DEFAULT 'not active',
  `player_turn` enum('player1','player2') DEFAULT NULL,
  `result` enum('player1','player2') DEFAULT NULL,
  `last_change` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `game_status`
--

LOCK TABLES `game_status` WRITE;
/*!40000 ALTER TABLE `game_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `game_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `karta`
--

DROP TABLE IF EXISTS `karta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `karta` (
  `id` int(11) NOT NULL,
  `arithmos` varchar(50) DEFAULT NULL,
  `xroma` varchar(50) DEFAULT NULL,
  `symvolo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `karta`
--

LOCK TABLES `karta` WRITE;
/*!40000 ALTER TABLE `karta` DISABLE KEYS */;
INSERT INTO `karta` VALUES (1,'2','mavro','trifylli'),(2,'3','mavro','trifylli'),(3,'4','mavro','trifylli'),(4,'5','mavro','trifylli'),(5,'6','mavro','trifylli'),(6,'7','mavro','trifylli'),(7,'8','mavro','trifylli'),(8,'9','mavro','trifylli'),(9,'10','mavro','trifylli'),(10,'J','mavro','trifylli'),(11,'K','mavro','trifylli'),(12,'Q','mavro','trifylli'),(13,'A','mavro','trifylli'),(14,'2','mavro','bastouni'),(15,'3','mavro','bastouni'),(16,'4','mavro','bastouni'),(17,'5','mavro','bastouni'),(18,'6','mavro','bastouni'),(19,'7','mavro','bastouni'),(20,'8','mavro','bastouni'),(21,'9','mavro','bastouni'),(22,'10','mavro','bastouni'),(23,'J','mavro','bastouni'),(24,'K','mavro','bastouni'),(25,'Q','mavro','bastouni'),(26,'A','mavro','bastouni'),(27,'2','kokkino','romvos'),(28,'3','kokkino','romvos'),(29,'4','kokkino','romvos'),(30,'5','kokkino','romvos'),(31,'6','kokkino','romvos'),(32,'7','kokkino','romvos'),(33,'8','kokkino','romvos'),(34,'9','kokkino','romvos'),(35,'10','kokkino','romvos'),(36,'J','kokkino','romvos'),(37,'K','kokkino','romvos'),(38,'Q','kokkino','romvos'),(39,'A','kokkino','romvos'),(40,'2','kokkino','kardia'),(41,'3','kokkino','kardia'),(42,'4','kokkino','kardia'),(43,'5','kokkino','kardia'),(44,'6','kokkino','kardia'),(45,'7','kokkino','kardia'),(46,'8','kokkino','kardia'),(47,'9','kokkino','kardia'),(48,'10','kokkino','kardia'),(49,'J','kokkino','kardia'),(50,'K','kokkino','kardia'),(51,'Q','kokkino','kardia'),(52,'A','kokkino','kardia');
/*!40000 ALTER TABLE `karta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `karta_empty`
--

DROP TABLE IF EXISTS `karta_empty`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `karta_empty` (
  `id` int(11) NOT NULL,
  `arithmos` varchar(50) DEFAULT NULL,
  `xroma` varchar(50) DEFAULT NULL,
  `symvolo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `karta_empty`
--

LOCK TABLES `karta_empty` WRITE;
/*!40000 ALTER TABLE `karta_empty` DISABLE KEYS */;
INSERT INTO `karta_empty` VALUES (1,'2','mavro','trifylli'),(2,'3','mavro','trifylli'),(3,'4','mavro','trifylli'),(4,'5','mavro','trifylli'),(5,'6','mavro','trifylli'),(6,'7','mavro','trifylli'),(7,'8','mavro','trifylli'),(8,'9','mavro','trifylli'),(9,'10','mavro','trifylli'),(10,'J','mavro','trifylli'),(11,'K','mavro','trifylli'),(12,'Q','mavro','trifylli'),(13,'A','mavro','trifylli'),(14,'2','mavro','bastouni'),(15,'3','mavro','bastouni'),(16,'4','mavro','bastouni'),(17,'5','mavro','bastouni'),(18,'6','mavro','bastouni'),(19,'7','mavro','bastouni'),(20,'8','mavro','bastouni'),(21,'9','mavro','bastouni'),(22,'10','mavro','bastouni'),(23,'J','mavro','bastouni'),(24,'K','mavro','bastouni'),(25,'Q','mavro','bastouni'),(26,'A','mavro','bastouni'),(27,'2','kokkino','romvos'),(28,'3','kokkino','romvos'),(29,'4','kokkino','romvos'),(30,'5','kokkino','romvos'),(31,'6','kokkino','romvos'),(32,'7','kokkino','romvos'),(33,'8','kokkino','romvos'),(34,'9','kokkino','romvos'),(35,'10','kokkino','romvos'),(36,'J','kokkino','romvos'),(37,'K','kokkino','romvos'),(38,'Q','kokkino','romvos'),(39,'A','kokkino','romvos'),(40,'2','kokkino','kardia'),(41,'3','kokkino','kardia'),(42,'4','kokkino','kardia'),(43,'5','kokkino','kardia'),(44,'6','kokkino','kardia'),(45,'7','kokkino','kardia'),(46,'8','kokkino','kardia'),(47,'9','kokkino','kardia'),(48,'10','kokkino','kardia'),(49,'J','kokkino','kardia'),(50,'K','kokkino','kardia'),(51,'Q','kokkino','kardia'),(52,'A','kokkino','kardia');
/*!40000 ALTER TABLE `karta_empty` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `player1_karta`
--

DROP TABLE IF EXISTS `player1_karta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `player1_karta` (
  `id` int(11) NOT NULL,
  `arithmos` varchar(50) DEFAULT NULL,
  `xroma` varchar(50) DEFAULT NULL,
  `symvolo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `player1_karta`
--

LOCK TABLES `player1_karta` WRITE;
/*!40000 ALTER TABLE `player1_karta` DISABLE KEYS */;
/*!40000 ALTER TABLE `player1_karta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `player2_karta`
--

DROP TABLE IF EXISTS `player2_karta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `player2_karta` (
  `id` int(11) NOT NULL,
  `arithmos` varchar(50) DEFAULT NULL,
  `xroma` varchar(50) DEFAULT NULL,
  `symvolo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `player2_karta`
--

LOCK TABLES `player2_karta` WRITE;
/*!40000 ALTER TABLE `player2_karta` DISABLE KEYS */;
/*!40000 ALTER TABLE `player2_karta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stoiva_karta`
--

DROP TABLE IF EXISTS `stoiva_karta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stoiva_karta` (
  `id` int(11) NOT NULL,
  `arithmos` varchar(50) DEFAULT NULL,
  `xroma` varchar(50) DEFAULT NULL,
  `symvolo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stoiva_karta`
--

LOCK TABLES `stoiva_karta` WRITE;
/*!40000 ALTER TABLE `stoiva_karta` DISABLE KEYS */;
/*!40000 ALTER TABLE `stoiva_karta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `onoma` enum('player1','player2') NOT NULL,
  `token` varchar(100) DEFAULT NULL,
  `last_action` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`onoma`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'gamedb'
--
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `clean_karta` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `clean_karta`()
begin
	replace into karta select * from karta_empty;
    update game_status set status = 'not active', player_turn = null, result = null;
    update user set onoma = null, token = null;
    delete from player1_karta;
    delete from player2_karta;
    delete from stoiva_karta;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `moirasma_kartas` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `moirasma_kartas`()
begin			
	insert into player1_karta select * from karta order by rand(id) limit 26;
  	delete from karta where id in (select id from player1_karta);
    insert into player2_karta select * from karta;
    delete from karta;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `player1_win` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `player1_win`()
begin
	insert into player2_karta select * from stoiva_karta;
    delete from stoiva_karta;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `player2_win` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `player2_win`()
begin
	insert into player1_karta select * from stoiva_karta;
    delete from stoiva_karta;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-11-13 20:02:21
