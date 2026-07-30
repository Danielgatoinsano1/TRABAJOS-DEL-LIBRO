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
                    type="tel"
                    id="cemail"
                    name="cemail"
                    placeholder="Correo electrónico">
            </div>

            <div class="w3-container">
                <button class="w3-btn w3-blue-grey w3-section"
                        name="cguardar">
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

            //Crear objeto con todos los datos del cliente
            $listaclientes = modificarcliente::ConsultarClientes();

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
</div>

</main>


<?php require 'pie_pagina.php'; ?>
