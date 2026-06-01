<div class="form-card">
    <div class="form-card-header">
        <h2>Despacho — Asignación de Pedidos a Choferes</h2>
        <p>Asigna un pedido específico a un repartidor de la empresa controlando la exclusividad del transporte.</p>
    </div>

    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-error">
            <b>⚠️ Restricción Logística:</b> <?php echo htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8'); ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if(isset($_SESSION['mensaje'])): ?>
        <div class="alert alert-info">
            <b>✅ Éxito:</b> <?php echo htmlspecialchars($_SESSION['mensaje'], ENT_QUOTES, 'UTF-8'); ?>
            <?php if(isset($_SESSION['ruta_asignada'])): ?>
                <div style="margin-top: 10px; font-size: 0.95em; border-top: 1px solid #cbd5e1; padding-top: 10px;">
                    Pedido asignado: <strong>#<?php echo intval($_SESSION['ruta_asignada']['id_pedido']); ?></strong><br>
                    Ruta creada: <strong>#<?php echo intval($_SESSION['ruta_asignada']['id_ruta']); ?></strong><br>
                    Vehículo: <strong><?php echo htmlspecialchars($_SESSION['ruta_asignada']['placa'], ENT_QUOTES, 'UTF-8'); ?></strong> — <?php echo htmlspecialchars($_SESSION['ruta_asignada']['modelo'], ENT_QUOTES, 'UTF-8'); ?>
                </div>
            <?php endif; ?>
        </div>
        <?php unset($_SESSION['mensaje']); unset($_SESSION['ruta_asignada']); ?>
    <?php endif; ?>

    <form action="index.php?action=guardar_entrega" method="POST">
        <div class="form-grid">
            
            <div class="form-group">
                <label>Chofer / Distribuidor Responsable:</label>
                <select name="id_chofer" required>
                    <option value="">-- Seleccione un Chofer --</option>
                    <?php foreach ($choferes as $ch): ?>
                        <option value="<?php echo $ch['id_usuario']; ?>">
                            <?php echo htmlspecialchars($ch['nombre_completo'], ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Pedido Comercial a Entregar:</label>
                <select name="id_pedido" required>
                    <option value="">-- Seleccione un Pedido Libre --</option>
                    <?php foreach ($pedidosDisponibles as $pe): ?>
                        <option value="<?php echo $pe['id_pedido']; ?>">
                            Pedido #<?php echo $pe['id_pedido']; ?> — <?php echo htmlspecialchars($pe['razon_social'], ENT_QUOTES, 'UTF-8'); ?> (Destino: <?php echo htmlspecialchars($pe['direccion_entrega'], ENT_QUOTES, 'UTF-8'); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group full-width">
                <label>Observaciones de Despacho (Carga / Temperatura / Instrucciones):</label>
                <textarea name="observaciones" rows="3" placeholder="Ej. Llevar en compartimiento frío a -4°C..."></textarea>
            </div>

        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Confirmar y Registrar Entrega Única</button>
        </div>
    </form>
</div>