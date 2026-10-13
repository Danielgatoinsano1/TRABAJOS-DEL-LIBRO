<?php require 'menu.php'; ?>
<main class="w3-container w3-mobile ">
    <div class="w3-content" style="max-width:80%">
        <div class="w3-container w3-row">
            <div class="w3-container w3-col w3-teal" style="width:70%">
                <h3>Sistema de Facturacion</h3>
            </div>
            <div class="w3-container w3-cyan w3-rest">
                <h3 class="w3-twothird">Factura No 1.</h3>
                <h3 id="numfactura" class="w3-third">0000</h3>
            </div>
        </div>
        <form class="w3-container" action="guardarfactura.php" method="post">
            <input type="hidden" id="numfacturar" name="numfacturar">
            <div class="w3-container">
                <div class="w3-responsive">
                    <table class="tabla w3-table-all w3-centered w3-bordered">
                        <tr class="ajaxTitle w3-border">
                            <th style="width: 10%;">Id-Producto</th>
                            <th style="width: 10%;">Cantidad</th>
                            <th style="width: 50%;">Descripcion</th>
                            <th style="width: 15%;">Precio</th>
                            <th style="width: 15%;">Total</th>
                        </tr>
                    </table>
                </div>
                <br>
                <div class="w3-row w3-panel">
                    <div class="w3-col w3-mobile" style="width:80%">
                        <button id="btnNueva" class="w3-button w3-teal" type="button"> Nueva factura</button> <input id="guarfact" name="guarfact" class="w3-btn w3-teal" type="submit" value="Guardar factura">
                    </div>
                    <div class="w3-col w3-mobile" style="width:20%">
                        <div class="w3-col w3-mobile">
                            <label for="sutotalfact">Subtotal:</label>
                            <input type="text" id="sutotalfact" name="sutotalfact" class="w3-input w3-border w3-sand">
                        </div>
                        <div class="w3-col w3-mobile">
                            <label for="impuestofact">IVA:</label>
                            <input type="text" id="impuestofact" name="impuestofact" class="w3-input w3-border w3-sand">
                        </div>
                        <div class="w3-col w3-mobile">
                            <label for="todpagarfact">Total a pagar:</label>
                            <input type="text" id="todpagarfact" name="todpagarfact" class="w3-input w3-border w3-sand">
                        </div>
                    </div>
                </div>
            </div>
            <div class="w3-row">
                <div id="datosproducto" class="w3-col l7 m7">
                    <fieldset>
                        <legend>Seleccionar producto:</legend>
                        <div class="w3-col w3-mobile" style="width:12%">
                            <label for="">Codigo:</label>
                            <input type="text" id="codpro" class="w3-input w3-border w3-sand">
                        </div>
                        <div class="w3-col w3-mobile" style="width:14%">
                            <label for="">Cantidad:</label>
                            <input type="text" id="cantpro" class="w3-input w3-border w3-sand">
                        </div>
                        <div class="w3-col w3-mobile" style="width:42%">
                            <label for="">Descripcion:</label>
                            <input type="text" id="despro" class="w3-input w3-border w3-sand"> 
                        </div>
                        <div class="w3-col w3-mobile" style="width:15%">
                            <label for="">Precio:</label>
                            <input type="text" id="prepro" class="w3-input w3-border w3-sand">
                        </div>
                        <div class="w3-col w3-mobile" style="width:15%">
                            <label for="">Total:</label>
                            <input type="text" id="totpro" class="w3-input w3-border w3-sand">
                        </div>
                    </fieldset>
                    <div class="w3-container w3-panel">
                        <button id="btn2" class="w3-button w3-blue w3-button w3-hover-red" type="button">Agregar producto</button>
                    </div>
                </div>
                <div id="Datoscliente" class="w3-col w3-mobile l5 m5">
                    <fieldset>
                        <legend>Seleccionar cliente:</legend>
                        <div class="w3-col w3-mobile l3 m3">
                            <label for="">Codigo:</label>
                            <input type="text" id="cod_cliente" name="cod_cliente" class="w3-input w3-border w3-sand">
                        </div>
                        <div class="w3-col w3-mobile l9 m9">
                            <label for="">Nombre del cliente:</label>
                            <input type="text" id="nomcliente" class="w3-input w3-border w3-sand">
                        </div>
                    </fieldset>
                </div>
        </form>
        <div id="container"></div>
    </div>
    </div>
</main>
<?php require 'pie_pagina.php';?>
<script type="text/javascript" src="./JScript/factura.js"></script>