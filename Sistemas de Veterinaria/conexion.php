<?php

class Conexion
{
    protected PDO $conexion;

    public function __construct()
    {
        $dsn = 'mysql:host=localhost;dbname=santuario_mascotas;charset=utf8mb4';

        try {
            $this->conexion = new PDO($dsn, 'root', '', [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            throw new RuntimeException(
                'No fue posible conectar con la base de datos. Verifica que MySQL esté activo y que la base santuario_mascotas exista.',
                0,
                $e
            );
        }
    }

    public function obtenerConexion(): PDO
    {
        return $this->conexion;
    }
}
