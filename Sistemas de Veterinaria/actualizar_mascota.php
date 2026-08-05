<?php
require_once __DIR__ . '/Mascota.php';
require_once __DIR__ . '/GuardarMascota.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['actualizar_mascota'])) {
    header('Location: listar_mascotas.php?tipo=error&mensaje=' . urlencode('Solicitud no válida.'));
    exit;
}
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$campos = ['nombre', 'especie', 'raza', 'edad', 'peso_actual', 'color_senas', 'responsable', 'telefono_emergencia'];
$datos = [];
foreach ($campos as $campo) {
    $datos[$campo] = trim((string) ($_POST[$campo] ?? ''));
}
if (!$id || in_array('', $datos, true)) {
    header('Location: listar_mascotas.php?tipo=error&mensaje=' . urlencode('Datos incompletos.'));
    exit;
}
try {
    $mascota = new Mascota($datos['nombre'], $datos['especie'], $datos['raza'], $datos['edad'], $datos['peso_actual'], $datos['color_senas'], $datos['responsable'], $datos['telefono_emergencia']);
    $repositorio = new GuardarMascota();
    if ($repositorio->buscarPorId($id) === null) {
        throw new RuntimeException('La mascota no existe.');
    }
    $repositorio->actualizar($id, $mascota);
    header('Location: listar_mascotas.php?tipo=exito&mensaje=' . urlencode('Mascota actualizada correctamente.'));
} catch (InvalidArgumentException $e) {
    header('Location: editar_mascota.php?id=' . $id . '&mensaje=' . urlencode($e->getMessage()));
} catch (Throwable $e) {
    error_log($e->getMessage());
    header('Location: editar_mascota.php?id=' . $id . '&mensaje=' . urlencode('No fue posible actualizar la mascota.'));
}
exit;
