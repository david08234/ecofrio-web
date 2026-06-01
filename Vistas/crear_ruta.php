<div class="form-card">
    <div class="form-card-header">
        <h2>Despacho — Planificación y Agrupación de Rutas</h2>
        <p>Agrupar los pedidos comerciales pendientes en una jornada de transporte específica.</p>
    </div>

    <form action="index.php?action=guardar_ruta" method="POST">
        
        <div class="form-grid">
            <div class="form-group">
                <label>Seleccionar Vehículo / Camión:</label>
                <select name="id_vehiculo" required>
                    <option value="">-- Seleccione un Camión Disponible --</option>
                    <?php foreach ($vehiculos as $v): ?>
                        <option value="<?php echo $v['id_vehiculo']; ?>">
                            <?php echo $v['placa']; ?> — <?php echo $v['modelo']; ?> (Capacidad: <?php echo $v['capacidad_carga']; ?> Kg)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Fecha Programada de Salida:</label>
                <input type="date" name="fecha_ruta" value="<?php echo date('Y-m-d'); ?>" required>
            </div>
        </div>

        <hr style="border: 0; border-top: 1px solid #d1d5db; margin: 32px 0;">
        
        <h2 style="font-size: 20px; margin-bottom: 16px; color: #111827;">Pedidos Pendientes de Consolidación</h2>
        
        <table>
            <thead>
                <tr>
                    <th width="5%" style="text-align: center;">Seleccionar</th>
                    <th>ID Pedido</th>
                    <th>Cliente / Razón Social</th>
                    <th>Dirección de Destino</th>
                    <th>Monto Total ($)</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($pedidosPendientes)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; color: gray; padding: 20px;">
                            No existen pedidos pendientes de distribución en este momento.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($pedidosPendientes as $p): ?>
                    <tr>
                        <td style="text-align: center;">
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

        <div class="form-actions" style="margin-top: 24px;">
            <button type="submit" class="btn btn-primary" style="width: 100%;">
                Generar Hoja de Ruta y Despachar Unidades
            </button>
        </div>
    </form>
</div>