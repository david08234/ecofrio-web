<div class="form-card" style="max-width: 100%;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0; color: #111827;">Gestión de Personal Activo</h2>
        <a href="index.php?vista=crear_usuario" class="btn btn-primary">Registrar Nuevo Usuario</a>
    </div>

    <table class="custom-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $u): ?>
            <tr>
                <td><?php echo $u['id_usuario']; ?></td>
                <td><?php echo $u['nombre']; ?></td>
                <td><?php echo $u['correo']; ?></td>
                <td><?php echo $u['rol_puesto']; ?></td>
                <td>
                    <a href="index.php?vista=editar_usuario&id=<?php echo $u['id_usuario']; ?>" style="margin-right: 10px;">Editar</a> | 
                    <a href="index.php?action=eliminar_usuario&id=<?php echo $u['id_usuario']; ?>" 
                       onclick="return confirm('¿Seguro?')">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>