<?php
declare(strict_types=1);
require_once "modelos/vehiculo.php";

class VehiculoController {
    public function registrar(): void {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST['action'] ?? '') === 'guardar_vehiculo') {
            
            $placa = isset($_POST['placa']) ? trim(htmlspecialchars($_POST['placa'], ENT_QUOTES, 'UTF-8')) : '';
            $modelo = isset($_POST['modelo']) ? trim(htmlspecialchars($_POST['modelo'], ENT_QUOTES, 'UTF-8')) : null;
            if ($modelo === '') { $modelo = null; }

            if ($placa === '') {
                $_SESSION['error'] = "La placa es obligatoria.";
                header("Location: index.php?vista=registrar_vehiculo"); exit();
            }

            $capacidad = isset($_POST['capacidad_carga_kg']) && $_POST['capacidad_carga_kg'] !== '' 
                ? filter_var($_POST['capacidad_carga_kg'], FILTER_VALIDATE_FLOAT) 
                : null;

            if ($capacidad === false || (is_float($capacidad) && $capacidad < 0)) {
                $_SESSION['error'] = "La capacidad debe ser un número positivo.";
                header("Location: index.php?vista=registrar_vehiculo"); exit();
            }

            $vehiculo = new Vehiculo(null, $placa, $modelo, $capacidad);
            $_SESSION['mensaje'] = "Camión logístico '" . $vehiculo->obtenerPlaca() . "' procesado.";
            header("Location: index.php?vista=registrar_vehiculo"); exit();
        }
    }
}