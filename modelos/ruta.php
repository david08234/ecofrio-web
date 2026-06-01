<?php
class Ruta {
    private $conn;

    public function __construct($db) { $this->conn = $db; }

    public function crearRutaTransaccional($id_vehiculo, $fecha_ruta, $pedidos_ids) {
        try {
            $this->conn->beginTransaction();

            // 1. Insertar la cabecera de la ruta
            $queryRuta = "INSERT INTO rutas_entrega (id_vehiculo, fecha_ruta, estado_ruta) VALUES (:vehiculo, :fecha, 'Asignada')";
            $stmtRuta = $this->conn->prepare($queryRuta);
            $stmtRuta->execute([
                ':vehiculo' => $id_vehiculo,
                ':fecha' => $fecha_ruta
            ]);

            $id_ruta = $this->conn->lastInsertId();

            // 2. Asociar los pedidos seleccionados a la ruta y actualizar su estado
            $queryPedido = "UPDATE pedidos SET id_ruta = :ruta, estado_pedido = 'En Ruta' WHERE id_pedido = :id_pedido";
            $stmtPedido = $this->conn->prepare($queryPedido);

            foreach ($pedidos_ids as $id_pedido) {
                $stmtPedido->execute([
                    ':ruta' => $id_ruta,
                    ':id_pedido' => $id_pedido
                ]);
            }

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }
}
?>