<?php
function conect()
{
$conexion=null;
$nom_servidor="localhost";
$username="root";
$password="";



try{


$conexion=new PDO("mysql:host=$nom_servidor;dbname=sistem_fares;charset=UTF8",
$username,$password,array(
    PDO::ATTR_EMULATE_PREPARES=> false,
    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
));
return $conexion;
}
catch(PDOException $e){

echo $e->getMessage();
return null;
}
 }


?>