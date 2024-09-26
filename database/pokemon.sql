-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 26 sep. 2024 à 09:56
-- Version du serveur : 8.2.0
-- Version de PHP : 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `pokemon`
--

-- --------------------------------------------------------

--
-- Structure de la table `api_commande`
--

DROP TABLE IF EXISTS `api_commande`;
CREATE TABLE IF NOT EXISTS `api_commande` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `adresse_livraison` varchar(150) NOT NULL,
  `ville` varchar(150) NOT NULL,
  `code_postal` int NOT NULL,
  `livraison` varchar(150) NOT NULL,
  `total` decimal(7,2) NOT NULL,
  `numero_commande` varchar(100) NOT NULL,
  `date_creation` datetime(6) NOT NULL,
  `utilisateur_id` bigint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `api_commande_utilisateur_id_76c5730d` (`utilisateur_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `api_utilisateur`
--

DROP TABLE IF EXISTS `api_utilisateur`;
CREATE TABLE IF NOT EXISTS `api_utilisateur` (
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

--
-- Déchargement des données de la table `api_utilisateur`
--

INSERT INTO `api_utilisateur` (`id`, `prenom`, `nom`, `email`, `telephone`, `date_naissance`, `mdp`, `statut`) VALUES
(1, 'amine', 'm\'zali', 'mza@gmail.com', '0606060606', '2006-06-06', '06060606', 'admin'),
(2, '2', 'a', 'a@a.com', 'a', '1111-11-11', 'a', 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `auth_group`
--

DROP TABLE IF EXISTS `auth_group`;
CREATE TABLE IF NOT EXISTS `auth_group` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `auth_group_permissions`
--

DROP TABLE IF EXISTS `auth_group_permissions`;
CREATE TABLE IF NOT EXISTS `auth_group_permissions` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `group_id` int NOT NULL,
  `permission_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `auth_group_permissions_group_id_permission_id_0cd325b0_uniq` (`group_id`,`permission_id`),
  KEY `auth_group_permissions_group_id_b120cbf9` (`group_id`),
  KEY `auth_group_permissions_permission_id_84c5c92e` (`permission_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `auth_permission`
--

DROP TABLE IF EXISTS `auth_permission`;
CREATE TABLE IF NOT EXISTS `auth_permission` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `content_type_id` int NOT NULL,
  `codename` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `auth_permission_content_type_id_codename_01ab375a_uniq` (`content_type_id`,`codename`),
  KEY `auth_permission_content_type_id_2f476e4b` (`content_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `auth_permission`
--

INSERT INTO `auth_permission` (`id`, `name`, `content_type_id`, `codename`) VALUES
(1, 'Can add log entry', 1, 'add_logentry'),
(2, 'Can change log entry', 1, 'change_logentry'),
(3, 'Can delete log entry', 1, 'delete_logentry'),
(4, 'Can view log entry', 1, 'view_logentry'),
(5, 'Can add permission', 2, 'add_permission'),
(6, 'Can change permission', 2, 'change_permission'),
(7, 'Can delete permission', 2, 'delete_permission'),
(8, 'Can view permission', 2, 'view_permission'),
(9, 'Can add group', 3, 'add_group'),
(10, 'Can change group', 3, 'change_group'),
(11, 'Can delete group', 3, 'delete_group'),
(12, 'Can view group', 3, 'view_group'),
(13, 'Can add user', 4, 'add_user'),
(14, 'Can change user', 4, 'change_user'),
(15, 'Can delete user', 4, 'delete_user'),
(16, 'Can view user', 4, 'view_user'),
(17, 'Can add content type', 5, 'add_contenttype'),
(18, 'Can change content type', 5, 'change_contenttype'),
(19, 'Can delete content type', 5, 'delete_contenttype'),
(20, 'Can view content type', 5, 'view_contenttype'),
(21, 'Can add session', 6, 'add_session'),
(22, 'Can change session', 6, 'change_session'),
(23, 'Can delete session', 6, 'delete_session'),
(24, 'Can view session', 6, 'view_session'),
(25, 'Can add utilisateur', 7, 'add_utilisateur'),
(26, 'Can change utilisateur', 7, 'change_utilisateur'),
(27, 'Can delete utilisateur', 7, 'delete_utilisateur'),
(28, 'Can view utilisateur', 7, 'view_utilisateur'),
(29, 'Can add commande', 8, 'add_commande'),
(30, 'Can change commande', 8, 'change_commande'),
(31, 'Can delete commande', 8, 'delete_commande'),
(32, 'Can view commande', 8, 'view_commande');

-- --------------------------------------------------------

--
-- Structure de la table `auth_user`
--

DROP TABLE IF EXISTS `auth_user`;
CREATE TABLE IF NOT EXISTS `auth_user` (
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

-- --------------------------------------------------------

--
-- Structure de la table `auth_user_groups`
--

DROP TABLE IF EXISTS `auth_user_groups`;
CREATE TABLE IF NOT EXISTS `auth_user_groups` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `group_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `auth_user_groups_user_id_group_id_94350c0c_uniq` (`user_id`,`group_id`),
  KEY `auth_user_groups_user_id_6a12ed8b` (`user_id`),
  KEY `auth_user_groups_group_id_97559544` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `auth_user_user_permissions`
--

DROP TABLE IF EXISTS `auth_user_user_permissions`;
CREATE TABLE IF NOT EXISTS `auth_user_user_permissions` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `permission_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `auth_user_user_permissions_user_id_permission_id_14a6b632_uniq` (`user_id`,`permission_id`),
  KEY `auth_user_user_permissions_user_id_a95ead1b` (`user_id`),
  KEY `auth_user_user_permissions_permission_id_1fbb5f2c` (`permission_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

DROP TABLE IF EXISTS `commandes`;
CREATE TABLE IF NOT EXISTS `commandes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int NOT NULL,
  `adresse_livraison` varchar(255) CHARACTER SET armscii8 COLLATE armscii8_general_ci NOT NULL,
  `ville` varchar(255) CHARACTER SET armscii8 COLLATE armscii8_general_ci NOT NULL,
  `code_postal` int NOT NULL,
  `livraison` varchar(150) NOT NULL,
  `total` decimal(7,2) NOT NULL,
  `numero_commande` varchar(100) CHARACTER SET armscii8 COLLATE armscii8_general_ci NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`id`, `id_utilisateur`, `adresse_livraison`, `ville`, `code_postal`, `livraison`, `total`, `numero_commande`, `date_creation`) VALUES
(17, 2, 'oui3', 'Cergy', 95000, '0', 2407.00, '6642a9f93e722', '2024-05-14 02:02:01'),
(18, 2, 'oui4', 'Cergy', 95000, '0', 600.00, '6642ac1ee83c0', '2024-05-14 02:11:10'),
(19, 2, 'oui4', 'Cergy', 95000, '0', 600.00, '6642ac91df91a', '2024-05-14 02:13:05'),
(20, 2, 'oui4', 'Cergy', 95000, '0', 600.00, '6642ac9300e87', '2024-05-10 02:13:07'),
(21, 2, 'oui4', 'Cergy', 95000, '0', 600.00, '6642ac93d5341', '2024-05-10 02:13:07'),
(22, 2, 'oui4', 'Cergy', 95000, '0', 600.00, '6642ac944ff57', '2024-05-12 02:13:08'),
(23, 2, 'oui4', 'Cergy', 95000, '0', 600.00, '6642ac9a9d45b', '2024-05-14 02:13:14'),
(24, 2, 'oui4', 'Cergy', 95000, '0', 600.00, '6642acbdad58d', '2024-05-13 02:13:49'),
(25, 2, 'oui5', 'Cergy', 95000, '0', 17898.00, '6642ad3350916', '2024-05-14 02:15:47'),
(26, 2, 'oui10', 'Cergy', 95000, '0', 1753.00, '6642ad9dcaa83', '2024-05-14 02:17:33'),
(27, 2, 'oui11', 'Cergy', 95000, '0', 1969.00, '6642ae266369d', '2024-05-10 02:19:50'),
(29, 11, '17 boulevard du prot', 'Cergy', 95000, '0', 13.00, '6643b5866dbec', '2024-05-12 21:03:34'),
(31, 11, 'PARIS ', 'PARIS', 75000, '0', 318.00, '6643ba616d67b', '2024-05-13 21:24:17'),
(32, 11, 'azertyuiopsdfgh', 'zerg', 12345, '0', 932.00, '6643be5796d6c', '2024-05-13 21:41:11'),
(33, 11, 'azert iebf p', 'cergy', 95000, '0', 780.00, '6643d52ed97d7', '2024-05-14 23:18:38'),
(34, 13, 'qs', 'qs', 0, '0', 23.00, '664bad4ab8fbc', '2024-05-20 22:06:34'),
(35, 13, 'qs', 'qs', 0, '0', 13.00, '664bad6fe1b6e', '2024-05-20 22:07:11'),
(36, 13, 'qs', 'qs', 0, '0', 13.00, '664badff68a24', '2024-05-20 22:09:35');

-- --------------------------------------------------------

--
-- Structure de la table `django_admin_log`
--

DROP TABLE IF EXISTS `django_admin_log`;
CREATE TABLE IF NOT EXISTS `django_admin_log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `action_time` datetime(6) NOT NULL,
  `object_id` longtext,
  `object_repr` varchar(200) NOT NULL,
  `action_flag` smallint UNSIGNED NOT NULL,
  `change_message` longtext NOT NULL,
  `content_type_id` int DEFAULT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `django_admin_log_content_type_id_c4bce8eb` (`content_type_id`),
  KEY `django_admin_log_user_id_c564eba6` (`user_id`)
) ;

-- --------------------------------------------------------

--
-- Structure de la table `django_content_type`
--

DROP TABLE IF EXISTS `django_content_type`;
CREATE TABLE IF NOT EXISTS `django_content_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `app_label` varchar(100) NOT NULL,
  `model` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `django_content_type_app_label_model_76bd3d3b_uniq` (`app_label`,`model`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `django_content_type`
--

INSERT INTO `django_content_type` (`id`, `app_label`, `model`) VALUES
(1, 'admin', 'logentry'),
(2, 'auth', 'permission'),
(3, 'auth', 'group'),
(4, 'auth', 'user'),
(5, 'contenttypes', 'contenttype'),
(6, 'sessions', 'session'),
(7, 'api', 'utilisateur'),
(8, 'api', 'commande');

-- --------------------------------------------------------

--
-- Structure de la table `django_migrations`
--

DROP TABLE IF EXISTS `django_migrations`;
CREATE TABLE IF NOT EXISTS `django_migrations` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `app` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `applied` datetime(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `django_migrations`
--

INSERT INTO `django_migrations` (`id`, `app`, `name`, `applied`) VALUES
(1, 'contenttypes', '0001_initial', '2024-09-26 08:56:00.136003'),
(2, 'auth', '0001_initial', '2024-09-26 08:56:00.383479'),
(3, 'admin', '0001_initial', '2024-09-26 08:56:00.473185'),
(4, 'admin', '0002_logentry_remove_auto_add', '2024-09-26 08:56:00.477174'),
(5, 'admin', '0003_logentry_add_action_flag_choices', '2024-09-26 08:56:00.480164'),
(6, 'contenttypes', '0002_remove_content_type_name', '2024-09-26 09:28:40.557723'),
(7, 'auth', '0002_alter_permission_name_max_length', '2024-09-26 09:28:40.575674'),
(8, 'auth', '0003_alter_user_email_max_length', '2024-09-26 09:28:40.595608'),
(9, 'auth', '0004_alter_user_username_opts', '2024-09-26 09:28:40.598598'),
(10, 'auth', '0005_alter_user_last_login_null', '2024-09-26 09:28:40.617541'),
(11, 'auth', '0006_require_contenttypes_0002', '2024-09-26 09:28:40.618538'),
(12, 'auth', '0007_alter_validators_add_error_messages', '2024-09-26 09:28:40.622524'),
(13, 'auth', '0008_alter_user_username_max_length', '2024-09-26 09:28:40.643744'),
(14, 'auth', '0009_alter_user_last_name_max_length', '2024-09-26 09:28:40.664685'),
(15, 'auth', '0010_alter_group_name_max_length', '2024-09-26 09:28:40.682614'),
(16, 'auth', '0011_update_proxy_permissions', '2024-09-26 09:28:40.688593'),
(17, 'auth', '0012_alter_user_first_name_max_length', '2024-09-26 09:28:40.706542'),
(18, 'sessions', '0001_initial', '2024-09-26 09:28:40.726097'),
(19, 'api', '0001_initial', '2024-09-26 09:40:00.641132');

-- --------------------------------------------------------

--
-- Structure de la table `django_session`
--

DROP TABLE IF EXISTS `django_session`;
CREATE TABLE IF NOT EXISTS `django_session` (
  `session_key` varchar(40) NOT NULL,
  `session_data` longtext NOT NULL,
  `expire_date` datetime(6) NOT NULL,
  PRIMARY KEY (`session_key`),
  KEY `django_session_expire_date_a5c62663` (`expire_date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ligne_commandes`
--

DROP TABLE IF EXISTS `ligne_commandes`;
CREATE TABLE IF NOT EXISTS `ligne_commandes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_commande` varchar(255) NOT NULL,
  `pokemon` json NOT NULL COMMENT 'Id_Pokemon : Quantité',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `ligne_commandes`
--

INSERT INTO `ligne_commandes` (`id`, `id_commande`, `pokemon`) VALUES
(28, '28', '{\"3\": 2, \"6\": 3}'),
(29, '29', '{\"3\": 1}'),
(30, '31', '{\"1\": 1}'),
(31, '32', '{\"65\": 1, \"149\": 1}'),
(32, '33', '{\"5\": 1, \"9\": 1, \"151\": 1}'),
(33, '34', '{\"4\": 1}'),
(34, '35', '{\"3\": 1}'),
(35, '36', '{\"3\": 1}');

-- --------------------------------------------------------

--
-- Structure de la table `pokedex`
--

DROP TABLE IF EXISTS `pokedex`;
CREATE TABLE IF NOT EXISTS `pokedex` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) CHARACTER SET armscii8 COLLATE armscii8_general_ci NOT NULL,
  `type_1` varchar(100) CHARACTER SET armscii8 COLLATE armscii8_general_ci NOT NULL,
  `type_2` varchar(100) CHARACTER SET armscii8 COLLATE armscii8_general_ci DEFAULT NULL,
  `generation` int NOT NULL,
  `légendaire` tinyint(1) NOT NULL DEFAULT '0',
  `prix` decimal(5,2) NOT NULL,
  `discount` int NOT NULL,
  `image` varchar(150) CHARACTER SET armscii8 COLLATE armscii8_general_ci NOT NULL,
  `quantité` int NOT NULL DEFAULT '0',
  `description` varchar(250) CHARACTER SET armscii8 COLLATE armscii8_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=154 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `pokedex`
--

INSERT INTO `pokedex` (`id`, `nom`, `type_1`, `type_2`, `generation`, `légendaire`, `prix`, `discount`, `image`, `quantité`, `description`) VALUES
(1, 'Bulbizarre', 'plante', 'poison', 1, 0, 318.00, 0, '66f07e02936e4001.png', 15, 'Pok&eacute;mon de type Plante et Poison de la premi&egrave;re g&eacute;n&eacute;ration. C&#039;est l&#039;un des Pok&eacute;mon de d&eacute;part de la r&eacute;gion de Kanto.'),
(2, 'Herbizarre', 'plante', 'poison ', 1, 0, 23.00, 1, '../img/002.png', 0, 'Pok&eacute;mon de type Plante et Poison de la premi&egrave;re g&eacute;n&eacute;ration.'),
(3, 'Florizarre', 'plante', 'poison ', 1, 0, 13.00, 0, '../img/003.png', 10, 'Ce Pok&eacute;mon est capable de transformer la lumi&egrave;re du soleil en &eacute;nergie. Il est donc encore plus fort en &eacute;t&eacute;. '),
(4, 'Salameche', 'feu', '', 1, 0, 23.00, 0, '../img/004.png', 1, 'Salam&egrave;che est un Pok&eacute;mon bip&egrave;de et reptilien avec un corps principalement orange, &agrave; l&#039;exception de son ventre et de ses plantes de pieds qui sont beiges'),
(5, 'Reptincel', 'feu', '', 1, 0, 90.00, 0, '../img/005.png', 2, 'Ce Pok&eacute;mon au sang chaud est constamment &agrave; la recherche d&#039;adversaires. Il ne se calme qu&#039;une fois qu&#039;il a gagn&eacute;. '),
(6, 'Dracaufeu', 'feu', 'vol', 1, 0, 34.00, 0, '../img/006.png', 14, 'Dracaufeu est bas&eacute; sur un dragon europ&eacute;en. Contrairement &agrave; ses pr&eacute;-&eacute;volutions, il a deux ailes lui permettant de voler'),
(7, 'Carapuce', 'eau', '', 1, 0, 23.00, 0, '../img/007.png', 0, 'Carapuce est une petite tortue bip&egrave;de de couleur bleue. Il poss&egrave;de une carapace brune au pourtour blanc, beige au niveau du ventre. Ses yeux sont grands et violac&eacute;s.'),
(8, 'Carabaffe', 'eau', '', 1, 0, 50.00, 0, '../img/008.png', 10, 'Carabaffe a une large queue recouverte d&#039;une &eacute;paisse fourrure. Elle devient de plus en plus fonc&eacute;e avec l&#039;&acirc;ge. '),
(9, 'Tortank', 'eau', '', 1, 0, 100.00, 10, '../img/009.png', 6, 'Ce Pok&eacute;mon brutal est arm&eacute; de canons hydrauliques. Ses puissants jets d&#039;eau sont d&eacute;vastateurs. Il &eacute;crase ses adversaires de tout son poids pour leur faire perdre connaissance'),
(65, 'Alakazam', 'psy', '', 1, 0, 500.00, 0, '../img/065.png', 6, 'Dou? d’une intelligence hors du commun, ce Pok?mon serait capable de conserver tous ses souvenirs, de sa naissance jusqu’? sa mort.'),
(149, 'Dracolosse', 'dragon', 'vol', 1, 0, 465.00, 7, '../img/149.png', 35, 'Sa gentillesse est telle que s’il voit un Pok?mon ou un ?tre humain en train de se noyer, il n’h?site pas ? lui venir en aide.'),
(151, 'Mew', 'psy', '', 1, 1, 600.00, 0, '../img/151.png', 1, 'Unique et rare, son existence est remise en cause par les experts. Peu nombreux sont ceux qui l&#039;ont vu.\r\n');

-- --------------------------------------------------------

--
-- Structure de la table `reinitmdp`
--

DROP TABLE IF EXISTS `reinitmdp`;
CREATE TABLE IF NOT EXISTS `reinitmdp` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Utilisateur` int NOT NULL,
  `DateExp` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Token` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Utilise` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Table pour creer un autre mdp s''il est perdu';

--
-- Déchargement des données de la table `reinitmdp`
--

INSERT INTO `reinitmdp` (`Id`, `Utilisateur`, `DateExp`, `Token`, `Utilise`) VALUES
(7, 2, '2024-03-31 02:28:59', '24e2a24d2de44f0c0ffd46b1229706232663027631a18410625a3ede7693', 0),
(8, 8, '2024-03-31 02:30:31', '3f9d907479cb3fdb53af90c848ef7f3f86343a1b37a883d103bc3ff8da73', 0),
(10, 1, '2024-03-31 02:36:37', '203ec9cd08df9b9989a9e8b7a4733a723a14ad89b3b9b57ce90068f72f48', 0),
(11, 1, '2024-03-31 03:39:10', '9c1f66992e641a0e90ac175ee1aa338d76a3706b6b354c6af2fc796df908', 1),
(12, 8, '2024-03-31 04:14:08', 'bae87ac4fea52e5015f08cbe42d5f0b33186d76c3b355a4cd933f852927a', 1),
(13, 8, '2024-03-31 04:14:52', '98cffa536a578e756a5b82a8eed32c6b130c07d7fb7dce5b98789c21abc8', 1),
(14, 8, '2024-03-31 04:16:06', 'c0605d7aeef18e8e82fdd2756875d19f3d9205af0358877c46a78f7d9008', 0),
(15, 4, '2024-03-31 21:39:29', '3419358f9df4b757ad806095d62dcc61af4224408c7fa5e8a91e21f172e2', 1);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `prenom` varchar(100) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telephone` text NOT NULL,
  `dateNaissance` varchar(100) NOT NULL,
  `mdp` text NOT NULL,
  `statut` varchar(100) NOT NULL DEFAULT 'client',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `prenom`, `nom`, `email`, `telephone`, `dateNaissance`, `mdp`, `statut`) VALUES
(1, 'Aa', 'AA', 'aa@gmail.com', '1234567890', '08/02/2024', '$2y$10$zX7NdUlkHoLQAomJkBGHBuJqT40XP4xrqALrOyyVpuKQ/YgmFlkqS', 'admin'),
(2, 'Ok', 'TEST', 'ok@gmail.com', '1234567890', '06/02/2024', '$2y$12$Dt8WLmOI1aA.PcVwb2/r4uISQyGNFmZaiJS8DFGHpj/JP9fy8DXC.', 'client'),
(3, 'Dad', 'AAD', 'ah@gmail.com', '865757574', '18/02/2024', '$2y$10$9iKg9AAZ4FKxN2igQWQINuNpHsehft7aozg8m7Xg32oU5P8BVkOg2', 'client'),
(4, 'Ae', 'EFFAE', 'faf@gmail.com', '123456789', '06/02/2024', '$2y$10$UUWbo/5KcriCRF7HglUyz.IBcPGtqlwRjgX5xjAbe1NN3cRqWfkM2', 'client'),
(6, 'Test', 'AZDD', 'zz@gmail.com', '123456789', '21/02/2024', '$2y$10$u3gH2SJ1vMYeR8Z/FcL7r.enhTs4WsyLvSh3WPserTz7afOQnaV/6', 'client'),
(8, 'Azerty', 'AZ', 'azerty@gmail.com', '0', '06/03/2024', '$2y$10$1jPg.bkocvifSC1rmR4mcuhWjA.Us21Brgv3TiIo8cMKoqLlmtdLy', 'client'),
(9, 'Amine', 'MZALI', 'mzaliamine@gmail.com', '647890947', '05/05/2003', '$2y$10$GMTFr1JfgvpRVcJVWRbO9.w/qdgndIB1oo48x5yidaGZlvabo7wZq', 'client'),
(10, 'Amine', 'MZALI', 'mzaliamine@hotmail.fr', '0647890947', '05/05/2003', '$2y$10$c1Xh24w9t1IP/X3N3wM4Zuww70hPl.h6xOWufsxkEWbrzlyHG.GO6', 'client');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
