<div class="container">
    <h2>Editar Cliente</h2>

    <form action="index.php?action=actualizar_cliente" method="POST">
        <input type="hidden" name="id_cliente" value="<?php echo htmlspecialchars($datosCliente['id_cliente'], ENT_QUOTES, 'UTF-8'); ?>">

        <label>Razón Social:</label><br>
        <input type="text" name="razon_social" required maxlength="150" value="<?php echo htmlspecialchars($datosCliente['razon_social'], ENT_QUOTES, 'UTF-8'); ?>"><br><br>

        <label>NIT / Identificación Tributaria:</label><br>
        <input type="text" name="nit" required maxlength="20" value="<?php echo htmlspecialchars($datosCliente['nit'], ENT_QUOTES, 'UTF-8'); ?>"><br><br>

        <label>Teléfono Celular:</label><br>
        <input type="text" name="telefono" maxlength="20" value="<?php echo htmlspecialchars($datosCliente['telefono'], ENT_QUOTES, 'UTF-8'); ?>"><br><br>

        <button type="submit" class="btn-primary">Actualizar Cliente</button>
        <a href="index.php?vista=listar_clientes">Cancelar</a>
    </form>
</div>
