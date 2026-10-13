<?php
require_once 'conexionf2.php';

//Declarar variables
$facnum = "";
$codclientef = "";
$impuestof = "";
$grantotalfac = "";
$subtotalfact = "";
$contador = 0;

$tablamovfact = 'movimientofactura';
//Funcion para escapar los datos
function filtrofares($dat_fares)
{
    $datos = trim($dat_fares); //Elimina espacios antes y despues de los datos
    $datos = stripslashes($dat_fares); // Elimina backslashes "\"
    $datos = htmlspecialchars($dat_fares); // Traduce caracteres especiales en entidades HTML
    return $datos;
}
//Comprobar si los datos se pasaron a traves del metodo POST
if (isset($_POST["guarfact"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    //Si la factura no esta vacia entonces
    if (!empty($_POST["numfacturar"])) {
        /*Almacenar en la variable $vcodigo el valor del codigo que ingreso el usuario ya filtrado*/
        $facnum = filtrofares($_POST["numfacturar"]);
        session_start();
        $_SESSION['facturan']  =  $facnum;
    }
    if (!empty($_POST["cod_cliente"])) {
        $codclientef = filtrofares($_POST["cod_cliente"]);
    }
    if (!empty($_POST["impuestofact"])) {
        $impuestof = filtrofares($_POST["impuestofact"]);
    }
    if (!empty($_POST["todpagarfact"])) {
        $grantotalfac = filtrofares($_POST["todpagarfact"]);
    }
    if (!empty($_POST["sutotalfact"])) {
        $subtotalfact = filtrofares($_POST["sutotalfact"]);
    }
    //Variables para extraer los productos facturados
    $vidproducto = $_POST["Id_Producto"];
    $vCantidad = $_POST["Cantidad"];
    $vPrecio = $_POST["Precio"];
    $vTotal = $_POST["Total"];

    $conexion = new Conexion(); //Conectar con la base de datos
    $conexion->beginTransaction(); //Iniciar la transaccion
    //Preparar la consulta
    for ($i  =  0; $i  <  sizeof($vidproducto);  $i++)  {
        $sqlInsertItem = "INSERT INTO " . $tablamovfact . "(facturano, clienteid,
        productoid, cantfact, precifact, totalfact) VALUES (" . $facnum . ", " .
        $codclientef . ", " . $vidproducto[$i] . ", " . $vCantidad[$i] . ", " .
        $vPrecio[$i] . ", " . $vTotal[$i] . ")";
        $conexion->exec($sqlInsertItem);
    }
    $consulta = "INSERT INTO controlfactura (nofactura, codclientefact, subtotalfact,
    impuestofact, grantotalfact) VALUES("  .  $facnum  .  ",  "  . $codclientef  .
    ", " . $subtotalfact . ", " . $impuestof . ", " . $grantotalfac . ")";

    $conexion->exec($consulta); //Agregar la consulta
    if ($conexion->commit()) { //Si se guardaron los datos correctamente
        header('Location: mostrarfactura.php'); //Cargar el archivo mostrarfactura.php
    } else {
        $conexion->rollBack(); //Deshacer los cambios
    } 
}