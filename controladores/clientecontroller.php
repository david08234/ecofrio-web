<?php
require_once "config/conexion.php";
require_once "modelos/cliente.php";

class ClienteController {
    private $db;
    private $cliente;

    public function __construct() {
        $this->db = (new Conexion())->conectar();
        $this->cliente = new Cliente($this->db);
    }

    public function listar() {
        $resultado = $this->cliente->obtenerTodos();
        $clientes = $resultado->fetchAll(PDO::FETCH_ASSOC);
        require_once "Vistas/listar_clientes.php";
    }

    public function mostrarCrear() {
        require_once "Vistas/crear_cliente.php";
    }

    public function registrar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->cliente->razon_social = $_POST['razon_social'];
            $this->cliente->nit = $_POST['nit'];
            $this->cliente->telefono = $_POST['telefono'];

            if ($this->cliente->crear()) {
                header("Location: index.php?vista=listar_clientes");
                exit();
            }

            echo "Error al registrar el cliente.";
        }
    }

    public function mostrarEditar($id) {
        $datosCliente = $this->cliente->obtenerPorId($id);
        if ($datosCliente) {
            require_once "Vistas/editar_cliente.php";
        } else {
            echo "Cliente no encontrado.";
        }
    }

    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->cliente->id_cliente = $_POST['id_cliente'];
            $this->cliente->razon_social = $_POST['razon_social'];
            $this->cliente->nit = $_POST['nit'];
            $this->cliente->telefono = $_POST['telefono'];

            if ($this->cliente->actualizar()) {
                header("Location: index.php?vista=listar_clientes");
                exit();
            }

            echo "Error al actualizar el cliente.";
        }
    }

    public function eliminar($id) {
        $this->cliente->eliminar($id);
        header("Location: index.php?vista=listar_clientes");
        exit();
    }
}
?>