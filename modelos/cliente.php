<?php
class Cliente {
    private $conn;
    private $tabla = "clientes";

    public $id_cliente;
    public $razon_social;
    public $nit;
    public $telefono;

    public function __construct($db) { $this->conn = $db; }

    public function obtenerTodos() {
        $query = "SELECT * FROM " . $this->tabla . " ORDER BY razon_social ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function obtenerPorId($id) {
        $query = "SELECT * FROM " . $this->tabla . " WHERE id_cliente = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear() {
        $query = "INSERT INTO " . $this->tabla . " (razon_social, nit, telefono) VALUES (:razon, :nit, :tel)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':razon' => $this->razon_social, ':nit' => $this->nit, ':tel' => $this->telefono]);
    }

    public function actualizar() {
        $query = "UPDATE " . $this->tabla . " SET razon_social = :razon, nit = :nit, telefono = :tel WHERE id_cliente = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':razon' => $this->razon_social, ':nit' => $this->nit, ':tel' => $this->telefono, ':id' => $this->id_cliente]);
    }

    public function eliminar($id) {
        $query = "DELETE FROM " . $this->tabla . " WHERE id_cliente = ?";
        return $this->conn->prepare($query)->execute([$id]);
    }
}
?>