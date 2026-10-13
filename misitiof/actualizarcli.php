<?php

require_once 'manipularcli.php';

//Declarar variables
$vcodigo = "";
$vnombre = "";
$vdireccion = "";
$vtelresi = "";
$vtelcel = "";
$vemail = "";

//Función para escapar los datos
function filtrofares($dat_fares)
{
    $datos = trim($dat_fares);
    $datos = stripslashes($datos);
    $datos = htmlspecialchars($datos);
    return $datos;
}

//Comprobar si los datos se pasaron a través del método POST
if (isset($_POST["cactualizar"]) && $_SERVER["REQUEST_METHOD"] == "POST") {

    if (!empty($_POST["ccodigo"])) {
        $vcodigo = filtrofares($_POST["ccodigo"]);
    }

    if (!empty($_POST["cnomcliente"])) {
        $vnombre = filtrofares($_POST["cnomcliente"]);
    }

    if (!empty($_POST["cdireccion"])) {
        $vdireccion = filtrofares($_POST["cdireccion"]);
    }

    if (!empty($_POST["ctelcasa"])) {
        $vtelresi = filtrofares($_POST["ctelcasa"]);
    }

    if (!empty($_POST["ccelular"])) {
        $vtelcel = filtrofares($_POST["ccelular"]);
    }

    if (!empty($_POST["cemail"])) {
        $vemail = filtrofares($_POST["cemail"]);
    }

    //Crear objeto y pasar los datos por parámetros
    $guardarcliente = new modificarcliente(
        $vcodigo,
        $vnombre,
        $vdireccion,
        $vtelresi,
        $vtelcel,
        $vemail
    );

    $guardarcliente->actualizar();
}

header('Location: frmcliente.php');

die();