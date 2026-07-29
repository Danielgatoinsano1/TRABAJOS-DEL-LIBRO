<?php

require_once __DIR__ . '/Mascota.php';
require_once __DIR__ . '/GuardarMascota.php';

function limpiarDato($dato): string
{
    return htmlspecialchars(stripslashes(trim((string) $dato)), ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['guardar_mascota'])) {
    header('Location: frmmascota.php?tipo=error&mensaje=' . urlencode('Solicitud no válida.'));
    exit;
}

$campos = [
    'nombre',
    'especie',
    'raza',
    'edad',
    'peso_actual',
    'color_senas',
    'responsable',
    'telefono_emergencia',
];

$datos = [];
foreach ($campos as $campo) {
    $datos[$campo] = limpiarDato($_POST[$campo] ?? '');
}

if (in_array('', $datos, true)) {
    header('Location: frmmascota.php?tipo=error&mensaje=' . urlencode('Todos los campos son obligatorios.'));
    exit;
}

try {
    $mascota = new Mascota(
        $datos['nombre'],
        $datos['especie'],
        $datos['raza'],
        $datos['edad'],
        $datos['peso_actual'],
        $datos['color_senas'],
        $datos['responsable'],
        $datos['telefono_emergencia']
    );

    $repositorio = new GuardarMascota();

    if (!$repositorio->guardar($mascota)) {
        throw new RuntimeException('El registro no fue completado.');
    }

    header('Location: frmmascota.php?tipo=exito&mensaje=' . urlencode('Mascota registrada correctamente.'));
    exit;
} catch (InvalidArgumentException $e) {
    header('Location: frmmascota.php?tipo=error&mensaje=' . urlencode($e->getMessage()));
    exit;
} catch (Throwable $e) {
    error_log($e->getMessage());
    header('Location: frmmascota.php?tipo=error&mensaje=' . urlencode('No fue posible guardar la mascota. Inténtalo nuevamente.'));
    exit;
}
