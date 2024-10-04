-- MySQL dump 10.13  Distrib 5.7.24, for osx11.1 (x86_64)
--
-- Host: localhost    Database: pokemon
-- ------------------------------------------------------
-- Server version	9.0.1

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
-- Table structure for table `api_utilisateur`
--

DROP TABLE IF EXISTS `api_utilisateur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `api_utilisateur` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `prenom` varchar(150) NOT NULL,
  `nom` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telephone` varchar(15) NOT NULL,
  `date_naissance` date NOT NULL,
  `mdp` varchar(150) NOT NULL,
  `statut` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `api_utilisateur`
--

LOCK TABLES `api_utilisateur` WRITE;
/*!40000 ALTER TABLE `api_utilisateur` DISABLE KEYS */;
INSERT INTO `api_utilisateur` VALUES (1,'amine','m\'zali','mza@gmail.com','0606060606','2006-06-06','06060606','admin'),(2,'2','a','a@a.com','a','1111-11-11','a','admin');
/*!40000 ALTER TABLE `api_utilisateur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `avis`
--

DROP TABLE IF EXISTS `avis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `avis` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int NOT NULL,
  `produit_id` int NOT NULL,
  `commentaire` text NOT NULL,
  `note` int DEFAULT NULL,
  `date_creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `utilisateur_id` (`utilisateur_id`),
  KEY `produit_id` (`produit_id`),
  CONSTRAINT `avis_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`),
  CONSTRAINT `avis_ibfk_2` FOREIGN KEY (`produit_id`) REFERENCES `pokedex` (`id`),
  CONSTRAINT `avis_chk_1` CHECK ((`note` between 1 and 5))
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `avis`
--

LOCK TABLES `avis` WRITE;
/*!40000 ALTER TABLE `avis` DISABLE KEYS */;
INSERT INTO `avis` VALUES (1,1,1,'Excellent produit, je recommande !',5,'2024-10-04 13:18:45'),(2,2,2,'Bon produit mais un peu cher.',4,'2024-10-04 13:18:45'),(3,3,3,'Correct mais pourrait être amélioré.',3,'2024-10-04 13:18:45'),(4,4,1,'Pas satisfait, le produit est arrivé endommagé.',2,'2024-10-04 13:18:45'),(5,1,3,'Très bon produit pour son prix.',4,'2024-10-04 13:18:45');
/*!40000 ALTER TABLE `avis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commande_produit`
--

DROP TABLE IF EXISTS `commande_produit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commande_produit` (
  `id` int NOT NULL AUTO_INCREMENT,
  `commande_id` int NOT NULL,
  `produit_id` int NOT NULL,
  `quantite` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `commande_id` (`commande_id`),
  KEY `produit_id` (`produit_id`),
  CONSTRAINT `commande_produit_ibfk_1` FOREIGN KEY (`commande_id`) REFERENCES `commandes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `commande_produit_ibfk_2` FOREIGN KEY (`produit_id`) REFERENCES `pokedex` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commande_produit`
--

LOCK TABLES `commande_produit` WRITE;
/*!40000 ALTER TABLE `commande_produit` DISABLE KEYS */;
INSERT INTO `commande_produit` VALUES (3,28,1,2),(4,28,2,3),(5,44,1,2),(6,44,2,1),(7,44,3,5);
/*!40000 ALTER TABLE `commande_produit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commande_produits`
--

DROP TABLE IF EXISTS `commande_produits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commande_produits` (
  `id` int NOT NULL AUTO_INCREMENT,
  `commande_id` int DEFAULT NULL,
  `produit_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `commande_id` (`commande_id`),
  KEY `produit_id` (`produit_id`),
  CONSTRAINT `commande_produits_ibfk_1` FOREIGN KEY (`commande_id`) REFERENCES `commandes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `commande_produits_ibfk_2` FOREIGN KEY (`produit_id`) REFERENCES `pokedex` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commande_produits`
--

LOCK TABLES `commande_produits` WRITE;
/*!40000 ALTER TABLE `commande_produits` DISABLE KEYS */;
/*!40000 ALTER TABLE `commande_produits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commandes`
--

DROP TABLE IF EXISTS `commandes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commandes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int NOT NULL,
  `adresse_livraison` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ville` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `code_postal` int NOT NULL,
  `livraison` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `total` decimal(7,2) NOT NULL,
  `numero_commande` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `statut` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'EN_TRAITEMENT',
  PRIMARY KEY (`id`),
  KEY `utilisateur_id` (`utilisateur_id`),
  CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commandes`
--

LOCK TABLES `commandes` WRITE;
/*!40000 ALTER TABLE `commandes` DISABLE KEYS */;
INSERT INTO `commandes` VALUES (17,2,'oui3','Cergy',95000,'0',2407.00,'6642a9f93e722','2024-05-14 02:02:01','LIVREE'),(18,2,'oui4','Cergy',95000,'0',600.00,'6642ac1ee83c0','2024-05-14 02:11:10','EN_TRAITEMENT'),(19,2,'oui4','Cergy',95000,'0',600.00,'6642ac91df91a','2024-05-14 02:13:05','EN_TRAITEMENT'),(20,2,'oui4','Cergy',95000,'0',600.00,'6642ac9300e87','2024-05-10 02:13:07','EN_TRAITEMENT'),(21,2,'oui4','Cergy',95000,'0',600.00,'6642ac93d5341','2024-05-10 02:13:07','EN_TRAITEMENT'),(22,2,'456 rue de la Victoire','Cergy',95000,'0',600.00,'6642ac944ff57','2024-05-12 02:13:08','EN_TRAITEMENT'),(23,2,'oui4','Cergy',95000,'0',600.00,'6642ac9a9d45b','2024-05-14 02:13:14','EN_TRAITEMENT'),(24,2,'oui4','Cergy',95000,'0',600.00,'6642acbdad58d','2024-05-13 02:13:49','EN_TRAITEMENT'),(25,2,'oui5','Cergy',95000,'0',17898.00,'6642ad3350916','2024-05-14 02:15:47','EN_TRAITEMENT'),(26,2,'oui10','Cergy',95000,'0',1753.00,'6642ad9dcaa83','2024-05-14 02:17:33','EN_TRAITEMENT'),(27,2,'oui11','Cergy',95000,'0',1969.00,'6642ae266369d','2024-05-10 02:19:50','EN_TRAITEMENT'),(28,1,'123 Rue de la Paix','Paris',75001,'Standard',59.99,'CMD123456','2024-10-01 19:13:40','EN_TRAITEMENT'),(29,1,'123 Rue Example','Paris',75001,'Express',150.00,'CMD123456','2024-10-01 21:29:24','EN_TRAITEMENT'),(30,1,'123 Rue Example','Paris',75001,'Express',150.00,'CMD123456','2024-10-01 21:32:00','EN_TRAITEMENT'),(31,17,'123 Rue de la Paix','Paris',75001,'Standard',59.99,'CMD123456','2024-10-03 11:33:39','EN_TRAITEMENT'),(32,17,'456 Avenue des Champs','Lyon',69001,'Express',149.99,'CMD123457','2024-10-03 11:33:39','EXPEDIEE'),(33,17,'789 Boulevard Saint-Germain','Marseille',13001,'Express',199.99,'CMD123458','2024-10-03 11:33:39','LIVREE'),(34,18,'123 Rue Exemple','Paris',75001,'Express',150.00,'CMD123456','2024-10-04 12:23:58','EN_TRAITEMENT'),(35,18,'123 Rue Exemple','Paris',75001,'Express',150.00,'CMD123456','2024-10-04 12:25:03','EN_TRAITEMENT'),(36,18,'123 Rue Exemple','Paris',75001,'Express',150.00,'CMD123456','2024-10-04 12:25:10','EN_TRAITEMENT'),(37,18,'123 Rue Exemple','Paris',75001,'Express',150.00,'CMD123456','2024-10-04 12:26:50','EN_TRAITEMENT'),(38,17,'123 Rue Exemple','Paris',75001,'Express',150.00,'CMD123456','2024-10-04 12:34:58','EN_TRAITEMENT'),(39,17,'123 Rue Exemple','Paris',75001,'Express',150.00,'CMD123456','2024-10-04 12:35:10','EN_TRAITEMENT'),(40,17,'123 Rue Exemple','Paris',75001,'Express',150.00,'CMD123456','2024-10-04 12:41:30','EN_TRAITEMENT'),(41,1,'123 rue de la Paix','Paris',75001,'standard',99.99,'1234444','2024-10-04 13:06:49','EN_TRAITEMENT'),(42,17,'123 rue de la Paix','Paris',75001,'standard',99.99,'1234444','2024-10-04 13:07:22','EN_TRAITEMENT'),(43,17,'123 rue de la Paix','Paris',75001,'standard',99.99,'1234444','2024-10-04 13:15:33','EN_TRAITEMENT'),(44,17,'123 rue de la Paix','Paris',75001,'standard',99.99,'1234444','2024-10-04 13:16:03','EN_TRAITEMENT');
/*!40000 ALTER TABLE `commandes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `django_migrations`
--

DROP TABLE IF EXISTS `django_migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `django_migrations` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `app` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `applied` datetime(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `django_migrations`
--

LOCK TABLES `django_migrations` WRITE;
/*!40000 ALTER TABLE `django_migrations` DISABLE KEYS */;
INSERT INTO `django_migrations` VALUES (1,'contenttypes','0001_initial','2024-09-26 08:56:00.136003'),(2,'auth','0001_initial','2024-09-26 08:56:00.383479'),(3,'admin','0001_initial','2024-09-26 08:56:00.473185'),(4,'admin','0002_logentry_remove_auto_add','2024-09-26 08:56:00.477174'),(5,'admin','0003_logentry_add_action_flag_choices','2024-09-26 08:56:00.480164'),(6,'contenttypes','0002_remove_content_type_name','2024-09-26 09:28:40.557723'),(7,'auth','0002_alter_permission_name_max_length','2024-09-26 09:28:40.575674'),(8,'auth','0003_alter_user_email_max_length','2024-09-26 09:28:40.595608'),(9,'auth','0004_alter_user_username_opts','2024-09-26 09:28:40.598598'),(10,'auth','0005_alter_user_last_login_null','2024-09-26 09:28:40.617541'),(11,'auth','0006_require_contenttypes_0002','2024-09-26 09:28:40.618538'),(12,'auth','0007_alter_validators_add_error_messages','2024-09-26 09:28:40.622524'),(13,'auth','0008_alter_user_username_max_length','2024-09-26 09:28:40.643744'),(14,'auth','0009_alter_user_last_name_max_length','2024-09-26 09:28:40.664685'),(15,'auth','0010_alter_group_name_max_length','2024-09-26 09:28:40.682614'),(16,'auth','0011_update_proxy_permissions','2024-09-26 09:28:40.688593'),(17,'auth','0012_alter_user_first_name_max_length','2024-09-26 09:28:40.706542'),(18,'sessions','0001_initial','2024-09-26 09:28:40.726097'),(19,'api','0001_initial','2024-09-26 09:40:00.641132'),(22,'api','0002_alter_commande_table_alter_utilisateur_table','2024-09-26 12:42:39.855250'),(23,'api','0003_alter_commande_table_alter_utilisateur_table','2024-09-26 12:42:39.861239'),(24,'api','0002_pokedex','2024-09-26 12:45:43.381217');
/*!40000 ALTER TABLE `django_migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ligne_commandes`
--

DROP TABLE IF EXISTS `ligne_commandes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ligne_commandes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_commande` varchar(255) NOT NULL,
  `pokemon` json NOT NULL COMMENT 'Id_Pokemon : Quantité',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ligne_commandes`
--

LOCK TABLES `ligne_commandes` WRITE;
/*!40000 ALTER TABLE `ligne_commandes` DISABLE KEYS */;
INSERT INTO `ligne_commandes` VALUES (28,'28','{\"3\": 2, \"6\": 3}'),(29,'29','{\"3\": 1}'),(30,'31','{\"1\": 1}'),(31,'32','{\"65\": 1, \"149\": 1}'),(32,'33','{\"5\": 1, \"9\": 1, \"151\": 1}'),(33,'34','{\"4\": 1}'),(34,'35','{\"3\": 1}'),(35,'36','{\"3\": 1}');
/*!40000 ALTER TABLE `ligne_commandes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paiement`
--

DROP TABLE IF EXISTS `paiement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paiement` (
  `id` int NOT NULL AUTO_INCREMENT,
  `transaction_id` varchar(100) NOT NULL,
  `commande_id` int NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `statut` varchar(10) NOT NULL DEFAULT 'en_attente',
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `transaction_id` (`transaction_id`),
  KEY `fk_commande` (`commande_id`),
  CONSTRAINT `fk_commande` FOREIGN KEY (`commande_id`) REFERENCES `commandes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paiement`
--

LOCK TABLES `paiement` WRITE;
/*!40000 ALTER TABLE `paiement` DISABLE KEYS */;
INSERT INTO `paiement` VALUES (1,'cs_test_a1n5fq5D8EFtw0CUaWaGJzFFDPKfZ6pJaSjAwTMStg6thc3mW3Fdrcmu6S',17,100.00,'en_attente','2024-09-27 19:55:56'),(2,'cs_test_a1bhvHpbWtWanWqZMNLI7fwGjOZJ3vJ1ZyLM9m1yceqAxT5NEQwCohgBCw',18,123.00,'en_attente','2024-09-28 17:20:11'),(3,'cs_test_a1IJZqUw01uETZOvejwa9aTtu8vBcEpf5LRSdqPZnWPDyHcYmLmwRrvIUk',17,555.00,'valide','2024-09-28 17:35:10'),(4,'cs_test_a1TQ65Qd9KcVtbaxl3ALgkRAcFp3h8qBGtDjf0lw5VrDWT8nag3HWzsu52',17,7998.00,'en_attente','2024-09-28 17:44:52'),(5,'cs_test_a1papC8VV6lKtsL6a3EqGrg0xcIOn2I46ZJQTMPd5VH5hCFpUMWuVDH6qC',17,767.00,'en_attente','2024-09-28 18:06:22'),(6,'cs_test_a12i57g24pzlU5tbTqpCYKPPuA87Spw7Uu1oNwaWC9aLZRTDwYxTuDFWG8',20,7895.00,'valide','2024-09-28 18:09:42'),(7,'cs_test_a1LBaSZSvaAuCVHrPj13X7fS4m7UIVgqoxoOO7QymotJtUHYpjleuk3G3j',21,355.00,'en_attente','2024-09-28 18:12:23'),(8,'cs_test_a1RCE0JdG98jDOYEDYbsJbh6CwWoE8dECb5BUIEPYfFvWhtALzYU5GZEAA',22,9000.00,'valide','2024-09-28 20:53:12'),(9,'cs_test_a1s84CAwGHvkvBXfQmoCAEUqDDbhIktFYX7x7vr7avRcDXurKBcYCUvSUS',22,3600.00,'en_attente','2024-10-03 09:04:18'),(10,'cs_test_a17tLeRP8ZG7aqgKcbfogUl5tPx5Izd36c1d104ci9QS7dTsoeLB2lkRh3',22,3600.00,'en_attente','2024-10-03 09:06:26'),(11,'cs_test_a1AOWz8lALlratv9pRxWRiWTEZrCfXzWcNhxlFqcvMDkE1tA31aaLBphHi',22,3600.00,'en_attente','2024-10-03 09:18:14'),(12,'cs_test_a1QWDRGnrwJHMg6hVXNKbjAHPSYEkYCoEwsyriHSdgwe7vmRkJ259uzLPW',22,6548.00,'en_attente','2024-10-03 09:18:57'),(13,'cs_test_a1zPc4YOgkk8ThkIxqYpKfIIBsDr7YOfVEFB9FBcJl3OLIJcVI6reLlk1d',22,1000.12,'en_attente','2024-10-03 09:23:22'),(14,'cs_test_a17FZYBGphTShrEYfFgrVINeJ803DbJBbceOnGYnsmCj2Ay9mQFb9qGCaU',23,99.99,'en_attente','2024-10-04 13:00:28'),(15,'cs_test_a1PgYxYLBxgIOXRecnblN65BHUZt4jb6lhIEy8FKxBjn03g7kszX3R3799',23,99.99,'en_attente','2024-10-04 13:33:46');
/*!40000 ALTER TABLE `paiement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pokedex`
--

DROP TABLE IF EXISTS `pokedex`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pokedex` (
  `id` int NOT NULL,
  `nom` varchar(100) NOT NULL,
  `type_1` varchar(100) NOT NULL,
  `type_2` varchar(100) DEFAULT NULL,
  `generation` int NOT NULL,
  `legendaire` tinyint(1) DEFAULT '0',
  `prix` decimal(5,2) NOT NULL,
  `discount` int NOT NULL,
  `image` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `quantite` int DEFAULT '0',
  `description` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pokedex`
--

LOCK TABLES `pokedex` WRITE;
/*!40000 ALTER TABLE `pokedex` DISABLE KEYS */;
INSERT INTO `pokedex` VALUES (1,'Bulbizarre','plante','poison',1,0,50.00,0,'66f07e02936e4001.png',15,'Pokémon de type Plante et Poison de la première génération. C\'est l\'un des Pokémon de départ de la région de Kanto.'),(2,'Herbizarre','plante','poison',1,0,23.00,1,'../img/002.png',0,'Pokémon de type Plante et Poison de la première génération.'),(3,'Florizarre','plante','poison',1,0,13.00,0,'../img/003.png',10,'Ce Pokémon est capable de transformer la lumière du soleil en énergie. Il est donc encore plus fort en été.'),(4,'Salameche','feu',NULL,1,0,23.00,0,'../img/004.png',1,'Salamèche est un Pokémon bipède et reptilien avec un corps principalement orange, à l\'exception de son ventre et de ses plantes de pieds qui sont beiges.'),(5,'Reptincel','feu',NULL,1,0,90.00,0,'../img/005.png',10,'Ce Pokémon au sang chaud est constamment à la recherche d\'adversaires. Il ne se calme qu\'une fois qu\'il a gagné.'),(6,'Dracaufeu','feu','vol',1,0,34.00,0,'../img/006.png',14,'Dracaufeu est basé sur un dragon européen. Contrairement à ses pré-évolutions, il a deux ailes lui permettant de voler.'),(7,'Carapuce','eau',NULL,1,0,23.00,0,'../img/007.png',0,'Carapuce est une petite tortue bipède de couleur bleue. Il possède une carapace brune au pourtour blanc, beige au niveau du ventre. Ses yeux sont grands et violacés.'),(8,'Carabaffe','eau',NULL,1,0,50.00,0,'../img/008.png',10,'Carabaffe a une large queue recouverte d\'une épaisse fourrure. Elle devient de plus en plus foncée avec l\'âge.'),(9,'Tortank','eau',NULL,1,0,100.00,10,'../img/009.png',6,'Ce Pokémon brutal est armé de canons hydrauliques. Ses puissants jets d\'eau sont dévastateurs. Il écrase ses adversaires de tout son poids pour leur faire perdre connaissance.'),(10,'Chenipan','Insecte',NULL,1,0,22.00,5,'../img/010.png',100,'Chenipan est un Pokémon de type Insecte de la première génération.'),(11,'Chrysacier','Insecte',NULL,1,0,25.00,5,'../img/011.png',90,'Chrysacier est l\'évolution de Chenipan, un Pokémon de type Insecte.'),(12,'Papilusion','Insecte','Vol',1,0,40.50,5,'../img/012.png',75,'Papilusion est l\'évolution finale de Chenipan, de type Insecte et Vol.'),(13,'Aspicot','Insecte','Poison',1,0,22.00,5,'../img/013.png',100,'Aspicot est un Pokémon de type Insecte et Poison de la première génération.'),(14,'Coconfort','Insecte','Poison',1,0,25.00,5,'../img/014.png',90,'Coconfort est l\'évolution d\'Aspicot, de type Insecte et Poison.'),(15,'Dardargnan','Insecte','Poison',1,0,45.00,5,'../img/015.png',70,'Dardargnan est l\'évolution finale d\'Aspicot, de type Insecte et Poison.'),(16,'Roucool','Normal','Vol',1,0,25.00,5,'../img/016.png',95,'Roucool est un Pokémon de type Normal et Vol de la première génération.'),(17,'Roucoups','Normal','Vol',1,0,35.00,5,'../img/017.png',85,'Roucoups est l\'évolution de Roucool, un Pokémon de type Normal et Vol.'),(18,'Roucarnage','Normal','Vol',1,0,55.00,10,'../img/018.png',60,'Roucarnage est l\'évolution finale de Roucool, un Pokémon puissant de type Normal et Vol.'),(19,'Rattata','Normal',NULL,1,0,20.00,5,'../img/019.png',100,'Rattata est un Pokémon de type Normal, commun dans la première génération.'),(20,'Rattatac','Normal',NULL,1,0,35.00,5,'../img/020.png',85,'Rattatac est l\'évolution de Rattata, un Pokémon de type Normal.'),(21,'Piafabec','Normal','Vol',1,0,22.00,5,'../img/021.png',100,'Piafabec est un Pokémon de type Normal et Vol de la première génération.'),(22,'Rapasdepic','Normal','Vol',1,0,40.00,5,'../img/022.png',75,'Rapasdepic est l\'évolution de Piafabec, un Pokémon de type Normal et Vol.'),(23,'Abo','Poison',NULL,1,0,28.00,5,'../img/023.png',90,'Abo est un Pokémon de type Poison de la première génération.'),(24,'Arbok','Poison',NULL,1,0,48.00,5,'../img/024.png',70,'Arbok est l\'évolution d\'Abo, un Pokémon de type Poison.'),(25,'Pikachu','Électrique',NULL,1,0,32.00,5,'../img/025.png',90,'Pikachu est un Pokémon de type Électrique, emblématique de la première génération.'),(26,'Raichu','Électrique',NULL,1,0,40.50,5,'../img/026.png',75,'Raichu est l\'évolution de Pikachu, un Pokémon de type Électrique.'),(27,'Sabelette','Sol',NULL,1,0,30.00,5,'../img/027.png',90,'Sabelette est un Pokémon de type Sol de la première génération.'),(28,'Sablaireau','Sol',NULL,1,0,45.00,5,'../img/028.png',70,'Sablaireau est l\'évolution de Sabelette, un Pokémon de type Sol.'),(29,'Nidoran♀','Poison',NULL,1,0,25.00,5,'../img/029.png',95,'Nidoran♀ est un Pokémon de type Poison de la première génération.'),(30,'Nidorina','Poison',NULL,1,0,35.00,5,'../img/030.png',85,'Nidorina est l\'évolution de Nidoran♀, un Pokémon de type Poison.'),(31,'Nidoqueen','Poison','Sol',1,0,55.00,10,'../img/031.png',60,'Nidoqueen est l\'évolution finale de Nidoran♀, de type Poison et Sol.'),(32,'Nidoran♂','Poison',NULL,1,0,25.00,5,'../img/032.png',95,'Nidoran♂ est un Pokémon de type Poison de la première génération.'),(33,'Nidorino','Poison',NULL,1,0,35.00,5,'../img/033.png',85,'Nidorino est l\'évolution de Nidoran♂, un Pokémon de type Poison.'),(34,'Nidoking','Poison','Sol',1,0,55.00,10,'../img/034.png',60,'Nidoking est l\'évolution finale de Nidoran♂, de type Poison et Sol.'),(35,'Mélofée','Fée',NULL,1,0,30.00,5,'../img/035.png',90,'Mélofée est un Pokémon de type Fée de la première génération.'),(36,'Mélodelfe','Fée',NULL,1,0,50.00,5,'../img/036.png',65,'Mélodelfe est l\'évolution de Mélofée, un Pokémon de type Fée.'),(37,'Goupix','Feu',NULL,1,0,32.00,5,'../img/037.png',85,'Goupix est un Pokémon de type Feu de la première génération.'),(38,'Feunard','Feu',NULL,1,0,52.00,10,'../img/038.png',50,'Feunard est l\'évolution de Goupix, un Pokémon de type Feu.'),(39,'Rondoudou','Normal','Fée',1,0,28.00,5,'../img/039.png',90,'Rondoudou est un Pokémon de type Normal et Fée de la première génération.'),(40,'Grodoudou','Normal','Fée',1,0,45.00,5,'../img/040.png',70,'Grodoudou est l\'évolution de Rondoudou, un Pokémon de type Normal et Fée.'),(41,'Nosferapti','Poison','Vol',1,0,22.00,5,'../img/041.png',100,'Nosferapti est un Pokémon de type Poison et Vol de la première génération.'),(42,'Nosferalto','Poison','Vol',1,0,42.00,5,'../img/042.png',75,'Nosferalto est l\'évolution de Nosferapti, un Pokémon de type Poison et Vol.'),(43,'Mystherbe','Plante','Poison',1,0,25.00,5,'../img/043.png',95,'Mystherbe est un Pokémon de type Plante et Poison de la première génération.'),(44,'Ortide','Plante','Poison',1,0,35.00,5,'../img/044.png',85,'Ortide est l\'évolution de Mystherbe, un Pokémon de type Plante et Poison.'),(45,'Rafflésia','Plante','Poison',1,0,55.00,10,'../img/045.png',60,'Rafflésia est l\'évolution finale de Mystherbe, un Pokémon de type Plante et Poison.'),(46,'Paras','Insecte','Plante',1,0,25.00,5,'../img/046.png',95,'Paras est un Pokémon de type Insecte et Plante de la première génération.'),(47,'Parasect','Insecte','Plante',1,0,40.00,5,'../img/047.png',75,'Parasect est l\'évolution de Paras, un Pokémon de type Insecte et Plante.'),(48,'Mimitoss','Insecte','Poison',1,0,28.00,5,'../img/048.png',90,'Mimitoss est un Pokémon de type Insecte et Poison de la première génération.'),(49,'Aéromite','Insecte','Poison',1,0,45.00,5,'../img/049.png',70,'Aéromite est l\'évolution de Mimitoss, un Pokémon de type Insecte et Poison.'),(50,'Taupiqueur','Sol',NULL,1,0,22.00,5,'../img/050.png',100,'Taupiqueur est un Pokémon de type Sol de la première génération.'),(51,'Triopikeur','Sol',NULL,1,0,40.00,5,'../img/051.png',75,'Triopikeur est l\'évolution de Taupiqueur, un Pokémon de type Sol.'),(52,'Miaouss','Normal',NULL,1,0,25.00,5,'../img/052.png',95,'Miaouss est un Pokémon de type Normal de la première génération.'),(53,'Persian','Normal',NULL,1,0,42.00,5,'../img/053.png',75,'Persian est l\'évolution de Miaouss, un Pokémon de type Normal.'),(54,'Psykokwak','Eau',NULL,1,0,28.00,5,'../img/054.png',90,'Psykokwak est un Pokémon de type Eau de la première génération.'),(55,'Akwakwak','Eau',NULL,1,0,48.00,5,'../img/055.png',70,'Akwakwak est l\'évolution de Psykokwak, un Pokémon de type Eau.'),(56,'Férosinge','Combat',NULL,1,0,30.00,5,'../img/056.png',90,'Férosinge est un Pokémon de type Combat de la première génération.'),(57,'Colossinge','Combat',NULL,1,0,45.00,5,'../img/057.png',70,'Colossinge est l\'évolution de Férosinge, un Pokémon de type Combat.'),(58,'Caninos','Feu',NULL,1,0,35.00,5,'../img/058.png',85,'Caninos est un Pokémon de type Feu de la première génération.'),(59,'Arcanin','Feu',NULL,1,0,55.00,10,'../img/059.png',60,'Arcanin est l\'évolution de Caninos, un Pokémon de type Feu.'),(60,'Ptitard','Eau',NULL,1,0,25.00,5,'../img/060.png',95,'Ptitard est un Pokémon de type Eau de la première génération.'),(61,'Têtarte','Eau',NULL,1,0,35.00,5,'../img/061.png',85,'Têtarte est l\'évolution de Ptitard, un Pokémon de type Eau.'),(62,'Tartard','Eau','Combat',1,0,55.00,10,'../img/062.png',60,'Tartard est l\'évolution finale de Ptitard, un Pokémon de type Eau et Combat.'),(63,'Abra','Psy',NULL,1,0,30.00,5,'../img/063.png',90,'Abra est un Pokémon de type Psy de la première génération.'),(64,'Kadabra','Psy',NULL,1,0,45.00,5,'../img/064.png',70,'Kadabra est l\'évolution d\'Abra, un Pokémon de type Psy.'),(65,'Alakazam','psy',NULL,1,0,500.00,0,'../img/065.png',6,'Doué d’une intelligence hors du commun, ce Pokémon serait capable de conserver tous ses souvenirs, de sa naissance jusqu’à sa mort.'),(66,'Machoc','Combat',NULL,1,0,28.00,5,'../img/066.png',90,'Machoc est un Pokémon de type Combat de la première génération.'),(67,'Machopeur','Combat',NULL,1,0,45.00,5,'../img/067.png',70,'Machopeur est l\'évolution de Machoc, un Pokémon de type Combat.'),(68,'Mackogneur','Combat',NULL,1,0,60.00,10,'../img/068.png',50,'Mackogneur est l\'évolution finale de Machoc, un Pokémon puissant de type Combat.'),(69,'Chétiflor','Plante','Poison',1,0,25.00,5,'../img/069.png',95,'Chétiflor est un Pokémon de type Plante et Poison de la première génération.'),(70,'Boustiflor','Plante','Poison',1,0,35.00,5,'../img/070.png',85,'Boustiflor est l\'évolution de Chétiflor, un Pokémon de type Plante et Poison.'),(71,'Empiflor','Plante','Poison',1,0,55.00,10,'../img/071.png',60,'Empiflor est l\'évolution finale de Chétiflor, un Pokémon de type Plante et Poison.'),(72,'Tentacool','Eau','Poison',1,0,30.00,5,'../img/072.png',90,'Tentacool est un Pokémon de type Eau et Poison de la première génération.'),(73,'Tentacruel','Eau','Poison',1,0,55.00,10,'../img/073.png',60,'Tentacruel est l\'évolution de Tentacool, un Pokémon de type Eau et Poison.'),(74,'Racaillou','Roche','Sol',1,0,28.00,5,'../img/074.png',90,'Racaillou est un Pokémon de type Roche et Sol de la première génération.'),(75,'Gravalanch','Roche','Sol',1,0,45.00,5,'../img/075.png',70,'Gravalanch est l\'évolution de Racaillou, un Pokémon de type Roche et Sol.'),(76,'Grolem','Roche','Sol',1,0,60.00,10,'../img/076.png',50,'Grolem est l\'évolution finale de Racaillou, un Pokémon puissant de type Roche et Sol.'),(77,'Ponyta','Feu',NULL,1,0,30.00,5,'../img/077.png',90,'Ponyta est un Pokémon de type Feu de la première génération.'),(78,'Galopa','Feu',NULL,1,0,50.00,10,'../img/078.png',65,'Galopa est l\'évolution de Ponyta, un Pokémon de type Feu.'),(79,'Ramoloss','Eau','Psy',1,0,28.00,5,'../img/079.png',90,'Ramoloss est un Pokémon de type Eau et Psy de la première génération.'),(80,'Flagadoss','Eau','Psy',1,0,50.00,10,'../img/080.png',65,'Flagadoss est l\'évolution de Ramoloss, un Pokémon de type Eau et Psy.'),(81,'Magnéti','Électrique','Acier',1,0,30.00,5,'../img/081.png',90,'Magnéti est un Pokémon de type Électrique et Acier de la première génération.'),(82,'Magnéton','Électrique','Acier',1,0,45.00,5,'../img/082.png',70,'Magnéton est l\'évolution de Magnéti, un Pokémon de type Électrique et Acier.'),(83,'Canarticho','Normal','Vol',1,0,35.00,5,'../img/083.png',85,'Canarticho est un Pokémon de type Normal et Vol de la première génération.'),(84,'Doduo','Normal','Vol',1,0,30.00,5,'../img/084.png',90,'Doduo est un Pokémon de type Normal et Vol de la première génération.'),(85,'Dodrio','Normal','Vol',1,0,50.00,10,'../img/085.png',65,'Dodrio est l\'évolution de Doduo, un Pokémon de type Normal et Vol.'),(86,'Otaria','Eau',NULL,1,0,28.00,5,'../img/086.png',90,'Otaria est un Pokémon de type Eau de la première génération.'),(87,'Lamantine','Eau','Glace',1,0,50.00,10,'../img/087.png',65,'Lamantine est l\'évolution d\'Otaria, un Pokémon de type Eau et Glace.'),(88,'Tadmorv','Poison',NULL,1,0,30.00,5,'../img/088.png',90,'Tadmorv est un Pokémon de type Poison de la première génération.'),(89,'Grotadmorv','Poison',NULL,1,0,50.00,10,'../img/089.png',65,'Grotadmorv est l\'évolution de Tadmorv, un Pokémon de type Poison.'),(90,'Kokiyas','Eau',NULL,1,0,28.00,5,'../img/090.png',90,'Kokiyas est un Pokémon de type Eau de la première génération.'),(91,'Crustabri','Eau','Glace',1,0,50.00,10,'../img/091.png',65,'Crustabri est l\'évolution de Kokiyas, un Pokémon de type Eau et Glace.'),(92,'Fantominus','Spectre','Poison',1,0,30.00,5,'../img/092.png',90,'Fantominus est un Pokémon de type Spectre et Poison de la première génération.'),(93,'Spectrum','Spectre','Poison',1,0,45.00,5,'../img/093.png',70,'Spectrum est l\'évolution de Fantominus, un Pokémon de type Spectre et Poison.'),(94,'Ectoplasma','Spectre','Poison',1,0,60.00,10,'../img/094.png',50,'Ectoplasma est l\'évolution finale de Fantominus, un Pokémon puissant de type Spectre et Poison.'),(95,'Onix','Roche','Sol',1,0,40.00,5,'../img/095.png',75,'Onix est un Pokémon de type Roche et Sol de la première génération.'),(96,'Soporifik','Psy',NULL,1,0,28.00,5,'../img/096.png',90,'Soporifik est un Pokémon de type Psy de la première génération.'),(97,'Hypnomade','Psy',NULL,1,0,45.00,5,'../img/097.png',70,'Hypnomade est l\'évolution de Soporifik, un Pokémon de type Psy.'),(98,'Krabby','Eau',NULL,1,0,30.00,5,'../img/098.png',90,'Krabby est un Pokémon de type Eau de la première génération.'),(99,'Krabboss','Eau',NULL,1,0,50.00,10,'../img/099.png',65,'Krabboss est l\'évolution de Krabby, un Pokémon de type Eau.'),(100,'Voltorbe','Électrique',NULL,1,0,30.00,5,'../img/100.png',90,'Voltorbe est un Pokémon de type Électrique de la première génération.'),(101,'Électrode','Électrique',NULL,1,0,45.00,5,'../img/101.png',70,'Électrode est l\'évolution de Voltorbe, un Pokémon de type Électrique.'),(102,'Noeunoeuf','Plante','Psy',1,0,28.00,5,'../img/102.png',90,'Noeunoeuf est un Pokémon de type Plante et Psy de la première génération.'),(103,'Noadkoko','Plante','Psy',1,0,50.00,10,'../img/103.png',65,'Noadkoko est l\'évolution de Noeunoeuf, un Pokémon de type Plante et Psy.'),(104,'Osselait','Sol',NULL,1,0,30.00,5,'../img/104.png',90,'Osselait est un Pokémon de type Sol de la première génération.'),(105,'Ossatueur','Sol',NULL,1,0,50.00,10,'../img/105.png',65,'Ossatueur est l\'évolution d\'Osselait, un Pokémon de type Sol.'),(106,'Kicklee','Combat',NULL,1,0,50.00,10,'../img/106.png',65,'Kicklee est un Pokémon de type Combat de la première génération.'),(107,'Tygnon','Combat',NULL,1,0,50.00,10,'../img/107.png',65,'Tygnon est un Pokémon de type Combat de la première génération.'),(108,'Excelangue','Normal',NULL,1,0,40.00,5,'../img/108.png',75,'Excelangue est un Pokémon de type Normal de la première génération.'),(109,'Smogo','Poison',NULL,1,0,30.00,5,'../img/109.png',90,'Smogo est un Pokémon de type Poison de la première génération.'),(110,'Smogogo','Poison',NULL,1,0,50.00,10,'../img/110.png',65,'Smogogo est l\'évolution de Smogo, un Pokémon de type Poison.'),(111,'Rhinocorne','Sol','Roche',1,0,35.00,5,'../img/111.png',85,'Rhinocorne est un Pokémon de type Sol et Roche de la première génération.'),(112,'Rhinoféros','Sol','Roche',1,0,55.00,10,'../img/112.png',60,'Rhinoféros est l\'évolution de Rhinocorne, un Pokémon de type Sol et Roche.'),(113,'Leveinard','Normal',NULL,1,0,60.00,10,'../img/113.png',50,'Leveinard est un Pokémon de type Normal de la première génération.'),(114,'Saquedeneu','Plante',NULL,1,0,35.00,5,'../img/114.png',85,'Saquedeneu est un Pokémon de type Plante de la première génération.'),(115,'Kangourex','Normal',NULL,1,0,50.00,10,'../img/115.png',65,'Kangourex est un Pokémon de type Normal de la première génération.'),(116,'Hypotrempe','Eau',NULL,1,0,28.00,5,'../img/116.png',90,'Hypotrempe est un Pokémon de type Eau de la première génération.'),(117,'Hypocéan','Eau',NULL,1,0,45.00,5,'../img/117.png',70,'Hypocéan est l\'évolution d\'Hypotrempe, un Pokémon de type Eau.'),(118,'Poissirène','Eau',NULL,1,0,28.00,5,'../img/118.png',90,'Poissirène est un Pokémon de type Eau de la première génération.'),(119,'Poissoroy','Eau',NULL,1,0,45.00,5,'../img/119.png',70,'Poissoroy est l\'évolution de Poissirène, un Pokémon de type Eau.'),(120,'Stari','Eau',NULL,1,0,28.00,5,'../img/120.png',90,'Stari est un Pokémon de type Eau de la première génération.'),(121,'Staross','Eau','Psy',1,0,50.00,10,'../img/121.png',65,'Staross est l\'évolution de Stari, un Pokémon de type Eau et Psy.'),(122,'M. Mime','Psy','Fée',1,0,50.00,10,'../img/122.png',65,'M. Mime est un Pokémon de type Psy et Fée de la première génération.'),(123,'Insécateur','Insecte','Vol',1,0,50.00,10,'../img/123.png',65,'Insécateur est un Pokémon de type Insecte et Vol de la première génération.'),(124,'Lippoutou','Glace','Psy',1,0,50.00,10,'../img/124.png',65,'Lippoutou est un Pokémon de type Glace et Psy de la première génération.'),(125,'Élektek','Électrique',NULL,1,0,50.00,10,'../img/125.png',65,'Élektek est un Pokémon de type Électrique de la première génération.'),(126,'Magmar','Feu',NULL,1,0,50.00,10,'../img/126.png',65,'Magmar est un Pokémon de type Feu de la première génération.'),(127,'Scarabrute','Insecte',NULL,1,0,50.00,10,'../img/127.png',65,'Scarabrute est un Pokémon de type Insecte de la première génération.'),(128,'Tauros','Normal',NULL,1,0,50.00,10,'../img/128.png',65,'Tauros est un Pokémon de type Normal de la première génération.'),(129,'Magicarpe','Eau',NULL,1,0,25.00,5,'../img/129.png',95,'Magicarpe est un Pokémon de type Eau de la première génération.'),(130,'Léviator','Eau','Vol',1,0,60.00,10,'../img/130.png',50,'Léviator est l\'évolution de Magicarpe, un Pokémon de type Eau et Vol.'),(131,'Lokhlass','Eau','Glace',1,0,60.00,10,'../img/131.png',50,'Lokhlass est un Pokémon de type Eau et Glace de la première génération.'),(132,'Métamorph','Normal',NULL,1,0,50.00,10,'../img/132.png',65,'Métamorph est un Pokémon de type Normal de la première génération.'),(133,'Évoli','Normal',NULL,1,0,30.00,5,'../img/133.png',90,'Évoli est un Pokémon de type Normal de la première génération, connu pour ses nombreuses évolutions.'),(134,'Aquali','Eau',NULL,1,0,50.00,10,'../img/134.png',65,'Aquali est l\'une des évolutions d\'Évoli, un Pokémon de type Eau.'),(135,'Voltali','Électrique',NULL,1,0,50.00,10,'../img/135.png',65,'Voltali est l\'une des évolutions d\'Évoli, un Pokémon de type Électrique.'),(136,'Pyroli','Feu',NULL,1,0,50.00,10,'../img/136.png',65,'Pyroli est l\'une des évolutions d\'Évoli, un Pokémon de type Feu.'),(137,'Porygon','Normal',NULL,1,0,50.00,10,'../img/137.png',65,'Porygon est un Pokémon de type Normal de la première génération.'),(138,'Amonita','Roche','Eau',1,0,35.00,5,'../img/138.png',85,'Amonita est un Pokémon de type Roche et Eau de la première génération.'),(139,'Amonistar','Roche','Eau',1,0,55.00,10,'../img/139.png',60,'Amonistar est l\'évolution d\'Amonita, un Pokémon de type Roche et Eau.'),(140,'Kabuto','Roche','Eau',1,0,35.00,5,'../img/140.png',85,'Kabuto est un Pokémon de type Roche et Eau de la première génération.'),(141,'Kabutops','Roche','Eau',1,0,55.00,10,'../img/141.png',60,'Kabutops est l\'évolution de Kabuto, un Pokémon de type Roche et Eau.'),(142,'Ptéra','Roche','Vol',1,0,55.00,10,'../img/142.png',60,'Ptéra est un Pokémon de type Roche et Vol de la première génération.'),(143,'Ronflex','Normal',NULL,1,0,60.00,10,'../img/143.png',50,'Ronflex est un Pokémon de type Normal, célèbre pour sa grande taille et son sommeil.'),(144,'Artikodin','Glace','Vol',1,1,70.00,15,'../img/144.png',40,'Artikodin est un Pokémon légendaire de type Glace et Vol.'),(145,'Électhor','Électrique','Vol',1,1,70.00,15,'../img/145.png',40,'Électhor est un Pokémon légendaire de type Électrique et Vol.'),(146,'Sulfura','Feu','Vol',1,1,70.00,15,'../img/146.png',40,'Sulfura est un Pokémon légendaire de type Feu et Vol.'),(147,'Minidraco','Dragon',NULL,1,0,35.00,5,'../img/147.png',85,'Minidraco est un Pokémon de type Dragon de la première génération.'),(148,'Draco','Dragon',NULL,1,0,55.00,10,'../img/148.png',60,'Draco est l\'évolution de Minidraco, un Pokémon de type Dragon.'),(149,'Dracolosse','dragon','vol',1,0,465.00,7,'../img/149.png',35,'Sa gentillesse est telle que s’il voit un Pokémon ou un être humain en train de se noyer, il n’hésite pas à lui venir en aide.'),(151,'Mew','psy',NULL,1,1,600.00,0,'../img/151.png',1,'Unique et rare, son existence est remise en cause par les experts. Peu nombreux sont ceux qui l\'ont vu.'),(392,'Simiabraz','Feu','Combat',4,0,505.00,0,'https://github.com/HybridShivam/Pokemon/blob/master/assets/images/392.png',55,'a'),(448,'Lucario','Combat','Acier',4,0,45.99,10,'https://example.com/images/lucario.png',100,'Lucario est un Pokémon de type Combat et Acier qui utilise son aura pour combattre ses adversaires.'),(494,'Victini','Feu','Psy',5,1,79.99,15,'https://example.com/images/victini.png',50,'Victini est un Pokémon légendaire de type Feu et Psy qui apporte la victoire à son dresseur.');
/*!40000 ALTER TABLE `pokedex` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `set_default_image` BEFORE INSERT ON `pokedex` FOR EACH ROW BEGIN
    IF NEW.image IS NULL OR NEW.image = '' THEN
        SET NEW.image = CONCAT('https://github.com/HybridShivam/Pokemon/blob/master/assets/images/', LPAD(NEW.id, 3, '0'), '.png');
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `reinitmdp`
--

DROP TABLE IF EXISTS `reinitmdp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reinitmdp` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Utilisateur` int NOT NULL,
  `DateExp` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Token` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Utilise` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Table pour creer un autre mdp s''il est perdu';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reinitmdp`
--

LOCK TABLES `reinitmdp` WRITE;
/*!40000 ALTER TABLE `reinitmdp` DISABLE KEYS */;
INSERT INTO `reinitmdp` VALUES (7,2,'2024-03-31 02:28:59','24e2a24d2de44f0c0ffd46b1229706232663027631a18410625a3ede7693',0),(8,8,'2024-03-31 02:30:31','3f9d907479cb3fdb53af90c848ef7f3f86343a1b37a883d103bc3ff8da73',0),(10,1,'2024-03-31 02:36:37','203ec9cd08df9b9989a9e8b7a4733a723a14ad89b3b9b57ce90068f72f48',0),(11,1,'2024-03-31 03:39:10','9c1f66992e641a0e90ac175ee1aa338d76a3706b6b354c6af2fc796df908',1),(12,8,'2024-03-31 04:14:08','bae87ac4fea52e5015f08cbe42d5f0b33186d76c3b355a4cd933f852927a',1),(13,8,'2024-03-31 04:14:52','98cffa536a578e756a5b82a8eed32c6b130c07d7fb7dce5b98789c21abc8',1),(14,8,'2024-03-31 04:16:06','c0605d7aeef18e8e82fdd2756875d19f3d9205af0358877c46a78f7d9008',0),(15,4,'2024-03-31 21:39:29','3419358f9df4b757ad806095d62dcc61af4224408c7fa5e8a91e21f172e2',1);
/*!40000 ALTER TABLE `reinitmdp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `utilisateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `prenom` varchar(150) NOT NULL,
  `nom` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telephone` text NOT NULL,
  `date_naissance` date DEFAULT NULL,
  `password` varchar(150) NOT NULL,
  `statut` varchar(50) NOT NULL DEFAULT 'client',
  `last_login` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `idx_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utilisateur`
--

LOCK TABLES `utilisateur` WRITE;
/*!40000 ALTER TABLE `utilisateur` DISABLE KEYS */;
INSERT INTO `utilisateur` VALUES (1,'Aa','AA','aa@gmail.com','1234567890','2024-02-08','$2y$10$zX7NdUlkHoLQAomJkBGHBuJqT40XP4xrqALrOyyVpuKQ/YgmFlkqS','admin',NULL,1,0),(2,'Samy','TEST','ok@gmail.com','1234567890','2024-02-06','$2y$12$Dt8WLmOI1aA.PcVwb2/r4uISQyGNFmZaiJS8DFGHpj/JP9fy8DXC.','client',NULL,1,0),(3,'Dad','AAD','ah@gmail.com','865757574','2024-02-18','$2y$10$9iKg9AAZ4FKxN2igQWQINuNpHsehft7aozg8m7Xg32oU5P8BVkOg2','client',NULL,1,0),(4,'Ae','EFFAE','faf@gmail.com','123456789','2024-02-06','$2y$10$UUWbo/5KcriCRF7HglUyz.IBcPGtqlwRjgX5xjAbe1NN3cRqWfkM2','client',NULL,1,0),(6,'Test','AZDD','zz@gmail.com','123456789','2024-02-21','$2y$10$u3gH2SJ1vMYeR8Z/FcL7r.enhTs4WsyLvSh3WPserTz7afOQnaV/6','client',NULL,1,0),(8,'Azerty','AZ','azerty@gmail.com','0','2024-03-06','$2y$10$1jPg.bkocvifSC1rmR4mcuhWjA.Us21Brgv3TiIo8cMKoqLlmtdLy','client',NULL,1,0),(9,'Amine','MZALI','mzaliamine@gmail.com','647890947','2003-05-05','$2y$10$GMTFr1JfgvpRVcJVWRbO9.w/qdgndIB1oo48x5yidaGZlvabo7wZq','client',NULL,1,0),(10,'Amine','MZALI','mzaliamine@hotmail.fr','0647890947','2003-05-05','$2y$10$c1Xh24w9t1IP/X3N3wM4Zuww70hPl.h6xOWufsxkEWbrzlyHG.GO6','client',NULL,1,0),(14,'Caca','Boudin','caca@boudin.com','0600000000','1990-05-10','pbkdf2_sha256$870000$qNyNd8Cz1Ia4iIfFbIT4Jb$DVX0uQ+5gAAx2XiMIT2iSHvlGY7euvoXo5PYGeMDapM=','client',NULL,1,0),(15,'John','Doe','john.doe@example.com','0600000000','1990-05-10','pbkdf2_sha256$870000$W1qsFd46rOD8ldjda505ss$MvfEtlJtbSmlMonvNPQWPVrpUrvUPIpw7E9SDHa3MeM=','client',NULL,1,0),(16,'John','Doe','john.doe2@example.com','0600000000','1990-05-10','pbkdf2_sha256$870000$pbWZHf0XGxSln4TAeaREP2$H8/TBYr2Vnu0kJ0RSx3m/c+f1wn6IF1451g83UgEFVk=','client',NULL,1,0),(17,'caca','pipi','aa@example.com','0600000000','2013-05-10','pbkdf2_sha256$870000$6OlCWGyO8iarx37SQRLN2q$l2s0/Bllp9y38I000BkDrE19aAuoZ6cbOpahD/f/nqo=','client',NULL,1,0),(18,'Jean','Dupont','aa@aa.com','0123456789','1990-01-01','pbkdf2_sha256$870000$rMATQl8yeBzM5Jqh54Fa3p$nUM5/OtNRLG+UKAj50ImynzU0nwDXySKqyOIx5geCd0=','admin',NULL,1,0),(19,'John','Doe','exemple@email.com','0600000000','1990-01-01','pbkdf2_sha256$870000$Xa3wi99W11N86G56UlgIfz$4i5tB/vOvfYo1nOaGqg/m1m+emyqon7MAvIhg7qCxYU=','client',NULL,1,0);
/*!40000 ALTER TABLE `utilisateur` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-10-04 20:55:31
