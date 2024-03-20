CREATE DATABASE  IF NOT EXISTS `db_validez` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `db_validez`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: db_validez
-- ------------------------------------------------------
-- Server version	5.7.14

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tbl_aviso_historico`
--

DROP TABLE IF EXISTS `tbl_aviso_historico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_aviso_historico` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` int(11) NOT NULL,
  `tipo_aviso` tinyint(1) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `aviso_email_qtd` int(11) DEFAULT '0',
  `aviso_sms_qtd` int(11) DEFAULT '0',
  `url_hash` varchar(45) COLLATE latin1_general_ci DEFAULT NULL,
  `relatorio` text COLLATE latin1_general_ci,
  `visualizou` tinyint(3) DEFAULT '0',
  PRIMARY KEY (`codigo`),
  UNIQUE KEY `hash_UNIQUE` (`url_hash`),
  KEY `fk_usuario8_idx` (`usuario`),
  CONSTRAINT `fk_usuario8` FOREIGN KEY (`usuario`) REFERENCES `tbl_usuario` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=162 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_aviso_historico`
--

LOCK TABLES `tbl_aviso_historico` WRITE;
/*!40000 ALTER TABLE `tbl_aviso_historico` DISABLE KEYS */;
INSERT INTO `tbl_aviso_historico` VALUES (135,1,1,'2017-11-04',2,1,'1db68eed558488b58a503e6c6938d91b4519d6b6','{\"produtos\":[{\"codigo\":\"29\",\"nome\":\"Toddy Shake\",\"marca\":\"Pepsico\",\"categoria\":\"Bebida\",\"subcategoria\":\"Lacteos\",\"status\":\"1\",\"un_med_custo\":\"Unidade\",\"preco_custo\":\"2,60\",\"fator\":null,\"quantidade\":\"5\",\"unidade_medida\":\"Unidade\",\"data_validade\":\"2017-11-27\",\"data_cadastro\":\"2017-07-30\",\"fornecedor\":null,\"localizacao\":null,\"lote\":null,\"descricao\":null},{\"codigo\":\"30\",\"nome\":\"Yakut\",\"marca\":null,\"categoria\":null,\"subcategoria\":null,\"status\":\"1\",\"un_med_custo\":null,\"preco_custo\":null,\"fator\":null,\"quantidade\":\"2\",\"unidade_medida\":\"Unidade\",\"data_validade\":\"2018-01-01\",\"data_cadastro\":\"2017-08-07\",\"fornecedor\":null,\"localizacao\":null,\"lote\":null,\"descricao\":null}]}',0),(137,1,1,'2017-11-05',2,1,'c3bf8dc0621ae6809173ed5e19e4d7378425f359','{\"produtos\":[{\"codigo\":\"29\",\"nome\":\"Toddy Shake\",\"marca\":\"Pepsico\",\"categoria\":\"Bebida\",\"subcategoria\":\"Lacteos\",\"status\":\"1\",\"un_med_custo\":\"Unidade\",\"preco_custo\":\"2,60\",\"fator\":null,\"quantidade\":\"5\",\"unidade_medida\":\"Unidade\",\"data_validade\":\"2017-11-27\",\"data_cadastro\":\"2017-07-30\",\"fornecedor\":null,\"localizacao\":null,\"lote\":null,\"descricao\":null},{\"codigo\":\"30\",\"nome\":\"Yakut\",\"marca\":null,\"categoria\":null,\"subcategoria\":null,\"status\":\"1\",\"un_med_custo\":null,\"preco_custo\":null,\"fator\":null,\"quantidade\":\"2\",\"unidade_medida\":\"Unidade\",\"data_validade\":\"2018-01-01\",\"data_cadastro\":\"2017-08-07\",\"fornecedor\":null,\"localizacao\":null,\"lote\":null,\"descricao\":null}]}',0),(141,1,1,'2017-11-10',2,1,'d74fbdd5c15b4919f819feb2f9a936caedbddf1e','{\"produtos\":[{\"codigo\":\"29\",\"nome\":\"Toddy Shake\",\"marca\":\"Pepsico\",\"categoria\":\"Bebida\",\"fator\":null,\"quantidade\":\"5\",\"unidade_medida\":\"Unidade\"},{\"codigo\":\"30\",\"nome\":\"Yakut\",\"marca\":null,\"categoria\":null,\"fator\":null,\"quantidade\":\"2\",\"unidade_medida\":\"Unidade\"}]}',0),(142,1,1,'2017-11-11',2,1,'629f7dc807b217b1ce6775cbb6d3a9614b3bd321','{\"produtos\":[{\"codigo\":\"29\",\"nome\":\"Toddy Shake\",\"marca\":\"Pepsico\",\"categoria\":\"Bebida\",\"fator\":null,\"quantidade\":\"5\",\"unidade_medida\":\"Unidade\"},{\"codigo\":\"30\",\"nome\":\"Yakut\",\"marca\":null,\"categoria\":null,\"fator\":null,\"quantidade\":\"2\",\"unidade_medida\":\"Unidade\"}]}',0),(143,1,1,'2017-11-12',2,1,'77f618c4a35afdb043c75fffc39fc20c4da4b1f0','{\"produtos\":[{\"codigo\":\"29\",\"nome\":\"Toddy Shake\",\"marca\":\"Pepsico\",\"categoria\":\"Bebida\",\"fator\":null,\"quantidade\":\"5\",\"unidade_medida\":\"Unidade\"},{\"codigo\":\"30\",\"nome\":\"Yakut\",\"marca\":null,\"categoria\":null,\"fator\":null,\"quantidade\":\"2\",\"unidade_medida\":\"Unidade\"}]}',0),(145,1,1,'2017-11-16',2,1,'56f270da4b5f773a152010126ea0c9e38cd3b2d7','{\"produtos\":[{\"codigo\":\"29\",\"nome\":\"Toddy Shake\",\"marca\":\"Pepsico\",\"categoria\":\"Bebida\",\"fator\":null,\"quantidade\":\"5\",\"unidade_medida\":\"Unidade\"},{\"codigo\":\"30\",\"nome\":\"Yakut\",\"marca\":null,\"categoria\":null,\"fator\":null,\"quantidade\":\"2\",\"unidade_medida\":\"Unidade\"}]}',0),(146,1,1,'2017-11-17',2,1,'9c55a5de4eedc98fbe7d15ab26bd4fc7e096f5a8','{\"produtos\":[{\"codigo\":\"29\",\"nome\":\"Toddy Shake\",\"marca\":\"Pepsico\",\"categoria\":\"Bebida\",\"fator\":null,\"quantidade\":\"5\",\"unidade_medida\":\"Unidade\"},{\"codigo\":\"30\",\"nome\":\"Yakut\",\"marca\":null,\"categoria\":null,\"fator\":null,\"quantidade\":\"2\",\"unidade_medida\":\"Unidade\"}]}',0),(148,1,1,'2017-11-19',2,1,'57624660e652ab986cc14af0a3491752ca14e01c','{\"produtos\":[{\"codigo\":\"29\",\"nome\":\"Toddy Shake\",\"marca\":\"Pepsico\",\"categoria\":\"Bebida\",\"fator\":null,\"quantidade\":\"5\",\"unidade_medida\":\"Unidade\"},{\"codigo\":\"30\",\"nome\":\"Yakut\",\"marca\":null,\"categoria\":null,\"fator\":null,\"quantidade\":\"2\",\"unidade_medida\":\"Unidade\"}]}',0),(150,1,1,'2017-11-21',2,1,'42dda3460f034cd2f510c38650321aab445ba12b','{\"produtos\":[{\"codigo\":\"29\",\"nome\":\"Toddy Shake\",\"marca\":\"Pepsico\",\"categoria\":\"Bebida\",\"fator\":null,\"quantidade\":\"5\",\"unidade_medida\":\"Unidade\"},{\"codigo\":\"30\",\"nome\":\"Yakut\",\"marca\":null,\"categoria\":null,\"fator\":null,\"quantidade\":\"2\",\"unidade_medida\":\"Unidade\"}]}',0),(151,1,1,'2017-11-22',2,1,'c99240bae17fb078713daa7b1f84213da14fbcba','{\"produtos\":[{\"codigo\":\"29\",\"nome\":\"Toddy Shake\",\"marca\":\"Pepsico\",\"categoria\":\"Bebida\",\"fator\":null,\"quantidade\":\"5\",\"unidade_medida\":\"Unidade\"},{\"codigo\":\"30\",\"nome\":\"Yakut\",\"marca\":null,\"categoria\":null,\"fator\":null,\"quantidade\":\"2\",\"unidade_medida\":\"Unidade\"}]}',0),(152,1,1,'2017-11-23',2,1,'3aa08f4215926f7a5b7c3bb09d5ee84219036953','{\"produtos\":[{\"codigo\":\"29\",\"nome\":\"Toddy Shake\",\"marca\":\"Pepsico\",\"categoria\":\"Bebida\",\"fator\":null,\"quantidade\":\"5\",\"unidade_medida\":\"Unidade\"},{\"codigo\":\"30\",\"nome\":\"Yakut\",\"marca\":null,\"categoria\":null,\"fator\":null,\"quantidade\":\"2\",\"unidade_medida\":\"Unidade\"}]}',0),(154,1,1,'2017-11-25',2,1,'4bfdeb01696bb4e72fd896aeff0f9a4f16ceddca','{\"produtos\":[{\"codigo\":\"29\",\"nome\":\"Toddy Shake\",\"marca\":\"Pepsico\",\"categoria\":\"Bebida\",\"fator\":null,\"quantidade\":\"5\",\"unidade_medida\":\"Unidade\"},{\"codigo\":\"30\",\"nome\":\"Yakut\",\"marca\":null,\"categoria\":null,\"fator\":null,\"quantidade\":\"2\",\"unidade_medida\":\"Unidade\"}]}',0),(156,1,1,'2017-11-27',2,1,'3dfaa0954ba287333dc9526e5aada8ef2f5b95e9','{\"produtos\":[{\"codigo\":\"29\",\"nome\":\"Toddy Shake\",\"marca\":\"Pepsico\",\"categoria\":\"Bebida\",\"fator\":null,\"quantidade\":\"5\",\"unidade_medida\":\"Unidade\"},{\"codigo\":\"30\",\"nome\":\"Yakut\",\"marca\":null,\"categoria\":null,\"fator\":null,\"quantidade\":\"2\",\"unidade_medida\":\"Unidade\"}]}',0),(157,1,1,'2017-11-28',2,1,'9bc2fad158e015bd3c450621b9b46d539b69f31b','{\"produtos\":[{\"codigo\":\"29\",\"nome\":\"Toddy Shake\",\"marca\":\"Pepsico\",\"categoria\":\"Bebida\",\"fator\":null,\"quantidade\":\"5\",\"unidade_medida\":\"Unidade\"},{\"codigo\":\"30\",\"nome\":\"Yakut\",\"marca\":null,\"categoria\":null,\"fator\":null,\"quantidade\":\"2\",\"unidade_medida\":\"Unidade\"}]}',1),(158,1,1,'2017-11-29',2,1,'9c8f063ec86a7ed12a42ac271281da077c1d5d59','{\"produtos\":[{\"codigo\":\"29\",\"nome\":\"Toddy Shake\",\"marca\":\"Pepsico\",\"categoria\":\"Bebida\",\"fator\":null,\"quantidade\":\"5\",\"unidade_medida\":\"Unidade\"},{\"codigo\":\"30\",\"nome\":\"Yakut\",\"marca\":null,\"categoria\":null,\"fator\":null,\"quantidade\":\"2\",\"unidade_medida\":\"Unidade\"}]}',1),(159,1,1,'2017-11-30',2,1,'ad50ac238d34191232cbc0c4c8c4bb11a495c4d2','{\"produtos\":[{\"codigo\":\"29\",\"nome\":\"Toddy Shake\",\"marca\":\"Pepsico\",\"categoria\":\"Bebida\",\"fator\":null,\"quantidade\":\"5\",\"unidade_medida\":\"Unidade\",\"data_validade\":\"2017-11-27\"},{\"codigo\":\"30\",\"nome\":\"Yakut\",\"marca\":null,\"categoria\":null,\"fator\":null,\"quantidade\":\"2\",\"unidade_medida\":\"Unidade\",\"data_validade\":\"2018-01-01\"}]}',0),(160,1,1,'2017-12-01',2,1,'601ecbeb2ed8c49f2e1fbfd6bd2263728734462a','{\"produtos\":[{\"codigo\":\"29\",\"nome\":\"Toddy Shake\",\"marca\":\"Pepsico\",\"categoria\":\"Bebida\",\"fator\":null,\"quantidade\":\"5\",\"unidade_medida\":\"Unidade\",\"data_validade\":\"2017-11-27\"},{\"codigo\":\"30\",\"nome\":\"Yakut\",\"marca\":null,\"categoria\":null,\"fator\":null,\"quantidade\":\"2\",\"unidade_medida\":\"Unidade\",\"data_validade\":\"2018-01-01\"}]}',1),(161,1,1,'2017-12-02',2,1,'c1018db3b3fff45280fe20e4d67c16e1abe01f41','{\"produtos\":[{\"codigo\":\"29\",\"nome\":\"Toddy Shake\",\"marca\":\"Pepsico\",\"categoria\":\"Bebida\",\"fator\":null,\"quantidade\":\"5\",\"unidade_medida\":\"Unidade\",\"data_validade\":\"2017-11-27\"},{\"codigo\":\"30\",\"nome\":\"Yakut\",\"marca\":null,\"categoria\":null,\"fator\":null,\"quantidade\":\"2\",\"unidade_medida\":\"Unidade\",\"data_validade\":\"2018-01-01\"}]}',0);
/*!40000 ALTER TABLE `tbl_aviso_historico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_aviso_periodico`
--

DROP TABLE IF EXISTS `tbl_aviso_periodico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_aviso_periodico` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` int(11) DEFAULT NULL,
  `data_aviso_ultimo` date DEFAULT NULL,
  `data_aviso_proximo` date DEFAULT NULL,
  PRIMARY KEY (`codigo`),
  UNIQUE KEY `fk_usuario11_idx` (`usuario`),
  CONSTRAINT `fk_usuario14` FOREIGN KEY (`usuario`) REFERENCES `tbl_usuario` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_aviso_periodico`
--

LOCK TABLES `tbl_aviso_periodico` WRITE;
/*!40000 ALTER TABLE `tbl_aviso_periodico` DISABLE KEYS */;
INSERT INTO `tbl_aviso_periodico` VALUES (1,1,'2017-11-19','2017-12-04');
/*!40000 ALTER TABLE `tbl_aviso_periodico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_aviso_produto`
--

DROP TABLE IF EXISTS `tbl_aviso_produto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_aviso_produto` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` int(11) NOT NULL,
  `produto` int(11) NOT NULL,
  `data_aviso_inicial` date NOT NULL,
  `data_aviso_final` date NOT NULL,
  PRIMARY KEY (`codigo`),
  UNIQUE KEY `produto_UNIQUE` (`produto`),
  KEY `fk_usuario12_idx` (`usuario`),
  KEY `fk_produto3_idx` (`produto`),
  CONSTRAINT `fk_produto3` FOREIGN KEY (`produto`) REFERENCES `tbl_produto` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_usuario12` FOREIGN KEY (`usuario`) REFERENCES `tbl_usuario` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_aviso_produto`
