<div class="form-card">
    <div class="form-card-header">
        <h2>Registrar Personal en la Plataforma</h2>
    </div>

    <form action="index.php?action=guardar_usuario" method="POST">
        <div class="form-grid">
            <div class="form-group">
                <label>Nombre Completo:</label>
                <input type="text" name="nombre" required>
            </div>

            <div class="form-group">
                <label>Correo Electrónico:</label>
                <input type="email" name="correo" required>
            </div>

            <div class="form-group">
                <label>Contraseña Provisional:</label>
                <input type="password" name="contrasena" required>
            </div>

            <div class="form-group">
                <label>Rol asignado dentro de EcoFrío:</label>
                <select name="rol_puesto" required>
                    <option value="Admin">Administrador (Acceso Completo)</option>
                    <option value="Almacen">Encargado de Almacén</option>
                    <option value="Vendedor">Área Comercial / Ventas</option>
                    <option value="Conductor">Chofer de Distribución Logística</option>
                </select>
            </div>
        </div>

        <div class="form-actions">
            <a href="index.php?vista=listar_usuarios" class="btn btn-cancel">Cancelar</a>
            <button type="submit" class="btn btn-primary">Guardar Registro</button>
        </div>
    </form>
</div>