-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 06, 2021 at 07:44 PM
-- Server version: 8.0.25-0ubuntu0.20.04.1
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `prolab_database`
--
CREATE DATABASE IF NOT EXISTS `prolab_database` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `prolab_database`;

-- --------------------------------------------------------

--
-- Table structure for table `administrators`
--

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attends`
--

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
(9, 4),
(9, 5),
(9, 6),
(9, 7),
(9, 8),
(9, 9);

-- --------------------------------------------------------

--
-- Table structure for table `free_agents`
--

CREATE TABLE IF NOT EXISTS `free_agents` (
  `idHasAppointment` int NOT NULL,
  `idDesiredAppointment` int NOT NULL,
  PRIMARY KEY (`idHasAppointment`,`idDesiredAppointment`),
  KEY `FK_freeAgents_idAppointment_idx` (`idDesiredAppointment`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `has_appointment`
--

CREATE TABLE IF NOT EXISTS `has_appointment` (
  `idHasAppointment` int NOT NULL AUTO_INCREMENT,
  `idStudent` int NOT NULL,
  `idAppointment` int NOT NULL,
  PRIMARY KEY (`idHasAppointment`),
  KEY `FK_hasAppointment_idStudent_idx` (`idStudent`),
  KEY `FK_hasAppointment_idAppointment_idx` (`idAppointment`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lab_exercises`
--

