-- MySQL dump 10.13  Distrib 8.2.0, for Win64 (x86_64)
--
-- Host: localhost    Database: decisiontree
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (4,'PROBLEME DE FONCTIONNEMENT GENERAL'),(5,'PROBLEME DE PRESSION'),(6,'PROBLEME DE CHAUFFE');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `diagnostic_steps`
--

DROP TABLE IF EXISTS `diagnostic_steps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `diagnostic_steps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `problem_type_id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `next_step_id` int(11) DEFAULT NULL,
  `next_step_ko_id` int(11) DEFAULT NULL,
  `description` longtext NOT NULL,
  `need_doc` tinyint(1) NOT NULL,
  `ordre` int(11) NOT NULL,
  `goto` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9F89B18F727ACA70` (`parent_id`),
  KEY `IDX_9F89B18FB13C343E` (`next_step_id`),
  KEY `IDX_9F89B18F236E4CE0` (`problem_type_id`),
  KEY `IDX_9F89B18F7130560A` (`next_step_ko_id`),
  CONSTRAINT `FK_9F89B18F236E4CE0` FOREIGN KEY (`problem_type_id`) REFERENCES `problem_type` (`id`),
  CONSTRAINT `FK_9F89B18F7130560A` FOREIGN KEY (`next_step_ko_id`) REFERENCES `diagnostic_steps` (`id`),
  CONSTRAINT `FK_9F89B18F727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `diagnostic_steps` (`id`),
  CONSTRAINT `FK_9F89B18FB13C343E` FOREIGN KEY (`next_step_id`) REFERENCES `diagnostic_steps` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=136 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `diagnostic_steps`
--

LOCK TABLES `diagnostic_steps` WRITE;
/*!40000 ALTER TABLE `diagnostic_steps` DISABLE KEYS */;
INSERT INTO `diagnostic_steps` VALUES (1,15,'symptome',NULL,2,NULL,'Le moteur de la pompe ne tourne pas ET le programmateur est ├®teint',0,1,NULL),(2,15,'check',1,4,3,'V├®rifier la position du bouton On/Off',0,2,NULL),(3,15,'action',2,NULL,NULL,'Mettre le bouton sur ON',0,3,NULL),(4,15,'check',2,6,5,'V├®rifier l\'arr├¬t d\'urgence (Tir├®)',0,4,NULL),(5,15,'action',4,NULL,NULL,'Tirer l\'Arr├¬t d\'urgence',0,5,NULL),(6,15,'check',4,8,7,'V├®rifier que le c├óble de la machine est correctement branch├®',0,6,NULL),(7,15,'action',6,NULL,NULL,'Brancher le c├óble correctement',0,7,NULL),(8,15,'check',6,129,9,'V├®rifier le disjoncteur de la \"maison\"',0,8,NULL),(9,15,'action',8,NULL,NULL,'R├®enclancher le disjoncteur, s\'assurrer qu\'il n\'y a rien d\'autre de brancher et qu\'il s\'agit d\'un 16A, le cas ├®ch├®ant changer de prise',0,9,NULL),(10,16,'symptome',NULL,NULL,NULL,'Identification du probl├¿me : PROGRAMMATEUR EN ERREUR (affiche ERR)',0,1,NULL),(11,16,'check',10,10,NULL,'V├®rifier l\'affichage du code d\'erreur',0,2,NULL),(12,16,'check',10,11,NULL,'V├®rifier les connexions du programmateur',0,3,NULL),(13,16,'check',10,12,NULL,'V├®rifier la tension d\'alimentation',0,4,NULL),(14,16,'check',10,13,NULL,'V├®rifier les capteurs connect├®s',0,5,NULL),(15,16,'action',10,14,NULL,'R├®initialiser le programmateur',0,6,NULL),(16,16,'action',10,15,NULL,'Remplacer le programmateur si n├®cessaire',0,7,NULL),(17,16,'action',10,16,NULL,'R├®tablir les connexions',0,8,NULL),(18,16,'action',10,17,NULL,'Mettre ├á jour le firmware',0,9,NULL),(19,17,'symptome',NULL,NULL,NULL,'Identification du probl├¿me : PROGRAMMATEUR ne s\'allume plus ou clignote',0,1,NULL),(20,17,'check',19,19,NULL,'V├®rifier l\'alimentation ├®lectrique',0,2,NULL),(21,17,'check',19,20,NULL,'V├®rifier le bouton d\'alimentation',0,3,NULL),(22,17,'check',19,21,NULL,'V├®rifier les connexions du programmateur',0,4,NULL),(23,17,'check',19,22,NULL,'V├®rifier l\'├®tat du fusible',0,5,NULL),(24,17,'action',19,23,NULL,'Remplacer le programmateur',0,6,NULL),(25,17,'action',19,24,NULL,'R├®parer les connexions',0,7,NULL),(26,17,'action',19,25,NULL,'Remplacer le bouton d\'alimentation',0,8,NULL),(27,17,'action',19,26,NULL,'Nettoyer les contacts',0,9,NULL),(28,18,'symptome',NULL,NULL,NULL,'Identification du probl├¿me : PLUS DE CONSOMMATION D\'ANTICALCAIRE',0,1,NULL),(29,18,'check',28,28,NULL,'V├®rifier le niveau d\'anticalcaire',0,2,NULL),(30,18,'check',28,29,NULL,'V├®rifier le syst├¿me de dosage',0,3,NULL),(31,18,'check',28,30,NULL,'V├®rifier les connexions du syst├¿me',0,4,NULL),(32,18,'check',28,31,NULL,'V├®rifier l\'├®tat du r├®servoir',0,5,NULL),(33,18,'action',28,32,NULL,'Recharger l\'anticalcaire',0,6,NULL),(34,18,'action',28,33,NULL,'Remplacer le syst├¿me de dosage',0,7,NULL),(35,18,'action',28,34,NULL,'Nettoyer le r├®servoir',0,8,NULL),(36,18,'action',28,35,NULL,'V├®rifier les param├¿tres de dosage',0,9,NULL),(37,19,'symptome',NULL,NULL,NULL,'Identification du probl├¿me : PAS DE PRESSION AU MANO (LA POMPE NE TOURNE PAS) ALORS QU\'ON APPUIE SUR LA GACHETTE',0,1,NULL),(38,19,'check',37,37,NULL,'V├®rifier le manom├¿tre',0,2,NULL),(39,19,'check',37,38,NULL,'V├®rifier la pompe',0,3,NULL),(40,19,'check',37,39,NULL,'V├®rifier les connexions ├®lectriques',0,4,NULL),(41,19,'check',37,40,NULL,'V├®rifier l\'├®tat du moteur',0,5,NULL),(42,19,'action',37,41,NULL,'Remplacer la pompe',0,6,NULL),(43,19,'action',37,42,NULL,'R├®parer les connexions ├®lectriques',0,7,NULL),(44,19,'action',37,43,NULL,'Remplacer le manom├¿tre',0,8,NULL),(45,19,'action',37,44,NULL,'Nettoyer les vannes',0,9,NULL),(46,20,'symptome',NULL,NULL,NULL,'Identification du probl├¿me : IMPOSSIBLE DE MONTER EN PRESSION SORTIE DE POMPE (AU MANO) et le moteur tourne',0,1,NULL),(47,20,'check',46,46,NULL,'V├®rifier le manom├¿tre',0,2,NULL),(48,20,'check',46,47,NULL,'V├®rifier les joints d\'├®tanch├®it├®',0,3,NULL),(49,20,'check',46,48,NULL,'V├®rifier l\'├®tat de la pompe',0,4,NULL),(50,20,'check',46,49,NULL,'V├®rifier les vannes',0,5,NULL),(51,20,'action',46,50,NULL,'Remplacer les joints d\'├®tanch├®it├®',0,6,NULL),(52,20,'action',46,51,NULL,'Remplacer la pompe',0,7,NULL),(53,20,'action',46,52,NULL,'Nettoyer les vannes',0,8,NULL),(54,20,'action',46,53,NULL,'Ajuster la pression',0,9,NULL),(55,21,'symptome',NULL,NULL,NULL,'Identification du probl├¿me : PRESSION OK AU MANO MAIS PAS OU PEU DE SORTIE D\'EAU AUX ACCESSOIRES',0,1,NULL),(56,21,'check',55,55,NULL,'V├®rifier les accessoires',0,2,NULL),(57,21,'check',55,56,NULL,'V├®rifier les tuyaux',0,3,NULL),(58,21,'check',55,57,NULL,'V├®rifier les filtres',0,4,NULL),(59,21,'check',55,58,NULL,'V├®rifier les vannes',0,5,NULL),(60,21,'action',55,59,NULL,'Nettoyer les accessoires',0,6,NULL),(61,21,'action',55,60,NULL,'Remplacer les tuyaux',0,7,NULL),(62,21,'action',55,61,NULL,'Nettoyer les filtres',0,8,NULL),(63,21,'action',55,62,NULL,'Ajuster les vannes',0,9,NULL),(64,22,'symptome',NULL,NULL,NULL,'Identification du probl├¿me : PRESSION SACCADEE',0,1,NULL),(65,22,'check',64,64,NULL,'V├®rifier le manom├¿tre',0,2,NULL),(66,22,'check',64,65,NULL,'V├®rifier la pompe',0,3,NULL),(67,22,'check',64,66,NULL,'V├®rifier les vannes',0,4,NULL),(68,22,'check',64,67,NULL,'V├®rifier les joints',0,5,NULL),(69,22,'action',64,68,NULL,'Remplacer le manom├¿tre',0,6,NULL),(70,22,'action',64,69,NULL,'Remplacer la pompe',0,7,NULL),(71,22,'action',64,70,NULL,'Nettoyer les vannes',0,8,NULL),(72,22,'action',64,71,NULL,'Ajuster la pression',0,9,NULL),(73,23,'symptome',NULL,NULL,NULL,'Identification du probl├¿me : LA MACHINE NE CHAUFFE PLUS VOYANT VERT ALLUME',0,1,NULL),(74,23,'check',73,73,NULL,'V├®rifier la r├®sistance',0,2,NULL),(75,23,'check',73,74,NULL,'V├®rifier le thermostat',0,3,NULL),(76,23,'check',73,75,NULL,'V├®rifier les connexions ├®lectriques',0,4,NULL),(77,23,'check',73,76,NULL,'V├®rifier l\'├®tat du voyant',0,5,NULL),(78,23,'action',73,77,NULL,'Remplacer la r├®sistance',0,6,NULL),(79,23,'action',73,78,NULL,'Remplacer le thermostat',0,7,NULL),(80,23,'action',73,79,NULL,'R├®parer les connexions',0,8,NULL),(81,23,'action',73,80,NULL,'Nettoyer les contacts',0,9,NULL),(82,24,'symptome',NULL,NULL,NULL,'Identification du probl├¿me : LA MACHINE NE CHAUFFE PLUS VOYANT VERT RESTE ETEINT',0,1,NULL),(83,24,'check',82,82,NULL,'V├®rifier le voyant',0,2,NULL),(84,24,'check',82,83,NULL,'V├®rifier le thermostat',0,3,NULL),(85,24,'check',82,84,NULL,'V├®rifier les connexions',0,4,NULL),(86,24,'check',82,85,NULL,'V├®rifier la r├®sistance',0,5,NULL),(87,24,'action',82,86,NULL,'Remplacer le thermostat',0,6,NULL),(88,24,'action',82,87,NULL,'Remplacer la r├®sistance',0,7,NULL),(89,24,'action',82,88,NULL,'R├®parer les connexions',0,8,NULL),(90,24,'action',82,89,NULL,'Nettoyer les contacts',0,9,NULL),(91,25,'symptome',NULL,NULL,NULL,'Identification du probl├¿me : LA MACHINE NE CHAUFFE PAS ASSEZ',0,1,NULL),(92,25,'check',91,91,NULL,'V├®rifier la temp├®rature',0,2,NULL),(93,25,'check',91,92,NULL,'V├®rifier le thermostat',0,3,NULL),(94,25,'check',91,93,NULL,'V├®rifier la r├®sistance',0,4,NULL),(95,25,'check',91,94,NULL,'V├®rifier les param├¿tres',0,5,NULL),(96,25,'action',91,95,NULL,'Ajuster le thermostat',0,6,NULL),(97,25,'action',91,96,NULL,'Remplacer la r├®sistance',0,7,NULL),(98,25,'action',91,97,NULL,'Nettoyer les composants',0,8,NULL),(99,25,'action',91,98,NULL,'Mettre ├á jour les param├¿tres',0,9,NULL),(100,26,'symptome',NULL,NULL,NULL,'Identification du probl├¿me : VOYANT VERT S\'ETEINT JUSQU\'A UNE TEMPERATURE RELATIVEMENT BASSE',0,1,NULL),(101,26,'check',100,100,NULL,'V├®rifier le thermostat',0,2,NULL),(102,26,'check',100,101,NULL,'V├®rifier la temp├®rature',0,3,NULL),(103,26,'check',100,102,NULL,'V├®rifier le voyant',0,4,NULL),(104,26,'check',100,103,NULL,'V├®rifier les param├¿tres',0,5,NULL),(105,26,'action',100,104,NULL,'Remplacer le thermostat',0,6,NULL),(106,26,'action',100,105,NULL,'Ajuster les param├¿tres',0,7,NULL),(107,26,'action',100,106,NULL,'Nettoyer les composants',0,8,NULL),(108,26,'action',100,107,NULL,'V├®rifier la calibration',0,9,NULL),(109,27,'symptome',NULL,NULL,NULL,'Identification du probl├¿me : LA MACHINE MONTE TROP EN TEMPERATURE',0,1,NULL),(110,27,'check',109,109,NULL,'V├®rifier le thermostat',0,2,NULL),(111,27,'check',109,110,NULL,'V├®rifier la temp├®rature',0,3,NULL),(112,27,'check',109,111,NULL,'V├®rifier la r├®sistance',0,4,NULL),(113,27,'check',109,112,NULL,'V├®rifier les param├¿tres',0,5,NULL),(114,27,'action',109,113,NULL,'Remplacer le thermostat',0,6,NULL),(115,27,'action',109,114,NULL,'Ajuster les param├¿tres',0,7,NULL),(116,27,'action',109,115,NULL,'Nettoyer les composants',0,8,NULL),(117,27,'action',109,116,NULL,'V├®rifier la ventilation',0,9,NULL),(118,28,'symptome',NULL,NULL,NULL,'Identification du probl├¿me : LA MACHINE FUME BEAUCOUP',0,1,NULL),(119,28,'check',118,118,NULL,'V├®rifier la temp├®rature',0,2,NULL),(120,28,'check',118,119,NULL,'V├®rifier les joints',0,3,NULL),(121,28,'check',118,120,NULL,'V├®rifier la r├®sistance',0,4,NULL),(122,28,'check',118,121,NULL,'V├®rifier l\'├®tat g├®n├®ral',0,5,NULL),(123,28,'action',118,122,NULL,'Remplacer les joints',0,6,NULL),(124,28,'action',118,123,NULL,'Nettoyer les composants',0,7,NULL),(125,28,'action',118,124,NULL,'Ajuster la temp├®rature',0,8,NULL),(126,28,'action',118,125,NULL,'V├®rifier la ventilation',0,9,NULL),(127,15,'symptome',NULL,NULL,NULL,'Le moteur de la pompe ne tourne pas ET le programmateur est allum├®',0,2,0),(128,15,'symptome',NULL,NULL,NULL,'Le moteur de la pompe tourne ET le programmateur est ├®teint',0,3,0),(129,15,'check',8,131,130,'V├®rifier l\'enrouleur / Tester avec un autre enrouleur',0,9,NULL),(130,15,'action',129,NULL,NULL,'Changer d\'enrouleur (Min section 2,5)',0,10,NULL),(131,15,'check',129,133,132,'V├®rifier le disjoncteur principal de la machine dans coffret ├®lectrique',0,11,NULL),(132,15,'action',131,NULL,NULL,'R├®enclancher le disjoncteur, si le probl├¿me revient -> appeler le SAV 0681676430',0,12,NULL),(133,15,'check',131,135,134,'Tester continuit├® de l\'alimentation ├®lectrique au voltm├¿tre',1,13,NULL),(134,15,'action',133,NULL,NULL,'Une fois identifi├® o├╣ cela se passe, appeler le SAV',0,14,NULL),(135,15,'action',133,NULL,NULL,'Appeler le SAV 0681676430',0,15,NULL);
/*!40000 ALTER TABLE `diagnostic_steps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20250408114601','2025-04-08 15:10:24',217);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `problem_type`
--

