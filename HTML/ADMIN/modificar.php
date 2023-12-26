<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN</title>
    <link rel="stylesheet" href="../../CSS/admin.css" />
    <link rel="shortcut icon" href="admin_29358.ico" type="image/x-icon">
    <?php
    // Importo la libreria
    require_once("../../PHP/bookstores/functions_global.php");

    // Compruebo que el que haya iniciado sesion sea el administrador
    if (!isset($_SESSION["admin"])) {
        // Si no es el administrador lo mando al login
        header("Location: ../login.php");
    }
    // Si que esta entrado un administrados sigue la ejecución
    ?>
</head>

<body>
    <h1>PAGINA DEL ADMINISTRADOR</h1>
    <div class="content">
        <div class="controles">
            <div class="boton">
                <a href="./añadir.php">AÑADIR</a>
            </div>
            <div class="boton">
                <a href="#" id="actual">MODIFICAR</a>
            </div>
            <div class="boton">
                <a href="../login.php">SALIR</a>
            </div>
        </div>
        <div class="contenido2">
            <div>
                <h2>Almacen de las prendas</h2>
            </div>
            <form action="../../PHP/modificarPrenda.php" method="post">
                <div class="tablaPrendas">
                    <?php
                    mostar_tabla_administrador();
                    ?>
            </form>
        </div>
        <?php
        unset($_POST);
        if (isset($_SESSION["ERROR"])) {
            echo <<<FIN
                        <div class="error">
                            <p>{$_SESSION["ERROR"]}</p>
                        </div>
                    FIN;
            unset($_SESSION["ERROR"]);
        }
        ?>
    </div>
    </div>
</body>

</html>