<?php
require_once 'classcontrolfactura.php';

header('Content-Type: application/json; charset=utf-8');

try {
    echo json_encode(
        array_map(
            static fn(array $fila): array => ['ultimafactura' => (int) ($fila['factura'] ?? 0)],
            datos_movfactura::obtenerultimafactura()
        )
    );
} catch (Throwable $error) {
    http_response_code(500);
    echo json_encode(['error' => true]);
}
