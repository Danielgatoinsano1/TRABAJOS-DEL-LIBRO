<?php
require_once 'classcontrolfactura.php';
$registros = datos_movfactura::obtenerultimafactura();
$ultimo = $registros[0]['factura'] ?? null;
$json = array();
$json[] = array('ultimafactura' => $ultimo);
header('Content-Type: application/json; charset=UTF-8');
echo json_encode($json);
