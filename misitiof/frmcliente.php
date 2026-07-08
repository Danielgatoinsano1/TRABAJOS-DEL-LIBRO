<!-- Agregar el menú -->
<?php require 'menu.php'; ?>

<main class="w3-row-padding w3-container">

    <!-- Crear el formulario -->
    <div class="w3-col s6 w3-mobile w3-section">

        <!-- Encabezado del formulario -->
        <div class="w3-container fcolor-d2">
            <h2>Ingresar datos del cliente</h2>
        </div>

        <!-- Diseño del formulario -->
        <form class="w3-card" action="guardarcli.php" method="post">

            <div class="w3-row-padding">
                <div class="w3-third">
                    <label for="ccod" class="w3-label f-color-texto"><b>Código</b></label>
                    <input class="w3-input w3-border fcolor-15"
                        type="text"
                        placeholder="id del cliente"
                        id="ccod"
                        name="ccodigo"
                        required
                        autofocus>
                </div>

                <div class="w3-twothird">
                    <label for="nalum" class="w3-label f-color-texto"><b>Nombre</b></label>
                    <input class="w3-input w3-border fcolor-15"
                        type="text"
                        id="nalum"
                        name="cnomcliente"
                        placeholder="Nombre del cliente"
                        required>
                </div>
            </div>

            <div class="w3-row-padding">
                <label for="cdirec" class="w3-label f-color-texto"><b>Dirección</b></label>
                <textarea class="w3-input w3-border fcolor-15"
                        id="cdirec"
                        name="cdireccion"
                        placeholder="Dirección"></textarea>
            </div>

            <div class="w3-half">
                <label for="ctel" class="w3-label f-color-texto"><b>Teléfono residencial</b></label>
                <input class="w3-input w3-border fcolor-15"
                    type="tel"
                    id="ctel"
                    name="ctelcasa"
                    placeholder="Teléfono residencial"
                    required>
            </div>

            <div class="w3-half">
                <label for="ccel" class="w3-label f-color-texto"><b>Celular</b></label>
                <input class="w3-input w3-border fcolor-15"
                    type="tel"
                    id="ccel"
                    name="ccelular"
                    placeholder="Teléfono celular">
            </div>

            <div class="w3-row-padding">
                <label for="cemail" class="w3-label f-color-texto"><b>Email</b></label>
                <input class="w3-input w3-border fcolor-15"
                    type="tel"
                    id="cemail"
                    name="cemail"
                    placeholder="Correo electrónico">
            </div>

            <button class="w3-btn w3-blue-grey w3-section"
                    name="cguardar">
                Guardar
            </button>

        </form>

    </div>

</main>

<?php require 'pie_pagina.php'; ?>
