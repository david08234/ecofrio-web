<?php
// Vista: Formulario transaccional para crear pedidos
// Variables esperadas: $clientes (array), $productos (array)
?>
<div class="form-card" style="max-width: 800px;"> <div class="form-card-header">
        <h2>Registrar Pedido</h2>
    </div>

    <form id="formPedido" action="index.php?action=guardar_pedido" method="POST">
        
        <div class="form-grid">
            <div class="form-group">
                <label>Cliente:</label>
                <select name="id_cliente" required>
                    <option value="">-- Seleccione un cliente --</option>
                    <?php foreach ($clientes as $c): ?>
                        <option value="<?php echo htmlspecialchars($c['id_cliente'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($c['razon_social'], ENT_QUOTES, 'UTF-8'); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group full-width">
                <label>Dirección de Entrega:</label>
                <input type="text" name="direccion_entrega" required maxlength="255">
            </div>
        </div>

        <hr style="border: 0; border-top: 1px solid #d1d5db; margin: 24px 0;">
        <h2 style="font-size: 20px; margin-bottom: 16px; color: #111827;">Productos</h2>
        
        <div class="form-group">
            <label>Producto:</label>
            <select id="selectProducto">
                <option value="">-- Seleccione producto --</option>
                <?php foreach ($productos as $p): ?>
                    <option value="<?php echo htmlspecialchars($p['id_producto'], ENT_QUOTES, 'UTF-8'); ?>|<?php echo htmlspecialchars($p['precio'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($p['nombre'] . ' — ' . $p['categoria'] . ' — $' . $p['precio'], ENT_QUOTES, 'UTF-8'); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-action-row">
            <div class="form-group" style="width: 150px; flex-shrink: 0;">
                <label>Cantidad:</label>
                <input type="number" id="cantidadProducto" min="1" value="1">
            </div>
            
            <div class="form-group" style="flex-grow: 1;">
                <button type="button" id="btnAgregar" class="btn btn-primary" style="width: 100%; background-color: #4b5563;">Agregar al carrito</button>
            </div>
        </div>

        <div style="overflow-x: auto; margin-bottom: 24px;">
            <table id="tablaCarrito" class="custom-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Producto</th>
                        <th>Precio Unitario</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" style="text-align:right; padding: 12px 15px; font-size: 16px;"><b>Total:</b></td>
                        <td colspan="2" style="padding: 12px 15px; font-size: 16px; font-weight: bold; color: #1d4ed8;">
                            $<span id="totalCarrito">0.00</span>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary" style="font-size: 18px; padding: 15px 30px;">Guardar Pedido</button>
        </div>
    </form>
</div>

<script>
// Manejo simple del carrito en el cliente
const btnAgregar = document.getElementById('btnAgregar');
const selectProducto = document.getElementById('selectProducto');
const cantidadInput = document.getElementById('cantidadProducto');
const tablaBody = document.querySelector('#tablaCarrito tbody');
const totalSpan = document.getElementById('totalCarrito');

let total = 0;

function actualizarTotal() {
    totalSpan.textContent = total.toFixed(2);
}

function crearHiddenInputs(rowIndex, id, precio, cantidad) {
    const container = document.createElement('div');
    container.style.display = 'none';
    container.innerHTML = `
        <input type="hidden" name="producto_id[]" value="${id}">
        <input type="hidden" name="producto_precio[]" value="${precio}">
        <input type="hidden" name="producto_cantidad[]" value="${cantidad}">
    `;
    return container;
}

btnAgregar.addEventListener('click', () => {
    const val = selectProducto.value;
    const cantidad = parseInt(cantidadInput.value, 10) || 0;
    if (!val) { alert('Seleccione un producto.'); return; }
    if (cantidad <= 0) { alert('Cantidad inválida.'); return; }

    const [id, precio] = val.split('|');
    const nombre = selectProducto.options[selectProducto.selectedIndex].text;
    const subtotal = parseFloat(precio) * cantidad;

    // Crear fila (inyecté las clases de tus iconos de acción en el botón de quitar)
    const tr = document.createElement('tr');
    tr.innerHTML = `
        <td>${id}</td>
        <td>${nombre}</td>
        <td>$${parseFloat(precio).toFixed(2)}</td>
        <td>${cantidad}</td>
        <td><strong>$${subtotal.toFixed(2)}</strong></td>
        <td><button type="button" class="btnRemove btn-icon btn-icon-delete" style="border: none; cursor: pointer;" title="Quitar">✖</button></td>
    `;

    // Añadir inputs ocultos para envío
    const hidden = crearHiddenInputs(tablaBody.children.length, id, precio, cantidad);
    tr.appendChild(hidden);

    tablaBody.appendChild(tr);

    total += subtotal;
    actualizarTotal();

    // remover
    tr.querySelector('.btnRemove').addEventListener('click', () => {
        total -= subtotal;
        actualizarTotal();
        tr.remove();
    });
});

// Validación antes de enviar
document.getElementById('formPedido').addEventListener('submit', function(e){
    if (tablaBody.children.length === 0) {
        e.preventDefault();
        alert('El carrito está vacío. Agregue al menos un producto.');
    }
});
</script>