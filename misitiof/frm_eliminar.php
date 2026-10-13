<?php
require_once 'classProducto.php'; 

$mensaje = "";

if (isset($_POST['btn_eliminar'])) {
    $codproducto = $_POST['codproducto'];

    $prod = new datosProductos();
    $prod->set_codproducto($codproducto);

    $prod->eliminarproducto();
    $mensaje = "El producto con código $codproducto ha sido eliminado correctamente.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Producto</title>
    <!-- Enlace a tu archivo local w3.css -->
    <link rel="stylesheet" href="EstilosCssF/w3.css">
</head>
<body class="w3-light-grey">

<div class="w3-container w3-content" style="max-width:500px; margin-top:50px;">
    
    <div class="w3-card-4 w3-white w3-round-large">
        <div class="w3-container w3-blue w3-round-top-large">
            <h2>Eliminar Producto</h2>
        </div>

        <div class="w3-container w3-padding">
            <?php if ($mensaje != ""): ?>
                <div class="w3-panel w3-pale-grey w3-border w3-border-grey w3-round">
                    <p><strong><?php echo $mensaje; ?></strong></p>
                </div>
            <?php endif; ?>

            <form action="frm_eliminar.php" method="POST" class="w3-container">
                <p>
                    <label class="w3-text-black"><b>Ingrese el Código del Producto:</b></label>
                    <input class="w3-input w3-border w3-round" type="number" name="codproducto" placeholder="Ejemplo: 101" required>
                </p>

                <p class="w3-center">
                    <button class="w3-btn w3-blue w3-round-large w3-block" type="submit" name="btn_eliminar" onclick="return;">
                        Eliminar Producto
                    </button>
                </p>
            </form>
        </div>
    </div>

</div>

</body>
</html>