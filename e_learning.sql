-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2025 at 08:28 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e_learning`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `id_blog` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `auteur` varchar(100) NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) DEFAULT NULL,
  `contenu` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`id_blog`, `id_user`, `titre`, `auteur`, `date_creation`, `image`, `contenu`) VALUES
(43, 7, 'marketingggg', 'imen', '2025-05-09 00:00:00', '', 'testing marketing imentesting marketing imentesting marketing imentesting marketing imentesting marketing imen'),
(44, 0, 'finance in tunisia', 'imen setiii ', '2025-05-07 00:00:00', 'blog.jpeg', 'dvdflvbdnfvnvndfbvdfbvlwjdhfbvjlhwdfvjwhdfbvdvdflvbdnfvnvndfbvdfbvlwjdhfbvjlhwdfvjwhdfbvdvdflvbdnfvnvndfbvdfbvlwjdhfbvjlhwdfvjwhdfbvdvdflvbdnfvnvndfbvdfbvlwjdhfbvjlhwdfvjwhdfbvdvdflvbdnfvnvndfbvdfbvlwjdhfbvjlhwdfvjwhdfbvdvdflvbdnfvnvndfbvdfbvlwjdhfbvjlhwdfvjwhdfbvdvdflvbdnfvnvndfbvdfbvlwjdhfbvjlhwdfvjwhdfbvdvdflvbdnfvnvndfbvdfbvlwjdhfbvjlhwdfvjwhdfbvdvdflvbdnfvnvndfbvdfbvlwjdhfbvjlhwdfvjwhdfbv'),
(45, 19, 'finance', 'imen setiii', '2025-05-08 00:00:00', 'blog_681ce2d98d8de8.16922268.jpeg', 'zesrdtfghbjnk,lzesrdtfghbjnk,lzesrdtfghbjnk,lzesrdtfghbjnk,lzesrdtfghbjnk,lzesrdtfghbjnk,lzesrdtfghbjnk,lzesrdtfghbjnk,lzesrdtfghbjnk,l'),
(47, 0, 'cccccccccccccc', 'imen setiii ', '2025-05-08 19:02:12', NULL, 'lovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelovelove'),
(48, 19, 'hchjsbdfvgdgvf', 'wdfbjwedhfbvjqehfgvb', '2025-05-08 00:00:00', 'blog_681cf66ee61b99.37932556.jpeg', 'qzdsgvq<zdgvcqzygd<vcdzgcevqezfgdcvuefdvcdtfaervdcatfervfvdcferva');

-- --------------------------------------------------------

--
-- Table structure for table `commentaire`
--

CREATE TABLE `commentaire` (
  `id_commentaire` int(11) NOT NULL,
  `id_blog` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `contenu` text DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `commentaire`
--

INSERT INTO `commentaire` (`id_commentaire`, `id_blog`, `id_user`, `contenu`, `date_creation`) VALUES
(23, 30, 2, 'jhjhjhjhjhjhjhjhjg', '2025-04-24 00:00:00'),
(24, 33, 2, 'aaaa', '2025-04-18 00:00:00'),
(25, 37, 1, 'aaaa', '2025-04-10 00:00:00'),
(26, 36, 3, 'aaaaaaa', '2025-04-03 00:00:00'),
(28, 33, 1, 'impolie', '2025-04-26 00:00:00'),
(29, 33, 1, 'fhfgfg', '2025-04-26 00:00:00'),
(30, 33, 1, 'bad', '2025-04-26 00:00:00'),
(31, 36, 1, '*******', '2025-04-26 21:26:37'),
(32, 36, 1, '***', '2025-04-26 21:28:41'),
(36, 38, 1, 'hi', '2025-04-28 11:50:46'),
(37, 38, 1, 'imen seti2a20', '2025-04-28 11:51:08'),
(39, 33, 1, 'bienn', '2025-04-28 00:00:00'),
(40, 37, 1, 'bonjour ', '2025-04-28 16:06:19'),
(42, 36, 1, 'fgh', '2025-04-30 13:25:13'),
(43, 36, 1, 'hi', '2025-04-30 13:25:25'),
(44, 36, 1, 'test', '2025-04-30 13:32:17'),
(45, 35, 1, 'fghj', '2025-04-30 13:33:22'),
(47, 35, 1, 'fghj', '2025-04-30 13:35:28'),
(48, 35, 1, 'hello', '2025-04-30 13:35:55'),
(49, 38, 1, 'hi', '2025-04-30 13:36:04'),
(50, 35, 1, 'hiii', '2025-04-30 13:36:12'),
(51, 33, 1, 'dfghj,k;', '2025-04-30 13:36:22'),
(52, 38, 1, 'hhhhhhhhhhhhhhhhhh', '2025-04-30 13:37:03'),
(53, 33, 1, 'gyvvvvvvvvvvvv', '2025-04-30 13:39:48'),
(54, 37, 1, 'fghjk', '2025-04-30 13:40:05'),
(57, 30, 1, '***', '2025-05-07 23:26:22'),
(58, 0, 0, 'test', '2025-05-08 02:16:49'),
(59, 39, 0, 'test', '2025-05-08 02:24:27'),
(60, 39, 0, 'test', '2025-05-08 02:25:35'),
(61, 39, 0, 'oiuytre', '2025-05-08 02:25:46'),
(62, 39, 0, 'dfsdf', '2025-05-08 02:29:18'),
(63, 39, 0, 'sqdsqd', '2025-05-08 02:33:55'),
(64, 39, 0, 'qsdqsd', '2025-05-08 02:35:10'),
(65, 39, 0, 'qsdsqd', '2025-05-08 02:37:24'),
(66, 39, 0, 'test', '2025-05-08 10:24:49'),
(67, 39, 0, 'aqws', '2025-05-08 10:25:22'),
(68, 35, 0, 'test', '2025-05-08 10:39:09'),
(69, 40, 0, 'kjhgfd', '2025-05-08 11:16:40'),
(70, 41, 0, 'kjnbvcx', '2025-05-08 11:16:51'),
(71, 42, 0, 'testingtesting', '2025-05-08 11:42:38'),
(72, 42, 0, 'testid', '2025-05-08 11:56:25'),
(73, 42, 0, 'kjhgf', '2025-05-08 11:57:48'),
(74, 42, 0, 'azezae', '2025-05-08 11:58:52'),
(75, 42, 0, 'hfdgd', '2025-05-08 12:00:31'),
(76, 42, 7, 'hfdgdghgh', '2025-05-08 12:03:25'),
(77, 42, 7, 'test', '2025-05-08 12:19:30'),
(78, 42, 7, 'kjhgj', '2025-05-08 12:20:11'),
(79, 42, 7, 'tgdfg', '2025-05-08 12:20:49'),
(80, 42, 7, 'kjhg', '2025-05-08 12:20:58'),
(81, 42, 7, 'rdgdfhg', '2025-05-08 12:21:27'),
(82, 44, 19, 'zsz', '2025-05-08 18:03:36'),
(83, 43, 19, '***', '2025-05-08 18:04:19'),
(84, 43, 19, '***', '2025-05-08 18:15:58'),
(85, 43, 19, 'hello world', '2025-05-08 18:16:07'),
(86, 43, 19, 'hzejhqzdfjcghq', '2025-05-08 18:16:25'),
(87, 47, 19, 'gegefefvvch vjsghdc', '2025-05-08 18:16:33'),
(88, 43, 19, 'lo', '2025-05-08 18:16:44'),
(90, 43, 19, 'ghghghghhgh', '2025-05-08 19:20:13');

-- --------------------------------------------------------

--
-- Table structure for table `evenement`
--

CREATE TABLE `evenement` (
  `idevenement` int(11) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `categorie` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `lieu` varchar(100) NOT NULL,
  `idorganisateur` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `nbplace` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `evenement`
--

INSERT INTO `evenement` (`idevenement`, `titre`, `description`, `categorie`, `date`, `lieu`, `idorganisateur`, `image`, `nbplace`) VALUES
(10, 'Tendances Tech', 'Découvrez les technologies émergentes qui vont transformer les entreprises en 2025 : intelligence ar', 'Webinaire', '2025-12-12', 'sousse palace', 1, NULL, 7),
(16, 'Comment réussir votre transformation digitale', 'Participez à ce webinaire pour découvrir les étapes clés d’une transformation numérique réussie : st', 'Webinaire', '2025-06-01', 'Esprit', 3, NULL, 49),
(17, 'Le futur du travail ', 'Exploration des nouvelles dynamiques du travail hybride, des outils collaboratifs et de la culture d', 'Conférence', '2025-07-04', 'Hammamet', 13, NULL, 18),
(18, 'Maîtriser Git et GitHub pour la collaboration', 'Un atelier intensif pour apprendre à utiliser Git et GitHub dans vos projets de développement logici', 'Séminaire', '2025-12-12', 'Esprit', 18, NULL, 40),
(19, 'Rencontre Startups et Investisseurs', 'Une soirée dédiée aux jeunes pousses et aux investisseurs à la recherche de projets innovants. Pitch', 'Networking', '2025-10-10', 'Tunis', 2, NULL, 50),
(20, ' Créez votre site web en trois heures', 'Un atelier pratique pour apprendre à créer un site web professionnel avec des outils no-code comme W', 'Atelier', '2025-11-01', 'Tunis', 4, NULL, 30);

-- --------------------------------------------------------

--
-- Table structure for table `facture`
--

CREATE TABLE `facture` (
  `id` int(11) NOT NULL,
  `numero_facture` varchar(100) NOT NULL,
  `date_facture` date NOT NULL,
  `montant_total` decimal(10,2) NOT NULL,
  `statut` varchar(50) NOT NULL,
  `client_nom` varchar(100) DEFAULT NULL,
  `paiement_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facture`
--

INSERT INTO `facture` (`id`, `numero_facture`, `date_facture`, `montant_total`, `statut`, `client_nom`, `paiement_id`) VALUES
(5, '55', '2025-04-05', 500.00, 'traité', 'ahmed ', 2);

-- --------------------------------------------------------

--
-- Table structure for table `paiement`
--

CREATE TABLE `paiement` (
  `id` int(11) NOT NULL,
  `montant` varchar(50) NOT NULL,
  `devise` varchar(50) NOT NULL,
  `methode` varchar(50) NOT NULL,
  `carte` varchar(50) NOT NULL,
  `description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `paiement`
