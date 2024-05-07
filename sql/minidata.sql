-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3308
-- Généré le : mar. 07 mai 2024 à 15:41
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

--
-- Déchargement des données de la table `2025_attachments`
--

INSERT INTO `2025_attachments` (`id`, `pdf_link`, `article_link`, `video_link`) VALUES
(1, 'https://inria.hal.science/inria-00000987/file/AntDevMon06CPE.pdf', 'https://onlinelibrary.wiley.com/doi/abs/10.1002/cpe.1024', NULL),
(2, 'https://pages.lip6.fr/Olivier.Marin/Publis/nossdav14.pdf', 'https://dl.acm.org/doi/abs/10.1145/2578260.2578265', NULL),
(3, 'https://dl.acm.org/doi/pdf/10.1145/3659944', 'https://dl.acm.org/doi/abs/10.1145/3659944', NULL);

--
-- Déchargement des données de la table `2025_authors`
--

INSERT INTO `2025_authors` (`id`, `lastname`, `firstname`, `email`, `phone_number`, `job`, `description`, `update_date`) VALUES
(1, 'Monnet', 'Sébastien', 'sebastien.monnet@univ-smb.fr', NULL, NULL, NULL, '2024-05-07'),
(2, 'Alloui', 'Ilham', NULL, NULL, NULL, NULL, '2024-05-07'),
(3, 'Vernier', 'Flavien', NULL, NULL, NULL, NULL, '2024-05-07'),
(4, 'Salamatian', 'Kavé', NULL, NULL, NULL, NULL, '2024-05-07'),
(5, 'Valet', 'Lionel', NULL, NULL, NULL, NULL, '2024-05-07'),
(6, 'Véron', 'Maxime', NULL, NULL, NULL, NULL, '2024-05-07'),
(7, 'de Souza Batista', 'Agnaldo', NULL, NULL, NULL, NULL, '2024-05-07');

--
-- Déchargement des données de la table `2025_editors`
--

INSERT INTO `2025_editors` (`id`, `name`) VALUES
(1, 'John Wiley & Sons, Ltd.'),
(2, 'ACM');

--
-- Déchargement des données de la table `2025_publications`
--

INSERT INTO `2025_publications` (`id`, `title`, `description`, `type`, `publication_date`, `update_date`, `title_type`, `pages`, `id_attachment`, `id_editor`) VALUES
(1, 'How to bring together fault tolerance and data consistency to enable grid data sharing', 'This paper addresses the challenge of transparent data sharing within computing Grids built as cluster federations. On such platforms, the availability of storage resources may change in a dynamic way, often due to hardware failures. We focus on the problem of handling the consistency of replicated data in the presence of failures. We propose a software architecture which decouples consistency management from fault tolerance management. We illustrate this architecture with a case study showing how to design a consistency protocol using fault‐tolerant building blocks. As a proof of concept, we describe a prototype implementation of this protocol within JUXMEM, a software experimental platform for Grid data sharing, and we report on a preliminary experimental evaluation of the proposed approach. Copyright © 2006 John Wiley & Sons, Ltd.', 'Revue', '2006-11-01', '2024-05-07', 'Concurrency and Computation: Practice and Experience', '1705-1723', 1, 1),
(2, 'Matchmaking in multi-player on-line games: studying user traces to improve the user experience', 'Designing and implementing a quality matchmaking service for Multiplayer Online Games requires an extensive knowledge of the habits, behaviors and expectations of the players. Gathering and analyzing traces of real games offers insight on these matters, but game server providers are very protective of such data in order to deter possible reuse by the competition and to prevent cheating. We circumvented this issue by gathering public data from a League of Legends server (information over more than 28 million game sessions). In this paper, we present our database which is freely available online, and we detail the analysis and conclusions we draw from this data regarding the expected requirements for the matchmaking service.', 'Livre', '2014-03-19', '2024-05-07', 'Proceedings of Network and Operating System Support on Digital Audio and Video Workshop', '7-12', 2, NULL),
(3, 'A Survey on Resilience in Information Sharing on Networks: Taxonomy and Applied Techniques', 'Information sharing is vital in any communication network environment to enable network operating services take decisions based on the information collected by several deployed computing devices. The various networks that compose cyberspace, as Internet-of-Things (IoT) ecosystems, have significantly increased the need to constantly share information, which is often subject to disturbances. In this sense, the damage of anomalous operations boosted researches aimed at improving resilience to information sharing. Hence, in this survey, we present a systematization of knowledge about scientific efforts for achieving resilience to information sharing on networks. First, we introduce a taxonomy to organize the strategies applied to attain resilience to information sharing on networks, offering brief concepts about network anomalies and connectivity services. Then, we detail the taxonomy in the face of malicious …', 'Source', '2024-01-01', '2024-05-07', 'ACM Computing Surveys', NULL, 3, 2);

--
-- Déchargement des données de la table `2025_publish`
--

INSERT INTO `2025_publish` (`id_author`, `id_publication`) VALUES
(1, 1),
(1, 2),
(6, 2),
(7, 3);

--
-- Déchargement des données de la table `2025_quotes`
--

INSERT INTO `2025_quotes` (`id_publication`, `id_quote`) VALUES
(1, 3);

--
-- Déchargement des données de la table `2025_users`
--

INSERT INTO `2025_users` (`id`, `lastname`, `firstname`, `email`, `phone_number`, `password`, `registration_date`, `description`, `update_date`, `id_author`) VALUES
(1, 'Iddouch', 'Ikram', 'Ikram@gmail.com', NULL, 'Ikram', '2024-05-07', NULL, '2024-05-07', NULL),
(2, 'Monnet', 'Sébastien', 'sebastien.monnet@univ-smb.fr', NULL, '123456', '2024-05-07', NULL, '2024-05-07', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
