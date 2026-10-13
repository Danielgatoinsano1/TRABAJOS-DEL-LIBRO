<?php
require_once 'manipularcli.php'; //Llamar el archivo manipularcli
//Declar variables
$vcodigo="";
$vnombre="";
$vdireccion="";
$vtelresi="";
$vtelcel="";
$vemail="";

//Funcion para escapar los datos
function filtrofares($dat_fares)
{
    $datos=trim($dat_fares); //Elimina espacios antes y despues de los datos
    $datos=stripslashes($dat_fares); //Elimina backslashes "\"
    $datos=htmlspecialchars($dat_fares); //Traduce caracteres especiales en entidades HTML
    return $datos;
}
//Comprobar si los datos se pasaron a traves del metodo POST
if(isset($_POST["cguardar"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    //Si el codigo no esta vacio entonces
    if(!empty($_POST["ccodigo"])) {
        /*Almacenar en la variable $vcodigo el valor del codigo
        que ingreso el usuario ya filtrado*/
        $vcodigo=filtrofares($_POST["ccodigo"]);
    }
    if (!empty($_POST["cnomcliente"])) {
        $vnombre=filtrofares($_POST["cnomcliente"]);
    }
    if (!empty($_POST["cdireccion"])) {
        $vdireccion=filtrofares($_POST["cdireccion"]);
    }
    if (!empty($_POST["ctelcasa"])) {
        $vtelresi=filtrofares($_POST["ctelcasa"]);
    }
    if (!empty($_POST["ccelular"])) {
        $vtelcel=filtrofares($_POST["ccelular"]);
    }
    if (!empty($_POST["cemail"])) {
        $vemail=filtrofares($_POST["cemail"]);
    }
    //Crear objeto y pasar los datos por parametros
    $guardarcliente  =  new  modificarcliente(null,  $vnombre,  $vdireccion,
      $vtelresi,  $vtelcel,  $vemail);
    $guardarcliente->guardar();
}
header('Location: frmcliente.php'); //Llamar a la pagina frmcliente.php
die();