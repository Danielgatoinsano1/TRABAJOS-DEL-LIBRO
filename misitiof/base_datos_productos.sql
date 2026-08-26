-- Base de datos para classProducto.php
-- Compatible con MySQL/MariaDB y phpMyAdmin.

CREATE DATABASE IF NOT EXISTS `sistem_fares`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE `sistem_fares`;

CREATE TABLE IF NOT EXISTS `inventario` (
  `Codigo` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_producto` VARCHAR(50) NOT NULL,
  `costo` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `porc_venta` DECIMAL(6,2) NOT NULL DEFAULT 0.00,
  `precio_venta` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `imagen` VARCHAR(255) DEFAULT NULL,
  `stock` INT NOT NULL DEFAULT 0,
  `fecha` DATE NOT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `idx_inventario_producto` (`nom_producto`)
) ENGINE=InnoDB
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;
CREATE TABLE IF NOT EXISTS `movimientos` (
  `id_movimiento` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_producto` INT UNSIGNED NOT NULL,
  `fecha_movimiento` DATE NOT NULL,
  `cantidad_movi` INT NOT NULL,
  PRIMARY KEY (`id_movimiento`),
  KEY `idx_movimientos_producto` (`id_producto`),
  CONSTRAINT `fk_movimientos_producto`
    FOREIGN KEY (`id_producto`) REFERENCES `inventario` (`Codigo`)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
) ENGINE=InnoDB
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;