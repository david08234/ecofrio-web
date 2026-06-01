<?php
declare(strict_types=1);
session_start();
ini_set('display_errors', '1');
error_reporting(E_ALL);

// Redirigir a login si el usuario no está autenticado
$scriptName = basename($_SERVER['SCRIPT_NAME']);
if ($scriptName === 'index.php' && !isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit();
}

// Carga de controladores
require_once "controladores/usuariocontroller.php";
require_once "controladores/clientecontroller.php";
require_once "controladores/productocontroller.php";
require_once "controladores/vehiculocontroller.php";
require_once "controladores/pedidocontroller.php";
require_once "controladores/rutacontroller.php";
require_once "controladores/entregacontroller.php";

// Instanciación de controladores
$ctrlUsuario  = new UsuarioController();
$ctrlCliente  = new ClienteController();
$ctrlProducto = new ProductoController();
$ctrlPedido   = new PedidoController();
$ctrlVehiculo = new VehiculoController(); // Controlador de Camiones
$ctrlRuta     = new RutaController();     // Controlador de Despacho/Rutas
$ctrlEntrega  = new EntregaController();  // Controlador de Entregas y Choferes

$nombreUsuario = $_SESSION['nombre'] ?? '';
$rolUsuario = $_SESSION['rol_puesto'] ?? '';

// Protege acciones administrativas contra usuarios no autorizados
if (isset($_GET['action']) && in_array($_GET['action'], ['guardar_usuario', 'actualizar_usuario', 'eliminar_usuario']) && $rolUsuario !== 'Admin') {
    header('Location: index.php?vista=home&msg=AccesoDenegado');
    exit();
}

// 1. PROCESAMIENTO DE ACCIONES (Lógica CRUD y Transacciones)
// Se ejecuta antes de cualquier salida HTML para permitir redirecciones limpias con header()
if (isset($_GET["action"])) {
    switch ($_GET["action"]) {
        // Acciones de Usuarios
        case 'guardar_usuario':    $ctrlUsuario->guardar(); break;
        case 'actualizar_usuario': $ctrlUsuario->actualizar(); break;
        case 'eliminar_usuario':   $ctrlUsuario->eliminar($_GET['id'] ?? null); break;
        case 'listar_usuarios':    $vista = 'listar_usuarios'; break;
        
        // Acciones de Clientes
        case 'guardar_cliente':    $ctrlCliente->registrar(); break;
        case 'eliminar_cliente':   $ctrlCliente->eliminar($_GET['id'] ?? null); break;

        // Acciones de Productos
        case 'guardar_producto':   $ctrlProducto->registrar(); break;
        case 'eliminar_producto':  $ctrlProducto->eliminar($_GET['id'] ?? null); break;

        // Acciones Transaccionales de Pedidos
        case 'guardar_pedido':     $ctrlPedido->registrar(); break;

        // Acciones de Vehículos
        case 'guardar_vehiculo':   $ctrlVehiculo->registrar(); break;

        // Acciones de Rutas (Consolidación)
        case 'guardar_ruta':       $ctrlRuta->procesarRuta(); break;

        // Acciones de Entregas (Asignación Única a Choferes)
        case 'guardar_entrega':    $ctrlEntrega->asignar(); break;
    }
}

// 2. CARGA DE VISTAS (Enrutamiento Base)
$vista = $_GET['vista'] ?? 'home';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>EcoFrío - Gestión Logística</title>
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body>
    <header>
        <h1>EcoFrío S.R.L. &mdash; Sistema de Gestión</h1>
        <nav>
            <a href="index.php?vista=home">Inicio</a> | 
            <?php if ($rolUsuario === 'Admin'): ?>
                <a href="index.php?vista=listar_usuarios">Usuarios</a> | 
            <?php endif; ?>
            <a href="index.php?vista=listar_clientes">Clientes</a> | 
            <a href="index.php?vista=listar_productos">Productos</a> | 
            <a href="index.php?vista=registrar_vehiculo">Vehículos</a> | 
            <a href="index.php?vista=crear_pedido">Pedidos</a> | 
            <a href="index.php?vista=crear_ruta">Rutas</a> | 
            <a href="index.php?vista=gestionar_entrega">Entregas</a>
            <?php if (isset($_SESSION['id_usuario'])): ?> | <a href="logout.php">Cerrar sesión</a><?php endif; ?>
        </nav>
    </header>
    <hr>
    <main>
        <?php
        switch ($vista) {
            // Módulo de Usuarios
            case 'listar_usuarios':
                if ($rolUsuario !== 'Admin') {
                    echo "<p style='color: red; font-weight: bold;'>Acceso denegado: solo administradores pueden gestionar usuarios.</p>";
                } else {
                    $ctrlUsuario->listar();
                }
                break;
            case 'crear_usuario':
                if ($rolUsuario !== 'Admin') {
                    echo "<p style='color: red; font-weight: bold;'>Acceso denegado: solo administradores pueden crear usuarios.</p>";
                } else {
                    $ctrlUsuario->mostrarCrear();
                }
                break;
            case 'editar_usuario':
                if ($rolUsuario !== 'Admin') {
                    echo "<p style='color: red; font-weight: bold;'>Acceso denegado: solo administradores pueden editar usuarios.</p>";
                } else {
                    $ctrlUsuario->mostrarEditar($_GET['id'] ?? null);
                }
                break;
            
            // Módulo de Clientes
            case 'listar_clientes':    $ctrlCliente->listar(); break;
            case 'crear_cliente':      include "vistas/crear_cliente.php"; break;
            
            // Módulo de Productos (Inventario)
            case 'listar_productos':   $ctrlProducto->listar(); break;
            case 'crear_producto':     include "vistas/crear_producto.php"; break;
            
            // Módulo Transaccional de Pedidos
            case 'crear_pedido':       $ctrlPedido->mostrarCrear(); break;
            
            // Módulo de Logística (Vehículos de la Flota)
            case 'registrar_vehiculo': $ctrlVehiculo->listar(); break;
            
            // Módulo de Planificación de Distribución (Rutas)
            case 'crear_ruta':         $ctrlRuta->mostrarAsignacion(); break;
            
            // Módulo de Entregas (Gestión de Choferes y control UNIQUE)
            case 'gestionar_entrega':  $ctrlEntrega->mostrarGestion(); break;
            
            // Panel de Control Principal (Dashboard)
            case 'home':
            default:
                echo "<h2>Panel de Control Principal</h2><p>Bienvenido al sistema.</p>";
                
                // Alertas de confirmación visuales en el Dashboard
                if (isset($_GET['msg'])) {
                    if ($_GET['msg'] === 'PedidoCreado') {
                        echo "<p style='color: green; font-weight: bold;'>¡✅ Pedido y detalles registrados exitosamente mediante transacción PDO!</p>";
                    } elseif ($_GET['msg'] === 'RutaCreada') {
                        echo "<p style='color: green; font-weight: bold;'>¡✅ Hoja de ruta consolidada con éxito. Los pedidos seleccionados han sido asignados al camión correspondiente!</p>";
                    }
                }
                break;
        }
        ?>
    </main>
</body>
</html>