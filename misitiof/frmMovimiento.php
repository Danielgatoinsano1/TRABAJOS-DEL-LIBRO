<!-- Agregar el menú -->
<?php require 'menu.php'; ?>

<main class="w3-content" style="max-width:400px">

    <!-- Crear el formulario -->
    <div class="w3-mobile w3-section">

        <!-- Encabezado del formulario -->
        <div class="w3-container w3-teal w3-hover-red">
            <h2>Cargar inventario</h2>
        </div>

        <?php if (isset($_GET['estado']) && is_string($_GET['estado'])) { ?>
            <div class="w3-panel <?php echo $_GET['estado'] === 'guardado' ? 'w3-pale-green' : 'w3-pale-red'; ?>">
                <?php echo $_GET['estado'] === 'guardado' ? 'El inventario se actualizó correctamente.' : 'No se pudo actualizar el inventario. Verifica el producto, la fecha y la cantidad.'; ?>
            </div>
        <?php } ?>

        <!-- Diseño del formulario -->
        <form class="w3-card" action="insertarMovimiento.php" method="post">

            <div class="w3-row-padding">

                <div class="w3-row-padding">
                    <label for="codpro" class="w3-label f-color-texto">
                        <b>Id del producto:</b>
                    </label>

                    <input class="w3-input w3-border fcolor-15"
                        type="number"
                        placeholder="Id producto"
                        id="codpro"
                        name="codpro"
                        min="1"
                        step="1"
                        oninput="mostrarProducto(this.value)"
                        required>
                </div>

                <div class="w3-row-padding">
                    <label for="nompro" class="w3-label f-color-texto">
                        <b>Producto:</b>
                    </label>

                    <input class="w3-input w3-border fcolor-15"
                        type="text"
                        id="nompro"
                        name="nompro"
                        placeholder="Nombre del producto">
                </div>

                <div class="w3-row-padding">
                    <label for="fechmovi" class="w3-label f-color-texto">
                        <b>Fecha:</b>
                    </label>

                    <input class="w3-input w3-border fcolor-15"
                        type="date"
                        id="fechmovi"
                        name="fechmovi"
                        required>
                </div>

                <div class="w3-row-padding">
                    <label for="cantpro" class="w3-label f-color-texto">
                        <b>Cantidad:</b>
                    </label>

                    <input class="w3-input w3-border fcolor-15"
                    type="number"
                    id="cantpro"
                    name="cantpro"
                    placeholder="Cantidad producto"
                    min="1"
                    step="1"
                    required>
                </div>

                <button class="w3-btn w3-blue-grey w3-section"
                        name="cguardar">
                    Guardar
                </button>

            </div>

        </form>

    </div>

</main>

<?php require 'pie_pagina.php'; ?>
