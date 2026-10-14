<?php

require_once 'classMovimiento.php';
require_once 'classProducto.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['cguardar'])) {
    header('Location: frmMovimiento.php');
    exit;
}

$codigoValidado = filter_var($_POST['codpro'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
$cantidadValidada = filter_var($_POST['cantpro'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
$fechaEntrada = $_POST['fechmovi'] ?? '';
$fechaValidada = is_string($fechaEntrada) ? DateTime::createFromFormat('!Y-m-d', $fechaEntrada) : false;
if ($codigoValidado === false || $cantidadValidada === false || !$fechaValidada || $fechaValidada->format('Y-m-d') !== $fechaEntrada) {
    header('Location: frmMovimiento.php?estado=error');
    exit;
}

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

    $datosmov = new datos_Movimiento(
        null,
        $cod_pro,
        $vfecha,
        $vcantidad_movi
    );

    try {
        // Confirmar que el producto existe antes de guardar el movimiento.
        $productoSelect = datosProductos::consultarProductoCod($cod_pro);
        if (!$productoSelect) {
            throw new DomainException('El producto seleccionado no existe.');
        }
        $stockAct = (int) $productoSelect[0]->stock;
        $datosmov->guardarmov($stockAct);
    } catch (Throwable $error) {
        error_log('Error al registrar movimiento de inventario: ' . $error->getMessage());
        header('Location: frmMovimiento.php?estado=error');
        exit;
    }
}

header('Location: frmMovimiento.php?estado=guardado'); //Volver al formulario de inventario
die();
