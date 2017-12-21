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
  `AliasEvaluado` varchar(6) COLLATE latin1_spanish_ci NOT NULL,
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
  `Alias` varchar(6) COLLATE latin1_spanish_ci NOT NULL,
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

  
  
  --         INSERTS
  
INSERT INTO `ACCION` (`IdAccion`, `NombreAccion`, `DescripAccion`) VALUES
('0', 'ADD', 'ADD'),
('1', 'DELETE', 'DELETE'),
('2', 'EDIT', 'EDIT'),
('3', 'SEARCH', 'SEARCH'),
('4', 'SHOWCURRENT', 'SHOWCURRENT'),
('5', 'SHOWALL', 'SHOWALL'),
('6', 'ASIGN', 'ASIGN'),
('7', 'CONSULTETS', 'CONSULTETS'),
('8', 'GENQAS', 'GENQAS'),
('9', 'GENHIST', 'GENHIST'),
('10', 'SOLOUSU', 'SOLOUSU'),
('11', 'SOLOADMIN', 'SOLOADMIN'),
('12', 'EDITUSU', 'EDITUSU'),
('13', 'GENET', 'GENET'),  
('14', 'CONSULTQAS', 'CONSULTQAS'); 
  
INSERT INTO `FUNCIONALIDAD` (`IdFuncionalidad`, `NombreFuncionalidad`, `DescripFuncionalidad`) VALUES
('1', 'GestionUsuarios', 'GestionUsuarios'),
('10', 'Gestion de historias', 'Gestion de historias'),
('11', 'Gestion de trabajos', 'Gestion de trabajos'),
('12', 'Gestion de Evaluacion', 'Gestion de Evaluacion'),
('2', 'GestionGrupos', 'GestionGrupos'),
('3', 'GestionFuncionalidades', 'GestionFuncionalidades'),
('4', 'GestionAccion', 'GestionAccion'),
('5', 'GestionPermisos', 'GestionPermisos'),
('6', 'Asignacion de QAs', 'Asignacion de QAs'),
('7', 'Gestion de notas', 'Gestion de notas'),
('8', 'Gestion de entregas', 'Gestion de entregas');




INSERT INTO `FUNC_ACCION` (`IdFuncionalidad`, `IdAccion`) VALUES
('1', '0'),
('1', '1'),
('1', '2'),
('1', '3'),
('1', '4'),
('1', '5'),
('1', '6'),
('10', '0'),
('10', '1'),
('10', '2'),
('10', '3'),
('10', '4'),
('10', '5'),
('11', '0'),
('11', '1'),
('11', '2'),
('11', '3'),
('11', '4'),
('11', '5'),
('12', '0'),
('12', '1'),
('12', '2'),
('12', '3'),
('12', '4'),
('12', '5'),
('12', '7'),
('12', '10'),
('12', '11'),
('12', '12'),
('12', '14'),
('2', '0'),
('2', '1'),
('2', '2'),
('2', '3'),
('2', '4'),
('2', '5'),
('2', '6'),
('3', '0'),
('3', '1'),
('3', '2'),
('3', '3'),
('3', '4'),
('3', '5'),
('3', '6'),
('4', '0'),
('4', '1'),
('4', '2'),
('4', '3'),
('4', '4'),
('4', '5'),
('5', '3'),
('5', '5'),
('6', '0'),
('6', '1'),
('6', '2'),
('6', '3'),
('6', '4'),
('6', '5'),
('6', '8'),
('6', '9'),
('7', '0'),
('7', '1'),
('7', '2'),
('7', '3'),
('7', '4'),
('7', '5'),
('7', '8'),
('7', '10'),
('7', '13'),
('8', '0'),
('8', '1'),
('8', '2'),
('8', '3'),
('8', '4'),
('8', '5'),
('8', '10');


INSERT INTO `PERMISO` (`IdGrupo`, `IdFuncionalidad`, `IdAccion`) VALUES
('00001A', '12', '2'),
('00001A', '12', '7'),
('00001A', '12', '10'),
('00001A', '12', '14'),
('00001A', '7', '10'),
('00001A', '8', '2'),
('00001A', '8', '10');



INSERT INTO `GRUPO` (`IdGrupo`, `NombreGrupo`, `DescripGrupo`) VALUES
('00000A', 'Administracion', 'Grupo que tendra todos los permisos'),
('00001A', 'Alumnos', 'Grupo que tendra todos los permisos de alumnos'),
('00002A', 'Prueba', 'Este grupo se inicializa sin permisos');

 


