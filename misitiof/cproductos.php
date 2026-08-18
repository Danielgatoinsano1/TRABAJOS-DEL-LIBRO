<?php
require_once 'menu.php';
require_once 'manipularproductos.php';

$pagina = isset($_GET['pagina']) ? max(1, (int) $_GET['pagina']) : 1;
$cantidad = 5;
$totalRegistros = modificarProducto::totalRegistros();
$numeroPaginas = max(1, (int) ceil($totalRegistros / $cantidad));
$pagina = min($pagina, $numeroPaginas);
$productos = modificarProducto::limitarRegistros(($pagina - 1) * $cantidad, $cantidad);
$estado = $_GET['estado'] ?? '';
$mensajes = [
    'guardado' => ['w3-green', 'El producto se guardó correctamente.'],
    'actualizado' => ['w3-green', 'El producto se actualizó correctamente.'],
    'eliminado' => ['w3-green', 'El producto se eliminó correctamente.'],
    'codigo_existe' => ['w3-red', 'Ese código ya existe. Escribe uno diferente.'],
    'imagen_error' => ['w3-red', 'La imagen debe ser JPG, PNG o GIF y debe poder subirse.'],
    'no_encontrado' => ['w3-red', 'No se encontró el producto solicitado.'],
    'error' => ['w3-red', 'No se pudo realizar la operación. Revisa los datos.'],
];
?>

<main class="w3-row-padding w3-container">
    <?php if (isset($mensajes[$estado])) { ?>
        <div class="w3-panel <?php echo $mensajes[$estado][0]; ?>"><p><?php echo $mensajes[$estado][1]; ?></p></div>
    <?php } ?>

    <div class="w3-col s6 w3-mobile w3-section">
        <div class="w3-container fcolor-d2"><h2>Ingresar datos del producto</h2></div>
        <form class="w3-card" action="guardarproducto.php" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="w3-row-padding">
                <div class="w3-third">
                    <label for="codigo"><b>Código</b></label>
                    <input class="w3-input w3-border fcolor-15" type="number" id="codigo" name="codigo" min="1" step="1" required autofocus>
                </div>
                <div class="w3-twothird">
                    <label for="nproducto"><b>Producto</b></label>
                    <input class="w3-input w3-border fcolor-15" type="text" id="nproducto" name="nproducto" maxlength="50" required>
                </div>
            </div>
            <div class="w3-row-padding">
                <div class="w3-half">
                    <label for="costop"><b>Costo</b></label>
                    <input class="w3-input w3-border fcolor-15" type="number" id="costop" name="costop" min="0" step="0.01" required>
                </div>
                <div class="w3-half">
                    <label for="porcentajev"><b>Porcentaje de venta</b></label>
                    <input class="w3-input w3-border fcolor-15" type="number" id="porcentajev" name="porcentajev" min="0" step="0.01" required>
                </div>
            </div>
            <div class="w3-row-padding">
                <div class="w3-half">
                    <label for="pventa"><b>Precio de venta</b></label>
                    <input class="w3-input w3-border fcolor-15" type="number" id="pventa" readonly>
                </div>
                <div class="w3-half">
                    <label for="fecha_creacion"><b>Fecha</b></label>
                    <input class="w3-input w3-border fcolor-15" type="date" id="fecha_creacion" name="fecha_creacion" required>
                </div>
            </div>
            <div class="w3-row-padding">
                <label for="simagen"><b>Imagen</b></label>
                <input class="w3-input w3-border" type="file" id="simagen" name="simagen" accept="image/jpeg,image/png,image/gif">
            </div>
            <div class="w3-container"><button class="w3-btn w3-blue-grey w3-section" type="submit" name="cguardar" value="1">Guardar</button></div>
        </form>
    </div>

    <div class="w3-col s6 w3-mobile w3-section">
        <table class="w3-table-all w3-hoverable w3-striped">
            <thead><tr class="fcolor-11"><th>Código</th><th>Producto</th><th>Precio</th><th>Acción</th></tr></thead>
            <tbody>
                <?php foreach ($productos as $producto) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars((string) $producto->Codigo); ?></td>
                        <td><?php echo htmlspecialchars($producto->nom_producto); ?></td>
                        <td><?php echo number_format((float) $producto->precio_venta, 2); ?></td>
                        <td>
                            <a href="editproducto.php?codigo=<?php echo urlencode($producto->Codigo); ?>" class="w3-btn w3-teal" title="Editar"><i class="fas fa-edit"></i></a>
                            <a href="eliminarproducto.php?codigo=<?php echo urlencode($producto->Codigo); ?>" class="w3-btn w3-red" title="Eliminar" onclick="return confirm('¿Deseas eliminar este producto?');"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                <?php } ?>
                <?php if (!$productos) { ?><tr><td colspan="4" class="w3-center">No hay productos registrados.</td></tr><?php } ?>
            </tbody>
        </table>
        <div class="w3-center w3-section"><div class="w3-bar">
            <?php if ($pagina > 1) { ?><a class="w3-bar-item w3-button w3-border w3-teal" href="cproductos.php?pagina=<?php echo $pagina - 1; ?>">&laquo;</a><?php } else { ?><span class="w3-bar-item w3-button w3-border w3-teal w3-disabled">&laquo;</span><?php } ?>
            <?php for ($i = 1; $i <= $numeroPaginas; $i++) { ?><a class="w3-bar-item w3-button w3-border<?php echo $pagina === $i ? ' w3-dark-grey' : ''; ?>" href="cproductos.php?pagina=<?php echo $i; ?>"><?php echo $i; ?></a><?php } ?>
            <?php if ($pagina < $numeroPaginas) { ?><a class="w3-bar-item w3-button w3-border w3-teal" href="cproductos.php?pagina=<?php echo $pagina + 1; ?>">&raquo;</a><?php } else { ?><span class="w3-bar-item w3-button w3-border w3-teal w3-disabled">&raquo;</span><?php } ?>
        </div></div>
    </div>
</main>

<script>
const costo = document.getElementById('costop');
const porcentaje = document.getElementById('porcentajev');
const precio = document.getElementById('pventa');
function calcularPrecio() {
    const c = Number.parseFloat(costo.value) || 0;
    const p = Number.parseFloat(porcentaje.value) || 0;
    precio.value = (c + (c * p / 100)).toFixed(2);
}
costo.addEventListener('input', calcularPrecio);
porcentaje.addEventListener('input', calcularPrecio);
</script>
<?php require 'pie_pagina.php'; ?>