--

INSERT INTO `paiement` (`id`, `montant`, `devise`, `methode`, `carte`, `description`) VALUES
(2, '9563000', 'EUR', 'Carte Bancaire', '00000', 'a'),
(8, '855', 'TND', 'Carte Bancaire', '444444444444444444', 'uu'),
(13, '200', 'TND', 'Carte Bancaire', '000111111111111', 'jtkjgjkg'),
(14, '200', 'TND', 'Carte Bancaire', '000111111111111', 'ggh'),
(15, '200', 'TND', 'Cash', '000111111111122', 'bdhdb'),
(16, '200', 'TND', 'Cash', '0000000000000000000000000000000000000000000000000', 'bdhdb8888'),
(17, '200', 'TND', 'Cash', '0000', 'bdhdb8888'),
(18, '200', 'TND', 'Cash', 'bb', 'hjj');

-- --------------------------------------------------------

--
-- Table structure for table `reclamation`
--

CREATE TABLE `reclamation` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `sujet` varchar(50) NOT NULL,
  `descrip` varchar(50) NOT NULL,
  `daterec` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `reclamation`
--

INSERT INTO `reclamation` (`id`, `email`, `sujet`, `descrip`, `daterec`, `status`) VALUES
(8, 'daagiferiel92@gmail.com', 'hg', 'qsdq', '2025-03-19', 'FermÃ©e'),
(9, 'houssem.wesslati24@gmail.com', 'hgqsdqd', 'sqdqd', '2025-04-06', 'RÃ©solue'),
(10, 'daagiferiel92@gmail.com', 'kzdfjrek', 'testdesv', '2025-03-14', 'En cours'),
(11, 'daagiferiel92@gmail.com', 'd', 'sdqs', '2025-04-06', 'En cours');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `idr` int(11) NOT NULL,
  `client` varchar(100) NOT NULL,
  `idev` int(11) NOT NULL,
  `date` varchar(100) NOT NULL,
  `code_confirmation` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`idr`, `client`, `idev`, `date`, `code_confirmation`) VALUES
