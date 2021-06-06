CREATE DATABASE  IF NOT EXISTS `prolab_database` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `prolab_database`;
-- MySQL dump 10.13  Distrib 8.0.22, for Win64 (x86_64)
--
-- Host: localhost    Database: prolab_database
-- ------------------------------------------------------
-- Server version	8.0.21

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `administrators`
--

DROP TABLE IF EXISTS `administrators`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `administrators` (
  `idAdministrator` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idAdministrator`),
  UNIQUE KEY `idKorisnika_UNIQUE` (`idAdministrator`),
  CONSTRAINT `FK_administrators_idAdministrator` FOREIGN KEY (`idAdministrator`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrators`
--

LOCK TABLES `administrators` WRITE;
/*!40000 ALTER TABLE `administrators` DISABLE KEYS */;
INSERT INTO `administrators` VALUES (3);
/*!40000 ALTER TABLE `administrators` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `appointments`
--

DROP TABLE IF EXISTS `appointments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `appointments` (
  `idAppointment` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `classroom` varchar(45) DEFAULT NULL,
  `capacity` int NOT NULL,
  `location` varchar(80) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `idLabExercise` int NOT NULL,
  PRIMARY KEY (`idAppointment`),
  KEY `FK_appointment_labExercise_idx` (`idLabExercise`),
  CONSTRAINT `FK_appointments_idLabExercise` FOREIGN KEY (`idLabExercise`) REFERENCES `lab_exercises` (`idLabExercise`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appointments`
--

LOCK TABLES `appointments` WRITE;
/*!40000 ALTER TABLE `appointments` DISABLE KEYS */;
INSERT INTO `appointments` VALUES (4,'Lab1','70',70,'ETF','2021-07-16 10:00:00',3),(5,'Lab1','61',30,'ETF','2021-07-16 13:00:00',3),(6,'Lab1','309',40,'ETF','2021-07-16 16:00:00',3),(7,'Lab2','65',1,'ETF','2021-07-28 10:00:00',4),(8,'Lab2','65',1,'ETF','2021-07-28 13:00:00',4),(10,'Lab3','70',2,'ETF','2021-06-06 22:40:00',5);
/*!40000 ALTER TABLE `appointments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attends`
--

DROP TABLE IF EXISTS `attends`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attends` (
  `idStudent` int NOT NULL,
  `idSubject` int NOT NULL,
  PRIMARY KEY (`idStudent`,`idSubject`),
  KEY `FK_pohadja_idpredmeta_idx` (`idSubject`),
  CONSTRAINT `FK_attends_idStudent` FOREIGN KEY (`idStudent`) REFERENCES `students` (`idStudent`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_attends_idSubject` FOREIGN KEY (`idSubject`) REFERENCES `subjects` (`idSubject`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attends`
--

LOCK TABLES `attends` WRITE;
/*!40000 ALTER TABLE `attends` DISABLE KEYS */;
INSERT INTO `attends` VALUES (9,4),(9,5),(10,5),(9,6),(8,7),(9,7),(10,7),(11,7),(9,8),(9,9);
/*!40000 ALTER TABLE `attends` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `free_agents`
--

DROP TABLE IF EXISTS `free_agents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `free_agents` (
  `idHasAppointment` int NOT NULL,
  `idDesiredAppointment` int NOT NULL,
  PRIMARY KEY (`idHasAppointment`,`idDesiredAppointment`),
  KEY `FK_freeAgents_idAppointment_idx` (`idDesiredAppointment`),
  CONSTRAINT `FK_freeAgents_idAppointment` FOREIGN KEY (`idDesiredAppointment`) REFERENCES `appointments` (`idAppointment`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `free_agents`
--

LOCK TABLES `free_agents` WRITE;
/*!40000 ALTER TABLE `free_agents` DISABLE KEYS */;
INSERT INTO `free_agents` VALUES (25,7);
/*!40000 ALTER TABLE `free_agents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `has_appointment`
--

DROP TABLE IF EXISTS `has_appointment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `has_appointment` (
  `idHasAppointment` int NOT NULL AUTO_INCREMENT,
  `idStudent` int NOT NULL,
  `idAppointment` int NOT NULL,
  PRIMARY KEY (`idHasAppointment`),
  KEY `FK_hasAppointment_idStudent_idx` (`idStudent`),
  KEY `FK_hasAppointment_idAppointment_idx` (`idAppointment`),
  CONSTRAINT `FK_hasAppointment_idAppointment` FOREIGN KEY (`idAppointment`) REFERENCES `appointments` (`idAppointment`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_hasAppointment_idStudent` FOREIGN KEY (`idStudent`) REFERENCES `students` (`idStudent`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `has_appointment`
--

LOCK TABLES `has_appointment` WRITE;
/*!40000 ALTER TABLE `has_appointment` DISABLE KEYS */;
INSERT INTO `has_appointment` VALUES (18,10,4),(19,8,5),(22,8,7),(25,9,8),(26,9,5),(27,11,6);
/*!40000 ALTER TABLE `has_appointment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lab_exercises`
--

DROP TABLE IF EXISTS `lab_exercises`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lab_exercises` (
  `idLabExercise` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `expiration` datetime NOT NULL,
  `idSubject` int NOT NULL,
  PRIMARY KEY (`idLabExercise`),
  KEY `FK_subject_idx` (`idSubject`),
  CONSTRAINT `FK_labExercices_idSubject` FOREIGN KEY (`idSubject`) REFERENCES `subjects` (`idSubject`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lab_exercises`
--

LOCK TABLES `lab_exercises` WRITE;
/*!40000 ALTER TABLE `lab_exercises` DISABLE KEYS */;
INSERT INTO `lab_exercises` VALUES (3,'Lab1','Radićemo vrlo teške zadatke. (ABUS i DBUS)','2021-07-15 10:00:00',7),(4,'Lab2','Opis.','2021-07-27 10:00:00',7),(5,'Lab3','Opis','2021-06-06 22:38:00',7);
/*!40000 ALTER TABLE `lab_exercises` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `new_subject_requests`
--

DROP TABLE IF EXISTS `new_subject_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `new_subject_requests` (
  `idRequest` int NOT NULL AUTO_INCREMENT,
  `subjectName` varchar(45) NOT NULL,
  `idTeacher` int NOT NULL,
  PRIMARY KEY (`idRequest`),
  KEY `FK_zahteviZaNovePredmete_idTeacher_idx` (`idTeacher`),
  CONSTRAINT `FK_newSubjectRequests_idTeacher` FOREIGN KEY (`idTeacher`) REFERENCES `teachers` (`idTeacher`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `new_subject_requests`
--

LOCK TABLES `new_subject_requests` WRITE;
/*!40000 ALTER TABLE `new_subject_requests` DISABLE KEYS */;
INSERT INTO `new_subject_requests` VALUES (8,'Veb dizajn_VD',6),(9,'Sistemi softver_SS',6);
/*!40000 ALTER TABLE `new_subject_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `new_subject_requests_teaches`
--

DROP TABLE IF EXISTS `new_subject_requests_teaches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `new_subject_requests_teaches` (
  `idRequest` int NOT NULL,
  `idTeacher` int NOT NULL,
  PRIMARY KEY (`idRequest`,`idTeacher`),
  KEY `FK_idAssociateTeacher_idx` (`idTeacher`),
  CONSTRAINT `FK_newSubjectRequestsTeaches_idRequest` FOREIGN KEY (`idRequest`) REFERENCES `new_subject_requests` (`idRequest`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_newSubjectRequestsTeaches_idTeacher` FOREIGN KEY (`idTeacher`) REFERENCES `teachers` (`idTeacher`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `new_subject_requests_teaches`
--

LOCK TABLES `new_subject_requests_teaches` WRITE;
/*!40000 ALTER TABLE `new_subject_requests_teaches` DISABLE KEYS */;
INSERT INTO `new_subject_requests_teaches` VALUES (8,6),(9,6),(8,7),(9,7),(9,13);
/*!40000 ALTER TABLE `new_subject_requests_teaches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `projects` (
  `idProject` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `minMemberNumber` varchar(45) NOT NULL,
  `maxMemberNumber` varchar(45) NOT NULL,
  `expirationDate` date NOT NULL,
  `idSubject` int NOT NULL,
  PRIMARY KEY (`idProject`),
  KEY `FK_project_subject_idx` (`idSubject`),
  CONSTRAINT `FK_project_idSubject` FOREIGN KEY (`idSubject`) REFERENCES `subjects` (`idSubject`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (2,'Pravljenje crveno crnog stabla','2','4','2021-07-01',5);
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registration_requests`
--

DROP TABLE IF EXISTS `registration_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `registration_requests` (
  `idRegistrationRequest` int NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `userType` varchar(1) NOT NULL,
  PRIMARY KEY (`idRegistrationRequest`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registration_requests`
--

LOCK TABLES `registration_requests` WRITE;
/*!40000 ALTER TABLE `registration_requests` DISABLE KEYS */;
INSERT INTO `registration_requests` VALUES (11,'david,David,Villa','123456aA','vd181234d@student.etf.bg.ac.rs','s'),(12,'emma,Emma,Watson','123456aA','emma@admin.etf.rs','a'),(13,'samuel,Samuel,Beckett','123456aA','bs184321d@student.etf.bg.ac.rs','s'),(14,'maria,Maria,Montesorri','123456aA','mm181111d@student.etf.bg.ac.rs','s'),(15,'jokara,Nikola,Jokić','123456aA','dzoni@etf.rs','t');
/*!40000 ALTER TABLE `registration_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `students` (
  `idStudent` int NOT NULL AUTO_INCREMENT,
  `index` varchar(9) NOT NULL,
  PRIMARY KEY (`idStudent`),
  UNIQUE KEY `idKorisnika_UNIQUE` (`idStudent`),
  UNIQUE KEY `index_UNIQUE` (`index`),
  CONSTRAINT `FK_students_idStudent` FOREIGN KEY (`idStudent`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (11,'2012/0123'),(12,'2014/0123'),(10,'2017/0123'),(8,'2019/0123'),(9,'2019/0223');
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subject_join_requests`
--

DROP TABLE IF EXISTS `subject_join_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subject_join_requests` (
  `idRequest` int NOT NULL AUTO_INCREMENT,
  `idSubject` int NOT NULL,
  `idStudent` int NOT NULL,
  PRIMARY KEY (`idRequest`),
  KEY `FK_idSubject_idx` (`idSubject`),
  KEY `FK_idStudent_idx` (`idStudent`),
  CONSTRAINT `FK_subjectJoinRequests_idStudent` FOREIGN KEY (`idStudent`) REFERENCES `students` (`idStudent`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_subjectJoinRequests_idSubject` FOREIGN KEY (`idSubject`) REFERENCES `subjects` (`idSubject`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Mozda kao primary key da se stavi samo (idSubject, idStudent)?';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subject_join_requests`
--

LOCK TABLES `subject_join_requests` WRITE;
/*!40000 ALTER TABLE `subject_join_requests` DISABLE KEYS */;
INSERT INTO `subject_join_requests` VALUES (14,10,9),(15,9,10),(16,8,10),(17,10,10);
/*!40000 ALTER TABLE `subject_join_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subjects` (
  `idSubject` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `code` varchar(45) NOT NULL COMMENT 'Sifra predmeta',
  `idTeacher` int NOT NULL,
  PRIMARY KEY (`idSubject`),
  KEY `FK_subjects_idTeacher_idx` (`idTeacher`),
  CONSTRAINT `FK_subjects_idTeacher` FOREIGN KEY (`idTeacher`) REFERENCES `teachers` (`idTeacher`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subjects`
--

LOCK TABLES `subjects` WRITE;
/*!40000 ALTER TABLE `subjects` DISABLE KEYS */;
INSERT INTO `subjects` VALUES (4,'Osnovi Racunarske Tehnike 1','ORT1',6),(5,'Algoritmi i Strukture Podataka 1','ASP1',6),(6,'Algoritmi i Strukture Podataka 2','ASP2',6),(7,'Arhitektura Racunara','AR',7),(8,'Matematika 1','M1',7),(9,'Fizika 1','F1',7),(10,'Upravljanje u realnom vremenu','URV',6);
/*!40000 ALTER TABLE `subjects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teachers`
--

DROP TABLE IF EXISTS `teachers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `teachers` (
  `idTeacher` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idTeacher`),
  CONSTRAINT `FK_teachers_idTeacher` FOREIGN KEY (`idTeacher`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teachers`
--

LOCK TABLES `teachers` WRITE;
/*!40000 ALTER TABLE `teachers` DISABLE KEYS */;
INSERT INTO `teachers` VALUES (6),(7),(13);
/*!40000 ALTER TABLE `teachers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teaches`
--

DROP TABLE IF EXISTS `teaches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `teaches` (
  `idTeacher` int NOT NULL,
  `idSubject` int NOT NULL,
  PRIMARY KEY (`idTeacher`,`idSubject`),
  KEY `FK_teaches_idSubject_idx` (`idSubject`),
  CONSTRAINT `FK_teaches_idSubject` FOREIGN KEY (`idSubject`) REFERENCES `subjects` (`idSubject`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_teaches_idTeacher` FOREIGN KEY (`idTeacher`) REFERENCES `teachers` (`idTeacher`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teaches`
--

LOCK TABLES `teaches` WRITE;
/*!40000 ALTER TABLE `teaches` DISABLE KEYS */;
INSERT INTO `teaches` VALUES (6,4),(6,5),(6,6),(7,6),(6,7),(7,7),(6,8),(7,8),(7,9),(6,10);
/*!40000 ALTER TABLE `teaches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `team_members`
--

DROP TABLE IF EXISTS `team_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `team_members` (
  `idStudent` int NOT NULL,
  `idTeam` int NOT NULL,
  PRIMARY KEY (`idStudent`,`idTeam`),
  KEY `FK_teams_members_idTeam_idx` (`idTeam`),
  CONSTRAINT `FK_teamMembers_idStudent` FOREIGN KEY (`idStudent`) REFERENCES `students` (`idStudent`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_teamMembers_idTeam` FOREIGN KEY (`idTeam`) REFERENCES `teams` (`idTeam`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team_members`
--

LOCK TABLES `team_members` WRITE;
/*!40000 ALTER TABLE `team_members` DISABLE KEYS */;
INSERT INTO `team_members` VALUES (10,18),(9,19);
/*!40000 ALTER TABLE `team_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `teams` (
  `idTeam` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `locked` tinyint NOT NULL,
  `idProject` int NOT NULL,
  `idLeader` int NOT NULL,
  PRIMARY KEY (`idTeam`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  KEY `gfdgdfg_idx` (`idProject`),
  KEY `fk_teams_idLeader_idx` (`idLeader`),
  CONSTRAINT `fk_teams_idLeader` FOREIGN KEY (`idLeader`) REFERENCES `students` (`idStudent`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_teams_idProject` FOREIGN KEY (`idProject`) REFERENCES `projects` (`idProject`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams`
--

LOCK TABLES `teams` WRITE;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
INSERT INTO `teams` VALUES (18,'Perini Petlici',0,2,10),(19,'Sundjer Bob',0,2,9);
/*!40000 ALTER TABLE `teams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `idUser` int NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `forename` varchar(45) NOT NULL,
  `surname` varchar(45) NOT NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `idKorisnik_UNIQUE` (`idUser`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (3,'mika','1111','mika@admin.rs','Mika','Mihajlović'),(6,'aca','123456aA','aca@etf.rs','Aleksandar','Aleksandrović'),(7,'mare123','123456aA','marko@etf.rs','Marko','Marković'),(8,'student','123456aA','pp190123d@student.etf.bg.ac.rs','Petar','Petrović'),(9,'marina','123456aA','mm190223d@student.etf.bg.ac.rs','Marina','Marinković'),(10,'nikola','123456aA','nn170123d@student.etf.bg.ac.rs','Nikola','Nikolić'),(11,'danilo','123456aA','dd120123d@student.etf.bg.ac.rs','Danilo','Danilović'),(12,'andjela','123456aA','aa140123d@student.etf.bg.ac.rs','Andjela','Andjelković'),(13,'johny123','123456aA','johny@etf.rs','John','Jonhson');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-06-06 23:10:50
