<?php
require_once __DIR__ . '/configuracion_bd.php';

function conect($base = 'sistem_fares')
{
    try {
        return crearConexionBaseDatos($base);
    } catch (PDOException $error) {
        error_log('Error de conexión a ' . $base . ': ' . $error->getMessage());
        throw new RuntimeException('No se pudo conectar con la base de datos solicitada.', 0, $error);
    }
}
