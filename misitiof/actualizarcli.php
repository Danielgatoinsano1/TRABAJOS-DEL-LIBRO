<?php

require_once 'manipularcli.php'; // Llamar el archivo manipularcli

// Declarar variables
$vcodigo = "";
$vnombre = "";
$vdireccion = "";
$vtelresi = "";
$vtelcel = "";
$vemail = "";

// Función para escapar los datos
function filtrofares($dat_fares)
{
    $datos = trim($dat_fares); // Elimina espacios antes y después de los datos
    $datos = stripslashes($dat_fares); // Elimina backslashes "\"
    $datos = htmlspecialchars($dat_fares); // Traduce caracteres especiales en entidades HTML

    return $datos;
}

// Comprobar si los datos se pasaron a través del método POST
if (
    isset($_POST["cactualizar"]) &&
    $_SERVER["REQUEST_METHOD"] == "POST"
) {
    if (!empty($_POST["ccodigo"])) {
        // Si el código no está vacío, entonces almacenar en la variable
        // $vcodigo el valor del código que ingresó el usuario ya filtrado
        $vcodigo = filter_var($_POST["ccodigo"], FILTER_VALIDATE_INT) ?: "";
    }

    if (!empty($_POST["cnomcliente"])) {
        $vnombre = trim((string) $_POST["cnomcliente"]);
    }

    if (!empty($_POST["cdireccion"])) {
        $vdireccion = trim((string) $_POST["cdireccion"]);
    }

    if (!empty($_POST["ctelcasa"])) {
        $vtelresi = trim((string) $_POST["ctelcasa"]);
    }

    if (!empty($_POST["ccelular"])) {
        $vtelcel = trim((string) $_POST["ccelular"]);
    }

    if (!empty($_POST["cemail"])) {
        $vemail = trim((string) $_POST["cemail"]);
    }

    // Crear objeto y pasar los datos por parámetros
    $guardarcliente = new modificarcliente(
        $vcodigo,
        $vnombre,
        $vdireccion,
        $vtelresi,
        $vtelcel,
        $vemail
    );

    if ($vcodigo === "" || $vnombre === "" || $vtelresi === "" || ($vemail !== "" && !filter_var($vemail, FILTER_VALIDATE_EMAIL))) {
        header('Location: frmcliente.php?estado=error');
        exit;
    }

    try {
        $guardarcliente->actualizar();
        header('Location: frmcliente.php?estado=actualizado');
    } catch (Throwable $error) {
        error_log('Error al actualizar cliente: ' . $error->getMessage());
        header('Location: frmcliente.php?estado=error');
    }
    exit;
}

header('Location: frmcliente.php'); // Llamar a la página frmcliente.php
die();
