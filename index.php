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
    header('Location: index.php?vista=home&msg=AccAccessDenegado');
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
    <style>
        /* Estilos complementarios para la barra de navegación del index */
        header {
            background: #ffffff;
            padding: 16px 32px;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05);
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }
        header h1 {
            font-size: 20px;
            color: #111827;
            margin: 0;
            font-weight: bold;
        }
        nav {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
        }
        nav a {
            color: #4b5563;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            padding: 8px 12px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        nav a:hover {
            background: #e2e8f0;
            color: #111827;
        }
        nav a.logout-link {
            color: #ef4444;
        }
        nav a.logout-link:hover {
            background: #fee2e2;
            color: #dc2626;
        }
        main {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px 40px 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1>EcoFrío S.R.L. &mdash; Sistema de Gestión</h1>
        <nav>
            <a href="index.php?vista=home">Inicio</a>
            <?php if ($rolUsuario === 'Admin'): ?>
                <a href="index.php?vista=listar_usuarios">Usuarios</a>
            <?php endif; ?>
            <a href="index.php?vista=listar_clientes">Clientes</a>
            <a href="index.php?vista=listar_productos">Productos</a>
            <a href="index.php?vista=registrar_vehiculo">Vehículos</a>
            <a href="index.php?vista=crear_pedido">Pedidos</a>
            <a href="index.php?vista=crear_ruta">Rutas</a>
            <a href="index.php?vista=gestionar_entrega">Entregas</a>
            <?php if (isset($_SESSION['id_usuario'])): ?>
                <a href="logout.php" class="logout-link">Cerrar sesión</a>
            <?php endif; ?>
        </nav>
    </header>

    <main>
        <?php
        switch ($vista) {
            // Módulo de Usuarios
            case 'listar_usuarios':
                if ($rolUsuario !== 'Admin') {
                    echo "<div class='alert alert-error'><b>Acceso denegado: solo administradores pueden gestionar usuarios.</b></div>";
                } else {
                    $ctrlUsuario->listar();
                }
                break;
            case 'crear_usuario':
                if ($rolUsuario !== 'Admin') {
                    echo "<div class='alert alert-error'><b>Acceso denegado: solo administradores pueden crear usuarios.</b></div>";
                } else {
                    $ctrlUsuario->mostrarCrear();
                }
                break;
            case 'editar_usuario':
                if ($rolUsuario !== 'Admin') {
                    echo "<div class='alert alert-error'><b>Acceso denegado: solo administradores pueden editar usuarios.</b></div>";
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
                ?>
                <div class="dashboard-welcome">
                    <h2>¡Hola, <?php echo htmlspecialchars($nombreUsuario, ENT_QUOTES, 'UTF-8'); ?>! 👋</h2>
                    <p>Bienvenido al panel de control de EcoFrío. Tu rol actual es: <strong><?php echo htmlspecialchars($rolUsuario, ENT_QUOTES, 'UTF-8'); ?></strong>.</p>
                </div>

                <?php
                if (isset($_GET['msg'])) {
                    if ($_GET['msg'] === 'PedidoCreado') {
                        echo "<div class='alert alert-info'><b>¡✅ Pedido y detalles registrados exitosamente mediante transacción PDO!</b></div>";
                    } elseif ($_GET['msg'] === 'RutaCreada') {
                        echo "<div class='alert alert-info'><b>¡✅ Hoja de ruta consolidada con éxito. Los pedidos seleccionados han sido asignados al camión correspondiente!</b></div>";
                    } elseif ($_GET['msg'] === 'AccesoDenegado') {
                        echo "<div class='alert alert-error'><b>⚠️ Acceso denegado: No cuenta con los privilegios administrativos requeridos.</b></div>";
                    }
                }
                ?>

                <div class="kpi-grid">
                    <div class="kpi-card">
                        <div class="kpi-icon blue">📦</div>
                        <div class="kpi-details">
                            <h3>Pedidos Hoy</h3>
                            <p>0</p>
                        </div>
                    </div>

                    <div class="kpi-card">
                        <div class="kpi-icon green">🚛</div>
                        <div class="kpi-details">
                            <h3>Rutas Activas</h3>
                            <p>0</p>
                        </div>
                    </div>

                    <div class="kpi-card">
                        <div class="kpi-icon orange">👥</div>
                        <div class="kpi-details">
                            <h3>Clientes</h3>
                            <p>0</p>
                        </div>
                    </div>

                    <div class="kpi-card">
                        <div class="kpi-icon purple">❄️</div>
                        <div class="kpi-details">
                            <h3>Productos</h3>
                            <p>0</p>
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                    <a href="index.php?vista=crear_pedido" class="btn btn-primary">➕ Nuevo Pedido</a>
                    <a href="index.php?vista=crear_ruta" class="btn btn-primary" style="background: #15803d;">🗺️ Asignar Ruta</a>
                    <a href="index.php?vista=listar_productos" class="btn btn-cancel">Ver Inventario</a>
                </div>
                <?php
                break;
        }
        ?>
    </main>
</body>
</html>