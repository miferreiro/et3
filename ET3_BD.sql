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
-- script de creaci�n de la bd, usuario, asignaci�n de privilegios a ese usuario sobre la bd
-- creaci�n de tabla e insert sobre la misma.
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
-- OK : indicaci�n de si esta correcta o no la QA (1 correcto, 0 Incorrecto)
-- CorrectoP : Indicaci�n de si esta correcta la historia de la ET
-- CorrectoA : evaluaci�n de la historia por parte del alumno evaluador de esa historia de esa ET

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
('00001A', '12', '12'),
('00001A', '12', '14'),
('00001A', '7', '10'),
('00001A', '8', '2'),
('00001A', '8', '10');



INSERT INTO `GRUPO` (`IdGrupo`, `NombreGrupo`, `DescripGrupo`) VALUES
('00000A', 'Administracion', 'Grupo que tendra todos los permisos'),
('00001A', 'Alumnos', 'Grupo que tendra todos los permisos de alumnos'),
('00002A', 'Prueba', 'Este grupo se inicializa sin permisos');

 
--
-- EL LOGIN DEL USUARIO COINCIDE CON SU CONTRASE�A
--


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
('ET1', 'ET1', '2017-12-08', '2018-12-31', '20'),
('QA1', 'QA1', '2017-12-05', '2018-12-31', '10'),
('ET2', 'ET2', '2017-12-08', '2018-12-31', '20'),
('QA2', 'QA2', '2017-12-05', '2018-12-31', '10'),
('ET3', 'ET3', '2017-12-08', '2018-12-31', '30'),
('QA3', 'QA3', '2017-12-05', '2018-12-31', '10');

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
  
INSERT INTO `ENTREGA` (`login`, `IdTrabajo`, `Alias`, `Horas`, `Ruta`) VALUES
('a', 'ET1', 'ucJjSo', 0, '../Files/ucJjSo/README.md'),
('a', 'ET2', 'l3MxL9', 0, '../Files/l3MxL9/README.md'),
('a', 'ET3', 'SQIe3G', 0, '../Files/SQIe3G/README.md'),
('b', 'ET1', 'BWlZi8', 0, '../Files/BWlZi8/README.md'),
('b', 'ET2', 'EWLJLg', 0, '../Files/EWLJLg/README.md'),
('b', 'ET3', 'MoELRr', 0, '../Files/MoELRr/README.md'),
('c', 'ET1', 'j3aiZ8', 0, '../Files/j3aiZ8/README.md'),
('c', 'ET2', 'leeSIk', 0, '../Files/leeSIk/README.md'),
('c', 'ET3', 'PfiFCW', 0, '../Files/PfiFCW/README.md'),
('d', 'ET1', 'IuxC9f', 0, '../Files/IuxC9f/README.md'),
('d', 'ET2', 'MvA6DR', 0, '../Files/MvA6DR/README.md'),
('d', 'ET3', '9eTUyd', 0, '../Files/9eTUyd/README.md'),
('e', 'ET1', 'oeNLkK', 0, '../Files/oeNLkK/README.md'),
('e', 'ET2', 'k4vBp', 0, '../Files/k4vBp/README.md'),
('e', 'ET3', '6WNzpx', 0, '../Files/6WNzpx/README.md'),
('f', 'ET1', 'xDrXf1', 0, '../Files/xDrXf1/README.md'),
('f', 'ET2', 'M9gGjp', 0, '../Files/M9gGjp/README.md'),
('f', 'ET3', 'YiVkXq', 0, '../Files/YiVkXq/README.md');

INSERT INTO `ASIGNAC_QA` (`IdTrabajo`, `LoginEvaluador`, `LoginEvaluado`, `AliasEvaluado`) VALUES
('QA1', 'a', 'b', 'BWlZi8'),
('QA1', 'a', 'd', 'IuxC9f'),
('QA1', 'a', 'c', 'j3aiZ8'),
('QA1', 'a', 'e', 'oeNLkK'),
('QA1', 'a', 'f', 'xDrXf1'),
('QA1', 'b', 'd', 'IuxC9f'),
('QA1', 'b', 'c', 'j3aiZ8'),
('QA1', 'b', 'e', 'oeNLkK'),
('QA1', 'b', 'a', 'ucJjSo'),
('QA1', 'b', 'f', 'xDrXf1'),
('QA1', 'c', 'b', 'BWlZi8'),
('QA1', 'c', 'd', 'IuxC9f'),
('QA1', 'c', 'e', 'oeNLkK'),
('QA1', 'c', 'a', 'ucJjSo'),
('QA1', 'c', 'f', 'xDrXf1'),
('QA1', 'd', 'b', 'BWlZi8'),
('QA1', 'd', 'c', 'j3aiZ8'),
('QA1', 'd', 'e', 'oeNLkK'),
('QA1', 'd', 'a', 'ucJjSo'),
('QA1', 'd', 'f', 'xDrXf1'),
('QA1', 'e', 'b', 'BWlZi8'),
('QA1', 'e', 'd', 'IuxC9f'),
('QA1', 'e', 'c', 'j3aiZ8'),
('QA1', 'e', 'a', 'ucJjSo'),
('QA1', 'e', 'f', 'xDrXf1'),
('QA1', 'f', 'b', 'BWlZi8'),
('QA1', 'f', 'd', 'IuxC9f'),
('QA1', 'f', 'c', 'j3aiZ8'),
('QA1', 'f', 'e', 'oeNLkK'),
('QA1', 'f', 'a', 'ucJjSo'),
('QA2', 'a', 'b', 'EWLJLg'),
('QA2', 'a', 'e', 'k4vBp'),
('QA2', 'a', 'c', 'leeSIk'),
('QA2', 'a', 'f', 'M9gGjp'),
('QA2', 'a', 'd', 'MvA6DR'),
('QA2', 'b', 'e', 'k4vBp'),
('QA2', 'b', 'a', 'l3MxL9'),
('QA2', 'b', 'c', 'leeSIk'),
('QA2', 'b', 'f', 'M9gGjp'),
('QA2', 'b', 'd', 'MvA6DR'),
('QA2', 'c', 'b', 'EWLJLg'),
('QA2', 'c', 'e', 'k4vBp'),
('QA2', 'c', 'a', 'l3MxL9'),
('QA2', 'c', 'f', 'M9gGjp'),
('QA2', 'c', 'd', 'MvA6DR'),
('QA2', 'd', 'b', 'EWLJLg'),
('QA2', 'd', 'e', 'k4vBp'),
('QA2', 'd', 'a', 'l3MxL9'),
('QA2', 'd', 'c', 'leeSIk'),
('QA2', 'd', 'f', 'M9gGjp'),
('QA2', 'e', 'b', 'EWLJLg'),
('QA2', 'e', 'a', 'l3MxL9'),
('QA2', 'e', 'c', 'leeSIk'),
('QA2', 'e', 'f', 'M9gGjp'),
('QA2', 'e', 'd', 'MvA6DR'),
('QA2', 'f', 'b', 'EWLJLg'),
('QA2', 'f', 'e', 'k4vBp'),
('QA2', 'f', 'a', 'l3MxL9'),
('QA2', 'f', 'c', 'leeSIk'),
('QA2', 'f', 'd', 'MvA6DR'),
('QA3', 'a', 'e', '6WNzpx'),
('QA3', 'a', 'd', '9eTUyd'),
('QA3', 'a', 'b', 'MoELRr'),
('QA3', 'a', 'c', 'PfiFCW'),
('QA3', 'a', 'f', 'YiVkXq'),
('QA3', 'b', 'e', '6WNzpx'),
('QA3', 'b', 'd', '9eTUyd'),
('QA3', 'b', 'c', 'PfiFCW'),
('QA3', 'b', 'a', 'SQIe3G'),
('QA3', 'b', 'f', 'YiVkXq'),
('QA3', 'c', 'e', '6WNzpx'),
('QA3', 'c', 'd', '9eTUyd'),
('QA3', 'c', 'b', 'MoELRr'),
('QA3', 'c', 'a', 'SQIe3G'),
('QA3', 'c', 'f', 'YiVkXq'),
('QA3', 'd', 'e', '6WNzpx'),
('QA3', 'd', 'b', 'MoELRr'),
('QA3', 'd', 'c', 'PfiFCW'),
('QA3', 'd', 'a', 'SQIe3G'),
('QA3', 'd', 'f', 'YiVkXq'),
('QA3', 'e', 'd', '9eTUyd'),
('QA3', 'e', 'b', 'MoELRr'),
('QA3', 'e', 'c', 'PfiFCW'),
('QA3', 'e', 'a', 'SQIe3G'),
('QA3', 'e', 'f', 'YiVkXq'),
('QA3', 'f', 'e', '6WNzpx'),
('QA3', 'f', 'd', '9eTUyd'),
('QA3', 'f', 'b', 'MoELRr'),
('QA3', 'f', 'c', 'PfiFCW'),
('QA3', 'f', 'a', 'SQIe3G');
  

