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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appointments`
--

LOCK TABLES `appointments` WRITE;
/*!40000 ALTER TABLE `appointments` DISABLE KEYS */;
INSERT INTO `appointments` VALUES (1,'Termin 1','Sala 65',2,'ETF','2021-05-24 15:00:00',1),(2,'Termin 2','Sala 56',100,'ETF','2021-05-24 18:00:00',1),(3,'asd','123',123,'123','2021-05-29 16:09:49',1);
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
INSERT INTO `attends` VALUES (4,1);
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `has_appointment`
--

LOCK TABLES `has_appointment` WRITE;
/*!40000 ALTER TABLE `has_appointment` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lab_exercises`
--

LOCK TABLES `lab_exercises` WRITE;
/*!40000 ALTER TABLE `lab_exercises` DISABLE KEYS */;
INSERT INTO `lab_exercises` VALUES (1,'Lab1','opis lab vezbe 1','2021-05-25 20:42:36',2),(2,'Lab2','opis vezbe lab 2','2021-05-22 23:58:17',2);
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `new_subject_requests`
--

LOCK TABLES `new_subject_requests` WRITE;
/*!40000 ALTER TABLE `new_subject_requests` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (1,'asd','2','4','2021-05-31',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registration_requests`
--

LOCK TABLES `registration_requests` WRITE;
/*!40000 ALTER TABLE `registration_requests` DISABLE KEYS */;
INSERT INTO `registration_requests` VALUES (2,'zika,zika,zikic','123','zika@todorovic.com','s');
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (5,'2018/0251'),(4,'2018/0255'),(2,'zk180257');
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Mozda kao primary key da se stavi samo (idSubject, idStudent)?';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subject_join_requests`
--

LOCK TABLES `subject_join_requests` WRITE;
/*!40000 ALTER TABLE `subject_join_requests` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subjects`
--

LOCK TABLES `subjects` WRITE;
/*!40000 ALTER TABLE `subjects` DISABLE KEYS */;
INSERT INTO `subjects` VALUES (1,'ORT','123',1),(2,'ASP1','234',1),(3,'KDP','345',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teachers`
--

LOCK TABLES `teachers` WRITE;
/*!40000 ALTER TABLE `teachers` DISABLE KEYS */;
INSERT INTO `teachers` VALUES (1);
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
INSERT INTO `teaches` VALUES (1,1);
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
  PRIMARY KEY (`idTeam`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  KEY `gfdgdfg_idx` (`idProject`),
  CONSTRAINT `fk_teams_idProject` FOREIGN KEY (`idProject`) REFERENCES `projects` (`idProject`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams`
--

LOCK TABLES `teams` WRITE;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'pera','123','pera@detlic.com','pera','detlic'),(2,'zika','1234','zk180257/@student/rs','zika','zikic'),(3,'mika','234','mika@admin.rs','mika','mikic'),(4,'laza','345','laza@student.etf.rs','laza','lazic'),(5,'velja','321','velja@student.rs','velja','veljkovic');
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

-- Dump completed on 2021-05-28 21:58:41
