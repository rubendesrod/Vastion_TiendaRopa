<?php
   // Fichero que contiene las Constantes
require_once('configDB.php');

/**
 * Funcion para comprobar que se ha iniciado sesión de alguna manera
 * @return flag Devuelve 1 si se ha iniciado sesion o 0 si no se ha iniciado sesión
 */
function comprobar_acceder_sin_logear(){
    session_start();
    if(isset($_SESSION["login"])){
        return 1;
    }else{
        return 0;
    }
}

/**
 * Funcion para comprobar el envio del login
 * @param conexion objeto que contiene la conexion a la base de datos
 * @param datos array asciativo que contiene los datos del login
 * @return exito devuelve un 1 si el logeo es correcto o 0 si el logeo no es correcto
 */
function comprobar_login($conexion, $datos){

}

/**
 * Funcion para comprobar el registro del usuario
 * @param conexion objeto que contiene la conexion a la base de datos
 * @param datos array asociativo que contiene los datos del registro del usuario
 * @return exito devuelve 1 si se ha registrado correctamente o 0 si no se ha podido registrar
 */
function comprobar_registro($conexion, $datos){

}

