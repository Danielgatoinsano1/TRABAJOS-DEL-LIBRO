<?php require 'menu.php'; ?>

<main class="w3-container w3-mobile">
    <div class="w3-content" style="max-width: 80%">
        <div class="w3-container w3-col w3-teal">
            <h3>Sistema de Facturación</h3>
        </div>

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
                    <tbody></tbody>
                </table>
            </div>

            <div class="w3-row w3-panel">
                <div class="w3-col" style="width: 70%">
                    <button id="btnNueva" class="w3-button w3-teal" type="button">Nueva factura</button>
                    <input id="guarfact" class="w3-btn w3-teal" type="submit" value="Guardar factura">
                </div>
                <div class="w3-rest">
                    <label for="subtotalfact">Subtotal:</label>
                    <input type="text" id="subtotalfact" name="subtotalfact" class="w3-input w3-border w3-sand" readonly>
                </div>
            </div>

            <div class="w3-row">
                <div class="w3-col" style="width: 70%"></div>
                <div class="w3-rest">
                    <label for="impuestofact">IVA:</label>
                    <input type="text" id="impuestofact" name="impuestofact" class="w3-input w3-border w3-sand" readonly>
                </div>
            </div>

            <div class="w3-row">
                <div class="w3-col" style="width: 70%"></div>
                <div class="w3-rest">
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
                            <label for="codcliente">Código:</label>
                            <input type="text" id="codcliente" name="codcliente" class="w3-input w3-border w3-sand">
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

<script src="JScript/factura.js"></script>
