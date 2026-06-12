-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2026 at 04:49 PM
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
-- Database: `sabaya`
--

-- --------------------------------------------------------

--
-- Table structure for table `adresse`
--

CREATE TABLE `adresse` (
  `id_adresse` int(11) NOT NULL,
  `ville` varchar(100) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `code_postal` varchar(20) NOT NULL,
  `id_client` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adresse`
--

INSERT INTO `adresse` (`id_adresse`, `ville`, `adresse`, `code_postal`, `id_client`) VALUES
(1, 'New York', 'Street 16', '10080', 2),
(2, 'New York', 'Street 16', '10080', 2),
(3, '90001', 'stree145', 'tanger', 2),
(4, '90001', 'stree145', 'tanger', 2),
(5, '90001', 'stree145', 'tanger', 2),
(6, 'New York', 'Street 16', '10080', 2),
(7, '90001', 'stree145', 'tanger', 2),
(8, 'tanja', 'street 123', '90001', 2),
(16, 'saaaaaaaaaa', 'street 123', '90001', 2);

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE `categorie` (
  `id_categorie` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`id_categorie`, `nom`, `image`) VALUES
(1, 'Abayas Casual', '1780882540_boutique_byines_3496270921519915979.png'),
(2, 'Abayas Soirée', NULL),
(3, 'Abayas Cérémonie', NULL),
(4, 'Ensembles', NULL),
(5, 'Khimar et Accessoires', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `id_client` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','client') DEFAULT 'client'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id_client`, `nom`, `prenom`, `email`, `telephone`, `password`, `role`) VALUES
(1, 'Admin', 'Sabaya', 'admin@sabaya.com', '0600000000', '$2y$12$9Dw2pDjb/boHlRrGAjx1OeFhJp.6k2DNkTdItjytgo8SddhPMCgYO', 'admin'),
(2, 'KHIMAE', 'ESSS', 'admin@sabayaA.com', '0613623407', '$2y$10$8qgEWPWQBt6n/O8L14fcU.1ebA3Yue2FKd2E9NBzLoKqRSpSRkYUy', 'client');

-- --------------------------------------------------------

--
-- Table structure for table `commande`
--

