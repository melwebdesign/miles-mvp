-- MySQL dump 10.13  Distrib 8.0.43, for Linux (aarch64)
--
-- Host: localhost    Database: app
-- ------------------------------------------------------
-- Server version	8.0.43

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reservation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pickup_datetime` datetime NOT NULL,
  `return_datetime` datetime NOT NULL,
  `pickup_city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `return_city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `return_at_different_location` tinyint(1) NOT NULL,
  `vehicle_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_42C84955545317D1` (`vehicle_id`),
  CONSTRAINT `FK_42C84955545317D1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservation`
--

LOCK TABLES `reservation` WRITE;
/*!40000 ALTER TABLE `reservation` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicle`
--

DROP TABLE IF EXISTS `vehicle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicle` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `make` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `production_year` int NOT NULL,
  `price` int NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seats` int NOT NULL,
  `doors` int NOT NULL,
  `gearbox` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehicle_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `power` int NOT NULL,
  `powertrain` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `minimum_driver_age` int NOT NULL,
  `insurance_deductible` int NOT NULL,
  `mileage` int NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicle`
--

LOCK TABLES `vehicle` WRITE;
/*!40000 ALTER TABLE `vehicle` DISABLE KEYS */;
INSERT INTO `vehicle` VALUES (1,'Ford Puma (155)','Ford','Puma',2023,399,'https://abo.miles-mobility.com/media/437/download/Ford_Puma-155_diagonal_left.jpg?v=1',5,5,'Automatic','Petrol',155,'2WD','SUV',18,900,500,'active'),(2,'Audi A4','Audi','A4 Avant',2023,548,'https://abo.miles-mobility.com/media/290/download/Audi_A4_avant_diagonal-left.jpg?v=1',5,5,'Automatic','Petrol',146,'2WD','Station Wagon',23,900,500,'active'),(3,'VW Polo','VW','Polo',2023,387,'https://abo.miles-mobility.com/media/249/download/VW_Polo_diagonal_left.jpg',5,5,'Automatic','Petrol',95,'2WD','Small Car',18,900,500,'active'),(4,'Jeep Compass Schwarz','Jeep','Compass',2023,499,'https://abo.miles-mobility.com/media/505/download/4Q0A9139.jpg',5,5,'Automatic','Plug-in Hybrid',240,'4WD','SUV',18,1000,500,'active'),(5,'VW Tiguan','VW','Tiguan',2023,548,'https://abo.miles-mobility.com/media/351/download/VW_Tiguan_diagonal-front.jpg',5,5,'Automatic','Petrol',150,'2WD','SUV',23,900,500,'active'),(6,'Opel Mokka-e Voltaik Blau Metallic','Opel','Mokka-e',2023,399,'https://abo.miles-mobility.com/media/540/download/4Q0A9153.jpg',5,5,'Automatic','Electric',100,'2WD','SUV',18,1000,500,'active'),(7,'Tesla Model 3 (RWD)','Tesla','Model 3 (RWD)',2023,669,'https://abo.miles-mobility.com/media/303/download/MILES_Tesla-Model-3_diagonal.jpg',5,4,'Automatic','Electric',325,'2WD','Sedan',23,1000,500,'active'),(8,'Opel Mokka-e Kontrast Grau Metallic','Opel','Mokka-e',2023,399,'https://abo.miles-mobility.com/media/530/download/4Q0A9153.jpg',5,5,'Automatic','Electric',100,'2WD','SUV',18,1000,500,'active'),(9,'Audi A4 Avant S-line','Audi','A4 S-line',2023,749,'https://abo.miles-mobility.com/media/391/download/Audi_A4_s-line_diagonal.jpg',5,5,'Automatic','Petrol',146,'2WD','Station Wagon',23,900,500,'active'),(10,'Jeep Compass Graphite Grey','Jeep','Compass',2023,499,'https://abo.miles-mobility.com/media/511/download/4Q0A9139.jpg',5,5,'Automatic','Plug-in Hybrid',240,'4WD','SUV',18,1000,500,'active');
/*!40000 ALTER TABLE `vehicle` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-29  9:33:20
