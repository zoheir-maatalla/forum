-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 19 avr. 2021 à 00:57
-- Version du serveur :  5.7.31
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `forum`
--

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

DROP TABLE IF EXISTS `administrateur`;
CREATE TABLE IF NOT EXISTS `administrateur` (
  `commentaires` varchar(255) NOT NULL,
  `membre` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_topics` int(11) NOT NULL,
  `date_heure` datetime NOT NULL,
  `titre` varchar(255) NOT NULL,
  `id_utilisateurs` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `id_topics`, `date_heure`, `titre`, `id_utilisateurs`) VALUES
(38, 2, '2021-04-17 04:12:32', 'exercices de poids de corps ', 1),
(39, 2, '2021-04-17 06:31:04', 'Musculation sans protéines ?', 1),
(43, 37, '2021-04-19 03:42:37', 'GDDFGDGDVSDVSDC', 11),
(44, 1, '2021-04-17 04:00:56', 'muscu', 11);

-- --------------------------------------------------------

--
-- Structure de la table `dislikes`
--

DROP TABLE IF EXISTS `dislikes`;
CREATE TABLE IF NOT EXISTS `dislikes` (
  `id` int(11) NOT NULL,
  `id_messages` int(11) NOT NULL,
  `id_utilisateurs` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE IF NOT EXISTS `likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_messages` int(11) NOT NULL,
  `id_utilisateurs` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `likes`
--

INSERT INTO `likes` (`id`, `id_messages`, `id_utilisateurs`) VALUES
(12, 13, 4);

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_categorie` int(11) NOT NULL,
  `id_utilisateurs` int(11) NOT NULL,
  `date_heure` datetime NOT NULL,
  `contenu` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `id_categorie`, `id_utilisateurs`, `date_heure`, `contenu`) VALUES
(13, 40, 1, '2021-04-17 05:34:15', 'Est-ce que la musculation est un sport ?\r\nLa musculation est la base de la pratique du culturisme et de plusieurs sports de force comme l\'haltérophilie. Elle est aussi une préparation physique dans de nombreux sports nécessitant une condition physique solide (notamment pour les sportifs de haut niveau).'),
(17, 44, 10, '2021-04-17 04:38:38', 'Musculation sans protéines ?'),
(18, 44, 10, '2021-04-17 04:38:55', 'Musculation sans protéines ? Cela n’est possible que dans certaines conditions. En effet, les protéines jouent un rôle décisif dans la musculation. La condition essentielle pour prendre du muscle est bien évidemment l’entraînement en force.  Néanmoins, une quantité suffisante de protéines peut permettre d’optimiser l’entraînement. Le besoin en protéines augmente en fonction de l’intensité de l’entraînement et doit être adapté en conséquence. La consommation de protéines est essentielle pour la musculation, dans la mesure où les muscles sont en grande partie constituée de protéines.  Notre conseil : pour garantir la réussite de ton développement musculaire, tu as besoin de conseils personnalisés pour ton entraînement et ta nutrition. Avec notre Body Check gratuit, tu peux facilement calculer ton IMC et recevoir des conseils et des recommandations de nos experts.');

-- --------------------------------------------------------

--
-- Structure de la table `topics`
--

DROP TABLE IF EXISTS `topics`;
CREATE TABLE IF NOT EXISTS `topics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `date_heure` datetime NOT NULL,
  `login` varchar(255) NOT NULL,
  `id_utilisateurs` int(11) NOT NULL,
  `visibilite` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `topics`
--

INSERT INTO `topics` (`id`, `titre`, `date_heure`, `login`, `id_utilisateurs`, `visibilite`) VALUES
(1, 'bonjour', '2021-04-17 04:22:20', 'test', 1, 0),
(2, 'FITNESS', '2021-07-08 04:26:20', 'test', 1, 0),
(34, 'Séance A', '2021-07-09 04:51:51', 'admin', 8, 0),
(42, 'Musculation sans protéines ?', '2021-07-09 11:02:27', 'admin', 8, 0);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `login`, `password`) VALUES
(1, 'zoheir', '$2y$15$E7ti6ejCYqqC8OgZWWLude4lCTriuGzQXKvOnORp5vx6mQHlihf6G'),
(8, 'admin', '$2y$15$aK/z5KxrNr1ki9LMFHgFau4zit0YLmUFDIWa.TbrKQu9AK76jNwty'),
(9, 'mata', '$2y$15$7k6.TPPdT4NTVMt33impJuJ1da/9jeXLhM3AgKUDXAjVQd5jNeb8C'),
(10, 'test', '$2y$15$JignzgQa6Th62O0cFf8Fx.vmEJ1d7w7oeCdjo34dZVZ55jSm9Gfui'),
(11, 'zeler', '$2y$15$5JbGQ29PVSlDBgMY9LaDZeMLdt4icX1CzdqgiSfis0X6jpToyZFzy');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
