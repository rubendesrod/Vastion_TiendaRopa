<?php
// Fichero que contiene las Constantes
require_once('configDB.php');
require_once('querys.php');
// Inicio la sesion para no tenerla que abrir por cada funcion realizada
session_start();
// Seteo la funcion que va a controlar los errores del programa
set_error_handler("miGestorDeErrores");



/**
 * Funcion para controlar los errores que puedan surguir
 */
function miGestorDeErrores($nivel, $mensaje)
{
    switch ($nivel) {
        case E_ERROR:
            echo "Error de tipo FATAL ERROR: $mensaje.<\br>";
            break;
        default:
            echo "Error de tipo no especificado: $mensaje.<br />";
            exit();
    }
}


/**
 * Funcion para realizar una conexion a la base de datos con PDO 
 * @return PDO objeto de la conexion a la base de datos o 0 si no se ha realizado la conexion
 */
function conectar_db()
{
    // crear la conexion a la db
    try {
        $conexion = new PDO(
            DSN,
            USER,
            PASS,
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
        );
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
 * Funcion para realizar el envio del login
 * @param array $datos array asciativo que contiene los datos del login
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
 * Funcion para comprobar que el que inicia la sesion no es el administrador
 * @param array $datos array asociativo que contiene los datos para realizar el logeo del administrador
 * @return BOOLEAN devuelve 1 o 0 / 1 si el logeo es correcto o 0 si no lo es
 */
function inicar_logeo_admin($datos)
{

    // Seteo la variable que voy a usar como flag
    $exito = 0;

    // Seteo las variables del array
    $correo = $datos["correo"];
    $contra = $datos["contraseña"];

    // hago la conexion con la base de datos
    $db = conectar_db();
    try {

        // Realizo la consulta preparada
        $consulta = $db->prepare(SELECT_ADMIN);
        $consulta->execute();
        $admin = $consulta->fetch(PDO::FETCH_OBJ);
        // Primero compruebo el correo
        if ($correo == $admin->correo) {
            // Compruebo la contraseña
            if ($contra == $admin->contraseña) {
                $exito = 1;
            }
        }
        return $exito;
    } catch (PDOException $e) {
        echo "Error pdoException: " . $e->getMessage();
    } catch (Exception $e) {
        echo "Error Exception: " . $e->getMessage();
    }
}



/**
 * Funcion para realizar el registro del usuario
 * @param array $datos array asociativo que contiene los datos del registro del usuario
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
                crear_carrito($correo);
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
 * Funcion para crear el carrito del usuario que se registre
 * @param string $correo_usuario correo del usuario que se va a vincular a la id del carrito
 */
function crear_carrito($correo_usuario)
{

    // Variable usada como flag
    $exito = 0;

    // Crear la conexion a la base de datos
    $db = conectar_db();

    try {
        $consulta = $db->prepare(INSERTAR_CARRITO);
        $consulta->bindParam(1, $correo_usuario);
        $consulta->execute();
        $exito = 0;
    } catch (PDOException $e) {
        echo "error en la consulta preparada " . $e->getMessage();
        exit();
    } catch (Exception $e) {
        echo "Error de expcepcion: " . $e->getMessage();
        exit();
    }

    return $exito;
}



/**
 * Funcion para sacar el id del carrito de un usuario
 * @param string $correo correo del usuario que se quiere saber el id del carrito
 * @return integer id del correo
 */
function sacar_id_carrito($correo)
{

    $db = conectar_db();

    try {

        $consulta = $db->prepare(SELECT_ID_CARRITO);
        $consulta->bindParam(1, $correo);
        $consulta->execute();

        $consulta->bindColumn(1, $id);
        $consulta->fetch(PDO::FETCH_BOUND);

        return $id;
    } catch (PDOException $e) {
        echo "error en la consulta preparada: " . $e->getMessage();
    } catch (Exception $e) {
        echo "errpr de excepcion no expecificado: " . $e->getMessage();
    }
}



/**
 * Funcion para añadir una prenda al carrito del usuario
 * @param array $datos contiene los datos para realizar el insert
 */
function añadir_prenda_carrito($datos)
{
    // Creo un array para verificar con los datos pasados en la funcion
    $arrayVerificacion = array(":idCarrito" => $datos[":idCarrito"], ":idPrenda" => $datos[":idPrenda"]);
    $db = conectar_db();

    try {
        // Primero compruebo que la prenda que el usuario quiere añadir esta ya añadida en el carrito
        $consulta = $db->prepare(SELECT_PRENDA_CARRITO_ID);
        $consulta->execute($arrayVerificacion);

        // Ahora compruebo que me devuelve alguna columna
        if ($consulta->rowCount() > 0) {

            // Almaceno el resultado con un array asociativo
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
            // Guarda la cantidad que hay en el carrito de esa prenda
            $cantidadPrenda = $resultado['cantidad'] + $datos[":cantidad"];

            // Cierro la consulta preparada anterior
            $consulta->closeCursor();

            // La prenda esta en el carrito hay que actualizar la cantidad
            $query = "UPDATE contenido SET cantidad = :cantidad WHERE ID_Prenda = :idPrenda";
            $consulta = $db->prepare($query);

            // Saco la cantidad de la prenda que quiero actualizar
            $arrayActualizar = array(":cantidad" => $cantidadPrenda, ":idPrenda" => $datos[":idPrenda"]);
            $consulta->execute($arrayActualizar);

            // Actualizo la prenda con los datos mandados pero solo me resta la cantidad que se ha vuelto ha enviar
            actualizar_prenda($datos, "restar");
        } else {

            // Cierro la consulta preparada anterior
            $consulta->closeCursor();

            // La prenda no esta en el carrito hay que añadirla
            $consulta = $db->prepare(INSERTAR_PRENDA_CARRITO);
            $consulta->execute($datos);

            if ($consulta->rowCount() <= 0) {
                throw new Exception("Error: no se pudo insertar la prenda al carrito", 1);
            }

            // Actualizo los datos de la prenda restando en este caso
            actualizar_prenda($datos, "restar");
        }
    } catch (PDOException $e) {
        echo "error en la consulta preparada: " . $e->getMessage();
        exit();
    } catch (Exception $e) {
        echo "error de exception no identificado: " . $e->getMessage();
        exit();
    }
}



/**
 * Funcion para actualizar la cantidad de una prenda
 * @param array $datos contiene los datos de id y cantidad de la prenda
 * @param STRING $operacion contiene el tipo de operacion que va a realizar en la actualizacion
 */
function actualizar_prenda($datos, $operacion)
{

    $db = conectar_db();

    $cantidadReal = cantidad_prenda($datos[":idPrenda"]);
    // Ahora sacamos la cantidad total que quedaría de la prenda
    switch ($operacion) {
        case "restar":
            $cantidadTotal = $cantidadReal - $datos[":cantidad"];
            break;
        case "sumar":
            $cantidadTotal = $cantidadReal + $datos[":cantidad"];
            break;
    }


    try {

        $query = $db->prepare(ACTUALZIAR_PRENDA_CANTIDAD);
        $query->bindParam(1, $cantidadTotal);
        $query->bindParam(2, $datos[":idPrenda"]);
        $query->execute();
    } catch (PDOException $e) {
        echo "error en la consulta preparada: " . $e->getMessage();
        exit();
    } catch (Exception $e) {
        echo "error de exception no identificado: " . $e->getMessage();
        exit();
    }
}



/**
 * Funcion para sacar la cantidad de una prenda
 * @param integer $id_prenda id de la prenda que se quiere saber la cantidad
 * @return integer cantidad de la prenda
 */
function cantidad_prenda($id_prenda)
{

    $db = conectar_db();

    try {

        $consulta = $db->prepare(SELECT_PRENDA_ID);
        $consulta->bindParam(1, $id_prenda);
        $consulta->execute();
        $pr = $consulta->fetch(PDO::FETCH_OBJ);
        return $pr->cantidad;
    } catch (PDOException $e) {
        echo "error en la consulta preparada: " . $e->getMessage();
        exit();
    } catch (Exception $e) {
        echo "error de exception no identificado: " . $e->getMessage();
        exit();
    }
}



/**
 * Funcion que devolverá todas las prendas disponibles en la tienda
 */
function devolver_prendas()
{

    // Inicio la conexion a la base de datos
    $db = conectar_db();

    // Parámetros de paginación
    $elementosPorPagina = 5;
    $paginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
    $offset = ($paginaActual - 1) * $elementosPorPagina;

    // Realizo la consulta preparada con LIMIT y OFFSET
    try {
        // nombre, marca, precio, cantidad, talla, imagen
        $consulta = $db->prepare(SELECT_PRENDAS . " LIMIT :elementosPorPagina OFFSET :offset");
        $consulta->bindParam(':elementosPorPagina', $elementosPorPagina, PDO::PARAM_INT);
        $consulta->bindParam(':offset', $offset, PDO::PARAM_INT);
        $consulta->bindColumn(1, $id);
        $consulta->bindColumn(2, $nombre);
        $consulta->bindColumn(3, $marca);
        $consulta->bindColumn(4, $precio);
        $consulta->bindColumn(5, $cantidad);
        $consulta->bindColumn(6, $talla);
        $consulta->bindColumn(7, $imagen);
        $consulta->execute();

        while ($prenda = $consulta->fetch(PDO::FETCH_BOUND)) {
            echo <<<FIN
            <div class="prenda">
                <img class="card-img" src="./HTML$imagen" alt="$nombre-$marca"/>
                <hr>
                <div class="card-info">
                    <p class="card-title">$nombre - $marca</p>
                    <p class="card-details">$cantidad - Talla: $talla</p>
                    <p class="card-price">$precio €</p>
                    <form action="./HTML/infoPrenda.php" method="post">
                        <button class="add-button" name="id" value="$id">VER</button>
                    </form>
                </div>
            </div>
            FIN;
        }

        // Agregar enlaces de paginación
        $totalElementos = $db->query("SELECT count(*) FROM prenda WHERE cantidad > 0")->fetchColumn();
        // saco el total de elemento con el total de elemento que tengo y los elementos que quiero por pagina
        $totalPaginas = ceil($totalElementos / $elementosPorPagina);
        echo "</div><div class='paginas'>";
        for ($i = 1; $i <= $totalPaginas; $i++) {
            echo '<a href="?pagina=' . $i . '">' . $i . '</a> ';
        }
    } catch (PDOException $e) {
        echo "La consulta no se ha realizado correctamente:<br>" . $e->getMessage();
    }
}

/**
 * Funcion para devolver una sola prenda, que será cual usuario quiera ver una de las prendas que hay mostradas
 * @param INTEGER $id id de la prenda que le usuario ha seleccionado
 * @return Object objeto de la prenda de ropa
 */
function devolver_prenda($id)
{

    $db = conectar_db();

    try {

        $consulta = $db->prepare(SELECT_PRENDA_ID);
        $consulta->bindParam(1, $id);
        $consulta->execute();
        return $consulta->fetch(PDO::FETCH_OBJ);
    } catch (PDOException $e) {
        echo "error con la sonsulta preparada: " . $e->getMessage();
    } catch (Exception $e) {
        echo "Error de expcepcion no expecificado: " . $e->getMessage();
    }
}


/**
 * Funcion para devolver los datos de la cuenta 
 */
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
                        <div><form action="./cambiarContra.php">
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



/**
 * Funcion para mostrar el carrito de un usuario en concreto
 * @param integer $id_carrito id del carrito que se quiere mostrar
 */
function mostrar_carrito_usuario($id_carrito)
{

    // Primero realizar la conexion a la base de datos
    $db = conectar_db();

    // Seteo una varaible para el total de € del carrito
    $totalPagar = 0;

    // Array con los parametros para la consulta
    $array_parametros = array(":idCarrito" => $id_carrito);

    // sacar todas las id de las prendas que tiene el carrito del usuario
    try {

        $consulta = $db->prepare(SELECT_CONTENIDO_CARRITO_ID);
        $consulta->bindColumn(1, $id_prenda);
        // COn esto saco la cantidad de esa prenda que el usuario ha elegido
        $consulta->bindColumn(2, $prenda_cantidad);
        $consulta->execute($array_parametros);
        if ($consulta->rowCount() == 0) {
            // Si la consulta no devuelve ninguna fila no hay contenido en el carrito
            echo <<<FIN
                <div class="sinContenido">
                    <h1>No has añadido nada a tu carrito de momento</h1>
                    <a href="../index.php">MIRAR ROPA</a>
                </div>
            FIN;
        } else {
            while ($contenido = $consulta->fetch(PDO::FETCH_BOUND)) {
                // Ahora estoy recorriendo el contenido del carrito de un usuario
                $prenda = devolver_prenda($id_prenda);
                $totalPagar += $prenda_cantidad * $prenda->precio;
                echo <<<FIN
                <div class="carrito">
                    <div class="item">
                        <img src=".$prenda->imagen" alt="Prenda">
                        <div class="info">
                            <div class="nombre">{$prenda->nombre}</div>
                            <div class="precio">Talla: {$prenda->talla}</div>
                            <div class="precio">Precio: {$prenda->precio}€</div>
                            <div class="cantidad">Cantidad: {$prenda_cantidad}</div>
                            <a 
                            href="../PHP/eliminarPrenda.php
                                    ?idPrenda=$id_prenda
                                    &idCarrito=$id_carrito
                                    &cantidad=$prenda_cantidad" 
                                    class="eliminar">
                                Eliminar
                            </a>
                        </div>
                    </div>
                </div>
                FIN;
            }
            echo <<<FIN
            <div class="boton">
                <form action="./confirmarPedido.php" method="post">
                    <p>Total a pagar: {$totalPagar}€</p>
                    <button>CONFIRMAR PEDIDO</button>
                </form>
            </div>
            FIN;
        }
    } catch (PDOException $e) {
        echo "Error en la consulta preparada: " . $e->getMessage();
        exit();
    } catch (Exception $e) {
        echo "Error de excepcion no especificado: " . $e->getMessage();
        exit();
    }
}



/**
 * Funcion para mostrar las prendas en la tabla del administrador
 */
function mostar_tabla_administrador()
{

    // Realizo la conexion a la base de datos
    $db = conectar_db();

    // Parámetros de paginación
    $elementosPorPagina = 5;
    $paginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
    $offset = ($paginaActual - 1) * $elementosPorPagina;

    try {
        // nombre, marca, precio, cantidad, talla, imagen
        $consulta = $db->prepare(SELECT_PRENDAS . " LIMIT :elementosPorPagina OFFSET :offset");
        $consulta->bindParam(':elementosPorPagina', $elementosPorPagina, PDO::PARAM_INT);
        $consulta->bindParam(':offset', $offset, PDO::PARAM_INT);
        $consulta->bindColumn(1, $id);
        $consulta->bindColumn(2, $nombre);
        $consulta->bindColumn(3, $marca);
        $consulta->bindColumn(4, $precio);
        $consulta->bindColumn(5, $cantidad);
        $consulta->bindColumn(6, $talla);
        $consulta->bindColumn(7, $imagen);
        $consulta->execute();

        // Obtener nombres de columnas
        $numColumnas = $consulta->columnCount();
        $nombresColumnas = [];
        echo "<table><tr>";
        for ($i = 0; $i < $numColumnas; $i++) {
            $columna = $consulta->getColumnMeta($i);
            echo "<th>" . $columna['name'] . "</th>";
        }
        echo "</tr>";

        // Saco fila por cada prenda que hay en la base de datos
        while ($prenda = $consulta->fetch(PDO::FETCH_BOUND)) {
            echo <<<FIN
                <tr>
                    <td>$id</td>
                    <td>$nombre</td>
                    <td>$marca</td>
                    <td><input type="number" min="0" name="precio[$id]" step="any" value="$precio"/></td>
                    <td><input type="number" min="0" name="cantidad[$id]" value="$cantidad"/></td>
                    <td>$talla</td>
                    <td>$imagen</td>   
                    <td><button name="id" value="$id">Modificar</button></td>
                </tr>
            FIN;
        }

        echo "</div></table></div>";
        // Agregar enlaces de paginación
        $totalElementos = $db->query("SELECT count(*) FROM prenda")->fetchColumn();
        // saco el total de elemento con el total de elemento que tengo y los elementos que quiero por pagina
        $totalPaginas = ceil($totalElementos / $elementosPorPagina);
        echo "<div class='paginas'>";
        for ($i = 1; $i <= $totalPaginas; $i++) {
            echo '<a href="?pagina=' . $i . '">' . $i . '</a> ';
        }
    } catch (PDOException $e) {
        echo "La consulta no se ha realizado correctamente:<br>" . $e->getMessage();
    }
}
