<?php

require_once 'manipularcli.php';

// Declaración de variables
$id = "";
$codid;
$nombreCli;
$direccioncli;
$telefonosres;
$telefonocel;
$correocli;

if (isset($_GET['idcli'])) { // Verificar si existe idcli y si tiene un valor
    $id = $_GET['idcli']; // Asignar el id del cliente a la variable $id
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
?>