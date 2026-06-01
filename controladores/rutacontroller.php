<?php
require_once "config/conexion.php";
require_once "modelos/ruta.php";
require_once "modelos/vehiculo.php";

class RutaController {
    private $db;
    private $ruta;

    public function __construct() {
        $this->db = (new Conexion())->conectar();
        $this->ruta = new Ruta($this->db);
    }

    public function mostrarAsignacion() {
        // Cargar camiones disponibles
        $modVehiculo = new Vehiculo($this->db);
        $vehiculos = $modVehiculo->obtenerTodos();

        // Cargar pedidos pendientes (id_ruta IS NULL o estado_pedido = 'Pendiente')
        $query = "SELECT p.*, c.razon_social FROM pedidos p 
                  INNER JOIN clientes c ON p.id_cliente = c.id_cliente 
                  WHERE p.estado_pedido = 'Pendiente' ORDER BY p.id_pedido DESC";
        $pedidosPendientes = $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);

        require_once "vistas/crear_ruta.php";
    }

    public function procesarRuta() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_vehiculo = $_POST['id_vehiculo'];
            $fecha_ruta = $_POST['fecha_ruta'];
            $pedidos_seleccionados = $_POST['pedidos'] ?? [];

            if (empty($pedidos_seleccionados)) {
                die("Error: Debe seleccionar al menos un pedido para consolidar la ruta.");
            }

            if ($this->ruta->crearRutaTransaccional($id_vehiculo, $fecha_ruta, $pedidos_seleccionados)) {
                header("Location: index.php?vista=home&msg=RutaCreada");
            } else {
                echo "Error crítico al procesar la distribución logística.";
            }
        }
    }
}
?>