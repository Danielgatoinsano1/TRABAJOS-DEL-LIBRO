<?php

class Conexion extends PDO
{
    private $tipo_de_base = "mysql";
    private $host = "localhost";
    private $nombre_de_base = "sistem_fares";
    private $usuario = "root";
    private $contrasena = "";

    public function __construct()
    {
        try {
            parent::__construct(
                "{$this->tipo_de_base}:dbname={$this->nombre_de_base};host={$this->host};charset=utf8",
                $this->usuario,
                $this->contrasena
            );

            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            error_log('Error de conexión a sistem_fares: ' . $e->getMessage());
            throw new RuntimeException('No se pudo conectar con la base de datos.', 0, $e);
        }
    }
}
