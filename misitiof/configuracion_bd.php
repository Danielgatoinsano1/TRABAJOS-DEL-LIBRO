<?php

/**
 * Configuracion compartida de MySQL.
 *
 * La aplicacion guarda sus tablas en sistem_fares. sistema_fares es la base
 * antigua de clientes y se puede seleccionar para la migracion o consultas.
 */
function configuracionBaseDatos($base = 'sistem_fares')
{
    $basesPermitidas = ['sistem_fares', 'sistema_fares'];
    if (!in_array($base, $basesPermitidas, true)) {
        throw new InvalidArgumentException('Base de datos no configurada.');
    }

    return [
        'host' => getenv('FARES_DB_HOST') ?: 'localhost',
        'usuario' => getenv('FARES_DB_USER') ?: 'root',
        'contrasena' => getenv('FARES_DB_PASSWORD') ?: '',
        'base' => $base,
        'charset' => 'utf8mb4',
    ];
}

function crearConexionBaseDatos($base = 'sistem_fares')
{
    $config = configuracionBaseDatos($base);
    $dsn = "mysql:host={$config['host']};dbname={$config['base']};charset={$config['charset']}";

    return new PDO($dsn, $config['usuario'], $config['contrasena'], [
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
}
