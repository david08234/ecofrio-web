<?php
require_once "config/conexion.php";
require_once "modelos/usuario.php";
class UsuarioController {
    private $db;
    private $usuario;

    public function __construct() {
        $conexion = new Conexion();
        $this->db = $conexion->conectar();
        $this->usuario = new Usuario($this->db);
    }

    // Listar todos los usuarios
    public function listar() {
        $resultado = $this->usuario->obtenerTodos();
        $usuarios = $resultado->fetchAll(PDO::FETCH_ASSOC);
        require_once "Vistas/listar_usuario.php";
    }

    // Mostrar formulario de creación
    public function mostrarCrear() {
        require_once "Vistas/crear_usuario.php";
    }

    // Procesar inserción
    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $correo = trim($_POST['correo'] ?? '');
            $contrasena = $_POST['contrasena'] ?? '';
            $rol_puesto = $_POST['rol_puesto'] ?? '';

            if ($nombre === '' || $correo === '' || $contrasena === '' || $rol_puesto === '') {
                echo "Error al registrar el usuario: todos los campos son obligatorios.";
                return;
            }

            if ($this->usuario->existeCorreo($correo)) {
                echo "Error al registrar el usuario: el correo ya está registrado.";
                return;
            }

            $this->usuario->nombre = $nombre;
            $this->usuario->correo = $correo;
            $this->usuario->contrasena = $contrasena;
            $this->usuario->rol_puesto = $rol_puesto;

            if ($this->usuario->crear()) {
                header("Location: index.php?vista=listar_usuarios");
                exit();
            } else {
                $error = $this->usuario->lastError ? ' - ' . htmlspecialchars($this->usuario->lastError) : '';
                echo "Error al registrar el usuario." . $error;
            }
        }
    }

    // Mostrar formulario de edición con datos cargados
    public function mostrarEditar($id) {
        $datosUsuario = $this->usuario->obtenerPorId($id);
        if ($datosUsuario) {
            require_once "Vistas/editar_usuario.php";
        } else {
            echo "Usuario no encontrado.";
        }
    }

    // Procesar actualización
    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->usuario->id_usuario = $_POST['id_usuario'];
            $this->usuario->nombre = $_POST['nombre'];
            $this->usuario->correo = $_POST['correo'];
            $this->usuario->rol_puesto = $_POST['rol_puesto'];

            if ($this->usuario->existeCorreoExceptoId($this->usuario->correo, $this->usuario->id_usuario)) {
                echo "Error al actualizar el usuario: el correo ya está registrado por otro usuario.";
                return;
            }

            if ($this->usuario->actualizar()) {
                header("Location: index.php?vista=listar_usuarios");
                exit();
            } else {
                echo "Error al actualizar el usuario.";
            }
        }
    }

    // Procesar eliminación
    public function eliminar($id) {
        if ($this->usuario->eliminar($id)) {
            header("Location: index.php?vista=listar_usuarios");
            exit();
        } else {
            echo "Error al eliminar el usuario.";
        }
    }
}
