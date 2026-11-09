-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-11-2026 a las 18:04:53
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
-- Base de datos: `tuauto.com`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(10) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `email`, `telefono`, `pass`, `fecha_registro`, `admin`, `activo`) VALUES
(9, 'administrador', 'administrador@gmail.com', '1111111111', '$2y$10$O3T0r.hMIeO8GWVrLIVwJutAKmztSuGX9w0V.pcubBi9/L.5ic0VG', '2026-11-09 16:51:11', 1, 1),
(10, 'Ignacio Ezequiel Molina', 'ignacio.molina721@davinci.edu.ar', '1134327716', '$2y$10$sbbwHYYup7ix8hx8L3Zroe1IXaQ3Yv8e7vLqSFuKsOD2VVJ1bgwpK', '2026-11-09 16:52:14', 0, 1),
(11, 'Ignacio Molina', 'ignacio.molina002@gmail.com', '1134327716', '$2y$10$5VdOoXEHpOB.yTAQ.XMJVOivmYizYXcfV1o2LyuwG.KklwoNNzNEe', '2026-11-09 16:52:52', 0, 1),
(12, 'Gabriel Molina', 'drgabrielmolina@hotmail.com', '1123245896', '$2y$10$5FyK61RKiVkrwUPP6VLSIOzCeVY7PLHpyR0gdeO48/SsHEuQMfEuq', '2026-11-09 16:54:40', 0, 1),
(13, 'Roxana Zarate', 'roxanagzarate@gmail.com', '1151782885', '$2y$10$Iqduh8nwLG.j4iI/vmS91exRRZFbtUgYfX5NhFiLUPi2.FPBlWeUy', '2026-11-09 16:55:56', 0, 1),
(14, 'Agustina Molina', 'agustinamolina@gmail.com', '1145879636', '$2y$10$YT1ywo/iwYha2DbDVS7CfOSV4P2QmnvUetarnDwK00kFwgoqKxbl2', '2026-11-09 16:56:47', 0, 1),
(15, 'Agustin Zarate', 'agustinzarate@gmail.com', '1145652789', '$2y$10$EQmvGR0xTkMyOS0JKUoCZeumsA1W2PztroIAJQY9PO5PyS3gQhF2u', '2026-11-09 16:57:38', 0, 1),
(16, 'Daniel Zarate', 'danielzarate1234@gmail.com', '1169896412', '$2y$10$7JOSjFhTpJ6CICpmeajc/uQ7Xa9LIJZ9YNXe5fWCESzGy8eILqqzi', '2026-11-09 16:58:46', 0, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
