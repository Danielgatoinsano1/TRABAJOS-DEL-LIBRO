<?php

require_once 'manipularproductos.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: Productospaginados.php');
    exit;
}

$codigo = filter_var($_POST['codigo'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
if ($codigo === false) {
    header('Location: cproductos.php?estado=error');
    exit;
}

try {
    (new modificarProducto($codigo))->eliminar();
    header('Location: cproductos.php');
} catch (Throwable $error) {
    error_log('Error al eliminar producto: ' . $error->getMessage());
    header('Location: cproductos.php?estado=error');
}
exit;
