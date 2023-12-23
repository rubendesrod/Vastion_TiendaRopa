<?php

// CONSULTAS INSERT

define("INSERTAR_USUARIO", 'INSERT INTO usuario VALUES (?,?,?,?,?)');
define("INSERTAR_PRENDA", 'INSERT INTO prenda VALUES(?,?,?,?,?,?, "admin@gmail.com")');
define("INSERTAR_CARRITO", 'INSERT INTO carrito(correo_usuario) VALUES(?)');
define("INSERTAR_CONTENIDO", 'INSERT INTO contenido VALUES(?, ?, ?)');
define("INSERTAR_PRENDA_CARRITO", 'INSERT INTO contenido VALUES (:idCarrito, :idPrenda, :cantidad)');


// CONSULTAS UPDATE

define("ACTUALIZAR_USUARIO_CONSTRASEÑA", 'UPDATE usuario SET contraseña = ? WHERE correo = ?');
define("ACTUALIZAR_USUARIO_NOMBRE", 'UPDATE usuario SET nombre = ? WHERE correo = ?');
define("ACTUALIZAR_USUARIO_APELL1", 'UPDATE usuario SET apell1 = ? WHERE correo = ?');
define("ACTUALIZAR_USUARIO_APELL2", 'UPDATE usuario SET apell2 = ? WHERE correo = ?');

define("ACTUALZIAR_PRENDA_NOMBRE", 'UPDATE prenda SET nombre = ? WHERE ID = ?');
define("ACTUALZIAR_PRENDA_MARCA", 'UPDATE prenda SET marca = ? WHERE ID = ?');
define("ACTUALZIAR_PRENDA_PRECIO", 'UPDATE prenda SET precio = ? WHERE ID = ?');
define("ACTUALZIAR_PRENDA_CANTIDAD", 'UPDATE prenda SET cantidad = ? WHERE ID = ?');
define("ACTUALZIAR_PRENDA_TALLA", 'UPDATE prenda SET talla = ? WHERE ID = ?');
define("ACTUALZIAR_PRENDA_IMAGEN", 'UPDATE prenda SET imagen = ? WHERE ID = ?');

define("ACTUALIZAR_CANTIDAD_PRENDA", 'UPDATE contenido SET cantidad = ? WHERE ID_Prenda = ? AND ID_Carrito = ?');


// CONSULATAS DELETE
define("BORRAR_PRENDA", 'DELETE FROM prenda WHERE ID = ?');
define("BORRAR_PRENDA_CARRITO", 'DELETE FROM contenido WHERE ID_Prenda = :idPrenda AND ID_Carrito = :idCarrito');


// Consultas SELECT
define("SELECT_CONTENIDO_CARRITO_ID", 'SELECT ID_Prenda, cantidad  FROM contenido WHERE ID_Carrito = :idCarrito');
define("SELECT_USUARIO_CORREO_CONTRASEÑA", 'SELECT correo, contraseña FROM usuario WHERE correo = ?');
define("SELECT_USUARIO", 'SELECT * FROM usuario WHERE correo = ?');
define("SELECT_PRENDAS", 'SELECT ID, nombre, marca, precio, cantidad, talla, imagen FROM prenda');
define("SELECT_PRENDA_ID", 'SELECT * FROM prenda WHERE ID = ?');
define("SELECT_ID_CARRITO", 'SELECT id FROM carrito WHERE correo_usuario = ?');


?>