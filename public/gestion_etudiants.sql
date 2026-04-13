-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 13 avr. 2026 à 03:14
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_etudiants`
--

-- --------------------------------------------------------

--
-- Structure de la table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `nom_classe` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `classes`
--

INSERT INTO `classes` (`id`, `nom_classe`) VALUES
(1, 'Licence 1'),
(2, 'Licence 2'),
(3, 'Licence 3');

-- --------------------------------------------------------

--
-- Structure de la table `etudiants`
--

CREATE TABLE `etudiants` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `classe_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `etudiants`
--

INSERT INTO `etudiants` (`id`, `nom`, `prenom`, `email`, `classe_id`, `user_id`) VALUES
(2, 'Sylla', 'Mouhamed', 'syll@gmail.com', 3, NULL),
(3, 'oumy', 'sene', 'oumy@gmail.com', 2, NULL),
(4, NULL, NULL, NULL, NULL, NULL),
(6, 'root', '-', 'root@mail.com', 1, 4),
(7, 'root', '-', 'root@mail.com', 1, 5),
(8, 'root', '-', 'root@mail.com', 1, 6),
(9, 'root', '-', 'root@mail.com', 1, 7),
(10, 'root', '-', 'root@mail.com', 1, 8),
(11, 'root', '-', 'root@mail.com', 1, 9),
(12, 'root', '-', 'root@mail.com', 1, 10),
(13, 'root', '-', 'root@mail.com', 1, 11),
(14, 'root', '-', 'root@mail.com', 1, 12),
(15, 'root', '-', 'root@mail.com', 1, 13);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(20) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 'admin'),
(2, 'etudiant', '3c0d8d9b8a1bdd4eca72ef03f6151254', 'user'),
(3, 'etudiant1', 'd4d53bb8b5655771d66636d1b2c5f637', 'user'),
(4, 'root', 'd41d8cd98f00b204e9800998ecf8427e', 'user'),
(5, 'root', 'd41d8cd98f00b204e9800998ecf8427e', 'user'),
(6, 'root', 'd41d8cd98f00b204e9800998ecf8427e', 'user'),
(7, 'root', 'd41d8cd98f00b204e9800998ecf8427e', 'user'),
(8, 'root', 'd41d8cd98f00b204e9800998ecf8427e', 'user'),
(9, 'root', 'd41d8cd98f00b204e9800998ecf8427e', 'user'),
(10, 'root', 'd41d8cd98f00b204e9800998ecf8427e', 'user'),
(11, 'root', 'd41d8cd98f00b204e9800998ecf8427e', 'user'),
(12, 'root', 'd41d8cd98f00b204e9800998ecf8427e', 'user'),
(13, 'root', 'd41d8cd98f00b204e9800998ecf8427e', 'user');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `etudiants`
--
ALTER TABLE `etudiants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `classe_id` (`classe_id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `etudiants`
--
ALTER TABLE `etudiants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `etudiants`
--
ALTER TABLE `etudiants`
  ADD CONSTRAINT `etudiants_ibfk_1` FOREIGN KEY (`classe_id`) REFERENCES `classes` (`id`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `utilisateurs` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
