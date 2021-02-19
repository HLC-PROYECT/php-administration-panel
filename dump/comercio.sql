-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 20-01-2021 a las 23:34:22
-- Versión del servidor: 8.0.23
-- Versión de PHP: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `comercio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE `articulos` (
  `codigo` int NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `precio` varchar(100) DEFAULT NULL,
  `categoria` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `articulos`
--

INSERT INTO `articulos` (`codigo`, `nombre`, `descripcion`, `precio`, `categoria`) VALUES
(1, 'ATI RAEDON X700', 'Tarjeta gráfica de ATI con 256MB de RAM', '100', 'Tarjetas gráficas'),
(2, 'GEFORCE MX440', 'Tarjeta gráfica de NVIDIA. 128MB de RAM', '50', 'Tarjetas gráficas'),
(3, 'INTEL PENTIUM M 760', 'Procesador Pentium 2.0GHz', '120', 'Procesadores');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `dni` varchar(10) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `telefono` varchar(100) DEFAULT NULL,
  `localidad` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `dni_cliente` varchar(10) DEFAULT NULL,
  `cod_articulo` int DEFAULT NULL,
  `fecha_compra` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `depart`
--

CREATE TABLE `depart` (
  `dept_no` int DEFAULT NULL,
  `dnombre` varchar(30) DEFAULT NULL,
  `loc` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `depart`
--

INSERT INTO `depart` (`dept_no`, `dnombre`, `loc`) VALUES
(10, 'CONTABILIDAD', 'SEVILLA'),
(20, 'INVESTIGACION', 'MADRID'),
(30, 'VENTAS', 'BARCELONA'),
(40, 'PRODUCCION', 'BILBAO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `emple`
--

CREATE TABLE `emple` (
  `emp_no` int NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `oficio` varchar(30) DEFAULT NULL,
  `dir` int DEFAULT NULL,
  `fecha_alt` date DEFAULT NULL,
  `salario` int DEFAULT NULL,
  `comision` int DEFAULT NULL,
  `dept_no` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `emple`
--

INSERT INTO `emple` (`emp_no`, `apellido`, `oficio`, `dir`, `fecha_alt`, `salario`, `comision`, `dept_no`) VALUES
(7369, 'SANCHEZ', 'EMPLEADO', 7902, '1990-12-17', 1040, NULL, 20),
(7499, 'ARROYO', 'VENDEDOR', 7698, '1990-02-20', 1500, 390, 30),
(7521, 'SALA', 'VENDEDOR', 7698, '1991-02-22', 1625, 650, 30),
(7566, 'JIMENEZ', 'DIRECTOR', 7839, '1991-04-02', 2900, NULL, 20),
(7654, 'MARTIN', 'VENDEDOR', 7698, '1991-09-29', 1600, 1020, 30),
(7698, 'NEGRO', 'DIRECTOR', 7839, '1991-05-01', 3005, NULL, 30),
(7782, 'CEREZO', 'DIRECTOR', 7839, '1991-06-09', 2885, NULL, 10),
(7788, 'GIL', 'ANALISTA', 7566, '1991-11-09', 3000, NULL, 20),
(7839, 'REY', 'PRESIDENTE', NULL, '1991-11-17', 4100, NULL, 10),
(7844, 'TOVAR', 'VENDEDOR', 7698, '1991-09-08', 1350, 0, 30),
(7876, 'ALONSO', 'EMPLEADO', 7788, '1991-09-23', 1430, NULL, 20),
(7900, 'JIMENO', 'EMPLEADO', 7698, '1991-12-03', 1335, NULL, 30),
(7902, 'FERNANDEZ', 'ANALISTA', 7566, '1991-12-03', 3000, NULL, 20),
(7934, 'MUNOZ', 'EMPLEADO', 7782, '1992-01-23', 1690, NULL, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hospitales`
--

CREATE TABLE `hospitales` (
  `cod_hospital` int DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `direccion` varchar(50) DEFAULT NULL,
  `num_plazas` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `hospitales`
--

INSERT INTO `hospitales` (`cod_hospital`, `nombre`, `direccion`, `num_plazas`) VALUES
(1, 'Rafael Méndez', 'Gran Vía, 7', 250),
(2, 'Reina Sofía', 'Junterones, 5', 225),
(3, 'Príncipe Asturias', 'Avenida Colón', 150),
(4, 'Virgen de la Arrixaca', 'Avenida Juan Carlos I', 250);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicos`
--

CREATE TABLE `medicos` (
  `cod_hospital` int DEFAULT NULL,
  `dni` int NOT NULL,
  `apellidos` varchar(50) DEFAULT NULL,
  `especialidad` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `medicos`
--

INSERT INTO `medicos` (`cod_hospital`, `dni`, `apellidos`, `especialidad`) VALUES
(4, 22233311, 'Martínez Molina, Gloria', 'PSIQUIATRA'),
(2, 22233322, 'Tristán García, Ana', 'CIRUJANO'),
(2, 22233333, 'Martínez Molina, Andrés', 'CIRUJANO'),
(4, 33222111, 'Mesa del Castillo, Juan', 'DERMATOLOGO'),
(1, 66655544, 'Castillo Montes, Pedro', 'PSIQUIATRA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `cod_hospital` int DEFAULT NULL,
  `dni` int NOT NULL,
  `apellidos` varchar(50) DEFAULT NULL,
  `funcion` varchar(30) DEFAULT NULL,
  `salario` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`cod_hospital`, `dni`, `apellidos`, `funcion`, `salario`) VALUES
(1, 12345678, 'García Hernández, Eladio', 'CONSERJE', 1200),
(4, 22233311, 'Martínez Molina, Gloria', 'MEDICO', 1600),
(2, 22233322, 'Tristán García, Ana', 'MEDICO', 1900),
(2, 22233333, 'Martínez Molina, Andrés', 'MEDICO', 1600),
(4, 33222111, 'Mesa del Castillo, Juan', 'MEDICO', 2200),
(3, 55544411, 'Ruiz Hernández, Caridad', 'MEDICO', 1900),
(4, 55544412, 'Jiménez Jiménez, Dolores', 'CONSERJE', 1200),
(2, 55544433, 'González Marín, Alicia', 'CONSERJE', 1200),
(1, 66655544, 'Castillo Montes, Pedro', 'MEDICO', 1700),
(1, 87654321, 'Fuentes Bermejo, Carlos', 'DIRECTOR', 2000),
(3, 99988333, 'Serrano Díaz, Alejandro', 'DIRECTOR', 2400);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`dni`);

--
-- Indices de la tabla `emple`
--
ALTER TABLE `emple`
  ADD PRIMARY KEY (`emp_no`);

--
-- Indices de la tabla `medicos`
--
ALTER TABLE `medicos`
  ADD PRIMARY KEY (`dni`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`dni`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
