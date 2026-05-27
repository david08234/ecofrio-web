<h2>Ventas - Tomar Pedido (Maestro-Detalle)</h2>
<?php if(isset($_SESSION['error'])): ?>
    <p style="color: red;"><b>⚠️ <?php echo htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8'); ?></b></p>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>
<?php if(isset($_SESSION['mensaje'])): ?>
    <p style="color: green;"><b>✅ <?php echo htmlspecialchars($_SESSION['mensaje'], ENT_QUOTES, 'UTF-8'); ?></b></p>
    <?php unset($_SESSION['mensaje']); ?>
<?php endif; ?>

<form action="index.php?action=pedidos" method="POST">
    <input type="hidden" name="action" value="guardar_pedido">
    <input type="hidden" name="id_vendedor" value="2"> <h3>Cabecera del Pedido</h3>
    <p>
        <label>ID Cliente:</label><br>
        <input type="number" name="id_cliente" required min="1">
    </p>
    <p>
        <label>Fecha del Pedido:</label><br>
        <input type="date" name="fecha_pedido" value="<?php echo date('Y-m-d'); ?>" required>
    </p>
    <p>
        <label>Dirección Física de Entrega:</label><br>
        <input type="text" name="direccion_entrega" required maxlength="255" size="50">
    </p>
    <p>
        <label>Monto Total General ($):</label><br>
        <input type="number" step="0.01" name="monto_total" min="0" required>
    </p>
    
    <hr>
    <h3>Detalle del Pedido</h3>
    <p>
        <label>ID Producto:</label> 
        <input type="number" name="productos[0][id_producto]" required min="1">
        
        <label>Cantidad:</label> 
        <input type="number" name="productos[0][cantidad]" required min="1">
        
        <label>Precio Unitario ($):</label> 
        <input type="number" step="0.01" name="productos[0][precio_unitario]" required min="0">
    </p>
    <br>
    <button type="submit">Registrar Pedido Completo</button>
</form>