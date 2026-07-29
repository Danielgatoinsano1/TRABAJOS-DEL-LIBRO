<?php
$mensaje = isset($_GET['mensaje']) ? htmlspecialchars((string) $_GET['mensaje'], ENT_QUOTES, 'UTF-8') : '';
$tipo = ($_GET['tipo'] ?? '') === 'exito' ? 'exito' : 'error';
include __DIR__ . '/menu.php';
?>

<section class="w3-container">
    <div class="vet-formulario w3-card">
        <h1 class="vet-titulo">Registrar mascota</h1>
        <p class="vet-subtitulo">Completa todos los datos para agregar una mascota al santuario.</p>

        <?php if ($mensaje !== ''): ?>
            <div class="<?= $tipo === 'exito' ? 'vet-mensaje-exito' : 'vet-mensaje-error' ?>" role="alert">
                <?= $mensaje ?>
            </div>
        <?php endif; ?>

        <form method="post" action="guardar_mascota.php">
            <div class="vet-grid">
                <div class="vet-campo">
                    <label for="nombre">Nombre</label>
                    <input class="w3-input w3-border" id="nombre" name="nombre" type="text" required>
                </div>
                <div class="vet-campo">
                    <label for="especie">Especie</label>
                    <input class="w3-input w3-border" id="especie" name="especie" type="text" required>
                </div>
                <div class="vet-campo">
                    <label for="raza">Raza</label>
                    <input class="w3-input w3-border" id="raza" name="raza" type="text" required>
                </div>
                <div class="vet-campo">
                    <label for="edad">Edad (años)</label>
                    <input class="w3-input w3-border" id="edad" name="edad" type="number" min="0" required>
                </div>
                <div class="vet-campo">
                    <label for="peso_actual">Peso actual (kg)</label>
                    <input class="w3-input w3-border" id="peso_actual" name="peso_actual" type="number" min="0.01" step="0.01" required>
                </div>
                <div class="vet-campo">
                    <label for="color_senas">Color y señas particulares</label>
                    <input class="w3-input w3-border" id="color_senas" name="color_senas" type="text" required>
                </div>
                <div class="vet-campo">
                    <label for="responsable">Responsable</label>
                    <input class="w3-input w3-border" id="responsable" name="responsable" type="text" required>
                </div>
                <div class="vet-campo">
                    <label for="telefono_emergencia">Teléfono de emergencia</label>
                    <input class="w3-input w3-border" id="telefono_emergencia" name="telefono_emergencia" type="tel" required>
                </div>
            </div>
            <button class="vet-boton" type="submit" name="guardar_mascota">Guardar mascota</button>
        </form>
    </div>
</section>

<?php include __DIR__ . '/pie_pagina.php'; ?>
