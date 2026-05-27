<?php
declare(strict_types=1);

class Vehiculo
{
    private string $placa;
    private ?string $modelo;
    private ?float $capacidadCargaKg;

    public function __construct(string $placa, ?string $modelo, ?float $capacidadCargaKg)
    {
   
        $this->placa = $placa;
        $this->modelo = $modelo;
        $this->capacidadCargaKg = $capacidadCargaKg;
    }

    public function obtenerPlaca(): string { return $this->placa; }
}