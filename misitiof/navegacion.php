<nav class="w3-bar fcolor-l4" aria-label="Navegación principal">
    <a href="index.php" class="w3-bar-item w3-button w3-mobile">Principal</a>
    <div class="w3-dropdown-click w3-mobile">
        <button class="w3-button" type="button" aria-controls="menuInventario"
            aria-expanded="false"
            onclick="const menu = this.nextElementSibling; const abrir = !menu.classList.contains('w3-show'); menu.classList.toggle('w3-show', abrir); this.setAttribute('aria-expanded', String(abrir))">Inventario</button>
        <div id="menuInventario" class="w3-dropdown-content w3-bar-block ftema">
            <a href="cproductos.php" class="w3-bar-item w3-button">Crear producto</a>
            <a href="Productospaginados.php" class="w3-bar-item w3-button">Consultar y modificar productos</a>
            <a href="frmcliente.php" class="w3-bar-item w3-button">Clientes</a>
            <a href="frmMovimiento.php" class="w3-bar-item w3-button">Agregar inventario</a>
            <a href="frmFactura.php" class="w3-bar-item w3-button">Facturar</a>
            <a href="index.php" class="w3-bar-item w3-button">Información de libros</a>
            <a href="frmLibros.php#comentario" class="w3-bar-item w3-button">Comentarios de libros</a>
        </div>
    </div>
    <div class="w3-dropdown-click w3-mobile">
        <button class="w3-button" type="button" aria-controls="menuLibros"
            aria-expanded="false"
            onclick="const menu = this.nextElementSibling; const abrir = !menu.classList.contains('w3-show'); menu.classList.toggle('w3-show', abrir); this.setAttribute('aria-expanded', String(abrir))">Libros</button>
        <div id="menuLibros" class="w3-dropdown-content w3-bar-block ftema">
            <a href="libroscategoria.php?categoria=<?php echo rawurlencode('Educación Básica'); ?>" class="w3-bar-item w3-button">Educación Básica</a>
            <a href="libroscategoria.php?categoria=<?php echo rawurlencode('I BTP y I BCH'); ?>" class="w3-bar-item w3-button">I BTP y I BCH</a>
            <a href="libroscategoria.php?categoria=<?php echo rawurlencode('II BTP'); ?>" class="w3-bar-item w3-button">II BTP</a>
            <a href="libroscategoria.php?categoria=<?php echo rawurlencode('III BTP'); ?>" class="w3-bar-item w3-button">III BTP</a>
        </div>
    </div>
    <a href="mailto:edicionesfares@edicionesfares.com" class="w3-bar-item w3-button w3-mobile">Contacto</a>
</nav>
