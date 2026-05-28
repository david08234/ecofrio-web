<?php
declare(strict_types=1);
session_start();

// Carga obligatoria de todos los controladores
require_once "controladores/usuariocontroller.php";
require_once "controladores/clientecontroller.php";
require_once "controladores/productocontroller.php";
require_once "controladores/vehiculocontroller.php";
require_once "controladores/pedidocontroller.php";
require_once "controladores/rutacontroller.php";
require_once "controladores/entregacontroller.php";

// Instanciación de Controladores
$ctrlUsuario  = new usuarioController();
$ctrlCliente  = new clienteController();
$ctrlProducto = new productoController();
$ctrlVehiculo = new vehiculoController();
$ctrlPedido   = new pedidoController();
$ctrlRuta     = new rutaController();
$ctrlEntrega  = new entregaController();

// Interceptor Global de Acciones POST
if (isset($_GET["action"])) {
    switch ($_GET["action"]) {
        case 'usuarios':  $ctrlUsuario->registrar();  break;
        case 'clientes':  $ctrlCliente->registrar();  break;
        case 'productos': $ctrlProducto->registrar(); break;
        case 'vehiculos': $ctrlVehiculo->registrar(); break;
        case 'pedidos':   $ctrlPedido->registrar();   break;
        case 'rutas':     $ctrlRuta->registrar();     break;
        case 'entregas':  $ctrlEntrega->registrar();  break;
    }
}

// Capturador de Vistas GET
$vista = $_GET['vista'] ?? 'home';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoFrío - Módulo Logístico Base</title>
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body>
    <header>
        <h1>EcoFrío S.R.L. &mdash; Sistema de Gestión</h1>
        <nav>
            <a href="index.php?vista=home">Inicio</a> | 
            <a href="index.php?vista=crear_usuario">Usuarios</a> | 
            <a href="index.php?vista=crear_cliente">Clientes</a> | 
            <a href="index.php?vista=crear_producto">Productos</a> | 
            <a href="index.php?vista=registrar_vehiculo">Vehículos</a> | 
            <a href="index.php?vista=crear_pedido">Pedidos</a> | 
            <a href="index.php?vista=crear_ruta">Rutas</a> | 
            <a href="index.php?vista=gestionar_entrega">Entregas</a>
        </nav>
    </header>
    <hr>
    
    <main>
        <?php
        switch ($vista) {
            case 'crear_usuario':     include "vistas/crear_usuario.php";     break;
            case 'crear_cliente':     include "vistas/crear_cliente.php";     break;
            case 'crear_producto':    include "vistas/crear_producto.php";    break;
            case 'registrar_vehiculo': include "vistas/registrar_vehiculo.php"; break;
            case 'crear_pedido':       include "vistas/crear_pedido.php";       break;
            case 'crear_ruta':         include "vistas/crear_ruta.php";         break;
            case 'gestionar_entrega':  include "vistas/gestionar_entrega.php";  break;
            case 'home':
            default:
                echo "<h2>Panel de Control Principal</h2>";
                break;
        }
        ?>
    </main>
</body>
</html>