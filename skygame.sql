-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 15 avr. 2022 à 11:07
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
(1, '1r02njk7c3hw1oxmd0ob0n6oj6k1c0', '2022-05-27 18:05:36');

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `amis`
--

INSERT INTO `amis` (`idAmi`, `demande`, `dateAmi`, `idUtilisateur1`, `idUtilisateur2`) VALUES
(2, 1, '2022-04-12 01:19:14', 22, 23),
(3, 1, '2022-04-12 15:31:18', 22, 40),
(4, 1, '2022-04-12 16:12:12', 22, 37),
(5, 1, '2022-04-13 00:42:11', 39, 22),
(7, 0, '2022-04-15 13:05:17', 22, 38);

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
(121, 'Minecraft', 'co49x5', 4, 2600),
(1905, 'Fortnite', 'co2ekt', 5, 800),
(11198, 'Rocket League', 'co4cfe', NULL, 5900),
(45131, 'Grand Theft Auto V: Special Edition', 'co2nbc', NULL, 6200),
(98077, 'Grand Theft Auto V: Premium Online Edition', 'co1twh', NULL, 1800),
(163631, 'Slime Rancher: Plortable Edition', 'co3jlo', NULL, 1100),
(163826, 'Blake: The Visual Novel', 'co3mcj', NULL, 7000),
(165192, 'The Elder Scrolls V: Skyrim Anniversary Edition', 'co3lyu', 4, 1900),
(182125, 'Far Cry 6: Insanity', 'co48um', NULL, 2700),
(186234, 'Grand Mountain Adventure: Wonderlands', 'co4it8', NULL, 2600),
(186597, 'Strange Horticulture', 'co4bsb', 4, 600),
(188661, 'MLB The Show 22', 'co4fcv', NULL, 400),
(191404, 'Chrono Cross: The Radical Dreamers Edition', 'co4hbr', NULL, 600),
(194737, 'Demeo: PC Edition', 'co4kxh', NULL, 5800);

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `idMessage` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(200) NOT NULL,
  `dateMessage` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idUtilisateur1` int(11) NOT NULL,
  `idUtilisateur2` int(11) NOT NULL,
  PRIMARY KEY (`idMessage`),
  KEY `idUtilisateur1` (`idUtilisateur1`) USING BTREE,
  KEY `idUtilisateur2` (`idUtilisateur2`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`idMessage`, `message`, `dateMessage`, `idUtilisateur1`, `idUtilisateur2`) VALUES
(1, 'zaefdzefeizuefz\r\ngegergergf', '2022-04-11 22:54:13', 22, 40),
(2, 'ujqydsgfvujzsqfczesfgezrd', '2022-04-11 22:55:33', 40, 22),
(3, 'ergrefgretfdghzrshg', '2022-04-12 12:36:37', 22, 40),
(4, 'T\'es serieux là vient bagarre ????', '2022-04-12 12:37:12', 22, 40),
(5, 'Ok', '2022-04-12 12:37:50', 22, 40),
(6, 'Ok', '2022-04-12 12:38:31', 40, 22),
(7, 'oiszqhydfikuzefezf', '2022-04-12 12:41:58', 22, 40),
(8, 'Ton site pue la merde ', '2022-04-12 12:42:52', 40, 22),
(9, 'dzfdytzefdzedfzefredgv', '2022-04-12 13:01:13', 22, 40),
(10, 'dszfhdsqzgfjhzearf\r\nfegsfedgh\r\ndfgqshdqs', '2022-04-12 13:01:27', 22, 23),
(11, 'ergfrfedgezg', '2022-04-12 13:03:54', 22, 23),
(12, 'gfhsbsgfhfsrh', '2022-04-12 13:04:20', 22, 23),
(13, 'dseqgdfqs', '2022-04-12 13:04:25', 22, 23),
(14, 'efgfrergrfgthygtr', '2022-04-12 13:04:30', 22, 40),
(15, 'Hdbdvdhdbd', '2022-04-12 13:05:47', 40, 22),
(16, 'ertygtedhygtrhg\r\n', '2022-04-12 13:06:07', 22, 40),
(17, 'Jdbdvdhbd', '2022-04-12 13:06:43', 40, 22),
(18, 'ok fdp qaikdsgbsaqjhkd\r\neszfgsrdeg', '2022-04-12 13:25:39', 22, 40),
(19, 'htfdhytfdchgdygdegtrd\r\noe', '2022-04-12 13:26:09', 22, 40),
(20, 'hgbjhyuygtkuytuyijgtuikl\r\niutguytkg\r\niuytgujytguiytiu', '2022-04-12 13:26:58', 22, 40),
(21, 'hrtgyrtfhgtrfhdfsrh', '2022-04-12 13:43:35', 22, 23),
(22, 'dfghdgfhfgdhfdgh', '2022-04-12 13:55:34', 22, 40),
(23, 'dfbhgdgfhdfgh', '2022-04-12 13:56:49', 22, 40),
(24, 'zefrdedzsfezdsf', '2022-04-12 14:12:57', 22, 37),
(25, 'sfvsdfs', '2022-04-12 14:13:01', 22, 37),
(26, 'Luhjdsbjdvdbd', '2022-04-12 14:20:19', 40, 22),
(27, 'dfskijuhgiksugfdsg', '2022-04-12 16:07:16', 22, 40),
(28, 'zrfezsfgrzsfg\r\n', '2022-04-12 22:43:51', 39, 22),
(29, 'fyhufyhjf', '2022-04-12 22:44:27', 39, 22),
(30, 'wdxcwxcwxc', '2022-04-12 23:06:25', 39, 22),
(31, 'Jsvdvhd', '2022-04-12 23:07:22', 22, 39),
(32, 'Jsvsvdh', '2022-04-12 23:07:31', 22, 39),
(33, 'Prout\r\n', '2022-04-12 23:14:01', 22, 39),
(34, 'sjgfdvguysqgfqsd\r\n', '2022-04-12 23:14:06', 39, 22),
(35, 'Hihihiha\r\n', '2022-04-12 23:14:16', 22, 39),
(36, 'sgsedhg\r\nhsdgf\r\nhsdh', '2022-04-13 13:15:59', 22, 39),
(37, 'kusgfukizsrfg\r\nfhsfh', '2022-04-13 14:23:03', 39, 22),
(38, 'Le caca', '2022-04-13 14:23:04', 22, 39),
(39, 'Le gros caca', '2022-04-13 14:23:21', 22, 39),
(40, 'edrghdfghdf', '2022-04-13 14:23:26', 39, 22),
(41, 'La grooosssse meeeerrrde', '2022-04-13 14:23:36', 22, 39),
(42, 'Bwhdvdvbdhjfjfb\r\nFjdhdhd', '2022-04-13 21:05:22', 22, 39),
(43, 'Jdvdhdh', '2022-04-13 21:06:05', 22, 23);

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `notes_jeu`
--

INSERT INTO `notes_jeu` (`idNote`, `note`, `dateNote`, `idUtilisateur`, `idJeu`) VALUES
(7, 4, '2022-03-28 17:04:19', 22, 186597),
(8, 5, '2022-03-28 18:17:04', 22, 1905),
(9, 4, '2022-04-05 14:21:46', 22, 121),
(10, 4, '2022-04-13 21:07:48', 39, 165192);

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `transactions_jeu`
--

INSERT INTO `transactions_jeu` (`idTransactionJeu`, `cleJeu`, `dateTransaction`, `idUtilisateur`, `idJeu`) VALUES
(3, 'CUG3E86LXJJ0', '2022-03-28 17:12:19', 22, 182125),
(4, 'ATZ22RU8ONQK', '2022-03-28 18:16:53', 22, 1905),
(5, '0PK3NRLMUG7U', '2022-04-10 22:49:27', 22, 186597),
(6, 'BDLQSHNFSRA8', '2022-04-13 21:11:39', 22, 121);

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
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `transactions_skycoin`
--

INSERT INTO `transactions_skycoin` (`idTransactionSkyCoin`, `dateTransaction`, `idUtilisateur`, `idSkycoin`) VALUES
(17, '2022-03-28 17:04:56', 22, 1),
(18, '2022-03-28 17:05:06', 22, 8),
(19, '2022-03-28 17:10:55', 22, 8),
(20, '2022-03-28 18:16:26', 22, 8),
(21, '2022-03-28 19:25:13', 22, 8),
(22, '2022-03-28 19:25:14', 22, 8),
(23, '2022-03-28 19:25:14', 22, 8),
(24, '2022-03-28 19:25:15', 22, 8),
(25, '2022-03-31 16:29:23', 22, 8),
(26, '2022-03-31 20:17:53', 22, 1),
(27, '2022-04-01 15:49:43', 22, 1),
(28, '2022-04-03 19:58:14', 22, 8),
(29, '2022-04-03 19:58:15', 22, 8),
(30, '2022-04-03 19:58:17', 22, 8),
(31, '2022-04-03 19:58:18', 22, 8),
(32, '2022-04-03 19:58:19', 22, 8),
(33, '2022-04-03 19:58:22', 22, 8),
(34, '2022-04-03 19:58:23', 22, 8),
(35, '2022-04-03 19:58:24', 22, 8),
(36, '2022-04-03 19:58:25', 22, 8),
(37, '2022-04-03 19:58:26', 22, 8),
(38, '2022-04-03 19:58:27', 22, 8),
(39, '2022-04-04 16:26:02', 22, 1),
(40, '2022-04-04 16:29:43', 22, 8),
(41, '2022-04-05 14:14:11', 22, 8),
(42, '2022-04-05 14:14:15', 22, 8),
(43, '2022-04-05 15:02:32', 37, 1),
(44, '2022-04-06 17:06:17', 22, 1),
(45, '2022-04-06 17:06:26', 22, 8),
(46, '2022-04-07 21:57:48', 22, 1),
(47, '2022-04-08 21:00:46', 40, 1),
(48, '2022-04-09 18:26:03', 22, 1),
(49, '2022-04-09 18:26:08', 22, 8),
(50, '2022-04-10 17:27:21', 22, 1),
(51, '2022-04-11 09:16:35', 22, 1),
(52, '2022-04-11 09:16:44', 22, 8),
(53, '2022-04-13 21:08:17', 39, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`idUtilisateur`, `civilite`, `nom`, `prenom`, `email`, `password`, `pseudo`, `dateCreation`, `photo`, `banniere`, `description`, `skyCoin`, `lastRecompence`, `verifMail`, `codeVerifMail`) VALUES
(22, 0, 'Dieumegard', 'Bilal', 'bilal.dieumegard@gmail.com', 'f8c1d87006fbf7e5cc4b026c3138bc046883dc71', 'Luxray555', '2022-03-28 17:03:19', 1, 2, '', 308800, '2022-04-11 09:16:35', 1, 2466),
(23, 0, 'dujyzfguyj', 'dyagzujyfhd', 'dakew60144@jo6s.com', 'f8c1d87006fbf7e5cc4b026c3138bc046883dc71', 'dszujagfdujhy', '2022-03-28 18:19:27', 1, 3, NULL, 100, NULL, 1, 181),
(37, 0, 'gvedfsgvedgvefds', 'egved', 'weporix683@royins.com', 'f8c1d87006fbf7e5cc4b026c3138bc046883dc71', 'edgvedsgvf', '2022-04-05 15:01:43', NULL, 1, NULL, 200, '2022-04-05 15:02:32', 1, 9386),
(38, 1, 'szdfgvsedqgedsg', 'rshrsdgh', 'derthrt@rzhrt.com', 'f8c1d87006fbf7e5cc4b026c3138bc046883dc71', 'hrdsehredsh', '2022-04-08 20:39:46', NULL, 1, NULL, 100, NULL, 0, 9561),
(39, 0, 'dfsqgsqg', 'deqsgdqesgf', 'gsedqgszqedg@edgszq.com', 'f8c1d87006fbf7e5cc4b026c3138bc046883dc71', 'sqgedsqfgsed', '2022-04-08 20:40:10', 4, 3, 'Salut c\'est david la farge pokemon', 200, '2022-04-13 21:08:17', 1, 3976),
(40, 0, 'dsgdrfg', 'eqdsgesdg', 'cifas16120@yeafam.com', 'f8c1d87006fbf7e5cc4b026c3138bc046883dc71', 'MYOKI', '2022-04-08 20:59:43', 3, 3, 'Je suis le personnage test du site \r\n', 200, '2022-04-08 21:00:46', 1, 2264);

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
