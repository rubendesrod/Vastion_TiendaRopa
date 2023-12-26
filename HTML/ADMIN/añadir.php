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
                <a href="#" id="actual">AÑADIR</a>
            </div>
            <div class="boton">
                <a href="./modificar.php">MODIFICAR</a>
            </div>
            <div class="boton">
                <a href="../login.php">SALIR</a>
            </div>
        </div>
        <form action="../../PHP/insertarNuevaPrenda.php" method="post">
            <div class="contenido">
                <h2>AÑADE UNA PRENDA</h2>
                <div class="marca">
                    <label for="marca">Marca</label>
                    <input type="text" name="marca" id="marca" />
                </div>
                <div class="tipo">
                    <label>Tipo</label>
                    <select name="tipo" id="">
                        <option value="Chandal">Chandal</option>
                        <option value="Polo">Polo</option>
                        <option value="Camiseta">Camiseta</option>
                        <option value="Sudadera">Sudadera</option>
                        <option value="Pantalon">Pantalon</option>
                        <option value="Cazadora">Cazadora</option>
                    </select>
                </div>
                <div class="talla">
                    <label>Talla</label>
                    <select name="talla" id="">
                        <option value="XS">XS</option>
                        <option value="S">S</option>
                        <option value="L">L</option>
                        <option value="M">M</option>
                        <option value="XL">XL</option>
                        <option value="XXL">XXL</option>
                    </select>
                </div>
                <div class="cantidad">
                    <label for="cantidad">Cantidad</label>
                    <input type="number" name="cantidad" id="cantidad" />
                </div>
                <div class="precio">
                    <label for="precio">Precio</label>
                    <input type="number" name="precio" id="precio" step="any" />
                </div>
                <div class="archivos">
                    <p>La imagen debe estar en la carpeta IMG, dimensiones 400x500</p>
                    <input type="file" name="nombreIMG" id="selecc" />
                    <label for="selecc" id="labelUpload">UPLOAD IMAGE</label>
                </div>
                <div class="mandarDatos">
                    <button type="submit">ENVIAR</button>
                </div>
                <?php
                if(isset($_SESSION["ERROR"])){
                    echo<<<FIN
                        <div class="error">
                            <p>{$_SESSION["ERROR"]}</p>
                        </div>
                    FIN;
                }
                ?>
                </div>
            </div>
        </form>
    </div>
</body>

</html>