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
-- Table structure for table `auth_group`
--

DROP TABLE IF EXISTS `auth_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_group` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_group`
--

LOCK TABLES `auth_group` WRITE;
/*!40000 ALTER TABLE `auth_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_group_permissions`
--

DROP TABLE IF EXISTS `auth_group_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_group_permissions` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `group_id` int NOT NULL,
  `permission_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `auth_group_permissions_group_id_permission_id_0cd325b0_uniq` (`group_id`,`permission_id`),
  KEY `auth_group_permissions_group_id_b120cbf9` (`group_id`),
  KEY `auth_group_permissions_permission_id_84c5c92e` (`permission_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_group_permissions`
--

LOCK TABLES `auth_group_permissions` WRITE;
/*!40000 ALTER TABLE `auth_group_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_group_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_permission`
--

DROP TABLE IF EXISTS `auth_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_permission` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `content_type_id` int NOT NULL,
  `codename` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `auth_permission_content_type_id_codename_01ab375a_uniq` (`content_type_id`,`codename`),
  KEY `auth_permission_content_type_id_2f476e4b` (`content_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_permission`
--

LOCK TABLES `auth_permission` WRITE;
/*!40000 ALTER TABLE `auth_permission` DISABLE KEYS */;
INSERT INTO `auth_permission` VALUES (1,'Can add log entry',1,'add_logentry'),(2,'Can change log entry',1,'change_logentry'),(3,'Can delete log entry',1,'delete_logentry'),(4,'Can view log entry',1,'view_logentry'),(5,'Can add permission',2,'add_permission'),(6,'Can change permission',2,'change_permission'),(7,'Can delete permission',2,'delete_permission'),(8,'Can view permission',2,'view_permission'),(9,'Can add group',3,'add_group'),(10,'Can change group',3,'change_group'),(11,'Can delete group',3,'delete_group'),(12,'Can view group',3,'view_group'),(13,'Can add user',4,'add_user'),(14,'Can change user',4,'change_user'),(15,'Can delete user',4,'delete_user'),(16,'Can view user',4,'view_user'),(17,'Can add content type',5,'add_contenttype'),(18,'Can change content type',5,'change_contenttype'),(19,'Can delete content type',5,'delete_contenttype'),(20,'Can view content type',5,'view_contenttype'),(21,'Can add session',6,'add_session'),(22,'Can change session',6,'change_session'),(23,'Can delete session',6,'delete_session'),(24,'Can view session',6,'view_session'),(25,'Can add utilisateur',7,'add_utilisateur'),(26,'Can change utilisateur',7,'change_utilisateur'),(27,'Can delete utilisateur',7,'delete_utilisateur'),(28,'Can view utilisateur',7,'view_utilisateur'),(29,'Can add commande',8,'add_commande'),(30,'Can change commande',8,'change_commande'),(31,'Can delete commande',8,'delete_commande'),(32,'Can view commande',8,'view_commande'),(33,'Can add pokedex',9,'add_pokedex'),(34,'Can change pokedex',9,'change_pokedex'),(35,'Can delete pokedex',9,'delete_pokedex'),(36,'Can view pokedex',9,'view_pokedex');
/*!40000 ALTER TABLE `auth_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_user`
--

DROP TABLE IF EXISTS `auth_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `password` varchar(128) NOT NULL,
  `last_login` datetime(6) DEFAULT NULL,
  `is_superuser` tinyint(1) NOT NULL,
  `username` varchar(150) NOT NULL,
  `first_name` varchar(150) NOT NULL,
  `last_name` varchar(150) NOT NULL,
  `email` varchar(254) NOT NULL,
  `is_staff` tinyint(1) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `date_joined` datetime(6) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_user`
--

LOCK TABLES `auth_user` WRITE;
/*!40000 ALTER TABLE `auth_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_user_groups`
--

DROP TABLE IF EXISTS `auth_user_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_user_groups` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `group_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `auth_user_groups_user_id_group_id_94350c0c_uniq` (`user_id`,`group_id`),
  KEY `auth_user_groups_user_id_6a12ed8b` (`user_id`),
  KEY `auth_user_groups_group_id_97559544` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_user_groups`
--

LOCK TABLES `auth_user_groups` WRITE;
/*!40000 ALTER TABLE `auth_user_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_user_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_user_user_permissions`
--

DROP TABLE IF EXISTS `auth_user_user_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_user_user_permissions` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `permission_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `auth_user_user_permissions_user_id_permission_id_14a6b632_uniq` (`user_id`,`permission_id`),
  KEY `auth_user_user_permissions_user_id_a95ead1b` (`user_id`),
  KEY `auth_user_user_permissions_permission_id_1fbb5f2c` (`permission_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_user_user_permissions`
--

LOCK TABLES `auth_user_user_permissions` WRITE;
/*!40000 ALTER TABLE `auth_user_user_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_user_user_permissions` ENABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `avis`
--

LOCK TABLES `avis` WRITE;
/*!40000 ALTER TABLE `avis` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commande_produit`
--

LOCK TABLES `commande_produit` WRITE;
/*!40000 ALTER TABLE `commande_produit` DISABLE KEYS */;
INSERT INTO `commande_produit` VALUES (3,28,1,2),(4,28,2,3);
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
  `statut_livraison` varchar(20) COLLATE utf8mb4_general_ci DEFAULT 'EN_ATTENTE',
  PRIMARY KEY (`id`),
  KEY `utilisateur_id` (`utilisateur_id`),
  CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commandes`
--

LOCK TABLES `commandes` WRITE;
/*!40000 ALTER TABLE `commandes` DISABLE KEYS */;
INSERT INTO `commandes` VALUES (17,2,'oui3','Cergy',95000,'0',2407.00,'6642a9f93e722','2024-05-14 02:02:01','LIVREE','LIVREE'),(18,2,'oui4','Cergy',95000,'0',600.00,'6642ac1ee83c0','2024-05-14 02:11:10','EN_TRAITEMENT','EN_ATTENTE'),(19,2,'oui4','Cergy',95000,'0',600.00,'6642ac91df91a','2024-05-14 02:13:05','EN_TRAITEMENT','EN_ATTENTE'),(20,2,'oui4','Cergy',95000,'0',600.00,'6642ac9300e87','2024-05-10 02:13:07','EN_TRAITEMENT','EN_ATTENTE'),(21,2,'oui4','Cergy',95000,'0',600.00,'6642ac93d5341','2024-05-10 02:13:07','EN_TRAITEMENT','EN_ATTENTE'),(22,2,'oui4','Cergy',95000,'0',600.00,'6642ac944ff57','2024-05-12 02:13:08','EN_TRAITEMENT','EN_ATTENTE'),(23,2,'oui4','Cergy',95000,'0',600.00,'6642ac9a9d45b','2024-05-14 02:13:14','EN_TRAITEMENT','EN_ATTENTE'),(24,2,'oui4','Cergy',95000,'0',600.00,'6642acbdad58d','2024-05-13 02:13:49','EN_TRAITEMENT','EN_ATTENTE'),(25,2,'oui5','Cergy',95000,'0',17898.00,'6642ad3350916','2024-05-14 02:15:47','EN_TRAITEMENT','EN_ATTENTE'),(26,2,'oui10','Cergy',95000,'0',1753.00,'6642ad9dcaa83','2024-05-14 02:17:33','EN_TRAITEMENT','EN_ATTENTE'),(27,2,'oui11','Cergy',95000,'0',1969.00,'6642ae266369d','2024-05-10 02:19:50','EN_TRAITEMENT','EN_ATTENTE'),(28,1,'123 Rue de la Paix','Paris',75001,'Standard',59.99,'CMD123456','2024-10-01 19:13:40','EN_TRAITEMENT','EN_ATTENTE'),(29,1,'123 Rue Example','Paris',75001,'Express',150.00,'CMD123456','2024-10-01 21:29:24','EN_TRAITEMENT','EN_ATTENTE'),(30,1,'123 Rue Example','Paris',75001,'Express',150.00,'CMD123456','2024-10-01 21:32:00','EN_TRAITEMENT','EN_ATTENTE'),(31,17,'123 Rue de la Paix','Paris',75001,'Standard',59.99,'CMD123456','2024-10-03 11:33:39','EN_TRAITEMENT','EN_ATTENTE'),(32,17,'456 Avenue des Champs','Lyon',69001,'Express',149.99,'CMD123457','2024-10-03 11:33:39','EXPEDIEE','EN_COURS'),(33,17,'789 Boulevard Saint-Germain','Marseille',13001,'Express',199.99,'CMD123458','2024-10-03 11:33:39','LIVREE','LIVREE');
/*!40000 ALTER TABLE `commandes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `django_admin_log`
--

DROP TABLE IF EXISTS `django_admin_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `django_admin_log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `action_time` datetime(6) NOT NULL,
  `object_id` longtext,
  `object_repr` varchar(200) NOT NULL,
  `action_flag` smallint unsigned NOT NULL,
  `change_message` longtext NOT NULL,
  `content_type_id` int DEFAULT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `django_admin_log_content_type_id_c4bce8eb` (`content_type_id`),
  KEY `django_admin_log_user_id_c564eba6` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `django_admin_log`
--

LOCK TABLES `django_admin_log` WRITE;
/*!40000 ALTER TABLE `django_admin_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `django_admin_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `django_content_type`
--

DROP TABLE IF EXISTS `django_content_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `django_content_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `app_label` varchar(100) NOT NULL,
  `model` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `django_content_type_app_label_model_76bd3d3b_uniq` (`app_label`,`model`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `django_content_type`
--

LOCK TABLES `django_content_type` WRITE;
/*!40000 ALTER TABLE `django_content_type` DISABLE KEYS */;
INSERT INTO `django_content_type` VALUES (1,'admin','logentry'),(2,'auth','permission'),(3,'auth','group'),(4,'auth','user'),(5,'contenttypes','contenttype'),(6,'sessions','session'),(7,'api','utilisateur'),(8,'api','commande'),(9,'api','pokedex');
/*!40000 ALTER TABLE `django_content_type` ENABLE KEYS */;
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
-- Table structure for table `django_session`
--

DROP TABLE IF EXISTS `django_session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `django_session` (
  `session_key` varchar(40) NOT NULL,
  `session_data` longtext NOT NULL,
  `expire_date` datetime(6) NOT NULL,
  PRIMARY KEY (`session_key`),
  KEY `django_session_expire_date_a5c62663` (`expire_date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `django_session`
--

LOCK TABLES `django_session` WRITE;
/*!40000 ALTER TABLE `django_session` DISABLE KEYS */;
/*!40000 ALTER TABLE `django_session` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paiement`
--

LOCK TABLES `paiement` WRITE;
/*!40000 ALTER TABLE `paiement` DISABLE KEYS */;
INSERT INTO `paiement` VALUES (1,'cs_test_a1n5fq5D8EFtw0CUaWaGJzFFDPKfZ6pJaSjAwTMStg6thc3mW3Fdrcmu6S',17,100.00,'en_attente','2024-09-27 19:55:56'),(2,'cs_test_a1bhvHpbWtWanWqZMNLI7fwGjOZJ3vJ1ZyLM9m1yceqAxT5NEQwCohgBCw',18,123.00,'en_attente','2024-09-28 17:20:11'),(3,'cs_test_a1IJZqUw01uETZOvejwa9aTtu8vBcEpf5LRSdqPZnWPDyHcYmLmwRrvIUk',17,555.00,'valide','2024-09-28 17:35:10'),(4,'cs_test_a1TQ65Qd9KcVtbaxl3ALgkRAcFp3h8qBGtDjf0lw5VrDWT8nag3HWzsu52',17,7998.00,'en_attente','2024-09-28 17:44:52'),(5,'cs_test_a1papC8VV6lKtsL6a3EqGrg0xcIOn2I46ZJQTMPd5VH5hCFpUMWuVDH6qC',17,767.00,'en_attente','2024-09-28 18:06:22'),(6,'cs_test_a12i57g24pzlU5tbTqpCYKPPuA87Spw7Uu1oNwaWC9aLZRTDwYxTuDFWG8',20,7895.00,'valide','2024-09-28 18:09:42'),(7,'cs_test_a1LBaSZSvaAuCVHrPj13X7fS4m7UIVgqoxoOO7QymotJtUHYpjleuk3G3j',21,355.00,'en_attente','2024-09-28 18:12:23'),(8,'cs_test_a1RCE0JdG98jDOYEDYbsJbh6CwWoE8dECb5BUIEPYfFvWhtALzYU5GZEAA',22,9000.00,'valide','2024-09-28 20:53:12'),(9,'cs_test_a1s84CAwGHvkvBXfQmoCAEUqDDbhIktFYX7x7vr7avRcDXurKBcYCUvSUS',22,3600.00,'en_attente','2024-10-03 09:04:18'),(10,'cs_test_a17tLeRP8ZG7aqgKcbfogUl5tPx5Izd36c1d104ci9QS7dTsoeLB2lkRh3',22,3600.00,'en_attente','2024-10-03 09:06:26'),(11,'cs_test_a1AOWz8lALlratv9pRxWRiWTEZrCfXzWcNhxlFqcvMDkE1tA31aaLBphHi',22,3600.00,'en_attente','2024-10-03 09:18:14'),(12,'cs_test_a1QWDRGnrwJHMg6hVXNKbjAHPSYEkYCoEwsyriHSdgwe7vmRkJ259uzLPW',22,6548.00,'en_attente','2024-10-03 09:18:57'),(13,'cs_test_a1zPc4YOgkk8ThkIxqYpKfIIBsDr7YOfVEFB9FBcJl3OLIJcVI6reLlk1d',22,1000.12,'en_attente','2024-10-03 09:23:22');
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
INSERT INTO `pokedex` VALUES (1,'Bulbizarre','plante','poison',1,0,50.00,0,'66f07e02936e4001.png',15,'Pokémon de type Plante et Poison de la première génération. C\'est l\'un des Pokémon de départ de la région de Kanto.'),(2,'Herbizarre','plante','poison',1,0,23.00,1,'../img/002.png',0,'Pokémon de type Plante et Poison de la première génération.'),(3,'Florizarre','plante','poison',1,0,13.00,0,'../img/003.png',10,'Ce Pokémon est capable de transformer la lumière du soleil en énergie. Il est donc encore plus fort en été.'),(4,'Salameche','feu',NULL,1,0,23.00,0,'../img/004.png',1,'Salamèche est un Pokémon bipède et reptilien avec un corps principalement orange, à l\'exception de son ventre et de ses plantes de pieds qui sont beiges.'),(5,'Reptincel','feu',NULL,1,0,90.00,0,'../img/005.png',10,'Ce Pokémon au sang chaud est constamment à la recherche d\'adversaires. Il ne se calme qu\'une fois qu\'il a gagné.'),(6,'Dracaufeu','feu','vol',1,0,34.00,0,'../img/006.png',14,'Dracaufeu est basé sur un dragon européen. Contrairement à ses pré-évolutions, il a deux ailes lui permettant de voler.'),(7,'Carapuce','eau',NULL,1,0,23.00,0,'../img/007.png',0,'Carapuce est une petite tortue bipède de couleur bleue. Il possède une carapace brune au pourtour blanc, beige au niveau du ventre. Ses yeux sont grands et violacés.'),(8,'Carabaffe','eau',NULL,1,0,50.00,0,'../img/008.png',10,'Carabaffe a une large queue recouverte d\'une épaisse fourrure. Elle devient de plus en plus foncée avec l\'âge.'),(9,'Tortank','eau',NULL,1,0,100.00,10,'../img/009.png',6,'Ce Pokémon brutal est armé de canons hydrauliques. Ses puissants jets d\'eau sont dévastateurs. Il écrase ses adversaires de tout son poids pour leur faire perdre connaissance.'),(65,'Alakazam','psy',NULL,1,0,500.00,0,'../img/065.png',6,'Doué d’une intelligence hors du commun, ce Pokémon serait capable de conserver tous ses souvenirs, de sa naissance jusqu’à sa mort.'),(149,'Dracolosse','dragon','vol',1,0,465.00,7,'../img/149.png',35,'Sa gentillesse est telle que s’il voit un Pokémon ou un être humain en train de se noyer, il n’hésite pas à lui venir en aide.'),(151,'Mew','psy',NULL,1,1,600.00,0,'../img/151.png',1,'Unique et rare, son existence est remise en cause par les experts. Peu nombreux sont ceux qui l\'ont vu.'),(392,'Simiabraz','Feu','Combat',4,0,505.00,0,'https://github.com/HybridShivam/Pokemon/blob/master/assets/images/392.png',55,'a');
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utilisateur`
--

LOCK TABLES `utilisateur` WRITE;
/*!40000 ALTER TABLE `utilisateur` DISABLE KEYS */;
INSERT INTO `utilisateur` VALUES (1,'Aa','AA','aa@gmail.com','1234567890','2024-02-08','$2y$10$zX7NdUlkHoLQAomJkBGHBuJqT40XP4xrqALrOyyVpuKQ/YgmFlkqS','admin',NULL,1,0),(2,'Samy','TEST','ok@gmail.com','1234567890','2024-02-06','$2y$12$Dt8WLmOI1aA.PcVwb2/r4uISQyGNFmZaiJS8DFGHpj/JP9fy8DXC.','client',NULL,1,0),(3,'Dad','AAD','ah@gmail.com','865757574','2024-02-18','$2y$10$9iKg9AAZ4FKxN2igQWQINuNpHsehft7aozg8m7Xg32oU5P8BVkOg2','client',NULL,1,0),(4,'Ae','EFFAE','faf@gmail.com','123456789','2024-02-06','$2y$10$UUWbo/5KcriCRF7HglUyz.IBcPGtqlwRjgX5xjAbe1NN3cRqWfkM2','client',NULL,1,0),(6,'Test','AZDD','zz@gmail.com','123456789','2024-02-21','$2y$10$u3gH2SJ1vMYeR8Z/FcL7r.enhTs4WsyLvSh3WPserTz7afOQnaV/6','client',NULL,1,0),(8,'Azerty','AZ','azerty@gmail.com','0','2024-03-06','$2y$10$1jPg.bkocvifSC1rmR4mcuhWjA.Us21Brgv3TiIo8cMKoqLlmtdLy','client',NULL,1,0),(9,'Amine','MZALI','mzaliamine@gmail.com','647890947','2003-05-05','$2y$10$GMTFr1JfgvpRVcJVWRbO9.w/qdgndIB1oo48x5yidaGZlvabo7wZq','client',NULL,1,0),(10,'Amine','MZALI','mzaliamine@hotmail.fr','0647890947','2003-05-05','$2y$10$c1Xh24w9t1IP/X3N3wM4Zuww70hPl.h6xOWufsxkEWbrzlyHG.GO6','client',NULL,1,0),(14,'Caca','Boudin','caca@boudin.com','0600000000','1990-05-10','pbkdf2_sha256$870000$qNyNd8Cz1Ia4iIfFbIT4Jb$DVX0uQ+5gAAx2XiMIT2iSHvlGY7euvoXo5PYGeMDapM=','client',NULL,1,0),(15,'John','Doe','john.doe@example.com','0600000000','1990-05-10','pbkdf2_sha256$870000$W1qsFd46rOD8ldjda505ss$MvfEtlJtbSmlMonvNPQWPVrpUrvUPIpw7E9SDHa3MeM=','client',NULL,1,0),(16,'John','Doe','john.doe2@example.com','0600000000','1990-05-10','pbkdf2_sha256$870000$pbWZHf0XGxSln4TAeaREP2$H8/TBYr2Vnu0kJ0RSx3m/c+f1wn6IF1451g83UgEFVk=','client',NULL,1,0),(17,'caca','pipi','aa@example.com','0600000000','2013-05-10','pbkdf2_sha256$870000$6OlCWGyO8iarx37SQRLN2q$l2s0/Bllp9y38I000BkDrE19aAuoZ6cbOpahD/f/nqo=','client',NULL,1,0);
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

-- Dump completed on 2024-10-03 16:19:46
