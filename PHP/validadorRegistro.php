<?php
include 'patrones.php';
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
    $_SESSION['password'] = htmlspecialchars($_POST['pass']);
    $_SESSION['passwordRep'] = htmlspecialchars($_POST['passRep']);
    $_SESSION['name'] = htmlspecialchars($_POST['name']);
    $_SESSION['apell1'] = htmlspecialchars($_POST['ape1']);
    $_SESSION['apell2'] = htmlspecialchars($_POST['ape2']);
    header('Location: ../HTML/login.php');
} else {
    header('Location: ../HTML/register.html');
}

?>