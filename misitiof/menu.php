<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ediciones Fares</title>
    <link rel="stylesheet" href="EstilosCssF/w3.css">
    <link rel="stylesheet" href="EstilosCssF/dcoloresf.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <script src="JScript/jquery-3.6.0.min.js"></script>
    <script src="JScript/acciones_script.js"></script>
</head>
<body>
<div class="w3-container">
    <header class="w3-container fcolor-d5">
        <h1>Ediciones Fares</h1>
    </header>
    <nav class="w3-bar fcolor-l4" aria-label="Navegacion principal">
        <a href="index.php" class="w3-bar-item w3-button w3-mobile">Principal</a>
        <a href="index.php" class="w3-bar-item w3-button w3-mobile">Libros</a>
        <div class="w3-dropdown-hover w3-mobile">
            <button class="w3-button" type="button" aria-controls="menuInventario"
                onclick="document.getElementById('menuInventario').classList.toggle('w3-show')">Inventario</button>
            <div id="menuInventario" class="w3-dropdown-content w3-bar-block ftema">
                <a href="cproductos.php" class="w3-bar-item w3-button">Crear producto</a>
                <a href="Productospaginados.php" class="w3-bar-item w3-button">Consultar y modificar productos</a>
                <a href="frmcliente.php" class="w3-bar-item w3-button">Clientes</a>
                <a href="frmMovimiento.php" class="w3-bar-item w3-button">Agregar inventario</a>
                <a href="frmFactura.php" class="w3-bar-item w3-button">Facturar</a>
                <a href="facturasguardadas.php" class="w3-bar-item w3-button">Facturas guardadas</a>
                <a href="index.php" class="w3-bar-item w3-button">Informacion de libros</a>
            </div>
        </div>
        <a href="mailto:edicionesfares@edicionesfares.com" class="w3-bar-item w3-button w3-mobile">Contacto</a>
    </nav>
</div>
