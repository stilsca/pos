-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: localhost    Database: db_pos
-- ------------------------------------------------------
-- Server version	8.0.34

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cajas`
--

DROP TABLE IF EXISTS `cajas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cajas` (
  `idCaja` int NOT NULL AUTO_INCREMENT,
  `nombreCaja` varchar(45) NOT NULL,
  PRIMARY KEY (`idCaja`)
) ENGINE=InnoDB;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cajas`
--

LOCK TABLES `cajas` WRITE;
/*!40000 ALTER TABLE `cajas` DISABLE KEYS */;
INSERT INTO `cajas` VALUES (1,'Caja uno');
/*!40000 ALTER TABLE `cajas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cajas_apci`
--

DROP TABLE IF EXISTS `cajas_apci`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cajas_apci` (
  `idApertura` int NOT NULL AUTO_INCREMENT,
  `idUsuario` int NOT NULL,
  `idCaja` int NOT NULL,
  `fechaApertura` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fechaCierre` datetime DEFAULT NULL,
  `montoApertura` int NOT NULL,
  `montoCierre` int DEFAULT NULL,
  PRIMARY KEY (`idApertura`),
  KEY `fk_cajas_apci_1_idx` (`idUsuario`),
  KEY `fk_cajas_apci_2_idx` (`idCaja`),
  CONSTRAINT `fk_cajas_apci_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`),
  CONSTRAINT `fk_cajas_apci_2` FOREIGN KEY (`idCaja`) REFERENCES `cajas` (`idCaja`)
) ENGINE=InnoDB;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cajas_apci`
--

LOCK TABLES `cajas_apci` WRITE;
/*!40000 ALTER TABLE `cajas_apci` DISABLE KEYS */;
INSERT INTO `cajas_apci` VALUES (1,1,1,'2023-12-03 21:21:36','2023-12-04 10:10:25',0,216750),(2,1,1,'2023-11-30 22:55:38','2023-12-02 22:55:45',0,550000),(4,1,1,'2023-12-04 10:40:49',NULL,0,NULL);
/*!40000 ALTER TABLE `cajas_apci` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clientes` (
  `idCliente` int NOT NULL AUTO_INCREMENT,
  `razonSocial` varchar(45) NOT NULL,
  `documento` int NOT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `celular` int DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `memo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idCliente`)
) ENGINE=InnoDB;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES (2,'STILVER CARLOS ANTONIO SCAVONE CACERES',3413973,'CAAGUAZU',NULL,NULL,NULL);
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compras`
--

DROP TABLE IF EXISTS `compras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `compras` (
  `idCompra` int NOT NULL AUTO_INCREMENT,
  `idCondicion` int NOT NULL,
  `idProveedor` int NOT NULL,
  `idApertura` int NOT NULL,
  `fecha` date NOT NULL,
  `nroTimbrado` varchar(10) DEFAULT NULL,
  `nroComprobante` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idCompra`),
  KEY `fk_compras_cab_condicion1_idx` (`idCondicion`),
  KEY `fk_compras_cab_proveedor1_idx` (`idProveedor`),
  KEY `fk_compras_cab_1_idx` (`idApertura`),
  CONSTRAINT `fk_compras_cab_1` FOREIGN KEY (`idApertura`) REFERENCES `cajas_apci` (`idApertura`),
  CONSTRAINT `fk_compras_cab_condicion1` FOREIGN KEY (`idCondicion`) REFERENCES `condicion` (`idCondicion`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_compras_cab_proveedor1` FOREIGN KEY (`idProveedor`) REFERENCES `proveedores` (`idProveedor`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compras`
--

LOCK TABLES `compras` WRITE;
/*!40000 ALTER TABLE `compras` DISABLE KEYS */;
/*!40000 ALTER TABLE `compras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compras_det`
--

DROP TABLE IF EXISTS `compras_det`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `compras_det` (
  `idCompraDet` int NOT NULL AUTO_INCREMENT,
  `idCompra` int NOT NULL,
  `idProducto` int NOT NULL,
  `costo` int NOT NULL,
  `cantidad` float NOT NULL,
  `impuesto` int NOT NULL,
  PRIMARY KEY (`idCompraDet`),
  KEY `fk_compras_det_compras_cab1_idx` (`idCompra`),
  KEY `fk_compras_det_productos1_idx` (`idProducto`),
  CONSTRAINT `fk_compras_det_compras_cab1` FOREIGN KEY (`idCompra`) REFERENCES `compras` (`idCompra`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_compras_det_productos1` FOREIGN KEY (`idProducto`) REFERENCES `productos` (`idProducto`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compras_det`
--

LOCK TABLES `compras_det` WRITE;
/*!40000 ALTER TABLE `compras_det` DISABLE KEYS */;
/*!40000 ALTER TABLE `compras_det` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `condicion`
--

DROP TABLE IF EXISTS `condicion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `condicion` (
  `idCondicion` int NOT NULL AUTO_INCREMENT,
  `nombreCondicion` varchar(45) NOT NULL,
  PRIMARY KEY (`idCondicion`)
) ENGINE=InnoDB;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `condicion`
--

LOCK TABLES `condicion` WRITE;
/*!40000 ALTER TABLE `condicion` DISABLE KEYS */;
INSERT INTO `condicion` VALUES (1,'Contado'),(2,'Crédito');
/*!40000 ALTER TABLE `condicion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `impuestos`
--

DROP TABLE IF EXISTS `impuestos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `impuestos` (
  `idImpuesto` int NOT NULL AUTO_INCREMENT,
  `porcentaje` double NOT NULL,
  `nombreImpuesto` varchar(45) NOT NULL,
  PRIMARY KEY (`idImpuesto`)
) ENGINE=InnoDB;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `impuestos`
--

LOCK TABLES `impuestos` WRITE;
/*!40000 ALTER TABLE `impuestos` DISABLE KEYS */;
INSERT INTO `impuestos` VALUES (1,10,'Gravada 10'),(2,5,'Gravada 5'),(3,0,'Exenta');
/*!40000 ALTER TABLE `impuestos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perfiles`
--

DROP TABLE IF EXISTS `perfiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `perfiles` (
  `idPerfil` int NOT NULL AUTO_INCREMENT,
  `nombrePerfil` varchar(45) NOT NULL,
  PRIMARY KEY (`idPerfil`)
) ENGINE=InnoDB AUTO_INCREMENT=4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perfiles`
--

LOCK TABLES `perfiles` WRITE;
/*!40000 ALTER TABLE `perfiles` DISABLE KEYS */;
INSERT INTO `perfiles` VALUES (1,'Administrador'),(2,'Cajero');
/*!40000 ALTER TABLE `perfiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perfiles_permisos`
--

DROP TABLE IF EXISTS `perfiles_permisos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `perfiles_permisos` (
  `idPerfil` int NOT NULL,
  `idPermiso` int NOT NULL,
  PRIMARY KEY (`idPerfil`,`idPermiso`),
  KEY `fk_perfiles_permisos_2_idx` (`idPermiso`),
  CONSTRAINT `fk_perfiles_permisos_1` FOREIGN KEY (`idPerfil`) REFERENCES `perfiles` (`idPerfil`),
  CONSTRAINT `fk_perfiles_permisos_2` FOREIGN KEY (`idPermiso`) REFERENCES `permisos` (`idPermiso`)
) ENGINE=InnoDB ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perfiles_permisos`
--

LOCK TABLES `perfiles_permisos` WRITE;
/*!40000 ALTER TABLE `perfiles_permisos` DISABLE KEYS */;
INSERT INTO `perfiles_permisos` VALUES (1,1),(1,2),(1,3),(1,4),(1,5),(1,6),(1,7),(1,8),(1,9),(1,10),(1,11),(1,12),(1,13),(1,14);
/*!40000 ALTER TABLE `perfiles_permisos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permisos`
--

DROP TABLE IF EXISTS `permisos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permisos` (
  `idPermiso` int NOT NULL AUTO_INCREMENT,
  `nombrePermiso` varchar(45) NOT NULL,
  `codigoPermiso` varchar(45) NOT NULL,
  PRIMARY KEY (`idPermiso`)
) ENGINE=InnoDB AUTO_INCREMENT=16 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permisos`
--

LOCK TABLES `permisos` WRITE;
/*!40000 ALTER TABLE `permisos` DISABLE KEYS */;
INSERT INTO `permisos` VALUES (1,'Marcas','0x1'),(2,'Grupos','0x2'),(3,'Productos','0x3'),(4,'Timbrados','0x4'),(5,'Clientes','0x5'),(6,'Proveedores','0x6'),(7,'Cajas','0x7'),(8,'Usuarios','0x8'),(9,'Perfiles','0x9'),(10,'Cierre caja','0x10'),(11,'Ventas','0x11'),(12,'Compras','0x12'),(13,'Descuento','0x13'),(14,'Anular venta','0x14'),(15,'Inventario','0x15');
/*!40000 ALTER TABLE `permisos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos` (
  `idProducto` int NOT NULL AUTO_INCREMENT,
  `nombreProducto` varchar(45) NOT NULL,
  `precio` int NOT NULL,
  `codigoBarra` varchar(150) DEFAULT NULL,
  `idTipo` int NOT NULL,
  `idGrupo` int NOT NULL,
  `idImpuesto` int NOT NULL,
  `idMarca` int NOT NULL,
  `activo` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`idProducto`),
  KEY `fk_productos_tipo_producto_idx` (`idTipo`),
  KEY `fk_productos_grupo_producto1_idx` (`idGrupo`),
  KEY `fk_productos_impuesto_producto1_idx` (`idImpuesto`),
  KEY `fk_productos_marca_producto1_idx` (`idMarca`),
  CONSTRAINT `fk_productos_grupo_producto1` FOREIGN KEY (`idGrupo`) REFERENCES `productos_grupos` (`idGrupo`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_productos_impuesto_producto1` FOREIGN KEY (`idImpuesto`) REFERENCES `impuestos` (`idImpuesto`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_productos_marca_producto1` FOREIGN KEY (`idMarca`) REFERENCES `productos_marcas` (`idMarca`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_productos_tipo_producto1` FOREIGN KEY (`idTipo`) REFERENCES `productos_tipos` (`idTipo`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (1,'Carnaza de 1ra',43500,'1001',1,1,2,1,1),(25,'CARNE OSOBUCO X KG',21600,'4567',1,1,2,1,1);
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos_grupos`
--

DROP TABLE IF EXISTS `productos_grupos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos_grupos` (
  `idGrupo` int NOT NULL AUTO_INCREMENT,
  `nombreGrupo` varchar(45) NOT NULL,
  `activo` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`idGrupo`)
) ENGINE=InnoDB AUTO_INCREMENT=8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos_grupos`
--

LOCK TABLES `productos_grupos` WRITE;
/*!40000 ALTER TABLE `productos_grupos` DISABLE KEYS */;
INSERT INTO `productos_grupos` VALUES (1,'Carnicos',1),(2,'Lacteos',1),(3,'Embutidos',1),(4,'Panificados',1);
/*!40000 ALTER TABLE `productos_grupos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos_marcas`
--

DROP TABLE IF EXISTS `productos_marcas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos_marcas` (
  `idMarca` int NOT NULL AUTO_INCREMENT,
  `nombreMarca` varchar(45) NOT NULL,
  `activo` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`idMarca`)
) ENGINE=InnoDB AUTO_INCREMENT=9;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos_marcas`
--

LOCK TABLES `productos_marcas` WRITE;
/*!40000 ALTER TABLE `productos_marcas` DISABLE KEYS */;
INSERT INTO `productos_marcas` VALUES (1,'Sin marca',1),(8,'Test',1);
/*!40000 ALTER TABLE `productos_marcas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos_tipos`
--

DROP TABLE IF EXISTS `productos_tipos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos_tipos` (
  `idTipo` int NOT NULL AUTO_INCREMENT,
  `nombreTipo` varchar(45) NOT NULL,
  PRIMARY KEY (`idTipo`)
) ENGINE=InnoDB AUTO_INCREMENT=17;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos_tipos`
--

LOCK TABLES `productos_tipos` WRITE;
/*!40000 ALTER TABLE `productos_tipos` DISABLE KEYS */;
INSERT INTO `productos_tipos` VALUES (1,'Almacenable'),(2,'Servicio');
/*!40000 ALTER TABLE `productos_tipos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proveedores`
--

DROP TABLE IF EXISTS `proveedores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proveedores` (
  `idProveedor` int NOT NULL AUTO_INCREMENT,
  `documento` varchar(45) NOT NULL,
  `razonSocial` varchar(250) NOT NULL,
  `telefono` varchar(25) DEFAULT NULL,
  `direccion` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`idProveedor`)
) ENGINE=InnoDB AUTO_INCREMENT=2 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedores`
--

LOCK TABLES `proveedores` WRITE;
/*!40000 ALTER TABLE `proveedores` DISABLE KEYS */;
INSERT INTO `proveedores` VALUES (1,'44444407-1','Sin nombre',NULL,NULL);
/*!40000 ALTER TABLE `proveedores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `timbrados`
--

DROP TABLE IF EXISTS `timbrados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `timbrados` (
  `idTimbrado` int NOT NULL AUTO_INCREMENT,
  `nroTimbrado` int NOT NULL,
  `regimen` text NOT NULL,
  `vigenciaInicio` date NOT NULL,
  `vigenciaFin` date NOT NULL,
  `inicio` int NOT NULL,
  `fin` int NOT NULL,
  `activo` tinyint NOT NULL,
  PRIMARY KEY (`idTimbrado`)
) ENGINE=InnoDB AUTO_INCREMENT=2 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `timbrados`
--

LOCK TABLES `timbrados` WRITE;
/*!40000 ALTER TABLE `timbrados` DISABLE KEYS */;
INSERT INTO `timbrados` VALUES (1,1234567,'001-001','2023-12-01','2024-12-31',1,500,1);
/*!40000 ALTER TABLE `timbrados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `idUsuario` int NOT NULL AUTO_INCREMENT,
  `user` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `idPerfil` int NOT NULL,
  PRIMARY KEY (`idUsuario`),
  UNIQUE KEY `user_UNIQUE` (`user`),
  KEY `fk_usuarios_1_idx` (`idPerfil`),
  CONSTRAINT `fk_usuarios_1` FOREIGN KEY (`idPerfil`) REFERENCES `perfiles` (`idPerfil`)
) ENGINE=InnoDB AUTO_INCREMENT=3 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'admin','$2y$10$Uci8Xz1V4PoqrnoVUHgrZecWuePao4hoNNr85gjSnIH/V3rIkBLX.',1);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ventas`
--

DROP TABLE IF EXISTS `ventas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ventas` (
  `idVenta` int NOT NULL AUTO_INCREMENT,
  `idTimbrado` int NOT NULL,
  `idCondicion` int NOT NULL,
  `idCliente` int NOT NULL,
  `fecha` date NOT NULL,
  `idApertura` int NOT NULL,
  `nroComprobante` int NOT NULL,
  `anulado` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`idVenta`),
  KEY `fk_ventas_timbrado1_idx` (`idTimbrado`),
  KEY `fk_ventas_condicion1_idx` (`idCondicion`),
  KEY `fk_ventas_cliente1_idx` (`idCliente`),
  KEY `fk_ventas_cab_1_idx` (`idApertura`),
  CONSTRAINT `fk_ventas_cab_1` FOREIGN KEY (`idApertura`) REFERENCES `cajas_apci` (`idApertura`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_ventas_cliente1` FOREIGN KEY (`idCliente`) REFERENCES `clientes` (`idCliente`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_ventas_condicion1` FOREIGN KEY (`idCondicion`) REFERENCES `condicion` (`idCondicion`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_ventas_timbrado1` FOREIGN KEY (`idTimbrado`) REFERENCES `timbrados` (`idTimbrado`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ventas`
--

LOCK TABLES `ventas` WRITE;
/*!40000 ALTER TABLE `ventas` DISABLE KEYS */;
INSERT INTO `ventas` VALUES (2,1,1,2,'2023-12-03',1,1,0),(3,1,1,2,'2023-12-03',1,2,0);
/*!40000 ALTER TABLE `ventas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ventas_det`
--

DROP TABLE IF EXISTS `ventas_det`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ventas_det` (
  `idVentaDet` int NOT NULL AUTO_INCREMENT,
  `idVenta` int NOT NULL,
  `idProducto` int NOT NULL,
  `precio` int NOT NULL,
  `cantidad` float NOT NULL,
  `impuesto` int NOT NULL,
  PRIMARY KEY (`idVentaDet`),
  KEY `fk_ventas_det_ventas_cab1_idx` (`idVenta`),
  KEY `fk_ventas_det_productos1_idx` (`idProducto`),
  CONSTRAINT `fk_ventas_det_productos1` FOREIGN KEY (`idProducto`) REFERENCES `productos` (`idProducto`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_ventas_det_ventas_cab1` FOREIGN KEY (`idVenta`) REFERENCES `ventas` (`idVenta`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ventas_det`
--

LOCK TABLES `ventas_det` WRITE;
/*!40000 ALTER TABLE `ventas_det` DISABLE KEYS */;
INSERT INTO `ventas_det` VALUES (1,2,1,43500,1,5),(2,3,1,43500,1.5,5),(3,3,25,21600,5,5);
/*!40000 ALTER TABLE `ventas_det` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-12-04 15:11:37
