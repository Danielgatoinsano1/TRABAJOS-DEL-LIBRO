<?php
require_once 'fclases.php';
$persona= new datospersona('0301199901942', ' Hector Maldonado ', 'New York');
echo $persona-> get_codigo(); echo $persona-> get_nombre(); echo $persona-> get_direccion();