-- MariaDB dump 10.19-11.3.0-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: fbc_db
-- ------------------------------------------------------
-- Server version	11.3.0-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ingredients`
--

DROP TABLE IF EXISTS `ingredients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ingredients` (
  `ingredient_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`ingredient_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingredients`
--

LOCK TABLES `ingredients` WRITE;
/*!40000 ALTER TABLE `ingredients` DISABLE KEYS */;
INSERT INTO `ingredients` VALUES
(1,'Oeuf','https://img.cuisineaz.com/2880x1920/2018/03/22/i139020-comment-reconnaitre-un-oeuf-bio.jpeg'),
(2,'Cheddar','https://fridg-front.s3.amazonaws.com/media/CACHE/images/products/cheddar_en_tranche/49a525fae562455b9162eff531ed162c.jpg'),
(3,'Bacon','https://images.immediate.co.uk/production/volatile/sites/30/2019/11/Bacon-rashers-in-a-pan-72c07f4.jpg?quality=90&resize=556,505'),
(4,'Farine','https://happypanier.fr/wp-content/uploads/2020/04/AdobeStock_247082259-scaled-e1629022500268.jpeg'),
(5,'Lait','https://www.aquaportail.com/pictures1712/lait-vache.jpg');
/*!40000 ALTER TABLE `ingredients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recipeingredients`
--

DROP TABLE IF EXISTS `recipeingredients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recipeingredients` (
  `recipe_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL,
  `quantity` varchar(20) NOT NULL,
  PRIMARY KEY (`recipe_id`,`ingredient_id`),
  KEY `ingredient_id` (`ingredient_id`),
  CONSTRAINT `recipeingredients_ibfk_1` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`recipe_id`),
  CONSTRAINT `recipeingredients_ibfk_2` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`ingredient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recipeingredients`
--

LOCK TABLES `recipeingredients` WRITE;
/*!40000 ALTER TABLE `recipeingredients` DISABLE KEYS */;
INSERT INTO `recipeingredients` VALUES
(1,1,'67'),
(1,2,'5'),
(1,4,'NON'),
(10,1,'4'),
(10,3,'10'),
(11,2,''),
(11,4,'5'),
(12,2,''),
(12,4,'4'),
(13,1,'12'),
(13,2,'4'),
(13,3,'9');
/*!40000 ALTER TABLE `recipeingredients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recipes`
--

DROP TABLE IF EXISTS `recipes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recipes` (
  `recipe_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `creator_name` varchar(100) DEFAULT NULL,
  `instructions` text NOT NULL,
  `image` varchar(500) NOT NULL,
  `likes` int(11) NOT NULL DEFAULT 0,
  `categorie` varchar(100) NOT NULL,
  PRIMARY KEY (`recipe_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recipes`
--

LOCK TABLES `recipes` WRITE;
/*!40000 ALTER TABLE `recipes` DISABLE KEYS */;
INSERT INTO `recipes` VALUES
(1,'Cookies','Moi','1. mettre la farine au four 2.mettre au fous et manger','https://img.cuisineaz.com/1280x720/2015/08/11/i78773-cookie-moelleux-aux-pepites-de-chocolat.jpg',51,'Petit-Dejeuner'),
(10,'Omelette aux champignons','Chef Marie',' Battre les Å“ufs, ajouter les champignons coupÃ©s, cuire Ã  feu doux jusqu\'Ã  consistance moelleuse.','https://dxpulwm6xta2f.cloudfront.net/eyJidWNrZXQiOiJhZGMtZGV2LWltYWdlcy1yZWNpcGVzIiwia2V5IjoiUkVQX2x2XzE1NjI3X29tZWxldHRlX2NoYW1waWdub25zX3BhcmlzX3BsZXVyb3RlX2NlcGVzX3BlcnNpbF8uanBnIiwiZWRpdHMiOnsianBlZyI6eyJxdWFsaXR5Ijo4MH0sInBuZyI6eyJxdWFsaXR5Ijo4MH0sIndlYnAiOnsicXVhbGl0eSI6ODB9fX0=',0,'Petit-Dejeuner'),
(11,'Poulet rÃ´ti aux herbes','Chef Antoine','Assaisonner le poulet avec des herbes fraÃ®ches, rÃ´tir au four jusqu\'Ã  ce qu\'il soit dorÃ© et croustillant.','https://mccormick.widen.net/content/ajszpbmyqs/original/poulet_roti_aux_herbes_de_provence_et_ses_legumes_2000x1125.jpg',0,'Repas'),
(12,'Spaghetti Bolognese','Chef Paolo','PrÃ©parer une sauce bolognaise savoureuse, servir sur des spaghetti cuits al dente.','https://supervalu.ie/thumbnail/800x600/var/files/real-food/recipes/Uploaded-2020/spaghetti-bolognese-recipe.jpg',0,'Repas'),
(13,'Chili con carne','Chef Maria','Cuire la viande hachÃ©e avec des haricots rouges, des tomates et des Ã©pices pour un chili savoureux.','https://img.cuisineaz.com/660x660/2021/09/17/i180572-shutterstock-1886261287.jpeg',0,'Dinner');
/*!40000 ALTER TABLE `recipes` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-12-03 23:38:06
