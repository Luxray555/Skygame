-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 15 avr. 2022 à 22:13
-- Version du serveur : 5.7.36
-- Version de PHP : 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `skygame`
--

-- --------------------------------------------------------

--
-- Structure de la table `access_token`
--

DROP TABLE IF EXISTS `access_token`;
CREATE TABLE IF NOT EXISTS `access_token` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `token` varchar(100) DEFAULT NULL,
  `expireTokenTime` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `access_token`
--

INSERT INTO `access_token` (`id`, `token`, `expireTokenTime`) VALUES
(1, 'jnkb6pdge1238eny5yxt80pyre2iob', '2022-06-12 08:50:38');

-- --------------------------------------------------------

--
-- Structure de la table `amis`
--

DROP TABLE IF EXISTS `amis`;
CREATE TABLE IF NOT EXISTS `amis` (
  `idAmi` int(11) NOT NULL AUTO_INCREMENT,
  `demande` int(1) NOT NULL DEFAULT '0',
  `dateAmi` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idUtilisateur1` int(11) NOT NULL,
  `idUtilisateur2` int(11) NOT NULL,
  PRIMARY KEY (`idAmi`),
  KEY `idUtilisateur2` (`idUtilisateur2`) USING BTREE,
  KEY `idUtilisateur1` (`idUtilisateur1`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `jeux`
--

DROP TABLE IF EXISTS `jeux`;
CREATE TABLE IF NOT EXISTS `jeux` (
  `idJeu` int(11) NOT NULL,
  `nomJeu` varchar(100) NOT NULL,
  `idImageJeu` varchar(50) DEFAULT NULL,
  `noteMoyenne` int(1) DEFAULT NULL,
  `prixJeu` int(5) NOT NULL,
  PRIMARY KEY (`idJeu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `idMessage` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(200) NOT NULL,
  `dateMessage` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `vuMessage` int(1) NOT NULL DEFAULT '0',
  `idUtilisateur1` int(11) NOT NULL,
  `idUtilisateur2` int(11) NOT NULL,
  PRIMARY KEY (`idMessage`),
  KEY `idUtilisateur1` (`idUtilisateur1`) USING BTREE,
  KEY `idUtilisateur2` (`idUtilisateur2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `notes_jeu`
--

DROP TABLE IF EXISTS `notes_jeu`;
CREATE TABLE IF NOT EXISTS `notes_jeu` (
  `idNote` int(11) NOT NULL AUTO_INCREMENT,
  `note` int(11) NOT NULL,
  `dateNote` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idUtilisateur` int(11) NOT NULL,
  `idJeu` int(11) NOT NULL,
  PRIMARY KEY (`idNote`),
  KEY `idUtilisateur` (`idUtilisateur`,`idJeu`),
  KEY `idJeu` (`idJeu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `skycoins`
--

DROP TABLE IF EXISTS `skycoins`;
CREATE TABLE IF NOT EXISTS `skycoins` (
  `idSkycoin` int(11) NOT NULL AUTO_INCREMENT,
  `prixSkycoin` varchar(25) NOT NULL,
  `convertSkycoin` varchar(25) NOT NULL,
  `bonusSkycoin` varchar(25) NOT NULL,
  `totalSkycoin` int(11) NOT NULL,
  PRIMARY KEY (`idSkycoin`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `skycoins`
--

INSERT INTO `skycoins` (`idSkycoin`, `prixSkycoin`, `convertSkycoin`, `bonusSkycoin`, `totalSkycoin`) VALUES
(1, 'Récompense quotidienne', '100 Skycoin', '0', 100),
(2, '5€', '500 Skycoin', '0', 500),
(3, '10€', '1000 Skycoin', '200', 1200),
(4, '20€', '2000 Skycoin', '500', 2500),
(5, '40€', '4000 Skycoin', '1000', 5000),
(6, '60€', '6000 Skycoin', '1500', 7500),
(7, '80€', '8000 Skycoin', '2000', 10000),
(8, '100€', '10000 Skycoin', '3000', 13000);

-- --------------------------------------------------------

--
-- Structure de la table `transactions_jeu`
--

DROP TABLE IF EXISTS `transactions_jeu`;
CREATE TABLE IF NOT EXISTS `transactions_jeu` (
  `idTransactionJeu` int(11) NOT NULL AUTO_INCREMENT,
  `cleJeu` varchar(12) NOT NULL,
  `dateTransaction` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idUtilisateur` int(11) NOT NULL,
  `idJeu` int(11) NOT NULL,
  PRIMARY KEY (`idTransactionJeu`),
  KEY `idJeu` (`idJeu`),
  KEY `idUtilisateur` (`idUtilisateur`,`idJeu`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `transactions_skycoin`
--

DROP TABLE IF EXISTS `transactions_skycoin`;
CREATE TABLE IF NOT EXISTS `transactions_skycoin` (
  `idTransactionSkyCoin` int(11) NOT NULL AUTO_INCREMENT,
  `dateTransaction` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idUtilisateur` int(11) NOT NULL,
  `idSkycoin` int(11) NOT NULL,
  PRIMARY KEY (`idTransactionSkyCoin`),
  KEY `idSkycoin` (`idSkycoin`) USING BTREE,
  KEY `idUtilisateur` (`idUtilisateur`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `idUtilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `civilite` int(1) NOT NULL,
  `nom` varchar(25) NOT NULL,
  `prenom` varchar(25) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(50) NOT NULL,
  `pseudo` varchar(15) NOT NULL,
  `dateCreation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `photo` int(1) DEFAULT NULL,
  `banniere` int(1) NOT NULL DEFAULT '1',
  `description` varchar(5000) DEFAULT NULL,
  `skyCoin` int(11) NOT NULL DEFAULT '100',
  `lastRecompence` timestamp NULL DEFAULT NULL,
  `verifMail` int(1) NOT NULL DEFAULT '0',
  `codeVerifMail` int(4) DEFAULT NULL,
  PRIMARY KEY (`idUtilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `amis`
--
ALTER TABLE `amis`
  ADD CONSTRAINT `amis_ibfk_1` FOREIGN KEY (`idUtilisateur1`) REFERENCES `utilisateurs` (`idUtilisateur`),
  ADD CONSTRAINT `amis_ibfk_2` FOREIGN KEY (`idUtilisateur2`) REFERENCES `utilisateurs` (`idUtilisateur`);

--
-- Contraintes pour la table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`idUtilisateur1`) REFERENCES `utilisateurs` (`idUtilisateur`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`idUtilisateur2`) REFERENCES `utilisateurs` (`idUtilisateur`);

--
-- Contraintes pour la table `notes_jeu`
--
ALTER TABLE `notes_jeu`
  ADD CONSTRAINT `notes_jeu_ibfk_1` FOREIGN KEY (`idJeu`) REFERENCES `jeux` (`idJeu`),
  ADD CONSTRAINT `notes_jeu_ibfk_2` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateurs` (`idUtilisateur`);

--
-- Contraintes pour la table `transactions_jeu`
--
ALTER TABLE `transactions_jeu`
  ADD CONSTRAINT `transactions_jeu_ibfk_1` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateurs` (`idUtilisateur`),
  ADD CONSTRAINT `transactions_jeu_ibfk_2` FOREIGN KEY (`idJeu`) REFERENCES `jeux` (`idJeu`);

--
-- Contraintes pour la table `transactions_skycoin`
--
ALTER TABLE `transactions_skycoin`
  ADD CONSTRAINT `transactions_skycoin_ibfk_1` FOREIGN KEY (`idSkycoin`) REFERENCES `skycoins` (`idSkycoin`),
  ADD CONSTRAINT `transactions_skycoin_ibfk_2` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateurs` (`idUtilisateur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
