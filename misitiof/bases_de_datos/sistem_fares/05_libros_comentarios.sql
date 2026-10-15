USE `sistem_fares`;

CREATE TABLE IF NOT EXISTS `libroscomentarios` (
  `id_libro_comentario` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo_libro` INT UNSIGNED NOT NULL,
  `categoria` VARCHAR(80) NOT NULL,
  `informacion` TEXT NOT NULL,
  `comentario` TEXT DEFAULT NULL,
  `creado` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_libro_comentario`),
  KEY `idx_libroscomentarios_categoria` (`categoria`),
  KEY `idx_libroscomentarios_libro` (`codigo_libro`),
  CONSTRAINT `fk_libroscomentarios_inventario`
    FOREIGN KEY (`codigo_libro`) REFERENCES `inventario` (`Codigo`)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
