/* PROJET 4 : BASE DE DONNÉÉE POUR SITE DE COMMANDE DE PLAT EN LIGNE--------------
----------------------------------------------------------------------------------
PARCOURS DE FORMATION DEVELOPPER D'APPLICATION PHP SYMFONY OPENCLASSROOMS --------
----------------------------------------------------------------------------------
------------------------------------------------------DATE : 20/05/2019------------*/

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




/* CREATION DE LA STRUCTURE DE LA BASE DE DONNÉE ---------------------------------
----------------------------------------------------------------------------------*/
--
-- Table structure for table `category`
--
CREATE DATABASE IF NOT EXISTS blog CHARACTER SET `utf8`;

USE blog;

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Actualite'),(2,'Information'),(3,'Projet'),(4,'Formation'),(5,'Technologie');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(10) unsigned NOT NULL,
  `comment_text` varchar(255) NOT NULL,
  `update_date` datetime DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `validation` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_post_id` (`post_id`),
  CONSTRAINT `fk_post_id` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `comment` VALUES (5,1,'j\'adore symfony','2019-05-20 21:53:02','Dupont tom',1),(6,7,'Cool je vais voir ca de suite !!!','2019-05-20 22:24:14','tom Dupont',1),(7,6,'TrÃ¨s joli bravo !!!','2019-05-20 22:24:43','tom Dupont',1),(8,5,'Merci de l\'info je viens d\'apprendre beaucoup de chose','2019-05-20 22:25:43','tom Dupont',1),(9,3,'Salut moi aussi je suis la mÃªme formation ...','2019-05-20 22:26:32','tom Dupont',1),(10,1,'Je ne connais pas encore ce framework. est il bien?','2019-05-20 22:27:37','Sarah Durant',1),(11,6,'intÃ©ressant ce projet dit moi!!','2019-05-20 22:28:28','Sarah Durant',1),(12,3,'C\'est une trÃ¨s bonne formation je connais bien Openclassrooms.','2019-05-20 22:29:51','Sarah Durant',1),(13,4,'C\'est un peu trop compliquÃ© pour moi ...','2019-05-20 22:30:44','Sarah Durant',1),(14,1,'C\'est un framework trÃ¨s puissant je l\'utilise depuis des annÃ©es','2019-05-20 22:32:16','Pierre Lucciani',1),(15,7,'je vais aller y faire un tour merci','2019-05-20 22:32:51','Pierre Lucciani',1),(16,6,'une belle rÃ©alisation mais il reste encore a faire je pense...','2019-05-20 22:33:37','Pierre Lucciani',1),(17,5,'trop facile le html5!!!','2019-05-20 22:34:04','Pierre Lucciani',1),(18,3,'je vais me renseigner sur cette formation ou puis je trouver leur adresse ?','2019-05-20 22:34:54','Pierre Lucciani',1),(19,4,'intÃ©ressant cette alternative mais est ce viable ?','2019-05-20 22:35:51','Pierre Lucciani',1);
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` longtext NOT NULL,
  `update_date` datetime NOT NULL,
  `preview_text` varchar(300) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_category_id` (`category_id`),
  KEY `fk_user_id` (`user_id`),
  CONSTRAINT `fk_category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post`
--

LOCK TABLES `post` WRITE;
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
INSERT INTO `post` VALUES (1,5,2,'Qu\'est ce que Symfony','Symfony est donc un framework PHP ! Il fournit une mÃ©thodologie (conventions d\'Ã©criture et d\'organisation, discipline du code produit, MVC), des outils (CRUD, GÃ©nÃ©ration d\'amin, plugins/bundles). Il intÃ¨gre des outils qui lui apporte des fonctionnalitÃ©s intÃ©ressante et qui ne sont pas de trop comme l\'ORM Doctrine et un moteur de template (Twig).\r\n\r\nComme tout framework, il nÃ©cessite un temps de formation, d\'apprentissage des bonnes pratiques. Mais ce temps en vaut la peine !\r\n\r\nSymfony utilise des bundles pour ajouter, retirer, modifier des fonctionnalitÃ©s sur vos projets. Le kernel lui mÃªme de Symfony est un bundle !\r\n\r\nLes bundles sont utilisable sur tout vos projets, il existe des bundles pour Ã  peu prÃ¨s tout, vous n\'avez pas a rÃ©inventer la roue, il existe des bundles qui servent de CMS, des bundles pour faire des blogs, des forums, des systÃ¨mes de paiement en ligne, etc.\r\n\r\nLes formulaires sont aussi trÃ¨s simple Ã  mettre en place grÃ¢ce Ã  Symfony, il vous suffit d\'indiquer l\'objet pour lequel vous souhaitez crÃ©er ce formulaire et Symfony est capable de gÃ©nÃ©rer les champs en fonction des informations dont il dispose. Par exemple si vous avez un objet bureau et un objet tiroir, vous indiquez Ã  Symfony que l\'objet tiroir est forcÃ©ment liÃ© Ã  un bureau, vous crÃ©ez ensuite un formulaire pour l\'objet bureau et un autre pour l\'objet tiroir, Symfony sait que tiroir doit Ãªtre liÃ© Ã  bureau, il vous proposera donc une liste de bureau dÃ©jÃ  stockÃ© en base lors de l\'affichage du formulaire. Vous n\'aurez pas eu de requÃªte Ã  Ã©crire ni de gestion de balise HTML etc.\r\n\r\nLe framework est de plus en plus utilisÃ© dans les entreprises et les offres d\'emploi recherchant des profils maÃ®trisant Symfony croissent sur les sites d\'annonces professionnels, maÃ®triser Symfony est un plus qui peut vous ouvrir plusieurs portes.\r\n\r\nEnfin la communautÃ© utilisant le framwork Symfony est trÃ¨s active, comme beaucoup de projet open source, ce qui permet d\'Ãªtre plutÃ´t bien informÃ© et guidÃ© en cas de problÃ¨me par des utilisateurs certifiÃ©s. SensioLabs met en place des certificats que l\'on peut passer dans des centres d\'examens comme des certificats Microsoft ou Cisco.\r\n\r\nDe plus le framework Symfony est un des meilleurs, si ce n\'est le meilleur, framework PHP du moment sur le marchÃ©, avec plus de 300 000 dÃ©veloppeur Symfony recensÃ© Ã  travers le monde, des projet comme Spotify ou BlaBlaCar l\'utilisant il peut donc jouir d\'une assez bonne presse, ce qui est tout Ã  fait normal.','2019-05-20 22:14:32','Symfony est lâ€™un des frameworks PHP les plus populaires et des plus utilisÃ©s au monde! Il est Ã©ditÃ© par la sociÃ©tÃ© SensioLabs. DiffusÃ© comme un logiciel libre, Symfony bÃ©nÃ©ficie de contributions de toute la communautÃ© : beaucoup de franÃ§ais mais aussi des dÃ©veloppeurs de tous horizons.'),(2,2,2,'A propos de moi','Durant toutes mes annÃ©es d\'Ã©tude, j\'ai codÃ© dans divers langages de programmation (Pascal, C,Assembleur...) et participÃ© Ã©galement Ã  plusieurs projets embarquÃ©s. Aujourd\'hui le monde du web devient incontournable, c\'est pourquoi je suis actuellement une formation de DÃ©veloppeur d\'application PHP/Symfony sur Openclassrooms. Mes diffÃ©rentes expÃ©riences professionnelles mon permis d\'acquÃ©rir les aptitudes requises au travail en Ã©quipe nÃ©anmoins je suis capable de suivre un projet complet de faÃ§on autonome. De nature crÃ©atif et dynamique, je suis tout Ã  fait Ã  l\'aise sur un developpement Front ou Backend. ','2019-05-08 22:33:36','Durant toutes mes annÃ©es d\'Ã©tude, j\'ai codÃ© dans divers langages de programmation (Pascal, C,Assembleur...) et participÃ© Ã©galement Ã  plusieurs projets embarquÃ©s. Aujourd\'hui le monde du web devient incontournable, c\'est pourquoi je suis actuellement une formation de DÃ©veloppeur.'),(3,4,2,'DÃ©veloppeur d\'Application PHP/Symphony',' OpenClassrooms est un Ã©tablissement privÃ© d\'enseignement Ã  distance dÃ©clarÃ© au rectorat de l\'AcadÃ©mie de Paris, dÃ©livrant ses propres diplÃ´mes ainsi que ceux d\'autres partenaires acadÃ©miques prestigieux.\r\n\r\nÃ€ l\'issue de votre formation et de la validation de vos compÃ©tences par le jury du diplÃ´me, vous pourrez obtenir le diplÃ´me \"DÃ©veloppeur(euse) d\'application\" enregistrÃ© au RÃ©pertoire National des Certifications Professionnelles.\r\n\r\nCe diplÃ´me est de niveau DiplÃ´me niveau Bac+3/4, c\'est-Ã -dire de niveau 6 sur le Cadre EuropÃ©en des Certifications (European Qualifications Framework) et de niveau DiplÃ´me niveau Bac+3/4 sur le cadre franÃ§ais.\r\n\r\nGrÃ¢ce Ã  la spÃ©cialisation PHP / Symfony,  je vais abordÃ© tous les sujets centraux me permettant de dÃ©velopper une application de maniÃ¨re professionnelle et robuste. Depuis lâ€™affichage de donnÃ©es provenant de la base de donnÃ©es, la traduction de contenu ou construire une API REST.\r\n\r\nLa formation me permettra d\'acquÃ©rir et de maÃ®triser ces compÃ©tences :\r\n\r\n    -Analyse d\'un cahier des charges et choix d\'une solution technique adaptÃ©e parmi les solutions existantes.\r\n    -Conception de lâ€™architecture technique dâ€™une application Ã  lâ€™aide de diagrammes UML.\r\n    -CrÃ©ation de projet web dynamique grÃ¢ce PHP.\r\n    -Communiquer avec une base de donnÃ©es pour stocker et requÃªter des informations.\r\n    -DÃ©velopper de maniÃ¨re professionnelle grÃ¢ce au framework Symfony.\r\n    -Mise en oeuvre des tests unitaires et fonctionnels ainsi quâ€™utiliser les outils les plus connus dâ€™intÃ©gration continue.\r\n    -Production d\'une documentation technique et fonctionnelle pour chaque application.\r\n    -Prise en compte des problÃ©matiques de performance dâ€™une application PHP.\r\n\r\nJe terminerai cette formation courant Septembre 2019 je pourrai donc mettre Ã  disposition mes compÃ©tences de DÃ©veloppeur d\'Application PHP/Symfony pour tous vos projets dÃ©s la validation de celle ci. \r\n\r\n\r\n','2019-05-12 22:05:35','Je suis actuellement un parcours de formation sur Openclassrooms comme DÃ©veloppeur d\'Application PHP/Symfony.GrÃ¢ce Ã  la spÃ©cialisation PHP / Symfony de cette formation permettra de traiter tous les sujets centraux et donc de participer a diverses projets. '),(4,1,2,'WebAssembly, une alternative au JavaScript ?','Apple, Google, Mozilla, Webkit : main dans la main avec la bÃ©nÃ©diction de Brendan Eich, inventeur du JavaScript, les grands acteurs du web annoncent lâ€™ouverture du projet WebAssembly, une technologie web visant Ã  proposer une alternative plus performante au trÃ¨s populaire JavaScript.\r\n\r\nJavaScript est aujourdâ€™hui un langage de programmation extrÃªmement populaire sur le web, et tous les acteurs et navigateurs ont proposÃ©s successivement leur variante ou amÃ©lioration de cette technologie afin dâ€™amÃ©liorer et de capitaliser sur ce standard. On peut ainsi citer asm.js du cÃ´tÃ© de Mozilla, Dart pour Google, ou encore les travaux dâ€™Apple sur lâ€™accÃ©lÃ©ration JavaScript sur Safari.\r\n\r\nMais quand chacun dÃ©veloppe son propre standard, on se retrouve gÃ©nÃ©ralement avec lâ€™inverse exact du concept de Â« standard Â» : on peut donc voir dâ€™un bon Å“il lâ€™arrivÃ©e de WebAssembly, projet commun Ã  ces diffÃ©rents acteurs. \r\n\r\nWebAssembly se dÃ©finit comme un bytecode complÃ©mentaire Ã  JavaScript : il nâ€™a pas lâ€™intention, comme Dart, de remplacer complÃ¨tement le traditionnel langage, mais plutÃ´t dâ€™enrichir ses possibilitÃ©s en offrant une alternative pour les taches qui nÃ©cessitent dâ€™avoir un meilleur contrÃ´le sur lâ€™utilisation des ressources de la machine.\r\n\r\nCelui-ci prendra la forme de fichiers binaires en .wasm qui pourront ainsi sâ€™exÃ©cuter dans le navigateur en profitant de performances optimales, contrairement aux scripts qui doivent Ãªtre compilÃ©s Ã  la volÃ©e Ã  chaque exÃ©cution.\r\n\r\nSi chacun avait multipliÃ© les annonces dans son coin, le projet WebAssembly entend donc rÃ©unir les principaux acteurs dans une mÃªme dÃ©marche afin de bÃ©nÃ©ficier de la traction nÃ©cessaire pour sâ€™imposer dans lâ€™Ã©cosystÃ¨me avec une diffusion comparable Ã  celle du JavaScript. WebAssembly ne tente pas de remplacer le langage, mais se dÃ©finit clairement comme un complÃ©ment, qui coexistera avec les technologies dÃ©jÃ  existantes.\r\n\r\nPour lâ€™instant, le projet est encore balbutiant, mais une page github rassemblant les premiers travaux a Ã©tÃ© mise en ligne et lâ€™avancement de celui-ci est menÃ© par un groupe de travail du W3C.','2019-05-12 22:09:12','Dans un effort commun de standardisation et dâ€™amÃ©lioration des performances web, plusieurs acteurs majeurs se rangent derriÃ¨re le projet WebAssembly, une technologie qui se prÃ©sente comme une alternative plus performante du JavaScript.'),(5,5,2,'Qu\'est ce que le HTML5','Le HTML5, pour HyperText Markup Language 5, est une version du cÃ©lÃ¨bre format HTML utilisÃ© pour concevoir les sites Internet. Celui-ci se rÃ©sume Ã  un langage de balisage qui sert Ã  l\'Ã©criture de l\'hypertexte indispensable Ã  la mise en forme d\'une page Web. LancÃ©e en octobre 2014, cette version HTML5 apporte de nouveaux Ã©lÃ©ments et de nouveaux attributs par rapport Ã  la version prÃ©cÃ©dente. Elle offre par exemple la possibilitÃ© de dÃ©finir le contenu principal d\'une page Web, d\'ajouter une introduction en header, d\'insÃ©rer un sous-titre Ã  un contenu multimÃ©dia de type vidÃ©o, etc.\r\n\r\nLe HTML5 est un format de langage dÃ©veloppÃ© par le W3C (World Wide Web Consortium) et le WHATWG (Web Hypertext Application Technology Working Group). Le successeur de HTML5 n\'aura peut-Ãªtre pas de numÃ©ro : il s\'agira alors non pas de HTML6, mais de HTML Living Standard... En attendant, la version HTML5.1 a paru en 2016 et HTML5.2 en 2017. \r\nAttention, dans les propos des webmasters, le terme HTML5 regroupe souvent plusieurs technologies destinÃ©es notamment au dÃ©veloppement d\'applications : HTML5, CSS3 et JavaScript. On parle aussi de DHTML : Dynamic HTML, en rÃ©fÃ©rence Ã  ces technologies qui rendent les pages web aptes Ã  se modifier au fil de la consultation, directement sur le navigateur web. . ','2019-05-20 22:01:51','Le HTML5, pour HyperText Markup Language 5, est une version du cÃ©lÃ¨bre format HTML utilisÃ© pour concevoir les sites Internet. Celui-ci se rÃ©sume Ã  un langage de balisage qui sert Ã  l\'Ã©criture de l\'hypertexte indispensable Ã  la mise en forme d\'une page Web'),(6,3,2,'RÃ©alisation du Blog professionnel','Ce projet fait partie des diffÃ©rents projets que j\'ai rÃ©alisÃ© durant la formation de dÃ©veloppeur d\'application PHP Symphony dâ€™Openclassrooms.\r\nCe projet avait pour but de dÃ©velopper  les compÃ©tences telles que le respect des normes PSR Ã  savoir les principales normes qui dÃ©finition  le style du code  PHP, mais aussi les normes  d\'auto chargement des classes  et de gestion  des messages HTTP.\r\nLe projet devait Ãªtre rÃ©aliser suivant une architecture basÃ©e sur le modÃ¨le MVC et un des critÃ¨res importants du projet Ã©tait la sÃ©curisation des principales faille de sÃ©curitÃ© comme XSS CRSF SQL injection et session hijacking.\r\nLa totalitÃ© du projet devait Ãªtre versionnÃ© sur Github grÃ¢ce au logiciel de versionning Git en appliquant les bonnes pratiques d\'usage.\r\nEn ce qui concerne le contenu du site qui Ã©tait Ã  dÃ©velopper, le site est composÃ© de deux   principales parties, une partie rÃ©servÃ© aux visiteurs et une partie uniquement rÃ©servÃ© aux personnes habilitÃ©es Ã  administrer le site.\r\nLâ€™accÃ¨s Ã  la partie administration devait Ãªtre sÃ©curisÃ© par une authentification avec mot de passe.\r\n','2019-05-20 22:10:49','Ce projet fait partie des diffÃ©rents projets que j\'ai rÃ©alisÃ© durant la formation de dÃ©veloppeur d\'application PHP Symphony dâ€™Openclassrooms.\r\nCe projet avait pour but de dÃ©velopper  les compÃ©tences telles que le respect des normes PSR, la maitrise de l\'architecture MVC ...'),(7,3,2,'Suivez tous mes projets sur Github','Retrouvez tous mes projets sur mon repositorie Github  Ã  cette adresse https://github.com/jeremybouvier','2019-05-20 22:14:01','Retrouvez tous mes projets sur mon repositorie Github  Ã  cette adresse https://github.com/jeremybouvier');
/*!40000 ALTER TABLE `post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (1,'Administrateur'),(2,'Visiteur'),(3,'Redacteur');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `surname` varchar(45) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `login_name` varchar(45) NOT NULL,
  `password` varchar(60) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_role_id` (`role_id`),
  CONSTRAINT `fk_role_id` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,1,'Admin','Admin','admin@blog.com','admin','$2y$10$YUKA8K1vwhxlJuirjccviuy1X6qYCrrspMtaAqGgjZkrYQdy1GOM.'),(2,1,'Bouvier','JÃ©rÃ©my','jeremybouvier2b@gmail.com','jeremybouvier','$2y$10$csZJVQDmgqVBYhUpemVLdOicOm2bCn68yVCqqm9VyIq4uMiAWPp5S'),(4,2,'Dupont','Tom','tomdupont@gmail.com','tom','$2y$10$dNsd6hXePlQVOCzuzRoR2ex08oxFYWpgAQg4yu1JokoxfXnHNq9u2'),(5,2,'Durant','Sarah','sarahdurant@gmail.com','sarah','$2y$10$3o3YqBp3jhRQ5nOD8BAmVuYxHrGu/Z5ntcTwP0mYgQcGcWuOBijYa'),(6,2,'Lucciani','Pierre','pierrelucciani@gmail.com','pierre','$2y$10$IaPuQv4YGA4u.Cfxoj7y2uB./OdKO2RlukE.q1XuUOl9GSjaKu52e');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-05-23 21:07:54
