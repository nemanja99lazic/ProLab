-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 23, 2021 at 09:14 PM
-- Server version: 8.0.21
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `prolab_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrators`
--

DROP TABLE IF EXISTS `administrators`;
CREATE TABLE IF NOT EXISTS `administrators` (
  `idAdministrator` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idAdministrator`),
  UNIQUE KEY `idKorisnika_UNIQUE` (`idAdministrator`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `administrators`
--

INSERT INTO `administrators` (`idAdministrator`) VALUES
(3);

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

DROP TABLE IF EXISTS `appointments`;
CREATE TABLE IF NOT EXISTS `appointments` (
  `idAppointment` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `classroom` varchar(45) DEFAULT NULL,
  `capacity` int NOT NULL,
  `location` varchar(80) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `idLabExercise` int NOT NULL,
  PRIMARY KEY (`idAppointment`),
  KEY `FK_appointment_labExercise_idx` (`idLabExercise`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attends`
--

DROP TABLE IF EXISTS `attends`;
CREATE TABLE IF NOT EXISTS `attends` (
  `idStudent` int NOT NULL,
  `idSubject` int NOT NULL,
  PRIMARY KEY (`idStudent`,`idSubject`),
  KEY `FK_pohadja_idpredmeta_idx` (`idSubject`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attends`
--

INSERT INTO `attends` (`idStudent`, `idSubject`) VALUES
(2, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `free_agents`
--

DROP TABLE IF EXISTS `free_agents`;
CREATE TABLE IF NOT EXISTS `free_agents` (
  `idStudent` int NOT NULL,
  `idAppointment` int NOT NULL,
  `idDesiredAppointment` int NOT NULL,
  PRIMARY KEY (`idStudent`,`idAppointment`,`idDesiredAppointment`),
  KEY `FK_freeAgents_hasAppointment_idx` (`idAppointment`),
  KEY `FK_freeAgents_appointments_idx` (`idDesiredAppointment`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `has_appointment`
--

DROP TABLE IF EXISTS `has_appointment`;
CREATE TABLE IF NOT EXISTS `has_appointment` (
  `idAppointment` int NOT NULL,
  `idStudent` int NOT NULL,
  PRIMARY KEY (`idAppointment`,`idStudent`),
  KEY `FK_hasAppointment_students_idx` (`idStudent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lab_exercises`
--

DROP TABLE IF EXISTS `lab_exercises`;
CREATE TABLE IF NOT EXISTS `lab_exercises` (
  `idLabExercise` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `expiration` datetime NOT NULL,
  `idSubject` int NOT NULL,
  PRIMARY KEY (`idLabExercise`),
  KEY `FK_subject_idx` (`idSubject`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `lab_exercises`
--

INSERT INTO `lab_exercises` (`idLabExercise`, `name`, `description`, `expiration`, `idSubject`) VALUES
(1, 'Lab1', 'opis lab vezbe 1', '2021-05-25 20:42:36', 2);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `new_subject_requests`
--

DROP TABLE IF EXISTS `new_subject_requests`;
CREATE TABLE IF NOT EXISTS `new_subject_requests` (
  `idRequest` int NOT NULL AUTO_INCREMENT,
  `subjectName` varchar(45) NOT NULL,
  `idTeacher` int NOT NULL,
  PRIMARY KEY (`idRequest`),
  KEY `FK_zahteviZaNovePredmete_idTeacher_idx` (`idTeacher`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `new_subject_requests_teaches`
--

DROP TABLE IF EXISTS `new_subject_requests_teaches`;
CREATE TABLE IF NOT EXISTS `new_subject_requests_teaches` (
  `idRequest` int NOT NULL,
  `idTeacher` int NOT NULL,
  PRIMARY KEY (`idRequest`,`idTeacher`),
  KEY `FK_idAssociateTeacher_idx` (`idTeacher`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `idProject` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `minMemberNumber` varchar(45) NOT NULL,
  `maxMemberNumber` varchar(45) NOT NULL,
  `expirationDate` date NOT NULL,
  `idSubject` int NOT NULL,
  PRIMARY KEY (`idProject`),
  KEY `FK_project_subject_idx` (`idSubject`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registration_requests`
--

DROP TABLE IF EXISTS `registration_requests`;
CREATE TABLE IF NOT EXISTS `registration_requests` (
  `idRegistrationRequest` int NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `userType` varchar(1) NOT NULL,
  PRIMARY KEY (`idRegistrationRequest`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `registration_requests`
--

INSERT INTO `registration_requests` (`idRegistrationRequest`, `username`, `password`, `email`, `userType`) VALUES
(2, 'zika,zika,zikic', '123', 'zika@todorovic.com', 's');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE IF NOT EXISTS `students` (
  `idStudent` int NOT NULL AUTO_INCREMENT,
  `index` varchar(9) NOT NULL,
  PRIMARY KEY (`idStudent`),
  UNIQUE KEY `idKorisnika_UNIQUE` (`idStudent`),
  UNIQUE KEY `index_UNIQUE` (`index`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`idStudent`, `index`) VALUES
(2, 'zk180257');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
CREATE TABLE IF NOT EXISTS `subjects` (
  `idSubject` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `code` varchar(45) NOT NULL COMMENT 'Sifra predmeta',
  `idTeacher` int NOT NULL,
  PRIMARY KEY (`idSubject`),
  KEY `FK_subjects_idTeacher_idx` (`idTeacher`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`idSubject`, `name`, `code`, `idTeacher`) VALUES
(1, 'ORT', '123', 1),
(2, 'ASP1', '234', 1);

-- --------------------------------------------------------

--
-- Table structure for table `subject_join_requests`
--

DROP TABLE IF EXISTS `subject_join_requests`;
CREATE TABLE IF NOT EXISTS `subject_join_requests` (
  `idRequest` int NOT NULL AUTO_INCREMENT,
  `idSubject` int NOT NULL,
  `idStudent` int NOT NULL,
  PRIMARY KEY (`idRequest`),
  KEY `FK_idSubject_idx` (`idSubject`),
  KEY `FK_idStudent_idx` (`idStudent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Mozda kao primary key da se stavi samo (idSubject, idStudent)?';

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

DROP TABLE IF EXISTS `teachers`;
CREATE TABLE IF NOT EXISTS `teachers` (
  `idTeacher` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idTeacher`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`idTeacher`) VALUES
(1);

-- --------------------------------------------------------

--
-- Table structure for table `teaches`
--

DROP TABLE IF EXISTS `teaches`;
CREATE TABLE IF NOT EXISTS `teaches` (
  `idTeacher` int NOT NULL,
  `idSubject` int NOT NULL,
  PRIMARY KEY (`idTeacher`,`idSubject`),
  KEY `FK_teaches_idSubject_idx` (`idSubject`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
CREATE TABLE IF NOT EXISTS `teams` (
  `idTeam` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `locked` tinyint NOT NULL,
  `idProject` int NOT NULL,
  PRIMARY KEY (`idTeam`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  KEY `gfdgdfg_idx` (`idProject`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

DROP TABLE IF EXISTS `team_members`;
CREATE TABLE IF NOT EXISTS `team_members` (
  `idStudent` int NOT NULL,
  `idTeam` int NOT NULL,
  PRIMARY KEY (`idStudent`,`idTeam`),
  KEY `FK_teams_members_idTeam_idx` (`idTeam`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`idUser`, `username`, `password`, `email`, `forename`, `surname`) VALUES
(1, 'pera', '123', 'pera@detlic.com', 'pera', 'detlic'),
(2, 'zika', '1234', 'zk180257/@student/rs', 'zika', 'zikic'),
(3, 'mika', '234', 'mika@admin.rs', 'mika', 'mikic');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `administrators`
--
ALTER TABLE `administrators`
  ADD CONSTRAINT `FK_administrators_idAdministrator` FOREIGN KEY (`idAdministrator`) REFERENCES `users` (`idUser`) ON UPDATE CASCADE;

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `FK_appointments_idLabExercise` FOREIGN KEY (`idLabExercise`) REFERENCES `lab_exercises` (`idLabExercise`) ON UPDATE CASCADE;

--
-- Constraints for table `attends`
--
ALTER TABLE `attends`
  ADD CONSTRAINT `FK_attends_idStudent` FOREIGN KEY (`idStudent`) REFERENCES `students` (`idStudent`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_attends_idSubject` FOREIGN KEY (`idSubject`) REFERENCES `subjects` (`idSubject`) ON UPDATE CASCADE;

--
-- Constraints for table `free_agents`
--
ALTER TABLE `free_agents`
  ADD CONSTRAINT `FK_freeAgents_idAppointment` FOREIGN KEY (`idAppointment`) REFERENCES `has_appointment` (`idAppointment`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_freeAgents_idDesiredAppointment` FOREIGN KEY (`idDesiredAppointment`) REFERENCES `appointments` (`idAppointment`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_freeAgents_idStudent` FOREIGN KEY (`idStudent`) REFERENCES `has_appointment` (`idStudent`) ON UPDATE CASCADE;

--
-- Constraints for table `has_appointment`
--
ALTER TABLE `has_appointment`
  ADD CONSTRAINT `FK_hasAppointment_appointments` FOREIGN KEY (`idAppointment`) REFERENCES `appointments` (`idAppointment`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_hasAppointment_students` FOREIGN KEY (`idStudent`) REFERENCES `students` (`idStudent`) ON UPDATE CASCADE;

--
-- Constraints for table `lab_exercises`
--
ALTER TABLE `lab_exercises`
  ADD CONSTRAINT `FK_labExercices_idSubject` FOREIGN KEY (`idSubject`) REFERENCES `subjects` (`idSubject`) ON UPDATE CASCADE;

--
-- Constraints for table `new_subject_requests`
--
ALTER TABLE `new_subject_requests`
  ADD CONSTRAINT `FK_newSubjectRequests_idTeacher` FOREIGN KEY (`idTeacher`) REFERENCES `teachers` (`idTeacher`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `new_subject_requests_teaches`
--
ALTER TABLE `new_subject_requests_teaches`
  ADD CONSTRAINT `FK_newSubjectRequestsTeaches_idRequest` FOREIGN KEY (`idRequest`) REFERENCES `new_subject_requests` (`idRequest`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_newSubjectRequestsTeaches_idTeacher` FOREIGN KEY (`idTeacher`) REFERENCES `teachers` (`idTeacher`) ON UPDATE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `FK_project_idSubject` FOREIGN KEY (`idSubject`) REFERENCES `subjects` (`idSubject`) ON UPDATE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `FK_students_idStudent` FOREIGN KEY (`idStudent`) REFERENCES `users` (`idUser`) ON UPDATE CASCADE;

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `FK_subjects_idTeacher` FOREIGN KEY (`idTeacher`) REFERENCES `teachers` (`idTeacher`) ON UPDATE CASCADE;

--
-- Constraints for table `subject_join_requests`
--
ALTER TABLE `subject_join_requests`
  ADD CONSTRAINT `FK_subjectJoinRequests_idStudent` FOREIGN KEY (`idStudent`) REFERENCES `students` (`idStudent`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_subjectJoinRequests_idSubject` FOREIGN KEY (`idSubject`) REFERENCES `subjects` (`idSubject`) ON UPDATE CASCADE;

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `FK_teachers_idTeacher` FOREIGN KEY (`idTeacher`) REFERENCES `users` (`idUser`) ON UPDATE CASCADE;

--
-- Constraints for table `teaches`
--
ALTER TABLE `teaches`
  ADD CONSTRAINT `FK_teaches_idSubject` FOREIGN KEY (`idSubject`) REFERENCES `subjects` (`idSubject`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_teaches_idTeacher` FOREIGN KEY (`idTeacher`) REFERENCES `teachers` (`idTeacher`) ON UPDATE CASCADE;

--
-- Constraints for table `teams`
--
ALTER TABLE `teams`
  ADD CONSTRAINT `fk_teams_idProject` FOREIGN KEY (`idProject`) REFERENCES `projects` (`idProject`) ON UPDATE CASCADE;

--
-- Constraints for table `team_members`
--
ALTER TABLE `team_members`
  ADD CONSTRAINT `FK_teamMembers_idStudent` FOREIGN KEY (`idStudent`) REFERENCES `students` (`idStudent`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_teamMembers_idTeam` FOREIGN KEY (`idTeam`) REFERENCES `teams` (`idTeam`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
