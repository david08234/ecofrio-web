<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login - EcoFrío</title>
  <link rel="stylesheet" href="estilos.css">
</head>
<body>

  <div class="pagina">
    <div class="contenedor-login">

      <h1>Sistema Logístico EcoFrío</h1>

      <form action="procesar_login.php" method="POST">

        <label for="usuario">Usuario o Correo:</label>
        <input type="text" id="usuario" name="usuario" >

        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" >

        <input type="submit" value="Ingresar">

      </form>

    </div>
    <p class="pie">EcoFrío &copy; 2026 &mdash; Sistema de Gestión Logística</p>
  </div>

</body>
</html>