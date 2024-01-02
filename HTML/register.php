<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/formularios.css">
    <link rel="shortcut icon" href="IMG/logo.png" type="image/x-icon">
    <title>Registro</title>
</head>

<body>
    <div class="content">
        <form action="../PHP/validadorRegistro.php" method="post">
            <fieldset>
                <legend>REGISTRO</legend>
                <div class="form-campo">
                    <label for="">Correo</label>
                    <input type="text" name="email" id="email">
                </div>
                <div class="form-campo">
                    <label for="">Contraseña</label>
                    <input type="password" name="pass" id="pass">
                </div>
                <div class="form-campo">
                    <label for="">Repite la Contraseña</label>
                    <input type="password" name="passRep" id="passRep">
                </div>
                <div class="form-campo">
                    <label for="">Nombre</label>
                    <input type="text" name="name" id="nombre">
                </div>
                <div class="form-campo">
                    <label for="">Primer Apellido</label>
                    <input type="text" name="ape1" id="ape1">
                </div>
                <div class="form-campo">
                    <label for="">Segundo Apellido</label>
                    <input type="text" name="ape2" id="ape2">
                </div>
                <div class="form-registrar">
                    <p>Ya tengo cuenta <a href="login.php">Login</a></p>
                </div>
                <div class="errores">
                    <?php
                    session_start();
                    if (isset($_SESSION["ERROR"])) {
                        echo "<p>" . $_SESSION["ERROR"] . "</p>";
                    }
                    ?>
                </div>
                <div class="form-acceder">
                    <button type="submit">Registrar</button>
                </div>
            </fieldset>
        </form>
    </div>
</body>

</html>