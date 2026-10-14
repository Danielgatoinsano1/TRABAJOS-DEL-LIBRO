<?php
require_once 'conexionf2.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$numeroEntrada = $_GET['factura'] ?? ($_SESSION['facturan'] ?? null);
$numero = filter_var($numeroEntrada, FILTER_VALIDATE_INT);
if (!$numero) {
    http_response_code(404);
    exit('No hay una factura seleccionada.');
}
$_SESSION['facturan'] = $numero;

$conexion = new Conexion();
$consulta = $conexion->prepare(
    'SELECT m.facturano, m.cantfact, i.nom_producto, m.precifact, m.totalfact,
            c.nomcli, c.direccli, c.telres_cli, h.subtotalfact, h.impuestofact, h.grantotalfact
     FROM movimientofactura AS m
     INNER JOIN controlfactura AS h ON h.nofactura = m.facturano
     INNER JOIN inventario AS i ON i.Codigo = m.productoid
     INNER JOIN clientes AS c ON c.idcli = h.codclientefact
     WHERE m.facturano = :numero
     ORDER BY m.idmovimientofact'
);
$consulta->execute([':numero' => $numero]);
$registros = $consulta->fetchAll(PDO::FETCH_ASSOC);

if (!$registros) {
    http_response_code(404);
    exit('No se encontraron los datos de la factura.');
}
