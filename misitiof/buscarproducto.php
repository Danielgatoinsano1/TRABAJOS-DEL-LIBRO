<?php
require_once 'conexionf2.php';
//Almacenar en $cod_pr el valor de la variable dato recibida por el metodo GET
$cod_pro = $_POST['producto'];
$vnom_pro = "";
//Almacenar en $productoSelect el registro que corresponda con el valor de la variable $cod_pro
$conexion = new Conexion();
$consulta = $conexion->prepare('SELECT * FROM inventario where codigo = :codpro');
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
    $jsonstring = json_encode($json);
    echo $jsonstring;
}