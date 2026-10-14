<?php require 'menu.php'; ?>

<main class="w3-container w3-mobile">
    <div class="w3-content" style="max-width: 80%">
        <div class="w3-container w3-col w3-teal" style="display: flex; align-items: stretch; padding: 0">
            <h3 style="flex: 7; margin: 0; padding: 16px 20px">Sistema de Facturación</h3>
            <div style="flex: 3; display: flex; align-items: center; justify-content: space-around; gap: 8px; box-sizing: border-box; padding: 12px 16px; background: #2196f3; color: #102a43; font-size: 20px">
                <span>Factura No. 1.</span>
                <strong id="numfactura">0000</strong>
            </div>
        </div>
        <p id="estadoFactura" class="w3-panel w3-pale-red" role="status" aria-live="polite" style="display:none"></p>

        <form action="guardarfactura.php" method="post" id="formFactura">
            <input type="hidden" id="numfacturar" name="numfacturar" value="">

            <div class="w3-responsive">
                <table class="w3-table-all w3-centered w3-bordered" id="tablaFactura">
                    <thead>
                        <tr class="ajaxTitle">
                            <th style="width: 10%">Id-Producto</th>
                            <th style="width: 10%">Cantidad</th>
                            <th style="width: 50%">Descripción</th>
                            <th style="width: 15%">Precio</th>
                            <th style="width: 15%">Total</th>
                        </tr>
                    </thead>
                    <tbody class="tabla"></tbody>
                </table>
            </div>

            <div class="w3-row w3-panel">
                <div class="w3-col" style="width: 70%">
                    <button id="btnNueva" class="w3-button w3-teal" type="button">Nueva factura</button>
                    <input id="guarfact" class="w3-btn w3-teal" type="submit" value="Guardar factura">
                </div>
                <div class="w3-col" style="width: 30%">
                    <label for="subtotalfact">Subtotal:</label>
                    <input type="text" id="subtotalfact" name="subtotalfact" class="w3-input w3-border w3-sand" readonly>
                    <label for="impuestofact">IVA:</label>
                    <input type="text" id="impuestofact" name="impuestofact" class="w3-input w3-border w3-sand" readonly>
                    <label for="todpagarfact">Total a pagar:</label>
                    <input type="text" id="todpagarfact" name="todpagarfact" class="w3-input w3-border w3-sand" readonly>
                </div>
            </div>

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
                            <label for="nombrecliente">Nombre:</label>
                            <input type="text" id="nombrecliente" name="nombrecliente" class="w3-input w3-border w3-sand" readonly>
                        </div>
                    </fieldset>
                </div>
            </div>
        </form>
    </div>
</main>

<script src="JScript/factura.js"></script>