DROP TABLE IF EXISTS `problem_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `problem_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_56D1406B12469DE2` (`category_id`),
  CONSTRAINT `FK_56D1406B12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `problem_type`
--

LOCK TABLES `problem_type` WRITE;
/*!40000 ALTER TABLE `problem_type` DISABLE KEYS */;
INSERT INTO `problem_type` VALUES (15,4,'LA MACHINE NE DEMARRE PAS'),(16,4,'PROGRAMMATEUR EN ERREUR (affiche ERR)'),(17,4,'PROGRAMMATEUR ne s\'allume plus ou clignote'),(18,4,'PLUS DE CONSOMMATION D\'ANTICALCAIRE'),(19,5,'PAS DE PRESSION AU MANO (LA POMPE NE TOURNE PAS) ALORS QU\'ON APPUIE SUR LA GACHETTE'),(20,5,'IMPOSSIBLE DE MONTER EN PRESSION SORTIE DE POMPE (AU MANO) et le moteur tourne'),(21,5,'PRESSION OK AU MANO MAIS PAS OU PEU DE SORTIE D\'EAU AUX ACCESSOIRES'),(22,5,'PRESSION SACCADEE'),(23,6,'LA MACHINE NE CHAUFFE PLUS VOYANT VERT ALLUME'),(24,6,'LA MACHINE NE CHAUFFE PLUS VOYANT VERT RESTE ETEINT'),(25,6,'LA MACHINE NE CHAUFFE PAS ASSEZ'),(26,6,'VOYANT VERT S\'ETEINT JUSQU\'A UNE TEMPERATURE RELATIVEMENT BASSE'),(27,6,'LA MACHINE MONTE TROP EN TEMPERATURE'),(28,6,'LA MACHINE FUME BEAUCOUP');
/*!40000 ALTER TABLE `problem_type` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-09 18:01:14
