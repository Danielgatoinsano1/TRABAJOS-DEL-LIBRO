<?php
require_once 'classProducto.php'; 

$productoEditar = null;
$mensaje = "";

// 1. Buscar el producto por código
if (isset($_POST['btn_buscar'])) {
    $codigo = $_POST['codproducto'];
    $resultado = datosProductos::consultarProductoCod($codigo);
    
    if (!empty($resultado)) {
        $productoEditar = $resultado[0];
    } else {
        $mensaje = "Producto no encontrado.";
    }
}

// 2. Guardar los cambios
if (isset($_POST['btn_actualizar'])) {
    $prod = new datosProductos();
    $prod->set_codproducto($_POST['codproducto']);
    $prod->set_nom_producto($_POST['nom_producto']);
    $prod->set_costoproducto($_POST['costoproducto']);
    $prod->set_porc_ventapro($_POST['porc_ventapro']);
    $prod->set_precio_ventapro($_POST['precio_ventapro']);
    $prod->set_imagenpro($_POST['imagenpro']);
    $prod->set_fechapro($_POST['fechapro']);

    $prod->actualizarProducto();
    $mensaje = "Producto actualizado con éxito.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <!-- Enlace a tu archivo local w3.css -->
    <link rel="stylesheet" href="EstilosCssF/w3.css">
</head>
<body class="w3-light-grey">

<div class="w3-container w3-content" style="max-width:600px; margin-top:30px;">
    
    <div class="w3-card-4 w3-white w3-round-large">
        <div class="w3-container w3-blue w3-round-top-large">
            <h2>Editar Producto</h2>
        </div>

        <div class="w3-container w3-padding">
            <?php if ($mensaje != ""): ?>
                <div class="w3-panel w3-blue-grey w3-display-container w3-round">
                    <p><?php echo $mensaje; ?></p>
                </div>
            <?php endif; ?>

            <!-- Formulario de Búsqueda -->
            <form action="frm_editar.php" method="POST" class="w3-container">
                <label class="w3-text-blue"><b>Código del Producto a Buscar:</b></label>
                <div class="w3-row">
                    <div class="w3-col s8">
                        <input class="w3-input w3-border w3-round" type="number" name="codproducto" required value="<?php echo isset($productoEditar) ? $productoEditar->codigo : ''; ?>">
                    </div>
                    <div class="w3-col s4 w3-padding-left">
                        <button class="w3-btn w3-blue w3-round w3-block" type="submit" name="btn_buscar">Buscar</button>
                    </div>
                </div>
            </form>

            <hr>

            <!-- Formulario de Edición -->
            <?php if ($productoEditar): ?>
            <form action="frm_editar.php" method="POST" class="w3-container">
                <input type="hidden" name="codproducto" value="<?php echo $productoEditar->codigo; ?>">

                <p>
                    <label class="w3-text-gray">Nombre del Producto</label>
                    <input class="w3-input w3-border w3-round" type="text" name="nom_producto" value="<?php echo $productoEditar->nom_producto; ?>" required>
                </p>

                <div class="w3-row-padding" style="margin:0 -16px;">
                    <div class="w3-half">
                        <label class="w3-text-gray">Costo</label>
                        <input class="w3-input w3-border w3-round" type="number" step="0.01" name="costoproducto" value="<?php echo $productoEditar->costo; ?>" required>
                    </div>
                    <div class="w3-half">
                        <label class="w3-text-gray">% Venta</label>
                        <input class="w3-input w3-border w3-round" type="number" name="porc_ventapro" value="<?php echo $productoEditar->porc_venta; ?>" required>
                    </div>
                </div>

                <p>
                    <label class="w3-text-gray">Precio de Venta</label>
                    <input class="w3-input w3-border w3-round" type="number" step="0.01" name="precio_ventapro" value="<?php echo $productoEditar->precio_venta; ?>" required>
                </p>

                <p>
                    <label class="w3-text-gray">Nombre de la Imagen</label>
                    <input class="w3-input w3-border w3-round" type="text" name="imagenpro" value="<?php echo $productoEditar->Imagen; ?>">
                </p>

                <p>
                    <label class="w3-text-gray">Fecha</label>
                    <input class="w3-input w3-border w3-round" type="date" name="fechapro" value="<?php echo $productoEditar->Fecha; ?>" required>
                </p>

                <p class="w3-center">
                    <button class="w3-btn w3-green w3-round-large w3-block" type="submit" name="btn_actualizar">Guardar Cambios</button>
                </p>
            </form>
            <?php endif; ?>
        </div>
    </div>

</div>

</body>
</html>