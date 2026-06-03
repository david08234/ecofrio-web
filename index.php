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
require_once "controladores/reportcontroller.php";

// Instanciación de controladores
$ctrlUsuario  = new UsuarioController();
$ctrlCliente  = new ClienteController();
$ctrlProducto = new ProductoController();
$ctrlPedido   = new PedidoController();
$ctrlVehiculo = new VehiculoController(); // Controlador de Camiones
$ctrlRuta     = new RutaController();     // Controlador de Despacho/Rutas
$ctrlEntrega  = new EntregaController();  // Controlador de Entregas y Choferes
$ctrlReporte  = new ReportController();  // Controlador de Reportes Administrativos

$nombreUsuario = $_SESSION['nombre'] ?? '';
$rolUsuario = $_SESSION['rol_puesto'] ?? '';

$permisos = [
    'Admin' => [
        'vistas' => [
            'home', 'listar_usuarios', 'crear_usuario', 'editar_usuario',
            'listar_clientes', 'crear_cliente', 'editar_cliente',
            'listar_productos', 'crear_producto', 'editar_producto',
            'crear_pedido', 'registrar_vehiculo', 'crear_ruta', 'gestionar_entrega',
            'reportes'
        ],
        'acciones' => [
            'guardar_usuario', 'actualizar_usuario', 'eliminar_usuario',
            'listar_usuarios', 'guardar_cliente', 'actualizar_cliente', 'eliminar_cliente',
            'guardar_producto', 'actualizar_producto', 'eliminar_producto',
            'guardar_pedido', 'guardar_vehiculo', 'guardar_ruta', 'guardar_entrega', 'confirmar_entrega',
            'exportar_clientes', 'exportar_productos', 'exportar_ventas'
        ]
    ],
    'Vendedor' => [
        'vistas' => [
            'home', 'listar_clientes', 'crear_cliente', 'editar_cliente',
            'listar_productos',
            'crear_pedido'
        ],
        'acciones' => [
            'guardar_cliente', 'actualizar_cliente', 'eliminar_cliente',
            'guardar_pedido'
        ]
    ],
    'Almacen' => [
        'vistas' => [
            'home',
            'listar_productos', 'crear_producto', 'editar_producto'
        ],
        'acciones' => [
            'guardar_producto', 'actualizar_producto', 'eliminar_producto'
        ]
    ],
    'Conductor' => [
        'vistas' => ['home', 'gestionar_entrega'],
        'acciones' => ['confirmar_entrega']
    ],
];

function puedeAccederVista(string $rol, string $vista): bool {
    global $permisos;
    if ($rol === 'Admin') {
        return true;
    }
    return isset($permisos[$rol]) && in_array($vista, $permisos[$rol]['vistas'], true);
}

function puedeEjecutarAccion(string $rol, string $accion): bool {
    global $permisos;
    if ($rol === 'Admin') {
        return true;
    }
    return isset($permisos[$rol]) && in_array($accion, $permisos[$rol]['acciones'], true);
}

$accionSolicitada = $_GET['action'] ?? '';
if ($accionSolicitada !== '' && !puedeEjecutarAccion($rolUsuario, $accionSolicitada)) {
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
        case 'confirmar_entrega':  $ctrlEntrega->confirmarEntrega(); break;

        // Acciones de Reportes Administrativos
        case 'exportar_clientes':  $ctrlReporte->exportarClientes(); break;
        case 'exportar_productos': $ctrlReporte->exportarProductos(); break;
        case 'exportar_ventas':    $ctrlReporte->exportarVentas(); break;
    }
}

