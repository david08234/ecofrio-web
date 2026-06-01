<?php
require_once "config/conexion.php";
require_once "modelos/pedido.php";
require_once "modelos/cliente.php";
require_once "modelos/producto.php";

class PedidoController {
    private $db;
    private $pedido;

    public function __construct() {
        $this->db = (new Conexion())->conectar();
        $this->pedido = new Pedido($this->db);
    }

    // Cargar formulario con datos
    public function mostrarCrear() {
        // Obtenemos catálogos para los select
        $modeloCliente = new Cliente($this->db);
        $clientes = $modeloCliente->obtenerTodos()->fetchAll(PDO::FETCH_ASSOC);

        $modeloProducto = new Producto($this->db);
        $productos = $modeloProducto->obtenerTodos()->fetchAll(PDO::FETCH_ASSOC);

        require_once "Vistas/crear_pedido.php";
    }

    // Procesar transacción
    public function registrar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_cliente = $_POST['id_cliente'];
            $direccion = $_POST['direccion_entrega'];
            
            // Determinar id_vendedor: preferir sesión, si no existe tomar el primer usuario disponible
            session_start();
            if (!empty($_SESSION['id_usuario'])) {
                $id_vendedor = $_SESSION['id_usuario'];
            } else {
                // Intentar obtener primer usuario de la tabla usuarios
                $stmtUser = $this->db->query("SELECT id_usuario FROM usuarios LIMIT 1");
                $id_vendedor = $stmtUser ? $stmtUser->fetchColumn() : null;
            }

            if (empty($id_vendedor)) {
                die('No existe un usuario vendedor configurado en el sistema.');
            }

            // Recibir arrays del carrito (creados por JavaScript)
            $ids_productos = $_POST['producto_id'] ?? [];
            $cantidades = $_POST['producto_cantidad'] ?? [];
            $precios = $_POST['producto_precio'] ?? [];

            if(empty($ids_productos)) {
                die("El pedido no puede estar vacío. Agregue productos al carrito.");
            }

            // Armar el carrito y calcular total
            $carrito = [];
            $monto_total = 0;

            for ($i = 0; $i < count($ids_productos); $i++) {
                $subtotal = $cantidades[$i] * $precios[$i];
                $monto_total += $subtotal;

                $carrito[] = [
                    'id_producto' => $ids_productos[$i],
                    'cantidad' => $cantidades[$i],
                    'precio' => $precios[$i]
                ];
            }

            // Ejecutar Modelo
            if ($this->pedido->crearPedidoTransaccional($id_cliente, $id_vendedor, $direccion, $monto_total, $carrito)) {
                // Redirigir al inicio o a una lista de pedidos (ajusta según necesites)
                header("Location: index.php?vista=home&msg=PedidoCreado");
            } else {
                echo "Error crítico al guardar la transacción.";
            }
        }
    }
}
?>