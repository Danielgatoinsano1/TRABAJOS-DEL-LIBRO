<?php
require_once 'conexionf2.php';

class datos_movfactura
{
    public static function obtenerultimafactura(): array
    {
        $conexion = new Conexion();
        $consulta = $conexion->query('SELECT MAX(nofactura) AS factura FROM controlfactura');
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }
}
