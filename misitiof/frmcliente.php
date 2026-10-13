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
        <label><b>Nombre</b></label>
        <input class="w3-input w3-border fcolor-l5" type="text"
               name="cnomcliente" required>
    </div>

    <div class="w3-row-padding">
        <label><b>Dirección</b></label>
        <textarea class="w3-input w3-border fcolor-l5"
                  name="cdireccion"></textarea>
    </div>

    <div class="w3-row-padding">

        <div class="w3-half">
            <label><b>Teléfono residencial</b></label>
            <input class="w3-input w3-border fcolor-l5"
                   type="tel" name="ctelcasa">
        </div>

        <div class="w3-half">
            <label><b>Celular</b></label>
            <input class="w3-input w3-border fcolor-l5"
                   type="tel" name="ccelular">
        </div>

    </div>

    <div class="w3-row-padding">
        <label><b>Email</b></label>
        <input class="w3-input w3-border fcolor-l5"
               type="email" name="cemail">
    </div>

    <button class="w3-btn w3-blue-grey w3-section"
            name="cguardar">
        Guardar
    </button>

</form>

    </div>
    <div class="w3-col s6 w3-mobile w3-section">
        <table class="w3-table w3-table-all w3-hoverable w3-striped">
            <thead>
                <tr class="fcolorl1">
                    <th>Codigo</th>
                    <th>Nombre</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                require_once 'manipularcli.php';
                // Crear objeto con todos los datos del cliente
                $listaclientes = modificarcliente::ConsultarClientes();
                foreach ($listaclientes as $cliente) { ?>
                <tr>
                    <!-- Mostrar el id del alumno que está dentro de $cliente -->
                    <td> <?php echo $cliente->idcli; ?></td>
                    <!-- Mostrar el nombre del alumno que está dentro de $cliente -->
                    <td> <?php echo $cliente->nomcli; ?></td>
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
                        <a href="eliminacli.php?idcli=<?php echo $cliente->idcli ?>"
                            class="w3-btn w3-red">
                            <!-- Insertar un icono de eliminar -->
                            <i class="fas fa-user-times"></i>
                        </a>
                    </td>
                </tr>
                <?php
                    }   // Cerrar el foreach
                ?>
            </tbody>
        </table>
    </div>

</main>

<?php require 'pie_pagina.php'; ?>