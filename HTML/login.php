<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../CSS/formularios.css">
    <link rel="shortcut icon" href="IMG/logo.png" type="image/x-icon">
    <?php
        session_start();
        session_destroy();
    ?>
</head>
<body>
    <div class="content">
        <form action="../PHP/validarLogin.php" method="post">
            <fieldset>
                <legend>LOGIN</legend>
                <div class="form-campo">
                    <label for="">Correo</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div class="form-campo">
                    <label for="">Contraseña</label>
                    <input type="password" name="pass" id="pass" required>
                </div>
                <div class="form-registrar">
                    <p>No tengo cuenta <a href="register.html">Registrarme</a></p>
                </div>
                <div class="form-acceder">
                    <button type="submit">login</button>
                </div>
            </fieldset>
        </form>
    </div>
</body>
</html>