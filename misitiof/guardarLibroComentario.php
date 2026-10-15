<?php
require_once 'conexionf.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: frmLibros.php');
    exit;
}

$codigoLibro = filter_var($_POST['codigo_libro'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
$categoria = is_string($_POST['categoria'] ?? null) ? trim($_POST['categoria']) : '';
$informacion = is_string($_POST['informacion'] ?? null) ? trim($_POST['informacion']) : '';
$comentario = is_string($_POST['comentario'] ?? null) ? trim($_POST['comentario']) : '';
$categoriasPermitidas = ['Educación Básica', 'I BTP y I BCH', 'II BTP', 'III BTP'];

if ($codigoLibro === false || !in_array($categoria, $categoriasPermitidas, true)
    || $informacion === '' || mb_strlen($informacion) > 5000 || mb_strlen($comentario) > 3000) {
    header('Location: frmLibros.php?estado=error');
    exit;
}

try {
    $conexion = conect();
    $consulta = $conexion->prepare(
        'INSERT INTO libroscomentarios (codigo_libro, categoria, informacion, comentario)
         VALUES (:codigo, :categoria, :informacion, :comentario)'
    );
    $consulta->execute([
        ':codigo' => $codigoLibro,
        ':categoria' => $categoria,
        ':informacion' => $informacion,
        ':comentario' => $comentario !== '' ? $comentario : null,
    ]);
    header('Location: frmLibros.php?estado=guardado');
} catch (Throwable $error) {
    error_log('No se pudo guardar la información del libro: ' . $error->getMessage());
    header('Location: frmLibros.php?estado=error');
}
exit;
