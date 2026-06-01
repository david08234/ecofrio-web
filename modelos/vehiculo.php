<?php
class Vehiculo {
    private $conn;
    private $tabla = "vehiculos";

    public $id_vehiculo;
    public $placa;
    public $modelo;
    public $capacidad_carga;

    public function __construct($db) { $this->conn = $db; }

    public function obtenerTodos() {
        $query = "SELECT id_vehiculo, placa, modelo, capacidad_carga_kg AS capacidad_carga FROM " . $this->tabla . " ORDER BY placa ASC";
        return $this->conn->query($query);
    }

    public function crear() {
        $query = "INSERT INTO " . $this->tabla . " (placa, modelo, capacidad_carga_kg) VALUES (:placa, :modelo, :capacidad)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':placa' => $this->placa,
            ':modelo' => $this->modelo,
            ':capacidad' => $this->capacidad_carga
        ]);
    }
}
?>