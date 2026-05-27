<?php
declare(strict_types=1);
require_once "modelos/pedido.php";

class PedidoController {
    public function registrar(): void {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST['action'] ?? '') === 'guardar_pedido') {
            
            $id_cliente = filter_var($_POST['id_cliente'] ?? null, FILTER_VALIDATE_INT);
            $id_vendedor = filter_var($_POST['id_vendedor'] ?? null, FILTER_VALIDATE_INT);
            $fecha = isset($_POST['fecha_pedido']) ? trim($_POST['fecha_pedido']) : '';
            $direccion = isset($_POST['direccion_entrega']) ? trim(htmlspecialchars($_POST['direccion_entrega'], ENT_QUOTES, 'UTF-8')) : '';
            $total = filter_var($_POST['monto_total'] ?? null, FILTER_VALIDATE_FLOAT);

            if (!$id_cliente || !$id_vendedor || $fecha === '' || $direccion === '' || $total === false || $total < 0) {
                $_SESSION['error'] = "Cabecera de orden incompleta.";
                header("Location: index.php?vista=crear_pedido"); exit();
            }

            $productosRaw = $_POST['productos'] ?? [];
            $productosProcesados = [];

            foreach ($productosRaw as $item) {
                $id_prod = filter_var($item['id_producto'] ?? null, FILTER_VALIDATE_INT);
                $cant = filter_var($item['cantidad'] ?? null, FILTER_VALIDATE_INT);
                $p_unit = filter_var($item['precio_unitario'] ?? null, FILTER_VALIDATE_FLOAT);

                if ($id_prod && $cant && $cant > 0 && $p_unit !== false && $p_unit >= 0) {
                    $productosProcesados[] = [
                        'id_producto' => $id_prod,
                        'cantidad' => $cant,
                        'precio_unitario' => $p_unit
                    ];
                }
            }

            if (empty($productosProcesados)) {
                $_SESSION['error'] = "Debe añadir al menos un producto válido al detalle.";
                header("Location: index.php?vista=crear_pedido"); exit();
            }

            $pedido = new Pedido(null, $id_cliente, $id_vendedor, $fecha, $direccion, $total, 'Pendiente', $productosProcesados);
            $_SESSION['mensaje'] = "Pedido maestro-detalle estructurado para la dirección: " . $pedido->obtenerDireccion();
            header("Location: index.php?vista=crear_pedido"); exit();
        }
    }
}   