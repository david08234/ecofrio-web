<div class="form-card" style="max-width: 100%;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0; color: #111827;">Gestión de Clientes EcoFrío</h2>
        <a href="index.php?vista=crear_cliente" class="btn btn-primary">Registrar Nuevo Cliente</a>
    </div>

    <table class="custom-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Razón Social</th>
                <th>NIT</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientes as $c): ?>
            <tr>
                <td><?php echo $c['id_cliente']; ?></td>
                <td><?php echo $c['razon_social']; ?></td>
                <td><?php echo $c['nit']; ?></td>
                <td><?php echo $c['telefono']; ?></td>
                <td>
                    <a href="index.php?vista=editar_cliente&id=<?php echo $c['id_cliente']; ?>" style="margin-right: 10px;">Editar</a> |
                    <a href="index.php?action=eliminar_cliente&id=<?php echo $c['id_cliente']; ?>" onclick="return confirm('¿Seguro?')">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>