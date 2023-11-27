create database dbTienda;
use dbTienda;

DROP TABLE IF EXISTS
    Usuario;
DROP TABLE IF EXISTS
    Administrador;
DROP TABLE IF EXISTS
    Prenda;
DROP TABLE IF EXISTS
    Añade;

    -- Crear la tabla Administrador
CREATE TABLE Administrador(
    ID INT PRIMARY KEY AUTO_INCREMENT,
    correo VARCHAR(255),
    contraseña VARCHAR(255)
);
-- Crear la tabla Usuario
CREATE TABLE Usuario(
    ID INT PRIMARY KEY AUTO_INCREMENT,
    correo VARCHAR(255),
    contraseña VARCHAR(255),
    nombre VARCHAR(255),
    apell1 VARCHAR(255),
    apell2 VARCHAR(255)
);
-- Crear la tabla Prenda
CREATE TABLE Prenda(
    ID INT PRIMARY KEY AUTO_INCREMENT,
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
    ID INT PRIMARY KEY AUTO_INCREMENT,
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

-- Inserción en la tabla Administrador
INSERT INTO Administrador (correo, contraseña)
VALUES ('admin@example.com', 'contraseña123');

-- Inserciones en la tabla Usuario
INSERT INTO Usuario ( correo, contraseña, nombre, apell1, apell2)
VALUES
    ('usuario1@example.com', 'contraseña1', 'Juan', 'Pérez', 'López'),
    ('usuario2@example.com', 'contraseña2', 'Ana', 'González', 'Sánchez'),
    ('usuario3@example.com', 'contraseña3', 'Carlos', 'Martínez', 'Jiménez'),
    ('usuario4@example.com', 'contraseña4', 'María', 'Fernández', 'Gómez'),
    ('usuario5@example.com', 'contraseña5', 'Pedro', 'Rodríguez', 'Ramírez');

-- Inserciones en la tabla Prenda
INSERT INTO Prenda (nombre, marca, precio, cantidad, talla, ID_ADMIN)
VALUES
    ('Camiseta', 'Nike', 29.99, 50, 'M', 1),
    ('Jeans', "Levi's", 59.99, 30, 'S', 1),
    ('Zapatillas', 'Adidas', 89.99, 20, '42', 1),
    ('Vestido', 'H&M', 39.99, 15, 'S', 1),
    ('Sudadera', 'Puma', 49.99, 40, 'L', 1);

-- Inserciones en la tabla Carrito
INSERT INTO Carrito (ID_Usuario)
VALUES
    (1),
    (2),
    (3),
    (4),
    (5);

-- Inserciones en la tabla Añade
INSERT INTO Añade (ID_Carrito, ID_Prenda, cantidad)
VALUES
    (1, 1, 2),
    (1, 2, 1),
    (2, 3, 3),
    (3, 4, 1),
    (4, 5, 2);
