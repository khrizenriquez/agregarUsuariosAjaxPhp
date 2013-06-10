-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-06-2013 a las 07:45:40
-- Versión del servidor: 5.5.27
-- Versión de PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `bdcargafoto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbdatosusuario`
--

CREATE TABLE IF NOT EXISTS `tbdatosusuario` (
  `nombreusuario` varchar(50) NOT NULL,
  `apellidosusuario` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `direccionarchivos` varchar(200) NOT NULL,
  `idtbdatosusuario` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idtbdatosusuario`),
  KEY `fkUsuario` (`usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbusuarios`
--

CREATE TABLE IF NOT EXISTS `tbusuarios` (
  `correlativo` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) NOT NULL,
  `clave` varchar(130) NOT NULL,
  PRIMARY KEY (`correlativo`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=40 ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbdatosusuario`
--
ALTER TABLE `tbdatosusuario`
  ADD CONSTRAINT `fkUsuario` FOREIGN KEY (`usuario`) REFERENCES `tbusuarios` (`usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
