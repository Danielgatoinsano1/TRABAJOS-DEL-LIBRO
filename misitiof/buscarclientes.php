<?php
require_once 'conexionf2.php';

header('Content-Type: application/json; charset=utf-8');

$codigo = filter_input(INPUT_POST, 'buscarcliente', FILTER_VALIDATE_INT);
if (!$codigo) {
    echo json_encode([]);
    exit;
}

try {
    $conexion = new Conexion();
    $consulta = $conexion->prepare(
        'SELECT nomcli FROM clientes WHERE idcli = :idcli LIMIT 1'
    );
    $consulta->bindValue(':idcli', $codigo, PDO::PARAM_INT);
    $consulta->execute();
    $cliente = $consulta->fetch(PDO::FETCH_ASSOC);

    echo json_encode(
        $cliente ? [['nombreCliente' => $cliente['nomcli']]] : [],
        JSON_UNESCAPED_UNICODE
    );
} catch (Throwable $error) {
    http_response_code(500);
    echo json_encode(['error' => 'No se pudo consultar el cliente.']);
}
