-- La aplicación se conecta a `sistem_fares` (ver conexionf2.php).
-- Ejecutar este archivo para completar instalaciones que solo importaron
-- las tablas de inventario y movimientos.
USE `sistem_fares`;

CREATE TABLE IF NOT EXISTS `clientes` (
  `idcli` INT NOT NULL AUTO_INCREMENT,
  `nomcli` TEXT NOT NULL,
  `direccli` TEXT DEFAULT NULL,
  `telres_cli` TEXT DEFAULT NULL,
  `telcel_cli` TEXT DEFAULT NULL,
  `email_cli` TEXT DEFAULT NULL,
  PRIMARY KEY (`idcli`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
