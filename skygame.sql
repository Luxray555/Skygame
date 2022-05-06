-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 06 mai 2022 à 16:38
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
(1, 'bcdwvo41ir5lyg7bc89lxrmwda2ucu', '2022-07-05 04:30:50');

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `amis`
--

INSERT INTO `amis` (`idAmi`, `demande`, `dateAmi`, `idUtilisateur1`, `idUtilisateur2`) VALUES
(2, 1, '2022-05-06 13:32:06', 1, 3),
(3, 0, '2022-05-06 13:33:55', 2, 1),
(4, 0, '2022-05-06 13:34:14', 1, 4),
(5, 1, '2022-05-06 14:05:34', 1, 5);

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

--
-- Déchargement des données de la table `jeux`
--

INSERT INTO `jeux` (`idJeu`, `nomJeu`, `idImageJeu`, `noteMoyenne`, `prixJeu`) VALUES
(163826, 'Blake: The Visual Novel', 'co3mcj', NULL, 1000),
(186597, 'Strange Horticulture', 'co4bsb', NULL, 2300),
(194737, 'Demeo: PC Edition', 'co4kxh', NULL, 1300);

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`idMessage`, `message`, `dateMessage`, `vuMessage`, `idUtilisateur1`, `idUtilisateur2`) VALUES
(1, 'Test message', '2022-05-06 11:32:31', 1, 3, 1),
(2, 'Reçu...', '2022-05-06 11:33:04', 1, 1, 3);

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `transactions_skycoin`
--

INSERT INTO `transactions_skycoin` (`idTransactionSkyCoin`, `dateTransaction`, `idUtilisateur`, `idSkycoin`) VALUES
(1, '2022-05-06 11:34:24', 1, 8);

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`idUtilisateur`, `civilite`, `nom`, `prenom`, `email`, `password`, `pseudo`, `dateCreation`, `photo`, `banniere`, `description`, `skyCoin`, `lastRecompence`, `verifMail`, `codeVerifMail`) VALUES
(1, 0, 'Dieumegard', 'Bilal', 'bilal.dieumegard@gmail.com', 'f8c1d87006fbf7e5cc4b026c3138bc046883dc71', 'Luxray555', '2022-05-06 11:03:46', 1, 2, 'Moi c\'est Bilal.', 13100, NULL, 1, 7704),
(2, 0, 'Assarar', 'Ayoub', 'ayoub.assarar@gmail.com', 'f8c1d87006fbf7e5cc4b026c3138bc046883dc71', 'Spyro37', '2022-05-06 11:06:00', 3, 1, 'Moi c\'est Ayoub.', 100, NULL, 1, 5220),
(3, 0, 'Aabbi', 'Nassim', 'nassim.aabbi@gmail.com', 'f8c1d87006fbf7e5cc4b026c3138bc046883dc71', 'Slayer37', '2022-05-06 11:07:02', 1, 1, 'Moi c\'est Nassim.', 100, NULL, 1, 663),
(4, 0, 'Bouarfa', 'Yanis', 'yanis.bouarfa@gmail.com', 'f8c1d87006fbf7e5cc4b026c3138bc046883dc71', 'Yanax', '2022-05-06 11:07:57', 2, 3, 'Moi c\'est Yanis.', 100, NULL, 1, 5242),
(5, 0, 'Quintin', 'Eliot', 'eliot.quintin@gmail.com', 'f8c1d87006fbf7e5cc4b026c3138bc046883dc71', 'Caelus', '2022-05-06 11:10:52', 4, 2, 'Moi c\'est Eliot.', 100, NULL, 1, 8137);

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
