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
            <li><a href="../index.php">Inicio</a></li>
            <li><a href="./miCarrito.php" id="actual">Mi carrito</a></li>
            <li><a href="./miPerfil.php">Mi Perfil</a></li>
            <li><a href="./login.php">Cerrar Sesión</a></li>
        </ul>
    </nav>
    <!--Primero muestro el mensaje de confirmacion-->
    <div class="content">
        <div class="Confirmacion-de-pedido">
            <h2>Agradecemos tu pedido</h2>
            <p>Los detalles de tu pedido han sido enviados a tu correo electrónico.<a
                    href="https://mail.google.com/" target="_blank"><?php echo $_SESSION["correo"]?></a>.</p>
            <div class="boton">
                <button><a href="./miCarrito.php">Volver a mi carrito</a></button>
            </div>
        </div>
    </div>
    <!--Borro todo el contenido del carrito de esa persona pero esta vez sin actualizar la cantidad de la tienda de ropa -->
    <?php
    // Primero conectamos a la base de datos
    $db = conectar_db();
    // Realizamos la consulta preparada para borrar el contenido del carrito del usuario
    try {
        $id_carrito = sacar_id_carrito($_SESSION["correo"]);
        // Realizo la transaccion
        $db->beginTransaction();
        $consulta = $db->prepare(BORRAR_CONTENIDO_USUARIO);
        $consulta->bindParam(1, $id_carrito);
        $consulta->execute();
        if($consulta->rowCount() <= 0){
            throw new Exception("No se ha podido borrar el contenido del carrito", 1);
        }
        $db->commit();
    } catch (PDOException $e) {
        echo "Error PDOException: ".$e->getMessage();
        $db->rollBack();
    } catch (Exception $e){
        echo "Error Exception: ".$e->getMessage();
        $db->rollBack();
    } 
    ?>
</body>

</html>