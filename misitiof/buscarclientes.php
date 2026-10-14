<?php
require_once 'conexionf2.php';

header('Content-Type: application/json; charset=utf-8');

try {
    $codigo = filter_input(INPUT_POST, 'buscarcliente', FILTER_VALIDATE_INT);
    if (!$codigo || $codigo < 1) {
        echo json_encode([]);
        exit;
    }

    $conexion = new Conexion();
    $consulta = $conexion->prepare(
        'SELECT idcli, nomcli FROM clientes WHERE idcli = :codigo'
    );
    $consulta->execute([':codigo' => $codigo]);
    $cliente = $consulta->fetch();

    echo json_encode(
        $cliente ? [['nombrecliente' => $cliente['nomcli']]] : [],
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    );
} catch (Throwable $error) {
    error_log('Error al buscar cliente para factura: ' . $error->getMessage());
    http_response_code(500);
    echo json_encode(['error' => true]);
}
