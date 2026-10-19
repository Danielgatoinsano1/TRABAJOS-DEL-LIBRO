<?php
require_once 'conexionf2.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método no permitido.');
}

$codigoCliente = filter_input(INPUT_POST, 'cod_cliente', FILTER_VALIDATE_INT);
$numeroFactura = filter_input(INPUT_POST, 'numfacturar', FILTER_VALIDATE_INT);
$productos = $_POST['Id_Producto'] ?? [];
$cantidades = $_POST['Cantidad'] ?? [];

if (!$codigoCliente || !$numeroFactura || !is_array($productos) || !is_array($cantidades)
    || count($productos) === 0 || count($productos) !== count($cantidades)) {
    http_response_code(400);
    exit('La factura debe incluir un cliente y al menos un producto válido.');
}

try {
    $conexion = new Conexion();
    $conexion->beginTransaction();

    $ultimoNumero = (int) $conexion->query('SELECT COALESCE(MAX(nofactura), 999) FROM controlfactura')->fetchColumn();
    if ($numeroFactura <= $ultimoNumero) {
        throw new DomainException('El número de factura ya fue utilizado. Elige otro número.');
    }

    $cliente = $conexion->prepare('SELECT idcli FROM clientes WHERE idcli = :id');
    $cliente->execute([':id' => $codigoCliente]);
    if (!$cliente->fetchColumn()) {
        throw new DomainException('El cliente seleccionado no existe.');
    }

    $lineas = [];
    $subtotal = 0.0;
    $consultaProducto = $conexion->prepare(
        'SELECT precio_venta FROM inventario WHERE Codigo = :codigo'
    );

    foreach ($productos as $indice => $productoEntrada) {
        $productoId = filter_var($productoEntrada, FILTER_VALIDATE_INT);
        $cantidad = filter_var($cantidades[$indice] ?? null, FILTER_VALIDATE_INT);
        if (!$productoId || !$cantidad || $cantidad < 1) {
            throw new DomainException('Hay un producto o una cantidad inválida.');
        }

        $consultaProducto->execute([':codigo' => $productoId]);
        $precio = $consultaProducto->fetchColumn();
        if ($precio === false) {
            throw new DomainException('Uno de los productos ya no está disponible.');
        }

        $precio = (float) $precio;
        $totalLinea = round($precio * $cantidad, 2);
        $subtotal += $totalLinea;
        $lineas[] = [$productoId, $cantidad, $precio, $totalLinea];
    }

    $subtotal = round($subtotal, 2);
    $impuesto = round($subtotal * 0.15, 2);
    $total = round($subtotal + $impuesto, 2);

    $cabecera = $conexion->prepare(
        'INSERT INTO controlfactura (nofactura, codclientefact, subtotalfact, impuestofact, grantotalfact)
         VALUES (:numero, :cliente, :subtotal, :impuesto, :total)'
    );
    $cabecera->execute([
        ':numero' => $numeroFactura,
        ':cliente' => $codigoCliente,
        ':subtotal' => $subtotal,
        ':impuesto' => $impuesto,
        ':total' => $total,
    ]);

    $detalle = $conexion->prepare(
        'INSERT INTO movimientofactura
         (facturano, clienteid, productoid, cantfact, precifact, totalfact)
         VALUES (:factura, :cliente, :producto, :cantidad, :precio, :total)'
    );
    foreach ($lineas as [$productoId, $cantidad, $precio, $totalLinea]) {
        $detalle->execute([
            ':factura' => $numeroFactura,
            ':cliente' => $codigoCliente,
            ':producto' => $productoId,
            ':cantidad' => $cantidad,
            ':precio' => $precio,
            ':total' => $totalLinea,
        ]);
    }

    $conexion->commit();
    session_start();
    $_SESSION['facturan'] = $numeroFactura;
    header('Location: mostrarfactura.php');
    exit;
} catch (Throwable $error) {
    if (isset($conexion) && $conexion->inTransaction()) {
        $conexion->rollBack();
    }
    error_log('Error al guardar factura: ' . $error->getMessage());
    http_response_code(400);
    $mensaje = $error instanceof DomainException
        ? $error->getMessage()
        : 'No se pudo guardar la factura. Revisa los datos e inténtalo de nuevo.';
    echo htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8');
}
