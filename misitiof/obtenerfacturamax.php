<?php
require_once 'classcontrolfactura.php';
$registros = datos_movfactura::obtenerultimafactura();
$json = array();
foreach ($registros as $facturacion) {
    $json[] = array(
        'ultimafactura' => $facturacion['factura'],
    );
}
$jsonstring = json_encode($json);
echo $jsonstring;