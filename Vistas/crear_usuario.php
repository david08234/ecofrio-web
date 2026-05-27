<h2>Registrar Usuario</h2>

<?php if(isset($_SESSION['error'])): ?>
    <p style="color: red;"><b> <?php echo htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8'); ?></b></p>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>
<?php if(isset($_SESSION['mensaje'])): ?>
    <p style="color: green;"><b> <?php echo htmlspecialchars($_SESSION['mensaje'], ENT_QUOTES, 'UTF-8'); ?></b></p>
    <?php unset($_SESSION['mensaje']); ?>
<?php endif; ?>

<form action="index.php?action=usuarios" method="POST">
    <input type="hidden" name="action" value="guardar_usuario">
    
        <label>Nombre Completo:</label><br>
        <input type="text" name="nombre" required maxlength="100"><br><br>
   
    
        <label>Correo Electrónico:</label><br>
        <input type="email" name="correo" required maxlength="100"><br><br>
   
    
        <label>Contraseña:</label><br>
        <input type="password" name="contrasena" required><br><br>
   
    
        <label>Rol / Puesto en Sistema:</label><br>
        <select name="rol_puesto" required>
            <option value="" disabled selected>-- Seleccione --</option>
            <option value="Admin">Administrador</option>
            <option value="Almacen">Encargado de Almacén</option>
            <option value="Vendedor">Vendedor</option>
            <option value="Conductor">Conductor</option>
        </select><br><br>
   
    <button type="submit">Guardar Usuario</button>
</form>