(35, 'hejer', 10, '2025-05-04', ''),
(36, 'hejer', 16, '2025-05-05', '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `numtel` varchar(100) NOT NULL,
  `sexe` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nom`, `prenom`, `email`, `password`, `numtel`, `sexe`, `role`) VALUES
(2, 'hejer', 'sodrati', 'sodratihejer14@gmail.com', '547896321', '+216 98564213', 'Femme', 'admin'),
(4, 'ahmed', 'hyu', 'ahmed@esprit.tn', '54789553325', '+216 53735747', 'Homme', 'client'),
(5, 'bayrem', 'bh', 'bayrem@esprit.tn', '547896321', '+216 98564213', 'Homme', 'organisateur'),
(7, 'sarra', 'sodrati', 'sodratisarra2@gmail.com', '547896321', '+216 98564213', 'Femme', 'client'),
(8, 'zieddd', 'zzzzzzzzzzz', 'zz@esprit.tn', '547896321', '+216 98564213', 'Homme', 'client'),
(10, 'art', 'art', 'art@esprit.tn', '547896321', '+216 98564213', 'Homme', 'enseignant'),
(11, 'samia', 'art', 'art2@esprit.tn', '547896321', '+216 98564213', 'Homme', 'enseignant'),
(19, 'setti', 'imen ', 'imen.setti@esprit.tn', '000000', '+216 58720769', 'Femme', 'Client');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id_blog`),
  ADD KEY `fkB` (`id_user`);

--
-- Indexes for table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`id_commentaire`),
  ADD KEY `commentaire_ibfk_1` (`id_blog`),
  ADD KEY `fk` (`id_user`);

--
-- Indexes for table `evenement`
--
ALTER TABLE `evenement`
  ADD PRIMARY KEY (`idevenement`);

--
-- Indexes for table `facture`
--
ALTER TABLE `facture`
  ADD PRIMARY KEY (`id`),
  ADD KEY `paiement_id` (`paiement_id`);

--
-- Indexes for table `paiement`
--
ALTER TABLE `paiement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reclamation`
--
ALTER TABLE `reclamation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`idr`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `id_blog` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `id_commentaire` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `evenement`
--
ALTER TABLE `evenement`
  MODIFY `idevenement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `facture`
--
ALTER TABLE `facture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `paiement`
--
ALTER TABLE `paiement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `reclamation`
--
ALTER TABLE `reclamation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `idr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `facture`
--
ALTER TABLE `facture`
  ADD CONSTRAINT `facture_ibfk_1` FOREIGN KEY (`paiement_id`) REFERENCES `paiement` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