// 2. CARGA DE VISTAS (Enrutamiento Base)
$vista = $_GET['vista'] ?? 'home';
if (!puedeAccederVista($rolUsuario, $vista)) {
    $_SESSION['error'] = 'Acceso denegado: tu rol no tiene permiso para este módulo.';
    $vista = 'home';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>EcoFrío - Gestión Logística</title>
    <link rel="stylesheet" href="assets/css/estilos.css?v=2">
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
            max-width: 100%; /* Esto libera el ancho total de la pantalla */
            margin: 0;
            padding: 20px;
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
            <?php if (puedeAccederVista($rolUsuario, 'listar_clientes')): ?>
                <a href="index.php?vista=listar_clientes">Clientes</a>
            <?php endif; ?>
            <?php if (puedeAccederVista($rolUsuario, 'listar_productos')): ?>
                <a href="index.php?vista=listar_productos">Productos</a>
            <?php endif; ?>
            <?php if (puedeAccederVista($rolUsuario, 'reportes')): ?>
                <a href="index.php?vista=reportes">Reportes</a>
            <?php endif; ?>
            <?php if (puedeAccederVista($rolUsuario, 'registrar_vehiculo')): ?>
                <a href="index.php?vista=registrar_vehiculo">Vehículos</a>
            <?php endif; ?>
            <?php if (puedeAccederVista($rolUsuario, 'crear_pedido')): ?>
                <a href="index.php?vista=crear_pedido">Pedidos</a>
            <?php endif; ?>
            <?php if (puedeAccederVista($rolUsuario, 'crear_ruta')): ?>
                <a href="index.php?vista=crear_ruta">Rutas</a>
            <?php endif; ?>
            <?php if (puedeAccederVista($rolUsuario, 'gestionar_entrega')): ?>
                <a href="index.php?vista=gestionar_entrega">Entregas</a>
            <?php endif; ?>
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
            
            // Módulo de Reportes Administrativos
            case 'reportes':           $ctrlReporte->mostrarReportes(); break;
            
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
                        echo "<div class='alert alert-info'><b>✅ Pedido y detalles registrados exitosamente </b></div>";
                    } elseif ($_GET['msg'] === 'RutaCreada') {
                        echo "<div class='alert alert-info'><b>✅ Hoja de ruta consolidada con éxito. Los pedidos seleccionados han sido asignados al camión correspondiente</b></div>";
                    } elseif ($_GET['msg'] === 'AccesoDenegado') {
                        echo "<div class='alert alert-error'><b>⚠️ Acceso denegado: No cuenta con los privilegios administrativos requeridos</b></div>";
                    }
                }

                // Obtener métricas del dashboard
                require_once "config/conexion.php";
                $conexion = new Conexion();
                $db = $conexion->conectar();

                // Pedidos de hoy
                $queryPedidosHoy = "SELECT COUNT(*) as total FROM pedidos WHERE DATE(fecha_pedido) = CURDATE()";
                $stmtPedidos = $db->query($queryPedidosHoy);
                $totalPedidosHoy = $stmtPedidos->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

                // Rutas activas (rutas con entregas pendientes de confirmar)
                $queryRutasActivas = "SELECT COUNT(DISTINCT r.id_ruta) as total 
                                      FROM rutas_entrega r
                                      INNER JOIN entregas_detalle ed ON r.id_ruta = ed.id_ruta
                                      WHERE DATE(r.fecha_despacho) = CURDATE() 
                                      AND ed.estado_entrega = 'En Ruta'";
                $stmtRutas = $db->query($queryRutasActivas);
                $totalRutasActivas = $stmtRutas->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

                // Total de clientes
                $queryClientes = "SELECT COUNT(*) as total FROM clientes";
                $stmtClientes = $db->query($queryClientes);
                $totalClientes = $stmtClientes->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

                // Total de productos
                $queryProductos = "SELECT COUNT(*) as total FROM productos";
                $stmtProductos = $db->query($queryProductos);
                $totalProductos = $stmtProductos->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
                ?>

                <div class="kpi-grid">
                    <div class="kpi-card">
                        <div class="kpi-icon blue">📦</div>
                        <div class="kpi-details">
                            <h3>Pedidos Hoy</h3>
                            <p><?php echo intval($totalPedidosHoy); ?></p>
                        </div>
                    </div>

                    <div class="kpi-card">
                        <div class="kpi-icon green">🚛</div>
                        <div class="kpi-details">
                            <h3>Rutas Activas</h3>
                            <p><?php echo intval($totalRutasActivas); ?></p>
                        </div>
                    </div>

                    <div class="kpi-card">
                        <div class="kpi-icon orange">👥</div>
                        <div class="kpi-details">
                            <h3>Clientes</h3>
                            <p><?php echo intval($totalClientes); ?></p>
                        </div>
                    </div>

                    <div class="kpi-card">
                        <div class="kpi-icon purple">❄️</div>
                        <div class="kpi-details">
                            <h3>Productos</h3>
                            <p><?php echo intval($totalProductos); ?></p>
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                    <a href="index.php?vista=crear_pedido" class="btn btn-primary">➕ Nuevo Pedido</a>
                    <a href="index.php?vista=crear_ruta" class="btn btn-primary" style="background: #15803d;">🗺️ Asignar Ruta</a>
                   <a href="index.php?vista=listar_productos" class="btn btn-primary">Ver Inventario</a>
                </div>
                <?php
                break;
        }
        ?>
    </main>
</body>
</html>