INSERT INTO `USUARIO` (`login`, `password`, `DNI`, `Nombre`, `Apellidos`, `Correo`, `Direccion`, `Telefono`) VALUES
('a', '0cc175b9c0f1b6a831c399e269772661', '50307657X', 'a', 'a', 'aa@a.aa', 'a', '34988222222'),
('admin', '21232f297a57a5a743894a0e4a801fc3', '44656257D', 'admin', 'admin', 'admin@admin.admin', 'admin', '988252515'),
('b', '92eb5ffee6ae2fec3ad71c777531578f', '86309999S', 'b', 'b', 'b@b.bb', 'b', '988212212'),
('c', '4a8a08f09d37b73795649038408b5f33', '90011482Q', 'c', 'c', 'cc@c.cc', 'c', '988272717'),
('d', '8277e0910d750195b448797616e091ad', '86309999S', 'd', 'd', 'd@d.dd', 'd', '34998343433'),
('e', 'e1671797c52e15f763380b45e841ec32', '71028847V', 'e', 'e', 'e@ee.e', 'e', '988222222'),
('f', '8fa14cdd754f91cc6554c9e71929cce7', '12081312X', 'f', 'f', 'ff@ff.ff', 'f', '988222222'),
('g', 'b2f5ff47436671b6e533d8dc3614845d', '57039042P', 'g', 'g', 'gg@gg.g', 'g', '988222222'),
('h', '2510c39011c5be704182423e3a695e91', '80950297A', 'h', 'h', 'hh@hh.h', 'h', '988222222'),
('i', '865c0c0b4ab0e063e5caa3387c1a8741', '71821143D', 'i', 'i', 'ii@ii.ii', 'i', '988222222'),
('j', '363b122c528f54df4a0446b6bab05515', '06886276F', 'j', 'j', 'jj@jj.jj', 'j', '988222222');

INSERT INTO `USU_GRUPO` (`login`, `IdGrupo`) VALUES
('a', '00001A'),
('admin', '00000A'),
('b', '00001A'),
('c', '00001A'),
('d', '00001A'),
('e', '00001A'),
('f', '00001A'),
('g', '00001A'),
('h', '00001A'),
('i', '00001A'),
('j', '00001A');

INSERT INTO `TRABAJO` (`IdTrabajo`, `NombreTrabajo`, `FechaIniTrabajo`, `FechaFinTrabajo`, `PorcentajeNota`) VALUES
('ET1', 'ET1', '2017-12-08', '2017-12-10', '20'),
('QA1', 'QA1', '2017-12-05', '2017-12-11', '10'),
('ET2', 'ET2', '2017-12-08', '2017-12-10', '20'),
('QA2', 'QA2', '2017-12-05', '2017-12-11', '10'),
('ET3', 'ET3', '2017-12-08', '2017-12-10', '30'),
('QA3', 'QA3', '2017-12-05', '2017-12-11', '10');

INSERT INTO `HISTORIA` (`IdTrabajo`, `IdHistoria`, `TextoHistoria`) VALUES
('ET1', 0, 'historia0'),
('ET1', 1, 'historia1'),
('ET1', 2, 'historia2'),
('ET1', 3, 'historia3'),
('ET1', 4, 'historia4'),
('ET1', 5, 'historia5'),
('ET1', 6, 'historia6'),
('ET1', 7, 'historia7'),
('ET1', 8, 'historia8'),
('ET1', 9, 'historia9'),
('ET2', 0, 'historia0'),
('ET2', 1, 'historia1'),
('ET2', 2, 'historia2'),
('ET2', 3, 'historia3'),
('ET2', 4, 'historia4'),
('ET2', 5, 'historia5'),
('ET2', 6, 'historia6'),
('ET2', 7, 'historia7'),
('ET2', 8, 'historia8'),
('ET2', 9, 'historia9'),
('ET3', 0, 'historia0'),
('ET3', 1, 'historia1'),
('ET3', 2, 'historia2'),
('ET3', 3, 'historia3'),
('ET3', 4, 'historia4'),
('ET3', 5, 'historia5'),
('ET3', 6, 'historia6'),
('ET3', 7, 'historia7'),
('ET3', 8, 'historia8'),
('ET3', 9, 'historia9');
  

  
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
