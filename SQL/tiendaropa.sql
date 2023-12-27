create database if not exists dbTienda;

use dbTienda;


DROP TABLE IF EXISTS prenda;

DROP TABLE IF EXISTS administrador;

DROP TABLE IF EXISTS usuario;

DROP TABLE IF EXISTS añade;

-- Crear la tabla Administrador
CREATE TABLE administrador(
    correo VARCHAR(30) PRIMARY KEY,
    contraseña VARCHAR(25)
);

-- Crear la tabla Usuario
CREATE TABLE usuario(
    correo VARCHAR(30) PRIMARY KEY,
    contraseña VARCHAR(32),
    nombre VARCHAR(30),
    apell1 VARCHAR(30),
    apell2 VARCHAR(30)
);

-- Crear la tabla Prenda
CREATE TABLE prenda(
    ID INT PRIMARY KEY auto_increment,
    nombre VARCHAR(30),
    marca VARCHAR(30),
    precio DECIMAL(10, 2),
    cantidad INT,
    talla VARCHAR(10),
    imagen varchar(200),
    ID_ADMIN VARCHAR(30),
    FOREIGN KEY(ID_ADMIN) REFERENCES Administrador(correo)
);

-- Crear la tabla Carrito
CREATE TABLE carrito(
    ID INT PRIMARY KEY auto_increment,
    correo_usuario VARCHAR(30),
    FOREIGN KEY(correo_usuario) REFERENCES Usuario(correo)
);

-- Crear la tabla Añade
CREATE TABLE contenido(
    ID_Carrito INT,
    ID_Prenda INT,
    cantidad INT,
    PRIMARY KEY(ID_Carrito, ID_Prenda),
    FOREIGN KEY(ID_Carrito) REFERENCES Carrito(ID),
    FOREIGN KEY(ID_Prenda) REFERENCES Prenda(ID)
);

-- INSERT ADMINISTRADOR
INSERT INTO
    administrador
VALUES
    ('admin@gmail.com', 'admin');

-- INSERT USUARIO
INSERT INTO
    usuario
VALUES
    (
        'ruben@gmail.com',
        '81dc9bdb52d04dc20036dbd8313ed055',
        'Ruben',
        'Descalzo',
        'Rodríguez'
    );

-- INSERT PRENDA
INSERT INTO
    prenda
VALUES
    (1,'Polo', 'Versacce', '60€', '2', 'S', '/IMG/polo_verssace.png', 'admin@gmail.com'),
    (2,'Polo', 'Versacce', '60€', '5', 'L', '/IMG/polo_verssace.png', 'admin@gmail.com'),
    (3,'Polo', 'Ralph Lauren', '68€', '10', 'XS', '/IMG/polo_RalpLauren.png', 'admin@gmail.com'),
    (4,'Polo', 'Ralph Lauren', '72€', '3', 'M', '/IMG/polo_RalpLauren.png','admin@gmail.com'),
    (5,'Chandal', 'Ralph Lauren', '102€', '12', 'S', '/IMG/chandal_ralphLauren.png', 'admin@gmail.com'),
    (6,'Chandal', 'Nike Tech', '220€', '16', 'L', '/IMG/nikeTech.png', 'admin@gmail.com'),
    (7,'Cazadora', 'Trapstar', '413€', '6', 'S', '/IMG/trapstarCazadora.png', 'admin@gmail.com'),
    (8,'Cazadora', 'Nike Nocta', '300€', '4', 'S', '/IMG/NikeNocta.png', 'admin@gmail.com'),
    (9,'Sudadera', 'Ami Paris', '90€', '13', 'L', '/IMG/SudaderaAmi.png', 'admin@gmail.com'),
    (10,'Camiseta', 'Balenciaga', '74€', '13', 'XXL', '/IMG/CamisetaBalenciaga.png', 'admin@gmail.com');


-- INSERT CARRITO
INSERT INTO 
    carrito
VALUES
    (1,'ruben@gmail.com');

-- INSERT CONTENIDO
INSERT INTO 
    contenido
VALUES
    (1, 1, 1),
    (1, 5, 2);
    
    

