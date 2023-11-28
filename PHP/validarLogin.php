<?php

require_once './bookstores/patterns.php';
require_once './bookstores/functions_global.php';

session_start();

// Primero hay que validar el $_SESSION no esté vacío porque si se intenta un login hay comprobar que tiene datos la sesion
// EN el caso de que no este registrado se le mandara a la zonar de registro
// Valido que los campos cumplan con los patrones
// No valido el que esten vacios porque lo hago con HTML
if (preg_match(EMAIL, $_POST['email']) && preg_match(CONTRA, $_POST['pass'])) {

    $correo = htmlspecialchars($_POST['email']);
    $contra = htmlspecialchars($_POST['pass']);

    $datos = [
        "correo" => $correo,
        "contraseña" => $contra
    ];

    if (iniciar_login($datos)) {
        header('Location: ../index.php');
    } else {
        echo "<a href='../HTML/login.html'></a>";
        echo "<h1>DATOS INCORRECTOS</h1>";
    }
    ;

} else {
    echo 'No se cumple con el formato de los datos';
}

?>