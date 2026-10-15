<?php
require_once 'menu.php';
require_once 'classProducto.php';

$categoriasLibros = [
    'Educación Básica',
    'I BTP y I BCH',
    'II BTP',
    'III BTP',
];

try {
    $productos = datosProductos::consultarProductoTod();
} catch (Throwable $error) {
    error_log('No se pudo cargar el inventario para el formulario de libros: ' . $error->getMessage());
    $productos = [];
}

$e = static fn($valor): string => htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
$estado = $_GET['estado'] ?? '';
?>

<main class="w3-container w3-padding-16">
    <div class="w3-content" style="max-width: 900px">
        <div class="w3-container w3-teal">
            <h2>Información y comentarios de libros</h2>
        </div>

        <?php if ($estado === 'guardado') { ?>
            <div class="w3-panel w3-pale-green" role="status">La información del libro se guardó correctamente.</div>
        <?php } elseif ($estado === 'error') { ?>
            <div class="w3-panel w3-pale-red" role="alert">No se pudo guardar. Revisa los datos y vuelve a intentarlo.</div>
        <?php } ?>

        <form class="w3-container w3-card w3-padding" action="guardarLibroComentario.php" method="post">
            <p>
                <label for="codigo_libro">Libro del inventario</label>
                <select class="w3-select w3-border" name="codigo_libro" id="codigo_libro" required>
                    <option value="" disabled selected>Selecciona un libro</option>
                    <?php foreach ($productos as $producto) { ?>
                        <option value="<?php echo $e($producto->Codigo); ?>">
                            <?php echo $e($producto->nom_producto); ?>
                        </option>
                    <?php } ?>
                </select>
            </p>
            <p>
                <label for="categoria">Categoría</label>
                <select class="w3-select w3-border" name="categoria" id="categoria" required>
                    <option value="" disabled selected>Selecciona una categoría</option>
                    <?php foreach ($categoriasLibros as $categoria) { ?>
                        <option value="<?php echo $e($categoria); ?>"><?php echo $e($categoria); ?></option>
                    <?php } ?>
                </select>
            </p>
            <p>
                <label for="informacion">Información del libro</label>
                <textarea class="w3-input w3-border" name="informacion" id="informacion" rows="5" maxlength="5000" required></textarea>
            </p>
            <p>
                <label for="comentario">Comentario</label>
                <textarea class="w3-input w3-border" name="comentario" id="comentario" rows="3" maxlength="3000"></textarea>
            </p>
            <button class="w3-button w3-teal" type="submit">Guardar información</button>
            <a class="w3-button w3-light-grey" href="index.php">Volver a la galería</a>
        </form>
    </div>
</main>

<?php require 'pie_pagina.php'; ?>
