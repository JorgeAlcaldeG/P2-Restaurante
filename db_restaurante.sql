-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-11-2023 a las 20:52:07
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_restaurante`
--
CREATE DATABASE IF NOT EXISTS `db_restaurante` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_restaurante`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_camareros`
--

CREATE TABLE `tbl_camareros` (
  `id_user` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `contrasena` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_camareros`
--

INSERT INTO `tbl_camareros` (`id_user`, `nombre`, `correo`, `contrasena`) VALUES
(1, 'Julia S', 'julia@gmail.com', '$2y$10$qoqGHk2cmOumJNQ7KHPE4eyJgNr0rlykUvLIE86llfPXDz4RBsrvm'),
(2, 'Jorge', 'jorge@gmail.com', '$2y$10$qoqGHk2cmOumJNQ7KHPE4eyJgNr0rlykUvLIE86llfPXDz4RBsrvm'),
(3, 'Oscar', 'oscar@gmail.com', '$2y$10$qoqGHk2cmOumJNQ7KHPE4eyJgNr0rlykUvLIE86llfPXDz4RBsrvm');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mesas`
--

CREATE TABLE `tbl_mesas` (
  `id_mesa` int(11) NOT NULL,
  `id_sala` int(11) DEFAULT NULL,
  `mesa_ocupada` tinyint(1) DEFAULT 0,
  `numero_mesa` int(11) DEFAULT NULL,
  `fecha_entrada` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_mesas`
--

