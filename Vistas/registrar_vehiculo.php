<h2>Logística - Control de Vehículos de la Flota</h2>
<?php if(isset($_SESSION['error'])): ?>
    <p style="color: red;"><b>⚠️ <?php echo htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8'); ?></b></p>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>
<?php if(isset($_SESSION['mensaje'])): ?>
    <p style="color: green;"><b>✅ <?php echo htmlspecialchars($_SESSION['mensaje'], ENT_QUOTES, 'UTF-8'); ?></b></p>
    <?php unset($_SESSION['mensaje']); ?>
<?php endif; ?>

<form action="index.php?action=vehiculos" method="POST">
    <input type="hidden" name="action" value="guardar_vehiculo">
    <p>
        <label>Placa de Control:</label><br>
        <input type="text" name="placa" required maxlength="15" placeholder="Ej. 1024-YTB">
    </p>
    <p>
        <label>Modelo / Marca:</label><br>
        <input type="text" name="modelo" maxlength="50" placeholder="Ej. Foton 2025">
    </p>
    <p>
        <label>Capacidad Máxima de Carga (KG):</label><br>
        <input type="number" step="0.01" name="capacidad_carga_kg" min="0">
    </p>
    <button type="submit">Dar de Alta Vehículo</button>
</form>