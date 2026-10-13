<?php
require_once 'manipularcli.php';
$id = "";
if (isset($_GET['idcli'])) {
    $id = $_GET['idcli'];
}
$Clientes = new modificarcliente($id, null, null, null, null, null);
$Clientes->eliminar();
header('Location: frmcliente.php');

die();
?>