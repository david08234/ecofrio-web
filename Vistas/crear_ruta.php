<div class="container">
    <h2>Despacho — Planificación y Agrupación de Rutas</h2>
    <p>Agrupar los pedidos comerciales pendientes en una jornada de transporte específica.</p>

    <form action="index.php?action=guardar_ruta" method="POST">
        <fieldset>
            <legend>Asignación de Transporte</legend>
            <p>
                <label>Seleccionar Vehículo / Camión:</label><br>
                <select name="id_vehiculo" required>
                    <option value="">-- Seleccione un Camión Disponible --</option>
                    <?php foreach ($vehiculos as $v): ?>
                        <option value="<?php echo $v['id_vehiculo']; ?>">
                            <?php echo $v['placa']; ?> — <?php echo $v['modelo']; ?> (Capacidad: <?php echo $v['capacidad_carga']; ?> Kg)
                        </option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                <label>Fecha Programada de Salida:</label><br>
                <input type="date" name="fecha_ruta" value="<?php echo date('Y-m-d'); ?>" required>
            </p>
        </fieldset>

        <br>
        <h3>Pedidos Pendientes de Consolidación</h3>
        <table border="1" cellpadding="8" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="5%">Seleccionar</th>
                    <th>ID Pedido</th>
                    <th>Cliente / Razón Social</th>
                    <th>Dirección de Destino</th>
                    <th>Monto Total ($)</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($pedidosPendientes)): ?>
                    <tr>
                        <td colspan="5" align="center" style="color: gray; padding: 20px;">
                            No existen pedidos pendientes de distribución en este momento.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($pedidosPendientes as $p): ?>
                    <tr>
                        <td align="center">
                            <input type="checkbox" name="pedidos[]" value="<?php echo $p['id_pedido']; ?>">
                        </td>
                        <td>#<?php echo $p['id_pedido']; ?></td>
                        <td><?php echo htmlspecialchars($p['razon_social'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($p['direccion_entrega'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>$<?php echo number_format((float)$p['monto_total'], 2); ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <br>
        <button type="submit" class="btn-primary" style="width: 100%; padding: 12px; font-size: 16px;">
            Generar Hoja de Ruta y Despachar Unidades
        </button>
    </form>
</div>