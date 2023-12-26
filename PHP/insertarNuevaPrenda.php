<?php

// Incluimos el archvio que contiene todas nuestras funciones
require_once './bookstores/functions_global.php';

// marca, tipo, talla, cantidad, precio, nombreIMG
// Una vez tengamos los datos comprobamos que estan seteado
if (
    $_POST["marca"] != ""
    && $_POST["tipo"] != ""
    && $_POST["talla"] != ""
    && $_POST["cantidad"] != ""
    && $_POST["precio"] != ""
    && $_POST["nombreIMG"] != ""
) {

    // Hago que la session de error ya no exista
    unset($_SESSION["ERROR"]);

    // Todos los campos contiene informacion se puede hacer la inserccion
    $db = conectar_db();

    // Hago el string de la imagen para que salga la url
    $urlImg = "/IMG"."/".$_POST["nombreIMG"];
    
    // Seteo un array de parametros
    $array_parametros = array(
        ":nombre" => $_POST["tipo"],
        ":marca" => $_POST["marca"],
        ":precio" => $_POST["precio"],
        ":cantidad" => $_POST["cantidad"],
        ":talla" => $_POST["talla"],
        ":imagen" => $urlImg,
        ":ID_ADMIN" => "admin@gmail.com"
    );

    // Realizo la consulta preparada
    try {

        $consulta = $db->prepare(INSERTAR_PRENDA);
        $consulta->execute($array_parametros);
        if($consulta->rowCount() <= 0){
            throw new Exception("No se ha podido insertar la prenda", 1);
            
        }

        header("Location: ../HTML/ADMIN/añadir.php");

    } catch (PDOException $e) {
        echo "Error de PDOExcepcion: " . $e->getMessage();
    } catch (Exception $e) {
        echo "Error de excepcion: " . $e->getMessage();
    }

} else {
    // Seteo una cookie con un mensaje de error y lo mando a la pagina anterior
    $_SESSION["ERROR"] = "Todos los campos tienen que estar completados";
    header("Location: ../HTML/ADMIN/añadir.php");
}


?>