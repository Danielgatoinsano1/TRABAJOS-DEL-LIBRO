<?php
require_once 'conexionf2.php';
header('Content-Type: application/json; charset=utf-8');
try {
    $codigo = filter_input(INPUT_POST, 'producto', FILTER_VALIDATE_INT);
    if (!$codigo) { echo json_encode([]); exit; }
    $conexion = new Conexion();
    $consulta = $conexion->prepare('SELECT nom_producto, precio_venta FROM inventario WHERE Codigo = :codigo');
    $consulta->execute([':codigo' => $codigo]);
    $producto = $consulta->fetch(PDO::FETCH_ASSOC);
    echo json_encode($producto ? [[
        'nomproducto' => $producto['nom_producto'],
        'preproducto' => $producto['precio_venta']
    ]] : [], JSON_UNESCAPED_UNICODE);
} catch (Throwable $error) {
    http_response_code(500);
    echo json_encode(['error' => true, 'mensaje' => 'No fue posible consultar el producto.']);
}
