<div class="form-card" style="max-width: 100%; margin: 0;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0; color: #111827;">Inventario - Catálogo de Productos</h2>
        <a href="index.php?vista=crear_producto" class="btn btn-primary">Registrar Nuevo Producto</a>
    </div>

    <table class="custom-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Producto</th>
                <th>Categoría</th>
                <th>Precio Venta ($)</th>
                <th>Stock Actual</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $p): ?>
            <tr>
                <td><?php echo $p['id_producto']; ?></td>
                <td><?php echo $p['nombre']; ?></td>
                <td><?php echo $p['categoria']; ?></td>
                <td><?php echo number_format((float)$p['precio'], 2); ?></td>
                <td><?php echo $p['stock']; ?></td>
                <td>
                    <a href="index.php?vista=editar_producto&id=<?php echo $p['id_producto']; ?>" style="margin-right: 10px;">Editar</a> | 
                    <a href="index.php?action=eliminar_producto&id=<?php echo $p['id_producto']; ?>" onclick="return confirm('¿Seguro de dar de baja este producto del catálogo?')">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>