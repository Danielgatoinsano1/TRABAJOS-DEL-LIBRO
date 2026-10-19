<?php
require_once __DIR__ . '/configuracion_bd.php';

class Conexion extends PDO
{
    public function __construct($base = 'sistem_fares')
    {
        try {
            $config = configuracionBaseDatos($base);
            parent::__construct(
                "mysql:host={$config['host']};dbname={$config['base']};charset={$config['charset']}",
                $config['usuario'],
                $config['contrasena'],
                [
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                ]
            );
        } catch (PDOException $e) {
            error_log('Error de conexión a ' . $base . ': ' . $e->getMessage());
            throw new RuntimeException('No se pudo conectar con la base de datos solicitada.', 0, $e);
        }
    }
}
