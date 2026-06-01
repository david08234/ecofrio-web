<?php
class Producto {
    private $conn;
    private $tabla = "productos";

    public $id_producto;
    public $nombre;
    public $categoria;
    public $precio;
    public $stock;

    public function __construct($db) { $this->conn = $db; }

    public function obtenerTodos() {
        $query = "SELECT id_producto, nombre_producto AS nombre, categoria, precio_venta AS precio, stock FROM " . $this->tabla . " ORDER BY id_producto ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function obtenerPorId($id) {
        $query = "SELECT id_producto, nombre_producto AS nombre, categoria, precio_venta AS precio, stock FROM " . $this->tabla . " WHERE id_producto = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear() {
        $query = "INSERT INTO " . $this->tabla . " (nombre_producto, categoria, precio_venta, stock) VALUES (:nombre, :categoria, :precio, :stock)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':nombre' => $this->nombre,
            ':categoria' => $this->categoria,
            ':precio' => $this->precio,
            ':stock' => $this->stock
        ]);
    }

    public function eliminar($id) {
        $query = "DELETE FROM " . $this->tabla . " WHERE id_producto = ?";
        return $this->conn->prepare($query)->execute([$id]);
    }

    public function actualizar() {
        $query = "UPDATE " . $this->tabla . " SET nombre_producto = :nombre, categoria = :categoria, precio_venta = :precio, stock = :stock WHERE id_producto = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':nombre' => $this->nombre,
            ':categoria' => $this->categoria,
            ':precio' => $this->precio,
            ':stock' => $this->stock,
            ':id' => $this->id_producto
        ]);
    }
}
?>