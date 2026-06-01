<div class="form-card">
    <div class="form-card-header">
        <h2>Logística — Alta de Camiones de Distribución</h2>
    </div>
    
    <?php if(isset($_GET['msg']) && $_GET['msg'] === 'VehiculoCreado'): ?>
        <div class="alert alert-info">
            <b>¡Vehículo incorporado a la flota operativa exitosamente!</b>
        </div>
    <?php endif; ?>

    <form action="index.php?action=guardar_vehiculo" method="POST">
        <div class="form-grid">
            <div class="form-group">
                <label>Número de Placa:</label>
                <input type="text" name="placa" placeholder="Ej. 4521-XYZ" required maxlength="15">
            </div>
            
            <div class="form-group">
                <label>Capacidad Máxima de Carga (Kg / Ton):</label>
                <input type="number" step="0.01" name="capacidad_carga" placeholder="Ej. 5000" required>
            </div>

            <div class="form-group full-width">
                <label>Modelo / Descripción:</label>
                <input type="text" name="modelo" placeholder="Ej. Volvo FMX - Camión Frigorífico" required maxlength="100">
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Dar de Alta Vehículo</button>
        </div>
    </form>

    <hr style="border: 0; border-top: 1px solid #d1d5db; margin: 32px 0;">
    
    <h2 style="font-size: 22px; margin-bottom: 16px;">Flota de Vehículos Registrados</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Placa</th>
                <th>Modelo / Tipo</th>
                <th>Capacidad Carga</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vehiculos as $v): ?>
            <tr>
                <td><?php echo $v['id_vehiculo']; ?></td>
                <td><strong><?php echo $v['placa']; ?></strong></td>
                <td><?php echo $v['modelo']; ?></td>
                <td><?php echo $v['capacidad_carga']; ?> Kg</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>