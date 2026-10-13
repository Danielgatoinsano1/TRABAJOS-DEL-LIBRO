<?php
function conect()
{
    //Declarar y asignar valor a las variables
    $conexion=null;
    $nom_servidor="localhost";
    $username="root";
    $password="";
    try {
        //Realizar la conexion con la base de datos
        $conexion = new PDO("mysql:host=$nom_servidor;dbname=sistem_fares;charset=utf8mb4",
        $username, $password, array(
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ));
        return$conexion; //Devolver la conexion a la funcion
    }catch(PDOException$e) {
        echo$e->getMessage();//Mostrar mensaje de error devuelto por la excepcion
        return null; // Devolver null (vacion) a la funcion
    }
}
