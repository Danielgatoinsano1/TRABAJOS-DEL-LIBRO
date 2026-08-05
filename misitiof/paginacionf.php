<?php

require 'manipularcli.php';

/* Almacenar en $pagina el valor de la variable página como entero, pero
si el valor es menor de 1 almacenar 1 */
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

$cantRegistros = 5; // Cantidad de registros a mostrar

/* Si el valor de la variable $pagina es mayor que 1, almacenar
(($pagina * $cantRegistros) - $cantRegistros), de lo contrario almacenar 0 */
$inicio = ($pagina > 1) ? (($pagina * $cantRegistros) - $cantRegistros) : 0;

$totalregistros = modificarCliente::totalRegistros();

$listaClientes = modificarCliente::limitRegistros($inicio, $cantRegistros);

$numeropaginas = ceil($totalregistros / $cantRegistros);