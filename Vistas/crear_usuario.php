    <h2>Registrar Personal en la Plataforma</h2>
    <form action="index.php?action=guardar_usuario" method="POST">
        <label>Nombre Completo:</label><br>
        <input type="text" name="nombre" required><br><br>

        <label>Correo Electrónico:</label><br>
        <input type="email" name="correo" required><br><br>

        <label>Contraseña Provisional:</label><br>
        <input type="password" name="contrasena" required><br><br>

        <label>Rol asignado dentro de EcoFrío:</label><br>
        <select name="rol_puesto" required>
            <option value="Admin">Administrador (Acceso Completo)</option>
            <option value="Almacen">Encargado de Almacén</option>
            <option value="Vendedor">Área Comercial / Ventas</option>
            <option value="Conductor">Chofer de Distribución Logística</option>
        </select><br><br>

        <button type="submit">Guardar Registro</button>
        <a href="index.php?vista=listar_usuarios">Cancelar</a>
    </form>