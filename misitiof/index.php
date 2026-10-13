<!-- Agregar el menu -->
<?php require 'menu.php'; ?>
<?php
require 'classProducto.php';
//$traerProductos = new datosProductos();
$listaProductos = datosProductos::consultarProductoTod();
?>
<main class="w3-row-padding w3-container ">
    <div class="w3-container fcolor-d2 ">
        <h2>Galeria de Libros</h2>
    </div>
    <div class="w3-row-padding w3-section w3-stretch">
        <?php
        foreach ($listaProductos as $producto1) { ?>
            <div class="w3-col s3 w3-row-padding">
                <img src="<?php echo 'imgfares/' . $producto1->imagen; ?>"
                style="width:100%" onclick="onClick(this)">
            </div>
        <?php } ?>
    </div>
    <div id="fdivimagen" class="w3-modal" onclick="this.style.display='none'">
        <span class="w3-button w3-hover-red w3-xlarge w3-display-topright"> &times;</span>
        <div class="w3-modal-content w3-animate-zoom">
            <img id="fimg" style="width:100%">
        </div>
    </div>
</main>
<script>
    function onClick(element) {
        document.getElementById("fimg").src = element.src;
        document.getElementById("fdivimagen").style.display = "block";
    }
</script>
<?php require 'pie_pagina.php'; ?>