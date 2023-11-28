<?php
   // Fichero que contiene las Constantes
require_once './functions_database.php';
require_once './querys.php';

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
 * @param datos array asciativo que contiene los datos del login
 * @return exito devuelve un 1 si el logeo es correcto o 0 si el logeo no es correcto
 */
function comprobar_login($datos){

    $conexion = conectar_db();
    if($conexion){
        $exito = 0;
        // Comprobar que existe el correo de ese usuario
        // Si existe comparar las contraseñas si no datos incorrectos
        $correo = $datos['correo'];
        $contra = $datos['contraseña'];

        $conexion->prepare(SELECT_USUARIO_CORREO_CONTRASEÑA);
        $conexion->bin_param('s', $correo);
        $conexion->execute();
        $result = $conexion->store_result();
        if($result->num_rows() > 0){
            // Comprobar la contraseña
            return $exito = 1;
        }else{
            // El correo no existe
            return $exito
        }


    }else{
        echo "<h1>No se ha podido realizar la conexion a la DB</h1>";
    }
    cerrar_db($conexion);
}

/**
 * Funcion para comprobar el registro del usuario
 * @param datos array asociativo que contiene los datos del registro del usuario
 * @return exito devuelve 1 si se ha registrado correctamente o 0 si no se ha podido registrar
 */
function comprobar_registro($datos){

}

