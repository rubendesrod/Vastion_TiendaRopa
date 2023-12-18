<?php

// Incluyo la biblioteca de las funciones
require_once './bookstores/functions_global.php';


// Guardo los datos en un array asociativo que será utilizado mas delante
$datos = [
    "correo" => htmlspecialchars($_POST['email']),
    "contraseña" => htmlspecialchars($_POST['pass'])
];

// Relizo la funcion del login si se logea le llevará al index si no al mismo formulario
if (iniciar_login($datos)) {
    $_SESSION["login"] = true;
    header('Location: ../index.php');
} else {
    header('Location: ../HTML/login.php');
}
;

?>