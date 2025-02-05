-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-02-2025 a las 14:04:27
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `webii_productstpe`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `idcat` int(11) NOT NULL,
  `catname` varchar(50) NOT NULL,
  `catimage` varchar(350) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`idcat`, `catname`, `catimage`) VALUES
(1, 'Sin categoría asignada', 'images/imagenPorDefault.jpg'),
(2, 'Electrónica', 'images/electronica.jpg'),
(3, 'Hogar', 'images/hogar.jpg'),
(4, 'Ropa', 'images/ropa.jpg'),
(5, 'Deportes', 'images/deportes.jpg'),
(6, 'Juguetes', 'images/juguetes.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `idproduct` int(11) NOT NULL,
  `prodname` varchar(50) NOT NULL,
  `description` varchar(200) NOT NULL,
  `idcategory` int(11) DEFAULT NULL,
  `stock` tinyint(1) NOT NULL,
  `price` float NOT NULL,
  `imgproduct` varchar(350) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`idproduct`, `prodname`, `description`, `idcategory`, `stock`, `price`, `imgproduct`) VALUES
(1, 'Televisor', 'SmartTV de 42 pulgadas con pantalla curva...', 1, 1, 200, 'images/television.jpeg'),
(2, 'Laptop', 'Laptop con procesador Intel i7 y 16GB RAM', 1, 1, 800, 'images/notebook.jpeg'),
(3, 'Licuadora', 'Licuadora de 600W con 3 velocidades', 2, 1, 50, 'images/licuadora.jpg'),
(4, 'Sofá', 'Sofá de tres plazas con tapizado de cuero sintético', 2, 1, 350, 'images/sofa.jpeg'),
(5, 'Camiseta deportiva', 'Camiseta de poliéster transpirable para entrenamientos', 3, 1, 25, 'images/camiseta.jpeg'),
(6, 'Zapatillas running', 'Zapatillas con tecnología de amortiguación avanzada', 4, 1, 100, 'images/zapatillas.jpeg'),
(7, 'Pelota de fútbol', 'Balón oficial tamaño 5 de cuero sintético', 4, 1, 30, 'images/pelota.jpg'),
(8, 'Muñeca interactiva', 'Muñeca que habla y canta, ideal para niños de 3 a 6 años', 5, 1, 40, 'images/muneca.jpg'),
(9, 'Auto de juguete', 'Auto a control remoto con luces LED', 5, 1, 60, 'images/auto_juguete.jpg'),
(10, 'Abrigo de invierno', 'Chaqueta térmica impermeable con forro polar', 3, 1, 90, 'images/abrigo.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `iduser` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pass` varchar(150) NOT NULL,
  `token` varchar(150) NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`iduser`, `name`, `surname`, `email`, `pass`, `token`, `admin`) VALUES
(1, 'Admin', 'User', 'webadmin@admin.com', '$2y$10$11WnltIgF5IzvPCUCH6N7uuxWJyG14M4wRgS9ji6llO04Ln20aLGK', '646fc0d751c58050fb1d81ee8f455420', 1),
(2, 'UserComun', 'Apellido', 'user@comun.com', '$2y$10$hP1MFvzm7SpV6CbZX7GQDekSTWD0GyVtR0eN2icxbLHNM.QfQ0U4a', '80da7e7ce496db405ee6b67d87bf648d', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`idcat`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`idproduct`),
  ADD KEY `idcategory` (`idcategory`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`iduser`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `idcat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `idproduct` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`idcategory`) REFERENCES `categories` (`idcat`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
