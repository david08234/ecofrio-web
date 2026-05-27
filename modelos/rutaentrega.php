<?php
declare(strict_types=1);

class RutaEntrega
{
    private int $idConductor;
    private int $idVehiculo;
    private string $fechaDespacho;

    public function __construct(int $idConductor, int $idVehiculo, string $fechaDespacho)
    {
        $this->idConductor = $idConductor;
        $this->idVehiculo = $idVehiculo;
        $this->fechaDespacho = $fechaDespacho;
    }

    public function obtenerFecha(): string { return $this->fechaDespacho; }
}