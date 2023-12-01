<?php
// Fichero que contiene las Constantes
require_once('configDB.php');
require_once('querys.php');
// Inicio la sesion para no tenerla que abrir por cada funcion realizada
session_start();

/**
 * Funcion para comprobar que se ha iniciado sesión de alguna manera antes de entrar al index u otra página
 * @return exito Devuelve 1 si se ha iniciado sesion o 0 si no se ha iniciado sesión
 */
function comprobar_acceder_sin_logear()
{
    // Compruebo que se ha hecho login si la sesion['login'] ha sido definida
    if (isset($_SESSION["login"])) {
        return 0;
    } else {
        return 1;
    }
}

/**
 * Funcion para realizar el envio del login y también se comprobará si el que intenta inicar es el admin
 * @param datos array asciativo que contiene los datos del login
 * @return exito devuelve un 1 si el logeo es correcto o 0 si el logeo no es correcto
 */
function iniciar_login($datos)
{

    $conexion = new mysqli(HOST, USER, PASS, DB);
    $exito = 0;

    if ($conexion) {
        // Comprobar que existe el correo de ese usuario
        // Si existe comparar las contraseñas si no datos incorrectos
        $correo = $datos['correo'];
        $contra = md5($datos['contraseña']);

        // Consulta preparada
        $consulta = $conexion->prepare(SELECT_USUARIO_CORREO_CONTRASEÑA);
        $consulta->bind_param('s', $correo);
        $consulta->execute();

        // Almaceno el resultado
        $result = $consulta->get_result();

        // Compruebo que exista el resultado
        if ($result->num_rows > 0) {

            // Si que existe ese correo ahora se comprueba la contraseña
            $datosUsuario = $result->fetch_object();
            if ($contra == $datosUsuario->contraseña) {
                // El usuario se ha logeado correctamente
                $exito = 1;
            } else {
                // La contraseña es incorrecta
                $exito = 0;
            }

            // Cierro las dos consultas realizadas
            $result->close();
            $consulta->close();
        } else {
            // El correo no existe
            $consulta->close();
            $exito = 0;
        }
    } else {
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
function iniciar_registro($datos)
{

    $conexion = new mysqli(HOST, USER, PASS, DB);
    $exito = 0;

    // Compruebo que me ha devuelto el objeto de conexion
    if ($conexion) {

        // Almaceno los datos del array pasado por parametro
        $correo = $datos['correo'];
        $contra = md5($datos['contraseña']);
        $nombre = $datos['nombre'];
        $apell1 = $datos['apell1'];
        $apell2 = $datos['apell2'];

        // Consulta preparada
        $consulta = $conexion->prepare(SELECT_USUARIO_CORREO_CONTRASEÑA);
        $consulta->bind_param('s', $correo);
        $consulta->execute();

        // Obtengo el resultado
        $result = $consulta->get_result();

        // Verifico si se ha encontrado un usuario
        if ($result->num_rows > 0) {
            // Existe el correo
            // No podrá  hacer el registro
            $consulta->close();
            $exito = 0;
        } else {
            // No existe el correo
            // Se le registrara como nuevo usuario en la DB
            $consulta->close();

            // Consulta preparada
            $consulta = $conexion->prepare(INSERTAR_USUARIO);
            $consulta->bind_param('sssss', $correo, $contra, $nombre, $apell1, $apell2);
            $consulta->execute();

            // Almaceno el resultado
            $result = $consulta->get_result();
            if ($result->num_rows > 0) {
                // El usuario ha sido registrado en la DB
                $exito = 1;
            } else {
                // El usuario no ha sido registrado en la DB
                $exito = 0;
            }
        }
    } else {
        echo "<h1>No se ha podido realizar la conexion a la DB</h1>";
        $exito = 0;
    }

    $conexion->close();
    return $exito;
}

/**
 * Funcion que devolverá todas las prendas disponibles en la tienda
 */
function devolver_prendas()
{

    // Inicio la conexion a la base de datos
    try {

        $db = new PDO(
            DSN,
            USER,
            PASS,
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
        );

    } catch (PDOException $e) {
        echo "Error en la conexion a la DB ".$e->getMessage();
    }

    // Realizo la consulta preparada
    try {

        // nombre, marca, precio, cantidad, talla, imagen
        $consulta = $db->query(SELECT_PRENDAS);
        $consulta->bindColumn(1, $nombre);
        $consulta->bindColumn(2, $marca);
        $consulta->bindColumn(3, $precio);
        $consulta->bindColumn(4, $cantidad);
        $consulta->bindColumn(5, $talla);
        $consulta->bindColumn(6, $imagen); 
        while($prenda = $consulta->fetch(PDO::FETCH_BOUND)){
            echo<<<FIN
            <div class="prenda">
            <p> $nombre -- $marca [$precio €]</p>
            <p> $cantidad -- $talla</p>
            <img src="./HTML$imagen" alt="$nombre-$marca"/>
                <button>AÑADIR</button>
            </div>
            FIN;
        }


    } catch (PDOException $e) {
        echo "La conulsta no se ha realizado correctamente:<br>".$e->getMessage();
    }

}
