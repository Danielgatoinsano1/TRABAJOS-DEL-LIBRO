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

-- Agrega primero la clave: MariaDB requiere un índice para AUTO_INCREMENT.
SET @sql_pk = (SELECT IF(COUNT(*) = 0, 'ALTER TABLE `inventario` ADD PRIMARY KEY (`Codigo`)', 'SELECT 1') FROM information_schema.statistics WHERE table_schema = DATABASE() AND table_name = 'inventario' AND index_name = 'PRIMARY');
PREPARE sentencia_pk FROM @sql_pk;
EXECUTE sentencia_pk;
DEALLOCATE PREPARE sentencia_pk;
ALTER TABLE `inventario` MODIFY `Codigo` INT UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `inventario`
  MODIFY `costo` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  MODIFY `porc_venta` DECIMAL(6,2) NOT NULL DEFAULT 0.00,
  MODIFY `precio_venta` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  MODIFY `imagen` VARCHAR(255) DEFAULT NULL;
CREATE TABLE IF NOT EXISTS `movimientos` (
  `id_movimiento` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_producto` INT UNSIGNED NOT NULL,
  `fecha_movimiento` DATE NOT NULL,
  `cantidad_movi` INT NOT NULL,
  PRIMARY KEY (`id_movimiento`),
  KEY `idx_movimientos_producto` (`id_producto`),
  CONSTRAINT `fk_movimientos_producto`
    FOREIGN KEY (`id_producto`) REFERENCES `inventario` (`Codigo`)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
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

-- Tablas requeridas por el flujo de facturación del libro.
CREATE TABLE IF NOT EXISTS `controlfactura` (
  `idcontrolfactura` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nofactura` INT UNSIGNED NOT NULL,
  `codclientefact` INT NOT NULL,
  `subtotalfact` DECIMAL(12,2) NOT NULL DEFAULT 0,
  `impuestofact` DECIMAL(12,2) NOT NULL DEFAULT 0,
  `grantotalfact` DECIMAL(12,2) NOT NULL DEFAULT 0,
  `creada` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcontrolfactura`),
  UNIQUE KEY `uq_controlfactura_numero` (`nofactura`),
  KEY `idx_controlfactura_cliente` (`codclientefact`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `movimientofactura` (
  `idmovimientofact` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `facturano` INT UNSIGNED NOT NULL,
  `clienteid` INT NOT NULL,
  `productoid` INT UNSIGNED NOT NULL,
  `cantfact` INT UNSIGNED NOT NULL,
  `precifact` DECIMAL(12,2) NOT NULL,
  `totalfact` DECIMAL(12,2) NOT NULL,
  PRIMARY KEY (`idmovimientofact`),
  KEY `idx_movfact_factura` (`facturano`),
  KEY `idx_movfact_producto` (`productoid`),
  CONSTRAINT `fk_movfact_control`
    FOREIGN KEY (`facturano`) REFERENCES `controlfactura` (`nofactura`)
    ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Datos mínimos de demostración solo cuando las tablas están vacías.
INSERT INTO `clientes` (`nomcli`, `direccli`, `email_cli`)
SELECT 'Cliente de prueba', 'Domicilio de prueba', 'prueba@example.com'
WHERE NOT EXISTS (SELECT 1 FROM `clientes`);
INSERT INTO `inventario` (`nom_producto`, `costo`, `porc_venta`, `precio_venta`, `stock`, `fecha`)
SELECT 'Producto de prueba', 100.00, 15.00, 115.00, 100, CURDATE()
WHERE NOT EXISTS (SELECT 1 FROM `inventario`);

