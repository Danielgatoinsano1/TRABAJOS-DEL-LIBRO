<?php

require_once 'manipularcli.php';

// Declaración de variables
$id = filter_input(INPUT_GET, 'idcli', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
$codid = null;
$nombreCli = '';
$direccioncli = '';
$telefonosres = '';
$telefonocel = '';
$correocli = '';

if ($id === false || $id === null) {
    header('Location: frmcliente.php?estado=no_encontrado');
    exit;
}

// Instanciar la clase clientes y pasar por parámetros el id del cliente
$clientes = new modificarcliente(
    $id,
    null,
    null,
    null,
    null,
    null
);

// Ejecutar el método ConsultarClientesId() y asignar el resultado
// a la variable $listaclientes
$listaclientes = $clientes->ConsultarClientesId();

foreach ($listaclientes as $clienteselec) {
    // Recorrer los datos de $listaclientes
    // Asignar los datos a las variables
    $codid = $clienteselec->idcli;
    $nombreCli = $clienteselec->nomcli;
    $direccioncli = $clienteselec->direccli;
    $telefonosres = $clienteselec->telres_cli;
    $telefonocel = $clienteselec->telcel_cli;
    $correocli = $clienteselec->email_cli;
}

if ($codid === null) {
    header('Location: frmcliente.php?estado=no_encontrado');
    exit;
}
?>
