<?php

require_once 'conexionf2.php';
require_once 'fclases.php';

class modificarcliente extends datospersona
{
    const TABLA = 'clientes';

    public function guardar()
    {
        $conexion = new Conexion();

        //Preparar la consulta
        $consulta = $conexion->prepare(
            'INSERT INTO ' . self::TABLA .
            ' (nomcli, direcli, telres_cli, telcel_cli, email_cli)
            VALUES(:nombre, :direccion, :telresidencial, :telcelular, :email)'
        );

        //Asignar los valores
        $consulta->bindParam(':nombre', $this->dnombre);
        $consulta->bindParam(':direccion', $this->ddireccion);
        $consulta->bindParam(':telresidencial', $this->dtelresi);
        $consulta->bindParam(':telcelular', $this->dtelcel);
        $consulta->bindParam(':email', $this->demail);

        $consulta->execute(); //Ejecutar la consulta
        $conexion = null; //Cerrar conexión
    }
public static function ConsultarClientes()
{
    $conexion = new Conexion();

    $consulta = $conexion->prepare(
        'SELECT idcli, nomcli FROM ' . self::TABLA .
        ' ORDER BY nomcli'
    );

    $consulta->execute();

    $registros = $consulta->fetchAll(PDO::FETCH_OBJ);

    return $registros;
}
public function ConsultarClientesId()
{
    $conexion = new Conexion();

    $consulta = $conexion->prepare(
        'SELECT * FROM ' . self::TABLA . '
         WHERE idcli = :codcli'
    );

    $consulta->bindParam(':codcli', $this->dcodigo);
    $consulta->execute();

    $registros = $consulta->fetchAll(PDO::FETCH_OBJ);

    $conexion = null;

    return $registros;
}

public function actualizar()
{
    $conexion = new Conexion();

    $consulta = $conexion->prepare(
        'UPDATE ' . self::TABLA . '
        SET nomcli = :nombre,
            direccli = :direccion,
            telres_cli = :telresidencial,
            telcel_cli = :telcelular,
            email_cli = :email
        WHERE idcli = :codcli'
    );

    $consulta->bindParam(':nombre', $this->dnombre);
    $consulta->bindParam(':direccion', $this->ddireccion);
    $consulta->bindParam(':telresidencial', $this->dtelresi);
    $consulta->bindParam(':telcelular', $this->dtelcel);
    $consulta->bindParam(':email', $this->demail);
    $consulta->bindParam(':codcli', $this->dcodigo);

    $consulta->execute();

    $conexion = null;

}
public function eliminarCliente()
{
    $conexion = new Conexion ();
    //Preparar la Consulta
    $consulta = $conexion->prepare('DELETE FROM ' . self::TABLA .' where idcli = :codcli');
    //Asignar los valores
    $consulta->bindParam(':codcli', $this->dcodigo);
    $consulta->execute(); //Ejecutar la consulta
    $conexion = null; //Cerrar conexion
}
}
