<?php
declare(strict_types=1);
require_once "modelos/usuario.php";

class UsuarioController {
    public function registrar(): void {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST['action'] ?? '') === 'guardar_usuario') {
            
            $nombre = isset($_POST['nombre']) ? trim(htmlspecialchars($_POST['nombre'], ENT_QUOTES, 'UTF-8')) : '';
            $correo = isset($_POST['correo']) ? filter_var(trim($_POST['correo']), FILTER_VALIDATE_EMAIL) : false;
            $contrasena = isset($_POST['contrasena']) ? trim($_POST['contrasena']) : '';
            $rol = isset($_POST['rol_puesto']) ? trim($_POST['rol_puesto']) : '';

            if ($nombre === '' || $contrasena === '') {
                $_SESSION['error'] = "El nombre y la contraseña no pueden estar vacíos.";
                header("Location: index.php?vista=crear_usuario"); exit();
            }
            if ($correo === false) {
                $_SESSION['error'] = "El formato de correo no es válido.";
                header("Location: index.php?vista=crear_usuario"); exit();
            }
            
            $rolesValidos = ['Admin', 'Almacen', 'Vendedor', 'Conductor'];
            if (!in_array($rol, $rolesValidos, true)) {
                $_SESSION['error'] = "Rol inválido.";
                header("Location: index.php?vista=crear_usuario"); exit();
            }

            $user = new Usuario(null, $nombre, $correo, password_hash($contrasena, PASSWORD_BCRYPT), $rol);
            $_SESSION['mensaje'] = "Usuario '" . $user->obtenerNombre() . "' listo para la base de datos.";
            header("Location: index.php?vista=crear_usuario"); exit();
        }
    }
}