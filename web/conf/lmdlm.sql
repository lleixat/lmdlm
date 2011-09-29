-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Jeu 29 Septembre 2011 à 09:57
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
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `nom` varchar(40) NOT NULL,
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

INSERT INTO `users` (`nom`, `password`, `mail`, `image`, `first`, `last`, `etab`, `promo`, `id`) VALUES
('daniel', '0000', 'daniel@test.com', 'defaut.jpg', 123456, 456789, 1, 1, 1);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`promo`) REFERENCES `promo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`etab`) REFERENCES `etab` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
