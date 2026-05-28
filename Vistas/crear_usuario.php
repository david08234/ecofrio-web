<div class="contenedor-flotante">
    
    <h2>Registrar Usuario</h2>

    <?php if(isset($_SESSION['error'])): ?>
        <p class="mensaje-error"><b> <?php echo htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8'); ?></b></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    
    <?php if(isset($_SESSION['mensaje'])): ?>
        <p class="mensaje-exito"><b> <?php echo htmlspecialchars($_SESSION['mensaje'], ENT_QUOTES, 'UTF-8'); ?></b></p>
        <?php unset($_SESSION['mensaje']); ?>
    <?php endif; ?>

    <form action="index.php?action=usuarios" method="POST">
        <input type="hidden" name="action" value="guardar_usuario">
        
        <label>Nombre Completo:</label>
        <input type="text" name="nombre" required maxlength="100">
        
        <label>Correo Electrónico:</label>
        <input type="email" name="correo" required maxlength="100">
        
        <label>Contraseña:</label>
        <input type="password" name="contrasena" required>
        
        <label>Rol / Puesto en Sistema:</label>
        <select name="rol_puesto" required>
            <option value="" disabled selected>-- Seleccione --</option>
            <option value="Admin">Administrador</option>
            <option value="Almacen">Encargado de Almacén</option>
            <option value="Vendedor">Vendedor</option>
            <option value="Conductor">Conductor</option>
        </select>
        
        <button type="submit">Guardar Usuario</button>
    </form>

</div>