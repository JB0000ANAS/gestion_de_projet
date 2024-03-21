-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 21 mars 2024 à 02:20
-- Version du serveur : 8.0.31
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `voiture`
--

-- --------------------------------------------------------

--
-- Structure de la table `comparaison`
--

DROP TABLE IF EXISTS `comparaison`;
CREATE TABLE IF NOT EXISTS `comparaison` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `UtilisateurID` int DEFAULT NULL,
  `VoituresComparées` text,
  PRIMARY KEY (`ID`),
  KEY `UtilisateurID` (`UtilisateurID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `favoris`
--

DROP TABLE IF EXISTS `favoris`;
CREATE TABLE IF NOT EXISTS `favoris` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `UtilisateurID` int DEFAULT NULL,
  `VoitureID` int DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `UtilisateurID` (`UtilisateurID`),
  KEY `VoitureID` (`VoitureID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `prenom` varchar(20) DEFAULT NULL,
  `numero` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `adresse` varchar(20) DEFAULT NULL,
  `mail` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `avis` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `NomUtilisateur` (`nom`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`ID`, `nom`, `prenom`, `numero`, `adresse`, `mail`, `mdp`, `avis`) VALUES
(1, 'jebali', 'anas', '0636215916', '1579 route de Mende', 'jebalianas@gmail.com', 'jebali4444**', NULL),
(2, 'lariani', 'kenza', '0636215916', '1579 route de Mende', 'larianikenza@gmail.com', 'kenza4444**', NULL),
(3, 'kakaka', 'bilel', '06663678', '1579 route de Mende', 'jebalibilel@gmail.com', 'jebali4444**', NULL),
(4, 'nouisser', 'bilel', '06663678', '1579 route de Mende', 'nouisseryoucef@gmail.com', 'youcef4444**', NULL),
(5, 'hafsi', 'imed', '0602020508', '1579 route de Mende', 'hafsiimed@gmail.com', '$2y$10$O85ivvD7n5PHh', NULL),
(6, 'jomaa', 'eya', '0602020508', '1579 route de Mende', 'jomaaeya@gmail.com', '$2y$10$309kxMAkKPHZg', NULL),
(7, 'lamairi', 'ghassen', '0602020508', '1579 route de asasas', 'lamairighassen@gmail.com', '$2y$10$3W0rS5owL0UYU', NULL),
(8, 'aaaa', 'bbbb', '0636215916', '1579 route de Mende', 'aaaabbbb@gmail.com', '$2y$10$qL/rkbXqcBn5GKQeEWVNwO5QIYc1VztW89M5kHdcEizVjjIoPXJsa', NULL),
(9, ' hafsi', 'abou', '0636215916', '1579 route de Mende', 'hafsiabou@gmail.com', '$2y$10$BWa3nurR3xKNT5lfgWxFNuMBiOx3Ru3Bs4RCBAUx66M1VbHok.hBq', NULL),
(10, 'arfaoui', 'leila', '020604050', '77 cité elamal', 'arfeouileilaa@gmail.com', '$2y$10$vo2ZEFGYrg9yhDLyRibNiOmWAyV.m2.p0Ar1XCElMTIiNlufRNdFW', NULL),
(11, 'nemri', 'mouadh', '28226998', 'manoubamanouba', 'nemrimouadh@gmail.com', '$2y$10$D2swWJzzqrVzX77gBwmhD.iKYSplLQN4/rCtMVqp8zfmnoV1cmUiO', 'merci'),
(12, 'larianii', 'kenza', '0695791833', '1579 route de Mende', 'larianiikenza00@gmail.com', '$2y$10$u81tjQwk7j2JETZyuK29Ru6R5iJpbuVS3MH7GWm65KM2xTV6HHhD2', 'merci');

-- --------------------------------------------------------

--
-- Structure de la table `vehicules`
--

DROP TABLE IF EXISTS `vehicules`;
CREATE TABLE IF NOT EXISTS `vehicules` (
  `id` int NOT NULL AUTO_INCREMENT,
  `marque` varchar(255) NOT NULL,
  `nom_modele` varchar(255) NOT NULL,
  `type_de_carrosserie` varchar(255) DEFAULT NULL,
  `nombre_de_sieges` int DEFAULT NULL,
  `largeur` decimal(8,2) DEFAULT NULL,
  `longueur` decimal(8,2) DEFAULT NULL,
  `hauteur` decimal(8,2) DEFAULT NULL,
  `type_de_moteur` varchar(255) DEFAULT NULL,
  `capacite_du_moteur` decimal(8,2) DEFAULT NULL,
  `puissance_du_moteur` int DEFAULT NULL,
  `couple_maximal` decimal(8,2) DEFAULT NULL,
  `nombre_de_cylindres` int DEFAULT NULL,
  `type_de_boite_de_vitesses` varchar(255) DEFAULT NULL,
  `type_de_transmission` varchar(255) DEFAULT NULL,
  `vitesse_maximale` int DEFAULT NULL,
  `acceleration` decimal(8,2) DEFAULT NULL,
  `autonomie_electrique` int DEFAULT NULL,
  `capacite_de_la_batterie` int DEFAULT NULL,
  `prix` decimal(12,2) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=168 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `vehicules`
--

INSERT INTO `vehicules` (`id`, `marque`, `nom_modele`, `type_de_carrosserie`, `nombre_de_sieges`, `largeur`, `longueur`, `hauteur`, `type_de_moteur`, `capacite_du_moteur`, `puissance_du_moteur`, `couple_maximal`, `nombre_de_cylindres`, `type_de_boite_de_vitesses`, `type_de_transmission`, `vitesse_maximale`, `acceleration`, `autonomie_electrique`, `capacite_de_la_batterie`, `prix`, `image_url`) VALUES
(1, 'Abarth', '500e', 'Citadine', 4, '1.88', '3.67', '1.48', 'Électrique', '42.00', 118, '220.00', 0, 'Automatique', 'Traction', 170, '7.30', 300, 42, '29900.00', 'https://cdn.automobile-propre.com/uploads/2022/11/New-Abarth-500e-10.jpeg'),
(2, 'Abarth', '695', 'Compacte', 4, '1.95', '3.66', '1.48', 'Essence', '1.40', 180, '250.00', 4, 'Manuelle', 'Traction', 225, '6.70', 0, 0, '32500.00', 'https://images.caradisiac.com/images/1/3/1/5/191315/S1-prise-en-main-abarth-695-esseesse-collector-s-edition-c-est-dans-les-vieux-pots-686107.jpg'),
(3, 'Alfa Romeo', 'Giulia', 'Berline', 5, '1.86', '4.64', '1.43', 'Essence', '2.00', 200, '300.00', 4, 'Automatique', 'Traction', 250, '6.00', 0, 0, '40000.00', 'https://www.alfaromeo.fr/content/dam/alfa/cross/giulia/shift-to-merchant/engine/hub/my24-mca/AR-Giulia-Merchant-ContentGrid-Engine-03.jpg'),
(4, 'Alfa Romeo', 'Stelvio', 'SUV', 5, '1.87', '4.68', '1.67', 'Essence', '2.00', 220, '350.00', 4, 'Automatique', 'Traction', 240, '6.50', 0, 0, '45000.00', 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAoGBxQUExYUExQYGBYZGhkZGhoaGBwcGhoaFh8ZGhYcHx0dIiskGhwoIBYhJDQjKCwuMTExGiE3PDcwOyswMS4BCwsLDw4PHRERHS4oIigwMDAwMDAwMDIwMjAwMDAwMDIwMDAwMDIwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMP/AABEIALIBGgMBIgACEQEDEQH/'),
(5, 'Alfa Romeo', 'Tonale', 'SUV', 5, '1.78', '4.42', '1.60', 'Hybride', '1.30', 160, '250.00', 3, 'Automatique', 'Traction', 220, '7.00', 60, 11, '38000.00', NULL),
(6, 'Alpine', 'A110', 'Coupé sportif', 2, '1.79', '4.18', '1.25', 'Essence', '1.80', 252, '320.00', 4, 'Manuelle', 'Propulsion', 250, '4.50', 0, 0, '55000.00', NULL),
(7, 'Aston Martin', 'DBX', 'SUV', 5, '1.99', '5.04', '1.68', 'Essence', '4.00', 542, '700.00', 8, 'Automatique', 'Traction', 291, '4.50', 0, 0, '189900.00', NULL),
(8, 'Aston Martin', 'DB12', 'Coupé sportif', 2, '1.85', '4.55', '1.24', 'Essence', '5.20', 715, '900.00', 12, 'Automatique', 'Propulsion', 360, '3.40', 0, 0, '349900.00', NULL),
(9, 'Aston Martin', 'Vantage', 'Coupé sportif', 2, '1.94', '4.47', '1.27', 'Essence', '4.00', 510, '685.00', 8, 'Automatique', 'Propulsion', 314, '3.60', 0, 0, '159900.00', NULL),
(10, 'Audi', 'Q4 e-tron', 'SUV', 5, '1.82', '4.59', '1.63', 'Électrique', '82.00', 299, '664.00', 0, 'Automatique', 'Quattro', 180, '6.30', 400, 82, '59900.00', NULL),
(11, 'Audi', 'Q8 e-tron', 'SUV', 5, '1.98', '5.04', '1.71', 'Électrique', '95.00', 523, '952.00', 0, 'Automatique', 'Quattro', 210, '5.90', 450, 95, '74900.00', NULL),
(12, 'Audi', 'e-tron GT', 'Berline', 5, '1.95', '4.99', '1.39', 'Électrique', '86.50', 590, '830.00', 0, 'Automatique', 'Quattro', 245, '3.30', 400, 87, '105900.00', NULL),
(13, 'Audi', 'A1', 'Citadine', 5, '1.74', '4.03', '1.42', 'Essence', '1.00', 116, '200.00', 3, 'Manuelle', 'Traction', 203, '9.60', 0, 0, '22900.00', NULL),
(14, 'Audi', 'A3', 'Compacte', 5, '1.82', '4.34', '1.43', 'Essence', '1.50', 150, '250.00', 4, 'Automatique', 'Traction', 220, '8.20', 0, 0, '29900.00', NULL),
(15, 'Audi', 'A5', 'Coupé', 4, '1.86', '4.67', '1.37', 'Essence', '2.00', 190, '320.00', 4, 'Automatique', 'Traction', 235, '6.50', 0, 0, '42900.00', NULL),
(16, 'Audi', 'A7', 'Berline', 5, '1.91', '4.95', '1.42', 'Essence', '3.00', 340, '500.00', 6, 'Automatique', 'Quattro', 250, '5.20', 0, 0, '76900.00', NULL),
(17, 'Audi', 'Q3', 'SUV', 5, '1.85', '4.40', '1.62', 'Essence', '1.50', 150, '250.00', 4, 'Automatique', 'Traction', 220, '8.90', 0, 0, '35900.00', NULL),
(18, 'Audi', 'Q5', 'SUV', 5, '1.89', '4.67', '1.66', 'Essence', '2.00', 190, '320.00', 4, 'Automatique', 'Quattro', 230, '6.30', 0, 0, '42900.00', NULL),
(19, 'Audi', 'Q7', 'SUV', 7, '1.97', '5.06', '1.74', 'Essence', '3.00', 340, '500.00', 6, 'Automatique', 'Quattro', 250, '5.50', 0, 0, '52900.00', NULL),
(20, 'Audi', 'TT', 'Coupé', 2, '1.83', '4.18', '1.35', 'Essence', '2.00', 197, '320.00', 4, 'Automatique', 'Traction', 250, '4.90', 0, 0, '47900.00', NULL),
(21, 'Batmobile', 'Batmobile 1989', 'Voiture de sport', 2, '2.21', '5.31', '1.15', 'Essence', '6.20', 1200, '1150.00', 8, 'Automatique', 'Propulsion', 300, '3.70', 0, 0, '250000.00', NULL),
(22, 'Batmobile', 'Batmobile Christopher Nolan', 'Voiture de sport', 2, '2.26', '5.50', '1.10', 'Hybride', '3.50', 700, '800.00', 6, 'Automatique', 'Propulsion', 320, '2.80', 30, 6, '500000.00', NULL),
(23, 'Bentley', 'Bentayga', 'SUV', 5, '2.22', '5.14', '1.74', 'Essence', '4.00', 550, '770.00', 8, 'Automatique', 'Quattro', 292, '4.50', 0, 0, '180000.00', NULL),
(24, 'Bentley', 'Continental GT', 'Coupé', 4, '2.21', '4.85', '1.40', 'Essence', '4.00', 550, '770.00', 8, 'Automatique', 'Quattro', 333, '4.00', 0, 0, '220000.00', NULL),
(25, 'Bentley', 'Flying Spur', 'Berline', 5, '2.22', '5.32', '1.48', 'Essence', '4.00', 550, '770.00', 8, 'Automatique', 'Quattro', 333, '4.10', 0, 0, '230000.00', NULL),
(26, 'BMW', 'Serie 1', 'Citadine', 5, '1.75', '4.32', '1.43', 'Essence', '1.50', 140, '220.00', 3, 'Manuelle', 'Traction', 210, '8.30', 0, 0, '28000.00', NULL),
(27, 'BMW', 'iX1', 'SUV', 5, '1.83', '4.43', '1.53', 'Électrique', '70.00', 250, '400.00', 0, 'Automatique', 'Traction', 160, '7.90', 300, 70, '45000.00', NULL),
(28, 'BMW', 'iX2', 'SUV', 5, '1.83', '4.43', '1.53', 'Électrique', '90.00', 286, '400.00', 0, 'Automatique', 'Traction', 170, '7.00', 300, 90, '52000.00', NULL),
(29, 'BMW', 'X7', 'SUV', 7, '2.00', '5.16', '1.80', 'Essence', '4.40', 530, '750.00', 8, 'Automatique', 'Quattro', 250, '5.40', 0, 0, '80000.00', NULL),
(30, 'BMW', 'Serie 3', 'Berline', 5, '1.83', '4.71', '1.43', 'Essence', '2.00', 184, '290.00', 4, 'Automatique', 'Traction', 230, '7.00', 0, 0, '35000.00', NULL),
(31, 'BMW', 'Serie 5 hybride', 'Berline', 5, '1.90', '4.94', '1.48', 'Hybride', '2.00', 292, '420.00', 4, 'Automatique', 'Traction', 250, '5.80', 60, 12, '60000.00', NULL),
(32, 'BMW', 'i5', 'Berline', 5, '1.95', '4.93', '1.48', 'Électrique', '90.00', 350, '600.00', 0, 'Automatique', 'Traction', 225, '6.30', 350, 90, '75000.00', NULL),
(33, 'BMW', 'Serie 2 Gran Coupé', 'Berline', 5, '1.80', '4.53', '1.42', 'Essence', '2.00', 306, '450.00', 4, 'Automatique', 'Traction', 250, '6.10', 0, 0, '40000.00', NULL),
(34, 'BMW', 'M3 Competition', 'Berline', 5, '1.88', '4.79', '1.44', 'Essence', '3.00', 510, '650.00', 6, 'Automatique', 'Quattro', 290, '4.00', 0, 0, '80000.00', NULL),
(35, 'BMW', 'M4 Competition', 'Coupé', 4, '1.91', '4.78', '1.39', 'Essence', '3.00', 510, '650.00', 6, 'Automatique', 'Quattro', 280, '4.00', 0, 0, '85000.00', NULL),
(36, 'Cadillac', 'XT4', 'SUV', 5, '1.83', '4.60', '1.63', 'Essence', '2.00', 237, '350.00', 4, 'Automatique', 'Traction', 220, '7.80', 0, 0, '35000.00', NULL),
(37, 'Citroen', 'C3', 'Citadine', 5, '1.75', '3.99', '1.47', 'Essence', '1.20', 83, '118.00', 3, 'Manuelle', 'Traction', 180, '12.30', 0, 0, '15000.00', NULL),
(38, 'Citroen', 'e-C4', 'Compacte', 5, '1.80', '4.36', '1.52', 'Électrique', '50.00', 136, '260.00', 0, 'Automatique', 'Traction', 150, '9.70', 230, 50, '28000.00', NULL),
(39, 'Citroen', 'e-Berlingo', 'Monospace', 5, '1.84', '4.75', '1.81', 'Électrique', '50.00', 134, '260.00', 0, 'Automatique', 'Traction', 130, '11.20', 180, 50, '32000.00', NULL),
(40, 'Cupra', 'Leon', 'Compacte', 5, '1.80', '4.50', '1.45', 'Essence', '2.00', 310, '400.00', 4, 'Automatique', 'Traction', 250, '4.90', 0, 0, '40000.00', NULL),
(41, 'Cupra', 'Tavascan', 'SUV', 5, '1.63', '4.37', '1.56', 'Électrique', '77.00', 306, '270.00', 0, 'Automatique', 'Traction', 160, '7.20', 400, 77, '50000.00', NULL),
(42, 'Dacia', 'Spring', 'Citadine', 5, '1.57', '3.73', '1.52', 'Électrique', '33.00', 45, '125.00', 0, 'Automatique', 'Traction', 130, '17.00', 230, 33, '12000.00', NULL),
(43, 'Dacia', 'Sandero', 'Citadine', 5, '1.80', '4.08', '1.50', 'Essence', '1.00', 65, '95.00', 3, 'Manuelle', 'Traction', 165, '14.50', 0, 0, '10000.00', NULL),
(44, 'Dacia', 'Duster', 'SUV', 5, '1.80', '4.34', '1.68', 'Essence', '1.00', 100, '160.00', 3, 'Manuelle', 'Traction', 170, '12.50', 0, 0, '15000.00', NULL),
(45, 'Ferrari', 'SF90 Stradale', 'Voiture de sport', 2, '1.98', '4.71', '1.19', 'Hybride', '4.00', 1000, '800.00', 8, 'Automatique', 'Quattro', 340, '2.50', 25, 8, '600000.00', NULL),
(46, 'Ferrari', '296 GTB', 'Coupé sportif', 2, '1.97', '4.54', '1.19', 'Hybride', '3.00', 817, '740.00', 6, 'Automatique', 'Propulsion', 330, '2.90', 25, 7, '400000.00', NULL),
(47, 'Ferrari', '812 GTS', 'Coupé sportif', 2, '1.97', '4.68', '1.28', 'Essence', '6.50', 800, '718.00', 12, 'Automatique', 'Propulsion', 340, '3.00', 0, 0, '350000.00', NULL),
(48, 'Ferrari', 'F8 Tributo', 'Coupé sportif', 2, '1.98', '4.61', '1.20', 'Essence', '3.90', 720, '770.00', 8, 'Automatique', 'Propulsion', 340, '2.90', 0, 0, '300000.00', NULL),
(49, 'Fiat', '500e', 'Citadine', 4, '1.68', '3.63', '1.50', 'Électrique', '42.00', 118, '220.00', 0, 'Automatique', 'Traction', 170, '7.30', 300, 42, '29900.00', NULL),
(50, 'Fiat', '500 Hybrid', 'Citadine', 4, '1.68', '3.63', '1.50', 'Hybride', '1.00', 70, '140.00', 3, 'Automatique', 'Traction', 150, '10.90', 20, 1, '21900.00', NULL),
(51, 'Fiat', '600 Electrique', 'Citadine', 4, '1.68', '3.63', '1.50', 'Électrique', '40.00', 100, '150.00', 0, 'Automatique', 'Traction', 140, '12.00', 250, 40, '26900.00', NULL),
(52, 'Ford', 'Puma', 'SUV', 5, '1.80', '4.19', '1.54', 'Essence', '1.00', 155, '175.00', 3, 'Manuelle', 'Traction', 200, '9.00', 0, 0, '20000.00', NULL),
(53, 'Ford', 'Mustang Mach-E GT', 'SUV', 5, '1.89', '4.71', '1.61', 'Électrique', '88.00', 480, '860.00', 0, 'Automatique', 'Traction', 200, '3.70', 400, 88, '68000.00', NULL),
(54, 'Ford', 'Fiesta', 'Citadine', 5, '1.73', '4.04', '1.47', 'Essence', '1.00', 95, '170.00', 3, 'Manuelle', 'Traction', 180, '9.00', 0, 0, '15000.00', NULL),
(55, 'Ford', 'Focus', 'Compacte', 5, '1.83', '4.38', '1.47', 'Essence', '1.00', 125, '170.00', 3, 'Manuelle', 'Traction', 190, '9.50', 0, 0, '18000.00', NULL),
(56, 'Ford', 'Mustang', 'Coupé sportif', 4, '1.91', '4.79', '1.38', 'Essence', '5.00', 450, '580.00', 8, 'Automatique', 'Propulsion', 250, '4.50', 0, 0, '45000.00', NULL),
(57, 'Ford', 'Tourneo', 'Monospace', 9, '1.99', '5.34', '1.97', 'Essence', '2.00', 240, '350.00', 4, 'Automatique', 'Traction', 180, '9.00', 0, 0, '35000.00', NULL),
(58, 'GMC', 'Sierra', 'Pick-up', 5, '2.06', '5.88', '1.98', 'Essence', '6.20', 420, '623.00', 8, 'Automatique', 'Quattro', 230, '6.00', 0, 0, '50000.00', NULL),
(59, 'GMC', 'Terrain', 'SUV', 5, '1.84', '4.65', '1.66', 'Essence', '1.50', 170, '255.00', 4, 'Automatique', 'Traction', 190, '9.00', 0, 0, '30000.00', NULL),
(60, 'Honda', 'e', 'Citadine', 4, '1.75', '3.89', '1.52', 'Électrique', '35.50', 154, '315.00', 0, 'Automatique', 'Traction', 150, '8.30', 220, 36, '32000.00', NULL),
(61, 'Honda', 'Civic', 'Compacte', 5, '1.81', '4.65', '1.42', 'Essence', '1.00', 126, '200.00', 3, 'Manuelle', 'Traction', 190, '10.90', 0, 0, '22000.00', NULL),
(62, 'Honda', 'Type-R', 'Compacte', 5, '1.88', '4.56', '1.42', 'Essence', '2.00', 320, '400.00', 4, 'Manuelle', 'Traction', 272, '5.70', 0, 0, '32000.00', NULL),
(63, 'Honda', 'CR-V', 'SUV', 5, '1.85', '4.59', '1.67', 'Hybride', '2.00', 184, '315.00', 4, 'Automatique', 'Quattro', 175, '9.20', 0, 0, '35000.00', NULL),
(64, 'Honda', 'HR-V', 'SUV', 5, '1.77', '4.33', '1.59', 'Hybride', '1.50', 131, '253.00', 4, 'Automatique', 'Traction', 175, '9.40', 0, 0, '27000.00', NULL),
(65, 'Hyundai', 'Kona Electric', 'SUV', 5, '1.80', '4.18', '1.57', 'Électrique', '64.00', 201, '395.00', 0, 'Automatique', 'Traction', 167, '7.60', 450, 64, '35000.00', NULL),
(66, 'Hyundai', 'Tucson Hybrid', 'SUV', 5, '1.86', '4.50', '1.65', 'Hybride', '1.60', 230, '350.00', 4, 'Automatique', 'Traction', 190, '8.90', 50, 2, '30000.00', NULL),
(67, 'Hyundai', 'Ioniq 5', 'Citadine', 5, '1.89', '4.63', '1.60', 'Électrique', '72.60', 225, '305.00', 0, 'Automatique', 'Traction', 185, '7.40', 400, 73, '45000.00', NULL),
(68, 'Infiniti', 'QX80', 'SUV', 7, '2.03', '5.34', '1.95', 'Essence', '5.60', 400, '560.00', 8, 'Automatique', 'Traction', 210, '6.40', 0, 0, '70000.00', NULL),
(69, 'Infiniti', 'QX60', 'SUV', 7, '1.96', '4.98', '1.76', 'Hybride', '3.50', 265, '336.00', 6, 'Automatique', 'Traction', 185, '8.20', 30, 5, '50000.00', NULL),
(70, 'Jaguar', 'E-PACE', 'SUV', 5, '1.98', '4.41', '1.65', 'Essence', '2.00', 200, '320.00', 4, 'Automatique', 'Traction', 210, '8.00', 0, 0, '40000.00', NULL),
(71, 'Jaguar', 'F-PACE', 'SUV', 5, '1.96', '4.73', '1.66', 'Hybride', '2.00', 404, '640.00', 4, 'Automatique', 'Traction', 240, '5.10', 53, 13, '45000.00', NULL),
(72, 'Jaguar', 'XF', 'Berline', 5, '1.86', '4.96', '1.45', 'Essence', '2.00', 250, '365.00', 4, 'Automatique', 'Traction', 250, '6.00', 0, 0, '45000.00', NULL),
(73, 'Jaguar', 'F-TYPE', 'Coupé sportif', 2, '1.92', '4.47', '1.31', 'Essence', '5.00', 450, '580.00', 8, 'Automatique', 'Propulsion', 300, '4.30', 0, 0, '50000.00', NULL),
(74, 'Honda', 'e', 'Citadine', 4, '1.75', '3.89', '1.52', 'Électrique', '35.50', 154, '315.00', 0, 'Automatique', 'Traction', 150, '8.30', 220, 36, '32000.00', NULL),
(75, 'Honda', 'Civic', 'Compacte', 5, '1.81', '4.65', '1.42', 'Essence', '1.00', 126, '200.00', 3, 'Manuelle', 'Traction', 190, '10.90', 0, 0, '22000.00', NULL),
(76, 'Honda', 'Type-R', 'Compacte', 5, '1.88', '4.56', '1.42', 'Essence', '2.00', 320, '400.00', 4, 'Manuelle', 'Traction', 272, '5.70', 0, 0, '32000.00', NULL),
(77, 'Honda', 'CR-V', 'SUV', 5, '1.85', '4.59', '1.67', 'Hybride', '2.00', 184, '315.00', 4, 'Automatique', 'Quattro', 175, '9.20', 0, 0, '35000.00', NULL),
(78, 'Honda', 'HR-V', 'SUV', 5, '1.77', '4.33', '1.59', 'Hybride', '1.50', 131, '253.00', 4, 'Automatique', 'Traction', 175, '9.40', 0, 0, '27000.00', NULL),
(79, 'Hyundai', 'Kona Electric', 'SUV', 5, '1.80', '4.18', '1.57', 'Électrique', '64.00', 201, '395.00', 0, 'Automatique', 'Traction', 167, '7.60', 450, 64, '35000.00', NULL),
(80, 'Hyundai', 'Tucson Hybrid', 'SUV', 5, '1.86', '4.50', '1.65', 'Hybride', '1.60', 230, '350.00', 4, 'Automatique', 'Traction', 190, '8.90', 50, 2, '30000.00', NULL),
(81, 'Hyundai', 'Ioniq 5', 'Citadine', 5, '1.89', '4.63', '1.60', 'Électrique', '72.60', 225, '305.00', 0, 'Automatique', 'Traction', 185, '7.40', 400, 73, '45000.00', NULL),
(82, 'Infiniti', 'QX80', 'SUV', 7, '2.03', '5.34', '1.95', 'Essence', '5.60', 400, '560.00', 8, 'Automatique', 'Traction', 210, '6.40', 0, 0, '70000.00', NULL),
(83, 'Infiniti', 'QX60', 'SUV', 7, '1.96', '4.98', '1.76', 'Hybride', '3.50', 265, '336.00', 6, 'Automatique', 'Traction', 185, '8.20', 30, 5, '50000.00', NULL),
(84, 'Jaguar', 'E-PACE', 'SUV', 5, '1.98', '4.41', '1.65', 'Essence', '2.00', 200, '320.00', 4, 'Automatique', 'Traction', 210, '8.00', 0, 0, '40000.00', NULL),
(85, 'Jaguar', 'F-PACE', 'SUV', 5, '1.96', '4.73', '1.66', 'Hybride', '2.00', 404, '640.00', 4, 'Automatique', 'Traction', 240, '5.10', 53, 13, '45000.00', NULL),
(86, 'Jaguar', 'XF', 'Berline', 5, '1.86', '4.96', '1.45', 'Essence', '2.00', 250, '365.00', 4, 'Automatique', 'Traction', 250, '6.00', 0, 0, '45000.00', NULL),
(87, 'Jaguar', 'F-TYPE', 'Coupé sportif', 2, '1.92', '4.47', '1.31', 'Essence', '5.00', 450, '580.00', 8, 'Automatique', 'Propulsion', 300, '4.30', 0, 0, '50000.00', NULL),
(88, 'Jeep', 'Avenger', 'SUV', 5, '1.84', '4.61', '1.66', 'Essence', '3.60', 283, '353.00', 6, 'Automatique', 'Quattro', 206, '8.90', 0, 0, '28000.00', NULL),
(89, 'Jeep', 'Compass', 'SUV', 5, '1.82', '4.39', '1.63', 'Essence', '1.40', 130, '270.00', 4, 'Manuelle', 'Quattro', 200, '9.80', 0, 0, '25000.00', NULL),
(90, 'Jeep', 'Renegade', 'SUV', 5, '1.81', '4.24', '1.70', 'Essence', '1.00', 120, '190.00', 3, 'Manuelle', 'Traction', 190, '11.20', 0, 0, '20000.00', NULL),
(91, 'Jeep', 'Gladiator', 'Pick-up', 5, '1.88', '5.54', '1.88', 'Essence', '3.60', 285, '353.00', 6, 'Automatique', 'Quattro', 180, '9.00', 0, 0, '35000.00', NULL),
(92, 'Kia', 'Niro EV', 'SUV', 5, '1.81', '4.37', '1.56', 'Électrique', '64.00', 201, '395.00', 0, 'Automatique', 'Traction', 167, '7.60', 450, 64, '35000.00', NULL),
(93, 'Kia', 'Sportage', 'SUV', 5, '1.85', '4.48', '1.64', 'Hybride', '1.60', 230, '350.00', 4, 'Automatique', 'Traction', 190, '8.90', 50, 2, '30000.00', NULL),
(94, 'Kia', 'EV6', 'SUV', 5, '1.88', '4.68', '1.55', 'Électrique', '77.40', 313, '605.00', 0, 'Automatique', 'Traction', 201, '7.90', 430, 77, '42000.00', NULL),
(95, 'Kia', 'EV9', 'SUV', 7, '1.89', '4.96', '1.66', 'Électrique', '77.40', 313, '605.00', 0, 'Automatique', 'Traction', 201, '8.20', 450, 77, '50000.00', NULL),
(96, 'Kia', 'Xceed', 'Citadine', 5, '1.80', '4.39', '1.49', 'Essence', '1.00', 120, '172.00', 3, 'Manuelle', 'Traction', 190, '10.60', 0, 0, '22000.00', NULL),
(97, 'Lexus', 'ES', 'Berline', 5, '1.87', '4.98', '1.45', 'Hybride', '2.50', 218, '221.00', 4, 'Automatique', 'Traction', 180, '8.90', 50, 1, '45000.00', NULL),
(98, 'Lexus', 'RX', 'SUV', 5, '1.89', '4.89', '1.68', 'Hybride', '3.50', 308, '335.00', 6, 'Automatique', 'Traction', 180, '8.00', 50, 2, '55000.00', NULL),
(99, 'Lexus', 'LS', 'Berline', 5, '1.90', '5.23', '1.45', 'Hybride', '3.50', 295, '350.00', 6, 'Automatique', 'Traction', 250, '5.40', 50, 2, '60000.00', NULL),
(100, 'Lexus', 'LC', 'Coupé', 4, '1.92', '4.77', '1.31', 'Hybride', '3.50', 359, '475.00', 6, 'Automatique', 'Propulsion', 270, '4.40', 50, 1, '70000.00', NULL),
(101, 'Lamborghini', 'Urus', 'SUV', 5, '1.99', '5.11', '1.64', 'Essence', '4.00', 641, '850.00', 8, 'Automatique', 'Quattro', 305, '3.60', 0, 0, '250000.00', NULL),
(102, 'Lamborghini', 'Reventón', 'Coupé sportif', 2, '2.06', '4.72', '1.35', 'Essence', '6.50', 661, '660.00', 12, 'Automatique', 'Quattro', 340, '3.40', 0, 0, '500000.00', NULL),
(103, 'Lamborghini', 'Huracán', 'Coupé sportif', 2, '1.92', '4.46', '1.17', 'Essence', '5.20', 610, '560.00', 10, 'Automatique', 'Quattro', 325, '3.30', 0, 0, '250000.00', NULL),
(104, 'Land Rover', 'Range Rover Sport', 'SUV', 5, '1.98', '4.88', '1.89', 'Hybride', '3.00', 404, '640.00', 6, 'Automatique', 'Quattro', 209, '5.40', 48, 13, '70000.00', NULL),
(105, 'Land Rover', 'Range Rover', 'SUV', 5, '1.98', '5.02', '1.86', 'Hybride', '3.00', 400, '550.00', 6, 'Automatique', 'Quattro', 220, '5.90', 50, 13, '80000.00', NULL),
(106, 'Land Rover', 'Defender', 'SUV', 5, '1.97', '4.58', '1.97', 'Hybride', '2.00', 394, '550.00', 6, 'Automatique', 'Quattro', 160, '8.00', 30, 4, '60000.00', NULL),
(107, 'Lotus', 'Emira', 'Coupé sportif', 2, '1.86', '4.41', '1.22', 'Essence', '3.50', 400, '450.00', 6, 'Automatique', 'Propulsion', 290, '4.50', 0, 0, '75000.00', NULL),
(108, 'Lucid', 'Air', 'Berline', 5, '1.98', '4.95', '1.50', 'Électrique', '924.00', 1080, '1800.00', 2, 'Automatique', 'Traction', 270, '2.50', 600, 924, '169000.00', NULL),
(109, 'Lynk & Co', '01', 'SUV', 5, '1.86', '4.53', '1.70', 'Hybride', '1.50', 180, '265.00', 3, 'Automatique', 'Traction', 170, '7.50', 50, 2, '35000.00', NULL),
(110, 'McLaren', '720S', 'Coupé sportif', 2, '1.20', '4.54', '1.95', 'Essence', '4.00', 720, '770.00', 8, 'Automatique', 'Propulsion', 341, '2.90', 0, 0, '300000.00', NULL),
(111, 'McLaren', 'Artura', 'Coupé sportif', 2, '1.21', '4.54', '1.92', 'Hybride', '3.00', 680, '720.00', 6, 'Automatique', 'Traction', 330, '3.00', 25, 8, '350000.00', NULL),
(112, 'McLaren', 'Speedtail', 'Coupé sportif', 2, '1.93', '5.37', '1.13', 'Hybride', '4.00', 1070, '1150.00', 8, 'Automatique', 'Propulsion', 403, '2.70', 35, 10, '500000.00', NULL),
(113, 'McLaren', 'Senna', 'Coupé sportif', 2, '1.90', '4.71', '1.19', 'Essence', '4.00', 800, '800.00', 8, 'Automatique', 'Propulsion', 335, '2.80', 0, 0, '600000.00', NULL),
(114, 'Mercedes-Benz', 'CLA', 'Berline', 5, '1.78', '4.69', '1.43', 'Essence', '2.00', 224, '350.00', 4, 'Automatique', 'Traction', 250, '6.30', 0, 0, '40000.00', NULL),
(115, 'Mercedes-Benz', 'EQA', 'SUV', 5, '1.83', '4.46', '1.62', 'Électrique', '66.50', 190, '365.00', 0, 'Automatique', 'Traction', 160, '7.90', 420, 67, '45000.00', NULL),
(116, 'Mercedes-Benz', 'EQB', 'SUV', 7, '1.83', '4.68', '1.66', 'Électrique', '66.50', 190, '365.00', 0, 'Automatique', 'Traction', 160, '7.80', 400, 67, '50000.00', NULL),
(117, 'Mercedes-Benz', 'GLA', 'SUV', 5, '1.80', '4.41', '1.49', 'Hybride', '1.30', 160, '230.00', 4, 'Automatique', 'Traction', 190, '8.60', 60, 1, '35000.00', NULL),
(118, 'Mercedes-Benz', 'A', 'Citadine', 5, '1.43', '4.42', '1.44', 'Essence', '1.30', 163, '250.00', 4, 'Manuelle', 'Traction', 240, '8.20', 0, 0, '28000.00', NULL),
(119, 'Mercedes-Benz', 'C', 'Berline', 5, '1.81', '4.69', '1.46', 'Hybride', '1.50', 184, '250.00', 4, 'Automatique', 'Traction', 220, '5.40', 60, 14, '45000.00', NULL),
(120, 'Mercedes-Benz', 'C Hybride', 'Berline', 5, '1.81', '4.69', '1.46', 'Hybride', '2.00', 320, '550.00', 4, 'Automatique', 'Traction', 250, '4.70', 80, 14, '55000.00', NULL),
(121, 'Mercedes-Benz', 'S', 'Berline', 5, '1.92', '5.24', '1.50', 'Hybride', '3.00', 367, '500.00', 6, 'Automatique', 'Traction', 250, '5.00', 80, 20, '70000.00', NULL),
(122, 'Mazda', 'MX5', 'Cabriolet', 2, '1.50', '3.92', '1.23', 'Essence', '2.00', 184, '205.00', 4, 'Manuelle', 'Propulsion', 220, '6.50', 0, 0, '28000.00', NULL),
(123, 'Mazda', 'CX-60', 'SUV', 5, '1.85', '4.68', '1.68', 'Essence', '2.50', 195, '264.00', 4, 'Automatique', 'Traction', 200, '7.50', 0, 0, '30000.00', NULL),
(124, 'Mazda', 'CX-5', 'SUV', 5, '1.84', '4.55', '1.68', 'Essence', '2.00', 165, '213.00', 4, 'Automatique', 'Traction', 180, '8.00', 0, 0, '25000.00', NULL),
(125, 'Mini', 'Cooper Electric', 'Citadine', 4, '1.73', '3.85', '1.73', 'Électrique', '181.00', 270, '320.00', 0, 'Automatique', 'Traction', 165, '7.30', 270, 181, '33000.00', NULL),
(126, 'Mini', 'Countryman Electric', 'SUV', 5, '1.56', '4.30', '1.83', 'Électrique', '217.00', 270, '320.00', 0, 'Automatique', 'Traction', 165, '7.80', 320, 217, '40000.00', NULL),
(127, 'Peugeot', '208', 'Citadine', 5, '1.74', '4.06', '1.46', 'Essence', '1.20', 100, '230.00', 3, 'Manuelle', 'Traction', 175, '9.70', 0, 0, '18000.00', NULL),
(128, 'Peugeot', '208 Electric', 'Citadine', 5, '1.74', '4.06', '1.46', 'Électrique', '136.00', 260, '340.00', 0, 'Automatique', 'Traction', 150, '7.90', 220, 136, '30000.00', NULL),
(129, 'Peugeot', '2008', 'SUV', 5, '1.74', '4.30', '1.53', 'Essence', '1.20', 130, '230.00', 3, 'Manuelle', 'Traction', 180, '10.50', 0, 0, '20000.00', NULL),
(130, 'Peugeot', '308', 'Compacte', 5, '1.80', '4.42', '1.47', 'Essence', '1.20', 130, '230.00', 3, 'Manuelle', 'Traction', 190, '9.50', 0, 0, '22000.00', NULL),
(131, 'Peugeot', '3008', 'SUV', 5, '1.84', '4.49', '1.62', 'Hybride', '1.60', 200, '360.00', 4, 'Automatique', 'Traction', 190, '7.50', 50, 2, '25000.00', NULL),
(132, 'Peugeot', '408', 'Berline', 5, '1.86', '4.75', '1.47', 'Essence', '1.20', 130, '230.00', 3, 'Manuelle', 'Traction', 190, '9.90', 0, 0, '23000.00', NULL),
(133, 'Peugeot', '508', 'Berline', 5, '1.86', '4.75', '1.40', 'Hybride', '1.60', 200, '360.00', 4, 'Automatique', 'Traction', 190, '7.10', 50, 2, '27000.00', NULL),
(134, 'Porsche', '718', 'Coupé sportif', 2, '1.98', '4.38', '1.28', 'Essence', '2.00', 295, '380.00', 4, 'Automatique', 'Propulsion', 275, '4.70', 0, 0, '60000.00', NULL),
(135, 'Porsche', '911', 'Coupé sportif', 4, '1.85', '4.52', '1.30', 'Essence', '3.00', 385, '450.00', 6, 'Automatique', 'Traction', 305, '4.20', 0, 0, '80000.00', NULL),
(136, 'Porsche', 'Taycan', 'Berline', 4, '1.96', '4.96', '1.38', 'Électrique', '525.00', 650, '850.00', 0, 'Automatique', 'Traction', 260, '3.40', 400, 525, '100000.00', NULL),
(137, 'Porsche', 'Cayenne', 'SUV', 5, '1.98', '4.92', '1.69', 'Hybride', '3.00', 456, '700.00', 6, 'Automatique', 'Traction', 253, '5.00', 50, 3, '90000.00', NULL),
(138, 'Renault', 'Twingo Electrique', 'Citadine', 4, '1.59', '3.61', '1.44', 'Électrique', '82.00', 160, '160.00', 0, 'Automatique', 'Traction', 160, '12.90', 180, 82, '20000.00', NULL),
(139, 'Renault', 'Zoe Electrique', 'Citadine', 5, '1.73', '4.08', '1.56', 'Électrique', '110.00', 225, '220.00', 0, 'Automatique', 'Traction', 140, '10.90', 250, 110, '24000.00', NULL),
(140, 'Renault', 'Clio', 'Citadine', 5, '1.74', '4.05', '1.46', 'Essence', '1.00', 75, '95.00', 3, 'Manuelle', 'Traction', 170, '11.00', 0, 0, '16000.00', NULL),
(141, 'Renault', 'Megane', 'Compacte', 5, '1.81', '4.36', '1.43', 'Essence', '1.30', 115, '260.00', 4, 'Manuelle', 'Traction', 185, '9.70', 0, 0, '18000.00', NULL),
(142, 'Renault', 'Kangoo', 'Monospace', 5, '1.83', '4.67', '1.82', 'Essence', '1.00', 75, '95.00', 3, 'Manuelle', 'Traction', 160, '12.40', 0, 0, '22000.00', NULL),
(143, 'Renault', 'Kangoo Electrique', 'Monospace', 5, '1.83', '4.67', '1.82', 'Électrique', '44.00', 60, '105.00', 0, 'Automatique', 'Traction', 160, '11.60', 200, 44, '28000.00', NULL),
(144, 'Tesla', 'Model Y', 'SUV', 5, '1.91', '4.75', '1.66', 'Électrique', '326.00', 500, '526.00', 0, 'Automatique', 'Traction', 217, '5.10', 480, 326, '48000.00', NULL),
(145, 'Tesla', 'Model S', 'Berline', 5, '1.96', '4.97', '1.45', 'Électrique', '670.00', 1050, '1005.00', 0, 'Automatique', 'Traction', 250, '2.70', 640, 670, '90000.00', NULL),
(146, 'Tesla', 'Model 3', 'Berline', 5, '1.85', '4.69', '1.44', 'Électrique', '258.00', 416, '638.00', 0, 'Automatique', 'Traction', 225, '5.60', 580, 258, '43000.00', NULL),
(147, 'Tesla', 'Model X', 'SUV', 5, '1.99', '5.04', '1.68', 'Électrique', '421.00', 660, '855.00', 0, 'Automatique', 'Traction', 250, '4.40', 800, 421, '60000.00', NULL),
(148, 'Toyota', 'C-HR', 'SUV', 5, '1.56', '4.39', '1.73', 'Hybride', '1.80', 122, '163.00', 4, 'Automatique', 'Traction', 160, '8.20', 0, 2, '22000.00', NULL),
(149, 'Toyota', 'Corolla', 'Compacte', 5, '1.79', '4.38', '1.44', 'Hybride', '1.80', 122, '163.00', 4, 'Automatique', 'Traction', 160, '8.50', 0, 2, '23000.00', NULL),
(150, 'Toyota', 'RAV4', 'SUV', 5, '1.85', '4.60', '1.69', 'Hybride', '2.50', 218, '263.00', 4, 'Automatique', 'Traction', 180, '7.90', 0, 3, '25000.00', NULL),
(151, 'Toyota', 'Prius', 'Compacte', 5, '1.76', '4.59', '1.47', 'Hybride', '1.80', 122, '163.00', 4, 'Automatique', 'Traction', 165, '10.90', 0, 2, '20000.00', NULL),
(152, 'Toyota', 'Supra', 'Coupé sportif', 2, '1.86', '4.38', '1.29', 'Essence', '3.00', 340, '500.00', 6, 'Automatique', 'Traction', 250, '4.30', 0, 0, '60000.00', NULL),
(153, 'Toyota', 'Hilux', 'Pick-up', 5, '1.83', '5.33', '1.85', 'Essence', '2.70', 166, '245.00', 4, 'Manuelle', 'Quattro', 180, '12.00', 0, 0, '28000.00', NULL),
(154, 'Toyota', 'Proace', 'Fourgon', 3, '1.92', '4.95', '1.90', 'Diesel', '2.00', 120, '320.00', 4, 'Manuelle', 'Traction', 160, '11.40', 0, 0, '25000.00', NULL),
(155, 'Toyota', 'Verso', 'Monospace', 7, '1.79', '4.46', '1.62', 'Hybride', '1.80', 122, '163.00', 4, 'Automatique', 'Traction', 165, '10.40', 0, 2, '23000.00', NULL),
(156, 'Volkswagen', 'e-up', 'Citadine', 4, '1.64', '3.61', '1.50', 'Électrique', '61.00', 82, '210.00', 0, 'Automatique', 'Traction', 130, '12.30', 150, 61, '25000.00', NULL),
(157, 'Volkswagen', 'Polo', 'Citadine', 5, '1.75', '4.05', '1.45', 'Essence', '1.00', 80, '95.00', 3, 'Manuelle', 'Traction', 180, '10.40', 0, 0, '20000.00', NULL),
(158, 'Volkswagen', 'ID.3', 'Citadine', 5, '1.81', '4.26', '1.55', 'Électrique', '150.00', 204, '310.00', 0, 'Automatique', 'Traction', 160, '7.90', 330, 150, '28000.00', NULL),
(159, 'Volkswagen', 'Golf', 'Compacte', 5, '1.79', '4.28', '1.47', 'Hybride', '1.40', 204, '250.00', 4, 'Automatique', 'Traction', 210, '7.40', 50, 13, '25000.00', NULL),
(160, 'Volkswagen', 'T-Roc', 'SUV', 5, '1.82', '4.23', '1.57', 'Essence', '1.00', 110, '200.00', 3, 'Manuelle', 'Traction', 180, '10.10', 0, 0, '22000.00', NULL),
(161, 'Volkswagen', 'ID.5', 'SUV', 5, '1.85', '4.38', '1.63', 'Électrique', '220.00', 300, '460.00', 0, 'Automatique', 'Traction', 160, '6.20', 420, 220, '30000.00', NULL),
(162, 'Volvo', 'C40 Electrique', 'SUV', 5, '1.89', '4.43', '1.58', 'Électrique', '78.00', 300, '460.00', 0, 'Automatique', 'Traction', 150, '7.00', 380, 78, '45000.00', NULL),
(163, 'Volvo', 'XC90 Electrique', 'SUV', 7, '1.98', '4.95', '1.77', 'Électrique', '340.00', 250, '480.00', 0, 'Automatique', 'Traction', 180, '6.10', 400, 340, '60000.00', NULL),
(164, 'Volvo', 'XC90 Hybrid', 'SUV', 7, '1.98', '4.95', '1.77', 'Hybride', '2.00', 303, '400.00', 4, 'Automatique', 'Traction', 180, '5.80', 30, 10, '55000.00', NULL),
(165, 'Volvo', 'XC60 Hybrid', 'SUV', 5, '1.89', '4.69', '1.66', 'Hybride', '2.00', 303, '400.00', 4, 'Automatique', 'Traction', 180, '5.90', 30, 10, '48000.00', NULL),
(166, 'Volvo', 'V60 Hybrid', 'Break', 5, '1.87', '4.76', '1.47', 'Hybride', '2.00', 303, '400.00', 4, 'Automatique', 'Traction', 180, '5.90', 30, 10, '45000.00', NULL),
(167, 'Volvo', 'S60 Hybrid', 'Berline', 5, '1.86', '4.76', '1.44', 'Hybride', '2.00', 303, '400.00', 4, 'Automatique', 'Traction', 180, '5.90', 30, 10, '46000.00', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
