-- Importar este archivo en phpMyAdmin dentro de la base sistem_fares.
-- Solo crea la tabla faltante; no modifica ni elimina productos.

USE `sistem_fares`;

CREATE TABLE IF NOT EXISTS `movimientos` (
  `id_movimiento` INT NOT NULL AUTO_INCREMENT,
  `id_producto` INT NOT NULL,
  `fecha_movimiento` DATE NOT NULL,
  `cantidad_movi` INT NOT NULL,
  PRIMARY KEY (`id_movimiento`),
  KEY `idx_movimientos_producto` (`id_producto`)
) ENGINE=InnoDB
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;