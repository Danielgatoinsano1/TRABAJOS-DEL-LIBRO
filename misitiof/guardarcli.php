<?php

require_once 'manipularcli.php';

function filtrofares($dato)
{
    return trim($dato);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['cguardar'])) {
    header('Location: frmcliente.php');
    exit;
}

$codigo = filter_var($_POST['ccodigo'] ?? null, FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1]
]);
$nombre = filtrofares($_POST['cnomcliente'] ?? '');
$direccion = filtrofares($_POST['cdireccion'] ?? '');
$telResidencial = filtrofares($_POST['ctelcasa'] ?? '');
$telCelular = filtrofares($_POST['ccelular'] ?? '');
$email = filtrofares($_POST['cemail'] ?? '');

if ($codigo === false || $nombre === '' || $telResidencial === '') {
    header('Location: frmcliente.php?estado=error');
    exit;
}

try {
    // Guardar el código escrito por el usuario.
    $cliente = new modificarcliente(
        $codigo,
        $nombre,
        $direccion,
        $telResidencial,
        $telCelular,
        $email
    );
    $cliente->guardar();

    header('Location: frmcliente.php');
    exit;
} catch (PDOException $e) {
    if ($e->getCode() === '23000') {
        header('Location: frmcliente.php?estado=codigo_existe');
        exit;
    }

    error_log('Error al guardar cliente: ' . $e->getMessage());
    header('Location: frmcliente.php?estado=error');
    exit;
}