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
        if(comprobar_acceder_sin_logear()){
            header("Location: ./HTML/login.php");
        } 
    ?>
    <nav>
        <img src="HTML/IMG/logo.png" alt="Logo de Vastion">
        <ul>
            <li><a href="" id="actual">Inicio</a></li>
            <li><a href="">Mi carrito</a></li>
            <li><a href="">Mi Perfil</a></li>
            <li><a href="./HTML/login.php">Cerrar Sesión</a></li>
        </ul>
    </nav>
    <div class="content">
        <h1>ESCOGE LAS PRENDAS QUE MAS TE GUSTEN</h1>
        <div class="MostrarPrendas">
            <?php
                devolver_prendas();
            ?>
        </div>
    </div>
</body>
</html>