<?php
// Incluimos el archivo que acabamos de crear
require_once 'config/conexion.php';

// Llamamos a la función
$db = conectarDB();

if ($db !== null) {
    echo "<h2 style='color: green;'>¡Felicidades Grupo! La conexión con Laragon funciona perfectamente.</h2>";
} else {
    echo "<h2 style='color: red;'>La conexión falló. Verifica que Laragon esté iniciado.</h2>";
}
?>