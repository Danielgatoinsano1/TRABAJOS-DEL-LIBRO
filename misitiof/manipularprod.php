<?php
require_once 'conexionf.php';

class modificarproducto {

    public static function totalRegistros() {
        $conexion = conect();
        $stmt = $conexion->query("SELECT COUNT(*) FROM inventario");
        return $stmt->fetchColumn();
    }

    public static function limitRegistros($inicio, $cantRegistros) {
        $conexion = conect();
        $stmt = $conexion->prepare("SELECT * FROM inventario LIMIT :inicio, :cant");
        $stmt->bindValue(':inicio', (int)$inicio, PDO::PARAM_INT);
        $stmt->bindValue(':cant', (int)$cantRegistros, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>