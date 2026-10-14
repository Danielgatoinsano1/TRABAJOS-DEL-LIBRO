<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./imgfares/FAVICON.jpg" type="image/jpg" sizes="16x16">
    <link rel="stylesheet" type="text/css" href="./EstilosCssF/w3.css">
    <link rel="stylesheet" type="text/css" href="./EstilosCssF/dcoloresf.css">
    <link rel="stylesheet" type="text/css" href="./EstilosCssF/diseñocssf.css">
    <script src="./JScript/acciones_script.JS" defer></script>
    <title>Inventario-Fares</title>
</head>

<body>
    <header id="titulo1" class="fcolor-d5">
        <h1>Ediciones Fares</h1>
    </header>
    <?php require 'navegacion.php'; ?>
    
    <section class="fcolor-l1 seccion-form">
        <div class="s-encabezado">
            <h2>Inventario</h2>
        </div>
    <br><br>
    <?php if (isset($_GET['estado']) && is_string($_GET['estado'])) { ?>
        <?php $estadoProducto = $_GET['estado']; ?>
        <div class="w3-panel <?php echo $estadoProducto === 'guardado' ? 'w3-pale-green' : 'w3-pale-red'; ?>">
            <?php
            $mensajes = [
                'guardado' => 'El producto se guardó correctamente.',
                'codigo_existe' => 'Ese código de producto ya está registrado.',
                'imagen_error' => 'No se pudo procesar la imagen. Usa JPG, PNG o GIF.',
                'error' => 'No se pudo guardar el producto. Revisa los datos e inténtalo nuevamente.',
            ];
            echo htmlspecialchars($mensajes[$estadoProducto] ?? $mensajes['error'], ENT_QUOTES, 'UTF-8');
            ?>
        </div>
    <?php } ?>
    <form class="fcolor-l5" action="guardarproducto.php" method="post" enctype="multipart/form-data" autocomplete="off">
        <div id="codnom">
        <label class="codnom1">Código: <input type="number" name="codigo" id="codigo" min="1" step="1"
        placeholder="Ingresar Codigo" size="12" autofocus required> </label>
        <label class="codnom1">Producto:
        <input type="text" class="campof" name="nproducto" id="nproducto"
        minlength="3" maxlength="50" placeholder="Ingrese nombre del producto" size="50"
        required> </label>
        </div>
        
        <div id="cospor">
            <label class="codnom1">Costo: <input type="number" class="campof" name="costop" id="costop"
            min="0" step="0.01" required> </label>
            <label class="codnom1">Porcentaje de Venta: <input type="number" class="campof" name="porcentajev"
            id="porcentajev" min="0" step="0.01" required> </label>
        </div>
        
        <div id="prefecha">
        <label class="codnom1">Precio de venta: <input type="number" class="campof" name="pventa" id="pventa" step="0.01" readonly> </label>
        <label class="codnom1">Fecha: <input type="date" class="campof" name="fecha_creacion" id="fecha_creacion" required> </label>
        </div>

        <div id="csimagen" >
            <img width="200" alt="Vista previa de la imagen del producto">
        </div>

        <div id="botonimg">
        <input type="file" class="campof" name="simagen" id="simagen" accept="image/jpeg,image/png,image/gif">
        </div>
        <input type="submit" name="cguardar" id="cguardar" value="Guardar">
    </form>
    </section>
    <footer class="fcolor-d5">
        <p>Derechos Recervados &copy; 2004-2023 </p>
    </footer>
</body>
</html>
