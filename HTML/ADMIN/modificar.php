<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN</title>
    <link rel="stylesheet" href="admin.css" />
    <link rel="shortcut icon" href="admin_29358.ico" type="image/x-icon">
    <?php
        // Importo la libreria
        require_once("../../PHP/bookstores/functions_global.php");
        
        // Compruebo que el que haya iniciado sesion sea el administrador
        if(!isset($_SESSION["admin"])){
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
            <div class="busqueda">
                <form action="#">
                    <input type="text" name="marca" placeholder="Escribe la marca de ropa" />
                    <button type="submit">buscar</button>
                </form>
            </div>
            <div class="tablaPrendas">
                <table>
                    <!--Titulo de las columnas de la tabla-->
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Marca</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Talla</th>
                        <th>Imagen</th>
                    </tr>
                    <!--Contenido de las prendas-->
                    <tr>
                        <td>1</td>
                        <td>Polo</td>
                        <td>Versacce</td>
                        <td>60.00€</td>
                        <td>12</td>
                        <td>XS</td>
                        <td>./IMG/polo_versacce.png</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Polo</td>
                        <td>Versacce</td>
                        <td>60.00€</td>
                        <td>12</td>
                        <td>XS</td>
                        <td>./IMG/polo_versacce.png</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Polo</td>
                        <td>Versacce</td>
                        <td>60.00€</td>
                        <td>12</td>
                        <td>XS</td>
                        <td>./IMG/polo_versacce.png</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Polo</td>
                        <td>Versacce</td>
                        <td>60.00€</td>
                        <td>12</td>
                        <td>XS</td>
                        <td>./IMG/polo_versacce.png</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Polo</td>
                        <td>Versacce</td>
                        <td>60.00€</td>
                        <td>12</td>
                        <td>XS</td>
                        <td>./IMG/polo_versacce.png</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>

</html>