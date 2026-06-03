<?php
$pdo = new PDO('mysql:host=localhost;dbname=ecofrio_db;charset=utf8mb4','root','');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
foreach ($pdo->query('SELECT DISTINCT rol_puesto FROM usuarios') as $row) {
    echo $row['rol_puesto'] . PHP_EOL;
}
