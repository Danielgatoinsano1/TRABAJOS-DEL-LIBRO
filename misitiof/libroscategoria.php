<?php
require_once 'menu.php';
require_once 'conexionf.php';

$categoriasLibros = [
    'Educación Básica',
    'I BTP y I BCH',
    'II BTP',
    'III BTP',
];
$categoria = is_string($_GET['categoria'] ?? null) ? trim($_GET['categoria']) : '';
$e = static fn($valor): string => htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
$libros = [];
$errorConsulta = false;

if (in_array($categoria, $categoriasLibros, true)) {
    try {
        $conexion = conect();
        $consulta = $conexion->prepare(
            'SELECT i.Codigo, i.nom_producto, i.imagen, i.precio_venta,
                    lc.informacion, lc.comentario, lc.creado
             FROM libroscomentarios AS lc
             INNER JOIN inventario AS i ON i.Codigo = lc.codigo_libro
             WHERE lc.categoria = :categoria
             ORDER BY i.nom_producto, lc.creado DESC'
        );
        $consulta->execute([':categoria' => $categoria]);
        $libros = $consulta->fetchAll(PDO::FETCH_OBJ);
    } catch (Throwable $error) {
        error_log('No se pudieron cargar los libros de la categoría: ' . $error->getMessage());
        $errorConsulta = true;
    }
}
?>

<main class="w3-container w3-padding-16">
    <div class="w3-content">
        <div class="w3-container w3-teal">
            <h2><?php echo $e($categoria !== '' ? $categoria : 'Libros'); ?></h2>
        </div>

        <?php if (!in_array($categoria, $categoriasLibros, true)) { ?>
            <div class="w3-panel w3-pale-red" role="alert">Selecciona una categoría válida desde el menú Libros.</div>
        <?php } elseif ($errorConsulta) { ?>
            <div class="w3-panel w3-pale-red" role="alert">No se pudo cargar la información. Revisa la instalación de la tabla de libros.</div>
        <?php } elseif (!$libros) { ?>
            <div class="w3-panel w3-pale-yellow">Todavía no hay libros registrados en esta categoría.</div>
        <?php } else { ?>
            <div class="w3-row-padding w3-section">
                <?php foreach ($libros as $libro) {
                    $nombreImagen = basename((string) ($libro->imagen ?? ''));
                    $rutaImagen = __DIR__ . '/imgfares/' . $nombreImagen;
                    ?>
                    <article class="w3-col s12 m6 l4 w3-margin-bottom">
                        <div class="w3-card w3-white" style="height:100%">
                            <?php if ($nombreImagen !== '' && is_file($rutaImagen)) { ?>
                                <img src="imgfares/<?php echo rawurlencode($nombreImagen); ?>"
                                     alt="Portada de <?php echo $e($libro->nom_producto); ?>"
                                     style="width:100%; max-height:280px; object-fit:contain">
                            <?php } ?>
                            <div class="w3-container w3-padding">
                                <h3><?php echo $e($libro->nom_producto); ?></h3>
                                <p><?php echo nl2br($e($libro->informacion)); ?></p>
                                <?php if ($libro->comentario !== null && $libro->comentario !== '') { ?>
                                    <p><strong>Comentario:</strong> <?php echo nl2br($e($libro->comentario)); ?></p>
                                <?php } ?>
                                <p><strong>Precio:</strong> $<?php echo number_format((float) $libro->precio_venta, 2); ?></p>
                            </div>
                        </div>
                    </article>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</main>

<?php require 'pie_pagina.php'; ?>
