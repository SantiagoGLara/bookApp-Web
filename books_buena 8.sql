-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 02-06-2025 a las 14:28:06
-- Versión del servidor: 9.1.0
-- Versión de PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `books`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autor`
--

DROP TABLE IF EXISTS `autor`;
CREATE TABLE IF NOT EXISTS `autor` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nacionalidad` int DEFAULT NULL,
  `comentarios` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estado` enum('alto','bajo') COLLATE utf8mb4_general_ci DEFAULT 'alto',
  PRIMARY KEY (`id`),
  KEY `nacionalidad` (`nacionalidad`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `autor`
--

INSERT INTO `autor` (`id`, `nombre`, `nacionalidad`, `comentarios`, `estado`) VALUES
(1, 'Mario Benedetti', 3, '1920-2009, es uno de los escritores más importantes de la literatura uruguaya. Con su novela La Tregua obtuvo reconocimiento internacional. Escribió más de 80 libros de poesía, novelas, cuentos y ensayos. ', 'alto'),
(2, 'Gabriel García Márquez', 4, 'Nació en 1927 en  Aracataca Colombia, donde lo criaron sus abuelos. En 1947 se matriculó en la Facultad de Derecho de la Universidad Nacional de Bogotá y en ese mismo año se publicó en el diario El Espectador su cuento \"La tercera resignación\". ', 'alto'),
(3, 'Juan Rulfo', 1, 'Considerado uno de los escritores hispanoamericanos más importantes del siglo XX. La obra de Juan Rulfo, integrada por la colección de cuentos El Llano en llamas y las novelas Pedro Páramo y El gallo de oro, lo han situado como uno de los escritores más importantes de su siglo.', 'alto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `book`
--

DROP TABLE IF EXISTS `book`;
CREATE TABLE IF NOT EXISTS `book` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tipo` int NOT NULL DEFAULT '0',
  `paginas` smallint DEFAULT '0',
  `editorial` int NOT NULL,
  `isbn` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pais` int NOT NULL DEFAULT '1',
  `dimensiones` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `idioma` int NOT NULL DEFAULT '1',
  `imagen_portada` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `imagen_contraportada` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sobrecubierta` int NOT NULL DEFAULT '0',
  `pasta_dura` int NOT NULL DEFAULT '0',
  `resumen` varchar(500) COLLATE utf8mb4_general_ci NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `precio` decimal(10,0) NOT NULL DEFAULT '0',
  `autor` int NOT NULL DEFAULT '1',
  `estado` enum('alto','bajo') COLLATE utf8mb4_general_ci DEFAULT 'alto',
  PRIMARY KEY (`id`),
  KEY `tipo` (`tipo`),
  KEY `editorial` (`editorial`),
  KEY `pais` (`pais`),
  KEY `idioma` (`idioma`),
  KEY `autor` (`autor`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `book`
--

INSERT INTO `book` (`id`, `titulo`, `tipo`, `paginas`, `editorial`, `isbn`, `pais`, `dimensiones`, `idioma`, `imagen_portada`, `imagen_contraportada`, `sobrecubierta`, `pasta_dura`, `resumen`, `stock`, `precio`, `autor`, `estado`) VALUES
(1, 'Cien años de soledad', 1, 464, 5, '9786070728792', 1, '1', 1, '', '', 0, 0, 'Muchos años después, frente al pelotón de fusilamiento, el coronel Aureliano Buendía había de recordar aquella tarde remota en que su padre lo llevó a conocer el hielo. Macondo era entonces una aldea de veinte casas de barro y cañabrava construidas a la orilla de un río de aguas diáfanas que se precipitaban por un lecho de piedras pulidas, blancas y enormes como huevos prehistóricos.', 170, 478, 1, 'alto'),
(2, 'La tregua', 1, 208, 6, '9786073133531', 1, '1', 1, '', '', 0, 0, '\"La Tregua\", una novela emblemática escrita por Mario Benedetti. Ambientada en Montevideo durante la década de 1950, sigue la vida de Martín Satomé, un hombre solitario y rutinario. A medida que se acerca su jubilación, Martín experimenta un despertar emocional al enamorarse de una joven compañera de trabajo. A través de esta inesperada relación, se enfrenta a sus temores y reflexiona sobre el sentido de la vida.', 177, 251, 1, 'alto'),
(3, 'Pedro Paramo', 1, 136, 7, '9788493442606', 1, '1', 1, '', '', 0, 0, 'En dos cartas dirigidas en 1947 a su amada Clara Aparicio, Rulfo nombra su primera novela: \"Una estrella junto a la luna\", luego cambia a \"Los murmullos\". Entre 1953 y 1954, gracias a una beca, puede escribirla.', 159, 144, 1, 'alto'),
(4, 'La supraconciencia existe, Vida después de la vida', 4, 245, 2, '9786073923156', 2, '1', 1, '', '', 0, 0, 'El libro definitivo sobre el fenómeno de ls Experiencias Cercanas a la Muerte y su poder para transformar nuestras vidas', 167, 230, 1, 'alto'),
(5, 'La supraconciencia existe, Vida después de la vida', 4, 245, 2, '9786073923156', 2, '1', 1, 'imagen.img', '', 0, 0, 'El libro definitivo sobre el fenómeno de ls Experiencias Cercanas a la Muerte y su poder para transformar nuestras vidas', 155, 230, 1, 'alto'),
(6, 'Fundamentos de Programación', 1, 300, 1, '1234567891234', 1, '21 x 29.7', 1, NULL, NULL, 1, 1, 'computo', 177, 332, 1, 'alto'),
(7, 'Fundamentos de Programación', 1, 300, 1, '1234567891234', 1, '21 x 29.7', 1, NULL, NULL, 0, 1, 'computo', 116, 143, 1, 'alto'),
(8, 'Fundamentos de Programación', 1, 300, 1, '1234567891234', 1, '21 x 29.7', 1, NULL, NULL, 1, 1, 'computo', 100, 121, 1, 'alto'),
(9, 'Fundamentos de Programación', 1, 300, 1, '1234567891234', 1, '21 x 29.7', 1, NULL, NULL, 1, 1, 'computo', 100, 325, 1, 'alto'),
(10, 'Fundamentos de Programación', 1, 300, 1, '1234567891234', 1, '21 x 29.7', 1, NULL, NULL, 1, 1, 'computo', 149, 161, 1, 'alto'),
(11, 'Fundamentos de Programación', 1, 300, 1, '1234567891234', 1, '21 x 29.7', 1, NULL, NULL, 1, 1, 'computo', 176, 231, 1, 'alto'),
(12, 'Fundamentos de Programación', 1, 300, 1, '1234567891234', 1, '21 x 29.7', 1, NULL, NULL, 1, 1, 'computo', 131, 322, 1, 'alto'),
(13, 'Fundamentos de Programación', 1, 300, 1, '1234567891234', 1, '21 x 29.7', 1, NULL, NULL, 1, 1, 'computo', 128, 319, 1, 'alto'),
(14, 'Fundamentos de Programación', 1, 300, 1, '1234567891234', 1, '21 x 29.7', 1, NULL, NULL, 1, 1, 'computo', 140, 279, 1, 'alto'),
(15, 'Fundamentos de Programación', 1, 300, 1, '1234567891234', 1, '21 x 29.7', 1, NULL, NULL, 1, 1, 'computo', 159, 339, 1, 'alto'),
(16, 'Fundamentos de Programación', 1, 300, 1, '1234567891234', 1, '21 x 29.7', 1, NULL, NULL, 1, 1, 'computo', 140, 256, 1, 'alto'),
(17, 'Fundamentos de Programación', 1, 300, 1, '1234567891234', 1, '21 x 29.7', 1, NULL, NULL, 1, 1, 'computo', 166, 165, 1, 'alto'),
(18, 'Fundamentos de Programación', 1, 300, 1, '1234567891234', 1, '21 x 29.7', 1, NULL, NULL, 1, 1, 'computo', 183, 207, 1, 'alto'),
(19, 'Fundamentos de Programación 2', 1, 300, 1, '1234567891235', 1, '1', 1, '19.png', '19.png', 1, 1, 'computo', 118, 192, 1, 'alto'),
(20, 'La alegría del padre', 1, 200, 1, '1234567891234', 1, '21 x 29.7', 1, '20.png', '20.png', 1, 1, 'gran libro', 140, 238, 1, 'alto'),
(21, 'Caperucita roja', 1, 10, 2, '9786073833851', 1, '1', 1, '21.png', '21.png', 1, 1, '', 200, 264, 1, 'alto'),
(22, 'Caperucita roja', 1, 10, 1, '9786073833851', 1, '1', 1, '22.png', '22.png', 1, 1, '', 200, 256, 1, 'alto'),
(23, 'Libro de prueba', 2, 10, 3, '9786073833851', 2, '1', 2, '23.jpg', '23.jpg', 1, 0, 'vamos a ver qué pasa', 0, 150, 2, 'bajo'),
(24, 'prueba 2', 1, 10, 1, '9786073833851', 1, '1', 1, NULL, NULL, 1, 0, '', 0, 0, 1, 'bajo'),
(25, 'prueba libro 2', 1, 10, 1, '9786073833851', 1, '1', 1, NULL, NULL, 1, 0, '', 0, 0, 1, 'bajo'),
(26, 'prueba libro 3', 1, 10, 1, '9786073833851', 1, '1', 1, NULL, NULL, 1, 0, '', 0, 0, 1, 'bajo'),
(27, 'prueba libro 2', 1, 10, 1, '9786073833851', 1, '1', 1, NULL, NULL, 1, 0, '', 0, 0, 1, 'bajo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `edad` int DEFAULT NULL,
  `numcelular` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fecha_alta` date NOT NULL,
  `estado` enum('alto','bajo') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'alto',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `edad`, `numcelular`, `email`, `fecha_alta`, `estado`) VALUES
(1, 'Cliente 1', 20, '4433189203', 'cliente1@gmail.com', '2000-03-17', 'alto'),
(2, 'Felipe', 18, '4433761109', 'FeliponElChido@gmail.com', '2024-07-23', 'alto'),
(3, 'Gera', 21, '4412005372', 'gera@hotmail.com', '2025-05-29', 'alto'),
(4, 'Efrén', 21, '4433189204', 'Efren@hotmail.com', '2025-06-02', 'bajo'),
(5, 'Adrián Aguilar', 21, '4433761110', 'adrian@gmail.com', '2025-05-08', 'bajo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

DROP TABLE IF EXISTS `compras`;
CREATE TABLE IF NOT EXISTS `compras` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_proveedor` int NOT NULL,
  `id_usuario` int NOT NULL,
  `fecha_compra` datetime NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `id_metodo_pago` int DEFAULT NULL,
  `estado` enum('activo','cancelado') COLLATE utf8mb4_general_ci DEFAULT 'activo',
  `comentarios` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`),
  KEY `id_proveedor` (`id_proveedor`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_metodo_pago` (`id_metodo_pago`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `id_proveedor`, `id_usuario`, `fecha_compra`, `total`, `id_metodo_pago`, `estado`, `comentarios`) VALUES
(1, 1, 1, '2025-05-29 00:15:49', 300.00, 1, 'activo', 'Compra con 1 producto'),
(2, 1, 1, '2025-05-29 00:15:49', 681.00, 2, 'activo', 'Compra con 2 productos'),
(3, 1, 1, '2025-05-29 00:15:49', 1140.00, 3, 'activo', 'Compra con 3 productos'),
(4, 1, 1, '2025-06-01 21:39:26', 18480.00, 1, 'activo', 'Vamos a probar a ver si esto sí funciona '),
(5, 1, 1, '2025-06-01 21:40:01', 15600.00, 5, 'activo', 'a ver ahora con 2'),
(6, 1, 1, '2025-06-01 21:44:20', 26400.00, 6, 'cancelado', 'Vamos a hacer una de prueba a ver qué pasa'),
(7, 1, 1, '2025-06-02 06:36:45', 15000.00, 6, 'cancelado', 'vamos a comprar 100');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compras`
--

DROP TABLE IF EXISTS `detalle_compras`;
CREATE TABLE IF NOT EXISTS `detalle_compras` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_compra` int NOT NULL,
  `id_libro` int NOT NULL,
  `cantidad` int NOT NULL DEFAULT '1',
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `estado` enum('alto','bajo') COLLATE utf8mb4_general_ci DEFAULT 'alto',
  PRIMARY KEY (`id`),
  KEY `id_compra` (`id_compra`),
  KEY `id_libro` (`id_libro`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_compras`
--

INSERT INTO `detalle_compras` (`id`, `id_compra`, `id_libro`, `cantidad`, `precio_unitario`, `subtotal`, `estado`) VALUES
(1, 1, 6, 1, 300.00, 300.00, 'alto'),
(2, 2, 1, 1, 478.00, 478.00, 'alto'),
(3, 2, 2, 1, 203.00, 203.00, 'alto'),
(4, 3, 3, 1, 144.00, 144.00, 'alto'),
(5, 3, 4, 1, 230.00, 230.00, 'alto'),
(6, 3, 1, 1, 766.00, 766.00, 'alto'),
(7, 4, 21, 70, 264.00, 18480.00, 'alto'),
(8, 5, 21, 30, 264.00, 7920.00, 'alto'),
(9, 5, 22, 30, 256.00, 7680.00, 'alto'),
(10, 6, 21, 100, 264.00, 26400.00, 'bajo'),
(11, 7, 23, 100, 150.00, 15000.00, 'bajo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ventas`
--

DROP TABLE IF EXISTS `detalle_ventas`;
CREATE TABLE IF NOT EXISTS `detalle_ventas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_venta` int NOT NULL,
  `id_libro` int NOT NULL,
  `cantidad` int NOT NULL DEFAULT '1',
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `estado` enum('alto','bajo') COLLATE utf8mb4_general_ci DEFAULT 'alto',
  PRIMARY KEY (`id`),
  KEY `id_venta` (`id_venta`),
  KEY `id_libro` (`id_libro`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_ventas`
--

INSERT INTO `detalle_ventas` (`id`, `id_venta`, `id_libro`, `cantidad`, `precio_unitario`, `subtotal`, `estado`) VALUES
(1, 1, 1, 1, 478.00, 478.00, 'alto'),
(2, 2, 2, 1, 251.00, 251.00, 'alto'),
(3, 2, 3, 1, 478.00, 478.00, 'alto'),
(4, 3, 4, 1, 230.00, 230.00, 'alto'),
(5, 3, 5, 1, 230.00, 230.00, 'alto'),
(6, 3, 6, 1, 195.00, 195.00, 'alto'),
(7, 4, 21, 1, 264.00, 264.00, 'alto'),
(8, 5, 1, 5, 478.00, 2390.00, 'alto'),
(9, 5, 21, 19, 264.00, 5016.00, 'alto'),
(10, 5, 20, 3, 238.00, 714.00, 'alto'),
(11, 6, 14, 9, 279.00, 2511.00, 'alto'),
(12, 6, 16, 8, 256.00, 2048.00, 'alto'),
(13, 7, 21, 40, 264.00, 10560.00, 'alto'),
(14, 7, 9, 22, 325.00, 7150.00, 'alto'),
(15, 8, 22, 70, 256.00, 17920.00, 'bajo'),
(16, 9, 22, 1, 256.00, 256.00, 'bajo'),
(17, 10, 22, 10, 256.00, 2560.00, 'bajo'),
(18, 11, 22, 20, 256.00, 5120.00, 'bajo'),
(19, 12, 22, 70, 256.00, 17920.00, 'bajo'),
(20, 13, 21, 50, 264.00, 13200.00, 'bajo'),
(21, 13, 22, 120, 256.00, 30720.00, 'bajo'),
(22, 14, 22, 120, 256.00, 30720.00, 'bajo'),
(23, 14, 21, 50, 264.00, 13200.00, 'bajo'),
(24, 15, 8, 55, 121.00, 6655.00, 'alto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `editorial`
--

DROP TABLE IF EXISTS `editorial`;
CREATE TABLE IF NOT EXISTS `editorial` (
  `id` int NOT NULL AUTO_INCREMENT,
  `editorial` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `estado` enum('alto','bajo') COLLATE utf8mb4_general_ci DEFAULT 'alto',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `editorial`
--

INSERT INTO `editorial` (`id`, `editorial`, `estado`) VALUES
(1, 'Mc Graw Hill', 'alto'),
(2, 'Planeta', 'alto'),
(3, 'Alfaomega', 'alto'),
(4, 'Prentice Hall', 'alto'),
(5, 'Diana', 'alto'),
(6, 'Penguin Random House', 'alto'),
(7, 'rm', 'alto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lenguaje`
--

DROP TABLE IF EXISTS `lenguaje`;
CREATE TABLE IF NOT EXISTS `lenguaje` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lenguaje` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `estado` enum('alto','bajo') COLLATE utf8mb4_general_ci DEFAULT 'alto',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lenguaje`
--

INSERT INTO `lenguaje` (`id`, `lenguaje`, `estado`) VALUES
(1, 'Español', 'alto'),
(2, 'Inglés', 'alto'),
(3, 'Fancés', 'alto'),
(4, 'Alemán', 'alto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodos_pago`
--

DROP TABLE IF EXISTS `metodos_pago`;
CREATE TABLE IF NOT EXISTS `metodos_pago` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_general_ci,
  `estado` enum('alto','bajo') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'alto',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `metodos_pago`
--

INSERT INTO `metodos_pago` (`id`, `nombre`, `descripcion`, `estado`) VALUES
(1, 'Efectivo', 'Pago en moneda local', 'alto'),
(2, 'Transferencia', 'Transferencia bancaria', 'alto'),
(3, 'Cheque', 'Cheque nominativo', 'alto'),
(4, 'Crédito', 'Pago a crédito con plazo', 'alto'),
(5, 'Tarjeta Débito', 'Pago con tarjeta de débito', 'alto'),
(6, 'Tarjeta Crédito', 'Pago con tarjeta de crédito', 'alto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pais`
--

DROP TABLE IF EXISTS `pais`;
CREATE TABLE IF NOT EXISTS `pais` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `estado` enum('alto','bajo') COLLATE utf8mb4_general_ci DEFAULT 'alto',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pais`
--

INSERT INTO `pais` (`id`, `nombre`, `estado`) VALUES
(1, 'México', 'alto'),
(2, 'España', 'alto'),
(3, 'Uruguay', 'alto'),
(4, 'Colombia', 'alto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

DROP TABLE IF EXISTS `proveedores`;
CREATE TABLE IF NOT EXISTS `proveedores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `numcelular` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `fecha_alta` date NOT NULL,
  `estado` enum('alto','bajo') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'alto',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `nombre`, `numcelular`, `email`, `fecha_alta`, `estado`) VALUES
(1, 'Proveedor 1', '4438342038', 'proveedor_1@hotmail.com', '2025-05-28', 'alto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo`
--

DROP TABLE IF EXISTS `tipo`;
CREATE TABLE IF NOT EXISTS `tipo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tipo` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `estado` enum('alto','bajo') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'alto',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo`
--

INSERT INTO `tipo` (`id`, `tipo`, `estado`) VALUES
(1, 'Literatura', 'alto'),
(2, 'Ficción', 'alto'),
(3, 'Comedia', 'alto'),
(4, 'Científico', 'alto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `foto` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estado` enum('alto','bajo') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'alto',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `nombre`, `password`, `foto`, `estado`) VALUES
(1, 'antonio', 'antonio', '1234', NULL, 'alto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

DROP TABLE IF EXISTS `ventas`;
CREATE TABLE IF NOT EXISTS `ventas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_cliente` int NOT NULL,
  `id_usuario` int NOT NULL,
  `fecha_venta` datetime NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `id_metodo_pago` int DEFAULT NULL,
  `estado` enum('activo','cancelado') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'activo',
  `comentarios` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`),
  KEY `id_cliente` (`id_cliente`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_metodo_pago` (`id_metodo_pago`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `id_cliente`, `id_usuario`, `fecha_venta`, `total`, `id_metodo_pago`, `estado`, `comentarios`) VALUES
(1, 1, 1, '2025-05-29 00:15:32', 478.00, 1, 'activo', 'Venta con 1 producto'),
(2, 1, 1, '2025-05-29 00:15:32', 729.00, 2, 'activo', 'Venta con 2 productos'),
(3, 1, 1, '2025-05-29 00:15:32', 655.00, 3, 'activo', 'Venta con 3 productos'),
(4, 1, 1, '2025-05-29 11:31:24', 264.00, 5, 'activo', ''),
(5, 2, 1, '2025-05-29 11:36:05', 8120.00, 2, 'activo', 'Prueba 1'),
(6, 3, 1, '2025-05-29 14:36:10', 4559.00, 4, 'activo', 'Gera hizo sopa aguada'),
(7, 3, 1, '2025-05-29 15:26:13', 17710.00, 5, 'activo', ''),
(8, 3, 1, '2025-06-01 19:44:23', 17920.00, 3, 'cancelado', 'Prueba para probar las compras, está en 170 las compras, debería de quedar en 100. Si realizo una compra de 100, debería de aumentar a 200.\r\n\r\nGera, préstame una feria ocupo, porfa'),
(9, 3, 1, '2025-06-01 20:00:56', 256.00, 2, 'cancelado', 'Vamos a probar de nuez, voy a caperucita roja la de 170, a ver si sí jala.'),
(10, 2, 1, '2025-06-01 20:02:04', 2560.00, 6, 'cancelado', 'está raro esto '),
(11, 1, 1, '2025-06-01 20:05:10', 5120.00, 3, 'cancelado', 'Otra oportunidad'),
(12, 2, 1, '2025-06-01 20:06:41', 17920.00, 1, 'cancelado', ''),
(13, 1, 1, '2025-06-01 20:10:32', 43920.00, 3, 'cancelado', 'vamos a ver si ahora sí jala'),
(14, 1, 1, '2025-06-01 20:14:09', 43920.00, 4, 'cancelado', 'Otra oportunidad, otra oportunidad'),
(15, 1, 1, '2025-06-02 07:43:13', 6655.00, 4, 'activo', '');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `autor`
--
ALTER TABLE `autor`
  ADD CONSTRAINT `autor_ibfk_1` FOREIGN KEY (`nacionalidad`) REFERENCES `pais` (`id`);

--
-- Filtros para la tabla `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_1` FOREIGN KEY (`tipo`) REFERENCES `tipo` (`id`),
  ADD CONSTRAINT `book_ibfk_2` FOREIGN KEY (`editorial`) REFERENCES `editorial` (`id`),
  ADD CONSTRAINT `book_ibfk_3` FOREIGN KEY (`pais`) REFERENCES `pais` (`id`),
  ADD CONSTRAINT `book_ibfk_4` FOREIGN KEY (`idioma`) REFERENCES `lenguaje` (`id`),
  ADD CONSTRAINT `book_ibfk_5` FOREIGN KEY (`autor`) REFERENCES `autor` (`id`);

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id`),
  ADD CONSTRAINT `compras_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `compras_ibfk_3` FOREIGN KEY (`id_metodo_pago`) REFERENCES `metodos_pago` (`id`);

--
-- Filtros para la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD CONSTRAINT `detalle_compras_ibfk_1` FOREIGN KEY (`id_compra`) REFERENCES `compras` (`id`),
  ADD CONSTRAINT `detalle_compras_ibfk_2` FOREIGN KEY (`id_libro`) REFERENCES `book` (`id`);

--
-- Filtros para la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD CONSTRAINT `detalle_ventas_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id`),
  ADD CONSTRAINT `detalle_ventas_ibfk_2` FOREIGN KEY (`id_libro`) REFERENCES `book` (`id`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `ventas_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `ventas_ibfk_3` FOREIGN KEY (`id_metodo_pago`) REFERENCES `metodos_pago` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
