<?php 
require 'manipularprod.php';

/* Almacenar en $pagina el valor de la variable página */
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($pagina < 1) { $pagina = 1; }

$cantRegistros = 5; // Cantidad de registros a mostrar

/* Calcular inicio para la consulta SQL */
$inicio = ($pagina > 1) ? (($pagina * $cantRegistros) - $cantRegistros) : 0;

$totalregistros = modificarproducto::totalRegistros();
$listaproductos = modificarproducto::limitRegistros($inicio, $cantRegistros);
$numeropaginas = ceil($totalregistros / $cantRegistros);
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
    <title>Productos</title>
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

    <!-- Contenedor general sin clases de CSS externo que restrinjan el ancho -->
    <main style="width: 95% !important; margin: 30px auto !important; padding: 0; box-sizing: border-box;">
        
        <!-- Encabezado unificado al 100% -->
        <div class="fcolor-d5" style="width: 100% !important; padding: 15px; text-align: center; box-sizing: border-box;">
            <h2 style="color: white; margin: 0; font-size: 26px;">Lista de productos</h2>
        </div>

        <!-- Cuerpo de la tabla unificado al 100% -->
        <div style="background: #ffffff; padding: 20px; border: 1px solid #ccc; width: 100% !important; box-sizing: border-box;">
            <table class="w3-table-all w3-hoverable" style="width: 100%;">
                <thead>
                    <tr class="fcolor-l4" style="border-bottom: 2px solid #ccc;">
                        <th>Código</th>
                        <th>Producto</th>
                        <th>Costo</th>
                        <th>Precio Venta</th>
                        <th class="w3-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listaproductos as $fila): ?>
                    <tr>
                        <td><?php echo htmlspecialchars((string) $fila['Codigo'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo $fila['nom_producto']; ?></td>
                        <td><?php echo $fila['costo']; ?></td>
                        <td><?php echo $fila['precio_venta']; ?></td>
                        <td class="w3-center">
                            <a href="editprod.php?codigo=<?php echo rawurlencode((string) $fila['Codigo']); ?>" class="w3-button w3-blue w3-tiny w3-round">Editar</a>
                            <a href="eliminaprod.php?codigo=<?php echo rawurlencode((string) $fila['Codigo']); ?>" class="w3-button w3-red w3-tiny w3-round">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Paginación -->
            <div class="w3-center w3-padding-16">
                <div class="w3-bar w3-border">
                    <?php if ($pagina > 1): ?>
                        <a href="productospaginados.php?pagina=<?php echo $pagina - 1; ?>" class="w3-bar-item w3-button fcolor-l1">&laquo;</a>
                    <?php else: ?>
                        <span class="w3-bar-item w3-button fcolor-l1 w3-disabled">&laquo;</span>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $numeropaginas; $i++): ?>
                        <a href="productospaginados.php?pagina=<?php echo $i; ?>" class="w3-bar-item w3-button <?php echo ($i == $pagina) ? 'fcolor-d5 w3-text-white' : 'w3-white'; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($pagina < $numeropaginas): ?>
                        <a href="productospaginados.php?pagina=<?php echo $pagina + 1; ?>" class="w3-bar-item w3-button fcolor-d5 w3-text-white">&raquo;</a>
                    <?php else: ?>
                        <span class="w3-bar-item w3-button fcolor-d5 w3-text-white w3-disabled">&raquo;</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <footer class="fcolor-d5">
        <p>Derechos Reservados &copy; 2004-2023</p>
    </footer>
</body>
</html>
