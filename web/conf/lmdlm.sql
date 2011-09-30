-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Ven 30 Septembre 2011 à 13:46
-- Version du serveur: 5.5.8
-- Version de PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `etab`
--

INSERT INTO `etab` (`type`, `ville`, `id`) VALUES
(1, 'Limoges', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `promo`
--

INSERT INTO `promo` (`nom`, `annee`, `etab`, `id`) VALUES
('stereophonie 1947', 1947, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `type_etab`
--

CREATE TABLE IF NOT EXISTS `type_etab` (
  `nom` varchar(60) NOT NULL,
  `id` int(4) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `type_etab`
--

INSERT INTO `type_etab` (`nom`, `id`) VALUES
('faculté', 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user` varchar(40) NOT NULL,
  `password` varchar(120) NOT NULL,
  `mail` varchar(60) NOT NULL,
  `image` varchar(20) NOT NULL,
  `first` int(15) NOT NULL COMMENT 'date inscription',
  `last` int(15) NOT NULL COMMENT 'dern visite',
  `etab` int(3) NOT NULL COMMENT 'fac science Limoges',
  `promo` int(4) NOT NULL COMMENT 'deust 2011 ?',
  `id` int(5) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `etab` (`etab`,`promo`),
  KEY `promo` (`promo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`user`, `password`, `mail`, `image`, `first`, `last`, `etab`, `promo`, `id`) VALUES
('daniel', 'bfb8198b6d56f725b0aca902cfea248d19eab38c', 'daniel@test.com', 'defaut.jpg', 123456, 456789, 1, 1, 1);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `etab`
--
ALTER TABLE `etab`
  ADD CONSTRAINT `etab_ibfk_1` FOREIGN KEY (`type`) REFERENCES `type_etab` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `promo`
--
ALTER TABLE `promo`
  ADD CONSTRAINT `promo_ibfk_1` FOREIGN KEY (`etab`) REFERENCES `etab` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`etab`) REFERENCES `etab` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`promo`) REFERENCES `promo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
