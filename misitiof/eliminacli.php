<?php
require_once 'manipularcli.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: frmcliente.php');
    exit;
}

$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
if ($id === false) {
    header('Location: frmcliente.php?estado=error');
    exit;
}

try {
    (new modificarcliente($id, null, null, null, null, null))->eliminarCliente();
    header('Location: frmcliente.php');
} catch (Throwable $error) {
    error_log('Error al eliminar cliente: ' . $error->getMessage());
    header('Location: frmcliente.php?estado=error');
}
exit;
