<?php
require_once 'conexionf2.php';
$conexion = new Conexion();
$consulta = $conexion->query('SELECT cf.nofactura, cf.subtotalfact, cf.impuestofact, cf.grantotalfact, c.nomcli,
    COUNT(mf.idmovfactura) AS productos
    FROM controlfactura AS cf
    INNER JOIN clientes AS c ON c.idcli = cf.codclientefact
    LEFT JOIN movimientofactura AS mf ON mf.facturano = cf.nofactura
    GROUP BY cf.nofactura, cf.subtotalfact, cf.impuestofact, cf.grantotalfact, c.nomcli
    ORDER BY cf.nofactura DESC LIMIT 100');
$facturas = $consulta->fetchAll(PDO::FETCH_ASSOC);
$e = static fn($valor) => htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./EstilosCssF/w3.css">
    <link rel="stylesheet" href="./EstilosCssF/dcoloresf.css">
    <title>Facturas guardadas</title>
</head>
<body class="w3-content" style="max-width:1100px">
    <header class="w3-container fcolor-d5"><h1>Facturas guardadas</h1></header>
    <p class="w3-container"><a class="w3-button w3-teal" href="frmFactura.php">Crear factura</a></p>
    <div class="w3-responsive w3-container">
        <table class="w3-table-all w3-hoverable">
            <thead><tr><th>Número</th><th>Cliente</th><th>Productos</th><th>Subtotal</th><th>IVA</th><th>Total</th><th></th></tr></thead>
            <tbody>
            <?php if (!$facturas): ?>
                <tr><td colspan="7">Todavía no hay facturas guardadas.</td></tr>
            <?php else: foreach ($facturas as $factura): ?>
                <tr>
                    <td><?= $e($factura['nofactura']) ?></td>
                    <td><?= $e($factura['nomcli']) ?></td>
                    <td><?= $e($factura['productos']) ?></td>
                    <td><?= $e($factura['subtotalfact']) ?></td>
                    <td><?= $e($factura['impuestofact']) ?></td>
                    <td><?= $e($factura['grantotalfact']) ?></td>
                    <td><a class="w3-button w3-blue" href="mostrarfactura.php?factura=<?= rawurlencode((string) $factura['nofactura']) ?>">Ver factura y productos</a></td>
                </tr>
            <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
