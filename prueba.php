<?php
require_once 'fclases.php';
$persona=new datospersona('100111','Daniel Perez','Dubai'); //Crear el objeto
echo $persona->get_codigo();
echo $persona->get_nombre();
echo $persona->get_direccion(); //Imprimir el codigo
