<?php
require_once 'conexionf2.php';
//Recuperar los datos de la sesion
session_start();
$cod_pro = $_SESSION['facturan'];
$pre = $cod_pro;
$conexion = new Conexion();
$consulta = $conexion->prepare('SELECT movimientofactura.facturano, movimientofactura.cantfact,
inventario.nom_producto, movimientofactura.precifact, movimientofactura.totalfact, clientes.
nomcli,clientes.direccli, clientes.telres_cli, controlfactura.subtotalfact, controlfactura.
impuestofact, controlfactura.grantotalfact FROM ((clientes INNER JOIN controlfactura ON
clientes.idcli = controlfactura.codclientefact) INNER JOIN movimientofactura ON  controlfactura.
nofactura = movimientofactura.facturano) INNER JOIN inventario ON movimientofactura.productoid =
inventario.codigo where movimientofactura.facturano = :codfact' );


$consulta->bindParam(':codfact', $pre); //Cargar el numero de factura por parametro
$consulta->execute();//Ejecutar la consulta
//Cargar el resultado en la variable $registros
$registros = $consulta->fetchAll(PDO::FETCH_ASSOC);