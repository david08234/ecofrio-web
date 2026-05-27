<?php
declare(strict_types=1);

class Cliente
{
    private string $razonSocial;
    private string $nit;
    private ?string $telefono;

    public function __construct( string $razonSocial, string $nit, ?string $telefono)
    {
        $this->razonSocial = $razonSocial;
        $this->nit = $nit;
        $this->telefono = $telefono;
    }

    public function obtenerRazonSocial(): string { return $this->razonSocial; }
    public function obtenerNit(): string { return $this->nit; }
}