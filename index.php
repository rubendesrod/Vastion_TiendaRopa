<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link rel="shortcut icon" href="HTML/IMG/logo.png" type="image/x-icon">
</head>
<body>
    <?php 
        session_start();
        // Compruebo que se ha iniciado sesión primero en la pagina
        if(!isset($_SESSION['login'])){
            header('Location: ./HTML/login.php');
            exit();
        }
    ?>
    <img src="HTML/IMG/logo.png" alt="Logo de Vastion">
</body>
</html>