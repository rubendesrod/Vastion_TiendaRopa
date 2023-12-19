<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VASTION</title>
    <link rel="shortcut icon" href="HTML/IMG/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="CSS/index.css">
    <?php
    require_once("PHP/bookstores/functions_global.php");
    ?>
</head>

<body>
    <?php
    // Primero compruebo que se ha iniciado la sesión
    if (comprobar_acceder_sin_logear()) {
        header("Location: ./HTML/login.php");
    }
    ?>
    <nav>
        <img src="HTML/IMG/logo.png" alt="Logo de Vastion">
        <ul>
            <li><a href="" id="actual">Inicio</a></li>
            <li><a href="./HTML/miCarrito.php">Mi carrito</a></li>
            <li><a href="./HTML/miPerfil.php">Mi Perfil</a></li>
            <li><a href="./HTML/login.php">Cerrar Sesión</a></li>
        </ul>
    </nav>
    <div class="content">
        <h1>ESCOGE LAS PRENDAS QUE MAS TE GUSTEN</h1>
        <!--Clas el cual va a contener todas las tarjetas de las prendas-->
        <div class="mostrarPrendas">
            <?php
            devolver_prendas();
            ?>
        </div>
        <!--Footer dentro del content-->
        <div class="footer">
            <p>Políticas de Cookies</p>
            <p>&copy;VastionRopa</p>
            <p>Políticas de Privacidad</p>
        </div>
    </div>
    <!-- Script que hace el efecto de mostrar las prendas-->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            $(".prenda").each(function (index) {
                // Agregar la clase "mostrar" a cada prenda con un retraso
                $(this).delay(200 * index).queue(function (next) {
                    $(this).addClass("mostrar");
                    next();
                });
            });
        });
    </script>
</body>

</html>