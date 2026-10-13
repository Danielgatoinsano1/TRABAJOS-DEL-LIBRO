<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./EstilosCssF/dcoloresf.css">
    <link rel="stylesheet" type="text/css" href="./EstilosCssF/w3.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <script src="./JScript/acciones_script.js"></script>
    <script src="./JScript/jquery-3.6.0.min.js"></script>
    <!-- Cargar la libreria-->
    <script src="./JScript/html2pdf.bundle.min.js"></script>
    <!-- Script que generara el PDF -->
    <script src="./JScript/script.js"></script>
    <title>Factura</title>
</head>
<body class="w3-container w3-padding" style="width: 900px; margin: auto;">
<button class="w3-button w3-teal" id="btnPdf">Clic para crear PDF</button>
    <?php require_once 'cargarfactura.php';
    $idfact = "";
    $clien = "";
    $direc = "";
    $tel = "";
    $sub = "";
    $imp = "";
    $gtot = "";
    foreach ($registros as $dfactura) {
        $idfact = $dfactura['facturano'];
        $clien = $dfactura['nomcli'];
        $direc = $dfactura['direccli'];
        $tel = $dfactura['telres_cli'];
        $sub = $dfactura['subtotalfact'];
        $imp = $dfactura['impuestofact'];
        $gtot = $dfactura['grantotalfact'];
    }
    ?>
    <div class="w3-container w3-row">
        <div class="w3-container w3-cell" style="width: 200px;">
            <img src="./imgfares/logofares.png" alt="">
        </div>
        <div class="w3-container w3-cell">
            <p>
                <strong>Ediciones Fares</strong><br>
                <strong>Tegucigalpa, Honduras C.A.</strong>
            </p>
        </div>
        <div class="w3-container w3-cell">
            <p>
                www.edicionesfares.com<br>
                Email: edicionesfares@edicionesfares.com<br>
            </p>
        </div>
    </div>
    <div class="w3-cell-row w3-border">
        <div class="w3-container w3-cell" style="width: 600px;">
            <h2 class="w3-xxlarge w3-text-blue w3-padding-small"><strong>
            Factura</strong> </h2>
            <p>Cliente: <?php echo htmlspecialchars((string) $clien, ENT_QUOTES, 'UTF-8'); ?> </p>
            <p>Dirección: <?php echo ($direc); ?> </p>
            <p>Teléfono: <?php echo htmlspecialchars((string) $tel, ENT_QUOTES, 'UTF-8'); ?> </p>
        </div>
        <div class="w3-container w3-cell">
            <p class="w3-xlarge">Factura No:</p>
            <p class="w3-xxlarge w3-text-red"><strong><?php echo ($idfact); ?>
            </strong> </p>
        </div>
    </div>
    <div>
        <table class="tabla w3-table w3-bordered" style="width: 100%;">
            <tr>
                <th style="width: 15%;">Cantidad</th>
                <th style="width: 50%;">Descripción</th>
                <th style="width: 15%;">Precio</th>
                <th style="width: 20%;">Total</th>
            </tr>
            <tbody>
                <?php
                //Recorrer la matriz
                foreach ($registros as $dfactura) { ?>
                    <tr>
                        <!-- Mostrar el id del alumno que está dentro de $cliente -->
                        <td> <?php echo $dfactura['cantfact']; ?></td>
                        <!-- Mostrar el nombre del alumno que está dentro de $cliente -->
                        <td> <?php echo $dfactura['nom_producto']; ?></td>
                        <td> <?php echo $dfactura['precifact']; ?></td>
                        <td> <?php echo $dfactura['totalfact']; ?></td>
                    </tr>
                <?php
                } //Cerrar el foreach
                ?>
            </tbody> <!-- Cerrar el cuerpo de la tabla -->
        </table>
        <div class="w3-row w3-panel w3-border-top ">
            <div class="w3-mobile w3-container w3-right w3-border-left"
            style="width:400px;">
                <div class="w3-container w3-mobile w3-right">
                    <p>Subtotal: </p>
                    <p id="sutotalfact" class="w3-border w3-sand "> <?php echo ($sub); ?> </p>
                </div>
                <div class="w3-container w3-mobile w3-right">
                    <p>IVA:</p>
                    <p class="w3-border w3-sand "><?php echo ($imp); ?></p>
                </div>
                <div class="w3-container w3-mobile w3-right">
                    <p>Total a pagar:</p>
                    <p class="w3-border w3-sand"><?php echo ($gtot); ?></p>
                </div>
            </div>
        </div>

    </div>
</body>
</html>
