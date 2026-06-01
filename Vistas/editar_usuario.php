    <h2>Modificar Ficha del Empleado</h2>
    <form action="index.php?action=actualizar_usuario" method="POST">
        <input type="hidden" name="id_usuario" value="<?php echo $datosUsuario['id_usuario']; ?>">

        <label>Nombre Completo:</label><br>
        <input type="text" name="nombre" value="<?php echo $datosUsuario['nombre']; ?>" required><br><br>

        <label>Correo Electrónico:</label><br>
        <input type="email" name="correo" value="<?php echo $datosUsuario['correo']; ?>" required><br><br>

        <label>Cambiar Rol Organizacional:</label><br>
        <select name="rol_puesto" required>
            <option value="Admin" <?php if($datosUsuario['rol_puesto'] == 'Admin') echo 'selected'; ?>>Administrador</option>
            <option value="Almacen" <?php if($datosUsuario['rol_puesto'] == 'Almacen') echo 'selected'; ?>>Encargado de Almacén</option>
            <option value="Vendedor" <?php if($datosUsuario['rol_puesto'] == 'Vendedor') echo 'selected'; ?>>Área Comercial / Ventas</option>
            <option value="Conductor" <?php if($datosUsuario['rol_puesto'] == 'Conductor') echo 'selected'; ?>>Chofer de Distribución Logística</option>
        </select><br><br>

        <button type="submit">Actualizar Datos</button>
        <a href="index.php?vista=listar_usuarios">Cancelar</a>
    </form>