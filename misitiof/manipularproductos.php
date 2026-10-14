<?php

require_once 'conexionf.php';

class modificarProducto
{
    private $codigo;
    private $nombre;
    private $costo;
    private $porcentajeVenta;
    private $precioVenta;
    private $fecha;
    private $imagen;

    public function __construct($codigo, $nombre = null, $costo = null, $porcentajeVenta = null, $precioVenta = null, $fecha = null, $imagen = null)
    {
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->costo = $costo;
        $this->porcentajeVenta = $porcentajeVenta;
        $this->precioVenta = $precioVenta;
        $this->fecha = $fecha;
        $this->imagen = $imagen;
    }

    public function guardar()
    {
        $conexion = conect();
        $consulta = $conexion->prepare(
            'INSERT INTO inventario
             (Codigo, nom_producto, costo, porc_venta, precio_venta, fecha, imagen, stock)
             VALUES (:codigo, :nombre, :costo, :porcentaje, :precio, :fecha, :imagen, 0)'
        );
        $consulta->execute([
            ':codigo' => $this->codigo,
            ':nombre' => $this->nombre,
            ':costo' => $this->costo,
            ':porcentaje' => $this->porcentajeVenta,
            ':precio' => $this->precioVenta,
            ':fecha' => $this->fecha,
            ':imagen' => $this->imagen,
        ]);
    }

    public function consultarPorCodigo()
    {
        $conexion = conect();
        $consulta = $conexion->prepare('SELECT * FROM inventario WHERE Codigo = :codigo');
        $consulta->execute([':codigo' => $this->codigo]);
        return $consulta->fetch(PDO::FETCH_OBJ);
    }

    public function actualizar($cambiarImagen = false)
    {
        $conexion = conect();
        $sql = 'UPDATE inventario SET
                    nom_producto = :nombre,
                    costo = :costo,
                    porc_venta = :porcentaje,
                    precio_venta = :precio,
                    fecha = :fecha';

        if ($cambiarImagen) {
            $sql .= ', imagen = :imagen';
        }

        $sql .= ' WHERE Codigo = :codigo';
        $consulta = $conexion->prepare($sql);
        $datos = [
            ':codigo' => $this->codigo,
            ':nombre' => $this->nombre,
            ':costo' => $this->costo,
            ':porcentaje' => $this->porcentajeVenta,
            ':precio' => $this->precioVenta,
            ':fecha' => $this->fecha,
        ];

        if ($cambiarImagen) {
            $datos[':imagen'] = $this->imagen;
        }

        $consulta->execute($datos);
    }

    public function eliminar()
    {
        $conexion = conect();
        $consulta = $conexion->prepare('DELETE FROM inventario WHERE Codigo = :codigo');
        $consulta->execute([':codigo' => $this->codigo]);
    }

    public static function totalRegistros()
    {
        $conexion = conect();
        return (int) $conexion->query('SELECT COUNT(*) FROM inventario')->fetchColumn();
    }

    public static function limitarRegistros($inicio, $cantidad)
    {
        $conexion = conect();
        $consulta = $conexion->prepare(
            'SELECT * FROM inventario ORDER BY nom_producto LIMIT :inicio, :cantidad'
        );
        $consulta->bindValue(':inicio', (int) $inicio, PDO::PARAM_INT);
        $consulta->bindValue(':cantidad', (int) $cantidad, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_OBJ);
    }
}
