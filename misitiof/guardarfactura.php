<?php
require_once 'conexionf2.php';

function errorFactura(string $mensaje, int $estado = 400): void
{
    http_response_code($estado);
    header('Content-Type: text/html; charset=UTF-8');
    echo '<!doctype html><html lang="es"><meta charset="utf-8"><title>Error al guardar factura</title>';
    echo '<p>' . htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') . '</p><p><a href="frmFactura.php">Volver a la factura</a></p></html>';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['guarfact'])) {
    errorFactura('Solicitud no válida.');
}

$numero = filter_input(INPUT_POST, 'numfacturar', FILTER_VALIDATE_INT);
$cliente = filter_input(INPUT_POST, 'cod_cliente', FILTER_VALIDATE_INT);
$productos = $_POST['Id_Producto'] ?? null;
$cantidades = $_POST['Cantidad'] ?? null;
$precios = $_POST['Precio'] ?? null;
$totales = $_POST['Total'] ?? null;

if (!$numero || !$cliente || !is_array($productos) || !is_array($cantidades) || !is_array($precios) || !is_array($totales)
    || count($productos) === 0 || count($productos) !== count($cantidades) || count($productos) !== count($precios) || count($productos) !== count($totales)) {
    errorFactura('Completa el número, el cliente y al menos un producto antes de guardar.');
}

$subtotal = filter_input(INPUT_POST, 'sutotalfact', FILTER_VALIDATE_FLOAT);
$impuesto = filter_input(INPUT_POST, 'impuestofact', FILTER_VALIDATE_FLOAT);
$granTotal = filter_input(INPUT_POST, 'todpagarfact', FILTER_VALIDATE_FLOAT);
if ($subtotal === false || $subtotal === null || $subtotal < 0 || $impuesto === false || $impuesto === null || $impuesto < 0 || $granTotal === false || $granTotal === null || $granTotal < 0) {
    errorFactura('Los importes de la factura no son válidos.');
}

try {
    $conexion = new Conexion();
    $conexion->beginTransaction();

    $clienteQuery = $conexion->prepare('SELECT idcli FROM clientes WHERE idcli = :cliente');
    $clienteQuery->execute([':cliente' => $cliente]);
    if (!$clienteQuery->fetchColumn()) {
        throw new DomainException('El cliente seleccionado no existe.');
    }

    $insertarItem = $conexion->prepare('INSERT INTO movimientofactura (facturano, clienteid, productoid, cantfact, precifact, totalfact) VALUES (:factura, :cliente, :producto, :cantidad, :precio, :total)');
    $productoQuery = $conexion->prepare('SELECT Codigo FROM inventario WHERE Codigo = :producto');
    foreach ($productos as $i => $productoRaw) {
        $producto = filter_var($productoRaw, FILTER_VALIDATE_INT);
        $cantidad = filter_var($cantidades[$i] ?? null, FILTER_VALIDATE_INT);
        $precio = filter_var($precios[$i] ?? null, FILTER_VALIDATE_FLOAT);
        $total = filter_var($totales[$i] ?? null, FILTER_VALIDATE_FLOAT);
        if (!$producto || !$cantidad || $cantidad < 1 || $precio === false || $precio < 0 || $total === false || $total < 0) {
            throw new DomainException('Uno de los productos o importes no es válido.');
        }
        $productoQuery->execute([':producto' => $producto]);
        if (!$productoQuery->fetchColumn()) {
            throw new DomainException('Uno de los productos ya no existe en el inventario.');
        }
        $insertarItem->execute([
            ':factura' => $numero, ':cliente' => $cliente, ':producto' => $producto,
            ':cantidad' => $cantidad, ':precio' => $precio, ':total' => $total,
        ]);
    }

    $insertarFactura = $conexion->prepare('INSERT INTO controlfactura (nofactura, codclientefact, subtotalfact, impuestofact, grantotalfact) VALUES (:factura, :cliente, :subtotal, :impuesto, :total)');
    $insertarFactura->execute([':factura' => $numero, ':cliente' => $cliente, ':subtotal' => $subtotal, ':impuesto' => $impuesto, ':total' => $granTotal]);
    $conexion->commit();

    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    $_SESSION['facturan'] = $numero;
    header('Location: mostrarfactura.php');
    exit;
} catch (DomainException $error) {
    if (isset($conexion) && $conexion->inTransaction()) $conexion->rollBack();
    errorFactura($error->getMessage());
} catch (Throwable $error) {
    if (isset($conexion) && $conexion->inTransaction()) $conexion->rollBack();
    error_log('Error al guardar factura: ' . $error->getMessage());
    errorFactura('No se pudo guardar la factura. Revisa que el número no esté repetido y vuelve a intentarlo.', 500);
}
