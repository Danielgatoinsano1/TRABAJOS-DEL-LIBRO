<?php
require_once 'menu.php';
require_once 'manipularproductos.php';

$pagina = isset($_GET['pagina']) ? max(1, (int) $_GET['pagina']) : 1;
$cantidad = 3;
$totalRegistros = modificarProducto::totalRegistros();
$numeroPaginas = max(1, (int) ceil($totalRegistros / $cantidad));
$pagina = min($pagina, $numeroPaginas);
$productos = modificarProducto::limitarRegistros(($pagina - 1) * $cantidad, $cantidad);
?>

<div class="w3-container w3-center">
    <div class="w3-bar fcolor-d2" style="width: 90%; display: block; margin: 0 auto;">
        <h2>Lista de productos</h2>
    </div>

    <div class="w3-bar" style="width: 90%; display: block; margin: 0 auto;">
        <table class="w3-table-all">
            <thead>
                <tr class="w3-light-grey w3-hover-red">
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Costo</th>
                    <th>Porcentaje</th>
                    <th>Precio de venta</th>
                    <th>Fecha</th>
                    <th>Stock</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto) { ?>
                    <tr class="w3-hover-green">
                        <td><?php echo htmlspecialchars((string) $producto->Codigo); ?></td>
                        <td><?php echo htmlspecialchars($producto->nom_producto); ?></td>
                        <td><?php echo number_format((float) $producto->costo, 2); ?></td>
                        <td><?php echo number_format((float) $producto->porc_venta, 2); ?>%</td>
                        <td><?php echo number_format((float) $producto->precio_venta, 2); ?></td>
                        <td><?php echo htmlspecialchars($producto->fecha); ?></td>
                        <td><?php echo htmlspecialchars((string) $producto->stock); ?></td>
                        <td>
                            <a href="editproducto.php?codigo=<?php echo urlencode($producto->Codigo); ?>" class="w3-btn w3-teal" title="Editar"><i class="fas fa-edit"></i></a>
                            <a href="eliminarproducto.php?codigo=<?php echo urlencode($producto->Codigo); ?>" class="w3-btn w3-red" title="Eliminar" onclick="return confirm('¿Deseas eliminar este producto?');"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                <?php } ?>
                <?php if (!$productos) { ?>
                    <tr><td colspan="8">No hay productos registrados.</td></tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div style="width: 90%; margin: 10px auto 0; text-align: center;">
        <div class="w3-bar">
            <?php if ($pagina > 1) { ?>
                <a href="Productospaginados.php?pagina=<?php echo $pagina - 1; ?>" class="w3-bar-item w3-button w3-border w3-teal">&laquo;</a>
            <?php } else { ?>
                <span class="w3-bar-item w3-button w3-border w3-teal w3-disabled">&laquo;</span>
            <?php } ?>

            <?php for ($i = 1; $i <= $numeroPaginas; $i++) { ?>
                <a class="w3-bar-item w3-button w3-border<?php echo $pagina === $i ? ' w3-dark-grey' : ''; ?>" href="Productospaginados.php?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
            <?php } ?>

            <?php if ($pagina < $numeroPaginas) { ?>
                <a href="Productospaginados.php?pagina=<?php echo $pagina + 1; ?>" class="w3-bar-item w3-button w3-border w3-teal">&raquo;</a>
            <?php } else { ?>
                <span class="w3-bar-item w3-button w3-border w3-teal w3-disabled">&raquo;</span>
            <?php } ?>
        </div>
    </div>
</div>

<?php require 'pie_pagina.php'; ?>