CREATE TABLE IF NOT EXISTS `lab_exercises` (
  `idLabExercise` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `expiration` datetime NOT NULL,
  `idSubject` int NOT NULL,
  PRIMARY KEY (`idLabExercise`),
  KEY `FK_subject_idx` (`idSubject`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `new_subject_requests`
--

CREATE TABLE IF NOT EXISTS `new_subject_requests` (
  `idRequest` int NOT NULL AUTO_INCREMENT,
  `subjectName` varchar(45) NOT NULL,
  `idTeacher` int NOT NULL,
  PRIMARY KEY (`idRequest`),
  KEY `FK_zahteviZaNovePredmete_idTeacher_idx` (`idTeacher`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `new_subject_requests_teaches`
--

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

CREATE TABLE IF NOT EXISTS `projects` (
  `idProject` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `minMemberNumber` varchar(45) NOT NULL,
  `maxMemberNumber` varchar(45) NOT NULL,
  `expirationDate` date NOT NULL,
  `idSubject` int NOT NULL,
  PRIMARY KEY (`idProject`),
  KEY `FK_project_subject_idx` (`idSubject`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`idProject`, `name`, `minMemberNumber`, `maxMemberNumber`, `expirationDate`, `idSubject`) VALUES
(2, 'Pravljenje crveno crnog stabla', '2', '4', '2021-07-01', 5);

-- --------------------------------------------------------

--
-- Table structure for table `registration_requests`
--

CREATE TABLE IF NOT EXISTS `registration_requests` (
  `idRegistrationRequest` int NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `userType` varchar(1) NOT NULL,
  PRIMARY KEY (`idRegistrationRequest`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `idStudent` int NOT NULL AUTO_INCREMENT,
  `index` varchar(9) NOT NULL,
  PRIMARY KEY (`idStudent`),
  UNIQUE KEY `idKorisnika_UNIQUE` (`idStudent`),
  UNIQUE KEY `index_UNIQUE` (`index`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`idStudent`, `index`) VALUES
(11, '2012/0123'),
(12, '2014/0123'),
(10, '2017/0123'),
(8, '2019/0123'),
(9, '2019/0223');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE IF NOT EXISTS `subjects` (
  `idSubject` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `code` varchar(45) NOT NULL COMMENT 'Sifra predmeta',
  `idTeacher` int NOT NULL,
  PRIMARY KEY (`idSubject`),
  KEY `FK_subjects_idTeacher_idx` (`idTeacher`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`idSubject`, `name`, `code`, `idTeacher`) VALUES
(4, 'Osnovi Racunarske Tehnike 1', 'ORT1', 6),
(5, 'Algoritmi i Strukture Podataka 1', 'ASP1', 6),
(6, 'Algoritmi i Strukture Podataka 2', 'ASP2', 6),
(7, 'Arhitektura Racunara', 'AR', 7),
(8, 'Matematika 1', 'M1', 7),
(9, 'Fizika 1', 'F1', 7);

-- --------------------------------------------------------

--
-- Table structure for table `subject_join_requests`
--

CREATE TABLE IF NOT EXISTS `subject_join_requests` (
  `idRequest` int NOT NULL AUTO_INCREMENT,
  `idSubject` int NOT NULL,
  `idStudent` int NOT NULL,
  PRIMARY KEY (`idRequest`),
  KEY `FK_idSubject_idx` (`idSubject`),
  KEY `FK_idStudent_idx` (`idStudent`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Mozda kao primary key da se stavi samo (idSubject, idStudent)?';

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE IF NOT EXISTS `teachers` (
  `idTeacher` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idTeacher`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`idTeacher`) VALUES
(6),
(7);

-- --------------------------------------------------------

--
-- Table structure for table `teaches`
--

CREATE TABLE IF NOT EXISTS `teaches` (
  `idTeacher` int NOT NULL,
  `idSubject` int NOT NULL,
  PRIMARY KEY (`idTeacher`,`idSubject`),
  KEY `FK_teaches_idSubject_idx` (`idSubject`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `teaches`
--

INSERT INTO `teaches` (`idTeacher`, `idSubject`) VALUES
(6, 4),
(6, 5),
(6, 6),
(7, 6),
(6, 7),
(7, 7),
(6, 8),
(7, 8),
(7, 9);

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE IF NOT EXISTS `teams` (
  `idTeam` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `locked` tinyint NOT NULL,
  `idProject` int NOT NULL,
  `idLeader` int NOT NULL,
  PRIMARY KEY (`idTeam`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  KEY `gfdgdfg_idx` (`idProject`),
  KEY `fk_teams_idLeader_idx` (`idLeader`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`idTeam`, `name`, `locked`, `idProject`, `idLeader`) VALUES
(17, 'marinin tim', 0, 2, 9);

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE IF NOT EXISTS `team_members` (
  `idStudent` int NOT NULL,
  `idTeam` int NOT NULL,
  PRIMARY KEY (`idStudent`,`idTeam`),
  KEY `FK_teams_members_idTeam_idx` (`idTeam`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`idStudent`, `idTeam`) VALUES
(9, 17);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`idUser`, `username`, `password`, `email`, `forename`, `surname`) VALUES
(3, 'mika', '1111', 'mika@admin.rs', 'Mika', 'Mihajlović'),
(6, 'aca', '123456aA', 'aca@etf.rs', 'Aleksandar', 'Aleksandrović'),
(7, 'mare123', '123456aA', 'marko@etf.rs', 'Marko', 'Marković'),
(8, 'student', '123456aA', 'pp190123d@student.etf.bg.ac.rs', 'Petar', 'Petrović'),
(9, 'marina', '123456aA', 'mm190223d@student.etf.bg.ac.rs', 'Marina', 'Marinković'),
(10, 'nikola', '123456aA', 'nn170123d@student.etf.bg.ac.rs', 'Nikola', 'Nikolić'),
(11, 'danilo', '123456aA', 'dd120123d@student.etf.bg.ac.rs', 'Danilo', 'Danilović'),
(12, 'andjela', '123456aA', 'aa140123d@student.etf.bg.ac.rs', 'Andjela', 'Andjelković');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `administrators`
--
ALTER TABLE `administrators`
  ADD CONSTRAINT `FK_administrators_idAdministrator` FOREIGN KEY (`idAdministrator`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `FK_appointments_idLabExercise` FOREIGN KEY (`idLabExercise`) REFERENCES `lab_exercises` (`idLabExercise`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `attends`
--
ALTER TABLE `attends`
  ADD CONSTRAINT `FK_attends_idStudent` FOREIGN KEY (`idStudent`) REFERENCES `students` (`idStudent`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_attends_idSubject` FOREIGN KEY (`idSubject`) REFERENCES `subjects` (`idSubject`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `free_agents`
--
ALTER TABLE `free_agents`
  ADD CONSTRAINT `FK_freeAgents_idAppointment` FOREIGN KEY (`idDesiredAppointment`) REFERENCES `appointments` (`idAppointment`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `has_appointment`
--
ALTER TABLE `has_appointment`
  ADD CONSTRAINT `FK_hasAppointment_idAppointment` FOREIGN KEY (`idAppointment`) REFERENCES `appointments` (`idAppointment`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_hasAppointment_idStudent` FOREIGN KEY (`idStudent`) REFERENCES `students` (`idStudent`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lab_exercises`
--
ALTER TABLE `lab_exercises`
  ADD CONSTRAINT `FK_labExercices_idSubject` FOREIGN KEY (`idSubject`) REFERENCES `subjects` (`idSubject`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `new_subject_requests`
--
ALTER TABLE `new_subject_requests`
  ADD CONSTRAINT `FK_newSubjectRequests_idTeacher` FOREIGN KEY (`idTeacher`) REFERENCES `teachers` (`idTeacher`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `new_subject_requests_teaches`
--
ALTER TABLE `new_subject_requests_teaches`
  ADD CONSTRAINT `FK_newSubjectRequestsTeaches_idRequest` FOREIGN KEY (`idRequest`) REFERENCES `new_subject_requests` (`idRequest`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_newSubjectRequestsTeaches_idTeacher` FOREIGN KEY (`idTeacher`) REFERENCES `teachers` (`idTeacher`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `FK_project_idSubject` FOREIGN KEY (`idSubject`) REFERENCES `subjects` (`idSubject`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `FK_students_idStudent` FOREIGN KEY (`idStudent`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `FK_subjects_idTeacher` FOREIGN KEY (`idTeacher`) REFERENCES `teachers` (`idTeacher`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subject_join_requests`
--
ALTER TABLE `subject_join_requests`
  ADD CONSTRAINT `FK_subjectJoinRequests_idStudent` FOREIGN KEY (`idStudent`) REFERENCES `students` (`idStudent`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_subjectJoinRequests_idSubject` FOREIGN KEY (`idSubject`) REFERENCES `subjects` (`idSubject`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `FK_teachers_idTeacher` FOREIGN KEY (`idTeacher`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `teaches`
--
ALTER TABLE `teaches`
  ADD CONSTRAINT `FK_teaches_idSubject` FOREIGN KEY (`idSubject`) REFERENCES `subjects` (`idSubject`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_teaches_idTeacher` FOREIGN KEY (`idTeacher`) REFERENCES `teachers` (`idTeacher`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `teams`
--
ALTER TABLE `teams`
  ADD CONSTRAINT `fk_teams_idLeader` FOREIGN KEY (`idLeader`) REFERENCES `students` (`idStudent`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_teams_idProject` FOREIGN KEY (`idProject`) REFERENCES `projects` (`idProject`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `team_members`
--
ALTER TABLE `team_members`
  ADD CONSTRAINT `FK_teamMembers_idStudent` FOREIGN KEY (`idStudent`) REFERENCES `students` (`idStudent`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_teamMembers_idTeam` FOREIGN KEY (`idTeam`) REFERENCES `teams` (`idTeam`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
