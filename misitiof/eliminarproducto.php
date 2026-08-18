<?php

require_once 'manipularproductos.php';

$codigo = filter_input(INPUT_GET, 'codigo', FILTER_VALIDATE_INT);
if ($codigo) {
    try {
        (new modificarProducto($codigo))->eliminar();
        header('Location: cproductos.php?estado=eliminado');
        exit;
    } catch (PDOException $e) {
        error_log('Error al eliminar producto: ' . $e->getMessage());
    }
}

header('Location: cproductos.php?estado=error');
exit;
