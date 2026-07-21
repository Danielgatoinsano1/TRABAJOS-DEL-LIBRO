<?php
require_once 'fclases.php';
$persona=new datospersona('100111','Daniel Perez','Dubai'); //Crear el objeto
echo $persona->minombre();
//Imprimir el nombre

