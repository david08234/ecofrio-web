<?php
class Usuario {
    private $conn;
    private $tabla = "usuarios";

    // Propiedades de la entidad
    public $id_usuario;
    public $nombre;
    public $correo;
    public $contrasena;
    public $rol_puesto;
    public $lastError;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerTodos() {
        $query = "SELECT id_usuario, nombre, correo, rol_puesto FROM " . $this->tabla . " ORDER BY id_usuario DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function obtenerPorId($id) {
        $query = "SELECT id_usuario, nombre, correo, rol_puesto FROM " . $this->tabla . " WHERE id_usuario = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerPorUsuarioOCorreo($usuario) {
        $query = "SELECT id_usuario, nombre, correo, contrasena, rol_puesto FROM " . $this->tabla . " WHERE correo = ? OR nombre = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$usuario, $usuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function existeCorreo($correo) {
        $query = "SELECT id_usuario FROM " . $this->tabla . " WHERE correo = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$correo]);
        return (bool) $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function existeCorreoExceptoId($correo, $id) {
        $query = "SELECT id_usuario FROM " . $this->tabla . " WHERE correo = ? AND id_usuario != ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$correo, $id]);
        return (bool) $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear() {
        $query = "INSERT INTO " . $this->tabla . " SET nombre=:nombre, correo=:correo, contrasena=:contrasena, rol_puesto=:rol_puesto";
        $stmt = $this->conn->prepare($query);

        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->correo = htmlspecialchars(strip_tags($this->correo));
        $this->rol_puesto = htmlspecialchars(strip_tags($this->rol_puesto));

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":correo", $this->correo);
        $stmt->bindParam(":contrasena", $this->contrasena); 
        $stmt->bindParam(":rol_puesto", $this->rol_puesto);

        try {
            if ($stmt->execute()) {
                return true;
            }
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
        }

        return false;
    }

    // ACTUALIZAR USUARIO EXISTENTE (UPDATE)
    public function actualizar() {
        $query = "UPDATE " . $this->tabla . " SET nombre=:nombre, correo=:correo, rol_puesto=:rol_puesto WHERE id_usuario=:id_usuario";
        $stmt = $this->conn->prepare($query);

        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->correo = htmlspecialchars(strip_tags($this->correo));
        $this->rol_puesto = htmlspecialchars(strip_tags($this->rol_puesto));
        $this->id_usuario = htmlspecialchars(strip_tags($this->id_usuario));

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":correo", $this->correo);
        $stmt->bindParam(":rol_puesto", $this->rol_puesto);
        $stmt->bindParam(":id_usuario", $this->id_usuario);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // ELIMINAR USUARIO (DELETE)
    public function eliminar($id) {
        if (empty($id) || !is_numeric($id)) {
            return false;
        }

        $query = "DELETE FROM " . $this->tabla . " WHERE id_usuario = ?";
        $stmt = $this->conn->prepare($query);
        $id = (int) $id;
        $stmt->bindValue(1, $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}