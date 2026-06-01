<div class="form-card">
    <div class="form-card-header">
        <h2>Registrar Cliente</h2>
    </div>

    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-error">
            <b><?php echo htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8'); ?></b>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    
    <?php if(isset($_SESSION['mensaje'])): ?>
        <div class="alert alert-info">
            <b><?php echo htmlspecialchars($_SESSION['mensaje'], ENT_QUOTES, 'UTF-8'); ?></b>
        </div>
        <?php unset($_SESSION['mensaje']); ?>
    <?php endif; ?>

    <form action="index.php?action=guardar_cliente" method="POST">
        <div class="form-grid">
            <div class="form-group full-width">
                <label>Razón Social:</label>
                <input type="text" name="razon_social" required maxlength="150">
            </div>

            <div class="form-group">
                <label>NIT / Identificación Tributaria:</label>
                <input type="text" name="nit" required maxlength="20">
            </div>

            <div class="form-group">
                <label>Teléfono Celular:</label>
                <input type="text" name="telefono" maxlength="20">
            </div>
        </div>

        <div class="form-actions">
            <a href="index.php?vista=listar_clientes" class="btn btn-cancel">Cancelar</a>
            <button type="submit" class="btn btn-primary">Registrar Cliente</button>
        </div>
    </form>
</div>