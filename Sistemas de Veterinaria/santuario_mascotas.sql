-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: santuario_mascotas
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
-- Current Database: `santuario_mascotas`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `santuario_mascotas` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `santuario_mascotas`;

--
-- Table structure for table `mascotas`
--

DROP TABLE IF EXISTS `mascotas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mascotas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `especie` varchar(80) NOT NULL,
  `raza` varchar(100) NOT NULL,
  `edad` int(10) unsigned NOT NULL,
  `peso_actual` decimal(8,2) NOT NULL,
  `color_senas` varchar(255) NOT NULL,
  `responsable` varchar(150) NOT NULL,
  `telefono_emergencia` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mascotas`
--

LOCK TABLES `mascotas` WRITE;
/*!40000 ALTER TABLE `mascotas` DISABLE KEYS */;
INSERT INTO `mascotas` VALUES (4,'piruli','GATO','perlin',23,23.00,'puntos negro color negro','Dnaiel Perez','33334444'),(5,'dabdel','Perro','Pitbull',3,55.00,'Negro con puntos blancos','Josue Martinez','5455-5666'),(6,'daniel','GATO','Ferman',1,34.00,'Blanco','Leyla Ferreira','4567-8967'),(7,'VenganAmi','Perro','N/A',4,60.00,'COLOR CAFE','Maria Josefa Perez','8888-8888'),(8,'HADES666','Perro','Chihuahua',2,40.00,'CAFE','Yuliany Fermencia','3333-3432'),(9,'Anuelito','Loro','ternan',1,23.00,'Verde conrojo','Andres Pereira','3233-2334'),(10,'Fercho','Conejo','Condejal',1,65.00,'Blanco con cafe','Dana Perez','9998-9989'),(11,'Adrialito','Perro','doberman',4,55.00,'Negro con Orejas CAFE','Helen Wollpert','4390-6789'),(12,'Danis','Perico','Florkus',1,23.00,'Verde con Rojo','Josue Perez','3389-8978');
/*!40000 ALTER TABLE `mascotas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'santuario_mascotas'
--

--
-- Dumping routines for database 'santuario_mascotas'
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
