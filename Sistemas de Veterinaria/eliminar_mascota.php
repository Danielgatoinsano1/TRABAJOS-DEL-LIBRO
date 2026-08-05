<?php
require_once __DIR__ . '/GuardarMascota.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['eliminar_mascota'])) {
    header('Location: listar_mascotas.php?tipo=error&mensaje=' . urlencode('Solicitud no válida.'));
    exit;
}
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
try {
    if (!$id || $id < 1) {
        throw new InvalidArgumentException('Identificador no válido.');
    }
    $repositorio = new GuardarMascota();
    if (!$repositorio->eliminar($id)) {
        throw new RuntimeException('La mascota no existe o ya fue eliminada.');
    }
    header('Location: listar_mascotas.php?tipo=exito&mensaje=' . urlencode('Mascota eliminada correctamente.'));
} catch (Throwable $e) {
    error_log($e->getMessage());
    header('Location: listar_mascotas.php?tipo=error&mensaje=' . urlencode($e->getMessage()));
}
exit;
