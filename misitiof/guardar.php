<?php
require_once 'conexionf.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['cguardar'])) {
    header('Location: cproductos.php');
    exit;
}

$codigo = filter_input(INPUT_POST, 'codigo', FILTER_VALIDATE_INT);
$nombre = trim((string) ($_POST['nproducto'] ?? ''));
$costo = filter_input(INPUT_POST, 'costop', FILTER_VALIDATE_FLOAT);
$porcentaje = filter_input(INPUT_POST, 'porcentajev', FILTER_VALIDATE_FLOAT);
$precio = filter_input(INPUT_POST, 'pventa', FILTER_VALIDATE_FLOAT);
$fecha = trim((string) ($_POST['fecha_creacion'] ?? ''));

if (!$codigo || $nombre === '' || preg_match_all('/./us', $nombre) > 50 || $costo === false || $costo === null || $costo < 0
    || $porcentaje === false || $porcentaje === null || $porcentaje < 0 || $precio === false || $precio === null || $precio < 0) {
    http_response_code(400);
    exit('Revisa el código, nombre y precios del producto.');
}
if ($fecha === '') $fecha = date('Y-m-d');
$fechaValida = DateTime::createFromFormat('!Y-m-d', $fecha);
if (!$fechaValida || $fechaValida->format('Y-m-d') !== $fecha) {
    http_response_code(400);
    exit('La fecha no es válida.');
}

$imagen = null;
if (isset($_FILES['simagen']) && $_FILES['simagen']['error'] !== UPLOAD_ERR_NO_FILE) {
    if ($_FILES['simagen']['error'] !== UPLOAD_ERR_OK || !is_uploaded_file($_FILES['simagen']['tmp_name'])) {
        http_response_code(400);
        exit('No se pudo recibir la imagen.');
    }
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($_FILES['simagen']['tmp_name']);
    $extensiones = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif'];
    if (!isset($extensiones[$mime])) {
        http_response_code(400);
        exit('La imagen debe ser JPG, PNG o GIF.');
    }
    $imagen = $codigo . '.' . $extensiones[$mime];
    $directorio = __DIR__ . DIRECTORY_SEPARATOR . 'imgfares';
    if (!is_dir($directorio) || !move_uploaded_file($_FILES['simagen']['tmp_name'], $directorio . DIRECTORY_SEPARATOR . $imagen)) {
        http_response_code(500);
        exit('No se pudo guardar la imagen.');
    }
}

try {
    $conexion = conect();
    if (!$conexion) throw new RuntimeException('No hay conexión con la base de datos.');
    $sql = 'INSERT INTO inventario (Codigo, nom_producto, costo, porc_venta, precio_venta, fecha, imagen) VALUES (:codigo, :nombre, :costo, :porcentaje, :precio, :fecha, :imagen)';
    $stmt = $conexion->prepare($sql);
    $stmt->execute([':codigo' => $codigo, ':nombre' => $nombre, ':costo' => $costo, ':porcentaje' => $porcentaje, ':precio' => $precio, ':fecha' => $fecha, ':imagen' => $imagen]);
    header('Location: productospaginados.php');
    exit;
} catch (Throwable $error) {
    error_log('Error al guardar producto: ' . $error->getMessage());
    http_response_code(500);
    echo 'No se pudo guardar el producto. Comprueba que el código no esté repetido.';
}
