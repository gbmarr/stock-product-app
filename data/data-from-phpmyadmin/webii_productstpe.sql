-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-11-2024 a las 18:13:06
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
  `name` varchar(50) NOT NULL,
  `catimage` varchar(350) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`idcat`, `name`, `catimage`) VALUES
(1, 'Sin categoría asignada', 'images/imagenPorDefault.jpg'),
(2, 'Electrónica', 'images/imagenPorDefault.jpg'),
(3, 'Ropa', 'images/imagenPorDefault.jpg'),
(4, 'Hogar', 'images/imagenPorDefault.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `idproduct` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(200) NOT NULL,
  `idcategory` int(11) DEFAULT NULL,
  `stock` tinyint(1) NOT NULL,
  `price` float NOT NULL,
  `imgproduct` varchar(350) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`idproduct`, `name`, `description`, `idcategory`, `stock`, `price`, `imgproduct`) VALUES
(1, 'Televisor', 'Televisor LED de 42 pulgadas', 2, 1, 200, 'images/img-tv.jpeg'),
(2, 'Camiseta', 'Camiseta de algodón 100%', 3, 1, 30, 'images/camiseta.jpeg'),
(3, 'Sofá', 'Sofá de 3 plazas color gris', 4, 1, 500.1, 'images/sofa.jpeg'),
(4, 'Auriculares', 'Auriculares con cancelación de ruido', 2, 1, 1500, 'images/auriculares.jpeg');

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
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`iduser`, `name`, `surname`, `email`, `pass`, `admin`) VALUES
(1, 'Admin', 'User', 'admin@admin.com', '$2y$10$xHn/k/qTE8tGr1iSSe3X0OOUbkSnYGTLp7BAuIKFUAb9teWs/Ybxi', 1),
(2, 'UserComun', 'Apellido', 'user@comun.com', '$2y$10$hP1MFvzm7SpV6CbZX7GQDekSTWD0GyVtR0eN2icxbLHNM.QfQ0U4a', 0);

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
  MODIFY `idcat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `idproduct` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
