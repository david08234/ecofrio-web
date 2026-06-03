<?php
require_once "config/conexion.php";
require_once "modelos/reporte.php";

class ReportController {
    private $db;
    private $reporte;

    public function __construct() {
        $this->db = (new Conexion())->conectar();
        $this->reporte = new Reporte($this->db);
    }

    public function mostrarReportes() {
        $totales = [
            'clientes' => $this->reporte->contarClientes(),
            'productos' => $this->reporte->contarProductos(),
            'ventas' => $this->reporte->contarVentas(),
        ];
        require_once "Vistas/reportes.php";
    }

    public function exportarClientes() {
        $filename = 'clientes_export_' . date('Ymd_His') . '.csv';
        $datos = $this->reporte->obtenerClientes();
        $columnas = ['ID', 'Razón Social', 'NIT', 'Teléfono'];
        $filas = array_map(function ($row) {
            return [
                $row['id_cliente'],
                $row['razon_social'],
                $row['nit'],
                $row['telefono'],
            ];
        }, $datos);
        $this->exportarCSV($columnas, $filas, $filename);
    }

    public function exportarProductos() {
        $filename = 'productos_export_' . date('Ymd_His') . '.csv';
        $datos = $this->reporte->obtenerProductos();
        $columnas = ['ID', 'Producto', 'Categoría', 'Precio', 'Stock'];
        $filas = array_map(function ($row) {
            return [
                $row['id_producto'],
                $row['nombre'],
                $row['categoria'],
                $row['precio'],
                $row['stock'],
            ];
        }, $datos);
        $this->exportarCSV($columnas, $filas, $filename);
    }

    public function exportarVentas() {
        $filename = 'ventas_export_' . date('Ymd_His') . '.csv';
        $datos = $this->reporte->obtenerVentas();
        $columnas = ['ID Pedido', 'Cliente', 'NIT', 'Dirección', 'Monto Total', 'Estado', 'Fecha'];
        $filas = array_map(function ($row) {
            return [
                $row['id_pedido'],
                $row['razon_social'],
                $row['nit'],
                $row['direccion_entrega'],
                $row['monto_total'],
                $row['estado_pedido'],
                $row['fecha_pedido'],
            ];
        }, $datos);
        $this->exportarCSV($columnas, $filas, $filename);
    }

    private function exportarCSV(array $cabeceras, array $filas, string $filename) {
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        echo "\xEF\xBB\xBF"; // BOM para Excel

        $output = fopen('php://output', 'w');
        fputcsv($output, $cabeceras);

        foreach ($filas as $fila) {
            fputcsv($output, $fila);
        }

        fclose($output);
        exit();
    }
}
?>