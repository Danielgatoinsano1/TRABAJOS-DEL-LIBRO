<?php
require_once __DIR__ . '/conexion.php';

$totalMascotas = 0;
$totalEspecies = 0;
$promedioEdad = 0;
$promedioPeso = 0;
$mascotasRecientes = [];
$mensajeError = '';

function escaparDashboard($valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8', false);
}

try {
    $baseDatos = new Conexion();
    $conexion = $baseDatos->obtenerConexion();

    $consultaResumen = $conexion->query(
        'SELECT
            COUNT(*) AS total_mascotas,
            COUNT(DISTINCT LOWER(TRIM(especie))) AS total_especies,
            COALESCE(AVG(edad), 0) AS promedio_edad,
            COALESCE(AVG(peso_actual), 0) AS promedio_peso
         FROM Mascotas'
    );

    $resumen = $consultaResumen->fetch();
    $totalMascotas = (int) ($resumen['total_mascotas'] ?? 0);
    $totalEspecies = (int) ($resumen['total_especies'] ?? 0);
    $promedioEdad = (float) ($resumen['promedio_edad'] ?? 0);
    $promedioPeso = (float) ($resumen['promedio_peso'] ?? 0);

    $consultaRecientes = $conexion->query(
        'SELECT id, nombre, especie, raza, edad, peso_actual, responsable
         FROM Mascotas
         ORDER BY id DESC
         LIMIT 5'
    );
    $mascotasRecientes = $consultaRecientes->fetchAll();
} catch (Throwable $e) {
    error_log($e->getMessage());
    $mensajeError = 'No fue posible cargar el dashboard. Verifica Apache, MySQL y la base de datos.';
}

include __DIR__ . '/menu.php';
?>

<section class="w3-container vet-dashboard-wrapper">
    <div class="vet-dashboard-layout">
        <aside class="vet-sidebar-panel w3-card">
            <h2>Dashboard</h2>
            <p class="vet-sidebar-texto">Opciones principales del sistema.</p>

            <nav class="vet-sidebar-menu" aria-label="Opciones del dashboard">
                <a class="activo" href="index.php">Dashboard</a>
                <a href="frmmascota.php">Registrar mascota</a>
                <a href="listar_mascotas.php">Ver mascotas</a>
                <a href="frmmascota.php">Nuevo responsable</a>
                <a href="listar_mascotas.php">Consultas</a>
            </nav>

            <div class="vet-sidebar-ayuda">
                <h3>Acción rápida</h3>
                <a class="vet-boton" href="frmmascota.php">Registrar mascota</a>
            </div>
        </aside>

        <div class="vet-dashboard-main">
            <div class="vet-dashboard-hero vet-tarjeta w3-card">
                <span class="vet-insignia">Panel principal</span>
                <h1>Dashboard veterinario</h1>
                <p>
                    Consulta el estado del santuario y accede rápidamente a las opciones más importantes.
                </p>
            </div>

            <?php if ($mensajeError !== ''): ?>
                <div class="vet-mensaje-error" role="alert">
                    <?= escaparDashboard($mensajeError) ?>
                </div>
            <?php endif; ?>

            <div class="vet-dashboard-cards">
                <article class="vet-resumen-card w3-card">
                    <h3>Total de mascotas</h3>
                    <strong><?= escaparDashboard($totalMascotas) ?></strong>
                    <p>Registros almacenados</p>
                </article>

                <article class="vet-resumen-card w3-card">
                    <h3>Especies</h3>
                    <strong><?= escaparDashboard($totalEspecies) ?></strong>
                    <p>Especies diferentes</p>
                </article>

                <article class="vet-resumen-card w3-card">
                    <h3>Edad promedio</h3>
                    <strong><?= number_format($promedioEdad, 1) ?></strong>
                    <p>Años por mascota</p>
                </article>

                <article class="vet-resumen-card w3-card">
                    <h3>Peso promedio</h3>
                    <strong><?= number_format($promedioPeso, 2) ?></strong>
                    <p>Kilogramos</p>
                </article>
            </div>

            <div class="vet-dashboard-tablero">
                <section class="vet-tabla-panel vet-tarjeta w3-card">
                    <div class="vet-tabla-panel-head">
                        <div>
                            <h2>Últimas mascotas registradas</h2>
                            <p>Se muestran las 5 mascotas más recientes.</p>
                        </div>
                        <a class="vet-boton" href="listar_mascotas.php">Ver todas</a>
                    </div>

                    <?php if (count($mascotasRecientes) === 0): ?>
                        <div class="vet-vacio-dashboard">
                            <p>No hay mascotas registradas todavía.</p>
                            <a class="vet-boton" href="frmmascota.php">Agregar primera mascota</a>
                        </div>
                    <?php else: ?>
                        <div class="w3-responsive">
                            <table class="w3-table-all vet-tabla vet-tabla-dashboard">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Especie</th>
                                        <th>Raza</th>
                                        <th>Edad</th>
                                        <th>Peso</th>
                                        <th>Responsable</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($mascotasRecientes as $mascota): ?>
                                        <tr>
                                            <td><?= escaparDashboard($mascota['id']) ?></td>
                                            <td><?= escaparDashboard($mascota['nombre']) ?></td>
                                            <td><?= escaparDashboard($mascota['especie']) ?></td>
                                            <td><?= escaparDashboard($mascota['raza']) ?></td>
                                            <td><?= escaparDashboard($mascota['edad']) ?> años</td>
                                            <td><?= number_format((float) $mascota['peso_actual'], 2) ?> kg</td>
                                            <td><?= escaparDashboard($mascota['responsable']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </section>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/pie_pagina.php'; ?>
