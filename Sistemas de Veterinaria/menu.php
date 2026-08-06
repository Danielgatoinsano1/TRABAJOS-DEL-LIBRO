<?php $paginaMenu = basename($_SERVER['PHP_SELF'] ?? ''); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Santuario de Mascotas</title>
    <link rel="stylesheet" href="W3.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
</head>
<body>
    <aside class="vet-sidebar w3-sidebar w3-bar-block w3-teal w3-card">
        <a class="vet-marca w3-bar-item w3-dark-grey" href="index.php">Santuario de Mascotas</a>
        <div class="vet-icono-mascotas w3-bar-item w3-dark-grey">
            <span aria-hidden="true">🐾 🐶 🐱</span>
        </div>
            <nav class="vet-navbar" aria-label="Navegación principal">
                <span
                    class="vet-enlace-inactivo w3-bar-item w3-button<?= $paginaMenu === 'index.php' ? ' w3-white w3-text-teal' : '' ?>"
                    aria-disabled="true"
                    <?= $paginaMenu === 'index.php' ? 'aria-current="page"' : '' ?>
                >Inicio</span>
                <a class="w3-bar-item w3-button w3-hover-white" href="frmmascota.php">Registrar mascota</a>
                <a class="w3-bar-item w3-button w3-hover-white" href="Mascotaspaginadas.php">Mascotas paginadas</a>
        </nav>
    </aside>
    <main class="vet-contenido w3-white">
