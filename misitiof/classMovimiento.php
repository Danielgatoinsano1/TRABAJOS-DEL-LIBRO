<?php
require_once 'conexionf2.php';
class datos_Movimiento
{
    public function __construct(
        private $idmovimiento,
        private $idproducto,
        private $fechmovimiento,
        private $cantidadmov
    ){
    }
    public function get_idmovimiento() {
        return $this->idmovimiento;
    }
    public function get_idproducto() {
        return $this->idproducto;
    }
    public function get_fechmovimiento() {
        return $this->fechmovimiento;
    }
    public function get_cantidadmov() {
        return $this->cantidadmov;
    }
    public function set_idmovimiento($idmovimiento) {
        $this->idmovimiento = $idmovimiento;
    }
    public function set_idproducto($idproducto) {
        $this->idproducto = $idproducto;
    }
    public function set_fechmovimiento($fechmovimiento) {
        $this->fechmovimiento = $fechmovimiento;
    }
    public function set_cantidadmov($cantidadmov) {
        $this->cantidadmov = $cantidadmov;
    }

    const TABLA = 'movimientos';
    public function guardarmov($stocActual) {
        $cantidadStock = (int) $this->cantidadmov;
        $nuevo_stock = 0;
        if (isset($cantidadStock, $stocActual)) {
            $nuevo_stock = $stocActual + $cantidadStock; //Calcular el nuevo stock
        } else {
            exit;
        }
        //Conectar con la base de datos
        $conexion = new Conexion();
        $conexion->beginTransaction();
        //Preparar la consulta
        $conexion->exec('INSERT INTO movimientos (id_producto, cantidad_movi) VALUES(' . $this->idproducto . ',' . $this->cantidadmov . ')');
        $conexion->exec('UPDATE ' . 'inventario' . ' SET stock = ' . $nuevo_stock . ' where codigo = ' . $this->idproducto);
        if ($conexion->commit()) { //Si se guardaron los datos correctamente
            echo "datos guardados con exito"; //Mostrar mensaje
        } else {
            $conexion->rollBack(); //Rehacer los cambios
            echo "imposible guardar los datos";
        }
        $conexion = null; //Cerrar conexion
    }
}