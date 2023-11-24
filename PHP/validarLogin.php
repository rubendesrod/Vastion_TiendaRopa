<?php

include 'patrones.php';
session_start();

// Primero hay que validar el $_SESSION no esté vacío porque si se intenta un login hay comprobar que tiene datos la sesion
// EN el caso de que no este registrado se le mandara a la zonar de registro
// Valido que los campos cumplan con los patrones
// No valido el que esten vacios porque lo hago con HTML
if (preg_match(EMAIL, $_POST['email']) && preg_match(PASS, $_POST['pass'])) {
    if (
        $_POST['email'] == $_SESSION['email']
        && $_POST['pass'] == $_SESSION['password']
    ) {
        $_SESSION['login'] == true;
        header('Location: ./../index.php');
    } else {
        // COMO METER UN MENSAJE DE ERROR PORQUE NO ME APARECE
    }
} else {
    echo '<h1>No se cumple con el formato de los datos</h1>';
}

?>