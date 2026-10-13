<?php
require_once 'conexionf2.php';
//Almacenar en $cod_cli el valor de la variable buscarcliente recibida por el metodo POST
$cod_cli = filter_input(INPUT_POST, 'buscarcliente', FILTER_VALIDATE_INT);
header('Content-Type: application/json; charset=UTF-8');
if (!$cod_cli) { echo json_encode([]); exit; }
//Realizar la consulta
$conexion = new Conexion();
$consulta = $conexion->prepare('SELECT * FROM clientes where idcli = :codcli');
$consulta->bindParam(':codcli', $cod_cli);
$consulta->execute();
$registros = $consulta->fetchAll(PDO::FETCH_ASSOC);

$json = array();
if ($registros) {
    foreach ($registros as $cliente) {
        //Almacenar en la variable $vnom_pro l nombre del producto
        $json[] = array(
            'nombrecliente' => $cliente['nomcli'],
        );
    }
}
echo json_encode($json, JSON_UNESCAPED_UNICODE);
