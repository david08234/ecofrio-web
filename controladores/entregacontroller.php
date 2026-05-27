<?php
declare(strict_types=1);
require_once "modelos/entregadetalle.php";

class EntregaController {
    public function registrar(): void {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST['action'] ?? '') === 'guardar_entrega') {
            
            $id_ruta = filter_var($_POST['id_ruta'] ?? null, FILTER_VALIDATE_INT);
            $id_pedido = filter_var($_POST['id_pedido'] ?? null, FILTER_VALIDATE_INT);
            $estado = isset($_POST['estado_entrega']) ? trim($_POST['estado_entrega']) : '';
            $incidencias = isset($_POST['incidencias']) ? trim(htmlspecialchars($_POST['incidencias'], ENT_QUOTES, 'UTF-8')) : null;

            if ($incidencias === '') { $incidencias = null; }

            if (!$id_ruta || !$id_pedido || $estado === '') {
                $_SESSION['error'] = "Campos de asignación de entrega vacíos.";
                header("Location: index.php?vista=gestionar_entrega"); exit();
            }

            $estadosPermitidos = ['En Ruta', 'Entregado Exitoso', 'Con Incidencia'];
            if (!in_array($estado, $estadosPermitidos, true)) {
                $_SESSION['error'] = "Estado de entrega alterado inválido.";
                header("Location: index.php?vista=gestionar_entrega"); exit();
            }

            $entrega = new EntregaDetalle(null, $id_ruta, $id_pedido, $estado, $incidencias);
            $_SESSION['mensaje'] = "Manifiesto de entrega actualizado a: " . $entrega->obtenerEstado();
            header("Location: index.php?vista=gestionar_entrega"); exit();
        }
    }
}