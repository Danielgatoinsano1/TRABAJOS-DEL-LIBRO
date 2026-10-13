<?php
require_once 'conexionf2.php';
class datos_movfactura
{
    public function __construct(
        private $nofactura,
        private $codclientefact,
        private $subtotalfact,
        private $impuestofact,
        private $grantotalfact
    ) {
    }
    //Consultar producto por codigo
    public static function obtenerultimafactura()
    {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT MAX(nofactura) as factura FROM controlfactura');
        $consulta->execute();
        $registros = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $registros;
    }
}