-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Ven 07 Octobre 2011 à 21:09
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Contenu de la table `etab`
--

INSERT INTO `etab` (`type`, `ville`, `id`) VALUES
(1, 'Limoges', 1),
(1, 'azertyuiop', 2),
(1, 'fgkj', 3),
(1, 'fgkj', 4),
(1, 'fgkj', 5),
(1, 'fgkj', 6),
(1, 'fgkj', 7),
(1, 'fgkj', 8),
(1, 'fgkj', 9),
(1, 'fgkj', 10),
(1, 'fgkj', 11),
(1, 'fgkj', 12),
(1, 'fgkj', 13),
(1, 'fgkj', 14),
(1, 'fgkj', 15),
(1, 'angouleme', 17),
(1, 'dfhg', 18),
(1, 'angouleme', 19),
(1, 'dfhg', 20),
(2, 'dfshgfdhg', 21),
(2, 'dfsgfdg', 22),
(3, 'fffffff', 23),
(3, 'dfsgfdg', 24),
(3, 'dfsgfdg', 25),
(3, 'saint pierre du flanc', 26);

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
  KEY `proposeur` (`proposeur`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Contenu de la table `mots`
--

INSERT INTO `mots` (`mot`, `proposeur`, `date`, `valide`, `id`) VALUES
('tonton', 1, 3213215, 1, 2),
('flamby', 1, 1317909570, 0, 4),
('une étoile c&#39;est cool !', 1, 1317911629, 0, 13),
('jambon', 1, 1317912500, 0, 14),
('dfsg', 1, 1317912547, 0, 15),
('saint bernard', 1, 1317914429, 0, 16),
('pastis', 1, 1317931758, 0, 17),
('caravane', 1, 1317931768, 0, 18),
('troubadour', 1, 1317931774, 0, 19),
('seigneur', 1, 1317931778, 0, 20),
('calamine', 1, 1317931782, 0, 21),
('camembert', 1, 1317977716, 0, 22),
('parking', 1, 1317978495, 0, 23),
('charette', 1, 1317978806, 0, 24),
('camping car', 1, 1317978819, 0, 25),
('maison', 1, 1317979706, 0, 26),
('slip', 6, 1317981758, 0, 27),
('survetement', 6, 1317981765, 0, 28),
('canibal', 6, 1317981770, 0, 29);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `mot_du_jour`
--

INSERT INTO `mot_du_jour` (`id_mot`, `id_user`, `heure`, `jour`, `annee`, `hash`, `id_resultat`, `id`) VALUES
(18, 1, 1317937909, 278, 2011, '900e9b9c51', 0, 2),
(21, 1, 1317938707, 279, 2011, 'dd6aea3d6a', 13, 3),
(22, 6, 1317981737, 279, 2011, '485bb3845c', 17, 4),
(24, 15, 1318008707, 279, 2011, '0395360e75', 16, 8);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Contenu de la table `promo`
--

INSERT INTO `promo` (`nom`, `annee`, `etab`, `id`) VALUES
('stereophonie 1947', 1947, 1, 1),
('fghjfghj', 2011, 13, 2),
('fghjfghj', 2011, 14, 3),
('fghjfghj', 2011, 15, 4),
('deust a la con', 2011, 17, 6),
('deust 211', 2011, 18, 7),
('magnaco', 2011, 19, 8),
('dfhg', 2011, 20, 9),
('dfhgdfhg', 2011, 21, 10),
('dfhgdfhg', 2011, 22, 11),
('deust 211', 2011, 23, 12),
('dfhgdfhg', 2011, 24, 13),
('dfhgdfhg', 2011, 25, 14),
('cardinal en chef', 2011, 26, 15);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Contenu de la table `resultats`
--

INSERT INTO `resultats` (`heure`, `phrase`, `capture`, `valide`, `validateur`, `com`, `id`) VALUES
(1317999691, 'j&#39;ai de la calamine plein le fion', 'bdzvwg6-o6vukeo.jpg', 9, 1, '', 13),
(1318009141, 'voila qui devrait vous calmer\r\nalert(&#39;zertyuio&#39;);', 'pfvkefogp9zn-89.jpg', 9, 6, '', 16),
(1318012798, 'Donec ultrices scelerisque felis, quis vulputate odio blandit et. In semper aliquam varius. Fusce sit amet augue sem, ut viverra urna. Morbi volutpat risus ac lorem tempor ut camembert quam facilisis. Donec in dolor purus. Aenean venenatis tellus leo. Nulla ullamcorper, turpis a vulputate turpis duis.\r\n', 'mdtvmil5ebta8nh.jpg', 0, 6, '', 17);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `unvalidated_user`
--

INSERT INTO `unvalidated_user` (`user_id`, `hash`, `time_limit`, `id`) VALUES
(15, '5032d7e946f39eaf7e3a9f2f29bedf32626b1af2', 1318095057, 3);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`user`, `password`, `mail`, `image`, `rang`, `first`, `last`, `etab`, `promo`, `id`) VALUES
('daniel', 'bfb8198b6d56f725b0aca902cfea248d19eab38c', 'daniel@test.com', 'defaut.jpg', 5, 123456, 1318008612, 1, 1, 1),
('rudak', '2fea9ed14158ba7e7909d2639f9407e44d125a6a', 'rudak@truc.fr', 'oel5hpnoyn0ws7-.jpg', 5, 1317849127, 1318014395, 17, 6, 6),
('seigneur', '9864be216d985da9663add35523a7c659ff17dfc', 'seigneur@free.fr', 'rav6t10ha8up0nk.jpg', 0, 1318008657, 1318009144, 26, 15, 15);

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
  ADD CONSTRAINT `mots_ibfk_1` FOREIGN KEY (`proposeur`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
  ADD CONSTRAINT `promo_ibfk_1` FOREIGN KEY (`etab`) REFERENCES `etab` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `resultats`
--
ALTER TABLE `resultats`
  ADD CONSTRAINT `resultats_ibfk_1` FOREIGN KEY (`validateur`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `unvalidated_user`
--
ALTER TABLE `unvalidated_user`
  ADD CONSTRAINT `unvalidated_user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`etab`) REFERENCES `etab` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`promo`) REFERENCES `promo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
