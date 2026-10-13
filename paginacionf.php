<?php

require 'manipularcli.php';

/* Almacenar en $pagina el valor de la variable página como entero, pero
si el valor es menor de 1 almacenar 1 */
$pagina = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;

$cantRegistros = 3; // Cantidad de registros a mostrar por página

$totalregistros = modificarCliente::totalRegistros();
$numeropaginas = max(1, (int)ceil($totalregistros / $cantRegistros));

// Evitar que una página inexistente muestre la tabla vacía.
$pagina = min($pagina, $numeropaginas);

/* Si el valor de la variable $pagina es mayor que 1, almacenar
(($pagina * $cantRegistros) - $cantRegistros), de lo contrario almacenar 0 */
$inicio = ($pagina > 1) ? (($pagina * $cantRegistros) - $cantRegistros) : 0;

$listaClientes = modificarCliente::limitRegistros($inicio, $cantRegistros);