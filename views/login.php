<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión | EcoFrío</title>
    <link rel="stylesheet" href="assets/css/estilos.css">
    <style>
        body { background: #f1f5f9; color: #1f2937; font-family: Arial, sans-serif; }
        .login-wrapper { display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 20px; }
        .login-card { width: 100%; max-width: 420px; background: #ffffff; border-radius: 14px; box-shadow: 0 18px 50px rgba(15, 23, 42, 0.12); padding: 32px; }
        .login-card h1 { margin-bottom: 16px; font-size: 26px; color: #111827; }
        .login-card p { margin-bottom: 24px; color: #4b5563; }
        .login-card label { display: block; margin-bottom: 8px; font-weight: 600; }
        .login-card input[type="text"],
        .login-card input[type="password"] { width: 100%; padding: 12px 14px; margin-bottom: 18px; border: 1px solid #d1d5db; border-radius: 10px; font-size: 15px; }
        .login-card button { width: 100%; padding: 13px 16px; background: #1d4ed8; color: white; border: none; border-radius: 10px; font-size: 16px; font-weight: 700; cursor: pointer; }
        .login-card button:hover { background: #2563eb; }
        .login-card .help { margin-top: 14px; font-size: 14px; color: #6b7280; }
        .alert { margin-bottom: 16px; padding: 14px 16px; border-radius: 10px; font-size: 14px; }
        .alert-error { background: #f8d7da; color: #842029; border: 1px solid #f5c2c7; }
        .alert-info { background: #e2e8f0; color: #0f172a; border: 1px solid #cbd5e1; }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <h1>Acceso a EcoFrío</h1>
            <p>Ingresa tu usuario o correo y contraseña para iniciar sesión en el panel.</p>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error">Usuario o contraseña incorrectos. Intenta de nuevo.</div>
            <?php endif; ?>

            <form action="procesar_login.php" method="POST">
                <label for="usuario">Usuario o correo</label>
                <input type="text" id="usuario" name="usuario" required autofocus placeholder="Ingresa tu usuario o correo">

                <label for="contrasena">Contraseña</label>
                <input type="password" id="contrasena" name="contrasena" required placeholder="Ingresa tu contraseña">

                <button type="submit">Iniciar sesión</button>
            </form>

            <p class="help">Si no tienes acceso, contacta al administrador de EcoFrío.</p>
        </div>
    </div>
</body>
</html>
