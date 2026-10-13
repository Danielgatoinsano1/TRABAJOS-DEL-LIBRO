<?php
require_once 'conexionf2.php';
// Acepta la factura recién guardada o una seleccionada desde el historial.
$cod_pro = filter_input(INPUT_GET, 'factura', FILTER_VALIDATE_INT);
if (!$cod_pro) {
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    $cod_pro = $_SESSION['facturan'] ?? null;
}
if (!$cod_pro) {
    header('Location: facturasguardadas.php');
    exit;
}
$pre = $cod_pro;
$conexion = new Conexion();
$consulta = $conexion->prepare('SELECT mf.facturano, mf.cantfact, i.nom_producto, mf.precifact, mf.totalfact,
c.nomcli, c.direccli, c.telres_cli, cf.subtotalfact, cf.impuestofact, cf.grantotalfact
FROM movimientofactura AS mf
INNER JOIN controlfactura AS cf ON cf.nofactura = mf.facturano
INNER JOIN clientes AS c ON c.idcli = cf.codclientefact
INNER JOIN inventario AS i ON i.Codigo = mf.productoid
WHERE mf.facturano = :codfact ORDER BY mf.idmovfactura');


$consulta->bindParam(':codfact', $pre); //Cargar el numero de factura por parametro
$consulta->execute();//Ejecutar la consulta
//Cargar el resultado en la variable $registros
$registros = $consulta->fetchAll(PDO::FETCH_ASSOC);
