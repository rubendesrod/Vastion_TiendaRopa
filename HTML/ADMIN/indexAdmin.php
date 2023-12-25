<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN</title>
    <link rel="shortcut icon" href="./IMG/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../../CSS/admin.css">

    <?php
        // Importo la libreria
        require_once("../PHP/bookstores/functions_global.php");
        
        // Compruebo que el que haya iniciado sesion sea el administrador
        if(isset($_SESSION["admin"])){
            // Si no es el administrador lo mando al login
            header("Location: ../login.php");
        }
        // Si que esta entrado un administrados sigue la ejecución
    ?>
</head>
<body>
    <?php 
        
    ?>
    <div class="content">
        <div class="nav-bar">
        </div>  
        <div class="acciones">
            <div class="administrar"></div>
            <div class="añadir"></div>
        </div>
    </div>
</body>
</html>