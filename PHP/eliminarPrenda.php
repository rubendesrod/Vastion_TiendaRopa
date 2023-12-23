<?php

// Incluimos el archvio que contiene todas nuestras funciones
require_once './bookstores/functions_global.php';


if (isset($_GET["idPrenda"]) && isset($_GET["idCarrito"]) && isset($_GET["cantidad"])) {

    // Seteo las variables
    $prenda = $_GET["idPrenda"];
    $carrito = $_GET["idCarrito"];
    $cantidad = $_GET["cantidad"];

    // Añadimos los datos a un array con los parametros
    $array_parametros = array(":idPrenda" => $prenda, ":idCarrito" => $carrito);

    // Conexion con la base de datos
    $db = conectar_db();
    try {

        // Realizamos la consulta preparada para borrar la prenda
        $consulta = $db->prepare(BORRAR_PRENDA_CARRITO);
        $consulta->execute($array_parametros);
        if ($consulta->rowCount() > 0) {
            // Cierro la consulta anterior para reutilizar la variable
            $consulta->closeCursor();
            $array_parametros[":cantidad"] = $cantidad;
            actualizar_prenda($array_parametros, "sumar");
            header('Location: ../HTML/miCarrito.php');
        }else{
            throw new PDOException("No se ha eliminado la prenda");
        }

    } catch (PDOException $e) {
        echo "Error con el PDO:" . $e->getMessage();
    } catch (Exception $e) {
        echo "Error de excepcion:" . $e->getMessage();
    }

} else {

    // No se puede eliminar la prenda sin su id de prenda y carrito
    header('Location: ../index.php');

}

?>