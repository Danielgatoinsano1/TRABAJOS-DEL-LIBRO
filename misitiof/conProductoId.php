<?php
require_once 'classProducto.php';

header('Content-Type: text/plain; charset=utf-8');
$codigo = filter_input(INPUT_GET, 'dato', FILTER_VALIDATE_INT);
if (!$codigo || $codigo < 1) {
    exit;
}

try {
    $producto = datosProductos::consultarProductoCod($codigo);
    echo $producto ? (string) $producto[0]->nom_producto : '';
} catch (Throwable $error) {
    error_log('Error al buscar producto para movimiento: ' . $error->getMessage());
    http_response_code(500);
}
