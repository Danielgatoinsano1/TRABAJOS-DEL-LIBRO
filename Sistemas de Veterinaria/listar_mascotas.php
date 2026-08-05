<?php
require_once __DIR__ . '/conexion.php';

$mascotas = [];
$mensajeError = '';
$mensaje = isset($_GET['mensaje']) ? (string) $_GET['mensaje'] : '';
$tipo = ($_GET['tipo'] ?? '') === 'exito' ? 'exito' : 'error';

try {
    $baseDatos = new Conexion();
    $consulta = $baseDatos->obtenerConexion()->prepare(
        'SELECT id, nombre, especie, raza, edad, peso_actual, color_senas, responsable, telefono_emergencia
        FROM Mascotas
        ORDER BY id DESC'
    );
    $consulta->execute();
    $mascotas = $consulta->fetchAll();
} catch (Throwable $e) {
    error_log($e->getMessage());
    $mensajeError = 'No fue posible consultar las mascotas en este momento.';
}

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
                                    <a class="w3-button w3-blue" href="editar_mascota.php?id=<?= escapar($mascota['id']) ?>">Editar</a>
                                    <form method="post" action="eliminar_mascota.php" style="display:inline" onsubmit="return confirm('¿Seguro que deseas eliminar esta mascota?');">
                                        <input type="hidden" name="id" value="<?= escapar($mascota['id']) ?>">
                                        <button class="w3-button w3-red" type="submit" name="eliminar_mascota">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include __DIR__ . '/pie_pagina.php'; ?>
