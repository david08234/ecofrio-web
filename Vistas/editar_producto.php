<div class="container">
    <h2>Editar Producto</h2>

    <form action="index.php?action=actualizar_producto" method="POST">
        <input type="hidden" name="id_producto" value="<?php echo htmlspecialchars($datosProducto['id_producto'], ENT_QUOTES, 'UTF-8'); ?>">

        <p>
            <label>Nombre del Producto:</label><br>
            <input type="text" name="nombre" required maxlength="100" value="<?php echo htmlspecialchars($datosProducto['nombre'], ENT_QUOTES, 'UTF-8'); ?>">
        </p>

        <p>
            <label>Categoría:</label><br>
            <input type="text" name="categoria" maxlength="50" value="<?php echo htmlspecialchars($datosProducto['categoria'], ENT_QUOTES, 'UTF-8'); ?>">
        </p>

        <p>
            <label>Precio de Venta ($):</label><br>
            <input type="number" step="0.01" name="precio" min="0" required value="<?php echo htmlspecialchars($datosProducto['precio'], ENT_QUOTES, 'UTF-8'); ?>">
        </p>

        <p>
            <label>Stock Actual:</label><br>
            <input type="number" name="stock" value="<?php echo htmlspecialchars($datosProducto['stock'], ENT_QUOTES, 'UTF-8'); ?>" min="0" required>
        </p>

        <br>
        <button type="submit" class="btn-primary">Actualizar Producto</button>
        <a href="index.php?vista=listar_productos" style="margin-left: 15px;">Cancelar / Volver a la lista</a>
    </form>
</div>
