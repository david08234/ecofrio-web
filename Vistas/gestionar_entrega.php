<div class="container">
    <h2>Despacho — Asignación de Pedidos a Choferes</h2>
    <p>Asigna un pedido específico a un repartidor de la empresa controlando la exclusividad del transporte.</p>

    <?php if(isset($_SESSION['error'])): ?>
        <div style="background-color: #f8d7da; color: #721c24; padding: 12px; border: 1px solid #f5c6cb; border-radius: 4px; margin-bottom: 15px;">
            <b>⚠️ Restricción Logística:</b> <?php echo htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8'); ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if(isset($_SESSION['mensaje'])): ?>
        <div style="background-color: #d4edda; color: #155724; padding: 12px; border: 1px solid #c3e6cb; border-radius: 4px; margin-bottom: 15px;">
            <b>✅ Éxito:</b> <?php echo htmlspecialchars($_SESSION['mensaje'], ENT_QUOTES, 'UTF-8'); ?>
            <?php if(isset($_SESSION['ruta_asignada'])): ?>
                <div style="margin-top: 10px; font-size: 0.95em; color: #155724;">
                    Pedido asignado: <strong>#<?php echo intval($_SESSION['ruta_asignada']['id_pedido']); ?></strong><br>
                    Ruta creada: <strong>#<?php echo intval($_SESSION['ruta_asignada']['id_ruta']); ?></strong><br>
                    Vehículo: <strong><?php echo htmlspecialchars($_SESSION['ruta_asignada']['placa'], ENT_QUOTES, 'UTF-8'); ?></strong> — <?php echo htmlspecialchars($_SESSION['ruta_asignada']['modelo'], ENT_QUOTES, 'UTF-8'); ?>
                </div>
            <?php endif; ?>
        </div>
        <?php unset($_SESSION['mensaje']); unset($_SESSION['ruta_asignada']); ?>
    <?php endif; ?>

    <form action="index.php?action=guardar_entrega" method="POST">
        <fieldset>
            <legend>Asignar Operador de Reparto</legend>
            <p>
                <label>Chofer / Distribuidor Responsable:</label><br>
                <select name="id_chofer" required>
                    <option value="">-- Seleccione un Chofer --</option>
                    <?php foreach ($choferes as $ch): ?>
                        <option value="<?php echo $ch['id_usuario']; ?>">
                            <?php echo htmlspecialchars($ch['nombre_completo'], ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </p>

            <p>
                <label>Pedido Comercial a Entregar:</label><br>
                <select name="id_pedido" required>
                    <option value="">-- Seleccione un Pedido Libre --</option>
                    <?php foreach ($pedidosDisponibles as $pe): ?>
                        <option value="<?php echo $pe['id_pedido']; ?>">
                            Pedido #<?php echo $pe['id_pedido']; ?> — <?php echo htmlspecialchars($pe['razon_social'], ENT_QUOTES, 'UTF-8'); ?> (Destino: <?php echo htmlspecialchars($pe['direccion_entrega'], ENT_QUOTES, 'UTF-8'); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </p>

            <p>
                <label>Observaciones de Despacho (Carga / Temperatura / Instrucciones):</label><br>
                <textarea name="observaciones" rows="3" style="width: 100%;" placeholder="Ej. Llevar en compartimiento frío a -4°C..."></textarea>
            </p>
        </fieldset>

        <br>
        <button type="submit" class="btn-primary" style="padding: 10px 20px;">Confirmar y Registrar Entrega Única</button>
    </form>
</div>