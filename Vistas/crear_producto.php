<div class="container">
    <h2>Inventario - Alta al Catálogo de Productos</h2>
    
    <?php if(isset($_SESSION['error'])): ?>
        <p style="color: red;"><b>⚠️ <?php echo htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8'); ?></b></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    
    <?php if(isset($_SESSION['mensaje'])): ?>
        <p style="color: green;"><b>✅ <?php echo htmlspecialchars($_SESSION['mensaje'], ENT_QUOTES, 'UTF-8'); ?></b></p>
        <?php unset($_SESSION['mensaje']); ?>
    <?php endif; ?>

    <form action="index.php?action=guardar_producto" method="POST">
        <p>
            <label>Nombre del Producto:</label><br>
            <input type="text" name="nombre" required maxlength="100">
        </p>
        
        <p>
            <label>Categoría:</label><br>
            <input type="text" name="categoria" maxlength="50" placeholder="Ej. Lácteos">
        </p>
        
        <p>
            <label>Precio de Venta ($):</label><br>
            <input type="number" step="0.01" name="precio" min="0" required>
        </p>
        
        <p>
            <label>Stock Inicial:</label><br>
            <input type="number" name="stock" value="0" min="0" required>
        </p>
        
        <br>
        <button type="submit" class="btn-primary">Guardar Producto</button>
        <a href="index.php?vista=listar_productos" style="margin-left: 15px;">Cancelar / Volver a la lista</a>
    </form>
</div>