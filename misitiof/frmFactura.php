<?php
require_once 'conexionf2.php';
$facturaVista = null; $detalleVista = [];
try {
    $dbFactura = new Conexion();
    $idVista = filter_input(INPUT_GET, 'guardada', FILTER_VALIDATE_INT);
    if ($idVista) {
        $q = $dbFactura->prepare('SELECT idfactura, subtotal, iva, total FROM factura WHERE idfactura = :id');
        $q->execute([':id' => $idVista]); $facturaVista = $q->fetch(PDO::FETCH_ASSOC);
        if ($facturaVista) {
            $q = $dbFactura->prepare('SELECT d.Codigo, d.cantidad, i.nom_producto, d.precio FROM detalle_factura d JOIN inventario i ON i.Codigo = d.Codigo WHERE d.idfactura = :id ORDER BY d.iddetalle');
            $q->execute([':id' => $idVista]); $detalleVista = $q->fetchAll(PDO::FETCH_ASSOC);
        }
    }
} catch (Throwable $error) { $facturaVista = null; }
require 'menu.php'; ?>

<main class="w3-container w3-mobile">
    <div class="w3-content" style="max-width: 980px; margin: 24px auto;">
        <div class="w3-row w3-teal" style="display:flex;align-items:center;justify-content:space-between;padding:0 16px;min-height:58px"><h3 style="margin:12px 0">Sistema de Facturacion</h3><div style="text-align:right"><strong>Factura No. <?php echo $facturaVista ? (int) $facturaVista['idfactura'] : 'Nueva'; ?></strong><br><span style="color:#dbeafe;font-size:1.35em"><?php if ($facturaVista) echo htmlspecialchars(str_pad((string) $facturaVista['idfactura'], 3, '0', STR_PAD_LEFT), ENT_QUOTES, 'UTF-8'); ?></span></div></div>
        <?php if (isset($_GET['guardada'])): ?>
            <p class="w3-panel w3-pale-green">Factura #<?php echo (int) $_GET['guardada']; ?> guardada correctamente.</p>
        <?php elseif (isset($_GET['error'])): ?>
            <p class="w3-panel w3-pale-red"><?php echo htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>

        <form action="guardarfactura.php" method="post" id="formFactura">
            <input type="hidden" id="numfacturar" name="numfacturar" value="">

            <div class="w3-responsive">
                <table class="w3-table-all w3-centered w3-bordered" id="tablaFactura">
                    <thead>
                        <tr class="ajaxTitle">
                            <th style="width: 16%">ID Producto</th>
                            <th style="width: 14%">Cantidad</th>
                            <th style="width: 50%">Descripcion</th>
                            <th style="width: 15%">Precio</th>
                            
                        </tr>
                    </thead>
                    <tbody><?php foreach ($detalleVista as $linea): ?><tr><td><?php echo (int) $linea['Codigo']; ?></td><td><?php echo (int) $linea['cantidad']; ?></td><td><?php echo htmlspecialchars($linea['nom_producto'], ENT_QUOTES, 'UTF-8'); ?></td><td><?php echo number_format((float) $linea['precio'], 2); ?></td></tr><?php endforeach; ?></tbody>
                </table>
            </div>

            <div class="w3-row" style="display:flex;align-items:flex-start;justify-content:space-between;gap:24px;margin:16px 0">
                <div style="display:flex;gap:8px;align-items:center;padding-top:20px">
                    <button id="btnNueva" class="w3-button w3-teal" type="button">Nueva factura</button>
                    <input id="guarfact" class="w3-btn w3-teal" type="submit" value="Guardar factura">
                </div>
                <div style="width:280px;max-width:100%">
                    <label for="subtotalfact">Subtotal:</label>
                    <input type="text" id="subtotalfact" name="subtotalfact" class="w3-input w3-border w3-sand" readonly value="<?php echo $facturaVista ? number_format((float) $facturaVista['subtotal'], 2, '.', '') : ''; ?>">
                    <label for="impuestofact">IVA:</label>
                    <input type="text" id="impuestofact" name="impuestofact" class="w3-input w3-border w3-sand" readonly value="<?php echo $facturaVista ? number_format((float) $facturaVista['iva'], 2, '.', '') : ''; ?>">
                    <label for="todpagarfact">Total a pagar:</label>
                    <input type="text" id="todpagarfact" name="todpagarfact" class="w3-input w3-border w3-sand" readonly value="<?php echo $facturaVista ? number_format((float) $facturaVista['total'], 2, '.', '') : ''; ?>">
                </div>
            </div>
            <div class="w3-row">
                <div class="datosproducto w3-col s12 m7">
                    <fieldset style="display:grid; grid-template-columns:12% 12% minmax(0,1fr) 15% 15%; gap:10px; align-items:end">
                        <legend>Seleccionar producto:</legend>
                        
                        <div class="w3-col" style="min-width:0">
                            <label for="codpro">Codigo:</label>
                            <input type="text" id="codpro" class="w3-input w3-border w3-sand" autocomplete="off">
                        </div>
                        <div class="w3-col" style="min-width:0">
                            <label for="cantpro">Cantidad:</label>
                            <input type="number" id="cantpro" min="1" step="1" class="w3-input w3-border w3-sand">
                        </div>
                        <div class="w3-col" style="min-width:0">
                            <label for="despro">Descripcion:</label>
                            <input type="text" id="despro" class="w3-input w3-border w3-sand" readonly>
                        </div>
                        <div class="w3nocol" style="min-width:0">
                            <label for="prepro">Precio:</label>
                            <input type="text" id="prepro" class="w3-input w3-border w3-sand" readonly>
                        </div>
                        <div class="w3-col" style="min-width:0">
                            <label for="totpro">Total:</label>
                            <input type="text" id="totpro" class="w3-input w3-border w3-sand" readonly>
                        </div>
                    </fieldset>
                    <div class="w3-container w3-panel">
                        <button id="btn2" class="w3-button w3-blue w3-hover-red" type="button">Agregar producto</button>
                    </div>
                </div>

                <div id="Datoscliente" class="w3-col s12 m5" style="flex:1 1 35%; min-width:260px">
                    <fieldset>
                        <legend>Seleccionar cliente:</legend>
                        <div class="w3-col s12 m3">
                            <label for="codcliente">Codigo:</label>
                            <input type="text" id="codcliente" name="codcliente" required class="w3-input w3-border w3-sand">
                        </div>
                        <div class="w3-col s12 m9">
                            <label for="nomcliente">Nombre:</label>
                            <input type="text" id="nomcliente" name="nomcliente" class="w3-input w3-border w3-sand" readonly>
                        </div>
                    </fieldset>
                </div>
            </div>
        </form>
    </div>
</main>

<?php if (!$facturaVista): ?><script src="JScript/factura.js"></script><?php endif; ?>



