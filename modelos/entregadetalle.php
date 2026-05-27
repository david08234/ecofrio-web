<?php
declare(strict_types=1);

class EntregaDetalle
{
    private int $idRuta;
    private int $idPedido;
    private string $estadoEntrega;
    private ?string $incidencias;

    public function __construct(int $idRuta, int $idPedido, string $estadoEntrega, ?string $incidencias)
    {
        $this->idRuta = $idRuta;
        $this->idPedido = $idPedido;
        $this->estadoEntrega = $estadoEntrega;
        $this->incidencias = $incidencias;
    }

    public function obtenerEstado(): string { return $this->estadoEntrega; }
}