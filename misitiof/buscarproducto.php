<?php
require_once 'conexionf2.php';
//Almacenar en $cod_pr el valor de la variable dato recibida por el metodo GET
$cod_pro = filter_input(INPUT_POST, 'producto', FILTER_VALIDATE_INT);
header('Content-Type: application/json; charset=UTF-8');
if (!$cod_pro) { echo json_encode([]); exit; }
$vnom_pro = "";
//Almacenar en $productoSelect el registro que corresponda con el valor de la variable $cod_pro
$conexion = new Conexion();
$consulta = $conexion->prepare('SELECT nom_producto, precio_venta FROM inventario WHERE Codigo = :codpro');
$consulta->bindParam(':codpro', $cod_pro);
$consulta->execute();
$registros = $consulta->fetchAll(PDO::FETCH_ASSOC);

$json = array();
if ($registros) {
    foreach ($registros as $producto1) {
        //Almacenar en la variable $vnom_pro el nombre del producto
        $json[] = array(
            'nomproducto' => $producto1['nom_producto'],
            'preproducto' => $producto1['precio_venta']
        );
    }
}
echo json_encode($json, JSON_UNESCAPED_UNICODE);
