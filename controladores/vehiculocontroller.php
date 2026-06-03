<?php
require_once "config/conexion.php";
require_once "modelos/vehiculo.php";

class VehiculoController {
    private $db;
    private $vehiculo;

    public function __construct() {
        $this->db = (new Conexion())->conectar();
        $this->vehiculo = new Vehiculo($this->db);
    }

    public function listar() {
        $vehiculos = $this->vehiculo->obtenerTodos();
        require_once "Vistas/registrar_vehiculo.php";
    }

    public function registrar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->vehiculo->placa = $_POST['placa'];
            $this->vehiculo->modelo = $_POST['modelo'];
            $this->vehiculo->capacidad_carga = $_POST['capacidad_carga'];

            if ($this->vehiculo->crear()) {
                header("Location: index.php?vista=registrar_vehiculo&msg=VehiculoCreado");
            }
        }
    }
}
?>