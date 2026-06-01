<div class="container">
    <h2>Logística — Alta de Camiones de Distribución</h2>
    
    <?php if(isset($_GET['msg']) && $_GET['msg'] === 'VehiculoCreado'): ?>
        <p style="color: green;"><b>✅ ¡Vehículo incorporado a la flota operativa exitosamente!</b></p>
    <?php endif; ?>

    <form action="index.php?action=guardar_vehiculo" method="POST">
        <p>
            <label>Número de Placa:</label><br>
            <input type="text" name="placa" placeholder="Ej. 4521-XYZ" required maxlength="15">
        </p>
        <p>
            <label>Modelo / Descripción:</label><br>
            <input type="text" name="modelo" placeholder="Ej. Volvo FMX - Camión Frigorífico" required maxlength="100">
        </p>
        <p>
            <label>Capacidad Máxima de Carga (Kg / Ton):</label><br>
            <input type="number" step="0.01" name="capacidad_carga" placeholder="Ej. 5000" required>
        </p>
        <button type="submit" class="btn-primary">Dar de Alta Vehículo</button>
    </form>

    <br><br>
    <h3>Flota de Vehículos Registrados</h3>
    <table border="1" cellpadding="8" cellspacing="0" width="100%">
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