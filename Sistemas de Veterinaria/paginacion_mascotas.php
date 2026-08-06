<?php

require_once __DIR__ . '/GuardarMascota.php';

$mascotas = [];
$mensajeError = '';
$cantidadPorPagina = 7;
$paginaActual = filter_input(INPUT_GET, 'pagina', FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1],
]) ?: 1;
$totalMascotas = 0;
$totalPaginas = 1;
$primerRegistro = 0;
$ultimoRegistro = 0;

try {
    $totalMascotas = GuardarMascota::contarMascotas();
    $totalPaginas = max(1, (int) ceil($totalMascotas / $cantidadPorPagina));

    // Si se solicita una página que no existe, se muestra la última disponible.
    $paginaActual = min($paginaActual, $totalPaginas);
    $inicio = ($paginaActual - 1) * $cantidadPorPagina;

    $mascotas = GuardarMascota::obtenerMascotasPaginadas($inicio, $cantidadPorPagina);

    if ($totalMascotas > 0) {
        $primerRegistro = $inicio + 1;
        $ultimoRegistro = min($inicio + $cantidadPorPagina, $totalMascotas);
    }
} catch (Throwable $e) {
    error_log($e->getMessage());
    $mensajeError = 'No fue posible consultar las mascotas en este momento.';
}
