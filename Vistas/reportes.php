<div class="form-card">
    <div class="form-card-header">
        <h2>Reportes Administrativos</h2>
        <p>Exporta datos a hoja de cálculo para clientes, productos y ventas.</p>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error">
            <b>⚠️</b> <?php echo htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8'); ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="report-summary-grid">
        <div class="report-summary-card">
            <h3>Clientes</h3>
            <p><?php echo intval($totales['clientes']); ?> registrados</p>
        </div>
        <div class="report-summary-card">
            <h3>Productos</h3>
            <p><?php echo intval($totales['productos']); ?> en inventario</p>
        </div>
        <div class="report-summary-card">
            <h3>Ventas</h3>
            <p><?php echo intval($totales['ventas']); ?> registros</p>
        </div>
    </div>

    <div class="report-actions" style="display:flex; gap:12px; flex-wrap:wrap; margin-top:24px;">
        <a href="index.php?action=exportar_clientes" class="btn btn-primary">Exportar Clientes</a>
        <a href="index.php?action=exportar_productos" class="btn btn-primary">Exportar Productos</a>
        <a href="index.php?action=exportar_ventas" class="btn btn-primary">Exportar Ventas</a>
    </div>

    <div style="margin-top:20px; font-size:0.95em; color:#475569;">
        Los archivos se descargan en formato CSV, compatible con Excel y otras hojas de cálculo.
    </div>
</div>
