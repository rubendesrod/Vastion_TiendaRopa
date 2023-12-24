<?php

require_once '../PHP/bookstores/functions_global.php';

if (comprobar_acceder_sin_logear()) {
    header("Location: ./login.php");
}

if (isset($_POST["pass"]) && isset($_POST["passRep"])) {

    // seteo el correo del usuario
    $correo = $_SESSION["correo"];

    // Si las variables estan seteado ahora la defino en una variable
    $pass = $_POST["pass"];
    $passRep = $_POST["passRep"];

    // Compruebo que ninguno de los campos esta vacia
    if ($pass != "" || $passRep != "") {
        // Compruebo que las contraseñas son iguales
        if ($pass == $passRep) {
            // Se puede actualizar la contraseña del usuario
            $contraseña = md5($pass);
            $db = conectar_db();
            try {
                $consulta = $db->prepare(ACTUALIZAR_USUARIO_CONSTRASEÑA);
                $consulta->bindParam(1, $contraseña);
                $consulta->bindParam(2, $correo);
                $consulta->execute();
                // Compruebo que se una columna ha sido actualizada
                if ($consulta->rowCount() <= 0) {
                    throw new Exception("No se ha cambiado la contraseña");
                }
                unset($_SESSION["ERROR"]);
                header("Location: ../index.php");
            } catch (PDOException $e) {
                echo "Error en PDO: " . $e->getMessage();
                exit();
            } catch (Exception $e) {
                echo "Error de excepcion: " . $e->getMessage();
                exit();
            }
            // Borro la sesion de errores para que no tenga nada
            unset($_SESSION["ERROR"]);
        } else {
            // No se han escrito iguales las contraseñas
            // Mando un mensaje de error atraves de una cookie
            $_SESSION["ERROR"] = "Las contraseñas tiene que ser iguales";
            header("Location: ../HTML/cambiarContra.php");
        }
    } else {
        $_SESSION["ERROR"] = "Los dos campos tienen que estar escritos";
        header("Location: ../HTML/cambiarContra.php");
    }
} else {
    $_SESSION["ERROR"] = "Los dos campos tienen que estar escritos";
    header("Location: ../HTML/cambiarContra.php");
}

?>