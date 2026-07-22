-- MySQL dump 10.13  Distrib 8.4.10, for Linux (x86_64)
--
-- Host: localhost    Database: laravel
-- ------------------------------------------------------
-- Server version	8.4.10

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
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `certificados_coa`
--

DROP TABLE IF EXISTS `certificados_coa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `certificados_coa` (
  `idLote` varchar(50) NOT NULL,
  `pdfCertificadoUrl` varchar(255) NOT NULL,
  `fechaAnalisis` date NOT NULL,
  PRIMARY KEY (`idLote`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `certificados_coa`
--

LOCK TABLES `certificados_coa` WRITE;
/*!40000 ALTER TABLE `certificados_coa` DISABLE KEYS */;
INSERT INTO `certificados_coa` VALUES ('LOTE-2026-A1','http://localhost/Weedy/certs/coa-a1.pdf','2026-05-12'),('LOTE-2026-B2','http://localhost/Weedy/certs/coa-b2.pdf','2026-06-01'),('LOTE-2026-C3','http://localhost/Weedy/certs/coa-c3.pdf','2026-07-10');
/*!40000 ALTER TABLE `certificados_coa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `citas_telemedicina`
--

DROP TABLE IF EXISTS `citas_telemedicina`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `citas_telemedicina` (
  `idCita` varchar(50) NOT NULL,
  `fechaHora` datetime NOT NULL,
  `linkVideollamada` varchar(255) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `idMedico` varchar(50) NOT NULL,
  PRIMARY KEY (`idCita`),
  KEY `fk_citas_medico` (`idMedico`),
  CONSTRAINT `fk_citas_medico` FOREIGN KEY (`idMedico`) REFERENCES `personal_medico` (`idUsuario`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `citas_telemedicina`
--

LOCK TABLES `citas_telemedicina` WRITE;
/*!40000 ALTER TABLE `citas_telemedicina` DISABLE KEYS */;
/*!40000 ALTER TABLE `citas_telemedicina` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `diarios_dosificacion`
--

DROP TABLE IF EXISTS `diarios_dosificacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `diarios_dosificacion` (
  `idPaciente` varchar(50) NOT NULL,
  `idCita` varchar(50) NOT NULL,
  `registrosSintomas` text,
  `nivelDolor` int NOT NULL,
  `fechaRegistro` date NOT NULL,
  PRIMARY KEY (`idPaciente`,`idCita`),
  KEY `fk_diario_cita` (`idCita`),
  CONSTRAINT `fk_diario_cita` FOREIGN KEY (`idCita`) REFERENCES `citas_telemedicina` (`idCita`) ON UPDATE CASCADE,
  CONSTRAINT `fk_diario_paciente` FOREIGN KEY (`idPaciente`) REFERENCES `pacientes` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `diarios_dosificacion`
--

LOCK TABLES `diarios_dosificacion` WRITE;
/*!40000 ALTER TABLE `diarios_dosificacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `diarios_dosificacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empleados`
--

DROP TABLE IF EXISTS `empleados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `empleados` (
  `idUsuario` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `rol` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idUsuario`),
  CONSTRAINT `fk_empleados_usuarios` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empleados`
--

LOCK TABLES `empleados` WRITE;
/*!40000 ALTER TABLE `empleados` DISABLE KEYS */;
INSERT INTO `empleados` VALUES ('EMP-001','Administrador','2026-07-21 20:52:27','2026-07-21 21:03:55');
/*!40000 ALTER TABLE `empleados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `farmacos`
--

DROP TABLE IF EXISTS `farmacos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `farmacos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cepa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thc_porcentaje` decimal(5,2) NOT NULL,
  `cbd_porcentaje` decimal(5,2) NOT NULL,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `presentacion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `precio` decimal(8,2) NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `categoria` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `farmacos`
--

LOCK TABLES `farmacos` WRITE;
/*!40000 ALTER TABLE `farmacos` DISABLE KEYS */;
INSERT INTO `farmacos` VALUES (1,'Morita','Cocaina',50.00,50.00,'Sexo','si',NULL,20.00,1,NULL,'2026-07-18 20:22:36','2026-07-18 20:22:36');
/*!40000 ALTER TABLE `farmacos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incidencias`
--

DROP TABLE IF EXISTS `incidencias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `incidencias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) DEFAULT NULL,
  `estado` varchar(50) DEFAULT 'Abierta',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incidencias`
--

LOCK TABLES `incidencias` WRITE;
/*!40000 ALTER TABLE `incidencias` DISABLE KEYS */;
/*!40000 ALTER TABLE `incidencias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_07_18_184049_create_producto_farms_table',1),(5,'2026_07_18_184050_create_cita_telemedicinas_table',1),(6,'2026_07_18_184052_create_recipe_digitals_table',1),(7,'2026_07_18_184053_create_pedido_envios_table',1),(8,'2026_07_18_184102_add_rol_to_users_table',1),(9,'2026_07_18_193730_create_farmacos_table',2),(10,'2026_07_18_194353_update_farmacos_table_fields',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pacientes`
--

DROP TABLE IF EXISTS `pacientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pacientes` (
  `idUsuario` varchar(50) NOT NULL,
  `documentosValidacion` text,
  `historialClinico` text,
  PRIMARY KEY (`idUsuario`),
  CONSTRAINT `fk_pacientes_usuarios` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pacientes`
--

LOCK TABLES `pacientes` WRITE;
/*!40000 ALTER TABLE `pacientes` DISABLE KEYS */;
INSERT INTO `pacientes` VALUES ('USR-002','Cedula de identidad validada y digitalizada.','Paciente sin antecedentes alrgicos previos.');
/*!40000 ALTER TABLE `pacientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedido_productos`
--

DROP TABLE IF EXISTS `pedido_productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedido_productos` (
  `idPedido` varchar(50) NOT NULL,
  `idProducto` varchar(50) NOT NULL,
  `cantidad` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`idPedido`,`idProducto`),
  KEY `fk_det_producto` (`idProducto`),
  CONSTRAINT `fk_det_pedido` FOREIGN KEY (`idPedido`) REFERENCES `pedidos_envio` (`idPedido`) ON DELETE CASCADE,
  CONSTRAINT `fk_det_producto` FOREIGN KEY (`idProducto`) REFERENCES `productos_farma` (`idProducto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedido_productos`
--

LOCK TABLES `pedido_productos` WRITE;
/*!40000 ALTER TABLE `pedido_productos` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedido_productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedidos_envio`
--

DROP TABLE IF EXISTS `pedidos_envio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedidos_envio` (
  `idPedido` varchar(50) NOT NULL,
  `trackingNumber` varchar(100) DEFAULT NULL,
  `direccionEntrega` varchar(255) NOT NULL,
  `estadoEnvio` varchar(50) NOT NULL,
  `idRecipe` varchar(50) NOT NULL,
  `idUsuario` varchar(50) DEFAULT NULL,
  `notas` text,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idPedido`),
  KEY `fk_pedidos_recipes` (`idRecipe`),
  CONSTRAINT `fk_pedidos_recipes` FOREIGN KEY (`idRecipe`) REFERENCES `recipes_digitales` (`idRecipe`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos_envio`
--

LOCK TABLES `pedidos_envio` WRITE;
/*!40000 ALTER TABLE `pedidos_envio` DISABLE KEYS */;
INSERT INTO `pedidos_envio` VALUES ('ORD-001','TRK-999','Calle Los Robles, La Asuncin','Rechazado','REC-100',NULL,NULL,'2026-07-21 18:04:08',NULL),('ORD-002','TRK-987654322','La Asuncin, Calle Los Mangos, Casa #45','Pendiente','REC-789','USER-001','penecion','2026-07-21 17:45:30',NULL);
/*!40000 ALTER TABLE `pedidos_envio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_logistica`
--

DROP TABLE IF EXISTS `personal_logistica`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_logistica` (
  `idUsuario` varchar(50) NOT NULL,
  `idAlmacen` varchar(50) NOT NULL,
  PRIMARY KEY (`idUsuario`),
  CONSTRAINT `fk_logistica_usuarios` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_logistica`
--

LOCK TABLES `personal_logistica` WRITE;
/*!40000 ALTER TABLE `personal_logistica` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_logistica` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_medico`
--

DROP TABLE IF EXISTS `personal_medico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_medico` (
  `idUsuario` varchar(50) NOT NULL,
  `numeroLicencia` varchar(100) NOT NULL,
  `especialidad` varchar(150) NOT NULL,
  `agendaDisponible` text,
  PRIMARY KEY (`idUsuario`),
  UNIQUE KEY `numeroLicencia` (`numeroLicencia`),
  CONSTRAINT `fk_medico_usuarios` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_medico`
--

LOCK TABLES `personal_medico` WRITE;
/*!40000 ALTER TABLE `personal_medico` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_medico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos_farma`
--

DROP TABLE IF EXISTS `productos_farma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos_farma` (
  `idProducto` varchar(50) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `concentracionCBD_THC` varchar(100) NOT NULL,
  `stockDisponible` int NOT NULL DEFAULT '0',
  `precio` double(10,2) NOT NULL,
  `idLote` varchar(50) NOT NULL,
  PRIMARY KEY (`idProducto`),
  KEY `fk_productos_coa` (`idLote`),
  CONSTRAINT `fk_productos_coa` FOREIGN KEY (`idLote`) REFERENCES `certificados_coa` (`idLote`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos_farma`
--

LOCK TABLES `productos_farma` WRITE;
/*!40000 ALTER TABLE `productos_farma` DISABLE KEYS */;
INSERT INTO `productos_farma` VALUES ('PROD-CAP-03','Cápsulas Blandas de Espectro Completo','25mg CBD por cápsula',60,48.00,'LOTE-2026-B2'),('PROD-CBD-01','Aceite Medicinal CBD 10% - Gotero 30ml','10% CBD / 0.5% THC',150,35.00,'LOTE-2026-A1'),('PROD-CRE-04','Bálsamo Terapéutico Hidratante Botánico','2% CBD / 0% THC',10,19.99,'LOTE-2026-C3');
/*!40000 ALTER TABLE `productos_farma` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recipes_digitales`
--

DROP TABLE IF EXISTS `recipes_digitales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `recipes_digitales` (
  `idRecipe` varchar(50) NOT NULL,
  `codigoQR` varchar(255) NOT NULL,
  `tokenCifrado` varchar(255) NOT NULL,
  `fechaVencimiento` date NOT NULL,
  `idCita` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idRecipe`),
  UNIQUE KEY `idCita` (`idCita`),
  CONSTRAINT `fk_recipes_citas` FOREIGN KEY (`idCita`) REFERENCES `citas_telemedicina` (`idCita`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recipes_digitales`
--

LOCK TABLES `recipes_digitales` WRITE;
/*!40000 ALTER TABLE `recipes_digitales` DISABLE KEYS */;
INSERT INTO `recipes_digitales` VALUES ('REC-100','QR-DEMO-123','TOKEN-XYZ-789','2026-12-31',NULL),('REC-789','','','0000-00-00',NULL);
/*!40000 ALTER TABLE `recipes_digitales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('dQhIMQgkUVAIxYI9uAhEVP6VSxwZ0Iqdq89OC1Y0',NULL,'172.18.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJoUnVSbFplZkt1aHY2Q3dZQjA2b3JXaEpJSXMzaHp6VW9ROWxtZjNZIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvYWRtaW5cL2VtcGxlYWRvcyIsInJvdXRlIjpudWxsfSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1784667867);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `rol` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'paciente',
  `documento_identidad` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Paciente Prueba','paciente@test.com',NULL,'$2y$12$cshIRkX1exbbWaiJYDgbROEiLnHINpQTdHq9QCXpcs.Nb2ruPudjy',NULL,'2026-07-18 19:15:14','2026-07-18 19:15:14','paciente',NULL),(2,'Doctor Prueba','doctor@test.com',NULL,'$2y$12$AX/v0bLiq6viZQScUCOdg.4AbwMwfgCmKdZ0ZFVBIfJaFVCeF6uQy',NULL,'2026-07-18 19:15:28','2026-07-18 19:23:37','medico',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `idUsuario` varchar(50) NOT NULL,
  `nombreCompleto` varchar(255) NOT NULL,
  `correoElectronico` varchar(150) NOT NULL,
  `cedulaIdentidad` varchar(50) NOT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idUsuario`),
  UNIQUE KEY `correoElectronico` (`correoElectronico`),
  UNIQUE KEY `cedulaIdentidad` (`cedulaIdentidad`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES ('EMP-001','Ana Lpez','ana.admin@example.com','V-15888999','0412-1112233'),('USER-001','Miguel Luna','miguel@weedy.com','V-30123456','0412-5557788'),('USR-002','Carlos Rodrguez','carlos@example.com','V-26543210','0414-5551233');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-07-21 22:11:44
