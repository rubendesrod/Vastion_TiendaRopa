<?php
include './BOOKSTORES/patterns.php';
include './BOOKSTORES/functions.php';
session_start();
// Miro que cumplen con los patrones
// No valido el que esten vacios porque lo valido con HTML
if (
    preg_match(EMAIL, $_POST['email'])
    && preg_match(PASS, $_POST['pass'])
    && preg_match(PASS, $_POST['passRep'])
    && preg_match(NAME, $_POST['name'])
    && preg_match(APELL, $_POST['ape1'])
    && preg_match(APELL, $_POST['ape2'])
) {
    $_SESSION['email'] = htmlspecialchars($_POST['email']);
    // Realizo la conexion a la base de datos para insertar el nuevo registro de un usuario
    $connection = conectar_db();

    header('Location: ../HTML/login.php');
} else {
    header('Location: ../HTML/register.html');
}

?>