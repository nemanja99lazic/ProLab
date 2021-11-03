-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Jun 10, 2021 at 02:38 AM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

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
CREATE DATABASE IF NOT EXISTS `prolab_database` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `prolab_database`;

-- --------------------------------------------------------

--
-- Table structure for table `administrators`
--

DROP TABLE IF EXISTS `administrators`;
CREATE TABLE IF NOT EXISTS `administrators` (
  `idAdministrator` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idAdministrator`),
  UNIQUE KEY `idKorisnika_UNIQUE` (`idAdministrator`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `idAppointment` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `classroom` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `capacity` int(11) NOT NULL,
  `location` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `idLabExercise` int(11) NOT NULL,
  PRIMARY KEY (`idAppointment`),
  KEY `FK_appointment_labExercise_idx` (`idLabExercise`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`idAppointment`, `name`, `classroom`, `capacity`, `location`, `datetime`, `idLabExercise`) VALUES
(4, 'Lab1', '70', 70, 'ETF', '2021-07-16 10:00:00', 3),
(5, 'Lab1', '61', 30, 'ETF', '2021-07-16 13:00:00', 3),
(6, 'Lab1', '309', 40, 'ETF', '2021-07-16 16:00:00', 3),
(7, 'Lab2', '65', 1, 'ETF', '2021-07-28 10:00:00', 4),
(8, 'Lab2', '65', 1, 'ETF', '2021-07-28 13:00:00', 4),
(10, 'Lab3', '70', 2, 'ETF', '2021-06-06 22:40:00', 5),
(11, 'Lab4', '70', 1, 'ETF zgrada', '2021-07-01 03:09:00', 6),
(12, 'Lab4', '60', 1, 'ETF zgrada', '2021-07-01 03:09:00', 6),
(13, 'Lab1', '70', 2, 'ETF', '2021-07-10 03:41:00', 7),
(14, 'Lab1', '60', 2, 'ETF', '2021-07-10 03:41:00', 7),
(15, 'Lab2', '70', 2, 'ETF', '2021-07-17 03:42:00', 8),
(16, 'Lab2', '60', 2, 'ETF', '2021-07-17 03:42:00', 8),
(17, 'Lab3', '70', 2, 'ETF', '2021-08-21 03:43:00', 9),
(18, 'Lab3', '25', 2, 'ETF', '2021-08-21 03:43:00', 9);

-- --------------------------------------------------------

--
-- Table structure for table `attends`
--

DROP TABLE IF EXISTS `attends`;
CREATE TABLE IF NOT EXISTS `attends` (
  `idStudent` int(11) NOT NULL,
  `idSubject` int(11) NOT NULL,
  PRIMARY KEY (`idStudent`,`idSubject`),
  KEY `FK_pohadja_idpredmeta_idx` (`idSubject`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attends`
--

INSERT INTO `attends` (`idStudent`, `idSubject`) VALUES
(9, 4),
(8, 5),
(9, 5),
(10, 5),
(9, 6),
(8, 7),
(9, 7),
(10, 7),
(11, 7),
(9, 8),
(9, 9);

-- --------------------------------------------------------

--
-- Table structure for table `free_agents`
--

DROP TABLE IF EXISTS `free_agents`;
CREATE TABLE IF NOT EXISTS `free_agents` (
  `idHasAppointment` int(11) NOT NULL,
  `idDesiredAppointment` int(11) NOT NULL,
  PRIMARY KEY (`idHasAppointment`,`idDesiredAppointment`),
  KEY `FK_freeAgents_idAppointment_idx` (`idDesiredAppointment`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `free_agents`
--

INSERT INTO `free_agents` (`idHasAppointment`, `idDesiredAppointment`) VALUES
(22, 7);

-- --------------------------------------------------------

--
-- Table structure for table `has_appointment`
--

DROP TABLE IF EXISTS `has_appointment`;
CREATE TABLE IF NOT EXISTS `has_appointment` (
  `idHasAppointment` int(11) NOT NULL AUTO_INCREMENT,
  `idStudent` int(11) NOT NULL,
  `idAppointment` int(11) NOT NULL,
  PRIMARY KEY (`idHasAppointment`),
  KEY `FK_hasAppointment_idStudent_idx` (`idStudent`),
  KEY `FK_hasAppointment_idAppointment_idx` (`idAppointment`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `has_appointment`
--

INSERT INTO `has_appointment` (`idHasAppointment`, `idStudent`, `idAppointment`) VALUES
(18, 10, 4),
(19, 8, 5),
(22, 8, 8),
(25, 9, 7),
(27, 11, 6),
(51, 8, 11),
(52, 9, 12),
(54, 8, 13),
(55, 10, 13),
(56, 10, 16),
(62, 9, 16),
(63, 10, 17);

-- --------------------------------------------------------

--
-- Table structure for table `lab_exercises`
--

DROP TABLE IF EXISTS `lab_exercises`;
CREATE TABLE IF NOT EXISTS `lab_exercises` (
  `idLabExercise` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expiration` datetime NOT NULL,
  `idSubject` int(11) NOT NULL,
  PRIMARY KEY (`idLabExercise`),
  KEY `FK_subject_idx` (`idSubject`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lab_exercises`
--

INSERT INTO `lab_exercises` (`idLabExercise`, `name`, `description`, `expiration`, `idSubject`) VALUES
(3, 'Lab1', 'Radićemo vrlo teške zadatke. (ABUS i DBUS)', '2021-07-15 10:00:00', 7),
(4, 'Lab2', 'Opis.', '2021-07-27 10:00:00', 7),
(5, 'Lab3', 'Opis', '2021-06-06 22:38:00', 7),
(6, 'Lab4', 'Popravna lab vezba.', '2021-06-30 03:09:00', 7),
(7, 'Lab1', 'Odbrana domaceg zadatka 1.', '2021-07-10 03:40:00', 5),
(8, 'Lab2', 'DZ2', '2021-07-17 03:42:00', 5),
(9, 'Lab3', 'DZ3', '2021-08-20 03:43:00', 5);

-- --------------------------------------------------------

--
-- Table structure for table `new_subject_requests`
--

DROP TABLE IF EXISTS `new_subject_requests`;
CREATE TABLE IF NOT EXISTS `new_subject_requests` (
  `idRequest` int(11) NOT NULL AUTO_INCREMENT,
  `subjectName` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idTeacher` int(11) NOT NULL,
  PRIMARY KEY (`idRequest`),
  KEY `FK_zahteviZaNovePredmete_idTeacher_idx` (`idTeacher`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `new_subject_requests`
--

INSERT INTO `new_subject_requests` (`idRequest`, `subjectName`, `idTeacher`) VALUES
(8, 'Veb dizajn_VD', 6),
(9, 'Sistemi softver_SS', 6);

-- --------------------------------------------------------

--
-- Table structure for table `new_subject_requests_teaches`
--

DROP TABLE IF EXISTS `new_subject_requests_teaches`;
CREATE TABLE IF NOT EXISTS `new_subject_requests_teaches` (
  `idRequest` int(11) NOT NULL,
  `idTeacher` int(11) NOT NULL,
  PRIMARY KEY (`idRequest`,`idTeacher`),
  KEY `FK_idAssociateTeacher_idx` (`idTeacher`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `new_subject_requests_teaches`
--

INSERT INTO `new_subject_requests_teaches` (`idRequest`, `idTeacher`) VALUES
(8, 6),
(9, 6),
(8, 7),
(9, 7),
(9, 13);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `idProject` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `minMemberNumber` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `maxMemberNumber` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expirationDate` date NOT NULL,
  `idSubject` int(11) NOT NULL,
  PRIMARY KEY (`idProject`),
  KEY `FK_project_subject_idx` (`idSubject`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`idProject`, `name`, `minMemberNumber`, `maxMemberNumber`, `expirationDate`, `idSubject`) VALUES
(2, 'Pravljenje crveno crnog stabla', '2', '4', '2021-07-01', 5);

-- --------------------------------------------------------

--
-- Table structure for table `registration_requests`
--

DROP TABLE IF EXISTS `registration_requests`;
CREATE TABLE IF NOT EXISTS `registration_requests` (
  `idRegistrationRequest` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userType` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`idRegistrationRequest`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `registration_requests`
--

INSERT INTO `registration_requests` (`idRegistrationRequest`, `username`, `password`, `email`, `userType`) VALUES
(11, 'david,David,Villa', '123456aA', 'vd181234d@student.etf.bg.ac.rs', 's'),
(12, 'emma,Emma,Watson', '123456aA', 'emma@admin.etf.rs', 'a'),
(13, 'samuel,Samuel,Beckett', '123456aA', 'bs184321d@student.etf.bg.ac.rs', 's'),
(14, 'maria,Maria,Montesorri', '123456aA', 'mm181111d@student.etf.bg.ac.rs', 's'),
(15, 'jokara,Nikola,Jokić', '123456aA', 'dzoni@etf.rs', 't');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE IF NOT EXISTS `students` (
  `idStudent` int(11) NOT NULL AUTO_INCREMENT,
  `index` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`idStudent`),
  UNIQUE KEY `idKorisnika_UNIQUE` (`idStudent`),
  UNIQUE KEY `index_UNIQUE` (`index`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

DROP TABLE IF EXISTS `subjects`;
CREATE TABLE IF NOT EXISTS `subjects` (
  `idSubject` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Sifra predmeta',
  `idTeacher` int(11) NOT NULL,
  PRIMARY KEY (`idSubject`),
  KEY `FK_subjects_idTeacher_idx` (`idTeacher`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`idSubject`, `name`, `code`, `idTeacher`) VALUES
(4, 'Osnovi Racunarske Tehnike 1', 'ORT1', 6),
(5, 'Algoritmi i Strukture Podataka 1', 'ASP1', 6),
(6, 'Algoritmi i Strukture Podataka 2', 'ASP2', 6),
(7, 'Arhitektura Racunara', 'AR', 7),
(8, 'Matematika 1', 'M1', 7),
(9, 'Fizika 1', 'F1', 7),
(10, 'Upravljanje u realnom vremenu', 'URV', 6);

-- --------------------------------------------------------

--
-- Table structure for table `subject_join_requests`
--

DROP TABLE IF EXISTS `subject_join_requests`;
CREATE TABLE IF NOT EXISTS `subject_join_requests` (
  `idRequest` int(11) NOT NULL AUTO_INCREMENT,
  `idSubject` int(11) NOT NULL,
  `idStudent` int(11) NOT NULL,
  PRIMARY KEY (`idRequest`),
  KEY `FK_idSubject_idx` (`idSubject`),
  KEY `FK_idStudent_idx` (`idStudent`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Mozda kao primary key da se stavi samo (idSubject, idStudent)?';

--
-- Dumping data for table `subject_join_requests`
--

INSERT INTO `subject_join_requests` (`idRequest`, `idSubject`, `idStudent`) VALUES
(14, 10, 9),
(15, 9, 10),
(16, 8, 10),
(17, 10, 10);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

DROP TABLE IF EXISTS `teachers`;
CREATE TABLE IF NOT EXISTS `teachers` (
  `idTeacher` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idTeacher`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`idTeacher`) VALUES
(6),
(7),
(13);

-- --------------------------------------------------------

--
-- Table structure for table `teaches`
--

DROP TABLE IF EXISTS `teaches`;
CREATE TABLE IF NOT EXISTS `teaches` (
  `idTeacher` int(11) NOT NULL,
  `idSubject` int(11) NOT NULL,
  PRIMARY KEY (`idTeacher`,`idSubject`),
  KEY `FK_teaches_idSubject_idx` (`idSubject`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(7, 9),
(6, 10);

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
CREATE TABLE IF NOT EXISTS `teams` (
  `idTeam` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locked` tinyint(4) NOT NULL,
  `idProject` int(11) NOT NULL,
  `idLeader` int(11) NOT NULL,
  PRIMARY KEY (`idTeam`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  KEY `gfdgdfg_idx` (`idProject`),
  KEY `fk_teams_idLeader_idx` (`idLeader`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`idTeam`, `name`, `locked`, `idProject`, `idLeader`) VALUES
(18, 'Perini Petlici', 0, 2, 10),
(19, 'Sundjer Bob', 0, 2, 9);

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

DROP TABLE IF EXISTS `team_members`;
CREATE TABLE IF NOT EXISTS `team_members` (
  `idStudent` int(11) NOT NULL,
  `idTeam` int(11) NOT NULL,
  PRIMARY KEY (`idStudent`,`idTeam`),
  KEY `FK_teams_members_idTeam_idx` (`idTeam`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`idStudent`, `idTeam`) VALUES
(10, 18),
(9, 19);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `forename` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `idKorisnik_UNIQUE` (`idUser`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(12, 'andjela', '123456aA', 'aa140123d@student.etf.bg.ac.rs', 'Andjela', 'Andjelković'),
(13, 'johny123', '123456aA', 'johny@etf.rs', 'John', 'Jonhson');

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
