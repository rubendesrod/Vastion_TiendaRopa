<?php
   // Fichero que contiene las Constantes
require_once('./configDB.php');


/**
 * Funcion de conexion a la base de datos
 * @return conexion la conexión a la base de datos
 */
function conectar_db()
{
    $conexion = new mysqli(HOST, USER, PASS, DB);
    if ($conexion == false) {
        return false;
    }
    return $conexion;
}

/**
 * Función cambio de base de datos
 * @param conexion Objeto de conexion a la base de datos original
 * @param db_nueva DB a la que quiero cambiar
 * @return exito devuelvo true si ha cambiado correctamente o false
 */
function cambiar_db($conexion, $nueva_db)
{
    $exito = $conexion->select_db($nueva_db);
    return $exito;
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

/**
 * Funcion para lanzar una consulta a la base de datos
 * @param conexion Conexion a la base de datos que vamos a utilizar
 * @param query Consulta en SQL que vamos a realizar
 * @return exito Devuelve 1 si la consulte se ha realizado 0 si no 
 */
function consultar_db($conexion, $query)
{
    $exito = $conexion->query($query);
    return $exito;
}

/**
 * Funcion para devolver el numero de rgistros afectados por la consulta de accion (INSERT, DELETE, UPDATE) inmediantamente anterior
 * @param $conexion Conexion a la base de datos que vamos a utilizar (caso procedimental)
 * @return num_registros Devuelve el número de registros como un entero
 */
function devolver_filas_afetadas_por_consulta($conexion){
    $num_filas = $conexion->affected_rows;
    return $num_filas;
}
