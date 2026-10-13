CREATE DATABASE IF NOT EXISTS `sistem_fares` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `sistem_fares`;

-- Conserva tablas y registros que ya existan.
CREATE TABLE IF NOT EXISTS `clientes` (
  `idcli` INT NOT NULL AUTO_INCREMENT,
  `nomcli` TEXT NOT NULL,
  `direccli` TEXT DEFAULT NULL,
  `telres_cli` TEXT DEFAULT NULL,
  `telcel_cli` TEXT DEFAULT NULL,
  `email_cli` TEXT DEFAULT NULL,
  PRIMARY KEY (`idcli`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `inventario` (
  `Codigo` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_producto` VARCHAR(50) NOT NULL,
  `costo` DECIMAL(10,2) NOT NULL DEFAULT 0,
  `porc_venta` DECIMAL(6,2) NOT NULL DEFAULT 0,
  `precio_venta` DECIMAL(10,2) NOT NULL DEFAULT 0,
  `imagen` VARCHAR(255) DEFAULT NULL,
  `stock` INT NOT NULL DEFAULT 0,
  `fecha` DATE NOT NULL,
  PRIMARY KEY (`Codigo`), KEY `idx_inventario_producto` (`nom_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Normaliza instalaciones antiguas de inventario que carecen de clave primaria.
ALTER TABLE `inventario` MODIFY `Codigo` INT UNSIGNED NOT NULL AUTO_INCREMENT;
SET @sql_pk = (SELECT IF(COUNT(*) = 0, 'ALTER TABLE `inventario` ADD PRIMARY KEY (`Codigo`)', 'SELECT 1') FROM information_schema.statistics WHERE table_schema = DATABASE() AND table_name = 'inventario' AND index_name = 'PRIMARY');
PREPARE sentencia_pk FROM @sql_pk;
EXECUTE sentencia_pk;
DEALLOCATE PREPARE sentencia_pk;
CREATE TABLE IF NOT EXISTS `factura` (
  `idfactura` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `idcli` INT NOT NULL,
  `fecha` DATE NOT NULL,
  `subtotal` DECIMAL(12,2) NOT NULL DEFAULT 0,
  `iva` DECIMAL(12,2) NOT NULL DEFAULT 0,
  `total` DECIMAL(12,2) NOT NULL DEFAULT 0,
  PRIMARY KEY (`idfactura`), KEY `idx_factura_cliente` (`idcli`),
  CONSTRAINT `fk_factura_cliente` FOREIGN KEY (`idcli`) REFERENCES `clientes` (`idcli`) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `detalle_factura` (
  `iddetalle` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `idfactura` INT UNSIGNED NOT NULL,
  `Codigo` INT UNSIGNED NOT NULL,
  `cantidad` INT UNSIGNED NOT NULL,
  `precio` DECIMAL(12,2) NOT NULL,
  `subtotal` DECIMAL(12,2) NOT NULL,
  PRIMARY KEY (`iddetalle`), KEY `idx_detalle_factura` (`idfactura`), KEY `idx_detalle_producto` (`Codigo`),
  CONSTRAINT `fk_detalle_factura` FOREIGN KEY (`idfactura`) REFERENCES `factura` (`idfactura`) ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT `fk_detalle_producto` FOREIGN KEY (`Codigo`) REFERENCES `inventario` (`Codigo`) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Datos mínimos de demostración solo cuando las tablas están vacías.
INSERT INTO `clientes` (`nomcli`, `direccli`, `email_cli`)
SELECT 'Cliente de prueba', 'Domicilio de prueba', 'prueba@example.com'
WHERE NOT EXISTS (SELECT 1 FROM `clientes`);
INSERT INTO `inventario` (`nom_producto`, `costo`, `porc_venta`, `precio_venta`, `stock`, `fecha`)
SELECT 'Producto de prueba', 100.00, 15.00, 115.00, 100, CURDATE()
WHERE NOT EXISTS (SELECT 1 FROM `inventario`);

