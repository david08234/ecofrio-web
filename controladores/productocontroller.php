<?php
declare(strict_types=1);
require_once "modelos/producto.php";

class ProductoController {
    public function registrar(): void {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST['action'] ?? '') === 'guardar_producto') {
            
            $nombre = isset($_POST['nombre_producto']) ? trim(htmlspecialchars($_POST['nombre_producto'], ENT_QUOTES, 'UTF-8')) : '';
            $categoria = isset($_POST['categoria']) ? trim(htmlspecialchars($_POST['categoria'], ENT_QUOTES, 'UTF-8')) : null;
            if ($categoria === '') { $categoria = null; }

            if ($nombre === '') {
                $_SESSION['error'] = "Nombre de producto requerido.";
                header("Location: index.php?vista=crear_producto"); exit();
            }

            $precio = isset($_POST['precio_venta']) ? filter_var($_POST['precio_venta'], FILTER_VALIDATE_FLOAT) : false;
            $stock = isset($_POST['stock']) ? filter_var($_POST['stock'], FILTER_VALIDATE_INT) : false;

            if ($precio === false || $precio < 0 || $stock === false || $stock < 0) {
                $_SESSION['error'] = "Precio y stock deben ser numéricos positivos.";
                header("Location: index.php?vista=crear_producto"); exit();
            }

            $prod = new Producto(null, $nombre, $categoria, $precio, $stock);
            $_SESSION['mensaje'] = "Producto '" . $prod->obtenerNombre() . "' validado correctamente.";
            header("Location: index.php?vista=crear_producto"); exit();
        }
    }
}