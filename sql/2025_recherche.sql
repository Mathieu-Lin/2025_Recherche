-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 07 mai 2024 à 11:00
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4
SET
  SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET
  time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;

/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;

/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;

/*!40101 SET NAMES utf8 */;

--
-- Base de données : `2025_recherche`
--
-- --------------------------------------------------------
--
-- Structure de la table `2025_attachments`
--
CREATE TABLE
  `2025_attachments` (
    `id` int(11) NOT NULL,
    `pdf_link` varchar(200) DEFAULT NULL,
    `article_link` varchar(200) DEFAULT NULL,
    `video_link` varchar(200) DEFAULT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- --------------------------------------------------------
--
-- Structure de la table `2025_authors`
--
CREATE TABLE
  `2025_authors` (
    `id` int(11) NOT NULL,
    `lastname` varchar(50) NOT NULL,
    `firstname` varchar(50) NOT NULL,
    `email` varchar(100) NOT NULL,
    `phone_number` varchar(50) DEFAULT NULL,
    `job` varchar(50) DEFAULT NULL,
    `description` text DEFAULT NULL,
    `update_date` date NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- --------------------------------------------------------
--
-- Structure de la table `2025_editors`
--
CREATE TABLE
  `2025_editors` (
    `id` int(11) NOT NULL,
    `name` varchar(100) DEFAULT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- --------------------------------------------------------
--
-- Structure de la table `2025_publications`
--
CREATE TABLE
  `2025_publications` (
    `id` int(11) NOT NULL,
    `title` varchar(50) DEFAULT NULL,
    `description` text DEFAULT NULL,
    `type` varchar(50) NOT NULL,
    `publication_date` date NOT NULL,
    `update_date` date NOT NULL,
    `title_type` varchar(50) DEFAULT NULL,
    `pages` varchar(50) DEFAULT NULL,
    `id_attachment` int(11) DEFAULT NULL,
    `id_editor` int(11) DEFAULT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- --------------------------------------------------------
--
-- Structure de la table `2025_publish`
--
CREATE TABLE
  `2025_publish` (
    `id_author` int(11) NOT NULL,
    `id_publication` int(11) NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- --------------------------------------------------------
--
-- Structure de la table `2025_quotes`
--
CREATE TABLE
  `2025_quotes` (
    `id_publication` int(11) NOT NULL,
    `id_quote` int(11) NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- --------------------------------------------------------
--
-- Structure de la table `2025_users`
--
CREATE TABLE
  `2025_users` (
    `id` int(11) NOT NULL,
    `lastname` varchar(50) NOT NULL,
    `firstname` varchar(50) NOT NULL,
    `email` varchar(100) NOT NULL,
    `phone_number` varchar(50) DEFAULT NULL,
    `password` varchar(252) NOT NULL,
    `registration_date` date NOT NULL,
    `description` text DEFAULT NULL,
    `update_date` date NOT NULL,
    `id_author` int(11) DEFAULT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--
--
-- Index pour la table `2025_attachments`
--
ALTER TABLE `2025_attachments`
ADD PRIMARY KEY (`id`);

--
-- Index pour la table `2025_authors`
--
ALTER TABLE `2025_authors`
ADD PRIMARY KEY (`id`),
ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `2025_editors`
--
ALTER TABLE `2025_editors`
ADD PRIMARY KEY (`id`);

--
-- Index pour la table `2025_publications`
--
ALTER TABLE `2025_publications`
ADD PRIMARY KEY (`id`),
ADD KEY `fk_publication_attachment` (`id_attachment`),
ADD KEY `fk_publication_editor` (`id_editor`);

--
-- Index pour la table `2025_publish`
--
ALTER TABLE `2025_publish`
ADD PRIMARY KEY (`id_author`),
ADD KEY `fk_publication_publish` (`id_publication`);

--
-- Index pour la table `2025_quotes`
--
ALTER TABLE `2025_quotes`
ADD PRIMARY KEY (`id_publication`, `id_quote`),
ADD KEY `FK_publication_quote` (`id_quote`);

--
-- Index pour la table `2025_users`
--
ALTER TABLE `2025_users`
ADD PRIMARY KEY (`id`),
ADD UNIQUE KEY `email` (`email`),
ADD KEY `fk_user_author` (`id_author`);

--
-- AUTO_INCREMENT pour les tables déchargées
--
--
-- AUTO_INCREMENT pour la table `2025_attachments`
--
ALTER TABLE `2025_attachments`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `2025_authors`
--
ALTER TABLE `2025_authors`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `2025_editors`
--
ALTER TABLE `2025_editors`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `2025_publications`
--
ALTER TABLE `2025_publications`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `2025_users`
--
ALTER TABLE `2025_users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--
--
-- Contraintes pour la table `2025_publications`
--
ALTER TABLE `2025_publications`
ADD CONSTRAINT `fk_publication_attachment` FOREIGN KEY (`id_attachment`) REFERENCES `2025_attachments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_publication_editor` FOREIGN KEY (`id_editor`) REFERENCES `2025_editors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `2025_publish`
--
ALTER TABLE `2025_publish`
ADD CONSTRAINT `fk_author_publish` FOREIGN KEY (`id_author`) REFERENCES `2025_authors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_publication_publish` FOREIGN KEY (`id_publication`) REFERENCES `2025_publications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `2025_quotes`
--
ALTER TABLE `2025_quotes`
ADD CONSTRAINT `FK_publication_publication` FOREIGN KEY (`id_publication`) REFERENCES `2025_publications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `FK_publication_quote` FOREIGN KEY (`id_quote`) REFERENCES `2025_publications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `2025_users`
--
ALTER TABLE `2025_users`
ADD CONSTRAINT `fk_user_author` FOREIGN KEY (`id_author`) REFERENCES `2025_authors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;