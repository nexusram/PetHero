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
  `id` int(100) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `state` int(1) NOT NULL,
  `validate` int(100) NOT NULL,
  `id_owner` int(100) NOT NULL,
  `id_keeper` int(100) NOT NULL,
  `id_pet` int(100) NOT NULL,
  `total` int NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `breed`
--

CREATE TABLE `breed` (
  `id` int(100) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(200) NOT NULL,
  `id_petType` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `day`
--

CREATE TABLE `day` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_keeper` int(11) NOT NULL,
  `date` date NOT NULL,
  `isAvailable` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `keeper`
--

CREATE TABLE `keeper` (
  `id` int(100) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_user` int(100) NOT NULL,
  `id_petSize` int(100) NOT NULL,
  `remuneration` int(200) NOT NULL,
  `description` varchar(300) NOT NULL,
  `score` varchar(300) NOT NULL,
  `active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pet`
--

CREATE TABLE `pet` (
  `id` int(100) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_user` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `id_petType` int(100) NOT NULL,
  `id_breed` int(100) NOT NULL,
  `id_petSize` int(100) NOT NULL,
  `observation` varchar(200) NOT NULL,
  `picture` varchar(200) NOT NULL,
  `vacunationPlan` varchar(200) NOT NULL,
  `video` varchar(200),
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `petsize`
--

CREATE TABLE `petSize` (
  `id` int(100) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pettype`
--

CREATE TABLE `petType` (
  `id` int(100) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(50) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `userType` int(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `birthDay` date NOT NULL,
  `cellphone` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `userName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `coupon` (
  `id` int(50) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_booking` int(50) NOT NULL,
  `method` varchar(50) NOT NULL,
  `isPayment` tinyint(1) NOT NULL,
  `discount` double DEFAULT 0,
  `total` double DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT booking_user_fk FOREIGN KEY(`id_owner`) REFERENCES `user`(`id`),
  ADD CONSTRAINT booking_keeper_fk FOREIGN KEY(`id_keeper`) REFERENCES `keeper`(`id`),
  ADD CONSTRAINT booking_pet_fk FOREIGN KEY(`id_pet`) REFERENCES `pet`(`id`);
--
-- Indices de la tabla `breed`
--
ALTER TABLE `breed`
  ADD CONSTRAINT breed_petType_fk FOREIGN KEY(`id_petType`) REFERENCES `petType`(`id`);

--
-- Indices de la tabla `day`
--
ALTER TABLE `day`
  ADD CONSTRAINT day_keeper_fk FOREIGN KEY(`id_keeper`) REFERENCES `keeper`(`id`);
--
-- Indices de la tabla `keeper`
--
ALTER TABLE `keeper`
  ADD CONSTRAINT keeper_user_fk FOREIGN KEY(`id_user`) REFERENCES `user`(`id`),
  ADD CONSTRAINT keeper_petSize_fk FOREIGN KEY(`id_petSize`) REFERENCES `petSize`(`id`);
--
-- Indices de la tabla `pet`
--
ALTER TABLE `pet`
  ADD CONSTRAINT pet_user_fk FOREIGN KEY(`id_user`) REFERENCES `user`(`id`),
  ADD CONSTRAINT pet_breed_fk FOREIGN KEY(`id_breed`) REFERENCES `breed`(`id`),
  ADD CONSTRAINT pet_petType_fk FOREIGN KEY(`id_petType`) REFERENCES `petType`(`id`),
  ADD CONSTRAINT pet_petSize_fk FOREIGN KEY(`id_petSize`) REFERENCES `petSize`(`id`);

ALTER TABLE `user`
  ADD CONSTRAINT user_userName_uk UNIQUE KEY(`userName`),
  ADD CONSTRAINT user_email_uk UNIQUE KEY(`email`);

--
-- INSERT TO
--

INSERT INTO `petType` (`name`) VALUES
('Dog'),
('Cat'),
('Guinea pig'),
('Piton');

INSERT INTO `breed` (`name`, `id_petType`) VALUES
('None', 1),
('Colli', 1),
('Caniche', 1),
('Grand Danes', 1),
('Bull Dog France', 1),
('Pitbull', 1),
('Dogo Argentino', 1),
('Border Colli', 1),
('Doberman', 1),
('Chiguagua', 1),
('Salchicha', 1),
('Golden Retriever', 1),
('German shepherd', 1),
('Terrier', 1),
('Galgo', 1),
('Coker', 1),
('Beagle', 1),
('Boxer', 1),
('Yorkshire terrier', 1),
('Abisinio', 2),
('Siames', 2),
('Persa', 2),
('Kohana', 2),
('British shorthair', 2),
('Elfo', 2),
('Van turco', 2),
('Habana', 2),
('Ashera', 2),
('Khao manee', 2),
('Montes', 2),
('Javanes', 2),
('Sokoke', 2),
('Teddy', 3),
('American', 3),
('American satin', 3),
('Texel', 3),
('White crested', 3),
('Abyssinian', 3),
('Abyssinian satin', 3),
('Coronet', 3),
('Peruvian', 3),
('Peruvian Satin',3 ),
('Antaresia', 4),
('Aspidites', 4),
('Bothrochilus', 4),
('Liasis', 4),
('Malayopython', 4);

INSERT INTO `petSize` (`name`) VALUES
('Small'),
('Medium'),
('Largue');

INSERT INTO `user` (`userType`, `name`, `surname`, `password`, `email`, `birthDay`, `cellphone`, `address`, `userName`) VALUES
(1, 'Nahuel', 'Suarez', 'nahu123', 'nahuelsuarez97@hotmail.com', '1997-12-01', '549223595', 'Avenida Jacinto Peralta Ramos', 'Nahu'),
(1, 'Axel', 'Caceres', 'axel123', 'axelcaceres36@gmail.com', '2001-03-24', '2236976480', 'Avenida Colon 7520', 'Axel'),
(1, 'Mauro', 'Triaca', 'mauro123', 'maurotriaca@gmail.com', '1999-05-12', '2235556667', '3 de febrero 2550', 'Mauro');



INSERT INTO `keeper` (`id_user`, `id_petSize`, `remuneration`, `description`, `score`, `active`) VALUES
(1, 1, 2000, 'Trusted person. I have experience in the field. At the moment I only take care of small dogs. Check in time 11 a.m. Departure time 16 p.m', 0, 0),
(2, 2, 5000, 'I have experience in the field. I like big dogs. I give special care, VIP category. Check in time 9 a.m. Departure time 19 p.m', 0, 1),
(3, 3, 4500, 'I just started in the field. I love pets of all sizes and types, but right now I only care for the big ones. Check in time 7 a.m. Departure time 17 p.m', 0 , 1);

--
-- SP PET
--

DELIMITER $$

DROP PROCEDURE IF EXISTS `sp_filter_keeper` $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_filter_keeper` (in `petsize` int, in `startDate` date, in `endDate` date, in `id_user` int)
begin 
    SELECT k.id, k.id_user, k.id_petSize, k.remuneration, k.description, k.score, k.active, count(d.date) as 'quantity'
    FROM `keeper` k
    JOIN `day` d on k.id = d.id_keeper
    WHERE k.id_petSize = `petsize`
    AND d.isAvailable = true
    AND d.date between `startDate` and `endDate`
    AND k.id_user <> `id_user`
    group by k.id;
end $$