<?php
require 'menu.php';
require 'paginacionf.php';
?>
<div class="w3-container w3-center">
    <div class="w3-bar fcolor-d2 " style="width: 80%;">
        <h2>Lista de clientes</h2>
    </div>
    <div class="w3-bar" style="width: 80%;">
        <table class="w3-table-all">
            <thead>
                <tr class="w3-light-grey w3-hover-red">
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Teléfono residencial</th>
                </tr>
            </thead>
            <?php foreach ($listaclientes as $cliente) { ?>
                <tr class="w3-hover-green">
                    <td><?php echo $cliente->idcli; ?></td>
                    <td><?php echo $cliente->nomcli; ?></td>
                    <td><?php echo $cliente->direccli; ?></td>
                    <td><?php echo $cliente->telres_cli; ?></td>
                </tr>
            <?php } ?>
        </table>
        <div class="w3-bar">
            <?php
            if ($pagina == 1) { ?>
                <a href="#" class="w3-bar-item w3-button w3-border w3-teal w3-disabled">&laquo;</a>
            <?php } else { ?>
                <a href="Clientespaginados.php?pagina= <?php echo $pagina - 1; ?>" class="w3-bar-item w3-button w3-border w3-teal">&laquo;</a>
            <?php } ?>
            <?php for ($i = 1; $i <= $numeropaginas; $i++) {
                if ($pagina == $i) {
            ?>
                    <a class="w3-bar-item w3-button w3-border w3-dark-grey" href="Clientespaginados.php?pagina= <?php echo $i; ?>"><?php echo $i; ?></a>
                <?php } else { ?>
                    <a class="w3-bar-item w3-button w3-border" href="Clientespaginados.php?pagina= <?php echo $i; ?>"><?php echo $i; ?></a>
            <?php
                }
            } ?>
            <?php
            if ($pagina == $numeropaginas) { ?>
                <a href="#" class="w3-bar-item w3-button w3-border w3-teal w3-disabled">&raquo;</a>
            <?php } else { ?>
                <a href="Clientespaginados.php?pagina= <?php echo $pagina + 1; ?>" class="w3-bar-item w3-button w3-border w3-teal">&raquo;</a>
            <?php } ?>
        </div>
    </div>
</div>