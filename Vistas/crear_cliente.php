<div class="container">
    <h2>Registrar Cliente</h2>

    <?php if(isset($_SESSION['error'])): ?>
        <p class="mensaje-error"><b><?php echo htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8'); ?></b></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    
    <?php if(isset($_SESSION['mensaje'])): ?>
        <p class="mensaje-exito"><b><?php echo htmlspecialchars($_SESSION['mensaje'], ENT_QUOTES, 'UTF-8'); ?></b></p>
        <?php unset($_SESSION['mensaje']); ?>
    <?php endif; ?>

    <form action="index.php?action=guardar_cliente" method="POST">
        <label>Razón Social:</label><br>
        <input type="text" name="razon_social" required maxlength="150"><br><br>

        <label>NIT / Identificación Tributaria:</label><br>
        <input type="text" name="nit" required maxlength="20"><br><br>

        <label>Teléfono Celular:</label><br>
        <input type="text" name="telefono" maxlength="20"><br><br>

        <button type="submit" class="btn-primary">Registrar Cliente</button>
        <a href="index.php?vista=listar_clientes">Cancelar</a>
    </form>
</div>