--

LOCK TABLES `tbl_aviso_produto` WRITE;
/*!40000 ALTER TABLE `tbl_aviso_produto` DISABLE KEYS */;
INSERT INTO `tbl_aviso_produto` VALUES (1,1,25,'2016-06-28','2017-07-13'),(2,1,14,'2018-06-01','2019-06-16'),(3,1,17,'2018-06-01','2019-06-16'),(4,1,18,'2019-08-08','2020-08-23'),(5,1,26,'2016-10-03','2017-10-18'),(6,1,27,'2016-04-01','2017-04-16'),(7,1,28,'2016-07-31','2017-08-15'),(8,1,29,'2016-11-27','2017-12-12'),(9,1,30,'2017-01-01','2018-01-16'),(12,1,32,'2016-10-30','2017-11-03');
/*!40000 ALTER TABLE `tbl_aviso_produto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_campo_rel_config`
--

DROP TABLE IF EXISTS `tbl_campo_rel_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_campo_rel_config` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` int(11) NOT NULL,
  `c_marca` tinyint(1) DEFAULT '1',
  `c_categoria` tinyint(1) DEFAULT '1',
  `c_subcategoria` tinyint(1) DEFAULT '0',
  `c_status` tinyint(1) DEFAULT '0',
  `c_preco_custo` tinyint(1) DEFAULT '0',
  `c_quantidade` tinyint(1) DEFAULT '1',
  `c_data_validade` tinyint(1) DEFAULT '1',
  `c_data_cadastro` tinyint(1) DEFAULT '0',
  `c_fornecedor` tinyint(1) DEFAULT '0',
  `c_localizacao` tinyint(1) DEFAULT '0',
  `c_lote` tinyint(1) DEFAULT '0',
  `c_descricao` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`codigo`),
  UNIQUE KEY `fk_usuario10_idx` (`usuario`),
  CONSTRAINT `fk_usuario13` FOREIGN KEY (`usuario`) REFERENCES `tbl_usuario` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_campo_rel_config`
--

LOCK TABLES `tbl_campo_rel_config` WRITE;
/*!40000 ALTER TABLE `tbl_campo_rel_config` DISABLE KEYS */;
INSERT INTO `tbl_campo_rel_config` VALUES (1,1,1,1,0,0,0,1,1,0,0,0,0,0);
/*!40000 ALTER TABLE `tbl_campo_rel_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_categoria`
--

DROP TABLE IF EXISTS `tbl_categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_categoria` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) DEFAULT NULL,
  `usuario` int(11) NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `fk_usuario4_idx` (`usuario`),
  CONSTRAINT `fk_usuario4` FOREIGN KEY (`usuario`) REFERENCES `tbl_usuario` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_categoria`
--

LOCK TABLES `tbl_categoria` WRITE;
/*!40000 ALTER TABLE `tbl_categoria` DISABLE KEYS */;
INSERT INTO `tbl_categoria` VALUES (3,'Bebida',1),(5,'Alimento',1),(8,'Limpeza',1),(19,'Importado',1);
/*!40000 ALTER TABLE `tbl_categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_fornecedor`
--

DROP TABLE IF EXISTS `tbl_fornecedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_fornecedor` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) DEFAULT NULL,
  `usuario` int(11) NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `fk_usuario3_idx` (`usuario`),
  CONSTRAINT `fk_usuario3` FOREIGN KEY (`usuario`) REFERENCES `tbl_usuario` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_fornecedor`
--

LOCK TABLES `tbl_fornecedor` WRITE;
/*!40000 ALTER TABLE `tbl_fornecedor` DISABLE KEYS */;
INSERT INTO `tbl_fornecedor` VALUES (16,'Juca Salgados',1),(18,'Roberto Doces',1),(20,'Marcelo Bebidas',1);
/*!40000 ALTER TABLE `tbl_fornecedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_marca`
--

DROP TABLE IF EXISTS `tbl_marca`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_marca` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) DEFAULT NULL,
  `usuario` int(11) NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `fk_usuario_idx2` (`usuario`),
  CONSTRAINT `fk_usuario2` FOREIGN KEY (`usuario`) REFERENCES `tbl_usuario` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_marca`
--

LOCK TABLES `tbl_marca` WRITE;
/*!40000 ALTER TABLE `tbl_marca` DISABLE KEYS */;
INSERT INTO `tbl_marca` VALUES (1,'Elmachips',1),(3,'Nestle',1),(4,'Danone',1),(6,'Dove',1),(7,'Parmalat',1),(9,'Colgate',1),(10,'Johnsons',1),(17,'Garoto',1),(19,'Coca Cola',1),(21,'Pepsico',1),(22,'Qualita',1),(24,'Bauducco',1),(29,'Garoto',1);
/*!40000 ALTER TABLE `tbl_marca` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_produto`
--

DROP TABLE IF EXISTS `tbl_produto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_produto` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `marca` int(11) DEFAULT NULL,
  `categoria` int(11) DEFAULT NULL,
  `subcategoria` int(11) DEFAULT NULL,
  `descricao` varchar(200) DEFAULT NULL,
  `quantidade` int(11) NOT NULL,
  `unidade_medida` int(11) NOT NULL,
  `fator` int(11) DEFAULT NULL,
  `fornecedor` int(11) DEFAULT NULL,
  `localizacao` varchar(30) DEFAULT NULL,
  `lote` varchar(45) DEFAULT NULL,
  `codigo_barra` varchar(45) DEFAULT NULL,
  `codigo_referencia` varchar(45) DEFAULT NULL,
  `preco_custo` varchar(45) DEFAULT NULL,
  `un_med_custo` varchar(45) DEFAULT NULL,
  `data_validade` date NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `data_cadastro` date NOT NULL,
  `usuario` int(11) NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `fk_marca_idx` (`marca`),
  KEY `fk_catagoria_idx` (`categoria`),
  KEY `fk_fornecedor_idx` (`fornecedor`),
  KEY `fk_unidade_medida_idx` (`unidade_medida`),
  KEY `fk_usuario5_idx` (`usuario`),
  KEY `fk_subcategoria_idx` (`subcategoria`),
  CONSTRAINT `fk_catagoria` FOREIGN KEY (`categoria`) REFERENCES `tbl_categoria` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_fornecedor` FOREIGN KEY (`fornecedor`) REFERENCES `tbl_fornecedor` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_marca` FOREIGN KEY (`marca`) REFERENCES `tbl_marca` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_subcategoria` FOREIGN KEY (`subcategoria`) REFERENCES `tbl_subcategoria` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_unidade_medida` FOREIGN KEY (`unidade_medida`) REFERENCES `tbl_unidade_medida` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario5` FOREIGN KEY (`usuario`) REFERENCES `tbl_usuario` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_produto`
--

LOCK TABLES `tbl_produto` WRITE;
/*!40000 ALTER TABLE `tbl_produto` DISABLE KEYS */;
INSERT INTO `tbl_produto` VALUES (14,'Crystal',NULL,3,4,'Agua mineral sem gas',1,2,14,NULL,NULL,NULL,NULL,NULL,'1,00','Unidade','2019-06-01',1,'2016-11-12',1),(17,'Plax',9,NULL,NULL,NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-06-01',1,'2017-02-14',1),(18,'Baby Shampoo',10,NULL,NULL,'Shampoo para bebes',1,2,6,NULL,NULL,NULL,NULL,NULL,'5,00',NULL,'2020-08-08',1,'2017-03-04',1),(25,'Bonafont',19,3,33,'Agua mineral leve',50,1,NULL,NULL,NULL,NULL,NULL,NULL,'1,50','Unidade','2017-06-28',0,'2017-03-26',1),(26,'Club Social Club Social Club Social Club Social CL',NULL,5,NULL,'Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ip',1,2,6,16,NULL,NULL,NULL,NULL,NULL,NULL,'2017-10-03',0,'2017-03-26',1),(27,'Alfajor',NULL,NULL,NULL,NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2017-04-01',0,'2017-03-27',1),(28,'Mamut',NULL,NULL,NULL,NULL,4,1,NULL,16,NULL,NULL,NULL,NULL,NULL,NULL,'2017-07-31',0,'2017-03-27',1),(29,'Toddy Shake',21,3,7,NULL,5,1,NULL,NULL,NULL,NULL,NULL,NULL,'2,60','Unidade','2017-11-27',1,'2017-07-30',1),(30,'Yakut',NULL,NULL,NULL,NULL,2,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2018-01-01',1,'2017-08-07',1),(32,'Amendoim Tio Joao',NULL,5,13,NULL,100,2,NULL,NULL,NULL,NULL,NULL,NULL,'0,50','Pacote','2017-10-30',0,'2017-10-23',1);
/*!40000 ALTER TABLE `tbl_produto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_subcategoria`
--

DROP TABLE IF EXISTS `tbl_subcategoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_subcategoria` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  `categoria` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `fk_categoria_idx` (`categoria`),
  KEY `fk_usuario6_idx` (`usuario`),
  CONSTRAINT `fk_categoria` FOREIGN KEY (`categoria`) REFERENCES `tbl_categoria` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_usuario6` FOREIGN KEY (`usuario`) REFERENCES `tbl_usuario` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_subcategoria`
--

LOCK TABLES `tbl_subcategoria` WRITE;
/*!40000 ALTER TABLE `tbl_subcategoria` DISABLE KEYS */;
INSERT INTO `tbl_subcategoria` VALUES (1,'Alcoolicos',3,1),(4,'Refrigerante',3,1),(6,'Doce',5,1),(7,'Lacteos',3,1),(13,'Salgado',5,1),(15,'Higiene',8,1),(32,'Alcool',8,1),(33,'Ãgua',3,1);
/*!40000 ALTER TABLE `tbl_subcategoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_unidade_medida`
--

DROP TABLE IF EXISTS `tbl_unidade_medida`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_unidade_medida` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  `usuario` int(11) NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `fk_usuario_idx` (`usuario`),
  CONSTRAINT `fk_usuario` FOREIGN KEY (`usuario`) REFERENCES `tbl_usuario` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_unidade_medida`
--

LOCK TABLES `tbl_unidade_medida` WRITE;
/*!40000 ALTER TABLE `tbl_unidade_medida` DISABLE KEYS */;
INSERT INTO `tbl_unidade_medida` VALUES (1,'Unidade',1),(2,'Pacote',1),(4,'Ampola',1),(5,'Garrafa',1),(7,'Caixa',1);
/*!40000 ALTER TABLE `tbl_unidade_medida` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_usuario`
--

DROP TABLE IF EXISTS `tbl_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_usuario` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(80) NOT NULL,
  `tipo_usuario` tinyint(1) DEFAULT '1',
  `senha` varchar(45) NOT NULL,
  `token_facebook` varchar(45) DEFAULT NULL,
  `token_google` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`codigo`),
  UNIQUE KEY `usuario_UNIQUE` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_usuario`
--

LOCK TABLES `tbl_usuario` WRITE;
/*!40000 ALTER TABLE `tbl_usuario` DISABLE KEYS */;
INSERT INTO `tbl_usuario` VALUES (1,'vale10@valix.com.br',1,'624a99211ed1e9351ecc18dfe9d05a86',NULL,NULL);
/*!40000 ALTER TABLE `tbl_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_usuario_cadastro`
--

DROP TABLE IF EXISTS `tbl_usuario_cadastro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_usuario_cadastro` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` int(11) NOT NULL,
  `nome` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `documento` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  `telefone` varchar(10) COLLATE latin1_general_ci DEFAULT NULL,
  `celular` varchar(11) COLLATE latin1_general_ci DEFAULT NULL,
  `email` varchar(80) COLLATE latin1_general_ci DEFAULT NULL,
  `endereco` varchar(150) COLLATE latin1_general_ci DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `complemento` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `cep` varchar(15) COLLATE latin1_general_ci DEFAULT NULL,
  `bairro` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `cidade` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `estado` varchar(2) COLLATE latin1_general_ci DEFAULT NULL,
  `data_cadastro` date DEFAULT NULL,
  PRIMARY KEY (`codigo`),
  UNIQUE KEY `usuario_UNIQUE` (`usuario`),
  KEY `fk_usuario9_idx` (`usuario`),
  CONSTRAINT `fk_usuario9` FOREIGN KEY (`usuario`) REFERENCES `tbl_usuario` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_usuario_cadastro`
--

LOCK TABLES `tbl_usuario_cadastro` WRITE;
/*!40000 ALTER TABLE `tbl_usuario_cadastro` DISABLE KEYS */;
INSERT INTO `tbl_usuario_cadastro` VALUES (5,1,'Administrador','11122233396','1134536299','11991115348','vale10@valix.com.br','Rua Ana Jarvis',400,'','09190110','Jardim Parado','Santo André','SP',NULL);
/*!40000 ALTER TABLE `tbl_usuario_cadastro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_usuario_config`
--

DROP TABLE IF EXISTS `tbl_usuario_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_usuario_config` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` int(11) NOT NULL,
  `aviso_validade` int(11) DEFAULT '7',
  `tipo_aviso_validade` tinyint(1) DEFAULT '1',
  `aviso_vencido` int(11) DEFAULT '5',
  `tipo_aviso_vencido` tinyint(1) DEFAULT '1',
  `receber_sms_validade` tinyint(1) DEFAULT '0',
  `receber_email_validade` tinyint(1) DEFAULT '1',
  `aviso_periodo` int(11) DEFAULT '15',
  `tipo_aviso_periodo` tinyint(1) DEFAULT '1',
  `receber_sms_periodo` tinyint(1) DEFAULT '0',
  `receber_email_periodo` tinyint(1) DEFAULT '1',
  `receber_aviso_periodo` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`codigo`),
  UNIQUE KEY `fk_usuario7_idx` (`usuario`),
  CONSTRAINT `fk_usuario7` FOREIGN KEY (`usuario`) REFERENCES `tbl_usuario` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_usuario_config`
--

LOCK TABLES `tbl_usuario_config` WRITE;
/*!40000 ALTER TABLE `tbl_usuario_config` DISABLE KEYS */;
INSERT INTO `tbl_usuario_config` VALUES (1,1,1,3,15,1,1,1,15,1,1,1,1);
/*!40000 ALTER TABLE `tbl_usuario_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_usuario_email`
--

DROP TABLE IF EXISTS `tbl_usuario_email`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_usuario_email` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(80) COLLATE latin1_general_ci DEFAULT NULL,
  `usuario` int(11) NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `fk_usuario_config_idx` (`usuario`),
  CONSTRAINT `fk_usuario10` FOREIGN KEY (`usuario`) REFERENCES `tbl_usuario` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=198 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_usuario_email`
--

LOCK TABLES `tbl_usuario_email` WRITE;
/*!40000 ALTER TABLE `tbl_usuario_email` DISABLE KEYS */;
INSERT INTO `tbl_usuario_email` VALUES (195,'vale10@valix.com.br',1);
/*!40000 ALTER TABLE `tbl_usuario_email` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_usuario_telefone`
--

DROP TABLE IF EXISTS `tbl_usuario_telefone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_usuario_telefone` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `telefone` varchar(15) COLLATE latin1_general_ci DEFAULT NULL,
  `usuario` int(11) NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `fk_usuario_config2_idx` (`usuario`),
  CONSTRAINT `fk_usuario11` FOREIGN KEY (`usuario`) REFERENCES `tbl_usuario` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_usuario_telefone`
--

LOCK TABLES `tbl_usuario_telefone` WRITE;
/*!40000 ALTER TABLE `tbl_usuario_telefone` DISABLE KEYS */;
INSERT INTO `tbl_usuario_telefone` VALUES (90,'11921537978',1);
/*!40000 ALTER TABLE `tbl_usuario_telefone` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-03-20 17:33:00
