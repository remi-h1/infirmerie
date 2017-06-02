-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 08 Janvier 2016 à 23:53
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `infirmerie15`
--
CREATE DATABASE IF NOT EXISTS `infirmerie15` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `infirmerie15`;

-- --------------------------------------------------------

--
-- Structure de la table `classe`
--

CREATE TABLE IF NOT EXISTS `classe` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `libelleClasse` char(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Contenu de la table `classe`
--

INSERT INTO `classe` (`id`, `libelleClasse`) VALUES
(1, '3è Bleue'),
(2, '3è Rouge'),
(3, '3è Verte'),
(4, '4è Bleue'),
(5, '4è Rouge'),
(6, '4è Verte'),
(7, '5è Bleue'),
(8, '5è Rouge'),
(9, '5è Verte'),
(10, '6è Bleue'),
(11, '6è Rouge'),
(12, '6è Verte');

-- --------------------------------------------------------

--
-- Structure de la table `eleve`
--

CREATE TABLE IF NOT EXISTS `eleve` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `nom` varchar(25) NOT NULL,
  `prenom` varchar(25) NOT NULL,
  `prenom2` varchar(25) NOT NULL,
  `id_classe` int(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_classe` (`id_classe`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Contenu de la table `eleve`
--

INSERT INTO `eleve` (`id`, `nom`, `prenom`, `prenom2`, `id_classe`) VALUES
(1, 'Bertond', 'Amandine', 'Virginie', 11),
(2, 'Chenu', 'Pascal', 'Paul', 11),
(3, 'Vergne', 'Julie', 'Isabelle', 10),
(4, 'Claveau', 'Gérald', 'bertrand', 10),
(5, 'Cleret', 'Hélène', '', 12),
(6, 'Bailli', 'Dimitri', 'Pierre', 12),
(7, 'Bourbon', 'Mathilde', 'isabelle', 8),
(8, 'Chenu', 'François', '', 8),
(9, 'Calis', 'Virginie', '', 7),
(10, 'Poirier', 'Guillaume', '', 7),
(11, 'Cordier', 'Etienne', 'Benoit', 9),
(12, 'Cassin', 'Mathieu', 'Gérard', 9),
(13, 'Baugirard', 'Annie', '', 5),
(14, 'Daubin', 'Jean', '', 5),
(15, 'Langlois', 'Aude', 'Isabelle', 4),
(16, 'Cleret', 'Natalie', '', 4),
(17, 'Bertond', 'Yvan', 'Pierre', 6),
(18, 'Fichot', 'Clément', '', 6),
(19, 'Pichon', 'Arnaud', 'Sébastien', 2),
(20, 'Bourbon', 'Théo', '', 2),
(21, 'Dupond', 'Paul', 'René', 1),
(22, 'Bertier', 'Clotilde', 'Irène', 1),
(23, 'Vertou', 'Maxime', 'Denis', 3),
(24, 'Plisson', 'Sophie', '', 3);

-- --------------------------------------------------------

--
-- Structure de la table `passage`
--

CREATE TABLE IF NOT EXISTS `passage` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `heureDebut` time NOT NULL,
  `heureFin` time NOT NULL,
  `motif` varchar(255) CHARACTER SET utf8 NOT NULL,
  `idEleve` int(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idEleve` (`idEleve`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `passage`
--

INSERT INTO `passage` (`id`, `date`, `heureDebut`, `heureFin`, `motif`, `idEleve`) VALUES
(1, '2016-01-07', '10:20:00', '10:25:00', 'mal de tete', 2),
(2, '2015-12-20', '16:03:00', '16:05:00', 'coupure', 6),
(3, '2016-01-07', '10:26:00', '10:29:00', 'Blessure EPS', 13);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `eleve`
--
ALTER TABLE `eleve`
  ADD CONSTRAINT `eleve_ibfk_1` FOREIGN KEY (`id_classe`) REFERENCES `classe` (`id`);

--
-- Contraintes pour la table `passage`
--
ALTER TABLE `passage`
  ADD CONSTRAINT `passage_ibfk_1` FOREIGN KEY (`idEleve`) REFERENCES `eleve` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
