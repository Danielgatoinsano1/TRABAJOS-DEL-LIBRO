<?php

require_once 'classMovimiento.php';
require_once 'classProducto.php';

//Declarar variables
$cod_pro = "";
$vfecha = "";
$vcantidad_movi = "";

//Función para escapar los datos
function filtrofares($dat_fares)
{
    $datos = trim($dat_fares); // Elimina espacios antes y después de los datos
    $datos = stripslashes($dat_fares); // Elimina backslashes "\"
    $datos = htmlspecialchars($dat_fares); // Traduce caracteres especiales en entidades HTML

    return $datos;
}

//Comprobar si los datos se pasaron a través del método POST
if (
    isset($_POST["cguardar"]) &&
    $_SERVER["REQUEST_METHOD"] == "POST"
) {
    //Si codpro no está vacío entonces
    if (!empty($_POST["codpro"])) {

        /*Almacenar en la variable $cod_pro el valor del código
        que ingresó del producto*/
        $cod_pro = filtrofares($_POST["codpro"]);
    }

    //Si fechmovi no está vacío entonces
    if (!empty($_POST["fechmovi"])) {

        /*Almacenar en la variable $vfecha la fecha ingresada*/
        $vfecha = filtrofares($_POST["fechmovi"]);
    }

    //Si cantpro no está vacío entonces
    if (!empty($_POST["cantpro"])) {

        /*Almacenar en la variable $vcantidad_movi el valor de la cantidad
        que ingresó el usuario ya filtrado*/
        $vcantidad_movi = filtrofares($_POST["cantpro"]);
    }

    //Extraer el stock actual
    $stockAct = 0;

    $productoSelect =
        datosProductos::consultarProductoCod($cod_pro);

    foreach ($productoSelect as $producto1) {
        $stockAct = (int) $producto1->stock;
    }

    $datosmov = new datos_Movimiento(
        null,
        $cod_pro,
        $vfecha,
        $vcantidad_movi
    );

    $datosmov->guardarmov($stockAct);
}

header('Location: frmMovimiento.php'); //Llamar a la página frmMovimiento.php
die();