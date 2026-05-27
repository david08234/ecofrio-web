<?php
declare(strict_types=1);

class Producto
{
    private string $nombreProducto;
    private ?string $categoria;
    private float $precioVenta;
    private int $stock;

    public function __construct(string $nombreProducto, ?string $categoria, float $precioVenta, int $stock)
    {
        $this->nombreProducto = $nombreProducto;
        $this->categoria = $categoria;
        $this->precioVenta = $precioVenta;
        $this->stock = $stock;
    }

    public function obtenerNombre(): string { return $this->nombreProducto; }
    public function obtenerPrecio(): float { return $this->precioVenta; }
    public function obtenerStock(): int { return $this->stock; }
}