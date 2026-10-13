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
        $cantidad = filter_var($this->cantidadmov, FILTER_VALIDATE_INT);
        $producto = filter_var($this->idproducto, FILTER_VALIDATE_INT);
        if ($cantidad === false || $cantidad < 1 || $producto === false || $producto < 1) {
            throw new InvalidArgumentException('Producto y cantidad deben ser valores válidos.');
        }
        $conexion = new Conexion();
        try {
            $conexion->beginTransaction();
            $insertar = $conexion->prepare('INSERT INTO movimientos (id_producto, fecha_movimiento, cantidad_movi) VALUES (:producto, :fecha, :cantidad)');
            $insertar->execute([':producto' => $producto, ':fecha' => $this->fechmovimiento ?: date('Y-m-d'), ':cantidad' => $cantidad]);
            $actualizar = $conexion->prepare('UPDATE inventario SET stock = stock + :cantidad WHERE Codigo = :producto');
            $actualizar->execute([':cantidad' => $cantidad, ':producto' => $producto]);
            if ($actualizar->rowCount() !== 1) {
                throw new RuntimeException('El producto no existe en el inventario.');
            }
            $conexion->commit();
            return true;
        } catch (Throwable $error) {
            if ($conexion->inTransaction()) $conexion->rollBack();
            throw $error;
        }
    }
}
