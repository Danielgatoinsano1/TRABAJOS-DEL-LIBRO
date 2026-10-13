<?php

require_once 'manipularproductos.php';

$codigoProducto = filter_input(INPUT_GET, 'codigo', FILTER_VALIDATE_INT);
$productoSeleccionado = $codigoProducto ? (new modificarProducto($codigoProducto))->consultarPorCodigo() : false;

if (!$productoSeleccionado) {
    header('Location: cproductos.php?estado=no_encontrado');
    exit;
}
