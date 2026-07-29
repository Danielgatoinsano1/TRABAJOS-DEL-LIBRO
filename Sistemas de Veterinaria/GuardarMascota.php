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
}
