-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Dim 30 Octobre 2011 à 03:04
-- Version du serveur: 5.5.16
-- Version de PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `lmdlm`
--

-- --------------------------------------------------------

--
-- Structure de la table `etab`
--

CREATE TABLE IF NOT EXISTS `etab` (
  `type` int(2) NOT NULL,
  `ville` varchar(50) NOT NULL,
  `id` int(4) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=52 ;

--
-- Contenu de la table `etab`
--

INSERT INTO `etab` (`type`, `ville`, `id`) VALUES
(2, 'angouleme', 51);

-- --------------------------------------------------------

--
-- Structure de la table `mots`
--

CREATE TABLE IF NOT EXISTS `mots` (
  `mot` varchar(30) NOT NULL,
  `proposeur` int(5) NOT NULL,
  `date` int(15) NOT NULL,
  `valide` int(1) NOT NULL,
  `id` int(6) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mot` (`mot`),
  KEY `proposeur` (`proposeur`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=50 ;

--
-- Contenu de la table `mots`
--

INSERT INTO `mots` (`mot`, `proposeur`, `date`, `valide`, `id`) VALUES
('monsieur jacky', 40, 1319939572, 1, 49);

-- --------------------------------------------------------

--
-- Structure de la table `mot_du_jour`
--

CREATE TABLE IF NOT EXISTS `mot_du_jour` (
  `id_mot` int(6) NOT NULL,
  `id_user` int(5) NOT NULL,
  `heure` int(15) NOT NULL,
  `jour` int(3) NOT NULL,
  `annee` year(4) NOT NULL,
  `hash` varchar(10) NOT NULL,
  `id_resultat` int(6) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `id_mot` (`id_mot`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Contenu de la table `mot_du_jour`
--

INSERT INTO `mot_du_jour` (`id_mot`, `id_user`, `heure`, `jour`, `annee`, `hash`, `id_resultat`, `id`) VALUES
(49, 40, 1319940002, 302, 2011, '6b22e7c980', 45, 28);

-- --------------------------------------------------------

--
-- Structure de la table `promo`
--

CREATE TABLE IF NOT EXISTS `promo` (
  `nom` varchar(50) NOT NULL,
  `annee` year(4) NOT NULL,
  `etab` int(4) NOT NULL,
  `id` int(5) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `etab` (`etab`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

--
-- Contenu de la table `promo`
--

INSERT INTO `promo` (`nom`, `annee`, `etab`, `id`) VALUES
('deust a la con', 2011, 51, 40);

-- --------------------------------------------------------

--
-- Structure de la table `resultats`
--

CREATE TABLE IF NOT EXISTS `resultats` (
  `heure` int(15) NOT NULL,
  `phrase` text NOT NULL,
  `capture` varchar(25) NOT NULL,
  `valide` int(1) NOT NULL,
  `validateur` int(5) NOT NULL,
  `com` text NOT NULL,
  `id` int(6) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `validateur` (`validateur`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;

--
-- Contenu de la table `resultats`
--

INSERT INTO `resultats` (`heure`, `phrase`, `capture`, `valide`, `validateur`, `com`, `id`) VALUES
(1319940048, 'monsieur jack c&#39;est pas une tapette', 'oqbp9303lz8v4h7.jpg', 1, 40, '', 45);

-- --------------------------------------------------------

--
-- Structure de la table `type_etab`
--

CREATE TABLE IF NOT EXISTS `type_etab` (
  `nom` varchar(60) NOT NULL,
  `id` int(4) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `type_etab`
--

INSERT INTO `type_etab` (`nom`, `id`) VALUES
('faculté', 1),
('centre de trisomiques', 2),
('ecole d''attardés', 3);

-- --------------------------------------------------------

--
-- Structure de la table `unvalidated_user`
--

CREATE TABLE IF NOT EXISTS `unvalidated_user` (
  `user_id` int(5) NOT NULL,
  `hash` varchar(120) NOT NULL,
  `time_limit` int(15) NOT NULL,
  `id` int(4) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user` varchar(40) NOT NULL,
  `password` varchar(120) NOT NULL,
  `mail` varchar(60) NOT NULL,
  `image` varchar(20) NOT NULL,
  `rang` int(1) NOT NULL,
  `first` int(15) NOT NULL COMMENT 'date inscription',
  `last` int(15) NOT NULL COMMENT 'dern visite',
  `etab` int(3) NOT NULL COMMENT 'fac science Limoges',
  `promo` int(4) NOT NULL COMMENT 'deust 2011 ?',
  `id` int(5) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `etab` (`etab`,`promo`),
  KEY `promo` (`promo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`user`, `password`, `mail`, `image`, `rang`, `first`, `last`, `etab`, `promo`, `id`) VALUES
('rudak', '2fea9ed14158ba7e7909d2639f9407e44d125a6a', 'postmaster@kadur-arnaud.fr', '75sqc036o5ap-li.jpg', 5, 1319939433, 1319940079, 51, 40, 40);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `etab`
--
ALTER TABLE `etab`
  ADD CONSTRAINT `etab_ibfk_1` FOREIGN KEY (`type`) REFERENCES `type_etab` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `mots`
--
ALTER TABLE `mots`
  ADD CONSTRAINT `mots_ibfk_1` FOREIGN KEY (`proposeur`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `mot_du_jour`
--
ALTER TABLE `mot_du_jour`
  ADD CONSTRAINT `mot_du_jour_ibfk_1` FOREIGN KEY (`id_mot`) REFERENCES `mots` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mot_du_jour_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `promo`
--
ALTER TABLE `promo`
  ADD CONSTRAINT `promo_ibfk_1` FOREIGN KEY (`etab`) REFERENCES `etab` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `resultats`
--
ALTER TABLE `resultats`
  ADD CONSTRAINT `resultats_ibfk_1` FOREIGN KEY (`validateur`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `unvalidated_user`
--
ALTER TABLE `unvalidated_user`
  ADD CONSTRAINT `unvalidated_user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_3` FOREIGN KEY (`etab`) REFERENCES `etab` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`promo`) REFERENCES `promo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
