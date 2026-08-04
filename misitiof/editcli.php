<?php require 'menu.php'; ?> <!-- Agregar el menú -->
<?php require_once 'ConsultarCliente.php'; ?>

<main class="w3-row-padding w3-container">

    <!-- Crear el formulario -->
    <div class="w3-mobile w3-section" style="width: 80%; margin: auto;">

        <!-- Encabezado del formulario -->
        <div class="w3-container w3-teal">
            <h2>Editar datos del cliente</h2>
        </div>

        <!-- Diseño del formulario -->
        <form class="w3-card" action="actualizarcli.php" method="post">

            <div class="w3-row-padding">

                <div class="w3-third">
                    <label for="ccod" class="w3-label f-color-texto">
                        <b>Código</b>
                    </label>

                    <input
                        class="w3-input w3-border fcolor-15"
                        type="text"
                        placeholder="Id del cliente"
                        id="ccod"
                        name="ccodigo"
                        value="<?php echo $codid; ?>"
                        required
                        readonly
                    >
                </div>

                <div class="w3-twothird">
                    <label for="nalum" class="w3-label f-color-texto">
                        <b>Nombre</b>
                    </label>

                    <input
                        class="w3-input w3-border fcolor-15"
                        type="text"
                        id="nalum"
                        name="cnomcliente"
                        placeholder="Nombre del cliente"
                        value="<?php echo $nombreCli; ?>"
                        required
                        autofocus
                    >
                </div>

            </div>

            <div class="w3-row-padding">
                <label for="cdirec" class="w3-label f-color-texto">
                    <b>Dirección</b>
                </label>

                <textarea
                    class="w3-input w3-border fcolor-15"
                    id="cdirec"
                    name="cdireccion"
                    placeholder="Dirección"
                ><?php echo $direccioncli; ?></textarea>
            </div>

            <div class="w3-half">
                <label for="ctel" class="w3-label f-color-texto">
                    <b>Teléfono residencial</b>
                </label>

                <input
                    class="w3-input w3-border fcolor-15"
                    type="tel"
                    id="ctel"
                    name="ctelcasa"
                    placeholder="Teléfono residencial"
                    value="<?php echo $telefonosres; ?>"
                    required
                >
            </div>

            <div class="w3-half">
                <label for="ccel" class="w3-label f-color-texto">
                    <b>Celular</b>
                </label>

                <input
                    class="w3-input w3-border fcolor-15"
                    type="tel"
                    id="ccel"
                    name="ccelular"
                    placeholder="Teléfono celular"
                    value="<?php echo $telefonocel; ?>"
                >
            </div>

            <div class="w3-row-padding">
                <label for="cemail" class="w3-label f-color-texto">
                    <b>Email</b>
                </label>

                <input
                    class="w3-input w3-border fcolor-15"
                    type="email"
                    id="cemail"
                    name="cemail"
                    placeholder="Correo electrónico"
                    value="<?php echo $correocli; ?>"
                >
            </div>

            <button
                class="w3-btn w3-blue-grey w3-section"
                name="cactualizar"
            >
                Actualizar cliente
            </button>

        </form>

    </div>

</main>

<?php require 'pie_pagina.php'; ?>