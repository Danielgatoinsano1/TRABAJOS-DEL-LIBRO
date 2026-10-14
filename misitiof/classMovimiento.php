<?php

require_once 'conexionf2.php';

class datos_Movimiento
{
    public function __construct(
        private $idmovimiento,
        private $idproducto,
        private $fechmovimiento,
        private $cantidadmov
    ) {
    }

    public function get_idmovimiento()
    {
        return $this->idmovimiento;
    }

    public function get_idproducto()
    {
        return $this->idproducto;
    }

    public function get_fechmovimiento()
    {
        return $this->fechmovimiento;
    }

    public function get_cantidadmov()
    {
        return $this->cantidadmov;
    }

    public function set_idmovimiento($idmovimiento)
    {
        $this->idmovimiento = $idmovimiento;
    }

    public function set_idproducto($idproducto)
    {
        $this->idproducto = $idproducto;
    }

    public function set_fechmovimiento($fechmovimiento)
    {
        $this->fechmovimiento = $fechmovimiento;
    }

    public function set_cantidadmov($cantidadmov)
    {
        $this->cantidadmov = $cantidadmov;
    }

    const TABLA = 'movimientos';

    public function guardarmov($stocActual)
    {
        $cantidadStock = (int) $this->cantidadmov;
        if ((int) $this->idproducto < 1 || $cantidadStock < 1 || !is_numeric($stocActual)) {
            throw new InvalidArgumentException('El producto y la cantidad del movimiento no son válidos.');
        }

        // Conectar con la base de datos
        $conexion = new Conexion();
        $conexion->beginTransaction();

        // Guardar el movimiento con consultas preparadas
        $consultaMovimiento = $conexion->prepare(
            'INSERT INTO ' . self::TABLA . '
            (id_producto, fecha_movimiento, cantidad_movi)
            VALUES (:id_producto, :fecha_movimiento, :cantidad)'
        );
        $consultaMovimiento->execute([
            ':id_producto' => $this->idproducto,
            ':fecha_movimiento' => $this->fechmovimiento,
            ':cantidad' => $cantidadStock,
        ]);

        $consultaStock = $conexion->prepare(
            'UPDATE inventario SET stock = stock + :cantidad WHERE Codigo = :codigo'
        );
        $consultaStock->execute([
            ':cantidad' => $cantidadStock,
            ':codigo' => $this->idproducto,
        ]);
        if ($consultaStock->rowCount() !== 1) {
            throw new RuntimeException('El inventario no se pudo actualizar para ese producto.');
        }

        $conexion->commit();

        $conexion = null; // Cerrar conexión
    }
}
