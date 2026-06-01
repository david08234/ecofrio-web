<?php
require_once "controladores/logincontroller.php";
$loginController = new LoginController();
$loginController->logout();
?>