<?php
require_once 'conexionf2.php';

header('Content-Type: application/json; charset=utf-8');

try {
    $cod_pro = filter_input(INPUT_POST, 'producto', FILTER_VALIDATE_INT);
    if (!$cod_pro) {
        echo json_encode([]);
        exit;
    }

    $conexion = new Conexion();
    $consulta = $conexion->prepare(
        'SELECT nom_producto, precio_venta FROM inventario WHERE codigo = :codpro'
    );
    $consulta->bindParam(':codpro', $cod_pro, PDO::PARAM_INT);
    $consulta->execute();
    $registros = $consulta->fetchAll(PDO::FETCH_ASSOC);

    $json = [];
    foreach ($registros as $producto) {
        $json[] = [
            'nomproducto' => $producto['nom_producto'],
            'preproducto' => $producto['precio_venta'],
        ];
    }

    echo json_encode($json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
} catch (Throwable $error) {
    http_response_code(500);
    echo json_encode(['error' => true]);
}
