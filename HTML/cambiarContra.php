<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer</title>
    <link rel="shortcut icon" href="./IMG/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../CSS/formularios.css">
    <?php
    require_once '../PHP/bookstores/functions_global.php';

    if (comprobar_acceder_sin_logear()) {
        header("Location: ./login.php");
    }
    ?>
</head>
<body>
    <div class="content">
        <form action="../PHP/validarRestablecerContraseña.php" method="post">
            <fieldset>
                <legend>Restablecer contraseña</legend>
                <div class="form-campo">
                    <input type="password" name="pass" placeholder="Contraseña">
                </div>
                <div class="form-campo">
                    <input type="password" name="passRep" placeholder="Repite la contraseña">
                </div>
                <div class="form-registrar">
                    <p>VOLVER AL <a href="../index.php">INICIO</a></p>
                </div>
                <div class="form-acceder">
                    <button type="submit">RESTABLECER</button>
                </div>
            </fieldset>
        </form>
        <div class="errores">
            <?php
                if(isset($_SESSION["ERROR"])){
                    echo "<p>".$_SESSION["ERROR"]."</p>";
                }
            ?>
        </div>
    </div>
</body>

</html>