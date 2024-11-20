CREATE DATABASE IF NOT EXISTS webii_productstpe;
USE webii_productstpe;

/* Tabla categories */
CREATE TABLE IF NOT EXISTS categories (
    idcat INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

/* Tabla products */
CREATE TABLE IF NOT EXISTS products (
    idproduct INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description VARCHAR(200) NOT NULL,
    idcategory INT,
    stock BOOLEAN NOT NULL,
    price FLOAT NOT NULL,
    imgproduct VARCHAR(350),
    FOREIGN KEY (idcategory) REFERENCES categories(idcat)
);

/* Tabla users */
CREATE TABLE IF NOT EXISTS users (
    iduser INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    surname VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL,
    pass VARCHAR(150) NOT NULL,
    admin BOOLEAN NOT NULL
);

/*Inserts en tabla CATEGORIES*/
INSERT INTO categories (name)
SELECT * FROM (SELECT 'Electrónica') AS tmp
WHERE NOT EXISTS (
    SELECT name FROM categories WHERE name = 'Electrónica'
) LIMIT 1;

INSERT INTO categories (name)
SELECT * FROM (SELECT 'Ropa') AS tmp
WHERE NOT EXISTS (
    SELECT name FROM categories WHERE name = 'Ropa'
) LIMIT 1;

INSERT INTO categories (name)
SELECT * FROM (SELECT 'Hogar') AS tmp
WHERE NOT EXISTS (
    SELECT name FROM categories WHERE name = 'Hogar'
) LIMIT 1;

/* Inserts en tabla PRODUCTS */
INSERT INTO products (name, description, idcategory, stock, price, imgproduct)
SELECT * FROM (SELECT 'Televisor', 'Televisor LED de 42 pulgadas', 1, TRUE, 200, 'images/img-tv.jpeg') AS tmp
WHERE NOT EXISTS (
    SELECT name FROM products WHERE name = 'Televisor'
) LIMIT 1;

INSERT INTO products (name, description, idcategory, stock, price, imgproduct)
SELECT * FROM (SELECT 'Camiseta', 'Camiseta de algodón 100%', 2, TRUE, 30.00, 'images/camiseta.jpeg') AS tmp
WHERE NOT EXISTS (
    SELECT name FROM products WHERE name = 'Camiseta'
) LIMIT 1;

INSERT INTO products (name, description, idcategory, stock, price, imgproduct)
SELECT * FROM (SELECT 'Sofá', 'Sofá de 3 plazas color gris', 3, TRUE, 500.10, 'images/sofa.jpeg') AS tmp
WHERE NOT EXISTS (
    SELECT name FROM products WHERE name = 'Sofá'
) LIMIT 1;

INSERT INTO products (name, description, idcategory, stock, price, imgproduct)
SELECT * FROM (SELECT 'Auriculares', 'Auriculares con cancelación de ruido', 1, TRUE, 1500, 'images/auriculares.jpeg') AS tmp
WHERE NOT EXISTS (
    SELECT name FROM products WHERE name = 'Auriculares'
) LIMIT 1;

/* Inserts en tabla USERS */
INSERT INTO users (name, surname, email, pass, admin)
SELECT * FROM (SELECT 'Admin', 'User', 'admin@admin.com', '$2y$10$xHn/k/qTE8tGr1iSSe3X0OOUbkSnYGTLp7BAuIKFUAb9teWs/Ybxi', TRUE) AS tmp
WHERE NOT EXISTS (
    SELECT email FROM users WHERE email = 'admin@admin.com'
) LIMIT 1;

INSERT INTO users (name, surname, email, pass, admin)
SELECT * FROM (SELECT 'Usuario', 'Comun', 'user@user.com', '$2y$10$hP1MFvzm7SpV6CbZX7GQDekSTWD0GyVtR0eN2icxbLHNM.QfQ0U4a', FALSE) AS tmp
WHERE NOT EXISTS (
    SELECT email FROM users WHERE email = 'user@user.com'
) LIMIT 1;