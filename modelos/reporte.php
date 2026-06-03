<?php
class Reporte {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function contarClientes(): int {
        $stmt = $this->conn->query("SELECT COUNT(*) AS total FROM clientes");
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        return intval($fila['total'] ?? 0);
    }

    public function contarProductos(): int {
        $stmt = $this->conn->query("SELECT COUNT(*) AS total FROM productos");
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        return intval($fila['total'] ?? 0);
    }

    public function contarVentas(): int {
        $stmt = $this->conn->query("SELECT COUNT(*) AS total FROM pedidos");
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        return intval($fila['total'] ?? 0);
    }

    public function obtenerClientes(): array {
        $query = "SELECT id_cliente, razon_social, nit, telefono FROM clientes ORDER BY razon_social ASC";
        return $this->conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerProductos(): array {
        $query = "SELECT id_producto, nombre_producto AS nombre, categoria, precio_venta AS precio, stock FROM productos ORDER BY nombre_producto ASC";
        return $this->conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerVentas(): array {
        $query = "SELECT p.id_pedido, c.razon_social, c.nit, p.direccion_entrega, p.monto_total, p.estado_pedido, p.fecha_pedido
                  FROM pedidos p
                  LEFT JOIN clientes c ON p.id_cliente = c.id_cliente
                  ORDER BY p.fecha_pedido DESC, p.id_pedido DESC";
        return $this->conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>