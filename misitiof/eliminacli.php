<?php
require_once 'manipularcli.php';
$id = ""; //Declaracion de variable
if (isset($_GET['id'])) { // Verificar si existe idcli y si tiene un valor
$id = $_GET['id']; //Asignar el id del cliente a la variable $id
}
//Instanciar la clase cliente y pasar por parametros el id del cliente
$Clientes = new modificarcliente($id, null, null, null, null, null);
$Clientes->eliminarcliente();
header('Location: frmcliente.php'); //Llamar a la pagina frmcliente.php
die();