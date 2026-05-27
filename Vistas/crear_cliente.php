<h2>Comercial - Registrar Cliente</h2>
<?php if(isset($_SESSION['error'])): ?>
    <p style="color: red;"><b>⚠️ <?php echo htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8'); ?></b></p>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>
<?php if(isset($_SESSION['mensaje'])): ?>
    <p style="color: green;"><b>✅ <?php echo htmlspecialchars($_SESSION['mensaje'], ENT_QUOTES, 'UTF-8'); ?></b></p>
    <?php unset($_SESSION['mensaje']); ?>
<?php endif; ?>

<form action="index.php?action=clientes" method="POST">
    <input type="hidden" name="action" value="guardar_cliente">
    <p>
        <label>Razón Social:</label><br>
        <input type="text" name="razon_social" required maxlength="150">
    </p>
    <p>
        <label>NIT / Identificación Tributaria:</label><br>
        <input type="text" name="nit" required maxlength="20">
    </p>
    <p>
        <label>Teléfono Celular:</label><br>
        <input type="text" name="telefono" maxlength="20">
    </p>
    <button type="submit">Registrar Cliente</button>
</form>