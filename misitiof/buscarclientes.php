<?php
require_once 'conexionf2.php';
header('Content-Type: application/json; charset=utf-8');
try {
    $codigo = filter_input(INPUT_POST, 'buscarcliente', FILTER_VALIDATE_INT);
    if (!$codigo) { echo json_encode([]); exit; }
    $conexion = new Conexion();
    $consulta = $conexion->prepare('SELECT nomcli AS nombreCliente FROM clientes WHERE idcli = :codigo');
    $consulta->execute([':codigo' => $codigo]);
    echo json_encode($consulta->fetchAll(PDO::FETCH_ASSOC), JSON_UNESCAPED_UNICODE);
} catch (Throwable $error) {
    http_response_code(500);
    echo json_encode(['error' => true, 'mensaje' => 'No fue posible consultar el cliente.']);
}
