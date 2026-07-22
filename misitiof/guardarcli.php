<?php

require_once 'manipularcli.php'; // Llamar al archivo manipularcli

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
    $datos = trim($dat_fares); // Elimina espacios antes y después de los datos
    $datos = stripslashes($dat_fares); // Elimina backslashes "\"
    $datos = htmlspecialchars($dat_fares); // Traduce caracteres especiales en entidades HTML
    return $datos;
}


//Comprobar si los datos se pasaron a través del método POST

if (isset($_POST["guardar"]) && $_SERVER["REQUEST_METHOD"] == "POST") {

    //Si el código no está vacío entonces

    if (!empty($_POST["ccodigo"])) {

        /*Almacena en la variable $vcodigo el valor del código
        que ingresó el usuario ya filtrado*/

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

}