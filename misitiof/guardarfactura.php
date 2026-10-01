<?php
require_once 'conexionf2.php';

function volverConError($mensaje)
{
    header('Location: frmFactura.php?error=' . urlencode($mensaje));
    exit;
}

$cliente = filter_input(INPUT_POST, 'codcliente', FILTER_VALIDATE_INT);
$productos = $_POST['productos'] ?? [];
$cantidades = $_POST['cantidades'] ?? [];
if (!$cliente || !is_array($productos) || !is_array($cantidades) || count($productos) === 0 || count($productos) !== count($cantidades)) {
    volverConError('Datos de factura incompletos.');
}

try {
    $conexion = new Conexion();
    $consultaCliente = $conexion->prepare('SELECT idcli FROM clientes WHERE idcli = :cliente');
    $consultaCliente->execute([':cliente' => $cliente]);
    if (!$consultaCliente->fetchColumn()) volverConError('El cliente no existe.');

    $conexion->beginTransaction();
    $lineas = [];
    $subtotal = 0.0;
    $consultaProducto = $conexion->prepare('SELECT nom_producto, precio_venta FROM inventario WHERE Codigo = :codigo');
    foreach ($productos as $indice => $codigoBruto) {
        $codigo = filter_var($codigoBruto, FILTER_VALIDATE_INT);
        $cantidad = filter_var($cantidades[$indice] ?? null, FILTER_VALIDATE_INT);
        if (!$codigo || !$cantidad || $cantidad < 1) throw new InvalidArgumentException('Producto o cantidad inválidos.');
        $consultaProducto->execute([':codigo' => $codigo]);
        $producto = $consultaProducto->fetch(PDO::FETCH_ASSOC);
        if (!$producto) throw new InvalidArgumentException('Uno de los productos ya no existe.');
        $precio = (float) $producto['precio_venta'];
        $importe = round($precio * $cantidad, 2);
        $subtotal += $importe;
        $lineas[] = [$codigo, $cantidad, $precio, $importe];
    }

    $iva = round($subtotal * 0.15, 2);
    $total = round($subtotal + $iva, 2);
    $encabezado = $conexion->prepare('INSERT INTO factura (idcli, fecha, subtotal, iva, total) VALUES (:cliente, CURDATE(), :subtotal, :iva, :total)');
    $encabezado->execute([':cliente' => $cliente, ':subtotal' => $subtotal, ':iva' => $iva, ':total' => $total]);
    $idFactura = (int) $conexion->lastInsertId();
    $detalle = $conexion->prepare('INSERT INTO detalle_factura (idfactura, Codigo, cantidad, precio, subtotal) VALUES (:factura, :codigo, :cantidad, :precio, :subtotal)');
    foreach ($lineas as [$codigo, $cantidad, $precio, $importe]) {
        $detalle->execute([':factura' => $idFactura, ':codigo' => $codigo, ':cantidad' => $cantidad, ':precio' => $precio, ':subtotal' => $importe]);
    }
    $conexion->commit();
    header('Location: frmFactura.php?guardada=' . $idFactura);
    exit;
} catch (Throwable $error) {
    if (isset($conexion) && $conexion->inTransaction()) $conexion->rollBack();
}
