<?php
// Vista: Formulario transaccional para crear pedidos
// Variables esperadas: $clientes (array), $productos (array)
?>
<div class="container">
    <h2>Registrar Pedido</h2>

    <form id="formPedido" action="index.php?action=guardar_pedido" method="POST">
        <p>
            <label>Cliente:</label><br>
            <select name="id_cliente" required>
                <option value="">-- Seleccione un cliente --</option>
                <?php foreach ($clientes as $c): ?>
                    <option value="<?php echo htmlspecialchars($c['id_cliente'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($c['razon_social'], ENT_QUOTES, 'UTF-8'); ?></option>
                <?php endforeach; ?>
            </select>
        </p>

        <p>
            <label>Dirección de Entrega:</label><br>
            <input type="text" name="direccion_entrega" required maxlength="255">
        </p>

        <hr>
        <h3>Productos</h3>
        <div>
            <label>Producto:</label>
            <select id="selectProducto">
                <option value="">-- Seleccione producto --</option>
                <?php foreach ($productos as $p): ?>
                    <option value="<?php echo htmlspecialchars($p['id_producto'], ENT_QUOTES, 'UTF-8'); ?>|<?php echo htmlspecialchars($p['precio'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($p['nombre'] . ' — ' . $p['categoria'] . ' — $' . $p['precio'], ENT_QUOTES, 'UTF-8'); ?></option>
                <?php endforeach; ?>
            </select>
            <label style="margin-left:10px">Cantidad:</label>
            <input type="number" id="cantidadProducto" min="1" value="1" style="width:80px">
            <button type="button" id="btnAgregar">Agregar al carrito</button>
        </div>

        <br>
        <table id="tablaCarrito" border="1" cellpadding="6" cellspacing="0" width="100%">
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
                    <td colspan="4" style="text-align:right"><b>Total:</b></td>
                    <td colspan="2"><span id="totalCarrito">0.00</span></td>
                </tr>
            </tfoot>
        </table>

        <br>
        <button type="submit">Guardar Pedido</button>
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

    // Crear fila
    const tr = document.createElement('tr');
    tr.innerHTML = `
        <td>${id}</td>
        <td>${nombre}</td>
        <td>${parseFloat(precio).toFixed(2)}</td>
        <td>${cantidad}</td>
        <td>${subtotal.toFixed(2)}</td>
        <td><button type="button" class="btnRemove">Quitar</button></td>
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