INSERT INTO `EVALUACION` (`IdTrabajo`, `LoginEvaluador`, `AliasEvaluado`, `IdHistoria`, `CorrectoA`, `ComenIncorrectoA`, `CorrectoP`, `ComentIncorrectoP`, `OK`) VALUES
('QA1', 'a', 'BWlZi8', 0, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'BWlZi8', 1, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'BWlZi8', 2, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'BWlZi8', 3, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'BWlZi8', 4, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'BWlZi8', 5, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'BWlZi8', 6, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'BWlZi8', 7, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'BWlZi8', 8, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'BWlZi8', 9, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'BWlZi8', 0, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'BWlZi8', 1, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'BWlZi8', 2, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'BWlZi8', 3, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'BWlZi8', 4, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'BWlZi8', 5, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'BWlZi8', 6, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'BWlZi8', 7, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'BWlZi8', 8, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'BWlZi8', 9, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'BWlZi8', 0, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'BWlZi8', 1, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'BWlZi8', 2, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'BWlZi8', 3, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'BWlZi8', 4, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'BWlZi8', 5, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'BWlZi8', 6, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'BWlZi8', 7, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'BWlZi8', 8, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'BWlZi8', 9, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'BWlZi8', 0, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'BWlZi8', 1, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'BWlZi8', 2, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'BWlZi8', 3, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'BWlZi8', 4, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'BWlZi8', 5, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'BWlZi8', 6, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'BWlZi8', 7, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'BWlZi8', 8, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'BWlZi8', 9, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'BWlZi8', 0, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'BWlZi8', 1, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'BWlZi8', 2, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'BWlZi8', 3, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'BWlZi8', 4, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'BWlZi8', 5, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'BWlZi8', 6, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'BWlZi8', 7, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'BWlZi8', 8, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'BWlZi8', 9, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'IuxC9f', 0, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'IuxC9f', 1, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'IuxC9f', 2, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'IuxC9f', 3, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'IuxC9f', 4, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'IuxC9f', 5, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'IuxC9f', 6, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'IuxC9f', 7, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'IuxC9f', 8, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'IuxC9f', 9, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'IuxC9f', 0, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'IuxC9f', 1, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'IuxC9f', 2, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'IuxC9f', 3, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'IuxC9f', 4, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'IuxC9f', 5, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'IuxC9f', 6, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'IuxC9f', 7, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'IuxC9f', 8, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'IuxC9f', 9, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'IuxC9f', 0, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'IuxC9f', 1, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'IuxC9f', 2, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'IuxC9f', 3, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'IuxC9f', 4, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'IuxC9f', 5, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'IuxC9f', 6, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'IuxC9f', 7, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'IuxC9f', 8, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'IuxC9f', 9, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'IuxC9f', 0, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'IuxC9f', 1, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'IuxC9f', 2, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'IuxC9f', 3, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'IuxC9f', 4, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'IuxC9f', 5, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'IuxC9f', 6, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'IuxC9f', 7, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'IuxC9f', 8, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'IuxC9f', 9, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'IuxC9f', 0, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'IuxC9f', 1, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'IuxC9f', 2, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'IuxC9f', 3, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'IuxC9f', 4, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'IuxC9f', 5, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'IuxC9f', 6, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'IuxC9f', 7, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'IuxC9f', 8, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'IuxC9f', 9, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'j3aiZ8', 0, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'j3aiZ8', 1, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'j3aiZ8', 2, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'j3aiZ8', 3, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'j3aiZ8', 4, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'j3aiZ8', 5, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'j3aiZ8', 6, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'j3aiZ8', 7, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'j3aiZ8', 8, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'j3aiZ8', 9, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'j3aiZ8', 0, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'j3aiZ8', 1, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'j3aiZ8', 2, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'j3aiZ8', 3, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'j3aiZ8', 4, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'j3aiZ8', 5, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'j3aiZ8', 6, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'j3aiZ8', 7, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'j3aiZ8', 8, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'j3aiZ8', 9, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'j3aiZ8', 0, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'j3aiZ8', 1, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'j3aiZ8', 2, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'j3aiZ8', 3, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'j3aiZ8', 4, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'j3aiZ8', 5, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'j3aiZ8', 6, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'j3aiZ8', 7, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'j3aiZ8', 8, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'j3aiZ8', 9, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'j3aiZ8', 0, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'j3aiZ8', 1, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'j3aiZ8', 2, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'j3aiZ8', 3, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'j3aiZ8', 4, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'j3aiZ8', 5, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'j3aiZ8', 6, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'j3aiZ8', 7, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'j3aiZ8', 8, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'j3aiZ8', 9, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'j3aiZ8', 0, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'j3aiZ8', 1, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'j3aiZ8', 2, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'j3aiZ8', 3, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'j3aiZ8', 4, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'j3aiZ8', 5, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'j3aiZ8', 6, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'j3aiZ8', 7, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'j3aiZ8', 8, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'j3aiZ8', 9, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'oeNLkK', 0, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'oeNLkK', 1, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'oeNLkK', 2, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'oeNLkK', 3, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'oeNLkK', 4, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'oeNLkK', 5, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'oeNLkK', 6, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'oeNLkK', 7, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'oeNLkK', 8, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'oeNLkK', 9, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'oeNLkK', 0, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'oeNLkK', 1, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'oeNLkK', 2, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'oeNLkK', 3, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'oeNLkK', 4, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'oeNLkK', 5, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'oeNLkK', 6, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'oeNLkK', 7, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'oeNLkK', 8, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'oeNLkK', 9, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'oeNLkK', 0, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'oeNLkK', 1, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'oeNLkK', 2, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'oeNLkK', 3, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'oeNLkK', 4, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'oeNLkK', 5, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'oeNLkK', 6, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'oeNLkK', 7, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'oeNLkK', 8, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'oeNLkK', 9, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'oeNLkK', 0, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'oeNLkK', 1, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'oeNLkK', 2, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'oeNLkK', 3, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'oeNLkK', 4, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'oeNLkK', 5, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'oeNLkK', 6, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'oeNLkK', 7, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'oeNLkK', 8, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'oeNLkK', 9, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'oeNLkK', 0, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'oeNLkK', 1, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'oeNLkK', 2, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'oeNLkK', 3, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'oeNLkK', 4, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'oeNLkK', 5, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'oeNLkK', 6, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'oeNLkK', 7, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'oeNLkK', 8, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'oeNLkK', 9, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'ucJjSo', 0, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'ucJjSo', 1, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'ucJjSo', 2, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'ucJjSo', 3, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'ucJjSo', 4, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'ucJjSo', 5, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'ucJjSo', 6, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'ucJjSo', 7, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'ucJjSo', 8, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'ucJjSo', 9, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'ucJjSo', 0, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'ucJjSo', 1, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'ucJjSo', 2, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'ucJjSo', 3, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'ucJjSo', 4, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'ucJjSo', 5, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'ucJjSo', 6, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'ucJjSo', 7, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'ucJjSo', 8, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'ucJjSo', 9, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'ucJjSo', 0, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'ucJjSo', 1, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'ucJjSo', 2, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'ucJjSo', 3, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'ucJjSo', 4, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'ucJjSo', 5, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'ucJjSo', 6, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'ucJjSo', 7, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'ucJjSo', 8, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'ucJjSo', 9, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'ucJjSo', 0, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'ucJjSo', 1, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'ucJjSo', 2, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'ucJjSo', 3, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'ucJjSo', 4, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'ucJjSo', 5, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'ucJjSo', 6, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'ucJjSo', 7, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'ucJjSo', 8, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'ucJjSo', 9, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'ucJjSo', 0, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'ucJjSo', 1, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'ucJjSo', 2, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'ucJjSo', 3, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'ucJjSo', 4, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'ucJjSo', 5, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'ucJjSo', 6, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'ucJjSo', 7, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'ucJjSo', 8, 2, ' ', 2, ' ', 2),
('QA1', 'f', 'ucJjSo', 9, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'xDrXf1', 0, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'xDrXf1', 1, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'xDrXf1', 2, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'xDrXf1', 3, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'xDrXf1', 4, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'xDrXf1', 5, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'xDrXf1', 6, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'xDrXf1', 7, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'xDrXf1', 8, 2, ' ', 2, ' ', 2),
('QA1', 'a', 'xDrXf1', 9, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'xDrXf1', 0, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'xDrXf1', 1, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'xDrXf1', 2, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'xDrXf1', 3, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'xDrXf1', 4, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'xDrXf1', 5, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'xDrXf1', 6, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'xDrXf1', 7, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'xDrXf1', 8, 2, ' ', 2, ' ', 2),
('QA1', 'b', 'xDrXf1', 9, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'xDrXf1', 0, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'xDrXf1', 1, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'xDrXf1', 2, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'xDrXf1', 3, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'xDrXf1', 4, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'xDrXf1', 5, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'xDrXf1', 6, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'xDrXf1', 7, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'xDrXf1', 8, 2, ' ', 2, ' ', 2),
('QA1', 'c', 'xDrXf1', 9, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'xDrXf1', 0, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'xDrXf1', 1, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'xDrXf1', 2, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'xDrXf1', 3, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'xDrXf1', 4, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'xDrXf1', 5, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'xDrXf1', 6, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'xDrXf1', 7, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'xDrXf1', 8, 2, ' ', 2, ' ', 2),
('QA1', 'd', 'xDrXf1', 9, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'xDrXf1', 0, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'xDrXf1', 1, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'xDrXf1', 2, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'xDrXf1', 3, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'xDrXf1', 4, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'xDrXf1', 5, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'xDrXf1', 6, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'xDrXf1', 7, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'xDrXf1', 8, 2, ' ', 2, ' ', 2),
('QA1', 'e', 'xDrXf1', 9, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'EWLJLg', 0, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'EWLJLg', 1, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'EWLJLg', 2, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'EWLJLg', 3, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'EWLJLg', 4, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'EWLJLg', 5, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'EWLJLg', 6, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'EWLJLg', 7, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'EWLJLg', 8, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'EWLJLg', 9, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'EWLJLg', 0, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'EWLJLg', 1, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'EWLJLg', 2, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'EWLJLg', 3, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'EWLJLg', 4, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'EWLJLg', 5, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'EWLJLg', 6, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'EWLJLg', 7, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'EWLJLg', 8, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'EWLJLg', 9, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'EWLJLg', 0, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'EWLJLg', 1, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'EWLJLg', 2, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'EWLJLg', 3, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'EWLJLg', 4, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'EWLJLg', 5, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'EWLJLg', 6, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'EWLJLg', 7, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'EWLJLg', 8, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'EWLJLg', 9, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'EWLJLg', 0, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'EWLJLg', 1, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'EWLJLg', 2, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'EWLJLg', 3, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'EWLJLg', 4, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'EWLJLg', 5, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'EWLJLg', 6, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'EWLJLg', 7, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'EWLJLg', 8, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'EWLJLg', 9, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'EWLJLg', 0, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'EWLJLg', 1, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'EWLJLg', 2, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'EWLJLg', 3, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'EWLJLg', 4, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'EWLJLg', 5, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'EWLJLg', 6, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'EWLJLg', 7, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'EWLJLg', 8, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'EWLJLg', 9, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'k4vBp', 0, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'k4vBp', 1, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'k4vBp', 2, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'k4vBp', 3, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'k4vBp', 4, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'k4vBp', 5, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'k4vBp', 6, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'k4vBp', 7, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'k4vBp', 8, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'k4vBp', 9, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'k4vBp', 0, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'k4vBp', 1, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'k4vBp', 2, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'k4vBp', 3, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'k4vBp', 4, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'k4vBp', 5, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'k4vBp', 6, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'k4vBp', 7, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'k4vBp', 8, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'k4vBp', 9, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'k4vBp', 0, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'k4vBp', 1, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'k4vBp', 2, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'k4vBp', 3, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'k4vBp', 4, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'k4vBp', 5, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'k4vBp', 6, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'k4vBp', 7, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'k4vBp', 8, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'k4vBp', 9, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'k4vBp', 0, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'k4vBp', 1, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'k4vBp', 2, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'k4vBp', 3, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'k4vBp', 4, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'k4vBp', 5, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'k4vBp', 6, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'k4vBp', 7, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'k4vBp', 8, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'k4vBp', 9, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'k4vBp', 0, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'k4vBp', 1, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'k4vBp', 2, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'k4vBp', 3, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'k4vBp', 4, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'k4vBp', 5, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'k4vBp', 6, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'k4vBp', 7, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'k4vBp', 8, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'k4vBp', 9, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'l3MxL9', 0, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'l3MxL9', 1, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'l3MxL9', 2, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'l3MxL9', 3, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'l3MxL9', 4, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'l3MxL9', 5, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'l3MxL9', 6, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'l3MxL9', 7, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'l3MxL9', 8, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'l3MxL9', 9, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'l3MxL9', 0, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'l3MxL9', 1, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'l3MxL9', 2, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'l3MxL9', 3, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'l3MxL9', 4, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'l3MxL9', 5, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'l3MxL9', 6, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'l3MxL9', 7, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'l3MxL9', 8, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'l3MxL9', 9, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'l3MxL9', 0, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'l3MxL9', 1, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'l3MxL9', 2, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'l3MxL9', 3, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'l3MxL9', 4, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'l3MxL9', 5, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'l3MxL9', 6, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'l3MxL9', 7, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'l3MxL9', 8, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'l3MxL9', 9, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'l3MxL9', 0, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'l3MxL9', 1, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'l3MxL9', 2, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'l3MxL9', 3, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'l3MxL9', 4, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'l3MxL9', 5, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'l3MxL9', 6, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'l3MxL9', 7, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'l3MxL9', 8, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'l3MxL9', 9, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'l3MxL9', 0, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'l3MxL9', 1, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'l3MxL9', 2, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'l3MxL9', 3, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'l3MxL9', 4, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'l3MxL9', 5, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'l3MxL9', 6, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'l3MxL9', 7, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'l3MxL9', 8, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'l3MxL9', 9, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'leeSIk', 0, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'leeSIk', 1, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'leeSIk', 2, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'leeSIk', 3, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'leeSIk', 4, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'leeSIk', 5, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'leeSIk', 6, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'leeSIk', 7, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'leeSIk', 8, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'leeSIk', 9, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'leeSIk', 0, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'leeSIk', 1, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'leeSIk', 2, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'leeSIk', 3, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'leeSIk', 4, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'leeSIk', 5, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'leeSIk', 6, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'leeSIk', 7, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'leeSIk', 8, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'leeSIk', 9, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'leeSIk', 0, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'leeSIk', 1, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'leeSIk', 2, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'leeSIk', 3, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'leeSIk', 4, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'leeSIk', 5, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'leeSIk', 6, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'leeSIk', 7, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'leeSIk', 8, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'leeSIk', 9, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'leeSIk', 0, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'leeSIk', 1, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'leeSIk', 2, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'leeSIk', 3, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'leeSIk', 4, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'leeSIk', 5, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'leeSIk', 6, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'leeSIk', 7, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'leeSIk', 8, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'leeSIk', 9, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'leeSIk', 0, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'leeSIk', 1, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'leeSIk', 2, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'leeSIk', 3, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'leeSIk', 4, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'leeSIk', 5, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'leeSIk', 6, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'leeSIk', 7, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'leeSIk', 8, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'leeSIk', 9, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'M9gGjp', 0, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'M9gGjp', 1, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'M9gGjp', 2, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'M9gGjp', 3, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'M9gGjp', 4, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'M9gGjp', 5, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'M9gGjp', 6, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'M9gGjp', 7, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'M9gGjp', 8, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'M9gGjp', 9, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'M9gGjp', 0, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'M9gGjp', 1, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'M9gGjp', 2, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'M9gGjp', 3, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'M9gGjp', 4, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'M9gGjp', 5, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'M9gGjp', 6, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'M9gGjp', 7, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'M9gGjp', 8, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'M9gGjp', 9, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'M9gGjp', 0, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'M9gGjp', 1, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'M9gGjp', 2, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'M9gGjp', 3, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'M9gGjp', 4, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'M9gGjp', 5, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'M9gGjp', 6, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'M9gGjp', 7, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'M9gGjp', 8, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'M9gGjp', 9, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'M9gGjp', 0, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'M9gGjp', 1, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'M9gGjp', 2, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'M9gGjp', 3, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'M9gGjp', 4, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'M9gGjp', 5, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'M9gGjp', 6, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'M9gGjp', 7, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'M9gGjp', 8, 2, ' ', 2, ' ', 2),
('QA2', 'd', 'M9gGjp', 9, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'M9gGjp', 0, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'M9gGjp', 1, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'M9gGjp', 2, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'M9gGjp', 3, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'M9gGjp', 4, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'M9gGjp', 5, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'M9gGjp', 6, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'M9gGjp', 7, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'M9gGjp', 8, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'M9gGjp', 9, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'MvA6DR', 0, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'MvA6DR', 1, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'MvA6DR', 2, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'MvA6DR', 3, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'MvA6DR', 4, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'MvA6DR', 5, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'MvA6DR', 6, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'MvA6DR', 7, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'MvA6DR', 8, 2, ' ', 2, ' ', 2),
('QA2', 'a', 'MvA6DR', 9, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'MvA6DR', 0, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'MvA6DR', 1, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'MvA6DR', 2, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'MvA6DR', 3, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'MvA6DR', 4, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'MvA6DR', 5, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'MvA6DR', 6, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'MvA6DR', 7, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'MvA6DR', 8, 2, ' ', 2, ' ', 2),
('QA2', 'b', 'MvA6DR', 9, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'MvA6DR', 0, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'MvA6DR', 1, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'MvA6DR', 2, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'MvA6DR', 3, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'MvA6DR', 4, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'MvA6DR', 5, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'MvA6DR', 6, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'MvA6DR', 7, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'MvA6DR', 8, 2, ' ', 2, ' ', 2),
('QA2', 'c', 'MvA6DR', 9, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'MvA6DR', 0, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'MvA6DR', 1, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'MvA6DR', 2, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'MvA6DR', 3, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'MvA6DR', 4, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'MvA6DR', 5, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'MvA6DR', 6, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'MvA6DR', 7, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'MvA6DR', 8, 2, ' ', 2, ' ', 2),
('QA2', 'e', 'MvA6DR', 9, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'MvA6DR', 0, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'MvA6DR', 1, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'MvA6DR', 2, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'MvA6DR', 3, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'MvA6DR', 4, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'MvA6DR', 5, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'MvA6DR', 6, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'MvA6DR', 7, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'MvA6DR', 8, 2, ' ', 2, ' ', 2),
('QA2', 'f', 'MvA6DR', 9, 2, ' ', 2, ' ', 2),
('QA3', 'a', '6WNzpx', 0, 2, ' ', 2, ' ', 2),
('QA3', 'a', '6WNzpx', 1, 2, ' ', 2, ' ', 2),
('QA3', 'a', '6WNzpx', 2, 2, ' ', 2, ' ', 2),
('QA3', 'a', '6WNzpx', 3, 2, ' ', 2, ' ', 2),
('QA3', 'a', '6WNzpx', 4, 2, ' ', 2, ' ', 2),
('QA3', 'a', '6WNzpx', 5, 2, ' ', 2, ' ', 2),
('QA3', 'a', '6WNzpx', 6, 2, ' ', 2, ' ', 2),
('QA3', 'a', '6WNzpx', 7, 2, ' ', 2, ' ', 2),
('QA3', 'a', '6WNzpx', 8, 2, ' ', 2, ' ', 2),
('QA3', 'a', '6WNzpx', 9, 2, ' ', 2, ' ', 2),
('QA3', 'b', '6WNzpx', 0, 2, ' ', 2, ' ', 2),
('QA3', 'b', '6WNzpx', 1, 2, ' ', 2, ' ', 2),
('QA3', 'b', '6WNzpx', 2, 2, ' ', 2, ' ', 2),
('QA3', 'b', '6WNzpx', 3, 2, ' ', 2, ' ', 2),
('QA3', 'b', '6WNzpx', 4, 2, ' ', 2, ' ', 2),
('QA3', 'b', '6WNzpx', 5, 2, ' ', 2, ' ', 2),
('QA3', 'b', '6WNzpx', 6, 2, ' ', 2, ' ', 2),
('QA3', 'b', '6WNzpx', 7, 2, ' ', 2, ' ', 2),
('QA3', 'b', '6WNzpx', 8, 2, ' ', 2, ' ', 2),
('QA3', 'b', '6WNzpx', 9, 2, ' ', 2, ' ', 2),
('QA3', 'c', '6WNzpx', 0, 2, ' ', 2, ' ', 2),
('QA3', 'c', '6WNzpx', 1, 2, ' ', 2, ' ', 2),
('QA3', 'c', '6WNzpx', 2, 2, ' ', 2, ' ', 2),
('QA3', 'c', '6WNzpx', 3, 2, ' ', 2, ' ', 2),
('QA3', 'c', '6WNzpx', 4, 2, ' ', 2, ' ', 2),
('QA3', 'c', '6WNzpx', 5, 2, ' ', 2, ' ', 2),
('QA3', 'c', '6WNzpx', 6, 2, ' ', 2, ' ', 2),
('QA3', 'c', '6WNzpx', 7, 2, ' ', 2, ' ', 2),
('QA3', 'c', '6WNzpx', 8, 2, ' ', 2, ' ', 2),
('QA3', 'c', '6WNzpx', 9, 2, ' ', 2, ' ', 2),
('QA3', 'd', '6WNzpx', 0, 2, ' ', 2, ' ', 2),
('QA3', 'd', '6WNzpx', 1, 2, ' ', 2, ' ', 2),
('QA3', 'd', '6WNzpx', 2, 2, ' ', 2, ' ', 2),
('QA3', 'd', '6WNzpx', 3, 2, ' ', 2, ' ', 2),
('QA3', 'd', '6WNzpx', 4, 2, ' ', 2, ' ', 2),
('QA3', 'd', '6WNzpx', 5, 2, ' ', 2, ' ', 2),
('QA3', 'd', '6WNzpx', 6, 2, ' ', 2, ' ', 2),
('QA3', 'd', '6WNzpx', 7, 2, ' ', 2, ' ', 2),
('QA3', 'd', '6WNzpx', 8, 2, ' ', 2, ' ', 2),
('QA3', 'd', '6WNzpx', 9, 2, ' ', 2, ' ', 2),
('QA3', 'f', '6WNzpx', 0, 2, ' ', 2, ' ', 2),
('QA3', 'f', '6WNzpx', 1, 2, ' ', 2, ' ', 2),
('QA3', 'f', '6WNzpx', 2, 2, ' ', 2, ' ', 2),
('QA3', 'f', '6WNzpx', 3, 2, ' ', 2, ' ', 2),
('QA3', 'f', '6WNzpx', 4, 2, ' ', 2, ' ', 2),
('QA3', 'f', '6WNzpx', 5, 2, ' ', 2, ' ', 2),
('QA3', 'f', '6WNzpx', 6, 2, ' ', 2, ' ', 2),
('QA3', 'f', '6WNzpx', 7, 2, ' ', 2, ' ', 2),
('QA3', 'f', '6WNzpx', 8, 2, ' ', 2, ' ', 2),
('QA3', 'f', '6WNzpx', 9, 2, ' ', 2, ' ', 2),
('QA3', 'a', '9eTUyd', 0, 2, ' ', 2, ' ', 2),
('QA3', 'a', '9eTUyd', 1, 2, ' ', 2, ' ', 2),
('QA3', 'a', '9eTUyd', 2, 2, ' ', 2, ' ', 2),
('QA3', 'a', '9eTUyd', 3, 2, ' ', 2, ' ', 2),
('QA3', 'a', '9eTUyd', 4, 2, ' ', 2, ' ', 2),
('QA3', 'a', '9eTUyd', 5, 2, ' ', 2, ' ', 2),
('QA3', 'a', '9eTUyd', 6, 2, ' ', 2, ' ', 2),
('QA3', 'a', '9eTUyd', 7, 2, ' ', 2, ' ', 2),
('QA3', 'a', '9eTUyd', 8, 2, ' ', 2, ' ', 2),
('QA3', 'a', '9eTUyd', 9, 2, ' ', 2, ' ', 2),
('QA3', 'b', '9eTUyd', 0, 2, ' ', 2, ' ', 2),
('QA3', 'b', '9eTUyd', 1, 2, ' ', 2, ' ', 2),
('QA3', 'b', '9eTUyd', 2, 2, ' ', 2, ' ', 2),
('QA3', 'b', '9eTUyd', 3, 2, ' ', 2, ' ', 2),
('QA3', 'b', '9eTUyd', 4, 2, ' ', 2, ' ', 2),
('QA3', 'b', '9eTUyd', 5, 2, ' ', 2, ' ', 2),
('QA3', 'b', '9eTUyd', 6, 2, ' ', 2, ' ', 2),
('QA3', 'b', '9eTUyd', 7, 2, ' ', 2, ' ', 2),
('QA3', 'b', '9eTUyd', 8, 2, ' ', 2, ' ', 2),
('QA3', 'b', '9eTUyd', 9, 2, ' ', 2, ' ', 2),
('QA3', 'c', '9eTUyd', 0, 2, ' ', 2, ' ', 2),
('QA3', 'c', '9eTUyd', 1, 2, ' ', 2, ' ', 2),
('QA3', 'c', '9eTUyd', 2, 2, ' ', 2, ' ', 2),
('QA3', 'c', '9eTUyd', 3, 2, ' ', 2, ' ', 2),
('QA3', 'c', '9eTUyd', 4, 2, ' ', 2, ' ', 2),
('QA3', 'c', '9eTUyd', 5, 2, ' ', 2, ' ', 2),
('QA3', 'c', '9eTUyd', 6, 2, ' ', 2, ' ', 2),
('QA3', 'c', '9eTUyd', 7, 2, ' ', 2, ' ', 2),
('QA3', 'c', '9eTUyd', 8, 2, ' ', 2, ' ', 2),
('QA3', 'c', '9eTUyd', 9, 2, ' ', 2, ' ', 2),
('QA3', 'e', '9eTUyd', 0, 2, ' ', 2, ' ', 2),
('QA3', 'e', '9eTUyd', 1, 2, ' ', 2, ' ', 2),
('QA3', 'e', '9eTUyd', 2, 2, ' ', 2, ' ', 2),
('QA3', 'e', '9eTUyd', 3, 2, ' ', 2, ' ', 2),
('QA3', 'e', '9eTUyd', 4, 2, ' ', 2, ' ', 2),
('QA3', 'e', '9eTUyd', 5, 2, ' ', 2, ' ', 2),
('QA3', 'e', '9eTUyd', 6, 2, ' ', 2, ' ', 2),
('QA3', 'e', '9eTUyd', 7, 2, ' ', 2, ' ', 2),
('QA3', 'e', '9eTUyd', 8, 2, ' ', 2, ' ', 2),
('QA3', 'e', '9eTUyd', 9, 2, ' ', 2, ' ', 2),
('QA3', 'f', '9eTUyd', 0, 2, ' ', 2, ' ', 2),
('QA3', 'f', '9eTUyd', 1, 2, ' ', 2, ' ', 2),
('QA3', 'f', '9eTUyd', 2, 2, ' ', 2, ' ', 2),
('QA3', 'f', '9eTUyd', 3, 2, ' ', 2, ' ', 2),
('QA3', 'f', '9eTUyd', 4, 2, ' ', 2, ' ', 2),
('QA3', 'f', '9eTUyd', 5, 2, ' ', 2, ' ', 2),
('QA3', 'f', '9eTUyd', 6, 2, ' ', 2, ' ', 2),
('QA3', 'f', '9eTUyd', 7, 2, ' ', 2, ' ', 2),
('QA3', 'f', '9eTUyd', 8, 2, ' ', 2, ' ', 2),
('QA3', 'f', '9eTUyd', 9, 2, ' ', 2, ' ', 2),
('QA3', 'a', 'MoELRr', 0, 2, ' ', 2, ' ', 2),
('QA3', 'a', 'MoELRr', 1, 2, ' ', 2, ' ', 2),
('QA3', 'a', 'MoELRr', 2, 2, ' ', 2, ' ', 2),
('QA3', 'a', 'MoELRr', 3, 2, ' ', 2, ' ', 2),
('QA3', 'a', 'MoELRr', 4, 2, ' ', 2, ' ', 2),
('QA3', 'a', 'MoELRr', 5, 2, ' ', 2, ' ', 2),
('QA3', 'a', 'MoELRr', 6, 2, ' ', 2, ' ', 2),
('QA3', 'a', 'MoELRr', 7, 2, ' ', 2, ' ', 2),
('QA3', 'a', 'MoELRr', 8, 2, ' ', 2, ' ', 2),
('QA3', 'a', 'MoELRr', 9, 2, ' ', 2, ' ', 2),
('QA3', 'c', 'MoELRr', 0, 2, ' ', 2, ' ', 2),
('QA3', 'c', 'MoELRr', 1, 2, ' ', 2, ' ', 2),
('QA3', 'c', 'MoELRr', 2, 2, ' ', 2, ' ', 2),
('QA3', 'c', 'MoELRr', 3, 2, ' ', 2, ' ', 2),
('QA3', 'c', 'MoELRr', 4, 2, ' ', 2, ' ', 2),
('QA3', 'c', 'MoELRr', 5, 2, ' ', 2, ' ', 2),
('QA3', 'c', 'MoELRr', 6, 2, ' ', 2, ' ', 2),
('QA3', 'c', 'MoELRr', 7, 2, ' ', 2, ' ', 2),
('QA3', 'c', 'MoELRr', 8, 2, ' ', 2, ' ', 2),
('QA3', 'c', 'MoELRr', 9, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'MoELRr', 0, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'MoELRr', 1, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'MoELRr', 2, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'MoELRr', 3, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'MoELRr', 4, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'MoELRr', 5, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'MoELRr', 6, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'MoELRr', 7, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'MoELRr', 8, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'MoELRr', 9, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'MoELRr', 0, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'MoELRr', 1, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'MoELRr', 2, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'MoELRr', 3, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'MoELRr', 4, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'MoELRr', 5, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'MoELRr', 6, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'MoELRr', 7, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'MoELRr', 8, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'MoELRr', 9, 2, ' ', 2, ' ', 2),
('QA3', 'f', 'MoELRr', 0, 2, ' ', 2, ' ', 2),
('QA3', 'f', 'MoELRr', 1, 2, ' ', 2, ' ', 2),
('QA3', 'f', 'MoELRr', 2, 2, ' ', 2, ' ', 2),
('QA3', 'f', 'MoELRr', 3, 2, ' ', 2, ' ', 2),
('QA3', 'f', 'MoELRr', 4, 2, ' ', 2, ' ', 2),
('QA3', 'f', 'MoELRr', 5, 2, ' ', 2, ' ', 2),
('QA3', 'f', 'MoELRr', 6, 2, ' ', 2, ' ', 2),
('QA3', 'f', 'MoELRr', 7, 2, ' ', 2, ' ', 2),
('QA3', 'f', 'MoELRr', 8, 2, ' ', 2, ' ', 2),
('QA3', 'f', 'MoELRr', 9, 2, ' ', 2, ' ', 2),
('QA3', 'a', 'PfiFCW', 0, 2, ' ', 2, ' ', 2),
('QA3', 'a', 'PfiFCW', 1, 2, ' ', 2, ' ', 2),
('QA3', 'a', 'PfiFCW', 2, 2, ' ', 2, ' ', 2),
('QA3', 'a', 'PfiFCW', 3, 2, ' ', 2, ' ', 2),
('QA3', 'a', 'PfiFCW', 4, 2, ' ', 2, ' ', 2),
('QA3', 'a', 'PfiFCW', 5, 2, ' ', 2, ' ', 2),
('QA3', 'a', 'PfiFCW', 6, 2, ' ', 2, ' ', 2),
('QA3', 'a', 'PfiFCW', 7, 2, ' ', 2, ' ', 2),
('QA3', 'a', 'PfiFCW', 8, 2, ' ', 2, ' ', 2),
('QA3', 'a', 'PfiFCW', 9, 2, ' ', 2, ' ', 2),
('QA3', 'b', 'PfiFCW', 0, 2, ' ', 2, ' ', 2),
('QA3', 'b', 'PfiFCW', 1, 2, ' ', 2, ' ', 2),
('QA3', 'b', 'PfiFCW', 2, 2, ' ', 2, ' ', 2),
('QA3', 'b', 'PfiFCW', 3, 2, ' ', 2, ' ', 2),
('QA3', 'b', 'PfiFCW', 4, 2, ' ', 2, ' ', 2),
('QA3', 'b', 'PfiFCW', 5, 2, ' ', 2, ' ', 2),
('QA3', 'b', 'PfiFCW', 6, 2, ' ', 2, ' ', 2),
('QA3', 'b', 'PfiFCW', 7, 2, ' ', 2, ' ', 2),
('QA3', 'b', 'PfiFCW', 8, 2, ' ', 2, ' ', 2),
('QA3', 'b', 'PfiFCW', 9, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'PfiFCW', 0, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'PfiFCW', 1, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'PfiFCW', 2, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'PfiFCW', 3, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'PfiFCW', 4, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'PfiFCW', 5, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'PfiFCW', 6, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'PfiFCW', 7, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'PfiFCW', 8, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'PfiFCW', 9, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'PfiFCW', 0, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'PfiFCW', 1, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'PfiFCW', 2, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'PfiFCW', 3, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'PfiFCW', 4, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'PfiFCW', 5, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'PfiFCW', 6, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'PfiFCW', 7, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'PfiFCW', 8, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'PfiFCW', 9, 2, ' ', 2, ' ', 2),
('QA3', 'f', 'PfiFCW', 0, 2, ' ', 2, ' ', 2),
('QA3', 'f', 'PfiFCW', 1, 2, ' ', 2, ' ', 2),
('QA3', 'f', 'PfiFCW', 2, 2, ' ', 2, ' ', 2),
('QA3', 'f', 'PfiFCW', 3, 2, ' ', 2, ' ', 2),
('QA3', 'f', 'PfiFCW', 4, 2, ' ', 2, ' ', 2),
('QA3', 'f', 'PfiFCW', 5, 2, ' ', 2, ' ', 2),
('QA3', 'f', 'PfiFCW', 6, 2, ' ', 2, ' ', 2),
('QA3', 'f', 'PfiFCW', 7, 2, ' ', 2, ' ', 2),
('QA3', 'f', 'PfiFCW', 8, 2, ' ', 2, ' ', 2),
('QA3', 'f', 'PfiFCW', 9, 2, ' ', 2, ' ', 2),
('QA3', 'b', 'SQIe3G', 0, 2, ' ', 2, ' ', 2),
('QA3', 'b', 'SQIe3G', 1, 2, ' ', 2, ' ', 2),
('QA3', 'b', 'SQIe3G', 2, 2, ' ', 2, ' ', 2),
('QA3', 'b', 'SQIe3G', 3, 2, ' ', 2, ' ', 2),
('QA3', 'b', 'SQIe3G', 4, 2, ' ', 2, ' ', 2),
('QA3', 'b', 'SQIe3G', 5, 2, ' ', 2, ' ', 2),
('QA3', 'b', 'SQIe3G', 6, 2, ' ', 2, ' ', 2),
('QA3', 'b', 'SQIe3G', 7, 2, ' ', 2, ' ', 2),
('QA3', 'b', 'SQIe3G', 8, 2, ' ', 2, ' ', 2),
('QA3', 'b', 'SQIe3G', 9, 2, ' ', 2, ' ', 2),
('QA3', 'c', 'SQIe3G', 0, 2, ' ', 2, ' ', 2),
('QA3', 'c', 'SQIe3G', 1, 2, ' ', 2, ' ', 2),
('QA3', 'c', 'SQIe3G', 2, 2, ' ', 2, ' ', 2),
('QA3', 'c', 'SQIe3G', 3, 2, ' ', 2, ' ', 2),
('QA3', 'c', 'SQIe3G', 4, 2, ' ', 2, ' ', 2),
('QA3', 'c', 'SQIe3G', 5, 2, ' ', 2, ' ', 2),
('QA3', 'c', 'SQIe3G', 6, 2, ' ', 2, ' ', 2),
('QA3', 'c', 'SQIe3G', 7, 2, ' ', 2, ' ', 2),
('QA3', 'c', 'SQIe3G', 8, 2, ' ', 2, ' ', 2),
('QA3', 'c', 'SQIe3G', 9, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'SQIe3G', 0, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'SQIe3G', 1, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'SQIe3G', 2, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'SQIe3G', 3, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'SQIe3G', 4, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'SQIe3G', 5, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'SQIe3G', 6, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'SQIe3G', 7, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'SQIe3G', 8, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'SQIe3G', 9, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'SQIe3G', 0, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'SQIe3G', 1, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'SQIe3G', 2, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'SQIe3G', 3, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'SQIe3G', 4, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'SQIe3G', 5, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'SQIe3G', 6, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'SQIe3G', 7, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'SQIe3G', 8, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'SQIe3G', 9, 2, ' ', 2, ' ', 2),
('QA3', 'f', 'SQIe3G', 0, 2, ' ', 2, ' ', 2),
('QA3', 'f', 'SQIe3G', 1, 2, ' ', 2, ' ', 2),
('QA3', 'f', 'SQIe3G', 2, 2, ' ', 2, ' ', 2),
('QA3', 'f', 'SQIe3G', 3, 2, ' ', 2, ' ', 2),
('QA3', 'f', 'SQIe3G', 4, 2, ' ', 2, ' ', 2),
('QA3', 'f', 'SQIe3G', 5, 2, ' ', 2, ' ', 2),
('QA3', 'f', 'SQIe3G', 6, 2, ' ', 2, ' ', 2),
('QA3', 'f', 'SQIe3G', 7, 2, ' ', 2, ' ', 2),
('QA3', 'f', 'SQIe3G', 8, 2, ' ', 2, ' ', 2),
('QA3', 'f', 'SQIe3G', 9, 2, ' ', 2, ' ', 2),
('QA3', 'a', 'YiVkXq', 0, 2, ' ', 2, ' ', 2),
('QA3', 'a', 'YiVkXq', 1, 2, ' ', 2, ' ', 2),
('QA3', 'a', 'YiVkXq', 2, 2, ' ', 2, ' ', 2),
('QA3', 'a', 'YiVkXq', 3, 2, ' ', 2, ' ', 2),
('QA3', 'a', 'YiVkXq', 4, 2, ' ', 2, ' ', 2),
('QA3', 'a', 'YiVkXq', 5, 2, ' ', 2, ' ', 2),
('QA3', 'a', 'YiVkXq', 6, 2, ' ', 2, ' ', 2),
('QA3', 'a', 'YiVkXq', 7, 2, ' ', 2, ' ', 2),
('QA3', 'a', 'YiVkXq', 8, 2, ' ', 2, ' ', 2),
('QA3', 'a', 'YiVkXq', 9, 2, ' ', 2, ' ', 2),
('QA3', 'b', 'YiVkXq', 0, 2, ' ', 2, ' ', 2),
('QA3', 'b', 'YiVkXq', 1, 2, ' ', 2, ' ', 2),
('QA3', 'b', 'YiVkXq', 2, 2, ' ', 2, ' ', 2),
('QA3', 'b', 'YiVkXq', 3, 2, ' ', 2, ' ', 2),
('QA3', 'b', 'YiVkXq', 4, 2, ' ', 2, ' ', 2),
('QA3', 'b', 'YiVkXq', 5, 2, ' ', 2, ' ', 2),
('QA3', 'b', 'YiVkXq', 6, 2, ' ', 2, ' ', 2),
('QA3', 'b', 'YiVkXq', 7, 2, ' ', 2, ' ', 2),
('QA3', 'b', 'YiVkXq', 8, 2, ' ', 2, ' ', 2),
('QA3', 'b', 'YiVkXq', 9, 2, ' ', 2, ' ', 2),
('QA3', 'c', 'YiVkXq', 0, 2, ' ', 2, ' ', 2),
('QA3', 'c', 'YiVkXq', 1, 2, ' ', 2, ' ', 2),
('QA3', 'c', 'YiVkXq', 2, 2, ' ', 2, ' ', 2),
('QA3', 'c', 'YiVkXq', 3, 2, ' ', 2, ' ', 2),
('QA3', 'c', 'YiVkXq', 4, 2, ' ', 2, ' ', 2),
('QA3', 'c', 'YiVkXq', 5, 2, ' ', 2, ' ', 2),
('QA3', 'c', 'YiVkXq', 6, 2, ' ', 2, ' ', 2),
('QA3', 'c', 'YiVkXq', 7, 2, ' ', 2, ' ', 2),
('QA3', 'c', 'YiVkXq', 8, 2, ' ', 2, ' ', 2),
('QA3', 'c', 'YiVkXq', 9, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'YiVkXq', 0, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'YiVkXq', 1, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'YiVkXq', 2, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'YiVkXq', 3, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'YiVkXq', 4, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'YiVkXq', 5, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'YiVkXq', 6, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'YiVkXq', 7, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'YiVkXq', 8, 2, ' ', 2, ' ', 2),
('QA3', 'd', 'YiVkXq', 9, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'YiVkXq', 0, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'YiVkXq', 1, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'YiVkXq', 2, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'YiVkXq', 3, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'YiVkXq', 4, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'YiVkXq', 5, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'YiVkXq', 6, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'YiVkXq', 7, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'YiVkXq', 8, 2, ' ', 2, ' ', 2),
('QA3', 'e', 'YiVkXq', 9, 2, ' ', 2, ' ', 2);

