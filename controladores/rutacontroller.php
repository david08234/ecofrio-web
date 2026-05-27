<?php
declare(strict_types=1);
require_once "modelos/rutaentrega.php";

class RutaController {
    public function registrar(): void {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST['action'] ?? '') === 'guardar_ruta') {
            
            $conductor = filter_var($_POST['id_conductor'] ?? null, FILTER_VALIDATE_INT);
            $vehiculo = filter_var($_POST['id_vehiculo'] ?? null, FILTER_VALIDATE_INT);
            $fecha = isset($_POST['fecha_despacho']) ? trim($_POST['fecha_despacho']) : '';

            if (!$conductor || !$vehiculo || $fecha === '') {
                $_SESSION['error'] = "Todos los campos de la ruta son requeridos.";
                header("Location: index.php?vista=crear_ruta"); exit();
            }

            $ruta = new RutaEntrega(null, $conductor, $vehiculo, $fecha);
            $_SESSION['mensaje'] = "Ruta logística para el " . $ruta->obtenerFecha() . " generada.";
            header("Location: index.php?vista=crear_ruta"); exit();
        }
    }
}