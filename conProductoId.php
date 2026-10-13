<?php
require_once 'classProducto.php';
//Almacenar n $cod_pr el valor de la variable dato recibida por el metodo GET
$cod_pro = intval($_GET['dato']);
$vnom_pro = "";
//Almacenar en $productoSelect el registro que corresponda con el valor de la variable $cod_pro
$productoSelect = datosProductos::consultarProductoCod($cod_pro);

foreach ($productoSelect as $producto1) {
    //Almacenar en la variable $vnom_pro el nombre del producto
    $vnom_pro = $producto1->nom_producto;
}
//Devolver el valor a la funcion de llamada
$response = $vnom_pro;
echo $response;