-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-07-2026 a las 21:02:14
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
-- Base de datos: `weedy_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `certificados_coa`
--

CREATE TABLE `certificados_coa` (
  `idLote` varchar(50) NOT NULL,
  `pdfCertificadoUrl` varchar(255) NOT NULL,
  `fechaAnalisis` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `certificados_coa`
--

INSERT INTO `certificados_coa` (`idLote`, `pdfCertificadoUrl`, `fechaAnalisis`) VALUES
('LOTE-2026-A1', 'http://localhost/Weedy/certs/coa-a1.pdf', '2026-05-12'),
('LOTE-2026-B2', 'http://localhost/Weedy/certs/coa-b2.pdf', '2026-06-01'),
('LOTE-2026-C3', 'http://localhost/Weedy/certs/coa-c3.pdf', '2026-07-10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas_telemedicina`
--

CREATE TABLE `citas_telemedicina` (
  `idCita` varchar(50) NOT NULL,
  `fechaHora` datetime NOT NULL,
  `linkVideollamada` varchar(255) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `idMedico` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `diarios_dosificacion`
--

CREATE TABLE `diarios_dosificacion` (
  `idPaciente` varchar(50) NOT NULL,
  `idCita` varchar(50) NOT NULL,
  `registrosSintomas` text DEFAULT NULL,
  `nivelDolor` int(11) NOT NULL,
  `fechaRegistro` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `idUsuario` varchar(50) NOT NULL,
  `documentosValidacion` text DEFAULT NULL,
  `historialClinico` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos_envio`
--

CREATE TABLE `pedidos_envio` (
  `idPedido` varchar(50) NOT NULL,
  `trackingNumber` varchar(100) DEFAULT NULL,
  `direccionEntrega` varchar(255) NOT NULL,
  `estadoEnvio` varchar(50) NOT NULL,
  `idRecipe` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_productos`
--

CREATE TABLE `pedido_productos` (
  `idPedido` varchar(50) NOT NULL,
  `idProducto` varchar(50) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_logistica`
--

CREATE TABLE `personal_logistica` (
  `idUsuario` varchar(50) NOT NULL,
  `idAlmacen` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_medico`
--

CREATE TABLE `personal_medico` (
  `idUsuario` varchar(50) NOT NULL,
  `numeroLicencia` varchar(100) NOT NULL,
  `especialidad` varchar(150) NOT NULL,
  `agendaDisponible` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_farma`
--

CREATE TABLE `productos_farma` (
  `idProducto` varchar(50) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `concentracionCBD_THC` varchar(100) NOT NULL,
  `stockDisponible` int(11) NOT NULL DEFAULT 0,
  `precio` double(10,2) NOT NULL,
  `idLote` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `productos_farma`
--

INSERT INTO `productos_farma` (`idProducto`, `nombre`, `concentracionCBD_THC`, `stockDisponible`, `precio`, `idLote`) VALUES
('PROD-CAP-03', 'Cápsulas Blandas de Espectro Completo', '25mg CBD por cápsula', 60, 48.00, 'LOTE-2026-B2'),
('PROD-CBD-01', 'Aceite Medicinal CBD 10% - Gotero 30ml', '10% CBD / 0.2% THC', 150, 35.00, 'LOTE-2026-A1'),
('PROD-CRE-04', 'Bálsamo Terapéutico Hidratante Botánico', '2% CBD / 0% THC', 200, 19.99, 'LOTE-2026-C3'),
('PROD-GEL-02', 'Gel Alivio Localizado - Extra Fuerte', '5% CBD / 0% THC', 85, 24.50, 'LOTE-2026-A1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recipes_digitales`
--

CREATE TABLE `recipes_digitales` (
  `idRecipe` varchar(50) NOT NULL,
  `codigoQR` varchar(255) NOT NULL,
  `tokenCifrado` varchar(255) NOT NULL,
  `fechaVencimiento` date NOT NULL,
  `idCita` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` varchar(50) NOT NULL,
  `nombreCompleto` varchar(255) NOT NULL,
  `correoElectronico` varchar(150) NOT NULL,
  `cedulaIdentidad` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `certificados_coa`
--
ALTER TABLE `certificados_coa`
  ADD PRIMARY KEY (`idLote`);

--
-- Indices de la tabla `citas_telemedicina`
--
ALTER TABLE `citas_telemedicina`
  ADD PRIMARY KEY (`idCita`),
  ADD KEY `fk_citas_medico` (`idMedico`);

--
-- Indices de la tabla `diarios_dosificacion`
--
ALTER TABLE `diarios_dosificacion`
  ADD PRIMARY KEY (`idPaciente`,`idCita`),
  ADD KEY `fk_diario_cita` (`idCita`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`idUsuario`);

--
-- Indices de la tabla `pedidos_envio`
--
ALTER TABLE `pedidos_envio`
  ADD PRIMARY KEY (`idPedido`),
  ADD KEY `fk_pedidos_recipes` (`idRecipe`);

--
-- Indices de la tabla `pedido_productos`
--
ALTER TABLE `pedido_productos`
  ADD PRIMARY KEY (`idPedido`,`idProducto`),
  ADD KEY `fk_det_producto` (`idProducto`);

--
-- Indices de la tabla `personal_logistica`
--
ALTER TABLE `personal_logistica`
  ADD PRIMARY KEY (`idUsuario`);

--
-- Indices de la tabla `personal_medico`
--
ALTER TABLE `personal_medico`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `numeroLicencia` (`numeroLicencia`);

--
-- Indices de la tabla `productos_farma`
--
ALTER TABLE `productos_farma`
  ADD PRIMARY KEY (`idProducto`),
  ADD KEY `fk_productos_coa` (`idLote`);

--
-- Indices de la tabla `recipes_digitales`
--
ALTER TABLE `recipes_digitales`
  ADD PRIMARY KEY (`idRecipe`),
  ADD UNIQUE KEY `idCita` (`idCita`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `correoElectronico` (`correoElectronico`),
  ADD UNIQUE KEY `cedulaIdentidad` (`cedulaIdentidad`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas_telemedicina`
--
ALTER TABLE `citas_telemedicina`
  ADD CONSTRAINT `fk_citas_medico` FOREIGN KEY (`idMedico`) REFERENCES `personal_medico` (`idUsuario`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `diarios_dosificacion`
--
ALTER TABLE `diarios_dosificacion`
  ADD CONSTRAINT `fk_diario_cita` FOREIGN KEY (`idCita`) REFERENCES `citas_telemedicina` (`idCita`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_diario_paciente` FOREIGN KEY (`idPaciente`) REFERENCES `pacientes` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD CONSTRAINT `fk_pacientes_usuarios` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedidos_envio`
--
ALTER TABLE `pedidos_envio`
  ADD CONSTRAINT `fk_pedidos_recipes` FOREIGN KEY (`idRecipe`) REFERENCES `recipes_digitales` (`idRecipe`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedido_productos`
--
ALTER TABLE `pedido_productos`
  ADD CONSTRAINT `fk_det_pedido` FOREIGN KEY (`idPedido`) REFERENCES `pedidos_envio` (`idPedido`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_det_producto` FOREIGN KEY (`idProducto`) REFERENCES `productos_farma` (`idProducto`);

--
-- Filtros para la tabla `personal_logistica`
--
ALTER TABLE `personal_logistica`
  ADD CONSTRAINT `fk_logistica_usuarios` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `personal_medico`
--
ALTER TABLE `personal_medico`
  ADD CONSTRAINT `fk_medico_usuarios` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos_farma`
--
ALTER TABLE `productos_farma`
  ADD CONSTRAINT `fk_productos_coa` FOREIGN KEY (`idLote`) REFERENCES `certificados_coa` (`idLote`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `recipes_digitales`
--
ALTER TABLE `recipes_digitales`
  ADD CONSTRAINT `fk_recipes_citas` FOREIGN KEY (`idCita`) REFERENCES `citas_telemedicina` (`idCita`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
