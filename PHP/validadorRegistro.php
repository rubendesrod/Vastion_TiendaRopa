<?php

// Incluyo las bibliotecas de los patrones y las funciones
include './BOOKSTORES/patterns.php';
include './BOOKSTORES/functions_global.php';

// Compruebo que todos los campos estan seteados
if (
    $_POST['email'] != ""
    && $_POST['pass'] != ""
    && $_POST['passRep'] != ""
    && $_POST['name'] != ""
    && $_POST['ape1'] != ""
    && $_POST['ape2'] != ""
) {

    // Miro que cumplen con los patrones
    if (
        preg_match(EMAIL, $_POST['email'])
        && preg_match(CONTRA, $_POST['pass'])
        && preg_match(CONTRA, $_POST['passRep'])
        && preg_match(NAME, $_POST['name'])
        && preg_match(APELL, $_POST['ape1'])
        && preg_match(APELL, $_POST['ape2'])
    ) {

        // Con este if valido que las dos contraseñas son iguales
        if ($_POST['pass'] == $_POST['passRep']) {

            // Guardo el email en la sesión
            $_SESSION['email'] = htmlspecialchars($_POST['email']);

            // Meto los datos en un array que utilizará la funcion regsitro
            $datos = [
                "correo" => htmlspecialchars($_POST['email']),
                "contraseña" => htmlspecialchars($_POST['pass']),
                "nombre" => htmlspecialchars($_POST['name']),
                "apell1" => htmlspecialchars($_POST['ape1']),
                "apell2" => htmlspecialchars($_POST['ape2'])
            ];

            // Inicio la función que hara el regsitro
            // SI se ha registrado le llevará al login si no al mismo formulario
            if (iniciar_registro($datos)) {
                header('Location: ../HTML/login.php');
            } else {
                header('Location: ../HTML/register.php');
            }

            // Hago un unset de session error para que si otra pagina lo puede leer no haya confunsión
            unset($_SESSION["ERROR"]);
            
        } else {
            $_SESSION["ERROR"] = "Las contraseñas no son iguales";
            header('Location: ../HTML/register.php');
        }

    } else {
        $_SESSION["ERROR"] = "Los campos no cumplen con el formato establecido las contraseña 8 caracteres";
        header('Location: ../HTML/register.php');
    }


} else {
    $_SESSION["ERROR"] = "Completa todos los campos, son obligatorios";
    header('Location: ../HTML/register.php');
}
