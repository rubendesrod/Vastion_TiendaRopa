<?php

// Incluimos el archvio que contiene todas nuestras funciones
require_once './bookstores/functions_global.php';

// Primero sacar la id del carrito del usuario que esta conectado ahora mismo
$id_carrito = sacar_id_carrito($_SESSION["correo"]);

// Instanciamos las variables que vamos a necesitar
$datos = [
    ":idCarrito" => $id_carrito,
    ":idPrenda" => $_POST["id"],
    ":cantidad" => $_POST["cantidad"]
];

// Añadir la prenda, teniendo el id del carrito id de la prenda y la cantidad
añadir_prenda_carrito($datos);

header('Location: ../index.php');

?>