CREATE TABLE `commande` (
  `id_commande` int(11) NOT NULL,
  `datecmd` datetime DEFAULT current_timestamp(),
  `statuscmd` varchar(50) DEFAULT 'En attente',
  `id_client` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `commande`
--

INSERT INTO `commande` (`id_commande`, `datecmd`, `statuscmd`, `id_client`, `total`) VALUES
(1, '2026-06-05 15:29:30', 'En attente', 2, 200.00),
(2, '2026-06-05 15:55:23', 'Confirmée', 2, 400.00),
(3, '2026-06-05 22:20:27', 'En attente', 2, 200.00),
(4, '2026-06-06 00:41:35', 'En attente', 2, 200.00),
(5, '2026-06-06 00:52:46', 'En attente', 2, 200.00),
(6, '2026-06-06 00:59:55', 'En attente', 2, 200.00),
(7, '2026-06-06 03:06:06', 'En attente', 2, 600.00),
(8, '2026-06-08 09:59:49', 'En attente', 2, 200.00),
(9, '2026-06-11 13:14:38', 'En attente', 2, 799.00);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id_contact` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `sujet` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date_message` datetime DEFAULT current_timestamp(),
  `id_client` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id_contact`, `nom`, `email`, `sujet`, `message`, `date_message`, `id_client`) VALUES
(1, 'KHIMAE', 'mesbahimohammed671@gmail.com', 'conatc', 'thank u for ur service', '2026-06-11 09:33:13', 2);

-- --------------------------------------------------------

--
-- Table structure for table `ligne_commande`
--

CREATE TABLE `ligne_commande` (
  `id_ligne` int(11) NOT NULL,
  `qte` int(11) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `id_commande` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ligne_commande`
--

INSERT INTO `ligne_commande` (`id_ligne`, `qte`, `prix`, `id_commande`, `id_produit`) VALUES
(1, 1, 200.00, 1, 1),
(2, 2, 200.00, 2, 1),
(3, 1, 200.00, 3, 1),
(4, 1, 200.00, 4, 1),
(5, 1, 200.00, 5, 1),
(6, 1, 200.00, 6, 1),
(7, 3, 200.00, 7, 1),
(8, 1, 200.00, 8, 1),
(9, 1, 799.00, 9, 12);

-- --------------------------------------------------------

--
-- Table structure for table `produits`
--

CREATE TABLE `produits` (
  `id_produit` int(11) NOT NULL,
  `nom` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `taille` varchar(50) DEFAULT NULL,
  `couleur` varchar(50) DEFAULT NULL,
  `id_categorie` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produits`
--

INSERT INTO `produits` (`id_produit`, `nom`, `description`, `prix`, `stock`, `image`, `taille`, `couleur`, `id_categorie`) VALUES
(1, 'Abayas Caasual', 'abay', 200.00, 20, '1780694493_boutique_byines_3314221782547857149.png', 'XS', 'BLACK', 1),
(4, 'Abaya Satin Luxe', 'Abaya en satin doux offrant confort et élégance.', 950.00, 10, '1781093233_ChatGPT Image Jun 10, 2026, 01_06_36 PM.png', 'XS,XLL,S', 'Noir', 3),
(5, 'Abaya Emerald', 'Abaya noir inspirée des tendances modernes du luxe.', 899.00, 8, '1781092256_ChatGPT Image Jun 10, 2026, 12_49_38 PM.png', 'XS,XLL,S', 'Noir', 2),
(6, 'Abaya Prestige Gold', 'abaya Prestige avec détails dorés haut de gamme.', 1499.00, 5, '1781091936_ChatGPT Image Jun 10, 2026, 12_42_59 PM.png', 'XS,XLL', 'jaune', 2),
(7, 'Abaya Prestige Noir', 'Kaftan noir élégant pour cérémonies et événements.', 1399.00, 6, '1780913080_1780912821_boutique_byines_3844045370372665866.png', 'XS', 'Noir', 2),
(10, 'Robe Modeste Beige', 'Robe longue élégante alliant confort et modernité.', 699.00, 18, '1780912894_boutique_byines_3469503560297868880.png', 'XS', 'Beige', 3),
(11, 'Robe Satin Rose', 'Robe satinée avec finition premium.', 749.00, 14, '1780912848_boutique_byines_3314221782548072851.png', 'XLL', 'Rose', 3),
(12, 'Robe Prestige Noir', 'Robe noire intemporelle adaptée aux événements.', 799.00, 10, '1780912821_boutique_byines_3844045370372665866.png', 'xl', 'noir', 3),
(13, 'Robe Élégance Verte', 'Robe verte moderne inspirée du luxe contemporain.', 850.00, 9, '1780912796_boutique_byines_3864956182159171861.png', 'XLL,XS', 'Verte', 3);

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id_wishlist` int(11) NOT NULL,
  `date_ajout` datetime DEFAULT current_timestamp(),
  `id_client` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id_wishlist`, `date_ajout`, `id_client`, `id_produit`) VALUES
(3, '2026-06-08 01:07:21', 1, 1),
(4, '2026-06-11 13:00:45', 2, 12),
(5, '2026-06-11 14:44:42', 2, 13);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adresse`
--
ALTER TABLE `adresse`
  ADD PRIMARY KEY (`id_adresse`),
  ADD KEY `fk_adresse_client` (`id_client`);

--
-- Indexes for table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id_client`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id_commande`),
  ADD KEY `fk_commande_client` (`id_client`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id_contact`),
  ADD KEY `fk_contact_client` (`id_client`);

--
-- Indexes for table `ligne_commande`
--
ALTER TABLE `ligne_commande`
  ADD PRIMARY KEY (`id_ligne`),
  ADD KEY `fk_ligne_commande` (`id_commande`),
  ADD KEY `fk_ligne_produit` (`id_produit`);

--
-- Indexes for table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id_produit`),
  ADD KEY `fk_produit_categorie` (`id_categorie`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id_wishlist`),
  ADD KEY `fk_wishlist_client` (`id_client`),
  ADD KEY `fk_wishlist_produit` (`id_produit`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adresse`
--
ALTER TABLE `adresse`
  MODIFY `id_adresse` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id_categorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `id_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `commande`
--
ALTER TABLE `commande`
  MODIFY `id_commande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id_contact` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ligne_commande`
--
ALTER TABLE `ligne_commande`
  MODIFY `id_ligne` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `produits`
--
ALTER TABLE `produits`
  MODIFY `id_produit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id_wishlist` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adresse`
--
ALTER TABLE `adresse`
  ADD CONSTRAINT `fk_adresse_client` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `fk_commande_client` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `fk_contact_client` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `ligne_commande`
--
ALTER TABLE `ligne_commande`
  ADD CONSTRAINT `fk_ligne_commande` FOREIGN KEY (`id_commande`) REFERENCES `commande` (`id_commande`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ligne_produit` FOREIGN KEY (`id_produit`) REFERENCES `produits` (`id_produit`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `produits`
--
ALTER TABLE `produits`
  ADD CONSTRAINT `fk_produit_categorie` FOREIGN KEY (`id_categorie`) REFERENCES `categorie` (`id_categorie`) ON UPDATE CASCADE;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `fk_wishlist_client` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_wishlist_produit` FOREIGN KEY (`id_produit`) REFERENCES `produits` (`id_produit`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
