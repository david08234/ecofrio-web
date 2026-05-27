<?php
declare(strict_types=1);

class Pedido
{
    private int $idCliente;
    private int $idVendedor;
    private string $fechaPedido;
    private string $direccionEntrega;
    private float $montoTotal;
    private string $estadoPedido;
    private array $detalles;

    public function __construct(int $idCliente, int $idVendedor, string $fechaPedido, string $direccionEntrega, float $montoTotal, string $estadoPedido, array $detalles = [])
    {
        $this->idCliente = $idCliente;
        $this->idVendedor = $idVendedor;
        $this->fechaPedido = $fechaPedido;
        $this->direccionEntrega = $direccionEntrega;
        $this->montoTotal = $montoTotal;
        $this->estadoPedido = $estadoPedido;
        $this->detalles = $detalles;
    }

    public function obtenerDireccion(): string { return $this->direccionEntrega; }
    public function obtenerDetalles(): array { return $this->detalles; }
}