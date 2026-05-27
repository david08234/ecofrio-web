<?php
declare(strict_types=1);

class Usuario
{
    private string $nombre;
    private string $correo;
    private string $contrasena;
    private string $rolPuesto;

    public function __construct(string $nombre, string $correo, string $contrasena, string $rolPuesto)
    {
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->contrasena = $contrasena;
        $this->rolPuesto = $rolPuesto;
    }

    public function obtenerNombre(): string { return $this->nombre; }
    public function obtenerCorreo(): string { return $this->correo; }
    public function obtenerRol(): string { return $this->rolPuesto; }
}