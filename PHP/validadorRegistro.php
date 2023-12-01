<?php

// Incluyo las bibliotecas de los patrones y las funciones
include './BOOKSTORES/patterns.php';
include './BOOKSTORES/functions_global.php';

// No valido el que esten vacios porque lo valido con HTML
// Miro que cumplen con los patrones
/* if (
    preg_match(EMAIL, $_POST['email'])
    && preg_match(CONTRA, $_POST['pass'])
    && preg_match(CONTRA, $_POST['passRep'])
    && preg_match(NAME, $_POST['name'])
    && preg_match(APELL, $_POST['ape1'])
    && preg_match(APELL, $_POST['ape2'])
) { */
    
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
        if(iniciar_registro($datos)){
            header('Location: ../HTML/login.php');
        }else{
            header('Location: ../HTML/register.html');
        }
    }else{
        header('Location: ../HTML/register.html');
    }

/* } else {
    header('Location: ../HTML/register.html');
} */
