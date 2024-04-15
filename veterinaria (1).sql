-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-04-2024 a las 06:02:15
-- Versión del servidor: 10.4.17-MariaDB
-- Versión de PHP: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `veterinaria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dueno`
--

CREATE TABLE `dueno` (
  `id_dueno` int(20) NOT NULL,
  `nombre_completo` varchar(30) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `fecha_nac` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `dueno`
--

INSERT INTO `dueno` (`id_dueno`, `nombre_completo`, `direccion`, `fecha_nac`) VALUES
(1, 'Kazumi Acosta Adan', 'Av. Adolfo Lopez Mateos', '2001-01-20'),
(2, 'Luis Angel Meza Adan', 'Av. Adolfo Lopez Mateos', '2000-11-08'),
(3, 'Adrián Sandoval', 'Cuernavaca', '2024-03-20'),
(4, 'Camille Armida Acosta ', 'Av. Adolfo Lopez Mateos', '2024-04-12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mascota`
--

CREATE TABLE `mascota` (
  `id_mascota` int(20) NOT NULL,
  `id_dueno` int(20) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `mascota`
--

INSERT INTO `mascota` (`id_mascota`, `id_dueno`, `nombre`, `descripcion`) VALUES
(1, 1, 'Neko', 'Gato blanco con problemas de obesidad'),
(2, 3, 'Solovino', 'Bonito y café'),
(3, 2, 'Doki', 'Perro labrador cruzado'),
(4, 3, 'Mailo', 'Gato negro flojo'),
(5, 4, 'Midnight', 'Gato negro hiperactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medico`
--

CREATE TABLE `medico` (
  `id_medico` int(20) NOT NULL,
  `nombre_completo` varchar(50) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `edad` int(10) NOT NULL,
  `estatus` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `medico`
--

INSERT INTO `medico` (`id_medico`, `nombre_completo`, `direccion`, `edad`, `estatus`) VALUES
(1, 'Jose Israel Estrada Perdomo', 'Francisco I. Madero 4, Zacatepec, Morelos.', 34, 'Activo'),
(2, 'Neftalí Carreto', 'Puente de Ixtla', 23, 'Activo'),
(3, 'Claire Szarr', 'Faerun 24', 28, 'Estilista'),
(4, 'Astarion Szarr', 'Faerun 24', 38, 'Estilista');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `receta`
--

CREATE TABLE `receta` (
  `id_receta` int(11) NOT NULL,
  `id_visita` int(11) NOT NULL,
  `id_mascota` int(11) NOT NULL,
  `desc_receta` varchar(50) NOT NULL,
  `archivo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visita`
--

CREATE TABLE `visita` (
  `id_visita` int(20) NOT NULL,
  `id_mascota` int(20) NOT NULL,
  `id_medico` int(20) NOT NULL,
  `fecha_visita` date NOT NULL,
  `tipo_servicio` varchar(50) NOT NULL,
  `descripcion_servicio` varchar(50) NOT NULL,
  `archivo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `visita`
--

INSERT INTO `visita` (`id_visita`, `id_mascota`, `id_medico`, `fecha_visita`, `tipo_servicio`, `descripcion_servicio`, `archivo`) VALUES
(15, 5, 3, '2024-04-08', 'Estético', 'Acicalamiento', '/uploads/visita_15.pdf'),
(21, 4, 2, '2024-04-03', 'Nutricion', 'Dieta', '/uploads/visita_21.pdf'),
(22, 3, 4, '2024-04-04', 'Estético', 'Corte de uñas', ''),
(23, 2, 2, '2024-04-05', 'Revisión', 'Información de cómo cuidar a un gato', '/uploads/visita_23.pdf');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `dueno`
--
ALTER TABLE `dueno`
  ADD PRIMARY KEY (`id_dueno`),
  ADD KEY `nombre_completo` (`nombre_completo`);

--
-- Indices de la tabla `mascota`
--
ALTER TABLE `mascota`
  ADD PRIMARY KEY (`id_mascota`),
  ADD KEY `id_dueno` (`id_dueno`);

--
-- Indices de la tabla `medico`
--
ALTER TABLE `medico`
  ADD PRIMARY KEY (`id_medico`);

--
-- Indices de la tabla `receta`
--
ALTER TABLE `receta`
  ADD PRIMARY KEY (`id_receta`),
  ADD KEY `id_visita` (`id_visita`),
  ADD KEY `id_mascota` (`id_mascota`);

--
-- Indices de la tabla `visita`
--
ALTER TABLE `visita`
  ADD PRIMARY KEY (`id_visita`),
  ADD KEY `id_mascota` (`id_mascota`),
  ADD KEY `id_medico` (`id_medico`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `dueno`
--
ALTER TABLE `dueno`
  MODIFY `id_dueno` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `mascota`
--
ALTER TABLE `mascota`
  MODIFY `id_mascota` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `medico`
--
ALTER TABLE `medico`
  MODIFY `id_medico` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `receta`
--
ALTER TABLE `receta`
  MODIFY `id_receta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `visita`
--
ALTER TABLE `visita`
  MODIFY `id_visita` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `mascota`
--
ALTER TABLE `mascota`
  ADD CONSTRAINT `mascota_ibfk_1` FOREIGN KEY (`id_dueno`) REFERENCES `dueno` (`id_dueno`);

--
-- Filtros para la tabla `receta`
--
ALTER TABLE `receta`
  ADD CONSTRAINT `receta_ibfk_1` FOREIGN KEY (`id_visita`) REFERENCES `visita` (`id_visita`),
  ADD CONSTRAINT `receta_ibfk_2` FOREIGN KEY (`id_mascota`) REFERENCES `mascota` (`id_mascota`);

--
-- Filtros para la tabla `visita`
--
ALTER TABLE `visita`
  ADD CONSTRAINT `visita_ibfk_1` FOREIGN KEY (`id_medico`) REFERENCES `medico` (`id_medico`),
  ADD CONSTRAINT `visita_ibfk_2` FOREIGN KEY (`id_mascota`) REFERENCES `mascota` (`id_mascota`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
