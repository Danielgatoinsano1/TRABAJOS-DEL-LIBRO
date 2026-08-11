-- Base de datos del sistema Fares (clientes e inventario).
CREATE DATABASE IF NOT EXISTS `sistem_fares`
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `sistem_fares`;

CREATE TABLE IF NOT EXISTS `clientes` (
  `idcli` INT UNSIGNED NOT NULL,
  `nomcli` VARCHAR(120) NOT NULL,
  `direccli` VARCHAR(255) NOT NULL,
  `telres_cli` VARCHAR(25) DEFAULT NULL,
  `telcel_cli` VARCHAR(25) DEFAULT NULL,
  `email_cli` VARCHAR(150) DEFAULT NULL,
  PRIMARY KEY (`idcli`),
  UNIQUE KEY `uq_clientes_email` (`email_cli`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `inventario` (
  `codigo` INT UNSIGNED NOT NULL,
  `nom_producto` VARCHAR(150) NOT NULL,
  `costo` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `porc_venta` DECIMAL(6,2) NOT NULL DEFAULT 0.00,
  `precio_venta` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `fecha` DATE NOT NULL,
  `Imagen` VARCHAR(255) DEFAULT NULL,
  `stock` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
