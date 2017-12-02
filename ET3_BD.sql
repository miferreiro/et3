-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 20, 2017 at 10:08 AM
-- Server version: 10.1.26-MariaDB-0+deb9u1
-- PHP Version: 7.0.19-1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `IUET32017`
--
-- jrodeiro - 7/10/2017
-- script de creación de la bd, usuario, asignación de privilegios a ese usuario sobre la bd
-- creación de tabla e insert sobre la misma.
--
-- CREAR LA BD BORRANDOLA SI YA EXISTIESE
--
DROP DATABASE IF EXISTS `IUET32017`;
CREATE DATABASE `IUET32017` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
--
-- SELECCIONAMOS PARA USAR
--
USE `IUET32017`;
--
-- DAMOS PERMISO USO Y BORRAMOS EL USUARIO QUE QUEREMOS CREAR POR SI EXISTE
--
GRANT USAGE ON * . * TO `userET3`@`localhost`;
	DROP USER `userET3`@`localhost`;
--
-- CREAMOS EL USUARIO Y LE DAMOS PASSWORD,DAMOS PERMISO DE USO Y DAMOS PERMISOS SOBRE LA BASE DE DATOS.
--
CREATE USER IF NOT EXISTS `userET3`@`localhost` IDENTIFIED BY 'passET3';
GRANT USAGE ON *.* TO `userET3`@`localhost` REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;
GRANT ALL PRIVILEGES ON `IUET32017`.* TO `userET3`@`localhost` WITH GRANT OPTION;
-- --------------------------------------------------------
-- --------------------------------------------------------
--
-- Table structure for table `PERMISO`
--

