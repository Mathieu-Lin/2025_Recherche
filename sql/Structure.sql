-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3308
-- Généré le : lun. 20 mai 2024 à 11:05
-- Version du serveur :  5.7.33
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `linm`
--

-- --------------------------------------------------------

--
-- Structure de la table `2025_attachments`
--

CREATE TABLE `2025_attachments` (
  `id` int(11) NOT NULL,
  `pdf_link` text,
  `article_link` text,
  `video_link` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `2025_authors`
--

CREATE TABLE `2025_authors` (
  `id` int(11) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `phone_number` varchar(100) DEFAULT NULL,
  `job` varchar(100) DEFAULT NULL,
  `description` text,
  `update_date` date NOT NULL,
  `profile_picture` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `2025_editors`
--

CREATE TABLE `2025_editors` (
  `id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `2025_links`
--

CREATE TABLE `2025_links` (
  `id_publication` int(11) NOT NULL,
  `id_attachment` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `2025_publications`
--

CREATE TABLE `2025_publications` (
  `id` int(11) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `description` text,
  `type` varchar(50) DEFAULT NULL,
  `publication_date` date NOT NULL,
  `update_date` date NOT NULL,
  `title_type` varchar(200) DEFAULT NULL,
  `pages` varchar(50) DEFAULT NULL,
  `id_editor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `2025_publish`
--

CREATE TABLE `2025_publish` (
  `id_author` int(11) NOT NULL,
  `id_publication` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `2025_quotes`
--

CREATE TABLE `2025_quotes` (
  `id_publication` int(11) NOT NULL,
  `id_quote` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `2025_users`
--

CREATE TABLE `2025_users` (
  `id` int(11) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone_number` varchar(100) DEFAULT NULL,
  `password` text NOT NULL,
  `registration_date` date NOT NULL,
  `description` text,
  `update_date` date NOT NULL,
  `id_author` int(11) DEFAULT NULL,
  `profile_picture` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `2025_editors`
--
ALTER TABLE `2025_editors`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `2025_links`
--
ALTER TABLE `2025_links`
  ADD PRIMARY KEY (`id_publication`,`id_attachment`),
  ADD KEY `fk_attachment_link` (`id_attachment`);

--
-- Index pour la table `2025_publications`
--
ALTER TABLE `2025_publications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_publication_editor` (`id_editor`);

--
-- Index pour la table `2025_publish`
--
ALTER TABLE `2025_publish`
  ADD PRIMARY KEY (`id_author`,`id_publication`) USING BTREE,
  ADD KEY `fk_publication_publish` (`id_publication`);

--
-- Index pour la table `2025_quotes`
--
ALTER TABLE `2025_quotes`
  ADD PRIMARY KEY (`id_publication`,`id_quote`),
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
-- Contraintes pour la table `2025_links`
--
ALTER TABLE `2025_links`
  ADD CONSTRAINT `fk_attachment_link` FOREIGN KEY (`id_attachment`) REFERENCES `2025_attachments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_publication_link` FOREIGN KEY (`id_publication`) REFERENCES `2025_publications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `2025_publications`
--
ALTER TABLE `2025_publications`
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
