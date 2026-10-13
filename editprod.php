<?php
require_once 'conexionf.php';
$conexion = conect();

// Obtener datos del producto a editar
if (isset($_GET['codigo'])) {
    $codigo = $_GET['codigo'];
    $stmt = $conexion->prepare("SELECT * FROM inventario WHERE codigo = :codigo");
    $stmt->execute([':codigo' => $codigo]);
    $prod = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$prod) {
        header("Location: productospaginados.php");
        exit();
    }
}

// Procesar actualización al presionar Guardar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST['codigo'];
    $nom_producto = $_POST['nom_producto'];
    $costo = $_POST['costo'];
    $precio_venta = $_POST['precio_venta'];

    $sql = "UPDATE inventario SET 
            nom_producto = :nom_producto, 
            costo = :costo, 
            precio_venta = :precio_venta 
            WHERE codigo = :codigo";
            
    $stmt = $conexion->prepare($sql);
    $stmt->execute([
        ':nom_producto' => $nom_producto,
        ':costo' => $costo,
        ':precio_venta' => $precio_venta,
        ':codigo' => $codigo
    ]);

    // Redireccionar al listado paginado tras confirmar la edición
    header("Location: productospaginados.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./imgfares/favicon.jpg" type="image/jpg" sizes="16x16">
    <link rel="stylesheet" type="text/css" href="./EstilosCssF/dcoloresf.css">
    <link rel="stylesheet" type="text/css" href="./EstilosCssF/diseñocssf.css">
    <link rel="stylesheet" type="text/css" href="./EstilosCssF/w3.css">
    <script src="./JScript/acciones_script.js"></script>
    <title>Editar Producto - Fares</title>
</head>

<body>
    <header id="titulo1" class="fcolor-d5"> 
        <h1>Ediciones Fares</h1>
    </header>

    <nav class="fcolor-l4">
        <ul>
            <li><a href="#">Principal</a></li>
            <li><a href="#">Libros</a></li>
            <li class="f-desplegable">
                <a href="#" class="btndesplegable">Inventario</a>
                <div class="cont-desplegable">
                    <a href="cproductos.php">Crear producto</a>
                    <a href="productospaginados.php">Consultar producto</a>
                </div>
            </li>
            <li><a href="#">Contacto</a></li>
        </ul>
    </nav>

    <!-- Contenedor alineado al diseño del sistema -->
    <main style="width: 95% !important; max-width: 700px; margin: 30px auto !important; padding: 0; box-sizing: border-box;">
        
        <!-- Encabezado del formulario -->
        <div class="fcolor-d5" style="width: 100% !important; padding: 15px; text-align: center; box-sizing: border-box;">
            <h2 style="color: white; margin: 0; font-size: 26px;">Modificar Producto</h2>
        </div>

        <!-- Formulario de edición -->
        <div style="background: #ffffff; padding: 30px; border: 1px solid #ccc; width: 100% !important; box-sizing: border-box;">
            <form method="POST" action="editprod.php">
                <div style="margin-bottom: 15px;">
                    <label style="font-weight: bold; display: block; margin-bottom: 5px;">Código:</label>
                    <input type="text" name="codigo" value="<?php echo htmlspecialchars($prod['codigo'] ?? ''); ?>" readonly class="w3-input w3-border w3-light-grey" style="width: 100%;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="font-weight: bold; display: block; margin-bottom: 5px;">Producto:</label>
                    <input type="text" name="nom_producto" value="<?php echo htmlspecialchars($prod['nom_producto'] ?? ''); ?>" required class="w3-input w3-border" style="width: 100%;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="font-weight: bold; display: block; margin-bottom: 5px;">Costo:</label>
                    <input type="text" name="costo" value="<?php echo htmlspecialchars($prod['costo'] ?? ''); ?>" required class="w3-input w3-border" style="width: 100%;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="font-weight: bold; display: block; margin-bottom: 5px;">Precio Venta:</label>
                    <input type="text" name="precio_venta" value="<?php echo htmlspecialchars($prod['precio_venta'] ?? ''); ?>" required class="w3-input w3-border" style="width: 100%;">
                </div>

                <div style="text-align: center; margin-top: 25px;">
                    <button type="submit" class="w3-button w3-blue w3-round" style="padding: 10px 25px; margin-right: 10px; font-weight: bold;">Guardar Cambios</button>
                    <a href="productospaginados.php" class="w3-button w3-red w3-round" style="padding: 10px 25px; text-decoration: none; font-weight: bold;">Cancelar</a>
                </div>
            </form>
        </div>
    </main>

    <footer class="fcolor-d5">
        <p>Derechos Reservados &copy; 2004-2023</p>
    </footer>
</body>
</html>