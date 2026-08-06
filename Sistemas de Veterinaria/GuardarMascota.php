<?php

require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/Mascota.php';

class GuardarMascota extends Conexion
{
    public function guardar(Mascota $mascota): bool
    {
        $sql = 'INSERT INTO Mascotas
                (nombre, especie, raza, edad, peso_actual, color_senas, responsable, telefono_emergencia)
                VALUES
                (:nombre, :especie, :raza, :edad, :peso_actual, :color_senas, :responsable, :telefono_emergencia)';

        try {
            $consulta = $this->conexion->prepare($sql);

            return $consulta->execute([
                ':nombre' => $mascota->getNombre(),
                ':especie' => $mascota->getEspecie(),
                ':raza' => $mascota->getRaza(),
                ':edad' => $mascota->getEdad(),
                ':peso_actual' => $mascota->getPesoActual(),
                ':color_senas' => $mascota->getColorSenas(),
                ':responsable' => $mascota->getResponsable(),
                ':telefono_emergencia' => $mascota->getTelefonoEmergencia(),
            ]);
        } catch (PDOException $e) {
            throw new RuntimeException('No se pudo guardar la mascota.', 0, $e);
        }
    }

    public function buscarPorId(int $id): ?array
    {
        $consulta = $this->conexion->prepare('SELECT * FROM Mascotas WHERE id = :id');
        $consulta->execute([':id' => $id]);
        $mascota = $consulta->fetch();
        return $mascota === false ? null : $mascota;
    }

    public function actualizar(int $id, Mascota $mascota): bool
    {
        $consulta = $this->conexion->prepare(
            'UPDATE Mascotas SET nombre=:nombre, especie=:especie, raza=:raza, edad=:edad,
             peso_actual=:peso_actual, color_senas=:color_senas, responsable=:responsable,
             telefono_emergencia=:telefono_emergencia WHERE id=:id'
        );
        return $consulta->execute([
            ':id' => $id, ':nombre' => $mascota->getNombre(), ':especie' => $mascota->getEspecie(),
            ':raza' => $mascota->getRaza(), ':edad' => $mascota->getEdad(),
            ':peso_actual' => $mascota->getPesoActual(), ':color_senas' => $mascota->getColorSenas(),
            ':responsable' => $mascota->getResponsable(), ':telefono_emergencia' => $mascota->getTelefonoEmergencia(),
        ]);
    }

    public function eliminar(int $id): bool
    {
        $consulta = $this->conexion->prepare('DELETE FROM Mascotas WHERE id = :id');
        $consulta->execute([':id' => $id]);
        return $consulta->rowCount() > 0;
    }

    public static function contarMascotas(): int
    {
        $almacen = new self();
        $consulta = $almacen->conexion->prepare('SELECT COUNT(*) FROM Mascotas');
        $consulta->execute();

        return (int) $consulta->fetchColumn();
    }

    public static function obtenerMascotasPaginadas(int $inicio, int $cantidad): array
    {
        $almacen = new self();
        $consulta = $almacen->conexion->prepare(
            'SELECT id, nombre, especie, raza, edad, peso_actual, color_senas,
                    responsable, telefono_emergencia
             FROM Mascotas
             ORDER BY id DESC
             LIMIT :inicio, :cantidad'
        );
        $consulta->bindValue(':inicio', max(0, $inicio), PDO::PARAM_INT);
        $consulta->bindValue(':cantidad', max(1, $cantidad), PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchAll();
    }
}
