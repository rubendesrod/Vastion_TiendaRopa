<?php

// Incluimos el archvio que contiene todas nuestras funciones
require_once './bookstores/functions_global.php';

// Primero compruebo que esta seteado el post
if (isset($_POST)) {

    // Seteo todo el array post en variables
    $array_parametros = array(
        ":precio" => $_POST["precio"][$_POST["id"]], 
        ":cantidad"=> $_POST["cantidad"][$_POST["id"]],
        ":id"=> $_POST["id"]
    );

    

    // realizo la conexion a la base de datos
    $db = conectar_db();

    // Realizo la consulta preparada para actualizar el precio y cantidad de la prenda
    try {
        $consulta = $db->prepare(ACTUALIZAR_PRENDA_CANTIDADPRECIO);
        $consulta->execute($array_parametros);
        if($consulta->rowCount() <= 0){
           // Significa que no se ha actualizado nada ya que 
           // los datos eran los mismos que tenia esa prenda anteriormente
           $_SESSION["ERROR"] = "No se ha actualizado ya que los datos eran los mismos";
        }
        header("Location: ../HTML/ADMIN/modificar.php");
    } catch (PDOException $e) {
        echo "Error PDOException: " . $e->getMessage();
    } catch (Exception $e) {
        echo "Error Exception: " . $e->getMessage();
    }


} else {
    header("Location: ../HTML/login.php");
}

?>