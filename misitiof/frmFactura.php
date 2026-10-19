<?php
require_once 'conexionf2.php';
$numeroFacturaSiguiente = 1000;
try {
    $conexionNumeroFactura = new Conexion();
    $numeroFacturaSiguiente = (int) $conexionNumeroFactura
        ->query('SELECT COALESCE(MAX(nofactura), 999) + 1 FROM controlfactura')
        ->fetchColumn();
} catch (Throwable $error) {
    error_log('No se pudo consultar el siguiente número de factura: ' . $error->getMessage());
}
require 'menu.php';
?>

<style>
    #formFactura .datosproducto fieldset > .w3-col {
        box-sizing: border-box;
        padding: 0 4px;
    }

    #tablaFactura {
        border-collapse: separate;
        width: calc(100% - 60px);
        margin: 0 auto;
        border-spacing: 12px 8px;
    }

    #tablaFactura thead th {
        padding: 9px 7px;
        font-size: 15px;
        line-height: 1.25;
        vertical-align: middle;
    }

    #tablaFactura tbody .factura-linea td {
        padding: 4px 10px;
        background-color: #fff2cc;
        border-top: 1px solid #d8c99f;
        border-bottom: 1px solid #d8c99f;
        border-left: 1px solid #d8c99f;
        border-right: 1px solid #9b8651;
        font-size: 15px;
        text-align: left;
        border-radius: 4px;
    }

    #tablaFactura tbody .factura-linea td:first-child {
        border-left: 1px solid #d8c99f;
        border-radius: 4px;
    }

    #tablaFactura tbody .factura-linea td:last-child {
        border-radius: 4px;
    }
</style>

<main class="w3-container w3-mobile">
    <div class="w3-content" style="max-width: 80%">
        <div class="w3-container w3-col w3-teal" style="display: flex; align-items: stretch; padding: 0">
            <h3 style="flex: 7; margin: 0; padding: 16px 20px">Sistema de Facturación</h3>
            <div style="flex: 3; display: flex; align-items: center; justify-content: space-around; gap: 8px; box-sizing: border-box; padding: 12px 16px; background: #2196f3; color: #102a43; font-size: 20px">
                <span>Factura No. 1.</span>
                <strong id="numfactura"><?php echo htmlspecialchars((string) $numeroFacturaSiguiente, ENT_QUOTES, 'UTF-8'); ?></strong>
            </div>
        </div>
        <p id="estadoFactura" class="w3-panel w3-pale-red" role="status" aria-live="polite" style="display:none"></p>

        <form action="guardarfactura.php" method="post" id="formFactura">
            <input type="hidden" id="numfacturar" name="numfacturar" value="<?php echo htmlspecialchars((string) $numeroFacturaSiguiente, ENT_QUOTES, 'UTF-8'); ?>">
            <section id="vistaPreviaFactura" class="w3-container w3-white w3-border w3-margin-top factura-borrador" aria-label="Vista previa de la factura">
                <div class="w3-responsive">
                    <table class="w3-table-all w3-centered w3-bordered" id="tablaFactura">
                        <thead><tr class="ajaxTitle"><th style="width:9%">Id-<br>Producto</th><th style="width:9%">Cantidad</th><th style="width:50%">Descripción</th><th style="width:16%">Precio</th><th style="width:16%">Total</th></tr></thead>
                        <tbody class="tabla">
                            <tr id="filaFacturaVacia" style="display:none"><td colspan="5"></td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="w3-row w3-panel">
                    <div class="w3-col" style="width:70%">
                        <button id="btnNueva" class="w3-button w3-teal" type="button">Nueva factura</button>
                        <input id="guarfact" class="w3-btn w3-teal" type="submit" value="Guardar factura">
                    </div>
                    <div class="w3-col" style="width:30%">
                        <label for="subtotalfact">Subtotal:</label>
                        <input type="text" id="subtotalfact" name="subtotalfact" class="w3-input w3-border w3-sand" readonly>
                        <label for="impuestofact">IVA:</label>
                        <input type="text" id="impuestofact" name="impuestofact" class="w3-input w3-border w3-sand" readonly>
                        <label for="todpagarfact">Total a pagar:</label>
                        <input type="text" id="todpagarfact" name="todpagarfact" class="w3-input w3-border w3-sand" readonly>
                    </div>
                </div>
            </section>
            <div class="w3-row">
                <div class="datosproducto w3-col s12 m7">
                    <fieldset>
                        <legend>Seleccionar producto:</legend>
                        <div class="w3-col" style="width: 12%">
                            <label for="codpro">Código:</label>
                            <input type="text" id="codpro" class="w3-input w3-border w3-sand" autocomplete="off">
                        </div>
                        <div class="w3-col" style="width: 12%">
                            <label for="cantpro">Cantidad:</label>
                            <input type="number" id="cantpro" min="1" step="1" class="w3-input w3-border w3-sand">
                        </div>
                        <div class="w3-col" style="width: 46%">
                            <label for="despro">Descripción:</label>
                            <input type="text" id="despro" class="w3-input w3-border w3-sand" readonly>
                        </div>
                        <div class="w3-col" style="width: 15%">
                            <label for="prepro">Precio:</label>
                            <input type="text" id="prepro" class="w3-input w3-border w3-sand" readonly>
                        </div>
                        <div class="w3-col" style="width: 15%">
                            <label for="totpro">Total:</label>
                            <input type="text" id="totpro" class="w3-input w3-border w3-sand" readonly>
                        </div>
                    </fieldset>
                    <div class="w3-container w3-panel">
                        <button id="btn2" class="w3-button w3-blue w3-hover-red" type="button">Agregar producto</button>
                    </div>
                </div>

                <div id="Datoscliente" class="w3-col s12 m5">
                    <fieldset>
                        <legend>Seleccionar cliente:</legend>
                        <div class="w3-col s12 m3">
                            <label for="cod_cliente">Código:</label>
                            <input type="text" id="cod_cliente" name="cod_cliente" class="w3-input w3-border w3-sand">
                        </div>
                        <div class="w3-col s12 m9">
                            <label for="nombrecliente">Nombre del cliente:</label>
                            <input type="text" id="nombrecliente" name="nombrecliente" class="w3-input w3-border w3-sand" readonly>
                        </div>
                    </fieldset>
                </div>
            </div>
        </form>
    </div>
</main>

<script src="JScript/factura.js?v=11"></script>
