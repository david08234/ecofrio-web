<h2>Logística Última Milla - Vincular Pedido a Ruta (1:1)</h2>
<?php if(isset($_SESSION['error'])): ?>
    <p style="color: red;"><b>⚠️ <?php echo htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8'); ?></b></p>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>
<?php if(isset($_SESSION['mensaje'])): ?>
    <p style="color: green;"><b>✅ <?php echo htmlspecialchars($_SESSION['mensaje'], ENT_QUOTES, 'UTF-8'); ?></b></p>
    <?php unset($_SESSION['mensaje']); ?>
<?php endif; ?>

<form action="index.php?action=entregas" method="POST">
    <input type="hidden" name="action" value="guardar_entrega">
    <p>
        <label>ID Hoja de Ruta:</label><br>
        <input type="number" name="id_ruta" required min="1">
    </p>
    <p>
        <label>ID Pedido Correlativo:</label><br>
        <input type="number" name="id_pedido" required min="1">
    </p>
    <p>
        <label>Estado Inicial del Despacho:</label><br>
        <select name="estado_entrega" required>
            <option value="En Ruta" selected>En Ruta</option>
            <option value="Entregado Exitoso">Entregado Exitoso</option>
            <option value="Con Incidencia">Con Incidencia</option>
        </select>
    </p>
    <p>
        <label>Novedades / Incidencias en Ruta:</label><br>
        <textarea name="incidencias" rows="4" cols="45" placeholder="Opcional: roturas, retrasos..."></textarea>
    </p>
    <button type="submit">Confirmar Entrega</button>
</form>