<?php
class Pedido {
    private $conn;

    public function __construct($db) { 
        $this->conn = $db; 
    }

    // Método Transaccional
    public function crearPedidoTransaccional($id_cliente, $id_vendedor, $direccion, $total, $carrito) {
        try {
            // 1. Iniciar la transacción
            $this->conn->beginTransaction();

            // 2. Insertar Cabecera (Tabla: pedidos)
            $queryCabecera = "INSERT INTO pedidos (id_cliente, id_vendedor, fecha_pedido, direccion_entrega, monto_total, estado_pedido) 
                              VALUES (:cliente, :vendedor, CURDATE(), :direccion, :total, 'Pendiente')";
            $stmtCabecera = $this->conn->prepare($queryCabecera);
            $stmtCabecera->execute([
                ':cliente' => $id_cliente,
                ':vendedor' => $id_vendedor,
                ':direccion' => $direccion,
                ':total' => $total
            ]);

            // 3. Obtener el ID del pedido recién creado
            $id_pedido = $this->conn->lastInsertId();

            // 4. Insertar Detalles (Tabla: detalle_pedidos)
            $queryDetalle = "INSERT INTO detalle_pedidos (id_pedido, id_producto, cantidad, precio_unitario) 
                             VALUES (:pedido, :producto, :cantidad, :precio)";
            $stmtDetalle = $this->conn->prepare($queryDetalle);

            foreach ($carrito as $item) {
                $stmtDetalle->execute([
                    ':pedido' => $id_pedido,
                    ':producto' => $item['id_producto'],
                    ':cantidad' => $item['cantidad'],
                    ':precio' => $item['precio']
                ]);
            }

            // 5. Confirmar transacción
            $this->conn->commit();
            return true;

        } catch (Exception $e) {
            // Si algo falla, deshacer todo
            $this->conn->rollBack();
            $logDir = __DIR__ . '/../logs';
            if (!is_dir($logDir)) { mkdir($logDir, 0755, true); }
            file_put_contents($logDir . '/pedido_errors.log', date('Y-m-d H:i:s') . " - " . $e->getMessage() . PHP_EOL, FILE_APPEND);
            return false;
        }
    }
}
?>