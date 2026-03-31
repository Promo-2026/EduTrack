-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-03-2026 a las 02:29:36
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
-- Base de datos: `escuela`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

CREATE TABLE `estudiantes` (
  `dni` varchar(20) NOT NULL,
  `Nombre` varchar(30) NOT NULL,
  `Apellido` varchar(30) NOT NULL,
  `Edad` int(4) NOT NULL,
  `Grado` varchar(15) NOT NULL,
  `calificacion` int(2) NOT NULL DEFAULT 0,
  `estado` varchar(20) NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estudiantes`
--

INSERT INTO `estudiantes` (`dni`, `Nombre`, `Apellido`, `Edad`, `Grado`, `calificacion`, `estado`, `foto`) VALUES
('23423523456', 'Alan', 'Pérsico', 16, 'Sexto', 10, 'Aprobado', 'img/Alan_P__rsico_12212313.png'),
('33333333', 'juan', 'reichert', 38, 'Séptimo', 1, 'Reprobado', 'img/juan_reichert_33333333.png'),
('3563463', 'Mariliz', 'Almaraz', 18, 'Sexto', 10, 'Aprobado', 'img/Mariliz_Almaraz_871234.png'),
('457473', 'Belén', 'Tamburrino', 17, 'Sexto', 10, 'Aprobado', 'img/Belen_Tamburrino_47950900.png');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`dni`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
