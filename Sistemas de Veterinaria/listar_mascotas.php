<?php
require_once __DIR__ . '/paginacion_mascotas.php';

$mensaje = isset($_GET['mensaje']) ? (string) $_GET['mensaje'] : '';
$tipo = ($_GET['tipo'] ?? '') === 'exito' ? 'exito' : 'error';

function escapar($valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8', false);
}

include __DIR__ . '/menu.php';
?>

<section class="w3-container vet-listado">
    <div class="vet-tarjeta w3-card">
        <h1 class="vet-titulo">Mascotas registradas</h1>

        <?php if ($mensaje !== ''): ?>
            <div class="<?= $tipo === 'exito' ? 'vet-mensaje-exito' : 'vet-mensaje-error' ?>" role="alert"><?= escapar($mensaje) ?></div>
        <?php endif; ?>

        <?php if ($mensajeError !== ''): ?>
            <div class="vet-mensaje-error" role="alert"><?= escapar($mensajeError) ?></div>
        <?php elseif (count($mascotas) === 0): ?>
            <div class="vet-vacio">
                <p>Todavía no existen mascotas registradas.</p>
                <a class="vet-boton" href="frmmascota.php">Registrar la primera mascota</a>
            </div>
        <?php else: ?>
            <div class="vet-resumen-listado">
                <strong><?= escapar($totalMascotas) ?> mascotas</strong>
                <span>Mostrando <?= escapar($primerRegistro) ?>–<?= escapar($ultimoRegistro) ?></span>
            </div>

            <div class="w3-responsive">
                <table class="w3-table-all vet-tabla">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Especie</th>
                            <th>Raza</th>
                            <th>Edad</th>
                            <th>Peso</th>
                            <th>Color/señas</th>
                            <th>Responsable</th>
                            <th>Teléfono</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mascotas as $mascota): ?>
                            <tr>
                                <td><?= escapar($mascota['id']) ?></td>
                                <td><?= escapar($mascota['nombre']) ?></td>
                                <td><?= escapar($mascota['especie']) ?></td>
                                <td><?= escapar($mascota['raza']) ?></td>
                                <td><?= escapar($mascota['edad']) ?></td>
                                <td><?= escapar($mascota['peso_actual']) ?> kg</td>
                                <td><?= escapar($mascota['color_senas']) ?></td>
                                <td><?= escapar($mascota['responsable']) ?></td>
                                <td><?= escapar($mascota['telefono_emergencia']) ?></td>
                                <td>
                                    <a
                                        class="w3-btn w3-teal"
                                        href="editar_mascota.php?id=<?= escapar($mascota['id']) ?>"
                                        title="Editar mascota"
                                        aria-label="Editar mascota"
                                    ><i class="fas fa-edit" aria-hidden="true"></i></a>
                                    <form method="post" action="eliminar_mascota.php" style="display:inline" onsubmit="return confirm('¿Seguro que deseas eliminar esta mascota?');">
                                        <input type="hidden" name="id" value="<?= escapar($mascota['id']) ?>">
                                        <button
                                            class="w3-btn w3-red"
                                            type="submit"
                                            name="eliminar_mascota"
                                            title="Eliminar mascota"
                                            aria-label="Eliminar mascota"
                                        ><i class="fas fa-user-times" aria-hidden="true"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <nav class="vet-paginador" aria-label="Paginación de mascotas">
                <div class="w3-bar">
                <?php if ($paginaActual > 1): ?>
                    <a
                        class="w3-bar-item w3-button w3-border w3-teal"
                        href="Mascotaspaginadas.php?pagina=<?= $paginaActual - 1 ?>"
                        aria-label="Página anterior"
                    >&laquo;</a>
                <?php else: ?>
                    <span class="w3-bar-item w3-button w3-border w3-teal w3-disabled">&laquo;</span>
                <?php endif; ?>

                <?php for ($numeroPagina = 1; $numeroPagina <= $totalPaginas; $numeroPagina++): ?>
                    <a
                        class="w3-bar-item w3-button w3-border<?= $numeroPagina === $paginaActual ? ' w3-dark-grey' : '' ?>"
                        href="Mascotaspaginadas.php?pagina=<?= $numeroPagina ?>"
                        <?= $numeroPagina === $paginaActual ? 'aria-current="page"' : '' ?>
                    ><?= $numeroPagina ?></a>
                <?php endfor; ?>

                <?php if ($paginaActual < $totalPaginas): ?>
                    <a
                        class="w3-bar-item w3-button w3-border w3-teal"
                        href="Mascotaspaginadas.php?pagina=<?= $paginaActual + 1 ?>"
                        aria-label="Página siguiente"
                    >&raquo;</a>
                <?php else: ?>
                    <span class="w3-bar-item w3-button w3-border w3-teal w3-disabled">&raquo;</span>
                <?php endif; ?>
                </div>
            </nav>
            <p class="vet-pagina-estado">Página <?= escapar($paginaActual) ?> de <?= escapar($totalPaginas) ?></p>
        <?php endif; ?>
    </div>
</section>

<?php include __DIR__ . '/pie_pagina.php'; ?>