CREATE TABLE `PERMISO` (
  `IdGrupo` varchar(6) COLLATE latin1_spanish_ci NOT NULL,  
  `IdFuncionalidad` varchar(6) COLLATE latin1_spanish_ci NOT NULL,
  `IdAccion` varchar(6) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Table structure for table `FUNC_ACCION`
--

CREATE TABLE `FUNC_ACCION` (
  `IdFuncionalidad` varchar(6) COLLATE latin1_spanish_ci NOT NULL,
  `IdAccion` varchar(6) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


--
-- Table structure for table `USUARIO_GRUPO`
--

CREATE TABLE `USU_GRUPO` (
  `login` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  `IdGrupo` varchar(6) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Table structure for table `ACCION`
--

CREATE TABLE `ACCION` (
  `IdAccion` varchar(6) COLLATE latin1_spanish_ci NOT NULL,
  `NombreAccion` varchar(60) COLLATE latin1_spanish_ci NOT NULL,
  `DescripAccion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `FUNCIONALIDAD`
--

CREATE TABLE `FUNCIONALIDAD` (
  `IdFuncionalidad` varchar(6) COLLATE latin1_spanish_ci NOT NULL,
  `NombreFuncionalidad` varchar(60) COLLATE latin1_spanish_ci NOT NULL,
  `DescripFuncionalidad` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------
--
-- Table structure for table `GRUPO`
--

CREATE TABLE `GRUPO` (
  `IdGrupo` varchar(6) COLLATE latin1_spanish_ci NOT NULL,
  `NombreGrupo` varchar(60) COLLATE latin1_spanish_ci NOT NULL,
  `DescripGrupo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `TRABAJO`
--

CREATE TABLE `TRABAJO` (
  `IdTrabajo` varchar(6) COLLATE latin1_spanish_ci NOT NULL,
  `NombreTrabajo` varchar(60) COLLATE latin1_spanish_ci NOT NULL,
  `FechaIniTrabajo` date NOT NULL,
  `FechaFinTrabajo` date NOT NULL,
  `PorcentajeNota` decimal(2,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


-- --------------------------------------------------------

--
-- Table structure for table `EVALUACION`
--
-- OK : indicación de si esta correcta o no la QA (1 correcto, 0 Incorrecto)
-- CorrectoP : Indicación de si esta correcta la historia de la ET
-- CorrectoA : evaluación de la historia por parte del alumno evaluador de esa historia de esa ET

CREATE TABLE `EVALUACION` (
  `IdTrabajo` varchar(6) COLLATE latin1_spanish_ci NOT NULL,
  `LoginEvaluador` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  `AliasEvaluado` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  `IdHistoria` int(2) NOT NULL,
  `CorrectoA` tinyint(1) NOT NULL,
  `ComenIncorrectoA` varchar(300) COLLATE latin1_spanish_ci NOT NULL,
  `CorrectoP` tinyint(1) NOT NULL,
  `ComentIncorrectoP` varchar(300) COLLATE latin1_spanish_ci NOT NULL,
  `OK` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `HISTORIA`
--

CREATE TABLE `HISTORIA` (
  `IdTrabajo` varchar(6) COLLATE latin1_spanish_ci NOT NULL,
  `IdHistoria` int(2) NOT NULL,
  `TextoHistoria` varchar(300) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;



-- --------------------------------------------------------

--
-- Table structure for table `NOTASTRABAJO`
--

CREATE TABLE `NOTA_TRABAJO` (
  `login` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  `IdTrabajo` varchar(6) COLLATE latin1_spanish_ci NOT NULL,
  `NotaTrabajo` decimal(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `QA`
--

CREATE TABLE `ASIGNAC_QA` (
  `IdTrabajo` varchar(6) COLLATE latin1_spanish_ci NOT NULL,
  `LoginEvaluador` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  `LoginEvaluado` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  `AliasEvaluado` varchar(6) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ENTREGA`
--

CREATE TABLE `ENTREGA` (
  `login` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  `IdTrabajo` varchar(6) COLLATE latin1_spanish_ci NOT NULL,
  `Alias` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  `Horas` int(2) DEFAULT NULL,
  `Ruta` varchar(60) COLLATE latin1_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;



-- --------------------------------------------------------

--
-- Table structure for table `USUARIO`
--

CREATE TABLE `USUARIO` (
  `login` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  `password` varchar(128) COLLATE latin1_spanish_ci NOT NULL,
  `DNI` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  `Nombre` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `Apellidos` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `Correo` varchar(40) COLLATE latin1_spanish_ci NOT NULL,
  `Direccion` varchar(60) COLLATE latin1_spanish_ci NOT NULL,
  `Telefono` varchar(11) COLLATE latin1_spanish_ci NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Indexes for table `TRABAJO`
--
ALTER TABLE `TRABAJO`
  ADD PRIMARY KEY (`IdTrabajo`);

--
-- Indexes for table `EVALUACION`
--
ALTER TABLE `EVALUACION`
  ADD PRIMARY KEY (`IdTrabajo`,`AliasEvaluado`,`LoginEvaluador`,`IdHistoria`);

--
-- Indexes for table `HISTORIA`
--
ALTER TABLE `HISTORIA`
  ADD PRIMARY KEY (`IdTrabajo`,`IdHistoria`);

--
-- Indexes for table `NOTASTRABAJO`
--
ALTER TABLE `NOTA_TRABAJO`
  ADD PRIMARY KEY (`login`,`IdTrabajo`);

--
-- Indexes for table `QA`
--
ALTER TABLE `ASIGNAC_QA`
  ADD PRIMARY KEY (`IdTrabajo`,`LoginEvaluador`,`AliasEvaluado`);

--
-- Indexes for table `ENTREGA`
--
ALTER TABLE `ENTREGA`
  ADD PRIMARY KEY (`login`,`IdTrabajo`);

--
-- Indexes for table `USUARIO`
--
ALTER TABLE `USUARIO`
  ADD PRIMARY KEY (`login`);

--
-- Indexes for table `GRUPO`
--
ALTER TABLE `GRUPO`
  ADD PRIMARY KEY (`IdGrupo`);

--
-- Indexes for table `FUNCIONALIDAD`
--
ALTER TABLE `FUNCIONALIDAD`
  ADD PRIMARY KEY (`IdFuncionalidad`);

--
-- Indexes for table `ACCION`
--
ALTER TABLE `ACCION`
  ADD PRIMARY KEY (`IdAccion`);

--
-- Indexes for table `USUARIO_GRUPO`
--
ALTER TABLE `USU_GRUPO`
  ADD PRIMARY KEY (`login`,`IdGrupo`);

--
-- Indexes for table `FUNC_ACCION`
--
ALTER TABLE `FUNC_ACCION`
  ADD PRIMARY KEY (`IdFuncionalidad`,`IdAccion`);

--
-- Indexes for table `PERMISO`
--
ALTER TABLE `PERMISO`
  ADD PRIMARY KEY (`IdGrupo`,`IdFuncionalidad`,`IdAccion`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
