<?php
class Conexion extends PDO
{
    private $tipo_de_base = 'mysql';
    private $host = 'localhost';
    private $nombre_de_base = 'sistem_fares';
    private $usuario = 'root';
    private $contrasena = '';

    public function __construct()
    {
        try {
            parent::__construct(
                "{$this->tipo_de_base}:dbname={$this->nombre_de_base};host={$this->host};charset=utf8mb4",
                $this->usuario,
                $this->contrasena,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_EMULATE_PREPARES => false]
            );
        } catch (PDOException $error) {
            throw new PDOException('Error al conectar con la base de datos.', (int) $error->getCode(), $error);
        }
    }
}
