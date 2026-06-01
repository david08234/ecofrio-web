<?php
session_start();
if (isset($_SESSION['id_usuario'])) {
    header('Location: index.php');
    exit();
}
require_once __DIR__ . '/views/login.php';
