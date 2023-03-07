-- MySQL dump 10.13  Distrib 8.0.26, for Linux (x86_64)
--
-- Host: localhost    Database: qg_song_data
-- ------------------------------------------------------
-- Server version	8.0.26

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
-- Table structure for table `Album`
--

DROP TABLE IF EXISTS `Album`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Album` (
                         `id` int NOT NULL AUTO_INCREMENT,
                         `name_cyr` varchar(150) DEFAULT NULL,
                         `name_lat` varchar(150) DEFAULT NULL,
                         `cover_art` varchar(1000) DEFAULT NULL,
                         `release_date` datetime DEFAULT CURRENT_TIMESTAMP,
                         `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                         `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                         `main_artist_id` int DEFAULT NULL,
                         PRIMARY KEY (`id`),
                         KEY `Album_Artist_id_fk` (`main_artist_id`),
                         CONSTRAINT `Album_Artist_id_fk` FOREIGN KEY (`main_artist_id`) REFERENCES `Artist` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10000002 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Album`
--

LOCK TABLES `Album` WRITE;
/*!40000 ALTER TABLE `Album` DISABLE KEYS */;
/*!40000 ALTER TABLE `Album` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `AlbumArtists`
--

DROP TABLE IF EXISTS `AlbumArtists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `AlbumArtists` (
                                `id` int NOT NULL AUTO_INCREMENT,
                                `album_id` int NOT NULL,
                                `artist_id` int NOT NULL,
                                PRIMARY KEY (`id`),
                                KEY `AlbumArtists_Album_id_fk` (`album_id`),
                                KEY `AlbumArtists_Artist_id_fk` (`artist_id`),
                                CONSTRAINT `AlbumArtists_Album_id_fk` FOREIGN KEY (`album_id`) REFERENCES `Album` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                                CONSTRAINT `AlbumArtists_Artist_id_fk` FOREIGN KEY (`artist_id`) REFERENCES `Artist` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AlbumArtists`
--

LOCK TABLES `AlbumArtists` WRITE;
/*!40000 ALTER TABLE `AlbumArtists` DISABLE KEYS */;
/*!40000 ALTER TABLE `AlbumArtists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Artist`
--

DROP TABLE IF EXISTS `Artist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Artist` (
                          `id` int NOT NULL AUTO_INCREMENT,
                          `name_cyr` varchar(150) DEFAULT NULL,
                          `name_lat` varchar(150) DEFAULT NULL,
                          `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                          `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                          PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20000007 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Artist`
--

LOCK TABLES `Artist` WRITE;
/*!40000 ALTER TABLE `Artist` DISABLE KEYS */;
INSERT INTO `Artist` VALUES (20000001,'Молданазар','Moldanazar','2023-03-07 11:06:43','2023-03-07 11:06:43'),(20000002,'Aldiyar','Aldiyar','2023-03-07 11:07:56','2023-03-07 11:07:56'),(20000003,'Darkhan Juzz','Darkhan Juzz','2023-03-07 11:07:56','2023-03-07 11:07:56'),(20000004,'Ayau','Ayau','2023-03-07 11:07:56','2023-03-07 11:07:56'),(20000005,'Dequine','Dequine','2023-03-07 11:07:56','2023-03-07 11:07:56'),(20000006,'De lacure','De lacure','2023-03-07 11:07:56','2023-03-07 11:07:56');
/*!40000 ALTER TABLE `Artist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Lyrics`
--

DROP TABLE IF EXISTS `Lyrics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Lyrics` (
                          `id` int NOT NULL AUTO_INCREMENT,
                          `verse_nr` int NOT NULL,
                          `line_nr` int NOT NULL,
                          `qazaq_cyr` varchar(1000) DEFAULT NULL,
                          `qazaq_lat` varchar(1000) DEFAULT NULL,
                          `english` varchar(1000) DEFAULT NULL,
                          `russian` varchar(1000) DEFAULT NULL,
                          `original_lang` enum('qazaq_cyr','qazaq_lat','english','russian') NOT NULL COMMENT 'Language which is translated into to remaining languages. \nThis enum has to be updated everytime a new language gets added!',
                          `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                          `modfied` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                          `song_id` int NOT NULL,
                          PRIMARY KEY (`id`),
                          KEY `Lyrics_Song_id_fk` (`song_id`),
                          CONSTRAINT `Lyrics_Song_id_fk` FOREIGN KEY (`song_id`) REFERENCES `Song` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30000010 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Lyrics`
--

LOCK TABLES `Lyrics` WRITE;
/*!40000 ALTER TABLE `Lyrics` DISABLE KEYS */;
INSERT INTO `Lyrics` VALUES (30000001,1,1,'<0>Бірің</0> бауыр, бірің <1>дос</1>','<0>Bіrіń baýyr</0>, bіrіń <1>dos</1>','<0>Someone</0> is a brother, someone is a <1>friend</1>','<0>Кто-то</0> брат, кто-то <1>друг</1>','qazaq_cyr','2023-03-07 11:13:56','2023-03-07 11:13:56',50000001),(30000002,1,2,'<0>Жиылсын</0> бәрібасынқос','<0>Jıylsyn</0> bárіbasynqos','<0>Get them</0> all together','<0>Объедини</0> их всех во едино','qazaq_cyr','2023-03-07 11:23:11','2023-03-07 11:23:11',50000001),(30000003,1,3,'<0>Алыс</0>-<1>жақын</1> <2>таңдама</2>','<0>Alys</0>-<1>jaqyn</1 ><2>tańdama</2>','<2>Don\'t</2> choose between them','<2>Не выбирай</2> <0>дальнего</0> или <1>ближнего</1>','qazaq_cyr','2023-03-07 11:23:11','2023-03-07 11:23:11',50000001),(30000004,1,4,'<0>Бұл</0> <1>баршаға</1>','<0>Bul</0> <1>barshaga</1>','<0>That</0> is for <1>everyone</1>','<0>Это</0> для <1>каждого</1>','qazaq_cyr','2023-03-07 11:23:11','2023-03-07 11:23:11',50000001),(30000005,2,1,'Үстіне <0>киіп</0> алдымшапан (Шапан)','Ústіne <0>kıіp</0> aldymshapan (Shapan)','I <0>put</0> the shapan <0>on</0>','Я <0>надел</0> шапан','qazaq_cyr','2023-03-07 11:23:11','2023-03-07 11:23:11',50000001),(30000006,2,3,'<0>Көзқарас</0> өзге','<0>Kózqaras</0> ózge','We have a special <0>attitude</0>','<0>Отношение</0> к нам особое','qazaq_cyr','2023-03-07 12:23:05','2023-03-07 12:23:08',50000001),(30000007,2,4,'<0>Өзен</0> бопсарқылсын <1>береке</1> меніңеліме\"','<0>Ózen</0> bopsarqylsyn <1>bereke</1 >menіńelіme','Let <1>abundance</1> flow in my nation as a <0>river</0>','Пусть <1>изобилие</1> течет в моей стране словно<0>река</0>   \r','qazaq_cyr','2023-03-07 11:23:11','2023-03-07 11:23:11',50000001),(30000008,2,5,'Сақталсын береке <0>мекенімде</0>','Saqtalsyn bereke <0>mekenіmde</0>','Let there be peace in my <0>motherland</0>','Пусть будет мир на <0>родной земле</0>','qazaq_cyr','2023-03-07 11:23:11','2023-03-07 11:23:11',50000001),(30000009,2,2,'<0>Төгілсін</0> қымыз, <1>керек емес</1> шампан, бізге','<0>Tógіlsіn</0> qymyz, <1>kerek emes</1> shampan, bіzge','Let the kymyz <0>flow</0>, we <1>don\'t need</1> champagne','Пусть <0>льется</0> кымыз, нам <1>не нужно</1> шампанское','qazaq_cyr','2023-03-07 11:37:49','2023-03-07 11:37:49',50000001);
/*!40000 ALTER TABLE `Lyrics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Media`
--

DROP TABLE IF EXISTS `Media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Media` (
                         `id` int NOT NULL AUTO_INCREMENT,
                         `name` varchar(150) NOT NULL,
                         `url` varchar(1000) NOT NULL,
                         `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                         `modified` datetime DEFAULT CURRENT_TIMESTAMP,
                         `song_id` int NOT NULL,
                         PRIMARY KEY (`id`),
                         KEY `Media_Song_id_fk` (`song_id`),
                         CONSTRAINT `Media_Song_id_fk` FOREIGN KEY (`song_id`) REFERENCES `Song` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=40000005 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Media`
--

LOCK TABLES `Media` WRITE;
/*!40000 ALTER TABLE `Media` DISABLE KEYS */;
INSERT INTO `Media` VALUES (40000002,'Youtube','https: //www.youtube.com/watch?v=His0lJ_Yua4','2023-03-07 11:10:44','2023-03-07 11:10:44',50000001),(40000003,'Spotify','https: //open.spotify.com/album/3ijsmdTm9reCg8NWUo4PlY?referral=qazaqgenius','2023-03-07 11:11:29','2023-03-07 11:11:29',50000001),(40000004,'Deezer','https: //www.deezer.com/us/album/387479007','2023-03-07 11:11:29','2023-03-07 11:11:29',50000001);
/*!40000 ALTER TABLE `Media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Song`
--

DROP TABLE IF EXISTS `Song`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Song` (
                        `id` int NOT NULL AUTO_INCREMENT,
                        `title_cyr` varchar(300) DEFAULT NULL,
                        `title_lat` varchar(300) DEFAULT NULL,
                        `release_date` datetime DEFAULT CURRENT_TIMESTAMP,
                        `created` datetime DEFAULT CURRENT_TIMESTAMP,
                        `modified` datetime DEFAULT CURRENT_TIMESTAMP,
                        `main_artist_id` int DEFAULT NULL,
                        `album_id` int DEFAULT NULL,
                        PRIMARY KEY (`id`),
                        KEY `Song_Artist_id_fk` (`main_artist_id`),
                        KEY `Song_Album_id_fk` (`album_id`),
                        CONSTRAINT `Song_Album_id_fk` FOREIGN KEY (`album_id`) REFERENCES `Album` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
                        CONSTRAINT `Song_Artist_id_fk` FOREIGN KEY (`main_artist_id`) REFERENCES `Artist` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=50000002 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Song`
--

LOCK TABLES `Song` WRITE;
/*!40000 ALTER TABLE `Song` DISABLE KEYS */;
INSERT INTO `Song` VALUES (50000001,'Сеніммен','Senimmen','2022-12-23 00:00:00','2023-03-07 11:08:50','2023-03-07 11:08:50',NULL,NULL);
/*!40000 ALTER TABLE `Song` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `SongArtists`
--

DROP TABLE IF EXISTS `SongArtists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `SongArtists` (
                               `id` int NOT NULL AUTO_INCREMENT,
                               `artist_id` int NOT NULL,
                               `song_id` int NOT NULL,
                               PRIMARY KEY (`id`),
                               KEY `SongArtists_Artist_id_fk` (`artist_id`),
                               KEY `SongArtists_Song_id_fk` (`song_id`),
                               CONSTRAINT `SongArtists_Artist_id_fk` FOREIGN KEY (`artist_id`) REFERENCES `Artist` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                               CONSTRAINT `SongArtists_Song_id_fk` FOREIGN KEY (`song_id`) REFERENCES `Song` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Additional artists for a song (feat.)';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SongArtists`
--

LOCK TABLES `SongArtists` WRITE;
/*!40000 ALTER TABLE `SongArtists` DISABLE KEYS */;
INSERT INTO `SongArtists` VALUES (1,20000001,50000001),(2,20000002,50000001),(3,20000003,50000001),(4,20000004,50000001),(5,20000005,50000001),(6,20000006,50000001);
/*!40000 ALTER TABLE `SongArtists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Words`
--

DROP TABLE IF EXISTS `Words`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Words` (
                         `id` int NOT NULL AUTO_INCREMENT,
                         `word_in_line_nr` tinyint NOT NULL,
                         `qazaq_cyr` varchar(150) DEFAULT NULL,
                         `qazaq_lat` varchar(150) DEFAULT NULL,
                         `english` varchar(150) DEFAULT NULL,
                         `russian` varchar(150) DEFAULT NULL,
                         `additional_info` text,
                         `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                         `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                         `lyrics_id` int DEFAULT NULL,
                         PRIMARY KEY (`id`),
                         KEY `Words_Lyrics_id_fk` (`lyrics_id`),
                         CONSTRAINT `Words_Lyrics_id_fk` FOREIGN KEY (`lyrics_id`) REFERENCES `Lyrics` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=60000008 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Words`
--

LOCK TABLES `Words` WRITE;
/*!40000 ALTER TABLE `Words` DISABLE KEYS */;
INSERT INTO `Words` VALUES (60000001,0,'жию','jıyu','collect/unite','собирать','This is a additional info that is sometimes shown','2023-03-07 11:32:37','2023-03-07 11:32:37',30000002),(60000002,0,'алыс','alys','far away','дальний',NULL,'2023-03-07 11:34:50','2023-03-07 11:34:50',30000003),(60000003,1,'жакын','jakyn','closest','ближний','Just some random info','2023-03-07 11:34:50','2023-03-07 11:34:50',30000003),(60000004,2,'тандау','tandau','choice','выбор',NULL,'2023-03-07 11:34:50','2023-03-07 11:34:50',30000003),(60000005,1,'барша','barsha','everyone','каждый',NULL,'2023-03-07 11:35:57','2023-03-07 11:35:57',30000004),(60000006,0,'кию','kıyu','put on','надеть',NULL,'2023-03-07 11:39:19','2023-03-07 11:39:19',30000005),(60000007,0,'туған мекет',NULL,'motherland','родная земля','Info text','2023-03-07 11:40:19','2023-03-07 11:40:19',30000008);
/*!40000 ALTER TABLE `Words` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-03-07 20:23:23
