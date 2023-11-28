<?php
   // Fichero que contiene las Constantes
require_once('configDB.php');
require_once ('querys.php');

/**
 * Funcion para comprobar que se ha iniciado sesión de alguna manera antes de entrar al index u otra página
 * @return exito Devuelve 1 si se ha iniciado sesion o 0 si no se ha iniciado sesión
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
 * Funcion para realizar el envio del login y también se comprobará si el que intenta inicar es el admin
 * @param datos array asciativo que contiene los datos del login
 * @return exito devuelve un 1 si el logeo es correcto o 0 si el logeo no es correcto
 */
function iniciar_login($datos){

    $conexion = new mysqli(HOST,USER,PASS,DB);
    $exito = 0;
    
    if($conexion){
        // Comprobar que existe el correo de ese usuario
        // Si existe comparar las contraseñas si no datos incorrectos
        $correo = $datos['correo'];
        $contra = $datos['contraseña'];

        $consulta = $conexion->prepare(SELECT_USUARIO_CORREO_CONTRASEÑA);
        $consulta->bind_param('s', $correo);
        $consulta->execute();
        if($consulta->num_rows() > 0){
            // Comprobar la contraseña
            $consulta->close();
            $exito = 1;
        }else{
            // El correo no existe
            $consulta->close();
            $exito = 0;
        }

    }else{
        echo "<h1>No se ha podido realizar la conexion a la DB</h1>";
        $conexion->close();
        $exito = 0;
    }

    $conexion->close();
    return $exito;

}

/**
 * Funcion para realizar el registro del usuario
 * @param datos array asociativo que contiene los datos del registro del usuario
 * @return exito devuelve 1 si se ha registrado correctamente o 0 si no se ha podido registrar
 */
function iniciar_registro($datos){

    $conexion = new mysqli(HOST,USER,PASS,DB);
    $exito = 0;
    
    if($conexion){

        $correo = $datos['correo'];
        $contra = $datos['contraseña'];
        $nombre = $datos['nombre'];
        $apell1 = $datos['apell1'];
        $apell2 = $datos['apell2'];

        $consulta = $conexion->prepare(SELECT_USUARIO_CORREO_CONTRASEÑA);
        $consulta->bind_param('s', $correo);
        $consulta->execute();
        if($consulta->num_rows() > 0){
            // Existe el correo
            // No podrá  hacer el registro
            $consulta->close();
            $conexion->close();
            $exito = 0;
        }else{
            // No existe el correo
            // Se le registrara como nuevo usuario en la DB
            $consulta->close();
            $consulta = $conexion->prepare(INSERTAR_USUARIO);
            $consulta->bind_param('sssss', $correo, $contra, $nombre, $apell1, $apell2);
            $consulta->execute();
            if($consulta->num_rows() > 0){
                // El usuario ha sido registrado en la DB
                $conexion->close();
                $exito = 1;
            }else{
                // El usuario no ha sido registrado en la DB
                $conexion->close();
                $exito = 0;
            }
        }

    }else{
        echo "<h1>No se ha podido realizar la conexion a la DB</h1>";
        $exito = 0;
    }
    
}

