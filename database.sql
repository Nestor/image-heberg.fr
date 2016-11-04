/*
 * Copyright 2008-2016 Anael Mobilia
 *
 * This file is part of image-heberg.fr.
 *
 * image-heberg.fr is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * image-heberg.fr is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with image-heberg.fr. If not, see <http://www.gnu.org/licenses/>
 */

--
-- Structure de la table `erreurs`
--

CREATE TABLE IF NOT EXISTS `erreurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_erreur` int(11) NOT NULL,
  `date_erreur` datetime DEFAULT NULL,
  `ip` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

--
-- Structure de la table `hacks`
--

CREATE TABLE IF NOT EXISTS `hacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `count` smallint(6) NOT NULL DEFAULT '0',
  `last_date` datetime DEFAULT NULL,
  `last_ip` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

--
-- Structure de la table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `ip_envoi` text NOT NULL,
  `date_envoi` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `old_name` text NOT NULL,
  `new_name` text NOT NULL,
  `size` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `width` int(11) NOT NULL,
  `last_view` date NOT NULL DEFAULT '0000-00-00',
  `nb_view_v4` int(11) NOT NULL DEFAULT '0',
  `nb_view_v6` int(11) NOT NULL DEFAULT '0',
  `md5` tinytext NOT NULL,
  `bloque` tinyint(1) NOT NULL DEFAULT '0'
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

--
-- Structure de la table `liste_erreurs`
--

CREATE TABLE IF NOT EXISTS `liste_erreurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `type` enum('hack','flood','picture') DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

--
-- Structure de la table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `pk_login` int(11) NOT NULL AUTO_INCREMENT,
  `ip_login` text NOT NULL,
  `date_login` datetime NOT NULL,
  `pk_membres` int(11) NOT NULL,
  PRIMARY KEY (`pk_login`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

--
-- Structure de la table `membres`
--

CREATE TABLE IF NOT EXISTS `membres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` text NOT NULL,
  `login` text NOT NULL,
  `pass` text NOT NULL,
  `date_inscription` date NOT NULL,
  `ip_inscription` text NOT NULL,
  `lvl` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

--
-- Structure de la table `possede`
--

CREATE TABLE IF NOT EXISTS `possede` (
  `image_id` int(11) NOT NULL,
  `pk_membres` int(11) NOT NULL,
  PRIMARY KEY (`image_id`,`pk_membres`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Structure de la table `sondage`
--

CREATE TABLE IF NOT EXISTS `sondage` (
  `index` int(11) NOT NULL AUTO_INCREMENT,
  `actuelSpeed` tinyint(1) DEFAULT NULL,
  `actuelExt` tinyint(1) DEFAULT NULL,
  `actuelDim` tinyint(1) DEFAULT NULL,
  `actuelPoidsweight` tinyint(1) DEFAULT NULL,
  `actuelOptions` tinyint(1) DEFAULT NULL,
  `bmp` tinyint(1) DEFAULT NULL,
  `uploadMultiple` tinyint(1) DEFAULT NULL,
  `resterCo` tinyint(1) DEFAULT NULL,
  `renamePic` tinyint(1) DEFAULT NULL,
  `statsPic` tinyint(1) DEFAULT NULL,
  `thumbsListeImages` tinyint(1) DEFAULT NULL,
  `albums` tinyint(1) DEFAULT NULL,
  `albumShare` tinyint(1) DEFAULT NULL,
  `albumPwd` tinyint(1) DEFAULT NULL,
  `deleteCheckbox` tinyint(1) DEFAULT NULL,
  `divers` text,
  `ip` text NOT NULL,
  `quand` datetime NOT NULL,
  PRIMARY KEY (`index`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

--
-- Structure de la table `thumbnails`
--

CREATE TABLE IF NOT EXISTS `thumbnails` (
  `id` int(11) NOT NULL,
  `size` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `width` int(11) NOT NULL,
  `last_view` date NOT NULL,
  `nb_view_v4` int(11) NOT NULL DEFAULT '0',
  `nb_view_v6` int(11) NOT NULL DEFAULT '0',
  `md5` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Création du compte administrateur
--
INSERT INTO `membres` (`id`, `email`, `login`, `pass`, `date_inscription`, `ip_inscription`, `lvl`) VALUES
(1, 'john.doe@example.com', 'admin', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', DATE(NOW()), '127.0.0.1', 'admin');

--
-- Images 404 & bannie
--
INSERT INTO `images` (`id`, `ip_envoi`, `date_envoi`, `old_name`, `new_name`, `size`, `height`, `width`, `last_view`, `nb_view_v4`, `nb_view_v6`, `md5`, `bloque`) VALUES
(1, '127.0.0.1', '2008-01-01 00:00:00', '_image_404.png', '_image_404.png', 30703, 150, 640, '0000-00-00', 0, 0, '6858ce6ddc171a0fd9640831a5e74dfd', 0),
(2, '127.0.0.1', '2008-01-01 00:00:00', '_image_banned.png', '_image_banned.png', 28713, 150, 640, '0000-00-00', 0, 0, '12c357976276091e7cd42e98debb7fb1', 0);

--
-- Assignation à l'administrateur
--
INSERT INTO `possede` (`image_id`, `pk_membres`) VALUES ('1', '1'), ('2', '1');