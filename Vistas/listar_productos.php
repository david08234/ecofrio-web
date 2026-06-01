<div class="container">
    <h2>Inventario - Catálogo de Productos</h2>
    <a href="index.php?vista=crear_producto" class="btn-primary">Registrar Nuevo Producto</a>
    <br><br>
    <table border="1" cellpadding="10" cellspacing="0" width="100%">
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
                <td><?php echo $p['precio']; ?></td>
                <td><?php echo $p['stock']; ?></td>
                <td>
                    <!-- Dejamos preparado el botón de editar para cuando lo necesites -->
                    <a href="index.php?vista=editar_producto&id=<?php echo $p['id_producto']; ?>">Editar</a> | 
                    <a href="index.php?action=eliminar_producto&id=<?php echo $p['id_producto']; ?>" onclick="return confirm('¿Seguro de dar de baja este producto del catálogo?')">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>