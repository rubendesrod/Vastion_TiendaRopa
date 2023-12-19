<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VASTION</title>
    <link rel="shortcut icon" href="./IMG/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../CSS/index.css">
    <?php
    require_once("../PHP/bookstores/functions_global.php");
    ?>
</head>

<body>
    <?php
    // Primero compruebo que se ha iniciado la sesión
    if (comprobar_acceder_sin_logear()) {
        header("Location: ./login.php");
    }
    ?>
    <nav>
        <img src="./IMG/logo.png" alt="Logo de Vastion">
        <ul>
            <li><a href="../index.php" id="actual">Inicio</a></li>
            <li><a href="./miCarrito.php">Mi carrito</a></li>
            <li><a href="./miPerfil.php">Mi Perfil</a></li>
            <li><a href="./login.php">Cerrar Sesión</a></li>
        </ul>
    </nav>
    <div class="content">
        <!--Añado la informacion de la cuenta-->
        <div class="infoPrenda">
            <?php
            devolver_prenda($_POST["id"]);
            ?>
        </div>
    </div>

</body>

</html>