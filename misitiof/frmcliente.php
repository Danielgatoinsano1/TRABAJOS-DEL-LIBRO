<!-- Agregar el menú -->
<?php require 'menu.php'; ?>

<main class="w3-row-padding w3-container">

    <?php if (isset($_GET['estado']) && $_GET['estado'] === 'codigo_existe') { ?>
        <div class="w3-panel w3-red">
            <p>Ese código ya existe. Escribe un código diferente.</p>
        </div>
    <?php } elseif (isset($_GET['estado']) && $_GET['estado'] === 'error') { ?>
        <div class="w3-panel w3-red">
            <p>No se pudo guardar el cliente. Revisa los datos e inténtalo nuevamente.</p>
        </div>
    <?php } ?>

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
                        type="number"
                        placeholder="Escribe el código"
                        id="ccod"
                        name="ccodigo"
                        min="1"
                        step="1"
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

            <div class="w3-row-padding">
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
            </div>

            <div class="w3-row-padding">
                <label for="cemail" class="w3-label f-color-texto"><b>Email</b></label>
                <input class="w3-input w3-border fcolor-15"
                    type="email"
                    id="cemail"
                    name="cemail"
                    placeholder="Correo electrónico">
            </div>

            <div class="w3-container">
                <button class="w3-btn w3-blue-grey w3-section"
                        type="submit"
                        name="cguardar"
                        value="1">
                        Guardar
                </button>
                
            </div>

        </form>

    </div>
    
    <div class="w3-col s6 w3-mobile w3-section">
    <table class="w3-table w3-table-all w3-hoverable w3-striped">
        <thead> <!-- Encabezado de la tabla -->
            <tr class="fcolor-11">
                <th>Código</th>
                <th>Nombre</th>
                <th>Acción</th>
            </tr>
        </thead>

        <tbody>
            <?php

            require_once 'manipularcli.php';

            $pagina = isset($_GET['pagina']) ? max(1, (int) $_GET['pagina']) : 1;
            $cantRegistros = 5;
            $totalregistros = (int) modificarcliente::totalRegistros();
            $numeropaginas = max(1, (int) ceil($totalregistros / $cantRegistros));
            $pagina = min($pagina, $numeropaginas);
            $inicio = ($pagina - 1) * $cantRegistros;

            // Mostrar únicamente los cinco clientes correspondientes a la página actual
            $listaclientes = modificarcliente::limitRegistros($inicio, $cantRegistros);

            foreach ($listaclientes as $cliente) { ?>

                <tr>
                    <!-- Mostrar el id del alumno que esta dentro de $cliente -->
                    <td><?php echo $cliente->idcli; ?></td>

                    <!-- Mostrar el nombre del alumno que esta dentro de $cliente -->
                    <td><?php echo $cliente->nomcli; ?></td>

                    <td>
                        <!-- Pasar el id al archivo editcli.php cuando se dé clic
                        en el botón Editar -->
                        <a href="editcli.php?idcli=<?php echo $cliente->idcli ?>"
                        class="w3-btn w3-teal">

                            <!-- Insertar un icono de editar -->
                            <i class="fas fa-edit"></i>
                        </a>

                        <!-- Pasar el id al archivo eliminacli.php cuando se dé
                        clic en el botón Eliminar -->
                        <a href="eliminacli.php?id=<?php echo $cliente->idcli ?>"
                        class="w3-btn w3-red">

                            <!-- Insertar un icono de eliminar -->
                            <i class="fas fa-user-times"></i>
                        </a>
                    </td>
                </tr>

            <?php
            } //Cerrar el foreach
            ?>

        </tbody> <!-- Cerrar el cuerpo de la tabla -->
    </table> <!-- Cerrar la tabla -->

    <div class="w3-center w3-section">
        <div class="w3-bar">
            <?php if ($pagina > 1) { ?>
                <a class="w3-bar-item w3-button w3-border w3-teal"
                   href="frmcliente.php?pagina=<?php echo $pagina - 1; ?>">&laquo;</a>
            <?php } else { ?>
                <span class="w3-bar-item w3-button w3-border w3-teal w3-disabled">&laquo;</span>
            <?php } ?>

            <?php for ($i = 1; $i <= $numeropaginas; $i++) { ?>
                <a class="w3-bar-item w3-button w3-border<?php echo $pagina == $i ? ' w3-dark-grey' : ''; ?>"
                   href="frmcliente.php?pagina=<?php echo $i; ?>">
                    <?php echo $i; ?>
                </a>
            <?php } ?>

            <?php if ($pagina < $numeropaginas) { ?>
                <a class="w3-bar-item w3-button w3-border w3-teal"
                   href="frmcliente.php?pagina=<?php echo $pagina + 1; ?>">&raquo;</a>
            <?php } else { ?>
                <span class="w3-bar-item w3-button w3-border w3-teal w3-disabled">&raquo;</span>
            <?php } ?>
        </div>
    </div>
</div>

</main>


<?php require 'pie_pagina.php'; ?>
