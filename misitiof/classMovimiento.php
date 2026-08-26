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
        $nuevo_stock = 0;

        if (isset($cantidadStock, $stocActual)) {
            // Calcular el nuevo stock
            $nuevo_stock = $stocActual + $cantidadStock;
        } else {
            exit;
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
            'UPDATE inventario SET stock = :stock WHERE Codigo = :codigo'
        );
        $consultaStock->execute([
            ':stock' => $nuevo_stock,
            ':codigo' => $this->idproducto,
        ]);

        // Si se guardaron los datos correctamente
        if ($conexion->commit()) {
            echo "datos guardados con éxito"; // Mostrar mensaje
        } else {
            $conexion->rollBack(); // Rehacer los cambios
            echo "imposible guardar los datos";
        }

        $conexion = null; // Cerrar conexión
    }
}