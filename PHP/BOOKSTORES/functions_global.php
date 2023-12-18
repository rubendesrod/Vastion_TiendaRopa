<?php
// Fichero que contiene las Constantes
require_once('configDB.php');
require_once('querys.php');
// Inicio la sesion para no tenerla que abrir por cada funcion realizada
session_start();


/**
 * Funcion para realizar una conexion a la base de datos con PDO 
 * @return PDO objeto de la conexion a la base de datos o 0 si no se ha realizado la conexion
 */
function conectar_db()
{
    // crear la conexion a la db
    try {
        $conexion = new PDO(DSN, USER, PASS);
        return $conexion;
    } catch (PDOException $e) {
        echo "No se ha podido realizar la conexion a la DB" . $e->getMessage();
        exit();
    } catch (Exception $e) {
        echo "hay algun tipo de error al intentar crear la DB" . $e->getMessage();
        exit();
    }
}



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
                // Guardo el correo en la sesion para saber el usuario que hace las acciones
                $_SESSION["correo"] = $correo;
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
            try {
                // Consulta preparada
                $consulta = $conexion->prepare(INSERTAR_USUARIO);
                $consulta->bind_param('sssss', $correo, $contra, $nombre, $apell1, $apell2);
                $consulta->execute();
                $exito = 1;
            } catch (Exception $e) {
                echo "error de excepcion" . $e->getMessage();
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
        echo "Error en la conexion a la DB " . $e->getMessage();
    }

    // Realizo la consulta preparada
    try {

        // nombre, marca, precio, cantidad, talla, imagen
        $consulta = $db->query(SELECT_PRENDAS);
        $consulta->bindColumn(1, $id);
        $consulta->bindColumn(2, $nombre);
        $consulta->bindColumn(3, $marca);
        $consulta->bindColumn(4, $precio);
        $consulta->bindColumn(5, $cantidad);
        $consulta->bindColumn(6, $talla);
        $consulta->bindColumn(7, $imagen);
        while ($prenda = $consulta->fetch(PDO::FETCH_BOUND)) {
            echo <<<FIN
            <div class="prenda">
                <img class="card-img" src="./HTML$imagen" alt="$nombre-$marca"/>
                <hr>
                <div class="card-info">
                    <p class="card-title">$nombre - $marca</p>
                    <p class="card-details">$cantidad - Talla: $talla</p>
                    <p class="card-price">$precio €</p>
                    <form action="../PHP/añadirPrenda.php">
                    <button class="add-button" name="id" value="$id">AÑADIR</button>
                    </form>
                </div>
            </div>
            FIN;
        }


    } catch (PDOException $e) {
        echo "La conulsta no se ha realizado correctamente:<br>" . $e->getMessage();
    }

}

/**Funcion para devolver los datos de la cuenta */
function detalles_cuenta()
{
    $correo = $_SESSION["correo"];

    // Primero realizar la conexion a la base de datos
    $db = conectar_db();

    try {

        $consulta = $db->prepare(SELECT_USUARIO);
        $consulta->bindParam(1, $correo);
        if ($consulta->execute()) {
            if ($consulta->rowCount() > 0) {
                while ($cuenta = $consulta->fetch(PDO::FETCH_OBJ)) {
                    echo <<<FIN
                    <div class="detallesCuenta">
                        <div><h4>Correo: </h4><p> $cuenta->correo</p></div>
                        <div><h4>Nombre: </h4> <p>$cuenta->nombre</p></div>
                        <div><h4>Apellidos: </h4> <p>$cuenta->apell1 $cuenta->apell2</p></div>
                        <div><form action="../PHP/cambiarContra.php">
                            <button>cambiar contraseña</button>
                        </form></div>
                    </div>
                    FIN;
                }
            }
        }

    } catch (PDOException $e) {
        echo "Error en la preparación de la consulta" . $e->getMessage();
    } catch (Exception $e) {
        echo "Error no especificado de excepcion" . $e->getMessage();
    }

}
