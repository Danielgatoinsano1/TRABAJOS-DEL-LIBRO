<?php
require_once 'classMovimiento.php';
require_once 'classProducto.php';
//Declarar variables
$cod_pro = "";
$vfecha = "";
$vcantidad_movi = "";
function filtrofares($dat_fares) { //Funcion para escapar los datos
    $datos = trim($dat_fares); //Elimina espacios antes y despues de los datos
    $datos = stripslashes($dat_fares); //Elimina backslashes "\"
    $datos = htmlspecialchars($dat_fares); //Traduce caracteres especiales en entidades HTML
    return $datos;
}
//Comprobar si los datos se pasaron a traves del metodo POST
if (isset($_POST["cguardar"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["codpro"])) { //Si codpro no esta vacio entonces
        /*Almacenar en la variable $cod_pro el valor del codigo que ingreso del producto*/
        $cod_pro = filtrofares($_POST["codpro"]);
    }
    if (!empty($_POST["fechmovi"])) { //Si fechmovi no esta vacio entonces
        /*Almacenar en la variable  $vfecha la fecha ingresada*/
        $vfecha = filtrofares($_POST["fechmovi"]);
    }
    if (!empty($_POST["cantpro"])) { //Si cantpro no esta vacio entonces
        /*Almacenar en la variable $vcantidad_movi el valor de la cantidad que ingreso el usuario ya filtrado*/
        $vcantidad_movi = filtrofares($_POST["cantpro"]);
    }
    //Extraer el stock actual
    $stockAct = 0;
    $productoSelect = datosProductos::consultarProductoCod($cod_pro);
    foreach ($productoSelect as $producto1) {
        $stockAct = (int) $producto1->stock;
    }
    $datosmov = new datos_Movimiento(null, $cod_pro, $vfecha, $vcantidad_movi);
    $datosmov->guardarmov($stockAct);
}
header('Location: frmMovimiento.php'); //Llamar a la pagina frmMovimiento.php
die();