INSERT INTO `tbl_mesas` (`id_mesa`, `id_sala`, `mesa_ocupada`, `numero_mesa`, `fecha_entrada`) VALUES
(1, 1, 0, 1, NULL),
(2, 2, 0, 2, NULL),
(3, 7, 0, 1, NULL),
(4, 6, 0, 2, NULL),
(5, 3, 0, 1, NULL),
(6, 8, 0, 2, NULL),
(7, 4, 0, 1, NULL),
(8, 7, 0, 2, NULL),
(9, 5, 0, 1, NULL),
(10, 9, 0, 2, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_registros_mesas`
--

CREATE TABLE `tbl_registros_mesas` (
  `id_registro_mesas` int(11) NOT NULL,
  `id_mesa` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `fecha_hora_entrada` timestamp NULL DEFAULT NULL,
  `fecha_hora_salida` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_registros_mesas`
--

INSERT INTO `tbl_registros_mesas` (`id_registro_mesas`, `id_mesa`, `id_user`, `fecha_hora_entrada`, `fecha_hora_salida`) VALUES
(1, 5, 1, '2023-11-23 18:33:25', '2023-11-23 18:33:26'),
(2, 7, 1, '2023-11-23 18:39:25', '2023-11-23 18:39:27'),
(3, 9, 1, '2023-11-23 18:48:00', '2023-11-23 18:48:00'),
(4, 5, 1, '2023-11-23 18:56:43', '2023-11-23 18:56:46'),
(5, 4, 1, '2023-11-23 18:56:47', '2023-11-23 18:56:47'),
(6, 2, 1, '2023-11-23 18:56:48', '2023-11-23 18:56:50'),
(7, 4, 1, '2023-11-23 18:57:09', '2023-11-23 18:57:12'),
(8, 1, 1, '2023-11-23 18:57:10', '2023-11-23 18:57:12'),
(9, 10, 1, '2023-11-23 18:57:10', '2023-11-23 18:57:13'),
(10, 9, 1, '2023-11-23 18:57:09', '2023-11-23 18:57:13'),
(11, 5, 1, '2023-11-23 18:57:08', '2023-11-23 18:57:13'),
(12, 6, 1, '2023-11-23 18:57:09', '2023-11-23 18:57:14'),
(13, 8, 1, '2023-11-24 14:36:55', '2023-11-24 14:36:57'),
(14, 5, 1, '2023-11-24 14:36:50', '2023-11-24 14:36:59'),
(15, 5, 1, '2023-11-24 14:37:06', '2023-11-24 14:37:37'),
(16, 5, 1, '2023-11-24 14:37:39', '2023-11-24 14:38:07'),
(17, 10, 1, '2023-11-24 15:04:27', '2023-11-24 15:04:28'),
(18, 5, 1, '2023-11-24 16:08:47', '2023-11-24 16:08:48'),
(19, 5, 1, '2023-11-24 16:08:50', '2023-11-24 16:08:56'),
(20, 5, 1, '2023-11-24 16:08:57', '2023-11-24 16:08:58'),
(21, 9, 1, '2023-11-24 16:09:30', '2023-11-24 16:09:30'),
(22, 10, 1, '2023-11-24 16:09:32', '2023-11-24 16:09:33'),
(23, 1, 1, '2023-11-24 16:09:33', '2023-11-24 16:09:34'),
(24, 4, 1, '2023-11-24 16:09:35', '2023-11-24 16:09:36'),
(25, 2, 1, '2023-11-24 16:09:37', '2023-11-24 16:09:37'),
(26, 7, 1, '2023-11-24 16:09:38', '2023-11-24 16:09:39'),
(27, 8, 1, '2023-11-24 16:09:40', '2023-11-24 16:09:40'),
(28, 3, 1, '2023-11-24 16:09:41', '2023-11-24 16:09:42'),
(29, 6, 1, '2023-11-24 16:09:43', '2023-11-24 16:09:43'),
(30, 9, 1, '2023-11-24 16:10:31', '2023-11-24 16:10:34'),
(31, 9, 1, '2023-11-24 16:10:46', '2023-11-24 16:17:37'),
(32, 10, 1, '2023-11-24 16:17:36', '2023-11-24 16:17:38'),
(33, 2, 1, '2023-11-24 16:17:40', '2023-11-24 16:17:41'),
(34, 8, 1, '2023-11-24 16:17:43', '2023-11-24 16:17:44'),
(35, 7, 1, '2023-11-24 16:17:48', '2023-11-24 16:17:50'),
(36, 3, 1, '2023-11-24 16:21:03', '2023-11-24 16:25:56'),
(37, 3, 1, '2023-11-24 16:25:57', '2023-11-24 16:25:58'),
(38, 8, 1, '2023-11-24 16:24:42', '2023-11-24 16:26:37'),
(39, 8, 1, '2023-11-24 16:26:37', '2023-11-24 16:26:38'),
(40, 4, 1, '2023-11-24 16:21:01', '2023-11-24 16:30:29'),
(41, 4, 1, '2023-11-24 16:30:31', '2023-11-24 18:06:45'),
(42, 3, 1, '2023-11-24 16:25:59', '2023-11-24 18:06:47'),
(43, 8, 1, '2023-11-24 16:26:39', '2023-11-24 18:06:50'),
(44, 4, 1, '2023-11-24 18:06:54', '2023-11-24 18:47:53'),
(45, 4, 1, '2023-11-24 19:09:43', '2023-11-24 19:09:46'),
(46, 4, 1, '2023-11-24 19:09:48', '2023-11-24 19:09:51'),
(47, 4, 1, '2023-11-26 17:46:43', '2023-11-26 17:46:45'),
(48, 3, 1, '2023-11-26 17:47:00', '2023-11-26 17:47:02'),
(49, 3, 1, '2023-11-26 17:47:04', '2023-11-26 17:47:08'),
(50, 5, 1, '2023-11-26 17:47:10', '2023-11-26 17:47:11'),
(51, 10, 1, '2023-11-26 17:47:12', '2023-11-26 17:47:13'),
(52, 1, 1, '2023-11-26 17:47:16', '2023-11-26 17:47:17'),
(53, 5, 2, '2023-11-26 17:51:25', '2023-11-26 17:51:26'),
(54, 9, 2, '2023-11-26 17:51:27', '2023-11-26 17:51:28'),
(55, 1, 2, '2023-11-26 17:51:29', '2023-11-26 17:51:30'),
(56, 7, 2, '2023-11-26 17:51:31', '2023-11-26 17:51:32'),
(57, 2, 2, '2023-11-26 17:51:33', '2023-11-26 17:51:33'),
(58, 8, 2, '2023-11-26 17:51:34', '2023-11-26 17:51:35'),
(59, 10, 2, '2023-11-26 17:51:36', '2023-11-26 17:51:37'),
(60, 9, 2, '2023-11-26 17:51:38', '2023-11-26 17:51:40'),
(61, 9, 3, '2023-11-26 17:53:12', '2023-11-26 17:53:37'),
(62, 8, 3, '2023-11-26 17:53:15', '2023-11-26 17:53:39'),
(63, 5, 3, '2023-11-26 17:53:19', '2023-11-26 17:53:39'),
(64, 2, 3, '2023-11-26 17:53:29', '2023-11-26 17:53:40'),
(65, 10, 3, '2023-11-26 17:53:26', '2023-11-26 17:53:41'),
(66, 1, 3, '2023-11-26 17:53:17', '2023-11-26 17:53:42'),
(67, 4, 3, '2023-11-26 17:53:35', '2023-11-26 17:53:43'),
(68, 3, 3, '2023-11-26 17:53:24', '2023-11-26 17:53:43'),
(69, 6, 3, '2023-11-26 17:53:32', '2023-11-26 17:53:44'),
(70, 7, 3, '2023-11-26 17:53:21', '2023-11-26 17:53:44'),
(71, 3, 1, '2023-11-26 18:44:57', '2023-11-26 18:44:59'),
(72, 8, 1, '2023-11-26 18:44:58', '2023-11-26 18:45:06'),
(73, 9, 1, '2023-11-26 18:45:07', '2023-11-26 19:42:58'),
(74, 9, 1, '2023-11-26 19:45:34', '2023-11-26 19:45:37'),
(75, 9, 1, '2023-11-26 19:45:49', '2023-11-26 19:46:19'),
(76, 1, 1, '2023-11-26 19:46:22', '2023-11-26 19:46:27'),
(77, 4, 1, '2023-11-26 19:49:05', '2023-11-26 19:49:16'),
(78, 6, 3, '2023-11-26 19:51:48', '2023-11-26 19:51:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_registros_sillas`
--

CREATE TABLE `tbl_registros_sillas` (
  `id_registro_silla` int(11) NOT NULL,
  `id_silla` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `fecha_hora_entrada` timestamp NULL DEFAULT NULL,
  `fecha_hora_salida` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_salas`
--

CREATE TABLE `tbl_salas` (
  `id_sala` int(11) NOT NULL,
  `ubicacion_sala` varchar(50) NOT NULL,
  `capacidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_salas`
--

INSERT INTO `tbl_salas` (`id_sala`, `ubicacion_sala`, `capacidad`) VALUES
(1, 'Terraza Principal', 30),
(2, 'Salón Principal', 50),
(3, 'Sala VIP 1', 15),
(4, 'Terraza Secundaria', 20),
(5, 'Sala de Eventos 1', 40),
(6, 'Salón secundario', 30),
(7, 'Terraza trasera', 30),
(8, 'Sala VIP 2', 15),
(9, 'Sala de Eventos 2', 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_sillas`
--

CREATE TABLE `tbl_sillas` (
  `id_silla` int(11) NOT NULL,
  `silla_ocupada` tinyint(1) DEFAULT 0,
  `id_mesa` int(11) DEFAULT NULL,
  `fecha_entrada` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_sillas`
--

INSERT INTO `tbl_sillas` (`id_silla`, `silla_ocupada`, `id_mesa`, `fecha_entrada`) VALUES
(1, 0, 1, NULL),
(2, 0, 1, NULL),
(3, 0, 2, NULL),
(4, 0, 2, NULL),
(5, 0, 3, NULL),
(6, 0, 3, NULL),
(7, 0, 4, NULL),
(8, 0, 4, NULL),
(9, 0, 5, NULL),
(10, 0, 5, NULL),
(11, 0, 6, NULL),
(12, 0, 6, NULL),
(13, 0, 7, NULL),
(14, 0, 7, NULL),
(15, 0, 8, NULL),
(16, 0, 8, NULL),
(17, 0, 9, NULL),
(18, 0, 9, NULL),
(19, 0, 10, NULL),
(20, 0, 10, NULL),
(21, 0, 1, NULL),
(22, 0, 1, NULL),
(23, 0, 1, NULL),
(24, 0, 1, NULL),
(25, 0, 4, NULL),
(26, 0, 4, NULL),
(27, 0, 2, NULL),
(28, 0, 2, NULL),
(29, 0, 2, NULL),
(30, 0, 2, NULL),
(31, 0, 5, NULL),
(32, 0, 5, NULL),
(33, 0, 5, NULL),
(34, 0, 5, NULL),
(35, 0, 6, NULL),
(36, 0, 6, NULL),
(37, 0, 7, NULL),
(38, 0, 7, NULL),
(39, 0, 9, NULL),
(40, 0, 9, NULL),
(41, 0, 9, NULL),
(42, 0, 9, NULL),
(43, 0, 10, NULL),
(44, 0, 10, NULL),
(45, 0, 10, NULL),
(46, 0, 10, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_camareros`
--
ALTER TABLE `tbl_camareros`
  ADD PRIMARY KEY (`id_user`);

--
-- Indices de la tabla `tbl_mesas`
--
ALTER TABLE `tbl_mesas`
  ADD PRIMARY KEY (`id_mesa`),
  ADD KEY `id_sala` (`id_sala`);

--
-- Indices de la tabla `tbl_registros_mesas`
--
ALTER TABLE `tbl_registros_mesas`
  ADD PRIMARY KEY (`id_registro_mesas`),
  ADD KEY `id_mesa` (`id_mesa`),
  ADD KEY `id_user` (`id_user`);

--
-- Indices de la tabla `tbl_registros_sillas`
--
ALTER TABLE `tbl_registros_sillas`
  ADD PRIMARY KEY (`id_registro_silla`),
  ADD KEY `id_silla` (`id_silla`),
  ADD KEY `id_user` (`id_user`);

--
-- Indices de la tabla `tbl_salas`
--
ALTER TABLE `tbl_salas`
  ADD PRIMARY KEY (`id_sala`);

--
-- Indices de la tabla `tbl_sillas`
--
ALTER TABLE `tbl_sillas`
  ADD PRIMARY KEY (`id_silla`),
  ADD KEY `id_mesa` (`id_mesa`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_camareros`
--
ALTER TABLE `tbl_camareros`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbl_mesas`
--
ALTER TABLE `tbl_mesas`
  MODIFY `id_mesa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `tbl_registros_mesas`
--
ALTER TABLE `tbl_registros_mesas`
  MODIFY `id_registro_mesas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT de la tabla `tbl_registros_sillas`
--
ALTER TABLE `tbl_registros_sillas`
  MODIFY `id_registro_silla` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_salas`
--
ALTER TABLE `tbl_salas`
  MODIFY `id_sala` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tbl_sillas`
--
ALTER TABLE `tbl_sillas`
  MODIFY `id_silla` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_mesas`
--
ALTER TABLE `tbl_mesas`
  ADD CONSTRAINT `tbl_mesas_ibfk_1` FOREIGN KEY (`id_sala`) REFERENCES `tbl_salas` (`id_sala`);

--
-- Filtros para la tabla `tbl_registros_mesas`
--
ALTER TABLE `tbl_registros_mesas`
  ADD CONSTRAINT `tbl_registros_mesas_ibfk_1` FOREIGN KEY (`id_mesa`) REFERENCES `tbl_mesas` (`id_mesa`),
  ADD CONSTRAINT `tbl_registros_mesas_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `tbl_camareros` (`id_user`);

--
-- Filtros para la tabla `tbl_registros_sillas`
--
ALTER TABLE `tbl_registros_sillas`
  ADD CONSTRAINT `tbl_registros_sillas_ibfk_1` FOREIGN KEY (`id_silla`) REFERENCES `tbl_sillas` (`id_silla`),
  ADD CONSTRAINT `tbl_registros_sillas_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `tbl_camareros` (`id_user`);

--
-- Filtros para la tabla `tbl_sillas`
--
ALTER TABLE `tbl_sillas`
  ADD CONSTRAINT `tbl_sillas_ibfk_1` FOREIGN KEY (`id_mesa`) REFERENCES `tbl_mesas` (`id_mesa`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
