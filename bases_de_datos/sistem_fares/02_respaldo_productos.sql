-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: sistem_fares
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

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
-- Current Database: `sistem_fares`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `sistem_fares` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `sistem_fares`;

--
-- Table structure for table `inventario`
--

DROP TABLE IF EXISTS `inventario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventario` (
  `Codigo` int(11) NOT NULL,
  `nom_producto` varchar(50) NOT NULL,
  `costo` decimal(11,0) NOT NULL,
  `porc_venta` decimal(11,0) NOT NULL,
  `precio_venta` int(11) NOT NULL,
  `imagen` int(11) DEFAULT NULL,
  `stock` int(11) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventario`
--

LOCK TABLES `inventario` WRITE;
/*!40000 ALTER TABLE `inventario` DISABLE KEYS */;
INSERT INTO `inventario` VALUES (111,'jjjjj',10,10,0,NULL,0,'2026-03-19'),(0,'ggggg',100,10,0,NULL,0,'2026-03-07'),(159874,'holaa',1500,112,0,NULL,0,'2026-03-11'),(89896,'vgggf',132,15,0,NULL,0,'2026-03-05'),(56565,'holaaaa',654,95,0,NULL,0,'2026-03-11'),(3029233,'LOGO DE CAFE ONLINE',91,10,100,0,0,'2026-05-07'),(90232323,'PRONADOR JOSUES',31,222,100,0,0,'2026-04-30'),(11,'Fijador de cabello ',122,2,124,11,0,'2026-04-29'),(1804,'Jugo de Zanahoria',15,200,45,1804,0,'2026-06-28'),(12323123,' ad a sda s ad ad',0,0,0,0,0,'0000-00-00'),(2,'Jabon',23,1,23,2,0,'2026-07-28'),(3,'Almendra',23,23,28,3,0,'2026-08-12');
/*!40000 ALTER TABLE `inventario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'sistem_fares'
--

--
-- Dumping routines for database 'sistem_fares'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-08-11 11:55:42
