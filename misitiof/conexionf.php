<?php
function conect()
{
    $nom_servidor = "localhost";
    $username = "root";
    $password = "";

    try {
        return new PDO(
            "mysql:host=$nom_servidor;dbname=sistem_fares;charset=utf8mb4",
            $username,
            $password,
            [
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]
        );
    } catch (PDOException $error) {
        error_log('Error de conexión a sistem_fares: ' . $error->getMessage());
        throw new RuntimeException('No se pudo conectar con la base de datos.', 0, $error);
    }
}

?>
