<?php
require_once __DIR__ . '/GuardarMascota.php';

function e($valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$mascota = null;
if ($id && $id > 0) {
    try {
        $mascota = (new GuardarMascota())->buscarPorId($id);
    } catch (Throwable $error) {
        error_log($error->getMessage());
    }
}
if ($mascota === null) {
    header('Location: listar_mascotas.php?tipo=error&mensaje=' . urlencode('La mascota solicitada no existe.'));
    exit;
}
$mensaje = isset($_GET['mensaje']) ? (string) $_GET['mensaje'] : '';
include __DIR__ . '/menu.php';
?>
<section class="w3-container">
    <div class="vet-formulario w3-card">
        <h1 class="vet-titulo">Editar mascota</h1>
        <?php if ($mensaje !== ''): ?><div class="vet-mensaje-error" role="alert"><?= e($mensaje) ?></div><?php endif; ?>
        <form method="post" action="actualizar_mascota.php">
            <input type="hidden" name="id" value="<?= e($mascota['id']) ?>">
            <div class="vet-grid">
                <?php foreach (['nombre'=>'Nombre', 'especie'=>'Especie', 'raza'=>'Raza', 'color_senas'=>'Color y señas particulares', 'responsable'=>'Responsable', 'telefono_emergencia'=>'Teléfono de emergencia'] as $campo => $etiqueta): ?>
                    <div class="vet-campo">
                        <label for="<?= $campo ?>"><?= $etiqueta ?></label>
                        <input class="w3-input w3-border" id="<?= $campo ?>" name="<?= $campo ?>" type="<?= $campo === 'telefono_emergencia' ? 'tel' : 'text' ?>" value="<?= e($mascota[$campo]) ?>" required>
                    </div>
                <?php endforeach; ?>
                <div class="vet-campo">
                    <label for="edad">Edad (años)</label>
                    <input class="w3-input w3-border" id="edad" name="edad" type="number" min="0" value="<?= e($mascota['edad']) ?>" required>
                </div>
                <div class="vet-campo">
                    <label for="peso_actual">Peso actual (kg)</label>
                    <input class="w3-input w3-border" id="peso_actual" name="peso_actual" type="number" min="0.01" step="0.01" value="<?= e($mascota['peso_actual']) ?>" required>
                </div>
            </div>
            <button class="vet-boton" type="submit" name="actualizar_mascota">Actualizar mascota</button>
            <a class="w3-button w3-light-grey" href="listar_mascotas.php">Cancelar</a>
        </form>
    </div>
</section>
<?php include __DIR__ . '/pie_pagina.php'; ?>
