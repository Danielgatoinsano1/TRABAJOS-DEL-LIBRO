<?php
require_once 'conexionf2.php';

$conexion = new Conexion();
$consulta = $conexion->query(
    'SELECT h.nofactura, h.subtotalfact, h.impuestofact, h.grantotalfact,
            c.nomcli, COUNT(m.facturano) AS productos
     FROM controlfactura AS h
     INNER JOIN clientes AS c ON c.idcli = h.codclientefact
     LEFT JOIN movimientofactura AS m ON m.facturano = h.nofactura
     GROUP BY h.nofactura, h.subtotalfact, h.impuestofact, h.grantotalfact, c.nomcli
     ORDER BY h.nofactura DESC
     LIMIT 100'
);
$facturas = $consulta->fetchAll(PDO::FETCH_ASSOC);
$e = static fn($valor): string => htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
?>
<?php require 'menu.php'; ?>
<main class="w3-container w3-content" style="max-width: 1100px">
    <div class="w3-container fcolor-d2"><h2>Facturas guardadas</h2></div>
    <p><a class="w3-button w3-teal" href="frmFactura.php">Crear factura</a></p>
    <div class="w3-responsive">
        <table class="w3-table-all w3-hoverable">
            <thead>
                <tr><th>Numero</th><th>Cliente</th><th>Productos</th><th>Subtotal</th><th>IVA</th><th>Total</th><th></th></tr>
            </thead>
            <tbody>
            <?php if (!$facturas) { ?>
                <tr><td colspan="7">Todavia no hay facturas guardadas.</td></tr>
            <?php } else { foreach ($facturas as $factura) { ?>
                <tr>
                    <td><?php echo $e($factura['nofactura']); ?></td>
                    <td><?php echo $e($factura['nomcli']); ?></td>
                    <td><?php echo $e($factura['productos']); ?></td>
                    <td><?php echo number_format((float) $factura['subtotalfact'], 2); ?></td>
                    <td><?php echo number_format((float) $factura['impuestofact'], 2); ?></td>
                    <td><?php echo number_format((float) $factura['grantotalfact'], 2); ?></td>
                    <td><a class="w3-button w3-blue" href="mostrarfactura.php?factura=<?php echo rawurlencode((string) $factura['nofactura']); ?>">Ver factura y productos</a></td>
                </tr>
            <?php } } ?>
            </tbody>
        </table>
    </div>
</main>
<?php require 'pie_pagina.php'; ?>
