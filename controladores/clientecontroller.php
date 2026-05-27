<?php
declare(strict_types=1);
require_once "modelos/cliente.php";

class ClienteController {
    public function registrar(): void {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST['action'] ?? '') === 'guardar_cliente') {
            
            $razon_social = isset($_POST['razon_social']) ? trim(htmlspecialchars($_POST['razon_social'], ENT_QUOTES, 'UTF-8')) : '';
            $nit = isset($_POST['nit']) ? trim(htmlspecialchars($_POST['nit'], ENT_QUOTES, 'UTF-8')) : '';
            $telefono = isset($_POST['telefono']) ? trim(htmlspecialchars($_POST['telefono'], ENT_QUOTES, 'UTF-8')) : null;

            if ($telefono === '') { $telefono = null; }

            if ($razon_social === '' || $nit === '') {
                $_SESSION['error'] = "Razón Social y NIT son requeridos.";
                header("Location: index.php?vista=crear_cliente"); exit();
            }

            $cliente = new Cliente(null, $razon_social, $nit, $telefono);
            $_SESSION['mensaje'] = "Cliente '" . $cliente->obtenerRazonSocial() . "' verificado.";
            header("Location: index.php?vista=crear_cliente"); exit();
        }
    }
}