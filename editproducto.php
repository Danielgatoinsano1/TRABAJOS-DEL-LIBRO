<?php
require_once 'menu.php';
require_once 'ConsultarProducto.php';
function e($valor) { return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8'); }
?>
<main class="w3-row-padding w3-container">
    <div class="w3-mobile w3-section" style="width:80%; margin:auto;">
        <div class="w3-container w3-teal"><h2>Editar datos del producto</h2></div>
        <form class="w3-card" action="actualizarproducto.php" method="post" enctype="multipart/form-data">
            <div class="w3-row-padding">
                <div class="w3-third"><label for="codigo"><b>Código</b></label><input class="w3-input w3-border fcolor-15" type="number" id="codigo" name="codigo" value="<?php echo e($productoSeleccionado->Codigo); ?>" readonly required></div>
                <div class="w3-twothird"><label for="nproducto"><b>Producto</b></label><input class="w3-input w3-border fcolor-15" type="text" id="nproducto" name="nproducto" maxlength="50" value="<?php echo e($productoSeleccionado->nom_producto); ?>" required autofocus></div>
            </div>
            <div class="w3-row-padding">
                <div class="w3-half"><label for="costop"><b>Costo</b></label><input class="w3-input w3-border fcolor-15" type="number" id="costop" name="costop" min="0" step="0.01" value="<?php echo e($productoSeleccionado->costo); ?>" required></div>
                <div class="w3-half"><label for="porcentajev"><b>Porcentaje de venta</b></label><input class="w3-input w3-border fcolor-15" type="number" id="porcentajev" name="porcentajev" min="0" step="0.01" value="<?php echo e($productoSeleccionado->porc_venta); ?>" required></div>
            </div>
            <div class="w3-row-padding">
                <div class="w3-half"><label for="pventa"><b>Precio de venta</b></label><input class="w3-input w3-border fcolor-15" type="number" id="pventa" value="<?php echo e($productoSeleccionado->precio_venta); ?>" readonly></div>
                <div class="w3-half"><label for="fecha_creacion"><b>Fecha</b></label><input class="w3-input w3-border fcolor-15" type="date" id="fecha_creacion" name="fecha_creacion" value="<?php echo e($productoSeleccionado->fecha); ?>" required></div>
            </div>
            <div class="w3-row-padding"><label for="simagen"><b>Nueva imagen (opcional)</b></label><input class="w3-input w3-border" type="file" id="simagen" name="simagen" accept="image/jpeg,image/png,image/gif"></div>
            <div class="w3-container"><button class="w3-btn w3-blue-grey w3-section" type="submit" name="cactualizar" value="1">Actualizar producto</button><a href="cproductos.php" class="w3-btn w3-teal w3-section" style="float:right">Regresar a productos</a></div>
        </form>
    </div>
</main>
<script>
const costo = document.getElementById('costop'), porcentaje = document.getElementById('porcentajev'), precio = document.getElementById('pventa');
function calcularPrecio() { const c = Number.parseFloat(costo.value) || 0, p = Number.parseFloat(porcentaje.value) || 0; precio.value = (c + (c * p / 100)).toFixed(2); }
costo.addEventListener('input', calcularPrecio); porcentaje.addEventListener('input', calcularPrecio);
</script>
<?php require 'pie_pagina.php'; ?>
