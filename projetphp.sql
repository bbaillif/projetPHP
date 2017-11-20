-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Lun 13 Novembre 2017 à 22:58
-- Version du serveur :  10.1.21-MariaDB
-- Version de PHP :  7.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projetphp`
--

-- --------------------------------------------------------

--
-- Structure de la table `creneau`
--

CREATE TABLE `creneau` (
  `ID_creneau` varchar(6) NOT NULL,
  `jour` date NOT NULL,
  `heure` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `creneau`
--

INSERT INTO `creneau` (`ID_creneau`, `jour`, `heure`) VALUES
('LU46M1', '2017-11-13', '08:00:00'),
('LU46M2', '2017-11-13', '08:30:00'),
('LU46M3', '2017-11-13', '09:00:00'),
('LU46M4', '2017-11-13', '09:30:00'),
('LU46M5', '2017-11-13', '10:00:00'),
('LU46M6', '2017-11-13', '10:30:00'),
('LU46M7', '2017-11-13', '11:00:00'),
('LU46M8', '2017-11-13', '11:30:00'),
('LU46M9', '2017-11-13', '12:00:00'),
('LU46A1', '2017-11-13', '13:30:00'),
('LU46A2', '2017-11-13', '14:00:00'),
('LU46A3', '2017-11-13', '14:30:00'),
('LU46A4', '2017-11-13', '15:00:00'),
('LU46A5', '2017-11-13', '15:30:00'),
('LU46A6', '2017-11-13', '16:00:00'),
('LU46A7', '2017-11-13', '16:30:00'),
('LU46A8', '2017-11-13', '17:00:00'),
('LU46A9', '2017-11-13', '17:30:00'),
('MA46M1', '2017-11-14', '08:00:00'),
('MA46M2', '2017-11-14', '08:30:00'),
('MA46M3', '2017-11-14', '09:00:00'),
('MA46M4', '2017-11-14', '09:30:00'),
('MA46M5', '2017-11-14', '10:00:00'),
('MA46M6', '2017-11-14', '10:30:00'),
('MA46M7', '2017-11-14', '11:00:00'),
('MA46M8', '2017-11-14', '11:30:00'),
('MA46M9', '2017-11-14', '12:00:00'),
('MA46A1', '2017-11-14', '13:30:00'),
('MA46A2', '2017-11-14', '14:00:00'),
('MA46A3', '2017-11-14', '14:30:00'),
('MA46A4', '2017-11-14', '15:00:00'),
('MA46A5', '2017-11-14', '15:30:00'),
('MA46A6', '2017-11-14', '16:00:00'),
('MA46A7', '2017-11-14', '16:30:00'),
('MA46A8', '2017-11-14', '17:00:00'),
('MA46A9', '2017-11-14', '17:30:00'),
('ME46M1', '2017-11-15', '08:00:00'),
('ME46M2', '2017-11-15', '08:30:00'),
('ME46M3', '2017-11-15', '09:00:00'),
('ME46M4', '2017-11-15', '09:30:00'),
('ME46M5', '2017-11-15', '10:00:00'),
('ME46M6', '2017-11-15', '10:30:00'),
('ME46M7', '2017-11-15', '11:00:00'),
('ME46M8', '2017-11-15', '11:30:00'),
('ME46M9', '2017-11-15', '12:00:00'),
('ME46A1', '2017-11-15', '13:30:00'),
('ME46A2', '2017-11-15', '14:00:00'),
('ME46A3', '2017-11-15', '14:30:00'),
('ME46A4', '2017-11-15', '15:00:00'),
('ME46A5', '2017-11-15', '15:30:00'),
('ME46A6', '2017-11-15', '16:00:00'),
('ME46A7', '2017-11-15', '16:30:00'),
('ME46A8', '2017-11-15', '17:00:00'),
('ME46A9', '2017-11-15', '17:30:00'),
('JE46M1', '2017-11-16', '08:00:00'),
('JE46M2', '2017-11-16', '08:30:00'),
('JE46M3', '2017-11-16', '09:00:00'),
('JE46M4', '2017-11-16', '09:30:00'),
('JE46M5', '2017-11-16', '10:00:00'),
('JE46M6', '2017-11-16', '10:30:00'),
('JE46M7', '2017-11-16', '11:00:00'),
('JE46M8', '2017-11-16', '11:30:00'),
('JE46M9', '2017-11-16', '12:00:00'),
('JE46A1', '2017-11-16', '13:30:00'),
('JE46A2', '2017-11-16', '14:00:00'),
('JE46A3', '2017-11-16', '14:30:00'),
('JE46A4', '2017-11-16', '15:00:00'),
('JE46A5', '2017-11-16', '15:30:00'),
('JE46A6', '2017-11-16', '16:00:00'),
('JE46A7', '2017-11-16', '16:30:00'),
('JE46A8', '2017-11-16', '17:00:00'),
('JE46A9', '2017-11-16', '17:30:00'),
('VE46M1', '2017-11-17', '08:00:00'),
('VE46M2', '2017-11-17', '08:30:00'),
('VE46M3', '2017-11-17', '09:00:00'),
('VE46M4', '2017-11-17', '09:30:00'),
('VE46M5', '2017-11-17', '10:00:00'),
('VE46M6', '2017-11-17', '10:30:00'),
('VE46M7', '2017-11-17', '11:00:00'),
('VE46M8', '2017-11-17', '11:30:00'),
('VE46M9', '2017-11-17', '12:00:00'),
('VE46A1', '2017-11-17', '13:30:00'),
('VE46A2', '2017-11-17', '14:00:00'),
('VE46A3', '2017-11-17', '14:30:00'),
('VE46A4', '2017-11-17', '15:00:00'),
('VE46A5', '2017-11-17', '15:30:00'),
('VE46A6', '2017-11-17', '16:00:00'),
('VE46A7', '2017-11-17', '16:30:00'),
('VE46A8', '2017-11-17', '17:00:00'),
('VE46A9', '2017-11-17', '17:30:00');

-- --------------------------------------------------------

--
-- Structure de la table `medecin`
--

CREATE TABLE `medecin` (
  `ID_personnel` varchar(6) NOT NULL,
  `ID_service_acc` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `medecin`
--

INSERT INTO `medecin` (`ID_personnel`, `ID_service_acc`) VALUES
('PER005', 'ACC001'),
('PER002', 'ACC002');

-- --------------------------------------------------------

--
-- Structure de la table `pathologie`
--

CREATE TABLE `pathologie` (
  `pathologie` text NOT NULL,
  `NU_defaut` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `pathologie`
--

INSERT INTO `pathologie` (`pathologie`, `NU_defaut`) VALUES
('rhume', 2),
('angine', 3),
('os casse', 6),
('AVC', 8),
('bradycardie', 7),
('calcul', 5),
('appendicite', 7),
('diabete', 4),
('gastroenterite', 3),
('oedeme', 7),
('tumeur', 6);

-- --------------------------------------------------------

--
-- Structure de la table `patient`
--

CREATE TABLE `patient` (
  `num_secu` varchar(15) NOT NULL,
  `pathologie` varchar(30) NOT NULL,
  `NU` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `patient`
--

INSERT INTO `patient` (`num_secu`, `pathologie`, `NU`) VALUES
('269039584447537', 'rhume', 2),
('111023370509701', 'bradycardie', 8),
('195124533749884', 'tumeur', 6),
('160106045434593', 'calcul', 6),
('246045702087545', 'AVC', 8);

-- --------------------------------------------------------

--
-- Structure de la table `personne`
--

CREATE TABLE `personne` (
  `num_secu` varchar(15) NOT NULL,
  `nom` text NOT NULL,
  `prenom` text NOT NULL,
  `sexe` char(1) NOT NULL,
  `date_naiss` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `personne`
--

INSERT INTO `personne` (`num_secu`, `nom`, `prenom`, `sexe`, `date_naiss`) VALUES
('170125410485276', 'Robert', 'Paul', 'H', '1970-01-20'),
('258030602778037', 'Paulet', 'Claire', 'F', '1958-03-04'),
('280098090025040', 'Martin', 'Elisabeth', 'F', '1980-09-25'),
('172019575482625', 'Richard', 'Arnaud', 'H', '1972-01-08'),
('162087831292080', 'Rouleau', 'Jacques', 'H', '1962-08-15'),
('164044940578302', 'Lapointe', 'Vincent', 'H', '1964-04-10'),
('190100148034501', 'Clavet', 'Claude', 'H', '1990-01-30'),
('269039584447537', 'Blanchard', 'Sylvie', 'F', '1969-03-06'),
('111023370509701', 'Nadeau', 'Antoine', 'H', '2011-02-15'),
('195124533749884', 'Lussier', 'Roger', 'H', '1995-12-29'),
('160106045434593', 'Chenard', 'Serge', 'H', '1960-10-10'),
('246045702087545', 'Laux', 'Mireille', 'F', '1946-04-14');

-- --------------------------------------------------------

--
-- Structure de la table `personnel`
--

CREATE TABLE `personnel` (
  `num_secu` varchar(15) NOT NULL,
  `ID_personnel` varchar(6) NOT NULL,
  `MDP` varchar(10) NOT NULL,
  `droit` text NOT NULL,
  `mail` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `personnel`
--

INSERT INTO `personnel` (`num_secu`, `ID_personnel`, `MDP`, `droit`, `mail`) VALUES
('170125410485276', 'PER001', 'mdp1', '2', 'paul.robert@chu.fr'),
('258030602778037', 'PER002', 'mdp2', '1', 'claire.paulet@chu.fr'),
('280098090025040', 'PER003', 'mdp3', '2', 'elisabeth.martin@chu.fr'),
('172019575482625', 'PER004', 'mdp4', '2', 'arnaud.richard@chu.fr'),
('162087831292080', 'PER005', 'mdp5', '1', 'jacques.rouleau@chu.fr'),
('164044940578302', 'PER006', 'mdp6', '2', 'vincent.lapointe@chu.fr'),
('190100148034501', 'PER007', 'mdp7', '0', 'claude.clavet@chu.fr');

-- --------------------------------------------------------

--
-- Structure de la table `planning`
--

CREATE TABLE `planning` (
  `ID_service_int` varchar(6) NOT NULL,
  `ID_creneau` varchar(6) NOT NULL,
  `ID_personnel` varchar(6) NOT NULL,
  `num_secu` varchar(15) NOT NULL,
  `facture` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `planning`
--

INSERT INTO `planning` (`ID_service_int`, `ID_creneau`, `ID_personnel`, `num_secu`, `facture`) VALUES
('INT004', 'LU46M3', 'PER005', '111023370509701', '0'),
('INT004', 'ME46A1', 'PER001', '160106045434593', '0'),
('INT002', 'MA46M4', 'PER005', '246045702087545', '0');

-- --------------------------------------------------------

--
-- Structure de la table `respo_intervention`
--

CREATE TABLE `respo_intervention` (
  `ID_personnel` varchar(6) NOT NULL,
  `ID_service_int` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `respo_intervention`
--

INSERT INTO `respo_intervention` (`ID_personnel`, `ID_service_int`) VALUES
('PER001', 'INT001'),
('PER003', 'INT002'),
('PER004', 'INT003'),
('PER006', 'INT004');

-- --------------------------------------------------------

--
-- Structure de la table `service_accueil`
--

CREATE TABLE `service_accueil` (
  `ID_service_acc` varchar(6) NOT NULL,
  `nom` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `service_accueil`
--

INSERT INTO `service_accueil` (`ID_service_acc`, `nom`) VALUES
('ACC001', 'Generale'),
('ACC002', 'Urgence');

-- --------------------------------------------------------

--
-- Structure de la table `service_intervention`
--

CREATE TABLE `service_intervention` (
  `ID_service_int` varchar(6) NOT NULL,
  `nom` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `service_intervention`
--

INSERT INTO `service_intervention` (`ID_service_int`, `nom`) VALUES
('INT001', 'radiologie'),
('INT002', 'IRM'),
('INT003', 'laboratoire'),
('INT004', 'operation');

-- --------------------------------------------------------

--
-- Structure de la table `surbooking`
--

CREATE TABLE `surbooking` (
  `ID_service_int` varchar(6) NOT NULL,
  `demi_journee` text NOT NULL,
  `jour` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
