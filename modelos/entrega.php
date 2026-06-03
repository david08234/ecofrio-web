<?php
class Entrega {
    private $conn;
    private $tabla_detalle = "entregas_detalle";

    public function __construct($db) { 
        $this->conn = $db; 
    }

    // Verificar si el pedido ya fue asignado a algún chofer
    public function verificarPedidoAsignado(int $id_pedido): bool {
        $query = "SELECT COUNT(*) FROM " . $this->tabla_detalle . " WHERE id_pedido = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id_pedido]);
        return $stmt->fetchColumn() > 0;
    }

    // Registrar la asignación controlando la restricción por código
    public function registrarAsignacion(int $id_ruta, int $id_pedido, string $observaciones): array {
        // 1. Control por código de la restricción UNIQUE
        if ($this->verificarPedidoAsignado($id_pedido)) {
            return [
                'status' => false,
                'mensaje' => 'El pedido #' . $id_pedido . ' ya se encuentra asignado a otro chofer. No se puede duplicar.'
            ];
        }

        try {
            $this->conn->beginTransaction();

            // 2. Insertar en entregas_detalle usando la ruta creada para el chofer
            $queryInsert = "INSERT INTO " . $this->tabla_detalle . " (id_ruta, id_pedido, estado_entrega, incidencias) 
                            VALUES (:id_ruta, :id_pedido, 'En Ruta', :observaciones)";
            $stmtInsert = $this->conn->prepare($queryInsert);
            $stmtInsert->execute([
                ':id_ruta' => $id_ruta,
                ':id_pedido' => $id_pedido,
                ':observaciones' => $observaciones
            ]);

            // 3. Actualizar el estado del pedido a 'En Reparto'
            $queryPedido = "UPDATE pedidos SET estado_pedido = 'Asignado' WHERE id_pedido = ?";
            $this->conn->prepare($queryPedido)->execute([$id_pedido]);

            $this->conn->commit();
            return ['status' => true, 'mensaje' => 'Pedido asignado al chofer correctamente.'];

        } catch (PDOException $e) {
            $this->conn->rollBack();
            $duplicateMsg = '';
            if (isset($e->errorInfo[1]) && $e->errorInfo[1] === 1062) {
                $duplicateMsg = 'El pedido #' . $id_pedido . ' ya tiene una entrega registrada y no puede asignarse a otro chofer.';
            }
            return ['status' => false, 'mensaje' => $duplicateMsg ?: 'Error crítico en el servidor: ' . $e->getMessage()];
        }
    }

    public function confirmarEntrega(int $idConductor, int $idPedido): array {
        try {
            $this->conn->beginTransaction();

            $queryConfirmar = "UPDATE " . $this->tabla_detalle . " ed
                INNER JOIN rutas_entrega r ON ed.id_ruta = r.id_ruta
                SET ed.estado_entrega = 'Entregado Exitoso'
                WHERE r.id_conductor = :conductor
                  AND ed.id_pedido = :pedido
                  AND ed.estado_entrega = 'En Ruta'";
            $stmt = $this->conn->prepare($queryConfirmar);
            $stmt->execute([
                ':conductor' => $idConductor,
                ':pedido' => $idPedido
            ]);

            if ($stmt->rowCount() === 0) {
                $this->conn->rollBack();
                return ['status' => false, 'mensaje' => 'No se encontró una entrega en ruta para este pedido o ya fue confirmada.'];
            }

            $queryPedido = "UPDATE pedidos SET estado_pedido = 'Entregado' WHERE id_pedido = ?";
            $this->conn->prepare($queryPedido)->execute([$idPedido]);

            $this->conn->commit();
            return ['status' => true, 'mensaje' => 'Entrega del pedido #' . $idPedido . ' confirmada correctamente.'];
        } catch (PDOException $e) {
            $this->conn->rollBack();
            return ['status' => false, 'mensaje' => 'Error al confirmar la entrega: ' . $e->getMessage()];
        }
    }
}
?>