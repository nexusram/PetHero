-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-11-2022 a las 14:58:57
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pet`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `booking`
--

CREATE TABLE `booking` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `state` tinyint(1) NOT NULL,
  `validate` int(100) NOT NULL,
  `total` float NOT NULL,
  `id_owner` int(100) NOT NULL,
  `id_keeper` int(100) NOT NULL,
  `id_pet` int(100) NOT NULL,
  `id_coupon` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `breed`
--

CREATE TABLE `breed` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `id_petType` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `day`
--

CREATE TABLE `day` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_keeper` int(11) NOT NULL,
  `date` date NOT NULL,
  `isAvailable` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `keeper`
--

CREATE TABLE `keeper` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `user` int(100) NOT NULL,
  `petSize` int(100) NOT NULL,
  `remuneration` int(200) NOT NULL,
  `description` varchar(300) NOT NULL,
  `score` varchar(300) NOT NULL,
  `active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `keeper`
--

INSERT INTO `keeper` (`id`, `user`, `petSize`, `remuneration`, `description`, `score`, `active`) VALUES
(0, 1, 1, 20, 'bb', '0', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pet`
--

CREATE TABLE `pet` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `user` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `petType` int(100) NOT NULL,
  `breed` int(100) NOT NULL,
  `petSize` int(100) NOT NULL,
  `observation` varchar(200) NOT NULL,
  `picture` varchar(200) NOT NULL,
  `vacunationPlan` varchar(200) NOT NULL,
  `video` varchar(200) NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `petsize`
--

CREATE TABLE `petsize` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `petsize`
--

INSERT INTO `petsize` (`id`, `name`) VALUES
(1, 'large');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pettype`
--

CREATE TABLE `pettype` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pettype`
--

INSERT INTO `pettype` (`id`, `name`) VALUES
(1, 'dog');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `userType` int(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `birthDay` date NOT NULL,
  `cellphone` int(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `userName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `userType`, `name`, `surname`, `password`, `email`, `birthDay`, `cellphone`, `address`, `userName`) VALUES
(1, 3, 'nahu', 'nahu', 'gta', 'nahu@hotmail.com', '1997-12-12', 549223595, 'jacinto', 'nahu');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `coupon` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `id_booking` int(50) NOT NULL,
  `method` varchar(50) NOT NULL,
  `isPayment` tinyint(1) NOT NULL,
  `discount` double(50) DEFAULT 0,
  `total` double(50) DEFAULT 0
)


--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`),
  ADD CONSTRAINT FOREIGN KEY(`id_owner`) REFERENCES `user`(`id`),
  ADD CONSTRAINT FOREIGN KEY(`id_keeper`) REFERENCES `keeper`(`id`),
  ADD CONSTRAINT FOREIGN KEY(`id_pet`) REFERENCES `pet`(`id`),
  ADD CONSTRAINT FOREIGN KEY(`id_coupon`) REFERENCES `coupon`(`id`);
--
-- Indices de la tabla `breed`
--
ALTER TABLE `breed`
  ADD PRIMARY KEY (`id`),
  ADD CONSTRAINT FOREIGN KEY(`id_petType`) REFERENCES `petType`(`id`);

--
-- Indices de la tabla `day`
--
ALTER TABLE `day`
  ADD PRIMARY KEY (`id`);
  ADD CONSTRAINT FOREIGN KEY(`id_keeper`) REFERENCES `keeper`(`id`);
--
-- Indices de la tabla `keeper`
--
ALTER TABLE `keeper`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pet`
--
ALTER TABLE `pet`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `petsize`
--
ALTER TABLE `petsize`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pettype`
--
ALTER TABLE `pettype`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
