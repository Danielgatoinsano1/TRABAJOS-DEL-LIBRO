<?php
require_once 'manipularproductos.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['cactualizar'])) {
    header('Location: cproductos.php');
    exit;
}

$codigo = filter_var($_POST['codigo'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
$nombre = trim($_POST['nproducto'] ?? '');
$costo = filter_var($_POST['costop'] ?? null, FILTER_VALIDATE_FLOAT);
$porcentaje = filter_var($_POST['porcentajev'] ?? null, FILTER_VALIDATE_FLOAT);
$fecha = $_POST['fecha_creacion'] ?? '';
$fechaValida = DateTime::createFromFormat('Y-m-d', $fecha);

if ($codigo === false || $nombre === '' || $costo === false || $costo < 0 || $porcentaje === false || $porcentaje < 0 || !$fechaValida || $fechaValida->format('Y-m-d') !== $fecha) {
    header('Location: cproductos.php?estado=error');
    exit;
}

$imagen = null;
$cambiarImagen = isset($_FILES['simagen']) && $_FILES['simagen']['error'] !== UPLOAD_ERR_NO_FILE;
if ($cambiarImagen) {
    if ($_FILES['simagen']['error'] !== UPLOAD_ERR_OK) {
        header('Location: cproductos.php?estado=imagen_error');
        exit;
    }
    $tipos = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif'];
    $tipo = (new finfo(FILEINFO_MIME_TYPE))->file($_FILES['simagen']['tmp_name']);
    if (!isset($tipos[$tipo])) {
        header('Location: cproductos.php?estado=imagen_error');
        exit;
    }
    $imagen = $codigo . '.' . $tipos[$tipo];
    if (!move_uploaded_file($_FILES['simagen']['tmp_name'], __DIR__ . '/imgfares/' . $imagen)) {
        header('Location: cproductos.php?estado=imagen_error');
        exit;
    }
}

try {
    $precio = round($costo + ($costo * $porcentaje / 100), 2);
    (new modificarProducto($codigo, $nombre, $costo, $porcentaje, $precio, $fecha, $imagen))->actualizar($cambiarImagen);
    header('Location: cproductos.php?estado=actualizado');
} catch (PDOException $e) {
    error_log('Error al actualizar producto: ' . $e->getMessage());
    header('Location: cproductos.php?estado=error');
}
exit;
