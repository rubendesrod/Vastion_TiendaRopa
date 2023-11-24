create database tienda;
use tienda;

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
    correo VARCHAR(255),
    contraseña VARCHAR(255)
);
-- Crear la tabla Usuario
CREATE TABLE Usuario(
    ID INT PRIMARY KEY,
    correo VARCHAR(255),
    contraseña VARCHAR(255),
    nombre VARCHAR(255),
    apell1 VARCHAR(255),
    apell2 VARCHAR(255)
);
-- Crear la tabla Prenda
CREATE TABLE Prenda(
    ID INT PRIMARY KEY,
    nombre VARCHAR(255),
    marca VARCHAR(255),
    precio DECIMAL(10, 2),
    cantidad INT,
    talla VARCHAR(10),
    ID_ADMIN INT,
    FOREIGN KEY(ID_ADMIN) REFERENCES Administrador(ID)
);
-- Crear la tabla Carrito
CREATE TABLE Carrito(
    ID INT PRIMARY KEY,
    ID_Usuario INT,
    FOREIGN KEY(ID_Usuario) REFERENCES Usuario(ID)
);
-- Crear la tabla Añade
CREATE TABLE Añade(
    ID_Carrito INT,
    ID_Prenda INT,
    cantidad INT,
    PRIMARY KEY(ID_Carrito, ID_Prenda),
    FOREIGN KEY(ID_Carrito) REFERENCES Carrito(ID),
    FOREIGN KEY(ID_Prenda) REFERENCES Prenda(ID)
);
