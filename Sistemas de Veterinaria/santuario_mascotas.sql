-- Base de datos del sistema de veterinaria.
CREATE DATABASE IF NOT EXISTS `santuario_mascotas`
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `santuario_mascotas`;

CREATE TABLE IF NOT EXISTS `Mascotas` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `especie` VARCHAR(80) NOT NULL,
  `raza` VARCHAR(100) NOT NULL,
  `edad` INT UNSIGNED NOT NULL,
  `peso_actual` DECIMAL(7,2) NOT NULL,
  `color_senas` VARCHAR(255) NOT NULL,
  `responsable` VARCHAR(150) NOT NULL,
  `telefono_emergencia` VARCHAR(25) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_mascotas_nombre` (`nombre`),
  KEY `idx_mascotas_especie` (`especie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
