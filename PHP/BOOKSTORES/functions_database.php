<?php
   // Fichero que contiene las Constantes
require_once('configDB.php');


/**
 * Funcion de conexion a la base de datos
 * @return conexion la conexión a la base de datos
 */
function conectar_db()
{
    $conexion = new mysqli(HOST, USER, PASS, DB);
    if ($conexion) {
        return $conexion;
    }
    return false;
}

/**
 * Función de cierra la conexión de la base de datos
 * @param conexion Objeto de la conexion que quiero cerrar
 * @return exito devuelvo true si ha cambiado correctamente o false
 */
function cerrar_db($conexion)
{
    $exito = $conexion->close();
    return $exito;
}