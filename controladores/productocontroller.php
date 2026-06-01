<?php
require_once "config/conexion.php";
require_once "modelos/producto.php";

class ProductoController {
    private $db;
    private $producto;

    public function __construct() {
        $this->db = (new Conexion())->conectar();
        $this->producto = new Producto($this->db);
    }

    public function listar() {
        $resultado = $this->producto->obtenerTodos();
        $productos = $resultado->fetchAll(PDO::FETCH_ASSOC);
        require_once "Vistas/listar_productos.php";
    }

    public function registrar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->producto->nombre = $_POST['nombre'];
            $this->producto->categoria = $_POST['categoria'];
            $this->producto->precio = $_POST['precio'];
            $this->producto->stock = $_POST['stock'];
            
            if ($this->producto->crear()) {
                $_SESSION['mensaje'] = 'Producto creado correctamente.';
                header("Location: index.php?vista=listar_productos");
                exit();
            }

            $_SESSION['error'] = 'No fue posible crear el producto.';
            header("Location: index.php?vista=crear_producto");
            exit();
        }
    }

    public function mostrarCrear() {
        require_once "Vistas/crear_producto.php";
    }

    public function mostrarEditar($id) {
        $datosProducto = $this->producto->obtenerPorId($id);
        if ($datosProducto) {
            require_once "Vistas/editar_producto.php";
        } else {
            echo "Producto no encontrado.";
        }
    }

    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->producto->id_producto = $_POST['id_producto'];
            $this->producto->nombre = $_POST['nombre'];
            $this->producto->categoria = $_POST['categoria'];
            $this->producto->precio = $_POST['precio'];
            $this->producto->stock = $_POST['stock'];

            if ($this->producto->actualizar()) {
                $_SESSION['mensaje'] = 'Producto actualizado correctamente.';
                header("Location: index.php?vista=listar_productos");
                exit();
            }
            $_SESSION['error'] = 'No fue posible actualizar el producto.';
            header("Location: index.php?vista=editar_producto&id=" . $this->producto->id_producto);
            exit();
        }
    }

    public function eliminar($id) {
        if ($this->producto->eliminar($id)) {
            $_SESSION['mensaje'] = 'Producto eliminado.';
        } else {
            $_SESSION['error'] = 'No fue posible eliminar el producto.';
        }
        header("Location: index.php?vista=listar_productos");
        exit();
    }
}
?>