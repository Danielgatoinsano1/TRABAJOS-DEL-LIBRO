<?php
require_once 'cargarfactura.php';
$factura = $registros[0];
$salidaSegura = static fn($valor): string => htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Factura <?php echo $salidaSegura($factura['facturano']); ?></title>
    <link rel="stylesheet" href="EstilosCssF/w3.css">
    <link rel="stylesheet" href="EstilosCssF/dcoloresf.css">
    <script src="JScript/html2pdf.bundle.min.js"></script>
    <script src="JScript/script.js" defer></script>
    <style>
        body { background: #f5f5f5; }
        .factura-papel { max-width: 900px; margin: 20px auto; background: #fff; }
        @media print { .no-imprimir { display: none !important; } body { background: #fff; } }
    </style>
</head>
<body class="w3-container w3-padding">
    <button class="w3-button w3-teal no-imprimir" id="btnPdf" type="button">Clic para crear PDF</button>
    <span id="estadoPdf" class="w3-small" role="status" aria-live="polite"></span>
    <main id="documentoFactura" class="w3-container w3-padding factura-papel">
        <header class="w3-row w3-padding w3-border-bottom">
            <div class="w3-third"><strong class="w3-xlarge">Ediciones Fares</strong></div>
            <div class="w3-third"><strong>Ediciones Fares</strong><br>Tegucigalpa, Honduras C.A.</div>
            <div class="w3-third">www.edicionesfares.com<br>Email: edicionesfares@edicionesfares.com</div>
        </header>
        <section class="w3-row w3-padding w3-border">
            <div class="w3-twothird">
                <h1 class="w3-text-blue">Factura</h1>
                <p>Cliente: <?php echo $salidaSegura($factura['nomcli']); ?></p>
                <p>Dirección: <?php echo nl2br($salidaSegura($factura['direccli'])); ?></p>
                <p>Teléfono: <?php echo $salidaSegura($factura['telres_cli']); ?></p>
            </div>
            <div class="w3-third"><p class="w3-xlarge">Factura No:</p><strong class="w3-xxxlarge w3-text-red"><?php echo $salidaSegura($factura['facturano']); ?></strong></div>
        </section>
        <table class="w3-table w3-bordered w3-margin-top">
            <thead><tr><th>Cantidad</th><th>Descripción</th><th>Precio</th><th>Total</th></tr></thead>
            <tbody>
            <?php foreach ($registros as $detalle) { ?>
                <tr>
                    <td><?php echo $salidaSegura($detalle['cantfact']); ?></td>
                    <td><?php echo $salidaSegura($detalle['nom_producto']); ?></td>
                    <td><?php echo number_format((float) $detalle['precifact'], 2); ?></td>
                    <td><?php echo number_format((float) $detalle['totalfact'], 2); ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <section class="w3-row w3-padding w3-border-top">
            <div class="w3-third w3-right"><p>Total a pagar: <strong><?php echo number_format((float) $factura['grantotalfact'], 2); ?></strong></p>
                <p>IVA: <?php echo number_format((float) $factura['impuestofact'], 2); ?></p>
                <p>Subtotal: <?php echo number_format((float) $factura['subtotalfact'], 2); ?></p>
            </div>
        </section>
    </main>
</body>
</html>