INSERT INTO `NOTA_TRABAJO` (`login`, `IdTrabajo`, `NotaTrabajo`) VALUES
('a', 'ET1', '0.00'),
('a', 'ET2', '0.00'),
('a', 'ET3', '0.00'),
('a', 'QA1', '0.00'),
('a', 'QA2', '0.00'),
('a', 'QA3', '0.00'),
('b', 'ET1', '0.00'),
('b', 'ET2', '0.00'),
('b', 'ET3', '0.00'),
('b', 'QA1', '0.00'),
('b', 'QA2', '0.00'),
('b', 'QA3', '0.00'),
('c', 'ET1', '0.00'),
('c', 'ET2', '0.00'),
('c', 'ET3', '0.00'),
('c', 'QA1', '0.00'),
('c', 'QA2', '0.00'),
('c', 'QA3', '0.00'),
('d', 'ET1', '0.00'),
('d', 'ET2', '0.00'),
('d', 'ET3', '0.00'),
('d', 'QA1', '0.00'),
('d', 'QA2', '0.00'),
('d', 'QA3', '0.00'),
('e', 'ET1', '0.00'),
('e', 'ET2', '0.00'),
('e', 'ET3', '0.00'),
('e', 'QA1', '0.00'),
('e', 'QA2', '0.00'),
('e', 'QA3', '0.00'),
('f', 'ET1', '0.00'),
('f', 'ET2', '0.00'),
('f', 'ET3', '0.00'),
('f', 'QA1', '0.00'),
('f', 'QA2', '0.00'),
('f', 'QA3', '0.00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
