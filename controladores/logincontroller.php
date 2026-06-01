<?php
require_once "config/conexion.php";
require_once "modelos/usuario.php";

class LoginController {
    private $db;
    private $usuario;

    public function __construct() {
        $this->db = (new Conexion())->conectar();
        $this->usuario = new Usuario($this->db);
    }

    public function procesarLogin() {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: login.php');
            exit();
        }

        $identificador = trim($_POST['usuario'] ?? '');
        $contrasena = $_POST['contrasena'] ?? '';

        if ($identificador === '' || $contrasena === '') {
            header('Location: login.php?error=1');
            exit();
        }

        $usuario = $this->usuario->obtenerPorUsuarioOCorreo($identificador);

        if ($usuario && $usuario['contrasena'] === $contrasena) {
            session_regenerate_id(true);
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['rol_puesto'] = $usuario['rol_puesto'];
            $_SESSION['nombre'] = $usuario['nombre'];
            header('Location: index.php');
            exit();
        }

        header('Location: login.php?error=1');
        exit();
    }

    public function logout() {
        session_start();
        $_SESSION = [];
        session_destroy();
        header('Location: login.php');
        exit();
    }
}
?>