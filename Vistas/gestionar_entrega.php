<div class="form-card" style="max-width: 700px;"> <div class="form-card-header">
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

    <?php $rolUsuario = $_SESSION['rol_puesto'] ?? ''; ?>

    <?php if ($rolUsuario === 'Conductor'): ?>
        <div class="form-card" style="box-shadow: none; padding: 0; margin: 0;"> <div class="form-card-header" style="margin-top: 20px;">
                <h2 style="font-size: 20px;">Entregas Asignadas</h2>
                <p>Aquí aparecen las entregas que debes realizar y puedes confirmar cuando se completen.</p>
            </div>

            <?php if (empty($entregasAsignadas)): ?>
                <div class="alert alert-info">No tienes entregas asignadas en este momento.</div>
            <?php else: ?>
                <div style="overflow-x: auto;">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Pedido</th>
                                <th>Cliente</th>
                                <th>Destino</th>
                                <th>Fecha Ruta</th>
                                <th>Estado</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($entregasAsignadas as $entrega): ?>
                                <tr>
                                    <td><strong>#<?php echo intval($entrega['id_pedido']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($entrega['razon_social'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($entrega['direccion_entrega'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($entrega['fecha_despacho'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td>
                                        <span class="badge <?php echo ($entrega['estado_entrega'] === 'En Ruta') ? 'badge-almacen' : 'badge-admin'; ?>">
                                            <?php echo htmlspecialchars($entrega['estado_entrega'], ENT_QUOTES, 'UTF-8'); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($entrega['estado_entrega'] === 'En Ruta'): ?>
                                            <form action="index.php?action=confirmar_entrega" method="POST" style="margin:0;">
                                                <input type="hidden" name="id_pedido" value="<?php echo intval($entrega['id_pedido']); ?>">
                                                <button type="submit" class="btn btn-primary" style="padding: 8px 12px; font-size: 13px;">Confirmar</button>
                                            </form>
                                        <?php else: ?>
                                            <span style="color: #15803d; font-weight: bold;">✔ Completado</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <form action="index.php?action=guardar_entrega" method="POST">
            <div class="form-grid">
                
                <div class="form-group full-width">
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

                <div class="form-group full-width">
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
                    <textarea name="observaciones" rows="3" placeholder="Ej. Llevar en compartimiento frío a -4°C..." style="width: 100%; padding: 12px 14px; border: 1px solid #d1d5db; border-radius: 10px; font-family: inherit; font-size: 15px; box-sizing: border-box;"></textarea>
                </div>

            </div>

            <div class="form-actions" style="margin-top: 10px;">
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 14px; font-size: 16px;">Confirmar y Registrar Entrega Única</button>
            </div>
        </form>
    <?php endif; ?>
</div>