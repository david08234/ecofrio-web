<div class="contenedor-flotante">
    
    <h2>Comercial - Registrar Cliente</h2>

    <?php if(isset($_SESSION['error'])): ?>
        <p class="mensaje-error"><b> <?php echo htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8'); ?></b></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    
    <?php if(isset($_SESSION['mensaje'])): ?>
        <p class="mensaje-exito"><b> <?php echo htmlspecialchars($_SESSION['mensaje'], ENT_QUOTES, 'UTF-8'); ?></b></p>
        <?php unset($_SESSION['mensaje']); ?>
    <?php endif; ?>

    <form action="index.php?action=clientes" method="POST">
        <input type="hidden" name="action" value="guardar_cliente">
        
        <label>Razón Social:</label>
        <input type="text" name="razon_social" required maxlength="150">
        
        <label>NIT / Identificación Tributaria:</label>
        <input type="text" name="nit" required maxlength="20">
        
        <label>Teléfono Celular:</label>
        <input type="text" name="telefono" maxlength="20">
        
        <button type="submit">Registrar Cliente</button>
    </form>
    
</div>