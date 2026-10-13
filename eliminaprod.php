<?php
include("conexionf.php");
$conexion = conect();

if (isset($_GET['codigo'])) {
    $codigo = $_GET['codigo'];

    $stmt = $conexion->prepare("DELETE FROM inventario WHERE codigo = :codigo");
    
    if ($stmt->execute([':codigo' => $codigo])) {
        header("Location: productospaginados.php");
        exit();
    } else {
        echo "Error al eliminar el registro.";
    }
}
?>