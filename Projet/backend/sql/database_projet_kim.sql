-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 03 avr. 2023 à 13:28
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `database_projet_kim`
--

-- --------------------------------------------------------

--
-- Structure de la table `aliments`
--

DROP TABLE IF EXISTS `aliments`;
CREATE TABLE IF NOT EXISTS `aliments` (
  `id_aliment` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(40) NOT NULL,
  `id_type_aliment` int NOT NULL,
  `calories` int DEFAULT NULL,
  `glucides` float DEFAULT NULL,
  `sucres` float DEFAULT NULL,
  `lipides` float DEFAULT NULL,
  `acides_gras` float DEFAULT NULL,
  `proteines` float DEFAULT NULL,
  `sel` float DEFAULT NULL,
  PRIMARY KEY (`id_aliment`),
  KEY `id_type_aliment` (`id_type_aliment`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `aliments`
--

INSERT INTO `aliments` (`id_aliment`, `nom`, `id_type_aliment`, `calories`, `glucides`, `sucres`, `lipides`, `acides_gras`, `proteines`, `sel`) VALUES
(1, 'Pain de mie', 1, 219, 40, 6.1, 3.6, 0.3, 5.5, 0.87),
(2, 'Cacao en poudre', 8, 151, 20.6, 20.1, 3.7, 2.3, 7.5, 0.3),
(3, 'Céréales Lion', 8, 123, 22.2, 7.5, 2.3, 1, 2.4, 0.15),
(4, 'Gaufre industrielles', 8, 199, 25, 13, 10, 4.7, 2.3, 0.27),
(5, 'Lait', 7, 117, 12, 12, 4, 2.5, 8.3, 0.25),
(6, 'Beignets de poulet', 4, 211, 15, 0.6, 11, 2.1, 12, 1.1),
(7, 'Pancake', 8, 139, 16, 9.8, 5.6, 0.6, 2, 0.51),
(8, 'Frites', 1, 149, 25.5, 0.5, 12, 2.3, 2.5, 0.4),
(9, 'Curly', 11, 138, 16, 0.45, 6, 0.87, 4.2, 0.45),
(10, 'Tomate', 3, 20, 3.59, 2.8, 0.4, 0, 0.5, 0),
(11, 'Ratatouille', 3, 75, 6.2, 2.3, 6.5, 1.5, 1.2, 0.5),
(12, 'Lasagnes à la viande', 10, 134, 13.5, 2.84, 5.72, 2.55, 6.29, 0.97),
(13, 'Litchis', 2, 81, 16.1, 15.7, 0, 0, 1.13, 0),
(14, 'Orange', 2, 46, 8.03, 7.6, 0, 0, 0.75, 0),
(15, 'Cabillaud vapeur', 5, 106, 0, 0, 0.95, 0.16, 24.5, 0.16),
(16, 'Saumon fumé', 5, 178, 0.91, 0, 9.49, 2.06, 22, 3.51),
(17, 'Panna Cotta', 9, 198, 14.9, 14.7, 13, 8.89, 2.69, 0.085),
(18, 'Cheesecake', 9, 330, 31.7, 21.6, 20.3, 12.2, 4.57, 0.38),
(19, 'Tofu nature', 6, 148, 2.87, 0.57, 8.5, 1.35, 14.7, 0.025);

-- --------------------------------------------------------

--
-- Structure de la table `composition`
--

DROP TABLE IF EXISTS `composition`;
CREATE TABLE IF NOT EXISTS `composition` (
  `id_compo` int NOT NULL AUTO_INCREMENT,
  `id_plat` int NOT NULL,
  `id_ingredient` int NOT NULL,
  `pourcentage_ingredient` int NOT NULL,
  PRIMARY KEY (`id_compo`),
  KEY `id_plat` (`id_plat`),
  KEY `id_ingredient` (`id_ingredient`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `composition`
--

INSERT INTO `composition` (`id_compo`, `id_plat`, `id_ingredient`, `pourcentage_ingredient`) VALUES
(1, 11, 10, 16),
(2, 12, 10, 7);

-- --------------------------------------------------------

--
-- Structure de la table `profils_sportifs`
--

DROP TABLE IF EXISTS `profils_sportifs`;
CREATE TABLE IF NOT EXISTS `profils_sportifs` (
  `id_profil` int NOT NULL AUTO_INCREMENT,
  `nom_profil` varchar(30) NOT NULL,
  `description` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_profil`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `profils_sportifs`
--

INSERT INTO `profils_sportifs` (`id_profil`, `nom_profil`, `description`) VALUES
(1, 'Sédentaire', 'Une activité sportive peu intense par semaine ou moins'),
(2, 'Actif', 'Entre une et trois activités sportives par semaine'),
(3, 'Très actif', 'Entre trois et six activités sportives soutenues par semaine'),
(4, 'Athlète', 'Activités sportives quotidiennes ou très soutenues');

-- --------------------------------------------------------

--
-- Structure de la table `repas`
--

DROP TABLE IF EXISTS `repas`;
CREATE TABLE IF NOT EXISTS `repas` (
  `id_repas` int NOT NULL AUTO_INCREMENT,
  `id_mangeur` varchar(50) NOT NULL,
  `id_aliment_mange` int NOT NULL,
  `qte` float NOT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id_repas`),
  KEY `id_mangeur` (`id_mangeur`),
  KEY `id_aliment_mange` (`id_aliment_mange`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `repas`
--

INSERT INTO `repas` (`id_repas`, `id_mangeur`, `id_aliment_mange`, `qte`, `date`) VALUES
(1, 'harry.potter', 9, 2, '2023-03-13'),
(2, 'louise.dupont', 5, 1, '2023-03-19'),
(3, 'louise.dupont', 5, 1, '2023-03-18'),
(4, 'nathan.simon', 8, 3, '2023-03-16'),
(5, 'kim.luxembourger', 7, 2, '2023-03-15'),
(6, 'louis.leonard', 1, 2, '2023-03-17'),
(7, 'louise.dupont', 5, 1, '2023-03-20'),
(8, 'mamie.jacques', 11, 2, '2023-03-19'),
(9, 'dan.du.35', 6, 4, '2023-03-12');

-- --------------------------------------------------------

--
-- Structure de la table `sexe`
--

DROP TABLE IF EXISTS `sexe`;
CREATE TABLE IF NOT EXISTS `sexe` (
  `id_sexe` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(20) NOT NULL,
  PRIMARY KEY (`id_sexe`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `sexe`
--

INSERT INTO `sexe` (`id_sexe`, `nom`) VALUES
(1, 'F'),
(2, 'H'),
(3, 'X');

-- --------------------------------------------------------

--
-- Structure de la table `types_aliments`
--

DROP TABLE IF EXISTS `types_aliments`;
CREATE TABLE IF NOT EXISTS `types_aliments` (
  `id_type` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(40) NOT NULL,
  PRIMARY KEY (`id_type`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `types_aliments`
--

INSERT INTO `types_aliments` (`id_type`, `nom`) VALUES
(1, 'Féculent'),
(2, 'Fruit'),
(3, 'Légume'),
(4, 'Viande'),
(5, 'Poisson'),
(6, 'Autres protéines'),
(7, 'Laitage'),
(8, 'Sucreries'),
(9, 'Dessert'),
(10, 'Plats composés'),
(11, 'Autre');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `login` varchar(50) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `age` int NOT NULL,
  `sexe` int DEFAULT NULL,
  `taille` float NOT NULL,
  `poids` int NOT NULL,
  `profil` int DEFAULT NULL,
  `besoins_jour` int DEFAULT NULL,
  PRIMARY KEY (`login`),
  KEY `sexe` (`sexe`),
  KEY `profil` (`profil`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`login`, `nom`, `age`, `sexe`, `taille`, `poids`, `profil`, `besoins_jour`) VALUES
('alexandre.favreau@etu.imt-lille-douai.fr', 'Alexandre', 25, 2, 1.75, 60, 1, NULL),
('alexis.poirot@etu.imt-lille-douai.fr', 'Alexis', 25, 2, 1.75, 60, 2, NULL),
('anaelle.ana', 'Anna', 17, 1, 1.77, 69, 4, NULL),
('anthony.gouthier@etu.imt-lille-douai.fr', 'Anthony', 25, 2, 1.75, 60, 1, NULL),
('antoine.lambert@etu.imt-lille-douai.fr', 'Antoine', 25, 2, 1.75, 60, 2, NULL),
('armand.sumo@etu.imt-lille-douai.fr', 'Armand', 25, 2, 1.75, 60, 2, NULL),
('cedric.prast@etu.imt-lille-douai.fr', 'Cédric', 25, 2, 1.75, 60, 1, NULL),
('dan.du.35', 'Daniel', 33, 3, 1.89, 94, 3, NULL),
('emil.perouse@etu.imt-lille-douai.fr', 'Emil', 25, 2, 1.75, 60, 3, NULL),
('ezzat.al.zahabi@etu.imt-lille-douai.fr', 'Ezzat', 25, 2, 1.75, 60, 2, NULL),
('gaelle.erhart@etu.imt-lille-douai.fr', 'Gaelle', 25, 1, 1.75, 60, 1, NULL),
('guillaume.faure@etu.imt-lille-douai.fr', 'Guillaume', 25, 2, 1.75, 60, 2, NULL),
('harry.potter', 'Henri', 37, 2, 1.74, 78, 3, NULL),
('hatim.hebboul@etu.imt-lille-douai.fr', 'Hatim', 25, 2, 1.75, 60, 4, NULL),
('hugo.lim@etu.imt-lille-douai.fr', 'Hugo', 25, 2, 1.75, 60, 2, NULL),
('johan.gaudin@etu.imt-lille-douai.fr', 'Johan', 25, 2, 1.75, 60, 2, NULL),
('julia.zink@etu.imt-lille-douai.fr', 'Julia', 25, 1, 1.75, 60, 1, NULL),
('kanlanfaye.djamoine@etu.imt-lille-douai.fr', 'Kanlanfaye', 25, 2, 1.75, 60, 2, NULL),
('kim.luxembourger', 'Kim', 21, 1, 1.58, 52, 1, NULL),
('lea.grumiaux@etu.imt-lille-douai.fr', 'Léa', 25, 2, 1.75, 60, 2, NULL),
('louis.leonard', 'Louis', 21, 2, 1.75, 70, 2, NULL),
('louise.dupont', 'Louise', 54, 1, 1.49, 42, 4, NULL),
('lucas.arib@etu.imt-lille-douai.fr', 'Lucas', 25, 2, 1.75, 60, 2, NULL),
('mamie.jacques', 'Jacqueline', 78, 1, 1.47, 43, 1, NULL),
('mathis.jolivel@etu.imt-lille-douai.fr', 'Mathis', 25, 2, 1.75, 60, 3, NULL),
('maxime.de.veyrac@etu.imt-lille-douai.fr', 'Maxime', 25, 2, 1.75, 60, 2, NULL),
('mekki.ben.hamidouche@etu.imt-lille-douai.fr', 'Mekki', 25, 2, 1.75, 60, 2, NULL),
('nathan.simon', 'Nathan', 21, 2, 1.78, 73, 1, NULL),
('nilavan.deva@etu.imt-lille-douai.fr', 'Nilavan', 25, 2, 1.75, 60, 2, NULL),
('pierre.martin@etu.imt-lille-douai.fr', 'Pierre', 25, 2, 1.75, 60, 2, NULL),
('sacha.sicoli@etu.imt-lille-douai.fr', 'Sacha', 25, 2, 1.75, 60, 2, NULL),
('tanguy.feenstra@etu.imt-lille-douai.fr', 'Tanguy', 25, 2, 1.75, 60, 2, NULL),
('william.nguyen@etu.imt-lille-douai.fr', 'William', 25, 2, 1.75, 60, 2, NULL);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `aliments`
--
ALTER TABLE `aliments`
  ADD CONSTRAINT `aliments_ibfk_1` FOREIGN KEY (`id_type_aliment`) REFERENCES `types_aliments` (`id_type`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `composition`
--
ALTER TABLE `composition`
  ADD CONSTRAINT `composition_ibfk_1` FOREIGN KEY (`id_plat`) REFERENCES `aliments` (`id_aliment`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `composition_ibfk_2` FOREIGN KEY (`id_ingredient`) REFERENCES `aliments` (`id_aliment`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `repas`
--
ALTER TABLE `repas`
  ADD CONSTRAINT `repas_ibfk_1` FOREIGN KEY (`id_mangeur`) REFERENCES `utilisateurs` (`login`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `repas_ibfk_2` FOREIGN KEY (`id_aliment_mange`) REFERENCES `aliments` (`id_aliment`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD CONSTRAINT `utilisateurs_ibfk_1` FOREIGN KEY (`sexe`) REFERENCES `sexe` (`id_sexe`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `utilisateurs_ibfk_2` FOREIGN KEY (`profil`) REFERENCES `profils_sportifs` (`id_profil`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
