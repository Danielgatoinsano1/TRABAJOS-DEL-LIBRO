<?php

require_once 'manipularcli.php';

//Declaración de variables
$id = "";
$codid;
$nombreCli;
$direccioncli;
$telefonosres;
$telefonocel;
$correocli;

if (isset($_GET['idcli'])) {
    $id = $_GET['idcli'];
}

//Instanciar la clase clientes y pasar por parámetros el id del cliente
$Clientes = new modificarcliente($id, null, null, null, null, null);

//Ejecutar el método ConsultarClientesId()
$listaclientes = $Clientes->ConsultarClientesId();

foreach ($listaclientes as $clienteselec) {

    $codid = $clienteselec->idcli;
    $nombreCli = $clienteselec->nomcli;
    $direccioncli = $clienteselec->direccli;
    $telefonosres = $clienteselec->telres_cli;
    $telefonocel = $clienteselec->telcel_cli;
    $correocli = $clienteselec->email_cli;
}
