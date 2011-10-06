-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Jeu 06 Octobre 2011 à 17:38
-- Version du serveur: 5.5.8
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

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
(3, 'dfsgfdg', 25);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Contenu de la table `mots`
--

INSERT INTO `mots` (`mot`, `proposeur`, `date`, `valide`, `id`) VALUES
('jojo', 8, 123215, 1, 1),
('tonton', 1, 3213215, 1, 2),
('sdfgsdfg', 14, 1317909545, 0, 3),
('flamby', 1, 1317909570, 0, 4),
('alert(&#39;dfghj&#39;);', 1, 1317909641, 0, 6),
('dcgsdfg', 1, 1317911266, 0, 7),
('sdfg', 1, 1317911283, 0, 8),
('dfhgdfhg', 1, 1317911330, 0, 9),
('dsfgdsfg', 1, 1317911475, 0, 10),
('dsfgdsfg', 1, 1317911558, 0, 11),
('une étoile c&#39;est cool !', 1, 1317911614, 0, 12),
('une étoile c&#39;est cool !', 1, 1317911629, 0, 13),
('jambon', 1, 1317912500, 0, 14),
('dfsg', 1, 1317912547, 0, 15),
('saint bernard', 1, 1317914429, 0, 16);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

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
('dfhgdfhg', 2011, 25, 14);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `unvalidated_user`
--

INSERT INTO `unvalidated_user` (`user_id`, `hash`, `time_limit`, `id`) VALUES
(13, 'b7df100885c03102bc6a062f7dee382622159b02', 1317980888, 1),
(14, '1a550b864c419754d017b3b1cc5e1ed272148531', 1317980919, 2);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`user`, `password`, `mail`, `image`, `rang`, `first`, `last`, `etab`, `promo`, `id`) VALUES
('daniel', 'bfb8198b6d56f725b0aca902cfea248d19eab38c', 'daniel@test.com', 'defaut.jpg', 5, 123456, 456789, 1, 1, 1),
('kjh', 'kjh', 'kjh', 'kjh', 0, 23, 32, 1, 1, 2),
('poooo', 'b5c59975d886b98d1a000793c82d61938ee9a828', 'dfhgdfhg@dfgsfdg.fg', 'i34es1pcxk9zy8g.jpg', 0, 1317848187, 1317848187, 14, 3, 3),
('poooo', 'b5c59975d886b98d1a000793c82d61938ee9a828', 'dfhgdfhg@dfgsfdg.fg', 'o0dn7pk5m91gn1a.jpg', 0, 1317848216, 1317848216, 15, 4, 4),
('rudak', '2fea9ed14158ba7e7909d2639f9407e44d125a6a', 'rudak@truc.fr', 'oel5hpnoyn0ws7-.jpg', 0, 1317849127, 1317849127, 17, 6, 6),
('ghdfhgdfhg', 'b151f3e06dabeb6eab48512da3272715c548b844', 'dggfhgdfhg@dfgsfdg.fg', 'unlgu2puly7z-78.jpg', 0, 1317849546, 1317849546, 18, 7, 7),
('moumoul', '85254dda5b007ca4a48c2a9c861a079512a5ee89', 'dfhgdfhg@dfgsfdg.fg', 'l25w-yx52vb0wd4.jpg', 0, 1317849700, 1317849700, 19, 8, 8),
('dfhgdfhg', '0e8074442e600b2f08eb47182388edc7d06633f7', 'dggfhgdfhg@dfgsfdg.fg', 'f5438z9zrun2yrg.jpg', 0, 1317854017, 1317854017, 20, 9, 9),
('sdfsdf', 'ceb65b7d2bedd4dd757de71e99bc7592dee0c4e0', 'dfhgdfhg@dfgsfdg.fg', 'ma6m5zybufovmnx.jpg', 0, 1317854257, 1317854257, 21, 10, 10),
('dfgdfg dfgdfg ', 'c001a36cfc290564cdf6a64bc2a4391bd8206746', 'dggfhgdfhg@dfgsfdg.fg', 'shvalx3i23kyqrl.jpg', 0, 1317892081, 1317892081, 22, 11, 11),
('dfgsdfgf', '89ebf7e66e386b243e9b8536fbcefb87974e988f', 'dfhgdfhg@dfgsfdg.fg', 'bgbg5wpva3c6kh7.jpg', 0, 1317892147, 1317892147, 23, 12, 12),
('dfhgdfhg', '624ad3fd17d493fec7caab6d6ab1be03802b21d9', 'dggfhgdfhg@dfgsfdg.fg', '1q3qnvahk-7b310.jpg', 0, 1317894488, 1317894488, 24, 13, 13),
('dfhgdfhg', '624ad3fd17d493fec7caab6d6ab1be03802b21d9', 'dggfhgdfhg@dfgsfdg.fg', 'zs2ut6ny6xd7ksq.jpg', 0, 1317894518, 1317894518, 25, 14, 14);

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
-- Contraintes pour la table `promo`
--
ALTER TABLE `promo`
  ADD CONSTRAINT `promo_ibfk_1` FOREIGN KEY (`etab`) REFERENCES `etab` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

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
