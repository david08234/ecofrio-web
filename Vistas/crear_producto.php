<div class="form-card">
    <div class="form-card-header">
        <h2>Inventario - Alta al Catálogo de Productos</h2>
    </div>
    
    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-error">
            <b> <?php echo htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8'); ?></b>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    
    <?php if(isset($_SESSION['mensaje'])): ?>
        <div class="alert alert-info">
            <b> <?php echo htmlspecialchars($_SESSION['mensaje'], ENT_QUOTES, 'UTF-8'); ?></b>
        </div>
        <?php unset($_SESSION['mensaje']); ?>
    <?php endif; ?>

    <form action="index.php?action=guardar_producto" method="POST">
        <div class="form-grid">
            <div class="form-group full-width">
                <label>Nombre del Producto:</label>
                <input type="text" name="nombre" required maxlength="100">
            </div>
            
            <div class="form-group">
                <label>Categoría:</label>
                <input type="text" name="categoria" maxlength="50" placeholder="Ej. Lácteos">
            </div>
            
            <div class="form-group">
                <label>Precio de Venta ($):</label>
                <input type="number" step="0.01" name="precio" min="0" required>
            </div>
            
            <div class="form-group">
                <label>Stock Inicial:</label>
                <input type="number" name="stock" value="0" min="0" required>
            </div>
        </div>
        
        <div class="form-actions">
            <a href="index.php?vista=listar_productos" class="btn btn-cancel">Cancelar / Volver a la lista</a>
            <button type="submit" class="btn btn-primary">Guardar Producto</button>
        </div>
    </form>
</div>