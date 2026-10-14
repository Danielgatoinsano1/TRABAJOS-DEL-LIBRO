-- Tablas de facturacion para sistem_fares.
-- Los clientes residen en esta base tras la migracion desde sistema_fares.
USE `sistem_fares`;

CREATE TABLE IF NOT EXISTS `controlfactura` (
  `idcontrolfactura` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nofactura` INT UNSIGNED NOT NULL,
  `codclientefact` INT NOT NULL,
  `subtotalfact` DECIMAL(12,2) NOT NULL,
  `impuestofact` DECIMAL(12,2) NOT NULL,
  `grantotalfact` DECIMAL(12,2) NOT NULL,
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
  `precifact` DECIMAL(10,2) NOT NULL,
  `totalfact` DECIMAL(12,2) NOT NULL,
  PRIMARY KEY (`idmovimientofact`),
  KEY `idx_movfact_factura` (`facturano`),
  KEY `idx_movfact_producto` (`productoid`),
  CONSTRAINT `fk_movfact_control`
    FOREIGN KEY (`facturano`) REFERENCES `controlfactura` (`nofactura`)
    ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
