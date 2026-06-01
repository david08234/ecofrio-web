<?php
require_once "config/conexion.php";
require_once "modelos/entrega.php";

class EntregaController {
    private $db;
    private $entrega;

    public function __construct() {
        $this->db = (new Conexion())->conectar();
        $this->entrega = new Entrega($this->db);
    }

    public function mostrarGestion() {
        // Obtener choferes (Usuarios con rol de chofer/repartidor)
        $queryChoferes = "SELECT id_usuario, nombre AS nombre_completo FROM usuarios WHERE rol_puesto = 'Conductor' ORDER BY nombre ASC";
        $choferes = $this->db->query($queryChoferes)->fetchAll(PDO::FETCH_ASSOC);

        // Obtener pedidos que estén 'En Ruta' o listos para asignarse a un chofer individual
        $queryPedidos = "SELECT p.id_pedido, c.razon_social, p.direccion_entrega 
                         FROM pedidos p
                         INNER JOIN clientes c ON p.id_cliente = c.id_cliente
                         WHERE p.id_pedido NOT IN (SELECT id_pedido FROM entregas_detalle)
                         ORDER BY p.id_pedido DESC";
        $pedidosDisponibles = $this->db->query($queryPedidos)->fetchAll(PDO::FETCH_ASSOC);

        require_once "vistas/gestionar_entrega.php";
    }

    public function asignar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_chofer = (int)$_POST['id_chofer'];
            $id_pedido = (int)$_POST['id_pedido'];
            $observaciones = $_POST['observaciones'] ?? '';

            if (empty($id_chofer) || empty($id_pedido)) {
                $_SESSION['error'] = "Debe seleccionar un chofer y un pedido válidos.";
                header("Location: index.php?vista=gestionar_entrega");
                exit();
            }

            // Crear una ruta mínima para esta asignación de chofer
            $vehiculo = $this->db->query("SELECT id_vehiculo FROM vehiculos LIMIT 1")->fetch(PDO::FETCH_ASSOC);
            if (!$vehiculo) {
                $_SESSION['error'] = "No hay vehículos registrados para generar la ruta de entrega.";
                header("Location: index.php?vista=gestionar_entrega");
                exit();
            }

            $queryRuta = "INSERT INTO rutas_entrega (id_conductor, id_vehiculo, fecha_despacho) VALUES (:conductor, :vehiculo, CURDATE())";
            $stmtRuta = $this->db->prepare($queryRuta);
            $stmtRuta->execute([
                ':conductor' => $id_chofer,
                ':vehiculo' => $vehiculo['id_vehiculo']
            ]);
            $id_ruta = $this->db->lastInsertId();

            // Ejecutar inserción controlada en entregas_detalle
            $resultado = $this->entrega->registrarAsignacion((int)$id_ruta, $id_pedido, $observaciones);

            if (!$resultado['status']) {
                // Si la asignación falla, eliminar la ruta creada para no dejar registros huérfanos.
                $stmtDelete = $this->db->prepare("DELETE FROM rutas_entrega WHERE id_ruta = ?");
                $stmtDelete->execute([$id_ruta]);
            }

            if ($resultado['status']) {
                $vehiculoInfo = $this->db->prepare("SELECT placa, modelo FROM vehiculos WHERE id_vehiculo = ?");
                $vehiculoInfo->execute([$vehiculo['id_vehiculo']]);
                $vehiculoData = $vehiculoInfo->fetch(PDO::FETCH_ASSOC);

                $_SESSION['mensaje'] = $resultado['mensaje'];
                $_SESSION['ruta_asignada'] = [
                    'id_ruta' => $id_ruta,
                    'id_vehiculo' => $vehiculo['id_vehiculo'],
                    'id_pedido' => $id_pedido,
                    'placa' => $vehiculoData['placa'] ?? '',
                    'modelo' => $vehiculoData['modelo'] ?? ''
                ];
            } else {
                $_SESSION['error'] = $resultado['mensaje'];
            }

            header("Location: index.php?vista=gestionar_entrega");
            exit();
        }
    }
}
?>