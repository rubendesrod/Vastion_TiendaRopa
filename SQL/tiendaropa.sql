create database dbTienda;
use dbTienda;

DROP TABLE IF EXISTS
    Administrador;
DROP TABLE IF EXISTS
    Usuario;
DROP TABLE IF EXISTS
    Prenda;
DROP TABLE IF EXISTS
    Añade;
    -- Crear la tabla Administrador
CREATE TABLE Administrador(
    ID INT PRIMARY KEY,
    correo VARCHAR(30),
    contraseña VARCHAR(25)
);
-- Crear la tabla Usuario
CREATE TABLE Usuario(
    correo VARCHAR(30) PRIMARY KEY,
    contraseña VARCHAR(30),
    nombre VARCHAR(30),
    apell1 VARCHAR(30),
    apell2 VARCHAR(30)
);
-- Crear la tabla Prenda
CREATE TABLE Prenda(
    ID INT PRIMARY KEY,
    nombre VARCHAR(30),
    marca VARCHAR(30),
    precio DECIMAL(10, 2),
    cantidad INT,
    talla VARCHAR(10),
    imagen varchar(200),
    ID_ADMIN INT,
    FOREIGN KEY(ID_ADMIN) REFERENCES Administrador(ID)
);
-- Crear la tabla Carrito
CREATE TABLE Carrito(
    ID INT PRIMARY KEY,
    correo_usuario INT,
    FOREIGN KEY(correo_usuario) REFERENCES Usuario(correo)
);
-- Crear la tabla Añade
CREATE TABLE Contenido(
    ID_Carrito INT,
    ID_Prenda INT,
    cantidad INT,
    PRIMARY KEY(ID_Carrito, ID_Prenda),
    FOREIGN KEY(ID_Carrito) REFERENCES Carrito(ID),
    FOREIGN KEY(ID_Prenda) REFERENCES Prenda(ID)
);
