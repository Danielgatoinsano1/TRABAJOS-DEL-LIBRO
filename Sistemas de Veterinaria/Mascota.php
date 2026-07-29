<?php

class Mascota
{
    protected string $nombre;
    protected string $especie;
    protected string $raza;
    protected int $edad;
    protected float $pesoActual;
    protected string $colorSenas;
    protected string $responsable;
    protected string $telefonoEmergencia;

    public function __construct(
        string $nombre,
        string $especie,
        string $raza,
        $edad,
        $pesoActual,
        string $colorSenas,
        string $responsable,
        string $telefonoEmergencia
    ) {
        $this->setNombre($nombre);
        $this->setEspecie($especie);
        $this->setRaza($raza);
        $this->setEdad($edad);
        $this->setPesoActual($pesoActual);
        $this->setColorSenas($colorSenas);
        $this->setResponsable($responsable);
        $this->setTelefonoEmergencia($telefonoEmergencia);
    }

    public function getNombre(): string { return $this->nombre; }
    public function setNombre(string $nombre): void { $this->nombre = $nombre; }

    public function getEspecie(): string { return $this->especie; }
    public function setEspecie(string $especie): void { $this->especie = $especie; }

    public function getRaza(): string { return $this->raza; }
    public function setRaza(string $raza): void { $this->raza = $raza; }

    public function getEdad(): int { return $this->edad; }
    public function setEdad($edad): void
    {
        if (!is_numeric($edad) || filter_var($edad, FILTER_VALIDATE_INT) === false || (int) $edad < 0) {
            throw new InvalidArgumentException('La edad debe ser un número entero igual o mayor que cero.');
        }
        $this->edad = (int) $edad;
    }

    public function getPesoActual(): float { return $this->pesoActual; }
    public function setPesoActual($pesoActual): void
    {
        if (!is_numeric($pesoActual) || (float) $pesoActual <= 0) {
            throw new InvalidArgumentException('El peso debe ser numérico y mayor que cero.');
        }
        $this->pesoActual = (float) $pesoActual;
    }

    public function getColorSenas(): string { return $this->colorSenas; }
    public function setColorSenas(string $colorSenas): void { $this->colorSenas = $colorSenas; }

    public function getResponsable(): string { return $this->responsable; }
    public function setResponsable(string $responsable): void { $this->responsable = $responsable; }

    public function getTelefonoEmergencia(): string { return $this->telefonoEmergencia; }
    public function setTelefonoEmergencia(string $telefonoEmergencia): void
    {
        $this->telefonoEmergencia = $telefonoEmergencia;
    }
}
